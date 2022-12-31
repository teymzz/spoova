



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
<body>

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
               <li> <a href="<?= DomUrl('docs/live-server') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Live Server</a></li>
               <li> <a href="<?= DomUrl('docs/database') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Database</a> </li>
               <li> <a href="<?= DomUrl('docs/resource') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Resource class</a> </li>
               <li> <a href="<?= DomUrl('docs/routings') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Routing System</a> </li>
               <li> <a href="<?= DomUrl('docs/sessions') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Sessions</a> </li>
               <li> <a href="<?= DomUrl('docs/forms') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Forms</a> </li>
               <li> <a href="<?= DomUrl('docs/useraccounts') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Users</a> </li>
               <li> <a href="<?= DomUrl('docs/database/data-model') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling DBModels</a> </li>
               <li> <a href="<?= DomUrl('docs/classes') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Classes</a> </li>
               <li> <a href="<?= DomUrl('docs/functions') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Functions</a> </li>
               <li> <a href="<?= DomUrl('docs/directives') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Directives</a> </li>
               <li> <a href="<?= DomUrl('docs/setters') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Global Setters</a> </li>
               <li> <a href="<?= DomUrl('docs/mails') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Handling Mails</a> </li>
               <li> <a href="<?= DomUrl('docs/cli') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Cli Commands</a> </li>         
               <li> <a href="<?= DomUrl('docs/plugins') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Composer and Plugins</a></li>
               <li> <a href="<?= DomUrl('docs/wmv') ?>" class="<?= inPath('active') ?>" ><span class="ico ico-spin"></span>The <span class="fb-6 pointer" title="Windows Models View">WMV</span> PATTERN</a></li>
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
                        database which are built upon the following function or methods 
                        <br>
                        
                        <div class="font-em-d85">
                            <br> <code>Model::ofUser()</code>
                            <br> <code>Model::of()</code>
                            <br> <code>Model::where()</code>
                            <br> <code>Model::read()</code>
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
                                For example: If a table (users) contains an id (primary key) column, then a table (comments) must have a field 
                                name with <code>user_id</code>. The user_id is then used to pull data from the <code>comments</code> table which belongs
                                to the current user. 
                            </div>

                            <br>

                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Sample - PostModel.php</div>
                        <pre class="pre-code">
  &lt;?php

    namespace spoova\core\class\Models;
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
    use spoova\windows\Models\Posts;

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
                                relationship, the user table (e.g users) is the owner while the Model (e.g Posts) table is being owned.
                            </div> <br>
                        </li>

                        <li class="mxs-2">
                            <div class="c-olive">  <span class="flex midv"><span class="mxr-4">&#9635</span>Of()</span></div>
                            <div class="font-em-d9 mvt-6">
                                The <code>of()</code> method is similar to the <code>ofUser()</code> method. In this method, the table name can be 
                                customized if the relationship is between a model and a different table which is not the user table. The first argument 
                                takes a new database table name while other arguments follows the ForeignId and ForeignKey strutcure respectively. By default, 
                                if the owner table has an "s" for Example "Admins", then a owned table "Posts" must have a "admin_id" field which helps spoova 
                                to naturally connect the two fields. For example
                            </div> <br>
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 2 - Using the Posts table with an admin </div>
                        <pre class="pre-code">
  $adminPosts = Posts::of('admins', 3)->read()->Posts;
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                In the Example above, the Posts table will look for posts where admin_id where admin_id is 3 in the database. 
                            </div> <br>

                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                        <pre class="pre-code">
  $adminPosts = Posts::of('admins', 3, 'user_id')->read()->Posts;
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                The Example above is of a more complex relationship between database tables in which the foreign key is a custom <code>user_id</code> field. 
                                It is assumed that the foreign key supplied in this case belongs to the admin table. This same key (i.e user_id) must exist in the user Posts table. 
                                <!-- In this relationship, both the Posts and Admins table must have a 
                                ForeignKey fieldname of "user_id". Posts will then select only Posts where user_id is 3 and the value(3) can also be found in the Admins "user_id" table. -->
                            </div>
                            <br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                        <pre class="pre-code">
  $adminPosts = Posts::bind('users')->of('admins', 3, 'user_id')->read()->Posts;
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                The Example above is of a more advanced relationship between database tables. In this relationship, both the Posts and Admins table must have a 
                                ForeignKey fieldname of "user_id". Posts will then select only Posts where user_id is 3 and the value(3) can also be found in the Admins "user_id" table. 
                                However, both data is expected to have a parent table "users". Hence, the data from the users table will also be returned. The bind directive allows the 
                                identification that both data belongs to the users table. The relationship can thus be defined as one amongst the GrandParent, Parent and Child (or GrandChild).
                            </div>
                            <br>

                        </li>

                        <li>
                            <div class="c-olive">Where</div>
                            <div class="font-em-d9 mvt-10">
                                This method is only used to select data where a particular condition is met.
                            </div> <br>
                            
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 3 - where</div>
                        <pre class="pre-code">
  Posts::where('id = ?', [1])->read()->Posts;
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                In Example above, the <code>where()</code> will select data where id is 1 while the <code>read()</code> will fetch the relative data from database table "posts".
                                Since our data is accessible through the model name, we can then retrieve our data using the declared Model table name. Also, notice that a binded paramter is 
                                used as a second argument in the <code>where()</code> method. The where condition returns a DBCollectibles class which contain chainable operators which 
                                can be chained upon the <code>where()</code> method. It is important to emphasize that not all methods on the <code>DataCollectibles</code> class can be applied on the 
                                <code>where()</code> method.
                            </div>
                            <br>
                        </li>

                        <li>
                            <div class="c-olive">read()</div>
                            <div class="font-em-d9">
                                This <code>read()</code> method as explained earlier is used to retrieve data from database. It takes two arguments. The first argument (string or array) is the number of selected 
                                columns to return while the second argument (array) defines the limit of data to be returned
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 4 - read</div>
                        <pre class="pre-code">
  Posts::where('id = ?', [1])->read()->Posts; <span class="comment">// fetch posts where id is 1</span>

  Posts::where('id = ?', [1])->read('comments', [2])->Posts; <span class="comment">// fetch 2 comments where id is 1</span>

  Posts::where('id = ?', [2])->read(['firstname', 'lastname'], [10])->Posts; <span class="comment">// fetch firstname and lastname of 10 posts where id is 1</span>
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                The examples above may not be a realistic example, the idea is to explain the application of this method.
                            </div>
                            <br>
                        </li>

                        <li>
                            <div class="c-olive">delete()</div> 
                            <div class="font-em-d9 mvt-6">
                                This <code>delete()</code> method takes a single parameter which is the limit (integer) of data to be deleted. The 
                                parameter can also be a bool of true. Calling this method can be dangerous as all records belonging to the relative database table may get deleted. 
                                Setting argument as true ensures that developer are aware of the changes they 
                                are about to make (i.e deleting all records) before making them. If no argument is supplied, this method will not delete any data.            
                                It is also advised to to keep the live server off if this method will be applied. 
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 5 - delete</div>
    <pre class="pre-code">
  Posts::delete() <span class="comment">//delete all posts</span>
  Posts::where('id = ?', [1])->delete(); <span class="comment">// delete posts where id is 1</span>
    </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                The examples above may not be a realistic example, the idea is to explain the application of this method.
                            </div>
                            <br>
                        </li>

                        <li>
                            <div class="c-olive">update()</div>
                            <div class="font-em-d9 mvt-6">
                                This <code>update()</code> method is used to update a selected record. It takes a single array parameter. Which contains key(field name) and value(new) pairs 
                                . This method cannot be called directly on the model class since a conditon is expected to be met before an update occurs. Hence, it can be chained on the 
                                <code>where()</code> method.
                            </div> <br>
                            
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
                                <div class="pxv-10 bc-silver">Example 6 - update</div>
    <pre class="pre-code">
  Posts::where("id = 1")->update(['firstname' => 'Smith']) <span class="comment">//update where id is 1, set as firstname as smith</span>
    </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                               It is generally advised to turn off live server when performing operations that modifies the database records to prevent auto-execution of queries.
                            </div>
                            <br>
                        </li>
                    
                    </ul>

                    
                    <div class="">

                        <div class="font-em-1d2 c-orange">Database Relationships</div>

                        <div class="">
                        Database relationships have three main structures which are: 
                        <span class="c-blue">one to one</span>,
                        <span class="c-blue">one to many</span> and
                        <span class="c-blue">many to many</span> relationships. Spoova does not provide support for many to many relationship as of the moment. 
                        It only uses some model methods to link and 
                        obtain database information under the first two of the three relationships metioned. When working with relationships, the value dump 
                        <code>vdump()</code> function might serve a good purpose to 
                        understand the type of data returned.
                        <br><br>
                        
                        <!-- one to one -->  
                        <div class="">
                            <div class="font-em-1 fb-6 calibri">One to One Database Relationship (ownsOne)</div>
                            <div class="calibri">
                                In this relationship, a child model class method is placed on its Parent Model. Within the Child Model, the type of relationship is defined. Once the relationship 
                                is defined, then we can call the method. It is important to note that the Child method must be a static method. 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  &lt;?php 

    use spoova\core\classes\Model;

    Posts extends Model {

        static function User(){

            return self::ownsOne(User::class);

        }

        static function tableName() {
            return 'Posts';
        }

    }

    </pre>
    <div class="pxs-10 c-grey i">
        Now, we can access our relationship by calling the static method just as below:
    </div>

    <pre class="pre-code">
  &lt;?php 

    Posts::User()->read()->User;

    </pre>

