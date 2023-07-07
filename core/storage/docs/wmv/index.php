<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>WMV</title>
    <?= Rexit::load('headers') ?>
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: "Poppins", "Roboto", sans-serif;
     }

     .bc-v-title{
          background-color: #a6a6bc;
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
body.--theme-dark .bc-v-title{
    background-color: #656469;
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
         

    

     

     

     <nav class="nav-left fixed">

          <div class="flex ico-pane pxv-10">
               <div class="flex-icon theme-btn navtheme bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin fav-ico" style="transition: none;"></div>
                    <div class="font-em-1d2 fav-text px-40 flex mid overlay fb-2 fira" style="top:-1.1px; left:.4px; z-index: 1;">
                         s 
                    </div>
               </div>
               <a href="<?= Rexit::domurl() ?>" class="flex c-i inherit">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square calibri">
               <li> <a href="<?= Rexit::domurl('docs/installation') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/wmv') ?>" class="<?= Rexit::inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows View Models">WVM</span> PATTERN</a></li>
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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="font-em-1d5 c-orange"> <i class="bi-window-dock"></i> WVM PATTERN</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            The WVM pattern is an MVC achitectural pattern built using a basis of a window approach.
                            It follows a series of predefined structures that makes up the WMV itself. This system 
                            can be entirely classified into six categories which are <code>Routes</code>, <code>Frames</code>, 
                            <code>Models</code>, <code>APIs</code>, <code>Sessions</code> and <code>Rex</code> files, where the <code>Rex</code> files are template files 
                            controlled mostly with template directives and compiled using compiler functions.

                            The WMV depends on a structure where a <code>Model</code> is created before a 
                            <code>View</code> is rendered. In order to work with wmv framework, 
                            a window file must be created. Window files are classes that are extended to a root Window controller class.
                            Hence, they inherit properties of the Window parent which has url management and template 
                            loading extended features. The window system resolves routes mostly by the use of predefined routing logic. These 
                            logics are responsible determining how routes are validated and resolved.
                        </div> 
                    </div>
                    
                    <div class="windows-folder"> 
                        <br>
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Directory </div>
                        </div>

                        <div class="mvt-20">

                            <div class="">
                                The windows folder is a reserved directory storing for Routes, APIs, Frames, Models, Sessions and Rex files. By order of standard, spoova employs 
                                a standard logic which uses different window files as route entry points. These file are added to the 
                                windows route directory (i.e <code>windows/Routes</code> )  and each window file extends to a 
                                root <code>Window</code> class which is the main controller. 
                            </div> <br>
                            
                            <div class="">
                                <div class="fb-6 font-em-d85 bc-silver pxv-10 rad-r">What are logics?</div> <br>
                                <div class="">
                                    Logics are structures designed for resolving how route urls are processed through the use of window controller files. In WVM architecture, 
                                    web urls are divided into three subdivisions (i.e <span class="c-teal">root</span>, <span class="c-teal">base</span> and <span class="c-teal">path</span>) 
                                    which are directives that helps the window to understand how best to resolve a route. In order to effectively manage routes and  
                                    to allow for flexibilites, WVM employs the use of either a single super controller file (<span class="c-teal">window</span>) or multiple super controller 
                                    files which are categorized into logics to manage routes. By default, whenever a page is loaded, the url is transferred to the windows management structure. 
                                    This will try to resolve the url by looking for 
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
                                        Index logic is built upon the basic logic. In this logic, the <code class="calibri">windows\Routes\Index</code>
                                        namespaced class takes the full ownership and control of how urls are handled. When an index page 
                                        (e.g <code class="calibri">http://host_name/</code> or <code class="calibri">http://host_name/index</code>) is visited, the namespaced index class will resolve 
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
 
  <span class="c-dry-blue-d">namespace spoova\mi\windows\Routes;</span>
  
  <span class="c-dry-blue-d">use Window;</span>

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
                                                However, if a different url is called whose entry point name is not <code class="bd-f">"index"</code>, rather than call the <code>root()</code> method, 
                                                spoova will check if the route file exists first within the <code class="calibri">windows\Routes</code> directory and try to use the class to 
                                                resolve the url. The <code>self::callRoute()</code> method ensures that 
                                                the window tries to load every page using a class entry window name that exists within the <code class="calibri">windows\Routes</code> directory. If the url handler or window router file 
                                                does not exist, then a 404 reponse is returned through the <code>self::close()</code> method. To further explain this, let's take a look at two sample urls below: 
                                                
                                                <div class="pre-area">
                                                    <pre class="pre-code">
  http://localhost/app/home <span class="comment">window('root') => home</span>
  http://somesite.com/home  <span class="comment">window('root') => home</span>
                                                    </pre>
                                                </div>

                                                In the two sample urls above, spoova internally determines the url's entry point as <code>"home"</code>. The <code>self::callRoute()</code> will try to see if the <code>Home</code> route 
                                                class exists in the <code>windows/Routes</code> directly and automatically load it. If the file does not exist, it will return a false value which will trigger the <code>self::close()</code> 
                                                method that returns a 404 error page.
                                                
                                                into assuming we have a localhost url 
                                                <code>http://localhost/app/home</code>, then the <code>window('root')</code> of the url will be <code>"home"</code>. 
                                            </p>

                                            <p>
                                                As seen above, in any given url, an entry name returned by <code>window('root')</code> or <code>window(':')</code> 
                                                is always the name that comes after the domain url. In localhost, it is the path name that comes after the project folder name. In the first url sample 
                                                above, the project folder name is <code>app</code>, hence the window root is <code>"home"</code>. However, in the second url since <code>somesite.com</code> 
                                                will most likely be the domain url, then the first path that follows becomes the window root. If there is no path found after these urls, this will be assumed as the index page.
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
                                        Unlike other logics, standard logic suggests that all urls must have a window entry point corresponsing to a server or route entry file that takes ownership of its 
                                        relative sub-urls. When a url is visited, standard logic will split the url into divisions to obtain an entry point name. The entry point name of that url must have a correspoing 
                                        controller class that determines how the url is loaded. This means that a url <code>http://localhost/home</code> and <code>http://localhost/home/user/...</code> for example, will be handled 
                                        by a route file <code>"Home"</code>. This <code>Home</code> file must be an extension of <code>Window</code> class within the <code class="calibri">windows/Routes</code>
                                        directory and it will determine how its relative sub-paths are resolved. If the required route file does not exist, then a 404 error page is returned. 
                                        Futher explanation is given on window entry point <a href="<?= Rexit::route('::about_wmv') ?>"><span class="c-olive rule-dotted">here</span></a>. In order to define a standard logic, 
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
  &lt;?php
  
  <span class="c-dry-blue-d">namespace spoova\mi\windows\Routes;</span>
  
  <span class="c-dry-blue-d">use Window;</span>

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

                        <div id="map-files" class="">
                            
                            <div class="bc-silver pxv-10 rad-r"> <span class="bi-globe"></span> Working with map files </div>
                            <div class="pxv-10">
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
                                    the profile. This makes it possible to protect the main controller file names. We can also define a prefix name for all protected routes. This means that the prefix will be added before 
                                    calling the route names. This makes it easier to fake route entry names. Example is shown below:
                                </div> <br>

                                    <div class="pre-area">
                                        <div class="pxv-10 bc-silver"><span class="bi-gear"></span> windows/Routes/.map</div>
                                        <pre class="pre-code">
  {
      "*"    : "App"
  }
                                        </pre>
                                    </div>

                                    <div class="foot-note">
                                       When map file is used as above, the default behaviour of route file names will be changed. All route files will now be assumed to have a suffix of "App". For example, rather 
                                       than looking for a <code>Home</code> route file for <code>http://localhost/domain/home</code>, instead, the route file that will be looked for is <code>AppHome</code>. This makes it difficult 
                                        for anyone to guess the route entry file name.
                                    </div> <br>     
                                                           
                            </div>

                            <div class="pxv-10">
                                <div class="bc-silver pxv-10 rad-r"> <span class="bi-lock"></span> Standard Logic Inverse</div>
                                <div class="mvt-6">
                                    Inverse is the way to reduce the strict level of standard logic. By default, the standard login assumes that 
                                    window roots have controller files within the <code>windows/Routes</code> directory and that the file name 
                                    starts with an uppercase character while other characters are in lower case. This make it important that when a window root <code>"docs"</code> 
                                    is accessed, then the route <code>Docs</code> is called. However, if the root "doCs" is called instead, this will fail because the 
                                    route file "doCs" or "DoCs" does not exist but what we have is <code>"Docs"</code>. In other to remove the default strictness behaviour to 
                                    ensure that window roots accepts any lower case character, we need to add a non-strict level directive into the map file. This 
                                    can be seen in the example below <br><br>

                                    <div class="pre-area">
                                        <div class="pxv-10 bc-silver"><span class="bi-gear"></span> windows/Routes/.map</div>
                                        <pre class="pre-code">
  {
      ":root":{

          "!Docs"    : "Docs",

      }
  }
                                        </pre>
                                    </div>
                                </div>   

                                <div class="foot-note">
                                    Using the sample above as reference, under a standard logic when a url is visited, for example <code>http://localhost/dOcS/user</code>, the <code>windows/Routes/Docs</code> class 
                                    will now be called due to the <code>.map</code> file's directive to resolve that root in a non-strict type. Without the map file, only a url <code>http://localhost/docs/user</code> 
                                    will be able to call the route file "Docs". Note that once the inverse operator <code>"!"</code> is used before the key (e.g "!Docs"), the case of the key does not matter, however, the 
                                    case of the value must be maintained as the expected main route file name. 
                                </div>
                            </div>


                        </div>
                        
                
                    </div>  

                    <div class="windows-files"> 
                        <br>
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
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
                        
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
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
                                <li>A frame class should be placed in a "Frames" folder, a direct subdirectory of windows folder</li>
                                
                                <li>A frame class should extend to the root Windows class</li>
                                <li>A frame class should never be used to close a window</li>
                                <li>A frame class should contain only data essential for its children classes</li>
                                
                                <li>A frame class should not be used to render rex template files.</li>
                                <li>A frame class may be attached to a specific session channel, thereby including data specific only to that session.</li>    
                            </ul>
                            
                        </div>
                
                    </div>  

                    <div class="about_wmv"> 
                        <br>
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-card-list mxr-8 c-lime-dd"></span> Note </div>
                        </div> <br>

                        
                        <div>
                            There are several key points to note when working with the wvm network. To futher explain the wmv 
                            pattern, we have categorized important keynotes to the underlying subjects:
                            <br><br>
                            <ul class="c-olive">
                                <li> <a href="<?= Rexit::route('.wmv') ?>">About <span class="fb-6 pointer" title="Windows Models View">WVM (or WMV)</span></a></li>
                                <li> <a href="<?= Rexit::route('.open') ?>">Opening and Closing windows</a> </li>
                                <li> <a href="<?= Rexit::route('.calls') ?>">Windows Calls</a> </li>
                                <li> <a href="<?= Rexit::route('.middlewares') ?>">Windows Middlewares</a> </li>
                                <li> <a href="<?= Rexit::route('.frames') ?>">Window Frames</a> </li>
                                <li> <a href="<?= Rexit::route('.routes') ?>">Window Routes</a> </li>
                                <li> <a href="<?= Rexit::route('.sessions') ?>">Window Sessions</a> </li>
                                <li> <a href="<?= Rexit::route('::apis') ?>">Window APIs</a> </li>
                                <li> <a href="<?= Rexit::route('::models') ?>">Window Models</a> </li>
                                <li> <a href="<?= Rexit::route('::rex') ?>">Window Rex</a> </li> 
                                <li> <a href="<?= Rexit::route('.methods') ?>">Window Methods</a> </li>
                                <li> <a href="<?= Rexit::route('.inverse') ?>">Window Inverse</a> </li>
                                <li> <a href="<?= Rexit::route('.errors') ?>">Window Errors</a> </li>
                            </ul>
                        </div>      
                
                    </div>  

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


                </div>
            </div>
        </section>
    </div>
    
    
    

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>