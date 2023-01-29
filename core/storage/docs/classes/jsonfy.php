

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
    
        <section class="pxv-20 tutorial mails bc-white">
            <div class="font-em-1d2">

                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/jsonfy">Jsonfy</a>  </div>


                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Jsonfy</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            <code>Jsonfy</code> class is a tool that is used to handle a two 
                            level dimensionsional json string. It may convert a json string to 
                            an array, convert a two-dimensional array to json, modify an existing json 
                            string, fetch or remove data from a json string. The methods available are as follows: 

                        </div> <br> <br>

                            <ol>
                            <li> <a href="#newdata"> newData </a> </li>
                            <li> <a href="#datakey"> datakey </a> </li>
                            <li> <a href="#add"> add </a> </li>
                            <li> <a href="#update"> update </a> </li>
                            <li> <a href="#delete"> delete </a> </li>
                            <li> <a href="#read"> read </a> </li>
                            <li> <a href="#data"> data </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> Initializing class
                                </div>
                            </div> <br>

                            <div class="">
                                The jsonfy tool can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
                                        <pre class="pre-code">
    $jsonfy  = new Jsonfy;
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br><br>
                    </div>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> keywords
                                </div>
                            </div> <br>
                            <div class="">
                            The following keywords should be noted:
                            <br><br>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>keywords</code></div>
                                <pre class="pre-code">
    <span class="comment">
    $data : json string or array data

    $array : sample array used - ['name' => 'foo', 'class' => 'bar'];

    $json  : sample json used - {"name": "foo", "class": "bar"};

    data   : uses json string or array data 

    payload   : a data array having predefined keysets <code>iss</code> <code>nbf</code> and <code>exp</code> expected to be hashed

    token     : currently or previously generated token

    $token    : previously generated token
    </span>
                                </pre>
                            </div>
                        </div>

                            </div>
                        </div> <br><br>
                    </div>        

                    <div id="newdata" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> newData
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>newData</code> method is used to set a new json string or array data
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: newData</code></div>
                                        <pre class="pre-code">
    $jsonfy->newData(data); 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        We shall be looking at a series of examples below.
                        <br><br>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setting files</code></div>
                                <pre class="pre-code">

    $jsonfy->newData($json); <span class="comment">// check <a href="#keywords">keywords</a> for $json</span>

    $jsonfy->newData($array); <span class="comment">// check <a href="#keywords">keywords</a> for $array</span>

                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="add" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> add
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>add()</code> method is used to add a key and its value into 
                                a json or array data. It involves a series of formats. We shall be looking at 
                                few examples:
                                <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: add</code></div>
                                        <pre class="pre-code">
    $jsonfy->add(null); 
    $jsonfy->add(name); 


    $jsonfy->add(null, null); 
    $jsonfy->add(null, value); 
    $jsonfy->add(name, value);


    $jsonfy->add(null, null, null); 
    $jsonfy->add(name, key, value); 
    $jsonfy->add(null, key, value); 
    $jsonfy->add(name, null, value); 
    <span class="comment no-select">
    where: 

        name  : name of a given index of an associative array 
        value : value of a given index of an associative or 2-level multidimentional array 
        key   : subkey of a 2-level multidimentional array
        null  : numbered index (e.g 0, 1, 2 ...)

    Note: This may look comprehensive but a series of examples will provide guidance 
    </span>
                                        </pre>
                                    </div>
                                </div> 

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: add</code></div>
                                        <pre class="pre-code">
    <span class="comment">Note:: case lines below are assumed to be the first list</span>

    <span class="comment">//case 1 - one argument</span>
    $jsonfy->add('');                 <span class="comment">//['0'=>'']</span>
    $jsonfy->add('foo');              <span class="comment">//['foo'=>'']</span>

    <span class="comment">//case 2 - two arguments</span>
    $jsonfy->add('', '');             <span class="comment">//['0'=>'']</span>
    $jsonfy->add('', 'bar');          <span class="comment">//['0'=>'bar']</span>
    $jsonfy->add('foo', 'bar');       <span class="comment">//['foo'=>'bar']</span>

    <span class="comment">//case 3 - three arguments</span>
    $jsonfy->add('', '', '');         <span class="comment">//['0'=>['0'=>'']]</span>
    $jsonfy->add('foo', 'bar', 'me'); <span class="comment">//['foo'=>['bar'=>'me']]</span>
    $jsonfy->add('', 'bar', 'me');    <span class="comment">//['0'=>['bar'=>'me']]</span>
    $jsonfy->add('', 'me', '');       <span class="comment">//['0'=>['me'=>'']]</span>
    $jsonfy->add('', '', 'me');       <span class="comment">//['0'=>['0'=>'me']]</span>
                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>

                        <div class="font-menu">
                            In the above, all null (i.e '') data resolves to <code>numbers</code> except in few 
                            occassions. Kindly note the following<br>
                            <ol>
                                <li>
                                    When one argument is supplied, it becomes the index key. If the argument 
                                    is null, then <code>numbers</code> are used starting from 0. 
                                </li>
                                <li>
                                    When two null arguments are supplied without a third, the first argument 
                                    resolves to numbered index while the second resolves to empty value 
                                </li>
                                <li>
                                    When two null arguments are supplied with a third, the first two arguments 
                                    resolves to numbered index while the third resolves to value 
                                </li>
                                <li>
                                    When numbers are used, the <code>jsonfy</code> class increases index numbers. This 
                                    means that if <code>add('')</code> is used twice, the first will have the index of zero 
                                    <code>0</code> while the the second will assume an index of one <code>1</code>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div id="datakey" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> datakey
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>datakey()</code> method returns the first key of a specified value for 
                                an associative array.
                                <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: datakey</code></div>
                                        <pre class="pre-code">
    $jsonfy->datakey(key); 

    <span class="comment no-select">
    where: 

        key : name of a given index of an associative array
    </span>
                                        </pre>
                                    </div>
                                </div>          
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: datakey</code></div>
                                        <pre class="pre-code">
    <span class="comment">Note:: very line below is assumed to be the first list</span>

    $jsonfy->newData(['user'=> 'foo', 'class' => 'bar']);

    var_dump( $jsonfy->datakey('foo') ); <span class="comment">// user</span>
    var_dump( $jsonfy->datakey('bar') ); <span class="comment">// class</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="update" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> update
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>update()</code> method works similarly as the <code>add()</code> method, taking the 
                                same count of parameters needed for a corresponding update
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: update</code></div>
                                        <pre class="pre-code">
    <span class="comment">//example 1</span>
    $jsonfy->add('name', 'foo');     <span class="comment">//['name'=>'foo']</span>
    $jsonfy->update('name', 'voo');  <span class="comment">//['name'=>'voo']</span>

    <span class="comment">//example 2</span>
    $jsonfy->add('', 'foo');             <span class="comment">//['0'=>'foo']</span>
    $jsonfy->update($jsonfy->datakey('foo'), 'bar');          <span class="comment">//['0'=>'bar']</span>

    <span class="comment">//example 3</span>
    $jsonfy->add('user','foo','bar');         <span class="comment">//['user'=>['foo'=>'bar']]</span>
    $jsonfy->update('user', 'foo', 'me'); <span class="comment">//['user'=>['foo'=>'me']]</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>


                    <div id="delete" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> delete
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>delete()</code> method deletes a value from existing jsonfy data
                                It removes either the main key of a 2-level multidimentional array or the subkey 
                                of a multidimentional array.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: delete</code></div>
                                        <pre class="pre-code">
    <span class="comment">//test data</span>
    $jsonfy->add('user','foo','bar');         <span class="comment">//['user'=>['foo'=>'bar']]</span>
    
    <span class="comment">//example 1</span>
    $jsonfy->delete('user', 'foo');     <span class="comment">//['user'=>'']</span>

    <span class="comment">//example 2</span>
    $jsonfy->delete('user');     <span class="comment">//[]</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="read" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> read
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>read</code> method reads data from a supplied jsonfy data.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: expires</code></div>
                                        <pre class="pre-code">
    $jsonfy->read(key); 
        <span class="comment">
            where:
            
            key: main array index key.
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: read</code></div>
                                        <pre class="pre-code">
    <span class="comment">//example 1</span>
    $jsonfy->add('user','foo','bar'); <span class="comment">//['user'=>['foo'=>'bar']]</span>
    var_dump( $jsonfy->read('user') );            <span class="comment">//['foo'=>'bar']</span>


    <span class="comment">//example 2</span>
    $jsonfy->add('user','foo'); <span class="comment">//['user'=>'foo']</span>
    var_dump( $jsonfy->read('user') );      <span class="comment">//foo</span>

    <span class="comment">Note: when an index key does not exist, it returns a boolean of false</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="data" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> data
                                </div>
                            </div> <br>

                            <div class="">
                                This <code>data</code> method returns the entire stored data. This can be in 
                                form of array or json string.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: data</code></div>
                                        <pre class="pre-code">
    $jsonfy->data(type); 

    <span class="comment">
        where: 
        
            type - options [null|json|source|count] 

                    null - returns array of data stored 
                    json - returns json string of data stored 
                    count - returns the total count of data 
                    source - returns the source data supplied from newData method 
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: returning a data</code></div>
                                        <pre class="pre-code">
    $jsonfy->newData(['foo' => 'bar']); 

    var_dump($jsonfy->data('source')); <span class="comment">// ['foo' => 'bar']</span>

    var_dump($jsonfy->data()); <span class="comment">// ['foo' => 'bar']</span>

    var_dump($jsonfy->data('json')); <span class="comment">// {"foo": "bar"}</span>

    var_dump($jsonfy->data('count')); <span class="comment">// 1</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                
 <div class="font-menu pvs-4"> <a href="http://localhost/spoova/docs">Docs</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes">Classes</a> <span class="bi-chevron-right"></span> <a href="http://localhost/spoova/docs/classes/jsonfy">Jsonfy</a>  </div>


                </div>
            </div>
        </section>
    </div>
            
    


         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>