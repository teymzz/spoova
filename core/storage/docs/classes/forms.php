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

                    <div class="font-em-1d5 c-orange">Forms</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                            <div class="">
                                This class is simply used to generate 
                                html forms. Before a <code class="bd-f">Form</code> class can be used, 
                                a form model must be initialized. Models contain rules which the form can use in order to 
                                validate created forms. These rules are then applied on each form based 
                                on their relativity with the database. The <code>Form</code> class 
                                accepts static calls on all form input types except a few like <code>date-local</code> and password 
                                fields.
                            </div> <br>

                            <ul>
                                <li> <a href="#model"> Model </a> </li>
                                <li> <a href="#init"> Init </a> </li>
                                <li> <a href="#open"> Open </a> </li>
                                <li> <a href="#set"> Set </a> </li>
                                <li> <a href="#field"> Field </a> </li>
                                <li> <a href="#label"> Label </a> </li>
                                <li> <a href="#group"> Group </a> </li>
                                <li> <a href="#groupeach"> GroupEach </a> </li>
                                <li> <a href="#close"> Close </a> </li>
                                <li> <a href="#isSaved"> isSaved </a> </li>
                                <li> <a href="#isValidated"> isValidated </a> </li>
                                <li> <a href="#close"> errors </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="fb-6 flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> Initializing Form class
                                </div>
                            </div>

                            <div class="">
                                To initialize a form element, the following proceedures must be followed
                                <ul>
                                    <li>create a form model class with a method rules that returns an array</li>
                                    <li>Initialize the Form class by supplying an instantiated form model into the Form <code>model</code> method</li>
                                    <li>Open the Form class using either <code>init</code> or <code>open</code> method</li>
                                    <li>Create an input field using the field name on the Form class.</li>
                                </ul>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Create Form model (sample)</div>
                                        <pre class="pre-code">
  &lt;?php 

    namespace spoova\mi\windows\Model;

    use spoova\mi\core\classes\Model;

    class FormModel extends Model{

        public function rules() : array {

            return []; <span class="comment">// Form Validation rules</span>

        }

    }
                                        </pre>
                                    </div>
                                </div>

                                <div class="foot-note">
                                    In the above, a form model was created with the <code>rules()</code>
                                    method which usually contain form validation rules. Once the model is created, 
                                    the instance of that model will be loaded into the Form class for management. 
                                    This is shown below.
                                </div>

                                <div class="pre-area">

                                    <div class=" pxs-10">
                                    </div>

                                    <div id="model" class="box-full">
                                        <div class="pxv-6 bc-off-white">Instantiate form model</div>
                                        <pre class="pre-code">
  Form::model(new FormModel);
                                        </pre>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div> <br>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="">
                            The following keywords should be noted:
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">keywords</div>
                                    <pre class="pre-code">
    <span class="comment">
  $Form  : referenced variable anchoring Form class instance (optional)

  method : request method (optional)

  action : form action (optional)

  type   : form input type (e.g email, password...)
    </span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div> <br>       

                    <div id="init" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> init
                                </div>
                            </div>

                            <div class="">
                                The <code class="bd-f">init()</code> method is used to open a form class in a automatic display mode.
                                This means that when it is used, the form generated will be automatically printed out to the 
                                page.
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: init</div>
 <pre class="pre-code">
  Form::init($Form, method, action);
 </pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="foot-note">
                            The referenced variable <code>$Form</code> will anchor the form instance itself.
                        </div>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: Opening form (init)</div>
                                    <pre class="pre-code">
   <span class="comment">//starting a new form in rendering mode</span>
   Form::init($Form, 'post', 'somepage.php');
                                    </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="open" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> open
                                </div>
                            </div>
                            <div class="">
                                The <code class="bd-f">open()</code> method is similar to the <code class="bd-f">init()</code> method 
                                except that rather than printing directly, it returns the generated content of a form. It takes the same parameters as the <code class="bd-f">init()</code> method.
                            </div>
                        </div> <br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: Opening form (open)</div>
                                <pre class="pre-code">
  <span class="comment">//starting a new form without automatic display</span>
  echo Form::open($Form, 'post', 'somepage.php');
                                </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div id="set" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> set
                                </div>
                            </div>
                            <div class="">
                                The <code class="bd-f">set()</code> method is used to overide the default form settings.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: set</div>
                                        <pre class="pre-code">
  Form::set($array); 
    <span class="comment">
    where: 

        $array = list of options which can be contains array index: 

        form_class  => This sets the forms global class attribute value which is applied on all <code>Form::Group()</code>
        field_class => This sets the form inputs class attribute value which is applied on all <code>Form::Field()</code> 
    </span>
                                        </pre>
                                    </div>
                                </div>          
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: set</div>
                                        <pre class="pre-code">
    Form::set([

        'form_class'  => 'form-flex', <span class="comment no-select">// add form-flex class to all form groups</span>

        'field_class' => 'field-item bg-primary' <span class="comment no-select">// add bg-primary class to all form fields</span>

    ]);
                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="field" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Field
                                </div>
                            </div>

                            <div class="">
                                This method is used to add a new form input field. The 
                                syntax and examples are shown below.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::Field($type, $name, $attrs); <span class="comment">// supplies data  to be hashed.</span>
    <span class="comment">
    where: 

        $type  : type of input field (e.g password)
        $name  : the name attribute value of the input field 
        $attrs : other added attributes and value pairs
                                        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  <span class="comment">// add a new form input password field</span>
  Form::Field('password', 'passfield');

  <span class="comment">// add a new form input email field with attributes</span>
  Form::Field('email', 'email', ['addClass'=>'i-flex']);  

  <span class="comment">// add a new form input field by calling the input type</span>
  Form::Email('email', ['addClass'=>'i-flex']); 

  <span class="c-dry-blue no-comment font-i">Supported types:</span>
  <span class="c-sky-blue-d">
  Email, Text, TextBox/Textarea, Pass/Password, Range, 
  Radio, Checkbox, Hidden, File, Number, Tel, Url, 
  Date, DateLocal {date-local}, Week, Month, Year, 
  Image, Color, CheckBox, Radio, Search, Submit, Button
  </span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <div class="">
                        <!-- some code here -->
                        </div>
                    </div>

                    <div id="label" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Label
                                </div>
                            </div>

                            <div class="">
                                This method add  an html label tag to forms.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::label($attrs, $content); 
        <span class="comment">
    where:
    
    $attrs: supplied attributes
    $content : text content of the label
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  Form::label(['class'=>'label'], 'Username'); <span class="comment"> // &#60;label class="label"&#62;Username&#60;/label&#62; </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="group" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Group
                                </div>
                            </div>

                            <div class="">
                                This method is used to group input fields. A group can only contain a  
                                direct group child or children. A grandchild group is not supported. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::Group(tag, content); 
  <span class="comment">
    where: 

        tag: html tag name (e.g div)
        content: function or string
  </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 1</div>
                                        <pre class="pre-code">
  Form::Group('div', fn() => 

    Form::Text('firstname').
    Form::Text('lastname')

  ); 
                                        </pre>
                                                        </div>
                                                        <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 2 : Adding class attribute and child Group </div>
                                        <pre class="pre-code">
  Form::Group('div class="i-flex"', fn() => 

    Form::Group('div', fn() => 
        Form::Text('firstname').
        Form::Text('lastname')    
    )

  ); 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="groupeach" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GroupEach
                                </div>
                            </div>

                            <div class="">
                                This method is used to apply a tag on each input 
                                element supplied. GroupEach can only be applied once. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::GroupEach($tagname, $content); <span class="comment"> // group each </span>
        <span class="comment">
    where: 

    $tagname : html wrapper tag (e.g div)
    $content : function or string
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  Form::GroupEach( 
    'div class="field"',

    Form::Text('firstname').
    Form::Pass('lastname')
  );
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="foot-note">
                            In the above, each input field created will have a wrapper of "div" with a class of field.
                        </div>
                    </div>

                    <div id="close" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> close
                                </div>
                            </div>
                            <div class="">
                                When a form is opened using <code>Form::open()</code> or <code>Form::Init()</code>, 
                                It is expected to be closed using <code>Form::close()</code> which closes the form tag.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: close</div>
                                        <pre class="pre-code">
  Form::close(); <span class="comment">//close a tag </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GroupEach</div>
                                        <pre class="pre-code">
  Form::GroupEach( 
    'div class="field"',

        fn() =>

            Form::Text('firstname').
            Form::Pass('lastname').
            Form::close()
  );
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="sample" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd pxs-10"> 
                                    SAMPLE STRUCTURE
                                </div>
                            </div>

                            <div>

                                <div class="">
                                    The example below is a sample structure of how to create form fields. <br>
                                </div> <br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 1: sample structure</div>
                                      <pre class="pre-code">
  Form::model($model); <span class="comment">// check <a href="<?= Rexit::domurl('docs/wmv/models') ?>">here</a> for how to create a model </span>

  Form::init($form, 'get'); 

  <span class="comment">//displays automatically because <code>init()</code> was used</span>
  Form::Group('div', fn() => 
        
     Form::GroupEach('div class="inputs"', fn() => 

        Form::Field('email', 'email', ['placeholder' => 'email'])
        .Form::Pass('password', ['placeholder' => 'password'])
        .Form::close()

     )

  );
                                      </pre>
                                    </div>
                                </div>
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 2: sample structure</div>
                                        <pre class="pre-code">
    Form::model($model); <span class="comment">// check <a href="<?= Rexit::domurl('docs/wmv/models') ?>">here</a> for how to create a model </span>
    
    Form::open($form, 'post');

    <span class="comment">//using echo to display result</span>
    echo Form::Group('div', fn() => 
        
        Form::GroupEach('div class="inputs"', fn() => 
        
            Form::Field('email', 'email', ['placeholder' => 'email'])
            .Form::Pass('password', ['placeholder' => 'password'])
            .Form::close()

        )

    );
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
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