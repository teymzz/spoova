<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>Css Integerations</title>
    <?= Rexit::load('headers') ?>
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: Roboto;
     }

     .tutorial{
          min-height:100vh;
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
          font-family: firacode;
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
    color: rgb(125, 125, 125);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
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
    <!-- @live -->
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
         

    
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: Roboto;
     }

     .tutorial{
          min-height:100vh;
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
          font-family: firacode;
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
    color: rgb(125, 125, 125);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
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


<?= Res::live() ?>
    <style>
        body.--theme-dark .bc-silver-mod{
            background-color: #232940;
            color: rgb(153, 152, 152);
        }

        body.--theme-dark input{
            color: white;
        }
    </style>

    <section class="tutorial"> <br>
    
      <div class="pxs-12">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= Rexit::domurl('docs/other-features/css') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="">
            <div class="wid-fit c-olive font-em-1d5">Forms and Form Alignments</div>
            <div class="">
                Forms are mostly controlled using the <code>i-flex</code> class, although 
                <code>in-flex</code> and <code>flex</code> can also be applied. Other special 
                classes included <code>flex-full</code>, <code>flex-btn</code>, 
                <code>i-flex-btn</code> and <code>flex-child</code> classes.
            </div>
            <br>
            <ul class="mvt-10">
                <li><code>i-flex</code> -  sets input field up with flex properites</li>
                <li><code>i-flex-full</code> - sets input field up with flex properites at 100% width </li>
                <li><code>flex-btn</code> - used on form buttons </li>
                <li><code>flex-full</code> - applied on any form field</li>
            </ul>

            <div class="">
                Since these flex classes have the properties of a <code>flex</code> display type, utility classes 
                like <code>f-row</code> (or <code>flex-row</code> ) and <code>f-col</code> (or <code>flex-col</code>)
                can be applied on them. The example below defines how to set up a form input field using these predefined  
                classes.
            </div> <br>

            <div class="">

                <div class="bc-silver bc-silver-mod sample shadow-1">
                    <div class="bc-silver-d pxv-8">Form Input with <span class="c-teal">i-flex</span> property</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex bc-white-d" placeholder="Firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            
                            <div class="pre-area">
 <pre class="pre-code">
 <?php
 print to_lgts('<input type="text" class="i-flex" placeholder="firstname">');
 ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div><br>

                <div class="bc-silver bc-silver-mod sample shadow-1">
                    <div class="bc-silver-d pxv-8">Form Input with <span class="c-teal">i-flex-full</span> property</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex-full" placeholder="firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="pre-area">
 <pre class="pre-code">
 <?php
    print to_lgts('<input type="text" class="i-flex-full" placeholder="firstname">');
 ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="foot-note">
                    The <code>input</code> field's height above can be increased by setting a padding on the <code>input</code>
                    field itself just as shown below:
                </div> <br>

                <div class="bc-silver bc-silver-mod sample">
                    <div class="bc-silver-d pxv-8">Form Input with padding (10 pixels)</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex-full pxv-10" placeholder="firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="pre-area">
 <pre class="pre-code">
 <?php
    print to_lgts('<input type="text" class="i-flex-full pxv-10" placeholder="firstname">');
 ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>                

                <div class="foot-note">
                    In the code above, although we applied padding of "10 pixels" to all sides, only the top and bottom paddings were 
                    added. In situations we need to control the entire element padding, we can use a wrapper instead just shown as below: 
                </div> <br>


                <div class="bc-silver bc-silver-mod sample">
                    <div class="bc-silver-d pxv-6">Wrapping Form Input</div>
                    <div class="pxv-10">
                        <div class="i-flex-full pxv-10">
                            <input type="text" class="i-flex-full bco-10" placeholder="firstname"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full bc-white pxv-10">
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="firstname"> <br><br>
  </div>');
  ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>                    

                <div class="mvt-10 foot-note">
                    Yeah, That's it! Just by wrapping our <code>input</code> in a <code>div</code> with class <code>i-flex</code> 
                    or <code>i-flex-full</code>, we have been able to control the side margins. Also, in order to achieve this, the <code>input</code> 
                    was defined with a transparent white background while the parent <code>div</code> was given the desired background color. This means that 
                    our input can inherit its background color from the parent element. Aside from background colors and margins, wrapping our <code>input</code> 
                    elements in a div is the most ideal way to set up the form inputs using the predefined classes. 
                </div><br>

                <div class="bc-silver bc-silver-mod sample">
                    <div class="bc-silver-d pxv-6"> Form Input with side button (left) </div>
                    <div class="pxv-10">
                        <div class="i-flex-full bc-white">
                           <span class="flex-ico bc-silver-dd pxs-12">
                            <span class="ico-envelope"></span>
                           </span> 
                           <input type="text" class="i-flex-full bco-10 bc-silver" placeholder="email@example.com"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full bc-white">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span> 

    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

  </div>');
  ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>  


                <div class="foot-note">
                    The input design above will not be possible without an input wrapper. Which makes it easier to position 
                    our input icon (i.e <code>flex-ico</code>). Since the <code>input</code> exists at an 100% width, we can  
                    shift our icon to the right side of the input item and this will still work fine. This is show below: <br>
                </div>     
                

                <div class="bc-silver bc-silver-mod sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form Input with side button (right) </div>
                    <div class="pxv-10">
                        <div class="i-flex-full bc-white">
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full">
      
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span> 

  </div>');
  ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>  

                
                <div class="foot-note">
                    In the code above, when we switched our icon, notice that the wrapper <code>div</code> 
                    was given a left padding to push the input button a bit towards right side. Without applying 
                    the left padding, the <code>input</code> may look closer to the left than usual.
                </div> <br>

                <div class="bc-silver bc-silver-mod sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form: round input field with button </div>
                    <div class="pxv-10">
                        <div class="i-flex-full-in rad-r bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full-in rad-r bc-white">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span>       
    
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

  </div>');
  ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div> 
             
                <div class="mvt-10">
                    The sample above shows how to build a round input field by using the <code>i-flex-full-in</code> property. 
                    When the <code>i-flex-in</code> or <code>i-flex-full-in</code> utitily classes are applied to elements, aside 
                    from setting the element's display property as <code>flex</code>, it also extends to setting the property of 
                    <code>overflow:hidden</code> on the element. In most times, when we have an overflowing flex child, it is better to use 
                    the <code>i-flex-in</code> or <code>i-flex-full-in</code> classes or we could just add the 
                    <code>flow-hide</code> property to keep our content within the parent element.
                </div> 

            </div>   <br>

            <!-- Heading -->
            <div class="wid-fit c-olive font-em-1d5"><span class="bi-circle-fill c-silver-d mxr-6"></span>Form Fields</div>

            <div class="">

                <div class="">
                    Form fields are mostly needed for stacking form inputs together either as rows or as columns. At most 
                    times, forms inputs are usually aligned on separate lines. Naturally, the utility classes does not define vertical 
                    spaces or gaps of form input fields. Howvever, when a class of <code>form-field</code> is applied on the form input's 
                    direct parent element, the css library will understand that each form field is expected to have a vertical spacing just as below: 
                </div>
                <br>

                <div class="bc-silver bc-silver-mod sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form input fields without a parent "form-field" </div>
                    <div class="pxv-10">

                        <div class="i-flex-full-in bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                        </div>
                        <div class="i-flex-full-in bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-plane"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
                        </div>

                        <div class="bc-white-dd pxv-12">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-envelope"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
  </div>

  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-plane"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
  </div>');
  ?> 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="foot-note">
                    In the code above, the forms a aligned next to each other without a space. In order to add a space, 
                    we have to define the <b class="c-orange">form field</b> itself as shown below:
                </div>

                

                <div class="bc-silver bc-silver-mod sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form input fields with a direct parent "form-field" </div>
                    <div class="pxv-10">

                        <div class="form-field">
                            <div class="i-flex-full-in bc-white shadow-1">
                                <span class="flex-ico bc-silver pxs-12">
                                 <span class="ico-envelope"></span>
                                </span> 
                                <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                            </div>
                            <div class="i-flex-full-in bc-white shadow-1">
                                <span class="flex-ico bc-silver pxs-12">
                                 <span class="ico-plane"></span>
                                </span> 
                                <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
                            </div>
                        </div>

                        <div class="bc-white-dd pxv-12 mvt-4">
                            <div class="pre-area">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-envelope"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
  </div>

  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-plane"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
  </div>');
  ?> 
 </pre>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mvt-6">
                    We can also add spaces with direct parents having any of the <code>sp-d5</code>, <code>sp-d7</code> 
                    or <code>sp-1</code> classes with <code>sp-1</code> being the highest number of vertical spaces we can
                    add for form input fields. 
                </div>
                    
            </div> <br>


            
            <!-- Heading -->
            <div class="wid-fit c-olive font-em-1d5"><span class="bi-circle-fill c-silver-d mxr-6"></span>Form Animations</div>
            
            Form input placeholders can be animated using the <code>data-anime="place"</code> attribute along with a <code>data-cast</code> 
            and <code>data-rule</code> attribute. The <code>data-cast</code> is used to define the behaviour of the placeholder text with options 
            like <code>"fade"</code>, <code>"up-fade"</code>, <code>"up-fill"</code>, <code>"up-stick"</code>, <code>"up-wait"</code> and <code>"up-shrink"</code>. 
            However, the <code>data-rule</code> attriube is an attribute that determines a bottom line animation. The input forms below are samples of these 
            animations.
            <!-- There are basically two animations that can be applied on the form inputs or placeholders. In order to set a transition 
            on the form inputs, the utility class <code>anime-place</code> must be added to the form field wrapper. Examples are shown below:  -->
            <br><br>

            <!-- first animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 1</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="fade">
                            <input id="anime-1" type="text" name="username" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-1">Animation 1</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    The first placeholder animation above is one in which the input's text fades out once 
                    it is focused on.  This is done by setting the <code>data-cast</code> 
                    option of as <code>"fade"</code>. The code sample is shown below:
                </div><br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex rad-r bc-white midv font-em-1d1">
    <div class="rad-r" data-anime="place" data-cast="fade">
        <input id="anime-1" type="text" name="username" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-1">Animation 1</label>
    </div>
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- second animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 2</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="up-fade">
                            <input id="anime-2" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-2">Animation 2</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    The placholder animation above allows the text to 
                    fade up once the input is focused upon. The sample code is shown below:
                </div> <br>               
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('
  <div class="i-flex rad-r bc-white midv font-em-1d1">
    <div class="rad-r" data-anime="place" data-cast="up-fade">
        <input id="anime-2" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-2">Animation 2</label>
    </div>
  </div>
  ');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- Third animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 3</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="up-wait">
                            <input id="anime-3" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-3">Animation 3</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    The third animation  above is one in which the placeholder text 
                    slides up when focused upon but fades out once a text has been entered.
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex anime-place loaded">
    <label for="anime-3" class="place">Animation 3</label>
    <input id="anime-3" type="text" class="i-flex-full pxv-6" placeholder="Animation 3">
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- fourth animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 4</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="up-fill">
                            <input id="anime-4" type="text" name="username" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-4">Animation 4</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    The fourth animation  defines a placeholder that shifts up and 
                    stays until a text is filled in and the input is focused out. 
                    If no text was entered, after focusing out, the placeholder 
                    will return back to its initial position rather than fading out.
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex anime-place loaded">
    <label for="anime-4" class="place">Animation 4</label>
    <input id="anime-4" type="text" class="i-flex-full pxv-6" placeholder=" ">
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- fifth animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 5</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="up-shrink">
                            <input id="anime-5" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-5">Animation 5</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    The fifth animation above defines a placeholder that shifts up and 
                    stays up unless no text was entered after it was focused out. This means that the text will stay up 
                    as long as the input field is focused upon or text is filled in.
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex anime-place loaded">
    <label for="anime-5" class="place">Animation 5</label>
    <input id="anime-5" type="text" class="i-flex-full pxv-6" placeholder=" ">
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- seventh animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 7</div>
                <div class="pvs-10">
                    <div class="i-flex rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="up-stick" data-shrink="" padd="hard">
                            <input id="anime-7" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-7">Animation 7</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    If the padding of the animation is too big, we can use the <code>padd</code> attribute to adjust the passing 
                    with a value of <code>"soft"</code>, <code>"fair"</code> or <code>"hard"</code>. The default value is <code>"fair"</code>. 
                    This is shown below:
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex rad-r bc-white midv font-em-1d1">
    <div class="rad-r" data-anime="place" data-cast="up-stick" data-shrink="" padd="hard">
        <input id="anime-7" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-7">Animation 7</label>
    </div>
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <!-- eight animation -->
            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 8</div>
                <div class="pvs-10">
                    <div class="i-flex bc-white midv font-em-1d1">
                        <div class="" data-anime="place" data-cast="up-stick" data-shrink="" data-rule padd="soft">
                            <input id="anime-8" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-8">Animation 8</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    We can also add an animated ruler to the animated placeholder by adding the attribute <code>data-rule</code> 
                    as shown below:
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex bc-white midv font-em-1d1">
    <div class="" data-anime="place" data-cast="up-stick" data-shrink="" data-rule padd="soft">
        <input id="anime-8" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-8">Animation 8</label>
    </div>
  </div>');
  ?> 
 </pre>
                            </div>
            </div>

            <div class="foot-note">
              Note that rounded borders does not work well with animated line. In order to use the rounded borders 
              along with animated bottom line, then the element with the parent element must be 
              set to an <code class="">overflow:hidden</code> style. This can be done through the <code>i-flex-in</code> 
              class. Also, the border radius must be applied on both the parent element and the element with the 
              <code>data-anime</code> attribute. The overflow hidden property will prevent the animated text from sticking up. 
              In this situation, the <code>data-cast="fade"</code> is the best option to use. The animation and code structure is shown below:
            </div> 

            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 9</div>
                <div class="pvs-10">
                    <div class="i-flex-in rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="fade" data-rule padd="soft">
                            <input id="anime-9" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-9">Animation 9</label>
                        </div>
                    </div>
                </div>
                <div class="">
                    We can also add an animated ruler to the animated placeholder by adding the attribute <code>data-rule</code> 
                    as shown below:
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-in rad-r bc-white midv font-em-1d1">
    <div class="rad-r" data-anime="place" data-cast="fade" padd="soft">
        <input id="anime-9" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-9">Animation 9</label>
        <div line=""></div>
    </div>
  </div>
  ');
  ?>
 </pre>
                            </div>
            </div>

            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 10</div>
                <div class="pvs-10">
                    <div class="i-flex-in rad-r bc-white midv font-em-1d1">
                        <div class="rad-r" data-anime="place" data-cast="fade" data-rule="line" padd="soft">
                            <input id="anime-10" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-10">Animation 10</label>
                            <span line class="c-red"></span>
                        </div>
                    </div>
                </div>
                <div class="">
                    The easiest way to change the color of the bottom ruler animation as shown above is to set the value of the 
                    <code>data-rule</code> as <code>"line"</code> an to add an extra line field that can be styled with colors 
                    as shown below:
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-in rad-r bc-white midv font-em-1d1">
    <div class="rad-r" data-anime="place" data-cast="fade" data-rule="line" padd="soft">
        <input id="anime-9" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-9">Animation 10</label>
        <div line="" class="c-red"></div>
    </div>
  </div>
  ');
  ?>
 </pre>
                            </div>
            </div>

            <div class="bc-white-dd bc-silver-mod pxv-12 shadow mvt-6">
                <div class="no-select c-grey">code structure - Animation 11</div>
                <div class="pvs-10">
                    <div class="i-flex-in bd-f rad-r bc-white font-em-1d1">
                        <span class="flex-ico bi-cursor bc-orange c-white"></span>
                        <div class="rad-r bd-l-none" data-anime="place" data-cast="fade" data-rule="line" padd="soft">
                            <input id="anime-11" type="text" class="flex-full rad-i bco-8 c-i" placeholder=" ">
                            <label for="anime-11">Animation 11</label>
                            <span line class="c-orange line"></span>
                        </div>
                    </div>
                </div>
                <div class="">
                    When using the placeholder animation, we can add input icons using the <code>flex-ico</code> 
                    attribute as shown above. The format is shown below:
                </div> <br>
                <div class="pre-area bc-white">
 <pre class="pre-code">
  <?php
  print to_lgts('<div class="i-flex-in bd-f rad-r bc-white font-em-1d1">
    <span class="flex-ico bi-chat-dots bc-orange c-white"></span>
    <div class="rad-r" data-anime="place" data-cast="fade" data-rule="line" padd="soft">
        <input id="anime-11" type="text" class="flex-full bc-white rad-i bco-8 c-i" placeholder=" ">
        <label for="anime-11">Animation 11</label>
        <span line class="c-orange"></span>
    </div>
  </div>
  ');
  ?>
 </pre>
                            </div>
            </div>


        </div>  
        
      </div> 

    </section> <br>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>