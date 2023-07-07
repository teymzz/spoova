

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

 

    <div class="box-full bc-white-dd">
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start">
                    
                    <div class="font-em-d8 mvt-10">
                    
                        
 <div class="font-em-d8 pvs-4"> <?= $pointer ?? '' ?>  </div>
 <br>
    
                        <div class="font-em-1d5 c-orange"> <i class="bi-database-fill-gear"></i> Handling Database</div> <br>

                        <div class="db-connection">
                            <div class="fb-6 c-olive">Database connection</div>
                            <div class="">
                                Database connections are handled by default using the 
                                dbconfig file (i.e icore/dbconfig). However, this can be 
                                updated using specific predefined classes. It is worth mentioning that only sql
                                database systems are currently supported
                            </div> 
                        </div> <br>

                        <div class="db-operations">
                            <div class="fb-6 c-olive">Setting up a new connection using Database (DB) Class</div>
                            <div class=" font-em-1">There are different ways of opening a new connection and we'll be looking at a few examples</div> <br>
                            
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 1</div>
                        <pre class="pre-code">
  $dbc = (new DB);
  $dbh = $dbc->openDB();
                        </pre>
                            </div> <br><br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 2</div>        
                        <pre class="pre-code">
  $dbc = (new DB);
  $dbh = $dbc->openDB(DBNAME);
                        </pre>
                            </div> <br><br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 3</div>    
                        <pre class="pre-code">
  $dbc = (new DB);
  $dbh = $dbc->openDB(DBNAME, DBUSER, DBPASS, DBPORT, DBSERVER, DBSOCKET);
                        </pre>
                            </div> <br> <br>

                            <ul>
                                <li>
                                    In method (1) above, no arguments were supplied. 
                                    This makes the database class to assume the default 
                                    configurations already defined in the dbconfig.php file
                                </li><br>
                                <li>
                                    In method (2) above, only one database argument is supplied. 
                                    This makes the database class to assume only the default selected database  
                                    is needed to be updated. Hence, it switches to a new defined database using 
                                    default configurations.
                                </li><br>
                                <li>
                                    In method (3) above, all arguments were supplied. SOCKET is optional. 
                                    This makes the database class to overide the default configuration settings.
                                </li>
                            </ul>

                            <div class="foot-note">
                                <span class="fb-6">Footnote:</span><br>

                                <ul>
                                    <li>
                                        It is recommended to configure the default database connection 
                                        parameters in the dbconfig file. This may however be updated later. <br>
                                    </li>
                                    <li>
                                        Top level connection parameters will only affect subsequent
                                        connection when strictly defined. This is further discussed under 
                                        <a href="<?= Rexit::domurl('docs/useraccounts#running-queries') ?>">
                                            <span class="c-blue foot-note-hyperlink calibri  font-em-d9 fb-6">User Account Control</span>
                                        </a>
                                    </li>
                                    <li>
                                        For the purpose of this tutorial, <code>$dbh</code> will be referred to as <code>$db</code>
                                    </li>
                                </ul>


                                

                            </div>
                        </div> 
                        
                        <div class="db-connection">
                            <div class="fb-6 c-olive">Running Database Queries (CRUD)</div>
                            <div class="">
                                Database queries are handled using database crud and non-crud operators which are listed below:

                                <br><br>

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">SQL setters:</div>
                                    <div class="mvs-10">These are methods responsible for setting sql up queries</div>
                                    
                                    <ul class="olist">
                                        <li> <a href="<?= Rexit::domurl('docs/database/query') ?>">query() / queryState()</a>  </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/insert') ?>">insert_into()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/select') ?>">select()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/update') ?>">do_update()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/delete') ?>">do_delete()</a> </li>
                                    </ul>                 
                                </div>

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">CRUD Operators:</div>          
                                    <div class="mvs-10">
                                        These are query executors. 
                                        They tell database on how to process predefined sql queries.
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="<?= Rexit::domurl('docs/database/insert') ?>">insert()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/select') ?>">read()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/update') ?>">update()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/delete') ?>">delete()</a> </li>
                                        <li> <a href="<?= Rexit::domurl('docs/database/process') ?>">process()</a> </li>
                                    </ul>         
                                </div>   

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">Helper Operators:</div>          
                                    <div class="mvs-10">
                                        Other query executors are helper method which helps to reduce the time frame for performing simple tasks. 
                                        These are listed and explained below: <br>
                                    </div> 
                                    <ul class="olist pxl-14">
                                        <li> 
                                            <a>table_exists()</a> <br>

                                            <div class="c-black-ll pvs-10">This method returns true if a table exists in the database</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->table_exists('table_name')) {
      <span class="comment no-select">
    //run this code ...
      </span>
  }
                                                </pre>
                                            </div>

                                        </li> <br>

                                        <li> 
                                            
                                            <a>column_exist()</a> <br>
                                            <div class="c-black-ll pvs-10">This method returns true if a column exists in the database table name</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->column_exists('table_name', 'column_name')) {
      <span class="comment no-select">
    //run this code ...
      </span>
  }
                                                </pre>
                                            </div>   

                                        </li> <br>

                                        <li> 
                                            
                                            <a>addColumn()</a> <br>
                                            <div class="c-black-ll pvs-10">This method adds a column to database table. The syntax is shown below:</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->addColumn([table_name => column_name], type, pipe, definition, default)) {
  
  <span class="comment no-select">
    where: 

     table_name  : name of table where column will be added 

     column_name : name of column to be added 

     type        : type of column e.g ( decimal(2,5); varchar(200), e.t.c)

     pipe        : FIRST | AFTER FIELDNAME (After can be replaced with a pipe e.g "|Email" means AFTER Email )

     definition  : field definition (e.g NOT NULL, UNIQUE)

     default     : field default value.
  </span>
  
  }
 </pre>
                                            </div>   

