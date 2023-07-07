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
          font-family: "Poppins", "Roboto", sans-serif;
     }

     .bc-v-title{
          background-color: #a6a6bc;
     }

     .tutorial{
          min-height:100vh;
          font-family: "Poppins";
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
          font-family: "Firacode";
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
    color: rgb(173, 171, 171);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
}

body.--theme-dark .bc-sea-blue{
    background-color: rgb(29, 34, 59);
    color: rgb(164, 160, 160);
}

body.--theme-dark .bc-blue.c-white{
    background-color : rgb(35, 25, 66);;
    box-shadow: none;
    color: #8c8cb5;
    margin-bottom: 8px;
}

body.--theme-dark .nav-left .theme-btn .fav-ico{
    background-image: url("<?= Rexit::mapp('images/icons/favicon-white.png') ?>");
}

body.--theme-dark .nav-left .ico-pane{
    color:white;
    background-color: rgb(29, 35, 68);
}

body.--theme-dark .nav-left ul a{
    color: rgb(129, 125, 120);
}

body.--theme-dark .nav-left ul a.active{
    color: orange;
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

body.--theme-dark :is([class^="i-flex"]){
    background-color: #43435e;
    color:white;
}
body.--theme-dark :where([class^="i-flex"]) .flex-ico{
    background-color: #4d4d6f;
    color: #c0c5d0;
}

body.--theme-dark :where([class^="i-flex"]) .c-orange.line{
    color: #55557c;
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
body.--theme-dark .bc-v-title{
    background-color: #656469;
}
 </style>
<style rel="build.css.navbars"> 

     .nav-left{
          min-height: 100vh;
          width: 300px;
          background-color: rgba(var(--white-dd));
          display: inline-block;
          left: -300px;
          transition: left .2s ease-in-out;
          z-index: 1;
     }

     .nav-left.in{
          left: 0;
     }

     .nav-left .theme-btn .fav-ico{
          background-image: url("<?= Rexit::mapp('images/icons/favicon.png') ?>");
     }

     body .nav-left .ico-pane {
          color: #4853db;
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
    <?= Res::live() ?>
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
         

    

     

     <nav class="nav-left fixed">

          <div class="flex ico-pane pxv-10">
               <div class="flex-icon theme-btn navtheme bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin fav-ico" style="transition: none;"></div>
                    <div class="font-em-1d2 fav-text px-40 flex mid overlay fb-2 fira" style="top:-1.1px; left:.4px; z-index: 1;">
                         s 
                    </div>
               </div>
               <a href="<?= Rexit::domurl() ?>" class="flex inherit">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square calibri">
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



   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> 
                          <div class="px-80 bd-2 in-flex mid"> 2.0+ </div>  Resource class 
                        </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10">
    
                            <div class="bi"> <span class="bi-circle"></span> Resource urls (&lt; 2.0) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1">

                            <div>
                            The resource class already makes it possible to group static urls into specified group names through the <code>Res::name()</code> method just as  
                            shown below: <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')
        ->url('some_css_url_2.css')
        ->url('some_js_url.js')

      ->name('footers')
        ->url('some_css_url_1.css')
        ->url('some_css_url_2.css')
        ->url('some_js_url.js')
        
      ->urlClose();

    </pre>
                                </div>

                                <div class="foot-note">
                                  Once the group names are defined, we can then go on to import the groups into the 
                                  template file with the defined group names using the <code>@res()</code> directive 
                                </div>

                                <div class="pre-area bc-white pxs-10 mvs-10">
    <pre class="pre-code">
@res(':header') <span class="comment">//import all declared header urls</span>
    </pre>
                                </div> <br>

                                <div class="foot-note">
                                  We can also use the <code>&lt;?= Res::import() ?&gt;</code> method similarly outside the template file. Only the urls in 
                                  the called group will be imported to the webpage rather than having to call them one after the other in multiple files. 
                                  While this is easy to use, one major issue could be that if we need a url from another group into a new group, we need to set the group name and url again. 
                                  If we happen to use the same url in multiple groups and the list is long, it may be difficult to manage a url 
                                  multiple times especially if we have to change the path of a file. In order to resolve this issue, version 2.0 provides new methods which helps to properly name urls 
                                  making it easier to manage all urls as deemed fit.
                                </div>
                                
                                <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10">
    
                            <div class="bi"> <span class="bi-circle"></span> Resource urls (2.0+)</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1">

                            <div>
                                In version 2.0, each url can be given a unique name that makes it easier to call it as a group 
                                or as an single file. <br><br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1') <span class="comment">//set unique name</span>
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')

      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        
      ->urlClose();

    </pre>
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
@recall('css1', 'css2', 'js2') <span class="comment">//call files by unique name</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  In route files, we can also use the <code>Res::recall()</code> method or the <code>recall()</code> helper function to achieve a similar response. While 
                                  the <code>recall()</code> function is similar to <code>@recall()</code> directive, the <code>Res::recall()</code> 
                                  is slightly different as it can only call a single unique name at a time. 
                                  
                                 </div> <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;?php

Res::recall('css1'); <span class="comment">//calling unique name returns a script or list of scripts</span>
Res::recall('css1', true); <span class="comment">//calling unique name returns an array of scripts</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  The second line above is useful in helping to know the number of scripts existing in a single unique group. This is not possible in the first line because it 
                                  returns a string rather than an array. In cases where multiple unique names are required, then the helper function <code>recall()</code> makes this operation easier. 
                                  However, since the files are used within template files, the directive <code>@recall()</code> or <code>@load()</code> will at most times be used. The introduction of these 
                                  approaches even makes it easier to generate groups using defined names rather than their real path. 
                                </div> <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1')
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')

      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        
      ->bind('cssgroup', ['css1','css2'])
      ->bind('jsgroup', ['js1','js2'])
        
      ->urlClose();
    </pre>
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
@recall('cssgroup') <span class="comment">//each script of specified group will be returned to the webpage.</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  In the example above, new groups were created using the uniquely specified names of 
                                  the stored file urls. Once the group is created with its unique name, then name can then be 
                                  used in the template files. It is essential to know that the <code>bind()</code> method's group name supplied as 
                                  the first argument must be unique name. The resource methods <code>named()</code>, <code>bind()</code> and 
                                  <code>bindTo()</code> all share the same unique storage space. This means that any name supplied in any of these 
                                  methods cannot be unique in another method of the same group although, the <code>bindTo()</code> method is slightly 
                                  different. This is shown below:
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1')
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')
        ->bindTo('headers')
        
      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        ->bindTo('footers')
        ->bindTo('headers', ['js2'])  

      ->bind('cssgroup', ['css1','css2'])
      ->bind('jsgroup', ['js1','js2'])
        
      ->urlClose();
    </pre>
                                </div>

                                <div class="foot-note">
                                  The example above explains how the <code>bindTo()</code> method works. The code structure is explained below: <br>
                                  <br> 
                                  <ul>
                                    <li>When <code>bindTo()</code> is used immediately after a set of named urls, it binds 
                                      only the previously named urls into a new unique group. The new unique group name
                                      has nothing to do with the one defined through the global <code>name()</code>. For example, the <code>bindTo('headers')</code> will 
                                      add all the previously named urls into the supplied unique name <code>"headers"</code> while in the case of 
                                      <code>bindTo('footers')</code> only the named url <code>"js2"</code> will be added to the new unique group name.
                                    </li><br>
                                    <li class="">
                                      The method supports adding more files to a previously declared group, however, two arguments must be supplied. 
                                      The first argument is the existing unique name while the second argument is the array containing unique names of urls to be added to 
                                      the group. For example, in the above <code>bindTo('headers', ['js2'])</code> adds the url of <code>"js2"</code> to existing unique 
                                      group <code>"headers"</code>
                                    </li><br>
                                    <li class="">
                                      When <code>bindTo()</code> is used, all named urls before it will be added into the new group regardless of their parent groups. 
                                      Once the method is used, the previous named groups will be safely exited without affecting their unique names.
                                    </li>
                                  </ul>
                                </div>

                                <br><br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="">
                      <div class="c-orange"> <span class="bi-lightbulb"></span> Notice </div>
                      <div class="">
                        <ul class="pxl-20">
                          <li>
                            The custom global urls are stored and loaded from the <code>res/res.php</code> file.
                            The main static files declaration have been moved to a more private directory <code>core/res.php</code> to remove visual noise.
                          </li>  
                          <li>
                            While the names <code class="bd-f">"headers"</code> and <code class="bd-f">"footers"</code> are reserved, more urls can be 
                            added into them. This can be done by either using <code>bindTo()</code> for unique names or by using the <code>name()</code> 
                            method for global namespace.
                          </li>  
                          <li>
                            Methods that shares unique name space cannot redefine a unique name. These methods are <code>named()</code>, <code>bind()</code> and <code>bindTo()</code>. The <code>bindTo()</code> can only 
                            add more urls, it cannot redeclare an existing name unless the entire class is started on a strict mode using the <code>urlOpen(true)</code> method which entirely clears all previous declarations. 
                          </li>  
                          <li>
                            When a non-existing unique name is called, an empty string is returned. However, if a unique name is redeclared, 
                            an error is thrown.                        
                          </li>  
                        </ul>
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