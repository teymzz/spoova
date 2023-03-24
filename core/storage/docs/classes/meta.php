`

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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

            
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/meta">Meta</a>  </div>


            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Meta</div> <br>  
                
                <div class="helper-classes">
                    <div class="fb-6">Introduction</div> <br>
                    <div class="">

                    <div class="">
                        The meta class is created to handle meta tags. The attributes and 
                        values of these tags are supplied and then rendered. The following are the 
                        available methods and their descriptions
                    </div> <br>

                        <ul class="c-sky-blue-dd">
                            <li> <a href="#charset" data-scroll-hash="" data-minus="10"> charset </a> </li>
                            <li> <a href="#add" data-scroll-hash="" data-minus="10"> add </a> </li>
                            <li> <a href="#name" data-scroll-hash="" data-minus="10"> name </a> </li>
                            <li> <a href="#prop" data-scroll-hash="" data-minus="10"> prop </a> </li>
                            <li> <a href="#equiv" data-scroll-hash="" data-minus="10"> equiv </a> </li>
                            <li> <a href="#refresh" data-scroll-hash="" data-minus="10"> refresh </a> </li>
                            <li> <a href="#og" data-scroll-hash="" data-minus="10"> og </a> </li>
                            <li> <a href="#link" data-scroll-hash="" data-minus="10"> link </a> </li>
                            <li> <a href="#drop" data-scroll-hash="" data-minus="10"> drop </a> </li>
                            <li> <a href="#export" data-scroll-hash="" data-minus="10"> export </a> </li>
                            <li> <a href="#dump" data-scroll-hash="" data-minus="10"> dump </a> </li>
                        </ul>
                        
                    </div> 
                </div>

                <div id="meta">
                    The <code>Meta</code> class can be initialized by defining the meta charset type. <code>new Meta('UTF-8')</code> will 
                    declare a new <code>UTF-8</code> meta tag. However, this can also be done using the 
                    <code>charset()</code> method. The following are lists of available methods in the meta class.
                </div> <br>

                <div id="charset" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">1.</span>
                                </span> Charset
                            </div>
                        </div> <br>
                        <div class="">
                        This method is used to set the charset of meta tags. Example is shown below: <br><br>
                        
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Sample: setting charset</code></div>
                                <pre class="pre-code">
  $meta  = new Meta();
  
  $meta->charset('UTF-8'); <span class="comment"> // set meta charset</span>
                                </pre>
                            </div>
                        </div>

                        </div>
                    </div> <br><br>
                </div>

                <div id="add" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">2.</span>
                                </span> Add
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>add</code> method is used to add attributes to meta tags.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding attributes</code></div>
                                    <pre class="pre-code">
  $meta->add(name, content, type); 
<span class="comment"> 
    where: 

    name    : the name, property or http-equiv attribute value of meta tags 
    content : the content attribute of meta tags 
    type    : the type of meta tag. Options - [name|property|http-equiv]
                default type is name.
</span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding attributes</code></div>
                                    <pre class="pre-code">
  $meta->add('viewport', 'width=device-width, initial-scale=1.0');
  
  $meta->add('robots', 'noindex, nofollow');
  
  $meta->add('description','150 words');
  
  $meta->add('og:type', 'game.achievement', 'property');
  
  $meta->add('Pragma', 'no-cache', 'http-equiv');
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Examples above respectfully translates:</code></div>
    <pre class="pre-code">
  <span class="comment no-select">&#60;meta name="viewport" content="width=device-width, initial-scale=1.0"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="robots" content="noindex, nofollow"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="description" content="150 words"/&#62</span>
  
  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
  
  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="name" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">3.</span>
                                </span> name
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>name</code>  method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding property tags</code></div>
                                    <pre class="pre-code">
  $meta->name(name, content); 
  <span class="comment"> 
    where: 

    name : the name attribute value of meta tag
    content  : the content attribute value of meta tag
  </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                <div class="pxv-6 bc-off-white"><code>Example: adding named meta tags</code></div>
    <pre class="pre-code">
  $meta->name('description', '150 words');  
  
  <span class="comment no-select">//translates as:  &#60;meta name="description" content="150 words"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="prop" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">4.</span>
                                </span> Prop
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>prop</code> method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding property tags</code></div>
                                    <pre class="pre-code">
  $meta->prop(property, content); 
<span class="comment"> 
    where: 

    property : the property attribute value of meta tag
    content  : the content attribute value of meta tag
</span>
                                    </pre>
                                </div>
                            </div>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding property meta tags</code></div>
                                    <pre class="pre-code">
  $meta->prop('og:type', 'game.achievement');  
    <span class="comment no-select">
  // translates as:  &#60;meta property="og:type" content="game.achievement"/&#62
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="equiv" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">5.</span>
                                </span> http-equiv
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>equiv</code>  method is a shorthand for the meta tags with the attribute of http-equiv.
                            Example is shown below: <br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding http-equiv to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->equiv(http-equiv, content); 
    <span class="comment"> 
        where: 

        http-equiv : the http-equiv attribute value of meta tag
        content  : the content attribute value of meta tag
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding http-equiv meta tags</code></div>
                                    <pre class="pre-code">
  $meta->equiv('Pragma', 'no-cache',);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>
                
                <div id="refresh" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">6.</span>
                                </span> refresh
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>refresh</code>  method is a shorthand for the meta tags with the attribute of 
                            <code>http-equiv="refresh"</code>. Example is shown below:<br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding http-equiv to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->refresh(time); 
    <span class="comment"> 
        where: 

        time : time in seconds
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding refresh to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->refresh(30);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="refresh" content="30"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="og" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">7.</span>
                                </span> og
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>og</code> method is a shorthand for the meta tags with the attribute of 
                            <code>property="og:"</code>.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding og to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->og(type, content); 
    <span class="comment"> 
        where: 

        type : og type.
        content : content atttribute of og meta tags.
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding og property to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->og('type', 'game.achievement');  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="link" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">8.</span>
                                </span> link
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>link</code> method is used to add properties <code>link</code> meta tags. 
                            Examples are shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding og to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->link(rel, href, attrs); 
    <span class="comment"> 
        where: 

        rel : relativity attribute of link tag.
        href : href atttribute of link tags.
        attrs: other attributes of link tag
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding og property to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->link('icon', 'https://somesite.com/icon.png",['type' => 'image/png']);  
    <span class="comment no-select">
    // <span class="comment no-select">&#60;link rel="icon" href="https://somesite.com/icon.png" type="image/png" /&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="drop" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">9.</span>
                                </span> drop
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>drop()</code> method removes all stored meta definitions from storage list.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: clearing definitions</code></div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  $meta->drop(); <span class="comment">// clear previous descriptions</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="export" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">10.</span>
                                </span> export
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>export()</code> method displays all stored meta definitions from storage list on each line.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: display all stored meta tags</code></div>
                                    <pre class="pre-code">
    $meta->export(); <span class="comment">// displays each predefined meta tags in a listed order</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="dump" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">11.</span>
                                </span> dump
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>dump()</code> method returns all stored meta tags. However, when a boolean argument of <code>true</code> 
                            is supplied, it prints out all stored meta tags.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: clearing definitions</code></div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  var_dump($meta->dump()); <span class="comment">// return predefined meta tags</span> 
  $meta->dump(true); <span class="comment">// prints predefined meta tags</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="sample" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">12.</span>
                                </span> sample
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>sample()</code> method returns an array of meta tag samples. This data 
                            was compiled from across different source on the internet.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: get samples of meta tags</code></div>
                                    <pre class="pre-code">
  var_dump( $meta->sample() ); <span class="comment">// outputs array of meta tag sample attributes</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/meta">Meta</a>  </div>


            </div>
            </div>
        </section>
    </div>
    
    



         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>