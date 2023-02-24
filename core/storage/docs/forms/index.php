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



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial mails bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/forms">Forms</a>  </div>


                <div class="start font-em-d8">
                    <div class="font-em-1d5 c-orange">Handling Forms</div> <br>  
                    
                    <div class="pulling-data">
                        <p>
                            The <code>Form</code> class handles all form data that are sent through request. An
                            introduction into <code>Form</code> methods was given under <a href="<?= DomUrl('docs/classes/forms') ?>" class="c-gold-dd">helper classes</a>. 
                            This section will focus more on form validations in relation with the request class.
                        </p>
                        <p>
                            All form data request are suggested to be obtained by using the Request class. This enables us to perform 
                            necessary form validations. For any data to be sent, a form model must be created which anchors the necessary rules 
                            required for validation. In order to futher expantiate on this, different syntaxes are defined below which are later 
                            discussed. Form validations are managed in three levels. These are the strict, non-strict, timed and input validations.
                        </p>

                        <p>
                            <div class="font-em-1 c-orange">Fetching Request Data : Non-Strict Type</div> 
                            <div class="mvs-10">
                                Request data can be fetched using the <code>$Request->data()</code> method. For example: 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;
  $Formdata = $Request->data();
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return the form data sent from request by default, 
                                    if the <code>&#64;csrf</code> directive is not supplied, the data returned will be an empty array. In order 
                                    to ensure that all data supplied are accepted, each form must have a <code>&#64;csrf</code> directive attached to it. 
                                    <!-- <code>strict()</code> or <code>expires()</code> method is previously called on the request. 
                                    The <code>strict()</code> method prevents the page from loading data returning an error page if the csrf token requested is not 
                                    a valid one.     -->
                                </div>
                            </div>
                        </p>

                        <p>
                            <div class="font-em-1 c-orange">Fetching Request Data : Strict Type</div> 
                            <div class="mvs-10">
                                Strict data fetching resolves to an error page if crsf token is not a valid one. 
                                A csrf token may become invalid if it does not match the token set at run-time or the token has expired if timed. 
                                For example: 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  $Request->strict();
  $Formdata = $Request->data();
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return form data sent from request or an empty array if 
                                    no csrf token is set, if the strict method is applied, the request page will return a csrf default error page preventing any further action.
                                </div>
                            </div>
                        </p>

                        <p>
                            <div class="font-em-1 c-orange">Checking Request Data</div> 
                            <div class="mvs-10">
                                An empty data may be returned due to an invalid token, this does not mean that data sent 
                                cannot be checked to see if it contains a particular key. The <code>has()</code> method allows the checking of data forwarded before it is returned. 
                                This is useful in cases when we may want to detect the type of button clicked. An example is shown below:
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  if($Request->has('submit')){

      $Request->strict();
      $Formdata = $Request->data();

  }
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    In the above, notice that the <code>strict()</code> method comes after the <code>has()</code> function.
                                    This is because setting the strict type affects the <code>has()</code> method too and prevents it from checking 
                                    any data if the token is not valid.
                                    <!-- <code>strict()</code> or <code>expires()</code> method is previously called on the request. 
                                    The <code>strict()</code> method prevents the page from loading data returning an error page if the csrf token requested is not 
                                    a valid one.     -->
                                </div>
                            </div>
                        </p>

                        <p>
                            <div class="font-em-1 c-orange">Timing Request Data - Timed Token</div> 
                            <div class="mvs-10">
                                A request can be timed by using the <code>expires()</code> method. This tells the data the 
                                number of seconds required in order for a data to be sent. If a data is not sent within the 
                                required number of seconds, the data sent is not accepted hence, it returns an empty array. It should 
                                be noted that even if a <code>csrf</code> token has expired leading to an empty data, the
                                <code>has()</code> method will still allow the checking of data forwarded. The <code>expires()</code> method 
                                has no effect on the <code>has()</code> method unless a <code>strict()</code> method is declared along with it. 
                                An example is displayed below:
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  if($Request->has('submit')){

      $Request->strict()->expires(5);
      $Formdata = $Request->data();

  }
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    In the above, the csrf token expires in "5 seconds". This pushes the data to return empty data but because the strict method
                                    is set upon it, the request returns an error page if the token expires or becomes invalid.
                                </div>
                            </div>
                        </p>

                        <p>
                            
                            <div id="data-validation" class="font-em-1d5 c-orange">Data Validation</div>  

                            <div class="mvs-10">
                                The first level of authentication encountered is the csrf token validation which determines if data forwarded is accepted 
                                or rejected. When data fowarded is accepted having passed through the first stage successfully, then it proceeds
                                to validate each form input data required to be validated. This is done through the Model class. The <code>Model</code> class 
                                not only enables us authenticate form data but it also allows us to save the data into the database. Other features of this class 
                                include input-column mapping which allows the form input name to properly select its relative database column field where the data is expected to 
                                be inserted. Consider the following Model class structure: 
                            </div>
