



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

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/tutorial">Tutorial</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/database">Database</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/tutorial/database/data-model">Data-Model</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Database : Data Model</div> <br>

                    <div class="pxs-6">
                        Models are structures built to have a direct relationship with database. Hence,
                        they are capable of performing database queries. Spoova makes it easy to pull user data 
                        from database by creating certain model structures that depends on a user account. Once a user 
                        session is active and an id is obtained, the model is designed to perform advanced data pull from 
                        database which are built upon the following methods.
                        <br>
                        
                        <div class="font-em-d85">
                            <br> <code>Model::ofUser()</code>
                            <br> <code>Model::of()</code>
                            <br> <code>Model::where()</code>
                            <br> <code>Model::read()</code>
                            <br> <code>Model::update()</code>
                            <br> <code>Model::delete()</code>
                        </div>

                    </div> <br>

                    <ul class="list-square pxs-6 list-free">
                        <li class="mxs-2">
                            <div class="c-olive">  <span class="flex midv"><span class="mxr-4">&#9635</span>OfUser()</span></div> 

                            <div class="font-em-d9 mvt-6">
                                The <code>ofUser()</code> method is used to pull a data of the current user session account. 
                                The database default structure format demands that any table owned by the current user must have a 
                                <code>user_id</code> foreign key column that is mapped to the id field on the user's table. When data 
                                are obtained using models, <code>ofUser()</code> makes it possible to pull only data related to the current user.
                                For example: If a database table <code>"user"</code> contains an id (primary key) column, then a table (comments) must have a field 
                                name with <code>user_id</code>. The user_id is then used to pull data from the <code>comments</code> table which belongs
                                to the current session user. 
                            </div>

                            <br>

                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Sample - PostModel.php</div>
                        <pre class="pre-code">
  &lt;?php

    namespace teymzz\spoova\core\class\Models;
    use Models;

    Posts extends Models {       


    }

    public static function tableName() {
        return 'Posts';
    }

  }
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                In Example above, a post model was extended to the Models class with the table name "Posts". 
                                When data is pulled from this class, it uses the "Posts" database table. If the <code>ofUser()</code> 
                                static method is applied on "Posts" (i.e <code>Posts::ofUser()</code> ), then spoova will try to find 
                                the <span>Posts</span> related to the current user id by looking for a <code>user_id</code> field in the 
                                <code>Posts</code> table. By default, this method uses the current user id to pull data, however, this can be modified.
                                The <code>ofUser()</code> method takes its first argument as an integer. This integer is the id of the user 
                                whose data must be pulled from the database. For example:

                                
                            </div> <br>
                                
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow"> 
    <pre class="pre-code">
  &lt;?php

    Use Window
    use teymzz\spoova\windows\Models\Posts;

    Home extends UserFrame {       

        function __construct() {

            $currentUserPosts = Posts::ofUser()->read()->Posts;

            $customUserPosts = Posts::ofUser(2)->read()->Posts;

        }

    }

  }
    </pre>
                            </div> <br>
                            <div class="font-em-d87 mvt-10">
                                In Example above, a post model was used to obtain data of the current user or a custom user just by setting the 
                                user id. This is by far the easiest way to pull data from database without writing any query. Spoova will run its 
                                queries internally to pull respective data from the database then store it using the current model name. It should 
                                be noted that the <code>read()</code> method is used to read data from the database while the <code>->Posts</code>
                                is the current Model name which stores the data obtained as a traversable object. When an error occurs, the last error 
                                is saved and can be obtained using the <code>read()->DBError</code> property. In the event that the foreignKey field name is 
                                not user_id, then a second argument can be supplied into the <code>ofUser()</code> method to define a new key name, In this 
                                relationship, the user database table (i.e user) will be the owner while the Model (e.g Posts) table is being owned. We don't need to set the 
                                user table since that has been done in the <code>icore/init</code> file during installation.
                            </div> <br>
                        </li>

                        <li class="mxs-2">
                            <div class="c-olive">  <span class="flex midv"><span class="mxr-4">&#9635</span>Of()</span></div>
                            <div class="font-em-d9 mvt-6">
                                The <code>of()</code> method is similar to the <code>ofUser()</code> method. In this method, the table name can be 
                                customized if the relationship is between a model and any other database table. The first argument 
                                takes a new database table name while other arguments follows the ForeignId and ForeignKey structure respectively. By default, 
                                if the owner database table for example is <code>"admin"</code>, then a owned table <code>"posts"</code> must have an "admin_id" foreign key field 
                                while the owner table must have an "id" local key field which helps spoova 
                                to naturally connect the two fields. For example:
                            </div> <br>
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 2 - Child of Parent table </div>
                                <pre class="pre-code">
  Posts::of('admin', 3)->read()->Posts;
                                </pre>
                            </div> <br><br>
                            
                            <div class="font-em-d87">
                                In the Example above, the posts database table will look for posts where admin_id is 3. It should be noted that 
                                the "admin_id" foreign key is generated from the combination of the singular form of the owner table along with an 
                                "id" local key by default. This means that for example, if the owner table was "admin" or "admins", then the default 
                                generated foreign key will be "admin_id".
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 3 - Child with custom foreign key of Parent table  </div>
                        <pre class="pre-code">
  Posts::of('admin', 3, 'user_id')->read()->Posts;
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                The example above is of a more complex relationship between database tables in which the foreign key is a custom <code>user_id</code> field. 
                                It is assumed that the custom foreign key supplied in this case is related to the admin table's local key "id". 
                                This means that the admin table must have an "id" primary key field.
                                <!-- In this relationship, both the Posts and Admins table must have a 
                                ForeignKey fieldname of "user_id". Posts will then select only Posts where user_id is 3 and the value(3) can also be found in the Admins "user_id" table. -->
                            </div>
                            <br>

                        </li>

                        <li class="mxs-2">
                            <div class="c-olive">  <span class="flex midv"><span class="mxr-4">&#9635</span>bind()</span></div>
                            <div class="font-em-d9 mvt-6">
                                The <code>bind()</code> method is a method that can be called upon the model's <code>of()</code> method. 
                                The <code>bind()</code> method is used to set up a connection between three database fields. In this 
                                connection, the binded table is the highest table while the current model is the lowest table. The database table structures 
                                resemble the format below: 
                                <br>
                                <div class="pxv-10 bc-silver-dd mvs-10">
                                    <div class="in-flex mid">
                                        <div class="px-20 rad-r bd bd-2 flex mid">A</div>
                                        <div class="">----</div>
                                        <div class="flex mid"><div class="pxv-2 flex mid bd-2 clip-40">B</div></div>
                                        <div class="">----</div>
                                        <div class="px-20 rad-r bd bd-2 flex mid">C</div>
                                    </div>
                                </div>
                                
                                The code chain structure, however resembles the format below: <br>
                                <div class="pxv-10 bc-silver-dd mvs-10">
                                    <div class="in-flex mid">
                                        <div class="px-20 rad-r bd bd-2 flex mid">A</div>
                                        <div class="">--</div>
                                        <div class="px-20 rad-r bd bd-2 flex mid">C</div>
                                        <div class="">
                                            ------
                                        </div>
                                        <div class="flex mid"><div class="pxv-2 flex mid bd-2 clip-40">B</div></div>
                                    </div>
                                </div>

                                <div class="">
                                    In the structure above, while "A" is a child table to "C", the "C" is a child to binded table "B". 
                                    The "C" table is the link table or bridge between "A" and "B". This connection assumes that if table "A" is a child table, 
                                    then table "C" is a parent table while table "B" is a grand table. In order to set up this connection, the table "A" must have 
                                    a Foreign key field name "C_id" (modifiable) relative to its direct parent "C" and the table "C" must have a Foreign key name "B_id" (non-modifiable) relative to its 
                                    direct parent "B". Once the connection is successfully chained, we can proceed to obtain our data through the use of the current model's property which must be initialized 
                                    with a capital letter case. The code below is an example of this connection.
                                </div>
                            </div>
                            
                            <div class="foot-note mvs-10">Assuming we have a table structure as below:</div>

                            <div class="pre-area shadow">
                        <pre class="pre-code">
  comments 
    -id
    -post_id 

  posts 
    -id 
    -user_id 

  user 
    -id
                        </pre>
                            </div>

                            <div class="foot-note mvs-10">
                                In the table structure above, we can link to the owner of the comment's post through the  
                                post id.
                            </div>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                        <pre class="pre-code">
  Comments::of('posts', 3)->bind('users')->read()->Comments;
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                The setup above assumes that, the <code>comments</code> table has a foreign key field of <code>post_id</code> while the 
                                <code>posts</code> table has a foreign key field of <code>user_id</code>. From the sample above, the 
                                comment table will look within itself for where post_id foreign key is equivalent to posts table local key "id" 3. 
                                then the posts table will bind the parent "users" by using the parent foreign key field name "user_id". 
                                This relationship can thus be defined as a complex relationship, one that is defined for a Child, Parent and GrandParent. 
                                In the event that the foreign key of the post table on comments table above is not <code>post_id</code>, this can be modified by supplying a third
                                argument of the foreign key field name on the <code>of()</code> method.
                            </div> <br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                        <pre class="pre-code">
  Comments::of('posts', 3, 'foreignKey')->bind('users')->read()->Comments;
                        </pre>
                            </div>

                        </li> <br>

                        <li>
                            <div class="c-olive">read()</div>
                            <div class="font-em-d9 mvt-6">
                                This <code>read()</code> method as explained earlier is used to retrieve data from database. It takes two arguments. The first argument (string or array) is the number of selected 
                                columns to return while the second argument (array) defines the limit of data to be returned
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 4 - read</div>
                        <pre class="pre-code">
  User::read()->User; <span class="comment">// fetch all user data</span>

  User::read(['username'])->User; <span class="comment">// fetch only the username of every user</span>

  User::read(['firstname', 'lastname'], [10])->User; <span class="comment">// fetch firstname and lastname of 10 users</span>
                        </pre>
                            </div> <br><br>
                        </li>

                        <li>
                            <div class="c-olive">delete()</div> 
                            <div class="font-em-d9 mvt-6">
                                This <code>delete()</code> method takes a single parameter which can either be a bool of true or an integer limit of number of data to be deleted. The limit may not 
                                be applicable on multiple table. Calling this method without a condition can be dangerous as all records 
                                belonging to the relative database table may get deleted. The bool argument of "true" ensures that a developer 
                                is aware of the changes they are about to make (i.e deleting all records) before making them. If no argument is supplied, and no condition is set on the delete method, 
                                this method will not delete any data. It is also advised to to keep the live server off if this method will be applied. 
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 5 - delete</div>
    <pre class="pre-code">
  Posts::delete(<span class="c-red-dd">true</span>); <span class="comment">//delete all posts</span>
    </pre>
                            </div>
                        </li> <br>

                        <li>
                            <div class="c-olive">update()</div>
                            <div class="font-em-d9 mvt-6">
                                This <code>update()</code> method is used to update a selected record. 
                                It takes a single array parameter. Which contains key(field name) and value(new) pairs. When a condition is not set upon it,
                                all records will be updated: 
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 6 - update</div>
    <pre class="pre-code">
  Posts::update(['date' => <?= (date('Y-m-d'))?? "" ?> ]) <span class="comment">//update all posts records, set all date rows as "<?= (date('Y-m-d'))?? "" ?>"</span>
    </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                               It is generally advised to turn off live server when performing operations that modifies the database records to prevent auto-execution of queries.
                            </div>
                            <br>
                        </li>

                        <li>
                            <div class="c-olive">Where</div>
                            <div class="font-em-d9 mvt-10">
                                This method is used to set a situation where a particular condition is met. It is usually called upon the model name itself. Any of the 
                                <code>read()</code>, <code>update()</code> and <code>delete()</code> methods can be applied upon it.
                            </div> <br>
                            
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 7 - where</div>
                        <pre class="pre-code">
  User::where('id = ?', [1])->read()->User; <span class="comment">// read user where id is one</span>
  User::where('id = ?', [1])->delete(); <span class="comment">// delete user where id is 1</span>
  User::where('id = ?', [1])->update(['firstname'=>'Felix']); <span class="comment">// update user where id is 1, set firstname as "Felix"</span>
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                The examples above, are cases in which the <code>where()</code> condition can be applied. The first argument contains list of fields and placeholders 
                                for binded parameters while the second argument contains a list of binded parameter values.
                            </div>
                            <br>
                        </li>
                    
                    </ul>

                    
                    <div class="">

                        <div class="font-em-1d2 c-orange">Database Relationships</div>

                        <div class="">
                        Database relationships have three main structures which are: 
                        <span class="c-dodger-blue">one to one</span>,
                        <span class="c-dodger-blue">one to many</span> and
                        <span class="c-dodger-blue">many to many</span> relationships. Spoova model uses static methods to link and 
                        obtain database information under these three defined relationships. When working with relationships, data obtained 
                        can be accessed through a small letter case property unlike the default with uses an uppercase inital case. The 
                        <code>vdump()</code> helper function might serve a good purpose to view the type of data returned.
                        <br><br>
                        
                        <!-- one to one (ownsOne) -->  
                        <div class="">
                            <div class="font-em-1 c-olive-d fb-6 calibri">One to One Database Relationship (matchOne)</div>
                            <div class="calibri">
                                In this relationship, a child model class method is placed as a method upon its Parent Model. The type of relationship is then defined. Once the relationship 
                                is defined, then we can call the method. It is important to note that the child method must be a static method. 
                                <br><br>
                                Consider two database tables "user" and "admin" where a user cannot exist twice within the admin table. Using the structure below 

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Table structure</div>
                                    <pre class="pre-code">
  user 
    -id 
    -username

  admin 
    -id 
    -user_id
                                    </pre>
                                </div> <br>
                                
                                <div class="">Here, we need to create the User and Admin Model classes as below:</div><br>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Admin model</div>
                                    <pre class="pre-code">
  class Admin extends Model {


  }
                                    </pre>
                                </div> <br><br>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">User model</div>
                                    <pre class="pre-code">
  class User extends Model {

    function __construct(){
        
    }

    function admin(){

        return matchOne(Admin::class);

    }


  }
                                    </pre>
                                </div> <br><br>

                                <div class="">
                                    In the code above, the User model will try to look for a <code>"user_id"</code> foreign key 
                                    field within the admin table. The "user_id" is generated from the combination of the 
                                    current model's name and a default local key name "id". Once the relationship is defined, 
                                    we can obtain the data by calling the method as below: 
                                </div><br>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Obtain relative data</div>
                                    <pre class="pre-code">
  User::admin()->read()->admin;
                                    </pre>
                                </div> <br>                             

                                <div class="foot-note mvs-10">
                                    The code above will return a travsersable object containing the obtained data. The <code>read()</code> 
                                    method is a directive that tells the Model to obtain the defined relationship data between a model and 
                                    its respective child models. Also, unlike the <code>of()</code> and <code>ofUser()</code> methods that use 
                                    the Model's name as a property to obtain data, when accessing data under any of the known predefined relationships, 
                                    the first parameter of any relationship is used to obtain the collected data. For example, the <code>admin</code> 
                                    property was used to access the data because the first argument of <code>matchOne()</code> is the <code>Admin::class</code>. 
                                    In situations where the foreign key is not "user_id", we can supply the foreign key as the second parameter. 
                                    Also if the local key is not "id", we can supply the local key as the third argument just as below:
                                </div>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">User model</div>
                                    <pre class="pre-code">
  class User extends Model {

    function __construct(){
        
    }

    function admin(){

        return matchOne(Admin::class, 'foreign_key', 'local_key');

    }


  }
                                    </pre>
                                </div> <br><br>
