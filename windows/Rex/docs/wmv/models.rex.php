@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Window Models</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Models are classes that help to communicate with database. The spoova <code>Model</code> class is however build 
                            to perform two main functions which are data validation and data insertion. All other ORM functionalities 
                            such as reading and deleting from database are currently under development and some of these features might not be 
                            available for use at the moment. Currently, the <code>Model</code> class is used to validat and upload submitted request form data. 
                            Since most of the Model class features are form related, you can learn more about forms from <a href="@domurl('docs/forms')">here</a>.
                            The following are some of the methods of <code>Model</code> class and their functions some of which are also integerated with the <a href="@domurl('docs/forms')">Form</a> class.
                        </div> 
                    </div>
                    
                    <div class=""> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> Model Methods </div>
                        <div class="flex mid">
                            <span class="bi-chevron-double-right"></span>
                        </div>
                        </div> <br>

                        <div class="">
                            <ul class="mvt-10">
                                <li><a href=""><span class="c-orange-dd">loadData</span></a></li>
                                <li><a href=""><span class="c-orange-dd">loadedData</span></a></li>
                                <li><a href=""><span class="c-orange-dd">rules</span></a></li>
                                <li><a href=""><span class="c-orange-dd">validated</span></a></li>
                                <li><a href=""><span class="c-orange-dd">setError</span></a></li>
                                <li><a href=""><span class="c-orange-dd">error</span></a></li>
                                <li><a href=""><span class="c-orange-dd">errorIndex</span></a></li>
                                <li><a href=""><span class="c-orange-dd">formdata</span></a></li>
                                <li><a href=""><span class="c-orange-dd">dataupdate</span></a></li>
                                <li><a href=""><span class="c-orange-dd">saved</span></a></li>
                                <li><a href=""><span class="c-orange-dd">isAuthenticated</span></a></li>
                                <li><a href=""><span class="c-orange-dd">mapform</span></a></li>
                            </ul>

                            <div class="pxs-14">
                                <span id="loadData"></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> loadData </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        
                                        This method is used to load a submitted form data into a model class. An example of usage is shown 
                                        below: <br>


                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">File - SampleModel.php</div>
 <pre class="pre-code">

  namespace teymzz\spoova\window\Models;

  use Model;

  class SampleModel extends Model {

    function __construct() {

    }

  }
 </pre>
                                        </div> <br>

                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">File - Home.php</div>
 <pre class="pre-code">
  namespace windows\Routes;

  use teymzz\spoova\windows\Models\SampleModel;
  use teymzz\spoova\core\classes\Request;

  class Home extends Window {

    function __construct() {

        $Request =  new Request;
        $Model   =  new SampleModel;
      
        if( $Request->isPost() ) {
      
            $Model->loadData($Request->data()); <span class="comment">//load form data into model class</span>
      
        }
        
    }

  }
 </pre>
                                        </div> <br>
                                        <div class="foot-note">
                                            In the example above, once a post request is sent in <code>Home</code> url and the form data is submitted, the 
                                            <code>Home.php</code> route class will load the data into the model class. The data can then be processed 
                                            based on its required use. 
                                        </div>

                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="loadData"></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> loadedData
                                     </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        
                                        The method <code>"loadedData()"</code> is used to retrieve the data supplied into a model class through the <code>laodData</code> 
                                        method. <br>
                                    </div> 
                                </div>
                            </div><br>

                            <div id="rules" class="pxs-14">
                                <span id="rules"></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> rules </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The method is used set a list of form rules which a model class must use to 
                                        authenticate data supplied or loaded within it. Each data key to be validated must have a similar 
                                        property name within the model class. The model will then try to validate each data key by using its 
                                        corresponding property name. The rules method ensures that each form data key is validated through its list of 
                                        validation rules defined for each key.<br> These rules are discussed in <a href="@domurl('docs/forms#form-rules')">Form rules</a>
                                    </div> 
                                </div>
                            </div><br>

                            <div id="validated" class="pxs-14">
                                <span id=""></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> validated </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        This method is used to initialize the data validation. It can only be called when two operations have be successfully satisfied. 
                                        These operation includes loading of data and setting of data validation rules. In example "Home.php" above we can validate the 
                                        data supplied in the following ways:
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">Home.php</div>
 <pre class="pre-code">
 namespace windows\Routes;

 use teymzz\spoova\windows\Models\SampleModel;
 use teymzz\spoova\core\classes\Request;
 
 class Home extends Window {
 
   function __construct() {
 
       $Request =  new Request;
       $Model   =  new SampleModel;
     
       if( $Request->isPost() ) {
     
           $Model->loadData($Request->data()); 
           
           if($Model->validate()) {
             
             <span class="comment">//data validated successfully</span>
 
           }else {
             
             print_r($Model->errors());
             
           }
     
       }
       
   }
   
 }
 </pre>
                                        </div> <br>

                                        <div class="foot-note">
                                            In the above when the <code>$Model->validate()</code> is called, the entire loaded data will be validated. If all 
                                            validation was successful, then the <code>$Model->validate()</code> method will return true else it will return false.
                                            If any error occurs, the error will be returned by the <code>error()</code> method. 
                                        </div>

                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="error"></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> error </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The <code>error()</code> method as revealed in the previous example, returns the error messages encountered after validating 
                                        each data key. The error returned on each data key is determined by the order of validation rules applied on the corresponding 
                                        value of that key.
                                        <br>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="seterror"></span>
                                <div class="">
                                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                        <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> setError </div>
                                    </div>
                                    <div class="desc mvt-10">
                                        The <code>setError()</code> method is used to set custom errors. The custom errors are usually stored under the array index key 
                                        <code>:mod</code>. This method takes two arguments of key and value pairs where the first argument is the error name (or key) while the 
                                        second argument is the error message. When we call the <code>error()</code> method, the custom messages can be obtained by first calling the array key <code>:mod</code> along with the 
                                        defined message key. Using <code class="calibri">$Model->error()</code> in the earlier code samples, we can obtain  custom errors as shown below.

                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">Home.php</div>
 <pre class="pre-code">
 namespace windows\Routes;

 use teymzz\spoova\windows\Models\SampleModel;
 use teymzz\spoova\core\classes\Request;
 
 class Home extends Window {
 
   function __construct() {
 
       $Request =  new Request;
       $Model   =  new SampleModel;
     
       if( $Request->isPost() ) {
     
           $Model->loadData($Request->data()); 
           
           if($Model->validate()) {
             
             <span class="comment">//data validated successfully</span>
 
           }else {

             $Model->setError('someError', 'validation failed!');
             
             $modelErrors = $Model->errors();
             $customErrors = $modelErrors[':mod'] ?? [];

             var_dump($customErrors); <span class="comment">// ['someError' => 'validation failed!'] </span>
             
           }
     
       }
       
   }
   
 }
 </pre>
                                        </div> <br>     
                                        
                                        <div class="foot-note">
                                            Although, the example above may not be realistic enough, it simply explains 
                                            how the <code>setError</code> and <code>error</code> works together
                                        </div>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="errorindex"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> errorIndex </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        This method returns the first error message encountered after requested data's validation fails.
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="formdata"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> formdata </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        Since each request data contains a data key and its corresponding value, whenever a request data is loaded into the model class, 
                                        the model will match the keys of data supplied with the model class property. Only keys having a similar property name will be
                                        returned as an array list by the <code>formdata()</code> method.
                                        <br>
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="dataupdate"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> dataUpdate </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        A loaded data can be updated with the <code>dataUpdate()</code> method. This is usually done by supplying an array with the data key 
                                        and value pairs of data keys that are needed to be updated.
                                    </div>
                                </div>
                            </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="tablename"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> tablename </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The method <code>tableName()</code> is used to return a string of the database table name where database operations are expected to be performed.
                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">                        
                                <span id="saved"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> Saved </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The <code>saved()</code> method is usually used to save a data into a database table. It returns true if a data is succesfully saved into the 
                                        database. This method is also capable of updating database values immediately before they are inserted into the database fields. Without any lasting 
                                        modification of the real loaded data. In order to do this, the first argument must be an array of keys (column name) and value pairs.                         
                                    </div>
                                </div>
                            </div><br>

                            <div class="pxs-14">                        
                                <span id="isauthenticated"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> isAuthenticated </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        This method by default returns <code>true</code> if data validation is successful and no errors are found.                         
                                    </div>
                                </div>
                            </div><br>

                            <div class="pxs-14">                        
                                <span id="mapform"></span>
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle-fill mxr-8 c-lime-dd"></span> mapform </div>
                                </div>
                                <div class="">
                                    <div class="desc mvt-10">
                                        The <code class="calibri">mapform</code> method is used to modify requested data column names. This is usually applicable in situations where 
                                        form input data are submitted as the request data. At times, we may need to keep database table field names private because using the same form input name 
                                        as database column names may not be advisable due to security issues. The <code>mapform</code> ensures that we can map database columns to html input forms. 
                                        This method returns an array list of key and value pairs where the <code>key</code> is the form input's name and the <code>value</code> is the corresponding 
                                        database field name. This means that value submitted into an html form input's field will be inserted into the relative column name defined.                         
                                    </div>
                                </div>
                            </div><br>

                        </div>
                        
                
                    </div>  

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;