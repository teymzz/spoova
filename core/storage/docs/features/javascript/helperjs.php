
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
          font-family: Roboto;
     }

     .tutorial{
          min-height:100vh;
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
          font-family: firacode;
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
    color: rgb(125, 125, 125);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
}

body.--theme-dark .bc-blue.c-white{
    background-color : rgb(35, 25, 66);;
    box-shadow: none;
    color: #8c8cb5;
    margin-bottom: 8px;
}

body.--theme-dark .nav-left ul a{
    color: rgb(129, 125, 120);
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

.animated-header .ico-spin{
    background-image: url("<?= Rexit::mapp('images/icons/favicon.png') ?>");
}

body.--theme-dark .animated-header .ico-spin{
    background-image: url("<?= Rexit::mapp('images/icons/favicon-white.png') ?>");
}
body.--theme-dark .animated-header .c-blue-dd{
    color:white;
}
 </style>
<style rel="build.css.navbars"> 

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
    <!-- @live -->
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
         

<!-- @lay('build.co.coords:header') -->
<?= Res::live() ?>
 

     

     <nav class="nav-left fixed">

          <div class="flex pxv-10">
               <div class="flex-icon theme-btn navtheme bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin" data-src="<?= Rexit::mapp('images/icons/favicon.png') ?>" style="transition: none;"></div>
                    <div class="font-em-1d2 px-40 flex mid overlay fb-2 fira" style="top:-1.1px; left:.4px; z-index: 1; color:#202dd5;">
                         s 
                    </div>
               </div>
               <a href="<?= Rexit::domurl() ?>" class="flex">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2" style="color: #202dd5">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square">
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



<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

          <div class="start font-em-d8">
          
                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                <div class="font-em-1d5 c-orange">Javascript Helper Functions</div>
                
                <div class="db-connection"> <br>
                  
                    The <code>helper.js</code> file contains custom helper functions few of which are jquery dependent. 
                    There are several lists of javascript core helper functions. Some of these functions are jquery dependent and can be identified by a red asterik (<span class="c-red">*</span>) before them. These functions are listed below 
                    <br><br>
                    
                    <ul class="mvt-6 c-olive">
                        <li><a href="#initfunc" data-scroll-hash="initfunc">initFunc</a></li>
                        <li><a href="#loadfuncs" data-scroll-hash="loadfuncs">loadFuncs</a></li>
                        <li><a href="#callfunc" data-scroll-hash="callfunc">callFunc</a></li>
                        <li><a href="#supercall" data-scroll-hash="supercall">superCall</a></li>
                        <li><a href="#inrange" data-scroll-hash="inrange">inRange</a></li>
                        <li><a href="#isjson" data-scroll-hash="isjson">isJSON</a></li>
                        <li><a href="#getdate" data-scroll-hash="getdate">getDate</a></li>
                        <li><a href="#hashrunner" data-scroll-hash="hashrunner">hashRunner</a></li>
                        <li><a href="#hasattr" data-scroll-hash="hasattr">hasAttr</a></li>
                        <li><a href="#rdpage" data-scroll-hash="rdpage">rdPage</a></li>
                        <li><a href="#urlenv" data-scroll-hash="urlenv">urlenv</a></li>
                        <li><a href="#ajaxuri" data-scroll-hash="ajaxuri"><span class="c-red"></span>ajaxUri</a></li>
                        <li><a href="#ajaxresponder" data-scroll-hash="ajaxresponder">ajaxResponder</a></li>
                        <li><a href="#datascroll" data-scroll-hash="datascroll"><span class="c-red">*</span>dataScroll</a></li>
                        <li><a href="#datascrollhash" data-scroll-hash="datascrollhash"><span class="c-red">*</span>dataScrollHash</a></li>
                    </ul>
                </div> <br>
                
                <!-- init funcs -->
                <div id="initfunc">
                    <div class="font-em-1 c-orange">initFunc</div>
                    <div class="mvs-10">
                      This is part of the core web application. It is used for instantiating an already defined function. If a supplied function name 
                      does not exist, then the function will not be called.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax: initFunc</div>
    <pre class="pre-code">
  initFunc(['func_name', param, param,...]);
  <span class="comment">
    where:
      
      func_name : function name 
      param     : function arguments
  </span>
    </pre>
</div> 
                </div> <br>
                
                <!-- load funcs -->
                <div id="loadfuncs">
                    <div class="font-em-1 c-orange">loadFuncs</div>
                    <div class="mvs-10">
                      This is part of the core web application. It is used for instantiating already defined functions.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: loadFunc - loading multiple functions without argument</div>
    <pre class="pre-code">
  loadFuncs([func_1, func_2]); 
  <span class="comment">
    where:
      
      func_1 : function name
      func_2 : function name
  </span>
    </pre>
</div> 

<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 2: loadFunc - loading multiple functions with or without their arguments</div>
    <pre class="pre-code">
  loadFuncs([[func_1, arg], func_2]); 
  <span class="comment">
    where:
      
      [func_1, arg] : array of function name with argument 
      func_2        : function name without arguments
  </span>
    </pre>
</div> 
                </div> <br>   

                <!-- callFunc -->
                <div id="callfunc">
                    <div class="font-em-1 c-orange">callFunc</div>
                    <div class="mvs-10">
                      This is part of the core web application. It is used for instantiating already defined function with delay timeout before function is called
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
  callFunc(callback, timeout); 
  <span class="comment">
   where:
      
    callback  : callback function name or array of function name and its arguments 
    timeout   : delay time before function is executed
  </span>
    </pre>
</div> 

<!-- code begins -->
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example : callFunc</div>
    <pre class="pre-code">
  <span class="c-olive">&lt;script&gt;

    function myFunction(arg) {

        if(arg === 'hi'){ 
            alert('hi') ;
        }

    }

    callFunc(['myFunction', 'hi'], 1000 );

  &lt;/script&gt;
  </span>
</pre>
<div class="c-white no-select pxv-10 bc-sea-blue">Desc: <span class="i">The code above will call "myFunction" after 1 minute of delay time</span></div>
</div> 
                </div> <br>
                
                <!-- supercall -->
                <div id="supercall">
                    <div class="font-em-1 c-orange">superCall</div>
                    <div class="mvs-10">
                      This function performs a global scope event calling. 
                      Works with dynamically generated elements
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: superCall</div>
    <pre class="pre-code">
    superCall(event, selector, callback); 
  <span class="comment">
    where:
      
      event    : eventListener
      selector : element selector
      callback : callback function
  </span>
    </pre>
</div> 

<!-- code begins -->
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example : superCall</div>
    <pre class="pre-code">
  <span class="comment no-select">Test HTML:</span>
  &lt;div id="somediv"&gt;&lt;/div&gt;

  <span class="c-olive">
  &lt;script&gt;

    superCall('click','#somediv', function() { alert() } );

  &lt;/script&gt;
  </span>
</pre>
<div class="c-white no-select pxv-10 bc-sea-blue">Desc: <span class="i">The superCall above will call the "click" eventListener on a global scope</span></div>
</div> 
<!-- code ends -->
                </div> <br>

                <!-- inRange -->
                <div id="inrange">
                    <div class="font-em-1 c-orange">inRange</div>
                    <div class="mvs-10">
                      This function checks if a value is within the range of two values. It returns true if the test integer is within the 
                      range.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: inRange</div>
    <pre class="pre-code">
    inRange(integer, min, max); 
  <span class="comment">
    where:
      
      integer : test integer 
      min     : minimum range
      max     : maxumim range
  </span>
    </pre>
</div> 
                </div> <br> 
                
                <!-- callFunc -->
                <div id="isjson">
                    <div class="font-em-1 c-orange">isJSON</div>
                    <div class="mvs-10">
                      This function is used to check if a string is of json type. It returns a boolean of true if test string is of valid json format
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax: isJSON</div>
    <pre class="pre-code">
  isJSON(string); 
  <span class="comment">
    where:
      
      string : test string
  </span>
    </pre>
</div> 
                </div> <br>
               
                <!-- getDate -->
                <div id="getdate">
                    <div class="font-em-1 c-orange">getDate</div>
                    <div class="mvs-10">
                      This function is built upon the javascript <code>Date</code> object.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
    getDate(string); 
  <span class="comment">
    where string:
      
      ref   : return the Date Object Instance
      year  : return Date.getFullYear()
      month : return Date.getMonth()
      day   : return Date.getDay()
      date  : return Date.getDate()
      hour  : return Date.getHours()
      min   : return Date.getMinutes()
      sec   : return Date.getSeconds()
      milli : return Date.getMilliSeconds()
      full  : return full date
  </span>
    </pre>
</div> 
                </div> <br>  

                <!-- hashRunner -->
                <div id="hashrunner">
                    <div class="font-em-1 c-orange">hashRunner</div>
                    <div class="mvs-10">
                      This function works as a page url hash controller.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: hashRunner</div>
    <pre class="pre-code">
    hashRunner(option); 
  <span class="comment">
    where:
      
      option ":get"    : get the current hash in page url
      option "id"      : click the element having the relative id of the hash name in current page url
      option "class"   : click the element having the relative id of the hash name in current page url
      option "data-id" : click any element having the attibute of data-id with the value of the hash in current page url
  </span>
    </pre>
</div> 
                </div> <br>    

                <!-- hasAttr -->
                <div id="hasattr">
                    <div class="font-em-1 c-orange">hasAttr</div>
                    <div class="mvs-10">
                      This function checks if an element has an attribute.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: hasAttr</div>
    <pre class="pre-code">
    hasAttr(elem, attr); 
  <span class="comment">
    where:
      
      elem : element selector
      attr : name of attribute to be checked
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- rdPage -->
                <div id="rdpage">
                    <div class="font-em-1 c-orange">rdPage</div>
                    <div class="mvs-10">
                      This function redirects a page to another page. It can be used within html "onClick" attribute
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Sample: rdPage</div>
    <pre class="pre-code">
    rdPage('some/url'); <span class="comment">// redirects page to "some/user"</span> 
    </pre>
</div> 
                </div> <br>
                <!-- urlenv -->
                <div id="urlenv">
                    <div class="font-em-1 c-orange">urlenv</div>
                    <div class="mvs-10">
                      This function is used  within ajaxUri() function to map urls. It helps to reformats url to strings 
                      by removing extensions or mapping empty strings to current domain url. 
                    </div>
                    <div class="pre-area">
                      <div class="pxv-10 bc-silver">Sample: urlenv</div>
                      <pre class="pre-code">
  console.log( urlenv('site/user') ); <span class="comment">//http://some_domain/site/user</span>
                      </pre>
                    </div>
                </div> <br>
                
               
                <!-- ajaxUri -->
                <div id="ajaxuri">
                    <div class="font-em-1 c-orange">ajaxUri</div>
                    <div class="mvs-10">
                      This function uses the <code>urlenv()</code> function to reformat an absolute url to an http protocol.
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example: ajaxUri</div>
    <pre class="pre-code">
  <span class="c-olive">
    $.ajax({

        method: 'post',
        url: ajaxUri('some/url/link'), <span class="comment">// http://current_domain/some/url/link </span>
        contentType: 'json',
        complete(): function() {

            <span class="comment">// request completed!</span>

        }

    })
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- ajaxResponder -->
                <div id="ajaxresponder">
                    <div class="font-em-1 c-orange">ajaxResponder</div> 
                    <div class="mvs-10">
                      AjaxResponder was built to manage xmlHttpRequest response of an ajax request. If the html response is a json format, it tries to parse the response text before 
                      storing it in an object with key name "message" where it can be accessed. However, if the response text is not a json format, the response will 
                      be stored as a text under the same key. This function suggests that every response should be of json format. If the response status is 200 and 
                      response is of a json format, an object key of <code>type: 200</code> is added to the returned data. Hoewever, if the response is not of json format, 
                      even if the response status is 200, the key <code>type:</code> will be set as <code>response</code> instead of 200. The data returned parsed or unparsed 
                      can be obtained under the object key <code>"message"</code>. The example below reveals how to use this function within a Jquery ajax <code>complete()</code> method.
                    </div>
                    
                    <div class="pre-area">
                      <div class="pxv-10 bc-silver">Sample 1a: ajaxResponder - Response Format</div>
    <pre class="pre-code">
    <span class="comment">
    Example format returned if is Json Format:
      
     <span class="c-orange-dd">{ "success": "true", "type": "200", "message": parsed_responseText }</span>


    Example format returned if is NOT Json Format:
      
     <span class="c-orange-dd">{ "error": "parse error", "type": "response", "message":responseText }</span>
    </span>
    </pre>
                  </div> 
                    
                  <div class="pre-area">
                      <div class="pxv-10 bc-silver">Syntax 1b: ajaxResponder - Usage Format</div>
    <pre class="pre-code">
      <span class="c-olive">
    $.ajax({

        method: 'post',
        url: ajaxUri('some/url/link'), <span class="comment">// http://current_domain/some/url/link </span>
        contentType: 'json',
        complete(): function(response) {

            response = ajaxResponder(response);

            if(response.success) {

              console.log(response.message); <span class="comment">// json parsed responseText</span>

            } else if(response.error) {

              console.log(response.message); <span class="comment">// unparsed responseText</span>              

            }

        }

    })
      </span>
    </pre>
                  </div> 


                </div> <br>
 


                <!-- dataScroll -->
                <div id="datascroll">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>dataScroll</div>
                    <div class="mvs-10">
                      This function helps to scroll to a particular point on the web page using data-scroll attribute
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
    <span class="comment">Test: HTML</span>
    &lt;a data-scroll="elementid" data-minus="" data-plus=""&gt;&lt;/a&gt;
  <span class="comment">
    where:
      
      elementid  : the id of the element to be scrolled to
      data-minus : subtracts from the expected element position (in pixels) 
      data-plus  : adds to the expected element position (in pixels) 
      data-delay : add timeout delay before scroll is executed (in seconds)
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- dataScrollHash -->
                <div id="datascrollhash">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>dataScrollHash</div>
                    <div class="mvs-10">
                      This function is used to scroll to the last url's hash. It also performs the function of <code>dataScroll()</code>
                    </div>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: dataScrollHash</div>
    <pre class="pre-code">
    <span class="comment">Test URL:</span>
    https://some-site.com#someid

    <span class="comment">Test HTML:</span>
    <span class="c-olive">&lt;div id="someid" data-minus="10"&gt;&lt;/div&gt; 


    <span class="comment">Test Script:</span>

    &lt;script&gt; 

        dataScrollHash('someid');

    &lt;/script&gt; 
    </span>
</pre>
    <div class="pxv-10 bc-sea-blue c-white">
    In the above, when the page url is visited, the <code class="c-white">dataScrollHash()</code> function will scroll to the div with the supplied id. 
    The <code><span class="c-white">data-minus</span></code>, <code class="c-white">data-plus</code> and <code class="c-white">data-delay</code> 
    can also be applied on the div element just like the <code class="c-white">dataScroll()</code> 
    function. The <code class="c-white">data-delay</code> will subtract from the current element position by 10 pixels. This function can also be applied 
    on element using html event listener attributes. In some cases, the <code class="c-white">"window.onload"</code> 
    event listener or <code class="c-white">"setTimeout"</code> 
    may be needed to delay the execution before it can effectively work.
    </div>
</div> 
                </div> <br> 
                
                <div class="font-em-d8">
 The <code>dataScrollHash</code> function has been reserved an attribute <code>"data-scroll-hash"</code>. When the attribute is added to any element, it adds an <code>"onclick"</code> 
 event on that element. Once the element is clicked, the <code>data-scroll-hash</code> will search for the current page's url hash name. Once the hash string is obtained, 
 the page will try to scroll to any element having an id attribute value that matches the hash string. This is further discussed under integerated features.
                </div>

            </div>

        </div>
    </section>

    <script>
        hashRunner('data-scroll-hash');
    </script>
</div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>