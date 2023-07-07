<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?= Rexit::meta('dump') ?>
    <?= Rexit::load('headers') ?>
    <?= Rexit::load('animateCSS') ?>
    <link rel="import" href="component.html">
    <title>Spoova Pack</title>
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
        .ct-1{
            color:847b95;
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
                <div class="animate__animated animate__rubberBand flex-icon mxs-10 mid pxv-10 theme-btn box bd bd-silver rad-r anc-btn-link flow-hide bc-deeper bc-deeper-blue ripple relative">
                        <div class="flex px-80 bc-deeper-blue-dd rad-r">
                            <div class="rad-r px-full bc-deeper-blue-dd b-cover ico-spin" data-src="<?= Rexit::mapp('images/icons/favicon-white-full.png') ?>"></div>
                            <div class="overlay flex mid">
                                <div class="px-30 b-fluid" data-src="<?= Rexit::mapp('images/icons/S.png') ?>"></div>
                            </div>
                        </div>
                </div>
                <div href="<?= Rexit::domurl() ?>" class="in-flex f-col mxr-4">
                    <div class="flex midv fb-9 font-menu font-em-1d2 <?= spoovaLoaded('c-sea-blue','ct-1') ?>">POOVA</div>
                </div>
                <div class="flex mid font-em-d75">
                    <span class="c-orange">PACK</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>