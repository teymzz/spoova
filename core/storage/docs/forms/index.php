<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
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
    color: rgb(125, 125, 125);
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
               <li> <a href="<?= DomUrl('docs/template') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Template Engine</a> </li>
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/libraries') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Third-Party Libraries</a> </li>
               <li> <a href="<?= DomUrl('docs/other-features') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Other Features</a> </li>
          </ul>
      
     </nav>



    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/forms">Forms</a>  </div>


                <div class="start font-em-d8">
                    <div class="font-em-1d5 c-orange">Handling Forms</div> <br>  
                    
                    <div class="pulling-data">
                        <div>
                            The The <code>Form</code> class is used to create forms and to aslo handle all form data requests sent through the server. 
                            This class along with the <code>Request</code> class, are both able to set form validations, restrictions and saving of 
                            validated request data into the database. An introduction into the generation of forms through <code>Form</code> class 
                            using predefined methods was already discussed in <a href="<?= DomUrl('docs/classes/forms') ?>" class="c-gold-dd">Form</a> helper class. 
                            Here, we will focus more on form validations in relation with the request class.
                        </div> <br>

                        
                        <div>
                            <div class="font-em-1d2 c-orange">Request Data</div> 
                            All form data request sent are be obtained by using the Request class which enables us to perform 
                            necessary form validations on data request sent. This class ensures that only request data that meets a 
                            certain requirements are obtained. These requirements are categorized under different level of strictness.
                            which are strict and non-strict levels. These levels are then applied on form input request validations. 
                            We can initialize the request class as shown below: <br><br>
<div class="pre-area">
    <pre class="pre-code">
  use spoova/mi/core/class/Request;

  $Request = new Request;
    </pre>
</div>                          
                        </div><br>

                        <div>
                            <div class="font-em-1 c-orange">Fetching Request Data : Non-Strict Type</div> 
                            <div class="mvs-10">
                                Request data are strictly advised to be obtained using the <code>$Request->data()</code> method. This method ensures 
                                that only request data forwarded with a CSRF request token are obtainable. If a request data is fowarded without a request 
                                token, an empty array will be returned. When working within the template files, the <code>&#64;csrf</code> template directive 
                                is used to add CSRF tokens input fields to forms. The sample below reflects the syntax of obtaining request data: 
                                <br> <br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  $Formdata = $Request->data(); <span class="comment">// returns the request data sent</span>
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return the form data sent from request by default, 
                                    if the <code>&#64;csrf</code> directive is not supplied, the data returned will be an empty array. In order 
                                    to ensure that all data supplied are accepted, each form must have a <code>&#64;csrf</code> directive attached to it. 
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            <div class="font-em-1 c-orange">Fetching Request Data : Strict Type</div> 
                            <div class="mvs-10">
                                Setting request data as a strict type resolves to an error page if the means by which a request data was sent is not permitted. 
                                This is mostly caused when a CSRF token is not added to a form or the forwarded CSRF token is rejected.
                                A csrf token may become reject if it does not match the token set at run-time or the token has expired if timed. We can set a data 
                                to strict type using the <code>strict()</code> method. If a token is rejected, rather than for <code>data()</code> method to return 
                                an empty array, an error page will be displayed instead based on the type of error that occured. 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  $Request->strict(); <span class="comment">//set request data as strict type</span>

  $Formdata = $Request->data(); <span class="comment">//display error page if data was sent without valid CSRF</span>
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return form data sent from request or an empty array if 
                                    no csrf token is set, if the strict method is applied, the request page will return a csrf default error page preventing any further action.
                                </div>
                            </div>
                        </div> <br>

                        <div>
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
                                    In the above, assuming that our form has a button with the name "submit", then we can check if the data forwarded 
                                    has a "submit" key before setting the strict type or obtaining the data. Also notice, that the <code>strict()</code> method comes after the <code>has()</code> function.
                                    This is because setting the strict type affects the <code>has()</code> method too and prevents it from checking 
                                    any data if the token is not valid.
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            <div class="font-em-1 c-orange">Timing Request Data - Timed Token</div> 
                            <div class="mvs-10">
                                A request can be timed by using the <code>expires()</code> method. This tells the data the 
                                number of seconds required in order for a data to be sent. If a data is not sent within the 
                                required number of seconds, the data sent is not accepted hence, it returns an empty array or displays error message. It should 
                                be noted that even if a <code>csrf</code> token has expired leading to an empty data, the
                                <code>has()</code> method will still allow the checking of data forwarded as long as the <code>strict()</code> method is not applied before it. 
                                However, unlike the <code>strict()</code> method, the <code>expires()</code> method alone  
                                has no effect on the <code>has()</code> method if used before it unless a <code>strict()</code> method is declared along with it. 
                                The example is the best way to declare the strict type along with the <code>expires()</code> method:
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
                        </div> <br>

                        <div>
                            
                            <div id="data-validation" class="font-em-1d5 c-orange">Data Validation</div>  

                            <div class="mvs-10">
                                The first level of authentication encountered is the csrf token validation which determines if data forwarded is accepted 
                                or rejected. When data fowarded is accepted having passed through the first stage of csrf token validation successfully, then it proceeds
                                to validate each form input data required to be validated. This is done through a <code>Model</code> class. The <code>Model</code> class 
                                not only enables us to authenticate form data but it also allows us to save the data into the database. Other features of this class 
                                include input-column mapping which allows the form input name to properly select its relative database column field where the data is expected to 
                                be inserted. Consider the following Model class structure: 
                            </div>