<div class="d87">
The above data simulates a structure or format for setting up a one to one relationship between two database tables. By default, 
spoova uses the model name of classes as the default database table name. This behaviour can be overidden by setting the model's table 
name using the <code>tableName()</code> method which can be applied for any model. For example in the code below, the "PostItems" model will 
assume that the database table name is <code>post</code>  rather than <code>postitems</code> because the default behaviour was changed. <br><br>
</div>
                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">PostItems model</div>
                                    <pre class="pre-code">
  class PostItems extends Model {

    function __construct(){
        
    }

    function admin(){

        return matchOne(Some::class);

    }

    static function tableName() : string{
        
        return 'posts';

    }


  }
                                    </pre>
                                </div> <br><br>
                                
                            </div>
                        </div> <br>
                        
                        <!-- one to one (matchOneFor) -->  
                        <div class="">
                            <div class="font-em-1 c-olive-d fb-6 calibri">One to One Database Relationship (matchOneFor)</div>
                            <div class="calibri">
                                This relationship ensures that we can access the data of a parent model by using the relationship  
                                between the parent's child model and the current model
                                <br><br>
                                Consider three database tables "student", "book" and "author" as a structure below:
                                <br><br>
                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Table structure</div>
                                    <pre class="pre-code">
  student 
    -id 
    -name
    -book_id

  book 
    -id 
    -author_id

  author 
    -id 
    -user_id
                                    </pre>
                                </div>
                                
                                <div class="mvs-10">
                                    In the structure above, assuming that each student can only keep a single book from each author, 
                                    we can access the book's author by declaring the <code>matchOneFor</code> relationship as shown below: 
                                </div>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Student model</div>
                                    <pre class="pre-code">
  class Student extends Model {


    static function bookAuthor(){

        return matchOneFor(Author::class, Book::class);

    }


  }
                                    </pre>
                                </div> <br><br>

                                <div class="">
                                    In the code above, since the <code>student</code> is connected to the <code>book</code> by the 
                                    <code class="c-sea-green">book_id</code> foreign key and the <code>book</code> 
                                    is connected to the <code>author</code> by the <code class="c-sea-green">author_id</code> foreign key, 
                                    the <code>matchOneFor</code> relationship will pull the author data by using the <code>Book</code> model. 
                                    The <code>matchOneFor(Author::class, Book::class)</code> simply translates as "match one Author::class for Book::class". 
                                    Once the relationship is defined we can obtain our data as below:
                                </div><br>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Obtain relative data</div>
                                    <pre class="pre-code">
  Student::bookAuthor()->read()->author;
                                    </pre>
                                </div> <br>                             

                                <div class="foot-note mvs-10">
                                    The code above will return a travsersable object containing the obtained data. 
                                    By default, this relationship assumes that the default local keys for <code>author</code> 
                                    and <code>book</code> are both <code class="c-sea-green">id</code> respectively. 
                                    We can however, overide this condition by supplying a custom Foreign and Local keys for 
                                    both the <code>author</code> and the <code>book</code> by supplying a third and fourth 
                                    argument respectively as an array of Foreign and local keys, where the first value of the array 
                                    is the foreign key while the second value is a local key just as shown below:
                                </div>

                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Student model</div>
                                    <pre class="pre-code">
  class Student extends Model {


    static function bookAuthor(){

        return matchOneFor(Author::class, Book::class, ['authorForeignKey', 'authorLocalKey'], ['bookForeignKey', 'bookLocalKey']);
    
    }


  }
                                    </pre>
                                </div>
                                
                            </div>
                        </div> <br>
                        
                        <!-- one to many (matchMany) -->  
                        <div class="">
                            <div class="font-em-1 c-olive fb-6 calibri">One to Many Database Relationship (matchMany)</div>
                            <div class="calibri">

                                <div class="">
                                    <p>
                                        Similarly to "one-to-one" relationship, in "one-to-many" relationship, the child model class 
                                        method is placed on its Parent Model. Within the child Model, the "matchMany" relationship is defined. 
                                        Once this relationship is defined, then we can call the method.
                                    </p>
                                    <p>
                                        Consider the database tables "posts" and "comments". Each post can have many comments. Using the 
                                        table structure below, we can set up a one to many relationship:
                                    </p>
                                </div>
