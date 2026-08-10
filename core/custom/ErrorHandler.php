<?php

use spoova\mi\core\classes\Ajax;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\ErrorHandlers\ErrorBridge;
use spoova\mi\core\classes\ErrorHandlers\HandleErrors;
use spoova\mi\core\classes\ErrorHandlers\HandleExceptions;
use spoova\mi\core\classes\ErrorHandlers\HandleShutdown;
use spoova\mi\core\classes\ErrorHandlers\HandleTemplate;
use spoova\mi\core\classes\Init;
use spoova\mi\core\classes\SETTER;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliState;

class ErrorHandler extends Exception{

    protected static string $HANDLER  = '';
    public static string $pathicon = 'bi-chevron-right';

    protected static array $errs = [];
    protected static array $ErrorExceptions = [];
    protected static array $backTrace = [];
    protected static array $backTraceError = [];

    protected static array $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

    protected static string $cliMessage = '';

    protected const errors = [
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
        // E_STRICT          => "Strict", //2048
        E_RECOVERABLE_ERROR => "Notice", //4096
        E_DEPRECATED      => "Deprecated",//8192
        E_USER_DEPRECATED => "User Deprecated", //16384 
        E_ALL             => "All Errors", //32767
    ];

    //* define resource loading
    protected static bool $addedRes = false;

    /**
     * allowed number of error displays
     *
     * @var null|integer NULL allows all errors to be displayed while integer (e.g 1) specifies the total number of allowed error displays
     */
    protected static $err_displays = null;

    //* total number of errors already displayed
    protected static int $err_displayed = 0;

    /**
     * Determines if filename is added to errors
     *
     * @var string|boolean
     */
    protected static string|bool $addfile = true; //error file
    
    /**
     * Fatal Errors (Exceptions)
     *
     * @return void
     */
    public static function handleExceptions(?Throwable $e = null){
        new HandleExceptions($e);
    }

    /**
     * Fatal Errors (Template Exceptions)
     *
     * @return void
     */
    public static function handleTemplate(?Error $e = null){
        new HandleTemplate($e);
    }

    /**
     * Handle all simple non-fatal errors (Warning / Notice)
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public static function handleErrors(int $errno, string $errstr, string $errfile, int $errline) {
        if(!(error_reporting() & $errno)){
            return false; // respect supression
        }
        new HandleErrors(...func_get_args());
    }

    /**
     * Handle all compile errors (Warning / Notice)
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public static function handleShutdown(int $errno, string $errstr, string $errfile, int $errline) {
        new HandleShutdown(...func_get_args());
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
     * Set an array to contain error format
     *
     * @param string $error
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errTrace
     * @param string $errHandler optional [Error|Exception]
     * @param array $backTrace should be supplied if a backtrace key is required in returned array.
     * @return array
     */
    final protected static function buildErrors($error, $errstr, $errfile, $errline, $errTrace = [], $errHandler = 'Error', $backTrace = []) : array{
        $err = [
            'error'    => $error,
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => $errTrace,
            'handler'  => $errHandler,
        ];
        if(func_num_args() > 6) $err['backtrace'] = $backTrace;
        return $err;
    }

