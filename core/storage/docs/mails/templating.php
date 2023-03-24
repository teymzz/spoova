<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Templating</title>
    
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
        if(!value) $('body').removeClass('--theme-dark')
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
               <div class="flex-icon theme-btn navtheme box bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
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
      <div class="pxv-10 tutorial mails c-black-ll">
        
        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails">Mails</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails/templating">Templating</a>  </div>


        <div class="font-em-1d5 c-orange">Mails</div> <br>  
        
        <div class="pulling-data">

            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-window mxr-8 c-lime-dd"></span> Templating
                </div>
                </div>
            </div> <br>

            <div class="">

              <div class="">
                  Mail Templating involves the use of template files to handle mails. These template 
                  files can contain series of placeholders that are used to obtain variables that 
                  are later expected to be injected or passed across to them. These template files can 
                  later be loaded, rendered and forwarded as mail using either the 
                  <a href="<?= DomUrl('docs/mails/content') ?>">content()</a> or the 
                  <code>sendmail()</code> method. When handling template files, 
                  there are few things to take note <br><br>

                  <ul>
                      <li>Template files can be used to update default header configuration settings</li>
                      <li>
                          Placeholders are supplied as double curly brackets along with a dollar sign 
                          i.e <code>&#123;&#123; $var &#125;&#125;</code> where <code>$var</code> is the name of injected variable.
                      </li>
                      <li>
                          Variables can be injected as local or global variables. Local variables are injected using the 
                            <code class="bg-primary c-white bd-f">
                              <a href="<?= DomUrl('docs/mails/inject') ?>" class="i c-white">
                                  <span class="c-white-d">inject()</span>
                              </a>
                            </code> method
                      </li>
                  </ul>
              </div>

            </div> 
        </div> <br>
        
        <div class="">
            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="bi-person mxr-8 c-lime-dd"></span> Configuring Headers - Template File
                    </div>
                </div>
            </div> <br>
            <div class="">
                
                <div class="">  
                    Aside from the <code>setup()</code> method, the template file also be used to configure headers. This is 
                    useful when handling html or txt files. The <code>@</code> symbol is used to process this just as displayed 
                    below. 
                </div>

                <div class="">
                <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Template File With Headers</code></div>
  <pre class="pre-code">
  &#60;setup type="config"&#62;
    @site_name 	: 	{mysite}
    @site_mail 	: 	{mysite@osomething.com}
    @client_name: 	{user name}
    @client_mail: 	{user@something.com}
    @file 	: 	{[user/var/res/myfile.jpg] [myfile.php]}
    @file 	: 	{[myfile/var/filename.php]}
  &#60;/setup&#62;

  
  &lt;!DOCTYPE html&gt;
  &lt;html lang="en"&gt;
  &lt;head&gt;
      &lt;meta charset="UTF-8"&gt;
      &lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;
      &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
      &lt;title&gt;Document&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
      
  &lt;/body&gt;
  &lt;/html&gt;  
  
  </pre>
                </div>
              </div>
                </div>

            </div>
        </div>

        <div class="font-menu pvs-6">
            In the above, the <code>setup</code> data will be used as mail headers when 
            forwarding a mail. Every parameter is just as similar to the <code>$webmail</code> 
            parameters discussed in <a href="<?= DomUrl('docs/mails/setup') ?>">setup</a>. However, 
            when handling multiple files, multiple files should be placed in their own specific angle
            brackets within the curly brackets and separated only by a space just as relayed above. 
            It is not encouraged to do this often.
        </div>
        <div class="">
            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="mxr-8 c-lime-dd">&#123;&#123; &#125;&#125;</span> Template File - Placeholders
                    </div>
                </div>
            </div> <br>
            <div class="">
                
                <div class="">  
                    Placeholders are accesssed in 5 different ways: <br> <br>
                    <ul>
                        <li>As a injected local variable</li>
                        <li>As a global variable</li>
                        <li>As a post request</li>
                        <li>As a get request</li>
                        <li>As a post or get request</li>
                    </ul> 
                    
                </div>

                <div class="">
                <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Mailer File </code></div>
  <pre class="pre-code">

    <span class="comment">// ...Define some default request variables</span>
    $_GET['type'] = 'isGet';

    $_POST['method'] = 'isPost';
    
    <span class="comment">//.. Define a global variable</span>
    $globalvar = 'Foo';

    <span class="comment">// Initialize mailer class</span>
    $mailer = new Mailer;
    
    <span class="comment">// Set or load the mailer configuration parameters</span>
    $mailer->server('mail.server');

    $mailer->setup('mail.setup');

    <span class="comment">//Inject some local variables</span>
    $mailer->inject(['email' => 'foo@site.com']);

    <span class="comment">Load template file</span>
    $mail->sendmail('mail.template');

<div class="pxv-6 bc-off-white"><code>Sample: Template File </code></div>
  
  &lt;!DOCTYPE html&gt;
  &lt;html lang="en"&gt;
  &lt;head&gt;
      &lt;meta charset="UTF-8"&gt;
      &lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;
      &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
      &lt;title&gt;Mail Template File&lt;/title&gt;
  &lt;/head&gt;
  &lt;body&gt;
      
    Hi there, this is a message from &#123;&#123;$globalvar&#125;&#125;

    This however is an injected local variable &#123;&#123;$email&#125;&#125;

    The type of this message is &#123;&#123;get:type&#125;&#125;

    The method of this message is &#123;&#123;post:method&#125;&#125;  

    Choosing any request is as easy as &#123;&#123;method&#125;&#125;  or &#123;&#123;type&#125;&#125;

  &lt;/body&gt;
  &lt;/html&gt;  
  
  </pre>
                </div>
              </div>
                </div>

            </div>
        </div>

        <div class="font-menu pvs-6">
            The examples above shows how the placeholders can be used to 
            access global, local or request variables. <br><br>

            Global variables are naturally accessed with &#123;&#123;$name&#125;&#125; where 
            <code>$name</code> is the name of the global variable <br><br>

            Local variables are injected with <code>inject()</code> method and 
            accessed with the similarly as the global variables. Global variables however 
            overides local variables. <br><br>

            Post request values are accessed with the post keyword i.e &#123;&#123;post:key&#125;&#125; <br><br> where 
            <code>key</code> is the post key <br><br>

            Get request values are accessed with the get keyword i.e &#123;&#123;get:key&#125;&#125; <br><br> where 
            <code>key</code> is the get key <br><br>

            The get or post request values can be obtained generally as &#123;&#123;key&#125;&#125;. By default, this 
            variable i.e <code>key</code> will be obtained depending on the current request. However, the get 
            request has the higest power here. This means that if a key exists in post and equally get, then the 
            get request key will be picked.
            <br><br>
        </div>

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails">Mails</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails/templating">Templating</a>  </div>


      </div>
    </div>
    
    



         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>