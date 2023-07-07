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
    color: rgb(173, 171, 171);
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
    color: rgb(173, 171, 171);
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


    <style>
        .flex-silver .bc-silver-d{
            background-color: rgb(0, 69, 90);
        }
        .flex-silver .bc-silver-dd{
            background-color: rgb(39, 101, 120);
        }
    </style>
    <div class="box-full i-trans bc-white">
        <section class="tutorial">
            
            <div class="pxs-12"> <br>
                <style>
                    .flow-auto.grid {
                        /* margin: 1em; */
                        display: grid;
                        grid-template-columns:repeat(2, 1fr);
                        grid-gap:1em;
                    }

                    @media (min-width:800px){

                        .flow-auto.grid {
                            /* margin: 1em; */
                            display: grid;
                            grid-template-columns:repeat(3, 1fr);
                            grid-gap:1em;
                        }
                        
                    }
                    @media (min-width:1000px){

                        .flow-auto.grid {
                            /* margin: 1em; */
                            display: grid;
                            grid-template-columns:repeat(4, 1fr);
                            grid-gap:1em;
                        }
                        
                    }
                    @media (min-width:1305px){

                        .flow-auto.grid {
                            /* margin: 1em; */
                            display: grid;
                            grid-template-columns:repeat(5, 1fr);
                            grid-gap:1em;
                        }
                        
                    }

                    .flex-item{
                        height: 200px;
                    }
                </style>

    <div class="padd-x-4">         
        
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= Rexit::domurl('docs/other-features/css') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d9 mvt-4">

            <div class="wid-fit c-olive"><h4>Display classes</h4></div>

            Display utilty classes are grouped into 9 classes based on block, grid, flex or 
            table display type. These classes are: <br> <br>

            <code>block</code> - for block elements <br>
            <code>in-block</code> - for inline-block elements <br>
            <code>in-line</code> - for inline elements <br>
            <code>grid</code> - for grid elements <br>
            <code>in-grid</code> - for inline-grid elements <br>
            <code>flex</code> - for flex boxes <br>
            <code>in-flex</code> - for inline-flex boxes <br>
            <code>table</code> - for table elements <br>
            <code>in-table</code> - for inline-table elements <br>

            <div class="mvt-6">
                The <code>grid</code> and <code>flex</code> utility classes are special classes which can be combined with their 
                modifier attributes that determines how a content is displayed. For this reason, they are both discussed below:
            </div>

        </span>
    </div><br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Grid Items</div>
            Grid elements can be identified by their special class name <code>"grid"</code>. The grid items are not entirely handled 
            by the local <code>css</code> library. However, it provides utility class <code>"grid-center"</code> for aligning items 
            to the center. This may prove useful in situations where items are needed to be centralized.
            <br><br>

            <div class="in-flex-full bc-silver-d">
                <div class="px-140 grid-center bc-silver bd-r bd-silver-d">
                    Hello in center
                </div>
<div class="box-full pre-area">
    <div class="pxv-10 bc-silver-d">
        Example of "grid-center"
    </div>
    <pre class="pre-code">
  <?php print to_lgts('
    <div class="px-140 grid-center bc-silver">
        Hello in center
    </div>

    ')
  ?>
    </pre>
</div>
            </div>

        </span>

    </div> <br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Flex Items</div>
            Any element that has the class of <code>"flex"</code> is considered as a flex item while <code>"in-flex"</code> is used to 
            specify an inline-flex item. Flex is mostly used in form alignments.
            Flex items are greatly controlled by combining the name with other utility classes. Classes that can be combined with the <code>flex</code> 
            or <code>in-flex</code> are mostly used for flex alignments. Some of the classes and their features are listed below: <br>
            <span class="form-field">
                
                <code class="main">flex-l</code> - shifts a flex child item to the left<br>
                <code class="main">flex-lt</code> - shifts a flex child item to the left top<br>
                <code class="main">flex-lb</code> - shifts a flex child item to the left bottom<br>

                <code class="main">flex-r</code> - shifts a flex child item to the right<br>
                <code class="main">flex-rt</code> - shifts a flex child item to the right top<br>
                <code class="main">flex-rb</code> - shifts a flex child item to the right bottom<br>

                <code class="main">flex-col / f-col</code> - sets flex direction to column<br>
                <code class="main">flex-row / f-row</code> - set flex direction to row<br>
                <code class="main">flex-col-m</code> - sets flex direction to row on smaller screen size<br>
                <code class="main">flex-row-m</code> - sets flex direction to column on smaller screen size <br>

                <code class="main">mid</code> - centralizes the position of child items to the middle (vertically and horizontally) of the parent flex item <br>
                <code class="main">midl</code> - centralizes the position of child items vertically to the middle left of the parent flex item  <br>
                <code class="main">midr</code> -  centralizes the position of child items vertically to the middle right of the parent flex item   <br>
                <code class="main">midv</code> -  centralizes the position of child items vertically <br>
                <code class="main">midh</code> -  centralizes the position of child items horizontally <br>
               
                <code class="main">just-left</code> - justifies flex items to start <br>
                <code class="main">just-right</code> - justifies flex items to end  <br>
                <code class="main">just-center</code> -  justifies flex contents to center <br>
                <code class="main">flex-start</code> -  justifies flex contents to flex-start   <br>
                <code class="main">flex-end</code> -  justifies flex contents to flex-end <br>
                <code class="main">flex-center</code> -  justifies and aligns flex contents to center <br>
                <code class="main">space-between</code> -  justifies contents using space-between <br>
                <code class="main">space-around</code> -  justifies contents using space-around <br>
                <code class="main">space-even</code> -  justifies contents using space-evenly <br>
                <br>
                There is however a twist when it comes to setting flex items to 100 percent width. While 
                <code>flex-full</code> is applied specially for items with flex property, <code>in-flex-full</code> is applied for items with inline-flex display property.
                The images below reveals the effect of flex boxes when other utility classes are applied with it. <br><br>
            </span>

            <div class="flow-auto flex-silver grid">

                <div class="box shadow-1-strong">
                    <div class="flex flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex f-row
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex f-col flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex f-col
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex mid flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex mid
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midh flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midh
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midv flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midv
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midl flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midl
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midr flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midr
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-l flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-l
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-r flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-r
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-c flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-c
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-left flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-left
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-right flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-right
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-start flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-start
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-end flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-end
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-between flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-between
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-around flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-around
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-even flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-even
                </div>




            </div>
        </span>

    </div> <br>
            </div>
        </section>
    </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>