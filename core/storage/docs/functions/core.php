

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
<body>

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
               <li> <a href="<?= DomUrl('docs/wmv') ?>" class="<?= inPath('active') ?>" ><span class="ico ico-spin"></span>The <span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions">Functions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions/core">Core</a>  </div>


        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions - Core</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper functions are predefined spoova functions that eases building 
                web applications. These functions are discussed below
                <br>
                
            </div> 
          </div> <br>
          
          <div id="webclass" class="webclass">
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                1. webClass
            </div>
            
            <div class="mvt-10">
              The framework's core classes are located in the <code>core/classes</code> 
              folder while the tools are located in the <code>core/tool</code> folder. The <code>webClass()</code> 
              and <code>webTool()</code> methods loads classes from their respective folders. 
              In the line below, both line 1 & 2 resolves to the same class folder while line 3 & 4 loads from the 
              tools folder.
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  <span class="comment">1.</span>$myclass = spoova\core\classes\myclass;

  <span class="comment">2.</span>$myclass = webClass('myclass');
              </pre>    
            </div>
          </div>

          <div id="webtool" class="webtool"><br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                2. webTool
            </div>
            
            <div class="mvt-10">
              Just like the <a href="<?= DomUrl('docs/functions/core#webclass') ?>">webClass</a>, the webTool loads its 
              classes from the <code>core/tools</code> folder.
            </div> <br>

            <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  <span class="comment">1.</span>$mytool = spoova\core\tools\myclass;

  <span class="comment">2.</span>$mytool = webTool('myclass');
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="isguest" class="isguest"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                3. isGuest
            </div>
            
            <div class="mvt-10">
            This function depends on the <code>User</code>  class. It returns a bool of true when a user is NOT logged in.
            </div>      
          </div>

          <div id="isuser" class="isuser"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                4. isUser
            </div>
            
            <div class="mvt-10">
            This function also depends on the <code>User</code>  class. It returns a bool of true when a user is logged in.
            </div>      
          </div>

          <div id="ishttp" class="ishttp"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                5. isHTTP
            </div>
            
            <div class="mvt-10">
            This function returns true if a protocol begins with <code>http://</code>.
            </div>
  <div class="pre-area">
    <pre class="pre-code">
  echo isHTTP('http://site.com'); <span class="comment">//returns: true</span>
    </pre>
  </div>      
          </div>

          <div id="ishttps" class="ishttps"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                6. isHTTPS
            </div>
            
            <div class="mvt-10">
            Similarly to <code>isHTTP</code>, it returns true if a url begins with <code>https://</code>.
            </div>      
          </div>

          <div id="isabsolutepath" class="isabsolutepath"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                7. isAbsolutePath
            </div>
            
            <div class="mvt-10">
            This returns true on absolute urls.
            </div>  
            <div class="pre-area">
  <pre class="pre-code">
  echo isAbsolutePath('folder/path/space'); <span class="comment">//returns: true</span>
  
  echo isAbsolutePath('http://site.com/folder/path/space'); <span class="comment">//returns: false</span>
  </pre>
            </div>    
          </div>

          <div id="invoked" class="invoked"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                8. invoked
            </div>
            
            <div class="mvt-10">
            The <code>invoked</code> is a case-sensitive function that is used to check if the current url matches the  
            supplied url within a windows url. Only absolute path from the window entry point 
            should be supplied. Since index pages can either be empty (i.e "") or "index", a frontslash ("/") can be used to denote 
            an index page.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( invoked('some/url') ){

     <span class="comment">// currently in url some url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="windowIncludes" class="windowincludes"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                8. windowIncludes
            </div>
            
            <div class="mvt-10">
            The <code>windowIncludes</code> is a case-sensitive function that is used to check if the current base url matches the  
            list of supplied urls. Since index pages can either be empty (i.e "") or "index", a frontslash ("/") can be used to denote 
            an index page.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( windowIncludes('some/url') ){

     <span class="comment">// currently in url some url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="windowExcludes" class="windowincludes"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                9. windowExcludes
            </div>
            
            <div class="mvt-10">
            This method is an inverse of <code>windowIncludes</code>. It is also a case-sensitive function and it returns true if the 
            current page url does not exist within the list of supplied urls.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( windowExcludes(['some/url']) ){

     <span class="comment">//... do this if current url is not in list of url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>



          <div id="authdirect" class="authDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                10. authDirect
            </div>
            
            <div class="mvt-10">
            The <code>authDirect</code> is used to redirect only an authenticate user to another page. 
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  authDirect('new_url');
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="guestdirect" class="guestDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                11. guestDirect
            </div>
            
            <div class="mvt-10">
            The <code>guestDirect</code> is used to redirect a user to another page only when logged out. 
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  guestDirect('new_url');
              </pre>
            </div>
            <!-- code line ended -->
          </div> 

          <div id="redirect" class="redirect"> <br> 
              <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                  12. redirect
              </div>
              
              <div class="mvt-10">
              The <code>redirect</code> function is the spoova internal way of 
              redirecting urls. Url's are redirected to pages based on the project root 
              folder. For example, if the project folder is <code>app</code>, the <code>redirect</code> 
              function begins its redirection in the project root. This means that the <code>app</code> 
              is not included as part of the url supplied.
              </div> <br>      
              <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  redirect('/') <span class="comment">// redirect to accessible site root</span>
  redirect('index') <span class="comment">// redirect index page inside accessible site root</span>
                </pre>
                </div>
              <!-- code line ended -->
          </div> 

          <!-- response -->
          <div id="response" class="response"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                13. response
            </div>
            
            <div class="mvt-10">
            The <code>response</code> function is an http_response_code driven json string 
            that is built for handling ajax responses. It takes an http response code as argument 
            and uses it to build a json response string. By default, all 4xx and 5xx response codes 
            when supplied as argument are considered as errors while other response codes are considered 
            as successes. This behaviour sets the json error key as true when any of the error codes are 
            supplied as argument. These can be overidden by supplying a third boolean argument that defines 
            the success status of the response. When error is set as true, success becomes false and vice versa.
            </div> <br>   

            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  response(200, 'successful') <span class="comment"> // {"success":true,"error":false,"message":"successful","response_code":200}</span>
  response(500, 'failed') <span class="comment">     // {"success":false,"error":true,"message":"failed","response_code":500} </span>

  response(500, 'some message', true) <span class="comment">// {"success":true,"error":false,"message":"some message","response_code":500} </span>
                </pre>
              </div>
            <!-- code line ended -->

            <div class="font-menu font-em-d85 mvt-10">
              In the examples above, the first two lines returns a json response based on the supplied 
              response code while the last code was overwritten be supplying a third argument 
              of true, inidicating a success.
            </div>
          </div>

          <!-- setvar -->
          <div id="setvar" class="setvar"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd rad-4 pxv-8">
              <div class="box-full">
                14. setVar
              </div> <br>
              <div class="pre-area">
                <pre class="pre-code" style="font-size:1.2em">
   setVar($main, $alternate, $replacement);
  
   <span class="comment">where:</span>

   <span class="c-green">$main : main test value
   $alternate : alternate value
   $replacement: boolean value to determine if main value is updated with alternate value</span>
                </pre>
              </div>
            </div> <br>
            
            <div class="mvt-10">
              The <code>setVar</code> is a complex function that is used to perform several functions which include <br>
              <br>

              <ul>
                <li>
                  initializes variables through reference.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment no-select pxv-10 bc-silver">Example 1 - Undefined variables</div>
                      <pre class="pre-code">

  setVar($new_variable);

  var_dump($new_variable); <span class="comment">// void</span>

                      </pre>
  <div class="comment no-select pxv-10 bc-silver"> Example 2 - Defined variables</div>
                      <pre class="pre-code">
  $val = 'foo';

  echo( setVar($val) ); <span class="comment">// foo</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li> <br>


                <li>
                  returns a custom defined variable for an undefined or empty variables.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment no-select pxv-10 bc-silver">Example 1 - Undefined variable alternate</div>
  <pre class="pre-code">
  echo ( setVar($old, 'alternate') ); <span class="comment">// alternate</span>
  </pre>
  
  <div class="comment no-select pxv-10 bc-silver">Example 2 - Defined variable ignores alternate</div>
  <pre class="pre-code">
  $old = 'main';
  $alt = 'alternate';

  echo ( setVar($old, $alt) ); <span class="comment">// main</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li> <br>

                <li>
                  updates or modifies a supplied empty variable with alternate value when 
                  the third argument is set as true.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment pxv-10 bc-silver">Example 1</div>
                      <pre class="pre-code">
  $alt = 'alternate';
  
  setVar($old, $alt, true);

  echo ( $old ); <span class="comment">// alternate</span>
                      </pre>
  <div class="comment pxv-10 bc-silver">Example 2</div>
                      <pre class="pre-code">
  $old = 'main';
  $alt = 'alternate';

  echo ( setVar($old, $alt, true) ); <span class="comment">// main</span>

  echo ( $old ); <span class="comment">// main</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li>

              </ul>

              <div class="font-menu font-em-d85">
                It should be noted that a alternate value is only activated when the main test variable is empty or undefined.
              </div>

            </div> 

          </div>

          <!-- vdump -->
          <div id="vdump" class="vdump"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                15. vdump
            </div>
            
            <div class="mvt-10">
            This function dumps the information of a value supplied while exiting the page.
            </div>    
          </div>        

          <div id="urlparams" class="urlparams"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                16. urlParams
            </div>
            
            <div class="mvt-10">
              It returns the parameters of a supplied url. If no argument is supplied, 
              it uses the current page url as default url.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  $params = urlParams('http://site.com/users?val=foo&var=bar');

  print_r($params); <span class="comment">// ['val'=>'foo', 'var'=> 'bar']</span>
                </pre>
              </div>
            <!-- code line ended -->
          </div>        
          
          <div id="url" class="url"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                17. url
            </div>
            
            <div class="mvt-10">
            The <code>url()</code> function is used to return the <code>Url</code> class. Url class is 
            used to manage urls. It takes only one argument which is used as the test url and returns the instance 
            of the Url class. You can learn more about url class from <a href="<?= DomUrl('docs/classes/url') ?>"><span class="c-olive hyperlink">here</span></a>
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  url('http://site.com/users#profile')->hash(); <span class="comment">// returns profile</span>
                </pre>
              </div>
            <!-- code line ended -->
          </div> <br>

          <!-- ROUTE FUNCTIONS -->
          <div class="font-em-1d1 c-orange">Route Functions</div>
          <div class="div">Route functions are function designed specifically to handle routing operations. These functions are <code>compile()</code> 
          and <code>view()</code>. </div>
          <!-------------------------------- compile -->
          <div id="compile" class="compile"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                18. compile
            </div>
            
            <div class="mvt-10">
              This funtion can only be used once within the <code>Router</code> class to compile and render 
              the contents of a page. It can only be used once within each route.
            </div> <br>    

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  Res::load('file', fn => compile());
              </pre>
            </div>
            <br><br>
            <!-- code line ended -->

            <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  class Home {
    
    function construct(){

      self::load('file', fn => compile());

    }

  }
                </pre>
              </div>   <br><br>
            <!-- code line ended -->

            <div class="font-menu font-em-d85">
              It should be noted that the first example above will work but the second example will not work.
              In order for example 2 to work, it must be extended to a windows file just as below:
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function construct(){

      self::load('file', fn => compile());

    }

  <span class="c-green">}</span>
              </pre>
            </div> <br><br>

            <div class="font-menu font-em-d85">
              Compile can accept globally and locally declared variables and in turn pass these variables 
              as local variable to rex template files. When global variables are injected locally, such variables will be accessible 
              within the global and local scopes. 
              Only arrays are accepted as arguments.
            </div> <br>

            <div class="pre-area"> 
              <div class="bc-silver pxv-6">Example 1 - Global variables injection</div>
              <pre class="pre-code">
  $var = ['name' => 'foo'];

  Res::load('index', fn => compile($var));
              </pre>
            </div> <br><br>

            <div class="pre-area"> 
              <div class="bc-silver pxv-6">Example 2 - Local variables injection</div>
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function construct(){

      $var = ['name' => 'foo', 'title' => 'bar'];

      self::load('file', fn => compile($var));

    }

  <span class="c-green">}</span>
              </pre>
            </div>   
          </div>


          <!-------------------------------- view -->
          <div id="view" class="view"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                19. view
            </div>
              
            <div class="mvt-10">
              This function can also be used within the router class. 
              Unlike the <code>compile()</code> method, the <code>view()</code> method can be applied more than once and can be 
              used to render more than one template engines.
            </div> <br> 

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  Res::load('file', fn => view('file'));
              </pre>
            </div>

            <br><br>
            <!-- code line ended -->

    
            <div class="font-menu font-em-d85">
              It should be noted that the first example above will work but the second example will not work.
              In order for example 2 to work, it must be extended to a controller or windows file just as below:
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function construct(){

      $file1 = view('file1');
      $file2 = view('file2');
      
      return $file1.$file2;

    }

  <span class="c-green">}</span>
              </pre>
            </div> 
          </div> <br>

          <div class="font-menu font-em-d85">
            Just like compile, <code>view</code> can accept globally and locally declared variables and in turn pass these variables 
            as local variable to rex template files. When global variables are injected locally, such variables will be accessible 
            within the global and local scopes. 
            Only arrays are accepted as arguments.
          </div> <br>

          <div class="pre-area"> 
            <div class="bc-silver pxv-6">Example 1 - Global variables injection</div>
            <pre class="pre-code">
  $var = ['name' => 'foo'];

  Res::load('index', fn => view('file', $var));
            </pre>
          </div> <br><br>

          <div class="pre-area"> 
            <div class="bc-silver pxv-6">Example 2 - Local variables injection</div>
            <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends window{</span> 
    
    function construct(){

      $args = ['name' => 'foo', 'title' => 'bar'];

      $view1 = view('file1', $args);
      $view2 = view('file2');

      $view = $view1.$view2;

      return self::load('file', fn => $view );

    }

  <span class="c-green">}</span>
            </pre>
          </div>  

          <div class="font-menu font-em-d85 mvt-6">
            In the example above, <code>file1</code> and <code>file2</code> 
            were rendered (viewed) and displayed on a template <code>file</code>. 
            The contents of the <code>file</code> itself is not rendered but <code>file</code>
            only serves as an anchor for the loaded files to be viewed. Variables are likewise passed 
            in an array (<code>$args</code>) as argument.
          </div> <br>
          
          
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions">Functions</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/functions/core">Core</a>  </div>

      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  
  

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>