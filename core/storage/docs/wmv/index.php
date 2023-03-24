<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script> 
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
    
    <script> 
window.onload = function() {
    

    let switchBox = new Switcher;

    $('.theme-btn').click(function() {

        $('body').toggleClass('--theme-dark');

        if($('body').hasClass('--theme-dark')){                
            switchBox.set('spoovaTheme', '--theme-dark')
        }else{
            switchBox.set('spoovaTheme', '')    
        }

    })

    switchBox.bind('spoovaTheme', function(value){
        $('body').addClass(value)
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
               <div class="flex-icon theme-btn box bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv">Wmv</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">WMV PATTERN</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            The WMV pattern is an achitecture built upon the ideology of MVC pattern.
                            It follows a series of predefined structures that makes up the WMV itself. This system 
                            can be entirely classified into six categories which are <code>Routes</code>, <code>Frames</code>, 
                            <code>Models</code>, <code>APIs</code>, <code>Sessions</code> and <code>Rex</code> files, where the <code>Rex</code> files are template files 
                            controlled mostly with template directives and compiled using compiler functions.

                            The WMV depends on a structure where a <code>Model</code> is created before a 
                            <code>View</code> is rendered. In order to work with wmv framework, 
                            a window file must be created. Window files are classes that are extended to a root Window manager class.
                            Hence, they inherit properties of the Window parent which has url management, request access and template 
                            loading features. 
                        </div> 
                    </div>
                    
                    <div class="windows-folder"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Directory </div>
                        </div> <br>

                        <div class="">

                            <div class="">
                                The windows folder is a reserved directory storing for Routes, APIs, Frames, Models, Sessions and Rex files. By order of standard, spoova employs 
                                a standard logic which uses different window files as route entry points. These file are added to the 
                                windows route directory (i.e <code>windows/Routes</code> )  and each window file extends to a 
                                root <code>Window</code> class which is the main controller. 
                            </div> <br>
                            
                            <div class="">
                                <div class="fb-6 font-em-d85 bc-silver c-white-d pxv-10 rad-r">What are logics?</div> <br>
                                <div class="">
                                    Logics are structures designed for resolving how route urls are processed through the use of controller files. In WVM architecture, 
                                    web urls are divided into three subdivisions (i.e window, base and path) which are usually resolved by a controller file which determine how routes are loaded. In order to effectively manage routes and  
                                    to allow for flexibilites, WVM employs the use of either a single super controller file (window) or multiple super controller files which are categorized into logics to manage routes.
                                    By default, whenever a page is loaded, the url is transferred to the windows management structure. This will try to resolve the url by looking for 
                                    a super controller route file within the <code>windows/Routes</code> directory and under the <code>spoova\mi\windows\Routes</code> namespace. If 
                                    a window entry class file matching a url's entry name does not exist, spoova will return a 404 error. The window logics are of 3 categories: 
                                </div>
                            </div>

                            <ul class="mvt-10">
                                <li><a href="#basic-logic"><span class="c-orange-dd">Basic Logic</span></a></li>
                                <li><a href="#standard-logic"><span class="c-orange-dd">Standard Logic</span></a></li>
                                <li><a href="#index-logic"><span class="c-orange-dd">Index Logic</span></a></li>
                            </ul>

                            <div class="pxs-14">
                                <span id="basic-logic"></span>
                                <div class="basic-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Basic Logic</div>
                                    <div class="desc mvt-10">
                                        
                                        The basic logic involves the use of a super controller file to handle routes. Under this logic, whenever a url is visited, the route management structure transfers the url to a specified super controller 
                                        file which determines how the url is resolved. In order to use this method, the <code>index.php</code> file's <code>Server::run()</code> 
                                        method should be supplied with a class name as argument e.g <code>"basic"</code> just as below. 
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  <span class="no-select">&rarrhk;</span> Server::run('basic');
 </pre>
                                        </div> <br>
                                        
                                        Once this is done, then the application will assume that a <code>windows/Routes/Basic.php</code> file controls the entire application. The namespace is generated from the supplied 
                                        super controller's file name (i.e basic). If the file (i.e class) exists within the predefined path, then the class will take the full ownership and control of how urls run. This means that 
                                        every url will first land on that <code>windows/Routes/Basic.php</code> file which will then determine how such url is handled. In this manner, 
                                        the Basic file is the sole distributor and manager of all urls. Without it, pages will not be able to load.
                                    </div>
                                </div>
                            </div> <br>


                            <div class="pxs-14">
                                <span id="index-logic"></span>
                                <div class="index-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Index Logic</div>
                                    <div class="desc mvt-10">
                                        Index logic is built upon the basic logic. In this logic, the <code class="calibri">windows/Routes/Index.php</code>
                                        file takes the full ownership and control of how urls are handled. When an index page 
                                        (e.g <code class="calibri">http://host_name/</code> or <code class="calibri">http://host_name/index</code>) is visited, index class will resolve 
                                        the index page by calling its <code class="calibri">root()</code> method. However when other urls whose entry names are not index are called, 
                                        then spoova will try to resolve the urls by looking for a file with the root name within the <code class="calibri">windows/Routes</code> directory.
                                        If the file does not exist, then spoova will return a 404 error page. The structure below is an example of how to set up an index logic. 
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  <span class="no-select">&rarrhk;</span> Server::run('index');
 </pre>
                                        </div> <br>
                                        
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">windows/Routes/Index.php</div>
 <pre class="pre-code">
 
  <span class="c-violet-dd">namespace spoova\mi\windows\Routes;</span>
  
  <span class="c-purple">use Window;</span>

  class Index extends Window {

    function __construct(){

      if(self::isIndex($this)){
      
         self::call($this, [
    
            window('root') => 'root',
            
         ]);

      } else {

         if(!self::callRoute(window('root'))) self::close();

      } 
    
      function root() {

         <span class="comment">//call this on index page</span>

      }

    }

  }
 </pre>
                                        </div> <br>
                                        
                                        <div class="font-em-d9">
                                            <p>
                                                In the code above, by setting the <code>index.php</code> file to 
                                                <code>Server::run('index')</code>, the application will try to call the <code>windows\Routes\Index.php</code>. 
                                                If the file exists and the currently requested url is an index page, the <code>windows\Routes\Index.php</code>file will in turn call its <code>root()</code> method 
                                                using the shutter method <code>call()</code>.
                                                However, if a different url is called whose entry point name is not "index", rather than call the <code>root()</code> method, 
                                                spoova will check if the route file exists first within the <code class="calibri">windows\Routes</code> directory and try to use the class to 
                                                resolve the url. The <code>self::callRoute()</code> method ensures that 
                                                the window tries to load every page using a class entry window name that exists within the <code class="calibri">windows\Routes</code> directory. If the url handler or window router file 
                                                does not exist, then a 404 reponse is returned through the <code>self::close()</code> method. 
                                            </p>

                                            <p>
                                                In any given url, an entry name returned by <code>window('root')</code> or <code>window(':')</code> 
                                                is always the name that comes after the domain url. In localhost, it is the name that comes after the project folder name. In the code 
                                                above, assuming the project folder name is <code>app</code>, then a url "http://localhost/app/" and "http://localhost/app/index" will run successfully because the 
                                                <code>call()</code> method was used and both urls still refer to the index page. In situations where we need to handle more paths on the index page, for example 
                                                "http://localhost/app/localhost/more_path" then <code>self::basecall()</code> may be preferred instead while noting that unwanted urls must be filtered out through some validation logic.
                                            </p>
                                         
                                        </div>


                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="standard-logic"></span>
                                <div class="standard-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Standard Logic</div>
                                    <div class="desc mvt-10">
                                        Unlike other logics, standard logic suggests that all urls must have a window entry point corresponsing to a server entry file that takes ownership of its 
                                        relative sub-urls. When a url is visited, standard logic will split the url into divisions to obtain an entry point name. The entry point name of that url must have a correspoing 
                                        controller class that determines how the url is loaded. This means that a url <code>http://localhost/home</code> and <code>http://localhost/home/user/...</code> for example, will be handled 
                                        by a root window file <code>"Home"</code>. This <code>Home</code> window class within the <code class="calibri">windows/Routes</code>
                                        directory will determine how its relative sub-paths are resolved. If the root window file does not exist, then a 404 error page is returned. 
                                        In any given url there is always a window or entry point as explained <a href="<?= route('::about_wmv'); ?>"><span class="c-olive hyperlink">here</span></a>. In order to define a standard logic, 
                                        the <code>Server::run()</code> code in root config file <code>index.php</code> must have no arguments. 
                                        <br>

                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  Server::run(); <span class="comment no-select">// use standard logic</span>
 </pre>
                                        </div> <br>
                                        
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">windows/Routes/Index.php</div>
 <pre class="pre-code">
 
  <span class="c-violet-dd">namespace spoova\mi\windows\Routes;</span>
  
  <span class="c-purple">use Window;</span>

  class Index extends Window {

    function __construct(){

        self::call($this, [

            window(':') => 'root',
            window(':user') => 'user_method',
        
        ]);

    }

    function root() {

        <span class="comment">//call this on index page</span>

    }

    function user_method() {

        <span class="comment">//call this on index/user page</span>

    }



  }
 </pre>
                                        </div> <br>
                                        
                                        <div class="font-em-d8">
                                         In the code above, note that <code>window(':')</code> will return a requested 
                                         (or current) url's entry point name. Since, Index is the entry server file, then, 
                                         <code>index</code> will be returned. Also, <code>window(':user')</code> will return 
                                         <code>index/user</code>. Since <code>call()</code> is a direct shutter method, 
                                         if the method <code>user_method()</code> does not exist when the <code>http://domain/index/user</code>, 
                                         page is visited, then a 404 error will be returned. Once a method is defined, developer is left 
                                         to handle how to close such urls. Any of a window's method can use the shutter methods. It is important to note that 
                                         shutter methods are specifically built for standard logic.
                                        </div>
                                    </div>
                                </div>
                            </div> <br>

                        </div>

                        <div class="">
                            <div class="bc-silver pxv-10 rad-r"> <span class="bi-lock"></span> Standard Logic Protection</div>
                            <div class="mvt-6">
                                Usually, under standard logic, main controller files can be easily guessed from url structure since it is the url's main entry point. 
                                In order to protect main controller file names, a map file <code>.map</code> must be created within the <code>window/Routes</code> directory. This map file 
                                is expected to contain a json syntax for mapping url window to their corresponding class names. In this manner, window files becomes difficult to guess. An example of this 
                                is shown below: <br><br>

                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver"><span class="bi-gear"></span> windows/Routes/.map</div>
                                    <pre class="pre-code">
  {
      "Home"    : "HomeController",
      "Profile" : "ProfileClass",
  }
                                    </pre>
                                </div>
                            </div>
                            <div class="foot-note">
                                Using the sample above as reference, under a standard logic when a url is visited, for example <code>http://localhost/home/user</code>, the <code>windows/Routes/Home</code> class 
                                is expected to be called but due to the <code>.map</code> file, the <code>windows/Routes/HomeController</code> will be called instead. This same approach will be used for 
                                the profile. This makes it possible to protect the main controller file names.
                            </div>
                        </div>
                        
                
                    </div>  

                    <div class="windows-files"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Files </div>
                        </div> <br>

                        
                        <div>
                            In the creation of windows project, all window files (classes) must have the following features :
                            <br><br>
                            <ul>
                                <li>A window file must exist within the <code>windows/</code> directory or subdirectory</li>
                                <li>A window file (class) name should be initialized with an upper case</li>
                                <li>A window file (class) must be extended to the root <code>Window</code> class</li>
                                <li>A window file (class) must have a public <code>__construct()</code> method (entry point).</li>
                                <li>A window file (class) must have a closing structure</li>
                            </ul>
                        </div> 
                
                    </div>  

                    <div class="windows-frames"> 
                        
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Frames </div>
                        </div> <br>

                        
                        <div>
                            Frames are used to bind window files together. They store and provide similar data shared across window files. 
                            Although, Frames are extensions of Window class itself, they act as bridges or gaps between the root Window class 
                            and a Window child class. When a class is extended to a frame class, it inherits both the properties of the root window class
                            along with the specific frame class. The purpose of frame is to separate windows files that have different data from each other.
                            All window files sharing the same Frame will have data belonging to their specific frames. 
                            <br><br>
                            In order to identify frame files, they should have the following features:
                            <br><br>
                            
                            <ul>
                                <li>Should be placed in a "Frames" folder, a direct subdirectory of windows folder</li>
                                
                                <li>A frame file (class) should extend to the root Windows class</li>
                                <li>A frame file (class) should never be used to close a window</li>
                                <li>A frame file (class) should contain only data essential for its children classes</li>
                                
                                <li>A frame file (class) should not be used to render rex template files.</li>
                                <li>A frame file (class) may be attached to a specific session channel, thereby including data specific only to that session.</li>    
                            </ul>
                            
                        </div>
                
                    </div>  

                    <div class="about_wmv"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-card-list mxr-8 c-lime-dd"></span> Note </div>
                        </div> <br>

                        
                        <div>
                            There are several key points to note when working with the wvm network. To futher explain the wmv 
                            pattern, we have categorized important keynotes to the underlying subjects:
                            <br><br>
                            <ul class="c-olive">
                                <li> <a href="<?= route('.wmv'); ?>">About <span class="fb-6 pointer" title="Windows Models View">WMV</span> and <span class="fb-6 pointer" title="Model View Controller">MVC</span>?</a></li>
                                <li> <a href="<?= route('.open'); ?>">Opening and Closing windows</a> </li>
                                <li> <a href="<?= route('.calls'); ?>">Windows Calls</a> </li>
                                <li> <a href="<?= route('.middlewares'); ?>">Windows Middlewares</a> </li>
                                <li> <a href="<?= route('.frames'); ?>">Window Frames</a> </li>
                                <li> <a href="<?= route('.routes'); ?>">Window Routes</a> </li>
                                <li> <a href="<?= route('::apis'); ?>">Window APIs</a> </li>
                                <li> <a href="<?= route('::models'); ?>">Window Models</a> </li>
                                <li> <a href="<?= route('::rex'); ?>">Window Rex</a> </li> 
                                <li> <a href="<?= route('.methods'); ?>">Window Methods</a> </li>
                                <li> <a href="<?= route('.inverse'); ?>">Window Inverse</a> </li>
                                <li> <a href="<?= route('.errors'); ?>">Window Errors</a> </li>
                            </ul>
                        </div>      
                
                    </div>  

                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv">Wmv</a>  </div>


                </div>
            </div>
        </section>
    </div>
    
    
    

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>