<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>compiler class</title>
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



   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> 
                          <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div>  Compiler Class
                        </div>
                    </div>

                    <div class="font-em-d8">
                      <div class="">
                        The spoova's compiler class is introduced in version 2.0 in order to improve rex template engine 
                        by providing an easier and much flexible way of rendering template files. The major effect of this is 
                        to be able to add an extended control for template files. The following below are the useful subjects that
                        be discussed separately in order to have a full understnding of what the Compiler object does. 
                      </div> <br>                   
                      <div class="">
                        <ul>  
                          <li>Compiler instantiation</li>
                          <li>Compiler for string</li>
                          <li>Fetching rendered content</li>
                          <li>Viewing rendered content</li>
                          <li>Compiler improvements</li>
                          <li>Compiler helper functions</li>
                        </ul>
                      </div>
                    </div> <br>



                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler Instantiation</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                            The compiler object initialization syntax is as shown below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler($filepath, $vargs);

<span class="comment">
  where:
  
    $filepath : optional rex file path 
    $vargs    : optional variable arguments  
</span>
    </pre>
                                </div>

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 1</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler('user.home', ['name' => foo]);

                                </div>


                                In the example above, the compiler was initialized with a rex file path "user.home" and variable arguments 
                                were supplied using array as the second parameter which can the be accessed using the placeholder template 
                                directive (i.e <code>{{ $name }}</code> ) . Although, arguments are supplied above, we don't necessarily need to 
                                instantiate the Compiler class with objects. The <code>setFile()</code> method can be used to set or update the file name while the 
                                <code>setArgs()</code> can be used to set or update arguments. This is shown below:
                            

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 2</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->setFile('user.home');
  $Compiler->setArgs(['name' => foo]);
                                </div>

                                <div class="">
                                  In the example 2 above, the <code>setFile()</code> and <code>setArgs()</code> are both used 
                                  to set or update the file path and file arguments respectively. Both of these can also be defined using the <code>compile()</code> 
                                  method instead. This is shown below: 
                                </div> <br>
                                
                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 3</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->compile('user.home', ['name' => foo]);
                                </div>
                                
                                <div class="">
                                  In example 3 above, the compiler method does not necessarily need to follow the predefined order. The arguments may be switched interchangeably such that 
                                  arguments come before the file name, however, both arguments cannot be of the same data type. One must be a string which defines the file path while the others 
                                  is an array which defines the variable arguments.
                                </div>
                                
                                <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler For Strings </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                            One of the major feature of the compiler class is the ability to compile strings only into file path. This means that rather than a 
                            real template file, instead, a string content is supplied for rendering. The string will be compiled and added into a defined template file for viewing. This can be achieved 
                            through the sample procedure below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->body($body);

  $Compiler->setBase($storage_path); <span class="comment">//set a storage path for rendered string</span>

<span class="comment"> where :

  $body         : a string content to be rendered. 
  $storage_path : a unique subdirectory in "core/storage" directory. 
</span>
    </pre>
                                </div>

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 5</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler();

  $Compiler->setBase('folder_name');

  $Compiler->body('This is a body content');
                                </div>
                                
                                <div class="">
                                  In the example above, the compiler will assume to render the string as a raw content into the specfied folder name. It is 
                                  important to note that <code>setBase()</code> method is used by compiler to specify folder name where rendered contents are expected 
                                  to be stored. This is usually a subdirectory of the "core/storage" directory. It is important to keep rendered strings path as a separate 
                                  path from other basic files to avoid conflicting files.
                                </div> <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Fetching Rendered Content </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                When a file or string is rendered, the contents can be obtained using the <code>rex()</code> method 
                                which returns a rendered string content. This is shown below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use spoova/mi/core/classes/Compiler;

  class Home { 

      function __construct() {

        $Compiler = new Compiler();

        $Compiler->compile('file');

        $rex = $Compiler->rex();

        vdump($rex); <span class="comment">//variable dump content</span>

      }

  }
    </pre>
                                </div>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Viewing Rendered Content</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                There are couple of ways to print the rendered components. However, the displaying of rendered  
                                components is best understood by printing the object of the class itself. This means that any of the 
                                methods of the Compiler class that returns the Compiler object instance will be able to display the 
                                rendered contents as long as all essential parameters have be properly defined. An example below is a short way 
                                of displaying a rendered file.
                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  use spoova/mi/core/classes/Compiler;

  class Home extends Window { 

      function __construct() {

        echo new Compiler('file', ['name'=> 'foo']);

      }

  }
    </pre>
                                </div>
                                In the example above, the compiler object will be able to display the rendered component on the webpage when the relative page 
                                is visited. We can also make use of the compiler helper function "compile()" rather than the class itself
                            </div> <br>

                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compile Improvements </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                One of the major improvements to the compiler function is that previously it does 
                                not exist as a stand-alone function which means that it needs to be used within the 
                                <code>Res::load()</code> or a window's "self::load()" method. The new updates now ensures 
                                that the <code>compile()</code> function can exist as a stand alone function.

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;

  class Home extends Window { 

      function __construct() {

        echo compile('sample', ['name'=> 'foo']);

      }

  }
    </pre>
                                </div>
                                In the example above, the compile function will render the sampe file and the content will be printed to the page just like the  
                                Compiler class does. This behaviour is because the compile function now returns a compiler object.
                            </div>
                            
                        </div> <br>
                    </div> <br>


                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler Helper Functions </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8">
                            <div>
                              Aside from the "compile()" function, new functions have been introduced to help render files in a specifically designed way. These functions 
                              include <code>raw()</code> and <code>rex()</code> functions.
                            </div> 
                        </div><br>                  
                        <div class="font-em-d8">
                          
                          <div class="function-raw">
                            <div class="bc-silver pxv-10 pxs-20">
                              Function: raw()
                            </div>
                            <div class="pxv-20">
                              This function is used to obtain the direct raw content of a rex file before it is rendrered. The example of its usage is displayed below
                              <div>
                                  
  
                                  <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;
  
  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $raw = raw('sample'); <span class="comment">//source code</span>
         vdump($raw);
  
      }
  
  }
      </pre>
                                  </div>
                                  In the example above, function will return a raw string content of the rex sample file expected to be within the "window/Rex" directory.
                              </div>                          
                            </div>
                          </div>

                          <div class="function-view">
                            <div class="bc-silver pxv-10 pxs-20">
                              Function: rex()
                            </div>
                            <div class="pxv-20">
                              
                              This function is used to obtain the string content of a rendered rex file. The example of its usage is displayed below
                              
                              <div>

                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample'); <span class="comment">//return rendered content</span>
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                                <div>
                                  In the example above, function will return a string content of the rex file expected to be within the "window/Rex" directory. We can also 
                                  return a string content into the rex file through the second argument as shown below: 
                                </div>
                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;
  
  use Window;

  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample', fn() => 'My url is domurl()'); <span class="comment">//return rendered content of the string </span>   
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                                <div class="">
                                  Just like the <code>window::load()</code> method, we can also use the "compile()" function as a directive to compile the sample file and pass arguments 
                                  to the file instead of using the "sample" file as an anchor for a string content like the previous example. 
                                </div>
                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample', fn() =>compile(['name'=>'foo'])); <span class="comment">//return rendered content of the string </span>   
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                              </div>                          
                            </div>
                          </div>
                            
                        </div>
                    </div> <br>

                </div>
                
           </div>
       </section>
   </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>