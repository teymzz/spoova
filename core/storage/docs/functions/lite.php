
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Functions</title>
    
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
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions">Functions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions/lite">Lite</a>  </div>


        <div class="start font-em-d8">


          <div class="font-em-1d5 c-orange">Functions - Lite</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6 hide">Introduction</div>
            <div class="">

                Lite helper functions are predefined spoova functions that eases building 
                web applications. These functions are mostly applied to strings or arrays
                while other functions under this group are just custom redefined functions of already existing 
                inbuilt php functions.
                
            </div> 
          </div>
          
          <!-- base_encode -->
          <div id="base_encode" class="base_encode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">1. base_encode</div>
            </div> <br>
            
            <div>
                A coined function for php <code>base64_encode</code>. It removes the equals sign from the 
                generated hashed value. This does not affect the performance of <code>base64_decode</code> function 
                when decoding the hashed value.
            </div> 
          </div>  
          
          <!-- base_decode -->
          <div id="base_decode" class="base_decode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">2. base_decode</div>
            </div> <br>
            
            <div>
                Performs exactly the same function as <code>base64_decode</code>
            </div>
          </div>  

          <!-- tojson -->
          <div id="tojson" class="tojson"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. toJson</div>
            </div> <br>
            
            <div>
                This converts an array or string to json format. It is coined from 
                php <code>json_encode</code> function.
            </div> 
          </div>         

          <!-- fromjson -->
          <div id="fromjson" class="fromjson"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">4. fromJson</div>
            </div> <br>
            
            <div>
              This converts a json std object or string to array format by default.
            </div>
          </div>         

          <!-- enplode -->
          <div id="enplode" class="enplode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">5. enplode</div>
            </div> <br>
            
            <div>
              This function uses the php implode() function. The main function is to wrap a string around 
              an array that was imploded. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  <span class="comment">1.</span> enplode( ["_", "#"], ['Hi', 'there'] ); <span class="comment">// returns: #Hi_there# </span>

  <span class="comment">2.</span> enplode( ["_", "(", ")"], ['Hi', 'there'] ); <span class="comment">// returns: (Hi_there) </span>

  <span class="comment">3.</span> enplode( ["_", "(", ")"], [] ); <span class="comment">// returns: null</span>

  <span class="comment">4.</span> enplode( ["_", "(", ")"], [], true ); <span class="comment">// returns: ()</span>

              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                In the examples above, while the underscore is the string that is used to implode the second array argument,
                <ul class="mvt-6">
                  <li>
                    In line 1 above, the hash will be wrapped around the implode string only if there is a string to be imploded. 
                  </li>
                  <li>
                    In line 2 above, The first (opening) and second (closing) pathenthesis will be added to the start and end of the imploded string respectively.
                  </li>
                  <li>
                    In line 3 above, both pathenthesis will not be added to the imploded array because the array is empty.
                  </li>
                  <li>
                    Line 4 however, explains that when a third boolean argument of true is supplied, then the wrapper characters will always be added even if the array is empty.
                  </li>
                </ul>
              </div>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- tosingular -->
          <div id="tosingular" class="tosingular"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">6. toSingular</div>
            </div> <br>
            
            <div>
              This function converts a string to singular by removing the last "s" or "S" character. The argument can also take a list of 
              array strings. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  <span class="comment">1.</span> echo( toSingular( 'Boys' ) ); <span class="comment">// Boy </span>

  <span class="comment">2.</span> print_r( toSingular( ['Boys', 'Book' "FUSS"] ) ); <span class="comment">// ['Boy', 'Book', "FUS"] </span>

              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> Notice that only the last "S" character is removed
              </div> <br>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- inflect -->
          <div id="inflect" class="inflect"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">7. inflect</div>
            </div> <br>
            
            <div>
              Inflect is a simple function that either adds or removes the last "s" character of a string based on the count 
              of value supplied to it as second argument. The format is shown below:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">
                <div class="bc-silver pxv-10">
                  Syntax
                </div>
              <pre class="pre-code">
  inflect($text, $count, $strict) 
              <span class="comment">
    where :

      $text   : string or array list of text strings
      $count  : integer used to determine the qunatity of $text 
      $strict : strict automation of addition or removal of last "s" character.
              </span> 
              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> Let's take a look at few examples:
              </div>

              <pre class="pre-code">
    inflect("Boy", 1); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //Boy  (adds "s" if $count is greater than 1)</span>

    inflect("Boy", 2); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //Boys (adds "s" if $count is greater than 1)</span>

    inflect("Boy", 2, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.......</span> //Boys (adds "s" if $count is greater than 1 and last character is not "s")</span>

    inflect("Boys", 2, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">......</span> //Boys (adds "s" if $count is greater than 1 and last character is not "s")</span>

    inflect("Boys", 1, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">......</span> //Boy  (removes "s" if $count is less than 1 and last character is "s")</span>
              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> First argument can also be an array of strings. All strings values will be processed within the array. 
              </div>


              <pre class="pre-code">
    inflect(["Boy","Book"], 2); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //[Boys, Books]  (adds "s" if $count is greater than 1)</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- to_lgts -->
          <div id="to_lgts" class="to_lgts"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">8. to_lgts</div>
            </div> <br>
            
            <div>
                This function converts <code><?= ( htmlentities('&lt;') )?? "" ?></code> and <code><?= ( htmlentities('&gt;') )?? "" ?></code> to 
                their respective equivalent angle brackets. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  to_lgts('< code >');<span class="comment"> // returns: <?= ( htmlentities('&lt;') )?? "" ?> code <?= ( htmlentities('&gt;') )?? "" ?> </span>

              </pre>

            </div>
            <!-- code line ended -->

          </div>      

          <!-- href -->
          <div id="href" class="href"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">9. href</div>
            </div> <br>
            
            <div>
                This function converts the urls in a text or string to clickable links using the url link itself.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  $text = href('url : http://www.site.com');
  
  echo($text);<span class="comment"> // url : &lt;a href="http://www.site.com"&gt http://www.site.com &lt;/a&gt;</span>
              </pre>

            </div>

            <div class="mvs-10 font-em-d8">
              A wrapper tag name can also be supplied for links
            </div>

            <div class="pre-area shadow">
              <pre class="pre-code">
  $text = href('url : http://www.site.com', 'span class="some_class"');
  
  echo($text);<span class="comment"> 
  
  <span class="c-teal no-select">// returns :</span>

  &lt;span class="some_class"&gt; 
    &lt;a href="http://www.site.com"&gt http://www.site.com &lt;/a&gt;
  &lt;/span&gt; 
                 </span>
              </pre>

            </div>
            
            <!-- code line ended -->
          </div>        

          <!-- scriptname -->
          <div id="scriptname" class="scriptname"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">10. scriptName</div>
            </div> <br>
            
            <div>
                This function returns the current script name
            </div>
          </div>    

          <!-- array_get -->
          <div id="striplastslash" class="striplastSlash"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">11. striplastSlash</div>
            </div> <br>
            
            <div>
                This function removes the last slash from a url. It works for both forward slashes and backslashes
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $stripped = striplastSlash('site.com/user/profile/')
      
  var_dump($stripped); <span class="comment">//returns : site.com/user/profile</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>    

          <!-- redirectto -->
          <div id="redirectto" class="redirectto"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">12. redirectTo</div>
            </div> <br>
            
            <div>
                same as php <code>header("location:")</code>
            </div>
          </div>      

          <!-- limittext -->
          <div id="limittext" class="limittext"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">13. limitText</div>
            </div> <br>
            
            <div>
                This limits the number of texts acceptable in a text string and appends an ellipses 
                to strings that have beyond the acceptable length of texts. It performs a simple 
                smart calculation on strings that may require ellipses and resolves to either add or
                ignore the ellipses.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  limitText('This is a string of not more than 10 texts', 7); 
  
  <span class="comment">//returns : This is a string of not more ...</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>      

          <!-- limitchars -->
          <div id="limitchars" class="limitchars"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">14. limitChars</div>
            </div> <br>
            
            <div>
                This limits the number of characters acceptable in a text string and appends an ellipses 
                to strings that have beyond the acceptable length of texts
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  limitText('This is a string of not more than 10 texts', 22);

  <span class="comment">//returns : This is a string of not...</span> 
              </pre>

            </div>
            <!-- code line ended -->

            <div class="font-menu mvt-6">In the example above, by calculation, <code>limitText</code> automatically detects to add the letter <code>t</code> to the 
            <code>no</code> to form <code>not</code>  before adding ellipses. At most times this behaviour is not predictable.</div>

          </div>  

          <!-- limitword -->
          <div id="limitword" class="limitword"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">15. limitWord</div>
            </div> <br>
            
            <div>
                This works similarly to limitText function but it is applied on the total number 
                of words required before an ellipses is added to a text.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  limitWord('This is a string of not more than 10 texts', 7);

  <span class="comment">//returns : This is a string of not more ...</span> 
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