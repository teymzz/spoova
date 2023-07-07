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
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="font-em-1d5 c-orange">ImageClass</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                            <div class="">
                                The <code class="bd-f">ImageClass</code> is an extension of the <a href="<?= Rexit::domurl('docs/classes/fileuploader') ?>" class="c-olive ch-olive-dd rule-dotted">FileUploader</a>  class. All methods 
                                belonging to the FileUploader can be applied on the ImageClass. Other available methods 
                                are:
                            </div> <br> 

                            <ul>
                                <li> <a href="#setimage" class="c-olive ch-olive-dd"> setImage </a> </li>
                                <li> <a href="#setwidth" class="c-olive ch-olive-dd"> setWidth </a> </li>
                                <li> <a href="#resizeimage" class="c-olive ch-olive-dd"> resizeImage </a> </li>
                                <li> <a href="#runimage" class="c-olive ch-olive-dd"> runImage </a> </li>
                                <li> <a href="#imagedisplay" class="c-olive ch-olive-dd"> imageDisplay </a> </li>
                                <li> <a href="#imagedelete" class="c-olive ch-olive-dd"> imageDelete </a> </li>
                                <li> <a href="#check_jpeg" class="c-olive ch-olive-dd"> check_jpeg </a> </li>
                                <li> <a href="#newdata" class="c-olive ch-olive-dd"> newData </a> </li>
                                <li> <a href="#imagedestroy" class="c-olive ch-olive-dd"> imageDestroy </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following data
                        <br><br>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">TEST DATA</div>
                                <pre class="pre-code">
<span class="c-sea-blue"> 
    $_FILES['name']  = 'Foo'; 
    $_FILES['type']  = 'image/png'; 
    $_FILES['size']  = 5000000; //5mb
    $_FILES['tmp_name']   = '/tmp/files/image.png'; 
    $_FILES['error'] = ''; 
