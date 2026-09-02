<?php 

namespace spoova\mi\core\classes\Sensor\ProcessHandler;

use spoova\mi\core\classes\Sensor\ProcessHandler\ProcessHandler;

abstract class UnixProcessHandler extends ProcessHandler
{
    protected $lastError = null;

    /** Get processes via ps (pid,comm,rss). Returns array of ['pid','name','memory_kb','memory'] */
    public function getProcesses(?string $sortBy = null, string $order = 'desc'): array
    {
        // ask ps for user, pid, command, rss
        $cmd = 'ps -eo user,pid,comm,rss --no-headers';
        exec($cmd, $lines, $rc);
        if ($rc !== 0 || empty($lines)) {
            // fallback
            exec('ps -axo user,pid,comm,rss', $lines, $rc);
        }

        $out = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            // user could have spaces? generally no. split into 4 parts
            $parts = preg_split('/\s+/', $line, 4);
            if (count($parts) < 4) continue;
            [$user, $pid, $comm, $rssKb] = $parts;
            $out[] = [
                'user' => $user,
                'pid' => (int)$pid,
                'name' => basename($comm),
                'memory_kb' => (int)$rssKb,
                'memory' => ((int)$rssKb) . ' K'
            ];
        }

        // optional sorting kept as before (memory/name)
        if ($sortBy) {
            usort($out, function ($a, $b) use ($sortBy, $order) {
                if ($sortBy === 'name') {
                    $cmp = strcasecmp($a['name'], $b['name']);
                } else {
                    $cmp = $a['memory_kb'] <=> $b['memory_kb'];
                }
                return $order === 'desc' ? -$cmp : $cmp;
            });
        }

