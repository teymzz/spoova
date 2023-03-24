@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Forms</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                            <div class="">
                                The <code>Form</code> class is a tool that is used to generate 
                                html forms within classes. It is a more concise way of creating 
                                html form inputs. Before a form class can be used, a form model must 
                                be initialized. Models contain rules which the form can use in order to 
                                validate created forms. These rules are then applied on each form based 
                                on their relativity with the database. The <code>form</code> class 
                                accepts static calls on all form input types except a few like <code>date-local</code> and password
                            </div> <br>

                            <ol>
                                <li> <a href="#model"> Model </a> </li>
                                <li> <a href="#init"> Init </a> </li>
                                <li> <a href="#open"> Open </a> </li>
                                <li> <a href="#set"> Set </a> </li>
                                <li> <a href="#field"> Field </a> </li>
                                <li> <a href="#label"> Label </a> </li>
                                <li> <a href="#group"> Group </a> </li>
                                <li> <a href="#groupeach"> GroupEach </a> </li>
                                <li> <a href="#close"> Close </a> </li>
                                <li> <a href="#isSaved"> isSaved </a> </li>
                                <li> <a href="#isValidated"> isValidated </a> </li>
                                <li> <a href="#close"> errors </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> Initializing class
                                </div>
                            </div> <br>

                            <div class="">
                                To initialize a form element, the following proceedures must be followed
                                <ul>
                                    <li>create a form model class with a method rules that returns an array</li>
                                    <li>Initialize the Form class by supplying an instantiated form model into the Form <code>model</code> method</li>
                                    <li>Open the Form class using either <code>init</code> or <code>open</code> method</li>
                                    <li>Create an input field using the field name on the Form class.</li>
                                </ul>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>1. Creating Form model class (sample)</code></div>
                                        <pre class="pre-code">
    <code>Form Model class</code>
    <div class="pxs-10 bc-off-white c-green">
    The following model can be created in any folder within the app folder.
    </div>
    use spoova\mi\core\classes\Model;

    class FormModel extends Model{

        public function rules() : array {

            return []; <span class="comment">// Form Validation rules</span>

        }

    }
                                        </pre>
                                    </div>

                                    <div class="font-menu pxs-10">
                                        In the above, a form model was created with rules. The class 
                                        will be instantiated and supplied into the Form class. The <code>rules</code>
                                        method must contain form validation rules. This will be discussed later.
                                    </div>

                                    <div id="model" class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>2. Instantiating form class (Form::model())</code></div>
                                        <div class="pxv-10 c-green"><code>Form Model class</code></div>
                                        <pre class="pre-code">
    $model = new FormModel;

    Form::model($model);
                                        </pre>
                                    </div>
                                </div>

                            </div>

                        </div> <br><br>
                    </div>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> keywords
                                </div>
                            </div> <br>
                            <div class="">
                            The following keywords should be noted:
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>keywords</code></div>
                                    <pre class="pre-code">
    <span class="comment">
    $Form  : referenced variable anchoring Form class instance (optional)

    method : request method (optional)

    action : form action (optional)

    type   : form input type (e.g email, password...)
    </span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br><br>
                    </div>        

                    <div id="init" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> init
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>init</code> method is used to open a form class in a automatic display mode.
                                This means that when it is used, the form generated will be automatically printed out to the 
                                page.
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: init</code></div>
 <pre class="pre-code">
    Form::init($Form, method, action);
 </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>

                        The referenced variable <code>$var</code> will anchor the form instance itself.
                        <br><br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: Opening form (init)</code></div>
<pre class="pre-code">

    <span class="comment">//starting a new form in rendering mode</span>
    Form::init($Form, 'post', 'somepage.php');

</pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="open" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> open
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>open</code> method is used to open a form class in without an 
                            automatic display.
                            This means that when it is used, the form generated has to be printed out using 
                            either <code>echo</code> or <code>print</code> function. This is mostly used in classes.
                            It takes the same parameters as the <code>init</code> class
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: open</code></div>
                                    <pre class="pre-code">
    Form::open($Form, method, action);
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                        The referenced variable <code>$var</code> will anchor the form instance itself.
                        <br><br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: Opening form (init)</code></div>
                                <pre class="pre-code">

    <span class="comment">//starting a new form without automatic display</span>
    Form::open($Form, 'post', 'somepage.php');

                                </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div id="set" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> set
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>set()</code> method is used to overide the default form settings.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: set</code></div>
                                        <pre class="pre-code">
    Form::set($array); 
    <span class="comment">
        where: 

            $array = list of options which can be contains array index: 

            form_class  => This sets the forms global class attribute value which is applied on all <code>Form::Group()</code>
            field_class => This sets the form inputs class attribute value which is applied on all <code>Form::Field()</code> 
    </span>
                                        </pre>
                                    </div>
                                </div>          
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: set</code></div>
                                        <pre class="pre-code">
                                        
    Form::set([

        'form_class'  => 'form-flex', <span class="comment no-select">// add form-flex class to all form groups</span>

        'field_class' => 'field-item bg-primary' <span class="comment no-select">// add bg-primary class to all form fields</span>

        ]);

                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="field" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> Field
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>Field()</code> method is used to create a new form input field. The 
                                syntax and examples are shown below.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: Field</code></div>
                                        <pre class="pre-code">
    Form::Field(type, name, attrs); <span class="comment">// supplies data  to be hashed.</span>

    <span class="comment">
        where: 

            type  : type of input field (e.g password)
            name  : the name attribute value of the input field 
            attrs : other added attributes <a href="attrs">learn more...</a>
                                        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: Field</code></div>
                                        <pre class="pre-code">
    <span class="comment">// add a new form input password field</span>
    Form::Field('password', 'passfield');

    <span class="comment">// add a new form input email field with attributes</span>
    Form::Field('email', 'email', ['addClass'=>'i-flex']);  

    <span class="comment">// add a new form input field by calling the direct name</span>
    Form::Email('email', ['addClass'=>'i-flex']); 
    
    <span class="c-blue-dd no-comment">supported methods:</span>
    <span class="comment">
    Email, Text, TextBox/Textarea, Pass/Password, Range, 
    Radio, Checkbox, Hidden, File, Number, Tel, Url, 
    Date, DateLocal {date-local}, Week, Month, Year, 
    Image, Color, CheckBox, Radio, Search, Submit, Button
    </span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <div class="font-menu">
                        <!-- some code here -->
                        </div>
                    </div>

                    <div id="label" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> Label
                                </div>
                            </div> <br>

                            <div class="">
                                This method add  an html label tag to forms.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: Label</code></div>
                                        <pre class="pre-code">
    Form::label(attrs, content); 
        <span class="comment">
            where:
            
            attrs: supplied attributes
            content : text content of the label
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: Label</code></div>
                                        <pre class="pre-code">
    Form::label(['class'=>'label'], 'Username'); <span class="comment"> // &#60;label class="label"&#62;Username&#60;/label&#62; </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="group" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> Group
                                </div>
                            </div> <br>

                            <div class="">
                                This method is used to group a input fields. A group can only contain a  
                                direct group child(ren). A grand child group is not supported. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: Group</code></div>
                                        <pre class="pre-code">
    Form::Group(tag, content); 

    <span class="comment">
        where: 

            tag: html tag name (e.g div)
            content: function or string
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: Group</code></div>
                                        <pre class="pre-code">
    Form::Group('div', fn() => 

        Form::Text('firstname').
        Form::Text('lastname')

    ); 
                                        <span class="comment"> // &#60;label class="label"&#62;Username&#60;/label&#62; </span>
                                        </pre>
                                                        </div>
                                                        <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: Group </code></div>
                                        <pre class="pre-code">
                                        <span class="comment"> // - Adding class and child Group </span>
    Form::Group('div class="i-flex"', fn() => 

        Form::Group('div', fn() => 
            Form::Text('firstname').
            Form::Text('lastname')    
        )

    ); 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="groupeach" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">8.</span>
                                    </span> GroupEach
                                </div>
                            </div> <br>

                            <div class="">
                                This <code>GroupEach</code> method is used to apply a tag on each input 
                                element supplied. GroupEach can only be applied 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GroupEach</code></div>
                                        <pre class="pre-code">
    Form::GroupEach(tag, content); <span class="comment"> // group each </span>
        
        <span class="comment">
            where: 

            tag     : html wrapper tag (e.g div)
            content : function or string
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GroupEach</code></div>
                                        <pre class="pre-code">
    Form::GroupEach( 
        'div class="field"',

        Form::Text('firstname').
        Form::Pass('lastname')

        )
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="font-menu pvs-10">
                            In the above, each input field created will have a wrapper of "div" with a class of field.
                        </div>
                    </div>

                    <div id="close" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">9.</span>
                                    </span> Close
                                </div>
                            </div> <br>
                            <div class="">
                                When a form is opened using <code>Form::open()</code> or <code>Form::Init()</code>, 
                                It is expected to be closed using <code>Form::close</code> which closes the form tag.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: close</code></div>
                                        <pre class="pre-code">
    Form::close(); <span class="comment"> close a tag </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GroupEach</code></div>
                                        <pre class="pre-code">
    Form::GroupEach( 
        'div class="field"',

            fn() =>

                Form::Text('firstname').
                Form::Pass('lastname').
                Form::close()

        )
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="sample" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    SAMPLE STRUCTURE
                                </div>
                            </div> <br>

                            <div>

                                <div class="">
                                    The example below is a sample structure of form creating form fields. <br>                   <ul>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: sample structure</code></div>
<pre class="pre-code">

    Form::model($model) <span class="comment">check <a href="model">here</a> for how to create a model </span>

    Form::init($form, 'get'); 

    <span class="comment">displays automatically because <code>init()</code> was used</span>
    Form::Group('div', fn() => 
        
        Form::GroupEach('div class="inputs"', fn() => 
        
            Form::Field('email', 'email', ['placeholder' => 'email'])
            .Form::Pass('password', ['placeholder' => 'password'])
            .Form::close()

        )

    )
</pre>
                                    </div>
                                </div>
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: sample structure</code></div>
                                        <pre class="pre-code">
    Form::model($model) <span class="comment">check <a href="model">here</a> for how to create a model </span>
    
    Form::open($form, 'post');

    <span class="comment">//using echo to display result</span>
    echo Form::Group('div', fn() => 
        
        Form::GroupEach('div class="inputs"', fn() => 
        
            Form::Field('email', 'email', ['placeholder' => 'email'])
            .Form::Pass('password', ['placeholder' => 'password'])
            .Form::close()

        )

    )
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
                
    @lay('build.co.coords:footer')

@template;