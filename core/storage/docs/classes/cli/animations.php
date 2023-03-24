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
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/cli">Cli</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/cli/animations">Animations</a>  </div>


                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Animations</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        Notifications are used to keep users aware of the current state of an executed command. They help users to have a clearer understanding 
                                        pf what is going on. For example, there could be notifications for when a code successfully executes or when an error is encountered. 
                                        The Cli class provides some useful methods for setting responses. These method have a predefined text prefixes assigned to messages. The 
                                        text prefixes also use similarly related color codes to quickly call console users to awareness. The following are notification related methods. 
                                    </p>

                                </div>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li><a href="#textYield" class="c-i">textYield</a></li>
                                                <li><a href="#animeType" class="c-i">animeTest</a></li>
                                                <li><a href="#play" class="c-i">play</a></li>
                                                <li><a href="#pause" class="c-i">pause</a></li>
                                                <li><a href="#animeType" class="c-i">animeType</a></li>
                                                <li><a href="#animate" class="c-i">animate</a></li>
                                                <li><a href="#loadTime" class="c-i">loadTime</a></li>
                                                <li><a href="#endAnime" class="c-i">endAnime</a></li>
                                                <li><a href="#runAnime" class="c-i">runAnime</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div> <br>

                        <div id="textYield" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> Cli::textYield()
                                    </div>
                                </div> <br>
                                <div class="">
                                    This method is used to yield a particular text. Yielding here means that text will first be printed while 
                                    a loading animation will run after.
                                    <br><br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textYield</code></div>
                                            <pre class="pre-code">
    Cli::textYield($text, $yield, $pause);
    <span>
      where:

        $text     : test to be displayed 
        $yield    : Integer number of times the animation must run
        $pause    : An optional delay that is added after the loading animation is completed.
    </span>
                                            </pre>
                                        </div>
                                    </div>

                                </div>
                            </div> <br>

                        </div> <br>


                        <div id="play" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> Cli::play()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is used to run animations
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: play</code></div>
                                    <pre class="pre-code">
    Cli::play($yield, $indent, $message, $break, $pause); 
    <span class="comment no-select">
      where: 
    
        $yield   : Number of times animation must run
        $indent  : Number of left space indents to be added before text is printed
        $message : Animation text to be printed
        $break   : Number of line breaks to be added after animation is done.
        $pause   : Delay in seconds to be added after animation is done.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="pause" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">3.</span>
                                        </span> Cli::pause() or Cli::wait()
                                    </div>
                                </div> <br>
                                <div class="">
                                These method are used to set delay before an operation is executed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: pause</code></div>
                                    <pre class="pre-code">
    Cli::pause($seconds); 
    <span class="comment no-select">
      where: $seconds is delay in seconds
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="animeTest" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">4.</span>
                                        </span> Cli::animeTest()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>animeTest()</code> method is used to test the response of animations
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: animeTest</code></div>
                                    <pre class="pre-code">
    yield from Cli::animeText(); <span class="comment no-select">//tries to run animation using a long (or heavy) loading strategy.</span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="animate" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">5.</span>
                                        </span> Cli::animate()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>animate()</code> method is used to view the different loading animations and their behaviour when used.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: animeTest</code></div>
                                    <pre class="pre-code">
    Cli::animate($yield, $delay); 
    <span class="comment no-select">
      where: 
    
        $yield   : Number of times animation must run.
        $delay   : Delay in seconds to be added after animation is done.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="endAnime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">6.</span>
                                        </span> Cli::endAnime()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>endAnime()</code> method is designed to print a text after animation is completed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: endAnime</code></div>
                                    <pre class="pre-code">
    Cli::endAnime($pause, $break1, string $message, $break2, $indent); 
    <span class="comment no-select">
      where: 
    
        $pause   : Delay in seconds to before text is printed.
        $break1  : Line breaks before text is printed. Default is zero (0).
        $message : Message to be printed
        $break2  : Line breaks after text is printed. Default is one (1).
        $indent  : Left margin on printed text. Default is two (2).
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="loadTime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                         <span class=" mxr-8 c-lime-dd">
                                           <span class="numb-box">7.</span>
                                        </span> Cli::loadTime()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is designed to increase or decrease the amount of time needed for an animation to successfully complete. It can be 
                                declared before the <code>Cli::runAnime()</code> method is called or at any point before a <code>yield</code> generator function is 
                                declared.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: loadTime</code></div>
                                    <pre class="pre-code">
    Cli::loadTime($time); 
    <span class="comment no-select">
      where: 
    
        $time  : Animation time in seconds
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="runAnime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">8.</span>
                                        </span> Cli::runAnime()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is specially designed to run animations based on whether a function or public method is iterable. It uses special 
                                syntaxes to determine whether an iterable item is function related or object related, making it possible to run animations from functions 
                                or methods. An iterable item means a generator function or method.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: runAnime</code></div>
                                    <pre class="pre-code">
    Cli::runAnime($function, $callback); 
    <span class="comment no-select">
      where: 
    
        $function  : A function name or an array of function (or object) and its arguments.
        $callback  : An optional final callback to be executed when animation is complete.
    </span>
                                    </pre>
                                </div>
                            </div>  <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: functions without arguments</code></div>
                                    <pre class="pre-code">
    function animate(){

        yield from 100;

    }

    Cli::runAnime('animate'); <span class="comment no-select"> //run animation 100 times.</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: function with arguments</code></div>
                                    <pre class="pre-code">
    function animate($text){

        yield from 100;

        print $text[0];

    }

    Cli::runAnime(['animate', ['completed']]); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Class without arguments</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public static function load() {

            yield 100;

        }

    }

    Cli::runAnime([Anime::class, 'load']); <span class="comment no-select"> //run animation 100 times.</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Class with arguments</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public static function load($args) {

            yield 100;

            print $args[0];

        }

    }

    Cli::runAnime([[Anime::class, 'load'], ['completed']]); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Running animation in classes</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public function load() {

            Cli::runAnime([[$this, 'generator'], ['completed']]);

        }

        public function generator($args) {

            yield 100;

            print $args[0];

        }

    }

    $Anime = new Anime; 
    $Anime->load(); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Stopping animations</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public function load() {

            Cli::runAnime([[$this, 'generator'], ['completed']]);

        }

        public function generator($args) {

            yield 100; 
            
            print $args[0];

            yield false; <span class="comment">//stop animation here.</span>
            
            print "something"; <span class="comment">//this will not run.</span>

        }

    }

    $Anime = new Anime; 
    $Anime->load();
                                    </pre>
                                </div>
                            </div> <br>
                            
                                </div>

                                <div class="foot-note">
                                    Animations can be stopped using the key words <code>yield false</code> or <code>yield true</code>. In the example above, the 
                                    last message "something" will not execute because the stop keyword <code>yield false</code> was used.
                                </div>
                            </div> 
                        </div> <br>

                        <div id="loadType" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                         <span class=" mxr-8 c-lime-dd">
                                           <span class="numb-box">9.</span>
                                        </span> Cli::loadType()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method selects the type of animation to be used. In spoova Cli, there are currently 10 types of animations which includes 
                                <code>normal</code>, <code>roller</code>, <code>dotted</code>, <code>arrows</code>, <code>forward</code>, <code>timer</code>, 
                                <code>circle</code>, <code>angles</code>,<code>steps</code> and <code>braill</code>. Animation type can be declared or switched
                                at any point before or during an animation runtime.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: loadType</code></div>
                                    <pre class="pre-code">
    Cli::loadTime($type); 
    <span class="comment no-select">
      where: $type defines the loading type.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/cli">Cli</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/cli/animations">Animations</a>  </div>


                    </div>
                </div>
            </section>
        </div>

    


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>