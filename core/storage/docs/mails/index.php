
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Mails</title>
    
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
         

  <!-- @lay('build.co.coords:header') -->

   

     

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
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails">Mails</a>  </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="resource-intro">
              <div class="fb-6">Introduction</div> <br>
              <div class="">

                <div class="">
                  Sending mails in spoova is done through the <code>Mailer</code> class. 
                  The functionality of this class is made possible through the combination of third party 
                  plugins which are PhpMailer and CssInliner. The <code>Mailer</code> class ensures that mails 
                  can be generated from template files and forwarded as mail. It also enables functionalities such as 
                  performing dummy tests for mails and also viewing lasting effect of mails.
                </div> <br>

                <div class="">
                  <div class="fb-6 c-orange-d">Installation</div>
                  <div class="">
                    In order to use the Mailer class, the PHPMailer and CssInliner libraries must be installed as dependencies. The composer.json file 
                    should contain a similar code syntax below 
                    can be used to install the supported version of these classes.
                  </div>
                  <div class="pre-area">
                    <pre class="pre-code">
  {
    require: {
      'phpmailer/phpmailer' : '^6.0',
      'pelago/emogrifier' : '^6.6'
    }
  }
                    </pre>
                  </div>
                  <div class="">
                    Once the dependencies are installed through the <code>composer dump-autoload -o</code>, then we need to modify the <code>CssInliner</code> 
                    class <code>__construct()</code> method in order for <code>Mailer</code> class to work. This method should be set as public rather than private. 
                    Once this is done, we can proceed to set up the configuration files. 
                  </div>
                </div>
                  Before the <code>Mailer</code> class can be used, there is need to set up the mailer system. Setting up mail system can be addressed in two categories 
                  <br><br>
                  <ul>
                    <li>mail configuration setup</li>
                    <li>mail content setup</li>
                  </ul>
                  
              </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> Setting up mail - config </div>
              </div> <br>
              
              <div>
                  The mail configuration is done for two systems which are <code class="fb-6">server</code> and <code class="fb-6">headers</code> configurations. 
                  Both of this systems can be set up as default (using files) or within the code. It is however advisable to 
                  have a default configuration which can be updated when necessary.
              </div> <br>

              <div class="server">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample Server configuration (server.php)</code></div>
    <pre class="pre-code">
  &#60;?php

      return [
          'SMTPAuth'   => true,  <span class="comment">// Enable SMTP authentication</span>
          'Host'       => 'smtp.mail.com', <span class="comment">// Specify main and backup SMTP servers smtp.gmail.com / website hostname</span>
          'Username'   => 'info@site.com', <span class="comment">// SMTP username e.g info@site.com..</span>
          'Password'   => '123abc',  <span class="comment">// SMTP password  ..</span>
          'SMTPSecure' => 'tls', <span class="comment">// Enable TLS encryption, PHPMailer::ENCRYPTION_STARTTLS`PHPMailer::ENCRYPTION_SMTPS`</span>
          'Port'       => 587,   <span class="comment">// TCP port to connect to (mostly constant)</span>
      ];


    </pre>
                  </div>
                </div>
              </div>

              <div class="server">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample Content configuration (headers.php)</code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="comment">// default configuration settings for mail</span>
    $webmail['site']['mail']  = 'info@site.com';  <span class="comment">// website mail e.g info@site.com</span>
    $webmail['site']['name']  = 'website'; <span class="comment">       // mail header name or site name</span>

    <span class="comment">//default content settings - should be set later</span>
    $webmail['header'] = ''; <span class="comment">// optional - mail title e.g Welcome to ...</span>
    $webmail['body']   = ''; <span class="comment">// optional - mail content string or file</span>

    <span class="comment">//default user details - should be set later</span>
    $webmail['client']['mail'] = ''; <span class="comment">// optional- user email</span>
    $webmail['client']['name'] = ''; <span class="comment">// optional- user name</span> 

    </pre>
                  </div>
                </div>
              </div>            
        
          </div>  
          
          <div class="font-em-d8 mvt-6">
            <p>
              In the examples above, we have two files 
              <code>server.php</code> and <code>headers.php</code>.
              The <code>server.php</code> is used to setup the phpMailer server 
              according to the PHPMailer Documentation. The <code>headers.php</code>
              is a default file that anchors the PHPMailer headers.
            </p>
            
            <p>
              The <code>$webmail</code>
              is a reserved variable that anchors PHPMailers headers' values. Although the 
              <code>$webmail['body']</code> can be configured here, it is not advisable to do so as 
              the content may change from time to time depending on what type of mail is expected 
              to be sent. 
            </p>
            
            <p>
              The <code>$webmail['client']['mail']</code> refers to user email to which
              the mail is expected to be forwarded while the <code>$webmail['client']['name']</code>
              is the user name. Both of the <code>$webmail['client']</code> can easily change, therefore, 
              setting them within the <code>header</code> file is not realistic.
            </p>

            <p>
            After setting up the default parameters, the files can be loaded up when using the Mailer tool. 
            The example below shows how the <code>server.php</code> and <code>headers.php</code> files can be
            imported.
            </p>
          </div>

          <div class="mailer">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample loading configuration files</code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-purple">use spoova\mi\core\classes\Mailer</span>

    $mail = new Mailer;  <span class="comment">// Mailer instantiation</span>

    $mail->server('server'); <span class="comment">  // add server.php (accepts dots for paths)</span>
    $mail->setup('headers'); <span class="comment">  // add headers.php (accepts dots for paths)</span>
    
    $mail->authorize(true); <span class="comment">  // allow sending of mails </span>
    
    <span class="comment no-select">#update mail headers </span>
    $mail->sync('header', 'Notice'); <span class="comment">  // mail subject </span>
    $mail->sync('client', ['user'=>'foo', 'name' => 'bar']); <span class="comment">  // mail subject </span>

    <span class="comment no-select">#send mail</span>
    $mail->sendmail();

    if($mail->sent('online') || $mail->sent('offline')) {

      print 'mail successfully sent';

    }
    </pre>
                  </div>
                </div>
        </div> 

        <div class="font-em-d8 mvt-6">
            <p>
              In the example above, <code>$mailer->server()</code> and <code>$mailer->setup()</code> are used to 
              load the default server config and server header respectfully from a config file or array.
            </p>
            
            <p>
              The <code>$mail->authorize()</code> either allows or prevents a mail from 
              sending as a means of testing. Setting it as false will prevent the 
              <code>$mailer->sendmail()</code> method from sending out mails when used. 
              This helps to suppress errors especially when working in offline environment. 
              Spoova's <code>online</code> constant can then come into play as <code>online</code>
              returns true in live or online environment. This can then be rewritten to send mails only in online 
              environment as <code>$mail->authorize(online)</code>. For example: <br>

              <div class="authorize">
                <div class="pre-area fix">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: mail authorize</code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-sky-blue-dd">...</span>
    
    $mail->authorize(online); <span class="comment">  // allow sending of mails online </span>
    
    <span class="comment no-select">#update mail headers </span>
    $mail->sync('header', 'Notice'); <span class="comment">  // mail subject </span>
    $mail->sync('client', ['user'=>'foo', 'name' => 'bar']); <span class="comment">  // mail subject </span>

    <span class="comment no-select">#send mail if authorized</span>
    if($mail->authorized()){

      $mailer->sendmail('Hi there, this is a mail');

    } 
    </pre>
                  </div>
                </div>
        </div> 
            </p>
            
            <p>
              The <code>$mail->sync()</code> method is used to update the default header configurations just as
              seen above. It synchronizes new data supplied with the old data set. The <code>mail->authorized()</code> can 
              be used to check if a mail is authorized or not. This may prove useful when handling mails with different 
              configurations or setup.
            </p>

            <p>
            The last part which is <code>$mailer->sendmail()</code> is used to send a mail content. The content supplied serves as the 
            body of the mail headers. Although a string can be forwarded from the sendmail option. It is preferred that this should be 
            a file instead. The Mailer system allows that html mail pages can be sent. By default, it also accepts embeded css stylesheets. 
            This means that an html page can be forwarded as a mail. However, it is important to stick with either embedded or inline css 
            when writing mail pages or mail template pages to prevent undesired results.
            </p>

            <div class="pre-area fix">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: template content loading </code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-sky-blue-dd">...</span>
      
    if($mail->authorized()){

      $mailer->sendmail( Res::markup('mail-temp.feedback', fn() => compile()) );

    } 
    </pre>
                  </div>
            </div> <br><br>  
            
            <div class="font-em-1">
              <p>
                Since the <code>Res::markup()</code> prevents <code>compile()</code> from displaying a content, 
                but instead returns the content of a rex file, a template processed page can be forwarded as a mail. 
                However, the mailer tool has its internal way of handling template files. In order to send a raw file,
                The <code>$mailer->content('filename.php')</code> must be set where <code>filename.php</code> is the name 
                or path of the file. Supported files include <span class="c-orange-dd">xml, txt, html and php.</span> 
                You can learn more about this on the <a href="<?= DomUrl('docs/mails/templating') ?>"><span class="c-olive">templating</span></a> page.
              </p>
  
              <div>
                Below are lists of the available mailer methods. <br><br>
  
                <ul class="c-olive">
                  <li> <a href="<?= DomUrl('docs/mails/server') ?>"> server </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/setup') ?>"> setup </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/content') ?>"> content </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/sync') ?>"> sync </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/inject') ?>"> inject </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/authorize') ?>"> authorize </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/authorized') ?>"> authorized </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/pull') ?>"> pull </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/info') ?>"> info </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/attempted') ?>"> attempted </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/casted') ?>"> casted </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/sent') ?>"> sent </a></li>
                  <li> <a href="<?= DomUrl('docs/mails/response') ?>"> response </a></li>
                </ul>
              </div>
            </div>
          </div>

          
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/mails">Mails</a>  </div>


        </div>

      </div>

    </section>

  </div>
      
  


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>