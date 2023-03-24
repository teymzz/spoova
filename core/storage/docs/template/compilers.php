
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
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
    color: rgb(125, 125, 125);
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
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



  <style>
    .directives code {
      color: #f7f7f7;
      background-color: #47b13e;
      border:none;
    }
  </style>

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/template">Template</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/template/compilers">Compilers</a>  </div>


        <div class="start font-em-d8">

            <div class="font-em-1d5 c-orange">Rex Compiler Functions</div> <br> 

            <div class="compiler-intro">
              <div class="">
                <p>
                    The rex template engine uses two compiler functions which are <code>compile()</code> and <code>view()</code> 
                    mentioned earlier to render a file from the <code>windows/Rex</code> directory. When any of these methods is used, the 
                    full path of the rex file does not need tp be declared as the framework will naturally search for rex files only from the 
                    specified directory. The major difference between these two functions is that while the <code>compile()</code> function 
                    is used to compile and render file declared within the <code>Res::load()</code> method, the view method is used to compile 
                    and return a rendered file upon another file declared within the <code>Res::load()</code> method. Also, while the <code>compile()</code> 
                    function can only be used once within the <code>Res::load()</code>, the <code>view()</code> function can be applied multiple times.
                    In most cases, the <code>Res::load()</code> method is will be used more to load template files within any window system.
                </p>
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Samples of resource loading with compiler functions</div>
    <pre class="pre-code">
  Res::load('index', fn() => compile()); <span class="comment">//render a template file "index.rex.php"</span>
  
  Res::load('home', fn() => compile(['name' => 'Brooks'])); <span class="comment">//pass an argument to template file  "home.rex.php"</span>
  
  Res::load('foo', fn() => view('bar', ['name' => 'Brooks'])); <span class="comment">//render and dump a template file "bar.rex.php" on "index.rex.php"</span>
  
    </pre>
                </div>
                <div class="foot-note mvs-6">
                    It is important to note that in the above examples, all rex files are assumed to be from the <code>window/Rex</code> directory. Since it is 
                    much better to have one single rex file that controls how pages are displayed, hence, in most cases, the 
                    <code>view()</code> function does not need to be employed. It is much preferable to stick with the <code>compile()</code> function.
                </div> <br>
                <p>
                    The major advantage of the <code>view()</code> function is the ability to render different template files all at once before returning its content 
                    on the <code>Res::load()</code> declared file also known as the main template file.
                </p>               
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Differences between compile and view function</div>
    <pre class="pre-code">
  <span class="c-dodger-blue-dd">Res::load('index', function() {</span>

    return compile();
    
  <span class="c-dodger-blue-dd">});</span>
  

  <span class="c-dodger-blue-dd">Res::load('index', function() {</span>

    return view('index').view('home');

  <span class="c-dodger-blue-dd">});</span>
    </pre>
                </div>
                <div class="foot-note mvs-6">
                  <p>
                    In the example above, the <code>view()</code> method will process all template files within it and 
                    return its contents to the <code>index.rex.php</code> file which will inturn display its contents unlike the 
                    <code>compile()</code> function which cannot be used more than once. However, though the <code>view()</code> 
                    method may be used this way, it is highly discouraged to do so. Also, the <code>view()</code> method may be dropped in 
                    future update to favor only the compile method.
                  </p>

                  <p>
                    It is important to note that the resource loader method <code>Res::load()</code> will not compile its main rex file declared within it. 
                    unless the <code>compile()</code> function is declared within it. Instead, the content of any string returned by the callback function will 
                    be returned back on the page. This is shown below:
                  </p>
                </div> 
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Res loading without compile</div>
    <pre class="pre-code">
  Res::load('index', fn() => "me" });
    </pre>
                </div>
                <div class="foot-note mvs-6">
                  In the code above, The <code>index.rex.php</code> file will not be compiled, rather it will return the content of the callback function (i.e "me"), 
                  unlike when the compiler function <code>compile()</code> is used which literally tells the <code>Res::load()</code> method to compile the 
                  supplied rex file. This is why it is possible to dump the content of <code>view()</code> function on the intended main rex file because the <code>view()</code> 
                  function compiles its own file separately while returning the content of the file compiled. 
                </div>
              </div>
          </div> <br>
          
          <div class="">

            <div class="font-em-1d2 c-orange">Accessing compiler arguments</div> 

            <div class="">
              There are certain key situations when we need to pass variables down to template files. 
              Variables are passed down as array arguments into compiler functions which in turn converts them to accessible variables by the php template files. 
              The array arguments are usually specified by an array key which becomes the accessible variable that is used within the placeholder <code>&#123;&#123;&#125;&#125;</code> directive.
              The code below is an example of how to pass arguments to template files.
            </div> <br>

            <div class="pre-area">
              <div class="pxv-10 bc-silver">Sample window file</div>
              <pre class="pre-code">
  &lt;?php

  namespace spoova\mi\core\windows\Routes;

  use Window;

  class Home extends Window{ 

      function __construct() {

          self::load('home', fn() => compile(['name' => 'Foo']) );

      }

  }
  
  ?&gt;
              </pre>

            </div>

            <div class="pre-area">
              <div class="pxv-10 bc-silver">Sample rex file (home.rex.php)</div>
              <pre class="pre-code">
  &#123;&#123; $name &#125;&#125;
              </pre>

            </div>

            <div class="foot-note pvs-10">
              The sample rex file above will display the corresponding value of "name", that was passed across to it. Other available template directives can be found 
              <a href="<?= DomUrl('docs/template/directives') ?>" class="c-olive-d">here</a> 
            </div>

          </div>
          
          

        </div>
      </div>
    </section>
  </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>