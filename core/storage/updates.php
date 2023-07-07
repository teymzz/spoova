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

               
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>


               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dry-blue-d"> 
                          <span class="bi-wrench-adjustable-circle font-em-d85" hidden></span>
                          <span class="c-deep-blue fb-9 fira">S</span><span class="c-dry-blue-dd boxigen">poova 2.5!</span>
                        </div>
                    
                        <div class="font-em-d8">
                            <h4 class="c-violet"> <span class="fb-7 font-em-d9 in-flex mid px-40 rad-r c-white-dd" style="background-color:#d27adf">2.5</span> <span class="calibri fb-6">IS HERE</span></h4>
                            The <code class="bd-f"><span class="c-violet">version 2.5.0</span></code> release is out. This version focuses on stablizing the entire framework with improvements made 
                            on the window management system and how it resolves urls. The other fixes focuses on improving helper functions and some important core classes within the framework such as 
                            Filemanager, Forms and Session classes. With the new release, the framework's documentation is now available online. 
                        </div> <br>
                    </div>
                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div id="cli-fix" class="bi"> <span class="bi-terminal"></span> Cli improvements </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Some command-line commands were detected to have major issues. These commands include <code>project</code> used for creating new project applications,
                                 <code>config:all</code> used for configuration of new files and the <code>migrate</code> command which is used for generating migration files. The errors 
                                 thrown by these methods have been successfuly resolved. 
                            </p>
                            
                        </div>
                    </div> <br>  

                    <div id="form-validation" class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-layers"></span> Form validation improvements</div>  
                        </div>
                        
                        <div class="pxv-20 font-em-d8">
                            The Form class was improved in three different ways. The first improvement is made through the addition of new form methods which are <code>Form::castError()</code>, 
                            <code>Form::castedErrors()</code>, <code>Form::dataval()</code> and <code>Form::onpost()</code> methods. The second and third improvement is made through the introduction of 
                            <code>formerror()</code> function and <code>@formerror()</code> template directive. These improvements are made to enable the easy handling of form validation errors.
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">Form::castError()</div>
                                <div class="pxv-10">
                                    This function is used to save entire response of <code>Form::error()</code> into a unique 
                                    storage space where it can be obtained later after a form validation has been initialized. 
                                    A sample format is shown below:
                                </div>
                                <div class="pxs-10">
                                    <div class="pxs-10">
                                        <div class="pre-area">
                                            <pre class="pre-code">
  Form::model(new SampleModel);

  Form::loadData((new Request)->data());

  Form::isAuthenticated();

  Form::castError('login');
                                            </pre>
                                        </div>
                                    </div>
                                    <div class="">
                                        In the sample above, the <code>castError()</code> method is used to save any error response found into <code>"sample"</code> 
                                        unique name which can later be accessed by the <code>Form::castedError()</code>, <code>formerror()</code> or <code>@formerror()</code> directives.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">Form::castedError()</div>
                                <div class="pxv-10">
                                    This method returns the error saved through <code>Form::castError()</code> method by supplying the unique name 
                                    with which the error is saved along with a unique error key name that is expected to be returned. Internally generated error keys include <code>csrf:title</code>, 
                                    <code>csrf:info</code>, <code>mod:</code>, <code>index:</code> and <code>any:</code>. Learn more about casted errors from 
                                    <a href="<?= Rexit::domurl('docs/forms#formerror') ?>" class="c-olive">here</a>.
                                </div>
                            </div>
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">Form::dataval()</div>
                                <div class="pxv-10">
                                    This method returns the corresponding value of a key in the form request data.
                                </div>
                            </div>
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">Form::onpost()</div>
                                <div class="pxv-10">
                                    This method is used to perform a callback function only when a post request is forwarded. The 
                                    sample of usage is shown below:
                                </div>
                                <div class="pxs-10">
                                    <div class="pre-area">
                                        <pre class="pre-code">
    Form::onpost(function() {

        echo "This is a post request";

    });
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10 bc-silver">Form::register()</div>
                                <div class="pxv-10">
                                    This is a new method for registering a form. It is used mainly for performing activities 
                                    such as signup and login of a user session. A usage sample is shown below:
                                </div>
                                <div class="pxs-10">
                                    <div class="pre-area">
                                        <pre class="pre-code">
    Form::onpost(function() {

        Form::register('email', function($userinfo){

            User::login($userinfo);

        });

    });
                                        </pre>
                                    </div>
                                    <div class="">
                                        The example above is a simple way to register a user session through the <code>Form::register()</code> function. The first argument 
                                        points to a request data key whose corresponding value is assumed to be the expected session's <code>userid</code> that is later used by 
                                        the <code>User::login()</code> to initialize a new session.
                                    </div>
                                </div> <br>
                            </div>
                        </div>

                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10">
                                    More information about the <code>Form</code> class is provided <a href="<?= Rexit::domurl('docs/forms') ?>" class="c-olive">here</a>.
                                </div>
                            </div> <br>
                        </div>
                    </div> <br> 

                    <div id="session-management" class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-exclamation-circle"></span> Session management </div>  
    
                        </div>                        
                        <div class="pxv-20 pvb-1 font-em-d8">
                            <p>
                                In earlier versions of the framework, sessions were managed using the global session storage. This version 
                                has included more methods that can be easily used to manage sessions. More information about these new methods 
                                are available <a href="<?= Rexit::domurl('docs/sessions') ?>" class="c-olive">here</a>.
                            </p>

                            <div class="bc-white pxv-10">
                                <div class="pre-area">
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            Assuming we are currently on a web page whose url address is 
                                            <span class="c-dodger-blue">http://localhost/app/</span>, this url 
                                            is assumed to be the index page after the project folder name "app", 
                                            the following responses will be returned when any of the url patterns 
                                            is supplied into the window function. 
                                        </span>
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app/</span>

  window('root'); <span class="c-slate-grey">// empty string</span>
  window('base'); <span class="c-slate-grey">// empty string</span>
  window('path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            Assuming we are currently on the same index page but the url address 
                                            resembles the format: 
                                            <span class="c-dodger-blue">http://localhost/app/index</span>, this url, 
                                            the following will be responses of the window function. 
                                        </span>                                        
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app/index</span>
  
  window('root'); <span class="c-slate-grey">// 'index'</span>
  window('base'); <span class="c-slate-grey">// 'index'</span>
  window('path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            In the samples above, although the two url addresses points to the same <code>index</code> page, 
                                            the responses when the <code>index</code> name is actually supplied is a bit different. This could 
                                            cause errors especially when working with window shutter methods. The new version of the framework introduces 
                                            a new way to address this issue by supplying the <code>"@"</code> symbol on the paths which are expected to be 
                                            resolved. The sample below shows how the first url will respond when the <code>"@"</code> character is prepeded to 
                                            the argument 
                                        </span>                                        
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app</span>
  
  window('@root'); <span class="c-slate-grey">// 'index'</span>
  window('@base'); <span class="c-slate-grey">// 'index'</span>
  window('@path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>                                   
                                </div>
                            </div>

                        </div>  <br>                    
                    </div> <br>

                    <div id="window-improvements" class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-exclamation-circle"></span> Windows improvements </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8">
                            <p>
                                Although, like many other frameworks, spoova favors the MVC pattern, yet the entire systems is managed 
                                through a windows-approach which determines how routes are resolved based on three major patterns which are 
                                <code>root</code>, <code>path</code> and <code>base</code> url patterns. The <code>windows()</code> 
                                function is one which provides a great help when working with routes. In ealier versions of the framework, the 
                                <code>window()</code> function returns the following responses when supplied with any of url patterns:   
                            </p>

                            <div class="bc-white pxv-10">
                                <div class="pre-area">
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            Assuming we are currently on a web page whose url address is 
                                            <span class="c-dodger-blue">http://localhost/app/</span>, this url 
                                            is assumed to be the index page after the project folder name "app", 
                                            the following responses will be returned when any of the url patterns 
                                            is supplied into the window function. 
                                        </span>
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app/</span>

  window('root'); <span class="c-slate-grey">// empty string</span>
  window('base'); <span class="c-slate-grey">// empty string</span>
  window('path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            Assuming we are currently on the same index page but the url address 
                                            resembles the format: 
                                            <span class="c-dodger-blue">http://localhost/app/index</span>, this url, 
                                            the following will be responses of the window function. 
                                        </span>                                        
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app/index</span>
  
  window('root'); <span class="c-slate-grey">// 'index'</span>
  window('base'); <span class="c-slate-grey">// 'index'</span>
  window('path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>
                                    <div class="fira font-em-d9 pxv-10 pvb-1">
                                        <span class="comment">
                                            In the samples above, although the two url addresses points to the same <code>index</code> page, 
                                            the responses when the <code>index</code> name is actually supplied is a bit different. This could 
                                            cause errors especially when working with window shutter methods. The new version of the framework introduces 
                                            a new way to address this issue by supplying the <code>"@"</code> symbol on the paths which are expected to be 
                                            resolved. The sample below shows how the first url will respond when the <code>"@"</code> character is prepeded to 
                                            the argument 
                                        </span>                                        
                                    </div><br>
                                    <pre class="pre-code bc-silver">
  URL: <span class="c-dodger-blue">http://localhost/app</span>
  
  window('@root'); <span class="c-slate-grey">// 'index'</span>
  window('@base'); <span class="c-slate-grey">// 'index'</span>
  window('@path'); <span class="c-slate-grey">// empty string</span>
                                    </pre>                                   
                                </div>
                            </div>

                        </div>
                        
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="bc-white">
                                <div class="pxv-10">
                                    It is suggested to learn more on <a href="<?= Rexit::domurl('docs/wmv') ?>" class="c-olive">WMV Pattern</a> 
                                    and <a href="<?= Rexit::domurl('docs/wmv') ?>" class="c-olive">Shutter calls</a> to have a good understanding of how the 
                                    <code>window()</code> function is used within the window system. It is also suggested to visit 
                                    <a href="<?= Rexit::domurl('docs/wmv/inverse') ?>" class="c-olive">window inverse</a> to understand how this can be applied with 
                                    the inverse operator.
                                </div>
                            </div> <br>
                        </div>

                    </div> <br> 

                    <div class="font-em-d8 pvs-10">
                        For more details on spoova versions, you can track the spoova version updates from <a href="<?= Rexit::domurl('version') ?>" class="c-olive ch-dodger-blue-d">here</a>.
                    </div> <br> 

                </div>
           </div>
       </section>
   </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>