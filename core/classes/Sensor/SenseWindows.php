<?php

namespace spoova\mi\core\classes\Sensor;

use spoova\mi\core\classes\Sensor\SenseOS;
use spoova\mi\core\tools\BytesConverter;

/**
 * Retrieves uniform information for device memory, cpu usage and disk I/O (if available)
 * - Windows version
 *
 * Primary data source is PowerShell CIM (Get-CimInstance), which works on modern
 * Windows where the legacy `wmic` utility has been removed. Each metric falls
 * back to `wmic` when PowerShell/CIM is unavailable (older systems).
 */
class SenseWindows extends SenseOS{

    protected static array $message = [];
    protected static array $errors = [];

    public static function disk_io() : array {
        return [];
    }

    public function os_name() : string|false {
        return 'Windows';
    }

    /* --------------------------------------------------------------------- *
     *  Memory                                                               *
     * --------------------------------------------------------------------- */

    /**
     * Returns the memory usage value of the operating system.
     *
     * @return array keys returned include :
     *  - total: specifies the total memory available
     *  - used: specifies the total used memory
     *  - free: specifies the total free memory
     */
    public static function memory() : array
    {
        // Primary: PowerShell CIM
        $out = self::powershell('$o=Get-CimInstance Win32_OperatingSystem; Write-Output ($o.TotalVisibleMemorySize.ToString()+\',\'+$o.FreePhysicalMemory.ToString())');
        if($out !== null){
            $parts = explode(',', trim($out));
            if(count($parts) === 2 && is_numeric($parts[0]) && is_numeric($parts[1])){
                return self::memoryArray((int)$parts[0] * 1024, (int)$parts[1] * 1024);
            }
        }

        // Fallback: legacy wmic
        return self::memoryWmic();
    }

    private static function memoryArray(int $total, int $free) : array
    {
        if($free > $total){ // guard against swapped/odd readings
            $tmp = $total; $total = $free; $free = $tmp;
        }
        $used = $total - $free;
        return [
            'total' => BytesConverter::conversion($total)->toBytes(),
            'used'  => BytesConverter::conversion($used)->toBytes(),
            'free'  => BytesConverter::conversion($free)->toBytes(),
        ];
    }

    private static function memoryWmic() : array
    {
        if($output = shell_exec('wmic OS get TotalVisibleMemorySize,FreePhysicalMemory /format:csv')){
            $lines = explode("\n", trim($output));
            if (count($lines) > 1) {
                $values = str_getcsv($lines[1], escape: "\\");
                $total = (int)$values[1] * 1024; // Convert KB to bytes
                $free  = (int)$values[2] * 1024;
                return self::memoryArray($total, $free);
            }
        }
        return [];
    }

    /* --------------------------------------------------------------------- *
     *  CPU                                                                   *
     * --------------------------------------------------------------------- */

    /**
     * Get the percentage of cpu currently used
     *
     * @return array includes the details about load percentage. Returned keys include
     *   - average : specified the load percentage
     *   - performance : specified as [high, moderate, poor, low, very low]
     *   - rating: specifies performance in integers of [4, 3, 2, 1, 0] where 0 is very low and 4 is very high.
     */
    public static function cpu() : array {
        // Primary: PowerShell CIM (average LoadPercentage across cores)
        $out = self::powershell('(Get-CimInstance Win32_Processor | Measure-Object -Property LoadPercentage -Average).Average');
        if($out !== null && is_numeric(trim($out))){
            return self::cpuArray((int) round((float) trim($out)));
        }

        // Fallback: legacy wmic
        if($output = shell_exec('wmic cpu get loadpercentage')){
            $loadAverage = 0 + trim(str_replace('LoadPercentage', '', $output));
            return self::cpuArray((int) $loadAverage);
        }
        return [];
    }

    private static function cpuArray(int $loadAverage) : array
    {
        if($loadAverage <= 30){
            $performance = 'high';     $rating = 4;
        }elseif($loadAverage <= 60){
            $performance = 'moderate'; $rating = 3;
        }elseif($loadAverage <= 80){
            $performance = 'poor';     $rating = 2;
        }elseif($loadAverage <= 90){
            $performance = 'low';      $rating = 1;
        }else{
            $performance = 'very low'; $rating = 0;
        }
        return [
            'average' => $loadAverage,
            'performance' => $performance,
            'rating' => $rating,
        ];
    }

