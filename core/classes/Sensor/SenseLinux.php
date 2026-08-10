<?php

namespace spoova\mi\core\classes\Sensor;

use spoova\mi\core\classes\Sensor\SenseOS;
use spoova\mi\core\tools\BytesConverter;

/**
 * Retrieves uniform information for device memory, cpu usage and disk I/O (if available) 
 * - Linux version
 */
class SenseLinux extends SenseOS {

    protected static array $message = [];
    protected static array $errors = [];

    /**
     * Disk IO (Linux: using iostat if available)
     */
    public static function disk_io() : array {
        $result = [];
        if ($output = shell_exec("iostat -dx 1 2 | tail -n +7")) {
            $lines = explode("\n", trim($output));
            foreach ($lines as $line) {
                $parts = preg_split('/\s+/', trim($line));
                if (count($parts) > 1) {
                    $device = $parts[0];
                    $result[$device] = [
                        'reads_per_sec'  => $parts[1] ?? null,
                        'writes_per_sec' => $parts[2] ?? null,
                        'utilization'    => end($parts) // %util
                    ];
                }
            }
        }
        return $result;
    }

    /**
     * Returns memory usage
     */
    public static function memory() : array {
        if ($output = shell_exec("free -b")) {
            $lines = explode("\n", trim($output));
            foreach ($lines as $line) {
                if (str_starts_with($line, "Mem:")) {
                    $parts = preg_split('/\s+/', $line);
                    $total = (int)($parts[1] ?? 0);
                    $used  = (int)($parts[2] ?? 0);
                    $free  = (int)($parts[3] ?? 0);
                    return [
                        'total' => BytesConverter::conversion($total)->toBytes(),
                        'used'  => BytesConverter::conversion($used)->toBytes(),
                        'free'  => BytesConverter::conversion($free)->toBytes(),
                    ];
                }
            }
        }
        return [];
    }

    /**
     * CPU usage
     */
    public static function cpu() : array {
        if ($output = shell_exec("top -bn1 | grep 'Cpu(s)'")) {
            preg_match('/(\d+\.\d+)\s*id/', $output, $matches);
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
        return 'Linux';
    }

    /**
     * Processes above threshold (Linux: using ps aux)
     */
    public static function processes(int $bytes = 52428800) : array {
        $output = shell_exec("ps -eo pid,comm,rss --sort=-rss");
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