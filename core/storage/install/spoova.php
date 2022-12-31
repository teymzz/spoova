
<!-- database setup -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title>Installer</title>
    <script src="http://localhost/spoova/res/res.js"></script><script>if(typeof res != 'undefined') res.monitor("::watch","http://localhost/spoova/")</script>    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/config.js'></script><script src='http://localhost/spoova/res/main/js/core.js'></script><script src='http://localhost/spoova/res/main/js/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/custom.js'></script><script src='http://localhost/spoova/res/main/js/device.js'></script><script src='http://localhost/spoova/res/main/js/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/js/anime.js'></script><script src='http://localhost/spoova/res/main/js/init.js'></script>    <style>
        .fset{
            width: 50%; 
        }

        .form-field label {
            background-color: rgba(var(--deep-blue));
            color:white;
        }

        .form-field button {
            background-color: rgba(var(--deep-blue));
            color:white;
        }
        .form-field label + input {
            background-color: rgba(var(--deep-blue), var(--bco-7));
            color:white;
        }
    </style>
    
</head>
<body class="font-em-1 c-silver-dd bc-deeper-blue">
    
    <header class="bc-deep-blue-dd c-white font-em-2 pxs-20 relative flex-full pxv-10 midv">
      <div class="box ico-spin rad-r bd-4 bd-orange pxv-2 wid-fit mxr-10">
        <a href="http://localhost/spoova/" class="flex midv pull-left rad-r">
          <div class="favicon-r px-40 anc-btn-link b-cover ico-spin" style="background-image:url(http://localhost/spoova/res/main/images/icons/favicon-white.png)" ></div>
        </a>
      </div> 
      <div class="flex midv fb-7 helvetica nunito relative" style="top:-.1em">SPOOVA</div>
    </header>

    <div class="content">
        <section class="installation-pane pxv-10 in-flex-full" style="flex-wrap: wrap;">

            
        <section class="intro pvs-10 mobi-100 font-em-1d2 c-blue" style="width:55%">
         
            Start installation by setting up your default offline and online environment settings. 
            Ensure you read through each configuration settings. 
            <span class="hide">You can watch <a href="#" ><span class="c-sky-blue">tutorials</span></a> online to get started.</span>
            
        </section>
        
            <div class="box dbset mobi-100" style="width: 50%;">
                <div class="header pvs-10">
                    Database Environment Setup <br>
                    <div class=" c-orange-dd font-em-d85"> 
                    <span class="c-red-dd"> dbconfig path: [ icore\dbconfig.php ] </span> <br>
                    Supply your database information for an existing or new database. Should you like to create a new database if it does not exist, select "create new database".
                    </div>
                </div> 
                <div class="c-red"></div>
                <form method="post" class="form-field in-flex-full f-col">
                    
                    <div role="group" class="in-flex-full bc-deep-blue bd rad-4 pxv-10">
                        <span>
                            <span class="pxv-4 box"><span><input type="checkbox" name="dbcon_same"></span> Use offline settings for all
                        </span>
                        
            <span>
                <span class="pxv-4 box"><span><input type="checkbox" name="newdb"></span> Create new database
            </span>
        
                        <span hidden>
                            <span class="pxv-4 box"><span><input type="checkbox" name="use_dbconfig" checked="checked"></span> install & use setup
                        </span>
                    </div> 
                    
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-server mxr-4"></span> dbname</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbname_off" placeholder="offline" value="" >
                        <input type="text" class="flex-full pxv-10" name="dbname_on" placeholder="online" value="">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-person-check mxr-4"></span> dbuser</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbuser_off" placeholder="offline" value="" >
                        <input type="text" class="flex-full pxv-10" name="dbuser_on" placeholder="online" value="">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbpass</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbpass_off" placeholder="offline" value="" >
                        <input type="text" class="flex-full pxv-10" name="dbpass_on" placeholder="online" value="">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbserver</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbserver_off" placeholder="offline" value=""  >
                        <input type="text" class="flex-full pxv-10" name="dbserver_on" placeholder="online" value="">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-eye mxr-4"></span> dbport</button> 
                        <input type="text" class="flex-full bd-r bd-silver" name="dbport_off" placeholder="offline" value=""  >
                        <input type="text" class="flex-full pxv-10" name="dbport_on" placeholder="online" value="">
                    </div>
                    <div class="i-flex bc-deep-blue bco-7" role="group">
                        <button class="flex-ico" style="min-width:100px;"><span class="bi-plug mxr-4"></span> socket</button> 
                        <input type="text" name="dbsock" class="flex-full pxv-10" placeholder="dbsocket" value=""  >
                    </div>

                    <div class="in-flex-full flex-r bc-white-dd pxv-10">
                        <fielset class="i-flex bc-blue-l bd-f rad-4 c-white font-em-1d2">
                            <button class="flex-btn-full pxs-20 pvs-6 pxv-6 bc-blue-dd c-white rad-r" name="dbconfig">
                                <span class="bi-install"></span> Install
                            </button>
                        </fielset>
                    </div>   

                </form>                
        </div>
              

        </section>    
    </div>

</body>
</html>