</div>
<div class="d87">
The above data simulates a structure or format for setting up a one to one relationship between two database tables. 
In the example above, the <code>Posts</code> model will try to find a <code>User</code> table that has a <code>user_id</code> field and then 
returns both data. If the foreignKey and/or the ownerKey does not follow the default format, they can be supplied respectively as the 
second and third parameter. Also, if the tableName is not defined, the Posts model will assume a default by calling its own class name. The user model 
also behaves in a similar manner. <br><br> 

The static method <code>User()</code> called above serves as a query builder. This means that some data model methods can be available 
for use before calling the <code>read()</code> method. Since spoova is a works mainly in silent mode, it tends to suppress its error triggers at most 
operations. Hence, should an error occur, the model structure will store its last encountered error into error property. Spoova also keeps track
of its errors at all levels which means that the <code>Error</code> method will be available on both <code>read()</code> and <code>User</code> depending 
on which of the two is the last stopping point.
</div>
                                
                            </div>
                        </div> <br>
                        
                        <!-- one to many -->  
                        <div class="">
                            <div class="font-em-1 fb-6 calibri">One to Many Database Relationship (ownsMany)</div>
                            <div class="calibri">
                                In a similar manner like "one to one" relationship, a child model class method is placed on its Parent Model. Within the Child Model, the "ownsMany" relationship is defined. Once this 
                                is defined, then we can call the method. <br><br>
                                
