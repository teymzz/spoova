<?php

use spoova\mi\core\classes\ErrorHandlers\HandleErrors;
use spoova\mi\core\classes\ErrorHandlers\HandleExceptions;
use spoova\mi\core\classes\Init;
use spoova\mi\core\commands\Cli;

class ErrorHandler extends Exception{

    protected static $HANDLER  = '';
    public static $pathicon = 'bi-chevron-right';

    protected static $errs = [];
    protected static $ErrorExceptions = [];
    protected static array $backTrace = [];
    protected static array $backTraceError = [];

    protected static $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

    protected static $cliMessage;

    protected static $errors = [
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

    //* define resource loading
    protected static $addedRes = false;

    //* allowed number of error displays
    protected static $err_displays = 1;

    //* total number of errors already displayed
    protected static $err_displayed = 0;

    protected static string|bool $addfile = true; //error file
    
    /**
     * Fatal Errors (Exceptions)
     *
     * @return void
     */
    public static function handleExceptions(object $e = null){
        new HandleExceptions($e);
    }

    /**
     * Handle all simple non-fatal errors (Warning / Notice)
     *
     * @param string $errno
     * @param string $errstr
     * @param string $errfile
     * @param string $errline
     * @return void
     */
    public static function handleErrors($errno, $errstr, $errfile, $errline) {
        new HandleErrors(...func_get_args());
    }

    final static function webdisplay($error, $message, $efile, $eline, $traces = [], $tracex = []) {

        // Resource variable
        $res = '';

        // Format error traces
        $tracesCount  = count($traces) + count($tracex);
        $tracesString = self::handleTraces($traces);
        $tracexString = self::handleTraces($tracex);

        // Get Error Theme ... 
        $theme = '_';
        $theme .= Init::key('ERROR_THEME');

        // Get File content 
        $codeblock = self::fetchContent($efile, $eline, 4, 5);

        //extract routes from traces 
        $windows = []; $tracesWindow = ''; $codeblock2 = ''; $windowsTag = ''; 

        array_map(function($val) use(&$windows){
            if(isset($val['file'])){
                $file = $val['file'];
                $window = docroot.DS.WIN;
                if(to_dirslash(substr($file, 0, strlen($window))) === to_dirslash($window)){
                    $windows[] = $val;
                }
            }
        },$traces);
        
        if(isset($windows[0]) && isset($windows[0]['file'])){
            $windowFile = $windows[0]['file'];
            if(isset($windows[0]['line'])){
                if(strtolower(to_dirslash($windowFile)) !== strtolower(to_dirslash($efile))){

                    $windowsCount = count($windows);
                    $tracesWindow = self::handleTraces($windows);
            
                    $tracesWindow = <<<winTraces
                    <div class="bold font-em-d8 flow-hide window-debug"> 
                    $tracesWindow
                    </div>
                    winTraces;

                    $windowsTag = '
                    <span style="margin-left:10px"> 
                        <span class="span-btns err-stack-btn track-route-item bc-sky-blue-d rad-r pxs-20" onclick="stack(this)">Windows: '.$windowsCount.'</span> 
                    </span>
                    ';

                    $ePath2 = to_frontslash(explode(docroot.DS, $windowFile)[1] ?? '');
                    $codeblock2 = self::fetchContent($windowFile, $windows[0]['line'], 4, 5);
                    $codeblock2 = '
                    <div style="background-color:white">
                        <div class="" style="padding:10px; background-color:#efefef; color: #301c79;"> '.$ePath2.' </div> 
                        <div style="padding:10px; color: #e90c0c;">'.$codeblock2.'</div>
                    </div>
                    ';
                }
            }
        }

        // Get Error File Path
        $ePath = to_frontslash(explode(docroot.DS, $efile)[1] ?? '');

        
        $errinfo = ' in <span class="box fb-6 rad-r">'.basename($efile).'</span> on line '.$eline.''; 
        $emessage = self::filterTraces($message, $errinfo);

        // Load resources 
        $errlower = (strtolower($error));
        $errcolor = $errlower === 'warning'? '#d26d13' : 'rgb(217, 26, 26)';

        if(!self::$addedRes){
                        
            Ress::new('res/main/')
            
            # error files ... 
            ->url("css/local/debug/res.css => x-debug:res-css")->named('x-debug-css')
            ->url("js/local/debug/debug.js => x-debug:res-js")->named('x-debug-js')
            ->close();

            $res = '';
            $res .= @import('#x-debug-css');
            $res .= @import('#x-debug-js');

        }

        //Add error file map
        if($efile){ 
            $errfile = self::toArrows($efile); 
            $addErrFile = '<div class="error-track pxv-10"> '.$errfile.' <span class="err-btns span-btns rad-r fb-6 pxv-2 pxs-10"> '.$eline.' </span> </div>';
        }else{
            $addErrFile = '';
        }
                
        $Error = <<<Error
        <div class="font-em-1d2 pxv-10 calibri xdebug-error $theme custom-error-pane">
            $res
            <div class="box-full rad-5 pxv-10 err-wrapper" data-err="x-debug">
                <div class="err-header">
                    <div class="error-name in-flex mid"> <span class="err-btns span-btns rad-r pxv-6" style="color:$errcolor"> <span class="bi-exclamation-circle box px-20"></span> <span>$error</span></span> </div>
                    $addErrFile
                    <div class="error-desc font-menu font-em-d75 mvt-10 pxv-6 bc-white-d rad-5">$emessage</div>
                </div>
                <div class="Trace pxv-10 stack-trace"> 
                    <div class="bold font-em-d8 mvt-10 flex-full">
                        <div class="flex-full midv flow-hide no-wrap">
                            <span class="bi-map fb-6 mxr-10"></span> 
                            <span>
                                Stack Trace 
                                <span class="span-btns err-stack-btn stack-trace-item bc-sky-blue-d rad-r pxs-20" onclick="stack(this)">$tracesCount</span> 
                            </span>
                            <span style="margin-left:10px"> 
                                <span class="span-btns err-stack-btn opened code-block-item bc-sky-blue-d rad-r pxs-20" onclick="stack(this)">Code Block : Beta</span> 
                            </span>
                            $windowsTag
                        </div>
                    </div>
                    <div class="bold font-em-d8 flow-hide stack-debug"> 
                    <br> $tracesString $tracexString
                    </div>$tracesWindow
                    <div class="bold font-em-d8 flow-hide stack-code-debug opened" style="margin-top:20px; color:red; padding:0" >
                        $codeblock2
                        <div class="" style="background-color:white">
                            <div class="" style="padding:10px; background-color:#efefef; color: #301c79;"> $ePath </div> 
                            <div style="padding:10px; color: #e90c0c;">$codeblock</div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        Error;

        self::$addedRes = true;
        self::$err_displayed++;
        print $Error;
    }

    /**
     * Set a cli message to be displayed
     *
     * @param string $message
     * @return void
     */
    final static function cliMessage(string $message) {
        self::$cliMessage = $message;
    }

    /**
     * Format for displaying cli errors
     *
     * @param array $err
     * @return void
     */
    final static function cliDisplay(array $err){
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
    }

    /**
     * Set an array to contain error format
     *
     * @param string $error
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errTrace
     * @param string $errHandler
     * @return array
     */
    final protected static function buildErrors($error, $errstr, $errfile, $errline, $errTrace = [], $errHandler = 'Error') : array{
        $err = [
            'error'    => $error,
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => $errTrace,
            'handler'  => 'Error'
        ];
        return $err;
    }

    /**
     * Format error traces into block lists
     *
     * @param array $traces
     * @return string
     */
    final protected static function handleTraces($traces) : string {
        
        if(!is_array($traces)) return '';

        $tracer = '';
        
        foreach($traces as $trace => $traceval){
            $tracer .= ''; $caller = '';

            $file  = $traceval['file']  ?? '';
            $func  = $traceval['function']  ?? '';
            $type  = $traceval['type']  ?? '';
            $class = $traceval['class'] ?? '';
            
            if($class && $func){
                $caller = '<div class="fn-track"><span>'.$class.$type.$func.'()</span></div>';
            }else if($func){
                $caller = '<div class="fn-track"><span>'.$func.'()</span></div>';
            }

            if($file){
                $tracer .= '<div class="pxv-10 err-stack-division">
                    <div class="flex no-wrap midv"> 
                        <span class="span-btns err-stack-line flex mid">'.$traceval['line'].'</span>
                        <span class="flex flow-x no-wrap midv">'.self::toArrows($traceval['file']).'</span>
                    </div>
                    '.$caller.'
                </div>';
            }



            if(isset($traceval['call'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r mvt-10">Called: '.$traceval['call'].'</div>';
            }

            //$tracer .= "<br>";

        }

        return $tracer;

    }

    /**
     * Convert url to navigation format
     *
     * @param string $url 
     * @param string $fontSize
     * @return string
     */
    final protected static function toArrows(string $url = '', $fontSize = 'font-em-d8') : string {
        $root = str_replace("/","\\",$_SERVER['DOCUMENT_ROOT']);
        $errfile = ltrim(str_ireplace($root, '', $url),'\\');
        $arrowurl = str_ireplace('\\', ' <span class="'.self::$pathicon.' '.$fontSize.'"></span>', $errfile);
        return $arrowurl;
    }

    /**
     * Define error handler or exception handler to include file information
     *
     * @param string|boolean $bool 
     *  - string $bool filename to be searched in errors
     *  - bool(true) $bool add default filename detected
     *  - bool(false) $bool ignore any filename detected
     * @return void
     */
    final public static function addFile(string|bool $bool = true){
        self::$addfile = $bool;
    }

    /**
     * Include file information if allowed through ErrorHandler::addFile() method
     *
     * @param string $message
     * @param string $errfileInfo
     * @return string
     */
    final protected static function filterTraces(string $message, string $errfileInfo = '') : string {

        if(self::$addfile) $message .= $errfileInfo;

        return $message;

    }

    /**
     * Fetch file lines where error occured in file
     *
     * @param string $errorFile
     * @param integer $errorLine
     * @param integer $backwards number of lines backward
     * @param integer $forwards number of lines forward
     * @return string
     */
    final protected static function fetchContent(string $errorFile, int $errorLine, int $backwards = 3, int $forwards = 3) : string {
        
        // Get error file ...
        $contents = htmlentities(file_get_contents($errorFile));

        $lines = explode("\n", $contents);
        $totalLines = count($lines);
        $indexLines = [];

        //reset index for lines
        array_map(function($val, $key) use(&$indexLines) {
            $indexLines[$key + 1] = $val;
        }, $lines, array_keys($lines));

        //set error display lines from error line
        $elines = self::getLines($errorLine, $backwards, $forwards);
        $errorLines = count($elines);
        $valueLine = '';

        // get closest upwards line with a real value
        for($i = ($errorLine - 1); $i > 0; $i--){
            //get line with value ... 
            $lineText = $indexLines[$i];
            $lineTrim = ltrim($lineText, ' ');
            $lineTrim = ltrim($lineTrim, ' ');
            $singleComment = substr($lineTrim, 0, 1) === '#';
            $doubleComment = substr($lineTrim, 0, 2) === '//';
            $valueLine = $i;
            if((!$singleComment && !$doubleComment && $lineTrim)){
                $valueLine = $i;
                break;
            }
        }

        $codeblock = ''; 
        $addedLine = false; //divider
        $counter = 1;
        $firstLine = '';

        foreach($elines as $eline){

            if(is_int($valueLine)){

                $dist = $errorLine - $valueLine;

                // Prepend Divider
                if($dist > 2 && !$firstLine && !$codeblock){
                    if($eline >= $valueLine){
                        $codeblock .= "\n";
                        $codeblock .= $valueLine.'. '.$indexLines[$valueLine];
                        $codeblock .= "\n\n";
                        $codeblock .= '<div style="border-bottom:dotted"></div>';
                    }
                }

                // Add text line 
                if((($currentDist = ($errorLine - $eline)) <= 0) || ($dist <= 2)) {
                    $textString = $indexLines[$eline] ?? '';
                    $textTrimmed = trim($textString);
                    
                    if(($dist <= 2)){
                        if($textTrimmed && !$firstLine){
                            $firstLine = true;
                            if($currentDist === 0) {
                                $codeblock .= "\n";
                                $codeblock .= '<span class="font-em-1d5" style="color:red">'.($eline).'.   '.(ltrim($textString, ' ')).'</span>';
                            }else{
                                $codeblock .= "\n";
                                $codeblock .= $eline.'. '.$indexLines[$eline];
                            }
                        } else if($firstLine) {
                            if($currentDist === 0) {
                                $codeblock .= "\n";
                                $codeblock .= '<span class="font-em-1d5" style="color:red">'.($eline).'.   '.(ltrim($textString, ' ')).'</span>';
                            }else{
                                if(isset($indexLines[$eline])){
                                    $codeblock .= "\n"; // deal with line
                                    $codeblock .= $eline.'. '.$indexLines[$eline];
                                }
                            }
                        }
                    }else{
                        if($currentDist === 0) {
                            $codeblock .= "\n";
                            $codeblock .= '<span class="font-em-1d5" style="color:red">'.($eline).'.   '.(ltrim($textString, ' ')).'</span>';
                        }else{
                            $codeblock .= "\n";
                            $codeblock .= $eline.'. '.$indexLines[$eline];
                        }
                    }
                }

            }
            
        }
        
        $codeblock = '<pre style="font-family: firacode; font-weight: normal; color: #614dab;">'.$codeblock."\n".'</pre>';

        return $codeblock;
    } 

    /**
     * Fetch all available errors
     *
     * @return void
     */
    public static function getErrors() : array {
        $errs = self::$errs;
        $ErrorExceptions = self::$ErrorExceptions;

        if($errs && !$ErrorExceptions) return $errs;
        if(!$errs && $ErrorExceptions) return $ErrorExceptions;

        $merge = array_unique(array_combine($errs, $ErrorExceptions));

        return $merge;
    }

    private static function getLines($number, $backwards, $forwards) : array {
        $lines = [];
        //count backward
        for($i = $number - 1; $i >= 0 && $i >= $number - $backwards; $i--){
          $lines[] = $i;
        }

        for($i = $number; $i < $number + $forwards; $i++){
          $lines[] = $i;
        }

        sort($lines);
        return $lines; 
    }

}

set_error_handler([ErrorHandler::class,'handleErrors']);
set_exception_handler([ErrorHandler::class,'handleExceptions']);

require_once 'secure.php';
?>