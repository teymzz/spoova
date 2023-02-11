

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
               <li> <a href="<?= DomUrl('docs/directives') ?>" class="<?= inPath('active') ?>"><span class="ico ico-spin"></span>Helper Directives</a> </li>
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

            
 <div class="font-menu pvs-4">   </div>


            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Switcher.js</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                   This plugin (jquery dependent) is used to track selected options, fields, menu lists e.t.c. For example, when a menu option is selected, 
                   it is tracked in a way that if the page is reloaded, the selected option remains. This feature makes it easy to hide fields, 
                   show fields or perform even more advanced operations. In order to use this plugin, certain attributes must be configures
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Switcher attributes</div>
                    Switcher comes with certain attributes that enables elements to be tracked.

    <!-- code begin  -->
                    <div class="pre-area">
    <pre class="pre-code">
  data-switch : <span class="comment no-select">This is usually used to refer to the target element id</span>
  data-class  : <span class="comment no-select">This is class to which the target element belongs</span>
  data-rel    : <span class="comment no-select">This is used to point to another element item.</span>
    </pre>    
    <!-- code ends -->

                    </div>
                     
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Switcher Application</div>
                    In order to apply the <code>"switcher"</code> plugin, we must learn about its application first. The example below is a practical 
                    example of it usage:
                    <div class="field">
                        <div class="example pxv-10 bc-silver-d">Example 1</div>
                        <div class="bc-silver pxv-10 flex-full f-col">
                            <div class="flex-full">
                                <button class="flex-btn bc-orange-dd c-white mxr-10" data-switch="field1" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)">Show Field 1</button>
                                <button class="flex-btn bc-orange-d c-white" data-switch="field2" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)">Show Field 2</button>
                            </div>
                            <div class="field mvt-10 flex">
                                <div id="field1" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
                                    This is field 1
                                </div>
                                <div id="field2" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
                                    This is field 2
                                </div>
                            </div>
                        </div>

                        <div class="font-em-d85 mvt-10">
                            In the above, there is a binding relationship between the buttons and the fields below them such that when one button is clicked, its relative field is displayed while the other field becomes hidden.
                            Also, the clicked button changes its color. The code structure is displayed below:
                        </div><br>

                        <div>

                            <div class="pre-area">
                                <pre class="pre-code pxv-10">
  <span class="c-silver-dd"><?= ( to_lgts('<div class="bc-silver pxv-10 flex-full f-col">') )?? "" ?><span>
    <span class="c-olive-d">
    <?= ( to_lgts('
    <div class="CHILD-1 flex-full">
        <button data-switch="field1" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)" class="flex-btn bc-orange-dd c-white mxr-10">Click to Hide Field</button>
        <button data-switch="field2" data-class="toggle" data-rel="toggler" data-callback="switchColor" onclick="switcher(this)" class="flex-btn bc-orange-d c-white">Click to Show Field</button>
    </div>


    <div class="CHILD-2 field mvt-10 flex">

        <div id="field1" class="bc-white-d shadow flex-full toggle pxv-10 mxr-10" data-rel="toggler">
            This is field 1
        </div>

        <div id="field2" class="bc-white-d shadow flex-full toggle pxv-10" data-rel="toggler">
            This is field 2
        </div>

    </div>') 
    )?? "" ?>

    <?= (
        to_lgts('
    <script>

        function switchColor(elem) {

            $("[data-class]").removeClass("bc-orange-dd").addClass("bc-orange-d")
            $(elem).removeClass("bc-orange-d").addClass("bc-orange-dd")

        }

        $(document).ready(()=>{
            let switchBtn = new Switcher();
            switchBtn.loadSwitcher("toggle");
        })

    </script>        
        ')
    )?? "" ?>
      </span>
      
  <span class="c-silver-dd"><?= ( to_lgts('</div>') )?? "" ?></span>

                                </pre>
                            </div>                        

                        </div>

                        <div class="mvt-10">
                            <div class="font-em-d85">
                                The code above best explain how the <code>switcher</code> relationship is set up. In the div with <code>CHILD-1</code> class above, 
    
                                <ul>
                                    <li>The <code>data-switch</code> of the first button element points to the id attribute of the target element <code>field1</code> found in <code>CHILD-2</code></li>
                                    <li>The <code>data-class="toggle"</code> of the first and second button elements point to the <code>class</code> attributes of the target elements of the same group 
                                    <li>The <code>data-rel</code> attribute is used to connect all fields and buttons in the same group. 
                                </ul>
                                <br> 
                                The <code>"active"</code> value is usually added by the javascript to the <code>class</code> attribute of the switch button. It denotes the currently selected switch 
                                button. Switch buttons can be identified by the attribute <code>"data-switch"</code> which they use to point to the <code>"id"</code> attribute of the element they are expected to control. 
                                In order to set up a proper relationship between two or more switch buttons, the <code>"data-class"</code> attribute of the button must be the same as shown below:
                            </div>
            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes"&gt;&lt;/button&gt;
                </pre>
            </div>
                            <div class="font-em-d85">
                                In the relationship above, the <code>data-class</code> attribute connects the two switch boxes. By default, the first button of the same <code>data-class</code> is usually the primary 
                                button. Once the page loads, primary button will have a class value of 
                                <code>"active"</code> being the first primary element. If the user clicks the second button, this leadership will be passed to the second button such that when the page reloads, the second 
                                button will become the primary element and the <code>"active"</code> class will belong to it rather than the first button. The <code>"active"</code> class can be helpful when designing by simply 
                                using the class selector (i.e <code>.active</code>) to select the currently selected element.

                                <p>
                                    The main purpose of the switcher class is to toggle fields. Hence we can continue to set up our relationship by connecting buttons to fields. Just as below:
                                </p>
                            </div>
            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes"&gt;&lt;/div&gt;  
                </pre>
            </div>                            
                            <div class="font-em-d85">
                                The code above is one that represent a true relationship between buttons and their respective fields. From the above, we can notice that the <code>"data-switch"</code>
                                attribute of first <code>button</code> points to the <code>"id"</code> attribute of the first <code>div</code> element. Regardless of the order, When a switch button "AButton" uses the 
                                <code>"data-switch"</code> attribute to point to the <code>"id"</code> of another element "AField", then the button "AButton" becomes the controller of that element. In order to keep the 
                                relationship connected, the <code>"data-class"</code> value of button "AButton" must match the exist in the class attribute value of "AField". In this way, the buttons and the fields will be 
                                mutually connected. Although, the switch buttons may be connected to each other by <code>data-class</code> attribute and each button may connect to its own field by using both the 
                                <code>id ~ data-id</code> and <code>class ~ data-class</code> connectors, yet the relationship is not yet complete as they all need to have a grouping or referenced relationship. 
                                Elements of the same group needs to be uniquely referenced. This makes it easier for the switcher class to sort them and execute them together as a group. In order to do this, the 
                                <code>data-rel</code> attribute must connect all fields uniquely. This means that the value of the <code>data-rel</code> attribute must be the same for all elements in the same group and the 
                                value cannot be assigned to another group. This is shown below:
                            </div>

            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;  
                </pre>
            </div>                            
                            
                            <div class="font-em-d85">
                               By adding the <code>data-rel</code> attribute to all fields above, the relationship will be complete as the switcher class will be able to map all buttons to their fields. However, this 
                               will trigger an internal feature. Since the primary button if not clicked will be the first button, then the page will hide the second field (or div) and display the first one. However, if the 
                               second button is the primary (or active) button, then the second field will be displayed while the first remains hidden. In any given relationship, the relationship do not necessarily need to be 
                               complete but it has to be true. This means that it is essential that buttons of the same group must be connected even if not with a field. By default, no event will occur unless two activities are performed. 
                               The first activity is that all switch button must have an <code>onlick="switcher(this)"</code> attribute. Secondly, all buttons must be loaded using their <code>data-class</code> value.
                               This means that the code above should rather be written as: 
                            </div>

            <div class="pre-area mvt-6">
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  &lt;div id="box1" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;

  &lt;div id="box2" class="boxes" data-rel="box-group"&gt;&lt;/div&gt;  


  &lt;script&gt;

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

  &lt;/script&gt;
                </pre>
            </div>    
                            <div class="font-em-d85">
                               In the code above, once the <code>onclick</code> event attribute is added to the switch buttons, then the <code>Switcher</code> class is also used to load the <code>data-class</code> attribute. 
                               If there are several different switch buttons of different <code>data-class</code> value, then the values can be supplied as an array into the <code>loadSwitcher()</code> method.
                            </div>
                        </div>
                      
                    </div>
                   
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Handling Callbacks</div>
                   Callbacks can be made on switch buttons. This is done by adding the attribute <code>data-callback</code> and supplying the callback function name. The callback function will 
                   only be executed once the button is active. Since the <code>data-callback</code> function name cannot allow argument, by default switcher ensures that an function name passed 
                   into any <code>data-callback</code> attribute has access to the element itself. Hence, the first argument on any callback function name provides is 
                   always the target element object itself. For example: <br><br> 

            <div class="pre-area mvt-6">
                <div class="pxv-10 bc-silver">Callback: Example using Attributes</div>
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;


  &lt;script&gt;

    function open(element) {

        $(element).addClass('selected');

    }

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

  &lt;/script&gt;
                </pre>
            </div>
                    <div class="font-em-d9 mvt-6">
                        In the code above, the <code>element</code> argument represents the first button called. When the first button is active, then the function <code>"open"</code>
                        will be called and the class <code>selected</code> will be added to it.<br><br> 
                    </div>
                    Another way to initialize callbacks is through javascript, This can be done through 
                    the <code>loadCall()</code> method. However, any element in which the <code>loadCall()</code> function is applied will have the click event <code>executed</code> on it.       
            <div class="pre-area mvt-6">
                <div class="pxv-10 bc-silver">Callback: Example using Scripts</div>
                <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;


  &lt;script&gt;

    function open(element) {

        $(element).addClass('selected');

    }

    let switchBox = new Switcher;
    switchBox.loadSwither('boxes')

    switchBox.loadCall('box1', 'open')

  &lt;/script&gt;
                </pre>
            </div>
                   <div class="font-em-d9 mvt-6">
                       In the code above, the <code>loadCall()</code> method is used to select and track the <code>data-switch="box1"</code> button. A callback function <code>open()</code> is also assigned for when the button 
                       is active. Once the element becomes active, then a class of <code>"selected"</code> will be added to it. <br><br>
                   </div>

                    <div class="silent-update">
                        <div class="font-em-d95 c-orange-dd">Silent update</div>       
                        <div class="font-em-d9">
                            The switcher method uses the onclick event to update sessionStorageItem key and value pairs. However, there may be situations in which the click event is not 
                            nedeed. In order to update the sessionStorage item, the key <code>"data-switch"</code> and the <code>"data-class"</code> must be updated manually using javascript. This 
                            is done through the method <code>silentUpdate()</code> which takes the first argument as the id (or data-switch) value, and the second argument as the class or (data-class) 
                            value. Example is below:
                        </div>

<div class="pre-area shadow shadow-1-strong mvt-6">
    <pre class="pre-code" style="color:var(--olive)">
  &lt;button data-switch="box1" data-class="boxes" data-rel="box-group" onclick="switcher(this)" data-callback="open"&gt;&lt;/button&gt;

  &lt;button data-switch="box2" data-class="boxes" data-rel="box-group" onclick="switcher(this)"&gt;&lt;/button&gt;

  
  &lt;script&gt;

    $(document).ready(function() {

        let switchBox = new Switcher;
        switchBox.silentUpdate('box2', 'boxes')

    })

    switchBox.loadSwither('boxes')

  &lt;/script&gt;
    </pre>
  </div>
                        <div class="font-em-d9 mvt-6">
                            In the code above, once the page is loaded, the <code>silentUpdate</code> will set the primary element as the second button with the attribute <code>data-switch="box2"</code>.   
                        </div>

                    </div><br>
                    
                </div>

            </div>

        </div>
    </section>
</div>
 <script>

    function switchColor(elem) {

        $('[data-class]').removeClass('bc-orange-dd').addClass('bc-orange-d')
        $(elem).removeClass('bc-orange-d').addClass('bc-orange-dd')
 
    }

    $(document).ready(()=>{
        let switchBtn = new Switcher();
        switchBtn.loadSwitcher('toggle');
    })

 </script>

         <div class="blurry page-overlay ov-d5 hide"></div>
    </section>

</body>
</html>