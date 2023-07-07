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


                    <div class="font-em-1d5 c-orange">Window Models</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Models are classes that help to communicate with database. The spoova <code>Model</code> enables the commnunication with database using 
                            database relationships. All ORM functionalities of the database model 
                            such as reading and deleting from database can be accessed from <a href="<?= Rexit::domurl('docs/database/data-model') ?>" class="c-olive">database relationships</a>. 
                            This page will focus more on validating and inserting submitted request form data and
                            since most of the Model class features discussed here are form-related, you can learn more about forms from <a href="<?= Rexit::domurl('docs/forms') ?>" class="c-olive">here</a>.
                            The following are some of the methods of <code>Model</code> class and their functions some of which are also integerated with the <a href="<?= Rexit::domurl('docs/forms') ?>" class="c-olive">Form</a> class.
                        </div> 
                    </div>
                    
                    <div class=""> 
                        <br>
                        <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> Model Methods </div>
                        </div>

                        <div class="">
                            <ul class="mvt-10">
                                <li><a href="#loadData"><span class="c-orange-dd">loadData</span></a></li>
                                <li><a href=""><span class="c-orange-dd">loadedData</span></a></li>
                                <li><a href=""><span class="c-orange-dd">rules</span></a></li>
                                <li><a href=""><span class="c-orange-dd">validated</span></a></li>
                                <li><a href=""><span class="c-orange-dd">setError</span></a></li>
                                <li><a href=""><span class="c-orange-dd">error</span></a></li>
                                <li><a href=""><span class="c-orange-dd">errorIndex</span></a></li>
                                <li><a href=""><span class="c-orange-dd">formdata</span></a></li>
                                <li><a href=""><span class="c-orange-dd">dataupdate</span></a></li>
                                <li><a href=""><span class="c-orange-dd">saved</span></a></li>
                                <li><a href=""><span class="c-orange-dd">isAuthenticated</span></a></li>
                                <li><a href=""><span class="c-orange-dd">mapform</span></a></li>
                            </ul>

                            <div class="pxs-14">
                                <span id="loadData"></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> loadData </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        
                                        This method is used to load a submitted form data into a model class. An example of usage is shown 
                                        below: <br>


                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">File - SampleModel.php</div>
 <pre class="pre-code">

  namespace spoova\mi\window\Models;

  use Model;

  class SampleModel extends Model {

    function __construct() {

    }

  }
 </pre>
                                        </div> <br>

                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">File - Home.php</div>
 <pre class="pre-code">
  namespace windows\Routes;

  use spoova\mi\windows\Models\SampleModel;
  use spoova\mi\core\classes\Request;

  class Home extends Window {

    function __construct() {

        $Request =  new Request;
        $Model   =  new SampleModel;
      
        if( $Request->isPost() ) {
      
            $Model->loadData($Request->data()); <span class="comment">//load form data into model class</span>
      
        }
        
    }

  }
 </pre>
                                        </div> <br>
                                        <div class="foot-note">
                                            In the example above, once a post request is sent in <code>Home</code> url and the form data is submitted, the 
                                            <code>Home.php</code> route class will load the data into the model class. The data can then be processed 
                                            based on its required use. 
                                        </div>

                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="loadData"></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> loadedData
                                     </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        
                                        The method <code>"loadedData()"</code> is used to retrieve the data supplied into a model class through the <code>laodData</code> 
                                        method. <br>
                                    </div> 
                                </div>
                            </div><br>

                            <div id="rules" class="pxs-14">
                                <span id="rules"></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> rules </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The method is used set a list of form rules which a model class must use to 
                                        authenticate data supplied or loaded within it. Each data key to be validated must have a similar 
                                        property name within the model class. The model will then try to validate each data key by using its 
                                        corresponding property name. The rules method ensures that each form data key is validated through its list of 
                                        validation rules defined for each key. These rules are discussed in <a href="<?= Rexit::domurl('docs/forms#form-rules') ?>" class="c-olive rule-dotted">Form rules</a>.
                                    </div> 
                                </div>
                            </div><br>

                            <div id="validated" class="pxs-14">
                                <span id=""></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> validated </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        This method is used to initialize the data validation. It can only be called when two operations have be successfully satisfied. 
                                        These operation includes loading of data and setting of data validation rules. In example "Home.php" above we can validate the 
                                        data supplied in the following ways:
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">Home.php</div>
 <pre class="pre-code">
 namespace windows\Routes;

 use spoova\mi\windows\Models\SampleModel;
 use spoova\mi\core\classes\Request;
 
 class Home extends Window {
 
   function __construct() {
 
       $Request =  new Request;
       $Model   =  new SampleModel;
     
       if( $Request->isPost() ) {
     
           $Model->loadData($Request->data()); 
           
           if($Model->validate()) {
             
             <span class="comment">//data validated successfully</span>
 
           }else {
             
             print_r($Model->errors());
             
           }
     
       }
       
   }
   
 }
 </pre>
                                        </div> <br>

                                        <div class="foot-note">
                                            In the above when the <code>$Model->validate()</code> is called, the entire loaded data will be validated. If all 
                                            validation was successful, then the <code>$Model->validate()</code> method will return true else it will return false.
                                            If any error occurs, the error will be returned by the <code>error()</code> method. 
                                        </div>

                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="error"></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> error </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The <code>error()</code> method as revealed in the previous example, returns the error messages encountered after validating 
                                        each data key. The error returned on each data key is determined by the order of validation rules applied on the corresponding 
                                        value of that key.
                                        <br>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="seterror"></span>
                                <div class="">
                                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> setError </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The <code>setError()</code> method is used to set custom errors. The custom errors are usually stored under the array index key 
                                        <code>:mod</code>. This method takes two arguments of key and value pairs where the first argument is the error name (or key) while the 
                                        second argument is the error message. When we call the <code>error()</code> method, the custom messages can be obtained by first calling the array key <code>:mod</code> along with the 
                                        defined message key. Using <code class="calibri">$Model->error()</code> in the earlier code samples, we can obtain  custom errors as shown below.

                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">Home.php</div>
 <pre class="pre-code">
 namespace windows\Routes;

 use spoova\mi\windows\Models\SampleModel;
 use spoova\mi\core\classes\Request;
 
 class Home extends Window {
 
   function __construct() {
 
       $Request =  new Request;
       $Model   =  new SampleModel;
     
       if( $Request->isPost() ) {
     
           $Model->loadData($Request->data()); 
           
           if($Model->validate()) {
             
             <span class="comment">//data validated successfully</span>
 
           }else {

             $Model->setError('someError', 'validation failed!');
             
             $modelErrors = $Model->errors();
             $customErrors = $modelErrors[':mod'] ?? [];

             var_dump($customErrors); <span class="comment">// ['someError' => 'validation failed!'] </span>
             
           }
     
       }
       
   }
   
 }
 </pre>
                                        </div> <br>     
                                        
                                        <div class="foot-note">
                                            Although, the example above may not be realistic enough, it simply explains 
                                            how the <code>setError</code> and <code>error</code> works together
                                        </div>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="errorindex"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> errorIndex </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        This method returns the first error message encountered after requested data's validation fails.
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="formdata"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> formdata </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        Since each request data contains a data key and its corresponding value, whenever a request data is loaded into the model class, 
                                        the model will match the keys of data supplied with the model class property. Only keys having a similar property name will be
                                        returned as an array list by the <code>formdata()</code> method.
                                        <br>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="dataupdate"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> dataUpdate </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        A loaded data can be updated with the <code>dataUpdate()</code> method. This is usually done by supplying an array with the data key 
                                        and value pairs of data keys that are needed to be updated.
                                    </div>
                                </div>
                            </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="tablename"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> tablename </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The method <code>tableName()</code> is used to return a string of the database table name where database operations are expected to be performed.
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">                        
                                <span id="saved"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> Saved </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The <code>saved()</code> method is usually used to save a data into a database table. It returns true if a data is succesfully saved into the 
                                        database. This method is also capable of updating database values immediately before they are inserted into the database fields. Without any lasting 
                                        modification of the real loaded data. In order to do this, the first argument must be an array of keys (column name) and value pairs.                         
                                    </div>
                                </div>
                            </div><br>

                            <div class="pxs-14">                        
                                <span id="isauthenticated"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> isAuthenticated </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        This method by default returns <code>true</code> if data validation is successful and no errors are found.                         
                                    </div>
                                </div>
                            </div><br>

                            <div class="pxs-14">                        
                                <span id="mapform"></span>
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> mapform </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The <code class="calibri">mapform</code> method is used to modify requested data column names. This is usually applicable in situations where 
                                        form input data are submitted as the request data. At times, we may need to keep database table field names private because using the same form input name 
                                        as database column names may not be advisable due to security issues. The <code>mapform</code> ensures that we can map database columns to html input forms. 
                                        This method returns an array list of key and value pairs where the <code>key</code> is the form input's name and the <code>value</code> is the corresponding 
                                        database field name. This means that value submitted into an html form input's field will be inserted into the relative column name defined.                         
                                    </div>
                                </div>
                            </div><br>

                            <div class="pxs-14">         
                                <div class="">
                                    <div class="desc mvt-10">
                                        As a conclusion, when it comes to the validation and authentication of request data, it is preferred to handle authentications 
                                        through the <a href="<?= Rexit::domlink('docs.form') ?>" class="c-olive">Form class</a> which is specially designed for form authentications through 
                                        the use of form models. This class is also used to set custom error notices and also to separate form errors when working with multiple forms 
                                        in a single web page.
                                    </div>
                                </div>
                            </div><br>

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