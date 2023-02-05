

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



    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/setters">Setters</a>  </div>


                <div class="start font-em-d8">


                    <div class="font-em-1d5 c-orange">Setters and Getters</div> <br>  
                    
                    <div class="setters-intro">
                        <div class="fb-6">Introduction</div>
                        <div class="">
                            Setter is special top level class that is capable of manipulating or protecting defined values across the web application. 
                            This system can be used within the web application to store and even protect values which must not be tampered with unless 
                            certain strict conditions are met. It also prevents the use of modifiable php variables and keeps defined values in their own specific 
                            division, away from being updated without real known intent.
                            The setter system (or class) involves three specific methods <code>SET()</code>, <code>GET()</code>
                            and <code>MOD()</code> which are applied synergetically. This means that for any defined value to be 
                            properly managed, there has to be a top level to down level relationship between values. Values that are defined at top level can then be 
                            handled or managed in a manner desired by the developer. This system can be mostly used to keep track of specific value properties. For example, 
                            while php variables may be updated as desired along the code, setter values can be prevented from being updated at a low level if certain conditions are not met.

                            <p>
                                <div class="c-orange">Defining Values</div>
                                In order to define a new value, the <code>SET()</code> method has to be called at the top level. This method takes two arguments. The syntax is shown below: <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::SET()</div>
                                    <pre class="pre-code">
  SETTER::SET(KEY, VALUE, SECURE)  
  <span class="comment">
    where: 

     KEY : Protected Key
     VALUE : Key's value
     SECURE : secure hash/string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) that needs to be protected while the <code>VALUE</code> is the 
                                    content of that <code>KEY</code>. The <code>SECURE</code> defines the security level of the <code>KEY</code>. If <code>SECURE</code> 
                                    is set as <code>TRUE</code>, then the <code>KEY</code> defined cannot be updated or modified after it has been defined. 
                                    This turns the <code>KEY</code> to a read-only key. Any attempt to use <code>SETTER::MOD()</code> to modify the key's value, 
                                    an error will be thrown preventing such activity. However, if the <code>SECURE</code> value is a non-empty string, then it is assumed to be 
                                    a secure hash string. Whenever secure hash strings are used, then such hash must be provided by the <code>SETTER::MOD()</code> in order 
                                    for the value to be updated. If the <code>MOD()</code> (i.e modifier) hash does not match the one used to secure the <code>KEY</code>, 
                                    then an error is thrown. Also, whenever a new value is defined, it cannot be redefined using <code>SETTER::SET()</code> again. 
                                    Instead, the <code>SETTER::MOD()</code> must be called.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Modifiying Key's Value</div>

                                    <div class="pvs-10">
                                        In other to modify any key, the <code>SETTER::MOD()</code> method has to be called. 
                                        If this method is called before a value is set, an error will be thrown. 
                                        It takes three argument and the syntax is shown below: <br>
                                    </div>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::MOD()</div>
                                    <pre class="pre-code">
  SETTER::MOD(KEY, VALUE, HASH)  
  <span class="comment">
    where: 

     KEY : Protected Key
     VALUE : Key's new value
     HASH : secure hash string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) that needs to be modified or updated while the <code>VALUE</code> is the 
                                    new content of that <code>KEY</code>. The <code>HASH</code> defines the secure hash string used to set the key, if defined. 
                                    This means that whenever secure hash strings are used to lock a value when defined using <code>SETTER::SET()</code>, then such 
                                    hash must be provided by the <code>SETTER::MOD()</code> in order 
                                    for the value to be updated. If the <code>MOD()</code> (i.e modifier) hash does not match the one used to secure the <code>KEY</code>, 
                                    then an error is thrown.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Getting Defined Key's Value</div>

                                    <div class="pvs-10">
                                        In other to fetch any defined key, the <code>SETTER::GET()</code> method has to be called. 
                                        If this method is called before a value is set, an error will be thrown. 
                                        This method takes two argument. The syntax is shown below: <br>
                                    </div>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::GET()</div>
                                    <pre class="pre-code">
  SETTER::GET(KEY, HASH)  
  <span class="comment">
    where: 

     KEY : Protected Key
     HASH : secure hash string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) whose value needs to be fetched. Whenever a key is secured with an hash, then the 
                                    <code>HASH</code> string must be provided before the value of that key can be obtained. If the value of the <code>HASH</code> does not match, 
                                    an error is thrown. Also, if a KEY is not secured in <code>SET()</code> but <code>HASH</code> was provided in <code>GET()</code>, although the value 
                                    will be returned, an error will still be triggered discouraging such activity. 
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Detecting if a key exists</div>
                                In other to prevent errors which may occur from <code>SETTER::SET()</code> if the key has already been defined, we have to check if a key already exists 
                                by using the method <code>SETTER::EXIST()</code>. This will only return true if a key already exists. The usage is shown below: <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Usage: SETTER::EXIST()</div>
                                    <pre class="pre-code">

  if( !SETTER::EXISTS('key') ) {

    SETTER::SET('key', 'value');

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The code above will only set the key if it does not already exist. 
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Helper Functions</div>
                                There are two provided helper functions for running the Setter system. These functions are <code>SET()</code> and <code>GET()</code> functions. Although, we don't have 
                                any <code>MOD()</code> helper function, the <code>SET()</code> function is build to handle updates in the manner <code>SETTER::MOD()</code> will handle it. The <code>SET()</code>
                                function naturally checks if a varible is updateable or not previously set before setting them and it takes the same parameter as the <code>SETTER::SET()</code> or <code>SETTER::MOD()</code> 
                                methods. This obviously save more time. The <code>GET()</code> method obtains the value of a previously defined key. <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Example: SET and GET</div>
                                    <pre class="pre-code">
  SET('NAME 1', 'Felix');  
  SET('NAME 2', 'Rolland', true);  
  SET('NAME 3', 'Charley', 'hash123');  

  <span class="c-green-l">GET('NAME 1')</span> <span class="comment">// returns Felix</span>
  <span class="c-orange-dd">GET('NAME 1', 'hash234')</span> <span class="comment">// returns Felix, but triggers error</span>

  <span class="c-green-l">GET('NAME 2')</span> <span class="comment">// returns Felix</span>
  <span class="c-orange-dd">GET('NAME 2', 'hash234')</span> <span class="comment">// returns Felix, but triggers error</span>

  <span class="c-red-dd">GET('NAME 3')</span> <span class="comment">// invalid hash triggers error</span>
  <span class="c-green-l">GET('NAME 3', 'hash123')</span> <span class="comment">// returns Felix</span>
  <span class="c-red-dd">GET('NAME 3', 'hash234')</span> <span class="comment">// invalid hash triggers error </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-8">
                                    The example above best explains how the <code>SET</code> and <code>GET</code> functions work while the example below 
                                    explains how modifications work.
                                </div>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Example 2: Modifying values</div>
                                    <pre class="pre-code">
  SET('NAME 1', 'Felix');  
  SET('NAME 2', 'Rolland', true);  
  SET('NAME 3', 'Charley', 'hash123');  

  <span class="c-green-l">SET('NAME 1', 'New Felix')</span> <span class="comment">// allowed</span>

  <span class="c-red-dd">SET('NAME 2', 'New Rolland')</span> <span class="comment">// denied (read-only)</span>

  <span class="c-green-l">SET('NAME 3', 'New Charley', 'hash123')</span> <span class="comment">// allowed (valid hash)</span>
  <span class="c-red-dd">SET('NAME 3')</span> <span class="comment">// denied (invalid hash)</span>
  <span class="c-red-dd">SET('NAME 3', 'hash234')</span> <span class="comment">// denied (invalid hash) </span>
                                    </pre>
                                </div>
<!-- code ends -->

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