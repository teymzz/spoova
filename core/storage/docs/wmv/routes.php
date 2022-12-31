<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/trial/res/main/images/icons/favicon.png">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
    <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script> 
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-d));
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
          color: #4f58a0;
          font-size: .95em; 
          margin-bottom:0;
          padding-top:1em;
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
   --black-ll: 179, 179, 179;        
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
    
    
    <script src='http://localhost/trial/res/main/js/switcher.js'></script>
    
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
            

        })
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
               <div class="flex-icon theme-btn box bd-silver border rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin" data-src="http://localhost/trial/res/main/images/icons/favicon.png" style="transition: none"></div>
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

              
 <div class="font-menu pvs-4">   </div>


              <div class="start font-em-d8">
                <div class="font-em-1d5 c-orange">Routes</div> <br>  
                
                <div class="resource-intro">
                    <div class="">
                      The routes method on windows are used to name a route. They help to provide a name for a 
                      particular url which can later be accessed by using the <code>Routes()</code> function or 
                      <code>@Routes()</code> directive. Once the name of a particular url has been defined using 
                      <code>addRoutes()</code> method, if the path changes, as long as the name of the path remains 
                      the same, then such paths can be easily modified across web pages. This functionality makes it 
                      easier to work with links that are called multiple times in a very easier way saving a considerable 
                      amount of time in web development.
                    </div> 
                </div>

                
                <div class="example"> 
                  <br>
                  <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> <span class="bi-globe2 mxr-8 c-lime-dd"></span> Routes Example </div>
                  </div> <br>

                  <div class="">
                      <div class="pre-area">
                          <div class="file-1 pxv-10 bc-orange c-white">Home.php (sample window)</div>
                          <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){
        
        self::loadRoutes();

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' 

        ];
    }

  }

                          </pre>
                      </div>
                  </div>

                  <div class="font-menu mvt-6">
                    The method <code>addRoutes()</code> was applied to the code above, now we can access our <code>home/profile</code> 
                    using the function <code>routes('profile')</code> or directive <code>@routes('profile')</code> in template files.
                  </div>
                    
              
                </div> <br>

                
                <div class="windows-files"> 

                  <div class="c-orange">Route Methods</div>
                  
                  <div>
                    The Window class uses three different methods to handle its named routes which are 
                    <code>addRoutes()</code>, <code>loadRoutes()</code> and <code>getRoutes()</code>.
                    <br><br>

                    <!-- addRoute -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> addRoutes </div>
                    </div>

                    <div class="mvt-10">
                      This method is used to set a route on particular Window. The which can later be loaded using the <code>loadRoutes</code> 
                      method. It follows a predefined structure in which when an array of key pairs "name" and "route" is supplied, then such 
                      array is used to update the <code>Window</code> default routes. Also, an array must be returned when using <code>addRoutes()</code> 
                      method. The syntax structure is shown below:
                      <div class="pre-area">
                        <pre class="pre-code bc-off-white-dd">

  <span class="comment">... sample 1</span>

    public function addRoutes(array $array = []) : array {

        return Window::addRoutes([
        
          'route_name' => 'window/route/url' <span class="comment">// i.e full base url</span> 

        ]);
    }

  <span class="comment">... sample 2</span>

    public function addRoutes(array $array = []) : array {

        return [
        
          'route_name' => 'window/route/url' <span class="comment">// i.e full base url</span> 

        ];
    }

                        </pre>
                      </div> 
                      <div class="font-menu pvs-10">
                        By default, the <code>Window::addRoutes()</code> sets a list of named url 
                        and also returns an array of the currently set url. When the <code>addRoutes</code> 
                        method is redefined in a window file such as <b>sample 2</b> above, 
                        the root <code>Window::addRoutes()</code> must be used to update the routes. 
                        This can be achieved calling the code <code>Window::addRoutes()</code> such as 
                        <b>sample 1</b> above. It can also be achieved in a different way using <code>loadRoutes()</code> 
                        method.
                      </div>
                    </div> <br>

                    <!-- loadRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> loadRoutes </div>
                    </div> <br>
                    <div class="">
                      By default, the <code>Window::loadRoutes()</code> method calls a Window's <code>addRoutes()</code> method. 
                      The root <code>Window</code> class uses its <code>addRoutes()</code> to update its named routes. However, the 
                      <code>addRoutes()</code> method can be re-defined in child Window classes, since the most important concept of the 
                      <code>addRoutes()</code> method is to return an array list of named urls (or routes). If the <code>addRoutes()</code> 
                      was remodified, then the only the root Window <code>addRoutes()</code> method, that is <code>Window::addRoutes()</code> 
                      can be used to update the named urls. This example is displayed in <b>sample 1</b> of <a href="#addroute">addRoutes</a> 
                      discussed earlier. However, if <code>self::loadRoutes()</code> was used within the construct function of a child Window 
                      and the <code>addRoutes()</code> method was only used to return an array within that child Window class, then it is required 
                      to pass the current Window class as an argument into the <code>loadRoutes()</code> method when calling it within that class. 
                      A sample of this is shown below. 
                      <div class="pre-area font-menu bc-off-white-dd">
                        <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){
        
        self::loadRoutes(this);

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' 

        ];
    }

  } 

                        </pre>
                      </div>

                      <div class="font-menu pvs-10">
                        In the sample above, the construct function was used to update the 
                        default routes by passing the instance of the current class into the <code>loadRoutes()</code> method which 
                        by default automatically updates the routes by using the root <code>Window::addRoutes()</code> to pull the 
                        returned routes from the <code>addRoutes()</code> method of the current class.
                      </div>

                    </div> <br>

                    <!-- getRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> getRoutes </div>
                    </div> <br>

                    <div class="">
                      This method only returns the list of named routes for a particular window class. Before this method can successfully return 
                      the list of named route of a class, an update from a previously defined parent Window class must have occured through the use of
                      <code>loadRoutes()</code> method. If no update occurs, the parent Window routes are returned.
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