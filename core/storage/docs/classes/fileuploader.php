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

                    <div class="font-em-1d5 c-orange">FileUploader</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                        <div class="">
                            The FileUploader class is used for uploading files.
                            The following are the available methods in the class.
                        </div> <br>

                            <ul>
                            <li> <a href="#start" class="c-olive ch-olive-dd"> start </a> </li>
                            <li> <a href="#filesize" class="c-olive ch-olive-dd"> filesize </a> </li>
                            <li> <a href="#getfilename" class="c-olive ch-olive-dd"> GetFileName </a> </li>
                            <li> <a href="#getfiletype" class="c-olive ch-olive-dd"> GetFileType </a> </li>
                            <li> <a href="#getfilesize" class="c-olive ch-olive-dd"> GetFileSize </a> </li>
                            <li> <a href="#getfiletemp" class="c-olive ch-olive-dd"> GetFileTemp </a> </li>
                            <li> <a href="#getfileerror" class="c-olive ch-olive-dd"> GetFileError </a> </li>
                            <li> <a href="#getfiledata" class="c-olive ch-olive-dd"> GetFileData </a> </li>
                            <li> <a href="#uniquefile" class="c-olive ch-olive-dd"> uniqueFile </a> </li>
                            <li> <a href="#uploadfile" class="c-olive ch-olive-dd"> uploadFile </a> </li>
                            <li> <a href="#response" class="c-olive ch-olive-dd"> response </a> </li>
                            <li> <a href="#reconstruct" class="c-olive ch-olive-dd"> reconstruct </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following sample data
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
                            <div class=" fb-6 flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
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
                                <div class="pxv-6 bc-off-white">Sample: Initializing Input</div>
                                <pre class="pre-code">
    $FileUploader  = new FileUploader;
                                </pre>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div> <br>

                    <div id="start" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> start
                                </div>
                            </div>
                            <div class="">
                            The <code>start</code> method is used to set parameters 
                            into the input class.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: start</div>
                                    <pre class="pre-code">
    $FileUploader->start($files, $type);
    <span class="comment no-select">
      where:
            
       $files: $_FILES or files data array
       $type: When set as 'image', it allows internal validation of images selected.
    </span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: setting files</div>
                                <pre class="pre-code">
    $FileUploader->start($_FILES); <span class="comment">// set files for upload</span>

    $FileUploader->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>
                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="filesize" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> filesize
                                </div>
                            </div>

                            <div class="">
                                The <code>filesize()</code> method sets the maximum number of 
                                bytes the files uploaded must not exceed <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: filesize</div>
                                        <pre class="pre-code">
    $FileUploader->filesize($size); 
        <span class="comment">
      where:
            
        $size: maximum file size in bytes
        </span>
                                        </pre>
                                    </div>
                                </div>    

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: filesize</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES);

    $FileUploader->filesize(2000000); <span class="comment"> // 2mb</span>                            
                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfilename" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileName
                                </div>
                            </div>

                            <div class="">
                                This method returns the file name of the currently set file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileName</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileName(); <span class="comment"> // returns name of file</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileName</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileName(); <span class="comment"> // returns Foo</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletype" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileType
                                </div>
                            </div>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileType</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileType(); <span class="comment"> // returns type of file </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileType</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileType(); <span class="comment"> // image/png</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfilesize" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileSize
                                </div>
                            </div>
                            <div class="">
                                This method returns the size of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileSize</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileSize(); <span class="comment"> // returns size of file </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileSize</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileSize(); <span class="comment"> // 5000000</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletemp" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileTemp
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>tmp_name</code> of current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileTemp</div>
                                    <pre class="pre-code">
    $FileUploader->GetFileTemp(); <span class="comment"> // returns the temporary directory of file </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileTemp</div>
                                    <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileTemp(); <span class="comment"> // /tmp/files/image.png</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfileerror" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileError
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>error</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileError</div>
                                    <pre class="pre-code">
  $FileUploader->GetFileError(); <span class="comment"> // returns the current file error </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileError</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');
  $FileUploader->GetFileError(); <span class="comment"> // returns null</span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiledata" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileData
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>data</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileData</div>
                                    <pre class="pre-code">
  $FileUploader->GetFileData(<span class="c-orange-dd">bool</span>); <span class="comment"> //  returns string of supplied data </span>
    <span class="comment">
    where: 

      <span class="c-orange-dd">bool</span> : boolean of true adds the new directory and new file name of an uploaded file to the data string returned.
    </span>                         </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileData</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');
  $FileUploader->GetFileData(); <span class="comment"> //list $_FILES as string</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="uniquefile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uniqueFile
                                </div>
                            </div>
                            <div class="">
                            This function directs the uploader class to upload a file with a unique new name 
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: uniqueFile</div>
                                    <pre class="pre-code">
  $FileUploader->uniqueFile($param); 
    <span class="comment">
    where :

      $param : <span class="c-orange">true</span> permits a unique output name
                 <span class="c-orange">false</span> keeps the source file name
                 <span class="c-orange">string</span> sets a new output name. 
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: uniqueFile</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES);

  $FileUploader->uniqueFile(); <span class="comment">// generate a new output name</span>
  $FileUploader->uniqueFile(false); <span class="comment">// keep source name</span>
  $FileUploader->uniqueFile('foo'); <span class="comment">// use a unique output name foo</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="uploadfile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uploadFile
                                </div>
                            </div>

                            <div class="">
                                This method executes the upload directive. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: uploadFile</div>
                                        <pre class="pre-code">
  $FileUploader->uploadFile($validFiles, $destination, $makedir); <span class="comment"> // returns : true if file was uploaded</span> 
    <span class="comment"> 
    where :

       $validFiles: array list of valid or acceptable extensions.
       $destination: destination path of uploaded file.
       $makedir: bool of true creates a new directory if it does not already exist.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: uploadFile</div>
                                        <pre class="pre-code">

  $FileUploader->start($_FILES, 'image');

  $FileUploader->uploadFile(['jpg','png'], dirname(__FILE__).'/images', true); 
    <span class="comment">// 1. upload only files with jpg or png extensions</span>
    <span class="comment">// 2. upload into destination path supplied </span>
    <span class="comment">// 3. create directory of destination if it does not exist</span>

                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="response" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> response
                                </div>
                            </div>

                            <div class="">
                                The <code>response</code> returns the response of the processes executed. This 
                                may be good for code debugging
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: response</div>
                                        <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');

  $upload = $FileUploader->uploadFile(['jpg','png'], dirname(__FILE__).'/images', true); 

  if($upload){

      <span class="comment">//file uploaded successfully</span>

  } else {
        
      var_dump( $FileUploader->response() ); //return the upload response.

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="reconstruct" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> reconstruct
                                </div>
                            </div>
                            <div class="">
                                The <code>reconstruct</code> method is used to restructure multiple files for upload
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: reconstruct</div>
                                        <pre class="pre-code">
  $FileUploader->reconstruct($data);
    <span class="comment no-select"> 
    where : 

      $data: array of multiple files
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: reconstruct</div>
                                        <pre class="pre-code">
  <span class="c-olive-dd">
  $_FILES['name'][0]  = 'Foo'; 
  $_FILES['name'][1]  = 'Bar';   

  $_FILES['type'][0]  = 'image/png'; 
  $_FILES['type'][1]  = 'image/png'; 

  $_FILES['size'][0]  = 5000000; //5mb
  $_FILES['size'][1]  = 2000000; //2mb

  $_FILES['tmp_name'][0]   = '/tmp/files/foo.png'; 
  $_FILES['tmp_name'][1]   = '/tmp/files/bar.png'; 
    
  $_FILES['error'][0] = ''; 
  $_FILES['error'][1] = ''; 
  </span>

  $files = $FileUploader->reconstruct($_FILES);

  var_dump($files); 
    
  <span class="c-dry-blue">//The above returns: </span>
    <span class="comment">
      [
        
        0 => [
            'name'     => 'Foo'; 
            'type'     => 'image/png'; 
            'size'     => 5000000; 
            'tmp_name' => '/tmp/files/foo.png';
            'error'    => ''; 
        ],
    
        1 => [
            'name'     => 'Bar'; 
            'type'     => 'image/png'; 
            'size'     => 2000000; 
            'tmp_name' => '/tmp/files/bar.png';
            'error'    => ''; 
        ],

      ] 
    </span>
                                        </pre>
                                    </div>
                                </div>
                        
                                <div class="foot-note pvs-10">
                                    This method makes it easier to organize files for upload. Then upload can be done easily by:
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>...continued</code></div>
                                        <pre class="pre-code">
  <span class="comment">... using previous data</span>

  $files = $FileUploader->reconstruct($_FILES);

  foreach( $files as $file ) {
  
      $FileUploader->start($file, 'image');
      $FileUploader->uniqueFile();
  
      if($FileUploader->uploadFile(['jpg', 'png'])) {
  
          <span class="comment">//upload successful</span>
  
      } else {
  
          var_dump( $FileUploader->response() );
  
      }
  
  }
    </span>
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