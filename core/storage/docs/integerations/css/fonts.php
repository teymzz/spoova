<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Fonts</title>
        <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script>
        <style rel="integerations.template.css.index"> 

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

 </style>
        
    </head>

    <body>

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="padd-20 content-field xs-2s">
                    

    
    <style rel="css.tutorial"> 

     body{
          color: rgb(111, 110, 110);
     }

     .pre-area{
          font: menu;
          font-size: .85em;
          display: inline-block;
          width:100%;
          background-color : rgba(var(--silver));
      }
  
     .pre-area.fix {
         font-size: 1em;
     }
     
     pre.pre-code {
          overflow: auto hidden;
          color: #4f58a0;
          font-size: .95em; 
          margin-bottom:0;
          padding-top:1em;
     }
     
     pre .comment {
          color: #909090;
     }
  
     .lacier.active {
          background-color: #3ecb32;
          color: white;
          box-shadow: 0 0 2px 2px #3ecb32;
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


 

     body {
          color: rgb(111, 110, 110);
          background-color: #f1f1f1;
     }

 </style>
    



    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features/css') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-orange-dd font-em-1d7">FONTS</div>
            Font classes are used to set font sizes and font families. Font sizes are measured based on pixels or relative to the 
            size of the font (i.e em). The fonts measured in pixels are the static fonts while those measured in "em" are the relative fonts.
        </span> <br><br>

        <div class="wid-fit c-olive font-em-1d1">FONT SIZES</div>
        <div class="static-fonts">
            <div class="wid-fit c-olive font-em-1d1 mvt-10">Static Fonts</div>

            <div class="font-em-d85">
                Static fonts' classes range from <code>font-8</code> to <code>font-25</code> although there is also <code>font-0</code> 
                which can set the font of a text with the property and value <code>font: 0/0 a;</code>
            </div>

            <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                <div class="pxv-10 bc-silver-d">Example: font-14</div>
                <div class="bc-white-d pxv-8 text-left font-14" >
                    This text will never change its size based on any device because it uses font size 14 
                </div>
            </div> <br><br>
        </div>

        <div class="em-fonts">
            <div class="wid-fit c-olive font-em-1d1">EM Fonts</div>
            <div class="font-em-d85">
                Since em fonts are meausured using em unit, they have a much better relationship with different  
                devices. The em utility classes run from <code>0</code> and <code>1-6</code>. The font sizes that 
                fall under the category of zero <code>"0"</code> are known as the decimal fonts while others which run from 1 to 6 
                are the digit relative fonts. 
                
                <div class="decimal-only">
                    <div class="pvs-10 fb-6">Decimal Only Fonts</div>
                    Decimal only fonts are em fonts that have only the the decimal unit identifiers without a digit before them (ie <code>-d</code>). 
                    This is because the zero digit is ignored. These fonts run from <code>font-em-d1</code> to <code>font-em-d9</code> 
                    and they have a sub decimal value that uses the  <code>1-2-3-5-7-9</code> pattern. For example a decimal only font <code>font-em-d1</code> can be applied a sub decimal value of <code>7</code> to form 
                    <code>font-em-d17</code>. The illustration below shows the list of decimal fonts and the sub decimals that can be applied on them <br>
                    <br>

                    <div class="bc-white-d pxv-10">
                        Decimals : <code>font-em-d1</code> <code>font-em-d2</code> 
                                   <code>font-em-d3</code> <code>font-em-d4</code>
                                   <code>font-em-d5</code> <code>font-em-d6</code> 
                                   <code>font-em-d7</code> <code>font-em-d8</code>
                                   <code>font-em-d9</code>
                                   <br>
    
                        Subdecimals : <code>1</code><code>2</code><code>3</code>
                                      <code>5</code><code>7</code><code>9</code> 
                                      <br><br>
                        Examples : <code>font-em-d1</code><code>font-em-d17</code><code>font-em-d25</code>
                    </div>
                </div> <br>
                
                <div class="decimal-only">
                    <div class="pvs-10 fb-6">Integer Relative Fonts</div>
                    The integer relative fonts are em fonts that have whole digits assigned to them and they can be assigned decimal values but not subdecimals.
                    These fonts run from <code>1</code> to <code>6</code> 
                    while their decimal value that uses the pattern <code>d1-d2-d3-d5-d7-d9</code>. The illustration above best explains the syntax and examples 
                    of these fonts.
                    <br>
                    <div class="bc-white-d pxv-10">
                        Integer :  <code>font-em-1</code> <code>font-em-2</code> 
                                   <code>font-em-3</code> <code>font-em-4</code>
                                   <code>font-em-5</code> <code>font-em-6</code> <br>

                        Decimals : <code>1</code><code>2</code><code>3</code>
                                   <code>5</code><code>7</code><code>9</code> <br><br>
                        Examples : <code>font-em-1</code><code>font-em-1d5</code><code>font-em-2d7</code>
                    </div>
                </div>
                
                This means that the unit value of any font can be assigned relative 
                to its real font size at the units of <code>0</code> through <code>9</code>. Each of these units employs a decimal pattern 
                of <code>d1-d2-d3-d5-d7-d9</code> except the decimal only fonts. For example, a font <code>font-em-1</code> can use a decimal value of <code>1</code> just by assigning the value <code>d1</code> 
                to it to form <code>font-em-1d1</code> based on the pattern mentioned earlier. Since having a font size <code>font-em-0</code> is non realistic, there is not utility 
                class assigned for <code>font-em-0</code>, however there are categories of decimal only font sizes which can be assigned to any fonts. In this case, the zero <code>"0"</code> 
                is ignored while the decimal part only remains. Font sizes in this category uses a different pattern of flow.

            </div> <br>
        </div>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">FONT WEIGHTS</div>
            <div class="font-em-d85">
                Font weights utility classes ranges from <code>6</code> to <code>9</code> and they can be identified through the <code>fb-</code> identifier. 
                The format below reveals the font types supported <br>

                <code>fb-6</code> - sets font-wieight at 600 <br>
                <code>fb-7</code> - sets font-wieight at 700 <br>
                <code>fb-8</code> - sets font-wieight at 800 <br>
                <code>fb-9</code> - sets font-wieight at 900 <br><br>

                The weight of any font is applied relative to its font size. <br>

                <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                    <div class="pxv-10 bc-silver-d">Example: font weight 600 at 14pixels</div>
                    <div class="bc-white-d pxv-8 font-14 fb-6" >
                        Lorem ipsum dolor sit amet consectetur adipisicing el
                    </div>
                </div> <br><br>
            </div>
        </div>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">FONT FAMILY</div>
            <div class="font-em-d85">
                The font family utility classes that come with the local css font library includes:<br>

                <code>Calibri</code> <code>Verdana</code> <code>Helvetica</code> <br><br>

                <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                    <div class="pxv-10 bc-silver-d">Example: font family verdana</div>
                    <div class="bc-white-d pxv-8 font-14 fb-6 verdana" >
                        Lorem ipsum dolor sit amet consectetur adipisicing el
                    </div>
                </div> <br><br>
            </div>
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

</html>

