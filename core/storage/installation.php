

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



   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxv-10 tutorial bc-white">
           <div class="font-em-1d2">

               <div class="start font-em-d85">
             
                   
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                   <div class="font-em-1d5 c-orange">Installation</div>
                   
                   <div class="c-black-ll">
                       It is strongly advised to learn about the features of this framework
                       before proceeding with installation. You can learn about the framework
                       <span class="c-orange-dd">
                           <a href="<?= Rexit::domurl('about') ?>" class="inherit c-i">here</a>.
                       </span> or about its version supports from <span class="c-orange-dd">
                           <a href="<?= Rexit::domurl('features') ?>" class="inherit c-i">here</a>.
                       </span>
                   </div> <br>

                   <div class="calibri bc-white-dd">
                       <div class="c-olive pxv-10 bc-silver">Application config</div>

                       <div class="pxv-10">
       
                           <ul class="list-square pxl-20">
                               <li>Download the spoova frame project pack file from by following the procedure on <a href="https://packagist.org/packages/spoova/mi" class="c-olive">packagist.org</a> </li>
                               <li>Place the project pack into your root web folder (offline)</li>
                               <li>Open spoova project pack in the terminal</li>
                               <li>Run the command : <span class="fb-6 c-black-ll"> php mi project <span class="c-gold-dd">app</span></span> where "app" is your new project folder name </li>
                               <li>Follow the console directives to generate your project app</li>
                               <li>Configuration of new project app can be done through web installer page (if allowed before generation) or through the command line</li>
                               <li>Open the new project app in your editor's (e.g vscode) terminal for configuration</li>
                               <li>Run the command <code>php mi config:all</code> to configure your new project app</li>
                               <li>During configuration, database parameters must be defined within quotes, for example <code>"name user pass server port socket"</code> </li> 
                               <li>Database parameters should be filled with valid details while empty parameters should be set as dash (i.e -)</code></li>
                               <li>For spoova to run efficiently, database configuration along with other basic configurations should be updated with valid credentials. </li>
                               <li>All database configurations are saved into the icore/dbconfig.php file for both offline and online environments.</li>
                               <li>When using the inbuilt web installation tool, you can choose the hard install (e.g http://localhost/app/install?refresh) option on the home page to reset previously defined configurations. </li>
                           </ul>
                           <div class="bc-silver rad-3 flow-x flex font-em-d85 pvs-10 pxs-10 hide"> 
                            <div class="box bc-red-dd bd-1 bd-red-dd pxv-4 c-white-d no-wrap"> <span class="bi-exclamation-triangle"></span> Note:</div> 
                            <div class="box bd-1 bd-silver-d pxv-4 wid-full">It is highly discourged to use the spoova source pack as project folder.</div>
                           </div>
                       </div>
                   </div> <br>
                   
               </div>

               <div class="install-page calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Web Installer</div>
                   <div class="font-em-d85 pxv-10 no-select">
                   
                        During project application generation, a web installer page may be added. If the installer page is missing. Use the command 
                        <code>php mi web-installer</code> to generate a new installer page. However, it is strongly advised that all configurations should be 
                        handled from the terminal to ensure that all configurations are applied. To manually generate an installer page the following code may be 
                        added to an installation route.

                   </div>

                   <div class="font-em-d8">

                        <div class="pre-area">
            
            <pre class="pre-code">
    &lt?php

    namespace spoova\mi\windows\Routes;

    use Installer;
    use Window;

    class Install extends Window{


        function __construct()
        {
            include_once(_core.'installer.php');

            $Install = new Installer;
            $Install->install();

            echo $Install->content();
        }


    }
            </pre>            
                        
                        </div>

                   </div>

                   
                </div> 
                <div class="foot-note font-em-d8 pvs-10">
                    Note that the web installer page should be relative to the type of route logic used. 
                    The code sample above is one that is designed for standard logic.
                </div>
                <br>

               <div class="setup calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Setup config</div>
                   <div class="font-em-d85 pxv-10">
   
                       <div>Basic configuration can be applied for live server, resource meta and session control</div> <br>
                       <ul class="list-square pxl-20">
                           <li> <span class="fb-6 c-sky-blue-dd">Live Server:</span> <br>
                               Spoova comes with an internal php live server (beta). 
                               Attached to the live server is a live debug system (beta) 
                               that runs upon the live server. The liveserver is mainly designed for local 
                               environment but can also be enabled in live environments. This follows 
                               the options listed below:
                               
                               <br><div class="mvs-6 i pvs-10">The live server can be configured as:</div>
                               <span class="c-orange-dd">"offline"</span> enables the live server for only offline environments
                               <br> <span class="c-green">"online"</span> enables the live server for both online and offline environments
                               <br> <span class="c-red">"disabled"</span> suspends the liveserver. <br>
                               <br>
                               It is important to know that there are cases when fatal error may occur during reload or before the live server 
                               is able to reload the page or when live server is switched off (either by code or settings), forcing the live server to trip off. This is known as <code>"KILL EFFECT"</code>. In this situation, 
                               the page must be manually reloaded after the fatal error is fixed or liveserver re-enabled before the liveserver can propely continue. However, 
                               if an error occurs while the live server is monitoring the page (before sending a reload request), then the live server
                               tries to pause the page from reloading while popping up a debug message it could properly match to the type of error that occured.
                               Once the error is fixed, the notification is removed and the page resumes its monitoring. The pop-up is still known to have few bugs as it might be sometimes glitchy.
                           </li><br>

                           <li> <span class="fb-6 c-sky-blue-dd">Resource Meta:</span> <br>
                               Spoova comes with an inbuilt meta tags controller. 
                               When activated, default environment (i.e $_ENV) meta tag settings are applied to all pages during resource importation. 
                               Resource importation is further discussed under <a href="<?= Rexit::domurl('docs/resource/grouping') ?>"><span class="c-olive ch-olive  calibri fb-6 font-em-d9 rule-dotted">Resource class</span></a> .
                           </li> <br>

                           <li> <span class="fb-6 c-sky-blue-dd">Database Control:</span> <br>
                               Sessions are handled putting into consideration, 
                               the frequently built systems which involves a
                               User-App relationship. In order to control a User-App flow or relationship, 
                               sessions are handled in relation with the database configuration systems. 
                               Building this relationship requires that certain default session-database configurations must be made when initializing a project application.
                               
                               <br><br>The required configurations are stated below: 
                               <br>
                               <br> <span class="fb-6 c-olive-d">1. USER_TABLE</span>
                               <br> <div class="pxs-14">
                                        This refers to the Database table name that contains all users basic information <br>
                                    
                                        <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  USER_TABLE: users;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">2. USER_ID_FIELDNAME</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table unique column set for identifying each user <br> 
                                    
                                       <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example: USER_ID_FIELDNAME: email;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">3. COOKIE_FIELDNAME</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table column set to store cookies used that may be used for remember me. <br>
                                        
                                        <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  COOKIE_FIELDNAME: cookie;</div>
                                        </div>
                                    </div>  
                               
                           </li> <br>

                           All respective config keys should be placed (or can be found) in the init file (i.e icore/init). 
                           These keys are automatically configured either by the web installer tool or the terminal during configuration. 
                       
                       </ul>
                       
                   </div>
               </div> <br>

               <div class="getting-ready calibri bc-white-dd setup">
                   
                   <div class="c-olive pxv-10 bc-silver">Getting ready</div>

                   
                   <div class="calibri font-em-d85 mvt-5 pxv-10">

                       Spoova does an automatic caliberation of project folder once it is created. It is suggested to keep the name of project folders strictly as 
                       strings without any special characters which may lead to undesired responses. The caliberation system enables the project app to properly 
                       configure the <code class="">.htaccess</code> file. 
   
                       <ul class="list-square mvt-10 pxl-20">
                           <li>
                               Upon a successful installation using the in-built installation tool, 
                               you will be redirected to your app's home page
                           </li> <br>
                           <li>
                               After installation, ensure that your application is properly configured by checking the following files: <br><br>

                               <span class="fb-6 c-orange-dd">.htaccess :</span> <br> Error document should point to your project folder name. <br><br>
                               
                               <span class="fb-6 c-orange-dd">icore/dbconfig.php :</span> <br> File should contain the correct definition of your database configuration for offline or online environments (or both) <br><br>

                               <span class="fb-6 c-orange-dd">icore/init :</span> <br> File should contain other configuration keys and respective values.<br><br>
                               
                               <span class="fb-6 c-orange-dd">Session control :</span> <br> The session class requires a user table which is defined in the "icore/init" file. This must be created before using session class.<br><br>

                               <div class="flex-in f-col shadow rad-4">
                                    <div class="box bc-silver c-orange-d pxv-6">
                                        Note
                                    </div>
                                    <div class="bc-white pxv-6 pxl-10 wid-full">
                                        <span class="">
                                            If any of the file above is not properly configured, you can do a manual installation by setting up the configuration keys in their relative configuration files.
                                        </span>
                                    </div>
                               </div>

                           </li>
                       </ul>
                       
                   </div>
               </div>
           </div>
       </section>
   </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>