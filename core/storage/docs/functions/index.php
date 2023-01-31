

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



  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/functions">Functions</a>  </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions</div> <br>  
          
          <div class="resource-intro">
              <div class="fb-6 c-olive">Introduction</div>
              <div class="">

                  <div class="">
                    Helper functions are predefined spoova functions that eases building 
                    web applications. Spoova helper functions are divided into five categories 
                    (CMLS)
                  </div><br>

                  <ul>
                    <li><a href="#core" data-scroll-hash="core" data-minus="10">Core Functions</a></li>
                    <li><a href="#modal" data-scroll-hash="modal" data-minus="10">Modal Functions</a></li>
                    <li><a href="#lite" data-scroll-hash="lite" data-minus="10">Lite Functions</a></li>
                    <li><a href="#script" data-scroll-hash="script" data-minus="10">Script Functions</a></li>
                  </ul>
                  
              </div>
          </div>
          
          <div id="core" class="core-helpers"> 
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">1. Core Functions</div>
              </div> <br>
              
              <div>The core helper functions are custom functions that are introduced 
              into the core framework itself due to their high level of importance. They 
              sometimes have direct relationships with main classes and just provide an easier         
              means of accessing these classes methods or returns the value of specific methods  
              The removal of any of these methods will most likely result in a broken application. 
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9 c-aqua-dd" style="color:rgb(12, 131, 131)">
                    <ul>
                      <li> <a href="<?= route('::core#webclass'); ?>"> webClass </a> </li>
                      <li> <a href="<?= route('::core#webtool'); ?>"> webTool </a> </li>
                      <li> <a href="<?= route('::core#isguest'); ?>"> isGuest </a> </li>
                      <li> <a href="<?= route('::core#isuser'); ?>"> isUser </a> </li>
                      <li> <a href="<?= route('::core#ishttp'); ?>"> isHTTP </a> </li>
                      <li> <a href="<?= route('::core#ishttps'); ?>"> isHTTPS </a> </li>
                      <li> <a href="<?= route('::core#isabsolutepath'); ?>"> isAbsolutePath </a> </li>
                      <li> <a href="<?= route('::core#invoked'); ?>"> invoked </a> </li>
                      <li> <a href="<?= route('::core#windowincludes'); ?>"> windowIncludes </a> </li>
                      <li> <a href="<?= route('::core#windowexcludes'); ?>"> windowExcludes </a> </li>
                      <li> <a href="<?= route('::core#authdirect'); ?>"> authDirect </a> </li>
                      <li> <a href="<?= route('::core#guestdirect'); ?>"> guestDirect </a> </li>
                      <li> <a href="<?= route('::core#redirect'); ?>"> redirect </a> </li>
                      <li> <a href="<?= route('::core#response'); ?>"> response </a> </li>
                      <li> <a href="<?= route('::core#setvar'); ?>"> setVar </a> </li>
                      <li> <a href="<?= route('::core#vdump'); ?>"> vdump </a> </li>
                      <li> <a href="<?= route('::core#urlparams'); ?>"> urlParams </a> </li>
                      <li> <a href="<?= route('::core#url'); ?>"> url </a> </li>
                      <li style="list-style: square;">
                        <div class="pvt-6 fb-6 font-menu font-em-1">Template Compiler functions</div>    
                        <ul class="list-disc" style="padding:.5em">
                          <li> <a href="<?= DomUrl('docs/functions/core#compile') ?>"> compile </a> </li> </li>
                          <li> <a href="<?= DomUrl('docs/functions/core#view') ?>"> view </a> </li> </li>
                        </ul>
                      </li>
                    </ul>
                  </div>
              </div>        
          </div>         
          
          <div id="modal" class="modal-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">2. Modal Functions</div>
              </div> <br>
              
              <div>
                The modal custom helper functions are functions that help to handle some tedious 
                tasks easily. They have no relationship with 
                higher classes but are cogent in the build-up of spoova frame. The removal of 
                some of these functions may lead to broken applications. Hence are best not 
                removed. 
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131)">
                    <ul class="list-square">
                      <li> <a href="<?= DomUrl('docs/functions/modal#br') ?>"> br </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#refil') ?>"> refil </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#encodeuricomponent') ?>"> encodeURIComponent </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#inrange') ?>"> inRange </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#randice') ?>"> randice </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#is_empty') ?>"> is_empty </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#not_empty') ?>"> not_empty </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#combine') ?>"> combine </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#compare') ?>"> compare </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#arrinside') ?>"> arrInside </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#arrvoid') ?>"> arrVoid </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#arrgetsvoid') ?>"> arrGetsVoid </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#arrsort') ?>"> arrSort </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#array_trim') ?>"> array_trim </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#array_get') ?>"> array_get </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#array_object') ?>"> array_object </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#array_delete') ?>"> array_delete </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#array_unset') ?>"> array_unset </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/modal#reitemize') ?>"> reItemize </a> </li>
                    </ul>
                  </div> 
              </div>        
          </div>         
          
          <div id="lite" class="lite-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">3. Lite Functions</div> 
              </div> <br>
              
              <div>
                The lite helper functions are functions that are either coined 
                from an existing php internal functions or custom functions that are 
                applied on texts. These functions exist to ease building web applications 
                for developers as they can sometimes prove useful.
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131);">
                    <ul class="list-square">
                      <li> <a href="<?= DomUrl('docs/functions/lite#base_encode') ?>"> base_encode </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#base_decode') ?>"> base_decode </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#tojson') ?>"> toJson </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#fromjson') ?>"> fromJson </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#enplode') ?>"> enplode </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#tosingular') ?>"> toSingular </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#inflect') ?>"> inflect </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#to_lgts') ?>"> to_lgts </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#href') ?>"> href </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#scriptname') ?>"> scriptName </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#striplastslash') ?>"> striplastSlash </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#redirectto') ?>"> redirectTo </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#limittext') ?>"> limitText </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#limitchars') ?>"> limitChars </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/lite#limitword') ?>"> limitWord </a> </li>
                    </ul>
                  </div>
              </div>        
          </div>         
          
          <div id="script" class="script-helpers">
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full c-olive">4. Script Functions</div> 
              </div> <br>
              
              <div>
                The script helper functions are functions are custom functions that depend on
                javascript to run. These functions may prove useful when handling data types or when doing 
                simple debugging.
              </div> <br>

              <div class="">
                  <div class="font-menu font-em-d9" style="color:rgb(12, 131, 131)">
                    <ul class="list-square">
                      <li> <a href="<?= DomUrl('docs/functions/script#alert') ?>"> alert </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/script#javaconsole') ?>"> javaconsole </a> </li>
                      <li> <a href="<?= DomUrl('docs/functions/script#script') ?>"> script </a> </li>
                    </ul>
                  </div> <br>
              </div>        
          </div> 
          
          <div class="">
            There are other functions which are not discussed within this page. Some are discussed under other subheadings where  
            they are neccessary or required to be discussed.
          </div>
        
        </div>  
        
        
        
      </div>
    </section>
  </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>