</span>
                                </pre>
                            </div>
                        </div> 
                    </div> <br>

                    <div id="initialize" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> initializing class
                                </div>
                            </div>
                            <div class="">
                                The file uploader class can be easily initialized as shown below.
                                <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Sample: Initializing ImageClass</div>
                                        <pre class="pre-code">
  $ImageClass  = new ImageClass;
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="start" class="">
                        <div class="">
                            <div class="">
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: start</div>
                                        <pre class="pre-code">
  $ImageClass->start($files, $type);
    <span class="comment no-select">
    where:
        
     <span class="c-sky-blue-dd">$files:</span> $_FILES or files data array
     <span class="c-sky-blue-dd">$type:</span> type of file. options [file|image]. An option 'image' allows internal processing of images supplied.
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="foot-note">
                            We shall be looking at a series of examples below.
                        </div>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: setting files</div>
                                <pre class="pre-code">
  $ImageClass->start($_FILES); <span class="comment">// set files for upload</span>

  $ImageClass->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>

  $destination = "images/";

  if( $ImageClass->uploadFiles(['jpg']) ) {
      $newFileName = $ImageClass->newfile;
  }else{
      $newFileName = '';
  }

  $newFilePath = $destination.'/'.$newFileName;
                                </pre>
                            </div>
                        </div>
                    
                    </div> <br>

                    <div id="setimage" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> setImage
                                </div>
                            </div>
                            <div class="">
                            The <code>setImage()</code> sets an image for processing<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Syntax: setImage</div>
                                <pre class="pre-code">
  $ImageClass->setImage($path); 
    <span class="comment">
    where:
        
      <span class="c-sky-blue-dd">$path:</span> path of image
    </span>
                                </pre>
                            </div>
                        </div>    

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example</div>
                                <pre class="pre-code">
  $ImageClass->setImage($newFilePath);                         
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="setwidth" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> setWidth
                                </div>
                            </div>
                            <div class="">
                            The <code>setwidth()</code> sets the output width of an image<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Syntax: setWidth</div>
                                <pre class="pre-code">
  $ImageClass->width($width, $height, $quality, $fileOut); 
    <span class="comment">
    where:
        
      <span class="c-sky-blue-dd">$width:</span> image width in pixels
      <span class="c-sky-blue-dd">$height:</span> image height in pixels
      <span class="c-sky-blue-dd">$quality:</span> optional image quality from 0 - 9. Nine is the maximum.
      <span class="c-sky-blue-dd">$fileOut:</span> optional output file name.
    </span>
                                </pre>
                            </div>
                        </div>    

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: setWidth</div>
                                <pre class="pre-code">
  $ImageClass->setWidth(500, 500, 9);                         
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="resizeimage" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> resizeImage
                                </div>
                            </div>
                            <div class="">

                                This method returns is used to resize an image.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: resizeImage</div>
                                        <pre class="pre-code">
  $ImageClass->resizeImage(); <span class="comment"> // sets image class activity </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: resizeImage </div>
                                        <pre class="pre-code">
  $ImageClass->setImage($newFilePath);
  $ImageClass-setWidth(500, 500, 9);
  $ImageClass->resizeImage();
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="runimage" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> runImage
                                </div>
                            </div>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: runImage</div>
                                        <pre class="pre-code">
  $ImageClass->runImage(); <span class="comment"> // executes the activity declared. </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: runImage</div>
                                        <pre class="pre-code">
  $ImageClass->setImage($newFilePath);
  $ImageClass-setWidth(500, 500, 9);
  $ImageClass->resizeImage();
  $ImageClass->runImage(); <span class="comment">// executes the image resize previously declared</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="imagedisplay" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> imageDisplay
                                </div>
                            </div>

                            <div class="">
                                This method displays the processed image to the screen using the html img tag.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: imageDisplay</div>
                                        <pre class="pre-code">
  $ImageClass->imageDisplay(); <span class="comment"> // prints the image to screen </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: imageDisplay</div>
                                        <pre class="pre-code">    
  $ImageClass->setImage($newFilePath);
  $ImageClass-setWidth(500, 500, 9);
  $ImageClass->resizeImage();
    
  if($ImageClass->runImage()) {

      echo( $ImageClass->imageDisplay() ); <span class="comment no-select">// displays array data of file. </span>

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="imagedelete" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> imageDelete
                                </div>
                            </div>
                            <div class="">
                                This method safely deletes an image if it exists without throwing an error. It returns true if image 
                                was deleted and false if the image was not able to delete or does not exists.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: imageDelete</div>
                                        <pre class="pre-code">
  $ImageClass->imageDelete($path); <span class="comment"> // returns true or false. </span>
    <span class="comment">
    where : 

       $path: Optional relative path of image. If not provided, uses relative path defined in <code class="c-orange-dd">setImage()</code> method.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: imageDelete</div>
                                        <pre class="pre-code">
  $ImageClass->setImage($newFilePath);   <span class="comment">set image relative path</span> 

  if( $ImageClass->imageDelete() ) {

      <span class="comment">//image deleted successfully</span>

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="check_jpeg" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> check_jpeg
                                </div>
                            </div>
                            <div class="">
                                This method tries to detect if a jpeg image is bad.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: check_jpeg</div>
                                        <pre class="pre-code">
  $ImageClass->check_jpeg($filepath, $fix); <span class="comment"> // returns true or false </span>
    <span class="comment">
    where : 
        
       $filepath: path of image file 
       $fix: a bool of true tries to fix the image if possible.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: check_jpeg</div>
                                        <pre class="pre-code">
  if( $ImageClass->check_jpeg($newFilePath) ) {

      <span class="comment">jpeg file seems okay.</span>

  }
 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="newdata" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> newdata
                                </div>
                            </div>
                            <div class="">
                                This method returns the <code>data</code> for current processed file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: newData</div>
                                        <pre class="pre-code">
  $ImageClass->newData(); <span class="comment"> //  returns array data of valid file or empty array </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: newData</div>
                                        <pre class="pre-code">
  $ImageClass->setImage($newFilePath);
  $ImageClass-setWidth(500, 500, 9);
  $ImageClass->resizeImage();
    
  if($ImageClass->runImage()) {

      var_dump( $ImageClass->newData() ); <span class="comment no-select">// displays array data of file. </span>

  }
                                      </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="imagedestroy" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uniqueFile
                                </div>
                            </div> 
                            <div class="">
                            This function directs the image class to destroy previous activity
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: imageDestroy</div>
                                    <pre class="pre-code">
  $ImageClass->imageDestroy();
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: imageDestroy</div>
                                    <pre class="pre-code">
  $ImageClass->setImage($newFilePath);
  $ImageClass-setWidth(500, 500, 9);
  $ImageClass->resizeImage();
  
  if($ImageClass->runImage()) {

     $data = $ImageClass->newData();
     $ImageClass->imageDestroy();

  }
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