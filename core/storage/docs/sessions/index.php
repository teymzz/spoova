

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
               <li> <a href="<?= DomUrl('docs/wmv') ?>" class="<?= inPath('active') ?>" ><span class="ico ico-spin"></span>The <span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions">Sessions</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Sessions</div> <br>
                    
                    <div class="resource-intro">
                        <div class="fb-6 c-olive">Introduction</div>
                        <div class="">
                            Sessions by default are handled by the <a href="<?= route('::session'); ?>" class="hyperlink">Session</a> class. 
                            The session class depends on series of configurations both in files and code in other to work 
                            unanimously. It uses the mysql database connection class to handle user Requests. It is important 
                            to configure our session class by following the procedure listed below: 

                            <br><br>
                            
                            <li>Configuration of init file</li>
                            <li>Top level code configuration of session class</li>
                            
                        </div> 
                    </div> <br>

                    <div>
                        <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            1. Init File setup
                        </div> <br><br>


                        <div class="">
                            <div class="font-menu font-em-d9">
                            The init file <code>icore/init</code> contains few configurations that helps the 
                            Session class to properly map itself to the database. In the init file, the following must be configured
                            <br><br>
                            <ul>
                                <li>USERS_TABLE
                                    <div class="mvt-6">The user's main table in database containing user details</div>
                                </li> <br>
                                <li>USERS_FIELD_ID
                                    <div class="mvt-6">The user's main table user id field in database containing user details</div>
                                </li> <br>
                                <li>COOKIE_FIELD_NAME
                                    <div class="mvt-6">A user cookie field where remember me cookie can be stored.</div>
                                </li>
                            </ul>
                            </div> <br>
                        </div>        
                    </div>

                    <div>
                        <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            2. Session Setup
                        </div> <br><br>


                        <div class="">
                            <div class="font-menu font-em-d9">
                            Since spoova supports multi-sessions, session class requires a session key and an optional cookie key to run sucessfully. 
                            This should be set at the top of your application or project file.
                            </div> <br>

                            <div class="pre-area shadow">
                <pre class="pre-code">
  new Session('session_key', 'cookie_key');
                </pre>
                            </div> <br><br>

                            <div class="font-menu font-em-d9">
                                Once the Session class is set, then the User class will become active for use. This is because 
                                the User class depends on the session class to function properly. The Session set above can also 
                                be done on the User class. Hence, the user class can be used to start a session system. This means
                                that the line below is an acceptable replacement for the code above 
                            </div> <br>

                            <div class="pre-area shadow">
                <pre class="pre-code">
  new User('session_key', 'cookie_key');
                </pre>
                            </div> <br><br>

                        </div>        
                    </div><br>

                    <div>
                        <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            3. Session Channels
                        </div> <br><br>


                        <div class="">

                            <div class="font-menu font-em-d9">
                            Session channels are different session accounts that are built on top of the user application.
                            They are parallel sessions that are controlled by different session keys. This provides an easy 
                            structure in building sessions which contains data that can be obtained based on its predefined access key 
                            . Since just a single top level session key can be attached to a session account, each 
                            separate session account is controlled by its own unique key separately. For example, you can have a user account and 
                            a separate admin account. The user account will obtain its data from its own user session while the admin account will 
                            obtain its data from the admin session. In order to do this, two separate session (user) files must be created with their 
                            own unique keys such as the example below:
                            </div> <br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">File 1 - UserAccount.php</div>
                <pre class="pre-code">
  new Session('user', 'user_cookie');
                </pre>
                            </div> <br><br>

                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
                                <div class="pxv-10 bc-silver">File 2 - AdminAccount.php</div>
                <pre class="pre-code">
  new Session('admin', 'admin_cookie');
                </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                In the above examples, two different session files were created. User related 
                                pages will be connected to the <code>UserAccount.php</code> file while admin related pages 
                                will be connected to the <code>AdminAccount.php</code> files. By default, all session files should 
                                be placed in the <code>windows/Sessions</code> directory. This makes it easier for developers to know the number of session accounts that are available 
                                for each project application. The session files placed in the predefined session directory can be included into pages by using the 
                                <code>session()</code> function. For example: Assuming both previously created files exists within the accounts folder, then
                                they can be included into the top of the window frame classes as shown below:
                            </div> <br>

                <!--code started-->
                <div class="pre-area">
                    <div class="pxv-10 bc-silver">Example - adding UserAccount to a Frame Class</div>
                <pre class="pre-code">
  &lt;?php

    <span class="comment no-select">...namespace here...</span>

    session('UserAccount');

    class UserFrame {

    }
                </pre>
                </div> <br>
                
                
                            <div class="font-em-d87">
                                In the code above, we connected to the framework and loaded UserAccount.php file from the <code>windows/Sessions</code> directory.
                                So, if your account file's name is <code>User</code>, you can access your session main keys just by writing <code>session('User')</code>.
                                Since <code>Frames</code> have a <code>super()</code> method functionality, the <code>Account('UserAccount')</code> can also be placed in the 
                                super method. However, it is preferred to use the method above to load sessions accounts because a child window file will easily inherit the 
                                parent session keys if the method above is used.
                            </div> <br>
                        </div>        
                    </div>

                    <div>
                        <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            4. User Class
                        </div> <br><br>


                        <div class="">
                            <div class="font-menu font-em-1">
                        The user class bridges the gap between User account and Database control. It makes it easier 
                        to set up a User-Session-Database relationship. This relationship makes it easier to 
                        perform the following: <br><br>
                            <ul>
                                <li>Obtain the user setup configuration</li>
                                <li>Obtain an authenticated user account </li>
                                <li>Run queries on the User class</li>
                                <li>Create a structured communication between a Login and Logout system</li>
                            </ul>
                            </div> <br>
                        </div>     

                        <div class="">
                            <div class="fb-6 c-olive">Obtaining the user setup configuration</div> <br>
                            <div class="font-em-d9">
                                Assuming we are connected to a user session file, 
                                we can obtain the user configuration setup by calling the 
                                <code>User::config()</code> method.
                            </div> <br>
                            
                            <div class="">
                            
                <!-- code line started -->
                <div class="pre-area shadow">
                <pre class="pre-code">
  session('UserAccount');

  <span class="comment">// returns the user configurations </span>
  var_dump( User::config() );
                </pre>
                </div> <br><br>  
                <!-- code line ended -->
                                
                                <div class="font-em-d87">
                                    The <code>User::config()</code> returns the user configurations. This includes the
                                    user database table name, user database id field, user session key and cookie key names, 
                                    user cookie database table field name, the current user connection name and the connected user 
                                    id. The user id is dependent on the session connected. For example, an admin channel will return the 
                                    admin id once logged in, while a user channel will return a user id once logged it. In this manner,
                                    channels (or sessions) can be easily logged out just by calling the <code>User::logout()</code> method. 
                                </div> <br>
                            </div>

                            
                        </div>

                        <div class="">
                            <div class="fb-6 c-olive">Obtaining an authenticated user account</div> <br>
                            <div class="font-em-d9">
                                Assuming we are connected to the user channel as before, we can obtain the user id and user data 
                                through the User class.
                            </div> <br>
                            
                            <div class="">
                                <div class="pre-area shadow">
                <pre class="pre-code">
  User::id(); <span class="comment">// Returns the user id of a currently authenticated account</span>

  User::config('CONFIG_KEY'); <span class="comment">// Returns the value of a specific configuration key e.g SESSION_NAME returns the current session name</span>
                </pre>
                                </div> <br><br>                
                                <div class="font-em-d9">
                                    When a user is currently authenticated, the user class is capable of returning a user database authentication handler. This is discussed below. 
                                </div> <br>
                            </div>
                        </div>

                        <div class="">
                            <div class="fb-6 c-olive">Securing sessions</div> <br>
                            <div class="font-em-d9">
                                The session class provides a means to strictly validate the authenticated session using the method 
                                <code>Session::secure(true)</code>. This tells the session to perform the following operations: <br>

                                <ol>
                                    <li>Get the configured user database table where user data is expected to be stored</li>
                                    <li>Get the configured database tables's user id field(or column)</li>
                                    <li>Get the current user id (i.e <code>User::id()</code>)</li>
                                    <li>Check if the user id in 3 above exists in the user id field</li>
                                </ol>

                                The essence of the security is that the developer cannot create a fake userid because the Session 
                                class will try to ensure that the <code>User::id()</code> (same as <code>User::id()->main()</code>) exists within the database. This means that for this 
                                security system to work, the session's userid value stored must be found in the corresponding <span class="c-teal">USER_ID_FIELDNAME</span>
                                column name that is configured within the <code>icore/init</code> file. If these two data does not match, 
                                the session will be logged out. This behaviour can also be enabled by setting the third argument of an instantiated Session 
                                to true just as below:
                            </div> <br> 
                            
    <div class="pre-area">
        <pre class="pre-code shadow">
  new Session('user', 'cookie', true); <span class="comment">// secured session</span>
        </pre>              
    </div> <br><br>
                        </div>

                        <div class="">
                            <div class="fb-6 c-olive">Running queries in User Class</div> <br>
                            <div class="font-em-d9">
                                When a user is logged in, User class returns an authentication class from its <code>auth()</code> method that is capable of running queries. 
                                The authentication returned performs its operation based on user configurations.
                            </div> <br>
                            
                            <div class="">
                            
                <!--code started-->
                <div class="pre-area shadow">
                <pre class="pre-code">
  $auth = User::auth();
                </pre>
                </div> <br><br>   
                <!--code ended-->
                
                                <div class="font-em-d95">
                                    The <code>auth()</code> above can be used to perform direct queries on the user class or database class. Some of the actions that can be performed on the User class includes : <br>
                                    
                                    <ul>
                                        <li>Find data related to specific user by using the <code>find()</code> directive </li>
                                        <li>Returns the specific database connection a currently authenticated user uses through the <code>dbcon()</code> directive </li>
                                        <li>Modify the default <code>dbconfig.php</code> connection of a User through the use of <code>User::auth()</code> directive 
                                        by creating new database connection and supplying it as argument just as shown below: <br><br>

                <!-- code started -->
                <div class="pre-area shadow">
                <pre class="pre-code">
  $db = ($dbc = new DB)->openDB('newdb','newuser','newpass','newport','newserver');

  $auth = User::auth($db, $dbc);
                </pre>
                </div> <br><br>   
                <!-- code ended -->
                                            <div class="font-em-d87">
                                                In the code above, the User class is used to update the default connections set in <code>dbconfig.php</code> file. 
                                                Every other subsequent connections will obtain their configuration from the last update instead of the default config file.
                                            </div> <br>
                                        </li>
                                    </ul>


                                </div> <br>
                            </div>
                        </div>


                        
                    </div>    

                
                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/sessions">Sessions</a>  </div>

                </div>
            </div>
        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>