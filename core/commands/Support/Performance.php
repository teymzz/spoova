<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 * This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Support;

use Exception;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Hasher;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\SSCompiler;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Entry;

class Performance extends Entry{

    function __construct($args = []) {

        //This class is not available for use yet
        Cli::headerView('performance', break: 2);
        Cli::errorView('This command is not available yet!', break: 1);
        Cli::exit();
        
        $actions = ['setup', 'enable', 'disable'];
        $domroot = domroot(); // path till project folder
        $serverRoot = dirname($domroot); // project folder directory
        $iniPath = php_ini_loaded_file(); //path to PHP INI file.

        $action = $args[0] ?? '';

        if(!in_array($action, $actions)){
            Cli::headerView('performance '.Cli::underline($action), break: 2);
            Cli::errorView('empty argument "'.Cli::warn($action).'" supplied.', break: 1);
            return; 
        }

        // $response = Cli::runAnime([[$this, $action]]);
        //Cli::clearUp(3); 
        $response = Cli::cleanAnime(fn() => Cli::runAnime([$this, $action]));

        // $arr = ['foo','bar', ['foo', 1, 2, 3, true]];
        // $array = print_r($arr, true);
        //     // Get print_r() output as a string
        // $out = print_r($array, true);

        // // $array = $this->toSquareBrackets($out);
        // $func = function($array){

        //     // Define closure by reference so it can call itself
        //     // Match innermost Array(...) groups (no nested ones inside)
        //     $pattern = '/Array\s*\(([^()]*?)\)/';

        //     // Replace repeatedly until no more matches remain
        //     $timeOut = 100; $i = 0;
        //     while (preg_match($pattern, $array)) {
        //         $i++;
        //         $out = preg_replace($pattern, '[$1]', $array);
        //         if($i === $timeOut) break;
        //     }

        //     return $out;
        // };
        // $array = $func($array);
        // print $array;
        // exit;
        // Cli::hideCursor();
        // Cli::pulseView($array, function($char, CliPulser $meth) {

        //         $words = ['foo','bar','Array','(',')','=>']; 
        //         $indices = [];

        //         if(is_numeric($char)){
        //             return Cli::danger($char);
        //         }else if(!is_numeric($char)){
                    
        //             $word = $meth->words($words, function($char, $i, $word, $init) use($indices){
        //                 if($word === 'foo'){
        //                     return Cli::warn($char);
        //                 }elseif($word === 'bar'){
        //                     return Cli::alert($char);
        //                 }elseif($word === '=>'){
        //                     return $init? Cli::valid('▸') : '';
        //                 }elseif(in_array($word, $indices)){
        //                     return Cli::danger($char);
        //                 }
                       
        //                 return $char;
        //             });
        //             Cli::textView($word);
        //             return '';
        //         }

        // });
        // Cli::break(1);
        // Cli::showCursor();
        // exit;
        if(Cli::animeFails()){
            Cli::headerView('performance '.Cli::warn($action), break: 2);
            Cli::exit(Cli::animeInfo(), 2);
        }
        // if($status !== 0){

        //     // check for INI file configuration.
        //     $iniToken = Init::key('INI-Token');
        //     $iniPath = Init::key('INI-Path');


        //     if($iniToken === $token){
        //         if(!$iniPath){

        //         }
        //     }

        //     if($iniToken !== $token){
        //         Cli::clearLine()->errorView("Process aborted due to unknown browser activity.", break: '|2');
        //         Cli::exit();
        //     }else{
        //         Cli::clearLine()->errorView("Handshake detected from browser activity.", break: '|2');
        //         $projectINI = domroot('php.ini');
        //         putenv("PHPRC=$projectINI");
        //         Cli::exit(php_ini_loaded_file());   
        //     }
            
        //     // Cli::clearUp(3);

        //     //if(isset($output[0]))Cli::errorView($output[0], break: '|1');
        // //     Cli::break();
        // }else{
        //     Cli::errorView(implode("\n",$output));

        // }

        // exit();

        // if(!$iniPath){

        //     // generate new INI file.
        //     $customINI = to_backslash($serverRoot).'\php.ini';
            
        //     file_put_contents($customINI, "; Shared php.ini created on " . date('Y-m-d H:i:s') . "\n");

        //     // use shell command to PHP INI path to $customINI 
            
        // }


        // Cli::exit($iniPath);
        // $base_dir = to_frontslash(dirname(dirname(domroot())));
        // $ini_path = to_frontslash(php_ini_loaded_file());
        // $ini_paths = explode($base_dir, $ini_path, 2);
        // $ini_rel_path = count($ini_paths) > 1? $ini_paths[1] : $ini_path[0];
        // $ini_pathss = explode('/',$ini_rel_path);
        // $project_root = basename(to_frontslash(dirname(domroot()))); // e.g www, htdocs
        // Cli::exit($project_root);
    }

