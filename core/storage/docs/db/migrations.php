



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Tutorial - Database Data Model</title>
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
         

<!-- @lay('build.co.coords:header') -->
    <style>
        table.opt{
            border-spacing: 10px;
            border-collapse: separate;
        }
    </style>
 

     

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
    <section class="pxv-20 tutorial database bc-white">
        <div class="font-em-1d2">

            
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/database">Database</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/database/migrations">Migrations</a>  </div>


            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Database : Migrations</div> <br>

                <div class="pxs-6">
                    Migration files are files that enable us to create or modify our database table in the format that is  
                    desirable for our project applications. Spoova has a simple migration tool that makes it easy to perform 
                    tasks like table creation, alteration or modification. Migration files are usually generated from the command line 
                    by running some specific commands that generates migration files.
                </div> <br>

                <div class="">

                    <div class="migration-files">
                        <div class="c-olive">Generating migration files</div>

                        <div class="d87 mvs-4">
                            Migration files can be generated with the command line by running the following commands: 
                        </div>

                        <div class="pre-area mvs-20">
 <pre class="pre-code">
  php mi add:migrator file_name 
 </pre>
                        </div> <br>

                        <div class="foot-note">
                            Using the syntax above, the "file_name" is generated into the <code>core/migrations</code> directory. 
                            Files are generated by appending the migration file name supplied to the current time. Hence, the  
                            migration file will look like <code>M1673742992_file_name.php</code>. The file created is usually 
                            one which must implement the <code>up</code> and <code>down()</code> method. The <code>up()</code> 
                            method will be called when the migration file is stepped up while the <code>down()</code> method will be called 
                            when the migration files are stepped down. When defining migration file names, it is 
                            only logical to use names that makes it easier to identify what the migration file does for easy recognition. Hence, 
                            a migration file will resemble the format below.
                        </div><br>

                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example : Migration file sample</div>
                    <pre class="pre-code">
  &lt;?php 

    class M1673742992_file_name {


        function up() {

        } 

        function down() {

        }

        function tablename() : string {
            return 'some_table';
        }


    }
                    </pre>
                        </div> <br><br>

                        <div class="d87">
                            The structure above resembles a full format of a migration file. While the <code>up()</code> 
                            and <code>down()</code> methods are essential, the <code>tablename()</code> method is is optional. 
                            However, by declaring the <code>tablename()</code> method, it makes it easier to manipulate our data in a 
                            way that will be discussed later.
                        </div> <br>



                    </div>

                    <div class="migration-schema">
                        <div class="c-orange font-em-1d5">Migration Schema</div>
                        <div class="d87 mvt-4">
                           The <code>DBSCHEMA</code> class is the only class that makes it easier to create manage tables successfully through the 
                           command line environment. Along with a <code>DRAFT</code> class, they can create, alter, modify, change or drop database 
                           tables. The <code>DBSCHEMA</code> class has only four main methods which are listed below: 
                           <br> 
                            <div class="mvt-10">
                                <div class="">
                                    The <code>DBSCHEMA::CREATE()</code> method is used to generate or create database tables
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::ALTER()</code> method is used to alter or modify existing database tables
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::DROP_TABLE()</code> method is the only way to drop a table.
                                </div> <br>
                                <div class="">
                                    The <code>DBSCHEMA::DROP_FIELD()</code> method is the easiest way to drop a table's column outside the 
                                    <code>DB::ALTER()</code> scope.
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div class="migration-draft">
                        <div class="c-olive">Migration Draft</div>
                        <div class="d87 mvt-4">
                            <p class="">
                                The <code>DRAFT</code> class defines the structure and format of a table. It contains database designs and modification 
                                plans. This class uses methods to pivot how a table should be modififed or created. These methods are used to either define 
                                a table's data type or foreign constraints or used to alter a tables structure. The <code>DRAFT</code> class is usually applied 
                                within the <code>DBSCHEMA::CREATE()</code> or <code>DBSCHEMA::ALTER()</code> environment in a migration file using the format below:
                                    
                                There are lists of methods which can be applied 
                                and we shall be taking a closer look to some of these methods:
                            </p>
                            <div class="font-em-1d1">
                                <div class="pre-area">
        <pre class="pre-code">
  &lt;?php 

    class M1673742992_file_name {


        function up() {

            DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

            });

        } 

        function down() {

            DBSCHEMA::ALTER('tablename', function(DRAFT $DRAFT){

            });

        }

    }  
     
        </pre>
                                </div> 

                                <div class="pvs-10 font-em-d9">
                                    We can also supply an object as the first argument of <code>CREATE</code>, <code>ALTER</code>, <code>DROP_TABLE</code> 
                                    or <code>DROP_FIELD</code> methods 
                                    provided that the object implements a method "tablename()" which returns a database table name. Hence, the format 
                                    below is also valid.
                                </div>   
                                
                            <div class="font-em-1d1">
                                <div class="pre-area">
        <pre class="pre-code">
  &lt;?php 

    class M1673742992_file_name {


        function up() {

            DBSCHEMA::CREATE($this, function(DRAFT $DRAFT){

            });

        } 

        function down() {

            DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

            });

        }

        function tablename(){

            return 'table_name';

        }

    }  
     
        </pre>
                                </div>                                
                            </div>

                            <div class="mvt-10">

                                <div class="data-type-methods">
                                    <div class="c-sea-blue">Data type methods</div>
                                    <div class="">
                                        These methods helps to define the type of a field. The can be applied either within the <code>DBSCHEMA::CREATE()</code> 
                                        or <code>DBSCHEMA::ALTER()</code> environment through the use of <code>DRAFT</code> class. This is because they can be used when generating or modifying a table's 
                                        column. The following are static methods used for defining a table's data type:
                                    </div> <br>
                                    <code>VARCHAR()</code>,
                                    <code>CHAR()</code>,
                                    <code>ENUM()</code>,
                                    <code>JSON()</code>,
                                    <code>TEXT()</code>,
                                    <code>TEXTFIELD()</code>,
                                    <code>INT()</code>,
                                    <code>INTFIELD()</code>,
                                    <code>BOOL()</code>,
                                    <code>BIT()</code>,
                                    <code>BINARY()</code>,
                                    <code>SERIAL()</code>,
                                    <code>DATE()</code>,
                                    <code>TIME()</code>,
                                    <code>YEAR()</code>,
                                    <code>BLOB()</code>,
                                    <code>BLOBFIELD()</code>,
                                    <code>REAL()</code>,
                                    <code>DECIMAL()</code>,
                                    <code>DOUBLE()</code>,
                                    <code>FLOAT()</code>
                                </div> <br>

                                <div class="constraint-methods">
                                    <div class="c-sea-blue">Constraint related methods</div>
                                    <div class="">
                                        These methods are mostly used to set constraints on tables. They are non-static methods 
                                        that can be chained on data type method using valid chain structures. These methods include:
                                    </div> <br>
                                    <code>DEFAULT()</code>,
                                    <code>NULL()</code>,
                                    <code>NOT_NULL()</code>,
                                    <code>SIGNED()</code>,
                                    <code>UNSIGNED()</code>,
                                    <code>INDEX()</code>,
                                    <code>UNIQUE()</code>,
                                    <code>FOREIGN_KEY()</code>,
                                    <code>PRIMARY_KEY()</code>,
                                    <code>CONSTRAINT()</code>,
                                    <code>AUTO()</code> or
                                    <code>AUTO_INCREMENT()</code>,
                                    <code>CASCADE()</code>,
                                    <code>RESTRICT()</code>
                                </div> <br>

                                <div class="modifier-methods">
                                    <div class="c-sea-blue">Modifier methods</div>
                                    <div class="">
                                        Similarly to data type methods, the modifier methods are static methods that are only defined within the <code>DBSCHEMA::ALTER()</code> scope. 
                                        They take only one argument which is a callback closure argument that must return a <code>DRAFT</code> object. Since their main function is to modify an already existing table, 
                                        the <code>DRAFT</code> object is used to pivot an alteration within them and the <code>DRAFT</code> is returned back by the callback closure function. There are only three 
                                        type of these method which are <code>MODIFY()</code>, <code>CHANGE()</code> and <code>DROP()</code>. It is however important to note that unlike the 
                                        <code>MODIFY()</code> and <code>CHANGE()</code> methods, the <code>DROP()</code> method does not implement a callback function. Assuming we have a <code>DRAFT</code> object <code>"$DRAFT"</code>, 
                                        the <code>MODIFY</code> or <code>CHANGE</code> methods can be applied in the following format:
                                    </div> <br>

                                    <div class="pre-area">
    <pre class="pre-code">

    DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

        $DRAFT::MODIFY( function($DRAFT) { 
            
            $DRAFT::DATA_TYPE(); <span class="comment">// use any of the data type method here.</span>

            return $DRAFT;
        
        } );

    });

    </pre>
                                        <div class="c-grey pxs-20 font-em-d9">    
                                            The structure above defines the format which is used to modify a column's data type only. 
                                            Since it modifies only one column, we can reformat our code as below:
                                        </div>

    <pre class="pre-code">

    DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

        <span class="c-sky-blue-dd">$DRAFT::MODIFY( fn() => $DRAFT::DATA_TYPE() );</span>

    });

    </pre>

                                    </div> <br><br>

                                    <div class="pre-area">
                                        <div class="pxv-10 bc-silver">Example</div>
    <pre class="pre-code">

    DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

        <span class="c-sky-blue-dd">$DRAFT::CHANGE( fn() => $DRAFT::INT('fieldname', 2) );</span>

    });

    </pre>
                                    </div> <br><br>

                                    <div class="foot-note">
                                        <p class="">
                                            <p>
                                                In the example above, assuming the "fieldname" was a "VARCHAR" field before, the new data type "INT" will convert the field to an integer 
                                                field using the supplied length. The second argument in this case which is the length, must be the argument accepted to be valid by the field. 
                                            </p>

                                            <p>
                                                The <code>DROP()</code> method drops a database table column or database table's index. 
                                                It takes one or two arguments depending on what is expected to be dropped. If one argument is supplied, 
                                                it is assumes that the migration table's field is expected to be dropped unless it is set as "PRIMARY KEY" which 
                                                will drop the current table's primary key. However, if two arguments are supplied, then the first is assumed to be 
                                                an index type (e.g UNIQUE) while second argument will be the index name that is expected to be dropped. An example is shown below:
                                            </p>
                                            
                                        </p>
                                    </div>

                                    <div class="pre-area">
    <pre class="pre-code">

    DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

        <span class="c-sky-blue-dd">$DRAFT::DROP( 'address' );</span> <span class="comment">// drop current database table's field</span>

    });

    </pre>
                                    </div> <br><br>

                                    <div class="pre-area">
    <pre class="pre-code">

    DBSCHEMA::ALTER($this, function(DRAFT $DRAFT){

        <span class="c-sky-blue-dd">$DRAFT::DROP( 'UNIQUE', 'initials' );</span> <span class="comment">// drop unique index "initials" from current table</span>

    });

    </pre>
                                    </div> <br><br>


                                </div>
                            </div>
                        </div>                    
                    </div> <br>

                    <div class="defining-database">
                              <div class="c-olive">Setting column data type</div>
                        <div class="d87">
                            <div class="mvs-10">
                                The data type methods above sets the data type of field. The first argument in most cases is the name of the field 
                                to be altered or created. However the <code>INTFIELD()</code>, <code>TEXTFIELD()</code> and <code>BLOBFIELD()</code> takes the  
                                type of field first before the second argument which is the name of the column to be altered or modified. After 
                                defining the column name, then other properties are defined based on size, precision 
                                or options depending on the type of method called. The data type methods are listed below:
                            </div>

                            <div class="groups">
                                <div class="">
                                    <!-- <code>ID(<span class="c-grey">int $size = 0, string $name = 'id'</span>)</code> -->
                                </div>
                                <div class="">
                                    <code>VARCHAR(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>CHAR(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>ENUM(<span class="c-grey">$name, $options, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TEXT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>INT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BLOB(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TEXTFIELD(<span class="c-grey">$type, $name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>INTFIELD(<span class="c-grey">$type, $name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BLOBFIELD(<span class="c-grey">$type, $name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BIT(<span class="c-grey">$name</span>)</code>
                                </div>
                                <div class="">
                                    <code>BINARY(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>BOOL(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>SERIAL(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>FLOAT(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DOUBLE(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DECIMAL(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>REAL(<span class="c-grey">$name, $size, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DATE(<span class="c-grey">$name, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>DATETIME(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TIMESTAMP(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>TIME(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>YEAR(<span class="c-grey">$name, $precision, $default</span>)</code>
                                </div>
                                <div class="">
                                    <code>COMMENT(<span class="c-grey">$string</span>)</code>
                                </div>

                                <div class="foot-note mvs-10">
                                    Arguments are defined by the scope in which they are used or the type of field being created. 
                                    Each of these arguments are explained below:
                                </div>

                                <div class="bc-white-dd pxv-4">
                                    <code>$name</code> 
                                    <span>
                                        This is usually the first argument of any of the data type methods except in <code>INTFIELD()</code> 
                                        <code>BLOBFIELD()</code> and <code>TEXTFIELD()</code> method where it comes as the second argument. 
                                        It defines the name of a table's column when used within 
                                        the <code>DBSCHEMA::CREATE()</code> scope. However, within the <code>DBSCHEMA::ALTER</code> 
                                        it supports an array of old column name to new table name, where the index of the array is the 
                                        old column name while the value of that array index is the new column name.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">

                                    <code>$type</code> 
                                    <span>
                                        This is usually the first argument of any of the three data type methods <code>INTFIELD()</code> 
                                        <code>BLOBFIELD</code> and <code>TEXTFIELD</code>. It mostly defines the type of a field based on the 
                                        relative data type through any of the options listed below 
                                        <div class="pxv-10">

                                            <table class="font-em-d85 c-teal opt">
                                                <tr>
                                                    <th class="clip-100">Field</th>
                                                    <th class="clip-150">Description</th>
                                                    <th>Options</th>
                                                </tr>
                                                <tr>
                                                    <td>INTFIELD</td>
                                                    <td>For integer columns</td>
                                                    <td>[ INT | [TINYINT/TINY] | [SMALLINT/SMALL] | [BIGINT/BIG] ]</td></tr>
                                                <tr>
                                                    <td>TEXTFIELD</td>
                                                    <td>For text columns</td>
                                                    <td>[ TEXT | [TINYTEXT/TINY] | [MEDIUMTEXT/MEDIUM] | [LONGTEXT/LONG] ]</td>
                                                </tr>
                                                <tr>
                                                    <td>BLOBFIELD</td>
                                                    <td>For text columns</td>
                                                    <td>[ BLOB | [TINYBLOB/TINY] | [SMALLBLOB/SMALL] [MEDIUMBLOB/MEDIUM] | [LONGBLOB/LONG] ]</td>
                                                </tr>
                                            </table>

                                        </div>

                                        Options such as <code>TINY</code>, <code>SMALL</code>, <code>BIG</code>, <code>MEDIUM</code> and 
                                        <code>LONG</code> are usually aliases for their respective methods.
                                        
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$size</code> 
                                    <span>
                                        This defines the size of a table's column. Most but not all of the data type methods supports the 
                                        <code>$size</code> argument. The $size method may exist as an array, string or integer depending on the type of 
                                        table column being defined. In methods such as <code>FLOAT</code>, <code>DOUBLE</code>, <code>DECIMAL</code> 
                                        and <code>REAL</code>, the <code>$size</code> usually define both the precision and column length. In integer 
                                        related methods, the <code>$size</code> is defined as a string while in text related methods, it is defined as a string. 
                                        In decimal related methods such as <code>FLOAT</code>, <code>DECIMAL</code>, <code>REAL</code> and <code>DOUBLE</code>, 
                                        this argument is supplied as an array. 
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$option</code> 
                                    <span>
                                        This argument is only implemented by the <code>ENUM()</code> method which is an array that contains a list of 
                                        valid options to be applied on a field.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$precision</code> 
                                    <span>
                                        This argument is only used in time related methods such as <code>DATE</code>, 
                                        <code>DATETIME</code>, <code>TIMESTAMP</code>, <code>TIME</code> and <code>YEAR</code>. 
                                        It defines the precision for the field that is expected to be created or modified.
                                    </span>
                                </div> <br>

                                <div class="bc-white-dd pxv-4">
                                    <code>$default</code> 
                                    <span>
                                        In methods that implements this argument, the argument sets a default value for the field or column 
                                        to be created. This can also be added by using the <code>DEFAULT()</code> constriant method.
                                    </span>
                                </div>

                                <div class="bc-white-dd pxv-4">
                                    <code>$comment</code> 
                                    <span>
                                        This argument is implemented by the <code>COMMENT()</code> method. It is used to set a comment on a particular 
                                        field.
                                    </span>
                                </div>

                            </div>
                        </div>              
                    </div> <br>

                    <div class="">
                        <div class="c-olive"> The ID() Data Type Method </div>
                        <div class="">
                            
                            The <code>ID()</code> method is used to generate an auto-incremental primary key field. By default, the column 
                            name is set as "id" but that can be modified by supplying a custom name as the second argument. The first argument takes 
                            the length of field from a minimum of 1 to a maximum of 255. The syntax is shown below: <br>
                            <br>

                            <div class="bc-white-dd pxv-4">
                                <code class="bd-f">DRAFT::ID(<span class="c-grey">$size, $custom_name</span>);</code> <br>
                                
                                <div class="c-grey pxv-10 font-em-d85">
                                    <code>$size</code> as length of field <br>
                                    <code>$custom_name</code> as custom column name. Default is "id"
                                </div>
                            </div>

                        </div>
                    </div> <br>

                    <div class="">
                        <div class="c-olive-dd">Setting database column constraints</div>
                        <div class="d87">
                            <div class="">
                                Constraint methods are used to apply contraints on table columns. These constraint can be applied during table 
                                creation or modification on tables or generated table columns. These methods <code>DEFAULT()</code>, 
                                <code>NULL</code>, <code>NOT_NULL()</code>, <code>PRIMARY_KEY()</code>, <code>FOREIGN_KEY()</code>, <code>SIGNED()</code>, 
                                <code>UNSIGNED()</code>, <code>CONSTRAINT()</code>, <code>AUTO_INCREMENT()</code> are listed and explained below:
                            </div>
                            <br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">DEFAULT CONSTRAINT</div>
                                <div class="">
                                    The method <code>DEFAULT()</code> is used to set a default value for a field. While numeric values may be supplied for  
                                    interger or float fields, strings are mostly used to define string values, constants or functions. 
                                    Generally, all strings arguments are treated as string unless it uses a defined structure for constant or functions. 
    
                                    <div class="defining-constants">
                                        <div class=""> Defining special strings </div>
                                        <div class="">
                                            Special strings are known as unquoted strings which may be a constant or function. In order to separate normal strings from 
                                            special string, the special strings must be wrapped within a parenthesis (i.e "(value)"). Any value placed within the parenthesis is 
                                        treated as a special string. In this way, setting a default <span class="c-teal">"CURRENT_TIMESTAMP"</span>  constant will be defined as 
                                            <code>DEFAULT("(CURRENT_TIMESTAMP)")</code> while systemic functions such as <span class="c-teal">"GETDATE()"</span> can be defined 
                                            as <code>"(GET_DATE())"</code>. Without setting the parenthesis, the value may be treated as a normal string.
                                        </div>    
                                    </div>
                                </div>
                            </div> <br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">NULL and NOT NULL CONSTRAINT</div>
                                <div class="">
                                    The method <code>NOT_NULL()</code> is used to set a "NOT NULL" constraint on fields while the <code>NULL()</code> 
                                    method defines that a field may accept a null value.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">SIGNED AND UNSIGNED CONSTRAINT</div>
                                <div class="">
                                    The <code>SIGNED()</code> or <code>UNSIGNED()</code> constraints can be chained along with an <code>INT()</code> or 
                                    <code>INTFIELD()</code> method which literally defines whether the intended integer field to be created is signed or unsigned.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">CONSTRAINT METHOD</div>
                                <div class="">
                                    The <code>CONSTRAINT()</code> method is used to define a new constraint that has an identifier name which can be used to store the 
                                    intended unique or foreign key field. It takes an argument of an index storage name. Usually, this method may come before methods like 
                                    <code>UNIQUE()</code> or <code>FOREIGN_KEY()</code> is called.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">UNIQUE CONSTRAINT</div>
                                <div class="">
                                    A unique constraint can be set on a single field by chaining it on a any of the data type methods. In this case, no argument is 
                                    required because the current field is assumed to be the unique field. However, to set multiple fields as unique 
                                    fields, they must be called on the <code>CONSTRAINT()</code> method which takes an argument of the unique identifier name. If the 
                                    <code>UNIQUE()</code> method is chained on <code>CONSTRAINT()</code>, then multiple column names can be supplied as an array which denotes that 
                                    the array lists of supplied column names are intended to be uniquely binded.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">PRIMARY KEY CONSTRAINT</div>
                                <div class="">
                                    In order to define a field as a primary key field, the <code>PRIMARY_KEY()</code> method is employed. 
                                    This method can take a string or an array as the names of fields intended to be set as primary key field. 
                                    When no argument is supplied, it uses the current field name as the intended primary key field.
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">AUTO (or AUTO_INCREMENT) CONSTRAINT</div>
                                <div class="">
                                    The <code>AUTO()</code> is a short alias for <code>AUTO_INCREMENT()</code> which defines the automatic increment feature on a primarily defined 
                                    integer column. 
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">FOREIGN KEY CONSTRAINT</div>
                                <div class="">
                                   This method is used to apply a foreign key constraint on two tables. In this case, the first argument 
                                   is expected to be the parent table's name while the second argument is an array which contains an 
                                   index and relative value. The index is expected to be the foreign key (or column) name in the current migration table while 
                                   the value is the local key (or column) name on the parent table
                                </div>
                            </div><br>
                            <div class="">
                                <div class="font-em-d85 c-orange-dd fb-6">INDEX CONSTRAINT</div>
                                <div class="">
                                   The <code>INDEX()</code> method sets an index constraint on a table's field.
                                </div>
                            </div>
                        </div>

                    </div> <br>

                    <div class="">
                        <div class="adding-fields font-em-1d5 c-orange-dd">
                            Creating new table Format
                        </div>
                        <div class="">
                            The creation of new tables are handled by the <code>DBSCHEMA::CREATE()</code> scope using the <code>DRAFT</code> data type 
                            chaining structures.
                        </div> <br>
                        <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                               Sample: Creating a table
                            </div>
    <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::ID();

        $DRAFT::VARCHAR('firstname', 100)->NOT_NULL();

        $DRAFT::VARCHAR('lastname', 100)->NOT_NULL();

        $DRAFT::VARCHAR('username', 255)->NOT_NULL(); 
        
        $DRAFT::VARCHAR('password', 255)->NOT_NULL(); 
        
        $DRAFT::VARCHAR('email', 255)->NOT_NULL(); 
        
        $DRAFT::VARCHAR('address', 1000);
        
        $DRAFT::VARCHAR('phone', 20);
        
        $DRAFT::DATETIME('added_on', "(CURRENT_TIMESTAMP)");
        
        $DRAFT::DATETIME('updated_on')->DEFAULT("(CURRENT_TIMESTAMP)");
        
        $DRAFT::UNIQUE(['username', 'password']);

        return $DRAFT;

    })        
    </pre>
                        </div>
                    </div>

                    <div class="foot-note mvs-10 bc-silver pxv-10">
                        The format above is a sample of table columns definition format.
                    </div><br>

                    <div class="">
                        <div class="adding-fields font-em-1d5 c-orange-dd">
                            Adding Fields To Existing Table
                        </div>
                        <div class="">
                            Most of the data type method can be applied to add more fields to a table or to add indexes to table. Since the 
                            <code> DBSCHEMA::ALTER()</code> is used to modify tables, by declaring a data type method within this method, the  
                            migrator engine assumes that a new field is intended to be created. The methods like <code>AFTER()</code> and <code>BEFORE()</code> 
                            can be applied to specify the position where the new column is expected to be added. An example is shown below: <br>
                        </div> <br>
                        <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::ALTER('tablename', function(DRAFT $DRAFT){

        $DRAFT::VARCHAR('fullname')->AFTER('username'); <span class="comment no-select">// add fullname field after username column</span>
        $DRAFT::VARCHAR('address')->AFTER('firstname'); <span class="comment no-select">// add firstname field to the beginning of the table</span>

        return $DRAFT;

    })        
    </pre>
                        </div>
                    </div> <br>

                    <div class="">
                        <div class="dropping-fields font-em-1d5 c-orange-dd">
                            Dropping Fields or Indexes From Existing Table
                        </div>
                        <div class="">
                            The <code>DBSCHEMA::ALTER()</code> environment can also be used to drop a database table or table indexes just as shown below.
                        </div> <br>
                        <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::ALTER('users', function(DRAFT $DRAFT){

        $DRAFT::DROP('fullname'); <span class="comment no-select">// drop fullname column in users table</span>
        
        $DRAFT::DROP('PRIMARY KEY'); <span class="comment no-select">// drop the primary key from the table</span>
        
        $DRAFT::DROP('INDEX', 'unique1'); <span class="comment no-select">// drop the index name "unique1" from the table.</span>
        
        $DRAFT::DROP('UNIQUE', 'unique2'); <span class="comment no-select">// drop the unique name "unique2" from the table.</span>
        
        $DRAFT::DROP('FOREIGN KEY', 'unique3'); <span class="comment no-select">// drop the FOREIGN KEY name "unique3" from the table.</span>

        return $DRAFT;

    })        
    </pre>
                        </div>
                    </div> <br>

                    <div class="">
                        <div class="dropping-fields font-em-1d5 c-orange-dd">
                            Dropping an Existing Table
                        </div>
                        <div class="">
                            From the <code>DRAFT</code> class the <code>DROP(true)</code> or <code>DROP_TABLE()</code> can be used to drop the current table.
                        </div> <br>
                        <div class="pre-area">
                            <div class="bc-silver pxv-10">
                                Drop current table users
                            </div>
    <pre class="pre-code">
    DBSCHEMA::DROP_TABLE('users'); <span class="comment">// drop current table "users".</span>        
    </pre>
                        </div>
                    </div> <br>

                    <div class="">
                        <div class="renaming-fields font-em-1d5 c-orange-dd">
                            Renaming an Existing Table
                        </div>
                        <div class="">
                            The migration engine can also be used to rename a table through the <code>DRAFT::RENAME()</code> method.
                        </div> <br>
                        <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::ALTER('users', function(DRAFT $DRAFT){

        $DRAFT::RENAME_TO('user_table'); <span class="comment no-select">// rename current table "users" to "user_table"</span>

        return $DRAFT;
        
    })        
    </pre>
                        </div>
                    </div> <br>

                    <div class="">
                        <div class="renaming-fields font-em-1d5 c-orange-dd">
                            Renaming an Existing Table's Field
                        </div>
                        <div class="">
                            The <code>CHANGE()</code> method can be used to change the field name as shown below .
                        </div> <br>
                        <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::ALTER('users', function(DRAFT $DRAFT){

        $DRAFT::CHANGE(function() use($DRAFT) {

            $DRAFT::VARCHAR(['firstname' => 'fname']); <span class="comment no-select">// change firstname to fname of VARCHAR type</span>
            
            $DRAFT::VARCHAR(['lastname' => 'lname']);  <span class="comment no-select">// change lastname to lname of VARCHAR type</span>
            
            $DRAFT::INT(['serial_no' => 'serial']); <span class="comment no-select">// change serial_no to serial field of INT type</span>

            return $DRAFT;

        }); 
        
    })        
    </pre>
                        </div>
                        <div class="foot-note mvs-10">
                            In the code above we are able to change the fields names and data types through the <code>CHANGE()</code> modifier method 
                            within the <code>DBSCHEMA::ALTER()</code> scope. It is worthy to note that only the <code>CHANGE()</code> method accepts array 
                            arguments for data type methods, which makes it easier to change fields names. The <code>$DRAFT</code> object can also be supplied within the 
                            callback function instead of defining it within the <code>use()</code> function.
                        </div>
                    </div> <br>



                    <div class="">
                        <div class="renaming-fields font-em-1d5 c-orange-dd">
                            Converting Table Character Type
                        </div>
                        <div class="">
                           A table's character type can be converted to another character type by the use of the <code>DRAFT::CONVERT_TO()</code> 
                           method.
                        </div> <br>
                        <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::ALTER('users', function(DRAFT $DRAFT){

        $DRAFT::CONVERT_TO('latin 1'); <span class="comment no-select">//set current table character type to latin</span>
        
    })        
    </pre>
                        </div>
                    </div> <br>



                    <div class="">
                        <div class="sample-structures font-em-1d5 c-orange-dd">
                            Table Partitioning
                        </div>
                        The migration files can also be used to set up table partitions. Partitioning is mostly done by through the use of 
                        partitioning methods which are: 
                        
                        <code>PARTITION_BY</code>, <code>COLUMNS</code>, <code>PARTITION</code> and <code>VALUE</code>

                        Usually, these methods are called in the order in which they are listed.
                        <br><br>

                        <div class="">
                            <div class="">
                                <div class="partition_by c-teal flex midv">
                                  <span class="bi-circle-fill font-em-d8 mxr-6"></span>  PARTITION_BY
                                </div>
                                This method set the type of partition that is expected to be used to partition the tables. Valid options are 
                                <code>RANGE</code> and <code>LIST</code>. The second argument takes a callback function.
                            </div> <br>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example of usage
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::PARTITION_BY('RANGE', function(DRAFT $DRAFT){

            <span class="comment">//some code here</span>
            return $DRAFT;

        });

    })
 </pre>
                            </div>

                        </div> <br>

                        <div class="">
                            <div class="">
                                <div class="columns c-teal flex midv">
                                   <span class="bi-circle-fill font-em-d8 mxr-6"></span> COLUMNS
                                </div>
                                This specifies allows the definition of partition types as columns. For example, through this method we can have a type of 
                                "RANGE COLUMN" and "LISTS COLUMN". It also uses specific structures to determine if a partition is "RANGE" or "RANGE COLUMN". 
                                The first argument which is expected to be an array will either set a partition type as the type defined through the 
                                <code>PARTITION_BY()</code> (i.e RANGE or LIST) or it will automatically append a <code>"COLUMN"</code> string to the partition set if it detects 
                                an array within a supplied array argument. For example:
                            </div> <br>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example 1a: Type of RANGE
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::PARTITION_BY('RANGE', fn() => $DRAFT::COLUMN('col1') );

    })
 </pre>
                            </div>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example 1b: Type of RANGE
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::PARTITION_BY('RANGE', fn(DRAFT $DRAFT) =>

            $DRAFT::COLUMN(['col1', 'col'])

        );

    })
 </pre>
                            </div>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example 2: Type of RANGE COLUMN
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::PARTITION_BY('RANGE', function(DRAFT $DRAFT){

            $DRAFT::COLUMN([['col1','col2'], ['col3','col4']]);

            return $DRAFT;

        });

    })
 </pre>
                            </div>

                            <div class="foot-note mvs-10">
                               The only difference between the <code>RANGE</code> and <code>RANGE COLUMN</code> above is that 
                               in <code>RANGE COLUMN</code>, the array argument supplied to <code>COLUMN()</code> method also contains 
                               array values.
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                <div class="partition c-teal flex midv">
                                  <span class="bi-circle-fill font-em-d8 mxr-6"></span>  PARTITION
                                </div>
                                This method is used to set the identifier names of each partition specified. By setting the partitioning names, 
                                the database table can easily be queried using the specified partitions. The <code>PARTITION</code> method takes 
                                two arguments. The first argument is the partition identifier name, while the second argument defines the logic used 
                                for partitioning. This logic can be "LESS THAN" (or "VALUE LESS THAN") and "IN" (or "VALUES IN").
                            </div> <br>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example of usage
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::PARTITION_BY('RANGE', fn() =>

            $DRAFT::COLUMNS('col1')

                ->PARTITION('p0','VALUES LESS THAN');

        );

    })
 </pre>
                            </div>

                        </div> <br>

                        <div class="">
                            <div class="">
                                <div class="partition_by c-teal flex midv">
                                  <span class="bi-circle-fill font-em-d8 mxr-6"></span>  VALUE
                                </div>
                                This method the value or list of values that is used to separate a table. The values defined within this method 
                                are the values by which the table will be partitioned.
                            </div> <br>

                            <div class="pre-area">
                                <div class="pxv-10 bc-silver">
                                    Example of usage
                                </div>
 <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){

        $DRAFT::INT('number', '2')->NOT_NULL();

        $DRAFT::PARTITION_BY('RANGE', fn(DRAFT $DRAFT) =>

            $DRAFT::COLUMNS('number')

                ->PARTITION('p0','VALUES LESS THAN')->VALUE(500)
                ->PARTITION('p1','VALUES LESS THAN')->VALUE(300)
                ->PARTITION('p2','VALUES LESS THAN')->VALUE(200)

        );

    })
 </pre>
                            </div>

                            <div class="foot-note mvs-10"> 
                                Note that the <code>VALUE</code> method can also take string as its parameter. An example is shown below:
                            </div>

                            <div class="pre-area">
    <pre class="pre-code">
    DBSCHEMA::CREATE('tablename', function(DRAFT $DRAFT){
        
        $DRAFT::INT('number', '2')->NOT_NULL();

        $DRAFT::DATETIME('date')->DEFAULT('(CURRENT_TIMESTAMP)');


        $DRAFT::PARTITION_BY('RANGE', fn(DRAFT $DRAFT) =>

            $DRAFT::COLUMNS('date')

                ->PARTITION('p0','VALUES LESS THAN')->VALUE(500)
                ->PARTITION('p1','VALUES LESS THAN')->VALUE(300)
                ->PARTITION('p2','VALUES LESS THAN')->VALUE(200)

        );

    })        
    </pre>
                            </div>

                        </div>

                    </div> <br>

                    <div class="">
                        <div class="sample-structures font-em-1d5 c-orange-dd">
                            Executing migration files
                        </div>
                        The migration files <code>up()</code> and <code>down()</code> methods are responsible for executing migrations 
                        when we run certain commands from the command line. 

                        <br><br>

                        <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Running migrations up
                            </div>
 <pre class="pre-code">
  >> <span class="c-orange-dd">php</span> mi migration up
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The command above will execute all migration files by calling the <code>up()</code> method of each files in an ascending order. 
                            We can also execute the <code>down()</code> method by running the command below:
                        </div><br>

                        <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Running migrations down
                            </div>
 <pre class="pre-code">
  >> <span class="c-orange-dd">php</span> mi migrate down
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            In the cases where we want to run the migration files down in a specific number of times, we can also specify the number of times we 
                            want to run down (or reverse) the migration files just as shown below:
                        </div> <br>

                        <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Running migrations down in number of times
                            </div>
 <pre class="pre-code">
  >> <span class="c-orange-dd">php</span> mi migrate down 4
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The command above will step down migration files starting from the last executed migration file and ending in the 
                            file that occupies the number of times specified. This stepping down system is only applied for a down migration. 
                            Also, note that the connection used depends on the configuration file settings defined in 
                            the <code>icore/dbconfig.php</code> file. 
                        </div> <br>

                        <div class="pre-area">
                            <div class="pxv-10 bc-silver">
                                Getting migration status
                            </div>
 <pre class="pre-code">
  >> <span class="c-orange-dd">php</span> mi migrate status
 </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The command above tries to fetch the migration status from the database reserved <span class="c-orange">migrations</span>. The status 
                            table is only shown if the database connection is successful and the migrations table has been generated.
                            table.
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