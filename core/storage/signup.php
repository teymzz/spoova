
  
  
  
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/trial/res/main/images/icons/favicon.png">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
    <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script>
</head>
<body>

    
        
         
            <!-- add css -->
            <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/assets/css/index.css"> 
            <style rel="css.inc">  
    .content{
        box-shadow: 0 0 6px 4px #efefef;
        border: solid thin #dedede;
    }
 
  .slided-up{
    height:0 !important;
  }
  @media (min-width: 480px){
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
                        <input type="hidden" value="G7IuVKVVxIJTXapLSb3r" name="CSRF_TOKEN">
                        <div class="fm-d5 sp-1 wid-full bc-silver pxv-14 rad-4">
                            <div class="flex-full c-blue">
                                Signup
                            </div>
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error',':csrf','title')?> > <?= error(':csrf','title') ?> </span>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error',':mod')?>> <?= error(':mod') ?> </span>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error',':dbi')?>> <?= error(':dbi') ?> </span>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error','firstname')?>> <?= error('firstname') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="firstname" placeholder="firstname" value="<?=reqValue('$_POST', ['firstname'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error','lastname')?>> <?= error('lastname') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="lastname" placeholder="lastname" value="<?=reqValue('$_POST', ['lastname'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error','user')?>> <?= error('user') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="user" placeholder="username" value="<?=reqValue('$_POST', ['user'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error','email')?>> <?= error('email') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="email" placeholder="email" value="<?=reqValue('$_POST', ['email'])?>">
                                </div>
                            </div>
                            
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" <?= onHide('error','pass')?>> <?= error('pass') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="password" class="flex-full pxv-4" name="pass" placeholder="password" value="<?=reqValue('$_POST', ['pass'])?>">
                                </div>
                            </div>
    
                            <div class="flex-grid col-x-1">
                                <div class="flex-btn">
                                    <button class="flex-btn bg-primary rad-4 c-white pxv-10" name="signup">Submit</button>
                                </div>
                                <div class="flex mid c-grey-dd font-menu font-em-1">
                                    <div class="flex">forgot password?</div>
                                    <div class="flex pxs-10">
                                       <span class="mxr-6">or</span> 
                                       <span class="i"><a href="<?= DomUrl('signup') ?>">log in</a></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                    
                </div>
                
            </section>
                    
    

</body>
</html>
    
    