    public function toSquareBrackets(array $array){
        
        $pattern = '/Array\s*\((?>[^()]+|(?R))*\)/';
        
        $export = preg_replace_callback($pattern, function ($m) {
            // Recursively convert inner Array(...) blocks
            $inner = preg_replace_callback('/Array\s*\((?>[^()]+|(?R))*\)/', [$this,'toSquareBrackets'], $m[0]);
            // Replace only the outer Array( ... ) with [ ... ]
            $inner = preg_replace(['/^Array\s*\(/', '/\)$/'], ['[', ']'], $inner);
            return $inner;
        }, $array);
        return $export;
    }

    public function setup(){ yield from Cli::yield(); }

    public function enable(){

        Cli::clearLine()->headerView('performance enable', break: 2);
        yield from Cli::yield([]);

        // check for INI file configuration.
        $iniToken = Init::key('INI-Token');
        $iniPath = Init::key('INI-Path');

        $passkey = $iniPath ?? '1a2b3xyz';
        $Hasher = new Hasher([to_frontslash(domroot()),getOs()], $passkey);
        $token = $Hasher->hashify('sha1');

        if($iniToken !== $token) {
    
            $browser_open_commands = [
                'windows'=>'rundll32 url.dll,FileProtocolHandler', 
                'linux'=>'open', 
                'darwin'=>'xdg-open',
                'termux' => 'termux-open-url'
            ];
    
            $device = Cli::isTerminal('termux')? 'termux' : getOs();
            $callBrowser = $browser_open_commands[$device] ?? '';

            // Fetch domain from user input
            Cli::textView('Please enter your web domain (e.g localhost:8080)', break: '|2');
            Cli::textView(Cli::warn('Domain: '));
            $prompt = Cli::prompt()->value();
            Cli::clearUp(3);
            $prompt = domurl($prompt).'/'.docBase;
    
            Cli::textView(Cli::warn('Domain:').' '.domurl($prompt), break: '|2');
            Cli::pulseView('Opening domain in browser...', 30000)->pulseToggle(3, 3);

            exec("$callBrowser ".escapeshellarg($prompt).' 2>&1', $output, $status);

            if($status !== 0){
                Cli::clearLine();
                Cli::errorView(message:'visit domain "'.Cli::warn($prompt).'" in browser', break:'|2', title: 'Info: ');
                Cli::textView('Proceeded with browser [Y/N]? ');
                $prompt = Cli::prompt();
                Cli::clearUp(4);

                if($prompt->matches('n')){
                    Cli::clearLine()->textView("Please visit your browser first.", break: '|1');
                    yield false;
                }
                if(!$prompt->imatches(['y','n'])){
                    Cli::clearLine()->errorView("Process aborted because invalid response received.", break: '|1');
                    yield false;
                }
            }

            //Fetch INI path again & revalidate token...
            Init::load(); // recompile data
            $iniToken = Init::key('INI-Token');
            $iniPath = Init::key('INI-Path');

            $passkey = $iniPath;
            $Hasher = new Hasher(['domroot',getOs()], $passkey);
            $token = $Hasher->hashify('sha1');

            if($iniToken !== $token){
                Cli::clearLine()->errorView("process aborted due to unknown browser activity.", break: '|1');
                yield false;
            }else{
                Cli::clearLine()->errorView("Handshake detected from browser activity.", break: '|1');
                // try fixing FFI config from terminal using shell on INI file path here...
                yield false;
            }

            Cli::clearUp(3);
            if(isset($output[0]))Cli::errorView($output[0], break: '|1');
            Cli::break();

        }else{

            $config = parse_ini_file($iniPath, true);

            // Validate FFI configuration key
            $ffi = $config['ffi'] ?? false;
            if(!$ffi){
                Cli::clearLine()->errorView("FFI does not seem to be available on this device.", break: '|1');
                yield false;
            }

            // Validate FFI.enable value option
            $ffiEnable =  $ffi['ffi.enable'] ?? false;
            if(!in_array($ffiEnable, ['true','false','preload'])){
                Cli::clearLine()->errorView("unsupported FFI option defined in server's PHP INI file.", break: '|1');
                yield false;  
            }

            if($ffiEnable === 'preload'){
                $ffiPreload = $ffi['ffi.preload'] ?? false;
                if($ffiPreload && !is_file($ffiPreload)){
                    Cli::clearLine()->errorView("invalid FFI preload file path detected in PHP INI file.", 'Info: ', break: '|1');
                    yield false;  
                }elseif(!$ffiPreload){
                    Cli::clearLine()->errorView("no path set for FFI preload in ".Cli::alert(Cli::thin('php.ini'))." file.", 'Info: ', break: '|1');
                    yield false;
                }
            }


        }

    }

}