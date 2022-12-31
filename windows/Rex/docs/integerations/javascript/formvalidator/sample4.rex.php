@template('docs.integerations.template.co.format')

    <br>

    <div class="">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h4 class="c-orange-dd">Skipping fields meant for validation</h4>
        <span class="font-em-d87">
            Input fields with attribute <code>data-skip</code> will not be validated <br> <br>
            
            The second input field below is skipped only by adding the following required attributes to it:<br><br>
            <code>data-skip=""</code> - used for skipping fields
        </span>
    </div><br>

    <div class="pxv-4">
        <div class="bc-silver pxv-10">
            <div class="form-field" data-form="validate" data-resp=".resp">
                <div class="form-title c-red-dd">
                    <h2>My Form</h2>
                </div> <br> 
                <div class="resp"></div>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">FirstName</button>
                    <input required name="firstname" placeholder="10 chars min" data-min="10" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full padd-right-10">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">LastName</button>
                    <input required name="lastname" placeholder="10 chars min" data-min="10" data-skip class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full padd-right-10">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Username</button>
                    <input required name="username" placeholder="10 chars min" data-min="10" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full bc bc-red-d bh-red-dd c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full c-white pxv-10"> submit </button>
                </fieldset>
            </div>
        </div>
    </div> <br>


    <div class="font-em-d87 pxs-2">
    
        <b>Note that:</b> The attribute "data-skip" overides required. The attribute must not be used on all fields, else it will disable the submit button as security. When used, at least one field must be open for validation. 
        <br><br>
        
        <div class="font-em-d87 bold">
            <div class="box text-center">
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="sample3.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample5.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns"> NEXT >> </span>
                </a>
            </div>
        </div>

    </div>
@template;