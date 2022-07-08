<?php

class ErrorHandler extends Exception{

    public static $pathicon = 'bi-chevron-right';

    private static $exceptions = [
        'Error'   => E_ERROR,
        'ParseError' => E_PARSE,
    ];

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
        self::display($err);
    }

    /**
     * Handle all simple errors (Warning / Notice)
     *
     * @param [type] $errno
     * @param [type] $errstr
     * @param [type] $errfile
     * @param [type] $errline
     * @return void
     */
    static function handleErrors($errno, $errstr, $errfile, $errline) {
        $err = [
            'error'    => self::$errors[$errno],
            'message'  => $errstr,
            'errfile'  => $errfile,
            'errline'  => $errline,
            'errtrace' => '',
            'handler'  => 'Error'
        ];
        self::display($err);
    }

    static function display(array $err){

        $root = str_replace("/","\\",$_SERVER['DOCUMENT_ROOT']);
        $errfile = self::toArrows($err['errfile']);
        $errline = $err['errline'];
        $errTrace = $err['errtrace'];
        $errTraces = is_array($err['errtrace'])? count($err['errtrace']) : 0;
        $errlower = (strtolower($err['error']));
        $errcolor = $errlower === 'warning'? '#d26d13' : 'rgb(217, 26, 26)';

        $res = '
            <script x-debug="res-js" src="'.Domurl("res/main/js/debug.js").'"></script>      
            <link x-debug="res-css" rel="stylesheet"  href="'.rtrim(Domurl("res/main/css/res.css")).'" />        
        ';
        if(self::$err_displayed == self::$err_displays) return;
        if(self::$addedRes) $res = '';

        $body = ' 
        
            <div class="font-em-1d2 pxv-10 calibri xdebug-error custom-error-pane">
                '.$res.'
                <div class="mox-full bc-off-white rad-5 pxv-10 bc-sky-blue-dd c-white">
                    <div class="err-header">
                        <div class="error-name in-flex mid"> <span class="span-btns bc-white-d rad-r pxv-6 c-red-d" style="color:'.$errcolor.'"> <span class="bi-exclamation-circle mox px-20"></span> <span>'.ucfirst(strtolower($err['error'])).'</span></span> </div>
                        <div class="error-track pxv-10"> '.$errfile.' <span class="span-btns fb-6 pxv-2 pxs-10 bc-white-d rad-r c-sky-blue-dd"> '.$errline.' </span> </div>
                        <div class="error-desc font-menu font-em-d75 mvt-10 pxv-6 bc-white-d rad-5 c-silver-dd">'.$err['message'].' in <span class="mox fb-6 rad-r">'.basename($err['errfile']).'</span> on line '.$errline.'</div>
                    </div>
                    <div class="Trace pxv-10 stack-trace"> 
                        <div class="bold font-em-d8 mvt-10 flex-full">
                            <div class="flex-full midv">
                                <span class="bi-map fb-6 mxr-10"></span> 
                                <span>Stack Trace 
                                    <span class="span-btns bc-sky-blue-d rad-r pxs-20 c-white" style="border: solid 2px #70aac1; box-shadow: 0 0 0 2px #44869f inset; background-color: rgb(87, 146, 170);">'.$errTraces.'</span> 
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

        $body = str_replace(': eval()\'d code', '',$body);
        print $body;
    }

    private static function handleTraces($traces){
        
        if(!is_array($traces)) return '';

        $tracer = '<br>';
        
        foreach($traces as $trace => $traceval){
            $tracer .= '';
            if(isset($traceval['file'])){
                $tracer .= '<div class="pxv-10 rad-r bc-sky-blue">'.self::toArrows($traceval['file']).' <span class="span-btns bc-white c-sky-blue-dd rad-r pxs-20">'.$traceval['line'].'</span></div>';
            }

            if(isset($traceval['class'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r">Class: '.$traceval['class'].'</div>';
            }

            if(isset($traceval['function'])) {
                $tracer .= '<div class="pxs-10 pvs-4 rad-r">Function: '.$traceval['function'].'</div>';
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

}

if(php_sapi_name() != 'cli'){
 set_error_handler([ErrorHandler::class,'handleErrors']);
 set_exception_handler([ErrorHandler::class,'handleExceptions']);   
}


require_once 'secure.php';
?>