<!-- code begins -->
                                <div class="pre-area shadow">
                                    <div class="pxv-10 bc-silver">Table structure</div>
                                    <pre class="pre-code">
  posts 
    -id 
    -username

  comments 
    -id 
    -post_id
                                    </pre>
                                </div> <br>
<!-- code ends -->
                                <div class="foot-note mvs-10">
                                    Using the table structure above, now we can access our data as below:
                                </div>
                                
<div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    use teymzz\spoova\core\classes\Model;

    Posts extends Model {

        static function comments(){

            return self::matchMany(Comments::class);

        }

    }

    </pre>


</div>
                                <div class="foot-note mvs-10">
                                    Now, we can access our relationship by calling the static method just as below:
                                </div>
                                
<div class="pre-area shadow">
    <pre class="pre-code">
  Post::comments()->read()->comments;
    </pre>
</div>
                                

                                <div class="d87">
                                    The above data simulates a structure or format for setting up a one to many database relationship between two database tables.
                                    The structure reflects that since the <code>Post</code> model owns many comments, then spoova assumes that we are trying to read 
                                    the comments which are more than one. We can also modify the foreign and local key of the parent model through a second and/or third argument. 
                                    as shown below:
                                </div>
<div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    use teymzz\spoova\core\classes\Model;

    Posts extends Model {

        static function comments(){

            return self::matchMany(Comments::class, 'foreign_key', 'local_key');

        }

    }

    </pre>


