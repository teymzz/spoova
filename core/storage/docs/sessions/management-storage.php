
<!DOCTYPE html>
<html lang="en">
<head>
    <?= Rexit::meta('dump') ?>
    <title>Session storage</title>
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





<div class="box-full pxl-2 bc-white pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            <div class="start font-em-d8">

                
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                <div class="font-em-1d5 c-orange"> <i class="bi-person-fill"></i> Session storage</div> <br>
                
                <div class="resource-intro">
                  <div class="">
                    The session information is stored in the global session space. Spoova provides some useful methods to manage how data 
                    are stored or accessed from global session. These methods are discussed below: 
                  </div>

                  <!-- Session::save() -->
                  <div class="mvt-20">
                      <div class="mvs-4 c-orange"> <i class="bi-save"></i> Session::save()</div>
                      <div class=" font-em-d9">
                          This method is used to save session data. It requires a session key followed by the session value which is expected to be saved into the session key 
                          which can be of any data type.
                          <br><br>

                          <div class="code">  
                              <div class="pxv-10 bc-silver">
                                  Syntax: Session::save()
                              </div>
                              <div class="pre-area">
                                  <pre class="pre-code">
 Session::save($key, $value)
                                  </pre>
                                </div>
                            </div>

                            <div class="foot-note">
                              In the code above, the <code>$key</code> is usually a string key while the value supplied can be of any data type. Once this 
                              method is called, the key will be used to save the data into the global session space. 
                            </div>

                        </div>
                  </div>

                  <!-- logout -->
                  <div class="mvt-20">
                      <div class="mvs-4 c-orange"> <i class="bi-house-slash-fill"></i> Session::value()</div>
                      <div class=" font-em-d9">
                          The <code>Session::value()</code> method is used to obtain the value of a specified key from the global session space. Although it requires a key 
                          to know which value it is required to return, if not key is specified, the entire session content is returned.
                          <br><br>

                          <div class="code">  
                              <div class="pxv-10 bc-silver">
                                  Syntax: Session::value()
                              </div>
                              <div class="pre-area">
                                  <pre class="pre-code">
  Session::value($key?, $subkey?)
  <span class="comment">
    where: 
        
      $key    : session key whose value is expected to be returned
      $subkey : a subkey of the value of $key if the value is an array.
  </span>
                                  </pre>
                              </div>
                          </div>

                          <div class="foot-note">
                            THe <code>$key</code> above is used to fetch the value of an existing key in the storage. If <code>$subkey</code> 
                            is specified, and the value of $key supplied is an array, then <code>$subkey</code> is assumed to be a subkey of the value of 
                            <code>$key</code>. This means that the value of the subkey will be returned instead. An example is shown below:
                          </div>
 
                          <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Set and fetch a data.
                            </div>
                            <pre class="pre-code">

  $data1 = 'foobaz';

  $data2 = [
    
    'name1' => 'foo', 
    'name2' => 'bar', 
    'name3' => 'baz', 

  ];

  Session::save('data1', $data1);

  Session::save('data2', $data2);


  $session_data  = Session::value(); <span class="comment">// returns both data1 and data2 </span>

  $session_data1 = Session::value('data1'); <span class="comment">// foobaz </span>

  $session_data2 = Session::value('data2'); <span class="comment">// ['name1' => 'foo', 'name2' => 'bar', 'name3' => 'baz']</span>
  
  $session_data1 = Session::value('data2'); <span class="comment">// ['name1' => 'foo', 'name2' => 'bar', 'name3' => 'baz']</span>


  $session_name1 = Session::value('data2', 'name1'); <span class="comment">// foo</span>

  $session_name2 = Session::value('data2', 'name2'); <span class="comment">// bar</span>
  
  $session_names = Session::value('data2', ['name1','name3']); <span class="comment">// ['foo', 'baz']</span>
                                  </pre>
                              </div>

                              <div class="foot-note">
                                The code above best explains how the <code>Session::value()</code> works. Once we save a data into the session, we can obtain 
                                it by specifying the storage key used to store the data. The first result above shows that when the value is not specified, all the data stored 
                                is returned back. Also we can see that when the subkey argument is supplied, it only works when the data stored is an array that contains the the 
                                specified subkey value. Hence, the value of the subkey is returned.
                              </div>

                        </div>

                    </div> 

                  <!-- overwrite -->
                  <div class="mvt-20">
                      <div class="mvs-4 c-orange"> <i class="bi-dash-circle-dotted"></i> Session::overwrite()</div>
                      <div class=" font-em-d9">
                          The <code>overwrite()</code> method is used to overwrite the entire value of a session. This means that the session value 
                          is entirely replaced by the new value supplied. Usually, it is not advisable to overwrite the entire value of the global 
                          session data. If there is a need to modify the entire session data, the best way to perform this is to fetch the entire session 
                          value first. The value fetched can then be modified and then saved back using the <code>overwrite()</code> method. In this way, 
                          we are sure that no data will be lost.
                          <br><br>

                          <div class="code">  
                              <div class="pxv-10 bc-silver">
                                  Syntax: Session::overwrite()
                              </div>
                              <div class="pre-area">
                                  <pre class="pre-code">
  Session::overwrite($newvalue)
  <span class="comment">
   where $newvalue: a new value that overides the previous session value.  
  </span>
                                  </pre>
                              </div>
                          </div>

                          <div class="foot-note">
                            An example below best address how to properly overwrite the session global space
                          </div>

                            <div class="pre-area"> 
                                <div class="pxv-10 bc-silver">
                                    Sample: Session::overwrite()
                                </div>
                                <pre class="pre-code">
  $value = Session::value();<span class="comment">// fetch current session value</span>

  $value['some_key'] = "new_value"; <span class="comment">// perform some modification</span>

  Session::overwrite($value); <span class="comment">// overwrite entire session value</span>
                                </pre>
                            </div>


                        </div>


                    </div> <br>

                  <!-- overwrite -->
                  <div class="mvt-20">
                      <div class="mvs-4 c-orange"> <i class="bi-dash-circle-dotted"></i> Session::remove()</div>
                      <div class=" font-em-d9">
                          This method is used to remove the a key from the global session space. It can also be used to remove the entire 
                          value of a session.
                          <br><br>

                          <div class="code">  
                              <div class="pxv-10 bc-silver">
                                  Syntax: Session::remove()
                              </div>
                              <div class="pre-area">
                                  <pre class="pre-code">
  Session::remove($key?, $subkey?);
  <span class="comment">
   where:
   
    $key    : key expected to be removed from session  
    $subkey : subkey that is expected to be removed from a key in database 
  </span>
                                  </pre>
                              </div>
                          </div>

                          
                          <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Remove a data
                            </div>
                            <pre class="pre-code">

  $data1 = ['name'=>'foobaz'];

  $data2 = [
    
    'name1' => 'foo', 
    'name2' => 'bar', 

  ];

  Session::save('data1', $data1);
  Session::save('data2', $data2);


  Session::remove('data2', 'name2'); 
  
  var_dump(Session::value()); <span class="comment">//[ ['name'=>'foobaz'], ['name1' => 'foo']]</span>

  var_dump(Session::value('data1')); <span class="comment">// ['name1' => 'foobaz']</span>

  var_dump(Session::value('data2')); <span class="comment">// ['name1' => 'foo']</span>

  
  Session::remove(); <span class="comment">// remove entire session value</span> 

  var_dump(Session::value()); <span class="comment">// empty</span>
                                  </pre>
                              </div>

                              <div class="foot-note">
                                The sample above shows that a direct subkey of an array saved data can be removed from a key when both the key and the 
                                subkey is provided. However, if only the key is supplied, then only the key is removed. In the event that no key was 
                                supplied, the <code>remove()</code> method will assume to remove the entire sesion data.
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