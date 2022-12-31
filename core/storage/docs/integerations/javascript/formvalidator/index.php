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
                    


    <div class=""> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="<?= DomUrl('docs/other-features/javascript') ?>"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h2 class="c-orange-dd">Form Validator Plugin</h2>

        <span class="font-em-d85">
            Forms validator plugin is used for validating forms. By default, this plugin has been added 
            into the headers and is included into the webpage once the <code>&#64;Res(':headers')</code> is called. 
            Forms are validated by calling the <code>formValidator()</code> function once, 
            after which <code>data-form="validate"</code> attribute is added to the form field(s) containing the form. Attributes that may 
            be used to initialize the form include: <br><br>
            
            <div class="wid-fit c-olive"><h3>Form Field Attributes</h3></div>

            <code>data-form="validate"</code> - for selecting form field to be validated <br>
            <code>data-resp</code> - for selecting the message display field  <br>
            <code>data-init</code> - for intializing message display <br>
            <code>data-wait</code> - for setting message display time <br>
            <code>data-fillset</code> - for applying color display <br>
            <code>data-fill</code>- for setting colors <br>
        </span>
    </div><br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive"><h3>Input Field Attributes</h3></div>
            Forms are validated by calling the <code>formValidator()</code> function once, after which <code>data-form="validate"</code> attribute is added to the form field(s) containing the form. Other attributes that may be used to initialize the form include: <br><br>

            <code class="main">name=""</code> - for naming an input field <br>
            <code class="main">data-fieldname=""</code> - sets or overides the <code>"name"</code> attribute above<br>
            <code class="main">required</code> - all required fields will be validated<br>
            <code class="main">data-wait</code> - for setting message display time for a particular field<br>
            <code class="main">data-fillset</code> - for applying color display for a particular field <br>
            <code class="main">data-fill</code>- for setting colors for a particular field <br>
            <code class="main">data-skip</code> - for skipping input field's validatation <br>
            <code class="main">data-min</code> - for setting minimum acceptable length of characters<br>
            <code class="main">data-max</code> - for setting maximum acceptable length of characters<br>
            <code class="main">data-rex</code> - for setting rex pattern to be used for input valiation <br>
            <code class="main">data-space="false"</code> - for disabling space characters <br>
            <code class="main">allow-chars</code> - for switching validation type from the default set <br>
            <code class="main">data-strict</code> - for declaring input field as strictly for texts or numbers <br>
            <code class="main">data-type</code> - for declaring an input or button role as input <b>email</b> , <b>number</b>, <b>submit</b>, <b>text</b>, <b>text-num</b>, <b>url</b> ... <br><br>

            <b>Ajax Attributes</b> <br>
            <code class="main">data-url</code> - for sending ajax requests <br>
            <code class="main">data-keys</code> - for fetching ajax response keys <br>                                                

            <br> To understand the use of this plugin, it is required that each pages be visited respectively <br>

            <span class="links c-sky-blue-dd">
                <a href="<?= route('::sample1'); ?>">BEGIN TUTORIAL</a>
            </span>
        </span>
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