</div>
                                       
                            </div>
                        </div> <br>
                        
                        <!-- one to many inverse -->  
                        <div class="">
                            <div class="font-em-1 fb-6 calibri c-olive">One to Many Database Relationship (matchedFor) inverse of "matchOne"/"matchMany"</div>
                            <div class="calibri">
                                In a similar manner like "one-to-one" and "one-to-many" relationship, the <code>matchedFor</code> sets an inverse relationship for these two relationship 
                                (i.e matchOne and matchMany). In this case, the current model where this relationship is defined assumes that it is being owned by a parent model.  
                                This relationship can be defined by placing a Parent model class method on its Child Model. Within the Child Model, the "matchedFor" relationship will be defined 
                                This means that the first parameter of the <code>matchedFor</code> must be a parent model. Once the relationship is defined, then we can call the method. 
                                <br><br>
                                
                                <div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    use teymzz\spoova\core\classes\Model;

    Posts extends Model {

        static function user(){

            return self::matchedFor(User::class);

        }

    }
    </pre>

                                </div>

                                <div class="foot-note mvs-10">
                                Now, we can access our relationship by calling the static method just as below:
                                </div>
                                
                                <div class="pre-area shadow">
    <pre class="pre-code">
  Posts::user()->read()->posts;
    </pre>
                                </div>


                                <div class="foot-note mvs-10">
                                    Because the relationship above is an inverse relationship, rather than accessing 
                                    the data by using the parent model's table name (i.e user), instead, we have to access the data through the 
                                    child model (i.e post). The benefit of this setup is that we get to understand 
                                    the kind of relationship that exists between the <code>Post</code> model and the <code>User</code> model as one between 
                                    a child and a parent respectively. We can also modify the foreign and local key of the supplied class through a second and 
                                    third argument as shown below:
                                </div> 
                                <div class="pre-area">
   <pre class="pre-code">
  &lt;?php 

    use teymzz\spoova\core\classes\Model;

    Posts extends Model {

        static function user(){

            return self::matchedFor(User::class, 'foreign_key', 'local_key');

        }

    }
    </pre>
                                </div>

                            </div>
                        </div> <br>
                        
                        <!-- many to many relationship -->  
                        <div class="">
                            <div class="font-em-1 fb-6 calibri c-olive">Many to Many Database Relationship (maps)</div>
                            <div class="calibri">
                                This relationship is more advanced than the "one-to-one" and "one-to-many" database relations. 
                                This can be best explained with a situation in which a user can have many roles while many roles can 
                                also be assigned to multiple users. Using a database structure between a user and role tables, a third 
                                table "role_user" which is generated through alpabetic conjuction of role and table, we have a sample 
                                structure as below: 
                                <br><br>
                                
                                <div class="pre-area shadow">
    <pre class="pre-code">
  users 
    -id
    -name 

  roles 
    -id 
    -role

  user_role 
    -id 
    -user_id 
    -role_id
    </pre>

                                </div>

                                <div class="foot-note mvs-10">
                                In the code sample structure above, the <code>users</code> and <code>roles</code> table both have a binding 
                                relationship through a third table <code>role_user</code> which by default contains fields generated by the 
                                singular form of its source tables along with a default "id" local key specific to both parent fields. Both the 
                                singular form and the default local key are separated by and underscore "_". It is important to note that the 
                                singular form of any table is genarated by stripping off the last "s" character of that table name. This means that 
                                while a singular form of <code>users</code> will be <code>user</code>, the singular form of <code>user</code> will 
                                also be <code>user</code>. Using the table structure above, we can set up our relationship as shown below:
                                </div>
                                
                                <div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    class User extends Model {

        static function roles(){

            return maps(Roles::class);

        }

    }
    </pre>
                                </div>

                                <div class="foot-note mvs-10">
                                    In the relationship above, the user class will connect to the <code>roles</code> table by using the relationship it has with the <code>user_role</code> 
                                    table. If the linking table is not <code>user_role</code> which is the default, then we can supply the custom table name as the second argument. 
                                    Also, in this relationship, the parent tables <code>users</code> and <code>roles</code> must have an "id" primary key. However, the foreign keys can be 
                                    modified. The supplied model's custom foreignkey and the current model's foreign key on the linking table can be supplied as the third and fourth argument 
                                    respectively. Hence we can have a format as below:
                                </div>
                                
                                <div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    class User extends Model {

        static function roles(){

            return maps(Roles::class, 'bindingTable', 'rolesForeignKey', 'userForeignKey');

        }

    }
    </pre>
                                </div>

                                <div class="foot-note mvs-10">
                                    We can also define an inverse relationship for the above through the <code>Roles</code> class just as below
                                </div>

                                <div class="font-em-1 calibri">
                                
                                    <div class="pre-area shadow">
    <pre class="pre-code">
  &lt;?php 

    class Roles extends Model {

        static function roles(){

            return maps(User::class);

        }

    }
    </pre>
                                    </div>

                                </div>
                            </div>

                       

                        </div> <br>

                        <!-- collections -->
                        <div class="font-em-1 calibri collections">

                            <div class="font-em-1d2 fb-6 calibri c-olive">Collection</div>

                            <p>
                                All properties obtained in any database relationship are reflections of the collection class. This means that 
                                rather than calling the property itself, data returned can still be accessed using the <code class="calibri">collection()</code> method. For example:                                
                            </p>

                            <div class="pre-area shadow">
 <pre class="pre-code">
  User::posts()->read()->posts;

  User::posts()->read()->collection(); <span class="c-grey i no-select">//same as above</span>
 </pre>
                            </div>

                            <div class="d87 mvt-6">
                                The <code>collection()</code> method will enable us to access the correct property 
                                assigned to any relationship. 
                            </div> <br>    
