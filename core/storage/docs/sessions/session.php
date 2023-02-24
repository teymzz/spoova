

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
    <section class="pxv-20 tutorial database bc-white">
        <div class="font-em-1d2">

            
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions">Sessions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions/session">Session</a>  </div>


            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Sessions</div> <br>
                
                <div class="resource-intro">
                    <div class="">
                        Sessions are controlled by the session class which includes some important helper methods. 
                        The session configuration is mainly handled by the <code>icore/init</code> file. This means that the 
                        init file and the Session class are both linked. For session to be properly managed, the <code>init</code> 
                        file must be configured with valid parameteer. The code below reveals the syntax of the <code>init</code> 
                        file.
                        <br>

                        <div class="code">
                            <!-- code begins -->
                            <div class="pre-area mvs-10">
                            <div class="pxv-10 bc-silver">
                                Init File Sample Format
                            </div>
                            <pre class="pre-code">
  USER_TABLE: users;
  COOKIE_FIELDNAME: cookie;
  USER_ID_FIELDNAME: email;
  ...                                         
                                </pre>
                            </div>

                            <!-- code description -->
                            <div class="font-em-d87">
                                The setup syntax above is used to explain the Session class control system 

                                <div class="">
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>USER_TABLE:</code> <span>This table is expected to be the user table where user data is stored.</span></div>                                     
                                    </div>
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>COOKIE_FIELDNAME:</code> <span>A database column in USER_TABLE where cookie hash is stored</span></div>
                                    </div>
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>USER_ID_FIELDNAME:</code> <span>A database column in USER_TABLE that contains the user unique id</span></div>
                                    </div>
                                </div>

                                <div class="mvt-10">
                                    Once the <code>init</code> file is configured, the Session class can then be properly initialized within our application.
                                </div>
                            </div>                            
                        </div> <br>
                        

                        <div class="mvt-10">
                            <div class="c-orange">Session Initialization</div>
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


    
    Note: For the purpose of this documentation 

    $session_key => session_key 

    $cookie_key  => cookie_key 

    $secure      => secure
  </span>
                                        </pre>
                                    </div>
                                    <div class="font-em-d87 pxv-10 bc-off-white-dd hide">
                                        The session class requires that a <code class="c">$session_key</code> should be defined. This key will be used 
                                        by <code>$_SESSION</code> to store the user data once logged into a session. The <code>$cookie_key</code>, 
                                        though optional, helps the <code>$_COOKIE</code> global variable to identify where to store a cookie hash key.
                                        The entire relationship between the <code>$_SESSION</code> and <code>$_COOKIE</code> class will then be synced. Once 
                                        the relationship is defined, then we can log in or log out of a session with ease.
                                    </div> <br><br>

                                    <div class="">
                                        <div class="">Session(session_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            The session_key defined during the instantiation of the session class is a key that is used to store user data inside 
                                            the global <code>$_SESSION</code> variable. Hence, we can retrieve our data using the defined session_key 
                                            (e.g <code>$_SESSION[session_key]</code>). The session class requires that data stored in the 
                                            <code>$_SESSION[session_key]</code> must have a <code>userid</code>. This means that our session variable will be in the format 

                                            <code>$_SESSION[session_key]['userid']</code>. The session class will look for its userid from the <code>USER_ID_FIELDNAME</code> 

                                            (e.g email) column that must exist in the database.

                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="">Session(cookie_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            Just like the session_key, the cookie_key is used by the <code>$_COOKIE</code> class to store a user cookie for rememberMe. 
                                            Although, defining this key is optional, it is mostly required even if it is not used. When this value is defined, we can then set up a 
                                            remeberMe on our forms easily. If a session is logged out but its access cookie is active, the session class will look for the active value 
                                            in the database table's field relative to <code>COOKIE_FIELD_NAME</code> declared in the init file. This value will help to log the user back 
                                            if the hashed value stored is active. 
                                            
                                            defined during the instantiation of the session class is a key that is used to store user data inside 
                                            the global <code>$_SESSION</code> variable. Hence, we can retrieve our data using the defined session_key 
                                            (e.g <code>$_SESSION[session_key]</code>). The session class requires that data stored in the 
                                            <code>$_SESSION[session_key]</code> must have a <code>userid</code>. This means that our session variable will be in the format 

                                            <code>$_SESSION[session_key]['userid']</code>. The session class will look for its userid from the <code>USER_ID_FIELDNAME</code> 

                                            (e.g email) column that must exist in the database.

                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="">Session(secure)</div>

                                        <div class="font-em-d87 mvt-10">
                                           A layer of security can be added to our session class which ensures that a fake id cannot create an active session. By setting  
                                           <code>secure</code> as true, the Session class will validate the userid stored within the <code>$_SESSION[session_key]['userid']</code>. 
                                           If the value does not exist in the <code>USER_ID_FIELDNAME</code> column defined in init file, the session will be nullified. The 
                                           <code>Session::secure()</code> function can also enable this behaviour which also takes the argument of <code>true</code> or <code>false</code>. 

                                        </div><br>
                                    </div>

                                </div>

                                <div class="">
                                    <div class="pxv-10 bc-silver">
                                        Syntax: Session modification 
                                    </div>

                                    <div class="font-em-d87 pxv-10 bc-silver">
                                        By default, all sessions are set to last for a day. This behaviour can be modified in our application by using the <code>cookie()</code> method.
                                        The <code>cookie()</code> method is similar to the <code>set_cookie()</code> php inbuilt function. The only difference is that, the first argument 
                                        which is the session name does not need to be declared as this will be automatically pulled from the <code>session_key</code> defined during session 
                                        class instantiation. This method is most likely not required to be used except on rare cases. The <code>User::login()</code> method manages mostly what 
                                        a session needs to become active.
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div> 
                </div> <br>

                <div>
                    <div class="font-em-d87 fb-6 c-olive box-full rad-4 pvs-8">
                      Other helper methods of the session class. <br>

                      <ul class="mvt-10">
                        <li>stream()</li> 
                        <li>cookieName()</li> 
                        <li>sessionName()</li> 
                        <li>onauto()</li> 
                        <li>userid()</li> 
                        <li>checkSession()</li>
                      </ul>

                    </div> <br>

                    <!-- stream -->
                    <div class="">
                        <div class="mvs-4">stream()</div>
                        <div class="font-menu font-em-d9">

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

                    <!-- sessionName, cookieName -->
                    <div class="">
                        <div class="mvs-4">sessionName() and cookieName()</div>
                        <div class="font-menu font-em-d9">

                            <div class="mvs-10">
                                The <code>Session::sessionName()</code> and <code>Session::cookieName()</code> methods are both methods that retrives the 
                                session_key and cookie_key storage key names once defined 
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

                    <!-- onauto -->
                    <div class="mvt-20">
                        <div class="mvs-4">onauto()</div>
                        <div class="font-menu font-em-d9">
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

                            <div class="font-em-d87 pvs-10 ">
                                As an example in relation to the code syntax above, redirection from a <code>user</code> page to an <code>index</code> page when account becomes inactive 
                                or session is terminated will require that the user page should have a code syntax similar to <code>Session::onauto('logout', 'index')</code>. 
                                By placing such code in the <code>user</code> page, the <code>user</code> page will redirect to the <code>index</code> 
                                page once the session is terminated. Likewise, an <code>index</code> page can be enforced to redirect to an <code>home</code> page if a session is active. This means that the 
                                <code>index</code> page will have a code similar to <code>Session::onauto('login', 'home')</code>.  
                            </div>

                        </div>
                    </div> <br>

                </div>

                <div>
                    <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                        Session::userid()
                    </div> <br><br>


                    <div class="">
                        <div class="font-menu font-em-d9">
                        The <code>Session::userid()</code> method returns an active session id. For the Session class to successfully return the userid, 
                        the data stored in the in the <code>$_SESSION</code> variable must contain a <code>userid</code> key, that is, 
                        <code>$_SESSION['session_key']['userid']</code>. The value of this is then returned by the <code>userid()</code> method. 
                        It is not advisable to set this key manually form the <code>$_SESSION</code> variable. The data should be stored by the  
                        <code>User</code> class which is an extension of the Session class itself. Learn more about this from <a href="<?= DomUrl('docs/useraccounts') ?>" class="hyperlink">User accounts</a>
                        </div> <br>
                    </div>       
                     
                </div><br>    

            
                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions">Sessions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions/session">Session</a>  </div>

            </div>
        </div>
    </section>
</div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>