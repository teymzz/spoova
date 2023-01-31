



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Routing WMV</title>
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

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/routings">Routings</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/routings/wmv">WMV</a>  </div>


                <div class="start font-em-d8">
                    <div class="font-em-1d5 c-orange">Routing WMV</div> <br>
                    
                    <div class="db-connection">
                        <div class="fb-6 c-olive">Introduction</div>
                        <div class="">
                            The wmv is a term used for loading of web pages using web servers without starting the server manually through ports. 
                            . Windows files are all loaded from the windows folder through the use of a standard logic. By default, when a url does not exist,
                            spoova tries run its windows files from the windows (routes) folder. If the path does not exist spoova will return a 
                            404 error response page depending on whether it is an api window or not. This is done by
                            processing the <code>Index</code> class within the windows folder. The Index is then used to handle 
                            incoming urls which if not handled will return a 404 error page. The architectural pattern flow is
                            shown below.
                            <br><br>
                            <div class="font-menu  font-em-d85 bc-white-dd box-full rad-4 pxv-8">
                                url > windows(route) -> index -> 404 error page
                            </div>
                        </div> 
                    </div> <br>

                    <div class="db-operations">
                        <div class="fb-6 c-olive">Setting up a new wmv route</div>
                        <div class="font-menu font-em-1">
                            All window files are loaded from the windows folder. These files
                            can be extended to different Frames. Frames are binding structures that can be applied
                            on window files. Their functions are to define basic structure or concepts a window
                            can emulate. For example, Frame files can be used to separate or divide sessions which are
                            only recognized in some particular windows files. Hence, all window files extending to such 
                            Frames will only derive their session values from their parent frame file. Windows files have a great 
                            relationship with <code>Res</code> class. This makes it easier to call methods like <code>Res::load()</code> 
                            using <code>self::load()</code> instead, which also searches for its template files from the rex folder.  Proceedures below 
                            helps to explain the steps or stages involved in setting up a windows file.
                            <br><br>

                            <div class="fb-6 mvb-10">Setup steps</div>
                            <ol>
                                <li>Create a separate frame folder within the windows folder</li>
                                <li>In the frame folder, add a base group class frame file for the windows files that will share the same data.</li>
                                <li>Create a windows' page by using the page's entry point name as a class in the Windows File.</li>
                                <li>Extend your windows file to your frame file</li>
                                <li>Add a construct method within the windows file created in one above</li>
                                <li>
                                    Once this is done, when a user tries to access a page with the name of your windows file,
                                    the windows file will be automatically loaded up from the windows folder. If the non-existing url is not handled
                                    a 404 error is returned.
                                </li>
                            </ol>
                            
                        </div>

                        <div class="font-em-d8">Step 1 & 2 above : This frame file should be added inside the Frame folder directory within the windows folder.</div> <br>     
                        <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x">
<div class="pxv-10 bc-silver">File 1 - Frame file sample (UserFrame.php)</div>        
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\windows\Frames;
    use Window;

    class Userframe extends Window{

        function data() {

            return ['name' => 'Felix'];

        }

    }

  ?&gt;
                    </pre>
                        </div> <br><br>     

                        <div class="font-em-d8">Step 3, 4 & 5 above</div> <br> 
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
  <div class="pxv-10 bc-silver">File 2 - Windows file sample (Home.php)</div> <br>         
                    <pre class="pre-code">
  &lt;?php

    use spoova\windows\Frames\UserFrame;

    class Home extend Userframe{

        function __construct() {

            print "This is the homepage";

        }

    }

  ?&gt;
                    </pre>
                        </div> <br><br>



                        <div class="font-em-d87">
                            <div class="">Notice : In the above, we can discover that Frames are extensions of Windows.</div>          
                            Since the <code>Res::load()</code> can be applied on windows files, then we can say: <br>
                        </div> <br> 

                        <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x"> 
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\windows;

    use spoova\windows\Frames\UserFrame;


    class Home extend Userframe{

        function __construct() {

            self::load( 'index', fn => compile() );

        }

    }

  ?&gt;
                    </pre>
                        </div> <br> <br>

                        In example above:
                        <ol class="font-em-d9 mvt-10">
                            <li>
                                File 1 <code class="c-wine-dd">UserFrame.php</code> was added into the windows/Frame folder 
                                and the UserFrame class was extended to the Windows.
                            </li><br>
                            <li>
                            File 2 <code class="c-wine-dd">Home.php</code> must be a windows File. 
                            Hence, it was extended to the Frame file <code>UserFrame.php</code>. 
                            </li><br>
                            <li>
                                The last code section reveals how to use the resource load method <code>Res::load</code> within the windows File.
                            </li>
                        </ol>

                        <div class="foot-note">
                            <span class="head">Footnote:</span><br>

                            <div class="">
                                <ul>
                                    <li>
                                        It is important to note that file compiling, 
                                        that is, the use of <code>compile()</code>. 
                                        can only be done once. <br>
                                    </li>
                                    <li>
                                        If multiple files will be compiled, then it is 
                                        preferred to use the <code>view()</code> function. 
                                        There are distinctive differences between <code>compile()</code> 
                                        and <code>view()</code> . This is discussed under the helper compiler 
                                        functions tutorial.
                                    </li>
                                </ul>
    
                                The last example below shows how <code>view()</code> can be used within classes
                            </div>

                        </div>
                    </div> <br>
                    
                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x"> 
    <pre class="pre-code">
  &lt;?php
  
    namespace spoova\windows;

    use spoova\windows\Frames\UserFrame;


    class Home extend Userframe{

        function __construct() {

            $view1 = self::load( 'index', fn => view() );
            $view2 = self::load( 'home', fn => view() );

            echo $view1.$view2;

        }

    }
  
  ?&gt;
    </pre>

                        </div> <br> <br>  
                    
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/routings">Routings</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/routings/wmv">WMV</a>  </div>

                </div>
            </div>
        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>