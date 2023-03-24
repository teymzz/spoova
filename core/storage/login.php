
  
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
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
        <!-- @live() -->
        
        <!-- script -->
        <!-- @script('build.js.inc:index') -->


        <section>

            <div class="maincover centre">      

                <form method="post" class="form-field" style="width: 350px">
                    <input type="hidden" value="M6yJmkORoCecp5kBN238" name="CSRF_TOKEN">
                    <div class="fm-d5 sp-1 wid-full">
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" <?= onShow('error',':csrf','title')?> > <?= error(':csrf','title') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= onShow('error',':mod')?>> <?= error(':mod') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= onShow('error',':dbi')?>> <?= error(':dbi') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= onShow('error','user')?>> <?= error('user') ?> </span>
                                <span class="c-orange box-full pvs-8"><?= ( Res::Flash('mod', 'no errors') )?? "" ?> Hey</span>
                            </div>
                            <div class="i-flex-full-in rad-4">
                                <input type="text" class="flex-full pxv-4" name="user" placeholder="username" value="<?= reqValue('$_POST', ['user']) ?>">
                            </div>
                        </div>
                        
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" <?= onShow('error','pass')?>> <?= error('pass') ?> </span>
                            </div>
                            <div class="i-flex-full-in rad-4">
                                <input type="text" class="flex-full pxv-4" name="pass" placeholder="password" value="<?= reqValue('$_POST', ['pass']) ?>">
                            </div>
                        </div>

                        <div class="flex f-col col-x-1">
                            <div class="flex-btn">
                                <button class="flex-btn bg-primary rad-4 c-white pxv-10" name="login" value="login" >Submit</button>
                            </div>
                            <div class="">
                                <input type="checkbox" name="remember"> RememberMe
                            </div>
                            <div class="flex">
                                <div class="flex mid c-white font-menu font-em-1">
                                    <div class="flex">forgot password?</div>
                                    <div class="flex pxs-10 mxs-10">
                                       <span class="mxr-6">or</span> 
                                       <span class="i"><a href="<?= DomUrl('signup') ?>">sign up</a></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                
            </div>
            
        </section>
                


</body>
</html>
