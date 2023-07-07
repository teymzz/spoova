
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
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="resource-intro">
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
                  <div class="mvs-10">
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
                  <div class="foot-note">
                    Once the dependencies are installed through the <code>composer dump-autoload -o</code>, then we need to modify the <code>CssInliner</code> 
                    class <code>__construct()</code> method in order for <code>Mailer</code> class to work. This method should be set as public rather than private. 
                    Once this is done, we can proceed to set up the configuration files. 
                  </div>
                </div> <br>

                  Before the <code>Mailer</code> class can be used, there is need to set up the mailer system. Setting up mail system can be addressed in two categories 
                  <br>
                  <ul>
                    <li>mail configuration setup</li>
                    <li>mail content setup</li>
                  </ul>
                  
              </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
              <br>
              <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
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
          
          <div class="foot-note">

          <ul>
            <li>
              In the examples above, we have two files 
              <code class="bd-f">server.php</code> and <code class="bd-f">headers.php</code>.
              The <code>server.php</code> is used to setup the phpMailer server 
              according to the PHPMailer Documentation. The <code>headers.php</code>
              is a default file that anchors the PHPMailer headers.
            </li>
            <li>
              The <code>$webmail</code>
              is a reserved variable that anchors PHPMailers headers' values. Although the 
              <code>$webmail['body']</code> can be configured here, it is not advisable to do so as 
              the content may change from time to time depending on what type of mail is expected 
              to be sent. 
            </li>
            <li>
              The <code>$webmail['client']['mail']</code> refers to user email to which
              the mail is expected to be forwarded while the <code>$webmail['client']['name']</code>
              is the user name. Both of the <code>$webmail['client']</code> can easily change, therefore, 
              setting them within the <code>header</code> file is not realistic.
            </li>
            <li>
              After setting up the default parameters, the files can be loaded up when using the Mailer tool. 
              The example below shows how the <code>server.php</code> and <code>headers.php</code> files can be
              imported.
            </li>
          </ul>
            <p>
            </p>
            
            <p>
            </p>
            
            <p>
            </p>

          </div>
          
          <p class="">
          </p>
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

        <div class="font-em-d95 mvt-6">
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
                You can learn more about this on the <a href="<?= Rexit::domurl('docs/mails/templating') ?>"><span class="c-olive">templating</span></a> page.
              </p>
  
              <div>
                Below are lists of the available mailer methods. <br><br>
  
                <ul class="c-olive">
                  <li> <a href="<?= Rexit::domurl('docs/mails/server') ?>"> server </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/setup') ?>"> setup </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/content') ?>"> content </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/sync') ?>"> sync </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/inject') ?>"> inject </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/authorize') ?>"> authorize </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/authorized') ?>"> authorized </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/pull') ?>"> pull </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/info') ?>"> info </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/attempted') ?>"> attempted </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/casted') ?>"> casted </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/sent') ?>"> sent </a></li>
                  <li> <a href="<?= Rexit::domurl('docs/mails/response') ?>"> response </a></li>
                </ul>
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