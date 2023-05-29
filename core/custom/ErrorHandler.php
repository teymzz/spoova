<?php

use spoova\mi\core\classes\FileManager;
use spoova\mi\core\commands\Cli;

class ErrorHandler extends Exception{

    public static $pathicon = 'bi-chevron-right';

    private static $errs = [];
    private static $errExceptions = [];
    private static array $backTrace = [];

    private static $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

    private static $cliMessage;

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

    private static $addedRes = false;

    //* allowed number of error displays
    private static $err_displays = 1;

    //* total number of errors already displayed
    private static $err_displayed = 0;

    private static $addfile = true; //error file

    
    /**
     * Fatal Errors (Exceptions)
     *
     * @return void
     */
    static function handleExceptions($e = null){
        
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
        self::$errExceptions = $err;
        self::debug_filter();
        self::display($err);
    }

    /**
     * Handle all simple errors (Warning / Notice)
     *
     * @param string $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @return void
     */
    static function handleErrors($errno, $errstr, $errfile, $errline) {
        self::debug_filter();
        $err = self::buildErrors(self::$errors[$errno], $errstr, $errfile, $errline);
        self::$errs = $err;
        self::display($err);
    }
    
    /**
     * Fatal Errors (Exceptions)
     *
     * @return void
     */
    static function handleCliExceptions($e = null){
        
        $constant = ucfirst(get_class($e)); 
        $constant = $constant == 'ParseError'? $constant : 'Error';
        $exception = self::$exceptions[$constant];
        $error = self::$errors[$exception];

        $err = self::buildErrors(
            $error, $e->getMessage(), $e->getFile(), $e->getLine(),
            $e->getTrace(), 'Exception'
        );
        self::clidisplay($err);
    }

    /**
     * Handle all simple errors (Warning / Notice)
     *
     * @param string $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @return void
     */
    static function handleCliErrors($errno, $errstr, $errfile, $errline) {
        $err = self::buildErrors(self::$errors[$errno], $errstr, $errfile, $errline);
        self::clidisplay($err);
    }

    static function display(array $err){

        $root = str_replace("/","\\",$_SERVER['DOCUMENT_ROOT']);

        $addErrFile = (basename($err['errfile']) == 'EInfo');

        $errline = $err['errline'];
        $errTrace = $err['errtrace'];
        $errTraces = is_array($err['errtrace'])? count($err['errtrace']) : 0;

        if($addErrFile){ 
            $errfile = self::toArrows($err['errfile']); 
            $addErrFile = '<div class="error-track pxv-10"> '.$errfile.' <span class="err-btns span-btns rad-r fb-6 pxv-2 pxs-10"> '.$errline.' </span> </div>';
        }else{
            $addErrFile = '';
        }

        if(!$errTraces){
            if(self::$backTrace){
                $errTraces = count(self::$backTrace);
                $errTrace = self::$backTrace;
            } 
        }

        $errinfo = ' in <span class="box fb-6 rad-r">'.basename($err['errfile']).'</span> on line '.$errline.''; 
        $errMessage = self::filterTraces($err['message'], $errinfo);

        $errlower = (strtolower($err['error']));
        $errcolor = $errlower === 'warning'? '#d26d13' : 'rgb(217, 26, 26)';

        $res = '
            <script x-debug="res-js" src="'.Domurl("res/main/js/local/debug/debug.js").'"></script>      
            <link x-debug="res-css" rel="stylesheet"  href="'.rtrim(Domurl("res/main/css/local/debug/res.css")).'" />        
        ';
        if(self::$err_displayed == self::$err_displays) return;
        if(self::$addedRes) $res = '';

        $Filemanager = new FileManager;
        $Filemanager->setUrl(_icore.'init');
        $theme = "";

        if($Filemanager->openFile()){
            $theme = "_".$Filemanager->readFile('ERROR_THEME');
        }

        $body = ' 
        
            <div class="font-em-1d2 pxv-10 calibri xdebug-error '.$theme.' custom-error-pane">
                '.$res.'
                <div class="box-full rad-5 pxv-10 err-wrapper">
                    <div class="err-header">
                        <div class="error-name in-flex mid"> <span class="err-btns span-btns rad-r pxv-6" style="color:'.$errcolor.'"> <span class="bi-exclamation-circle box px-20"></span> <span>'.ucfirst(strtolower($err['error'])).'</span></span> </div>
                        '.$addErrFile.'
                        <div class="error-desc font-menu font-em-d75 mvt-10 pxv-6 bc-white-d rad-5">'.$errMessage.'</div>
                    </div>
                    <div class="Trace pxv-10 stack-trace"> 
                        <div class="bold font-em-d8 mvt-10 flex-full">
                            <div class="flex-full midv">
                                <span class="bi-map fb-6 mxr-10"></span> 
                                <span>Stack Trace 
                                    <span class="span-btns err-stack-btn bc-sky-blue-d rad-r pxs-20">'.$errTraces.'</span> 
                                </span>
                            </div>
                            <div class="flex midv"><span class="fb-8 bi-plus-circle toggle-stack" onclick="stack(this)"></span></div>
                        </div>
                        <div class="bold font-em-d8 flow-hide stack-debug" style="height:0;"> '.self::handleTraces($errTrace).' </div>
                    </div>                
                </div>
            </div>
        ';

        self::$addedRes = true;
        self::$err_displayed++;

        print $body;
    }

    static function cliMessage(string $message) {
        self::$cliMessage = $message;
    }

