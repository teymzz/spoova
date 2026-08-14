<?php

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\Livescript;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Entry;

class MiServer extends Entry {

    function __construct(string $command)
    {
        if($command === 'start'){
             $this->start();
        }else if($command === 'stop'){
             $this->stop();
        }
    }

    /**
     * start development server
     *
     * @return void
     */
    private function start(){

        $port = self::commands(1)?: 8080;

        /* Any port the operating system can bind is accepted. The previous check
           allowed four digit numbers only, which turned away every valid port
           below 1000 (80, 443 ...) and every one above 9999. */
        $portNumber = filter_var((string) $port, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1, 'max_range' => 65535]
        ]);

        if($portNumber === false){
            Cli::textView(Cli::error('server port('.$port.') denied!'), '', '1|1');
            Cli::textView(Cli::warn('a port must be a whole number between 1 and 65535'), '', '|1');
            return;
        }

        $port = $portNumber;

        /* Ports under 1024 are reserved and normally need elevated rights, so the
           bind can still fail after this point — said once here rather than leaving
           the developer to read a bare PHP error. */
        if($port < 1024){
            Cli::textView(Cli::alert('Notice:','|1').Cli::warn('port '.$port.' is privileged and may require elevated rights'), '', '|1');
        }

        // project root (where the real index.php lives) — this file sits at
        // core/commands/Root, so fall back three levels up if docroot is unset
        $document_root = getDefined('docroot') ?: dirname(__DIR__, 3);

        $process = (int) Init::key('NETWORK_ID');

        //get all active process id 
        $output = $this->getProcesses();
        
        if($process){
          // Not for Windows...
          if(in_array($process, $output)){
            Cli::textView(Cli::alert('Network router:','|1').Cli::warn("server already running"), '', '1|2');
            return;
          }
        }
        
        Cli::textView(Cli::alert('Project:'.docBase,'|1').Cli::warn("started on port ".Cli::underline($port)), '', '1|2');
        
        //fetch configuration
        $Filemanager = new Filemanager;

        $Filemanager->setUrl(self::init_url());
        
        if($Filemanager->openFile()  && Livescript::loaded()){
            
            $watch  = (int) Livescript::key('ACTIVITY');
            $status = (int) Init::key('SETUP_COMPLETE'); 

            $watchdog = ($watch == 1) ? ('offline (enabled)') : (($watch === 2)? 'online (enabled)' : 'disabled'); 
            
            $watch  = "  live server mode : ".$watchdog;

            $status = "  setup status : ".$status;
        
            Cli::textView(Cli::alert('Live server mode:','|1').Cli::warn($watchdog), '', '|2');
        }
        
        $host = 'localhost';
        $router = escapeshellarg(to_dirslash($document_root.'\index.php'));

        if(isWindows()){
            $silent = '> NUL 2>&1';
            $command = "php -S $host:$port $router $silent";

            //start development server
            exec($command, $output);
        }else{
            $command = "php -S {$host}:{$port} {$router}";

            //start development server
            exec($command, $output);
        }
        
    }

    private function stop(){
        
        //stop development server
        $process = (int) Init::key('NETWORK_ID');
        
        //get all active process id 
        $output = $this->getProcesses();
        
        if($process && in_array($process, $output)){
          if(isWindows()){
              $command = "taskkill /F /PID $process";
          } else {
              $command = "kill $process";
          }
          exec($command);
          Cli::textView(Cli::alert('Network router:'.docBase,'|1').Cli::danger("stopped"), '', '1|2');
          Init::unset('NETWORK_ID');
        }else{
          Init::unset('NETWORK_ID');
          Cli::textView(Cli::alert('Network router:','|1').Cli::danger("no processes found"), '', '1|2');
        }
    }

    private function getProcesses() {
        
        if(isWindows()){
            $command = 'powershell.exe "Get-Process | Select-Object -ExpandProperty Id"';
        } else {
            $command = 'ps -e -o pid --no-headers';
        }

        exec($command, $output, $return_var);
        if ($return_var === 0) {
            $output = array_map('intval', $output); // Convert each line to an integer
        }

        return $output;
    }


}