<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png" />
        <title>Css Integerations - Images</title>
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

        <span class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Images and Thumbnails</div>
        </span>

    </div> <br>

    <div class="padd-x-4 font-em-d87">

        <span class="">
            The class <code>"image-thumb"</code> can be used to access the thumbnail class properties which are useful when designing images. 
            The image below is an example of thumbnail: <br>

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    An example of image thumbnail 
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri">Study</div>
                    </div>
                </div>
            </div>

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 1</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg"&gt;

        &lt;div class="image-label ov-d5 c-white c-silver calibri" data-anime="slide-up">Study&lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br><br>

            <div class="">
                In the code above, 
                
                <ul class="pxl-20">
                    <li>
                        <code>image-thumb</code> parent class defines the thumbail box. 
                    </li>
                    <li>
                        <code>image</code> direct child class defines the thumbail box. 
                    </li>
                    <li>
                        <code>image-label</code> class defines the image label. 
                    </li>
                    <li>
                        A height of 180 pixels was set on the <code>image</code> element. 
                        This height defines the entire height of the thumbnail's image excluding any external padding
                    </li>
                </ul>

            </div>
        </span>

    </div>
    
    <div class="padd-x-4 font-em-d87">

        <span class="">
            <div class="wid-fit c-olive font-em-1d5">Slide-up Labels</div>
        </span>

        <div class="">
            By adding the attribute <code>data-anime="slide-up"</code> to labels, the label will only be displayed once the class name <code>slide-up</code> 
            is added to it. This can be done using javascript. Howvever, another way to achieve a slide-up without using javascript is to set the class of the 
            image label to "on-hover" just as shown below. 

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 2</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg"&gt;

        &lt;div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up">Study&lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br> <br>      

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    Hover on image to display label
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up">
                            Study
                        </div>
                    </div>
                </div>
            </div> <br>

            When there are large overflowing texts, the <code>data-anime="slide-up-scroll"</code> may be preferred over the normal slide up  as show below.

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 3</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg"&gt;

        &lt;div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">

            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Vitae molestias voluptates nam necessitatibus obcaecati, 
            culpa libero eaque distinctio praesentium cumque provident 
            quis iste omnis laboriosam vero labore voluptatem explicabo consectetur.
            
        &lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br> <br> 

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    Effect of "slide-up-scroll"
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        </div>
                    </div>
                    Non-Overflowing Text
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="http://localhost/spoova/res/assets/images/lach.jpg">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Vitae molestias voluptates nam necessitatibus obcaecati, 
                            culpa libero eaque distinctio praesentium cumque provident 
                            quis iste omnis laboriosam vero labore voluptatem explicabo consectetur.                            
                        </div>
                    </div>
                    Overflowing Text
                </div>
            </div>

        </div>

    </div> <br>
    
    <div class="padd-x-4 font-em-d87">

        <span class="">
            <div class="wid-fit c-olive font-em-1d5">Background Image positioning</div>
        </span>

        <div class="">
            The classes <code>b-cover</code>, <code>b-contain</code> are used to set image background-size 
            property to <code>cover</code> and <code>contain</code> respectively. Each of these classes have a 
            background-repeat set to <code>no-repeat</code>. Other classes under this are listed below: 
            <br>
            <ul class="mvt-10">
                <li><code>b-center</code> -  sets the background image to "center top" position</li>
                <li><code>b-fluid</code> - auto fits background images based on screen size.</li>
                <li><code>b-parallax</code> - gives a parallax effect on images</li>
                <li><code>b-clip</code> - sets background-clip property to "padding-box"</li>
                <li><code>im-fixed</code> - sets background-attachment property to "fixed"</li>
            </ul>
            
            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-center" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-center
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-cover
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-cover
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-contain" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-contain
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-parallax" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-parallax
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-fluid" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-fluid
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover b-clip" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                b-cover b-clip
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d im-fixed" data-src="http://localhost/spoova/res/assets/images/lach.jpg"></div>
                im-fixed
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

