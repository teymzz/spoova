@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8"> 

                    @lay('build.co.links:tutor_pointer')<br>

                    <div class="font-em-1d5 c-orange">Handling Forms</div> <br>  
                    
                    <div class="pulling-data">
                        <div>
                            The The <code>Form</code> class is used to create forms and to aslo handle all form data requests sent through the server. 
                            This class along with the <code>Request</code> class, are both able to set form validations, restrictions and saving of 
                            validated request data into the database. An introduction into the generation of forms through <code>Form</code> class 
                            using predefined methods was already discussed in <a href="@domurl('docs/classes/forms')" class="c-gold-dd">Form</a> helper class. 
                            Here, we will focus more on form validations in relation with the request class.
                        </div> <br>

                        
                        <div>
                            <div class="font-em-1d2 c-orange">Request Data</div> 
                            All form data request sent are be obtained by using the Request class which enables us to perform 
                            necessary form validations on data request sent. This class ensures that only request data that meets a 
                            certain requirements are obtained. These requirements are categorized under different level of strictness.
                            which are strict and non-strict levels. These levels are then applied on form input request validations. 
                            We can initialize the request class as shown below: <br><br>
<div class="pre-area">
    <pre class="pre-code">
  use spoova/mi/core/class/Request;

  $Request = new Request;
    </pre>
</div>                          
                        </div><br>

                        <div>
                            <div class="font-em-1 c-orange">Fetching Request Data : Non-Strict Type</div> 
                            <div class="mvs-10">
                                Request data are strictly advised to be obtained using the <code>$Request->data()</code> method. This method ensures 
                                that only request data forwarded with a CSRF request token are obtainable. If a request data is fowarded without a request 
                                token, an empty array will be returned. When working within the template files, the <code>@(@csrf)@</code> template directive 
                                is used to add CSRF tokens input fields to forms. The sample below reflects the syntax of obtaining request data: 
                                <br> <br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  $Formdata = $Request->data(); <span class="comment">// returns the request data sent</span>
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return the form data sent from request by default, 
                                    if the <code>@(@csrf)@</code> directive is not supplied, the data returned will be an empty array. In order 
                                    to ensure that all data supplied are accepted, each form must have a <code>@(@csrf)@</code> directive attached to it. 
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            <div class="font-em-1 c-orange">Fetching Request Data : Strict Type</div> 
                            <div class="mvs-10">
                                Setting request data as a strict type resolves to an error page if the means by which a request data was sent is not permitted. 
                                This is mostly caused when a CSRF token is not added to a form or the forwarded CSRF token is rejected.
                                A csrf token may become reject if it does not match the token set at run-time or the token has expired if timed. We can set a data 
                                to strict type using the <code>strict()</code> method. If a token is rejected, rather than for <code>data()</code> method to return 
                                an empty array, an error page will be displayed instead based on the type of error that occured. 
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  $Request->strict(); <span class="comment">//set request data as strict type</span>

  $Formdata = $Request->data(); <span class="comment">//display error page if data was sent without valid CSRF</span>
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    Although the <code>$Request->data()</code> is expected to return form data sent from request or an empty array if 
                                    no csrf token is set, if the strict method is applied, the request page will return a csrf default error page preventing any further action.
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            <div class="font-em-1 c-orange">Checking Request Data</div> 
                            <div class="mvs-10">
                                An empty data may be returned due to an invalid token, this does not mean that data sent 
                                cannot be checked to see if it contains a particular key. The <code>has()</code> method allows the checking of data forwarded before it is returned. 
                                This is useful in cases when we may want to detect the type of button clicked. An example is shown below:
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  if($Request->has('submit')){

      $Request->strict();
      $Formdata = $Request->data();

  }
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    In the above, assuming that our form has a button with the name "submit", then we can check if the data forwarded 
                                    has a "submit" key before setting the strict type or obtaining the data. Also notice, that the <code>strict()</code> method comes after the <code>has()</code> function.
                                    This is because setting the strict type affects the <code>has()</code> method too and prevents it from checking 
                                    any data if the token is not valid.
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            <div class="font-em-1 c-orange">Timing Request Data - Timed Token</div> 
                            <div class="mvs-10">
                                A request can be timed by using the <code>expires()</code> method. This tells the request the 
                                number of seconds required in order for a data to be sent. If a request data is not sent within the 
                                required number of seconds, the data sent is not accepted hence, it returns an empty array or displays error message. It should 
                                be noted that even if a <code>csrf</code> token has expired leading to an empty data, the
                                <code>has()</code> method will still allow the checking of data forwarded as long as the <code>strict()</code> method is not applied before it. 
                                However, unlike the <code>strict()</code> method, the <code>expires()</code> method alone  
                                has no effect on the <code>has()</code> method if used before it unless a <code>strict()</code> method is declared along with it. 
                                The example below is the best way to declare the strict type along with the <code>expires()</code> method:
                                <br><br>
