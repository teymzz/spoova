<?php 

namespace spoova\mi\core\classes\Sensor\ProcessHandler;

use Exception;
use FFI;
use spoova\mi\core\classes\Sensor\ProcessHandler\ProcessHandler;
use Throwable;

/**
 * WinProcessHandler
 * Windows-only process helper using FFI + tasklist parsing.
 *
 * PHP: requires "ffi" extension enabled and running on Windows.
 */
class WinProcessHandler extends ProcessHandler
{
    private $kernel32;
    private $psapi;
    private $kernel32_extra;
    private $lastError = null;

    // Constants (Win32)
    const FORMAT_MESSAGE_ALLOCATE_BUFFER = 0x00000100;
    const FORMAT_MESSAGE_FROM_SYSTEM     = 0x00001000;
    const FORMAT_MESSAGE_IGNORE_INSERTS  = 0x00000200;
    const PROCESS_SET_QUOTA              = 0x0100;
    const PROCESS_QUERY_INFORMATION      = 0x0400;

    public function __construct()
    {
        // Basic checks
        if (!$this->isWindows()) {
            $this->lastError = 'Not running on Windows';
            $this->kernel32 = $this->psapi = $this->kernel32_extra = null;
            return;
        }
        if (!self::enabled()) {
            $this->lastError = 'FFI extension not loaded. Enable ffi in php.ini';
            $this->kernel32 = $this->psapi = $this->kernel32_extra = null;
            return;
        }

        try {
            // kernel32 (OpenProcess, CloseHandle, GetLastError)
            $this->kernel32 = FFI::cdef('
                typedef void* HANDLE;
                HANDLE OpenProcess(unsigned long dwDesiredAccess, int bInheritHandle, unsigned long dwProcessId);
                int CloseHandle(HANDLE hObject);
                unsigned long GetLastError(void);
            ', 'kernel32.dll');

            // psapi (EmptyWorkingSet)
            $this->psapi = FFI::cdef('
                int EmptyWorkingSet(void* hProcess);
            ', 'psapi.dll');

            // kernel32 extras for FormatMessageA & LocalFree
            $this->kernel32_extra = FFI::cdef('
                unsigned long FormatMessageA(unsigned long dwFlags, const void* lpSource, unsigned long dwMessageId,
                                            unsigned long dwLanguageId, char** lpBuffer, unsigned long nSize, void* Arguments);
                void* LocalFree(void* hMem);
            ', 'kernel32.dll');
        } catch (Exception $e) {
            $this->lastError = 'Failed to initialize FFI: ' . $e->getMessage();
            $this->kernel32 = $this->psapi = $this->kernel32_extra = null;
        }
    }

    /** Check if running on Windows */
    private function isWindows(): bool {
        return stripos(PHP_OS_FAMILY ?? PHP_OS, 'Windows') !== false || stripos(PHP_OS, 'WIN') !== false;
    }

    /** Is FFI available */
    public static function enabled(): bool {
        return extension_loaded('ffi');
    }

    /** Get last error (or null) */
    public function getError(): ?array {
        if ($this->lastError) {
            return ['error' => $this->lastError];
        }
        return null;
    }

    /**
     * Convert Win32 error code to readable message using FormatMessageA.
     * If FFI helpers are missing returns fallback text.
     */
    private function winErrToString($code): string {
        if (!$this->kernel32_extra) return "Unknown error code: $code";

        $lpBuffer = FFI::new("char*[1]");
        $flags = self::FORMAT_MESSAGE_ALLOCATE_BUFFER | self::FORMAT_MESSAGE_FROM_SYSTEM | self::FORMAT_MESSAGE_IGNORE_INSERTS;

        // FormatMessageA will allocate and set lpBuffer[0]
        $len = $this->kernel32_extra->FormatMessageA($flags, NULL, (int)$code, 0, $lpBuffer, 0, NULL);
        if ($len == 0) {
            return "Unknown error code: $code";
        }

        $cstr = $lpBuffer[0];
        $msg = FFI::string($cstr);
        // free the allocated buffer
        $this->kernel32_extra->LocalFree($cstr);
        return trim($msg);
    }

    /**
     * Parse memory string from tasklist (e.g. "123,456 K") into integer KB
     */
    private function parseMemoryStringToKB(string $memStr): int {
        $digits = preg_replace('/[^\d]/', '', $memStr);
        return $digits === '' ? 0 : (int)$digits;
    }

    /**
     * getProcesses($sortBy = null, $order = 'desc')
     * Returns array of ['name'=>string,'pid'=>int,'memory'=>string,'memory_kb'=>int]
     */
    public function getProcesses(?string $sortBy = null, string $order = 'desc'): array {
        if (!$this->isWindows()) {
            $this->lastError = 'getProcesses() is Windows-only in this handler';
            return [];
        }

        $lines = [];
        exec('tasklist /FO CSV /NH', $lines, $rc);
        if ($rc !== 0) {
            $this->lastError = 'Failed to execute tasklist';
            return [];
        }

        $out = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            // reliable CSV parse
            $cols = str_getcsv($line, ',', '"', '\\');
            if (count($cols) < 5) continue;

            $name = $cols[0];
            $pid = (int)$cols[1];
            $mem = $cols[4]; // string like "123,456 K"
            $mem_kb = $this->parseMemoryStringToKB($mem);

            $out[] = [
                'name' => $name,
                'pid' => $pid,
                'memory' => $mem,
                'memory_kb' => $mem_kb
            ];
        }

        // optional sorting
        if ($sortBy) {
            usort($out, function($a, $b) use ($sortBy, $order) {
                $cmp = 0;
                if ($sortBy === 'memory') {
                    $cmp = $a['memory_kb'] <=> $b['memory_kb'];
                } elseif ($sortBy === 'name') {
                    $cmp = strcasecmp($a['name'], $b['name']);
                }
                return $order === 'desc' ? -$cmp : $cmp;
            });
        }

        return $out;
    }

    /**
     * Trims memory using PID
     *  - Uses FFI -> OpenProcess + EmptyWorkingSet
     * @return array  
     *  - returned format: ['ok'=>bool,'error_code'=>int|null,'error_message'=>string|null]
     */
    public function trimMemoryByPID(int $pid): array {
        $this->lastError = null;

        if (!$this->kernel32 || !$this->psapi) {
            $this->lastError = 'FFI not initialized or missing (ensure running on Windows with ffi enabled)';
            return ['ok' => false, 'error_code' => -1, 'error_message' => $this->lastError];
        }

        // Open process with required access
        $hProc = $this->kernel32->OpenProcess(self::PROCESS_QUERY_INFORMATION | self::PROCESS_SET_QUOTA, 0, $pid);
        
        // Must be an FFI\CData pointer
        if (!($hProc instanceof FFI\CData)) {
            $this->lastError = 'OpenProcess returned non-FFI value';
            return ['ok' => false, 'error_code' => -2, 'error_message' => $this->lastError];
        }

        // Check for null pointer
        if (FFI::isNull($hProc)) {
            $err = @$this->kernel32->GetLastError();
            $msg = $this->winErrToString($err);
            $this->lastError = "OpenProcess returned NULL: {$msg}";
            return ['ok' => false, 'error_code' => $err, 'error_message' => $this->lastError];
        }
        
        // Attempt to empty the working set (single call, guarded)
        try {
            $res = $this->psapi->EmptyWorkingSet($hProc);
        } catch (Throwable $e) {
            // Unexpected FFI exception — try to close handle and return error
            @($this->kernel32->CloseHandle($hProc));
            $this->lastError = 'EmptyWorkingSet threw exception: ' . $e->getMessage();
            return ['ok' => false, 'error_code' => -4, 'error_message' => $this->lastError];
        }

        if ($res == 0) {
            $err = $this->kernel32->GetLastError();
            // close handle before returning
            $this->kernel32->CloseHandle($hProc);
            $msg = $this->winErrToString($err);
            $this->lastError = "EmptyWorkingSet failed: {$msg}";
            return ['ok' => false, 'error_code' => $err, 'error_message' => $this->lastError];
        }

        // success
        $this->kernel32->CloseHandle($hProc);
        return ['ok' => true, 'error_code' => 0, 'error_message' => null];
    }

    /**
     * Trim all processes matching a name (case-insensitive).
     * Returns associative array keyed by pid:
     * pid => ['process'=> <proc array>, 'ok'=>bool, 'error_code'=>..., 'error_message'=>...]
     */
    public function trimMemoryByName(string $processName): array {
        $processes = $this->getProcesses();
        $results = [];

        foreach ($processes as $proc) {
            if (strcasecmp($proc['name'], $processName) === 0) {
                $result = $this->trimMemoryByPID($proc['pid']);
                $results[$proc['pid']] = array_merge(['process' => $proc], $result);
            }
        }

        if (empty($results)) {
            $this->lastError = "No processes found with name: {$processName}";
        }

        return $results;
    }

    /**
     * Group apps by name and aggregate memory.
     * Returns numeric array of groups:
     * [ ['name'=>..., 'pids'=>[...], 'total_memory_kb'=>int, 'total_memory_unit'=>string], ... ]
     */
    public function getAppsGrouped(): array {
        $procs = $this->getProcesses();
        $apps = [];

        foreach ($procs as $p) {
            $nameKey = strtolower($p['name']);
            if (!isset($apps[$nameKey])) {
                $apps[$nameKey] = [
                    'name' => $p['name'],
                    'pids' => [],
                    'owners' => [],
                    'total_memory_kb' => 0,
                    'total_memory_unit' => $p['memory'] ?? ($p['memory_kb'] . ' K')
                ];
            }
            $apps[$nameKey]['pids'][] = $p['pid'];
            // best-effort mark as SYSTEM if matches blacklist or pid small
            $apps[$nameKey]['owners'][] = $this->isSystemProcessByName($p['name'], $p['pid']) ? 'SYSTEM' : 'USER';
            $apps[$nameKey]['total_memory_kb'] += $p['memory_kb'];
        }

        // normalize owners unique
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
     * @param string $userApps   TRUE fetches only user apps
     *  - Note: system processes ignored is heuristic (i.e uses blacklist + small pid).
     * @return array
     */
    public function getHighMemoryApps(?int $minKb = null, ?int $top = null, string $sortBy = 'memory', string $order = 'desc', bool $userApps = false): array
    {
        $apps = $this->getAppsGrouped();

        if ($userApps) {
            $apps = array_filter($apps, function($g) {
                $owners = $g['owners'] ?? [];
                // if any owner is USER, keep it
                foreach ($owners as $o) {
                    if (strtoupper($o) === 'USER') return true;
                }
                return false;
            });
        }

        // min filter
        if ($minKb !== null) {
            $apps = array_filter($apps, fn($a) => ($a['total_memory_kb'] ?? 0) >= $minKb);
        }

        // sort
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

        return array_values($apps);
    }

    /**
     * System processes blacklisted
     *
     * @param string $name
     * @param integer $pid
     * @return boolean
     */
    protected function isSystemProcessByName(string $name, int $pid = 0): bool {
        $n = strtolower($name);
        $blacklist = [
            'system', 'system idle process', 'svchost.exe', 'wininit.exe', 'services.exe', 'lsass.exe', 'smss.exe', 'csrss.exe',
             'taskmgr','registry','runtimebroker'
            // you may keep explorer if you prefer
        ];

        if ($pid > 0 && $pid <= 4) return true; // very small pid -> system
        foreach ($blacklist as $b) {
            if (strpos($n, strtolower($b)) !== false) return true;
        }
        return false;
    }
}
