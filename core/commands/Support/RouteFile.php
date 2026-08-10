<?php

namespace spoova\mi\core\commands\Support; 

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPulser;

class RouteFile {

    public function __construct(array $args)
    {

        $reference = $args[0]?? ''; 

        if(!$reference) {
            Cli::cls();
            Cli::headerView('open route:', break: 2);
            Cli::exit(Cli::errorView('No route file provided', break: 1));
        }

        $notesPath = \WIN_ROUTES.$reference;

        $notesPath = \to_dirslash($notesPath.'.php');

        if(!is_file($notesPath)){
            Cli::headerView('open route:', break: 2);
            Cli::exit(Cli::errorView('File not found!', break: 1));
        }

        $find = ['windows'=>'where'];
        $find = $find[getOs()] ?? 'which';
        $find .= " code";
        if(shell_exec("$find code")){

            Cli::pulseView("Opening {$reference} file ...", function($char, CliPulser $mod) {
                return $mod->from('...', fn($char)=> Cli::alert($char));
            })->pulseToggle(3, 10)->pause(1)->clearLine();

            if(shell_exec('code -r '.$notesPath) !== false){
                Cli::textView(Cli::success("$reference file opened!"))->break(2)->clearLine();
            }else{
                Cli::textView(Cli::error('note file cannot be opened!'))->pause(1)->clearLine();
            }
        } else {
            Cli::textView(Cli::infoView(" Info ","view {$reference} at: ".Cli::warn(Cli::italics($notesPath))))->pause(1)->break(1)->bashBreak(1)->clearLine();
        }
    }

}