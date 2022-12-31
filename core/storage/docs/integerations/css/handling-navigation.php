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

    </div>

    <div class="padd-x-4 font-em-d87">

        <span class="">
            
            
            <span class="">
                <div class="wid-fit c-olive font-em-1d5">Menu Burger</div>
                An animated menu bar can be created using the <code>data-navi="menu-burger"</code> attribute.
                There are currently 3 different menu-burger designs which are the <code>balance</code>, 
                <code>equal</code> and <code>dots</code>. The following are the different types: <br>
            </span> <br>

            <!-- Balance -->
            <div class="relative bc-silver shadow">
                <div class="pxv-10 bc-sea-blue c-white">Balance </div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="balance c-sea-blue" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="balance c-sea-blue" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
        </div>
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br>

            <!-- Equal -->
            <div class="relative bc-silver shadow">
                <div class="pxv-10 bc-sea-blue c-white">Equal </div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="equal c-sea-blue" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="equal c-sea-blue" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
        </div>
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br>

            <!-- Dots -->
            <div class="relative bc-silver shadow">
                <div class="pxv-10 bc-sea-blue c-white">Dots </div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="dots c-sea-blue" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="dots c-sea-blue" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
        </div> 
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br>

            <div class="">
                The image below is a representaion of what happens when the <code>"open"</code> class is applied on the menu burger. 
                regardless of the menu burger type. 
            </div>

            <br><br>

            <!-- Dots -->
            <div class="relative bc-silver shadow">
                <div class="pxv-10 bc-sea-blue c-white">Dots (class of "open" was added on the menu-burger parent)</div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="dots open c-sea-blue" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="dots open c-sea-blue" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
        </div>                 
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br> 

            <div class="">
                The switch menu-burger can also contain items within its internal space. This can be achieved by adding an element 
                with a <code>menu-box</code> class within the menu burger. The element will only be visible when the menu box has 
                a class of open just as shown below:
            </div>           

            <!-- Equal -->
            <div class="relative bc-silver shadow mvt-10">
                <div class="pxv-10 bc-sea-blue c-white">Dots (class of "open" was added on the menu-burger parent)</div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="equal open c-sea-blue" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                            <div class="menu-box pxs-4 bd-1">
                                <span>Item 1</span><br>
                                <span>Item 2</span><br>
                                <span>Item 3</span><br>
                            </div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="equal open c-sea-blue" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
            <div class="menu-box pxs-4 bd-1">
                <span>Item 1</span><br>
                <span>Item 2</span><br>
                <span>Item 3</span><br>
            </div>
        </div>                 
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br>

            <div class="">
                The postion of the menu box above can be redefined by using the class selector 
                <code>[data-navi="menu-burger"] .menu-box</code>. A toggle effect is shown below:
            </div>            <br>

            <!-- Equal -->
            <div class="relative bc-silver shadow mvt-10">
                <div class="pxv-10 bc-sea-blue c-white">Click on the switch to toggle the switch</div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white">
                        <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                            <div class="menu-box pxs-4 bd-1">
                                <span>Item 1</span><br>
                                <span>Item 2</span><br>
                                <span>Item 3</span><br>
                            </div>
                        </div>
                    </div>
                    <div class="bc-silver">
    <div class="pre-area">
        <pre class="pre-code"><?= (
                to_lgts('
        <div class="equal open c-sea-blue toggled relative" data-navi="menu-burger">
            <div class="bar-top bar-small"></div>
            <div class="bar-mid"></div>
            <div class="bar-btm bar-small"></div>
            <div class="menu-box pxs-4 bd-1">
                <span>Item 1</span><br>
                <span>Item 2</span><br>
                <span>Item 3</span><br>
            </div>
        </div>

        &lt;script&gt;
            $(\'.toggled[data-navi="menu-burger"]\').click(function(){

                $(this).toggleAttr("open")

            }))
        &lt;/script&gt;                
                ')

            )?? "" ?>
        </pre>
    </div>
                    </div>                 

                </div>

            </div> <br>

            <div class="">
                Without defining the position of the menu-box, the menu box item may seem to scale in rather than slide in. 
                The <code>menu-box</code> can be postioned to slide down from left to right <code>tl-r</code> or from right to left 
                <code>tr-l</code>. These is done by applying utility classes <code>tr-l</code> or <code>tl-r</code> to the <code>menu-box</code> 
                element itself. Example is shown below: <br>
            </div>


            <!-- Equal -->
            <div class="relative bc-silver shadow mvt-10">
                <div class="pxv-10 bc-sea-blue c-white">Menu Box Effect</div>
                
                <div class="flex">

                    <div class="pxv-10 bc-white mxr-4">
                        <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                            <div class="menu-box pxs-4 bd-1">
                                <span>Item 1</span><br>
                                <span>Item 2</span><br>
                                <span>Item 3</span><br>
                            </div>
                        </div>
                        <div class="pvt-10">"menu-box"</div>
                    </div>               

                    <div class="pxv-10 bc-white mxr-4">
                        <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                            <div class="menu-box tr-l pxs-4 bd-1">
                                <span>Item 1</span><br>
                                <span>Item 2</span><br>
                                <span>Item 3</span><br>
                            </div>
                        </div>
                        <div class="pvt-10">"menu-box tr-l"</div>
                    </div>               

                    <div class="pxv-10 bc-white">
                        <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                            <div class="bar-top bar-small"></div>
                            <div class="bar-mid"></div>
                            <div class="bar-btm bar-small"></div>
                            <div class="menu-box tl-r pxs-4 bd-1">
                                <span>Item 1</span><br>
                                <span>Item 2</span><br>
                                <span>Item 3</span><br>
                            </div>
                        </div>
                        <div class="pvt-10">"menu-box tl-r"</div>
                    </div>               

                </div>

                
            </div> <br>
            
            <div class="">Yeah! Just a bit of css will help align our menu box properly</div>

            <div class="">
                <style>

                    .customized [data-navi="menu-burger"] .menu-box.tr-l{

                        right: 1.5em;

                    }

                    .customized [data-navi="menu-burger"] .menu-box.tl-r{

                        left: 1.5em;

                    }
                    
                </style>

                <div class="relative bc-silver shadow mvt-10 customized">
                    <div class="pxv-10 bc-sea-blue c-white">Menu Box Effect</div>
                    
                    <div class="flex">
           

                        <div class="pxv-10 bc-white mxr-4">
                            <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                                <div class="bar-top bar-small"></div>
                                <div class="bar-mid"></div>
                                <div class="bar-btm bar-small"></div>
                                <div class="menu-box tr-l pxs-4 bd-1">
                                    <span>Item 1</span><br>
                                    <span>Item 2</span><br>
                                    <span>Item 3</span><br>
                                </div>
                            </div>
                            <div class="pvt-10">"menu-box tr-l"</div>
                        </div>               

                        <div class="pxv-10 bc-white">
                            <div class="equal c-sea-blue toggled relative" data-navi="menu-burger">
                                <div class="bar-top bar-small"></div>
                                <div class="bar-mid"></div>
                                <div class="bar-btm bar-small"></div>
                                <div class="menu-box tl-r pxs-4 bd-1">
                                    <span>Item 1</span><br>
                                    <span>Item 2</span><br>
                                    <span>Item 3</span><br>
                                </div>
                            </div>
                            <div class="pvt-10">"menu-box tl-r"</div>
                        </div>               

                    </div>

                    
                </div> <br>

                <div class="">
                    The style below was applied to the first and second menu switches above<br>
<div class="pre-code">
    <pre class="pre-area c-sea-blue">
    <?= (

        to_lgts('
        
        <style>

            .customized [data-navi="menu-burger"] .menu-box.tr-l{

                right: 1.5em;

            }

            .customized [data-navi="menu-burger"] .menu-box.tl-r{

                left: 1.5em;

            }

        </style>

        ')

    )?? "" ?>        
    </pre>
</div>


                </div>  
                
                
            </div>


        </span>

    </div>

    
    <script>
        $('.toggled[data-navi="menu-burger"]').click(function(){
            $(this).toggleClass('open')
        }) 
    </script>


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