<div class="pre-area">
    <pre class="pre-code">

  namespace spoova\mi\windows\Models;
  
  use spoova\mi\core\classes\Model;
  
  class Signup extends Model {
  
      protected $firstname;
      protected $lastname;
      protected $usermail;
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
              'firstname' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2, SELF::RULE_MAX => 20],
              'lastname'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2, SELF::RULE_MAX => 20],
              'usermail'  => [SELF::RULE_REQUIRED, SELF::RULE_EMAIL]
              'password'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2]
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
              'usermail' => 'email',
              'password' => 'pass'
          ];
  
      }
  
  }
    </pre>
</div>
                            <div class="font-em-d87 mvt-10">

                                <p>
                                    The code above simulates a Signup model format that validates a firstname, lastname, usermail and password form field. 
                                    When a form request data is expected to be authenticated, each request data attribute expected to be authenticated 
                                    must be added as a property into the Model defined. This makes it easier for the Model class to pull out only needed data from 
                                    the request data. The following list explains each method and their functions
                                </p>
                                <p>
                                    <ul>
                                        <li>
                                            The <code>rules()</code> method defines the authentication needed for each field. The Model class ensures that only 
                                            defined authentication rules are applied on the relative property defined.
                                        </li>
                                        <li>
                                            The <code>mapform()</code> maps the input field names with their respective field names. For example, in the Model above,
                                            the request data attribute name of "usermail" will be mapped to "email" field in database. This means that if the input field 
                                            name sent in request is "usermail", when inserting data, the data will be inserted into the "email" field in the database table. 
                                            This makes it easier to protect database names. 
                                        </li>
                                        <li>
                                            The <code>tableName()</code> method is used to set a database table name where authenticated data is expected to be inserted.
                                        </li>
                                        <li>
                                            The <code>isAuthenticated()</code> method by default only returns true if all authentication rules applied to a form request are successfully passed and no 
                                            error was found. Redefining this method above in <code>Signup</code> provides an enviroment to apply more custom rules we require our form data to match. 
                                            For example, if all authentication rules applied was met by a request data, then the root <code>Model::isAuthenticated()</code> method will return true which means that 
                                            <code>Signup::isAuthenticated()</code> will also return true by default. However, if more 
                                            tests are done within the child <code>Signup::isAuthenticated()</code> above and the test fails, then <code>Signup::isAuthenticated()</code> will return false. 
                                            Note that in <code>Form</code> class, when <code>Form::isValidated()</code> is called, it automatically calls the <code>Signup::isAuthenticated()</code> method.
                                            This process is explained below
                                        </li>
                                    </ul>
                                </p>
                                
                            </div> <br>
                        </div>

                        <div>
                            <div class="font-em-1d5 c-orange">Data Processing</div> 

                            <div class="">
                                The <code>Form</code> class is used for further processing and submission request data after csrf validation. This class performs its internal 
                                validation using the instance of a Model class. Once the Model class is validated, then data can be submitted into the database table defined.
                                The sample of this is shown below: <br>
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  &lt;?php
    
    use spoova\mi\core\classes\Request;
    use Form;

    $Request = new Request;

    if($Request->has('submit')){

        $Request->strict();
        $Request->expires(30);

        Form::model(new Signup);

        Form::loadData($Request->data());

        <span class="c-lime-dd">(Form::isValidated() && Form::isSaved());</span>

    }

    $errors = Form::errors($inputErrors);
    
    </pre>
