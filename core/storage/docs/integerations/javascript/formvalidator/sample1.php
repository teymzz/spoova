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
        
        <h4 class="c-orange-dd">Validating input fields using required attribute</h4>
        <span class="font-em-d9">

            Input Fields that are required to be filled must have the attribute <code>required</code>.  Fields that are not required to be filled, may still be validated with other attributes which means that if they are filled, they must follow the laid down validation system for such input field.<br> <br>

            <h5 class="fb-6 c-sea-blue pxs-2">Attributes used below:</h5> 

            <code>data-form="validate"</code> - initializes the form field. This is used to declare a form field meant to be validated <br>

            <code>data-resp=".form-field"</code> and <code>data-init</code> - applies settings to form field <br>

            <code>required</code> - sets the required input fields<br>
            <code>data-type="submit"</code> sets the main submit button <br>
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
                    <input type="text" required placeholder="first field" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full">
                    <input type="text" required placeholder="second field" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full bc bc-red-d bh-red-dd pxv-10 c-white"> submit </button>
                </fieldset>
            </div>
        </div>

        <code class='pre bc-white-d c-red-dd' style="font-size: .745em"><span class="mybox-full c-black font-em-2 calibri pvs-10 pxs-8">Sample code</span>
            <br> &lt;div class=&quot;form-field&quot; data-form=&quot;validate&quot; data-resp=&quot;.resp&quot; data-init=""&gt;
            <br>    &lt;div class=&quot;form-title c-red-dd&quot;&gt;
            <br>        &lt;h2&gt;My Form&lt;/h2&gt;
            <br>    &lt;/div&gt; &lt;br&gt;
            <br>    &lt;div class=&quot;resp&quot;&gt;&lt;/div&gt;
            <br>        &lt;fieldset class=&quot;i-flex-full padd-x-4&quot;&gt;
            <br>            &lt;input type=&quot;text&quot; required placeholder=&quot;first field&quot; class=&quot;flex-full&quot;&gt;
            <br>        &lt;/fieldset&gt;
            <br>        &lt;fieldset class=&quot;i-flex-full padd-x-4&quot;&gt;
            <br>            &lt;input type=&quot;text&quot; required placeholder=&quot;second field&quot; class=&quot;flex-full&quot;&gt;
            <br>        &lt;/fieldset&gt;
            <br>        &lt;fieldset class=&quot;i-flex-full padd-10 bc bc-red-d bh-red-dd c-white anc-btn-link&quot;&gt;
            <br>            &lt;button type=&quot;submit&quot; data-type=&quot;submit&quot; class=&quot;flex-btn-full c-white&quot;&gt; submit
            <br>            &lt;/button&gt;
            <br>        &lt;/fieldset&gt;
            <br> &lt;/div&gt;
            <br> &lt;script&gt; formValidator(); &lt;/script&gt;
        </code>
    </div>

    <div class="font-em-d87 padd-4"> <br> <b>Note that:</b>
        <ol class="pxl-14">
            <li>
                All attributes mentioned on this page may not be discussed after this page.
            </li>
            <li>
                The form's response message field was tageted using <code>data-resp</code> attribute. This attribute takes a selector value to work. For example. It simply points the validator to where the message is meant to be displayed
                within the form.
            </li>
            <li>
                The form response message was initialized on the page's load. To change this behaviour to let the message display only after the user has started filling the field, remove <code>data-init</code> from the target form field.
                For all other sample forms discussed later, <code>data-init</code> attribute will be removed.
            </li>
            <li>
                The submit button with <code>data-type="submit"</code> was immediately disabled after load. This will occur if all fields are required
            </li>
            <li>
                The minimum and maximum characters allowed per field may still be set without adding the <code>required</code> attribute. This means the field is not required to be filled but when it filled, it has to follow a set of characters
                length.
            </li>
            <li>
                Whenever a button with attribute <code>data-type="submit"</code> or <code>type="submit"</code> has a parent of <code>fieldset</code>, that parent will also be given an attribute of <code>disabled="disabled"</code> until all
                conditions required for the form to be valid are met.
            </li>
            <li>
                All fields are automatically numbered unless the field has a <code>name</code> or <code>data-fieldname</code> attribute. It is highly discouraged to allow the formValidor to number the fields itself. In the field above, no
                name was set for both fields. So the fields are addressed as field 1 and field 2 respectively
            </li>
            <li>
                In other samples, the code will not be revealed, only the attributes will be explained.
            </li>
        </ol>
        <div class="font-em-d87 bold">
            <div class="box text-center">
                <a href="<?= DomUrl('docs/other-features/javascript/formvalidator') ?>" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="index.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample2.html" class="anc-btn-link">
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

