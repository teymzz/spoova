

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/trial/res/main/images/icons/favicon.png">
    <title>Tutorial - Inject</title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
    <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script> 
    <style rel="css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
     }

     .pre-area{
          font: menu;
          font-size: .85em;
          display: inline-block;
          width:100%;
          background-color : rgba(var(--silver));
      }
  
     .pre-area.fix {
         font-size: 1em;
     }
     
     pre.pre-code {
          overflow: auto hidden;
          color: #4f58a0;
          font-size: .95em; 
          margin-bottom:0;
          padding-top:1em;
     }
     
     pre .comment {
          color: #909090;
     }
  
     .lacier.active {
          background-color: #3ecb32;
          color: white;
          box-shadow: 0 0 2px 2px #3ecb32;
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


 </style>
    


    
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
        })
    </script>
    <section class="">
        <div class="control font-em-2 fixed c-orange box">
            <div class="flex px-40 mid rad-r shadow anc-btn-link bc-white">
                <span class="bi-list controller flex"></span>
            </div>
        </div>
         

  <!-- @lay('build.co.coords:header') -->

   

     <style rel="css.navbars"> 

     .nav-left{
          min-height: 100vh;
          width: 300px;
          background-color: #f2f2f2;
          box-shadow: 0px 1px 1px 1px #e0dddd;
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

     <nav class="nav-left fixed">

          <div class="flex pxv-10">
               <a href="<?= DomUrl('') ?>" class="flex">
                    <div class="flex-icon box bd-silver border rad-r flow-hide bc-silver ico-spin ripple">
                         <div class="px-40 b-cover" data-src="http://localhost/trial/res/main/images/icons/favicon.png"></div>
                    </div>
               </a>
               <div class="flex midv mxl-8 fb-9 font-menu font-em-1d2" style="color: #202dd5">SPOOVA</div>
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



  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-20 tutorial mails bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/trial/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/trial/docs/mails">Mails</a> <span class="bi-chevron-right"></span> <a href="http://localhost/trial/docs/mails/inject">Inject</a>  </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="mails-intro">

              <div class="fb-6">
                  <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="bi-update mxr-8 c-lime-dd"></span> Injecting template variables 
                    </div>
                  </div>
              </div> <br>

              <div class="">

                <div class="">
                    The <code>inject()</code> method is used to inject local variables into the mail template files
                    which can later be accessed by using placeholder with a dollar sign <code> &#123;&#123;$ &#125;&#125; </code>
                </div>

              </div> 
          </div>
          
          <div id="core" class="content"> 
              <br>
            
              
              <div>
                  Some few examples below provides a better insight to how this is done.
              </div> <br>

              <div class="file-setup">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Injecting local variables</code></div>
    <pre class="pre-code">
    &#60;?php

      $mailer = new Mailer;

      <span class="comment">... //other codes here</span>
      
      $mailer->content('mail.template'); <span class="comment no-select">// can be defined in $mailer->sendmail() </span> 

      $mailer->inject(['name' => 'Foo']); 

      $mailer->sendmail(); 

    </pre>
                  </div>
                </div>
              </div>
              <div class="file-setup">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: File Template (mail/template.php)</code></div>
    <pre class="pre-code">

    &#60;?php

      Hi there &#123;&#123; $name &#125;&#125; <span class="comment">// rendered as Hi there Foo</span>

    </pre>
                  </div>
                </div>
              </div>

          </div>  <br>

          <div class="font-menu">
              The mail template file accepts pushing forward requests as either get or post request. 
              However, this must be defined in the placeholder.
          </div>


          
 <div class="font-menu pvs-4"> <a href="http://localhost/trial/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/trial/docs/mails">Mails</a> <span class="bi-chevron-right"></span> <a href="http://localhost/trial/docs/mails/inject">Inject</a>  </div>


        </div>
      </div>
    </section>

  </div>
      
      


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>