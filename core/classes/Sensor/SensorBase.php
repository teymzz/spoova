<?php 

namespace spoova\mi\core\classes\Sensor;

use DBStatus;
use Server;
use spoova\mi\core\classes\Activity;
use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Bundle\API\API;
use spoova\mi\core\classes\Bundle\API\APIResponse;
use spoova\mi\core\classes\Bundle\API\APITest;
use spoova\mi\core\classes\Compiler;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBHandler;
use spoova\mi\core\classes\Livescript;
use Window;
use spoova\mi\core\classes\Sensor\AbstractSense;
use spoova\mi\core\classes\Sensor\SensorInterface;
use spoova\mi\core\tools\BytesConverter;

abstract class SensorBase {

    protected array $benched;
    
    protected AbstractSense|SensorInterface|null $sensor = null;

        /**
     * Get memory limit set for PHP Scripts
     *
     * @return string|false
     */
    public static function scripts() : string | false{
        return ini_get('memory_limit');
    }

    /**
     * Get maixmum upload size limit set from PHP ini file
     *
     * @return string|false
     */
    public static function max_upload() : string | false{
        return ini_get('upload_max_filesize');
    }

    /**
     * Get maixmum post size limit set from PHP ini file
     *
     * @return string|false
     */
    public static function max_post() : string | false{
        return ini_get('post_max_size');
    }

    /**
     * Get maximum post size limit set from PHP ini file
     *
     * @return array
     */
    public function controllers() : array {
        return Window::metrics();
    }

    /**
     * Retrieves sensor metrics.
     *  - XMLHttpRequest should be enforced in ajax requests.
     *
     * @param boolean $view TRUE automatically displays the metrics while FALSE returns the compiler data. 
     *  - setting as TRUE automatically prevents this method from being executed more than once. However this doesn't affect 
     *    the ajax (XMLHttpRequest) requests.
     * 
     * @return void|Compiler|never
     *  - void : returned to prevent loop when method is triggered 
     *  - Compiler : process is terminated after data is printed in ajax requests.
     *  - never : process is terminated after ssmetrix ram processes are obtained in ajax (XMLHttpRequests) requests after data has been printed.
     */
    public function metrics(bool $view = false) {
        
        if(Ajax::isAjax()) {
            if(isset($_GET['ssmetrix'])){
                self::senseProcesses(true); // handle AJAX
                exit;
            }
        }

        static $count = 0; $count++;
        
        if($view && $count > 1) return; //prevent multiple calls

        //get actual app runtime before any other process is added 
        $args['runtime'] = $this->runtime(); //defines the entire time required before the page is loaded

        $controllers = Window::metrics();

        $maps = $controllers[':keys'];
        $shutters = [];
        foreach($maps as $map => $val){
            $shutter = array_key_first($val); 
            if($shutter){
                $routes = array_keys($val[$shutter]['routes']); //get routes defined in shutter 
               
                if(isset($routes[0])){
                    $nval = array_filter($val[$shutter]['routes'], fn($key)=> !in_array($key, Window::SHUTTER_KEYS), ARRAY_FILTER_USE_KEY);
                    if($nval) $shutters[] = [$shutter, $nval]; // store [shutter_name, [routes => methods] ]
                }
            }
        }
        unset($controllers[':keys']);
        $controllers = array_map(function($val){
            $pathdivs = explode(scheme('', true), $val, 2);
            $scheme = '';
            if(count($pathdivs) > 1){
                $val = $pathdivs[1];
                $val = scheme(url($val)->pathmod(fn($val) => ucfirst($val)), false);
            }
            return $val;
        },$controllers);
        $controllers = array_values(array_unique($controllers));
        $trackers = [];

        foreach($maps as $map => $calls){
            $index = ($index ?? 0);
            $key = array_keys($calls)[0];
            $routeMaps = $calls[$key]['routes'];
            $controller = $calls[$key]['controller'];
            $trackers[$controller][$index] = [$key => $routeMaps];
            $index++;
        }

        // Get controller metrics
        $args['route'] = limitChars(lastCall(), 30); //defines the current route 
        $args['controllers'] = $controllers; // defines the current controllers to the page
        $args['shutters'] = $shutters; // defines all shutters triggered before the page is loaded
        $args['runtime'] = $this->runtime(); //defines the entire time required before the page is loaded
        
        $stats = function($value) {
            
            switch($value){
                case $value <= 50 : $state = 'VERY LOW';
                break;
                case $value <= 65 : $state = 'LOW';
                break;
                case $value <= 70 : $state = 'MED';
                break;
                case $value <= 85 : $state = 'HIGH';
                break;
                case $value > 85  : $state = 'VERY HIGH';
                break;
                default: $state = 'UNKNOWN';
            }
            
            return $state;

        };

        // Get device memory usage. The sensor may return an empty array when the
        // OS is unsupported or the underlying metric command is unavailable
        // (e.g. wmic removed on newer Windows) — default to zeros so the page
        // still renders instead of crashing on a divide-by-zero / missing key.
        $memory = $mem = $this->memory(); // defines the RAM info of the project application's device
        $mem += ['total' => 0, 'used' => 0, 'free' => 0];
        $memory += ['total' => 0, 'used' => 0, 'free' => 0];
        $memory['free'] = implode('', $memFree = BytesConverter::conversion($memory['free'])->toUnitBytes());
        $memory['used'] = implode('', $memUsed = BytesConverter::conversion($memory['used'])->toUnitBytes());
        $memory['total'] = implode('', $memTotal = BytesConverter::conversion($memory['total'])->toUnitBytes());
        $memory['percent-used'] = $mem['total'] ? round(($mem['used'] / $mem['total']) * 100) : 0;
        $memory['percent-free'] = $mem['total'] ? round(($mem['free'] / $mem['total']) * 100) : 0;
        $PHPMemory = $this->PHPMemory();

        $memory['php']['current'] = $PHPMemory['current'];
        $memory['php']['peak'] = $PHPMemory['peak'];
        $memory['php']['ini'] = $PHPMemory['ini'];

        // Get memory stats
        $args['memstat'] = $stats;
        $args['memory'] = $memory;
        //Get database queries
        $args['queries'] = DBHandler::metrics();
        $args['metrics_mode'] = DBHandler::metrics_fetch_mode();
        $args['logic'] = Server::logic();
        $args['dbstatus'] = (new DB())->openDB() ? 'connected' : 'disconnected';

        // Get currently used processes
        $processes = $this->processes(209715200);
        $args['processes'] = $processes[':ratings'] ?? [];
        $args['procs_map'] = $processes[':resources'] ?? [];
        $args['procs_id'] = $processes[':pid'] ?? [];
        $args['procs_scale'] = $processes[':scale'] ?? 0;
        $args['trackers'] = $trackers;
        $args['overlay'] = Livescript::key('overlay');
        
        $compiler = new Compiler();
        $compiler->setFile('core.custom.templates._metrics.metrics...');
        $compiler->setBase(true);
        $compiler->setArgs($args);

        if(!$view) return $compiler;
        echo $compiler;
    }