    /* --------------------------------------------------------------------- *
     *  Processes                                                            *
     * --------------------------------------------------------------------- */

    /**
     * Fetch the processes running above a certain specified number of bytes
     *
     * @param integer $bytes threshold number of bytes
     * @return array
     */
    public static function processes(int $bytes = 52428800) : array {

        // Primary: PowerShell CIM
        $script = 'Get-CimInstance Win32_Process | Where-Object { $_.WorkingSetSize -gt '.((int)$bytes).' } | ForEach-Object { $_.Name+\'|\'+$_.ProcessId+\'|\'+$_.WorkingSetSize }';
        $out = self::powershell($script);
        if($out !== null && trim($out) !== ''){
            $rows = [];
            foreach(preg_split('/\r?\n/', trim($out)) as $line){
                $line = trim($line);
                if($line === '') continue;
                $cols = explode('|', $line);
                if(count($cols) < 3) continue;
                $ws  = array_pop($cols);
                $pid = array_pop($cols);
                $name = implode('|', $cols); // preserve names even if they contained a delimiter
                if(!is_numeric($ws) || !is_numeric($pid)) continue;
                $rows[] = ['name' => $name, 'pid' => (int)$pid, 'ws' => (int)$ws];
            }
            if($rows) return self::buildProcessArray($rows, $bytes);
        }

        // Fallback: legacy wmic
        return self::processesWmic($bytes);
    }

    /**
     * Build the uniform processes array shape from normalized rows.
     *
     * @param array $rows each row: ['name'=>string, 'pid'=>int, 'ws'=>int(bytes)]
     * @param integer $bytes unit byte to be converted.
     */
    private static function buildProcessArray(array $rows, int $bytes) : array
    {
        $apps = $ratings = $resources = $pid = [];
        $stringBytes = BytesConverter::conversion($bytes)->toStringBytes();

        foreach($rows as $r){
            $usage = (int) $r['ws'];
            if($usage <= 0) continue;
            $appName = $r['name'];
            $procsId = (string) $r['pid'];
            $prBytes = BytesConverter::conversion($usage)->toStringBytes();

            $apps[$appName][$procsId] = $prBytes;
            $ratings[$appName]   = ($ratings[$appName] ?? 0) + $usage;
            $resources[$appName] = ($resources[$appName] ?? 0) + 1;
            $pid[$appName][]     = $procsId;
        }

        arsort($ratings);
        arsort($resources);
        $ratings = array_map(fn($value) => BytesConverter::conversion($value)->toStringBytes(), $ratings);

        $apps[':ratings']   = $ratings;
        $apps[':resources'] = $resources;
        $apps[':scale']     = $stringBytes;
        $apps[':pid']       = $pid;

        return array_filter($apps);
    }

    private static function processesWmic(int $bytes = 52428800) : array {

        $column1 = $column2 = $column3 = 0;
        $output = shell_exec("wmic process where \"workingsetsize > $bytes\" get ProcessId,Name,WorkingSetSize");
        if(!$output) return [];

        $rows = explode("\n", $output);
        $rows = array_map(function($val){
            return trim(preg_replace('/\s+/'," ", $val));
        }, $rows);

        $normalized = [];
        foreach($rows as $index => $row) {
            $i = ($i ?? -1) + 1;
            $row = explode(' ', $row);
            if($i === 0) continue; // header row
            if(!$row){ $i -= 1; continue; }
            if(is_numeric($usage = array_pop($row))){
                $procsId = array_pop($row);
                $appName = implode(' ', $row);
                $normalized[] = ['name' => $appName, 'pid' => (int)$procsId, 'ws' => (int)$usage];
            }else{
                $i -= 1;
            }
        }

        return self::buildProcessArray($normalized, $bytes);
    }

    /* --------------------------------------------------------------------- *
     *  Helpers                                                              *
     * --------------------------------------------------------------------- */

    /**
     * Run a PowerShell command and return its trimmed stdout, or null on failure.
     */
    private static function powershell(string $script) : ?string {
        if(!function_exists('shell_exec')) return null;
        $cmd = 'powershell -NoProfile -NonInteractive -Command "'.$script.'" 2>NUL';
        $output = @shell_exec($cmd);
        return ($output === null || $output === false) ? null : trim($output);
    }

}
