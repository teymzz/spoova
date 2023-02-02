<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Responsive</title>
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


 

     /* body {
          color: rgb(111, 110, 110);
          background-color: #f1f1f1;
     } */

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
 </style>
        
    </head>


    <body class="">

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="box-full i-trans padd-20 content-field bc-white xs-2s">
                    

    
    
    

    <div class="padd-x-4"> <br>
            
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features/css') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

    </div>

    <div class="padd-x-4">


        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Responsive Paddings</div>
            Responsiveness of elements is mostly achieved through paddings. The <code>xs-</code> utilty classes are set up specifically to handle 
            responsiveness based on 5 steps. Once any of the <code>xs-</code> class is applied, there is always a slight modification to content 
            padding within the range of these steps. The five steps are screen sizes with minimum widths <code>500px</code>, <code>800px</code>, <code>950px</code> and <code>1025px</code> 
            respectively. Media queries are set in pixels to prevent modifications that may occur when the font size of the html body is modified which 
            may redefine the response of the content. There are only three utility classes based on these 5 steps which are <code>xs-1</code>, <code>xs-2</code> and 
            <code>xs-3</code> respectively although there is a slight ending utility class built upon the <code>xs-</code> utility classes. 
            and this is achieved by placing an <code>"s"</code> after the aforementioned classes. Hence, we have <code>xs-1s</code>, 
            <code>xs-2s</code> and <code>xs-3s</code> classes. The utility classes are discussed based on their responses on screen sizes. <br>
            <br>
            <style>
                table.calibri tr > th{
                    padding: 10px;
                    min-width: 20px;
                    background-color: rgba(var(--silver));
                    margin: 0;
                }
                table.calibri tr > td{
                    background-color: rgba(var(--silver-d));
                    padding: 4px;
                }

                table.calibri{
                    border-spacing: 10px; 
                    min-width: 60%;
                }
            </style>
            <table class="calibri" style="color:rgba(var(--orange-dd))">
                <tr class="" style="color:rgba(var(--olive))"> <th>Class</th> <th> <500px </th><th>>=500px</th><th>>=800px</th><th>>=950px</th><th>>=1025px</th></tr>
                <tr><th>xs-1</th><td>0% padding</td><td>0% padding</td><td>5% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-2</th><td>0% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-3</th><td>0% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>20% padding</td></tr>
                <tr><th>xs-1s</th><td>2% padding</td><td>0% padding</td><td>5% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-2s</th><td>2% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-3s</th><td>2% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>20% padding</td></tr>
            </table>

            <span class="form-field">
                
                From the above, we can see that for any "xs-" utility class, the minimum padding is set at <code>0%</code> unless the 
                class ends with an <code>"s"</code> which sets the minimum padding at 2% of the current screen size. 
                
            </span>
        </span>

    </div> <br>

    
    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Container Box Items</div>
            The <code>box</code> utilty class has the property of inline-block display type. It is is mostly used to achieve 
            fluid responsive paddings. Box items are naturally built to have responsive feature although they are not the main responsive classes.  
            While the <code>xs-</code> classes may have a swift response, the <code>box</code> classes have a smoother transition 
            that reflect an elasticity when page width is expanded. While <code>box</code> sets an inline-block element, <code>box-full</code> sets an inline-block element 
            at 100% width. The responsive nature is based on the <code>xs-</code> responsive utility classes which is discussed earlier. 
            A box element can be integerated with the responsive class by combining the <code>box</code> class with the <code>xs-</code> class 
            to give a <code>boxs-</code> utilty class in which any of the "screen" steps (i.e 1, 2 or 3) mentioned earlier can be applied on it. 
            For example, an element with a utility class <code>boxs-1</code> will have its display type as inline-block while its responsive feature 
            is maintained. Hence the following box utility classes are allowed 
            <span class="form-field">
                
                <code class="main">boxs-1</code>, <code class="main">boxs-2</code>,
                <code class="main">boxs-3</code>, <code class="main">boxs-1s</code>,
                <code class="main">boxs-2s</code>, <code class="main">boxs-3s</code>. By default, all responsive utility classes <code>boxs-</code> have an 100% width.
    
            </span>
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

