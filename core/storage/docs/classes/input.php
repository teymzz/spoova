

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
               <li> <a href="<?= DomUrl('docs/directives') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Directives</a> </li>
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

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/input">Input</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Input</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            The input class is a special tool that helps to validate input. It 
                            is mostly used when validating form inputs. All validation are 
                            directly processed and returned through the <code>set</code> method. 
                            The following are methods available in the input class.
                        </div> <br> 

                            <ol>
                            <li> <a href="#set"> set </a> </li>
                            <li> <a href="#strict"> strict </a> </li>
                            <li> <a href="#default_type"> default_type </a> </li>
                            <li> <a href="#default_length"> default_length </a> </li>
                            <li> <a href="#default_range"> default_range </a> </li>
                            <li> <a href="#arrgetsvoid"> arrGetsVoid </a> </li>
                            <li> <a href="#voidkey"> voidKey </a> </li>
                            </ol>
                            
                        </div> 
                    </div>

                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> initializing class
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>input</code> class can be easily initialized as shown below.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
                                    <pre class="pre-code">
    $input  = new Input;
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br><br>
                    </div>

                    <div id="set" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> set
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>set</code> method is used to set parameters to be validated by
                                the input class. It's alias method is the <code>test()</code> method which takes the same number 
                                of arguments as parameters.
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: set</code></div>
                                        <pre class="pre-code">
    $input->set($value, $config, $bool);

    $input->test($value, $config, $bool); <span class="comment">// same as above</span>
    <span class="comment no-select">
      where:
        
        $value : value to be tested 
        $config: configuration parameters or options that define action to be performed 
        $bool  : a boolean of true tells input class to disallow spaces when validating input value set.                            
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>

                        <div class="exampes-intro font-menu font-em-d8">
                            We shall be looking at a series of examples below.
                        </div> <br>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: validating strings</code></div>
                                <pre class="pre-code">
    $text1 = 'foo';
    $text2 = 'foo bar';

    $text1 = $input->set($text1, ['type' => 'string']); <span class="comment">// returns foo</span>

    $text2 = $input->set($text2, ['type' => 'string']); <span class="comment">// returns bar</span>

    <span class="comment">//check spaces</span>
    $text1 = $input->set($text1, ['type' => 'string'], true); <span class="comment">// returns foo</span>
    $text2 = $input->set($text2, ['type' => 'string'], true); <span class="comment">// returns null because test string contains spaces</span>                              
                                </pre>
                            </div>
                        </div>

                        <div class="font-menu pvs-10">
                            The following are list of available options and their descriptions: <br>
                            <br>
                            <div class="">
                                <div class="">
                                    <code>type</code> - defines the type of validation. Options are [string | text | email | integer | number | phone | url | range | pregmatch]
                                </div>
                                <div class="">
                                    <code>length</code> - defines the minimum and maximum number of characters to be allowed where maximum is default if one value is supplied.
                                </div>
                                <div class="">
                                    <code>range</code> - defines an array list which a value must be a member of. 
                                </div> <br>
                            </div>
                            The following examples best describe how these options can be applied for validation <br>
                        </div>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: Input Types</code></div>
                                <pre class="pre-code">
    $input->set('site@gmail.com', ['type' => 'email']); <span class="comment">// returns site@gmail.com</span>
    $input->set('site.com', ['type' => 'email']); <span class="comment">// returns null</span>


    $input->set('10', ['type' => 'number']); <span class="comment">// returns 10</span>
    $input->set('hi', ['type' => 'number']); <span class="comment">// returns null</span>


    $input->set('0701323323', ['type' => 'phone']); <span class="comment">// returns 0701323323</span>
    $input->set('07812', ['type' => 'phone']); <span class="comment">// returns null : This uses a regex pattern</span>

    
    $input->set('20', ['type' => 'number', range => ['5', '15', '20']]); <span class="comment">// returns 20</span>                              
    $input->set('20', ['type' => 'number', range => ['5', '15', '25']]); <span class="comment">// returns null</span> 


    $input->set('foo', ['type' => 'string', 'length' => 10]); <span class="comment">// returns 10, character is less than 10</span>                              
    $input->set('foobar123', ['type' => 'string', 'length' => ['0', '5']]); <span class="comment">// returns null, character is greater than 5</span>    


    $input->set('foo', ['type' => 'text', 'length' => 10]); <span class="comment">// returns foo</span>                              
    $input->set('foobar123', ['type' => 'text']); <span class="comment">// returns null, value contains number</span> 
    

    $input->set('http://site.com', ['type' => 'url']); <span class="comment">// returns http://site.com</span>                              
    $input->set('site', ['type' => 'url']); <span class="comment">// returns null, value is not a valid url</span> 
    
    $input->set('foobar', ['type' => 'string', 'pattern' => 'a-zA-z']); <span class="comment">// match data type using pattern</span>
    
    $input->set('400', ['type' => 'number', 'range' => [100, 700]]); <span class="comment">// match data type using specific range of values</span>

    $input->set('foobar', ['type' => 'string', 'length' => [3, 7]]); <span class="comment">// matches a minimum and maximum length of character a data must contain.</span> 
                                </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div id="strict" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> strict
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>strict()</code> method is a directive that prevents the input class from proceeding with 
                                subsequent validations if an error is encountered in previous validations <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: strict validation</code></div>
                                        <pre class="pre-code">
    $input->strict(bool);
    <span class="comment">
      where:
    
        bool: set the strict type to true or false. Default is true.
    </span>                            </pre>
                                    </div>
                                </div>          
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: strict validation</code></div>
                                <pre class="pre-code">
    $input->strict();

    $input->set('foo', ['type'=>'number']); <span class="comment"> // returns null</span>
    
    $input->set('foo', ['type'=>'text']); <span class="comment"> // returns null because a previous validation returned null</span>                                  
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div>
                        <div class="foot-note mvt-10">
                            The <code>strict()</code> method when set to true, is used to to stop a validation process if any of the <code>set()</code> method 
                            cannot validate the data supplied. Once any error occurs in any earlier validation, other subsequent validations after will fail 
                            by returning an empty value.
                        </div>
                    </div> <br>

                    <div id="default_type" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> default_type
                                </div>
                            </div> <br>
                            <div class="">
                                    
                                Sets the default type of inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                    <div class="pxv-6 bc-off-white"><code>Syntax: default_type</code></div>
                    <pre class="pre-code">
    $input->default_type($type); <span class="comment"> // set base path</span>
    <span class="comment"> 
      where :

        $type: type of validation
    </span>
                    </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: default_type</code></div>
                                        <pre class="pre-code">
    $input->default_type('text'); <span class="comment"> // set default type</span>

    $input->set('foo'); <span class="comment">// returns foo</span>
    $input->set('foo123'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="default_length" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> default_length
                                </div>
                            </div> <br>
                            <div class="">
                                Sets the default length of inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: default_length</code></div>
                                        <pre class="pre-code">
    $input->default_length(length); <span class="comment"> // set base path</span>
    <span class="comment"> 
      where :

        length: array or string of acceptable lengths
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: default_length</code></div>
                                        <pre class="pre-code">
    $input->default_length(5); <span class="comment"> // set default length</span>
    
    $input->set('foo12'); <span class="comment">// returns foo12</span>
    $input->set('foobar123'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="default_range" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> default_range
                                </div>
                            </div> <br>
                            <div class="">
                                Sets the default ranges for inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: default_range</code></div>
                                        <pre class="pre-code">
    $input->default_range($range); <span class="comment"> // set default range</span>
    <span class="comment"> 
      where :

        $range: array of acceptable ranges
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: default_range</code></div>
                                        <pre class="pre-code">
    $input->default_range(['ball', 'cat', 'dog']); <span class="comment"> // set default range</span>
    
    $input->test('cat'); <span class="comment">// returns cat</span>
    $input->test('bird'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="arrgetsvoid" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> arrGetsVoid
                                </div>
                            </div> <br>
                            
                            <div class="">
                                The <code>arrGetsVoid</code> checks if a supplied array has any index key having an empty value within it.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: arrGetsVoid</code></div>
                                        <pre class="pre-code">
    Input::arrGetsVoid($array); 
    <span class="comment no-select"> 
      where:
        
       $array : array lists to be tested
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: arrGetsVoid</code></div>
                                        <pre class="pre-code">
    Input::arrGetsVoid(['name'=>'foo','age'=>'']); <span class="comment">// returns true</span>
    Input::arrGetsVoid(['name'=>'foo','age'=>'30']); <span class="comment">// returns false</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="voidkey" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> voidKey
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>voidKey</code> method returns the corresponding keys that have 
                                an empty value in a previously tested array. 
                                This method is useful when handling zip files.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: fetch last directory</code></div>
                                        <pre class="pre-code">
    Input::arrGetsVoid(['name'=>'foo', 'age'=>'']);
    Input::voidKey(); <span class="comment no-select"> // returns ['age']</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div> 
                    
                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/input">Input</a>  </div>


                </div>
            </div>
        </section>
    </div>
        


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>