<!-- code begins -->                                
                            <div class="pre-area shadow">

 <pre class="pre-code">
  Posts::user()->read(['firstname'], 2)->posts;
 </pre>

                            </div>
                            <div class="foot-note mvt-10">
                                The code above returns two posts, showing only the firstname of the users that made the two posts.                              
                            </div>
<!-- code ends -->
                        </div> <br> 
                        
                        <!-- reading -->
                                    

                        <div class="font-em-1 calibri reading">
                            <div class="font-em-1d2 fb-6 calibri c-olive">
                                Read method
                            </div>
                            <div class="">
                                The <code>read()</code> method is a directive that tells a model to process the relationship defined 
                                in a way that the relative data is returned. For example, we can select unambiguos fields easily by 
                                declaring the array list of fields we want to obtain as the first parameter of the <code>read</code> 
                                method just as shown below:
                            </div>
<!-- code begins -->                                
                            <div class="pre-area shadow">

    <pre class="pre-code">
  User::posts()->read(['firstname','lastname','post'])->posts;
    </pre>

                            </div>
                            
                            <div class="foot-note mvs-10">
                                In the code above, the <code>read()</code> method will process the data in a way that only the "firstname", 
                                "lastname" and "post" of each posts is returned depending on the type of relationship defined. We can also set 
                                the limit of data obtained by setting the limit as a second parameter.
                            </div>

                            <!-- code ends -->
                            <div class="pre-area shadow">

    <pre class="pre-code">
  User::posts()->read(['firstname','lastname','post'], [10])->posts;
    </pre>

                            </div>                                        
                            <div class="foot-note mvs-10">
                                Setting limits on <code>read</code> method works exactly as the query builder crude operator "read()" does. This means 
                                that we can also define the position at which the data is being obtained by defining two limits within the second argument.
                            </div>
                        </div>

                    </div> <br> <!-- database relationships (end) -->

                                        
                    <div class="modifying-relationships">

                        <div class="font-em-1d2 c-orange">Modifying Relationships</div>

                        <div class="calibri">
                            When setting up relationships, there are certain conditions or modification can be applied to data obtained using 
                            predefined methods. These methods are <code>where()</code>, <code>withDefault()</code>, <code>use()</code>, <code>byRecent()</code> and <code>order()</code>. 
                            These methods can only be applied before the <code>read()</code> method is called. Once the data is obtained through the 
                            <code>read()</code> method, then we can apply other methods which are <code>error()</code>, <code>pull()</code>, <code>protect()</code> 
                            and <code>shuffle()</code>.
                        </div>

                        <div class="where-condition">
                            <div class="pre-area shadow mvt-10">
                                <div class="pxv-10 bc-silver">Setting up "Where" condition</div>
 <pre class="pre-code">
   User::where('id = ?', [1])->read()->User; <span class="c-grey i no-select">// only user table where "id" field is 1 will be selected</span>
   User::posts()->where('posts.id = ?', [1])->read()->posts; <span class="c-grey i no-select">// only posts table where "id" field is 1 will be selected</span>
 </pre>

                            </div> 
                            <div class="foot-note">
                                The example above gives an insight into how the <code>where()</code> method can be applied on models or relationships. This method enables 
                                us to be able to set certain conditions which our data must meet before it can be successfully obtained. The 
                                <code>where()</code> method takes the first argument as a raw string that defines a list of fields and their respective values (or binded parameter placeholders). 
                                If the binded parameter sign (i.e "?") is used, then a second parameter that matches the number of expected binded values must be supplied 
                                on the <code>where()</code> method.
                            </div>                          
                        </div>



                        <div class="with-default">
                            <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Setting up "withDefault" condition</div>
  <pre class="pre-code">
   User::where('id=?', [1])->withDefault(['name' => 'Felix Russel'])->read()->User;
  </pre>

                            </div>
                            <div class="foot-note mvs-10">

                                The <span class="c-sea-green-d">"withDefault"</span> condition enables us to set up our data 
                                with a default data value if such key does not exist in the data obtained. It is important to note 
                                that the default data supplied will not be returned should any error occur from the generated sql query. 

                            </div>                            
                        </div>

                        <div class="use-clause">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Setting up "use" condition</div>
 <pre class="pre-code">
  User::posts()->use([Postclass => ['id'=>'postid'], User::class => ['id' => 'userId']])->read()->posts;
 </pre>
                            </div>

                            <div class="foot-note mvs-10">
                                In certain situations, where we have two similar fields between two related tables "A" and "B", the field in table "A" may 
                                overide the field in table "B". In this situation, it might be difficult to pull the record from the table that was overidden. 
                                The <code>use</code> method enables us to customize table names or even fetch a table that was overidden. The code sample is 
                                above is a way by which we can pull hidden data. The <code>use()</code> method is supplied an an array argument which contains 
                                the model class (or table name) as index while the index's takes an array value of old field name and new custom field name of the 
                                related index which in this case is a table or model class. In this way, we can fetch the hidden data without any problem. The index 
                                (or model classes) supplied must be related tables, else, an error will be returned. The <code>use()</code> method cannot be applied directly on a model. 
                                It can either be binded on the <code>where()</code> method or directly on dynamic relationship methods such as <code>of()</code>, <code>ofUser()</code> 
                                or dynamic relationship methods such as the example given above before the <code>read()</code> method is called.
                            </div>    
                            
                        </div>


                        <div class="by-recent">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Setting up "byRecent" condition</div>
 <pre class="pre-code">
  <span class="c-grey-dd no-select">1.</span> User::posts()->byRecent()->read()->posts;

  <span class="c-grey-dd no-select">2.</span> User::posts()->byRecent('date')->read()->posts;

  <span class="c-grey-dd no-select">3.</span> User::posts()->byRecent([Posts::class, 'post'])->read()->posts;

  <span class="c-grey-dd no-select">4.</span> User::posts()->byRecent(['posts', 'post'])->read()->posts;
 </pre>
                            </div>

                            <div class="foot-note mvs-10">
                                The <code>"byRecent"</code>  condition allows us to select recent data. It cannot be used with the <code>order()</code> 
                                method. By default, 
                                a "one-to-one" relationship will use the <code>id</code> of the parent model to select recent 
                                data while a "one-to-many" will use the <code>id</code> of the child model to select 
                                recent data if a custom field is not defined. For example, assuming we are working with a "one-to-many" relationship, then:<br>
                                <ul class="pxl-20 mvt-10">
                                    <li>
                                    In code line 1, the recent data will be sorted by using the Posts model's id field since no custom field is defined. 
                                    </li>
                                    <li>
                                        In code line 2 above, the data will be sorted using the "date" field of the Posts model. 
                                    </li>
                                    <li>
                                        Code line 3 above will select the post based on the supplied model class and the custom field "post" defined. 
                                    </li>
                                    <li>
                                        In line 4 above, the sort table "posts" is defined rather than supplying the model's class. While line 3 is dependent on the 
                                        model table name, line 4 is independent. 
                                    </li>
                                    <li>
                                        Under a <code>one-to-one</code> or <code>many-to-many</code> relationship, data will be sorted based on the model calling the 
                                        relationship unless the sort table name (or model) is  defined.
                                    </li>
                                </ul>
                            </div>    
                            
                        </div>

                        <div class="by-order">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Setting up "order" condition</div>
 <pre class="pre-code">
  <span class="c-grey-dd no-select">1.</span> User::posts()->order('firstname')->read()->posts;
  <span class="c-grey-dd no-select">2.</span> User::posts()->order('firstname', 'DESC')->read()->posts;
  <span class="c-grey-dd no-select">3.</span> User::posts()->order([Posts::class, 'post'])->read()->posts;
  <span class="c-grey-dd no-select">4.</span> User::posts()->order(['posts', 'firstname'])->read()->posts; <span class="no-select comment">// same as line 3 above if Posts::tablename() is not modfified</span>
 </pre>
                            </div>

                            <div class="foot-note mvs-10">
                                The <code>order()</code> condition allows us to select data by order. It overides the <code>byRecent()</code> method hence, it cannot be used along with it.
                                The first argument is the field used to sort the data while the second argument defines the order in which the field is sorted. By default, the second argument 
                                uses the ascending order "ASC" but can be changed to descending order "DESC". <br>
                                <ul class="pxl-20 mvt-10">
                                    <li>
                                        In code line 1, the data will be sorted in ascending order by using the Owner model's firstname field depending on the relationship type.
                                    </li>
                                    <li>
                                        In code line 2, the data will be sorted in descending order by using the Owner model's firstname field depending on the relationship type. 
                                    </li>
                                    <li>
                                        In code line 3, the data will be sorted in descending order by using the Posts model's (table name) and table field "post". 
                                    </li>
                                    <li>
                                        In code line 4, the data will be sorted in descending order by using the posts table and table field "post". This may be similar to line 3 above if the 
                                        table name is not modified.
                                    </li>
                                </ul>
                            </div>    
                            
                        </div>

                        <div class="pulling-data">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Pulling data</div>
 <pre class="pre-code">
   vdump(User::posts()->read()->pull(1));
 </pre>

                            </div>   
                            <div class="foot-note mvs-10">
                                <span class="">
                                    Whilst the <code class="c-brown-ll">read()</code> method returns a multidimentional transversible object, 
                                    the <code class="c-brown-ll">pull()</code> method allows us to pull data out of a list of collections 
                                    using the defined data access key. For example, the code above will pull out the first data obtained from a multidimentional 
                                    data. This method does not require the use of <code>collection()</code> or dynamic property to access the 
                                    returned data. Hence, we can directly pull a data out of the object using the index key of that object as 
                                    shown above. The data returned is usually a Collectibles object.
                                </span>                                  
                            </div>                         
                        </div>

                        <div class="protecting-data">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Protecting data</div>
 <pre class="pre-code">
   User::where('id = ?', [1])->read()->protect(['password']);
 </pre>

                            </div>   
                            <div class="foot-note mvs-10">
                                <span class="">
                                    The <code class="c-brown-ll">protect()</code> method allows us to hide a specific data value.
                                    Once an access key is protected, the value becomes <span class="c-brown-ll">***Protected***</span>. 
                                    The code above is an example local scope protection.  
                                    Data collections can also be protected at a global level. This means 
                                    that all models will remember to hide the value of some specific fields. 
                                    This can be done by calling the <code class="c-brown-ll">Collection::protect()</code> method. 
                                    Once the protection is set up, all models will ensure to protect 
                                    the data keys set on the global scope just as below:
                                </span>                                  
                            </div>   
                            <div class="pre-area shadow">
 <pre class="pre-code">
   User::where('id = ?', [1])->read()->collection(); <span class="no-select comment">//password value not protected</span>

   Collection::<span class="c-violet-dd">protect(['password']); </span>  <span class="no-select comment">//password protected globally</span>

   User::where('id = ?', [1])->read()->collection(); <span class="no-select comment">//password value protected from global protection</span>
 </pre>
                            </div>                                                  
                        </div> <br>

                        <div class="shuffle-data">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Shuffle data</div>
 <pre class="pre-code">
   User::where('id = ?', [1])->read()->shuffle();
 </pre>

                            </div>   
                            <div class="foot-note mvs-10">
                                <span class="">
                                    The <code class="c-brown-ll">shuffle()</code> method is used to shuffle the data returned within the 
                                    collection object. It takes no argument.
                                </span>                                  
                            </div>                                                    
                        </div>

                        <div class="shuffle-data">
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">The <span class="c-orange">get()</span> method</div>
 <pre class="pre-code">
  Comments::of('posts')->read()->Comments
 </pre>

                            </div>   
                            <div class="foot-note mvs-10">
                                <span class="">
                                    When we have a multiple lists of data returned in the collection object, we can pull out a specific data using the 
                                    the data key. Assuming we have a chained structure as above and a returned data format as shown below:
                                </span>                                  
                            </div>     
                            
                            
                            <div class="pre-area shadow">
                                <pre class="pre-code">
  <span class="c-orange-dd">object(spoova\core\classes\Collection)[24]</span>

    private 'data' => 
        array (size=2)

        0 => 
            <span class="c-orange-dd">object(stdClass)[25]</span>
                public 'id' => int 1
                public 'user_id' => int 2
                public 'post' => string 'This is a post' (length=14)
                public 'added_on' => string '2023-01-04 18:42:00' (length=19)
                public 'post_id' => int 2
                public 'comment' => string 'This is a comment to a post' (length=27)
        1 => 
            <span class="c-orange-dd">object(stdClass)[26]</span>
                public 'id' => int 2
                public 'user_id' => int 2
                public 'post' => string 'This is a post' (length=14)
                public 'added_on' => string '2023-01-12 21:22:32' (length=19)
                public 'post_id' => int 2
                public 'comment' => string 'This is a second comment to post' (length=32)

    private 'datakeys' => 
        array (size=2)

        0 => int 0
        1 => int 1

    private 'iterator' => int 0

    private 'callables' => 
        array (size=0)
        
        empty

    public 'error' => string '' (length=0)                                
                                </pre>
                            </div>             
                        </div>

                        <div class="foot-note mvs-10">
                            We can pull the first comment by using the <code>get()</code> method just as below:
                        </div>

                        <div class="pre-area">
                            <pre class="pre-code">
  Comments::of('posts')->read()->Comments->get(0);
                            </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            The data returned will be a format like below:
                        </div>

                        <div class="pre-area">
                            <pre class="pre-code">
  <span class="c-orange-dd">object(stdClass)[25]</span>
    public 'id' => int 1
    public 'user_id' => int 2
    public 'post' => string 'This is a post' (length=14)
    public 'added_on' => string '2023-01-04 18:42:00' (length=19)
    public 'post_id' => int 2
    public 'comment' => string 'This is a comment to a post' (length=27)
                            </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            According to the above structure, we can then access any of the stdClass object by calling the 
                            property just as below:
                        </div>   

                        <div class="pre-area">
                            <pre class="pre-code">
  Comments::of('posts')->read()->Comments->get(0)->comment;  <span class="comment no-select">// This is a comment to a post</span>                      
                            </pre>
                        </div>

                        <div class="foot-note mvs-10">
                            We can also supply our child key as a second argument on the <code>get()</code> method rather than calling it 
                            as a property just as below
                        </div>  

                        <div class="pre-area">
                            <pre class="pre-code">
  Comments::of('posts')->read()->Comments->get(0, 'comment');  <span class="comment no-select">// This is a comment to a post</span>                      
                            </pre>
                        </div>  

                        <div class="foot-note mvs-10">
                            In situations where we need to pull the entire data of an index, we can declare the second parameter as an empty 
                            array container. The container will then be filled with the entire array data. This is shown below: 
                        </div>  

                        <div class="pre-area">
                            <pre class="pre-code">
  Comments::of('posts')->read()->Comments->get(0, []);  <span class="comment no-select">// Get all data in index "0" as an array</span>                      
                            </pre>
                        </div>  

                        <div class="foot-note mvs-10">
                            In situations where we need to get specific fields, we can do this by declaring the specific fields to obtain:
                        </div>  

                        <div class="pre-area">
                            <pre class="pre-code">
  Comments::of('posts')->read()->Comments->get(0, ['comment','user_id','lol']);                     
                            </pre>
                        </div>    

                        <div class="foot-note mvs-10">
                           The above will return a format as below:
                        </div>  

                        <div class="pre-area">
                            <pre class="pre-code">
  array (size=3)
    'id' => int 1
    'comment' => string 'This is a comment to a post' (length=27)
    'lol' => boolean false                    
                            </pre>
                        </div>                        

                        <div class="foot-note mvs-10">
                            In the above, <code>lol</code> does not exist as a property, hence, it is set as false rather than triggering an error.
                        </div>  

                        <div class="foot-note mvs-10">
                            Getting a property from an index that does not exist will trigger an error. However, the data obtained can be optimized 
                            for get method.
                        </div>  
                        

                    </div> <br>

                    <div class="">
                        <div class="">
                            <div class="font-em-1d2 c-orange">Optimizing model data for get() method</div>
                            <div class="">
                                When fetching an index that does not exist in a list of collection data through <code>get()</code>, 
                                this can trigger error. The word "optimize" here means improving the efficiency of obtaining 
                                data from collection object even if an error occurs in sql query and the collection class cannot return 
                                any valid data. The class <code>ModelOptimizer</code> is used to optimize model data in a way that even if an error 
                                occurs in a collection object list, the error can still be silenced in a way that doesn't break the application. 
                                Assuming we have a chained structure as below: 
                                
                                <div class="pre-area shadow">
                                    <pre class="pre-code">
  var_dump( Roles::user() );
                                    </pre>
                                </div>

                                If the code above returns an error as below: 

                                <div class="pre-area shadow">
                                    <pre class="pre-code">
  <span class="c-orange-dd">object(spoova\core\classes\Collectibles)[18]</span>

    public 'user' => 
    
        <span class="c-orange-dd">object(spoova\core\classes\Collection)[16]</span>
        
            private 'data' => 
                array (size=0)
                empty
            private 'datakeys' => 
                array (size=0)
                empty
            private 'iterator' => int 0
            private 'callables' => 
                array (size=0)
                empty
            public 'error' => string 'Sql Error: Unknown column 'user.role_id' in 'on clause''
                                    </pre>
                                </div>

                                <div class="foot-note mvs-10">
                                    In the above, if we try to use the <code>get()</code> method directly to fetch an index, it may trigger an error.
                                    Instead, we can first optimize the object before finally chaining the <code>get()</code> method on it just as below:
                                </div>  

                                <div class="pre-area shadow">
                                    <pre class="pre-code">
  var_dump( Optimize(Roles::user()->user)->get(0, ['firstname','lastname']) );
                                    </pre>
                                </div>
                                
                                <div class="foot-note mvs-10">
                                    The collection data above was optimized before calling the <code>get()</code> method. Since no data index "0"
                                    exists, the optimizer will ensure that the <code>get()</code> method returns a false value by default. In case we  
                                    want to obtain the list of array we supplied (i.e firstname and lastname), we can set the Optimizer mode as false. This 
                                    will ensure that if array is supplied as sub indexes, then each of the array supplied will become an index assigned the <code>false</code> value. 
                                    An example is shown below: 
                                </div>  

                                <div class="pre-area shadow">
                                    <pre class="pre-code">
  var_dump( Optimize(Roles::user()->user, false)->get(0, ['firstname','lastname']) );

  <span class="no-select comment">//Rather than return <span class="c-red">false</span>, the above returns:</span>

  <span class="c-orange-dd">array (size=2)</span>

    'firstname' => boolean false
    'lastname' => boolean false

                                    </pre>
                                </div>   

                            </div>
                        </div>
                    </div> <br>


                    <!-- Fetching sql errors -->

                    <div class="fectching-sql-errors">

                        <div class="font-em-1d2 c-orange">Fetching Sql Errors</div>

                        <div class="calibri">
                            The errors encountered by any relationship is usually being stored in the <code>error</code> property but can be obtained 
                            through the <code>error()</code> method. The "error" method can be placed upon the dynamic collection properties or 
                            directly on the <code>read()</code> method. A sample format is below:
                        </div>
                        <div class="pre-area shadow">
 <pre class="pre-code">
   User::posts()->read()->collection()->error(); <span class="no-select comment">//valid</span>
   
   User::posts()->read()->posts->error(); <span class="no-select comment">//valid</span>

   User::posts()->read()->error(); <span class="no-select comment">//valid</span>
 </pre>
                        </div>  
                        <div class="foot-note mvt-10">
                            Any of the method above is valid to obtain error. If no error occurs, then the <code>error()</code> method will return a false 
                            value.
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