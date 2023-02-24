

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Functions</title>
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

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions">Functions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions/modal">Modal</a>  </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions - Modal</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper functions are predefined spoova functions that eases building 
                web applications. Spoova helper functions are divided into three categories 
                
                <br>
                
            </div> 
          </div>

          <!-- br -->
          <div id="br" class="br"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">1. br</div>
            </div> <br>
            
            <div>
                The <code>br</code> function breaks a line both within cli and on web pages
            </div> <br>
            
            <!-- code line started - refil -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment"> >> syntax: br(value, breaks)</span>

  <span class="c-sky-blue-dd">
      value: string 
      breaks: number of breaks after
  </span> 
              </pre>

            </div>
            <!-- code line ended -->
          </div>    

          <!-- refil -->
          <div id="refil" class="refil"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">2. refil</div>
            </div> <br>
            
            <div>
              If a trimmed value is not empty, <code>refil</code> returns the second argument supplied.
    
              <!-- code line started - refil -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  <span class="comment"> >> syntax: </span>

      $value = 'foo';
      $newval = refil($value, 'bar');

      echo $newval  <span class="comment">// returns : bar </span>
                </pre>

              </div>
              <!-- code line ended -->
  
            </div> <br>

          </div>

          <!-- encodeUriComponent -->
          <div id="encodeuricomponent" class="encodeuricomponent"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. encodeUriComponent</div>
            </div> <br>
            
            <div>
                Encodes url in a way that is similar to Javascript's encodeURIComponent
            </div> 
          </div>         

          <!-- inRange -->
          <div id="inrange" class="inrange"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">4. inRange</div>
            </div> <br>
            
            <div>
                Checks if a value is within the range of two values
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">// syntax: </span>
  inRange($value, $min, $max)


  <span class="comment">// Example : returns true </span>
  inRange(27, 20, 50)
              </pre>

            </div>
            <!-- code line ended -->

          </div>      
          
          <!-- randice -->
          <div id="randice" class="randice"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">5. randice</div>
            </div> <br>
              
            <div>
                Generates a list or random_bytes hash string from the supplied range of keys.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns random hashed string of 10 characters</span>
  $hash = randice(10);

  <span class="comment">//returns random hashed string of 5 characters from supplied string</span>
  $hash = randice(10, 'abc123');   
              </pre> 

            </div>
            <!-- code line ended -->

          </div>                 
          
          <!-- is_empty -->
          <div id="is_empty" class="is_empty"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">6. is_empty</div>
            </div> <br>
              
            <div>
                This function tests if a value is empty. This can be an array or trimmed string. 
                By trimming strings before testing, it acts as a proof against empty spaces. The function 
                is also capable of regarding non-empty values as empty values. Examples are shown below:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//tests if value supplied is empty</span>
  is_empty('a'); <span class="comment">//returns false</span>
  is_empty(''); <span class="comment">//returns true</span>
  is_empty('    '); <span class="comment">//returns true</span>
  is_empty([]); <span class="comment">//returns true</span>

  <span class="comment">//using defined and empty values</span>
  is_empty('a', ['a','b','c']); <span class="comment">//returns true (because "a" exists in the list of assumed empty values)</span>  
  is_empty('', ['a','b','c']); <span class="comment">//returns true (because test value is an empty value)</span>  
              </pre> 

            </div>
            <!-- code line ended -->

          </div>                 
          
          <!-- not_empty -->
          <div id="not_empty" class="not_empty"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">7. not_empty</div>
            </div> <br>
            
            <div>
                This is the reverse of <a href="<?= DomUrl('docs/functions/modal#is_empty') ?>">is_empty</a> function
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
    <span class="comment">//tests if value supplied is empty</span>
    not_empty('a'); <span class="comment">//returns true</span>
    not_empty(''); <span class="comment">//returns false</span>
    not_empty('    '); <span class="comment">//returns false</span>
    not_empty([]); <span class="comment">//returns false</span>

    <span class="comment">//using defined an empty values</span>
    not_empty('a', ['a','b','c']); <span class="comment">//returns false (because "a" exists in the list of assumed empty values)</span>  
    not_empty('', ['a','b','c']); <span class="comment">//returns false (because test value is an empty value)</span>  
              </pre> 

            </div>
            <!-- code line ended -->

          </div>  

          <!-- combine -->
          <div id="combine" class="combine"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">8. combine</div>
            </div> <br>
            
            <div>
                This function combines two arrays or a string into an array. The first argument 
                is not neccesarily an array but the second argument must be an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  $array = [1,2,3];

  combine(4, $array);
  vdump($array); <span class="comment">//returns: [1,2,3,4]</span>  

  <span class="comment">//using $array</span>
  
  combine([4, 5], $array);
  vdump($array); <span class="comment">//returns: [1,2,3,4,5]</span>
              </pre>

            </div>
            <!-- code line ended -->

          </div>   
          
          <!-- compare -->
          <div id="compare" class="compare"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">9. compare</div>
            </div> <br>
            
            <div>
                Compare checks if all arguments supplied are of equal values.
                It is case sensitive. These can be used to test any data type
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns true</span>
  vdump(compare('user', 'user', 'user')); 

  <span class="comment">//returns false</span>
  vdump(compare('user', 'user', 'me')); 
              </pre>

            </div>
            <!-- code line ended -->

          </div>   

          <!-- arrinside -->
          <div id="arrinside" class="arrinside"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">10. arrInside</div>
            </div> <br>
            
            <div>
                This function checks if array contains another array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=> ['name'=>'foo'] ];
      
  <span class="comment">//returns true</span>
  var_dump(arrInside($value)); 
              </pre>

            </div>
            <!-- code line ended -->

          </div>        

          <!-- arrvoid -->
          <div id="arrvoid" class="arrvoid"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">11. arrVoid</div>
            </div> <br>
            
            <div>
                This function checks if an array is empty. Contrary to empty function, all
                array keys having empty values are removed before testing is done.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>''];
  $foo = ['user'=>'foo'];
      
  <span class="comment">//returns true</span>
  var_dump(arrVoid($value));
  
  <span class="comment">//returns false</span>
  var_dump(arrVoid($foo)); 
              </pre>   
              
            </div>
            <!-- code line ended -->

          </div>        

          <!-- arrgetsvoid -->
          <div id="arrgetsvoid" class="arrgetsvoid"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">12. arrGetsVoid</div>
            </div> <br>
            
            <div>
                This function checks if at least one empty value exists within an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
    $value = ['user'=>'','gender'=>'male'];
    $foo = ['user'=>'foo', 'gender'=> 'male'];
        
    <span class="comment">//returns true</span>
    var_dump(arrGetsVoid($value));
    
    <span class="comment">//returns false</span>
    var_dump(arrGetsVoid($foo));    
              </pre>

            </div>
            <!-- code line ended -->

          </div> 

          <!-- arrSort -->
          <div id="arrsort" class="arrsort"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">13. arrSort</div>
            </div> <br>
            
            <div>
                The function removes keys with empty values, then sorts an array
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  vdump(arrsort([0 => 'foo', 1 => '', 2 => 'bar'])); <span class="comment">// [0 => 'foo', 2 => 'bar'] </span> 
  

  vdump(arrsort([0 => 'foo', 1 => '', 2 => 'bar'], true)); <span class="comment">// [0 => 'foo', 1 => 'bar'] </span> 
              </pre>

            </div>
            <!-- code line ended -->

          </div> 

          <!-- array_trim -->
          <div id="array_trim" class="array_trim"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">14. array_trim</div>
            </div> <br>
            
            <div>
                This function removes keys having empty values from an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>'','gender'=>'male'];
      
  <span class="comment">//returns ['gender'=>'male']</span>
  var_dump(array_trim($value));
              </pre>

            </div>
            <!-- code line ended -->
          </div>        

          <!-- array_get -->
          <div id="array_get" class="array_get"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">15. array_get</div>
            </div> <br>
            
            <div>
                This function returns a specified key in an array or null if such key does not exist.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>'','gender'=>'male'];
      
  <span class="comment">//returns ['gender'=>'male']</span>
  $user = array_get('user', $value);

  var_dump($user);
              </pre>

            </div>
            <!-- code line ended -->

          </div>    

          <!-- array_object -->
          <div id="array_object" class="array_object"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">16. array_object</div>
            </div> <br>
            
            <div>
                This function converts an array to an std object.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=> ['name'=>'foo'] ];
      
  $obj = array_object($value);

  <span class="comment">//returns : foo</span>
  vdump($obj->user['name'])
              </pre>

            </div>
            <!-- code line ended -->

          </div>                   

          <!-- array_delete -->
          <div id="array_delete" class="array_delete"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">17. array_delete</div>
            </div> <br>
            
            <div>
                The function removes the first matched key of a corresponding supplied value 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $array = ['name' => 'foo', 'size' => '3', 'num' => '3'];


  vdump(array_delete('foo', $array)); <span class="comment">// ['size' => '3', 'num' => '3'] </span> 
  

  vdump(array_delete('3', $array); <span class="comment">// ['name' => 'foo', 'num' => '3'] </span> 
              </pre>

            </div>
            <!-- code line ended -->

          </div>     

          <!-- array_unset -->
          <div id="array_unset" class="array_unset"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">18. array_unset</div>
            </div> <br>
            
            <div>
                The function removes all matched key of a corresponding supplied value 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $array = ['name' => 'foo', 'size' => '3', 'num' => '3'];

  vdump(array_unset('3', $array); <span class="comment">// ['name' => 'foo'] </span> 
              </pre>

            </div>
            <!-- code line ended -->

          </div>           
                    
          <!-- reItemize -->
          <div id="reitemize" class="reitemize"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">19. reItemize</div>
            </div> <br>
            
            <div>
              This function is used to regroup a two dimentional arrays of equal values.
              It is mainly used to regroup file uploads. For example:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">// An array: </span> 
  $array['name'][0] = 'fileName1';
  $array['age'][0]  = 20;  

  $array['name'][1] = 'fileName2';
  $array['age'][1] = 25;

  $array = reItemize($array);

  <span class="comment">// Becomes: </span> 
  $array[0]['name'] = 'fileName1';
  $array[0]['age'] = 20;

  $array[1]['name'] = 'fileName2';
  $array[1]['age'] = 25;
              </pre>

            </div>
            <!-- code line ended -->

          </div>            
        
        </div>  
      
      </div>
    </section>
    
  </div>

  


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>