<div class="pre-area">
    <pre class="pre-code">

  namespace spoova\windows\Models;
  
  use spoova\core\classes\Model;
  
  class LoginModel extends Model {
  
      
      protected $username;
      protected $password;
      
      public function __construct(){
  
          //your code here...
  
      }
  
      <span class="comment">/**
       * Validation rules
       *
       * @return array
       */</span>
      public function rules(): array {
  
          return [
              'username' => [SELF::RULE_REQUIRED],
              'password' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2]
          ];
  
      }
  
      <span class="comment">/**
       * Determines if a form authentication is completed 
       *
       * @return bool
       */</span>
      public static function isAuthenticated(): bool {
  
          return true; <span class="comment">//some validation test code is expected here.</span>
  
      }  

      <span class="comment">/**
       * set table name where data is inserted
       *
       * @return string
       */</span>
      public static function tablename(): string {
  
          return 'users'; <span class="comment">//default table name</span>

      }

      <span class="comment">/**
       * input field names mapped with relative database column name 
       *
       * @return string
       */</span>
      public static function mapform(): array {
  
          return [
              'username' => 'user',
              'password' => 'pass'
          ];
  
      }
  
  }
    </pre>
</div>
                            <div class="font-em-d87 mvt-10">
                                The code above simulates a LoginModel that validates a username and password field. The <code>rules()</code> 
                                method defines the authentication needed for each field. The <code>mapform()</code> maps the input field with 
                                attribute name of "username" to "user" field in database and a similar thing is done for the password field. This 
                                may be needed to protect the database field names. When all data is authenticated, <code>tablename()</code> sets the 
                                database table where the data supplied is inserted. The <code>isAuthenticated()</code> returns true by default if no 
                                error occurs. However, this function is determined to be called only if <code>Form::isAuthenticated()</code> method is called.
                                The <code>Form::isAuthenticated()</code> by default calls the <code>Form::isValidated()</code> method. This process is explained below
                            </div> <br>
                        </p>

                        <p>
                            <div class="font-em-1d5 c-orange">Data Loading</div> 

                            <div class="">
                                In order to use the LoginModel defined above, it must be applied to a <code>Form</code> class.
                                The Form class uses the model to perform its operations. Example is shown below:
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  &lt;?php
    
    use spoova\core\classes\Request;
    use Form;

    $Request = new Request;

    if($Request->has('submit')){

        $Request->strict()->expires(5);

        Form::loadData($Request->data());

        <span class="c-lime-dd">(Form::isValidated() && Form::isSaved());</span>

    }

    $errors = Form::errors($inputErrors);
    
    </pre>
