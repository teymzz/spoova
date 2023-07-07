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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

            <div class="start font-em-d8">

                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                <div class="font-em-1d5 c-orange">Meta</div> <br>  
                
                <div class="helper-classes">
                    <div class="">

                    <div class="">
                        The meta class is created to handle meta tags. The attributes and 
                        values of these tags are supplied and then rendered. The following are the 
                        available methods and their descriptions
                    </div> <br>

                        <ul class="c-sky-blue-dd">
                            <li> <a href="#charset" data-scroll-hash="" data-minus="10"> charset </a> </li>
                            <li> <a href="#add" data-scroll-hash="" data-minus="10"> add </a> </li>
                            <li> <a href="#name" data-scroll-hash="" data-minus="10"> name </a> </li>
                            <li> <a href="#prop" data-scroll-hash="" data-minus="10"> prop </a> </li>
                            <li> <a href="#equiv" data-scroll-hash="" data-minus="10"> equiv </a> </li>
                            <li> <a href="#refresh" data-scroll-hash="" data-minus="10"> refresh </a> </li>
                            <li> <a href="#og" data-scroll-hash="" data-minus="10"> og </a> </li>
                            <li> <a href="#link" data-scroll-hash="" data-minus="10"> link </a> </li>
                            <li> <a href="#drop" data-scroll-hash="" data-minus="10"> drop </a> </li>
                            <li> <a href="#export" data-scroll-hash="" data-minus="10"> export </a> </li>
                            <li> <a href="#dump" data-scroll-hash="" data-minus="10"> dump </a> </li>
                        </ul>
                        
                    </div> 
                </div>

                <div id="meta">
                    The <code>Meta</code> class can be initialized by defining the meta charset type. <code>new Meta('UTF-8')</code> will 
                    declare a new <code>UTF-8</code> meta tag. However, this can also be done using the 
                    <code>charset()</code> method. The following are lists of available methods in the meta class.
                </div> <br>

                <div id="charset" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class="mxr-8 bi-circle-fill"></span> Charset
                            </div>
                        </div>
                        <div class="">
                        This method is used to set the charset of meta tags. Example is shown below: <br><br>
                        
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Sample: setting charset</div>
                                <pre class="pre-code">
  $meta  = new Meta();
  
  $meta->charset('UTF-8'); <span class="comment"> // set meta charset</span>
                                </pre>
                            </div>
                        </div>

                        </div>
                    </div> <br><br>
                </div>

                <div id="add" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> Add
                            </div>
                        </div>

                        <div class="">
                            The <code>add</code> method is used to add attributes to meta tags.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding attributes</div>
                                    <pre class="pre-code">
  $meta->add(name, content, type); 
<span class="comment"> 
    where: 

    name    : the name, property or http-equiv attribute value of meta tags 
    content : the content attribute of meta tags 
    type    : the type of meta tag. Options - [name|property|http-equiv]
                default type is name.
</span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding attributes</div>
                                    <pre class="pre-code">
  $meta->add('viewport', 'width=device-width, initial-scale=1.0');
  
  $meta->add('robots', 'noindex, nofollow');
  
  $meta->add('description','150 words');
  
  $meta->add('og:type', 'game.achievement', 'property');
  
  $meta->add('Pragma', 'no-cache', 'http-equiv');
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Examples above respectfully translates:</div>
    <pre class="pre-code">
  <span class="comment no-select">&#60;meta name="viewport" content="width=device-width, initial-scale=1.0"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="robots" content="noindex, nofollow"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="description" content="150 words"/&#62</span>
  
  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
  
  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="name" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> name
                            </div>
                        </div>

                        <div class="">
                            The <code>name</code>  method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding property tags</div>
                                    <pre class="pre-code">
  $meta->name(name, content); 
  <span class="comment"> 
    where: 

    name : the name attribute value of meta tag
    content  : the content attribute value of meta tag
  </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                <div class="pxv-6 bc-off-white">Example: adding named meta tags</div>
    <pre class="pre-code">
  $meta->name('description', '150 words');  
  
  <span class="comment no-select">//translates as:  &#60;meta name="description" content="150 words"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="prop" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> Prop
                            </div>
                        </div>

                        <div class="">
                            The <code>prop</code> method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding property tags</div>
                                    <pre class="pre-code">
  $meta->prop(property, content); 
