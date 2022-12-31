<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Texts</title>
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
            <div class="wid-fit c-olive font-em-1d5">Text Alignments</div>
            Texts can be aligned to the left, right, center or justified. The following classes can be used for  
            text alignments.
            <br>
            <ul>
                <li><code>text-left</code> - aligns texts to the left</li>
                <li><code>text-right</code> - aligns texts to the right.</li>
                <li><code>text-center</code> - aligns texts to the center</li>
                <li><code>text-justify</code> - justifies text</li>
            </ul>
        </span>

        <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
        <div class="pxv-10 bc-silver-d">Example: text-left</div>
            <div class="bc-white-d pxv-8 text-left" >
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum natus placeat laboriosam nihil delectus adipisci illo, voluptatibus assumenda ipsa minus fugiat aspernatur doloribus non laborum repellat similique libero ducimus expedita.
                Ex, delectus quis placeat illum asperiores, deserunt sint tempore reprehenderit, aspernatur consectetur quaerat non sed! Deserunt minima reprehenderit nisi sequi ex ad provident sed, quod cupiditate, laboriosam porro unde modi.
                Ex, facilis iusto inventore quis assumenda consequatur necessitatibus reiciendis impedit officiis quibusdam, totam eius. Provident nemo suscipit maiores fugit earum dolorem ut esse aut omnis consequuntur ipsum, libero magnam voluptatem.
                Nihil accusantium ipsa doloremque quos consequatur enim sapiente, ab quis eaque ducimus, blanditiis officiis et? Quod, facilis porro vitae perspiciatis molestias natus unde obcaecati excepturi iure, alias iste! Cum, necessitatibus?
                Ut voluptatibus consequuntur minus minima, illum veritatis mollitia iste cum nam. Reprehenderit quisquam maiores minima nesciunt, exercitationem unde. Illo expedita quaerat earum nesciunt esse! Harum pariatur cumque illum provident nemo.
            </div>
        </div> <br><br>

        <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
            <div class="pxv-10 bc-silver-d">Example: text-center</div>
            <div class="bc-white-d pxv-8 text-center" >
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum natus placeat laboriosam nihil delectus adipisci illo, voluptatibus assumenda ipsa minus fugiat aspernatur doloribus non laborum repellat similique libero ducimus expedita.
                Ex, delectus quis placeat illum asperiores, deserunt sint tempore reprehenderit, aspernatur consectetur quaerat non sed! Deserunt minima reprehenderit nisi sequi ex ad provident sed, quod cupiditate, laboriosam porro unde modi.
                Ex, facilis iusto inventore quis assumenda consequatur necessitatibus reiciendis impedit officiis quibusdam, totam eius. Provident nemo suscipit maiores fugit earum dolorem ut esse aut omnis consequuntur ipsum, libero magnam voluptatem.
                Nihil accusantium ipsa doloremque quos consequatur enim sapiente, ab quis eaque ducimus, blanditiis officiis et? Quod, facilis porro vitae perspiciatis molestias natus unde obcaecati excepturi iure, alias iste! Cum, necessitatibus?
                Ut voluptatibus consequuntur minus minima, illum veritatis mollitia iste cum nam. Reprehenderit quisquam maiores minima nesciunt, exercitationem unde. Illo expedita quaerat earum nesciunt esse! Harum pariatur cumque illum provident nemo.
            </div>
        </div> <br><br>

        <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
        <div class="pxv-10 bc-silver-d">Example: text-right</div>
            <div class="bc-white-d pxv-8 text-right" >
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum natus placeat laboriosam nihil delectus adipisci illo, voluptatibus assumenda ipsa minus fugiat aspernatur doloribus non laborum repellat similique libero ducimus expedita.
                Ex, delectus quis placeat illum asperiores, deserunt sint tempore reprehenderit, aspernatur consectetur quaerat non sed! Deserunt minima reprehenderit nisi sequi ex ad provident sed, quod cupiditate, laboriosam porro unde modi.
                Ex, facilis iusto inventore quis assumenda consequatur necessitatibus reiciendis impedit officiis quibusdam, totam eius. Provident nemo suscipit maiores fugit earum dolorem ut esse aut omnis consequuntur ipsum, libero magnam voluptatem.
                Nihil accusantium ipsa doloremque quos consequatur enim sapiente, ab quis eaque ducimus, blanditiis officiis et? Quod, facilis porro vitae perspiciatis molestias natus unde obcaecati excepturi iure, alias iste! Cum, necessitatibus?
                Ut voluptatibus consequuntur minus minima, illum veritatis mollitia iste cum nam. Reprehenderit quisquam maiores minima nesciunt, exercitationem unde. Illo expedita quaerat earum nesciunt esse! Harum pariatur cumque illum provident nemo.
            </div>
        </div> <br><br>

        <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
        <div class="pxv-10 bc-silver-d">Example: text-justify</div>
            <div class="bc-white-d pxv-8 text-justify" >
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum natus placeat laboriosam nihil delectus adipisci illo, voluptatibus assumenda ipsa minus fugiat aspernatur doloribus non laborum repellat similique libero ducimus expedita.
                Ex, delectus quis placeat illum asperiores, deserunt sint tempore reprehenderit, aspernatur consectetur quaerat non sed! Deserunt minima reprehenderit nisi sequi ex ad provident sed, quod cupiditate, laboriosam porro unde modi.
                Ex, facilis iusto inventore quis assumenda consequatur necessitatibus reiciendis impedit officiis quibusdam, totam eius. Provident nemo suscipit maiores fugit earum dolorem ut esse aut omnis consequuntur ipsum, libero magnam voluptatem.
                Nihil accusantium ipsa doloremque quos consequatur enim sapiente, ab quis eaque ducimus, blanditiis officiis et? Quod, facilis porro vitae perspiciatis molestias natus unde obcaecati excepturi iure, alias iste! Cum, necessitatibus?
                Ut voluptatibus consequuntur minus minima, illum veritatis mollitia iste cum nam. Reprehenderit quisquam maiores minima nesciunt, exercitationem unde. Illo expedita quaerat earum nesciunt esse! Harum pariatur cumque illum provident nemo.
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

