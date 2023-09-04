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
               <a href="<?= Rexit::domurl() ?>" class="flex c-i inherit">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square calibri">
               <li> <a href="<?= Rexit::domurl('docs/installation') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/wmv') ?>" class="<?= Rexit::inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows View Models">WVM</span> PATTERN</a></li>
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
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2"> <span class="bi-journal-text"></span> Documentation </div>
                    
                        <div class="font-em-d8">
                            The spoova project pack comes with an offline documentation. This is accessible through the 
                            project packs navigation bar. When a new project application is created, spoova tries to 
                            keep the created project as clean as possible. Hence, the documentation will 
                            not be available in the project app. The quick access link below may prove useful to easily 
                            navigate to some sections within the application.
                        </div>
                    </div>

                    <div class="bc-white-dd">
                        <div class="pxv-10 font-em-d8" style="color: #e3dcdc;
background-color: #56567b;">
    
                            <div class="bi"> <span class="bi-filter-circle"></span> Quick Access </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8" style="color:#76769d;">
                            <div class="">
                              <div class="fb-6"> 
                                <a href="<?= Rexit::route('::installation') ?>" class="c-i"><i class="bi-circle"></i> Project Installation</a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="<?= Rexit::route('::wmv') ?>" class="c-i"><i class="bi-circle"></i> About WVM </a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="<?= Rexit::route('::live-server') ?>" class="c-i"><i class="bi-circle"></i> Live server </a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Resource grouping</div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::resource.grouping') ?>" class="c-i"> Naming resources (global) </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::domurl('version/2.0/resource') ?>" class="c-i"> Naming resources (unique) </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Database management </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::database') ?>" class="c-i"> Database operations </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::forms') ?>" class="c-i"> Form Request Management </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::domurl('docs/database/data-model') ?>" class="c-i"> Data Model </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::domurl('docs/database/migration') ?>" class="c-i"> Database Migration </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Session management </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::sessions') ?>" class="c-i"> Session class </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::sessions') ?>" class="c-i"> Window sessions </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::useraccounts') ?>" class="c-i"> User management </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Helper Resources </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::classes') ?>" class="c-i"> Helper classes </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::functions') ?>" class="c-i"> Helper Functions </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::other-features/css') ?>" class="c-i"> Helper Css </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::other-features/javascript') ?>" class="c-i"> Javascript Integrations </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Template Engine </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::domurl('docs/template/compilers') ?>" class="c-i"> Template compilers </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::domurl('version/2.0/compiler-class') ?>" class="c-i"> Compiler class </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::template/files') ?>" class="c-i"> Template files </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::template/directives') ?>" class="c-i"> Template directives </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::template/window') ?>" class="c-i"> Template directives </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="<?= Rexit::route('::template/on_the_go') ?>" class="c-i"> Template auto generation </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="<?= Rexit::route('::cli') ?>" class="c-i"><i class="bi-circle"></i> Cli commands</a>
                              </div>                            
                            </div>
                        </div> <br>
                    </div>

                </div>
           </div>
       </section>
   </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>