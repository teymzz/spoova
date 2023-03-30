
  
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="http://localhost/spoova/res/main/images/icons/favicon.png">
    <title></title>
    
    <link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/spoova/res/main/js/jquery/jquery-3.6.0.js'></script><script src='http://localhost/spoova/res/main/js/jquery/jquery.mousewheel.js'></script><script src='http://localhost/spoova/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/spoova/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/spoova/res/main/js/local/core.js'></script><script src='http://localhost/spoova/res/main/js/local/onLoaded.js'></script><script src='http://localhost/spoova/res/main/js/local/jqmodex.js'></script><script src='http://localhost/spoova/res/main/js/local/device.js'></script><script src='http://localhost/spoova/res/main/js/local/loadImages.js'></script><script src='http://localhost/spoova/res/main/js/local/formValidator.js'></script><script src='http://localhost/spoova/res/main/js/local/helper.js'></script><script src='http://localhost/spoova/res/main/js/local/init.js'></script>
</head>
<body>

    
        
         

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
    
            <section>
    
                <div class="maincover centre">      
    
                    <form method="post" class="form-field" style="width: 350px">
                        <input type="hidden" value="SsOrmPlhSszP9mRTruJl" name="CSRF_TOKEN">
                        <div class="fm-d5 sp-1 wid-full bc-silver pxv-14 rad-4">
                            <div class="flex-full c-blue">
                                Signup
                            </div>
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error',':csrf','title')?> > <?= error(':csrf','title') ?> </span>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error',':mod')?>> <?= error(':mod') ?> </span>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error',':dbi')?>> <?= error(':dbi') ?> </span>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error','firstname')?>> <?= error('firstname') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="firstname" placeholder="firstname" value="<?=reqValue('$_POST', ['firstname'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error','lastname')?>> <?= error('lastname') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="lastname" placeholder="lastname" value="<?=reqValue('$_POST', ['lastname'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error','user')?>> <?= error('user') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="user" placeholder="username" value="<?=reqValue('$_POST', ['user'])?>">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error','email')?>> <?= error('email') ?> </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="email" placeholder="email" value="<?=reqValue('$_POST', ['email'])?>">
                                </div>
                            </div>
                            
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-red-dd box-full pvs-8 font-em-d9" <?= onShow('error','pass')?>> <?= error('pass') ?> </span>
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
                                       <span class="i"><a href="<?= DomUrl('login') ?>">log in</a></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                    
                </div>
                
            </section>
                    
    

</body>
</html>
    