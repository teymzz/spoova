
<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>Live-server</title>
    <?= Rexit::load('headers') ?>
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: "Poppins", "Roboto", sans-serif;
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


    
    <div class="box pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial bc-white">
           <div class="font-em-1">

               
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>
            <div class="">
                <div class="font-em-1d2 c-orange">Live server implementation</div> <br>         
                
                <div class="">
                    <ul class="list-free pxs-1">
                        <li> 
                            <p>
                                Live server is an inbuilt server that runs on javascript language and helps to enable
                                live php development. In order to keep live server efficient, the live server runs at the top 
                                of the application before any content is rendered when it is called in routes. However, in template files,
                                it is imported at the point of call. Helper classes or functions
                                have been restructured and integerated into this framework to support live development. 
                                An error notification system was attached to php error handlers to convert php errors into an error pop-up 
                                notification message to reduce what is known as a "KILL EFFECT" which occurs when live server terminates and may not be able to 
                                continue unless the page is refreshed or the error is fixed before refreshing the page. 
                            </p>
                            
                            <p>
                                Certain PHP errors prevents the live server from running because they shut down the entire application. In order to reduce the 
                                effect of these errors, the liveserver will continue to run with a relative error pop-up notification message until the page is manually 
                                refreshed. Once the page is refreshed while such errors are active, the live server will not be able to restart until such errors are fixed 
                                and the page is refreshed to reboot the liveserver. In the cases where soft errors (e.g warning and notice errors) occurs, the liveserver will 
                                still try to reboot to keep the application on a live state and any error detected will be converted to a pop-up notification message.
                            </p>

                            <p>
                                Although, the live server may prove helpful, due to the comprehensive structure which php uses to handle its errors, 
                                spoova live server debug system is still known to have some minor issues. The live server implement 
                                different resource management approach to reduce its effect on cpu performace one of these is the internal behavioral pattern 
                                of pausing watch mode for web pages that are not in view. Although, the Live server was built to support majorly offline development, 
                                it is disabled by default and can be initialized or turned off through different ways which are further explained below:
                            </p>

                        </li>
                        <li>
                            
                            <div class="c-olive fb-6">1. Resource importing systems.</div>
                            <div class="mvt-6">
                                Through the command-line, the live server can be turned on by running the command below 
                                <br>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch online
                                    </pre>
                                </div>

                                <div class="">
                                    The command above will turn the live server on for both online and offline environments. 
                                    The online enviroment support may however not be very efficient. In other to keep it strictly for offline, 
                                    we can run the command below:
                                </div>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch offline
                                    </pre>
                                </div>

                                <div class="">
                                    We can also disable the default autoloading of the live server through the command below
                                </div>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch disable
                                    </pre>
                                </div>

                                <div class="">
                                    Should the command-line fail for any reason, this can be manually configured through <code>icore/init</code> 
                                    file by setting "RESOURCE_WATCH" to a default value of <code>"1"</code> or <code>"2"</code> which stands for 
                                    <code class="">offline</code> or <code class="">online</code> respectively while a default of <code>"2"</code> 
                                    disables the live server. These values should be defined without quotes. Although, setting up live server this 
                                    way may sound easy, it is not the most efficient way to start the live server unless a template file cannot be reached. 
                                    Template files are preferred and recommended for starting the live server. <br><br>
                                </div>
                            </div>
    
                            <span class="c-olive fb-6">2.</span> By including the directive <code class="font-em-d8">&lt;?= Res::import("::watch") ?&gt;</code>
                            in your project file. <br><br>
    
                            <span class="c-olive fb-6">3.</span> By including the <code class="font-em-d8">&lt;?= Res::live() ?&gt;</code> which is a shorthand for 2 above <br><br>
    
                            <span class="c-olive fb-6">4.</span> By including the <code class="font-em-d8">@live()</code> or <code class="font-em-d8">@live</code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">5.</span> By including the <code class="font-em-d8">@Res(\'::watch\')</code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">6.</span> By the use of helper function <code class="font-em-d8">monitor()</code> in window route files.<br><br>
                            
                            <span class="c-olive fb-6">7.</span> The template importing directive <code>@template(file:off)</code> is also useful for turning off the live server from a parent file. This is explained below: 
                            
                            <div class="pre-area mvt-10">
                                <div class="pxv-10 bc-silver">some-file.rex.php</div>
 <pre class="pre-code">
    &lt;html&gt; 

      &lt;head&gt; @live &lt;/head&gt;    

      &lt;body&gt;   

         yield()

      &lt;/body&gt;    

    &lt;/html&gt;
 </pre>
                            </div>

                            <div class="pre-area">
 <pre class="pre-code">

    @template('some-file:off') 

        <span class="comment">//some html here</span>

    @temple;

 </pre>
                            </div>

                            <div class="">
                                In the sample above, the parent file <code>some-file.rex.php</code> has the <code>@live</code> 
                                directive which enables the live server. This will also be inherited by the child template. In order to 
                                ensure that the child template does not inherit this live server, we can turn the live server off for the 
                                child template through the <code>:off</code> directive that comes after the rex file name <code>some-file</code>
                                supplied in the <code>@template()</code> directive above.
                            </div>

                        </li> <br>
    
                        <li> 
                            <span class="c-olive fb-6">8.</span> Live server can also be switched off or on with <code class="font-em-d8">&lt;?= Res::watch() ?&gt;</code> and <code class="font-em-d8">&lt;?= Res::off() ?&gt;</code> respectively.
                            <br><br>
    
                            <span class="font-em-d85 box c-brown-ll bc-white bd-1 shadow rad-5 pxv-10">
                                <div class="font-em-1d2 fb-9 mvb-6"><span class="bi-circle"></span> Notice</div> 
                               
                                <ul class="pxl-20 font-em-1d1">
                                    <li style="list-style:square" class="mvb-6">
                                        Turning off the live server can only be done before a previous setting is made to turn it on. This means that turning off can be done either 
                                        before the page loads or before resource importation is done.
                                    </li>
                                    <li style="list-style:square" class="mvb-6">Whenever the live server is turned off either by a KILL EFFECT 
                                        or through code, when turned back on, the page must be reloaded for the changes to take effect.
                                    </li>
                                    <li style="list-style:square" class="mvb-6">
                                        When working with database operations, operations that could change the state of another item permanently (for example, file update or delete) 
                                        or operations that changes state frequently, it is advised to turn off the liveserver to prevent pre-execution of codes or recurrence of page refresh.
                                    </li>
                                    <li style="list-style:square">
                                        Although, the live server's resource usage has been greatly reduced, we suggest to close and re-open web browser after a minimum of 10 hours continuous usage of live server. 
                                        This of course depends on the processing power of the device in use. This activity is also not required but it may help keep the web browser efficient if it ever slows down.
                                    </li>
                                </ul>
                            </span>
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