<div class="foot-note">Note: The type (datetime) will set a default of <code>1970-01-01 00:00:00</code> as the default datetime which 
still translates as zero.</div>
                                        </li>

                                        <li> 
                                            
                                            <a>drop()</a> <br>
                                            <div class="c-black-ll pvs-10">This method drops a database, database field or column. Examples are shown below</div> 

                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->drop(true)) {
  <span class="comment no-select">
    //currently connected database dropped successfully!
  </span>
  }
  
  if($db->drop('table_name', true)) {
  <span class="comment no-select">
    //selected table_name of current database dropped successfully!
  </span>
  }
  
  if($db->drop('table_name', 'column_name')) {
  <span class="comment no-select">
    //relative column dropped successfully
  </span>
  }
  
                                                </pre>
                                            </div>   

                                        
                                        </li>
                                    
                                    </ul>  
                                    
                                </div>

                                <div class="pxs-10">
                                    <div class="fb-6 font-em-1d1 c-orange">Handling Errors:</div>          
                                    
                                    <div class="">
                                        When using any of the helper methods, the DBHandler <code>error_exists()</code> and <code>error()</code> method must be supplied 
                                        an argument of <code>true</code>  in order to function as expected. However <code>DBStatus::err()</code> will still return 
                                        the last error encountered. Errors are discussed below.
                                    </div>
                                    <div class="mvs-10">
                                        Spoova is a silent framework. Most errors are not displayed unless requested.
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="<?= Rexit::domurl('docs/database/errors') ?>">checking errors</a> </li>
                                    </ul>         
                                </div>   

                                <div class="pxs-10">
                                    <div class="fb-6 font-em-1d1 c-orange">Database Status:</div>          
                                    <div class="mvs-10">
                                        Database status tracker class <code>DBStatus</code> helps to keep track of last executed 
                                        sql queries and  error responses. 
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="<?= Rexit::domurl('docs/database/status') ?>">database status</a> </li>
                                    </ul>         
                                </div>   

                                <div class="pxs-10">
                                    <div class="fb-6 font-em-1d1 c-orange">Database Relationships:</div>          
                                    <div class="mvs-10">
                                        The database information can be communicated with under three database relationships which are the one-to-one, one to many 
                                        and many to many database relationships. These relationships are handled through the database model class which determines how 
                                        information are processed and returned. More information is provided about database relationships 
                                        <a href="<?= Rexit::domurl('docs/database/data-model') ?>" class="c-olive">here</a>. It may also be important to learn about working with 
                                        <a href="<?= Rexit::domurl('docs/session') ?>" class="c-olive">Session</a>, <a href="<?= Rexit::domurl('docs/forms') ?>" class="c-olive">Forms</a> and 
                                        <a href="<?= Rexit::domurl('docs/useraccounts') ?>" class="c-olive">User</a> classes before proceeding with database models because these classes have some form of 
                                        close relationship with each other.
                                    </div>         
                                </div>   


                            </div> 
                        </div> <br>
                    </div>

                </div>
            </div>
        </section>
    </div>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>