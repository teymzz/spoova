

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
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
<body>

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
               <li> <a href="<?= DomUrl('docs/directives') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Directives</a> </li>
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-20 tutorial mails bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4">   </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Cli Commands</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
              The cli commands are spoova directives that can be used in the cli environment to modify or update
              the developers' project app. The spoova cli commands can only be run from the core folder
              <br><br>
              
              For the purpose of file structuring, it is believed that vendor folder should be part of the core 
              framework. All core applications and classes are stored within the core folder which is the reason 
              for placing vendor folder into core folder.
            </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Commands </div>

            </div> <br>
            
            <div>
                A list of helpful cli command are listed below with their descriptions
            </div> <br>
          </div>  

          <div class="">
            <ul>
              <li><a href="#add">add</a></li>
              <li><a href="#add-window">add:window</a></li>
              <li><a href="#add-model">add:model</a></li>
              <li><a href="#add-frame">add:frame</a></li>
              <li><a href="#add-route">add:route</a></li>
              <li><a href="#add-api">add:api</a></li>
              <li><a href="#add-rex">add:rex</a></li> 
              <li><a href="#clean-storage">clean storage</a></li> 
              <li><a href="#config-dbonline">config:dbonline</a></li>
              <li><a href="#config-dbonline">config:dboffline</a></li>
              <li><a href="#config-usersTable">config:usersTable</a></li>
              <li><a href="#config-cookieField">config:cookieField</a></li>
              <li><a href="#config-idField">config:idField</a></li>
              <li><a href="#config-meta">config:meta</a></li>
              <li><a href="#cli">cli</a></li>
              <li><a href="#features">features</a></li>
              <li><a href="#info">info</a></li>
              <li><a href="#install">install</a></li>
              <li><a href="#project">project &lt;project_name&gt;</a></li>
              <li><a href="#support">support</a></li>
              <li><a href="#version">version</a></li>
              <li><a href="#watch">watch</a></li>
            </ul>
          </div>
          
          <div id="add"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add</div>

            </div>
            
            <div>

                <div class="pvs-10">
                  The "add" directive is being used to add a new file. List of files that can be added are:
                </div>

                <ul>
                  <li>windows</li>
                  <li>frames</li>
                  <li>routes</li>
                  <li>apis</li>
                  <li>models</li>
                  <li>rex (template file)</li>
                </ul>
            </div> 
          </div>          
          
          <div id="add-window"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:window </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to create a window file into the window directory or subdirectory. If such path does not exist, the folder 
                will automatically be generated as a subdirectory of the window directory. Path supplied 
                can be in form of slashes or dots. When the path is not supplied, the file will be added directly into the window directory.
              </div>
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:window &lt;dir?&gt;&lt;windowName&gt; &lt;extends?&gt; [-O?];
  <span class="comment">
    where: 

        name => name of controller file
        path => optional path to contoller file
    
        
    Ex1: <span class="c-orange-dd">php mi add:window Info</span>   <span class="no-select">//add <span class="c-teal">windows/Info.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:window Info.User</span> <span class="no-select">//add <span class="c-teal">windows/Info/User.php</span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:api Info.User UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Info/User.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:api Info UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span> overwrite any previous file.</span> </span> </span>
                </span>
                </pre>

              </div>
            </div> 
          </div> 
          
          <div id="add-frame"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:frame </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This "frame" command is used to create a frame file into a "windows/frames" directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:frame &lt;path&gt; [-O?]
  <span class="comment">
    where: 

        path => path to frame file within Frames directory
        [-O] => overwrite old file (optional)
        
    Ex1: <span class="c-orange-dd">php mi add:frame Info</span>   <span class="no-select">//add <span class="c-teal">windows/Frames/Info.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:frame Info.UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Frames/Info/UserFrame.php </span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:api Info.UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Info/UserFrame.php <span class="comment"> overwrite any previous file.</span> </span> </span>

  </span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="add-routes"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:route </div>
            </div>
            
            <div>
                <div class="pvs-10">
                  This "route" command is used to create a route entry point file into a "windows/Routes" directory which is a subdirectory of the windows folder (directory).
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:route &lt;path&gt; &lt;extends?&gt; [-O?]
  <span class="comment">
    where: 

        path => path of route file within window/Routes directory
        extends => extend to frame file
        -O => Overwrite any existing file.
            
    Ex1: <span class="c-orange-dd">php mi add:route MyRoute</span>   <span class="no-select">//add <span class="c-teal">windows/Routes/MyRoute.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:route Loc.MyRoute</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php. </span>
    Ex3: <span class="c-orange-dd">php mi add:route Loc.MyRoute UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:route Loc.MyRoute UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span> overwrite any previous file.</span> </span> </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="add-api"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:api </div>

            </div>
            
            <div>
              <div class="pvs-10">
                This "api" command is used to create a routed api files into a "windows/API" directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:api [name] [extends?] [\Dir?] [-O?]
  <span class="comment">
    where: 

        name => name of api route
        extends? => extended frame class
        \Dir => directory of api route 
        -O   => overwrite any previous file   
    
    Ex1: <span class="c-orange-dd">php mi add:api Info</span>   <span class="no-select">//add <span class="c-teal">windows/Info.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:api Info \Loc</span> <span class="no-select">//add <span class="c-teal">windows/Info.php, <span class="comment">add</span> windows/Loc/InfoAPI.php</span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:api Info UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:api Info UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span> overwrite any previous file.</span> </span> </span>
    Ex5: <span class="c-orange-dd">php mi add:api Info UserFrame \Loc -O</span> <span class="no-select">//add <span class="c-teal">windows/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames/UserFrame</span>, add <span class="c-teal">windows/Loc/InfoAPI.php</span>, overwrite any previous file.</span> </span> </span>

  </span>
                </pre>
              </div>
            </div>

          </div> 
          
          <div id="add-model"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:model </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This model command is used to create a model file into a models directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:model &lt;path&gt; [-O?]
  <span class="comment">
    where: 

      path => path to model file within the windows/Models directory.
      -O => overwrite any previous file.

    Ex1: <span class="c-orange-dd">php mi add:model UserModel</span>            <span class="no-select">//add <span class="c-teal">windows/Models/UserModel.php</span> </span>
    Ex2: <span class="c-orange-dd">php mi add:model Access.UserModel</span>     <span class="no-select">//add <span class="c-teal">windows/Models/Access/UserModel.php</span> </span>
    Ex3: <span class="c-orange-dd">php mi add:model Access.UserModel -O</span>  <span class="no-select">//add <span class="c-teal">windows/Models/Access/UserModel.php</span>, overwrite previous file </span>

  </span>
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="add-rex"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:rex </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to create a template rex file into the <code>windows/Rex</code> directory.
                Path supplied can be in form of dots or slashes. When adding the file name,
                only name should be added without any file extension. The type of rex file can be supplied 
                using the column directive. However if no type is defined, then the rex file will assume a default 
                extension of <code>php</code>.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:rex  &lt;pathname&gt;.&lt;filename&gt;&lt;:ext?&gt;
  <span class="comment">
    where: 

      filename => name of rex file
      pathname => optional path to contoller file
      :ext     => options [:css|:js|:php]


    Ex1: <span class="c-orange-dd">php mi add:rex index</span>            <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.php</span> </span>
    Ex2: <span class="c-orange-dd">php mi add:rex index:css</span>        <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.css</span> </span>
    Ex3: <span class="c-orange-dd">php mi add:rex index:js</span>         <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.js</span> </span>
    Ex4: <span class="c-orange-dd">php mi add:rex build.index:css</span>  <span class="no-select">//add <span class="c-teal">windows/Rex/build/index.rex.css</span> </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="clean-storage"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> clean storage </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to clean storage files. When executed, this will remove all storage files from the storage path.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi clean storage
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="config-dbonline"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dbonline </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This configures the online database connection parameters. Online parameters 
                are used when working on live environment.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:dbonline "dbname dbuser dbpass dbserver dbport dbsocket"
  <span class="comment">
    where: 

        <span class="c-orange">dbname</span> => database name
        <span class="c-orange">dbuser</span> => database username
        <span class="c-orange">dbpass</span> => database password 
        <span class="c-orange">dbserver</span> => database server
        <span class="c-orange">dbport</span> => database port 
        <span class="c-orange">dbsocket</span> => database socket

        NOTE: Empty values are replaced with dash (i.e "-")

        Ex: <span class="c-orange-dd">php mi config:dbonline "tester root - localhost 3306" </span>  <span class="no-select">//set online database connection parameters </span>

  </span>
                </pre>

