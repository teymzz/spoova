
  
  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= Rexit::mapp('images/icons/favicon.png') ?>">
    <title><?= $title?? '' ?></title>
    <?= Rexit::meta('dump') ?>
    <?= Rexit::res(':headers') ?>
    
</head>
<body>

    
        
     
        <!-- add css -->
        <?= Rexit::res('res/assets/css/index.css') ?> 
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


<!-- @live -->
        <section>

            <div class="maincover centre">      

                <form method="post" class="form-field" style="width: 350px">
                    <?= Rexit::csrf() ?>                    <div class="fm-d5 sp-1 wid-full">
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('error', ':csrf', 'title') ?> > <?= Rexit::error(':csrf','title') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('error', ':mod') ?>> <?= Rexit::error(':mod') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('error', ':dbi') ?>> <?= Rexit::error(':dbi') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('error', 'user') ?>> <?= Rexit::error('user') ?> </span>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('flash', 'no errors') ?>><?= Res::Flash('mod', 'no errors') ?></span>
                            </div>
                            <div class="i-flex-full-in bd-1 bd-dodger-blue rad-4">
                                <input type="text" class="flex-full pxv-4 c-dodger-blue" name="user" placeholder="username" value="<?= Rexit::post(['user']) ?>">
                            </div>
                        </div>
                        
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" <?= Rexit::onShow('error', 'pass') ?>> <?= Rexit::error('pass') ?> </span>
                            </div>
                            <div class="i-flex-full-in bd-1 bd-dodger-blue rad-4">
                                <input type="text" class="flex-full pxv-4 c-dodger-blue" name="pass" placeholder="password" value="<?= Rexit::post(['user']) ?>">
                            </div>
                        </div>

                        <div class="flex f-col col-x-1">                            
                            <div class="flex">
                                <div class="flex mid c-white  font-em-d85">
                                    <div class="flex">forgot password?</div>
                                    <div class="flex">
                                       <span class="mxs-6">or</span> 
                                       <span class="i"><a href="<?= Rexit::domurl('signup') ?>">sign up</a></span> 
                                    </div>
                                </div>
                            </div>

                            <div class="flex-full midv">
                                <div class="flex no-wrap">
                                    <div class="c-white text-right" style="align-self: flex-end;">
                                        <input type="checkbox" name="remember"> remember me
                                    </div>
                                </div>
                                <div class="flex-full flex-r">
                                    <div class="flex-btn">
                                        <button class="flex-btn bg-primary rad-4 c-white pxv-10" <?= Rexit::btn('login') ?> >Submit</button>
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