<div class="pre-area">
    <pre class="pre-code">
  $Request = new Request;

  if($Request->has('submit')){

      $Request->strict()->expires(5);
      $Formdata = $Request->data();

  }
    </pre>
</div>       
                                <div class="font-em-d87 mvt-10">
                                    In the above, the csrf token expires in "5 seconds". This pushes the data to return empty data but because the strict method
                                    is set upon it, the request returns an error page if the token expires or becomes invalid.
                                </div>
                            </div>
                        </div> <br>

                        <div>
                            
                            <div id="data-validation" class="font-em-1d5 c-orange">Data Validation</div>  

                            <div class="mvs-10">
                                The first level of authentication encountered is the csrf token validation which determines if data forwarded is accepted 
                                or rejected. When data fowarded is accepted having passed through the first stage of csrf token validation successfully, then it proceeds
                                to validate each form input data required to be validated. This is done through a <code>Model</code> class. The <code>Model</code> class 
                                not only enables us to authenticate form data but it also allows us to save the data into the database. Other features of this class 
                                include input-column mapping which allows the form input name to properly select its relative database column field where the data is expected to 
                                be inserted. Consider the following Model class structure: 
                            </div>
<div class="pre-area">
    <pre class="pre-code">

  namespace spoova\mi\windows\Models;
  
  use spoova\mi\core\classes\Model;
  
  class Signup extends Model {
  
      protected $firstname;
      protected $lastname;
      protected $usermail;
      protected $password;

      public function __construct(){
  
          //your code here...
  
      }
  
      <span class="comment">/**
       * Validation rules
       *
       * @return array
       */</span>
      public function rules(): array {
  
          return [
              'firstname' => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2, SELF::RULE_MAX => 20],
              'lastname'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2, SELF::RULE_MAX => 20],
              'usermail'  => [SELF::RULE_REQUIRED, SELF::RULE_EMAIL]
              'password'  => [SELF::RULE_REQUIRED, SELF::RULE_MIN => 2]
          ];
  
      }
  
      <span class="comment">/**
       * Determines if a form authentication is completed 
       *
       * @return bool
       */</span>
      public static function isAuthenticated(): bool {
  
          return true; <span class="comment">//some validation test code is expected here.</span>
  
      }  

      <span class="comment">/**
       * set table name where data is inserted
       *
       * @return string
       */</span>
      public static function tablename(): string {
  
          return 'users'; <span class="comment">//default table name</span>

      }

      <span class="comment">/**
       * input field names mapped with relative database column name 
       *
       * @return string
       */</span>
      public static function mapform(): array {
  
          return [
              'usermail' => 'email',
              'password' => 'pass'
          ];
  
      }
  
  }
    </pre>
