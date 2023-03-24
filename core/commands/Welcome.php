<?php 

namespace spoova\mi\core\commands;

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
        
        use Window;
        
        class $fileName extends Window {
            
            public function __construct(){
        
                if(self::isIndex(\$this)){
        
                    self::call(\$this, [
            
                        window('root') => 'root',
                    
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
            @Res(':headers')
            @Res('res/assets/css/animate.min.css')
            <link rel="import" href="component.html">
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
                                    <div class="font-em-1d2 flex mid px-full center overlay fb-9 nunito fb-9">
                                        <span class="relative" style="top:-.12em">S</span>
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

    function installer() {

        $content = <<<CONTENT
        <?php

        namespace spoova\mi\windows\Routes;

        use Installer;
        use Window;

        class Install extends Window{


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
        $installer = $options['installer'];
        $installer   = $installer ? $this->installer() : '';

        if(is_dir($ProjectPath)) {

            //delete docs from new project
            $Filemanager = new FileManager;

            $removals = ['Rex', 'Routes'];

            foreach($removals as $removal) {

                $path = $ProjectPath.'/windows//'.$removal;
                if( is_dir($path) )  $Filemanager->deleteFile($path);
                $Filemanager->addDir($path);

            }

            //Create a new File
            $indexPath = $ProjectPath.'/windows/Routes/'."$entryFile.php";
            $installPath = $ProjectPath.'/windows/Routes/'.'Install.php';
            $tempPath = $ProjectPath.'/windows/Rex/'.'index.rex.php';

            $openFiles = [$indexPath, $tempPath];
            if($installer) $openFiles[] = $installPath; //add installer file

            if($Filemanager->openFiles($openFiles)) {

                file_put_contents($indexPath, $indexContent);   
                if($installer) file_put_contents($installPath, $installer);
                
                //create a new index rex template file
                file_put_contents($tempPath, $tempContent);

            }

        } 

        return false;

    }

}