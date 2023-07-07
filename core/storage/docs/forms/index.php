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
               <a href="<?= Rexit::domurl() ?>" class="flex c-i inherit">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square calibri">
               <li> <a href="<?= Rexit::domurl('docs/installation') ?>" class="<?= Rexit::inPath('active') ?>"><span class="ico ico-spin"></span>Installation</a> </li>
               <li> <a href="<?= Rexit::domurl('docs/wmv') ?>" class="<?= Rexit::inPath('active') ?>" ><span class="ico ico-spin"></span><span class="fb-6 pointer" title="Windows View Models">WVM</span> PATTERN</a></li>
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
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8"> 

                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
<br>

                    <div class="font-em-1d5 c-orange"> <i class="bi-person-vcard"></i> Handling Forms</div> <br>  
                    
                    <div class="pulling-data">
                        <div>
                            The The <code>Form</code> class is used to create forms and to aslo handle all form data requests sent through the server. 
                            This class along with the <code>Request</code> class, are both able to set form validations, restrictions and saving of 
                            validated request data into the database. An introduction into the generation of forms through <code>Form</code> class 
                            using predefined methods was already discussed in <a href="<?= Rexit::domurl('docs/classes/forms') ?>" class="c-gold-dd">Form</a> helper class. 
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
                                token, an empty array will be returned. When working within the template files, the <code>@csrf</code> template directive 
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
                                    if the <code>@csrf</code> directive is not supplied, the data returned will be an empty array. In order 
                                    to ensure that all data supplied are accepted, each form must have a <code>@csrf</code> directive attached to it. 
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
                                A request can be timed by using the <code>expires()</code> method. This tells the request the 
                                number of seconds required in order for a data to be sent. If a request data is not sent within the 
                                required number of seconds, the data sent is not accepted hence, it returns an empty array or displays error message. It should 
                                be noted that even if a <code>csrf</code> token has expired leading to an empty data, the
                                <code>has()</code> method will still allow the checking of data forwarded as long as the <code>strict()</code> method is not applied before it. 
                                However, unlike the <code>strict()</code> method, the <code>expires()</code> method alone  
                                has no effect on the <code>has()</code> method if used before it unless a <code>strict()</code> method is declared along with it. 
                                The example below is the best way to declare the strict type along with the <code>expires()</code> method:
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
  
          <span class="comment">//your code here...</span>
  
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
                            <div class="foot-note mvt-10">
                                
                                <div class="">
                                    In few lines above we've been able to perform several operations such as checking for button submission,
                                    restricting invalid forms, validating form data and saving the data into database. This operation is explained in steps below
                                </div> <br>
                                <ul>
                                    <li><code>$Request->has('submit')</code>: This checks if the request data forwarded has a "submit" key</li>
                                    <li><code>$Request->strict()</code>: This ensures that an error page is shown if csrf token is rejected</li>
                                    <li><code>$Request->expires(30)</code>: This ensures the csrf token generated can only be valid for 30 second</li>
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
                                    The <code>Signup</code> model defines the database table and columns the validated data is inserted in the database. In the above, 
                                    the request data returned by <code>$Request->data()</code> is loaded directly into 
                                    the <code>Form</code> class using <code>Form::loadData()</code> method. The <code>Form::isValidated()</code> will validate each property using their respective 
                                    keys defined within the model's <code>rule()</code> method and return <code>true</code> by default. If more custom tests are 
                                    done within the supplied model's <code>isAuthenticated()</code> method, this will further determine if the <code>Form::isAuthenticated()</code> will return a <code class="bd-f">true</code> or 
                                    <code class="bd-f">false</code> value. Lastly, the <code>Form::isSaved()</code> will try to save the data the database table "users" defined within the <code>tableName()</code> method of <code>Signup</code> model. 
                                    When an error occurs in the execution of these process, we can obtain the all errors using the <code>Form::errors()</code> method which allows us to fetch all required errors 
                                    depending on the stage where the error occurred. This method also makes it easier to fetch only errors that occur in input validation by supplying a variable e.g <code>$inputErrors</code>, which acts as reference
                                    for errors that occurs for a property when its specified validation rule is not passed.  
                                    To obtain the entire errors, the <code>Form::errors()</code> method returns the entire error that occured which may be from database connection, operation or input validation.
                                </p>

                                <p>
                                    Lastly, since the <code>Form::isAuthenticated()</code> can naturally call the model's <code>isAuthenticated()</code> method, we can easily add the <code>Form::isSaved()</code> into the 
                                    current model's <code>isAuthenticated()</code> method. Hence, The code line 
                                    <code>(Form::isValidated() && Form::isSaved())</code> can both be replaced with a single <code>Form::isAuthenticated()</code>. The <code>Signup</code> model's <code>isAuthenticated()</code> method 
                                    will resemble the format below:
                                </p>

                                <div class="pre-area">
                                    <pre class="pre-code">
   <span class="comment">/**
    * Determines if a form authentication is completed 
    *
    * @return bool
    */</span>
    public static function isAuthenticated(): bool {

        return Form::isSaved(); <span class="comment">//save and return true of data is saved</span>

    } 
                                    </pre>
                                </div>

                                <div class="mvs-10">
                                    The code line that manages the request will resemble the format below:
                                </div>

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

        <span class="c-lime-dd">if(Form::isAuthenticated()) {</span>
            
            if(Form::errors()) var_dump(Form::errors);

        <span class="c-lime-dd">}</span>
    }

    $errors = Form::errors($inputErrors);
    
    </pre>
                                </div>     
                                <div class="foot-note">
                                    Some other useful and important form methods are listed and discussed below:
                                </div> <br>       
                                <div class="">
                                    <div class="">
                                        <div class="c-orange"> <span class="bi-arrow-right-short"></span> Form::datakey()</div>
                                        <div class="">
                                            This method is used to retrieve a form data key from the <code>Form</code> class after the 
                                            <code>Form::loadData()</code> has been used to load a request data.
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Syntax: datakey()
                                            </div>
                                            <pre class="pre-code">
  Form::datakey($key)
    <span class="comment">
    where $key: a key in the request form data</span>
                                            </pre>
                                        </div>
                                    </div> <br>

                                    <div class="">
                                        <div class="c-orange"> <span class="bi-arrow-right-short"></span> Form::dataval() <span class="bc-slate-grey c-white box rad-r pxv-2 pxs-4">v2.5+</span></div>
                                        <div class="pvs-6">
                                            This method is similar to <code>Form::datakey()</code> method. as it returns the value of a 
                                            key in database but it can also be made to throw an error if the specified key does not exist.
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Syntax: dataval()
                                            </div>
                                            <pre class="pre-code">
  Form::dataval($key, $strict)
    <span class="comment">
    where:
    
      $key    : a key in the request form data
      $strict : when set as true throws an error if key does not exist.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>

                                    <div class="">
                                        <div class="c-orange"> <span class="bi-arrow-right-short"></span> Form::loadedData() <span class="bc-slate-grey c-white box rad-r pxv-2 pxs-4">v2.5+</span></div>
                                        <div class="pvs-6">
                                            This method returns the data supplied into the <code>Form::loadData()</code> method. It takes 
                                            no argument and returns an array.
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Sample: loadedData()
                                            </div>
                                            <pre class="pre-code">
  Form::loadData(['name' => 'foo']);

  prnt_r( Form::loadedData() ); <span class="comment">// ['name' => 'foo'] </span>
                                            </pre>
                                        </div>
                                    </div> <br>

                                    <div class="">
                                        <div class="c-orange"> <span class="bi-arrow-right-short"></span> Form::haskey() <span class="bc-slate-grey c-white box rad-r pxv-2 pxs-4">v2.5+</span></div>
                                        <div class="pvs-6">
                                            This method is similar to <code>Request::has()</code> method. The only difference is that the 
                                            <code>Form::haskey()</code> method check the key from the loaded form data.
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Sample: haskey()
                                            </div>
                                            <pre class="pre-code">
  Form::loadData(['name' => 'foo']);

  vdump( Form::haskey('name') ); <span class="comment">// true </span>
                                            </pre>
                                        </div>
                                    </div> <br>

                                    <div class="">
                                        <div class="c-orange"> <span class="bi-arrow-right-short"></span> Form::onpost() <span class="bc-slate-grey c-white box rad-r pxv-2 pxs-4">v2.5+</span></div>
                                        <div class="pvs-6">
                                            This method is used to run a callback function only when the forwarded request method 
                                            is post.
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Sample 1: onpost()
                                            </div>
                                            <pre class="pre-code">
  Form::onpost(function(){

    echo "request is post";

  });
                                            </pre>
                                        </div>
                                        <div class="foot-note">
                                            In the code above, the callback function will only run when the request is post. We can also ensure that the 
                                            callback function runs only when a request key exists in the form request that is sent. This is done by specifying 
                                            the required request key as shown below:
                                        </div>
                                        <div class="pre-area mvs-10">
                                            <div class="pxv-10 bc-silver">
                                                Sample 2: onpost()
                                            </div>
                                            <pre class="pre-code">
  Form::onpost('login', function(){

    echo "request is post";

  });
                                            </pre>
                                        </div>
                                        <div class="foot-note">
                                            In the code sample above, the callback function will be called only if the 
                                            <span class="c-soft-pink">"login"</span> key exists in the request key forwarded. This option can also be 
                                            good when testing for submission buttons. It is however important the the <spanc class="c-olive">Request</spanc> class must not be set as <code>strict</code> 
                                            before this method is used.
                                        </div>                                        
                                    </div> <br>

                                    
                                    
                                </div>                 
                            </div> 
                        </div>

                        <div class="">
                            <div class="c-orange"><span class="bi-arrow-up-circle"></span> Form::register() <span class="bc-slate-grey c-white box rad-r pxv-2 pxs-4">v2.5+</span> </div>
                            The version 2.5 introduces a new method for registering a session which is <code>Form::register()</code> method. The syntax of this method is 
                            displayed below:

                            <div class="pre-area">
                                <pre class="pre-code">
  Form::register($userid_key, $callback);
  <span class="comment">
    where:
     
     $userid_key : user id key in request data

     $callback    : callback function
  </span>
                                </pre>
                            </div>
                            <div class="foot-note">
                                When the <code>Form::register()</code> method is used, the first argument <code>$userid_key</code> that is expected 
                                to be supplied is usually a key in the form request data that corresponds to the configured database USER_ID_FIELDNAME. 
                                For example, if the database table column where the userid is stored is <code>email</code>, then the 
                                <code>$userid_key</code> should also be email and it should exist as a key in the form request data. Since the <code>mapform()</code>
                                method can hide database field names, it does not necessarily mean that the form input field should have the "email" field, we just have to 
                                specify the input field which is a placeholder for the real userid column in the user database table. Assuming we have a signup form as shown below
                            </div>

                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;form method="post"&gt;

        @csrf <span class="comment">&lt;!--apply csrf--&gt;</span>
    
        &lt;div&gt; @error(':mod', 'signup-failed') &lt;/div&gt; 
        &lt;div&gt; @error('firstname') &lt;/div&gt; 
        &lt;div&gt; &lt;input name="firstname"&gt; &lt;br&gt; &lt;/div&gt; 

        &lt;div&gt; @error('lastname') &lt;/div&gt;       
        &lt;div&gt; &lt;input name="lastname"&gt; &lt;br&gt; &lt;/div&gt; 

        &lt;div&gt; @error('usermail')  &lt;/div&gt;          
        &lt;div&gt; &lt;input type="email" name="usermail"&gt; &lt;br&gt; &lt;/div&gt; 

        &lt;div&gt; @error('userpass') &lt;/div&gt; 
        &lt;div&gt; &lt;input type="password" name="userpass"&gt; &lt;br&gt; &lt;/div&gt; 

        &lt;div&gt; &lt;button name="signup"&gt;button&lt;button&gt; &lt;/div&gt; 
    
    &lt;/form&gt;
                                </pre>
                            </div>
                            <div class="foot-note">
                                Assuming that the <code>usermail</code> field corresponds to the database column <code>"email"</code> where the 
                                collected input will be inserted in the predefined user database table, we can continue to create our form authentication 
                                model as shown below
                            </div>
                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;?php 

    namespace spoova\mi\windows\Models;

    class SignupModel {

        function rules(): array {

            <span class="comment">//set form validation rules</span>

            return [
                
             'firstname' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2],   
             'lastname'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2],   
             'usermail'  => [SELF::RULE_REQUIRED, SELF::RULE_EMAIL],   
             'userpass'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 8],   
                
            ];

        }

        static function mapform() : array {

            return [
                'usermail' => 'email' <span class="comment">//set the usermail field in form data back to email</span>
            ];

        }

        static function tablename() {
            return "users";
        }

        static function isAuthenticated() : bool {

            return self::isSaved(); <span class="comment">//try to save data into database</span>

        }

    }
                                </pre>
                            </div>
                            <div class="foot-note">
                                In the above, we successfully set some validation rules which are meant to be used to authenticate the form data. 
                                However, notice that the <code>usermail</code> field was internally renamed back to <code>email</code> which is 
                                expected to be where the data is inserted in the database table <code>"users"</code>. Since we intend to use the <code>"usermail"</code> field's 
                                value as the <code>userid</code>, we can set up the form authentication frame as shown below:
                            </div>
                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;?php 

    namespace spoova\mi\windows\Frames\AccessFrame;

    class AccessFrame extends Windows{

        static function onSubmit($Request Request) {

            if($Request->isPost()) {

                Form::model(new SignupModel); 
                
                if(Form::haskey('signup')) {

                    Form::loadData($Request->data());

                    Form::register('usermail', function($data){

                        if($data !== false) {

                            <span class="comment">// form saved successfully </span>
                            User::login($data);

                        }else{

                            <span class="comment">// set error that something is wrong ... </span>

                            Form::setError('signup-failed', 'signup failed due to some error');

                        }

                    })

                }

            }

        }

    }
                                </pre>
                            </div>
                            <div class="foot-note">
                                In the sample above, the <code>AccessFrame</code> will be used as a middleware to validate the form data. In the above, 
                                the <code>Form::haskey('signup')</code> checks that a the request data has a signup key equivalent to the signup button. 
                                The <code>Form::loadData()</code> is used to load the request form data into the <code>Form</code> class for authentication. 
                                Lastly, the <code>Form::register</code> assumes that the "usermail" key in request data contains the value intended to be used for 
                                userid. The callback function will return the <code>userid</code> data if the form is successfully authenticated and saved. This array 
                                data can then be used to login (i.e. create the user's new session). In order to apply this middleware, we can use any shutter method 
                                in our route but we need to declare a session first which can be used for logging in. Let's create a new root session frame below:
                            </div>
                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;?php 

    namespace spoova\mi\windows\Frames; 

    use Window;

    class SessionFrame extends Window {

        static function frame() {

            new Session('user', 'usercookie');

        }

    }
                                </pre>
                            </div>

                            <div class="foot-note">We also need to create a session for the signup route as shown below</div>
                            
                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;?php 

    namespace spoova\mi\windows\sessions; 

    use spoova\mi\windows\Frames\SessionFrame;

    class GuestSession extends SessionFrame {

        static function frame() {

            Session::auto('login', 'home'); <span class="comment">redirect after the session becomes active</span>

        }

    }
                                </pre>
                            </div>
                            <div class="foot-note">The session created above will be linked to the Signup route. You can learn more about
                                sessions from <a href="<?= Rexit::domlink('docs.sessions') ?>">sessions page</a>. The <code>GuestSession</code> above will 
                                be used for all guest pages that requires the use of session auto redirection. Now, we can proceed to create the 
                                <code>Signup</code> route as shown below:
                            </div>
                            
                            <pre class="pre-area">
                                <pre class="pre-code">
    &lt;?php
    
    namespace spoova\mi\windows\Routes;

    use spoova\mi\windows\sessions;

    class Signup extends GuestSession {

        function __construct() {

            self::call($this, [ window() => 'root' ]);

        }

        function root() {

            Accessframe::onSubmit(); <span class="comment">// apply middleware</span>

            self::load('signup', fn() => compile() ); <span class="comment">// load template</span>

        }

    }
                                </pre>
                            </pre>

                        </div>

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

  RULE_ISOLATE  <span class="comment">// Sets an attribute that cannot be closely matched by any other attribute's value</span>
  
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

                            <div class="foot-note">A sample rule returned by a model is shown below</div>

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

        Csrf::setError('default', 'csrf request failed');   <span class="comment">// set custom message</span>
        Csrf::setError('invalid', 'csrf token mismatched'); <span class="comment">// set custom message</span>
        Csrf::setError('session', 'csrf session expired');  <span class="comment">// set custom message</span>

        Csrf::setError('default', ['title' => 'some title', 'info' => 'some info']);<span class="comment">// set custom title and info using array</span>

        $Request->strict()->expires(5);

        Form::loadData($Request->data());

        (Form::isValidated() && Form::isSaved());

    }

    $errors = Form::errors();      <span class="comment">//return all validation errors</span> 

    print_r( $errors[':csrf'] );     <span class="comment">// return only csrf last error (both title and info)</span> 
    print_r( error(':csrf') );      <span class="comment">// same as above</span> 

    print error(':csrf', 'title'); <span class="comment">// return only csrf last error title</span> 
    print error(':csrf', 'info');  <span class="comment">// return only csrf last error info</span> 
    
    </pre>
                                </div>
                                                                                    
                                <div class="foot-note mvt-10">
                                    In the above, the <code>Csrf::setError()</code> is used to set a custom modified message. It stores its keys and value into a <code>":mod"</code> space 
                                    where the values can be retrieved later. Once a key and a message value is defined, 
                                    we can access the custom message through its key. For example, <code>error(':mod','invalid')</code> will return a message of "csrf token mismatched".  
                                    The second argument of <code>Csrf::setError()</code> sets a custom  error message. 
                                    Also, The <code>error()</code> helper function by default has internal access to <code>Form::errors()</code> method which usually returns the error encountered 
                                    after a form validation fails. Rather than use a variable to obtain the form errors, we can easily use the <code>error()</code> helper function to pull the error 
                                    specific error from the <code>Form::errors()</code>. The errors accessible by the <code>error()</code> function are discussed below:
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

                                <div class="foot-note mvt-10">
                                   The equivalent of the <code>error()</code> function is the <code>@error()</code> template directive. When no errors exists for the defined 
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
    error(':dbi'); <span class="comment">// sql error (fully stated according to type of error)</span> 
    
    </pre>
                                </div>

                                <div class="foot-note mvt-10">
                                    The <code>:dbi</code> is the only key that displays the full information about the type of database error that occurred. Other keys are just a shorthened form of message to keep the message 
                                    simple and easy to read. In template engines, the <code>@error()</code> directive can be used to obtain these errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Custom Errors</div>  
                                <div class="mvs-10">
                                    Custom errors are errors that are defined using the <code>Form::setError()</code> method. This method 
                                    stores the last defined error into an array key <code>":mod"</code>. Hence, by calling the <code>error(':mod')</code> 
                                    function, we can retrieve the last defined error. Example is shown below: <br>
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    Form::setError('something is wrong');

    echo error(':mod'); <span class="comment no-select">// something is wrong</span> 
    
    
    Form::setError('name', 'foo');

    echo error(':mod', 'name'); <span class="comment no-select">// foo</span> 
    </pre>
                                </div>

                                <div class="foot-note mvt-10">
                                    The sample above best explains how the <code>error()</code> function can access a message defined by <code>Form::setError()</code>. 
                                    It is mostly important that the value returned by the <code>error()</code> function is a string rather than an array for an easy access 
                                    through template files.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Session user id error notice</div>  
                                <div class="mvs-10">
                                    The <span class="teal">Session</span> class security system ensures that a fake user id is not authenticated. In the <code>core/init</code> file, we configured 
                                    the user table along with user id field (or column) name . Assuming a user session id was roughly 
                                    set which does not exist in the column "USER_ID_FIELDNAME" of the "USER_TABLE_NAME" defined, such an invalid id will be nullified. 
                                    This means that if the user id detected does not exist in the configured column, then even if a session id is faked, because that id does not exist 
                                    in the database, such session will automatically be rejected. This behaviour only works under a secured session defined by setting the third argument of <code>Session</code> 
                                    class to the value of <code>true</code> during initialization. Once a session is nullified, a flash message is usually stored with the reserved key <code class="bd-f">":user-error"</code>. This means 
                                    that if we call the function <code>flash(':user-error')</code> immediately the session is nullified, we will get a response of 
                                    <span class="span-btn bc-silver pxv-6 rad-2 c-red-dd font-em-d8">User error: user id mismatch</span> . This makes it easier to understand why a 
                                    session was nullified even if a session id was supplied. 
                                </div>                   
                            </div> <br>

                            <div>
                                <div id="formerror" class="font-em-1 c-orange"> <span class="bi-circle"></span> Improvements on retrieving errors <span class="box rad-r bd-4 pxv-2 pxs-4">v2.5+</span> </div>  
                                <div class="mvs-10">
                                    In version 2.5, a new way has been added to make it easier to fetch errors through a <code>formerror()</code> function. This function was introduced 
                                    to separate error encountered where there are multiple forms on a page which may result in conflicting errors most especially when a form may have 
                                    an input field with a name that that exists in another form's input field. An example is shown below:
                                </div>  
                                <div class="pre-area">
                                    <pre class="pre-code">
    &lt;form method="post" class="form1"&gt;
        &lt;input name="email" &gt;
        &lt;input name="password" &gt;
        &lt;button name="login"&gt;Login&lt;/button&gt;
    &lt;/form&gt;

    &lt;form method="post" class="form2"&gt;
        &lt;input name="firstname" &gt;
        &lt;input name="lastname" &gt;
        &lt;input name="email" &gt;
        &lt;input name="password" &gt;
        &lt;button name="login"&gt;Signup&lt;/button&gt;
    &lt;/form&gt;
                                    </pre>
                                </div>                 
                            </div>
                            
                            <div class="foot-note">
                                In the sample html above, both of the forms have an <code>email</code> and <code>password</code> field. This can result 
                                in conflicting error message because the <code>Form::error()</code> method is not aware of the form whose error is returned. 
                                With can however, specify the field whose error is returned through a new method <code>Form::castError()</code>. This new method 
                                takes an error key which is used to store the error. Once the error is stored, we can then obtain the error back through the use of
                                <code>Form::castedError()</code> method, <code>formerror()</code> helper function or the <code>@formerror()</code> template directive. 
                                In order to fetch a particular error, the cast name must first be supplied into as first argument of the <code>formerror()</code> function
                                This is shown below:
                            </div>

                            <div class="pre-area">
                                <pre class="pre-code">
    &lt;?php
    
    use spoova\mi\core\classes\Request;
    use Form;
    use Csrf;

    $Request = new Request;

    if($Request->isPost()){

        if($Request->has('submit')){

            Form::model(new SomeModel); <span class="comment">// add a model to be used for authentication</span>

            Form::loadData($Request->data());

            if(!Form::isValidated()){

                if($Request->has('login')){

                    <span class="comment">// if login button was clicked</span>

                    Form::castError('login');

                    print_r(formerror('login')) <span class="comment">// return errors stored in login</span>

                }else{

                    Form::castError('signup');
                    
                    print_r(formerror('signup')) <span class="comment">// return errors stored in signup</span>
                    
                }

                

            }

        }

    }
                                </pre>
                            </div>

                            <div class="foot-note">
                                In the sample above, although, the <code>Form::error()</code> has no idea of the form which error is returned, 
                                we took the advantage of the form buttons to cast the errors into their own unique space which can then be accessed through 
                                <code>formerror('login')</code> or <code>formerror('signup')</code>, depending on the unique name used for storing the data. 
                                Aside from the form input errors The <code>Form::castError()</code> stores other special error in a slightly different way through the use of special access keys. 
                                These keys include <code>flash:</code>, <code>csrf:</code>, <code>index:</code>, <code>any:</code> and <code>mod:</code>. These keys are explained below with the 
                                assumption that <code>castname</code> key is used to store each data.
                            </div>

                            <div>
                                <div class="font-em-1 c-orange">formerror('castname', 'flash:')</div>  
                                <div class="mvs-10">
                                    The <code>flash:</code> key is used to obtain flash notices. In most cases, it is used to obtain the <code>:user-error</code> message returned 
                                    when a session id is nullified. For example, the <code>formerror('flash:user-error')</code> is equivalent to <code>flash(':user-error')</code> 
                                    Other flash errors can be obtained by first calling the <code>flash:</code> access key identifier followed by the key of the flash name. An example is shown 
                                    below:
                                </div>         
                                <div class="pre-area">
                                    <pre class="pre-code">
    &lt;?php

    if(!Res::hasFlash('flash_name')){

        Res::setFlash('flash_name', 'flash message');

    } else {

        echo formerror('castname','flash:flash_name'); <span class="comment">// flash message</span>
    }
    
                                    </pre>
                                </div> 
                                <div class="foot-note">
                                    The example above uses the <code>formerror()</code> function to print the flash message. This is similarly done in template files 
                                    through the use of <code>@formerror('castname','flash:flash_name')</code>.
                                </div>         
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">formerror('castname', 'csrf:')</div>  
                                <div class="mvs-10">
                                    The <code>csrf:</code> key is used to obtain errors that may occur when a form that does not have csrf token is submitted. 
                                    The <code>formerror('castname','csrf:title')</code> is equivalent to <code>error(':csrf', 'title')</code> while the <code>formerror('castname','csrf:info')</code> 
                                    is similary equivalent to the <code>error(':csrf', 'info')</code>. We can also use the relative template directive to 
                                    fetch the value of such errors.
                                </div>         
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">formerror('castname', 'mod:')</div>  
                                <div class="mvs-10">
                                    The <code>mod:</code> key is used to obtain custom errors defined by the <code>Form::setError()</code> method just like the 
                                    <code>error(':mod')</code> helper function. A sample of this is shown below
                                </div>       
                                <div class="pre-area">
                                    <pre class="pre-code">
    &lt;?php

    Form::setError('name', 'foo');

    echo formerror('castname', ':mod', 'name'); <span class="comment">// foo</span>
                                    </pre>
                                </div>          
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">formerror('castname', 'index:')</div>  
                                <div class="mvs-10">
                                    The <code>index:</code> key is used to obtain the first error encountered in a form validation. This is mostly 
                                    dependent on the request data sent. The first error encountered from the the list input fields data is returned after 
                                    input authentication. In most cases, this is useful at the topmost part of 
                                    a form field in template files.  
                                </div>         
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">formerror('castname', 'any:')</div>  
                                <div class="mvs-10">
                                    The <code>any:</code> key is similar to the <code>index:</code> key. The only difference is that when this key is used,
                                    errors returned will include all errors from flash notices, csrf token validation, custom errors and any input validation error. 
                                    The first error encountered is usually returned. This key is also useful at the top of the form field. Any error encountered after 
                                    the form is  
                                </div>         
                            </div> <br>

                            
                            
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