</div>
                            <div class="font-em-d87 mvt-10">

                                <p>
                                    The code above simulates a Signup model format that validates a firstname, lastname, usermail and password form field. 
                                    When a form request data is expected to be authenticated, each request data attribute expected to be authenticated 
                                    must be added as a property into the Model defined. This makes it easier for the Model class to pull out only needed data from 
                                    the request data. The following list explains each method and their functions
                                </p>
                                <p>
                                    <ul>
                                        <li>
                                            The <code>rules()</code> method defines the authentication needed for each field. The Model class ensures that only 
                                            defined authentication rules are applied on the relative property defined.
                                        </li>
                                        <li>
                                            The <code>mapform()</code> maps the input field names with their respective field names. For example, in the Model above,
                                            the request data attribute name of "usermail" will be mapped to "email" field in database. This means that if the input field 
                                            name sent in request is "usermail", when inserting data, the data will be inserted into the "email" field in the database table. 
                                            This makes it easier to protect database names. 
                                        </li>
                                        <li>
                                            The <code>tableName()</code> method is used to set a database table name where authenticated data is expected to be inserted.
                                        </li>
                                        <li>
                                            The <code>isAuthenticated()</code> method by default only returns true if all authentication rules applied to a form request are successfully passed and no 
                                            error was found. Redefining this method above in <code>Signup</code> provides an enviroment to apply more custom rules we require our form data to match. 
                                            For example, if all authentication rules applied was met by a request data, then the root <code>Model::isAuthenticated()</code> method will return true which means that 
                                            <code>Signup::isAuthenticated()</code> will also return true by default. However, if more 
                                            tests are done within the child <code>Signup::isAuthenticated()</code> above and the test fails, then <code>Signup::isAuthenticated()</code> will return false. 
                                            Note that in <code>Form</code> class, when <code>Form::isValidated()</code> is called, it automatically calls the <code>Signup::isAuthenticated()</code> method.
                                            This process is explained below
                                        </li>
                                    </ul>
                                </p>
                                
                            </div> <br>
                        </div>

                        <div>
                            <div class="font-em-1d5 c-orange">Data Processing</div> 

                            <div class="">
                                The <code>Form</code> class is used for further processing and submission request data after csrf validation. This class performs its internal 
                                validation using the instance of a Model class. Once the Model class is validated, then data can be submitted into the database table defined.
                                The sample of this is shown below: <br>
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  &lt;?php
    
    use spoova\mi\core\classes\Request;
    use Form;

    $Request = new Request;

    if($Request->has('submit')){

        $Request->strict();
        $Request->expires(30);

        Form::model(new Signup);

        Form::loadData($Request->data());

        <span class="c-lime-dd">(Form::isValidated() && Form::isSaved());</span>

    }

    $errors = Form::errors($inputErrors);
    
    </pre>
                            </div>                      
                            <div class="font-em-d87 mvt-10">
                                
                                <div class="">
                                    In few lines above we've been able to perform several operations such as checking for button submission,
                                    restricting invalid forms, validating form data and saving the data into database. This operation is explained in steps below
                                </div> <br>
                                <ul>
                                    <li><code>$Request->has('submit')</code>: This checks if the request data forwarded has a "submit" key</li>
                                    <li><code>$Request->strict()</code>: This ensures that an error page is shown if csrf token is rejected</li>
                                    <li><code>$Request->expires(30)</code>: This ensures the csrf token generated can only be valid for 30 second</li>
                                    <li><code>Form::model(new Signup)</code>: Sets up a model class used for form data authentication</li>
                                    <li><code>Form::loadData($Request->data())</code>: Sets data to validated by the form and the supplied model</li>
                                    <li><code>Form::isValidated()</code>: By default, this calls the <code>Signup::isAuthenticated()</code> method to check if data is valid</li>
                                    <li><code>Form::isSaved()</code>: This method saves data into the database.</li>
                                    <li>
                                        <code>Form::errors()</code>: This returns all errors encountered during data validation including those related with csrf token. When a variable is supplied, only errors relating to 
                                        form inputs will be saved into the variable.
                                    </li>
                                </ul>

                                <p>
                                    The <code>Signup</code> model defines the database table and columns the validated data is inserted in the database. In the above, 
                                    the request data returned by <code>$Request->data()</code> is loaded directly into 
                                    the <code>Form</code> class using <code>Form::loadData()</code> method. The <code>Form::isValidated()</code> will validate each property using their respective 
                                    keys defined within the model's <code>rule()</code> method and return <code>true</code> by default. If more custom tests are 
                                    done within the supplied model's <code>isAuthenticated()</code> method, this will further determine if the <code>Form::isAuthenticated()</code> will return a <code class="bd-f">true</code> or 
                                    <code class="bd-f">false</code> value. Lastly, the <code>Form::isSaved()</code> will try to save the data the database table "users" defined within the <code>tableName()</code> method of <code>Signup</code> model. 
                                    When an error occurs in the execution of these process, we can obtain the all errors using the <code>Form::errors()</code> method which allows us to fetch all required errors 
                                    depending on the stage where the error occurred. This method also makes it easier to fetch only errors that occur in input validation by supplying a variable e.g <code>$inputErrors</code>, which acts as reference
                                    for errors that occurs for a property when its specified validation rule is not passed.  
                                    To obtain the entire errors, the <code>Form::errors()</code> method returns the entire error that occured which may be from database connection, operation or input validation.
                                </p>

                                <p>
                                    Lastly, since the <code>Form::isAuthenticated()</code> can naturally call the model's <code>isAuthenticated()</code> method, we can easily add the <code>Form::isSaved()</code> into the 
                                    current model's <code>isAuthenticated()</code> method. Hence, The code line 
                                    <code>(Form::isValidated() && Form::isSaved())</code> can both be replaced with a single <code>Form::isAuthenticated()</code>. The <code>Signup</code> model's <code>isAuthenticated()</code> method 
                                    will resemble the format below:
                                </p>

                                <div class="pre-area">
                                    <pre class="pre-code">
   <span class="comment">/**
    * Determines if a form authentication is completed 
    *
    * @return bool
    */</span>
    public static function isAuthenticated(): bool {

        return Form::isSaved(); <span class="comment">//save and return true of data is saved</span>

    } 
                                    </pre>
                                </div>

                                <div class="mvs-10">
                                    The code line that manages the request will resemble the format below:
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
  &lt;?php
    
    use spoova\mi\core\classes\Request;
    use Form;

    $Request = new Request;

    if($Request->has('submit')){

        $Request->strict();
        $Request->expires(30);

        Form::model(new Signup);

        Form::loadData($Request->data());

        <span class="c-lime-dd">if(Form::isAuthenticated()) {</span>
            
            if(Form::errors()) var_dump(Form::errors);

        <span class="c-lime-dd">}</span>
    }

    $errors = Form::errors($inputErrors);
    
    </pre>
                            </div>                              
                            </div> 
                        </div> <br>

                        <div>
                            <div id="form-rules" class="font-em-1d5 c-orange">Model Form Rules</div>  

                            <div class="">
                                There are several rules that can be applied for form input validation in a model class <code>rules()</code> method. Once these rules are defined within a Model, the model uses such rules 
                                to validate form inputs based on their attributes. The following rules can be applied on form inputs:
                            </div> <br>
                            <div class="pre-area">
    <pre class="pre-code">
  RULE_REQUIRED  <span class="comment">// Defines an attribute that must be filled</span>
  
  RULE_NOSPACE  <span class="comment">// Defines an attribute that cannot contain spaces</span>
  
  RULE_TEXT  <span class="comment">// Defines an attribute that can only contain alphabets</span>
  
  RULE_MIN  <span class="comment">// Sets a minimum length of characters accepted on a form input</span>
  
  RULE_MAX  <span class="comment">// Sets a maximun length of characters accepted on a form input</span>
  
  RULE_UNIQUE  <span class="comment">// Sets an attribute that must not exist more than once in the database</span>
  
  RULE_MATCHES  <span class="comment">// Sets an attribute that must match another attribute and must not be empty</span>
  
  RULE_EMAIL  <span class="comment">// Defines an attribute and must be of email format</span>
  
  RULE_NOT  <span class="comment">// Defines an attribute that must not be exactly the same as another form attribute(s) value(s)</span>
  
  RULE_UNLIKE  <span class="comment">// Defines an attribute that must not look like another attribute(s) whose names must be set</span>
  
  RULE_NUMBER  <span class="comment">// Defines an attribute that must be numeric</span>
  
  RULE_INTEGER  <span class="comment">// Defines an attribute that must be a valid integer</span>

  RULE_PHONE  <span class="comment">// Defines an attribute that must have a phone numer format</span>
  
  RULE_URL  <span class="comment">// Defines an attribute that must have a url address format</span>
  
  RULE_RANGE  <span class="comment">// Defines an attribute that must have its value within a specified range or list only</span> 

  RULE_NOT_CHARS  <span class="comment">// Defines an attribute that must not have a character exisiting in a list of defined characters that is set</span>       

