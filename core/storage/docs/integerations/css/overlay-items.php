<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Css Integerations</title>
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
            <div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Overlay Items</div>
            The overlay items just as the name implies, are items that stay as an upper layer over other elements. The main feature of these items is that they 
            have the capacity to spread across other elements. This can be used for blurring pages or preventing the click of a button 
            or even as notification boxes. By default, overlay items are not given a positional layer index. This has to be set manually 
            using the <code>z-index</code> property. There are two overlay utility classes available. These are the <code>page-overlay</code> 
            and the <code>overlay</code> class. The <code>page-overlay</code> differs from <code>overlay</code> in that the former has a <code>fixed</code> 
            postion while the latter has an <code>absolute</code> position. Whenever <code>page-overlay</code> class is used on an element, the element's 
            size will spread entirely across the screen or web page but when an <code>overlay</code> is used, it spreads only relative to its container which is 
            of course possible if the parent element has a <code>relative</code> positioning. Since these elements are transparent by nature, they are not visible 
            unless a color is applied on them. Due to the fact that they are mostly used for pop-ups, they are mostly used with other untility classes which sets 
            a slightly transparent background on them. These classes are the <code>ov-l</code> and <code>ov-d</code> classes which sets a white or dark transparent color 
            on the overlay items. The <code>ov-l</code> classes include <code>ov-l1</code>, <code>ov-l2</code>, <code>ov-l5</code> and <code>ov-l7</code> classes while the 
            <code>ov-d</code> classes include <code>ov-d1</code>, <code>ov-d2</code>, <code>ov-d5</code> and <code>ov-d7</code> classes.
            <br><br>
            
            <div class="pre-area">
                <div class="bc-silver">
    
                    <div class="pxv-10 bc-silver-d">Overlay Sample</div>
                    <pre class="pre-code">
  &lt;div class="px-180 c-orange grid-center"&gt;

    &lt;span style="margin-top:-30px"&gt; Hello in the back &lt;/span&gt;

    &lt;div&gt class="overlay ov-d5 grid-center c-white"&gt;
        Hello in the front
    &lt;/div&gt;
    
  &lt;/div&gt;
                    </pre>
                </div>
            </div>

            In the code above, the parent div element was set at a width and height of 180 pixels and the position was set at relative. The child div that has a class of 
            overlay will cover the entire parent div while the <code>ov-d5</code> will set the overlay darkness transparency just as shown below: 
            <br><br>

            <div class="px-180 relative c-orange grid-center">
                <span style="margin-top:-30px">Hello in the back</span>
                <div class="overlay ov-d5 grid-center">
                    Hello in the front
                </div>
            </div>

            <br>
            In the code above, the "Hello in the back" stays at the back of the overlaying element while "Hello in the front" stays in the front.
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

</html>

