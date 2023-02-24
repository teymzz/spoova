<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Window Rex</title>
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
               <li> <a href="<?= DomUrl('docs/wmv') ?>" class="<?= inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
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
               <li> <a href="<?= DomUrl('docs/template') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Template Engine</a> </li>
               <li> <a href="<?= DomUrl('docs/template/directives') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Template Directives</a> </li>
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv">Wmv</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv/rex">Rex</a>  </div>


                 

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Window Rex</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Rex files are template files that use template directives to control and manage the content of webpages. They are capable of 
                            using decoupled component files to structure or restructure how a page content is organized. Rex template files are usually 
                            found within the <code>windows/Rex</code> directory and they are usually rendered using compiler functions which can be <code>compile()</code>  
                            or <code>view()</code> functions. Rex files makes it easier to load and modify pages without having to write multiple codes. In spoova, there are 
                            three types of template files. These files are : <br><br>

                            <ul>
                                <li>php template files</li>
                                <li>css template files</li>
                                <li>javascript template files</li>
                            </ul>

                            The rex template files can easily be identified by their respective extensions. For example a css file assumes a 
                            <code>.css</code> extension while php and javascript assumes the <code>.php</code> and <code>.js</code> extensions respectively. 
                            Rex files are mostly identified by the <code>.rex</code> extension name which comes before the real extension name. 
                            This means that whilst a php rex file uses a <code>.rex.php</code> extension, the css files uses <code>.rex.css</code> and javascript 
                            files uses <code>.rex.js</code> extension name. This naming pattern makes it easier to identify the rex files and the type of 
                            code language each contains.

                        </div> 
                    </div> <br>
                    
                    <div class=""> 

                        <div class="php-rex-files">
                            
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> PHP Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The php rex files are the main rex files upon which other template files are built. 
                                        They are usually compiled by the <code>compile()</code> or <code>view()</code> 
                                        functions. When a compiler function is used, it take a first argument which defines 
                                        the path of a php rex file within the <code>windows/Rex</code> directory. For example: <br> 
                                        <br>
    <div class="pre-area">
        <pre class="pre-code">
    namespace windows\Routes;

    use window;

    class Home extends Window {
        
        function __construct(){

            self::load('index', fn() => compile() );

        }

    } 
        </pre>
    </div>
                                        <div class="foot-note">
                                            In the code above the <code>load()</code> method will look for the <code>index.rex.php</code> file within the 
                                            <code>windows/Rex</code> directory. If such file exists, then the compiler function <code>compile()</code> will 
                                            compile the rex template file.
                                        </div>
    
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="css-rex-files">
                            
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> CSS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The css rex files stylesheets that are directly loaded into the webpage as embedded stylesheets. 
                                        In css rex files, styles are divided into sections with each section having its own unique name. 
                                        The path of a stylesheet along with its unique name makes it possible to import only specifically needed style within an 
                                        external css rex file. When compiling php rex file data, only the defined css styles will be extracted from a stylesheet file while other css will 
                                        be ignored. An example below shows how the format of a css rex file.
                                        <br><br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">File path: Rex/css/index.rex.css</div>
        <pre class="pre-code">
    &#35;style:header
    <span class="c-orange-dd">
    .header{

      background-color: red;

    }
    </span>
    &#35;style;


    &#35;style:footer
      <span class="c-orange-dd">
    .footer{

      width: 100%;

    }
      </span>
    &#35;style;
        </pre>
    </div>
                                        <div class="foot-note">
                                            In the code above the css styles within the header can be imported in a php rex file by declaring the 
                                            css path and then the name of style needed to be imported. For example to import the file above, 
                                            then a php rex file will contain the following code:
                                        
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">some.rex.php</div>
        <pre class="pre-code">
  &#64;style('css.index:header');
        </pre>
    </div>       
                                        <div class="foot-note">
                                        In the code above when the file <code>some.rex.php</code> is compiled, the compiler will extract css styles 
                                        from <code>windows/Rex/css/index.rex.css</code>. Only the styles within the header section will be extracted.
                                        The compiled data will resemble the code below:
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">compiled data</div>
        <pre class="pre-code">
    &lt;style rel="css.index"&gt;

      .header{

        background-color: red;

      }

    &lt;/style&gt;
        </pre>
    </div>                                
                                        <br><br>
                                        <div class="foot-note">
                                        The <code>rel</code> attribute helps to reveal the path of the css file as it can become difficult to locate stylesheet 
                                        files when working on large projects. The path shown in the <code>rel</code> attribute is usually a path within the 
                                        <code>windows/Rex</code> directory. In certain situations we can import multiple styles from a single css file. This
                                        can be done by first defining the file path, then each style section is extracted by their unique names. The unique names 
                                        in this case will be separated by columns. For example, the code below is an example of multiple style extraction from a single css 
                                        file. Both the <code>footer</code> and <code>header</code> styles will be imported to the compiled data.
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">compiled data</div>
        <pre class="pre-code">
  &#64;style('css.index:header:footer');    
        </pre>
    </div>      
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="js-rex-files">
                            
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> JS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The javascript rex files just like stylesheets, are directly loaded into the webpage as embedded scripts. 
                                        In js rex files also, scripts are divided into sections with each section having its own unique name. 
                                        An example below shows the format of a js rex file <br><br>
                                        
    <div class="pre-area">
        <div class="pxv-10 bc-silver">File path: Rex/css/index.rex.js</div>
        <pre class="pre-code">
    &#35;script:header

      window.onload = function() {

        alert('loaded');

      }

    &#35;script;
        </pre>
    </div>
                                        <br><br>
                                        <div class="foot-note">
                                        Just like the css, the javascript rex file's scripts can be imported with their unique names. The code above will 
                                        return as:
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">compiled data</div>
        <pre class="pre-code">
    &lt;script&gt;

      window.onload = function() {

        alert('loaded');

      }

    &lt;script&gt;
        </pre>
    </div>  
                       
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                
                    </div>  <br>

                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv">Wmv</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv/rex">Rex</a>  </div>


                </div>

                
            </div>
        </section>
    </div>
    
    
    

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>