    public static function senseProcesses($sense = false) : array {

        $SenseProcesses = new SenseProcesses;

        if($sense){
            $query = url(uri)->query(); // fetch current URL
            $ssmetrix = $query['ssmetrix'] ?? randice();
            $ssmetrim = $query['ssmetrim'] ?? randice();
    
            API::channel(API::JSOX,function() use($ssmetrix, $ssmetrim){
                API::accepts('GET', function(APITest $method) {
                        $method->missing(['no request method found']);
                        $method->mismatch(['unapproved request method forwarded']);
                });
                API::queries([
                    'ssmetrix'=> $ssmetrix, // AJAX url handshake must exist before memory data is retrieved
                ]);
            })->shutdown(function(APIResponse $response){
    
                $response->view(); //automatically display response
    
            });
    
            if($ssmetrim){
                // Trim large data... 
                $SenseProcesses->setAction('trim');
                $SenseProcesses->process();
            }
        }

        $SenseProcesses->setAction('fetch');
        $processes = $SenseProcesses->process();
        $processes = $processes? $processes : [];

        foreach($processes['apps'] as $i => $process){
            $processes['apps'][$i]['total_memory_kb'] = BytesConverter::convert($process['total_memory_kb'] * 1024)->toStringBytes();
        }

        if($sense){
            print json_encode($processes);
            return $processes;
            exit;
        }else{
            return $processes;
        }
    }

    public static function os_name(string $os = PHP_OS_FAMILY) : string|false {

        $maps = [
            'windows' => 'Windows',
            'linux' => 'Linux',
            'darwin' => 'Mac',
            'mac' => 'Mac',
        ];

        return $maps[strtolower($os)] ?? false;

    }
    
    public function memory() : array {

        return $this->sensor->memory();

    }

    public function PHPMemory() : array {

        $current_memory = BytesConverter::conversion(memory_get_usage())->toStringBytes();
        $peak_memory = BytesConverter::conversion(memory_get_peak_usage())->toStringBytes();
        $ini_memory = BytesConverter::conversion(ini_get('memory_limit'))->toStringBytes();

        return [
            'current' => $current_memory,
            'peak' => $peak_memory,
            'ini' => $ini_memory,
        ];

    }
    
    public function cpu() : array {

        return $this->sensor->cpu();

    }

    /**
     * Get disk I/O statistics for the current OS (empty when unavailable).
     *
     * @return array
     */
    public function disk_io() : array {

        return $this->sensor->disk_io();

    }
    
    public function processes(int $bytes = 52428800) : array {

        return $this->sensor->processes($bytes);

    }

    public function queries() : array {

        return DBHandler::queries();

    }
    public function runtime() : string|false {

        $runtime = $this->benched('runtime') ?? false;

        return $runtime;

    }

    private function benched($key = null) {
        $benched = !isset($this->benched)? Activity::benched() : $this->benched;
        if($key !== null){
            return $benched[$key] ?? false;
        }
    }

}