</pre>
</div>                      

                            <div class="foot-note">A sample rule returned by a model is shown below</div>

                            <div class="pre-area">
                                <pre class="pre-code">
    ... 

    public function rules(): array {

      return  [

        'field1' => [
             
            SELF::RULE_REQUIRED,    <span class="comment">// field is required</span>

            SELF::RULE_NOSPACE,     <span class="comment">// allow no space character</span>

            SELF::RULE_TEXT,        <span class="comment">// allow only alphabets [A-Z]</span>

            SELF::RULE_MIN => '10', <span class="comment">// allow only a minimum of 10 characters</span>

            SELF::RULE_MAX => '12', <span class="comment">// allow only a maximum of 12 characters</span>

            SELF::RULE_UNIQUE,      <span class="comment">// value must not exist more than once in database</span>

            SELF::RULE_EMAIL,       <span class="comment">//value must resemble email format</span>

            SELF::RULE_PHONE,       <span class="comment">//value must resemble phone number format</span>

            SELF::RULE_NUMBER       <span class="comment">//value must be a numeric value</span>

            SELF::RULE_URL          <span class="comment">//value should be a url format</span>

            SELF::RULE_MATCH => 'field2', <span class="comment">// field1 value must match field2 value</span>

            SELF::RULE_UNLIKE  => ['field3', 'field4'], <span class="comment">// field must not resemble field3 and field4</span>
            
            SELF::RULE_NOT_CHARS  => ['*', ':'], <span class="comment">// value must not contain character <code>*</code> and <code>:</code></span>
            
            SELF::RULE_RANGE  => ['yes', 'no'], <span class="comment">// value must be within the range of options <code>yes</code> or <code>no</code></span>
            
            SELF::RULE_PATTERN  => "A-Za-z0-9", <span class="comment">// value must match the specified pattern
                
                ]

      ];

    }
                                </pre>
                            </div>

                        </div><br>

                        <div>
                            <div  id="managing-errors" class="font-em-1d5 c-orange">Managing Errors</div>

                            <div class="">

                                <div class="pvs-10">
                                    Errors management include error modification through custom ways and error fetching. Errors returned by the <code>Form</code> class are classified 
                                    into four forms: 
                                </div>
                                <ul>
                                    <li>CSRF errors</li>
                                    <li>Input errors</li>
                                    <li>Database errors</li>
                                    <li>Custom errors</li>
                                </ul>
                                <div class="pvb-10">
                                    The last type of error is defined through a flash message:
                                </div>
                                <ul>
                                    <li>User id error notice</li>
                                </ul>
                            </div>

                            <div>
                                <div class="font-em-1 c-orange pvs-2">CSRF Errors</div>  
                                <div class="mvs-10">
                                    Csrf errors are errors that are returned when a token is not valid. These errors are returned by the <code>Form::errors()</code> into an array 
                                    key specified as <code>:csrf</code> which contains only two subkeys <code>title</code> and <code>info</code> which contains the type of error and 
                                    the description of that error respectively. The <code>title</code> and <code>info</code> returned is determined by the kind of error that occured. 
                                    Under this subheading, errors are classified as default, invalid and session. When a token is missing, a default error is returned. When a token does not 
                                    match an invalid error is returned while the session error only returnes when a token has expired. In order to access the <code>:csrf</code> errors, an 
                                    helper function <code>error()</code> makes this easy shown below:
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error(':csrf', 'title'); <span class="comment">// return the csrf last error title</span> 
    error(':csrf', 'info');  <span class="comment">// return the csrf last error info</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    Remember that error displayed are determined on the type of error that occured. Also, the error returned for 
                                    each type can be customized as revealed below:
                                </div> <br>
                                <div class="pre-area">
    <pre class="pre-code">
