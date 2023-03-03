<?php 

namespace teymzz\spoova\core\commands;

use teymzz\spoova\core\classes\FileManager;
use teymzz\spoova\core\commands\Cli;

class InteractiveConsole {

    private static FileManager $Filemanager;
    private static $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

    private static $ipromptCounter = 0;

    private static $errors = [
        E_ERROR   => 'Fatal Error', //1
        E_WARNING => 'Warning',     //2
        E_PARSE   => 'Parse Error', //4
        E_NOTICE  => 'Notice Error', //8
        E_CORE_ERROR      => "Core Error", //16
        E_CORE_WARNING    => "Core Warning", //32
        E_COMPILE_ERROR   => "Zend Error", //64
        E_COMPILE_WARNING => "Zend Warning", //128
        E_USER_ERROR      => "Trigger Error", //256
        E_USER_WARNING    => "Trigger Warning", //512
        E_USER_NOTICE     => "Trigger Notice", //1024
        E_STRICT          => "Strict", //2048
        E_RECOVERABLE_ERROR => "Notice", //4096
        E_DEPRECATED      => "Deprecated",//8192
        E_USER_DEPRECATED => "User Deprecated", //16384 
        E_ALL             => "All Errors", //32767
    ];


    function __construct()
    {

        set_error_handler([self::class,'handleCliErrors']);
        set_exception_handler([self::class,'handleCliExceptions']);   
        static::$Filemanager = new FileManager;
        self::interact();

    }

    static function interact() {

        Cli::textView(Cli::alert("Welcome to wiz code runner!"), 0, "|1"); 
        
        Cli::textView(Cli::alert(Cli::emos('ribbon-arrow')." Paste or write your code below: "), "2|1", "1|1");  
        Cli::textView(Cli::warn(" Remember to end code with a semicolon delimiter. "), "5|1", "1|1");  
        self::process();

    }

    public static function process(){

        Cli::iprompt('', fn() => 
            [

                'boot' => function($counter){

                    Cli::textView(Cli::alert($counter."."), "3|1", "1");  

                },

                'final' => function($input) {   

                    $content = "<?php \n".str_replace(";\n", ";", $input)." ?>";

                    $wiz = _core.'custom/views/wiz.php';

                    if(static::$Filemanager->openFile(true, $wiz)){

                        file_put_contents($wiz, $content);
                        self::$ipromptCounter = Cli::ipromptCounter();
                        ob_start();
                        include($wiz);
                        $response = ob_get_clean();

                        file_put_contents($wiz, '');
                        static::$Filemanager->removeFile($wiz);
                        
                        Cli::textView(Cli::valid(">> response: "), "3|1", 1);     
                        Cli::textView(Cli::alert($response), "|1", "|2");
     
                    }
                }

            ]
        );

    }

    public static function handleCliErrors($errno, $errstr, $errfile, $errline){

        $err = [
            'error'    => self::$errors[$errno],
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => '',
            'handler'  => 'Error'
        ];
        $errline = (($errline -1) > self::$ipromptCounter)? self::$ipromptCounter : $errline -1;
        Cli::clearLine();
        Cli::textView(Cli::warn(self::$errors[$errno])." : ". $errstr . " in line ".$errline, 0, "|1");

        $wiz = _core.'custom/views/wiz.php';
        static::$Filemanager->removeFile($wiz);
        
    }

    public static function handleCliExceptions($e = null) {

        $constant = ucfirst(get_class($e)); 
        $constant = $constant == 'ParseError'? $constant : 'Error';
        $exception = self::$exceptions[$constant];
        $error = self::$errors[$exception];

        $err = [
            'error'    => $error,
            'message'  => $e->getMessage(), 
            'errfile'  => $e->getFile(), 
            'errline'  => $e->getLine(),
            'errtrace' => $e->getTrace(), 
            'handler'  => 'Exception'
        ];
        
        $errline = (($e->getLine()-1) > self::$ipromptCounter)? self::$ipromptCounter : $e->getLine() - 1;

        Cli::clearLine();
        Cli::textView(Cli::danger(Cli::emos('ribbon-arrow')), "2|1", "1");
        Cli::textView(Cli::danger($error)." : ". $e->getMessage() ." in line ".$errline, 0, '|2');

        $wiz = _core.'custom/views/wiz.php';
        static::$Filemanager->removeFile($wiz);

    }

}
