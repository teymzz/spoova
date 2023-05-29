@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Forms</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                            <div class="">
                                This class is simply used to generate 
                                html forms. Before a <code class="bd-f">Form</code> class can be used, 
                                a form model must be initialized. Models contain rules which the form can use in order to 
                                validate created forms. These rules are then applied on each form based 
                                on their relativity with the database. The <code>Form</code> class 
                                accepts static calls on all form input types except a few like <code>date-local</code> and password 
                                fields.
                            </div> <br>

                            <ul>
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
                            </ul>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="fb-6 flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> Initializing Form class
                                </div>
                            </div>

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
                                        <div class="pxv-6 bc-off-white">Create Form model (sample)</div>
                                        <pre class="pre-code">
  &lt;?php 

    namespace spoova\mi\windows\Model;

    use spoova\mi\core\classes\Model;

    class FormModel extends Model{

        public function rules() : array {

            return []; <span class="comment">// Form Validation rules</span>

        }

    }
                                        </pre>
                                    </div>
                                </div>

                                <div class="foot-note">
                                    In the above, a form model was created with the <code>rules()</code>
                                    method which usually contain form validation rules. Once the model is created, 
                                    the instance of that model will be loaded into the Form class for management. 
                                    This is shown below.
                                </div>

                                <div class="pre-area">

                                    <div class=" pxs-10">
                                    </div>

                                    <div id="model" class="box-full">
                                        <div class="pxv-6 bc-off-white">Instantiate form model</div>
                                        <pre class="pre-code">
  Form::model(new FormModel);
                                        </pre>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div> <br>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="">
                            The following keywords should be noted:
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">keywords</div>
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
                        </div>
                    </div> <br>       

                    <div id="init" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> init
                                </div>
                            </div>

                            <div class="">
                                The <code class="bd-f">init()</code> method is used to open a form class in a automatic display mode.
                                This means that when it is used, the form generated will be automatically printed out to the 
                                page.
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: init</div>
 <pre class="pre-code">
  Form::init($Form, method, action);
 </pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="foot-note">
                            The referenced variable <code>$Form</code> will anchor the form instance itself.
                        </div>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: Opening form (init)</div>
                                    <pre class="pre-code">
   <span class="comment">//starting a new form in rendering mode</span>
   Form::init($Form, 'post', 'somepage.php');
                                    </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="open" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> open
                                </div>
                            </div>
                            <div class="">
                                The <code class="bd-f">open()</code> method is similar to the <code class="bd-f">init()</code> method 
                                except that rather than printing directly, it returns the generated content of a form. It takes the same parameters as the <code class="bd-f">init()</code> method.
                            </div>
                        </div> <br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: Opening form (open)</div>
                                <pre class="pre-code">
  <span class="comment">//starting a new form without automatic display</span>
  echo Form::open($Form, 'post', 'somepage.php');
                                </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div id="set" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> set
                                </div>
                            </div>
                            <div class="">
                                The <code class="bd-f">set()</code> method is used to overide the default form settings.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: set</div>
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
                                        <div class="pxv-6 bc-off-white">Example: set</div>
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
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Field
                                </div>
                            </div>

                            <div class="">
                                This method is used to add a new form input field. The 
                                syntax and examples are shown below.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::Field($type, $name, $attrs); <span class="comment">// supplies data  to be hashed.</span>
    <span class="comment">
    where: 

        $type  : type of input field (e.g password)
        $name  : the name attribute value of the input field 
        $attrs : other added attributes and value pairs
                                        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  <span class="comment">// add a new form input password field</span>
  Form::Field('password', 'passfield');

  <span class="comment">// add a new form input email field with attributes</span>
  Form::Field('email', 'email', ['addClass'=>'i-flex']);  

  <span class="comment">// add a new form input field by calling the direct name</span>
  Form::Email('email', ['addClass'=>'i-flex']); 

  <span class="c-dry-blue no-comment font-i">Supported methods:</span>
  <span class="c-sky-blue-d">
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
                        <div class="">
                        <!-- some code here -->
                        </div>
                    </div>

                    <div id="label" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Label
                                </div>
                            </div>

                            <div class="">
                                This method add  an html label tag to forms.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::label($attrs, $content); 
        <span class="comment">
    where:
    
    $attrs: supplied attributes
    $content : text content of the label
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
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
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> Group
                                </div>
                            </div>

                            <div class="">
                                This method is used to group input fields. A group can only contain a  
                                direct group child or children. A grandchild group is not supported. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
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
                                        <div class="pxv-6 bc-off-white">Example 1</div>
                                        <pre class="pre-code">
  Form::Group('div', fn() => 

    Form::Text('firstname').
    Form::Text('lastname')

  ); 
                                        </pre>
                                                        </div>
                                                        <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 2 : Adding class attribute and child Group </div>
                                        <pre class="pre-code">
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
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GroupEach
                                </div>
                            </div>

                            <div class="">
                                This method is used to apply a tag on each input 
                                element supplied. GroupEach can only be applied once. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Form::GroupEach($tagname, $content); <span class="comment"> // group each </span>
        <span class="comment">
    where: 

    $tagname : html wrapper tag (e.g div)
    $content : function or string
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  Form::GroupEach( 
    'div class="field"',

    Form::Text('firstname').
    Form::Pass('lastname')
  );
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="foot-note">
                            In the above, each input field created will have a wrapper of "div" with a class of field.
                        </div>
                    </div>

                    <div id="close" class="">
                        <div class="">
                            <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> close
                                </div>
                            </div>
                            <div class="">
                                When a form is opened using <code>Form::open()</code> or <code>Form::Init()</code>, 
                                It is expected to be closed using <code>Form::close()</code> which closes the form tag.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: close</div>
                                        <pre class="pre-code">
  Form::close(); <span class="comment">//close a tag </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GroupEach</div>
                                        <pre class="pre-code">
  Form::GroupEach( 
    'div class="field"',

        fn() =>

            Form::Text('firstname').
            Form::Pass('lastname').
            Form::close()
  );
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="sample" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    SAMPLE STRUCTURE
                                </div>
                            </div>

                            <div>

                                <div class="">
                                    The example below is a sample structure of form creating form fields. <br>                   <ul>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 1: sample structure</div>
                                      <pre class="pre-code">
  Form::model($model) <span class="comment">check <a href="@domurl('docs/wmv/models')">here</a> for how to create a model </span>

  Form::init($form, 'get'); 

  <span class="comment">//displays automatically because <code>init()</code> was used</span>
  Form::Group('div', fn() => 
        
     Form::GroupEach('div class="inputs"', fn() => 

        Form::Field('email', 'email', ['placeholder' => 'email'])
        .Form::Pass('password', ['placeholder' => 'password'])
        .Form::close()

     )

  );
                                      </pre>
                                    </div>
                                </div>
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 2: sample structure</div>
                                        <pre class="pre-code">
    Form::model($model) <span class="comment">check <a href="@domurl('docs/wmv/models')">here</a> for how to create a model </span>
    
    Form::open($form, 'post');

    <span class="comment">//using echo to display result</span>
    echo Form::Group('div', fn() => 
        
        Form::GroupEach('div class="inputs"', fn() => 
        
            Form::Field('email', 'email', ['placeholder' => 'email'])
            .Form::Pass('password', ['placeholder' => 'password'])
            .Form::close()

        )

    );
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