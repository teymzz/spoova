

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



    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4">   </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Other Features</div> <br>
                    
                    <div class="db-connection">
                        <div class="fb-6">Introduction</div>
                        Other features of this framework mostly refer to the association or relationship it has with static files which are Javascript functions (or plugins) 
                        and Css utility classes. While spoova has its own internal library, some already known external libraries are favored for development. Spoova may work 
                        without these libraries, however, they have been integrated with the framework itself and thier absence may cause issues within the framework.  
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Css Utility classes</div>
                        Spoova comes with its own list of simple css utility classes to handle designs such as flex boxes, fluid boxes, grids items, 
                        form classes, borders, paddings, margins, colors and backgrounds and so on. These utility classes are provided as first 
                        hand help to make development faster. Devlopers can learn about more on these utility classes from <a href="<?= route('::css'); ?>" class="hyperlink">here</a>.
                         
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Javascript Files and Functions</div>
                        Spoova does not have a javascript library of its own. However, it comes with helper functions which may prove useful in development. Although 
                        no internal library exists, spoova favors <code>Jquery</code> over other libraries and some of the helper functions and plugins depend on it.
                        While some of these are discussed under integerations below, you can learn more from <a href="<?= route('::javascript'); ?>" class="hyperlink">here</a>. <br>
                        <!-- Javascript functions to Javascript plugins, some of which are jquery dependent. Some of the plugins 
                        that comes with this framework are listed below: <br> -->
                    </div> <br>
                    
                    <div class="">
                        <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Other Integerated Functionalities</div>
                        Integerated functions are activities that are built into the framework which may have their dependencies on external libraries, javascript functions or even css utility classes. 
                        In some cases, a response could depend on all of these dependencies altogether. These integerations sometimes use html attributes to effect their functions. In order to allow 
                        these integerations to work effectively, all core resource header files should be imported. This is done with <code>&#64;Res(':headers')</code> rex template directive. <br><br>
                        
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
    <code>&#64;domurl()</code> directive to assign a url value to the <code>href</code> attribute.
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