</div>                      
                            <div class="font-em-d87 mvt-10">
                                In few lines above we've been able to perform several operations such as checking for button submission,
                                restricting invalid forms, validating form data and saving the data into database. The <code>LoginModel</code> 
                                defines what table and what field the validated data is inserted in the database. In the above, the request data returned by 
                                <code>$Request->data()</code> is loaded directly into 
                                the <code>Form</code> class using <code>loadData()</code> method. The data is then validated using the <code>Form::isValidated()</code> 
                                method. Lastly, the form is saved into the database table "users" defined within the <code>tableName()</code> method of <code>LoginModel</code> class. 
                                Although, in all of these processes, no error was obtained, this is because the <code>Form::errors()</code> allows us to fetch all required errors 
                                depending on the stage where the error occurred. All form input errors only are obtained by reference through the <code>$inputErrors</code> while 
                                the entire errors returned by the <code>errors()</code> method are obtained into the <code>$errors</code> variable. Form errors are further explained under form errors.
                                Since the <code>Form::isAuthenticated()</code> can naturally call the model's <code>isAuthenticated()</code> method, The code line 
                                <code>(Form::isValidated() && Form::isSaved())</code> can be returned from the model's <code>isAuthenticated()</code> method and called simply by 
                                writing <code>Form::isAuthenticated()</code>
                            </div> <br>
                        </p>

                        <p>
                            <div id="form-rules" class="font-em-1d5 c-orange">Form Rules</div>  

                            <div class="">
                                There are several rules that can be applied in form input validation. Once these rules are defined within a Model, the model uses such rules 
                                to validate form inputs based on their attributes. The following rules can be applied on form inputs:
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  RULE_REQUIRED  <span class="comment">// Defines an attribute that must be filled</span>
  
  RULE_NOSPACE  <span class="comment">// Defines an attribute that cannot contain spaces</span>
  
  RULE_TEXT  <span class="comment">// Defines an attribute that can only contain alphabets</span>
  
  RULE_MIN  <span class="comment">// Sets a minimum length of characters accepted on a form input</span>
  
  RULE_MAX  <span class="comment">// Sets a maximun length of characters accepted on a form input</span>
  
  RULE_UNIQUE  <span class="comment">// Sets an attribute that must not exist in the database</span>
  
  RULE_MATCHES  <span class="comment">// Sets an attribute that must match another attribute and must not be empty</span>
  
  RULE_EMAIL  <span class="comment">// Defines an attribute and must be of email format</span>
  
  RULE_NOT  <span class="comment">// Defines an attribute that must not be exactly the same as another form attribute(s) value(s)</span>
  
  RULE_UNLIKE  <span class="comment">// Defines an attribute that must not look like another attribute(s) whose names must be set</span>
  
  RULE_NUMBER  <span class="comment">// Defines an attribute that must be numeric</span>
  
  RULE_PHONE  <span class="comment">// Defines an attribute that must have a phone numer format</span>
  
  RULE_URL  <span class="comment">// Defines an attribute that must have a url address format</span>
  
  RULE_NOT_CHARS  <span class="comment">// Defines an attribute that must not have a character exisiting in a list of defined characters that is set</span>       
  
  RULE_NOT_RANGE  <span class="comment">// Defines an attribute that must have its value within a specified range or list only</span>       

</pre>
</div>                      

                        </p>

                        <p>
                            <div  id="managing-errors" class="font-em-1d5 c-orange">Managing Errors</div>

                            <div class="">

                                <div class="pvs-10">
                                    Errors management include error modification through custom ways and error fetching. Errors returned by the <code>Form</code> class are classified 
                                    into four forms: 
                                </div>
                                <ul>
                                    <li>CSRF errors</li>
                                    <li>Input errors</li>
                                    <li>Database errors</li>
                                    <li>Custom errors</li>
                                </ul>
                                <div class="pvb-10">
                                    The last type of error is defined through a flash message:
                                </div>
                                <ul>
                                    <li>User id error notice</li>
                                </ul>
                            </div>

                            <div>
                                <div class="font-em-1 c-orange pvs-2">CSRF Errors</div>  
                                <div class="mvs-10">
                                    Csrf errors are errors that are returned when a token is not valid. These errors are returned by the <code>Form::errors()</code> into an array 
                                    key specified as <code>:csrf</code> which contains only two subkeys <code>title</code> and <code>info</code> which contains the type of error and 
                                    the description of that error respectively. The <code>title</code> and <code>info</code> returned is determined by the kind of error that occured. 
                                    Under this subheading, errors are classified as default, invalid and session. When a token is missing, a default error is returned. When a token does not 
                                    match an invalid error is returned while the session error only returnes when a token has expired. In order to access the <code>:csrf</code> errors, an 
                                    helper function <code>error()</code> makes this easy shown below:
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error(':csrf', 'title'); <span class="comment">// return the csrf last error title</span> 
    error(':csrf', 'info');  <span class="comment">// return the csrf last error info</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    Remember that error displayed are determined on the type of error that occured. Also, the error returned for 
                                    each type can be customized as revealed below:
                                </div> <br>
                                <div class="pre-area">
    <pre class="pre-code">
