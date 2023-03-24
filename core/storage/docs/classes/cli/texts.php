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

                    
 <div class="font-menu pvs-4">   </div>


                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Texts Control</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">
                                    There are different cli methods for adding texts to the terminal in the manner which is desirable to console users. 
                                    Hence, features like text margins and line breaks becomes easier to control. Most of these methods achieve their 
                                    functions by shifting the console pointer to desired positions while other methods only makes it easier to print text 
                                    to console in a specific desired format. These methods and their descriptions are listed below.
                                </div> <br>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li>textIndent</li>
                                                <li>textView</li>
                                                <li>List</li>
                                                <li>dots</li>
                                                <li>backspace</li>
                                                <li>cls</li>
                                                <li>clearLine</li>
                                                <li>clearUp</li>
                                                <li>upLine</li>
                                                <li>br</li>
                                                <li>break</li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div>  

                        <div id="textIndent" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> Cli::textIndent()
                                    </div>
                                </div> <br>

                                <div class="">
                                    This method is used to only apply indents on supplied text value. Once the indent is applied, the resulting text will 
                                    be returned as a string.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textIndent</code></div>
                                            <pre class="pre-code">
    Cli::textIndent($text, $spaces);
    <span class="comment">
      where: 
        
        $text   : text to be indented
        $spaces : number of indents to be applied
    </span>
                                            </pre>
                                        </div>
                                        </div>
                                </div>
                            </div> <br><br>
                        </div>

                        <div id="textView" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> Cli::textView()
                                    </div>
                                </div> <br>

                                <div class="">
                                    This method is used to display text contents on the command line. It is capable of applying features like spaces, indents, 
                                    breaks and delays on text to be display.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView($text, $spacing, $break, $pause);
    <span class="comment">
      where: 
        
        $text    : text to be displayed
        $spacing : An optional string format that applies spaces before and after the supplied text using a pipe divider
        $break   : An optional string format that applies breaks before and after the supplied text using a pipe divider
        $pause   : An optional string format that applies delays before and after a string is displayed.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 1: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView("Hello text", 2, 3, 1);
    <span class="comment no-select">
    In the code above, the text "Hello text" will be printed on the cli using specific features:

        1. The <code class="c-orange-d">2</code> defines that 2 spaces should be applied before the text is printed
        
        2. The <code class="c-orange-d">3</code> defines that 3 line breaks should be added before text is printed

        3. The <code class="c-orange-d">1</code> defines a 1 second delay before text is printed.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 2: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView("Hello text", "2|2", "3|2", '2|1');
    <span class="comment no-select"> 
    The code above reveals that pipes are used to specify the position before and after when an event should be applied.

        1. The <code class="c-orange-d">"2|2"</code> defines that 2 spaces before and 2 spaces after should be applied on the text
        
        2. The <code class="c-orange-d">"3|2"</code> defines that 3 line breaks before and 2 breaks after should be applied on the text

        3. The <code class="c-orange-d">"2|1"</code> defines that 2 seconds delay before and 1 delay after should be applied on the text.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>


                                </div>
                            </div> <br><br>
                        </div>

                        <div id="List" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">3.</span>
                                        </span> Cli::List()
                                    </div>
                                </div> <br>
                                <div class="">
                                    The <code>List</code> method is used to display an array of strings with numbers. The numbering starts from 
                                    zero upward. However, associative arrays will use ther specific array keys
                                    <br><br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: list</code></div>
                                            <pre class="pre-code">
    Cli::list($array, $spacing, $break, $interval);
    <span>
      where:

        $array      : array of strings to be displayed 
        $spacing    : An optional spacing format that applies spacing on each text to be displayed 
        $break      : An optional line breaking format that applies spacing on each text to be displayed 
        $interval   : An optional delay format that applies delay in seconds on each text to be displayed 
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 1: List</code></div>
                                            <pre class="pre-code">
    Cli::List(['Foo','Bar', 'Baz'], 0, "|1");
    <span>
     <span class="comment no-select">The response will be as below:</span> 

     1. Foo
     2. Bar
     3. Baz
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 2: List</code></div>
                                            <pre class="pre-code">
    Cli::List(['a'=>'Foo','b'=>'Bar', 'c' => 'Baz'], 0, "|1");
    <span>
     <span class="comment no-select">The response will be as below:</span> 

     a. Foo
     b. Bar
     c. Baz
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>


                                </div>
                            </div>
                        </div> <br>

                        <div id="dots" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">4.</span>
                                        </span> Cli::dots()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is used to repeat a defined character in the number of required number of chracter to to generated. The 
                                number of character generated depends on the maximum number of character expected to be generated in a given text. This 
                                ensures that a defined character fills up the spaces left if the defined maximum length of characters for a given text is not 
                                reached.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: dots</code></div>
                                    <pre class="pre-code">
    Cli::dots($max, $text, $char); 
    <span class="comment no-select">
      where: 
    
        $max  : The expected length of text characters that must be generated. 
        $text : A given text whose length of characters is measured
        $char : A character that fills up left over space. Default is dots "."
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="backspace" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">5.</span>
                                        </span> Cli::backspace()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>backspace()</code> method is used to delete the text characters starting from the right towards the 
                                left side. 
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: backspace</code></div>
                                    <pre class="pre-code">
    Cli::backspace($times); 
    <span class="comment no-select">
      where: $times is the number of times a backspace must be applied. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="cls" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class="mxr-8 c-lime-dd">
                                            <span class="numb-box">6.</span>
                                        </span> Cli::cls()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>cls()</code> method is used to clear the terminal screen.
                                </div>
                            </div> 
                        </div><br>

                        <div id="clearLine" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">7.</span>
                                        </span> Cli::clearLine()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>clearLine()</code> method is used to delete the entire character on a line. This method takes 
                                no arguments.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: backspace</code></div>
                                    <pre class="pre-code">
    Cli::backspace($times); 
    <span class="comment no-select">
      where: $times is the number of times a backspace must be applied. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="clearUp" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class="mxr-8 c-lime-dd">
                                            <span class="numb-box">8.</span>
                                        </span> Cli::clearUp()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>clearUp()</code> method is used to delete a line before a text is printed. It shifts the positon of the cli pointer 
                                up by deleting all characters found along the way to its destination point.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: clearUp</code></div>
                                    <pre class="pre-code">
    Cli::clearUp($times); 
    <span class="comment no-select">
      where: $times is the number of times a the pointer must move up. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="upLine" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">9.</span>
                                        </span> Cli::upLine()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>upLine()</code> method is used to shift the position of the command line pointer upwards without 
                                deleting any character.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: upLine</code></div>
                                    <pre class="pre-code">
    Cli::upLine($times); 
    <span class="comment no-select">
      where: $times is the number of times a cursor must be shifted upwards.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="br" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">10.</span>
                                        </span> Cli::br()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>br()</code> method is used to apply text line breaks after a text has been printed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: br</code></div>
                                    <pre class="pre-code">
    Cli::br($times); 
    <span class="comment no-select">
      where: $times is the number of times a line break must be applied. Default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="break" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">11.</span>
                                        </span> Cli::break()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>break()</code> method is also used to apply text line breaks after a text has been printed. The difference between <code>Cli::br()</code> 
                                and <code>Cli::break()</code> is that the latter prints directly by default while the former returns line breaks. However, the <code>Cli::break()</code> 
                                can also be modified to return line breaks rather than printing them. This can be done by setting the second argument to false.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: break</code></div>
                                    <pre class="pre-code">
    Cli::break($times, $print); 
    <span class="comment no-select">
      where: 
        
        $times : The number of times a line break must be applied. Default value is "1".
        $print : When set as false, line breaks will only be returned as a string
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                    
 <div class="font-menu pvs-4">   </div>


                    </div>
                </div>
            </section>
        </div>

    


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>

