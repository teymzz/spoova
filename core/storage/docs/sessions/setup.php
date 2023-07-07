
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

                <div class="font-em-1d5 c-orange"> <i class="bi-person-fill"></i> Sessions</div> <br>
                
                <div class="resource-intro">
                    <div class="">
                        <div class="">
                            Sessions are configured majorly through a base configuration file along with a top-level session defined keys. These two stages of configuration are listed and discussed below:

                            <br><br>
                            
                            <ul>
                                <li>Configuration of init file</li>
                                <li>Top level code configuration of session class</li>
                            </ul>

                            <div class="">
                                The documentation provided in this page are strictly for spoova 
                                <code>version 2.5</code>. For lesser documentations, visit the offline documentation of such versions.
                            </div>
                            
                        </div> 
                    </div> <br>

                    <div>
                        <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            Init File setup
                        </div> <br><br>

                        <div class="">
                            <div class=" font-em-d9">
                                The init file <code>icore/init</code> contains few configurations keys and values pairs 
                                that help the Session class to properly map itself to the database. 
                                The configuration keys are usually handled automatically from the command-line using the <code>config</code> 
                                command. The structure below reveals a sample format of how the configuration keys are expected to be defined.
                            </div>

                            <div class="code">
                            <!-- code begins -->
                            <div class="pre-area mvs-10">
                                <div class="pxv-10 bc-silver">
                                    Init File Sample Format
                                </div>
                                <pre class="pre-code">
  USER_TABLE: users;
  USER_ID_FIELDNAME: email;
  COOKIE_FIELDNAME: cookie;                    
                                </pre>
                            </div>

                            <!-- code description -->
                            <div class="foot-note">
                                The configuration keys and values above are used to explain the Session class control system just as explained earlier

                                <div class="">
                                    <div class="flex mvs-6">
                                        <div><code class="bd-f bc-white-dd">USER_TABLE:</code> <span>This table is expected to be the user table where user data is stored.</span></div>                                     
                                    </div>
                                    <div class="flex mvs-6">
                                        <div><code class="bd-f bc-white-dd">USER_ID_FIELDNAME:</code> <span>A database column in USER_TABLE that contains the user unique id</span></div>
                                    </div>
                                    <div class="flex mvs-6">
                                        <div><code class="bd-f bc-white-dd">COOKIE_FIELDNAME:</code> <span>A database column in USER_TABLE where cookie hash is stored</span></div>
                                    </div>
                                </div>

                                <div class="mvt-10">
                                    Once the <code>init</code> file is configured, the Session class can then be properly initialized within our application.
                                </div>
                            </div>                            
                        </div>
                        </div>        
                    </div> <br>
                        

                        <div class="mvt-10">
                            <div class="c-orange"> <i class="bi-lightning-fill"></i> Session Initialization</div>
                            <div class="mvt-10">
                                The session class can be initialized using the format below<br><br>

                                <div class="">
                                    <div class="pxv-10 bc-silver">
                                        Syntax: Session class initialization 
                                    </div>
                                    <div class="pre-area">
                                        <pre class="pre-code">
  new Session($session_key, $cookie_key, $secure);

  <span class="comment">
  where: 
    
    $session_key       : an array key where user data is stored on.

    $cookie_key        : an array key where rememberMe cookie hash is stored on.

    $secure (optional) : defines if a session should be secured (true|false)

    
    <span class="c-dry-blue">Note: For the purpose of this documentation</span>

    session_key => $session_key 

    cookie_key  => $cookie_key 

    secure      => $secure
  </span>
                                        </pre>
                                    </div>
                                    <div class="font-em-d87 pxv-10 bc-off-white-dd hide">
                                        The session class requires that a <code class="c">$session_key</code> should be defined. This key can be or any string but 
                                        it is advisable to use alphnumerical values for easy access. Th key is used by the 
                                        <code>User</code> class to store data when the <code>User::login()</code> method is called. The <code>$cookie_key</code>, 
                                        though optional, helps the <code>$_COOKIE</code> global variable to identify where to store a session user's cookie hash key which 
                                        is mostly used for remember me. Once both arguments are defined, The entire relationship between the <code>$_SESSION</code> and <code>$_COOKIE</code> 
                                        class will then be synced making it easier to either log in or log out of a session.
                                    </div> <br><br>

                                    <div class="">
                                        <div class="c-orange"> <i class="bi-person-add"></i> Session(session_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            The session_key defined during the instantiation of the session class is a key that is used to store user data inside 
                                            the global session storage. This key is expected to be a valid aphanumerical string.
                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="c-orange"> <i class="bi-key box" style="transform:rotate(45deg)"></i> Session(cookie_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            Just like the session_key, the <code>cookie_key</code> is used by the global cookie storage to store a user cookie which is mostly used for 
                                            rememberMe. Although, defining this key is optional, it is mostly required even if it is not used. When this value is defined, we can then set up a 
                                            remeberMe on our forms easily just by adding an input field with the name of remember. If a session is logged out but its access cookie is active, 
                                            the session class will look for the active value in the database table's field relative to <code>COOKIE_FIELD_NAME</code> declared in the init file. 
                                            This value will help to log the user back if the hashed value stored is active. It is important to note that setting this argument requires that 
                                            a <code>COOKIE_FIELD_NAME</code> key is defined in the <code>init</code> configuration file and the value of this key should be a field in the user's 
                                            database table where cookie hashes and values are either saved or obtained from.
                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="c-orange"><i class="bi-person-lock"></i> Session(secure)</div>

                                        <div class="font-em-d87 mvt-10">
                                           The <code>secure</code> argument which is the third argument of the <code>Session</code> instance deals more with session management. It is a way by which 
                                           a layer of security can be added to the session in such a way that the <code>"userid"</code> stored in session must exist in database. This ensures that a fake id cannot create an active session. 
                                           By setting  the "secure" argument as <code>true</code>, the Session class will validate the userid stored within the session class. 
                                           If the value does not exist in the <code>USER_ID_FIELDNAME</code> database column name defined in init file, the session will be nullified. The 
                                           <code>Session::secure()</code> method can also be used to achieve the same effect and it takes the argument of <code>true</code> or <code>false</code>. 
                                           In order to validate the <code>userid</code> of the current session user, the database connection must be active. 
                                        </div><br>
                                    </div>
                                </div>

                                <div class="">

                                    <div class="">
                                        <div class="c-orange"> <i class="bi-key"></i> Session linkage</div>

                                        <div class="font-em-d87 mvt-10">
                                            In order to have access to the session class, we need a way to link the session to routes which in turn makes use of these session information. 
                                            In earier versions of the framework, the linking of a session to routes can be done through session channels. However, starting from <code>version 2.5</code>, we can  
                                            start our session using the window's <code>frame()</code> method which is inherited from the root <code>Window</code> class. An example is shown below:
                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="pxv-10 bc-silver">
                                            Session: Instantiation
                                        </div>
                                        <div class="pre-area">
                                            <pre class="pre-code">
  &lt;?php

  namespace spoova\mi\windows\sessions;

  use Window

  class UserSession extends Window {


    static function frame() {

        new Session('user', 'user_cookie', true);

    }



  }
                                            </pre>
                                        </div>
                                    </div>

                                    <div class="foot-note">
                                        The sample above illustrates how to initialize the <code>Session</code> class from a frame file. While the 
                                        first argument and second argument are mostly required, the third is not required unless we want the Session class 
                                        to always validate the session id. Once we define our session, we can then link to the session from our routes just as shown below:
                                    </div>
                                    <div class="pre-area">
                                        <pre class="pre-code">
  &lt;?php

  namespace spoova\mi\windows\Routes\Home;

  use Window
  use spoova\mi\windows\sessions\UserSession


  class Home extends UserSession {


    function __construct() {

        vdump(User::config()); <span class="comment">// view configuration</span>

    }


  }
                                        </pre>
                                    </div>
                                    <div class="foot-note">
                                        In the <code>Home</code> route above, we linked to the session through the <code>UserSession</code> class. Once we successfully link the route, 
                                        we can use the <code>User::config()</code> method to detect if the session is successfully linked. The array returned which has two keys which are 
                                        <code>SESSION_NAME</code> and <code>COOKIE_NAME</code> should have their values as <code>"user"</code> and <code>"user_cookie"</code> respectively. 
                                        Once these values are displayed, it means the configuration keys are successfully defined and accessible. We can also obtain any of these keys by 
                                        using <code>Session::sessionName()</code> or <code>Session::cookieName()</code> respectively or we can do this similarly through the <code>User</code> 
                                        class with <code>User::sessionName()</code> and <code>User::cookieName()</code> methods.
                                    </div>
                                </div> <br>

                                
                                <!-- sessionName, cookieName -->
                                <div class="">
                                    <div class="mvs-4 c-orange"> <i class="bi-image-alt"></i> sessionName() and cookieName()</div>
                                    <div class=" font-em-d9">

                                        <div class="mvs-10">
                                            The <code>Session::sessionName()</code> and <code>Session::cookieName()</code> as explained earlier, are 
                                            both methods that retrives the session_key and cookie_key storage key names once defined. Example of this is 
                                            shown below:
                                        </div>

                            <div class="code mvs-10">  
                                <div class="pxv-10 bc-silver">
                                            Syntax: sessionName(), cookieName()
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  new Session::('user', 'usercookie'); <span class="comment no-select">//instance of session</span> 

  Session::sessionName(); <span class="comment no-select">//user</span>   

  Session::cookieName(); <span class="comment no-select">//usercookie</span>    
                                                </pre>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!-- stream -->
                                <div class="">
                                    <div class="mvs-4 c-orange"> <i class="bi-repeat"></i> Session::stream()</div>
                                    <div class="font-em-d9">

                                        <div class="mvs-10">
                                            The <code>Session::stream()</code> method is used to return the last instance of the session class. This can be after the <code>User</code> class or 
                                            the session class is instantiated. Mostly, the session is defined once at the top of the application, in order to access this instance, we can use the 
                                            <code>stream()</code> method later in the application. 
                                        </div>

                                        <div class="code mvs-10">  
                                            <div class="pxv-10 bc-silver">
                                                        Syntax: Session::stream
                                            </div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  new Session::('user', 'usercookie'); <span class="comment no-select">//instance of session</span> 

  Session::stream(); <span class="comment no-select">//fetch the instance of the session back</span>    
                                                </pre>
                                            </div>
                                        </div>

                                    </div>
                                </div> 

                                <!-- userid -->
                                <div class="">
                                    <div class="mvs-4 c-orange"> <i class="bi-person-check"></i> Session::userid()</div>
                                    <div class="font-em-d9">

                                        <div class="mvs-10">
                                            The <code>Session::userid()</code> method is used to fetch the current user id of the session class. 
                                            Once a session is active, the userid can easily be obtained through the use of this method as long as the 
                                            session contains the specified session userid key. Once the user session is successfully created through the 
                                            <code>User::login()</code> method, we can easily obtain the user id of the current session by calling the 
                                            <code>User::id()</code> or the <code>Session::userid()</code> method. The sample below shows how the user id can be added such that it can be obtained later.
                                        </div>

                                        <div class="code mvs-10">  
                                            <div class="pxv-10 bc-silver">
                                                        Syntax: Session::userid()
                                            </div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $data = ['userid' => 'some_id'] <span class="comment no-select">//test data</span> 

  User::login($data); <span class="comment no-select">//add userid into the session</span>    
                                                </pre>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="foot-note">
                                    In the code sample above, the <code>User::login()</code> will try to set the userid of the current user through the specified array key "userid". If the 
                                    session is set as secure, the session class will go on to validate the specified id. If the id (i.e some_id) corresponds to the id of the user in the pre-configured user table, 
                                    and preconfigured id field, then the id will be accepted and we can obtain the user id back through the <code>User::id()</code> or <code>Session::id()</code>. However, if the 
                                    id cannot be validated, it will be nullified making it impossible to fetch the specified user id. If the <code>secure</code> part of the session is set as false or not specified during instantiation, 
                                    the session id will not be validated.
                                    Other methods of the session class are explained under <a href="<?= Rexit::domlink('docs.sessions.management') ?>" class="c-olive rule-dotted">session management</a>
                                </div>  

                            </div>
                        </div>

                    </div> 
                </div> <br>


                <div class="hide">

                    <!-- stream -->
                    <div class="">
                        <div class="mvs-4 c-orange"> <i class="bi-repeat"></i> stream()</div>
                        <div class="font-em-d9">

                            <div class="mvs-10">
                                This method returns the instance of the session class. Once a session is initialized be defining the session_key and cookie_key, accessing the current session 
                                at a lower level of the application can only be achieved without any data loss by fetching the last instance of that session class. The instance of the session 
                                can be retrieved by using the <code>Session::stream()</code> method. which can be accessed at any level of the application. Example is shown below: 
                            </div>

                            <div class="code mvs-10">  
                                <div class="pxv-10 bc-silver">
                                            Syntax: Session::stream
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  new Session::('user', 'usercookie'); <span class="comment no-select">//instance of session</span> 

  Session::stream(); <span class="comment no-select">//fetch the instance of the session back</span>    
                                    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>


                    <!-- onauto -->
                    <div class="mvt-20">
                        <div class="mvs-4 c-orange"> <i class="bi-reply-all"></i> onauto()</div>
                        <div class=" font-em-d9">
                            The <code>Session::onauto()</code> method is an alias for <code>Session::stream()->auto()</code> method. It manages redirection of session class. It is used to perform redirection 
                            when a session is active or inactive to enforce a redirection. The syntax is shown below
                            <br><br>

                            <div class="code">  
                                <div class="pxv-10 bc-silver">
                                    Syntax: Session::onauto
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  Session::onauto([logout|login], url)

  <span class="comment">
  where: 
    
    login      : option to redirect only when session is active 

    logout     : option to redirect only when session is not active

    url : define the url to be redirected to.
  </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="foot-note">
                                As an example in relation to the code syntax above, redirection from a <code>user</code> page to an <code>index</code> page when account becomes inactive 
                                or session is terminated will require that the user page should have a code syntax similar to <code>Session::onauto('logout', 'index')</code>. 
                                By placing such code in the <code>user</code> page, the <code>user</code> page will redirect to the <code>index</code> 
                                page once the session is terminated. Likewise, an <code>index</code> page can be enforced to redirect to an <code>home</code> page if a session is active. This means that the 
                                <code>index</code> page will have a code similar to <code>Session::onauto('login', 'home')</code>.  
                            </div>

                        </div>
                    </div> <br>

                </div>

                <div class="hide">
                    <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                        Session::userid()
                    </div> <br><br>


                    <div class="">
                        <div class=" font-em-d9">
                        The <code>Session::userid()</code> method returns an active session id. For the Session class to successfully return the userid, 
                        the data stored in the in the <code>$_SESSION</code> variable must contain a <code>userid</code> key, that is, 
                        <code>$_SESSION['session_key']['userid']</code>. The value of this is then returned by the <code>userid()</code> method. 
                        It is not advisable to set this key manually form the <code>$_SESSION</code> variable. The data should be stored by the  
                        <code>User</code> class which is an extension of the Session class itself. Learn more about this from <a href="<?= Rexit::domurl('docs/useraccounts') ?>" class="hyperlink">User accounts</a>
                        </div> <br>
                    </div>       
                     
                </div><br>    

            
                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>

            </div>
        </div>
    </section>
</div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>