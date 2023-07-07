
<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <?= Rexit::head($title ?? '') ?>
    <?= Rexit::load('headers') ?>
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: "Poppins", "Roboto", sans-serif;
     }

     .tutorial{
          min-height:100vh;
          font-family: "Poppins";
     }

     .pre-area{
          font-size: .85em;
          display: inline-block;
          width:100%;
      }

     .pre-area:not([class*="bc-"]){
          background-color : rgba(var(--white-dd));
      }
  
     .pre-area.fix {
         font-size: 1em;
    }
     
     pre.pre-code {
          overflow: auto hidden;
          font-size: .95em; 
          margin-bottom:0;
          padding-top:1.5em;
          font-family: "Firacode";
     } 
     
     pre.pre-code:not([class*="c-"]) {
          color: #4f58a0;
     } 
     
     pre .comment {
          color: #909090;
     }
  
     .lacier.active {
          background-color: #0c947b;
          color: white;
     }
  
     .lacier.active > *{
          color: white;
     }  

     ul > li > a{
          color:inherit;
     }   

     ul > li > a:hover{
          color:inherit;
     }  

     [class*="foot-note"] {
         color: rgb(32, 130, 130);
         margin-top: 10px;
         margin-bottom: 10px;
     }

     :where(.d85){
          font-size: .85em;
     }
     :where(.d87){
          font-size: .87em;
     }
     :where([class*="foot-note"]){
          font-size: .95em;
     }
     :where([class*="foot-note"] .head){
          font-weight: 600;
     }

     [class*="rule-dashed"] {
          border-bottom: dashed .1em;
     }   
   
     
     [class*="hyperlink"] {
          border-bottom: dashed .1em;
     }

     [class*="rule-dotted"] {
          border-bottom: dotted .1em;
     }

     .olist {
          font-family: calibri;
          color:#9d6216;
     }

     .control{
          right: 10px;
          top: 10px;
          opacity: 1;
          display: inline-block;
          transition: opacity .8s ease-in-out;
          z-index: 10;
      }

      .control .controller.fade-out{
          transition: transform .2s ease-in-out, opacity .3s ease-in-out ;
          transform: rotate(360deg);
      }

      .control .controller:not(.bi-x).fade-out{
          opacity: 0;
      }
      
      .blurry{
          z-index: 0;
      }

      @media (min-width: 1001px){

          .control{
               display: none;
          }

          .nav-left{
               left: 0;
          }

          .tutorial{
               width: calc(100% - 300px);
               float:right;
          }
          .blurry{
               display: none !important;
           }
     }


 </style>
<style rel="build.css.headers"> 
.--theme-dark > * {
   --white-dd: 11, 10, 28;
   --white:  21, 15, 39;
   --off-white: 22, 23, 62;
   --black-ll: 179, 179, 179; 
   --silver: 23, 28, 56;       
   --silver-d: 21, 25, 49;       
   --silver-dd: 23, 28, 56;       
}

.--theme-dark .--theme-esc{
   --white-dd: 240, 240, 240;
   --white:  255, 255, 255;
   --black-ll: 79, 79, 79;
}

.--theme-dark .bc-white-d.--theme-esc{
    --white-d: 21, 24, 51;
    --white-dd: 23, 28, 56;
    --silver-d: var(--white-dd);
    color: rgb(203, 198, 198);
}

.--theme-dark .bc-white-d.--theme-esc .flex-full > *{
    --white: 255, 255, 255;
    --white-d: 250, 250, 250;
    --white-dd: 240, 240, 240;
    --black-ll: 79, 79, 79;
    --silver: 230, 230, 230;
    --silver-d: 220, 220, 220;
    --silver-dd: 200, 200, 200;
}

body.--theme-dark{
    color: rgb(173, 171, 171);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
}

body.--theme-dark .bc-sea-blue{
    background-color: rgb(29, 34, 59);
    color: rgb(164, 160, 160);
}

