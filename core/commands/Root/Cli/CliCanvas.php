<?php 

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Error;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliCanvas\CliDrawer;

class CliCanvas {

    function __construct()
    {
        if(Cli::hasCommand('stty')){
            // throw new \Exception('Cli command requires stty');
        }
    }

    /**
     * draw a textbox
     *
     * @param integer $width
     * @param integer $height
     * @param string $indent margin from left and bottom
     * @param Closure $handle function to handle drawings
     * @return CliDrawer
     */
    function textBox(int $width, int $height, int|string $indent = '0', ?Closure $handle = null) : CliDrawer {
        
        $cursor = Cli::cursorPosition();
        $row = $cursor['row'];
        $col = $cursor['col'];
        $initial =  $row.','.$col;
        $indent = explode('|', $indent);
        $indentXL = $indent[0] ?? 0;
        $indentXR = $indent[1] ?? 0; 
        $indents = [$indentXL, $indentXR];
        $entry = fn($rowplus = 0, $colplus = 0) => Cli::moveTo($row+1+$rowplus, $col+1+$indentXL+$colplus);
        $textStarts = ['x'=>$col+1+$indentXL, 'y'=>$row+1];
        $type = 'textBox';

        $Ghost = new GhostFunction(['ghostData']);

        // set required data
        $data = compact('row','col','width','height','indent','indents','initial','entry','type','textStarts');

        // Define method to access value of required variables.
        $Ghost->ghostData(function($key) use($data){
            if(array_key_exists($key, $data)) return $data[$key];
            throw new Error('"$'.$key.'" value is not available for CliDrawer class');
        });

        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliDrawer{});
        $object = GhostProxy::object();
        if($handle) $handle($object);
        return $object;
    }

}