    static function cliDisplay(array $err){
        if(!self::$cliMessage){

            $error   = $err['error'];
            $errfile = $err['errfile'];
            $errline = $err['errline'].br();
            $errTrace = $err['errtrace'];
            $errTraces = is_array($err['errtrace'])? count($err['errtrace']) : 0; 
            $errMessage = $err['message'];

            $error = Cli::warn($error.':');

            $body = <<<Body
            
            $error $errMessage in $errfile on line $errline 

            Body;
        }else{

            $cliMessage = self::$cliMessage;

            $body = $cliMessage;

        }
        print $body;
        return ;
    }

    private static function buildErrors($error, $errstr, $errfile, $errline, $errTrace = '', $errHandler = 'Error'){
        $err = [
            'error'    => $error,
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => '',
            'handler'  => 'Error'
        ];

        return $err;
    }

    private static function handleTraces($traces){
        
        if(!is_array($traces)) return '';

        $tracer = '<br>';
        
        foreach($traces as $trace => $traceval){
            $tracer .= '';
            if(isset($traceval['file'])){
                $tracer .= '<div class="pxv-10 rad-r bc-sky-blue err-stack-division">'.self::toArrows($traceval['file']).' <span class="span-btns bc-white c-sky-blue-dd err-stack-line rad-r pxs-20">'.$traceval['line'].'</span></div>';
            }

            if(isset($traceval['class'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r">Class: '.$traceval['class'].'</div>';
            }

            if(isset($traceval['function'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r">Function: '.$traceval['function'].'</div>';
            }

            if(isset($traceval['call'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r mvt-10">Called: '.$traceval['call'].'</div>';
            }

            $tracer .= "<br>";

        }

           
        return $tracer;

    }

    private static function toArrows(string $url = null, $fontSize = 'font-em-d8'){
        $root = str_replace("/","\\",$_SERVER['DOCUMENT_ROOT']);
        $errfile = ltrim(str_ireplace($root, '', $url),'\\');
        $arrowurl = str_ireplace('\\', ' <span class="'.self::$pathicon.' '.$fontSize.'"></span>', $errfile);
        return $arrowurl;
    }

    public static function addFile(bool $bool = true){
        self::$addfile = $bool;
    }

    private static function filterTraces($message, $errfileInfo = '') {

        if(self::$addfile) $message .= $errfileInfo;

        return $message;

    }

    public static function getErrors() {
        $errs = self::$errs;
        $errExceptions = self::$errExceptions;

        if($errs && !$errExceptions) return $errs;
        if(!$errs && $errExceptions) return $errExceptions;

        $merge = array_unique(array_combine($errs, $errExceptions));

        return $merge;

    }

    private static function debug_filter(){

        $backTraces = debug_backtrace();

        $eInfoFile = to_backslash(_core.'classes/EInfo.php');
        $eHandlerFile = __FILE__;

        $counter = 0;

        $excludes = [$eInfoFile, $eHandlerFile, scheme('core\classes\EInfo', false), ''];

        foreach($backTraces as $backTrace){

            foreach($excludes as $exclude){
                if(in_array($exclude, $backTrace)) {
                    unset($backTraces[$counter]);
                    unset($excludes[array_search($exclude, $excludes)]);
                } 
            }
            
            if(isset($backTrace['class'])){
                if($backTrace['class'] === 'ErrorHandler'){
                    unset($backTraces[$counter]);
                }
            }
            
            $counter++;
        }

        ksort($backTraces);

        $build = ''; $traces = [];

        foreach($backTraces as $backTrace){

           $build .= self::buildTrace($backTrace, $traces);

        }

        if($build){

            $debugger = '
                <div class="font-menu box pxv-10 bc-white-dd rad-5 shadow pull-right" style="margin:2em;">
                    <div class="fb-9 c-red-d">Debug Backtrace</div>
                    <div class="debugs mvt-10">
                        '.$build.'
                    </div>
                </div>
            ';

        }

        self::$backTrace = $traces;

    }

    public static function buildTrace($backTrace, &$traces = []){
        $file  = $backTrace['file']?? '';
        $args  = $backTrace['args']?? '';
        $func  = $backTrace['function'] ?? '';
        $class = $backTrace['class'] ?? '';
        $type  = $backTrace['type'] ?? '';
        $line  = $backTrace['line'] ?? '';


        if($class){
            $call = $class.$type.$func.'()';
            // if($type === "->"){
                //     $call = '$this'.$type.$func.'()';
                // }else{
                // $call = $class.$type.$func.'()';
            // }
        }else{
            $call = $func.'()';
        }

        if($line){

            $traces[] = [
                'file' => $file,
                'args' => $args,
                'func' => $func,
                'type' => $type,
                'line' => $line,
                'call' => $call
            ];

            $eFile = docBase.str_replace(docroot, '', $file);

            $field = <<<FIELD
    
                <div class="font-menu pxv-10 shadow" style="column-gap: 1em">
    
                    <div class="flex"><div style="min-width:55px;">File:</div><div>$eFile</div></div>
                    <div class="flex"><div style="min-width:55px;">Line:</div><div>$line</div></div>
                    <div class="flex"><div style="min-width:55px;">Function:</div><div>$call</div></div>
    
                </div>
    
            FIELD;
            return $field;
        }


    }

}

if(php_sapi_name() != 'cli'){
 set_error_handler([ErrorHandler::class,'handleErrors']);
 set_exception_handler([ErrorHandler::class,'handleExceptions']);   
}else{
 set_error_handler([ErrorHandler::class,'handleCliErrors']);
 set_exception_handler([ErrorHandler::class,'handleCliExceptions']);   
}


require_once 'secure.php';
?>