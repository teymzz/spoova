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
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/fileuploader">Fileuploader</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">FileUploader</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            FileUploader class is a special tool that is used for uploading files.
                            The following are the available methods in the class.
                        </div> <br>

                            <ol>
                            <li> <a href="#start"> start </a> </li>
                            <li> <a href="#filesize"> filesize </a> </li>
                            <li> <a href="#getfilename"> GetFileName </a> </li>
                            <li> <a href="#getfiletype"> GetFileType </a> </li>
                            <li> <a href="#getfilesize"> GetFileSize </a> </li>
                            <li> <a href="#getfiletemp"> GetFileTemp </a> </li>
                            <li> <a href="#getfileerror"> GetFileError </a> </li>
                            <li> <a href="#getfiledata"> GetFileData </a> </li>
                            <li> <a href="#uniquefile"> uniqueFile </a> </li>
                            <li> <a href="#uploadfile"> uploadFile </a> </li>
                            <li> <a href="#response"> response </a> </li>
                            <li> <a href="#reconstruct"> reconstruct </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following data
                        <br><br>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>test data</code></div>
                                <pre class="pre-code">
<span class="c-green"> 
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> initializing class
                                </div>
                            </div> <br>
                            <div class="">
                            The file uploader class can be easily initialized as shown below.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> start
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>start</code> method is used to set parameters 
                            into the input class.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: start</code></div>
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
                                <div class="pxv-6 bc-off-white"><code>Example: setting files</code></div>
                                <pre class="pre-code">
    $FileUploader->start($_FILES); <span class="comment">// set files for upload</span>

    $FileUploader->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>
                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="filesize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> filesize
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>filesize()</code> method sets the maximum number of 
                                bytes the files uploaded must not exceed <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: filesize</code></div>
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
                                        <div class="pxv-6 bc-off-white"><code>Example: filesize</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> GetFileName
                                </div>
                            </div> <br>

                            <div class="">
                                This method returns the file name of the currently set file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileName</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileName(); <span class="comment"> // returns name of file</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileName</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> GetFileType
                                </div>
                            </div> <br>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileType</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileType(); <span class="comment"> // returns type of file </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileType</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> GetFileSize
                                </div>
                            </div> <br>
                            <div class="">
                                This method returns the size of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileSize</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileSize(); <span class="comment"> // returns size of file </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileSize</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> GetFileTemp
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>tmp_name</code> of current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileTemp</code></div>
                                    <pre class="pre-code">
    $FileUploader->GetFileTemp(); <span class="comment"> // returns the temporary directory of file </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileTemp</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> GetFileError
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>error</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileError</code></div>
                                    <pre class="pre-code">
    $FileUploader->GetFileError(); <span class="comment"> // returns the current file error </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileError</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">8.</span>
                                    </span> GetFileData
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>data</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileData</code></div>
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
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileData</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">9.</span>
                                    </span> uniqueFile
                                </div>
                            </div> <br>
                            <div class="">
                            This function directs the uploader class to upload a file with a unique new name 
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: uniqueFile</code></div>
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
                                    <div class="pxv-6 bc-off-white"><code>Example: uniqueFile</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">10.</span>
                                    </span> uploadFile
                                </div>
                            </div> <br>

                            <div class="">
                                This method executes the upload directive. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: uploadFile</code></div>
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
                                        <div class="pxv-6 bc-off-white"><code>Example: uploadFile</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">11.</span>
                                    </span> response
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>response</code> returns the response of the processes executed. This 
                                may be good for code debugging
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: response</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> reconstruct
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>reconstruct</code> method is used to restructure multiple files for upload
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: reconstruct</code></div>
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
                                        <div class="pxv-6 bc-off-white"><code>Example: reconstruct</code></div>
                                        <pre class="pre-code">
    <span class="c-green">
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

    var_dump($files); <span class="comment">// returns: </span>
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
                        
                                <div class="font-menu pvs-10">
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
                    
                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/fileuploader">Fileuploader</a>  </div>


                </div>
            </div>
        </section>

    </div>
                
    


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>