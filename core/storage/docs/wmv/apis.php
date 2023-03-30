
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - WMV Routes</title>
    
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/js/jquery/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/local/core.js'></script><script src='http://localhost/spoova/res/main/js/local/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/local/jqmodex.js'></script><script src='http://localhost/spoova/res/main/js/local/device.js'></script><script src='http://localhost/spoova/res/main/js/local/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/local/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/local/helper.js'></script><script src='http://localhost/spoova/res/main/js/local/init.js'></script> 
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

    <section class="">
        <div class="control font-em-2 fixed c-orange box">
            <div class="flex px-40 mid rad-r shadow anc-btn-link bc-white">
                <span class="bi-list controller flex"></span>
            </div>
        </div>
         

<!-- @lay('build.co.coords:header') -->

 

     

     <nav class="nav-left fixed">

          <div class="flex pxv-10">
               <div class="flex-icon theme-btn navtheme box bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
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

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv">Wmv</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/wmv/apis">APIs</a>  </div>


                <div class="start font-em-d8">


                    <div class="font-em-1d5 c-orange">Handling APIs</div> <br>  
                    
                    <div class="setters-intro">
                        <div class="fb-6 mvb-6">Introduction</div>
                        <div class="">
                           In spoova, APIs are window routes that are declared as api channel. Since web urls are resolved using 
                           window route classes, APIs are routes specifically declared as API through a top level API integration. This means that they 
                           can inherit all the properties and functionalities of a normal route. A route can be declared as API by either calling the  
                           <code>integrateAPI()</code> method or by declaring the <code>$winAPI</code> static property using specifically designed options. 
                           When a route is declared as API, the effect is usually being felt by the 
                           route <a href="<?= DomUrl('docs/wmv/calls') ?>">shutter</a> methods which have the internal capacity 
                           to naturally determine the response of any window url or web page. Shutter methods which are
                           <code>call()</code>, <code>rootcall()</code>, <code>basecall()</code> and <code>pathcall()</code> 
                           methods are designed to detect the response of a route whether it is a normal webpage or an <code>API</code> 
                           route. 
                            <p>
                                <div class="c-orange mvb-6">API Integeration</div>
                                The figure below explains how to integerate an API with any window page <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Syntax: integerateAPI</div>
                                    <pre class="pre-code">
  Window::integerateAPI($type)  
  <span class="comment">
    where: 

     $type : [ajax|json|ajax:json|json:ajax]
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>type</code> above defines how a window responds to its shutter methods
                                    while the <code>integerateAPI()</code> method defines that the window should respond 
                                    as an api route.
                                </div><br>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example: integerateAPI</div>
                                    <pre class="pre-code">
  <span class="comment">...</span>
  
  class HomeAPI {

    function __construct() {

        self::integerateAPI('ajax');

    }

  }
                                    </pre>
                                </div>
                                <div class="foot-note pvs-10">
                                    The example above is a format of how to set up an api window url by using the <code>self::integerateAPI()</code> method.
                                    This method must be called prior to the use of shutter methods. There are 
                                    three different response types which are <code>ajax</code>, 
                                    <code>json</code> and <code>ajax:json</code> or <code>json:ajax</code>.  The behavioral pattern 
                                    or how these types respond to shutter methods are further explained below under their own subheadings.
                                </div>
<!-- code ends -->
                            </p>

                            <p>
                                <div class="c-orange">AJAX Response Type</div>
                                Whenever the <code>integerateAPI()</code> is set as <code>ajax</code>, if a url does not exist, rather than return a 
                                404 request page, the shutters will automatically switch to a json format 404 response type using the format below:  
