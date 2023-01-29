<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png" />
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script>
</head>
<body>

    
  
    <!-- add css -->
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/assets/css/index.css"> 
    <style rel="build.css.inc">  
    .content{
        box-shadow: 0 0 6px 4px #efefef;
        border: solid thin #dedede;
    }
 </style>
    <style rel="build.css.inc">  
  .slided-up{
    height:0 !important;
  }

  @media (min-width: 500px){
    .links{
      height:100vh !important;
    }        
  }

  #ul li a {
    color: #a5afbd;
  }
  #ul li a:hover{
    color: #737b86;
  }
 </style>
    
    <!-- script -->
    <script> 
    

    window.onload = function(){
        
        const hamburger_menu = document.querySelector(".hamburger-menu");
        const container = document.querySelector(".maincover");
        hamburger_menu.addEventListener("click", () => {

            container.classList.toggle("active");
            
            const ul = document.querySelector(".links");
            const slideToggle = elem => {

            let newHeight, height = elem.offsetHeight;

            if(!isMobile(500)){
                elem.classList.remove('slided-up');
            }else{ 
                elem.offsetHeight = elem.scrollHeight
                if(height == 0){
                    elem.classList.remove('slided-up');
                    newHeight = elem.scrollHeight;
                    elem.style.height = `${newHeight}px`;
                } else {
                    elem.classList.add('slided-up');
                    newHeight = 0;
                    elem.style.height = `${newHeight}px`;
                }   
            }
            
            } 
            slideToggle(ul); 
        });        

    }
    
 
</script>

    <section>

        <div class="maincover">          
        
        <div class="spv-nav">
            <div class="menu flex" style="padding-left:1em">
            <h3 class="logo flex-full midv">  
            <div class="in-flex midv mxr-6">
                <div class="flex midv rad-r" style="background-color:rgba(255, 255, 255, 0.27)">
                    <div class="px-40 b-cover ico-spin" data-src="<?= DomUrl('res/main/images/icons/favicon-white.png') ?>"></div>
                </div>
            </div>
            <div class="flex-full">
                <?= ( $site_name ?? 'spoova' )?? "" ?> 
                <span> <?= ( $site_name2 ?? 'frame' )?? "" ?> </span>
            </div>
                <div class="hamburger-menu flex midv">
                <div class="bar"></div>
                </div>
            </h3>
            </div>
        </div>
        
      
        <div class="links">
            <ul id="ul">
            <li>
                <a href="<?= DomUrl('') ?>" style="--i: 0.05s;">Home</a>
            </li>
            <li>
                <a href="<?= DomUrl('docs') ?>" style="--i: 0.1s;">Documentation</a>
            </li>
            <li>
                <a href="<?= DomUrl('docs/installation') ?>" style="--i: 0.15s;">Installation</a>
            </li>
            <li>
                <a href="<?= DomUrl('features') ?>" style="--i: 0.15s;"> <span class="bi-vinyl"></span> Features </a>
            </li>
            <li>
                <a href="<?= DomUrl('about') ?>" style="--i: 0.2s;">About</a>
            </li>
            </ul>
        </div>

        <div class="main-container">
            <div class="main">
            <header data-src="<?= DomUrl('res/assets/images/bkg.jpg') ?>">
                <div class="overlay">
                <div class="inner">
                    <?= ( print_r(\spoova\core\classes\spoova::isConnected()) )?? "" ?>
                    <h2 class="title"> spoova </h2>
                    <p>
                    An environmental friendly, simple and light php framework for fast web development
                    </p>
                    <a href="<?= route('about'); ?>" class="i-btns"><button class="btn">Learn more</button></a>
                </div>
                </div>
            </header>
            </div>

            <div class="shadow one"></div>
            <div class="shadow two"></div>
        </div>

        </div>

    </section>



</body>
</html>