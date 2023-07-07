

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

    
    
    <?= Rexit::load('switcherJS') ?>
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
         

    
 
 
 <script rel="build.js.headers"> 
    

     $(document).ready(function(){
          function runHash(){
          $('.lacier').removeClass('active');
          $hash = hashRunner(':get');       
          $('#'+$hash).on('click',function(){
               let el = '#'+$hash+' .lacier';
               $('.lacier').removeClass('active');
               $(el).addClass('active');
          })
          hashRunner('id');             
          }
          runHash();
          $(window).on('hashchange', function() { runHash(); })
     })

 
</script>

 <header class="animated-header bc-white-dd flex-full pxv-10">

    <div class="flex text-caps font-em-1d2">
        <div class="flex midv">
            
            <div class="flex midv animation animate__bounceIn">
                <div class="theme-btn navtheme px-40 rad-r b-cover ico-spin">
    
                </div>
            </div>
            
        </div>
        <div class="no-wrap fb-6 c-blue-dd flex midv">
            <a href="<?= Rexit::domurl('/') ?>" class="inherit ch-i"><?= $topic ?? 'SPOOVA' ?></a>
        </div>
    </div>

 </header>


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

    <style>
        table tr td, table tr th{
            padding: 10px 0;
        }
        table tr td{
            font-family: calibri;
            font: menu;
            font-size: 14px;
        }
        table .bi-check {
            font-weight: 900;
            font-size: 2.5em;
            color: var(--lime-dd);
        }

        table .bi-x {
            font-weight: 900;
            font-size: 2.5em;
            color: var(--red-dd);
        }
        header {
            position: fixed;
            z-index: 2;
        }
        .nav-left{
            padding-top: 80px;
        }
        .features{
            padding-top: 60px;
        }
        a:hover{
            color: inherit;
        }
    </style>

    <nav class="nav-left fixed">

        <ul class="list-square">
            <li> <a href="<?= Rexit::domurl('docs/') ?>"><span class="ico ico-spin"></span>Home</a> </li>
            <li> <a href="<?= Rexit::domurl('about') ?>" class="<?= Rexit::inPath('active') ?>" ><span class="ico ico-spin"></span>About</a></li>
            <li> <a href="<?= Rexit::domurl('docs/') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Documentation</a></li>
            <li> <a href="<?= Rexit::domurl('docs/installation') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
            <li> <a href="<?= Rexit::domurl('features') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Features</a> </li>
            <li> <a href="<?= Rexit::domurl('version') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Releases</a> </li>
        </ul>

    </nav>

    <div class="box-full pxl-2 bc-white pull-right features">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

                <div class="c-black-ll font-em-1d2">

                    <div class="pxv-20 pvb-2">
                        <div class=" c-orange font-em-1d5"> <span class="bi-window font-em-d85"></span> <span class="font-em-d82">Project Pack</span></div>
                    </div>

                    <div class="pxv-20">
                        
                        <table class="wid-full">

                            <thead>
                                <tr class="c-slate-grey"> 
                                    <th>Features</th>
                                    <th> <i class="bi-vinyl"></i> Details</th> 
                                </tr>
                            </thead>

                            <tbody>

                                
                                <tr> 
                                    <td>PHP Version Support</td> 
                                    <td>  8.0+</td> 
                                </tr>    

                                <tr> 
                                    <td>MySQL Version Support</td> 
                                    <td> 5.4+ </td> 
                                </tr>    

                                <tr> 
                                    <td>Mobile Web Server Support</td> 
                                    <td> Android KWS Server (No root) </td> 
                                </tr> 

                                <tr> 
                                    <td>MVC Architecture</td> 
                                    <td>Windows-View-Model (WVM)</td> 
                                </tr>

                                <tr> 
                                    <td>Routing Support</td> 
                                    <td>Port(8080)</td> 
                                </tr>

                                <tr> 
                                    <td>Live Server Support</td> 
                                    <td>Stable</td> 
                                </tr>

                                <tr> 
                                    <td>Inbuilt Helper Tools</td> 
                                    <td>Meta, FileUploader, Mailer</td> 
                                </tr>

                                <tr> 
                                    <td>Inbuilt Helper Classes</td> 
                                    <td>JWSToken, Jsonfy, Hasher</td> 
                                </tr>

                                <tr> 
                                    <td>Css Library</td> 
                                    <td>Bootstrap, MD5 Bootstrap (lite), Local Library</td>
                                </tr>

                                <tr> 
                                    <td>Css Icons</td> 
                                    <td>Bootstrap Font Icons (v1.10.0)</td>
                                </tr>

                                <tr> 
                                    <td>Javascript Library</td> 
                                    <td>JQuery (3.5.6)</td> 
                                </tr>

                                <tr> 
                                    <td>Third-party Mailer Libraries (Required)</td> 
                                    <td>Emogrifier, PHPMailer</td> 
                                </tr>        

                                <tr> 
                                    <td>Documentation</td> 
                                    <td> 
                                        <span class="bi-journal-text"></span> 
                                        <a href="docs" class="c-teal hide rule-dotted">offline</a> 
                                        <a href="<?= Rexit::domurl('https://www.spoova.com') ?>" class="c-teal rule-dotted">online</a> 
                                    </td> 
                                </tr>     

                                <tr> 
                                    <td class="i"><i class="bi-app-indicator"></i> Version <i>(latest)</i></td> 
                                    <td> <i class="bi-journal-arrow-down"></i> version 2.5.0 </td> 
                                </tr> 
                            
                            </tbody>



                        </table>

                    </div>

                </div>
           </div>
       </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>