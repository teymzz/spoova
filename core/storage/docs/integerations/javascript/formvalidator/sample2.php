<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title></title>
        <link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/res.css" x-debug="res-css"><script src='http://localhost/trial/res/main/js/jquery-3.6.0.js'></script><script src='http://localhost/trial/res/main/css/bootstrap/js/bootstrap.min.js'></script><link  rel="stylesheet" type="text/css" href="http://localhost/trial/res/main/css/mdb5/css/mdb.min.css"><script src='http://localhost/trial/res/main/js/config.js'></script><script src='http://localhost/trial/res/main/js/core.js'></script><script src='http://localhost/trial/res/main/js/onLoaded.js'></script><script src='http://localhost/trial/res/main/js/custom.js'></script><script src='http://localhost/trial/res/main/js/device.js'></script><script src='http://localhost/trial/res/main/js/loadImages.js'></script><script src='http://localhost/trial/res/main/js/formValidator.js'></script><script src='http://localhost/trial/res/main/js/jquery.mousewheel.js'></script><script src='http://localhost/trial/res/main/js/anime.js'></script><script src='http://localhost/trial/res/main/js/init.js'></script>
        <style rel="integerations.template.css.index"> 

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

 </style>
        
    </head>

    <body>

        <div id="userscreen" data-height="full" data-form="validate" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
            <div class="overlay">
                <div class="padd-20 content-field xs-2s">
                    
    
    <br>
    <div class="">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features/javascript') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>
        
        <h4 class="c-orange-dd">Validating fields by setting minimum and maximum characters allowed</h4>
        <span class="font-em-d87">
            Fields below are validated only by adding the following attributes to the input fields<br><br>
            <code>data-min=""</code> <code>data-max=""</code> - used for setting character limits on text fields <br>
            <code>data-init</code> - used for initializing message display (this may not be used in appending samples)
        </span>
    </div><br>

    <div class="form-field" data-form="validate" data-resp=".resp" data-init>

        <div class="pxs-4">
            <div class="bc-silver pxv-10 rad-4">
                <div class="form-title c-red-dd">
                    <h2>My Form</h2>
                </div> <br>
                <div class="resp pxs-2"></div>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Firstname</button>
                    <input name="firstname" required placeholder="10 chars min" data-min="10" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Lastname</button>
                    <input name="lastname" required placeholder="10 - 12 chars only" data-min="10" data-max="12" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full bc bc-red-d bh-red-dd pxv-10 c-white"> submit </button>
                </fieldset>
            </div>
        </div>

    </div>


    <div class="font-em-d87 pxs-2"> <br> <b>Note that:</b>
    
        <ol class="pxl-14 mvt-10">
            <li>
                Name has now been added to the input fields and formValidator uses that name attribute's value to properly refer to fields.
            </li>
            <li>
                First field was applied the attribute of <code>data-min="10"</code> which sets a minimum of 10 characters on that field
            </li>
            <li>
                Second field was applied the attribute of <code>data-min="10"</code> and <code>data-max="12"</code> which limits the characters to be from 10 to 12 characters
            </li>
        </ol>

        <div class="font-em-d87 bold">
            <div class="box text-center">
                <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="sample1.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample3.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns"> NEXT >> </span>
                </a>
            </div>
        </div>

    </div>

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

</html>