body.--theme-dark .bc-blue.c-white{
    background-color : rgb(35, 25, 66);;
    box-shadow: none;
    color: #8c8cb5;
    margin-bottom: 8px;
}

body.--theme-dark .nav-left .theme-btn .fav-ico{
    background-image: url("<?= Rexit::mapp('images/icons/favicon-white.png') ?>");
}

body.--theme-dark .nav-left .ico-pane{
    color:white;
    background-color: rgb(29, 35, 68);
}

body.--theme-dark .nav-left ul a{
    color: rgb(129, 125, 120);
}

body.--theme-dark .nav-left ul a.active{
    color: orange;
}

body.--theme-dark pre.pre-code:not([class*="c-"]) {
    color: #6b76ce;
  }

body.--theme-dark .directives code{
    background-color: #2f7a29;
    color: white;
}

body.--theme-dark code{
    color: #ff45a2;
}

body.--theme-dark .lacier{
    background-color : rgb(35, 25, 66);;
    box-shadow: none;
    color: #8c8cb5;
    margin-bottom: 8px;
}

body.--theme-dark .lacier.active > *{
    color: #8c8cb5;
}

body.--theme-dark :is([class^="i-flex"]){
    background-color: #43435e;
    color:white;
}
body.--theme-dark :where([class^="i-flex"]) .flex-ico{
    background-color: #4d4d6f;
    color: #c0c5d0;
}

body.--theme-dark :where([class^="i-flex"]) .c-orange.line{
    color: #55557c;
}

.animated-header .ico-spin{
    background-image: url("<?= Rexit::mapp('images/icons/favicon.png') ?>");
}

body.--theme-dark .animated-header .ico-spin{
    background-image: url("<?= Rexit::mapp('images/icons/favicon-white.png') ?>");
}
body.--theme-dark .animated-header .c-blue-dd{
    color:white;
}
 </style>
<style rel="build.css.navbars"> 

     .nav-left{
          min-height: 100vh;
          width: 300px;
          background-color: rgba(var(--white-dd));
          display: inline-block;
          left: -300px;
          transition: left .2s ease-in-out;
          z-index: 1;
     }

     .nav-left.in{
          left: 0;
     }

     .nav-left .theme-btn .fav-ico{
          background-image: url("<?= Rexit::mapp('images/icons/favicon.png') ?>");
     }

     body .nav-left .ico-pane {
          color: #4853db;
     }

     .nav-left ul > li:hover{
          color: var(--orange-dd);
          cursor:pointer;
     }

     .nav-left ul a{
         color: rgb(114, 110, 105);
         list-style: none; 
     }

     .nav-left ul li {
         list-style: none;
         margin: .2em 0em;
     }

     .nav-left ul li:hover .ico:before {
         content: "◈";
         display: inline-block;
         padding: 4px;
         color: #bebebe;
     }

     .nav-left ul li a.active {
          color: orange;
     }

     .tutorial{
          width: 100%;
          transition: width .2s ease-in-out;
     }

     @media (min-width: 1001px){

          .nav-left{
               left: 0 !important;
          }

          .tutorial{
               width: calc(100% - 300px);
               float:right;
          }
     }
 </style>

    
    
    <?= Rexit::load('switcherJS') ?>
    <?= Res::live() ?>
</head>
<body class="--theme-dark">

    <script>
        $(document).ready(function(){
            $('.control').click(function(){
                $btn = $(this).find('.controller')
                $isActive = $btn.hasClass('active');

                $btn.toggleClass('fade-out')
                $('.nav-left').toggleClass('in');
                $('.blurry').fadeToggle(function(){
                    if(!$isActive) { 
                        $btn.removeClass('bi-list').addClass('active bi-x') 
                    }else{
                        $btn.removeClass('active bi-x').addClass('bi-list') 
                    }
                });
            }) 
            $('.blurry').click(function(){
                $btn = $('.controller')
                $btn.toggleClass('fade-out')
                $('.nav-left').toggleClass('in');
                $('.blurry').fadeToggle(function(){
                    $btn.removeClass('active bi-x').addClass('bi-list')
                });
            });

            function runHash() {
                setTimeout(() => {
                    let hash = hashRunner(':get')
                    $('.lacier').removeClass('active');
                    $('#'+hash+' .lacier').addClass('active')  
                });                 
            }
            runHash();
            setTimeout(() => {

                $(window).bind('hashchange', function() {
                   runHash()
                })

            });

        })
    </script>
    
    <script rel="build.js.theme"> 
