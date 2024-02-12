<?php 

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\FileManager;

class Welcome {

    protected $ProjectPath;

    function __construct($ProjectPath)
    {
        $this->ProjectPath = $ProjectPath;

    }

    function window($fileName, $logic) : string {


        return ($logic === 'standard')? $this->standardLogic($fileName) : $this->basicLogic($fileName);

    }

    function standardLogic($fileName){

        return <<<CONTENT
        <?php

        namespace spoova\mi\windows\Routes;
        
        use Window;
        
        class $fileName extends Window {
            
            public function __construct(){
        
                self::call(\$this,
                    [
                        window('root') => 'root'
                    ]
                );  
        
            }
        
            function root() {
        
                \$title = ['title' => 'Hello! Spoova'];
        
                self::load('index', fn() => compile(\$title) );
                
            }
        
        }
                

        CONTENT;

    }

    function basicLogic($fileName){

        return <<<CONTENT
        <?php

        namespace spoova\mi\windows\Routes;
        
        use Route;
        
        class $fileName extends Route {
            
            public function __construct(){
        
                if(self::isIndex(\$this)){
        
                    self::call(\$this, [
            
                        lastUrl() => 'root',
                    
                    ]);
        
                } else {
    
                    if(!self::callRoute(window('root'))) self::close();
    
                }
        
            }
        
            function root() {
        
                \$title = ['title' => 'Hello! Spoova'];
        
                self::load('index', fn() => compile(\$title) );
                
            }
        
        }

        CONTENT;
    }

    function logic3(){

    }

    function template() : string {

        $content = <<<CONTENT
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            @meta('dump')
            @load('headers')
            @load('animateCSS')
            <title>{{ \$title ?? 'Hello!'}}</title>
            @live
            <style> 
                :root {
                    --em-2 : 2em;
                }           
                body{
                    font-size: 10px;
                    transition: font .2s;
                }
                .overlay{
                    z-index: 1; 
                    color:#202dd5; 
                    color:white; 
                }
                .px-80 {
                    width: var(--em-2);
                    height: var(--em-2);
                }
                .ct-1{
                    color:847b95;
                }
                @media (min-width:1000px) {
                    body{
                        font-size: initial;
                    }
                }
            </style>
        </head>
        <body>
            <div class="centre vhm-full bc-deeper-blue-dd fb-6 font-em-3 c-white">
                
                <div class="in-flex pxv-10 no-select">
                <div class="in-flex midv">
                        <div class="">
                            <span class="c-orange">Hello!</span> 
                            <span class="{{ spoovaLoaded('c-sea-blue','ct-1') }}">From</span> 
                        </div>
                        <div class="animate__animated animate__rubberBand flex-icon mxs-10 mid pxv-10 theme-btn box bd bd-silver rad-r anc-btn-link flow-hide bc-deeper bc-deeper-blue ripple relative">
                                <div class="flex px-80 bc-deeper-blue-dd rad-r">
                                    <div class="rad-r px-full bc-deeper-blue-dd b-cover ico-spin" data-src="@mapp('images/icons/favicon-white-full.png')"></div>
                                    <div class="overlay flex mid">
                                        <div class="px-30 b-fluid" data-src="@mapp('images/icons/S.png')"></div>
                                    </div>
                                </div>
                        </div>
                        <div href="@Domurl()" class="in-flex f-col">
                            <div class="flex midv fb-9 font-menu font-em-1d2 {{ spoovaLoaded('c-sea-blue','ct-1') }}">POOVA</div>
                            <div class="font-em-d2 absolute pxs-6 c-sky-blue" @onShow('spoovaLoaded', 'true')>app connected <span class="bi bi-check"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        CONTENT;

        return $content;

    }

    function e404() : string{

        return <<<CONTENT
        <!DOCTYPE html>
        <html>
             <head> 
                   @load('headers') <!-- load only 404 resources -->
                <title>404 Error Page</title>
                <link rel="shortcut icon" href="@mapp('images/icons/favicon.png')" type="image/x-icon">
                <style>
                    body{
                     background-color: #431670;
                    }
                    img{
                        transition: width .5s ease-in-out, height .5s ease-in-out;
                    }
                    .grid-center{
                        display: grid;
                        place-items:center;
                    }
                    @media (min-width: 1025px){
                        img{
                            width: 70%;
                            height: 100%;
                        }
                    }
                </style>
            </head> 
            <body>
                <div class="box-full">
                    <div class="grid-center vh-full">
                        <div class="inner grid-center rad-2" style="min-width:320px; color: black;">
                            <img src="@mapp('images/404.png') ?>" height="100%" width="100%" alt="404 error">
                        </div>
                    </div>
                 </div>  
            </body>
        </html>
        CONTENT;

    }

    function installer() {

        $content = <<<CONTENT
        <?php

        namespace spoova\mi\windows\Routes;

        use Installer;
        use Route;

        class Install extends Route{


            function __construct()
            {
                include_once(_core.'installer.php');
        
                \$Install = new Installer;
                \$Install->install();
                print \$Install->content();
            }


        }

        CONTENT;

        return $content;

    }

    function build(array $options = []) {

        $ProjectPath = $this->ProjectPath;

        $entryFile  = ucfirst($options['entry_file']);
        $baseLogic  = $options['logic'];
        
        $indexContent = $this->window($entryFile, $baseLogic);

        $tempContent = $this->template();
        $errorContent = $this->e404();
        $installer = $options['installer'];
        $installer   = $installer ? $this->installer() : '';

        if(is_dir($ProjectPath)) {

            //delete docs from new project
            $Filemanager = new FileManager;

            $removals = ['Rex', 'Routes'];

            foreach($removals as $removal) {

                $path = $ProjectPath.'/windows//'.$removal;
                if( is_dir($path) )  {
                    $Filemanager->deleteFile($path); // delete file or entire directory
                    $Filemanager->addDir($path);
                }

            }

            $resRemovals = ['css','images','video'];
            
            foreach($resRemovals as $removal){
    
                $path = $ProjectPath.'/res/assets/'.$removal;

                if(is_dir($path)){
                    if($Filemanager->deleteFile($path) && ($removal !== 'video')){
                        $Filemanager->addDir($path);
                    }
                }

            }

            //Create a new File
            $indexPath = $ProjectPath.'/windows/Routes/'."$entryFile.php";
            $installPath = $ProjectPath.'/windows/Routes/'.'Install.php';
            $tempPath = $ProjectPath.'/windows/Rex/'.'index.rex.php';
            $errorPath = $ProjectPath.'/windows/Rex/errors/'.'404.rex.php';

            $openFiles = [$indexPath, $tempPath, $errorPath];
            if($installer) $openFiles[] = $installPath; //add installer file

            if($Filemanager->openFiles($openFiles)) {

                file_put_contents($indexPath, $indexContent);   
                if($installer) file_put_contents($installPath, $installer);
                
                //create a new index rex template file
                file_put_contents($tempPath, $tempContent);

                //add a 404 error rex template file
                file_put_contents($errorPath, $errorContent);

            }

        } 

        return false;

    }

}