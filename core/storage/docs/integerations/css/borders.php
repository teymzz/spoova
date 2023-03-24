<!DOCTYPE html>
<html>

    <head>
        
        <title>Css Integerations - Borders</title>
        <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script>
        
        <script src='http://localhost/spoova/res/main/js/switcher.js'></script>
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
 </style>
        
    </head>


    <body class="">

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="box-full i-trans padd-20 content-field bc-white xs-2s">
                    

    
    
    

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Borders Thickness</div>
            <div class="">
                Borders are mostly denoted with the <code>bd</code> utility classes. While border colors 
                are discussed in <a href="<?= DomUrl('docs/other-features/css/colors') ?>">colors</a>, the color 
                thickness can be applied though digits that run from <code>1</code> to <code>9</code>. This means 
                that for a border to be applied to any element, it must have the property that matches a <code>bd-</code> and 
                ends with a digit (e.g 9). Hence we have a border thickness utility class that run from <code>bd-1</code> to 
                <code>bd-9</code>. The border thickness is defined using pixels as the thickness unit.
            </div><br>

            <div class="wid-fit c-olive font-em-1d5">Borders Radius</div>
            <div class="">
                There are only quite a number of border radius utility classes. A part runs from <code>rad-1</code>  
                to <code>rad-10</code> while the other parts include <code>rad-12</code>, <code>rad-14</code>, <code>rad-16</code> 
                <code>rad-18</code> and <code>rad-20</code>. Each of the digit specifies the amount of radius (in pixels)  
                that is applied on the element. Other custom radius classes are:<br><br>

                <ul class="pxl-14">
                    <li><code>rad-per-50</code> - radius at 50%</li>
                    <li><code>rad-r</code> - apply radius at 100vw </li>
                    <li><code>rad-rl</code> - apply radius on the left side at 100vw</li>
                    <li><code>rad-rr</code> - apply radius on the right side at 100vw</li>
                    <li><code>rad-r-none</code> - remove right radius</li>
                    <li><code>rad-l-none</code> - remove left radius</li>
                    <li><code>rad-t-none</code> - remove top radius</li>
                    <li><code>rad-b-none</code> - remove bottom radius</li>
                    <li><code>rad-lt-none</code> - remove left top radius</li>
                    <li><code>rad-lb-none</code> - remove left bottom radius</li>
                    <li><code>rad-rt-none</code> - remove right top radius</li>
                    <li><code>rad-rb-none</code> - remove right bottom radius</li>
                    <li><code>rad-none</code> - remove all border radius</li>
                    <li><code>rad-f</code> - remove all border radius (strict)</li>
                </ul>

            </div><br>

            <div class="wid-fit c-olive font-em-1d5">Borders Positions</div>
            <div class="">
                Border postions can be defined using custom classes for left, right, top or bottom<br><br>

                <ul class="pxl-14">
                    <li><code>bd-l</code> - border left</li>
                    <li><code>bd-r</code> - border right </li>
                    <li><code>bd-t</code> - border top</li>
                    <li><code>bd-b</code> - border bottom</li>
                    <li><code>bd-v</code> - border top and bottom</li>
                    <li><code>bd-x</code> - border left and right</li>
                    <li><code>bd-none</code> - remove all borders</li>
                    <li><code>bd-r-none</code> - remove right border</li>
                    <li><code>bd-l-none</code> - remove left border</li>
                    <li><code>bd-tp-none</code> - remove top border</li>
                    <li><code>bd-bm-none</code> - remove bottom border</li>
                    <li><code>bd-x-none</code> - remove right and left border</li>
                    <li><code>bd-v-none</code> - remove top and bottom border</li>
                </ul>

            </div><br>


   
        </div>  
        


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
        if(!value) $('body').removeClass('--theme-dark')
    })

 
}
</script>

</html>

