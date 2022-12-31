<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=.9, maximum-scale=1.0, user-scalable=1" />
<meta name="description" content="website_description" />
<link rel="icon" href="http://localhost/trial/res/main/images/icons/favicon.png" />
        <title>Form Validator - Sample 10</title>
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
            <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>
        <h4 class="c-orange-dd">Ajax - Validating Http Urls</h4>
        <span class="font-em-d87">
            Input fields with attribute <code>data-type="url"</code> sets the url to be validated using regex pattern <br><br>
            
            Input fields below are validated only by adding the following required attributes to the input field:<br><br>
            <code>data-url</code> - for validating urls. <br>
        </span>
    </div><br>

    <div class="pxv-4">
        <div class="pxv-10 bc-silver">
            <div id="form1" class="form-field" data-form="validate" data-resp=".rep">
                <div class="rep"></div>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico no-wrap">URL Validator</button>
                    <input required data-type="url" name="url" placeholder="please input your url" class="flex-full">
                </fieldset>

                <fieldset class="i-flex-full bc bc-sky-blue bh-red-dd c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full pxv-10 c-white"> submit </button>
                </fieldset>
            </div>            
        </div>
    </div>

    <div class="controls-pane pxs-2 font-em-d87">
        <br>
        <ol>
            <li>
                In the above field, the <code>data-type="url"</code> is set on the input field.
            </li>
            <li>
                All attributes discussed on this page may be used in other samples but will not be explained.
            </li>
        </ol> <br>
        <div class="font-em-d87 bold">
            <div class="text-center box">
                <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="sample9.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample11.html" class="anc-btn-link">
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

