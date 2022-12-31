@template('docs.integerations.template.co.format:off')

    @title('Form Validator - Sample 11')

    <br>
    <div class="">

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h4 class="c-orange-dd">Ajax - validating form using ajax</h4>
        <span class="font-em-d87">

            Input fields with attribute <code>data-url=""</code> is validated through ajax. Every other attributes set within the input field will be validated and then the data will be pushed to ajax validated. Input fields with this attribute works with other attributes explained below. <br><br>

            Attributes are : 
            
            <br><br> 
            <code class="main">data-url</code> - sets the domain url of the ajax file<br>
            <code class="main">data-keys</code> - takes a maximum of 2 keys. This will be explained below<br><br>

            <h5 class="fb-6 c-sea-blue">Relative Attributes</h5>

            <h5 class="c-olive font-em-1d2">data-url</h5>
            This attribute must contain the domain url of the file where the data should be pushed for validation <br><br>
            
            <h5 class="c-olive font-em-1d2">data-keys</h5>
            This is a pointer attribute. The default values are "valid msg", if not set. It directs the form to fetch the key values from a returned json ajax response. The first value will check for a similar key name that has true or false to detect whether the data was valid. The second value (optional) will point the form to an error message that is meant to be displayed if the first value returned in json response is false.. The second value if not set, will assume a default of <code>msg</code> A sample format is shown below<br><br>

            <div class="pre-area bd-true">
                <div class="pxv-10 bc-white-dd">code block 1</div>
                <div class="pxv-10">
                    <code>&lt;input data-url="http://www.myfile.com/file.php" data-key="valid msg"&gt;</code> <br>              
                </div>
            </div> <br>
            
            <div class="code-block bd-true">
                <div class="pxv-10 bc-white-dd">code block 2</div>
                <div class="pxv-10">                         
<code class="pre">             
    {
        "valid": "false", <br>
        "msg": "user exists"
    }<br>  
</code>
</div> 
            </div> <br>

            <h5 class="c-teal">Explanation</h5>

            <div class="">
                Assuming <b>code block 1</b> is our input and <b>code block 2</b> is the response returned from the url 
                supplied in <code>data-url="http://www.myfile.com/file.php"</code>, since the first key value in 
                <code>data-keys</code> <b>valid</b>  is false in our json response, the second key value <b>msg</b> 
                will be returned as the error message. If <code>"valid"</code> is true, no message will be returned which means 
                that and the input value will be accepted. This operation will also affect the main submit button attached 
                to the form. If there are other input fields that are yet to be validated, even if the input field containing 
                data-url returns a valid response, the submit form will not be active until all fields are validated. The 
                operation is also blended to work along with colors which will be discussed in the next page.<br> <br>
                
                <h5 class="c-orange-d">NOTICE!!!</h5>
                The sample below is tested using a local server. This may not work online. Clone and run through a local server to see it work. Ensure that your <code>data-url</code> value to points to the right backend file using the http or https protocol.
            </div> 

        </span>
    </div><br>

    <div class="">
        <div class="pxv-10 bc-silver">
            @csrf
            <div id="form1" class="form-field" data-form="validate" data-wait="500" data-resp=".rep">
                <div class="rep"></div>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white pxv-x-10 flex-ico">Firstname</button>
                    <input required data-min="5" data-max="10" data-fillset="shadow" data-fill="red lime 2" name="firstname" placeholder="5 - 10 chars only" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white pxv-x-10 flex-ico">Lastname</button>
                    <input required data-min="5" allow-space="false" data-strict data-max="10" data-fillset="shadow" data-fill="red lime 2" name="lastname" placeholder="5 - 10 chars only" class="flex-full">
                </fieldset>
                <fieldset class="i-flex-full">
                    <button class="flex-child bc-silver-d c-white pxv-x-10 flex-ico">Username</button>
                    <input required type="text" data-min="5" data-max="50" data-keys="valid msg" data-fillset="shadow" data-url="@domurl('docs/features/javascript/ajax')" data-fill="red lime 2" name="username" placeholder="try typing felix" class="flex-full">
                </fieldset>

                <fieldset class="i-flex-full bc bc-sky-blue bh-red-dd c-white anc-btn-link">
                    <button type="submit" data-type="submit" class="flex-btn-full pxv-10 c-white"> submit </button>
                </fieldset>
            </div>            
        </div>
    </div>

    <div class="controls-pane">
        <br>
        <div class="font-em-d87 bold">
            <div class="box pxs-2 text-center">
                <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-sky-blue-dd c-white pxv-6 control-btns"> << Home </span>
                </a>
                <a href="sample10.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-red-dd c-white pxv-6 control-btns"> << PREVIOUS </span>
                </a>
                <a href="sample12.html" class="anc-btn-link">
                    <span class="span-btns rad-2 bc-lime-dd c-white pxv-6 control-btns"> NEXT >> </span>
                </a>
            </div>
        </div>
    </div>

@template;