    /**
     * Format error traces into block lists
     *
     * @param array $traces
     * @param int $count number of traces desired
     * @return string
     */
    final protected static function handleTraces($traces, ?int &$counts = 0) : string {
        
        if(!is_array($traces)) return '';

        $tracer = ''; $counts = 0;
        
        foreach($traces as $trace => $traceval){
            $tracer .= ''; $caller = '';

            $file  = $traceval['file']  ?? '';
            $func  = $traceval['function']  ?? '';
            $type  = $traceval['type']  ?? '';
            $class = $traceval['class'] ?? '';
            
            if($class && $func){
                $caller = '<div class="fn-track"><div><span>'.$class.$type.$func.'()</span></div></div>';
            }else if($func){
                $caller = '<div class="fn-track"><div><span>'.$func.'()</span></div></div>';
            }

            if($file){
                $counts++;
                $traceval_line = $traceval['line'];
                
                $traceval_line = str_replace(['\\', ":"],['<i class="middot"></i>',"::"], $traceval_line);
                $tracer .= '
                <div class="err-stack-division">
                    <div class="flex no-wrap"> 
                    <span class="span-btns err-stack-line flex mid">'.$traceval_line.'</span>
                    <span class="flex flow-x no-wrap midv">'.self::toArrows($file).'</span>
                    </div>
                    '.$caller.'
                </div>
                ';
            }



            if(isset($traceval['call'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r mvt-10">Called: '.$traceval['call'].'</div>';
            }

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
     *  - string: filename to be searched in errors
     *  - TRUE: add default filename detected
     *  - FALSE: ignore any filename detected
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

        $contents = str_replace("\r\n","\n", $contents);
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
            $lineText = $indexLines[$i] ?? $errorLine;
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
        $firstLine = '';
        $lineblock = '';
        
        foreach($elines as $eline){

            if(is_int($valueLine)){

                $dist = $errorLine - $valueLine;

                // Prepend Divider
                if($dist > 2 && !$firstLine && !$codeblock){
                    if($eline >= $valueLine){
                        $codeblock .= "\n";
                        $codeblock .= ' '.$indexLines[$valueLine];
                        $lineblock .= '<div class="code-line"><pre class="code-line">'.$valueLine.'+</pre></div>';
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
                                $codeblock .= '<span class="code-line">   '.(ltrim($textString, ' ')).'</span>';
                                $lineblock .= '<div class="code-line"><pre class="code-line">'.$eline.'.</pre></div>';
                            }else{
                                $codeblock .= "\n";
                                $codeblock .= ' '.$indexLines[$eline];
                                $lineblock .= '<div class="code-line"><pre class="code-line">'.$eline.'.</pre></div>';
                            }
                        } else if($firstLine) {
                            if($currentDist === 0) {
                                $codeblock .= "\n";
                                $codeblock .= '<span class="code-spot">   '.(ltrim($textString, ' ')).'</span>';
                                $lineblock .= "<div class=\"code-spot\"><pre class=\"code-spot\">$eline.</pre></div>";
                            }else{
                                if(isset($indexLines[$eline])){
                                    $codeblock .= "\n"; // deal with line
                                    $codeblock .= ' '.$indexLines[$eline];
                                    $lineblock .= '<div class="code-line"><pre class="code-line">'.$eline.'.</pre></div>';;
                                }
                            }
                        }
                    }else{
                        if($currentDist === 0) {
                            $codeblock .= "\n";
                            $codeblock .= '<span class="code-spot">   '.(ltrim($textString, ' ')).'</span>';
                            $lineblock .= "<div class=\"code-spot\"><pre class=\"code-spot\">$eline.</pre></div>";
                        }else{
                            $codeblock .= "\n";
                            $codeblock .= ' '.$indexLines[$eline];
                            $lineblock .= '<div class="code-line"><pre class="code-line">'.$eline.'.</pre></div>';;
                        }
                    }
                }

            }
            
        }
        
        $codeblock = '<div class="flex f-col">'.$lineblock.'</div><pre>'.$codeblock."\n".'</pre>';

        return $codeblock;
    } 

    /**
     * Fetch all available errors
     *
     * @return array
     */
    public static function getErrors() : array {
        $errs = self::$errs;
        $ErrorExceptions = self::$ErrorExceptions;

        if($errs && !$ErrorExceptions) return $errs;
        if(!$errs && $ErrorExceptions) return $ErrorExceptions;

        $merge = array_unique(array_combine($errs, $ErrorExceptions));

        return $merge;
    }

    private static function getLines(int $number, int $backwards, int $forwards) : array {
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

    /**
     * Format throwable errors
     *
     * @param Throwable $e
     * @param string $error error type (or name)
     * @param array $backTrace
     * @return array keys returned are [error, message, errfile, errline, errtrace, handler, backtrace]
     */
    protected static function formatThrowable(Throwable $e, string $error, $backTrace = []) : array {
       return self::buildErrors($error, $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTrace(), $error, $backTrace);
    }

    protected static function resource(string $type, string $path){
        if($type === 'design') return '<link rel="stylesheet" type="text/css" href="'.dompath(realpath(domroot($path))).'">';
        if($type === 'script') return '<script src="'.dompath(realpath(domroot($path))).'" type="module"></script>';
    }
    
    private static function normalizePath(string $path){
        $path = str_replace('\\','/', $path);
        if(preg_match('#^[A-Za-z]:[^/]#', $path, $matches)){
            $path = substr($path, 0, 2).'\\'.substr($path, 2);
        }
        return str_replace('/','\\', $path);
    }

    /**
     * Display error on web page
     *
     * @param array $e entire list of error information
     * @param string $error type of error (e.g warning, notice, fatal)
     * @param string $message error message
     * @param string $efile error file
     * @param string $eline error line
     * @param array $traces debug backtrace
     * @param array $tracex (stack traces if any)
     * @param array $allTraces (smart trace)
     * @return void
     */
    final static function webdisplay(array $e, string $error, string $message, string $efile, string $eline, array $traces = [], $tracex = [], $allTraces = []) {
        
        // Resource variable
        $res = '';
        // Format error traces

        $tracesString = self::handleTraces($traces, $tracesCount);
        $tracexString = ($tracex !== $traces)? self::handleTraces($tracex, $stacksCount) : [];
        
        // Get Error Theme ... 
        // $theme = '_';
        // $theme .= Init::key('ERROR_THEME');

        // Get File content 
        $codeblock = self::fetchContent($efile, $eline, 5, 6);

        if(strpos($efile,":") !== false){
            $epos = strpos($efile, "\\") ?: strpos($efile, "/");
            if($epos !== false){
                if($epos === 1){
                    $efile = substr($efile, $epos);
                }else{
                    $efile = substr($efile, 0, $epos)."".substr($efile, $epos+1);
                }
            }
        }
        $edots = str_replace(['\\',"/",":"],[' • ',' • ',"::"], $efile);

        if($codeblock){
            $codeblock = '
            <div stack-debug="">
                <div class="code-path"><i class="bi-filetype-php"></i> '.$edots.' </div> 
                <div class="code-lines flex">'.$codeblock.'</div>
            </div>
            ';
        }

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
                $path1  = self::normalizePath(strtolower(to_dirslash($windowFile)));
                $path2  = self::normalizePath(strtolower(to_dirslash($efile)));
                $windowsCount = count($windows);
                $tracesWindow = self::handleTraces($windows);
                $tracesWindow = <<<winTraces
                <div class="window-debug error-slide">$tracesWindow</div>
                winTraces;
                $windowsTag = '
                <div class="flex gap-1 midv err-stack-btn stack-btn stack-window-btn" onclick="stack(this)">Windows <span class="err-counter">'.$windowsCount.'</span></div>
                ';
                if($path1 !== $path2){

                    $ePath2 = to_frontslash(explode(docroot.DS, $windowFile)[1] ?? '');
                    
                    $ePath2 = str_replace(['\\',"/",":"],[' • ',' • ',"::"], $ePath2);
                    $codeblock2 = self::fetchContent($windowFile, $windows[0]['line'], 5, 6);
                    $codeblock2 = '
                    <div stack-debug="">
                        <div class="code-path"><i class="bi-filetype-php"></i> '.$ePath2.' </div> 
                        <div class="code-lines flex">'.$codeblock2.'</div>
                    </div>
                    ';
                }

            }
        }

        // Get Error File Path

        $errinfo = ' thrown in <span class="box fb-6 rad-r">'.basename($efile).'</span> on line <span class="file-name">'.$eline.'</span>'; 
        $emessage = self::filterTraces($message, $errinfo);
        $econsole = self::filterTraces($message, " thrown in $efile on line $eline");

        // USe this to detect parent files where neccessary
        if(preg_match('~"([a-zA-Z$()_-]+?)"~', $emessage, $matches)){
            $key = $matches[1];
            //search for key in current line ...
            $traceReverse = array_reverse($traces); 
            $rootLine = false;
            foreach($traceReverse as $tracePath){
                if(!isset($tracePath['file'])) continue;
                if(!$rootLine && ($efile) === $tracePath['file']){
                    $rootLine = true;
                }
                if(!$rootLine) continue;
                $fPath = $tracePath['file'];
                $fLine = $tracePath['line'];

                $openFile= new SplFileObject($fPath);
                $openFile->seek($fLine - 1);
                $text = $openFile->current();
                if(strpos($text, $key) !== false){
                    $efile = $fPath;
                    $eline = $fLine;
                    break;
                }  
            }
        }


        // Load resources 
        $errlower = (strtolower($error));
        $errcolor = $errlower === 'warning'? '#d26d13' : 'rgb(217, 26, 26)';

        if(!self::$addedRes){

            Ress::new('res/main/')
            
            // # error files ... 
            ->url("css/local/debug/res.css => x-debug:res-css")->named('x-debug-css')
            ->url("js/local/debug/debug.js => x-debug:res-js;type:module")->named('x-debug-js')
            ->close();

            $res = ''; 
            if(!Ajax::isAjax()){
                Ress::no_meta();

                Ress::evoke(function() use(&$res) {
                    $res .= import('#x-debug-css');
                    $res .= import('#x-debug-js');
                    $res .= import('#popover-js');
                });


                if(SETTER::EXISTS('spoova-exception')){
                    javaconsole(recall('x-debug-css'));
                }
            }
        }

        

        //Add error file map
        if($efile){ 
            $errfile = self::toArrows($efile); 
            $addErrFile = ''.$errfile.'';
        }else{
            $addErrFile = '';
        }

        $stackBttn = $stackPane = '';

        if($stacksCount??[]){
            $stackBttn = '<div class="flex gap-1 midv b-stack stack-trace-btn stack-btn" onclick="stack(this)"> <i class="bi-map"></i>  Stack <div class="err-counter">'.$stacksCount.'</div></div>';
            $stackPane = '<div class="stack-trace error-slide"> 
                            '.$tracexString.'
                          </div>';
        }

        $DebugTitle = ($e['handler'] === 'Exception')? 'Stack Debug' : 'Debug';
        $msg = '';
        if(($DebugTitle === 'Debug') && ($tracesCount === 0)){
            $tracesCount = 1;
            $msg = ' stack-message-btn ';
        }

        $drawBtn = '
          <div class="mover" drag-btn><i class="bi-arrows-move"></i></div>
        ';

        $Error = <<<Error
        <div id="::xdebug-error" hidden class="xdebug-error custom-error-pane _black" data-err="x-debug">
            <div class="error-bind _black">
                <div hidden>( ! ) $error Error  $res</div>
                <div class="error-navs">
                    <div class="flex f-col">
                        <div class="flex error-class relative">
                            <div class="xd-err-info flex">
                                <span class="flex xd-flag midv"><i class="bi"></i>$error</span>
                                <span class="notice-id active xd-msg stack-message-btn stack-btn calibri" onclick="stack(this)">on line $eline</span>
                                <span hidden data-xdce>$econsole</span>
                            </div>
                        </div>
                        <div class="stacked-btns">
                            $stackBttn
                            <div class="flex gap-1 midv b-track stack-debug-btn$msg stack-btn" onclick="stack(this)"> $DebugTitle <div class="err-counter">$tracesCount</div></div>
                            <div class="flex gap-1 midv b-code stack-code-btn stack-btn" onclick="stack(this)">Code <sup class="">Beta</sup></div>
                            $windowsTag
                            $drawBtn
                        </div>
                    </div>
                </div>

                <div class="error-slides">
                        <div class="message-debug error-pane error-slide opened">
                            <div class="error-track"> 
                                <div class="" hidden></div>
                                <div class="">
                                    <div class="flex flow-auto midv">
                                        $addErrFile
                                    </div>
                                </div>
                            </div>
                            <div class="message-box">
                            <i class="bi-chat-dots"></i> $emessage
                            </div>
                        </div>
                    
                        <div class="stack-code-debug error-slide code-debug">
                            $codeblock2
                            $codeblock
                        </div>
                        
                        $stackPane
                        <div class="stack-debug error-slide"> 
                            $tracesString
                        </div>
                        
                        $tracesWindow
                        
                </div>

            </div>
            <div class="xe-sublist"></div>
        </div>
        Error;

        self::$addedRes = true;
        self::$err_displayed++;
        print $Error;
    }
}

set_error_handler(function (int $level, string $message, string $file = '', int $line = 0): bool {
    // Respect error suppression (e.g. the @ operator)
    if (!(error_reporting() & $level)) {
        return false;
    }

    ErrorBridge::connect([
        'type'    => $level,
        'message' => $message,
        'file'    => $file,
        'line'    => $line,
    ], 'error');

    return true;
});

set_exception_handler(function (Throwable $e): void {
    ErrorBridge::connect($e, 'exception');
});

register_shutdown_function(function (): void {

    $lastError = error_get_last();

    // Only fatal error types reach here uncaught — everything else
    // was already handled by set_error_handler() above.
    $fatalTypes = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR,
    ];

    if ($lastError !== null && in_array($lastError['type'], $fatalTypes, true)) {
        ErrorBridge::connect($lastError, 'shutdown');
    }else{
        if(isCli()) ErrorBridge::connect([], 'shutdown');
    }
});

require_once 'secure.php';
?>