&lt;?php
    
    use spoova\mi\core\classes\Request;
    use Form;
    use Csrf;

    $Request = new Request;

    if($Request->has('submit')){

        Csrf::setError('default', 'csrf request failed');   <span class="comment">// set title for default</span>
        Csrf::setError('invalid', 'csrf token mismatched'); <span class="comment">// set title for invalid</span>
        Csrf::setError('session', 'csrf session expired');  <span class="comment">// set title for expired csrf</span>

        Csrf::setError('default', ['title' => 'some title', 'info' => 'some info']);<span class="comment">// set title and info using array</span>

        $Request->strict()->expires(5);

        Form::loadData($Request->data());

        (Form::isValidated() && Form::isSaved());

    }

    $errors = Form::errors();      <span class="comment">//return all errors</span> 

    print_r($errors[':csrf']);     <span class="comment">// return only csrf last error (both title and info)</span> 
    print_r(errors(':csrf'));      <span class="comment">// same as above</span> 

    print error(':csrf', 'title'); <span class="comment">// return only csrf last error title</span> 
    print error(':csrf', 'info');  <span class="comment">// return only csrf last error info</span> 
    
    </pre>
                                </div>
                                                                                    
                                <div class="font-em-d87 mvt-10">
                                    In the above, we successfully modified our error to a new message. The second argument of <code>Csrf::setError()</code> sets a custom  error message. 
                                    Also, The <code>error()</code> helper function in the above only returns the title or info for the type of error that occured.
                                </div>
                                
                            </div> <br>

                            <div>
                                <div class="font-em-1 c-orange">Input Errors</div>  
                                <div class="mvs-10">
                                    Input errors occurs when form input validation fails. These errors are also stored within the form errors and can be accessed 
                                    using the relative attribute's name. The <code>error()</code> helper function only returns the first error encountered by each attribute, that is 
                                    , the topmost error index. An example of this is shown below:
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error('username'); <span class="comment">// return first error encountered for a username field</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                   The equivalent of the <code>error()</code> function is the <code>@(@error())@</code> template directive. When no errors exists for the defined 
                                   attribute <code>error()</code> function just returns empty without throwing any errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Database Errors</div>  
                                <div class="mvs-10">
                                    Database errors occurs when database operation fails due to one reason or the other. This could prevent saving of data into database. The 
                                    <code>Form::error()</code> also allows fetching of these errors using reserved key names such as <code>:dbi</code>, <code>:dbe</code> and <code>:dbm</code>
                                    The named keys can be supplied into <code>error()</code> to obtain their respective values.
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    error(':dbm'); <span class="comment">// something is wrong</span> 
    error(':dbe'); <span class="comment">// database error: something is wrong</span> 
    error(':dbi'); <span class="comment">// sql error (fully stated accoring to type of error)</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    The <code>:dbi</code> is the only key that displays the type of database error that occurred. Other keys are just a shorthened form of message to keep the message 
                                    simple and easy to read. In template engines, the <code>@(error())@</code> directive can be used to obtain these errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Custom Errors</div>  
                                <div class="mvs-10">
                                    Custom errors are errors that are defined using te <code>Form::setError()</code> method. This method 
                                    stores the last defined error into an array key <code>":mod"</code>. Hence, by calling the <code>error(':mod')</code> 
                                    function, we can retrieve the last defined error. Example is shown below: <br>
                                </div>

                                <div class="pre-area">
    <pre class="pre-code">
    &lt;?php
    
    Form::setError('something is wrong');

    print error(':mod'); <span class="comment no-select">// something is wrong</span> 
    
    </pre>
                                </div>

                                <div class="font-em-d87 mvt-10">
                                    The <code>:dbi</code> is the only key that displays the type of database error that occurred. Other keys are just a shorthened form of message to keep the message 
                                    simple and easy to read. In template engines, the <code>@(error())@</code> directive can be used to obtain these errors.
                                </div>

                            </div><br>

                            <div>
                                <div class="font-em-1 c-orange">Session user id error notice</div>  
                                <div class="mvs-10">
                                    The <span class="teal">Session</span> class security system ensures that a fake user id is not authenticated. In the <code>core/init</code> file, we define 
                                    the user id column name under the key "USER_ID_FIELDNAME" where the user id of the current session user is expected to be found. Assuming a user session id was roughly 
                                    set which does not exist in the column "USER_ID_FIELDNAME" of the "USER_TABLE_NAME" defined, such an invalid id will be nullified. 
                                    This means that if the user id detected does not exist in the configured column, then even if a session id is faked, because that id does not exist 
                                    in the database, such session will automatically be rejected. This behaviour only works under a secured session. 
                                    Once a session is nullified, a flash message is usually stored with the reserved key <code>":user-error"</code>. This means 
                                    that if we call the function <code>flash(':user-error')</code> immediately the session is nullified, we will get a response of 
                                    <span class="span-btn bc-silver pxv-6 rad-2 c-red-dd font-em-d8">User error: user id mismatch</span> . This behaviour makes it easier to understand why a 
                                    session was nullified even if a session id was supplied. 
                                </div>                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

@template;