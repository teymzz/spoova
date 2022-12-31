@template('docs.integerations.template.co.format')

    @title('Form Validator - Sample 12')
                <div class=""> <br>

                    <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
                        <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
                        <div class="c-orange-dd">form validation</div>
                    </div><br>

                    <div class="">
                        <h4 class="c-orange-dd">Colors - Setting Fill colors</h4>
                        <span class="font-em-d87">
                            Input fields with attribute <code>data-type="credit-card"</code> is used to set check for credit cards. The input value is validated for american express, discover, mastercard, visa and 
                            verve. If data supplied matches any of this value, the field is returned valid
                        </span>
                    </div><br>

                    <span class="font-em-d87">
                        Input fields with attribute <code>data-fillset=""</code>  is used to set fill colors type for errors and successes. Parameters accepted are : 
                        
                        <br><br> 
                        <code class="main">fill</code> - fill background colors only <br>
                        <code class="main">text</code> - fill text colors (and shadow) <br>
                        <code class="main">shadow</code> - fill shadow colors only<br><br>

                        
                        <h4 class="c-orange-dd">data-fill</h4>
                        Input fields with attribute <code>data-fill=""</code> is used to set fill colors for errors and successes. It accepts one or more colors. <br><br>
                        
                        <ul class="pxl-16">
                            <li>When one color is used, it regards the color as the success color.</li>
                            <li>When two colors are used, the first color will stand as error color while the second will stand as success color.</li>
                            <li>When 3 parameters are supplied and <code>data-fillset="text"</code>, the third parameter will stand as box shadow thickness.</li>
                            <li>When more 3 or 4 parameters are supplied and <code>data-fillset="fill"</code>, the first two parameters stands for error background and text colors respectively while the third or last two parameters stand for success background and text color respectively. the third parameter will stand as box shadow thickness.</li>                            
                            <li>Whenever <code>"-"</code> is used to represent a color, the color will not be applied.</li>
                        </ul> 

                        <div class="samples">
                            <b>The following samples best explains how <code>data-fill</code> and <code>data-fillset</code> works</b>  <br> <br> 

                            <div class="info">
                               set the text color to red when the field is invalid and to green when the it is valid :<br>
                               <code class="main">data-fillset="text"</code> <code>data-fill="red green"</code>  <br> <br>
                            </div>
                            

                            set the text and box-shadow color to red when the field is invalid and to green when the field is valid : <br>
                            <code class="main">data-fillset="text"</code> <code>data-fill="red green 2"</code>  <br><br>

                            set the text and box-shadow color to green when the field is valid : <br>
                            <code class="main">data-fillset="text"</code> <code>data-fill="- green 2"</code>  <br><br>                            
                            
                            set the text box-shadow color to red when the field is invalid and to green when the it is valid: <br> 
                            <code class="main">data-fillset="shadow"</code> <code>data-fill="red green 2"</code> <br><br>
                            
                            set the background color to green when the field is successfully valid : <br>
                            <code class="main">data-fillset="fill"</code> <code>data-fill="green"</code><br><br>

                            set the background color to red when the field is invalid and to green when the it is valid : <br> 
                            <code class="main">data-fillset="fill"</code> <code>data-fill="red green"</code> <br> <br>   
                            
                            Note that whenever box-shadow is applied, a minimum of 3 parameters must be decared for the <code>data-fill</code> attribute for error, success and shadow respectively. Also, <code>data-fillset="fill"</code> does not take a box-shadow but can take a maximum of 4 parameters in the color order: "background text background text" i.e
                            data-fill="red white green blue". The first two colors will set the error background and text colors while the last two will set the success background and text colors. The following should be noted when using <code>data-fillset="fill"</code> along with <code>data-fill</code> : <br><br>
                            
                            
                            <ul class="pxl-14">
                                <li>
                                    When only one color is added (e.g <code>data-fill="green"</code>), the color is assumed as the success background color <br>
                                </li>
                                <li>
                                    When only two colors are added (e.g <code>data-fill="green white"</code>), the first color is assumed as the success background color while the second is assumed as the
                                    success text color.
                                </li>
                                <li>
                                    When colors are added in the order <code>data-fill="green white red"</code>, the first two represents the error colors for background and text respectively, while the third (or last two) represents
                                    the success colors. <br>
                                </li>
                                <li>
                                    When skipping a color, the <code>-</code> value is used or set as the skipping value. This notifies the validator to skip that value. <br>
                                </li>
                                <li>
                                    When filling the background colors alone, the <code>data-fill="red - green -"</code> may be used or alternative shorthand method <code>data-fill=":red green"</code> This notifies the validator to
                                    use only fill colors and ignore the text colors.<br>
                                </li>
                                <li>
                                    Any of the following is a valid shorthand method for filling backgrounds only<br>
                                    <code class="main">data-fill=":- green"</code> <code>data-fill=":blue -"</code> <br> <br>
                                </li>
                            </ul>


                            
                        </div>

                        Input fields below are validated only by adding the following required attributes to the form field:<br><br>
                        <code class="main">data-fillset="text"</code> - for setting color. <br>
                        <code class="main">data-fill="- lime 2"</code> - for setting color. <br> This value can be used generally on the form field or on the input field. When set on both, input field will overide input field

                        <br><br> There are so many variations of how the fill bucket can be used and it also works with url ajax validations.
                    </span>
            </div><br>

            <div class="sample1 bc-white-dd padd-4">

                <div class="pxv-4">
                    <div class="pxv-10 bc-silver">
                        <div class="form-title c-red-dd">
                            <h2>My Form - Sample 1</h2>
                        </div> <br>
                        <div id="form1" class="form-field-1" data-form="validate" data-resp=".resp">
                            <div class="resp"></div>
                            <fieldset class="i-flex-full">
                                <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Password</button>
                                <input type="password" name="pass1" required placeholder="5 - 10 chars only" data-check data-min="5" data-max="10" data-fillset="shadow" data-fill="red white 2" class="flex-full" style="padding-left:10px;">
                            </fieldset>
                            <fieldset class="i-flex-full">
                                <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Retype</button>
                                <input type="password" name="pass2" required placeholder="5 - 10 chars only" data-check data-min="5" data-max="10" data-fillset="fill" data-fill="red white lime red" class="flex-full" style="padding-left:10px;">
                            </fieldset>
                            <fieldset class="i-flex-full">
                                <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Username</button>
                                <input data-min="5" data-max="10" data-fillset="shadow" data-fill="red lime 4" name="username" required placeholder="5 - 10 chars only" class="flex-full" style="padding-left:10px;">
                            </fieldset>

                            <fieldset class="i-flex-full bc bc-red-d bh-red-dd c-white anc-btn-link">
                                <button type="submit" data-type="submit" class="flex-btn-full pxv-10 c-white"> submit </button>
                            </fieldset>
                        </div>                        
                    </div>
                </div>

                <div class="font-em-d87 pxs-10"> <br> <b>Note that:</b>
                    <ol class="pxs-20">
                        <li>
                            In the above field, both password fields will be validated and the colors will be seen to switch over.
                        </li>
                        <li>
                            All attributes discussed on this page may be used in other samples but will not be explained.
                        </li>
                    </ol>
                </div>
            </div> <br><br>

            <div class="sample2 bc-white-dd pxv-4">

                <div class="pxv-10">
                    <div class="form-title c-red-dd">
                        <h2>My Form - Sample 2</h2>
                    </div> <br>

                    <div class="">
                        <div class="pxv-10 bc-silver">
                            <div id="form-2" class="form-field" data-form="validate" data-wait="500" data-resp=".rep">
                                <div class="rep"></div>
                                <fieldset class="i-flex-full">
                                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Password</button>
                                    <input type="password" data-check data-min="5" data-max="10" data-fillset="fill" data-fill=":#b30000 #10d310" name="pass1" required placeholder="5 - 10 chars only" class="flex-full">
                                </fieldset>
                                <fieldset class="i-flex-full">
                                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Retype</button>
                                    <input type="password" data-check data-min="5" data-max="10" data-fillset="fill" data-fill="red white #10d310 white" name="pass2" required placeholder="5 - 10 chars only" class="flex-full">
                                </fieldset>
                                <fieldset class="i-flex-full">
                                    <button class="flex-child bc-silver-d c-white padd-x-10 flex-ico">Username</button>
                                    <input type="text" data-min="5" data-max="50" data-fillset="shadow" data-fill="red lime 4" name="username" required placeholder="5 - 10 chars only" class="flex-full">
                                </fieldset>

                                <fieldset class="i-flex-fullbc bc-sky-blue bh-red-dd c-white anc-btn-link">
                                    <button type="submit" data-type="submit" class="flex-btn-full pxv-10 c-white"> submit </button>
                                </fieldset>
                            </div>                        
                        </div>
                    </div>
                </div>

                <div class="font-em-d87 pxs-20"> <br> <b>Note that:</b>
                    <ol class="">
                        <li>
                            In the above field, both password fields will be validated.
                        </li>
                        <li>
                            All attributes discussed on this page may be used in other samples but will not be explained.
                        </li>
                    </ol>
                </div>
            </div>


            <div class="controls-pane pxs-2">
                <br>
                <div class="font-em-d87 bold">
                    <div class="text-center box"> 
                        <a href="@domurl('docs/other-features/javascript/formvalidator')" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-sky-blue-dd c-white padd-6 control-btns"> << Home </span>
                        </a>
                        <a href="sample11.html" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-red-dd c-white padd-6 control-btns"> << PREVIOUS </span>
                        </a>
                        <a href="sample13.html" class="anc-btn-link">
                            <span class="span-btns rad-2 bc-lime-dd c-white padd-6 control-btns"> NEXT >> </span>
                        </a>
                    </div>
                </div>
            </div>
@template;