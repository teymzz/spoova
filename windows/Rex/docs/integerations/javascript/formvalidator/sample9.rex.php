@template('docs.integerations.template.co.format')
    @title('Form Validator - Sample 9') 
    
    <br>
    <div class="">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h4 class="c-orange-dd">Validating password fields</h4>
        <span class="font-em-d87">
            Input fields with attribute <code>type="password"</code> and <code>data-check</code> will be validated. When two of this field exist in the form field, both fields will compare each other to validate the matches. <br>
        </span>
    </div><br>

    <div class="pxv-4">
        <div class="pxv-10 bc-silver">
            <div class="form-title c-red-dd">
                <h2>My Form</h2>
            </div> <br>
            <div class="form-field" data-form="validate" data-resp=".resp">
                <div class="resp"></div>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Password</button>
                    <input type="password" data-min="5" data-max="10" name="user" data-check required placeholder="5 - 10 chars only" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Retype</button>
                    <input type="password" data-min="5" data-max="10" name="user" data-check required placeholder="5 - 10 chars only" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full bc bc-red-d bh-red-dd c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full pxv-10 c-white"> submit </button>
                </fieldset>
            </div>            
        </div>
    </div> <br> 

    <div class="font-em-d87 pxs-2"> 
        
        <b>Note that:</b> In the field above, both password fields will be validated. <br>
       
        <div class="font-em-d87 bold mvt-10">
            <div class="box text-center">
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="sample8.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample10.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns"> NEXT >> </span>
                </a>
            </div>
        </div>

    </div>
@template;