<!-- code begins -->
                                    <div class="pre-area shadow mvt-6">
                                        <div class="pxv-6 bc-silver">Invalid url response on integerateAPI('ajax')</div>
    <pre class="pre-code">
  {
    "success":false,

    "error":true,

    "message":"Page not found!",

    "response_code":404
  }
    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>integerateAPI('ajax')</code> does not really check if the response of any window 
                                    content matches a json format. It only believes that if an error occurs, then a json format should 
                                    be returned as a response, since api is only integerated with a window file.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">JSON Respose Type</div>
                                    When <code>integrateAPI()</code> is set as <code>json</code>, this will declare that the content of a page should be of json format. This 
                                    follows a strict content-type for any window api. If the content-type is not of a valid <code>json</code> content type, 
                                    the response returned will be json SyntaxError notifying that the content cannot be parsed as revealed in the figure below: 
<!-- figure begins -->
                                <div id="figure1" class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 1: Json Parse Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="http://localhost/spoova/res/main/images/json-parse-error.png"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>FIGURE 1</code> above is an example of a response returned by an api json-integerated window if the response type is not of valid json
                                    format.
                                </div>
<!-- code description ends -->

<!-- figure begins -->
                                <div id="figure2" class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 2: Json 404 Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="http://localhost/spoova/res/main/images/json-404.png"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>FIGURE 2</code> above is an example of a response returned by an api json-integerated window if url is not valid or the method does not exist.
                                </div>
<!-- code description ends -->


                            </p>

                            <p>
                                <div class="c-orange">AJAX:JSON Response Type</div>
                                The <code>ajax:json</code> or <code>json:ajax</code> response type is more of a true request validation type on json content-type. When <code>integerateAPI('ajax:json')</code> 
                                is set on any window, the content type of that window must be a json format just like <code>integerateAPI('json')</code>. Secondly, the request type must also be through an ajax 
                                request type. The validation execution order will return a <code>401</code> request if the request is not sent through ajax first. However, if the request is sent through ajax, 
                                then the validation will go on to check if the content type is of json format also. The figure below shows the response returned if the requested page is loaded directly and not 
                                through ajax request. <br>
<!-- figure begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 2: Json 404 Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="http://localhost/spoova/res/main/images/ajax-invalid-request.png"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The example above best reveals an error response obtained when an <code>integerateAPI('json:ajax')</code> is loaded directly.
                                </div>
