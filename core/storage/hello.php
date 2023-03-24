<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script>
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/assets/css/animate.min.css">
        <link rel="import" href="component.html">
    <title><?= ( $title ?? 'Hello!')?? "" ?></title>
    
    <style> 
        :root {
            --em-2 : 2em;
        }           
        body{
            font-size: 10px;
            transition: font .2s;
        }
        .overlay{
            z-index: 1; 
            color:#202dd5; 
            color:white; 
        }
        .px-80 {
            width: var(--em-2);
            height: var(--em-2);
        }
        @media (min-width:1000px) {
            body{
                font-size: initial;
            }
        }
    </style>
</head>
<body>
    <div class="centre vhm-full bc-deeper-blue-dd fb-6 font-em-3 c-white">
        
        <div class="in-flex pxv-10 no-select">
           <div class="in-flex midv">
                <div class="">
                    <span class="c-orange">Hello!</span> 
                    <span class="<?= ( spoovaLoaded('c-sea-blue','c-blue') )?? "" ?>">From</span> 
                </div>
                <div class="animate__animated animate__rubberBand flex-icon mxs-10 mid pxv-10 theme-btn box bd bd-silver rad-r anc-btn-link flow-hide bc-deeper bc-deeper-blue ripple relative">
                        <div class="flex px-80 bc-deeper-blue-dd rad-r">
                            <div class="rad-r px-full bc-deeper-blue-dd b-cover ico-spin" data-src="http://localhost/spoova/res/main/images/icons/favicon-white-full.png"></div>
                            <div class="font-em-1d2 flex mid px-full center overlay fb-9 nunito fb-9">
                                   <span class="relative" style="top:-.12em">S</span>
                            </div>
                        </div>
                </div>
                <div href="<?= DomUrl('') ?>" class="in-flex">
                    <div class="flex midv fb-9 font-menu font-em-1d2 <?= ( spoovaLoaded('c-sea-blue','c-blue') )?? "" ?>">POOVA</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>