        return $out;
    }

    /**
     * Send a signal to a PID and optionally wait then return before/after snapshots.
     *
     * Returns:
     * [
     *   'ok' => bool,
     *   'pid' => int,
     *   'signal' => int,
     *   'before' => <proc or null>,
     *   'after' => <proc or null>,
     *   'error_code' => int|null,
     *   'error_message' => string|null
     * ]
     *
     * WARNING: Unlike Windows' EmptyWorkingSet, POSIX has no portable "trim the
     * working set of another process" primitive. This sends a signal (default
     * SIGUSR1) whose *default* disposition is to TERMINATE a process that does
     * not install a handler for it. Only use this against cooperating processes
     * that you know handle the chosen signal as a memory-release request.
     */
    public function trimMemoryByPID(int $pid, int $signal = SIGUSR1, int $waitMs = 200): array
    {
        $this->lastError = null;
        // Reject invalid, kernel (0) and init (1) PIDs — signalling them is unsafe.
        if ($pid <= 1) {
            $this->lastError = "Invalid or protected PID: {$pid}";
            return ['ok' => false, 'pid' => $pid, 'signal' => $signal, 'error_code' => -1, 'error_message' => $this->lastError];
        }

        // capture 'before' snapshot
        $beforeList = $this->getProcesses(null, 'desc');
        $before = null;
        foreach ($beforeList as $p) if ($p['pid'] === $pid) { $before = $p; break; }

        // existence & permission check
        $exists = null;
        if (function_exists('posix_kill')) {
            $exists = @posix_kill($pid, 0); // does not send a signal, just checks existence/permission
            if ($exists === false) {
                $this->lastError = "Cannot signal PID {$pid} (not found or permission denied).";
                return ['ok' => false, 'pid' => $pid, 'signal' => $signal, 'before' => $before, 'error_code' => -2, 'error_message' => $this->lastError];
            }
        } else {
            exec("kill -0 " . (int)$pid . " 2>/dev/null", $out, $rc);
            if ($rc !== 0) {
                $this->lastError = "Cannot signal PID {$pid} (not found or permission denied).";
                return ['ok' => false, 'pid' => $pid, 'signal' => $signal, 'before' => $before, 'error_code' => -2, 'error_message' => $this->lastError];
            }
        }

        // send signal
        if (function_exists('posix_kill')) {
            $sent = @posix_kill($pid, $signal);
            if ($sent === false) {
                $this->lastError = "posix_kill failed sending signal {$signal} to PID {$pid}.";
                return ['ok' => false, 'pid' => $pid, 'signal' => $signal, 'before' => $before, 'error_code' => -3, 'error_message' => $this->lastError];
            }
        } else {
            // fallback to shell kill by name
            $sigName = $this->signalToName($signal);
            $cmd = "kill -{$sigName} " . (int)$pid . " 2>&1";
            exec($cmd, $out, $rc);
            if ($rc !== 0) {
                $this->lastError = "shell kill failed: " . implode("\n", $out);
                return ['ok' => false, 'pid' => $pid, 'signal' => $signal, 'before' => $before, 'error_code' => -4, 'error_message' => $this->lastError];
            }
        }

        // optional wait for kernel/process bookkeeping
        if ($waitMs > 0) {
            usleep($waitMs * 1000);
        }

        // capture 'after' snapshot
        $afterList = $this->getProcesses(null, 'desc');
        $after = null;
        foreach ($afterList as $p) if ($p['pid'] === $pid) { $after = $p; break; }

        return [
            'ok' => true,
            'pid' => $pid,
            'signal' => $signal,
            'before' => $before,
            'after' => $after,
            'error_code' => 0,
            'error_message' => null
        ];
    }

    /** Trim all processes matching a name (case-insensitive). */
    public function trimMemoryByName(string $procName, int $signal = SIGUSR1, int $waitMs = 200): array
    {
        $list = $this->getProcesses(null, 'desc');
        $matching = array_filter($list, fn($p) => strcasecmp($p['name'], $procName) === 0);

        if (empty($matching)) {
            $this->lastError = "No processes found with name: {$procName}";
            return ['ok' => false, 'error_code' => -5, 'error_message' => $this->lastError, 'results' => []];
        }

        $results = [];
        foreach ($matching as $p) {
            $results[$p['pid']] = $this->trimMemoryByPID($p['pid'], $signal, $waitMs);
        }

        return ['ok' => true, 'results' => $results];
    }

    /** Convert numeric signal to kill name (for shell fallback) */
    protected function signalToName(int $signal): string
    {
        switch ($signal) {
            case SIGUSR1: return 'USR1';
            case SIGUSR2: return 'USR2';
            case SIGHUP:  return 'HUP';
            case SIGTERM: return 'TERM';
            case SIGINT:  return 'INT';
            case SIGKILL: return 'KILL';
            default: return (string)$signal;
        }
    }

    
    /**
     * Unified name: group processes returned by getProcesses()
     */
    public function getAppsGrouped(): array
    {
        $list = $this->getProcesses();
        $apps = [];

        foreach ($list as $p) {
            $name = $p['name'] ?? $p['comm'] ?? 'unknown';
            $key  = strtolower($name);
            if (!isset($apps[$key])) {
                $apps[$key] = [
                    'name' => $name,
                    'pids' => [],
                    'owners' => [],                // list of owners for quick checks
                    'total_memory_kb' => 0,
                    'total_memory_unit' => $p['memory'] ?? ($p['memory_kb'] . ' K')
                ];
            }
            $apps[$key]['pids'][] = (int)$p['pid'];
            $apps[$key]['owners'][] = $p['user'] ?? 'unknown';
            $apps[$key]['total_memory_kb'] += (int)$p['memory_kb'];
        }

        // Normalize owners (unique)
        foreach ($apps as &$g) {
            $g['owners'] = array_values(array_unique($g['owners']));
        }
        unset($g);

        return array_values($apps);
    }

    /**
     * Return apps that meet the high-memory criteria.
     *
     * @param int|null $minKb   minimum total memory in KB (null => no minimum)
     * @param int|null $top     top N results after filtering (null => no limit)
     * @param string $sortBy    'memory'|'name' (controls sort field)
     * @param string $order     'desc'|'asc'
     * @param bool $userApps  When true exclude apps owned solely by system (root)
     * @return array
     */
    public function getHighMemoryApps(?int $minKb = null, ?int $top = null, string $sortBy = 'memory', string $order = 'desc', bool $userApps = false): array
    {
        $apps = $this->getAppsGrouped();

        // If onlyUserApps requested: filter out groups whose owners array only contains root (or system users)
        if ($userApps) {
            $apps = array_filter($apps, function($g) {
                $owners = $g['owners'] ?? [];
                // If any owner is not root => keep. Otherwise drop.
                foreach ($owners as $o) {
                    if (strtolower($o) !== 'root') return true;
                }
                return false;
            });
        }

        // Apply minKb if provided
        if ($minKb !== null) {
            $apps = array_filter($apps, fn($a) => ($a['total_memory_kb'] ?? 0) >= $minKb);
        }

        // Sort
        usort($apps, function($a, $b) use ($sortBy, $order) {
            if ($sortBy === 'name') {
                $cmp = strcasecmp($a['name'], $b['name']);
            } else {
                $cmp = ($a['total_memory_kb'] ?? 0) <=> ($b['total_memory_kb'] ?? 0);
            }
            return $order === 'desc' ? -$cmp : $cmp;
        });

        if ($top !== null && $top > 0) {
            $apps = array_slice($apps, 0, $top);
        }

        // remove owners from public shape if you prefer; currently we keep it for diagnostics
        return array_values($apps);
    }

    public function getError(): ?array {
        return $this->lastError ? ['error' => $this->lastError] : null;
    }
}