</div>                      
                            <div class="font-em-d87 mvt-10">
                                
                                <div class="">
                                    In few lines above we've been able to perform several operations such as checking for button submission,
                                    restricting invalid forms, validating form data and saving the data into database. This operation is explained in steps below
                                </div> <br>
                                <ul>
                                    <li><code>$Request->has('submit')</code>: This checks if the data forwarded has a "submit" attribute</li>
                                    <li><code>$Request->strict()</code>: This ensures that an error page is shown if csrf token is rejected</li>
                                    <li><code>$Request->expires(30)</code>: This ensures the crsf token generated can only be valid for 30 second</li>
                                    <li><code>Form::model(new Signup)</code>: Sets up a model class used for form data authentication</li>
                                    <li><code>Form::loadData($Request->data())</code>: Sets data to validated by the form and the supplied model</li>
                                    <li><code>Form::isValidated()</code>: By default, this calls the <code>Signup::isAuthenticated()</code> method to check if data is valid</li>
                                    <li><code>Form::isSaved()</code>: This method saves data into the database.</li>
                                    <li>
                                        <code>Form::errors()</code>: This returns all errors encountered during data validation including those related with csrf token. When a variable is supplied, only errors relating to 
                                        form inputs will be saved into the variable.
                                    </li>
                                </ul>

                                <p>
                                    The <code>Signup</code> model 
                                    defines what table and what field the validated data is inserted in the database. In the above, the request data returned by 
                                    <code>$Request->data()</code> is loaded directly into 
                                    the <code>Form</code> class using <code>loadData()</code> method. The data is then validated using the <code>Form::isValidated()</code> 
                                    method. Lastly, the form is saved into the database table "users" defined within the <code>tableName()</code> method of <code>Signup</code> model. 
                                    Although, in all of these processes, no error was obtained, this is because the <code>Form::errors()</code> allows us to fetch all required errors 
                                    depending on the stage where the error occurred. All form input errors only are obtained by reference through the <code>$inputErrors</code> while 
                                    the entire errors returned by the <code>errors()</code> method are obtained into the <code>$errors</code> variable.
                                </p>

                                <p>
                                    Lastly, since the <code>Form::isValidated()</code> can naturally call the model's <code>isAuthenticated()</code> method, The code line 
                                    <code>(Form::isValidated() && Form::isSaved())</code> can both be replaced with <code>Form::isAuthenticated()</code>
                                </p>
                            </div> 
                        </div> <br>

                        <div>
                            <div id="form-rules" class="font-em-1d5 c-orange">Model Form Rules</div>  

                            <div class="">
                                There are several rules that can be applied for form input validation in a model class <code>rules()</code> method. Once these rules are defined within a Model, the model uses such rules 
                                to validate form inputs based on their attributes. The following rules can be applied on form inputs:
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  RULE_REQUIRED  <span class="comment">// Defines an attribute that must be filled</span>
  
  RULE_NOSPACE  <span class="comment">// Defines an attribute that cannot contain spaces</span>
  
  RULE_TEXT  <span class="comment">// Defines an attribute that can only contain alphabets</span>
  
  RULE_MIN  <span class="comment">// Sets a minimum length of characters accepted on a form input</span>
  
  RULE_MAX  <span class="comment">// Sets a maximun length of characters accepted on a form input</span>
  
  RULE_UNIQUE  <span class="comment">// Sets an attribute that must not exist more than once in the database</span>
  
  RULE_MATCHES  <span class="comment">// Sets an attribute that must match another attribute and must not be empty</span>
  
  RULE_EMAIL  <span class="comment">// Defines an attribute and must be of email format</span>
  
  RULE_NOT  <span class="comment">// Defines an attribute that must not be exactly the same as another form attribute(s) value(s)</span>
  
  RULE_UNLIKE  <span class="comment">// Defines an attribute that must not look like another attribute(s) whose names must be set</span>
  
  RULE_NUMBER  <span class="comment">// Defines an attribute that must be numeric</span>
  
  RULE_INTEGER  <span class="comment">// Defines an attribute that must be a valid integer</span>

  RULE_PHONE  <span class="comment">// Defines an attribute that must have a phone numer format</span>
  
  RULE_URL  <span class="comment">// Defines an attribute that must have a url address format</span>
  
  RULE_RANGE  <span class="comment">// Defines an attribute that must have its value within a specified range or list only</span> 

  RULE_NOT_CHARS  <span class="comment">// Defines an attribute that must not have a character exisiting in a list of defined characters that is set</span>       