<div class="pre-area">
    <pre class="pre-code">
  &lt;?php 

    use spoova\core\classes\Model;

    User extends Model {

        static function posts(){

            return self::ownsMany(Posts::class);

        }

    }

    </pre>
    <div class="pxs-10 c-grey i">
        Now, we can access our relationship by calling the static method just as below:
    </div>

    <pre class="pre-code">
  &lt;?php 

    User::posts()->read()->Posts;

    </pre>

</div>
<div class="d87">
    The above data simulates a structure or format for setting up a one to many database relationship between two database tables.
    The structure reflects that since the <code>User</code> model owns many posts, then spoova assumes that we are trying to read 
    the posts which are more than one. Rather than read the User, we are more or less trying to read Posts. Hence, the "Posts" property should be called instead. 
    If the <code>User</code> is called, this will trigger an error that the property does not exist.
</div>
                                
                            </div>
                        </div> <br>
                        
                        <!-- one to many inverse -->  
                        <div class="">
                            <div class="font-em-1 fb-6 calibri">One to Many Database Relationship (ownedBy) inverse of "ownsMany"</div>
                            <div class="calibri">
                                In a similar manner like "one to Many" relationship, the <code>ownedBy</code> is an inverse of the <code>ownsMany()</code> 
                                method. In this relationship, a Parent model class method is placed on its Child Model. Within the Parent Model, the "ownedBy" specifies that 
                                the current model is owned by its Parent model. Once the relationship is defined, then we can call the method. 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  &lt;?php 

    use spoova\core\classes\Model;

    Posts extends Model {

        static function posts(){

            return self::ownedBy(User::class);

        }

    }
    </pre>
    <div class="pxs-12 c-grey i">
      Now, we can access our relationship by calling the static method just as below:
    </div>

    <pre class="pre-code">
  &lt;?php 

    Posts::user()->read()->Posts;

    </pre>

</div> <br><br>


<div class="font-em-1 calibri">
    All properties obtained in any database relationship are reflections of the database collection class. This means that rather than calling the property itself, data returned can still be accessed using the <code>Collection()</code> method. For example: 
                                
