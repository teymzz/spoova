@template('docs.integerations.template.co.format')
    
    <br>
    <div class="">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
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
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
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
@template;