</pre>
</div>                      

                            <div class="foot-note mvs-6">A sample array format is shown below</div>

                            <div class="pre-area">
                                <pre class="pre-code">
    ... 

    public function rules(): array {

      return  [

        'field1' => [
             
            SELF::RULE_REQUIRED,    <span class="comment">// field is required</span>

            SELF::RULE_NOSPACE,     <span class="comment">// allow no space character</span>

            SELF::RULE_TEXT,        <span class="comment">// allow only alphabets [A-Z]</span>

            SELF::RULE_MIN => '10', <span class="comment">// allow only a minimum of 10 characters</span>

            SELF::RULE_MAX => '12', <span class="comment">// allow only a maximum of 12 characters</span>

            SELF::RULE_UNIQUE,      <span class="comment">// value must not exist more than once in database</span>

            SELF::RULE_EMAIL,       <span class="comment">//value must resemble email format</span>

            SELF::RULE_PHONE,       <span class="comment">//value must resemble phone number format</span>

            SELF::RULE_NUMBER       <span class="comment">//value must be a numeric value</span>

            SELF::RULE_URL          <span class="comment">//value should be a url format</span>

            SELF::RULE_MATCH => 'field2', <span class="comment">// field1 value must match field2 value</span>

            SELF::RULE_UNLIKE  => ['field3', 'field4'], <span class="comment">// field must not resemble field3 and field4</span>
            
            SELF::RULE_NOT_CHARS  => ['*', ':'], <span class="comment">// value must not contain character <code>*</code> and <code>:</code></span>
            
            SELF::RULE_RANGE  => ['yes', 'no'], <span class="comment">// value must be within the range of options <code>yes</code> or <code>no</code></span>
            
            SELF::RULE_PATTERN  => "A-Za-z0-9", <span class="comment">// value must match the specified pattern
                
                ]

      ];

    }
                                </pre>
                            </div>

                        </div><br>

                        <div>
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
    
    use spoova\mi\core\classes\Request;
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
                                    In the above, we successfully modified our error to a new message. The second argument of <code>Csrf::setError()</code> sets a custom  error message. 
                                    Also, The <code>error()</code> helper function in the above only returns the title or info for the type of error that occured.
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
    
    error('username'); <span class="comment">// return first error encountered for a username field</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                   The equivalent of the <code>error()</code> function is the <code>&#64;@error()</code> template directive. When no errors exists for the defined 
                                   attribute <code>error()</code> function just returns empty without throwing any errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Database Errors</div>  
                                <div class="mvs-10">
                                    Database errors occurs when database operation fails due to one reason or the other. This could prevent saving of data into database. The 
                                    <code>Form::error()</code> also allows fetching of these errors using reserved key names such as <code>:dbi</code>, <code>:dbe</code> and <code>:dbm</code>
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
                                <div class="font-em-1 c-orange">Session user id error notice</div>  
                                <div class="mvs-10">
                                    The <span class="teal">Session</span> class security system ensures that a fake user id is not authenticated. In the <code>core/init</code> file, we define 
                                    the user id column name under the key "USER_ID_FIELDNAME" where the user id of the current session user is expected to be found. Assuming a user session id was roughly 
                                    set which does not exist in the column "USER_ID_FIELDNAME" of the "USER_TABLE_NAME" defined, such an invalid id will be nullified. 
                                    This means that if the user id detected does not exist in the configured column, then even if a session id is faked, because that id does not exist 
                                    in the database, such session will automatically be rejected. This behaviour only works under a secured session. 
                                    Once a session is nullified, a flash message is usually stored with the reserved key <code>":user-error"</code>. This means 
                                    that if we call the function <code>flash(':user-error')</code> immediately the session is nullified, we will get a response of 
                                    <span class="span-btn bc-silver pxv-6 rad-2 c-red-dd font-em-d8">User error: user id mismatch</span> . This behaviour makes it easier to understand why a 
                                    session was nullified even if a session id was supplied. 
                                </div>                   
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