<!-- code description ends -->

                            </p>

                            <p>
                                <div class="c-orange">Modifying Responses</div>
                                <p>
                                    The <code>integerateAPI()</code> method supports more than one argument. There are certain cases developers may want to modify 
                                    the <code>"invalid request"</code> response 
                                    message of the <code>json:ajax</code> api. This can be supplied through a second argument 
                                    (i.e <code>integrateAPI('ajax:json', 'invalid request protocol')</code>). The response default error code <code>"401"</code> can also 
                                    be modified through a third argument. For example : <code>integrateAPI('ajax:json', 'invalid request protocol', 402)</code>. 
                                    It is important to learn and have a good understanding of the <code>Ajax</code> class from <a href="<?= DomUrl('docs/classes/ajax') ?>">here</a>. 
                                </p>
                                <p>
                                    Whenever a page 
                                    returns 404, the <code>integerateAPI</code> will always return a response shown in <a href="#figure1"><span class="c-brown-ll bold hyperlink">Figure 1</span></a> earlier
                                    . There are other means to set up api routes without using shutter. This process involves the use of <code>Ajax</code> class and <code>response()</code> function to validate route responses. 
                                    The example below best explains this process.
                                </p>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example: Custom APIs</div>
                                    <pre class="pre-code">
  class APIs {

    function __construct(){

        self::integerateAPI('ajax'); <span class="comment">// set an ajax channel</span>

        Ajax::accept('post'); <span class="comment">// accept only post requests </span>
        
        Ajax::accept('post')->referred(); <span class="comment">// accept only posts requests and it must be referred</span>
        
        Ajax::with('json')->referred(); <span class="comment">// accept only posts requests and it must referred with response returned in json format </span>
        
        Ajax::accept(['post','get'])->with('json')->referred(); <span class="comment">// accept only posts and get requests and it must referred and returned value must be of json format</span>
        
        if(Ajax::isAjax()){

            <span class="comment">//If this request is an Ajax request, run this block code</span>

            return response(404, 'message here');

        } else {

            <span class="comment">//If this request is not an Ajax, run this block code</span>

            return response(404, 'message here');         

        }


    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The example above shows different methods of setting an api route. We suggest to visit the <a href="<?= DomUrl('docs/classes/ajax') ?>">ajax documentation</a> 
                                    to understand how the <code>Ajax</code> class works. The window pattern is structurally designed in a way that api can 
                                    be built on urls whose parent url are not of ajax or json types. An example below shows how this can be achieved.
                                </div> <br>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example 2: Building API on routes</div>
                                    <pre class="pre-code">
  class Home {

    function __construct(){

        self::call(
            [
                window(':') => 'root',    
                window(':user') => 'user',    
                window(':user.apiOne') => 'apiOne',    
                window(':user.apiTwo') => 'apiTwo',    
            ]
        );

    }


    fuction root() {

        <span class="comment">//This is the home url</span>
        self::load('some-file', fn() => compile());

    }


    <span class="comment">/**
     * This is home/user/apiOne
     */</span>
    fuction apiOne() {
        
        self::integrateAPI('ajax'); <span class="comment">//response should be json format for shutters</span>

        self::call([
        
            window('base:') => 'win:Routes\API\APIHandler';
            
        ]);

    }


    <span class="comment">/**
     * This is home/user/apiTwo
     */</span>
    fuction apiTwo() {

        Ajax::isAjax(':json'); <span class="comment">//set Content-Type as application/json</span>

        if(!Ajax::isAjax()){

            <span class="comment">//run this is if request is NOT ajax request</span>

            $response = ['message'=>'invalid request protocol', 'code' => 401];

            echo json_encode($response);

            return;

        } else {

            <span class="comment">//run this is if request is ajax request</span>

            if(routeExists('API\APIHandler')) {

                new API\APIHander();

            } else {

                $response = ['message'=>'api not found', 'code' => 404];

                echo json_encode($response);

                return;
                
            }

        }

    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="foot-note mvt-6">
                                    <p>
                                        If the <code>home</code> url is visited, then the method <code>root()</code>
                                        is called. When the <code>home/user</code> is visited, the <code>user()</code> method is called.
                                        When the <code>home/user/apiOne</code> is visited, the method <code>apiOne()</code> is called. 
                                        Each url visited calls their corresponding methods on the Home class. This means that, according to the 
                                        <code>code</code> above, the <code>Home</code> class is the urls entry point. While <code>root()</code> 
                                        may load its file as a web page, the <code>apiOne</code> is managed by the <code>integerateAPI()</code>
                                        method along with the <code>call()</code> shutter. In <code>apiTwo</code> however, the entire logic is handled 
                                        with the <code>Ajax</code> class and this is done through series of testing conditions. It can be easily noticed 
                                        that it is much easier to implement <code>integerateAPI()</code> than testing with <code>Ajax</code> class. However, 
                                        when we need to handle custom requests, then using the <code>Ajax</code> class is the best solution. 
                                    </p>

                                    <p>
                                        Previously defined examples have shown that the <code>integerateAPI()</code> method can be used to define a route type.
                                        This method can also be defined at top level by setting the static property <code>$winAPI</code> to any valid option accepted by 
                                        <code>integerateAPI()</code> method. If the property is set, the window will use that value to set shutter responses. Example 
                                        of this is shown below:
                                    </p>
                                    
                                </div>
<!-- code description ends -->
<!-- code begins -->
<div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example 2: Building API on routes</div>
                                    <pre class="pre-code">
  class Home {

    static $winAPI  = 'json:ajax';

    function __construct(){

        self::call(
            [
                window(':') => 'root',    
                window(':user') => 'user',       
            ]
        );

    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    <p>
                                        In the code above, the <code>call()</code> method will respond as if the <code>integrateAPI('json:ajax')</code> was called 
                                        on it.
                                    </p>
                                </div>
<!-- code description ends -->                            
                            </p>
                        </div>
                    </div>

                </div>


            </div>

        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>