



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png" />
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



   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxv-20 tutorial bc-white">
           <div class="font-em-1d2">

               
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/installation">Installation</a>  </div>


               <div class="start">
                   <div class="font-em-1d5 c-orange">Installation</div>
                   
                   <div class="font-em-d8 c-black-ll">
                       It is strongly advised to learn about the features of this framework
                       before proceeding with installation. You can learn about the features 
                       <span class="c-orange-dd">
                           <a href="<?= DomUrl('about') ?>" class="inherit">here</a>
                       </span> 
                   </div> <br>

                   <div class="calibri bc-white-dd">
                       <div class="c-olive pxv-10 bc-silver">Application config</div>
    
                       <div class="font-em-d85 pxv-10">
       
                           <ul class="list-square pxl-20">
                               <li>Download the spoova frame project pack file</li>
                               <li>Place the project pack into your root web folder (offline)</li>
                               <li>Open spoova project pack in the terminal</li>
                               <li>Run the command : <span class="fb-6 c-black-ll"> php mi project <span class="c-gold-dd">app</span></span> where "app" is your new project folder name </li>
                               <li>Follow the console directives to generate your project app</li>
                               <li>Configuration of new project app can be done through web installer page (if allowed before generation) or through the command line</li>
                               <li>Open the new project app in your editor's (e.g vscode) terminal for configuration</li>
                               <li>Run the command <code>php mi config:all</code> to configure your new project app</li>
                               <li>During configuration, database parameters must be within quotes (e.g <code>"dbname dbuser dbpass dbserver dbport dbsocket"</code>)</li> 
                               <li>Database parameters should be filled with valid details while empty parameters should be set as dash (i.e -)</code></li>
                               <li>For spoova to run efficiently, database configuration along with other basic configurations should be updated with valid credentials. </li>
                               <li>All database configurations are saved into the icore/dbconfig.php file for both offline and online environments.</li>
                               <li>When using the inbuilt web installation tool, you can choose the hard install (e.g http://localhost/app/install?refresh) option on the home page to reset previously defined configurations. </li>
                           </ul>
                           <div class="bc-silver rad-3 flow-x flex font-em-d85 pvs-10 pxs-10"> 
                            <div class="box bc-red-dd bd-1 bd-red-dd pxv-4 c-white-d no-wrap"> <span class="bi-exclamation-triangle"></span> Note:</div> 
                            <div class="box bd-1 bd-silver-d pxv-4 wid-full">It is highly discourged to use the spoova source pack as project folder.</div>
                           </div>
                       </div>
                   </div> <br>
                   
               </div>

               <div class="install-page calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Install Page Code</div>
                   <div class="font-em-d8 pxv-10 no-select">
                   
                        If the installation route page (e.g http://localhost/app/install) is missing, 
                        you can access the installation page by creating a new route into the <code>windows/Routes</code> 
                        directory and adding the following code: 

                   </div>

                   <div class="font-em-d8">

                        <div class="pre-area">
            
            <pre class="pre-code">
    &lt?php

    namespace spoova\windows\Routes;

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
                <div class="foot-note font-em-d8 pvs-10">Note that the web installer page must be relative to the route logic used.</div>
                <br>

               <div class="setup calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Setup config</div>
                   <div class="font-em-d85 pxv-10">
   
                       <ul class="list-square pxl-20">
                           <li>Basic setup includes live server, resource meta and session control</li>
                           <li> <span class="fb-6 c-sky-blue-dd">Live Server:</span> <br>
                               Spoova comes with an internal php live server (beta). 
                               Attached to the live server is a live debug system (beta) 
                               that runs upon the live server. The Live server is mainly build for local 
                               environment but can also be enabled for both online and offline environments. This follows 
                               the option listed below:
                               
                               <br><div class="mvs-6 i pvs-10">Setting your resource can be for:</div>
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
                               Resource importation is further discussed under <a href="<?= DomUrl('docs/resource/grouping') ?>"><span class="c-olive ch-olive font-menu calibri fb-6 font-em-d9 hyperlink">Resource class</span></a> .
                           </li> <br>

                           <li> <span class="fb-6 c-sky-blue-dd">Database Control:</span> <br>
                               Sessions are handled putting into consideration, 
                               the frequently built app systems which involves the
                               User-App relationship. In order to control the User-App flow, 
                               Sessions are handled in relation with the database configuration systems. 
                               In order to recognize this flow, certain default session-database configurations must be made when initializing your application.
                               
                               <br><br>The required configurations are stated below: 
                               <br>
                               <br> <span class="fb-6 c-olive-d">1. User Database Table Name (USER_TABLE) :</span>
                               <br> <div class="pxs-14">
                                        This refers to the Database table name that contains all users basic information <br>
                                    
                                        <div class="pxs-14 box span-btns c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  USER_TABLE: users;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">2. User Database Table ID Field (USER_ID_FIELDNAME):</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table unique column set for identifying each user <br> 
                                    
                                       <div class="pxs-14 box span-btns c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example: USER_ID_FIELDNAME: email;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">3. User Database Table Cookie Field (COOKIE_FIELDNAME):</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table column set to store cookies used that may be used for remember me. <br>
                                        
                                        <div class="pxs-14 box span-btns c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  COOKIE_FIELDNAME: cookie;</div>
                                        </div>
                                    </div>  
                               
                           </li> <br>

                           All respective config keys should be placed (or can be found) in the init file (i.e icore/init). 
                           By using the web browser installation tool, these fields will be automatically added at each installation phase once configured.
                       
                       </ul>
                       
                   </div>
               </div> <br>

               <div class="getting-ready calibri bc-white-dd">
                   
                   <div class="c-olive pxv-10 bc-silver">Getting ready</div>

                   
                   <div class="calibri font-em-d8 mvt-5 pxv-10">

                       Spoova does an automatic caliberation of project folder once it is created. It is suggested to keep the name of project folders strictly as 
                       strings without any special characters which may lead to undesired responses. The caliberation system enables the project app to properly 
                       configure the <code class="font-menu">.htaccess</code>. 
   
                       <ul class="list-square mvt-10 pxl-20">
                           <li>
                               Upon a successful installation using the in-built installation tool, 
                               you will be redirected to your app's home page
                           </li> <br>
                           <li>
                               Ensure that your application is properly configured by checking the following files: <br><br>

                               <span class="fb-6 c-orange-dd">.htaccess :</span> <br> Error document should point to your project folder name. <br><br>
                               
                               <span class="fb-6 c-orange-dd">icore/dbconfig.php :</span> <br> File should contain the correct definition of your database configuration for offline or online environments (or both) <br><br>

                               <span class="fb-6 c-orange-dd">icore/init :</span> <br> File should contain other configuration keys and respective values.<br><br>
                               
                               <span class="fb-6 c-orange-dd">Session control :</span> <br> The session class requires a user table which is defined in the "icore/init" file. This must be created before using session class.<br><br>

                               <div class="flex-in midv shadow rad-4">
                                    <div class="box bc-orange c-white-d pxv-6">
                                        Note
                                    </div>
                                    <div class="bc-white-d pxv-6 pxl-10 -full">
                                        <span class="">
                                            If any of the file above is not properly configured, you can do a manual installation by configuring the required keys yourself.
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