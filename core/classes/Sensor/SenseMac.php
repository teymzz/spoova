<?php

namespace spoova\mi\core\classes\Sensor;

use Exception;
use spoova\mi\core\classes\Sensor\SenseOS;
use spoova\mi\core\tools\BytesConverter;

/**
 * Retrieves uniform information for device memory, cpu usage and disk I/O (if available) 
 * - macOS (Darwin) version
 */
class SenseMac extends SenseOS {

    protected static array $message = [];
    protected static array $errors = [];

    /**
     * Disk IO (macOS: using iostat)
     */
    public static function disk_io() : array {
        $result = [];
        if ($output = shell_exec("iostat -d -c 2")) {
            $lines = explode("\n", trim($output));
            if (count($lines) > 2) {
                $lastLine = preg_split('/\s+/', trim($lines[count($lines) - 1]));
                if (count($lastLine) >= 3) {
                    $result = [
                        'tps'  => $lastLine[0] ?? null, // transfers per second
                        'kb_read_per_sec'  => $lastLine[1] ?? null,
                        'kb_written_per_sec' => $lastLine[2] ?? null,
                    ];
                }
            }
        }
        return $result;
    }

    /**
     * Memory usage (macOS: vm_stat + sysctl)
     */
    public static function memory() : array {
        $total = 0;
        $used = 0;
        $free = 0;

        // total memory
        if ($memSize = shell_exec("sysctl -n hw.memsize")) {
            $total = (int) trim($memSize);
        }

        // page size
        $pageSize = 4096;
        if ($ps = shell_exec("sysctl -n hw.pagesize")) {
            $pageSize = (int) trim($ps);
        }

        // vm_stat for free/inactive pages
        if ($vm = shell_exec("vm_stat")) {
            $lines = explode("\n", $vm);
            $pages = [];
            foreach ($lines as $line) {
                if (preg_match('/^(\w+):\s+(\d+)/', $line, $m)) {
                    $pages[$m[1]] = (int) $m[2];
                }
            }
            $freePages = ($pages['Pages free'] ?? 0) + ($pages['Pages inactive'] ?? 0);
            $free = $freePages * $pageSize;
            $used = $total - $free;
        }

        return [
            'total' => BytesConverter::conversion($total)->toBytes(),
            'used'  => BytesConverter::conversion($used)->toBytes(),
            'free'  => BytesConverter::conversion($free)->toBytes(),
        ];
    }

    /**
     * CPU usage (macOS: top -l 1)
     */
    public static function cpu() : array {
        if ($output = shell_exec("top -l 1 | grep 'CPU usage'")) {
            // Example: "CPU usage: 5.67% user, 2.34% sys, 91.98% idle"
            preg_match('/(\d+\.\d+)% idle/', $output, $matches);
            $idle = isset($matches[1]) ? floatval($matches[1]) : 0.0;
            $loadAverage = round(100 - $idle, 2);

            if ($loadAverage <= 30) {
                $performance = 'high'; $rating = 4;
            } elseif ($loadAverage <= 60) {
                $performance = 'moderate'; $rating = 3;
            } elseif ($loadAverage <= 80) {
                $performance = 'poor'; $rating = 2;
            } elseif ($loadAverage <= 90) {
                $performance = 'low'; $rating = 1;
            } else {
                $performance = 'very low'; $rating = 0;
            }

            return [
                'average' => $loadAverage,
                'performance' => $performance,
                'rating' => $rating,
            ];
        }
        return [];
    }

    public function os_name() : string|false {
        return 'Mac';
    }

    /**
     * Processes above threshold (macOS: ps aux)
     */
    public static function processes(int $bytes = 52428800) : array {
        $output = shell_exec("ps aux -o pid,comm,rss");
        $rows = explode("\n", trim($output));
        $apps = $appsByte = $ratings = $resources = $pid = [];

        $stringBytes = BytesConverter::conversion($bytes)->toStringBytes();

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header
            $row = preg_split('/\s+/', trim($row));
            if (count($row) >= 3) {
                [$procsId, $appName, $rssKb] = $row;
                $usage = (int)$rssKb * 1024; // KB → bytes
                if ($usage > $bytes) {
                    $prBytes = BytesConverter::conversion($usage)->toStringBytes();
                    $apps[$appName][$procsId] = $prBytes;
                    $appsByte[$appName] = $prBytes;
                    $ratings[$appName] = ($ratings[$appName] ?? 0) + $usage;
                    $resources[$appName] = ($resources[$appName] ?? 0) + 1;
                    $pid[$appName][] = $procsId;
                }
            }
        }

        arsort($ratings);
        arsort($resources);
        $ratings = array_map(fn($v) => BytesConverter::conversion($v)->toStringBytes(), $ratings);

        $apps[':ratings'] = $ratings;
        $apps[':resources'] = $resources;
        $apps[':scale'] = $stringBytes;
        $apps[':pid'] = $pid;

        return array_filter($apps);
    }

}
