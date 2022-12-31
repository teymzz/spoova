@template('docs.integerations.template.co.format')


    <div class=""> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
            <div class="c-orange-dd">form validation</div>
        </div><br>

        <h2 class="c-orange-dd">Form Validator Plugin</h2>

        <span class="font-em-d85">
            Forms validator plugin is used for validating forms. By default, this plugin has been added 
            into the headers and is included into the webpage once the <code>@(Res(':headers'))@</code> is called. 
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
                <a href="@route('::sample1')">BEGIN TUTORIAL</a>
            </span>
        </span>
    </div>

    
@template;