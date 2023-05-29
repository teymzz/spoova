@template('template.t-tut')

    @title('models')

    @lay('build.co.navbars:left-nav')


   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Models </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
                            @post.me[firstname][lastname]
                            <div class="bi"> <span class="bi-circle"></span> Model Class </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            The <code>Model</code> class has been improved with new methods which are <code>id()</code>, <code>insertID()</code> and 
                            <code>connection()</code>. The <code>insertID()</code> returns the insertion id generated when data is inserted to the database. The 
                            <code>id()</code> method returns the <code>id</code> value of an inserted data that is equivalent to the defined id database table column's 
                            name. The <code>connection()</code> method returns the current database connection instance. Since the <code>Form</code> class are used along 
                            with model class, each of these methods can be statistically called on the <code>Form</code> class (e.g Form::id()). 
                        </div>
                    </div> <br>

                    <div class="font-em-d8">
                      The model below will be used as a reference to explain the function of these methods 
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-orange-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> SignupModel (sample) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Model;

class SignupModel { 

    public $firstname;
    public $lastname;
    public $username;
    public $password;

    function rules() : array {

        return [
          
          'firstname' => [SELF::REQUIRED],
          'lastname'  => [SELF::REQUIRED],
          'username'  => [SELF::REQUIRED, SELF::MIN => '5'],
          'password'  => [SELF::REQUIRED, SELF::MIN => '8'],

        ];

    }

    function isAuthenticated() : bool {

        <span class="comment">//get request password</span>
        $password = Form::datakey('password');
        
        <span class="comment">//get request password hash</span>
        $passHash = password_hash($password, PASSWORD_DEFAULT); <span class="comment"></span>

        <span class="comment">//save data into database by overwriting request password with hashed value</span>
        return Form::isSaved([ 'password' => $passHash ]);

    }

}
    </pre>
                                </div>
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Model: id() </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            The Model's <code>id()</code> method returns the id of a user by either searching for the configured USER_ID_FIELDNAME 
                            in the request data list or the last inserted database id. Assuming that we have the USER_ID_FIELDNAME field configured as "username" in the 
                            "icore/init" file, In order to register a user into database when a form is submitted, a similar procedure 
                            like the approach below will employed

                            <div class="pre-area bc-white mvs-20">
    <pre class="pre-code">
    namespace spoova/mi/windows/Routes;

    use User;

    class Signup extends Windows { 

        function __construct(Request $Request) {

        if($Request->isPost()) {

            $SignupModel = new SignupModel;

            Form::model($SignupModel); <span class="comment">//set model</span> 

            Form::loadData( $Request->data() );

            if( Form::isAuthenticated() ) { 
                
                <span class="comment">//fetch username from saved data</span>
                $userid = $SignupModel->id(); 

                <span class="comment">//create a new session using userid</span>
                User::login(['userid' => $userid]);

            }


        }



        }

    }
    </pre>
                            </div>

                            <div class="">
                                We can equally shorten this process and make it more concise by 
                                accessing the Form class model's id either by <code>Form::model()->id()</code> 
                                or better still <code>Form::id()</code>. 
                            </div>
                            <div class="pre-area bc-white mvs-20">
    <pre class="pre-code">
    namespace spoova/mi/windows/Routes;

    use User;

    class Signup extends Windows { 

        function __construct(Request $Request) {

        if($Request->isPost()) {

            Form::model(new SignupModel); <span class="comment">//set model</span> 

            Form::loadData( $Request->data() );

            if( Form::isAuthenticated() ) {  

                <span class="comment">//create a new session using userid</span>
                User::login(['userid' => Form::id()]);

            }


        }



        }

    }
    </pre>
                            </div>
                            <div class="">
                                In the examples above, the model to be used is 
                                declared into the <code>Form</code> class using <code>Form::model()</code>. The 
                                request data is loaded for validation into the Form class using the <code>Form::loadData()</code> 
                                method. By default, the <code>Form::isAuthenticated()</code> returns true only if the required request data 
                                are successfully validated. However, this method is also capable of calling the supplied model's "isAuthenticated()" 
                                method. By making use of this advantage, we can save the form into the database using the <code>Form::isSaved()</code> method within the 
                                declared model's, that is, <code>SignupModel->isAuthenticated()</code>
                                method. This means that <code>Form::isAuthenticated()</code> will both authenticate the request data and also try to save them 
                                into database if authentication was successful. The <code>Form::id()</code> method which is relative to the Model's <code>id()</code> 
                                method will either return the configured USER_ID_FIELDNAME value found in request data or the autogenerated last inserted id.
                            </div>
                        
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Model: insertID() </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            The model's <code>insertID()</code> method is only used to obtain the last inserted id of a data inserted into the database table. This is useful in 
                            situations where the last inserted id is required even if the configured USER_ID_FIELDNAME exists as a different key in the request data.
                            
                            <div class="pre-area bc-white mvs-20">
                                <pre class="pre-code">
    namespace spoova/mi/windows/Routes;

    use User;

    class Signup extends Windows { 

        function __construct(Request $Request) {

        if($Request->isPost()) {

            Form::model(new SignupModel); <span class="comment">//set model</span> 

            Form::loadData( $Request->data() );

            if( Form::isAuthenticated() ) {  

                <span class="comment">//fetch last inserted id if it exists.</span>
                $insertID = Form::model()->insertID();

                <span class="comment">//create a new session using userid</span>
                User::login(['userid' => Form::id()]);

            }


        }



        }

    }
                                </pre>
                            </div>

                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Model: connection() </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            The model's <code>connection()</code>, also <code>Form::connection()</code> returns the current database handler connection used by the model.
                            
                            <div class="pre-area bc-white mvs-20">
                                <pre class="pre-code">
    namespace spoova/mi/windows/Routes;

    use User;

    class Signup extends Windows { 

        function __construct(Request $Request) {

            if($Request->isPost()) {

                Form::model(new SignupModel); <span class="comment">//set model</span> 

                vdump(Form::connection()); <span class="comment">//fetch current connection</span>

            }

        }

    }
                                </pre>
                            </div>

                        </div>
                    </div> <br>

                </div>
           </div>
       </section>
   </div>

@template;