<div class="pre-area">



    <pre class="pre-code">
  &lt;?php 

    Posts::user()->read()->Posts;

    Posts::user()->read()->Collection();

    <span class="c-grey i no-select">Both structures above will return the same data</sp>

    </pre>

</div>

<div class="d87 mvt-6">
   The <code>Collection()</code> method will enable us to harvest the correct relative 
   data collection regadless of the type of property we are trying to obtain. Also,
   the <code>read()</code>  method can be configured to allow selection of specific fields from database 
   which means we don't have to fetch the entire field. It's second argument also set the limit of data we are trying to obtain.
</div> <br>    
                                
<div class="pre-area">

    <pre class="pre-code">
  &lt;?php 

    Posts::user()->read(['firstname'], 2)->Posts;

    <span class="c-grey i no-select">Returns two posts, showing only the firstname of the users that made the two posts.</sp>

    </pre>

</div>

</div>

                            </div>
                        </div>

                       

                        </div> <br>

                    </div>


                                        
                    <div class="">

                        <div class="font-em-1d2 c-orange">Modifying Relationships</div>

                        <div class="calibri">
                            When setting up relationships, there are certain conditions or modification can be applied to data obtained using 
                            predefined methods. These methods are <code>where()</code>, <code>withDefault()</code> and <code>byRecent()</code>. 
                            These methods can only be applied before the <code>read()</code> method is called. Once the data is obtained through the 
                            <code>read()</code> method, then we can apply other methods which are <code>pluck()</code>, <code>protect()</code> and <code>shuffle</code>.
                        </div>
                        <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Setting up "Where" condition</div>
<pre class="pre-code">
 &lt;?php 

   User::posts()->where('Posts.id = ?', [1])->read()->Posts;

   <span class="c-grey i no-select">One to Many Relationship in which "where" directive will apply 
   the condition to fetch only data where the Posts id field is 1</span>

</pre>

                        </div>



                        <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Setting up "withDefault" condition</div>
<pre class="pre-code">
 &lt;?php 

   User::posts()->withDefault(['name' => 'Felix Russel'])->read()->Posts;

   <span class="c-grey i no-select">The <span class="c-brown-ll">"withDefault"</span> condition enables us to set up our data 
   with a default header if such key does not exist in the data obtained. The default data 
   will also be returned should any error occur since the data obtained has 
   a special way of handling its sql errors. This can be useful in 
   situations where errors may have occured if the structure is not properly defined. 
   </span>

</pre>

                        </div>
                        <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Setting up "byRecent" condition</div>
<pre class="pre-code">
 &lt;?php 

   User::posts()->byRecent()->read()->Posts;

   <span class="c-grey i no-select">The "byRecent" condition allows us to select recent data.
   It assumes the id using the relationship type. 
   
   A "one to one" will use the parent id to sort the recent data.
   A "one to many" will use the child id to sort the recent data.
   A "custom field name" can also be supplied as argument which must be in relation to its field ( e.g <span class="c-red">byRecent('Posts.user_id')</span> )  
   </span>

</pre>



                    </div>

                    <div class="pre-area shadow">
                        <div class="pxv-10 bc-silver">Pulling data</div>
<pre class="pre-code">
 &lt;?php 

   User::posts()->read()->Pull(1);

   <span class="c-grey i no-select">The <span class="c-brown-ll">read()</span> data returned is a multidimensional object data. 
   <span class="c-brown-ll">pull()</span> method allows us to pull data out of a list of collections 
   using the defined data access key (or index key). This method does not 
   require the use of <code>Collection()</code> or dynamic property to access the 
   returned data.  
   </span>

</pre>

                    </div>

                    <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Protecting data</div>
<pre class="pre-code">
 &lt;?php 

   User::posts()->read()->protect(['password']);

   <span class="c-grey i no-select">The  <span class="c-brown-ll">protect()</span> method allows us to hide a specific data value.
   Once an access key is protected, the value becomes <span class="c-brown-ll">***Protected***</span>. 
   Data collections can also be protected at a global level. This means 
   that all data returned will automatically hide some specific fields. 
   This can be done by calling the <code class="c-brown-ll">Collection::protect()</code> method. 
   Once the protection is set up, all models will ensure to protect 
   the data keys set on the global scope just as below:
   </span>

   Collection::<span class="c-violet-dd">protect(['password']);</span>

   User::posts()->read()->Collection(); <span class="i comment">//password value protected</span>

</pre>

                        </div>

                </div>
            </div>
        </section>

        

    </div>


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>