window.onload = function() {
    

    let switchBox = new Switcher;

    let themeBtn = document.querySelectorAll('.theme-btn');
    let body = document.querySelector('body');

    themeBtn.forEach(btn => {

        btn.addEventListener('click', () => {

            body.classList.toggle('--theme-dark');
    
            if(body.classList.contains('--theme-dark')){
                switchBox.set('spoovaTheme', '--theme-dark');
            }else{
                switchBox.set('spoovaTheme', '');
            }

        })

    })

    switchBox.bind('spoovaTheme', function(value){ 
       if(!value) body.classList.remove('--theme-dark')
    })

 
}
</script>

    <section class="font-menu font-em-1d1">
        <div class="control font-em-2 fixed c-orange box">
            <div class="flex px-40 mid rad-r shadow anc-btn-link bc-white">
                <span class="bi-list controller flex"></span>
            </div>
        </div>
         

    <!-- @lay('build.co.coords:header') -->

     

     

     <nav class="nav-left fixed">

          <div class="flex ico-pane pxv-10">
               <div class="flex-icon theme-btn navtheme bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin fav-ico" style="transition: none;"></div>
                    <div class="font-em-1d2 fav-text px-40 flex mid overlay fb-2 fira" style="top:-1.1px; left:.4px; z-index: 1;">
                         s 
                    </div>
               </div>
               <a href="<?= Rexit::domurl() ?>" class="flex inherit">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square calibri">
               <li> <a href="<?= Rexit::domurl('docs/installation') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/wmv') ?>" class="<?= Rexit::inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
               <li> <a href="<?= Rexit::domurl('docs/live-server') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Live Server</a></li>
               <li> <a href="<?= Rexit::domurl('docs/database') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Database</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/resource') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Resource class</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/routings') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Routing System</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/sessions') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling Sessions</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/forms') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling Forms</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/useraccounts') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling Users</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/database/data-model') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling DBModels</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/database/migrations') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling Migrations</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/classes') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Helper Classes</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/functions') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Helper Functions</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/template') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Template Engine</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/setters') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/mails') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/cli') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= Rexit::domurl('docs/plugins') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= Rexit::domurl('docs/libraries') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/other-features') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
               <li> <a href="<?= Rexit::domurl('updates') ?>" class="<?= Rexit::inPath('active') ?>"><span class="bi-recycle c-dry-blue"></span> Updates</a> </li>
          </ul>
      
     </nav>



    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="font-em-1d5 c-orange"> <i class="bi-router"></i> Routing</div> <br>
                    
                    <div class="routing-files">
                        <div class="">
                            Routes are registered through multiple ways using either ports or htaccess files.
                            The <code>model-view-controller</code> is a common pattern in framework development.
                            However, WMV <code>windows-view-model</code> or <code>windows-model-view</code> is a routing approach
                            that is built upon the MVC architecture. Both port routing (8080) with php in-built server or the use of 
                            third-party webserver is supported by this framework. In order to be more specific, web apps initialized 
                            through php local server ports (8080) will be referred to as "MVC Port" while those that uses web servers
                            will be termed as WMV, although, both systems are still under the MVC architecture. The spoova framework has 
                            a great relationship with both the Port routing or the use of Htacess file for routing system which makes it possible 
                            to interact and work with any of these two systems in an almost similar manner. For example, 
                            web page url addresses are configured to give out the same response under any of this systems.
                        </div> 
                    </div> <br>

                    <div class="routing-files">
                        <div class="fb-6 c-orange">What is WMV ?</div> <br>
                        <div class=" font-em-1">
                            <p class="">
                                The <code>windows-model-view</code> is an architectural pattern built on MVC pattern. 
                                It uses a 3-logic pattern to handle url routes, making it a more flexible system to deal with. In
                                <code>WMV</code>, the entire application is the house which has 
                                different windows, window frames and entry points. In <code>wmv</code> systems, a window cannot naturally 
                                exist unless it is given its own space. The <code>wmv</code> system does not depend on ordinary php files but on window files 
                                which in turn serves as entry points. These window files are classes that extends to the root <code>Window</code> class or object. 
                                Similarly to a house, a window enables us
                                to have a view and what we see are the models or structures which are accessible through the window.
                                A view cannot occur if there is nothing to be seen. This means that an object must be able to reflect a light.
                                Without a light, then there is no view at all. Hence, wmv is a pattern that follows a window format. A better example
                                is our eyes. When the eyes is opened, a light must be reflected on objects to be seen, else there will be total darkness.
                                The light itself is an object (model) that controls how an object is perceived. So, under <code>wmv</code>, the model comes first before view.
                                The <code>WMV</code> architecture is divided into six categories
                                which are 
                                <a href="<?= Rexit::domurl('docs/wmv/routes') ?>" class="c-olive ch-olive"><code>Routes</code>, 
                                <a href="<?= Rexit::domurl('docs/wmv/frames') ?>" class="c-olive ch-olive"><code>Frames</code></a> 
                                <a href="<?= Rexit::domurl('docs/wmv/apis') ?>" class="c-olive ch-olive"><code>APIs</code></a>, 
                                <a href="<?= Rexit::domurl('docs/wmv/sessions') ?>" class="c-olive ch-olive"><code>Sessions</code></a>, 
                                <a href="<?= Rexit::domurl('docs/wmv/rex') ?>" class="c-olive ch-olive"><code>Rex</code></a> and 
                                <a href="" class="c-olive ch-olive"><code>Models</code></a> . 
                                These will be discussed later under their headings.
                            </p>
                        </div> 
                    </div>

                    <div class="wmv-routing">
                        <div class="fb-6 c-orange">Routing - Template Engines (mvc)</div>
                        <div class=" font-em-1 mvt-10">
                            Routing involves management of urls that are later rendered along with template files. Spoova uses an in-built 
                            template engine <code>Compiler</code> to render its rex template files. The <code>rex</code> template files are 
                            placed within the <code>windows/Rex</code> directory which is the location where all php resource template files (rex) are loaded from. 
                            The template files are loaded through the use of <code>Res::load()</code> class which means "load resource". It is very
                            easy to load template files on routes and we will be examining few examples.
                        </div> <br>
                        
                        
                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 1 : Functions</div>
                    <pre class="pre-code">
  &lt;?php

    <span class="comment no-select">1.</span> Res::load('index', function(){ return "me"; });
    <span class="comment no-select">2.</span> Res::load('index', fn => "me" );
    <span class="comment no-select">3.</span>
    <span class="comment no-select">4.</span> Res::load('::path.of.file', fn => "me" );
    <span class="comment no-select">5.</span>
    <span class="comment no-select">6.</span> Res::load('index', fn => compile() );
    <span class="comment no-select">7.</span> 
    <span class="comment no-select">8.</span> Res::load('index', fn => view('some-file') );
        
  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class=" font-em-d9">
                            In example above, assuming we are within a window file : 

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 1 & 2 above, the <code>index</code> is usually an empty rex file (i.e index.rex.php) which serves as a screen 
                            upon which the string value (i.e "me") will be reflected on. This means that <code>index.rex.php</code> must exist within the rex folder for the word "me" to be displayed 
                            successfully on the webpage. The supplied empty file path <code>"index"</code> will be used as storage path.

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> Since creating empty files which are just needed as a screen to reflect our content might not be the best idea, 
                            by supplyig a double colon <code>::</code> and a path on the file just as line 4, the load function will help to push our data to the webpage while the storage file path will 
                            also be created. The path after the colon (i.e "path.of.file") will be translated 
                            to <code>path/of/file.rex.php</code> which will then be used as the storage file name (or path).
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 6, the <code>compile()</code> method is used as a directive for rendering the contents of the 
                            <code>index</code> rex file. A file will not be rendered unless the compile method is declared upon it.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 8, the <code>view()</code> method is used as a directive for rendering the contents of a supplied 
                            template file into the index file. In spoova 2.5, the <code>compile()</code> function can be used similarly.

                            <br><br>
                            <span class="fb-6">Note:</span> The <code>icore/filebase.php</code> file needs to  be included or accessible on all project files. This has been 
                            preloaded to all window structure. Hence, if this structure is employed, then there is no further need to include it.
                        </div> <br>      

                        <!-- Handling Classes -->
                        
                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 2 : Classes </div>        
                    <pre class="pre-code">
  &lt;?php
                    
    <span class="comment no-select">1.</span> use spoova\mi\windows\Routes\App;
    <span class="comment no-select">2.</span> 
    <span class="comment no-select">3.</span> Res::load('index', [App::class, 'index']);

  ?&gt;
                    </pre>
                        </div>

                        <div class="foot-note">
                            In example 2 above, we supplied a class using an array. The <code>App</code> class will be loaded from the <code>spoova\mi\windows\Routes</code>
                            namespace and the <code>index</code> method will be called from that <code>App</code> class.
                        </div>
                    
                        <div class="">
                            <div class="fb-6 c-orange">Markup</div>
                            <div class="mvt-10">
                                
                                The <code>markup()</code> method is similar to the the <code>load</code> 
                                method except that it prevents the <code>compile()</code> function from 
                                automatically displaying the content rendered. Instead, it returns the data 
                                compiled. Example is shown below:

                                <br><br>

                                <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 3 : Markup </div>        
                        <pre class="pre-code">
  &lt;?php
    
    <span class="comment no-select">1. include_once 'icore/filebase.php'; </span> 
    <span class="comment no-select">2.</span> use spoova\mi\windows;
    <span class="comment no-select">3.</span> 
    <span class="comment no-select">4.</span> $compiled = Res::markup('index', [App::class, 'index']);
    <span class="comment no-select">5.</span> print $compiled;

  ?&gt;
                        </pre>
                                </div> 
                            </div> 
                        </div>

                        <div class="foot-note">Accessing files using the window system allows pages to load 
                            only through the window classes or routes by calling <code>Server::run()</code> from the <code>index.php</code> file 
                            which is connected to an <code>icore/filebase.php</code> file. Hence, line 1 will be naturally available to all window 
                            files as long as any of the spoova <a href="<?= Rexit::domurl('docs/wmv') ?>"><span class="c-olive">architectural logics</span></a> are employed 
                            and this means that we don't need to include it. Due to the fact that the root Window class has a great relationship with the <code>Res</code> 
                            class, assuming that we are within a window file (or class), then the <code>Res::</code> class can be replaced with 
                            <code>self::</code>
                        </div>

                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 4 : Using window file </div>        
                        <pre class="pre-code">
  &lt;?php
    
    namespace spoova\mi\windows\Routes;

    use Window;

    class Home extends Window {

        function __construct() {

            $arguments = ['title' => 'This is Homepage'];

            self::load('home', fn() => compile($arguments) );

        }

    }

  ?&gt;
                        </pre>
                        </div>

                        <div class="foot-note">In the example above, not only were we able to use the <code>self::load()</code> 
                            inherited compiler but we also passed an argument to the <code>home.rex.php</code> file using the compiler function. 
                            You can learn more about <a href="<?= Rexit::domurl('docs/routings/mvc') ?>" class="c-olive rule-dotted">port routing</a> or 
                            <a href="<?= Rexit::domurl('docs/routings/wmv') ?>" class="c-olive rule-dotted">wmv</a> 
                            from the supplied links.
                        </div> <br> 

                    </div>
                </div>
            </div>
        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>