<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - WMV Middlewares</title>
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
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/wmv">Wmv</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/wmv/middlewares">Middlewares</a>  </div>


                <div class="start font-em-d85">

                    <div class="font-em-1d5 c-orange">Middlewares</div> <br>  
        
                    <div class="shutters-intro">
                        
                        <div class="font-em-d87">
                           Middlewares are activities that must run before a class or method is called. 
                           They are mostly executed through class methods. Their activity can affect the performace of 
                           window files. While middlewares can be applied to shutters from the <code>super()</code> method of
                           <a href="<?= DomUrl('docs/wmv/frames') ?>" class="hyperlink">Frame</a> files, it is mostly preferred 
                           to use them in other class method in which a shutter method is applied. Their flexible structure makes 
                           it possible for methods or windows to inherit them. While shutters have been discussed earlier, here, we 
                           will focus on how to apply middlewares to shutters. Middlewares can be applied through the <code>ONCALL()</code> method or 
                           by passing the the <code>SELF::ONCALL</code> key into a specific shutter list of accepted urls. It can also be applied 
                           by setting a preload function on urls using the <code>self::preload()</code> method. When supplied, 
                           these functions will execute before the method or class is resolved.
                            <br><br>

                            <div class="font-em-d9">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">self::preload()</div> <br> 
                                <div class="">
                                    This method can be applied to specific urls the immediately a url is resolved but not before it is authenticated. 
                                    A url becomes must first be resolved before it is allowed to render. Between the reolving and rendering of a url, 
                                    middlewares are allowed to act as bridge to determine how a url responds.   
                                    (i.e visited). The <code>preload()</code> method takes a list of direct urls as its first argument and a boot function as its second argument.
                                    A syntax and and example is shown below: <br><br>
                                    
                          
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
        <div class="no-select bc-silver-d pxv-10">Syntax:  self::preload()</div>
        <pre class="pre-code">
  <span class="comment">#sample stucture 1: <span class="c-brown-ll">self::preload($acceptableUrls, $boot)</span></span>

  $acceptableUrls <span class="comment">//an array list of valid urls</span>
  
  $boot  <span class="comment">//a function that is called before a url are rendered</span>
 </pre>
                                        </div>
                                    </div> <br> <br>  
                          
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
        <div class="no-select bc-silver-d pxv-10">Example:  self::preload()</div>
 <pre class="pre-code">

    use Window;

    class Home extends Window {

        function __construct() {

            self::preload( 
                [ 
                    'docs/user/settings',
                    'docs/user/profiles',
                ], 
        
                function() {
                    
                    echo "method applied";
        
                }
            );

        }

    }
 </pre>
                                        </div>
                                    </div> <br>

                                    <div class="font-menu mvt-10">
                                    Using the example above as reference, if the url <code>docs/user/settings</code> or 
                                    <code>docs/user/profiles</code> is visited, the text <code>"method applied"</code> 
                                    will be printed on the page. 
                                    </div> <br>
                            
                                </div>
                            </div>

                            <!-- oncall() -->
                            <div class="font-em-d87">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">SELF::ONCALL()</div> <br> 
                                <div class="">
                                    This method is a preload method can be applied on any of the four shutter methods. The first argument declares the type of middleware 
                                    to be applied. These options are: <br><br>
                                    
                                    <ul>
                                        <li> <code>CASTED::CALL</code>(or <code>CASTED::CAST</code>) </li>
                                        <li> <code>CASTED::ROOT</code> </li>
                                        <li> <code>CASTED::BASE</code> </li>
                                        <li> <code>CASTED::PATH</code> </li>
                                        <li> <code>CASTED::E404</code> </li>
                                        <li> <code>CASTED::GLOBALCAST</code> </li>
                                        <li> <code>CASTED::GLOBALBASE</code> </li>
                                        <li> <code>CASTED::GLOBALPATH</code> </li>
                                    </ul>
                                   
                                   Each of these options defines the shutter environment in which a boot function can execute its operations. 
                                   As their name implies, they only execute their operation when a relative shutter method comes into play. In a situation where 
                                   multiple shutters are pended for another, we may need to define our boot function for specfic shutters. Hence, when any of the defined shutter is 
                                   called then the function will execute.
                                </div>
                            </div> <br>

                          
                            <div class="pre-area shadow">
                                    <div class="">
                                        <div class="no-select bc-silver-d pxv-10">SELF::ONCALL</div>
        <pre class="pre-code">
  <span class="comment">#sample stucture 1: <span class="c-brown-ll">self::ONCALL(option, urls)</span></span>

  option <span class="comment">//casted options</span>
  
  urls  <span class="comment">acceptable urls and their respective boot options</span>
        </pre>
                                    </div>
                            </div> <br> <br>

                            
                            <p class="font-em-d87">The code structure below is an example of its usage: </p>

                          
                            <div class="pre-area shadow">
                                    <div class="">
                                        <div class="no-select bc-silver-d pxv-10">SELF::ONCALL</div>
        <pre class="pre-code" style="color: rgb(var(--sea-blue-dd));">
      class {

            function __construct() {

                SELF::ONCALL(CASTED::CALL, [
                    
                    'home/user/settings' => function(){
                                                <span class="comment">// run this for settings</span>
                                            },
                    
                    'home/user/profiles' => function(){
                                                <span class="comment">// run this for profiles</span>
                                            },
                    ]);

                SELF::ONCALL(CASTED::BASE, [
                    
                    'home/user' => function(){
                                                <span class="comment">// run this for user</span>
                                            },
                    
                    'home/room' => function(){
                                                <span class="comment">// run this for room</span>
                                            },
                    ]);

                SELF::CALL([
                    
                    'home/user/settings' => 'root',
                    'home/user/profiles' => 'profiles',

                    ], false);

                SELF::BASE([
                    
                    'home/user' => 'user',
                    'home/room' => 'room',

                    ]);

            }

      }
       </pre>
                                    </div>
                            </div> <br> <br>

                            <div class="font-em-d87">
                                The code structure above is a 
                                complex relationships between shutters and predefined 
                                or preloaded function. This relationship is explained below: <br><br>

                                <ul>
                                    <li>
                                        The <code>SELF::ONCALL(CASTED::CALL)</code> method is used to set a preset (or preload) function on the list of urls it contains which 
                                        is only applied within the <code>SELF::CALL()</code> method.
                                    </li>
                                    <li>
                                        The <code>SELF::ONCALL(CASTED::BASE)</code> method is used to set a preset (or preload) function on the list of urls it contains which 
                                        is only applied within the <code>SELF::BASECALL()</code> method.
                                    </li>
                                    <li>
                                        If the <code>SELF::CALL()</code> can resolve any of its urls, then the function for <code>SELF::ONCALL(CASTED::CALL)</code> will be called before 
                                        the url is rendered. However, if it cannot resolve its urls, then because it was pended, it will continue to <code>SELF::BASECALL()</code>.
                                    </li>
                                    <li>
                                        If <code>SELF::BASECALL()</code> can resolve any of its urls, the <code>SELF::ONCALL(CASTED::BASE)</code> function will be called for the relative url. If basecall 
                                        cannot resolve its url also, then a 404 error page is returned.
                                    </li>                                
                                </ul> 

                               
                                <div class="c-teal">
                                    While the method above may be useful, it can be a tedious process and setting up boot functions this way can cause a lot of confusion even if it is handled separately. 
                                    We can however shorten this function, making it more comprehensible by passing <code>SELF::ONCALL</code> key on the shutter itself. 
                                </div>
                            </div>

                            <div class="font-em-d87">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">SELF::ONCALL</div> <br> 
                                <div class="">
                                    This <code>SELF::ONCALL</code> key is a preload method can be applied within any list of urls for any of the four shutter methods. We don't have to apply any option since we are within the shutter itself.<br><br>
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
                                            <div class="no-select bc-silver-d pxv-10">Sample:  SELF::ONCALL</div>
  <pre class="pre-code">
  SELF::CALL([
    
    'home/user/profiles' => 'profiles',
    'home/user/settings' => 'settings',

     SELF::ONCALL => function() {

            <span class="comment">//run this if any of the url was resolved.</span>

            if( invoked('home/user/profiles') ) {
                <span class="comment">//do this</span>
            }

            if( invoked('home/user/settings') ) {
                <span class="comment">//do this</span>
            }

        }

    ])
  </pre>
                                        </div>
                                    </div> <br> <br>  
                                </div>
                            </div> <br>

                            <div class="font-em-d87">
                                The code structure above is more concise and 
                                understandable than when we applied the <code>SELF::ONCALL</code> method. The only difference is that here, 
                                our function is more localized and will not extend to a subsequent call method. For example, if the <code>SELF::CALL()</code> 
                                method above was pended, then another <code>SELF::CALL()</code> method below it will not inherit the function. 
                            </div>


                        </div>

                    </div> <br>
                </div>
            </div>
    
            
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/wmv">Wmv</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/wmv/middlewares">Middlewares</a>  </div>

      
            
        </section>
    </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>