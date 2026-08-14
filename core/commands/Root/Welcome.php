<?php 

namespace spoova\mi\core\commands\Root;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

/**
 * This class provides an interface for calibrating the 
 * project application. It helps developers to determine the 
 * type of project logic that can be applied.
 */
class Welcome {

    protected string $ProjectPath;

    function __construct(string $ProjectPath)
    {
        $this->ProjectPath = $ProjectPath;

    }

    function window(string $fileName, string $logic) : string {

        return ($logic === 'standard')? $this->standardLogic($fileName) : $this->basicLogic($fileName);

    }

    /**
     * Set standard logic for file name
     *
     * @param string $fileName
     * @return void
     */
    function standardLogic(string $fileName){

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

    function basicLogic(string $fileName){

        return <<<CONTENT
        <?php

        namespace spoova\mi\windows\Routes;
        
        use Route;
        
        class $fileName extends Route {
            
            public function __construct(){
        
                if(self::isIndex(\$this)){
        
                    self::call(\$this, [
            
                        lastCall() => 'root',
                    
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
    
    function template() : string {

        $content = <<<CONTENT
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            @meta('dump')
            @load('headers')
            @load('animateCSS')
            <title>{{ \$title ?? 'Hello!'}}</title>
            @live
            <style>
                /* The welcome page carries its own styling so that a new project renders
                   correctly before any project stylesheet has been written. */
                :root{
                    --ink        : #eef1ff;
                    --ink-soft   : #9aa4d2;
                    --accent     : #f0883e;
                    --accent-2   : #5aa9ff;
                    --ring       : rgba(90,169,255,.30);
                    --panel      : rgba(255,255,255,.045);
                    --panel-line : rgba(255,255,255,.09);
                    --code-line  : #202942;
                    --mark-bg    : #0a081e;
                    --mark-pad   : 14px;
                    /* the disc, not the roller — the roller is this less the padding */
                    --logo       : 150px;
                }

                *,*::before,*::after{ box-sizing:border-box; }

                body{
                    margin:0;
                    min-height:100vh;
                    display:grid;
                    place-items:center;
                    padding:2rem 1.25rem;
                    background:#0a0f2b;
                    /* two soft lights over a deep base, so the panel has something to sit on */
                    background-image:
                        radial-gradient(ellipse 80% 60% at 50% -10%, rgba(90,169,255,.20), transparent 60%),
                        radial-gradient(ellipse 60% 50% at 85% 110%, rgba(240,136,62,.14), transparent 60%);
                    color:var(--ink);
                    font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;
                    -webkit-font-smoothing:antialiased;
                }

                .stage{
                    width:100%;
                    max-width:560px;
                    text-align:center;
                    user-select:none;
                }

                /* ---- the rolling icon ---- */

                /* The padding is what sets the roller in from the edge of the disc. Both
                   layers are stacked in the one grid cell rather than being positioned
                   absolutely, because an absolute inset:0 resolves against the padding
                   box and would spill back over that inset. */
                .mark{
                    position:relative;
                    width:var(--logo);
                    height:var(--logo);
                    margin:0 auto 2rem;
                    padding:var(--mark-pad);
                    display:grid;
                    place-items:center;
                    background-color:var(--mark-bg);
                    border-radius:100vh;
                }

                /* the ring rolls; the crest inside it must not, so they stay separate layers */
                .mark-ring{
                    grid-area:1/1;
                    width:100%;
                    height:100%;
                    border-radius:50%;
                    background-repeat:no-repeat;
                    background-position:center;
                    background-size:contain;
                    opacity:.92;
                    filter:drop-shadow(0 0 18px var(--ring));
                }

                .mark-crest{
                    grid-area:1/1;
                    width:44%;
                    height:44%;
                    background-repeat:no-repeat;
                    background-position:center;
                    background-size:contain;
                }

                /* A quiet halo that breathes, to keep the mark alive while the ring turns.
                   The disc is opaque, so this now reads as a glow around it rather than
                   behind it — which is why it is inset negatively. */
                .mark::after{
                    content:"";
                    position:absolute;
                    inset:-18%;
                    border-radius:50%;
                    background:radial-gradient(circle,var(--ring),transparent 70%);
                    animation:pulse 3.2s ease-in-out infinite;
                    z-index:-1;
                }

                @keyframes pulse{
                    0%,100%{ transform:scale(.92); opacity:.45; }
                    50%    { transform:scale(1.06); opacity:.85; }
                }

                /* ---- wordmark ---- */

                .greeting{
                    font-size:.95rem;
                    letter-spacing:.14em;
                    text-transform:uppercase;
                    color:var(--ink-soft);
                    margin:0 0 .55rem;
                }

                .greeting b{ color:var(--accent); font-weight:600; }

                .wordmark{
                    margin:0;
                    font-size:clamp(2.6rem,11vw,4.2rem);
                    font-weight:800;
                    letter-spacing:.02em;
                    line-height:1;
                    background:linear-gradient(100deg,var(--accent-2),#c9d8ff 55%,var(--accent));
                    -webkit-background-clip:text;
                    background-clip:text;
                    color:transparent;
                }

                .tagline{
                    margin:.85rem 0 0;
                    font-size:.98rem;
                    color:var(--ink-soft);
                }

                /* ---- status ---- */

                .status{
                    display:inline-flex;
                    align-items:center;
                    gap:.5rem;
                    margin-top:1.6rem;
                    padding:.42rem .95rem;
                    font-size:.83rem;
                    border-radius:999px;
                    border:1px solid var(--panel-line);
                    background:var(--panel);
                    color:var(--ink-soft);
                }

                .status .dot{
                    width:7px;
                    height:7px;
                    border-radius:50%;
                    background:#3ddc97;
                    box-shadow:0 0 0 3px rgba(61,220,151,.18);
                }

                .status.is-idle .dot{ background:var(--ink-soft); box-shadow:none; }

                /* ---- next steps ---- */

                .steps{
                    margin:2.4rem auto 0;
                    padding:1.1rem 1.25rem;
                    max-width:420px;
                    text-align:left;
                    border:1px solid var(--panel-line);
                    border-radius:14px;
                    background:var(--panel);
                }

                .steps-title{
                    margin:0 0 .7rem;
                    font-size:.72rem;
                    letter-spacing:.16em;
                    text-transform:uppercase;
                    color:var(--ink-soft);
                }

                .steps ul{ margin:0; padding:0; list-style:none; }

                .steps li{
                    display:flex;
                    gap:.6rem;
                    padding:.3rem 0;
                    font-size:.87rem;
                    color:var(--ink-soft);
                }

                .steps code{
                    font-family:ui-monospace,SFMono-Regular,Consolas,monospace;
                    font-size:.85em;
                    color:var(--accent-2);
                    white-space:nowrap;
                    /* the padding and radius are what stop the border sitting hard against
                       the glyphs — the border alone reads as a box drawn round the text */
                    padding:.14em .45em;
                    border:solid 1px var(--code-line);
                    border-radius:5px;
                }

                @media (prefers-reduced-motion:reduce){
                    .ico-spin,.mark::after{ animation:none !important; }
                }
            </style>
        </head>
        <body>
            <main class="stage animate__animated animate__fadeIn">

                <div class="mark">
                    <div class="mark-ring ico-spin" data-src="@mapp('images/icons/favicon-white-full.png')" data-lqip="@lqip()"></div>
                    <div class="mark-crest" data-src="@mapp('images/icons/S.png')" data-lqip="@lqip()"></div>
                </div>

                <p class="greeting"><b>Hello!</b> &mdash; welcome aboard</p>

                <h1 class="wordmark">SPOOVA</h1>

                <p class="tagline">Your application is up and running.</p>

                <div class="status {{ spoovaLoaded('','is-idle') }}">
                    <span class="dot"></span>
                    <span>{{ spoovaLoaded('app connected','awaiting configuration') }}</span>
                    <span class="bi bi-check" @onShow('spoovaLoaded', 'true')></span>
                </div>

                <section class="steps">
                    <p class="steps-title">Next steps</p>
                    <ul>
                        <li>&rsaquo; <span>Edit this view in <code>windows/Rex/index.rex.php</code></span></li>
                        <li>&rsaquo; <span>Add a route with <code>mi add:route &lt;name&gt; --live</code></span></li>
                        <li>&rsaquo; <span>Configure the app with <code>mi config:all</code></span></li>
                    </ul>
                </section>

            </main>
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
                @load('404') <!-- load only 404 resources -->
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
            $Filemanager = new Filemanager;

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