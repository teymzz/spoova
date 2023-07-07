
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



<style>
     table {
          border-collapse: separate;
          border-spacing: 1em;
     }
</style>

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            <div class="start font-em-d8">

               
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                <div class="font-em-1d5 c-orange">Intersect.js</div> <br>
                
                <div class="db-connection">
                    The <code>Intersect()</code> plugin is a class that is dependent upon the <code>IntersectionObserver</code> 
                    native javascript class. The function of this plugin is to make it easier to use the native 
                    IntersectionObserver 
                    with added functionalities. 
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-lightning-fill mxr-6"></span>Initializing plugin</div>
                    The plugin is added as part of the core javascript urls of the application. However, it is not loaded by default. By 
                    using the unique name, we can load the javascript file first before we can have access to the plugin. The <code>intersectJS</code> 
                    is the unique name assigned to this script. Let's include the script below in the head section of our project template file:
                    
                    <div class="pre-area">
                         <pre class="pre-code">
  @load('intersectJS')
                         </pre>     
                    </div>

                    <div class="foot-note">
                         Once the script is included in our file, we can go on to initialize the <code>Intersect</code> plugin 
                         at the footer of the web page.
                    </div>
                    
                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;script&gt;

     let Intersect = new Intersect;

     console.log(Intersect);

  &lt;/script&gt;
                         </pre>     
                    </div>

                    <div class="foot-note">
                         When we do a <code>console.log()</code> of the plugin, we will 
                         have some returned object that resembles the format below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;script&gt;

  Object {  }

     <span class="c-blue-violet">&lt;prototype&gt;: Object { … }</span>
        <span class="c-sky-blue-dd">constructor</span> class Intersect {}
        <span class="c-sky-blue-dd">observe</span> function observe(el)
        <span class="c-sky-blue-dd">item</span> function item(el)
        <span class="c-sky-blue-dd">onScroll</span> function onScroll(el)
        <span class="c-sky-blue-dd">status</span> function status(el)

  &lt;/script&gt;
                         </pre>     
                    </div>                  
                </div>
                <div class="foot-note">
                    Each of the objects method have their specific functions and these are explained below:
                </div> <br>
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>constructor</div>
                    This is a reference to the object itself which is automatically added when the plugin 
                    is instantiated. It mostly does not provide any more functionality on the plugin
                </div> <br>

                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>observe</div>
                    This method is called when an object is expected to be observed. It takes an object that 
                    contains details of the element to be observed and a callback function. Assumming we have an html 
                    button as shown below: 

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe these two buttons using the <code>observe()</code> method. This is shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     <span class="c-sky-blue-dd">callback</span> : function(entry, observer) {
        console.log(entry);
     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code sample above, the <code>el</code> is used for selecting the buttons to be observed, while the 
                         <code>callback</code> will be triggered once the button is in view. Notice that the class selector <code>.btn</code> 
                          was used to select the buttons above. Once the button is in view, the entry will return that resembles the format below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
    <span class="c-sky-blue-dd">boundingClientRect</span>: DOMRect { x: 12, y: 11.916671752929688, width: 95.19999694824219, … }
    <span class="c-sky-blue-dd">index</span>: 0
    <span class="c-sky-blue-dd">intersectionRatio</span>: 1
    <span class="c-sky-blue-dd">intersectionRect</span>: DOMRect { x: 12, y: 11.916671752929688, width: 95.19999694824219, … }
    <span class="c-sky-blue-dd">intersections</span>: 0
    <span class="c-sky-blue-dd">inview</span>: true
    <span class="c-sky-blue-dd">isIntersecting</span>: true
    <span class="c-sky-blue-dd">selector</span>: ".btn"
    <span class="c-sky-blue-dd">rootBounds</span>: DOMRect { x: 0, y: 0, width: 678.4000244140625, … }
    <span class="c-sky-blue-dd">target</span>: &lt;button class="btn"&gt;
    <span class="c-sky-blue-dd">time</span>: 1188.7
    <span class="c-sky-blue-dd">unobserve</span>: function unobserve()
                         </pre>
                    </div>

                    <div class="foot-note">
                         The object returned above is similar to the entry object returned in an <code>IntersectionObserver</code> API with 
                         only slight differences. Some new keys were returned which are 
                         <code class="bd-f">index</code>, <code class="bd-f">intersections</code>, <code class="bd-f">inview</code>, <code class="bd-f">target</code> and 
                         <code class="bd-f">unobserve()</code>. <br>
                         
                         <div class="bc-white-dd pxv-10 mvt-16">
                              <table class="text-left calibri wid-full">
                                   <tr><th>Keys</th><th>Function</th></tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">index</span></td>
                                        <td>Identifies the count number of a target element is a selected group list</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">intersections</span></td>
                                        <td>Identifies the total number of intersections made by an element</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">inview</span></td>
                                        <td>Alias or alternative for <span class="c-soft-pink-d">isIntersecting</span>.</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">selector</span></td>
                                        <td>Returns the element's query selector (i.e <code>el</code>)</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">target</span></td>
                                        <td>Defines the entry target element.</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">unobserve()</span></td>
                                        <td>Defines the method to unobserve an observed element.</td>
                                   </tr>
                              </table>
                         </div>

                         <div class="foot-note">
                              Once we observe an element, we can easily unobserve it as shown below: 
                         </div>

                         <div class="pre-area">   
                              <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     
     <span class="c-sky-blue-dd">callback</span> : function(entry) {

        if(entry.inview) entry.unobserve()

     }

  })     
                              </pre>
                         </div>

                         <div class="foot-note">
                              With this returned object index, we can even perform more amazing operations like the sample below where 
                              we logged a console message when the second selected button is unobserved.
                         </div>

                         <div class="pre-area">   
                              <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     
     <span class="c-sky-blue-dd">callback</span> : function(entry) {

        if(entry.inview && entry.index === 1) {
          entry.unobserve();
          console.log('second button unobserved!')
        }

     }

  })     
                              </pre>
                         </div>
                         <div class="foot-note">
                              Amazingly, the <code class="bd-f">Intersect</code> plugin makes it easier to use the intersection class 
                              for multiple elements just as seen above.
                         </div>
                    </div>

                </div> <br>


                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>onScroll</div>
                    This method is called when an object is expected to be observed through an <code class="bd-f">onScroll</code> 
                    event. Once used, the <code>Intersection</code> will return the status of the selected elements on every scroll. 
                    Although, it is not ideal to use <code class="bd-f">onScroll</code> events on items but it can be helpful in some 
                    cases. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe through the <code>onScroll()</code> method as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.onScroll({

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log(`button ${entry.index + 1} is in intersecting`)
               entry.unobserve()
          }else{
               console.log('scrolling...')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code sample above, notice that we used the <code>unobserve()</code> method when the 
                         element is finally intersecting. This does not stop the scroll event from happening. Once the 
                         <code>unobserve()</code> is called, internally, the element will no longer be observed and this will 
                         make the <code>unobserved()</code> method return true. In order to truly end the scroll event, 
                         we can use the <code>item()</code> method instead or set the <code>status()</code> method's 
                         <code class="bd-f">onScroll</code> key as <code class="bd-f">"scroll-item"</code>.
                    </div>

                </div> <br>


                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>status</div>
                    This method is called when the status of an element is needed to be retrieved. Although, 
                    it can use the <code>onScroll</code> event, by default, the element status is only returned 
                    when the observed element is intersecting. When the <code>onScroll</code> key is set as 
                    <code class="bd-f">"scroll"</code> or <code class="bd-f">"scroll-item"</code>, the <code>onScroll</code> 
                    event will be triggered. The only difference between these two options is that while <code class="bd-f">"scroll"</code> 
                    does not truly stop a scroll event until the last observed element is unobserved, the <code class="bd-f">scroll-item</code> option truly removes the 
                    scroll event and is used on a single element. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         Using the <code>status</code> method, we can obtain the status of an element as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : "intersect",

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log(entry)
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  <span class="comment">Object {</span>    
     
     <span class="c-sky-blue-dd">boundingClientRect</span>: DOMRect { x: 12, y: -3309.833251953125, width: 95.19999694824219, … }
     
     <span class="c-sky-blue-dd">element</span>: <span class="comment">{</span>
       <span class="c-sky-blue-dd">aboveWindowTop</span> true
       <span class="c-sky-blue-dd">belowWindowTop</span> false
       <span class="c-sky-blue-dd">fromWindowTop</span> -3309
       <span class="c-sky-blue-dd">index</span> 0
       <span class="c-sky-blue-dd">id</span> ""
       <span class="c-sky-blue-dd">isIntersecting</span> false
       <span class="c-sky-blue-dd">selector</span> ".btn"
       <span class="c-sky-blue-dd">zeroDownwards</span> true
       <span class="c-sky-blue-dd">zeroPoint</span> false
       <span class="c-sky-blue-dd">zeroUpwards</span> false          
     <span class="comment">}</span>,
     
     <span class="c-sky-blue-dd">id</span>: ""
     <span class="c-sky-blue-dd">index</span>: 0
     <span class="c-sky-blue-dd">intersectionRatio</span>: 0
     <span class="c-sky-blue-dd">intersectionRect</span>: DOMRect { x: 0, y: 0, width: 0, … }
     <span class="c-sky-blue-dd">intersections</span>: 0
     <span class="c-sky-blue-dd">inview</span>: false
     <span class="c-sky-blue-dd">isIntersecting</span>: false
     <span class="c-sky-blue-dd">selector</span>: ".btn"
     <span class="c-sky-blue-dd">rootBounds</span>: DOMRect { x: 0, y: 0, width: 678.4000244140625, … }
     <span class="c-sky-blue-dd">selector</span>: ".btn"
     <span class="c-sky-blue-dd">scrollPoint</span>: 4083.88330078125
     <span class="c-sky-blue-dd">target</span>: &lt;button class="btn"&gt;
     <span class="c-sky-blue-dd">time</span>: 566.8
     <span class="c-sky-blue-dd">unobserve</span>: function unobserve()
     <span class="c-sky-blue-dd">unobserved</span>: function unobserved()
  <span class="comment">}</span>
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the sample above the <code class="bd-f">"onScroll"</code> key is set as <code class="bd-f">intersect</code>. 
                         Which is the default option. This ensures that the status of the element is only returned once it is intersecting. 
                         This also means that this default option does not use the scroll event rather it uses only the intersection observer. 
                         Notice that in the code sample above some new keys were added. These keys include the 
                         <code class="bd-f">element</code>, <code class="bd-f">scrollPoint</code>, <code class="bd-f">unobserved()</code>. The 
                         <code class="bd-f">scrollPoint</code> usually returns the current position of the element 
                         observed, while the <code class="bd-f">element</code> key contains futher information about the target element which are 
                         listed and explained in the table below:
                    </div>

                         
                    <div class="bc-white-dd pxv-10 mvt-16 foot-note">
                         <table class="text-left calibri wid-full">
                              <tr><th>Keys</th><th>Function</th></tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">aboveWindowTop</span></td>
                                   <td>Returns true when the element is entirely above the browsers top and not in view</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">belowWindowTop</span></td>
                                   <td>Returns true when at least a part of the element is in below the top browser's screen</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">fromWindowTop</span></td>
                                   <td>Returns the distance of the element from the window's top screen.</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">isIntersecting</span></td>
                                   <td>Returns true when the target element is intersecting</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroDownwards</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero or lower</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroPoint</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroUpwards</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero or above</td>
                              </tr>
                         </table>
                    </div>

                    <div class="foot-note">
                         The <code class="bd-f">unobserved()</code> method is only useful on scroll event when the <code>onScroll</code> 
                         key's option is set as <code class="bd-f">"scroll"</code>.
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : 'scroll'

     <span class="c-sky-blue-dd">el</span> : ".btn",

     callback : function(entry) {
        
          if(entry.inview) {
               <span class="comment">//code block 1</span>
               entry.unobserve()
               console.log('element unobserved!')
          }elseif(entry.unobserved()){
               <span class="comment">//code block 2</span>
               console.log('element has been unobserved!')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code above, the "code block 1" will continue to run until the element is unobserved. 
                         Once the element is unobserved, since the element is a scroll event, the "code block 2" will 
                         be triggered an continue to run. The <code class="bd-f">scroll</code> option is equivalent to the 
                         <code>onScroll()</code> method discussed earlier. It is important to note that as long as there 
                         is still at least one element observed, the scroll event will run internally. Once the last element is 
                         unobserved, the scroll element will be removed. Another equivalent option to use is the <code>srcoll-item</code> 
                         which is only used on a single element. The element will be observed and once it is unobserved, the 
                         scroll event will be removed.
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : 'scroll-item'

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               entry.unobserve()
               console.log('element unobserved and scroll event detached!')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the above, notice that when the option <code class="bd-f">"scroll-item"</code> is used, 
                         the <code>entry.unobserved()</code> is no longer used. This is because once the scroll 
                         event is detached, we can no longer detect if the element has been unobserved. Also, although 
                         we are using a class selector, only one element can be selected. If the number of selected elements returned 
                         is more than one, the <code class="bd-f">Intersection</code> object will return an error.
                    </div>

                </div> <br>

                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>item</div>
                    This method is the same as when the option <code class="bd-f">"scroll-item"</code> is used within the  
                    root <code>status()</code> method. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe through the <code>onScroll()</code> method as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.item({

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log('element unobserved and scroll event detached!')
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange">
                         <span class="bi-record-circle mxr-6"></span>Setting options
                    </div>
                    <div class="">
                         In the javascript <code>IntersectionObserver</code> API we can set options for <code class="bd-f">rootMargin</code> and 
                         <code class="bd-f">threshold</code>. This can also be defined for the <code>Intersection</code> plugin as shown 
                         below:
                    </div>
                    <br><br>
                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect();

  Intersect.item({

     <span class="c-sky-blue-dd">el</span>: ".btn",

     <span class="c-sky-blue-dd">threshold</span>: [0],

     <span class="c-sky-blue-dd">rootMargin</span>: "0px",

     <span class="c-sky-blue-dd">callback</span>: function(entry) {
        
          if(entry.inview) {
               console.log('element unobserved and scroll event detached!')
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         Aside from the <code class="bd-f" class="bd-f">el</code> 
                         and <code class="bd-f">callback</code> keys, any key defined in the 
                         <code>item()</code>, <code>observe()</code> and <code>onScroll()</code> 
                         methods will be added as an option for the <code>IntersectionObserver</code> API. 
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