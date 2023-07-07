
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
               <a href="<?= Rexit::domurl() ?>" class="flex c-i inherit">
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
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Other Features</div> <br>
                    
                    <div class="db-connection">
                        Spoova framework has some custom static files that provides some form of help in front-end development. This include the 
                        local css library along with some few javascript helper functions and plugins. Although these are not necessarily always required for 
                        development, in some cases, they could however provide some form of help when building light applications. Some of the core essential 
                        plugins are loaded by default in the core resource <code>res.php</code> file and their absence may cause issues within the framework.
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Css Utility classes</div>
                        Spoova comes with its own list of simple css utility classes to handle designs such as flex boxes, fluid boxes, grids items, 
                        form classes, borders, paddings, margins, colors and backgrounds and so on. These utility classes are provided as first 
                        hand help to make development faster. Devlopers can learn about more on these utility classes from <a href="<?= Rexit::route('::css') ?>" class="rule-dotted c-olive">here</a>.
                         
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Javascript Files and Functions</div>
                        Spoova does not have a javascript library of its own. However, it comes with helper functions which may prove useful in development. Although 
                        no internal library exists, spoova favors <code>Jquery</code> over other libraries and some of the helper functions and plugins depend on it.
                        While some of these are discussed under integerations below, you can learn more from <a href="<?= Rexit::route('::javascript') ?>" class="rule-dotted c-olive">here</a>. <br>
                        <!-- Javascript functions to Javascript plugins, some of which are jquery dependent. Some of the plugins 
                        that comes with this framework are listed below: <br> -->
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Other Integerated Functionalities</div>
                        Integerated functions are activities that are built into the framework which may have their dependencies on external libraries, javascript functions or even css utility classes. 
                        These integrations are mostly done using predefined element attributes and they require the loading of the default resource files through the <code>@res(':headers')</code> or 
                        <code>@load('headers')</code> template directives. Learn more from <a href="<?= Rexit::route('::attributes') ?>" class="rule-dotted">here</a> <br><br>
                        
                        <div class="integerated-images">
                            <div class="font-em-d95 c-orange-dd">Integerated: Lazy-Loading Images</div>                        
                            As an added feature, spoova manages lazy-loading of images through javascript along with a specifically 
                            reserved html attribute <code>data-src</code>. If the <code>data-src</code> attribute is added to any html element, then lazy-loading is applied to that element. The 
                            <code>data-src</code> can be applied in this way:
    <div class="pre-area shadow shadow-1-strong mvs-4">
        <pre class="pre-code">
  &lt;img data-src="http://site.com/some-image.jpg" &gt;
  
  &lt;div data-src="http://site.com/some-image.jpg" &gt;&lt;/div&gt;
        </pre>
    </div>
    In the above, both the <code>img</code> and <code>div</code> class will be resolved differently into the code below respectively.
    <div class="pre-area shadow shadow-1-strong mvs-4">
        <pre class="pre-code">
  &lt;img src="http://site.com/some-image.jpg" data-src="http://site.com/some-image.jpg" &gt;

  &lt;div style="background-image:url('http://site.com/some-image.jpg')" data-src="http://site.com/some-image.jpg"&gt;&lt;/div&gt;
        </pre>
    </div>
    From the code above, we can conclude that <code>div</code> elements are assigned a <code>backround-image</code> css property while
    <code>img</code> elements are assigned the <code>src</code> attribute. If we are working within our template files, we can also apply the 
    <code>domurl()</code> directive to assign a url value to the <code>href</code> attribute.
                        </div><br>
                        
                        <div class="integerated-page-scrolling">

                            <div class="">
                                <div class="font-em-d95 c-orange-dd">Integerated: Smooth Page Scrolling</div>                        
                                A special feature for managing page scroll is the <code>data-scroll</code> and <code>data-scroll-hash</code> attributes. 
                                These attributes helps to scroll to an element having an id attribute value that matches the supplied value of these attributes. 
                                Since the <code>data-scroll-hash</code> attibute performs both the function of <code>data-scroll</code> and even more extended features, 
                                this attribute alone will be discussed. The only major difference between these two attributes is that <code>data-scroll-hash</code> 
                                works for the current page hash as an extended feature. Other relative attributes that can be applied on these attributes are <code>data-plus</code> 
                                , <code>data-minus</code> which are used for adding or subtracting from target scroll point. There is also the <code>data-delay</code> which set a timeout 
                                before the scroll is executed.
                            </div>

                            <div class="samples">


<div class="pre-area mvt-10">
  <div class="pxv-10 bc-silver">Example 1: data-scroll-hash</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Button:</span>
  <span class="c-olive">&lt;button data-scroll-hash&gt;click btn&lt;/button&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="someid"&gt;&lt;/div&gt; 
  </pre>

  <div class="pxv-10 bc-sea-blue c-white">
    In the above, using the test url as current page url. If the button is clicked, the url hash string <code class="c-white">"someid"</code> 
    will be obtained. Once this is done, then the page will 
    scroll to <code class="c-white">div</code> element because it has a value <code class="c-white">id="someid"</code>
  </div>
</div> <br><br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 2: data-scroll-hash with link</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Button:</span>
  <span class="c-olive">&lt;a href="#newhash" data-scroll-hash&gt;click link&lt;/a&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="newhash"&gt;&lt;/div&gt; 
  </pre>
  
  <div class="pxv-10 bc-sea-blue c-white">
  In the above, once the link is clicked, the page url hashstring will change to <code class="c-white">newhash</code>. Once this is done, the new hash 
  string will be used as the target id of the element to be scrolled to.
  </div>
</div> <br><br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 3: data-scroll-hash integerations with hashRunner()</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Link Button:</span>
  <span class="c-olive">&lt;a href="#someid" data-scroll-hash="someid"&gt;click link&lt;/a&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="someid"&gt;&lt;/div&gt; 
  
  <span class="comment">Target Script:</span>
  <span class="c-olive">&lt;script id="someid"&gt;
      
    hashRunner('data-scroll-hash');
    
  &lt;/script&gt; 
  </pre>

    <div class="pxv-10 bc-sea-blue c-white">
    In the above, if the current page url is the test url above, if a user scrolls off from the div element and reloads the page, the <code class="c-white">hashRunner()</code> 
    function will re-scroll back to that div element. This might be useful to help a user return back to the target element once the page is reloaded. 
    </div>
</div> 

                            </div>                        
                        
                        </div> <br>
                        
                        
                    </div>

                </div>

            </div>
        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>