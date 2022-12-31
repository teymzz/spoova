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
            <div class="wid-fit c-olive font-em-1d5">Overflow Items</div>
            Overflowing elements are either handled as <code>auto</code>, <code>hidden</code> or by using <code>scroll</code>. The scroll bar of an  
            overflowing content could be on the x or y axis. The following are list of classes that can be used for handling scroll bars 
            <ul>
                <li>
                    <code>flow-auto</code> - sets an overflow of auto scroll 
                </li>
                <li>
                    <code>flow-hide</code> - sets an overflow of hidden
                </li>
                <li>
                    <code>flow-x</code> - sets overflow of scroll only on x-axis while y-axis is hidden
                </li>
                <li>
                    <code>flow-y</code> - sets overflow of scroll only on y-axis while x-axis is hidden
                </li>
                <li>
                    <code>flow-scroll</code> -  sets an overflow of scroll
                </li>
            </ul>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-auto</div>
                <div class="flow-auto pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-hide</div>
                <div class="flow-hide pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-x</div>
                <div class="flow-x pxv-10 bc-silver no-wrap" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-y</div>
                <div class="flow-y pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
                </div>
            </div> <br>

            It is important to note that <code>flow-x</code> sets the <code>overflow-y</code> property to "hidden" while the <code>flow-y</code> sets the <code>overflow-x</code> to hidden.
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

