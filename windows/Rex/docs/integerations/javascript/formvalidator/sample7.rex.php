@template('docs.integerations.template.co.format')
    <br>
    
    <div> 

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h4 class="c-orange-dd">Using regex patterns on fields for validation</h4>
        <span class="font-em-d87">
            Input fields with attribute <code>data-rex="--"</code> and <code>allow-chars="rex"</code> will be validated using the regex value of attribute <code>data-rex</code> <br><br>
            
            Input fields below are validated only by adding the following required attributes to the input field:<br><br>
            <code>data-rex</code> - for validating fields using regex pattern <br>
            <code>allow-chars="rex"</code> - for switching to regex validation
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
                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">User</button>
                    <input data-min="5" data-rex="me" allow-chars="rex" name="user" required placeholder="5 chars min" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full bc bc-red-d bh-red-dd c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full c-white pxv-10"> submit </button>
                </fieldset>
            </div>
        </div>
    </div> <br>

    <div class="font-em-d87 pxs-2"> 
        
        <b>Note that:</b>In the above field, the rex pattern is <code>"me"</code>. Only characters <code>m</code> and <code>e</code> will be accepted <br>

        <div class="font-em-d87 bold mvt-10">
            <div class="box text-center">
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                </a>
                <a href="sample6.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample8.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns"> NEXT >> </span>
                </a>
            </div>
        </div>

    </div>
@template;