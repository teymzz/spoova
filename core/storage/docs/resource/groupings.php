

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



    <style>
    ul > li > a{
        color:inherit;
    }   

    ul > li > a:hover{
        color:inherit;
    }   

    ul > li a:hover{
       color: var(--orange-dd);
       cursor:pointer;
    }

    .olist {
        font-family: calibri;
        color: burlywood;
    }
    </style>

    <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxv-20 tutorial bc-white">
           <div class="font-em-1d2">

                
 <div class="font-menu pvs-4">   </div>


                <div class="start" >
                    
                    <div class="font-em-1d2 c-orange">Resource Grouping (Importation)</div> <br>
                   
                    <div class="intro">
                        <div class="font-em-d8">
                            Resource grouping is the use of resource class to group static file urls
                            which can be imported later into the webpage. The resource importer is not
                            only capable of loading static urls but can also load configured meta tags 
                            and live server through default configuration settings. The features of
                            resource grouping are listed below: <br><br>
                            
                            <li>Storing and importing static urls</li>
                            <li>Validating local static urls</li>
                            <li>Grouping static urls</li>
                            <li>Resolving local urls into http protocol urls</li>
                            <li>Loading the default meta tag configurations</li>
                            <li>Live server importations and control</li>
                            
                        </div> 
                    </div> <br>

                    <div>

                    
                    
                        <div class="font-em-d8">

                            <div class="font-menu fb-6 font-em-1 bc-white-dd box-full rad-4 pxv-8">
                             Storing and importing static urls
                            </div> <br><br>

                            <div class="font-menu font-em-1">
                                Static urls are imported from the global resource folder <code>res</code>.
                                Therefore, all local static urls should begin with the res folder name, although 
                                a different folder name may be accepted. Before a file can be imported, it can 
                                be first stored into the storage system. By default, the Resource class stores 
                                urls into different containers which are either named or unamed. When storing static urls, 
                                a group name should be first declared else, the url will be stored in an unamed space. There are 
                                several methods used for handling resource storage and importation and they are listed below
                                <br><br>
                                <ul class="font-em-d85 c-olive">
                                    <li>Res::name()</li>
                                    <li>Res::callFile()</li>
                                    <li>Res::getFile()</li>
                                    <li>Res::addFile()</li>
                                    <li>Res::ignore()</li>
                                    <li>Res::new()
                                        <ul class="pxs-12 list-square">
                                            <li>->name()</li>
                                            <li>->url()</li>
                                            <li>->xurl()</li>
                                            <li>->urlOpen()</li>
                                            <li>->urlClose()</li>
                                            <li>->dir()</li>
                                            <li>->dirClose()</li>
                                        </ul>
                                    </li>
                                    <li>Res::path()</li>
                                    <li>
                                        Res::open()
                                    </li>
                                    <li>
                                        Res::close()
                                    </li>
                                    <li>
                                        Res::import()
                                    </li>
                                    <li>
                                        Res::export()
                                    </li>
                                </ul>
                            </div> <br>


                            <!-- Resource Naming -->
                            <div class="resource-naming">
                                <div class="fb-6">#Resource naming</div>
                                <div class="mvt-10">

                                    <div class="font-menu font-em-d95">
                                        Resource naming or grouping is done by giving static resources their own 
                                        storage group space which may be declared (named) or undeclared (unmamed).
                                        Example is listed below: <br><br>
                                    </div>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::name('css');

  Res::new()->name('js');
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        The example above reveals two different ways by which static urls can be grouped 
                                        before they are being stored. While <code>Res::name()</code> is a direct static method of 
                                        naming a new resource group, the <code>Res::new()->name()</code> is an indirect instance method of naming groups.
                                        To switch to a previously declared group or declare a new group, line one will have to be repeated at each declaration but line 2 supports a chainable 
                                        structure naming convention reducing the number of times the <code>Res</code> class will have to be called just as shown in the example below:
                                    </div> <br> 

                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  <span class="comment">1.</span> Res::name('css');
  <span class="comment">2.</span> Res::name('js');
  <span class="comment">3.</span> 
  <span class="comment">4.</span> Res::new()->name('css')->name('js');
    </pre>

                                    </div> <br><br>

                                    <div class="d87">
                                        When adding multiple groups, line 1 & 2 will be harder to manage, hence line 4 is mostly recommended
                                    </div> <br>         
                                </div>
                            </div>


                            <!-- Resource Setting -->
                            <div class="resource-input">
                                <div class="fb-6">#Resource Setting</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        Resources can be added through 3 input methods which are
                                        <code>Res::callFile()</code> <code>Res::getFile()</code> and
                                        <code>Res::addFile()</code>
                                    </div>
                                    
                                    <div class="box-full pre-area shadow mvt-10 flow-x"> 
                                        <div class="pxv-6 bc-silver">Example 1 - callFile</div>

    <pre class="pre-code">
  Res::name('css');
  
  Res::callFile('res/css/file1.css');
  Res::callFile('res/css/file2.css');
  
  
  Res::name('js');
  
  Res::callFile('res/js/file1.js');
  Res::callFile('res/js/file2.js');
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        In example 1 above, two groups were declared. The first group 
                                        <code>css</code> is where <code>file1.css</code> and <code>file2.css</code>
                                        paths will be saved. While the <code>file1.js</code> and <code>file2.js</code> 
                                        will be saved into <code>js</code> storage group declared just immediately above them. These groups
                                        can be imported later using the <code>Res::import()</code> method. Paths stored does not necessarily 
                                        have to be of the same extension. However, only four files extensions are supported which are 
                                        <code>html</code> <code>css</code> <code>js</code> and <code>php</code>
                                    </div> <br> 


                                    <div class="example-2">
                                        <div class="box-full pre-area shadow flow-x">
                                            <div class="pxv-6 bc-silver">Example 2 - instanced</div>
        <pre class="pre-code">
  Res::new()

     ->name('css')

     ->url('res/css/file1.css')
     ->url('res/css/file2.css')


     ->name('js')

     ->url('res/css/file1.js')
     ->url('res/css/file2.js')
        </pre>
            
                                        </div> <br><br>
                    
                                        <div class="d87">
                                        
                                        When using the instance method, a chainable structure can be employed that
                                        helps to keep the code easier to maintain instead of calling the resource <code>Res</code>
                                        class at every declaration like example 1 above.
                    
                                        </div> <br>         
                                    </div>


                                    <!-- example - 3 -->
                                    <div class="example-3">
                                        <div class="box-full pre-area shadow flow-x">
                                            <div class="pxv-6 bc-silver">Example 3 - getFile</div>
    <pre class="pre-code">
  $resolved = Res::getFile('res/css/file2.js')
    </pre>
            
                                        </div> <br><br>
                    
                                        <div class="d87">
                                        
                                        Just like the callFile method, the getFile method processes its arguments similarly 
                                        and returns a resolved url of its input. It is however worth noting that local urls 
                                        are validated before inclusion. If the path is not found, a null response is returned.
                                        Such invalid urls are never imported to the page. 

                    
                                        </div> <br>         
                                    </div>

                                    <!-- example - 4 -->
                                    <div class="example-3">
                                        <div class="box-full pre-area shadow flow-x">
                                            <div class="pxv-6 bc-silver">Example 4 - addFile</div>
    <pre class="pre-code">
  Res::name('css');
  Res::name('js');
  
  Res::addFile('css','res/css/file2.js');
  
  Res::addFile('res/css/file3.js');
    </pre>
            
                                        </div> <br><br>
                    
                                        <div class="d87">
                                        
                                        Just like the callFile method, the addFile method processes its urls by adding files to 
                                        an existing group. The group name to which the url will be added must be first declared as the first argument 
                                        while the second argument should be the file path that will be added. After the first 
                                        group declaration, <code>addFile</code> permits the omission of the class name for subsequent chained addFile 
                                        calls.

                    
                                        </div> <br>         
                                    </div>
                            
                                </div>
                            </div>


                            <!-- Resource Protection -->
                            <div class="resource-protection">
                                <div class="fb-6">#Resource protection</div>
                                <div class="mvt-10">

                                    <div class="font-menu font-em-d95">
                                        Resource naming opens a (url) storage space which is expected to be closed. 
                                        The dangers of not closing resource space is that developers may accidentally save into a different storage 
                                        space. Hence, it is a good practice to either close your resources or start naming on a safe mode. The 
                                        <code>Res::open()</code> is used to open a resource inclusion on safe mode while <code>Res::close()</code>
                                        is used to close currently opened resource group or to move back into the unamed storage space.
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x"> 
                                        <div class="pxv-6 bc-silver">Example 5 - Resource opening in safe mode</div>
    <pre class="pre-code">

  <span class="comment">// Method 1 ----------------------------------------------------</span>
  Res::open();
  Res::name('js');
  
  Res::callFile('http://www.site.com/file.css');
  
  
  <span class="comment">// Method 2 ----------------------------------------------------</span>       
  Res::open();
  
  Res::new()
      ->name('js')
      ->url('http://www.site.com/file.css');
  
  
  <span class="comment">// Method 3 ----------------------------------------------------</span>       
  Res::new()
  
      ->urlOpen()
      ->name('js')
      ->url('http://www.site.com/file.css');
  </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        The examples above reveals three different ways by which resource grouping can be initialized in safe mode. 
                                        This can also be achieved by naming a group at the top of your application where the urls will be saved which automatically 
                                        declares or selects a storage space.

                                    
                                    </div> <br> 

                                    <div class="box-full pre-area shadow flow-x"> 
                                    <div class="pxv-6 bc-silver">Example 6 - Resource closing</div>
    <pre class="pre-code">
  <span class="comment">// Method 1</span>
  Res::name('css');
  Res::name('js');
  
  Res::close();
  
  <span class="comment">// Method 2</span>
  Res::new()
  
  ->name('js')
  ->urlClose();
    </pre>

                                    </div> <br><br>

                                    <div class="d87">
                                        The resource <code>close()</code> can also clear previous storage when a bool of true 
                                        is supplied as its argument. Using the <code>close()</code> outside of a storage space will 
                                        reset all previously stored urls. This is why <code>open</code> or <code>urlOpen</code> is much
                                        preferred as it also provides a safe mean of exiting into unamed space. The "open" methods will 
                                        never reset the storage space unless an bool argument of true is suuplied.
                                    </div> <br>         
                                </div>
                            </div>

                            <!-- Resource Url Defaulting -->
                            <div class="resource-defaulting">
                                <div class="fb-6">#Resource url defaulting</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        Resource supports that a base or root url can be set for static files. Hence, 
                                        all subsequent urls will derive their parent url from the base url. The only way to 
                                        escape this is by using the <code>xurl</code> method to overide the default url set or by closing 
                                        the previously defined url base. The <code>new()</code> method accepts the default url base as shown in the 
                                        example below:
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::new('res/assets/')
  
     ->url('css/file.css')
     ->url('js/file.js')
     
     ->xurl('res/main/css/file2.css')
     ->xurl('res/main/js/file3.js')
     
     ->url('css/file2.css')
     
     -> urlClose();
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        The example above reveals that once a base url is set, the only way to overide it is by using the 
                                        <code>xurl</code> method. However, the full file path must be included into the <code>xurl()</code> 
                                        method. Every other <code>url()</code> declared will derive their base url from their parent <code>new()</code>
                                        method just as shown above.
                                    </div> <br> 

                                </div>
                            </div>

                            <!-- Resource Url Defaulting -->
                            <div class="resource-directory-switch">
                                <div class="fb-6">#Resource directory switch</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        The <code>Resource::path()</code> function enables the mapping of a parent directory to all local urls supplied when working 
                                        with a parent and child directory. If static files (absolute) urls are stored within the parent directory, A child directory 
                                        may have difficulty in importing the file except it uses the parent directory pointer <code>../</code> to pull the files. The 
                                        <code>Resource::path()</code> can be useful to declare in the child file that it needs to go to an upper directory. This must however 
                                        be declared before importing the files just as below.
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::path('../');

  Res::import();
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        In the example above, when importing, resource will append the directory pointer to only absolute paths while the http urls will not be affected. 
                                    </div> <br> 

                                </div>
                            </div>



                            <!-- Resource Ignoring -->
                            <div class="resource-ignoring">
                                <div class="fb-6">#Resource ignoring</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        By default, the <code>Res</code> class imports its static files from the <code>res</code> folder 
                                        . In order to prevent this, a resource ignore <code>Res::ignore()</code> is used to reset its path from the root 
                                        folder.The <code>Res::ignore()</code> method should come before the urls to be imported are stored. The <code>close()</code> 
                                        <code>urlClose()</code> <code>open()</code> or <code>urlOpen()</code> methods can be used to terminate this rule. It is however 
                                        preferable to avoid the use of <code>close()</code> methods. 
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code"> 
  Res::new()->name('css')
      
  ->url('folder/file.js')
  
  <span class="comment no-select box" style='border:dashed 1px; width: 97%'></span>
  
  Res::ignore(); 
  
  Res::new()->name('js')
  
  ->url('folder/file.js')
  ->urlClose();
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        In example above, the <code>Res::ignore()</code> will only 
                                        affect the urls stored after it was called while those above will not be affected. 
                                        The <code>urlClose()</code> method will also terminate the effect of <code>Res::ignore()</code>
                                    </div>
                        
                                </div>
                            </div> <br> 

                            <!-- Resource Definition -->
                            <div class="resource-definition">
                                <div class="fb-6">#Resource Defining</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        There are cases in which certain urls may not reveal their file extensions. This makes it difficult for 
                                        Resource class to properly resolve such urls to their respective script link. In such cases, the file extension should be supplied
                                        manually to help resource class to resolve such urls. An example is shown below:
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::new()->name('scripts')
  
  ->url('http://site.com/js-file:::js')
  ->url('http://site.com/css-file:::css')
  
  ->urlClose();
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        In example above, the urls supplied has no recognizable extension, however, if we know the 
                                        type of file it is, we can tell the resource class to resolve the url with its respective script tag.
                                        This is done by adding three colons and file extension after the url supplied. The extension will not be 
                                        added by the resource class. These extensions only exists to help resource class to identify what tag should be 
                                        used to resolve such urls. The urls when imported will be resolved into : <br><br>
                                        <div class="bc-white-dd c-brown-ll pxv-10 font-em-1"> 
                                            &lt;script src="http://site.com/js-file" &gt; <br><br>
                                            &lt;link href="http://site.com/css-file" &gt; 
                                        </div>
                                    </div>
                
                                </div>
                            </div> <br>

                            <!-- Resource Attributes -->
                            <div class="resource-attributes">
                                <div class="fb-6">#Resource Attributes</div>
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d95">
                                        There are cases in which certain our tag may have atrributes attached to them. In order to add attributes to tags, we can 
                                        employ the use of <code> = </code> & <code> > </code> sign (i.e <code>=></code> ) to point our attributes:
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::new()->name('scripts')
  
     ->url('http://site.com/js-file::js => class:value; id: some_id')
  
     <span class="comment no-select">// &lt;script src="http://site.com/js-file" class="value" id="some_id"&gt;&lt;/script&gt; </span>
    </pre>
                                    </div> <br><br>

                                    <div class="d87">
                                        In example above, we added attributes to our static urls. As revealed above, attributes can be separated using the 
                                        <code>:</code> semicolon character
                                    </div>
                
                                </div>
                            </div> <br>

                            <!-- Resource Importation -->
                            <div class="resource-importing">
                                <div class="fb-6">#Resource importation</div>
                                <div class="mvt-10">

                                    <div class="font-menu font-em-d95">
                                        Resources can be imported using different methods. Stored resource urls can be imported using the resource import 
                                        <code>Res::import()</code> method. Before we proceed, we need to understand the features and capabilities of 
                                        resource importer. <br><br>

                                        <div class="pxs-20">Features of Resource importer</div>
                                        <ul class="mvt-10">
                                            
                                            <li>Importing static urls</li>
                                            <li>Importing live server</li>
                                            <li>Importing meta tags</li>
                                        </ul> 
                                        By configuration, resource <code>import()</code>  can be configured to import default meta tags or live server when importing urls. The 
                                        Resource class has been configured in a way that both the liveserver and meta tags are imported once to the web page. These 
                                        configuration settings are stored within the init file which can be configured manually or by use of shell commands. 

                                        <br><br>
                                        <div class="liveserver">
                                            <div class="font-em-1d2 mvb-6">Live Server</div>
                                            Using cli commands: <br>
                                            <ul>
                                                <li>
                                                    Navigate to the core folder of your project file. For example: <code>c:\www\project_folder\core >> </code> 
                                                </li>
                                                <li>
                                                    Run the command <code>php spoova watch <span class="c-green-l">online|offline|disable</span></code> to turn on or off the default live server
                                                </li>
                                                <li>
                                                    Online : means to run live server in both online and offline environments
                                                </li>
                                                <li>
                                                    Offline : means to run live server only in offline environments
                                                </li>
                                                <li>
                                                    Disable : means to disable live server in both offline and online environments
                                                </li>
                                            </ul>

                                            Once the live server is turned on, the resource class will include the live server when importing static urls to the web page and this 
                                            action is only done once.
                                        </div>

                                        <br>
                                        <div class="meta-tags">
                                            <div class="font-em-1d2 mvb-6">Meta Tags</div>
                                            Using cli commands: <br>
                                            <ul>
                                                <li>
                                                    Navigate to the core folder of your project file. For example: <code>c:\www\project_folder\core >> </code> 
                                                </li>
                                                <li>
                                                    Run the command <code>php spoova meta <span class="c-green-l">on|off</span></code> to turn on or off the default live server
                                                </li>
                                            </ul>

                                            Once the resource meta is turned on, the resource class will include default configured meta tags when importing static urls to the web page. This action is also 
                                            visited once.  Manually, the init file can be configured by setting the <code>RESOURCE_META</code> to <code>on</code>
                                        </div>
                                    </div> <br>
                                    
                                    <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  RESOURCE_META: on
    </pre>
                                    </div> <br>
                        
                                </div>
                            </div> <br> 


                            <div>
                                <div class="fb-6 box-full rad-4 resource-statics">
                                    #Importing static urls
                                </div>
    
    
                                <div class="mvt-10">
                                    <div class="font-menu font-em-d9">
                                        Static urls are imported to the webpage by using the <code>Res::import()</code> method.
                                        The <code>import()</code> method supports different level of arguments which are discussed below: <br> <br>
    
                                        <div class="importing-groups">

                                            <div class="d87">
                                                The sample code structure below <b>(Fig 1)</b> will be used to explain resource importation. <br><br>
                                            </div>
    
                                            <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  Res::new('res/assets/')
  
  
     -> name('anime')
     -> url('css/anime.css')
     -> url('js/anime.js')
     
     
     -> name('design')
     -> url('css/design.css')
     -> url('js/design.js');
    </pre>
                                            </div> 
                                            <b class="font-menu fb-6">Fig 1.</b>
                                            <br>
                                        
                                        </div>
                                    </div> <br>
                                </div>   
    
                                <div class="">
                                    <div class="font-menu font-em-d9">
                                    
                                        <div class="importing-groups">
                                            <div class="head fb-6">
                                                <div class="wid-fit">
                                                    <span class="c-orange-dd box bc-orange" style="height:10px; width:10px"></span>
                                                    Importing Groups <br>
                                                </div>  
                                            </div>
                                            <div class="pvs-20">
                                                To import a group, a colon must be declared before the group name.  
                                                The methods below reveal methods by which a groups can be imported into web page.
                                            </div>
    
                                            <div class="box-full pre-area shadow flow-x"> <br>
    <pre class="pre-code">
  <span class="comment">1.</span> Res::import(':anime');
  <span class="comment">2.</span> Res::import(':design');
  
  <span class="comment">3.</span> Res::import([':anime', ':design']);
  
  <span class="comment">4.</span> Res::import('res/',[':anime', ':design']);
    </pre>
                                            </div> <br>
                                        
                                            <div class="d87 pvs-10">
                                                In example above, <code>line 1 & 2</code>  are methods of importing stored groups 
                                                separately. The use of array in <code>line 3</code> is a concise way of importing 
                                                multiple groups, without having to call the <code>import()</code> directive every time.
                                                Files are resolved and imported in the way they are stored.  In <code>line 4</code>, urls
                                                are imported with parent url of <code>res/</code> . However, this was used for testing purposes 
                                                hence not recommended for use.
                                            </div>
    
                                        </div>
                                    </div> <br>
                                </div>   
    
                                <div class="">
                                    <div class="font-menu font-em-d9">
                                    
                                        <div class="importing-groups">
                                            <div class="head fb-6">
                                                <div class="wid-fit">
                                                    <span class="c-orange-dd box bc-orange" style="height:10px; width:10px"></span>
                                                    Exporting Groups <br>
                                                </div> 
                                            </div>
                                            <div class="pvs-20">
                                                To export a stored a group, the <code>Res::export()</code> is used although this can be achieved using 
                                                <code>Res::import()</code>. Example below reveals how to export stored urls into variables
                                            </div>
    
                                            <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  $urls = ":lists";
  
  Res::import('', [':anime'], $urls);
  
  var_dump($url);
    </pre>
                                            </div> <br>
                                        
                                            <div class="d87 pvs-10">
                                                In example above, the variable <code>$url</code> was set with a value of 
                                                <code>:lists</code>, then supplied into the <code>Res::import()</code> method. 
                                                The directives tells the Resource class to update the value of <code>$url</code>
                                                with the stored urls. Hence, <code>$url</code> was printed out to the page. Another way to export 
                                                stored urls is shown below: <br><br>
                                            </div>
                                            
                                            <div class="box-full pre-area shadow flow-x">
    <pre class="pre-code">
  $exports1 = Res::export([':anime']);
  $exports2 = Res::export('../',[':anime']);
    </pre>
                                            </div> <br>
                                        
                                            <div class="d87 mvt-6">
                                            In example above, the first variable will contain the stored urls while line 2 adds a suffix of 
                                            <code>../</code> to imported local urls. The application of parent urls comes as a modification 
                                            to existing urls that may become invalid in static scripts. These helps to properly map the loaded urls to their 
                                            specific folders.
                                            <br><br>
                                            </div>
                                        </div> <br>
                                    </div>   
    
                                </div>
    
    
                                
 <div class="font-menu pvs-4">   </div>

                            </div>
                        </div>  
                

                    </div> <br>
                   

                </div>
           </div>
       </section>
    </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>