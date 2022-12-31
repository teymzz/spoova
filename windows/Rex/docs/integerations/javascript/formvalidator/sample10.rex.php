@template('docs.integerations.template.co.format')
    @title('Form Validator - Sample 10')
    
    <br>
    <div class="">
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
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
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
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
@template;