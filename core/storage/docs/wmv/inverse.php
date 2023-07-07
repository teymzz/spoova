<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>WMV - Errors</title>
    <?= Rexit::load('headers') ?>
    <style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-dd));
          font-family: "Poppins", "Roboto", sans-serif;
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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="font-em-1d5 c-orange">Window Inverse</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Spoova is a url-loose framework because it handles url comparison as a non-strict type. 
                            This means that a url <code class="calibri">"Home"</code> and <code class="calibri">"home"</code> are regarded to mean the same thing. 
                            There are certain situations that developers may want to be strict in defining window urls, especially 
                            in situations where urls are generated using <code class="calibri">base64_encode()</code> function. In this case,
                            handling case sensitive urls might be an issue. In order to fix this issue, spoova introduces two approaches which can be used to define 
                            case sensitive urls. 
                        </div> 
                    </div> <br>

                    <div class="">

                        <div class="c-olive">SELF::STRICT</div>

                        <div class="mvt-10">
                            The <code class="calibri">SELF::STRICT</code> key, when defined on a shutter, will set all urls to case sensitive. The value must be 
                            set as a boolean of <code class="calibri">true</code>. Once declared within a shutter, the shutter will remember to set all urls to case sensitive 
                            unless an inverse is declared which naturally negates the <code class="calibri">SELF::STRICT</code> key.
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',    <span class="comment no-select">// case sensitive url</span>
            
            'home/profile' => 'root', <span class="comment no-select">// case sensitive url</span>

             <span class="c-teal">SELF::STRICT => true,</span>    <span class="comment no-select">// set all urls as case sensitive</span>

        ])

    }
    
  }

</pre>
                        </div>
                    </div> <br>

                    <div class="">

                        <div class="c-olive">Inverse operator (<code class="calibri">!</code>)</div>

                        <div class="mvt-10">
                           The inverse operator, when declared upon any shutter url, defines that such url must be declared as strict type (i.e case sensitive). Since it is an inverse 
                           operator, in a situation where a <code class="calibri">SELF::STRICT</code> is already defined on a shutter, then applying the inverse <code class="calibri">!</code> operator will declare such
                           url as non-strict (or case insensitive). This relationship is explained below
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',     <span class="comment no-select">// case insensitive url</span>
            
            '<span class="c-brown">!</span>home/profile' => 'root', <span class="comment no-select">// case sensitive url (inverse)</span>

        ])

    }
    
  }

</pre>
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',     <span class="comment no-select">// case sensitive url</span>
            
            '<span class="c-brown">!</span>home/profile' => 'root', <span class="comment no-select">// case insensitive url (inverse)</span>

             <span class="c-teal">SELF::STRICT => true,</span> <span class="comment no-select">// set all urls as strict except inverse</span>

        ])

    }
    
  }

</pre>
                        </div>

                        <div class="foot-note mvt-10">
                            The examples above best explains the behavior of the inverse operator. on the urls. In the first code example, the natural 
                            shutter behavior was altered using the inverse operator. Likewise, in the second code example, the behavior of 
                            <code>SELF::STRICT</code> on urls was altered using the same operator. It is important to note that the <code>window()</code> 
                            method has also been integerated with the inverse method. Hence, the inverse operator can be used within the window method, for example, 
                            as <code>window('!:user')</code>. This is shown below.
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            window(':user') => 'root',     <span class="comment no-select">// case sensitive "home/user"</span>
            
            window('<span class="c-brown">!</span>:profile') => 'root', <span class="comment no-select">// case insensitive "home/profile"</span>

             <span class="c-teal">SELF::STRICT => true,</span> <span class="comment no-select">// set all urls as strict except inverse</span>

        ])

    }
    
  }

</pre>
                        </div>

                        <div class="foot-note">
                            In the sample above, the window function will understand to return the value with the inverse operator as its first character.
                            For example, assuming our root entry point on a window url is <code>home</code>, then while <code>window(':user')</code> will return <code>home/user</code> 
                            which will be compared as case-insensitive, 
                            <code>window('!:user')</code> will return <code>!home/user</code> which will be compared as a case-sensitive url unless this behaviour is inversely altered with 
                            <code>SELF::STRICT</code> constant. In the sample above, the <code>SELF::STRICT</code> option was set as <code>true</code> which will negate the default behaviour. 
                            Hence, <code>window(':user')</code> will become case-sensitive while the <code>window('!:user')</code> will become case-insensitive. 
                            Also, note that the <code>SELF::STRICT</code> inverse behaviour only affect shutters. Function such as <code>invoke()</code>, <code>windowExcludes()</code> and <code>windowIncludes()</code> will respond in 
                            their own individual default ways.
                        </div>

                    </div> <br>

                    <div class="">
                        <div class="c-orange"><span class="bi-circle"></span> Applying the inverse with window index resolver <span class="box rad-r bd-4 pxv-2 pxs-4">v2.5+</span></div>
                        <div class="pvs-16">
                            The window index resolver character <code>"@"</code> is usually applied to the <code>window()</code> function to 
                            ensure that a index page url always return the <code>index</code> name even if it is not defined in the current url. When working with inverse urls, 
                            we can supply this character by only after the inverse operator has been defined. This means that the inverse operator preceeds the index resolver. A sample 
                            format is shown below:
                        </div>
                        <div class="pre-area">
                            <pre class="pre-code">
  window('!@root:HoMe')
                            </pre>
                        </div>
                        <div class="foot-note">
                            In the sample above, assumming the specified current url resembles the format <span class="c-dodger-blue">http://localhost/app</span> which by default 
                            is expected to point to an index route, then if <code>window(':root/HoMe')</code> is equivalent to <code>/HoMe</code>, then 
                            <code>window('@root:HoMe')</code> will be equivalent to <code>index/HoMe</code> which is case-insensitive while the <code>window('!@root:HoMe')</code> will specify that the url is 
                            case-sensitive. However, it is important to note that in order to fix case-sensitity of window roots, this operation should be done with a 
                            <a href="<?= Rexit::domurl('version/1.5/map-file') ?>" class="c-olive rule-dotted">map file</a>. More information can also be found on map files <a href="<?= Rexit::domurl('docs/wmv#map-files') ?>" class="c-olive rule-dotted">here</a>.  
                        </div>
                    </div>

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


                </div>
            </div>
        </section>
    </div>
    
    
    

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>