
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/js/jquery/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/local/core.js'></script><script src='http://localhost/spoova/res/main/js/local/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/local/jqmodex.js'></script><script src='http://localhost/spoova/res/main/js/local/device.js'></script><script src='http://localhost/spoova/res/main/js/local/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/local/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/local/helper.js'></script><script src='http://localhost/spoova/res/main/js/local/init.js'></script> 
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
     }

     .tutorial{
          min-height:100vh;
     }

     .pre-area{
          font: menu;
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
          padding-top:1em;
     } 
     
     pre.pre-code:not([class*="c-"]) {
          color: #4f58a0;
     } 
     
     pre .comment {
          color: #909090;
     }
  
     .lacier.active {
          background-color: #3ecb32;
          color: white;
          box-shadow: 0 0 2px 3px #32bc27 inset;
     }
  
     .lacier.active .c-lime-dd{
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
     }

     :where(.d85){
          font-size: .85em;
     }
     :where(.d87){
          font-size: .87em;
     }
     :where([class*="foot-note"]){
          font-size: .87em;
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


 </style><style rel="build.css.headers"> 
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
    color: rgb(125, 125, 125);
    background-color : rgba(21, 15, 39);
}
 </style><style rel="build.css.navbars"> 

     .nav-left{
          min-height: 100vh;
          width: 300px;
          background-color: rgba(var(--white-dd));
          /* box-shadow: 0px 1px 1px 1px rgba(var(--white-dd)); */
          display: inline-block;
          left: -300px;
          transition: left .2s ease-in-out;
          z-index: 1;
     }

     .nav-left.in{
          left: 0;
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
    
    
    <script src='http://localhost/spoova/res/main/js/switcher.js'></script>
    
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

    <section class="">
        <div class="control font-em-2 fixed c-orange box">
            <div class="flex px-40 mid rad-r shadow anc-btn-link bc-white">
                <span class="bi-list controller flex"></span>
            </div>
        </div>
         

    <!-- @lay('build.co.coords:header') -->

     

     

     <nav class="nav-left fixed">

          <div class="flex pxv-10">
               <div class="flex-icon theme-btn navtheme box bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin" data-src="http://localhost/spoova/res/main/images/icons/favicon.png" style="transition: none"></div>
                    <div class="font-em-1d5 px-40 flex mid overlay fb-9 calibri" style="top:-2px; left:.4px; z-index: 1; color:#202dd5;">
                         s 
                    </div>
               </div>
               <a href="<?= DomUrl('') ?>" class="flex">
                    <div class="flex midv mxl-8 fb-9 font-menu font-em-1d2" style="color: #202dd5">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square">
               <li> <a href="<?= DomUrl('docs/installation') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="<?= DomUrl('docs/wmv') ?>" class="<?= inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
               <li> <a href="<?= DomUrl('docs/live-server') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Live Server</a></li>
               <li> <a href="<?= DomUrl('docs/database') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Database</a> </li>
               <li> <a href="<?= DomUrl('docs/resource') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Resource class</a> </li>
               <li> <a href="<?= DomUrl('docs/routings') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Routing System</a> </li>
               <li> <a href="<?= DomUrl('docs/sessions') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Sessions</a> </li>
               <li> <a href="<?= DomUrl('docs/forms') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Forms</a> </li>
               <li> <a href="<?= DomUrl('docs/useraccounts') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Users</a> </li>
               <li> <a href="<?= DomUrl('docs/database/data-model') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling DBModels</a> </li>
               <li> <a href="<?= DomUrl('docs/database/migrations') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Migrations</a> </li>
               <li> <a href="<?= DomUrl('docs/classes') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Classes</a> </li>
               <li> <a href="<?= DomUrl('docs/functions') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Functions</a> </li>
               <li> <a href="<?= DomUrl('docs/template') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Template Engine</a> </li>
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4">   </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Routing</div> <br>
                    
                    <div class="routing-files">
                        <div class="fb-6">Routing files</div> <br>
                        <div class="">
                            Routes are registered through multiple ways using either ports or htaccess files.
                            The <code>model-view-controller</code> is a common pattern in framework development.
                            However, WMV <code>windows-view-model</code> or (windows-model-view) approach was introduced as 
                            an approach built upon the MVC architecture. Both port routing (8080) using php inbuilt server or third-party server is supported by this framework. 
                            In order to be more specific, web apps initialized through php local server ports (8080) will be referred to as "MVC Port" while those that uses web servers
                            will be termed as WMV, although, both systems are still under the MVC architecture. The configuration of spoova frame has created a great connection between 
                            the MVC Port and WMV systems which makes it possible to interact with either of this system in the same manner. For example, url addresses are configured to 
                            give out the same response under any of this systems.
                        </div> 
                    </div> <br>

                    <div class="routing-files">
                        <div class="fb-6">What is WMV ?</div> <br>
                        <div class="font-menu font-em-1">
                            <p class="">
                                The <code>windows-model-view</code> is an architectural pattern built on MVC pattern. 
                                It uses a 3 logic pattern to handle url routes which makes it a more flexible system to deal with.
                                It works in a similar manner to building a real house with its several windows. 
                                <code>WMV</code> also has a window. In order to understand how this system works, we need to consider a project application as house with its 
                                different windows, window frames and entry points. A window cannot naturally exist unless it is given
                                its own space. WMV does not depend on files but window files which in turn serves as entry points. Similarly to a house, a window enables us
                                to have a view and what we see are the models or structures built outside that view which are objects visible to our sight.
                                A view cannot occur if there is nothing to be seen. This means that an object must be able to reflect a light.
                                Without a light, then there is no view at all. Hence, wmv is a pattern that follows a window format. A better example
                                is our eyes. When the eyes is opened, a light must be reflected on objects to be seen, else there will be total darkness.
                                The light itself is an object (model) that makes view possible. So, under wmv, the model comes first before view.
                                The <code>WMV</code> architecture is divided into six categories
                                which are 
                                <a href="<?= DomUrl('docs/wmv/routes') ?>"><code>Routes</code>, 
                                <a href="<?= DomUrl('docs/wmv/frames') ?>"><code>Frames</code></a> 
                                <a href="<?= DomUrl('docs/wmv/apis') ?>"><code>APIs</code></a>, 
                                <a href="<?= DomUrl('docs/wmv/sessions') ?>"><code>Sessions</code></a>, 
                                <a href="<?= DomUrl('docs/wmv/rex') ?>"><code>Rex</code></a> and 
                                <a href=""><code>Models</code></a> . 
                                These will be discussed later under their headings.
                            </p>
                        </div> 
                    </div>

                    <div class="wmv-routing">
                        <div class="fb-6">Routing - Template Engines (mvc)</div>
                        <div class="font-menu font-em-1">
                            Routing involves management or urls that are later rendered along with template engines. Spoova uses an in-built 
                            template engine <code>"rex"</code>
                            to render its rex template files. Rex template files are placed within the <code>windows/Rex</code> directory.
                            This is the location where all php resource template files (rex) are loaded from. The template files
                            are loaded through the use of <code>Res::load()</code> class which means "load resource". It is very
                            easy to load template files and we will be examining few examples.
                        </div> <br>
                        
                        
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
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
    <span class="comment no-select">8.</span> Res::load('index', fn => view() );
        
  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class="font-menu font-em-d85">
                            In example above, assuming we are within a window file : 

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 1 & 2 above, the <code>index</code> is usually an empty rex file (i.e index.rex.php) which serves as a screen 
                            upon which the string value (i.e "me") will be reflected on. This means that <code>index.rex.php</code> must exist within the rex folder for the word "me" to be displayed 
                            successfully on the webpage. The supplied empty file name (or path) <code>index</code> will be used as storage path.

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> Since creating empty files which are just needed as a screen to reflect our content might not be the best idea, 
                            by supplyig a double colon <code>::</code> and a path on the file just as line 4, the load function will help to push our data to the webpage while the storage file path will 
                            also be created. The path after the colon (i.e "path.of.file") will be translated 
                            to <code>path/of/file.rex.php</code> which will then be used as the storage file name (or path). The compile function will not be accepted when the double colon <code>::</code> 
                            is used because the content is not expected to be rendered from a file.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 6, the <code>compile()</code> method is used as a directive for rendering the contents of the loaded 
                            <code>index</code> file. A file will not be rendered unless the compile method is declared upon it.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 8, the <code>view()</code> method is used as a directive for rendering the contents of a supplied 
                            template file into the index file. 

                            <br><br> 
                            <span class="fb-6">Note:</span> Each of the compiler methods i.e <code>view()</code> and <code>compile()</code> can be applied within classes. 
                            
                            <br><br>
                            <span class="fb-6">Note:</span> The <code>icore/filebase.php</code> file needs to  be included or accessible on all project files. This has been 
                            preloaded to all window structure. Hence, if this structure is employed, then there is no further need to include it.
                        </div> <br>      

                        <!-- Handling Classes -->
                        
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 2 : Classes </div>        
                    <pre class="pre-code">
  &lt;?php
                    
    <span class="comment no-select">1.</span> use spoova\mi\windows;
    <span class="comment no-select">2.</span> 
    <span class="comment no-select">3.</span> Res::load('index', [App::class, 'index']);

  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class="font-menu font-em-d85">
                            In example 2 above : 

                            <br><br> We supplied a class using an array. As an example, the <code>App</code> class will be loaded from the <code>spoova\windows</code>
                            directory and the <code>index</code> method will be called from that <code>App</code> class. However, since spoova uses standard 
                            logic, web pages are only loaded classes using window route files, that is, window files within <code>window\Routes</code> directory or app namespace.
                            
                            
                        </div> <br> 
                    
                        <div class="">
                            <div class="fb-6">Markup</div>
                            <div class="">
                                
                                The <code>markup()</code> method is similar to the the <code>load</code> 
                                method except that it prevents the <code>compile()</code> function from 
                                automatically displaying the content rendered. Instead, it returns the data 
                                compiled. Example is shown below:

                                <br><br>

                                <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
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
                                </div> <br><br> 
                            <div class="font-menu font-em-d85">
                                The <code>markup</code> method above will return the compiled data. 
                            </div>
                            </div> 
                        </div> <br>

                        <div class="foot-note">
                            <span class="head">Footnote:</span> Accessing files using the window system allows pages to load 
                            only through the window classes or routes by calling <code>Server::run()</code> from the <code>index.php</code> file 
                            that is connected to an <code>icore/filebase.php</code> file. Hence, line 1 will be naturally available to all window 
                            files as long as any of the spoova <a href="<?= DomUrl('docs/wmv') ?>"><span class="c-olive">architectural logics</span></a> are employed. 
                            Assuming that we are within a window file (or class), then the <code>Res::</code> class can be replaced with 
                            <code>self::</code>
                        </div> <br>

                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 4 : Using window file </div>        
                        <pre class="pre-code">
  &lt;?php
    
    namespace spoova\mi\window\Routes;

    use Window;

    class Home extends Window {

        function __construct() {

            $arguments = ['title' => 'This is Homepage'];

            self::load('home', fn() => compile($arguments) );

        }

    }

  ?&gt;
                        </pre>
                        </div> <br><br>

                        <div class="foot-note">
                            <span class="head">Footnote:</span> In the example above, not only were we able to use the <code>self::load()</code> 
                            inherited method but we also passed an argument to the <code>home.rex.php</code> file using the compiler function which will 
                            also compile or render the rex file. The above is also an example of loading rex templates files.
                        </div> <br> 

                        <div class="learn-more">
                            <div class="fb-6">More on MVC and WMV</div>
                            <div class="">
                                Learn more on <code>mvc</code> and <code>wmv</code> from here

                                <br><br>

                                <div class="pxs-10">
                                    <ul class="olist list-square">
                                        <li> <a href="<?= DomUrl('docs/routings/mvc') ?>">MVC</a>  </li>
                                        <li> <a href="<?= DomUrl('docs/routings/wmv') ?>">WMV</a> </li>
                                    </ul>                 
                                </div>   

                            </div> 
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