

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
          font-family: Roboto;
     }

     .tutorial{
          min-height:100vh;
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
          font-family: firacode;
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
    color: rgb(125, 125, 125);
    background-color : rgba(21, 15, 39);
}

body.--theme-dark .c-teal{
    color: rgb(2, 145, 145);
}

body.--theme-dark .bc-blue.c-white{
    background-color : rgb(35, 25, 66);;
    box-shadow: none;
    color: #8c8cb5;
    margin-bottom: 8px;
}

body.--theme-dark .nav-left ul a{
    color: rgb(129, 125, 120);
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
    <!-- @live -->
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

          <div class="flex pxv-10">
               <div class="flex-icon theme-btn navtheme bd bd-silver rad-r anc-btn-link flow-hide bc-silver ripple relative" style="transition: none">
                    <div class="px-40 b-cover ico-spin" data-src="<?= Rexit::mapp('images/icons/favicon.png') ?>" style="transition: none;"></div>
                    <div class="font-em-1d2 px-40 flex mid overlay fb-2 fira" style="top:-1.1px; left:.4px; z-index: 1; color:#202dd5;">
                         s 
                    </div>
               </div>
               <a href="<?= Rexit::domurl() ?>" class="flex">
                    <div class="flex midv mxl-8 fb-9  font-em-1d2" style="color: #202dd5">POOVA</div>
               </a>
          </div> <br>

          <ul class="list-square">
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
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">
                    
                    
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>

                    <div class="font-em-1d5 c-orange">Database : Select (CRUD)</div> <br> 
                    
                    <ul class="list-free pxs-1 mvt-10">
                        <li>
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> select</span> <br>
                             The select method directive is the top level sql setter method for
                            selecting data from database fields. It defines sql select queries that can be 
                            executed later.

                            <br><br>

                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Method 1 : select </div>
                        <pre class="pre-code">
  $db->select('* from users');
                        </pre>
                            </div> <br><br>

                            <div class="box-full font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Method 2 : select with chained controller </div>
                        <pre class="pre-code">
  $db->select('* from users')->where(['username'=>'Felix']);
                        </pre>
                            </div>

                            <div class="foot-note">
                                The method above is used to set simple sql queries. 
                                Method <code>where()</code> should only be chained once on the <code>select()</code> operator in the predefined order.
                            </div>

                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 1 : Executing predefined query </div>
                        <pre class="pre-code">
  $db->select('* from users')->where(['username'=>'Felix']);

  $result = $db->read();
                        </pre>
                            </div>

                            <div class="foot-note">
                                Reading from database comes with different formats as the <code>read()</code> method is
                                capable of applying limits to queries. Another method <code>results()</code> can be used to 
                                obtain and remodify data obtained from the database. Let's take a look at some few examples.
                            </div> <br>

                            <!-- reading with limit -->
                            
                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 2 (Reading with limit)</div> 
                        <pre class="pre-code">
  $db->query('select * from users')->read(1);
                        </pre>
                            </div>  
                            <div class="foot-note">In Example 2 above, only one data is fetched from the database</div>
                            <br>

                            <!-- reading with limits -->
                            
                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 3 (Reading with limits)</div> 
                        <pre class="pre-code">
  $db->query('select * from users')->read(1, 2);
  $db->query('select * from users')->read(5, 7);
                        </pre>
                            </div>   
                            <div class="foot-note">
                                In Example 3 above, only two data is fetched from the database table. <br><br>
                                The first query translates that the number 1 data on the database should be 
                                ignored whilst 2 data should be obtained after. <br>
                                The second query translates that the number 5 data on the database should be 
                                ignored whilst 2 data should be obtained after (i.e. 7). <br>
                            </div>

                            <div class="foot-note">
                                <span class="fb-6 c-orange-dd">Notice:</span>
                                It is worth noting that data obtained are always in a multi-dimentional array format.<br>
                            </div> <br>
                        
                        <li>
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> results </span> <br>
                             This method is applied on data obtained from the database. It performs a data modifier function.
                            <br><br>

                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 4 : Data Fetching</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix']);
  
  $result1 = $db->read()? $db->results() : [];
  
  $result2 = $db->read()? $db->results(0) : [];
  
  $result3 = $db->read()? $db->results(0, 'username') : [];
                        </pre>
                            </div>

                        <div class="foot-note">
                                When dealing with multi-dimentional arrays, data can be easily fetched and accessed<br><br> 
                                
                                <div class="pxs-4">Assuming we have a data returned where :</div> <br>
                                <code>$result1</code> obtained above translates <code>[0 => ['username'=>Felix]]</code>, 
                                <br> then :
                                <code>$result2</code> translates that the zero <code>0</code> key should be fetched, hence :  <br>
                                <code>$result2</code> will translate as <code>['username'=>Felix]</code> <br> 
                                <code>$result3</code> will translate as <code>Felix</code> <br> 
                                
                                <br>
                                Note : In this manner, we are able to pull data easily from the data obtained. If such key does not exist, <code>$result2</code> or <code>$result3</code> will be set as an empty value.
                            </div> <br>

                            <!-- Data Trimming -->
                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 5 : Data Trimming</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix'])->read(50);
  
  $six_results = $db->results(':6');
  
  $ten_results = $db->results(':10');
                        </pre>
                            </div>         
                            
                            <div class="foot-note">
                                When dealing with multiple results, data obtained can be further trimmed
                                into a specific number of items arrays. The first result obtained above i.e 
                                <code>$six_results</code> will only pull 6 results out of 50 results obtained or
                                less depending on the total number of results obtained. The second result obtained above i.e 
                                <code>$ten_results</code> will only pull 10 results out of 50 results obtained or
                                less depending on the total number of results obtained. <br>
                                
                                <br>
                                Note : In this manner, we are able to trim data easily from the data obtained. 
                            </div> <br>

                            <!-- Data Shuffling -->
                            <div class="box-full   font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 5 : Data Shuffling</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix'])->read(50);

  $results1 = $db->results(':shuffle');

  $results2 = $db->results(':10', ':shuffle');
                        </pre>
                            </div>         
                            
                            <div class="foot-note">
                                Data obtained can be shuffled. This means that every time a data is obtained,
                                it is shuffled or reshuffled. In the example above, 50 results may be obtained and then
                                reshuffled which changes the position of data obtained at each reload. <br><br>
                                
                                In <code>$results2</code> above, 10 data was pulled out of 50 data and then reshuffled.
                                Notice the shift in position of <code>:shuffle</code> directive when two arguments are supplied.
                            </div> <br>

                        </li> 
        
                    </ul>
                </div>
            </div>
        </section>
    </div>

    


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>