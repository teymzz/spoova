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
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1">

                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                 

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
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
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
        <div class="pxv-10 bc-silver">Sample 1 - PHP rex file compilation (index.rex.php)</div>
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
                                        <div class="foot-note mvs-6">
                                            In the code above the <code>load()</code> method will look for the <code>index.rex.php</code> file within the 
                                            <code>windows/Rex</code> directory. If such file exists, then the compiler function <code>compile()</code> will 
                                            compile the rex template file.
                                        </div>
    
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="css-rex-files">
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> CSS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The css rex files stylesheets that are directly loaded into the webpage as embedded stylesheets. 
                                        In css rex files, stylesheets are divided into sections with each section having its own unique style name. 
                                        The path of a stylesheet along with its unique name makes it possible to import only specifically needed style within an 
                                        external css rex file. When compiling php rex file data, only the defined css styles will be extracted from a stylesheet file while other css will 
                                        be ignored. An example below shows how the format of a css rex file.
                                        <br><br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 2a: Css File (index.rex.css)</div>
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
                                        <div class="foot-note mvs-6">
                                            The code in sample 2 above is an example of sectionalizing of a rex css file. Each section above can be imported into a php rex file 
                                            using the <code>style()</code> directive. Only the css style names declared within the directive will be pulled into the php rex file. 
                                            . For example, assuming the css file above is located within the <code>windows/Rex/Css</code> directory, then to import the css file above, 
                                            a php rex file will contain the following code:
                                        
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 2b: PHP File (somefile.rex.php)</div>
        <pre class="pre-code">
  style('css.index:header');
        </pre>
    </div>       
                                        <div class="foot-note">
                                        In the code above when the file <code>somefile.rex.php</code> is compiled, the compiler will extract css styles 
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
                   
                                        <div class="foot-note pvs-10">
                                            The <code>rel</code> attribute helps to reveal the path of the css file as it can become difficult to locate stylesheet 
                                            files when working on large projects. The path shown in the <code>rel</code> attribute is usually a path within the 
                                            <code>windows/Rex</code> directory. In certain situations we can import multiple styles from a single css file. This
                                            can be done by first defining the file path, then each style section is extracted by their unique names. The unique names 
                                            in this case will be separated by columns. For example, the code below is an example of multiple style extraction from a single css 
                                            file. Both the <code>footer</code> and <code>header</code> styles will be imported as the compiled data.
                                        </div>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">somefile.rex.php</div>
        <pre class="pre-code">
  style('css.index:header:footer');    
        </pre>
    </div>      
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="js-rex-files">
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> JS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The javascript rex files are external javascript files are compiled directly into the webpage as embedded scripts through the 
                                        template directive <code>script()</code>. In js rex files, scripts are also divided into sections with each section having its own unique name. 
                                        An example below shows the format of a js rex file <br><br>
                                        
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 3: Js Rex File (index.rex.js)</div>
        <pre class="pre-code">
    &#35;script:header

      window.onload = function() {

        alert('loaded');

      }

    &#35;script;
        </pre>
    </div>
                              
                                        <div class="foot-note">
                                            Assuming we have the rex file above to be within the <code class="">"windows/Rex/js/"</code> directory, then we can import the file as shown below:
                                        </div>

    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 3b: PHP File (some.rex.php) to file</div>
        <pre class="pre-code">
    script('js.index:header')
        </pre>
    </div>
                                        <div class="foot-note">
                                            The path supplied above is expected to be found at <code>windows/Rex/js/index.rex.php</code>. The data compiled from the file above will be as below:
                                        </div>                                       
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

                                        <div class="foot-note mvs-6">
                                            Note that when compiling the template directives, an error will displayed only if the source file of the expectant rex file is missing. If the file is 
                                            not missing but the unique name supplied is not defined within the rex files (i.e css and js), no error will be displayed.  
                                        </div>
                       
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                
                    </div>  <br>

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


                </div>

                

            </div>
        </section>
    </div>
    
    
    

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>