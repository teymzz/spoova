
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
        <div class="">

            
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>

            <br>
            <div class="start font-em-d87"> 

                <div class="c-orange font-em-1d5"> <i class="bi-person-gear"></i> Handling Users</div> <br>
                
                <div class="resource-intro">
                    <div class="">
                        Spoova creates a User-Database relationship which makes its easier to control user accounts. 
                        This relationship makes it possible to perform simple operations like login and logout, account 
                        auto redirection, account information e.t.c just in a few number of lines. The <code>User</code> 
                        class is an extension of the <a href="<?= Rexit::domurl('docs/sessions') ?>" class="hyperlink">Session</a> class. 
                        Hence, it has access to most of the <code>Session</code> class static methods. 
                        However, it also handles the User session account using some specific static methods that will be discussed 
                        below.
                        <br><br>

                        <p>
                            In order for the User class to be able to link to database, it is important to configure the <code>init</code> 
                            file with require user details. The <code>init</code> file contains some basic user information that is 
                            neccessary for the <code>User</code> class to use to connect to the proper user database column in the default 
                            database name set in the <code>dbconfig.php</code> file. This means that both the <code>dbconfig.php</code> and <code>init</code>
                            must be properly configured in order for the <code>User</code> class to be able to pick up some basic User information from the database. 
                        </p>

                        <p class="c-orange-dd">
                           Although, part of this have been discussed on the session setup documentation, Some of the earlier discussed may be referenced on this page 
                           with the assumption that the configuration files have been properly set.
                        </p>

                    </div>
                </div> <br>

                <div class="">
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8 ">
                        <span class="bi-circle-fill c-silver-d"></span> Helper Methods
                    </div> <br>

                    <div class="mvt-10">
                        <div class="">
                            Assuming that we have properly set up our configuration files, the <code>User</code> class provides us with certain useful static method 
                            that can be used to either obtain the User information from the database or perform queries on the database itself.
                            <br><br>

                            <ul class="c-olive bc-white-dd pvs-10">
                                <li>User::config()</li>
                                <li>User::tableName()</li>
                                <li>User::id()</li>
                                <li>User::auth()</li>
                            </ul>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::config()</div>
                                <div class="">
                                    <div class="">
                                        <div class=" pvs-10"> This method returns certain important user configuration data details such as:</div>
                                        <div class="mvt-6 font-em-d85">
                                            <div class="mvs-6"><span class="c-orange-dd">DBNAME</span> =>  current database name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">USER_TABLE</span> =>  the user table name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">SESSION_NAME</span> => current session key name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">COOKIE_NAME</span> => current cookie name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">USER_ID_FIELD_NAME</span> => current user id field name in user database table (i.e USER_TABLE).</div>
                                            <div class="mvs-6"><span class="c-orange-dd">COOKIE_FIELD_NAME</span> => current cookie field name in database table (i.e USER_TABLE).</div>
                                        </div>
                                    </div>                                
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::tableName()</div>
                                <div class="pvs-10">
                                    This is an helper method that quickly returns the currently connected User default table name which contains all 
                                    user information. which is equivalent to "USER_TABLE" discussed earlier under the <code>User::config()</code> method
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::id()</div>
                                <div class="pvt-10">
                                This method returns the current user id for a logged in user. It is important that in order for a userid 
                                to be returned, the following must have occurred: <br><br>                                  
                                <ol class="pxl-14 font-em-d87">
                                    <li>
                                        The <span class="c-orange-dd">USER_TABLE</span> must have been previously set in the configuration
                                    </li>
                                    <li>
                                        The <span class="c-orange-dd">USER_ID_FIELD_NAME</span> must have been previously set in the configuration
                                    </li>
                                    <li>
                                        A userid must be stored when logging in whose value exists in <span class="c-orange-dd">USER_ID_FIELD_NAME</span> 
                                        in the database <span class="c-orange-dd">USER_TABLE</span>
                                    </li>
                                    <li>
                                        A user session must be active based on the predefined configurations
                                    </li>
                                </ol> 
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::auth()</div>
                                <div class="pvs-10">
                                    This method returns some basic user information which includes current user id, primary user id and current user connection. 
                                    This method returns the <code>UserAuth</code> class. Hence the following can be chained on this method:
                                        
                                    <ul class="font-em-d87 pvs-10 pxl-20 list-square">
                                        <li><b class="c-teal ">User::auth()->db()</b> : This returns the <code>DB</code> class</li>
                                        <li><b class="c-teal ">User::auth()->dbh()</b> : This returns the <code>DBHandler</code> class with its current user connection</li>
                                        <li><b class="c-teal ">User::auth()->id()</b> : This returns the currently authenticated user id for a session user account if called as a string</li>
                                        <li><b class="c-teal ">User::auth()->id()->main()</b> : This returns the currently authenticated user primary id for a session account. 
                                        <li><b class="c-teal ">User::auth()->id()->primary()</b> : This returns the <code>current</code> authenticated user primary id for a session account. 
                                        This can only be obtained if each user has an auto generated primary "id" field in the user's database table.
                                        </li>
                                    </ul>  
                                    
                                    Rather than setting up a new connection, the <code>User::auth()</code> method returns the default user connection if not previously modified 
                                    using the same method. This method only reflects that the Framework handles the entire User connection using the default connection parameters set in the 
                                    <code>dbconfig.php</code> file. This means that, provided all default configurations are set, running queries will be as simple as :
                                    <br><br>   
                                        
                                    <div class="pre-area bc-white">
    <pre class="pre-code">
  if($authdb = User::auth()->dbh()){
  
      $authdb->query('select * from users')->read();
      $results = $authdb->results();
  
  }
    </pre>                                    

                                    </div> 
                                
                                </div>
                            </div>

                        </div>
                    </div>        
                </div> <br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> Session Setup
                    </div> <br><br>


                    <div class="">
                        <div class=" ">
                        Since spoova supports multi-sessions, session class requires a session key and an optional cookie key to run sucessfully. 
                        This should be set at the top of your application or project file.
                        </div> <br>

                        <div class="pre-area shadow">
            <pre class="pre-code">
  new Session('session_key', 'cookie_key');
            </pre>
                        </div> <br><br>

                        <div class="">
                            Once the Session class is set, then the User class will become active for use. This is because 
                            the User class depends on the session class to function properly. Since the User class is an extension 
                            of the Session class, we can also initialize session from the user class.
                        </div> <br>

                        <div class="pre-area shadow">
            <pre class="pre-code">
  new User('session_key', 'cookie_key');
            </pre>
                        </div> <br><br>

                    </div>        
                </div><br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> Session accounts
                    </div> <br><br>


                    <div class="">

                        <div class=" ">
                        Session accounts may be separated using <code>Frames</code>. Frames are container classes for window files 
                        hence may contain data that are specific to certain window files which may not necessarily be available in other 
                        window files. Since <code>Frames</code> a extensions of Windows, they have access to all window methods. The 
                        <code>super()</code> method is a window method that contains all logic that must occur before a window is loaded. 
                        This gives us access to configure our session keys within the a specific session frame which can then be extended to by 
                        our window classes. Since only one top level key session can be attached to a user account, each 
                        separate user account can be controlled by its own key separately, for example, you can have a user account and 
                        a separate admin account. The user account will obtain its data from its own user session group while the admin account will 
                        obtain its data from the admin's separate group. In order to do this, two separate session (user) files or frames must be created with their 
                        own unique keys such as the example below:
                        </div> <br>

                        <div class="pre-area shadow">
                            <div class="pxv-10 bc-silver">File 1 - UserFrame.php</div>
            <pre class="pre-code">
    &lt;?php

    namespace spoova\mi\windows\Frames;
    
    use Window;

    class UserFrame extends Window {

        function super() {

            new Session('user', 'user_cookie');

        }

    }
            </pre>
                        </div> <br><br>

                        <div class="pre-area shadow">
                            <div class="pxv-10 bc-silver">File 2 - AdminFrame.php</div>
            <pre class="pre-code">
    &lt;?php

    namespace spoova\mi\windows\Frames;
    
    use Window;

    class AdminFrame extends Window {

        function super() {

            new Session('admin', 'admin_cookie');

        }

    }
            </pre>
                        </div> <br><br>

                        <div class="">
                            In the above examples, two different session (channel) files were created. User related 
                            pages (or routes) will be can be extended to the <code>UserFrame.php</code> file while admin related pages 
                            can be connected to the <code>AdminFrame.php</code> files. Session files may be separated from other frame files to keep track of 
                            where session files are declared. The major known issue with the <code>super()</code> method is that it can be overridden by a child 
                            class. This issue is fixed starting from <code>version 2.5+</code> where the <code>frame()</code> method can be used to replace the 
                            <code>super()</code> method to keep the state of frame classes.
                        </div>

                    </div>        
                </div><br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> User Session Control
                    </div> <br><br>


                    <div class="">
                        <div class=" ">
                            The User class can be used to control the activity and response of a session which includes storing of data and user redirection. 
                            The setting up of a user account system involve three(3) main steps: <br><br>

                            <ul>
                                <li>Data Storage and Retrieval</li>
                                <li>Session storage</li>
                                <li>Session redirection</li>
                                <li>Session auto redirection</li>
                            </ul>

                        </div>
                    </div>     

                    <div class="bc-white-dd">
                        <div class="c-olive bc-silver pxv-10">Data Storage and Retrieval</div>
                        <div class="pxv-10">
                            <p>
                                Data storage is mostly handled through the <code>Model</code> and <code>Form</code> class. 
                                The <code>Form</code> is supplied a model which contains authentication rules for form inputs and mapping 
                                of form inputs to database columns. Once the form is authenticated, the data can be saved using the <code>Form::isSaved()</code> 
                                method which saves the data to the model's defined database table.
                            </p>
                            <p>
                                Once a data is stored, then it can be fetched through using a database model. The <code>Model</code> class is the root database model handler 
                                that is used to communicate with the database through the use of a structure that depends on database relationships. These database relationships 
                                include <code class="bd-f c-teal-d">"one-to-one"</code>, <code class="bd-f c-teal-d">"one-to-many"</code> and <code class="bd-f c-teal-d">"many-to-many"</code> relationships. More information on database model is provided 
                                <a href="<?= Rexit::domlink('docs.database.data-model') ?>" class="c-olive">here</a>.
                            </p>
                        </div> 
                        
                    </div> <br>

                    <div class="bc-white-dd">
                        <div class="c-olive bc-silver pxv-10">Session Storage</div> 
                        <div class="pxv-10">
                            When a session is authenticated, the data of the user is expected to be stored in the session which can be retrieved later. 
                            In most cases only specific essential data which is required to keep a session active is mostly stored in the session. This 
                            data is expected to be authenticated before each request sent can obtain a session's data. The <code>User::login()</code> 
                            method allows us to store our data into the session by simply supplying the user data in the format: 
                        </div>
                        
                        <div class="pxv-10">
                        
            <!-- code line started -->
            <div class="pre-area bc-white">
            <pre class="pre-code">
  $userdata = ['userid' => 'someid'];

  User::login( $userdata );
            </pre>
            </div> <br><br>  
            <!-- code line ended -->
                            
                            <div class="">
                            In the above code format, the <code>someid</code> is a unique id that must be found in the init-defined <code>"USER_ID_FIELDNAME"</code>. 
                            If the corresponding column set in the init file does not contain the <code>someid</code>, the data is never stored if such session is defined as  
                            secured. This is explained in the <a href="<?= Rexit::domurl('docs/sessions/setup') ?>" class="c-olive">session setup</a> documentation. The <code>User::login()</code> method also 
                            manages the storage of a <code>cookie_key</code> which is binded to the session.
                            </div> <br>
                        </div>

                        
                    </div> <br>

                    <div class="bc-white-dd">
                        <div class="c-olive bc-silver pxv-10">Session redirection</div>
                        <div class="pxv-10">

                            <p>
                                A session redirection occurs in two format. This includes logging in and logging out of a session account. 
                                While the <code>User::login()</code> stores the user data in the session storage, it is also capable 
                                of redirecting the user to a new url once the session data is successfully stored. This is done by supplying the 
                                redirection url as a second parameter on the <code>login()</code> method. For example, the code syntax: 
                                <code>User::login(['userid'=>'someid'], 'home')</code> would mean that a session data should be stored and a redirection 
                                to the <code>home</code> should be made. This would be applied only when the user data has been validated and retrieved 
                                from the database.
                            </p>

                            <p>
                                The <code>User::login()</code> also take a third parameter which defineds the maximum lifetime of a cookie. By default, this 
                                is set as <code>86400</code> which is equivalent to 1 day. This can be modified as desired. For example <code>User::login(data, url, 60)</code> 
                                would mean that the cookie generated or retrieved from database should only last for 60 seconds. Cookies are used in the user class to setup a 
                                "remember-me" feature which can help to re-initialize a session once it has ended. This re-initialization is controlled automatically through the 
                                <code>Session::onauto()</code> or <code>User::onauto()</code> method. Other information about <code>User::onauto()</code> method is discussed under 
                                <a href="#onauto" class="c-olive">autoredirection</a>. 
                            </p>

                            <p>
                                Also, the <code>User::logout()</code> method ensures that an active session is terminated. Once this method is called on 
                                an active session, the session will be terminated. The <code>User::logout()</code> not only ensures that the session is terminated, 
                                it also terminates the cookie key if it exists and supplying a url within the <code>logout()</code> method will ensure that a redirection 
                                is made to the defined url once the session is terminated.
                            </p>

                            <p>
                                As an added feature to the <code>User::logout()</code> method, a session cookie can be revoked from the database. In this case, 
                                any stored cookie which is binded to the user data in the database will be nullified and a new one generated once a user logs in and the <code class="bd-f">"remember-me"</code> feature is used.
                                In order to achieve this, the <code>User::logout()</code> method must be supplied a logout url followed by a <code>true</code> argument. For example, 
                                <code>User::logout('index', true)</code> will revoke the cookie key, terminate a session and redirect the user to <code>index</code> page. 
                            </p>

                            <p>
                                Lastly, it is important to note that the <code>User::login()</code> or <code>User::logout()</code> are used when a certian condition is expected to be met. For example, 
                                it can be used when it requires that a <code>login</code> or <code>logout</code> button is clicked or after a user authentication has been done.
                            </p>


                        </div>

                        
                    </div> <br>

                    <div id="onauto" class="bc-white-dd">
                        <div class="c-olive bc-silver pxv-10">Session auto redirection</div>
                        <div class="pxv-10">

                            <p>
                                A session automatic redirection is usually being defined through the use of <code>Session::onauto()</code> or <code>User::onauto()</code> 
                                methods. This does not require that a condition is defined before a redirection occurs but rather, it checks if a condition is met before an automatic redirection is made. 
                                The auto redirection is based on two conditions which are when an session is active (login) or when it is not active (logout). 
                                The <code>User::onauto('login')</code> will ensure that a page is not redirected unless the session is active. This rule is usually applied on 
                                guest pages which are not required to be viewed when a session account is active. Once a session becomes active, these pages will force an automatic 
                                redirection to another specified page. The <code>User::onauto('logout')</code> are mostly applied on account related pages which must not be view once 
                                a session becomes inactive. When this condition is used on user account related pages, the session will ensure that a redirection is forced to another page 
                                if the session becomes inactive. An example is shown below:
                            </p>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    AppSession (parent session)
                                </div>
                                <pre class="pre-code">
    &lt;?php 

    namespace sppova\mi\windows\sessions;

    use Window;
    use Session;

    class AppSession extends Window {

        static function frame(){

            new Session('user', 'user_cookie');

        }

    }
                                </pre>
                            </div>

                            <p class="foot-note">
                                Assumming that we have a base session as shown above, we can extend this session to a GuestSession and UserSession such that the 
                                GuestSession is owned by guest routes and the User session is owned by User related pages.
                            </p>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    GuestSession
                                </div>
                                <pre class="pre-code">
    &lt;?php 

    namespace spoova\mi\windows\sessions;

    use spoova\mi\windows\sessions\AppSession;

    use Window;
    use Session;

    class GuestSession extends AppSession {

        static function frame(){

            Session::onauto('login', 'home'); <span class="comment">//auto redirect to home</span>

        }

    }
                                </pre>
                            </div> <br>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    UserSession
                                </div>
                                <pre class="pre-code">
    &lt;?php 

    namespace sppova\mi\windows\sessions;

    use spoova\mi\windows\sessions\AppSession;

    use Window;
    use Session;

    class UserSession extends AppSession {

        static function frame(){

            Session::onauto('logout', 'login'); <span class="comment">//auto redirect to login</span>

        }

    }
                                </pre>
                            </div>

                            <p class="foot-note">
                               Assuming that a <code>Login</code> route is extended to the <code>GuestSession</code> while an 
                               <code>Home</code> route is extended to the <code>UserSession</code>, for the <code>Login</code> 
                               route, once the account becomes active, it will redirect to the <code>Home</code> route while for the 
                               <code>Home</code> route, it will redirect to the login once the session becomes inactive. If not specified, 
                               the default redirection url for <code>User::login()</code> is <code class="bd-f">"home"</code> while the 
                               default for <code>User::logout()</code> is <code class="bd-f">"index"</code>. We can also ensure that a redirection 
                               is never made by setting the second argument as <code>false</code> instead of a string url.
                            </p>

                        </div>
                        
                    </div> <br>

                    <div class="bc-white-dd">
                        <div id="running-queries" class="c-olive pxv-10 bc-silver"> <i class="bi-circle"></i> Running queries from User class</div> <br>
                        <div class="pxs-10">
                            User class returns an authentication class from its <code>auth()</code> which is the <code>UserAuth</code> class. This class 
                            has a method <code>dbh()</code> which returns the database handler class only if a session is active. If a session is not 
                            active, the <code>dbh()</code> method will return null. The <code>DBhandler</code> class returned is always specfic to the current user session. 
                            Hence, rather than opening a new connection, we can retrieve the current user connection from the <code>User::dbh()</code> 
                            method and perform our queries through that <code>DBHandler</code> class returned.
                        </div> <br>
                        
                        <div class="">
                        
            <!--code started-->
            <div class="pre-area bc-silver">
                <pre class="pre-code">
  $auth = User::auth();

  if($db = $auth->dbh()) {

    <span class="comment">Session is active, run query</span>

  }
                </pre>
            </div> <br><br>  
            <!--code ended-->
            
                            <div class="pxs-10">
                                Some of the actions that can be performed on the User class include : <br><br>
                                
                                <ul class="pxl-20">
                                    <li>Modify the default <code>dbconfig.php</code> connection of a User through the use of <code>User::auth()</code> directive 
                                    by creating new database connection and supplying it as argument just as shown below: <br><br>
                                
                                        <!-- code started -->
                                        <div class="pre-area bc-silver">
    <pre class="pre-code">
  $db = ($dbc = new DB)->openDB('db','user','pass','port','server');
    
  $auth = User::auth($db, $dbc); <span class="comment">// use a new connection </span>
    </pre>
                                        </div> <br><br>   
                                        <!-- code ended -->

                                        <div class=" ">
                                            In the code above, the <code>DB</code> class is used to update the default connections of the <code>User</code> class set in <code>dbconfig.php</code> file. 
                                            Every other subsequent connections will obtain their configuration from the last update instead of the default config file.
                                        </div>
                                    </li>    

                                    <li class="mvt-10">Return the specific database connection a currently authenticated user uses through the <code>dbcon()</code> directive </li>
                                    
                                    <li>Return the authenticated user database handler class when <code>dbh()</code> method is called upon it. </li>
                                
                                    <li>
                                        Find data related to the defined user table by using the <code>find()</code> directive 
                                
    <!-- code started -->
    <div class="pre-area bc-silver mvt-10">
    <pre class="pre-code">
  $db = $auth->dbh();

  $db->where('userid = ?', [1])->find('username'); <span class="comment">//returns username from the user database table name</span>
    </pre>
    </div> <br>
    <!-- code ended -->
                                    </li>

                                </ul>

                            </div>
                        </div>
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