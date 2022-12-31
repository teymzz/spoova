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
    @Res(':headers')
    @style('docs.integerations.template.css.index:index')
    <title>Form Validator -Sample 13</title>
</head>

<body>
    <div id="v-form" data-form="validate" data-wait="1500" data-resp=".resp" class="grid-center bc-sky-blue-dd relative">
        <div class="box-2s overlay bg-cover">
            <div class="content-field">

                <br>
                <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
                    <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
                    <div class="c-orange-dd">form validation</div>
                </div><br>

                <div class=""> <br>
                    <h4 class="c-orange-dd">Colors - Credit card validation</h4>
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
                </div> <br>


                <div class="controls-pane mvt-10">
                    <div class="font-em-d87 bold">
                        <div class="box text-center">
                            <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
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
    </div>

    <script src="js/formValidator.js"></script>
    <script>
        formValidator();
    </script>
</body>

</html>