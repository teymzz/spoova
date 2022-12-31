<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Display</title>
        <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script>
        
        <script src='http://localhost/trial/res/main/js/switcher.js'></script>
        <style rel="docs.integerations.template.css.index"> 

.content-field fieldset {
    margin-bottom: .5em;
}

.content-field fieldset input {
    padding: 12px 6px;
}

.content-field {
    /* width: 50vw; */
}

.control-btns {
    min-width: 120px;
}

button.flex-ico {

    color: rgb(75, 73, 73);

}

code.main {
    margin-left: 0;
}

.form-field .i-flex-full input {
    transition: color .4s ease-in-out, box-shadow .4s ease-in-out !important;
}

@media screen and (max-width:1000px) {
    .content-field {
        width: 100%;
    }
}

 </style><style rel="build.css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
          background-color : rgba(var(--white-d));
          background-color: black;
     }

     .tutorial{
          min-height:100vh;
     }

     .pre-area{
          font: menu;
          font-size: .85em;
          display: inline-block;
          width:100%;
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


 

     /* body {
          color: rgb(111, 110, 110);
          background-color: #f1f1f1;
     } */

 </style><style rel="build.css.headers"> 
.--theme-dark > * {
   --white-dd: 11, 10, 28;
   --white:  21, 15, 39;
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

.bc-white-d.--theme-esc{
    --white-d: 21, 24, 51;
    --white-dd: 23, 28, 56;
    --silver-d: var(--white-dd);
    color: rgb(203, 198, 198);
}
 </style>
        
    </head>


    <body class="">

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="box-full padd-20 content-field bc-white xs-2s">
                    

    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
    
    
    

    <style>
        .flow-auto.grid {
            /* margin: 1em; */
            display: grid;
            grid-template-columns:repeat(2, 1fr);
            grid-gap:1em;
        }

        @media (min-width:800px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(3, 1fr);
                grid-gap:1em;
            }
            
        }
        @media (min-width:1000px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(4, 1fr);
                grid-gap:1em;
            }
            
        }
        @media (min-width:1305px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(5, 1fr);
                grid-gap:1em;
            }
            
        }

        .flex-item{
            height: 200px;
        }
    </style>

    <div class="padd-x-4"> <br>         
        
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features/css') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d9 mvt-4">

            <div class="wid-fit c-olive"><h4>Display classes</h4></div>

            Display utilty classes are grouped into 9 classes based on block, grid, flex or 
            table display type. These classes are: <br> <br>

            <code>block</code> - for block elements <br>
            <code>in-block</code> - for inline-block elements <br>
            <code>in-line</code> - for inline elements <br>
            <code>grid</code> - for grid elements <br>
            <code>in-grid</code> - for inline-grid elements <br>
            <code>flex</code> - for flex boxes <br>
            <code>in-flex</code> - for inline-flex boxes <br>
            <code>table</code> - for table elements <br>
            <code>in-table</code> - for inline-table elements <br>

            <div class="mvt-6">
                The <code>grid</code> and <code>flex</code> utility classes are special classes which can be combined with their 
                modifier attributes that determines how a content is displayed. For this reason, they are both discussed below:
            </div>

        </span>
    </div><br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Grid Items</div>
            Grid elements can be identified by their special class name <code>"grid"</code>. The grid items are not entirely handled 
            by the local <code>css</code> library. However, it provides utility class <code>"grid-center"</code> for aligning items 
            to the center. This may prove useful in situations where items are needed to be centralized.
            <br><br>

            <div class="in-flex-full bc-silver-d">
                <div class="px-140 grid-center bc-silver bd-r bd-silver-d">
                    Hello in center
                </div>
<div class="box-full pre-area">
    <div class="pxv-10 bc-silver-d">
        Example of "grid-center"
    </div>
    <pre class="pre-code">
  <?php print to_lgts('
    <div class="px-140 grid-center bc-silver">
        Hello in center
    </div>

    ')
  ?>
    </pre>
</div>
            </div>

        </span>

    </div> <br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Flex Items</div>
            Any element that has the class of <code>"flex"</code> is considered as a flex item while <code>"in-flex"</code> is used to 
            specify an inline-flex item. Flex is mostly used in form alignments.
            Flex items are greatly controlled by combining the name with other utility classes. Classes that can be combined with the <code>flex</code> 
            or <code>in-flex</code> are mostly used for flex alignments. Some of the classes and their features are listed below: <br>
            <span class="form-field">
                
                <code class="main">flex-l</code> - shifts a flex child item to the left<br>
                <code class="main">flex-lt</code> - shifts a flex child item to the left top<br>
                <code class="main">flex-lb</code> - shifts a flex child item to the left bottom<br>

                <code class="main">flex-r</code> - shifts a flex child item to the right<br>
                <code class="main">flex-rt</code> - shifts a flex child item to the right top<br>
                <code class="main">flex-rb</code> - shifts a flex child item to the right bottom<br>

                <code class="main">flex-col / f-col</code> - sets flex direction to column<br>
                <code class="main">flex-row / f-row</code> - set flex direction to row<br>
                <code class="main">flex-col-m</code> - sets flex direction to row on smaller screen size<br>
                <code class="main">flex-row-m</code> - sets flex direction to column on smaller screen size <br>

                <code class="main">mid</code> - centralizes the position of child items to the middle (vertically and horizontally) of the parent flex item <br>
                <code class="main">midl</code> - centralizes the position of child items vertically to the middle left of the parent flex item  <br>
                <code class="main">midr</code> -  centralizes the position of child items vertically to the middle right of the parent flex item   <br>
                <code class="main">midv</code> -  centralizes the position of child items vertically <br>
                <code class="main">midh</code> -  centralizes the position of child items horizontally <br>
               
                <code class="main">just-left</code> - justifies flex items to start <br>
                <code class="main">just-right</code> - justifies flex items to end  <br>
                <code class="main">just-center</code> -  justifies flex contents to center <br>
                <code class="main">flex-start</code> -  justifies flex contents to flex-start   <br>
                <code class="main">flex-end</code> -  justifies flex contents to flex-end <br>
                <code class="main">flex-center</code> -  justifies and aligns flex contents to center <br>
                <code class="main">space-between</code> -  justifies contents using space-between <br>
                <code class="main">space-around</code> -  justifies contents using space-around <br>
                <code class="main">space-even</code> -  justifies contents using space-evenly <br>
                <br>
                There is however a twist when it comes to setting flex items to 100 percent width. While 
                <code>flex-full</code> is applied specially for items with flex property, <code>in-flex-full</code> is applied for items with inline-flex display property.
                The images below reveals the effect of flex boxes when other utility classes are applied with it. <br><br>
            </span>

            <div class="flow-auto grid">

                <div class="box shadow-1-strong">
                    <div class="flex flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex <span class="c-silver-dd">f-row</span>
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex f-col flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex f-col
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex mid flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex mid
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midh flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midh
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midv flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midv
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midl flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midl
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midr flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midr
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-l flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-l
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-r flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-r
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-c flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-c
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-left flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-left
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-right flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-right
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-start flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-start
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-end flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-end
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-between flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-between
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-around flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-around
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-even flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-even
                </div>




            </div>
        </span>

    </div> <br>



                </div> <br>
            </div>
        </div>

    </body>

    
    <script>
        formValidator();

        function htmlentities(str) {
            return String(str).replace(/&/g, '&amp;');
        }
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

</html>

