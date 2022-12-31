<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="cache-control" content="max-age=0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>Form Validator -Sample 13</title>
</head>

<body>
    <div id="v-form" data-form="validate" data-wait="1500" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
        <div class="box-2s overlay bg-cover">
            <div class="content-field">

                <br>
                <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
                    <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
                    <div class="c-orange-dd">form validation</div>
                </div><br>

                <div class=""> <br>
                    <h2 class="c-orange-dd">Colors - Setting Fill colors</h2>
                    <span class="font-em-d87">
                        Input fields with attribute <code>data-type="credit-card"</code> is used to set check for credit cards. The input value is validated for american express, discover, mastercard, visa and verve. If data supplied matches any of this value, the field is returned valid<br><br>
                    </span>
                </div><br>

                <div class="sample1 bc-white-dd padd-4">
                    <div class="form-title pxv-10 c-red-dd">
                        <h4 class="fb-6 c-teal-dd">Credit Card Validation - Sample 1</h4>
                    </div>

                    <div id="form-2" class="form-field pxv-10" data-form="validate" data-wait="500" data-resp=".rep">
                        <div class="rep"></div>
                        <fieldset class="i-flex-full">
                            <button class="flex-child bc-silver c-white padd-x-10 flex-ico no-wrap">Credit Card</button>
                            <input data-type="credit-card" data-fillset="fill" data-fill="#b04848 white - -" name="credit" data-fieldname="credit card" required placeholder="5 - 10 chars only" class="flex-full" style="padding-left:10px;">
                        </fieldset>

                        <fieldset class="i-flex-full padd-10 bc bc-sky-blue-dd c-white anc-btn-link">
                            <button type="submit" data-type="submit" class="flex-btn-full c-white"> submit </button>
                        </fieldset>
                    </div>

                    <div class="font-em-d87 pxv-10"> 
                        <b>Note that:</b>
                        In the above field, the credit card field will be validated using a credit card pattern.
                    </div>
                </div>


                <div class="controls-pane">
                    <br>
                    <div class="text-cente font-em-d85 bold">
                        <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns text-center"> << Home </span>
                        </a>
                        <a href="sample11.html" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns text-center"> << PREVIOUS </span>
                        </a>
                        <a href="finish.html" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns text-center"> NEXT >> </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/formValidator.js"></script>
    <script>
        formValidator();
    </script>
</body>

</html>