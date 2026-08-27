<?php

namespace spoova\mi\core\commands\Support;

use Server;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliDev;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Root\Entry;

/**
 * This command's class sets the application logic
 */
class Logic extends Entry{

    function __construct(array $args)
    {
        // Cli::exit((!CliDev::isBash() || CliDev::isTermux()) || (CliDev::isWSL()));
        // Cli::textView(Cli::danger(Cli::emo('point-right').' spoova set logic'));
        // $times = 10; $length = 3; $beats = 30000;

        // Cli::pulseView('Hey therre ...')
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ->pulseBack($length, $beats)->pulseFront($length, $beats)
        //     ;
        // // for($i = 0; $i < $times; $i++){

        // //     Cli::pulseBack($length, $beats)->pulseFront($length, $beats);

        // // }
        // Cli::pause(1);
        // Cli::exit();
        Cli::headerView('spoova set logic', break: 2); //.(($args[0]??'')? ' ('.Cli::warn($args[0]).')' : '');

        $project_path = dirname(docroot).DS.docBase;
        $LOGIC_FILE = $project_path.DS.'index.php';
        $newLogic = in_array($logic = ($args[0] ?? ''), ['','standard']) ? 'standard' : $logic;

        if(!is_file($LOGIC_FILE)){

            $choice = ['y','yes','n','no', '::nocase' => true];
            $message = 'server file missing. Generate one? [Y/N] ';

            $prompt = Cli::prompt($choice, function(CliPrompt $prompt) use($message){

                if($prompt->active()){
                    if($prompt->trials() > 0) Cli::clearUp();
                    Cli::textView(Cli::error($message));
                }elseif($prompt->maximum()){
                    Cli::textView('Process terminated after '.Cli::warn($prompt->trials()).' trials', break: 1); 
                    Cli::exit();
                }elseif($prompt->matches('n')){
                    Cli::response(false, 'Process aborted successfully.'); 
                    Cli::exit();
                }

            }, 3);

            if($prompt->imatches(['y','yes'])){

                Cli::clearUp()->pulseView('Generating server file ...')->pulseToggle(3, 7, 100000);
                if(touch($LOGIC_FILE)){
                    /* server() carries the router file's return value back to the web server,
                       and decides for itself whether a request is for a public file */
                    $logicArg = in_array($logic, ['', 'standard'], true)? '' : "'".$logic."'";

                    file_put_contents($LOGIC_FILE, <<<LOGIC
                    <?php

                    include 'icore/filebase.php';

                    return server($logicArg);

                    LOGIC);
                    Cli::pulseClear()->textPlain(Cli::success(''))->pulseView('server file generated.', 100)->break(1);
                    Cli::pulseClear()->textPlain(Cli::success(''))->pulseView('server file configured as (', 100)->textView(Cli::warn($newLogic).')')->break(2);
                }else{
                    $message = 'Exiting '; $filler = "...";
                    Cli::pulseClear()->pulseView('Error: File generation failed!', 100, fn($char, $i) => $i < 6? Cli::danger($char) : $char)->wait(2000000);
                    Cli::clearLine()
                       ->pulseView($message, 0)
                       ->pulseView($filler, 200000, fn($char) => Cli::alert($char))
                       ->pulseUpdate($message.$filler, fn($char, $i) => ($i > 8)? Cli::alert($char) : $char)
                       ->pulseToggle(3, 2, 200000)
                       ->clearLine()
                       ->textView(Cli::error('Process aborted.'))
                       ->break(2);
                    exit;
                }
            }

            exit;
        }

        include_once($LOGIC_FILE);
        $oldLogic = Server::logic();
        $oldLogic = $oldLogic ?: 'standard';

        if($oldLogic === $newLogic){
            
            $message = 'Exiting '; $filler = "..."; Cli::pause(1);
            Cli::pulseClear()->pulseView('Notice: '.$oldLogic.' logic maintained.', 100, fn($char, $i) => $i < 7? Cli::alert($char) : $char)->wait(2000000);
            Cli::clearLine()
               ->textView(Cli::error('no new changes detected.', title: 'Info: '))
               ->break(1);

            exit;
        }

        $prefix = "Change logic to from ";
        $to = ' to ';
        $suffix = "'$newLogic'?";

        $old[1] = strlen($prefix) + 1;
        $old[2] = $old[1] + strlen($oldLogic) - 1;

        $new[1] = strlen($prefix.$oldLogic.$to) + 1;
        $new[2] = $new[1] + strlen($newLogic) - 1;

        $prompt = $prefix.$oldLogic.$to.$suffix;

        Cli::pause(1);
        Cli::pulseView($prompt, 0, function($char, $index) use($prompt, $old, $new){
            $strLen = strlen($prompt);
            $strPos = strpos($prompt, "\"") + 1;
            $char = (($index >= $old[1] && $index <= $old[2]) || ($index > $new[1] && $index <= $new[2]+1) )? Cli::warn($char) : $char;
            return $char; 
        })->break(2);

        Cli::text('[Yes] or [No]? '); //set text
        Cli::blinkCursor();

        $option = Cli::prompt(['y','yes','n','no', "::nocase"=>true], function(CliPrompt $prompt){

            if($prompt->matches(['no','n'])){
                Cli::response(false, fn() => ''.Cli::infoView(' Info ','Process terminated successfully.', break: 2));
                Cli::exit();
            }
            if($prompt->maximum()){
                $trials = $prompt->trials();
                Cli::clearLine()->errorView("Maximum number of {$trials} trials exceeded! ", break: 1);
                Cli::exit();
            }
            if($prompt->active()){
                if($prompt->trials() > 0) Cli::clearUp(1);
                Cli::clearView(Cli::alert(Cli::text()));
            }

        }, 3);

        if($option->matches(['yes','y'])) {

            $logic = $args[0] ?? '';
            if($logic === 'standard') $logic = '';
            
            Cli::clearUp(3)->hideCursor(function()use($logic, $LOGIC_FILE){
                Cli::pulseView('Updating logic ...')->pulseToggle(3, 10);
                $logicArg = ($logic === '')? '' : "'".$logic."'";

                file_put_contents($LOGIC_FILE, <<<LOGIC
                <?php

                include 'icore/filebase.php';

                return server($logicArg);

                LOGIC);
                Cli::pulseToggle(3, 10)->pulseClear('Updating logic ...');

                Cli::successView('updated to '.Cli::emos('point-right').Cli::warn($logic?:'standard'), 'Logic: ')->break(1);
            })->showCursor();

        }
    }

}