</div>
            </div> 
          </div> 
          
          <div id="config-dboffline"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dboffline </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Similarly to <code>dbonline</code>, the <code>dboffline</code> is used to configures the online database 
                  connection parameters. The offline connection parameters are also triggered to be used to connect to database 
                  locally.
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:dboffline "dbname dbuser dbpass dbserver dbport dbsocket"
  <span class="comment">
    where: 


        <span class="c-orange">dbname</span> => database name
        <span class="c-orange">dbuser</span> => database username
        <span class="c-orange">dbpass</span> => database password 
        <span class="c-orange">dbserver</span> => database server
        <span class="c-orange">dbport</span> => database port 
        <span class="c-orange">dbsocket</span> => database socket

        NOTE: Empty values are replaced with dash (i.e "-")

        Ex: <span class="c-orange-dd">php mi config:dbonline "tester root - localhost 3306" </span>  <span class="no-select">//set offline database connection parameters </span>

  </span>
                </pre>

              </div>

              <div class="pre-area shadow">
                <div class="bc-silver pxv-6">Example</div>
                <pre class="pre-code">
  <span class="c-lime-dd">php mi</span> <span class="c-orange-dd">config:dboffline</span><span class="c-violet-dd"> <abbr title="">"mydatabase</abbr> <abbr title="">root</abbr> <abbr title="">-</abbr> <abbr title="">localhost</abbr> <abbr title="">3307</abbr> <abbr title="">-</abbr>"</span>
  <span class="comment">
    where: 

      mydatabase => database name
      root       => database username
      -          => database password (empty) 
      localhost  => database server
      3307       => database port 
      -          => socket (empty)
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="config-userstable"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:usersTable </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This configures the users table name in a given database. This table is expected to contain the user information 
                such as user id or unique id field that can be used to trace a user.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:usersTable tablename
  <span class="comment">
    where: 

      tablename => name of database table

      Ex: <span class="c-orange-dd">php mi config:userTable users</span>  <span class="no-select">//set database user info table</span>
  </span>

                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="config-cookiefield"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:cookieField </div>

            </div>
            
            <div>

              <div class="pvs-10">
                In most login-logout system, users tend to keep records such as "rememberMe" which enables users to be able 
                to login without difficulty. The cookie field can be used to store a cookie token than can be retrieved for 
                logging in. Although it is not a neccesity to have a cookie field in the database user's table, yet, it is
                important to have a structure in place that supports this. Hence spoova suggests that for every project application, 
                a cookie field should exist in the selected database user's table. The name of this cookie field should be supplied 
                for use when logging in or out of an application.  
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:cookieField tablename
  <span class="comment">
    where: 

      tablename => name of database table

      Ex: <span class="c-orange-dd">php mi config:cookieField cookie </span>  <span class="no-select">//set cookie column in user info table </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 
                  
          <div id="config-idField"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:idField </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Every login-logout system, requires that a user should have an identification number or string. Spoova naturally 
                  do not assume the user id column (or field) name is usually an integer field or usually named "id". Instead, a name 
                  must be supplied which helps spoova to locate the user id column from the user table already set. The id field used may 
                  be a unique field (e.g email, id, phone. e.t.c) 
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:idField column
  <span class="comment">
    where: 

      column => name id column

      Ex: <span class="c-orange-dd">php mi config:idField email</span>  <span class="no-select">//set user id column name in user table</span>

  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="config-meta"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:meta </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  If meta tags are configured by default to be loaded by the resource class automatically, when importing static files using any of the resource 
                  importer function, method or directives (e.g <code>&lt;?= Res::import() &gt;</code>, <code>&#64;Res()</code>), the resource class
                  will build meta tags using the configuration set in <code>icore/filemeta.php</code> file and the predefined meta tags will be added only once to the webpage. 
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:meta [on|off]
  <span class="comment">
    where: 

      on  => switches automatic importation on 
      off => switches automatic importation off

      Ex: <span class="c-orange-dd">php mi config:meta on</span>  <span class="no-select">//set meta tags autoloading from <span class="c-teal">icore/filemeta.php</span> configuration on </span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="cli"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-code mxr-8 c-lime-dd"></span> cli </div>

            </div> <br>
            
            <div>
                The <code>cli</code> directive shows a list of available cli commands. When the <code>-lists</code> 
                directive is applied, more details of cli commands are displayed.

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi cli [-lists]
  <span class="comment">
    where: 

      -list  => optional directive to display more information on cli commands

      Ex: <span class="c-orange-dd">php mi cli -lists </span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="features"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> features </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  This command shows a list of spoova features
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi features
  <span class="comment">
    where: 

      features  => shows a list of available features
  </span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="info"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-info-circle mxr-8 c-lime-dd"></span> info </div>

            </div>
            
            <div>

              <div class="pvs-10">
                The <code>info</code> command is used to show a description of a particular command.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi info &lt;command&gt;
  <span class="comment">
    where: 

      command  => cli command name (e.g add:window)

      Ex1: <span class="c-orange-dd">php mi info add:window</span>  <span class="no-select">//displays description for "add:window" command</span>
      Ex2: <span class="c-orange-dd">php mi info add:routes</span>  <span class="no-select">//displays description for "add:routes" command</span>
      Ex3: <span class="c-orange-dd">php mi info "watch status"</span>  <span class="no-select">//displays description for "watch status" command</span>
  </span>
      <span class="c-teal"><span class="bi-circle-fill"></span> You can view a list of available commands using <code>php mi cli -lists</code></span>
               </pre>


              </div>
            </div> 
          </div> 

          <div id="install"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-download mxr-8 c-lime-dd"></span> Install </div>
            </div>
            
            <div>

                <div class="pvs-10">
                  This command installs the entire spoova application by testing all configuration parameters supplied for database
                  and the entire application. It also creates neccessary database if the selected database name does not exist 
                  as long as the database connection parameters have been properly set. When no option is supplied, then the entire 
                  application is installed. Specific options performs their relative functions as shown below.
                </div>


              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi install [db|dbname] [folder?]
  <span class="comment">
    where: 

      db     => test the database connection parameters defined in "icore/dbconfig.php" file 
      dbname => creates default database name supplied in "icore/dbconfig.php" file using the defined connection parameters
      folder => refers to an optional custom folder name in project root that contains an "icore/dbconfig.php" file with connection parameters.
  </span>
                </pre>

              </div>
            </div> 
          </div> <br>

          <div id="project"> 
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> project  </div>
                <div class="flex mid">
                  <span class="bi-chevron-double-right"></span>
                </div>
              </div> 
              
              <div>

                  <div class="pvs-10">
                    This command is used to create a new separate project application. This should be done from the 
                    spoova project pack directory. When a new project file is created using the cli, all essential mapping 
                    of file to the current enviroment is done. It is highly suggested to create a new project app 
                    using the cli which ensures that the new project app is essentially ready for configuration.
                  </div>


                <div class="pre-area shadow">
                  <div class="pxv-6 bc-silver">Syntax</div>
                  <pre class="pre-code">
  php mi project &lt;project_name&gt;
  <span class="comment">
    where: 

      project_name => name of new project application

      Ex: <span class="c-orange-dd">php mi project lumen</span>  <span class="no-select">//create separate project name "lumen"</span>
  </span>
                  </pre>

                </div>
              </div> 
          </div> <br>

          <div id="support"> 
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> support </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  This command displays the current support of spoova frame in terms of php version, mysql server,
                  web servers and other essential informations.
                </div>


              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi support
                </pre>
              </div>
            </div> 
          </div> 

          <div id="version"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> version </div>
            </div>
            
            <div>

                <div class="pvs-10">
                  This command displays the current version of spoova frame
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi version
                </pre>
              </div>
            </div> 
          </div> 
                  
          <div id="watch"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-clock mxr-8 c-lime-dd"></span> watch </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Watch is the inbuilt spoova live server system. This system can be switched to online or offline or disabled mode. 
                </div>
            

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi watch [online|offline|disabled|status]
  <span class="comment">
    where: 

      online    => sets watch for both offline and online environments
      offline   => sets watch for offline environment only
      disabled  => disables the watch entirely for both environments
      status    => get the current configuration status of watch

      Ex1: <span class="c-orange-dd">php mi watch online  </span>  <span class="no-select">//set watch to online and offline environments </span>
      Ex2: <span class="c-orange-dd">php mi watch offline </span>  <span class="no-select">//set watch to offline environment </span>
      Ex3: <span class="c-orange-dd">php mi watch disabled</span>  <span class="no-select">//set watch to disabled mode </span>
      Ex4: <span class="c-orange-dd">php mi watch status</span>    <span class="no-select">//get current watch status.</span>

  </span>
                </pre>

              </div>
            </div> 
          </div> 
          
        </div>
      </div>
    </section>

  </div>

  


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>

