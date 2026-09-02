<?php
declare(strict_types=1);

namespace spoova\mi\core\classes\Sensor;

use spoova\mi\core\classes\Sensor\ProcessHandler\ProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\UnixProcessHandler;
use spoova\mi\core\classes\Sensor\ProcessHandler\WinProcessHandler;
use Throwable;

class SenseProcesses {

    public $action = 'fetch';
    public ProcessHandler $handler;

    public function __construct()
    {
        // Minimal safety check 
        // if (!class_exists(ProcessHandler::class)) {
        //     echo ['status' => 'error', 'message' => 'ProcessHandler class not found.'];
        //     exit;
        // }

        // instantiate appropriate handler via factory()
        // try {
            $this->handler = ProcessHandler::factory();
        // } catch (Throwable $e) {
        //     echo json_encode(['status' => 'error', 'message' => 'Failed to instantiate ProcessHandler: ' . $e->getMessage()]);
        //     exit;
        // }

    }

    /**
     * Execute process
     *
     * @param string $type optional [json|array]
     * @return string|array|false
     */
    public function process($type = 'array') : array|string|false {
        if($this->action === 'trim'){
            $response = $this->trimProcesses();
        }else{
            $response = $this->fetchProcesses();
        }

        if(is_array($response)){
            if($type === 'json') return json_encode($response);
        }
        return $response;
    }

    private function fetchProcesses(){

        try {
            $groups = $this->handler->getHighMemoryApps(20480, userApps: true); // apps using about 20mb
        
            return ['status' => 'ok', 'apps' => $groups];
        } catch (Throwable $e) {
            return ['status' => 'error', 'message' => 'Failed to get processes: ' . $e->getMessage()];
        }
    }

    private function trimProcesses(){
        $pid = isset($_REQUEST['pid']) ? (int)$_REQUEST['pid'] : 0;
        $app = isset($_REQUEST['app']) ? trim((string)$_REQUEST['app']) : '';
        $handler = $this->handler;

        // Preference: pid if present
        if ($pid > 0) {

            $result = $handler->trimMemoryByPID($pid);

            if (!is_array($result)) {
                return ['status' => 'fail', 'message' => 'Unexpected response from trimMemoryByPID', 'raw' => $result];
            }

            $ok = !empty($result['ok']);
            return [
                'status' => $ok ? 'success' : 'fail',
                'by' => 'pid',
                'pid' => $pid,
                'result' => $result,
                'handler_error' => method_exists($handler, 'getError') ? $handler->getError() : null
            ];    
        }

        // If pid not provided, try app name
        if ($app === 'all') {

            if (($handler instanceof WinProcessHandler) || ($handler instanceof UnixProcessHandler)) {

                $groups = $handler->getHighMemoryApps(20480, userApps: true);

                $done = []; $trimmed = false; $trims = [];

                foreach ($groups as $g) {
                    $name = strtolower($g['name']);
                    if (isset($done[$name])) continue;

                    $results = $handler->trimMemoryByName($g['name']);
                    if($results) $trims[] = $name;
                    if(!$trimmed && $results){ $trimmed = true; }
                    $done[$name] = true;
                }

                return [
                    'status' => $trimmed ? 'ok' : 'fail',
                    'by' => 'app',
                    'app' => $app,
                    'results' => $results ?? [],
                    'handler_error' => method_exists($handler, 'getError') ? $handler->getError() : null,
                    'trims' => count($trims),
                    'trimmed' => $trims,
                ];
            }
            
            return ['status' => 'fail', 'message' => 'trimMemoryByName not supported by handler'];
            
        }

        if ($app !== '') {

            $results = $handler->trimMemoryByName($app);

            return [
                'status' => !empty($results) ? 'success' : 'fail',
                'by' => 'app',
                'app' => $app,
                'results' => $results,
                'handler_error' => method_exists($handler, 'getError') ? $handler->getError() : null
            ];
            
        }

        // neither pid nor app given
        return ['status' => 'fail', 'message' => 'trim requested but no pid or app supplied'];
    }

    /**
     * Set action to be performed
     *
     * @param string $action optional [fetch|trim]
     * @return void
     */
    public function setAction(string $action = 'fetch'){
        if(in_array($action, ['fetch','trim'])) $this->action = $action;
    }

}