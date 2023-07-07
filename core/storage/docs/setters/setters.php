
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
         

<!-- @lay('build.co.coords:header') -->

 

     

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
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>


                    <div class="font-em-1d5 c-orange"><i class="bi-toggles"></i> Setters and Getters</div> <br>  
                    
                    <div class="setters-intro">
                        <div class="">

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
                            </div>

                            <br>
                            <div>
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
                                <div class="font-em-d9 mvt-6">
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
                            </div><br>

                            <div>
                                <div class="c-orange">Modifying Key's Value</div>

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
                                <div class="font-em-d95 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) that needs to be modified or updated while the <code>VALUE</code> is the 
                                    new content of that <code>KEY</code>. The <code>HASH</code> defines the secure hash string used to set the key, if defined. 
                                    This means that whenever secure hash strings are used to lock a value when defined using <code>SETTER::SET()</code>, then such 
                                    hash must be provided by the <code>SETTER::MOD()</code> in order 
                                    for the value to be updated. If the <code>MOD()</code> (i.e modifier) hash does not match the one used to secure the <code>KEY</code>, 
                                    then an error is thrown.
                                </div>
<!-- code description ends -->
                            </div> <br>

                            <div class="">
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
                                <div class="font-em-d95 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) whose value needs to be fetched. Whenever a key is secured with an hash, then the 
                                    <code>HASH</code> string must be provided before the value of that key can be obtained. If the value of the <code>HASH</code> does not match, 
                                    an error is thrown. Also, if a KEY is not secured in <code>SET()</code> but <code>HASH</code> was provided in <code>GET()</code>, although the value 
                                    will be returned, an error will still be triggered discouraging such activity. 
                                </div>
<!-- code description ends -->
                            </div> <br>

                            <div class="">
                                <div class="c-orange">Detecting Existing Key</div>
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
                                <div class="foot-note">
                                    The code above will only set the key if it does not already exist. 
                                </div>
<!-- code description ends -->
                            </div> <br>

                            <div class="">
                                <div class="c-orange">Setter Helper Functions</div>
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

  <span class="c-green-l">GET('NAME 2')</span> <span class="comment">// returns Rolland</span>
  <span class="c-orange-dd">GET('NAME 2', 'hash234')</span> <span class="comment">// returns Rolland, but triggers error</span>

  <span class="c-red-dd">GET('NAME 3')</span> <span class="comment">// invalid hash triggers error</span>
  <span class="c-green-l">GET('NAME 3', 'hash123')</span> <span class="comment">// returns Charley</span>
  <span class="c-red-dd">GET('NAME 3', 'hash234')</span> <span class="comment">// invalid hash triggers error </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d95 mvt-8">
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

                            </div>


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