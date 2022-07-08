<?php 

include_once "icore/filebase.php";
//included files and resources
Res::watch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installer</title>
    <?= Res::import(":headers"); ?>
    <style>
        .fset{
            width: 50%; 
        }
    </style>
    
</head>
<body class="font-em-1 c-silver-dd">
    
    <header class="bc-blue-dd c-white font-em-2 pxs-20 relative flex-full pxv-10 midv">
      <div class="mox ico-spin rad-r bd-4 bd-orange pxv-2 wid-fit mxr-10">
        <a href="<?= DomUrl() ?>" class="flex midv pull-left rad-r bd-4 bd-blue">
          <div class="favicon-r px-20 anc-btn-link b-cover ico-spin" style="background-image:url(<?= DomUrl('res/main/images/icons/favicon-2.png')?>)" ></div>
        </a>
      </div> 
      <div class="flex midv fb-7 helvetica nunito ">Spoova</div>
    </header>

    <div class="content">
        <?= _install(DomUrl()) ?>
    </div>

</body>
</html>