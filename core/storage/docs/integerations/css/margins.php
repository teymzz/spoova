<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Images</title>
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

        <span class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Setting margins</div>
        </span>

    </div> <br>

    <div class="padd-x-4 font-em-d87">

        <span class="">
            Margins are defined using special fixed patterns which can be for negative or positive margins. The margins are set based on 
            pixels. The horizontal margins are denoted with the <code>mx</code> class while the vertical margins are denoted with <code>mv</code> 
            class. In situations where both horizontal and vertical margins are expected to be applied at equal margin, the <code>mxv</code> class 
            is employed. Negative margins uses the <code>n</code> identifier. Hence, a negative margin of 10 pixels on an horizontal axis will be denoted 
            as <code>mxn-10</code>. Margins can also be applied for left or right sides on either the horizontal axis and top or bottom sides or vertical axis. 
            The margin applied on contents uses the <code>1</code>, <code>2</code>, <code>3</code>, <code>4</code>, <code>5</code> <code>6</code>,
            <code>8</code>, <code>10</code>, <code>12</code>, <code>14</code>, <code>15</code>, <code>16</code>, <code>18</code> and <code>20</code>
            unit identifiers. Each of these digits reflects the margin distance given on any side defined. The list below are the list of margin purpose identifiers. 
            <br><br>

            <ul class="pxl-14">
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxs-</code> </span> <span> - applies margin on both sides on the horizontal axi</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-</code> </span> <span> - applies margin on the left side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-</code> </span> <span> - applies margin on the right size on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-n</code></span> <span>  - applies negative margin on the left side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-n</code></span> <span>  - applies negative margin on the right side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvs-</code> </span> <span> - applies margin on both sides on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-</code> </span> <span> - applies top margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-</code> </span> <span> - applies bottom margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-n</code></span> <span>  - applies negative top margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-n</code></span> <span>  - applies negative bottom margin on the vertical axis</span></li>
            </ul>
            
            <div class="">
                The example below reveals how to apply a margin of 2 pixels on any of the margin identifiers above: <br><br>
    
                <ul class="pxl-14">
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxs-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on both sides on the horizontal axi</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on the left side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on the right size on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-n2</code></span> <span>  - applies negative margin of <b class="c-teal">2 pixels</b> on the left side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-n2</code></span> <span>  - applies negative margin of <b class="c-teal">2 pixels</b> on the right side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvs-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on both sides on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-2</code> </span> <span> - applies top margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-2</code> </span> <span> - applies bottom margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-n2</code></span> <span>  - applies negative top margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-n2</code></span> <span>  - applies negative bottom margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                </ul>

            </div>

            <div class="bc-silver rad-4 shadow rad-2 flow-hide">
               <div class="box pxv-10 bc-orange-d c-white">Note:</div> 
               <span class="pxs-2">Although, these margins may be fixed, other margins can be applied from the bootstrap library.</span>
            </div>

        </span>

    </div>


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