<span class="comment"> 
    where: 

    property : the property attribute value of meta tag
    content  : the content attribute value of meta tag
</span>
                                    </pre>
                                </div>
                            </div>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding property meta tags</div>
                                    <pre class="pre-code">
  $meta->prop('og:type', 'game.achievement');  
    <span class="comment no-select">
  // translates as:  &#60;meta property="og:type" content="game.achievement"/&#62
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="equiv" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> http-equiv
                            </div>
                        </div>

                        <div class="">
                            The <code>equiv</code>  method is a shorthand for the meta tags with the attribute of http-equiv.
                            Example is shown below: <br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding http-equiv to meta tags</div>
                                    <pre class="pre-code">
  $meta->equiv(http-equiv, content); 
    <span class="comment"> 
        where: 

        http-equiv : the http-equiv attribute value of meta tag
        content  : the content attribute value of meta tag
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding http-equiv meta tags</div>
                                    <pre class="pre-code">
  $meta->equiv('Pragma', 'no-cache',);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>
                
                <div id="refresh" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> refresh
                            </div>
                        </div>
                        <div class="">
                            The <code>refresh</code>  method is a shorthand for the meta tags with the attribute of 
                            <code>http-equiv="refresh"</code>. Example is shown below:<br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding http-equiv to meta tags</div>
                                    <pre class="pre-code">
  $meta->refresh(time); 
    <span class="comment"> 
        where: 

        time : time in seconds
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding refresh to meta tags</div>
                                    <pre class="pre-code">
  $meta->refresh(30);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="refresh" content="30"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="og" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> og
                            </div>
                        </div>

                        <div class="">
                            The <code>og</code> method is a shorthand for the meta tags with the attribute of 
                            <code>property="og:"</code>.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding og to meta tags</div>
                                    <pre class="pre-code">
  $meta->og(type, content); 
    <span class="comment"> 
        where: 

        type : og type.
        content : content atttribute of og meta tags.
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding og property to meta tags</div>
                                    <pre class="pre-code">
  $meta->og('type', 'game.achievement');  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="link" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> link
                            </div>
                        </div> 
                        <div class="">
                            The <code>link</code> method is used to add properties <code>link</code> meta tags. 
                            Examples are shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: adding og to meta tags</div>
                                    <pre class="pre-code">
  $meta->link(rel, href, attrs); 
    <span class="comment"> 
        where: 

        rel : relativity attribute of link tag.
        href : href atttribute of link tags.
        attrs: other attributes of link tag
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: adding og property to meta tags</div>
                                    <pre class="pre-code">
  $meta->link('icon', 'https://somesite.com/icon.png",['type' => 'image/png']);  
    <span class="comment no-select">
    // <span class="comment no-select">&#60;link rel="icon" href="https://somesite.com/icon.png" type="image/png" /&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="drop" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> drop
                            </div>
                        </div> 
                        <div class="">
                            The <code>drop()</code> method removes all stored meta definitions from storage list.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Sample: clearing definitions</div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  $meta->drop(); <span class="comment">// clear previous descriptions</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="export" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> export
                            </div>
                        </div> 
                        <div class="">
                            The <code>export()</code> method displays all stored meta definitions from storage list on each line.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Sample: display all stored meta tags</div>
                                    <pre class="pre-code">
    $meta->export(); <span class="comment">// displays each predefined meta tags in a listed order</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="dump" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> dump
                            </div>
                        </div> 
                        <div class="">
                            The <code>dump()</code> method returns all stored meta tags. However, when a boolean argument of <code>true</code> 
                            is supplied, it prints out all stored meta tags.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Sample: clearing definitions</div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  var_dump($meta->dump()); <span class="comment">// return predefined meta tags</span> 
  $meta->dump(true); <span class="comment">// prints predefined meta tags</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="sample" class="">
                    <div class="">
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv c-orange"> 
                                <span class=" mxr-8 bi-circle-fill">
                                </span> sample
                            </div>
                        </div> 
                        <div class="">
                            The <code>sample()</code> method returns an array of meta tag samples. This data 
                            was compiled from across different source on the internet.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Sample: get samples of meta tags</div>
                                    <pre class="pre-code">
  var_dump( $meta->sample() ); <span class="comment">// outputs array of meta tag sample attributes</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
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