&lt;?php
    
    use spoova\core\classes\Request;
    use Form;
    use Csrf;

    $Request = new Request;

    if($Request->has('submit')){

        Csrf::setError('default', 'csrf request failed');   <span class="comment">// set title for default</span>
        Csrf::setError('invalid', 'csrf token mismatched'); <span class="comment">// set title for invalid</span>
        Csrf::setError('session', 'csrf session expired');  <span class="comment">// set title for expired csrf</span>

        Csrf::setError('default', ['title' => 'some title', 'info' => 'some info']);<span class="comment">// set title and info using array</span>

        $Request->strict()->expires(5);

        Form::loadData($Request->data());

        (Form::isValidated() && Form::isSaved());

    }

    $errors = Form::errors();      <span class="comment">//return all errors</span> 

    print_r($errors[':csrf']);     <span class="comment">// return only csrf last error (both title and info)</span> 
    print_r(errors(':csrf'));      <span class="comment">// same as above</span> 

    print error(':csrf', 'title'); <span class="comment">// return only csrf last error title</span> 
    print error(':csrf', 'info');  <span class="comment">// return only csrf last error info</span> 
    
    </pre>
                                </div>
                                                                                    
                                <div class="font-em-d87 mvt-10">
                                    In the above, we successfully modified our error to a new message. The second argument of <code>Csrf::setError()</code> should be string depending 
                                    which will make it accesible. Also, The <code>error()</code> will only return the title or info 
                                    for the type of error that occured.
                                </div>
                                
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">Input Errors</div>  
                                <div class="mvs-10">
                                    Input errors occurs when form input validation fails. These errors are also stored within the form errors and can be accessed 
                                    using the relative attribute's name. The <code>error()</code> helper function only returns the first error encountered by each attribute, that is 
                                    , the topmost error index. An example of this is shown below:
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error('username'); <span class="comment">// return the csrf first error encountered for username</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    When no errors exists, for the defined attribute <code>error()</code> function just returns empty without throwing any errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Database Errors</div>  
                                <div class="mvs-10">
                                    Database errors occurs when database operation fails due to one reason or the other. This could prevent saving of data into database. The 
                                    <code>Form::error()</code> also allows fetching of these errors using key names such as <code>:dbi</code>, <code>:dbe</code> and <code>:dbm</code>
                                    The named keys can be supplied into <code>error()</code> to obtain their respective values.
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error(':dbm'); <span class="comment">// something is wrong</span> 
    error(':dbe'); <span class="comment">// database error: something is wrong</span> 
    error(':dbi'); <span class="comment">// sql error (fully stated accoring to type of error)</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    The <code>:dbi</code> is the only key that displays the type of database error that occurred. Other keys are just a shorthened form of message to keep the message 
                                    simple and easy to read. In template engines, the <code>&#64;error()</code> directive can be used to obtain these errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Custom Errors</div>  
                                <div class="mvs-10">
                                    Custom errors are errors that are defined using te <code>Form::setError()</code> method. This method 
                                    stores the last defined error into an array key <code>":mod"</code>. Hence, by calling the <code>error(':mod')</code> 
                                    function, we can retrieve the last defined error. Example is shown below: <br>
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    Form::setError('something is wrong');

    print error(':mod'); <span class="comment no-select">// something is wrong</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    The <code>:dbi</code> is the only key that displays the type of database error that occurred. Other keys are just a shorthened form of message to keep the message 
                                    simple and easy to read. In template engines, the <code>&#64;error()</code> directive can be used to obtain these errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">User id error notice</div>  
                                <div class="mvs-10">
                                    The <span class="teal">Session</span> class provides a means to ensure that a fake user id is not authenticated if the id does not exist in the database. 
                                    This id is the one that is expected to exist in the user database field (or column) which is configured in the <code class="">icore/init</code> folder with the 
                                    key name "USER_ID_FIELDNAME". If the user id does not exist, then even if the user has successfully logged in, because the id does not exist 
                                    in the database, such session will automatically be nullified. This behaviour only works under a secured session. 
                                    Once a session is nullified, a flash message is usually stored with the reserved key <code>":user-error"</code>. This means 
                                    that if we call the function <code>flash(':user-error')</code> immediately the session is nullified, we will get a response of 
                                    <span class="bc-silver pxv-6 rad-2 c-red-dd font-em-d8">User error: user id mismatch</span> . If we are logged out 
                                    without having a way to display this error, we most likely will not know why a session logged out even when our credentials may be valid. 
                                    However, accessing this functionality can be useful in helping us to understand why supposed valid is actually invalid, thereby causing a nullified session.
                                </div>
                                                  
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>