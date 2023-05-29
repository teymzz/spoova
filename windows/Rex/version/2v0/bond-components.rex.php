

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond components </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Bond Components </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            The bond components are bond template files that are rendered into rex template files through the main bond directive <code>@(bond())@</code>. The 
                            first argument of this directive is used to call a bond component controller from the <code>spoova/mi/windows/Bond</code> namespace. Once called,
                            the bond component controller will determine how bond components are rendered into the webpage. Bond componnents are added separately into a reserved 
                            directory "windows/Rex/Bond" where they can be rendered before being added to the web page. The main feature of bond component is that they have 
                            extended functionality of rendering live templates using bond live template attributes.
                        </div><br>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Initializing Bond Components </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              Bond components components can be intialized by adding the bond directive <code>@(bond())@</code> to the rex template file similarly as below: 
                            </div>
                            <br>
                            <div class="pre-area bc-white">
                              <pre class="pre-code">
  @(bond('Posts'))@
                              </pre>
                            </div>
                            <div class="pre-area bc-white">
                              <pre class="pre-code">
  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{


    public function render(): Compiler|String {

      return &lt;&lt;&lt;compile
      &lt;div&gt;Hello World!&lt;/div&gt;
      compile;

    }


  }
                              </pre>
                            </div>
                            <div class="mvs-10">
                              Using the sample above as reference, assuming we added the directive <code>@(bond('Posts'))@</code> to our template file. The 
                              directive will in turn call the bond component controller <code>spoova/mi/windows/Bond/Posts</code>. This will render the page 
                              and return the text <span class="c-orange-dd">"Hello world!"</span> .
                            </div> <br>
                            <div class="mvb-10">
                              We can also return a compiler object through the render method as shown below :
                            </div>

                            <div class="">
                              <div class="">
                                <div class="pre-area bc-white">
                                  <pre class="pre-code">
  &lt;php?

  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{

    function render() : Compiler|String {

      return compile('bond.template_path');

    }

  }
                                  </pre>
                                </div>                                
                              </div>
                              <div class="">
                                <div class="pxv-10 bc-silver font-em-d8">window/Rex/bond/template_path</div>
                                <div class="pre-area bc-white">
                                  <pre class="pre-code">
  &lt;div&gt;
    Hello world!
  &lt;/div&gt;
                                  </pre>
                                </div>                                
                              </div>
                                
                              <div class="">                                
                                  <span class="c-orange-dd">Note:</span> It is important to keep bond components in a separate subdirectory of the <code>windows/Rex</code> 
                                  directory so as to prevent conflicting of files and to make it easier to locate them. Also, all bond component must have a root element
                              </div>
                            </div> <br>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Working with live templates</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            Live bond components are components that are re-rendered back into a page when an activity or a trigger event occurs. 
                            The easiest way declare a bond component as live component is by the use of live event triggers. These event triggers define 
                            an activity which must occur before a template is re-rendered back to the page. The following are lists of live event triggers: 
                            <br><br>

                            <div class="bc-white pxv-6">
                              <code class="bd-f">bond:load</code> This attribute is used to declare that an activity must be called as soon as the page loads. This also 
                              means that a request will be sent immediately a page is loaded. 
                            </div>

                            <div class="bc-white pxv-6 mvt-4">
                              <code class="bd-f">bond:click</code> This attribute declares that an activity must be called only when an element is clicked upon. 
                            </div>

                            <div class="bc-white pxv-6 mvt-4">
                              <code class="bd-f">bond:mouseover</code> This attribute declares that an activity must be called only when an element is hovered upon. This 
                              may generated a continuous request. 
                            </div>

                            <div class="bc-white pxv-6 mvt-4">
                              <code class="bd-f">bond:keypress</code> This attribute declares that an activity must be called only when a key is pressed down while on an input field. 
                            </div>
                            
                            <div class="mvs-10">
                              The introduction of any of these live events attributes into a bond component element will be responsible for declaring the element as a live component trigger.  
                            </div>
                          </div><br>

                          <div class="">
                            Assuming we have a bond controller as below:
                          </div>
                          <div class="pre-area bc-white mvt-10">
                            <div class="bc-silver pxv-10 hide">Bond Controller (spoova/mi/windows/Bond/Posts)</div>           
    <pre class="pre-code">
  &lt;?php 
  
  namespace spoova/mi/windows/Bond;

  use spoova/mi/windows/core/classes/Bond;

  class Number extends Bond{

    public $number = 0;

    function render() : Compiler|String {

      return compile('bondTemplate');

    }

    function increase() {

      $his->number++;

    }

  }
    </pre>
                          </div>
                          <div class="pre-area bc-white mvt-2">
    <pre class="pre-code">
    &lt;div&gt;
      Click button to increase number  
      &lt;button bond:load="increase"&gt; @({{ $number }})@ &lt;/button&gt;
    &lt;/div&gt;
    </pre>
                          </div>

                          <div class="mvs-10">
                            Since, we are rendering from a bond template <code>bond.template_path</code>, we can define our live element 
                            from the bond template as shown below:
                          </div>

                          <div class="pre-area bc-white">
                            <div class="bc-silver pxv-10">windows/Rex/bond/template_path</div>
    <pre class="pre-code">
  &lt;div @(bond:load="delete_posts")@&gt; &lt;/div&gt;
    </pre>
                          </div>
                          
                          <div class="mvs-10">
                            The directive <code>@(bond:load)@</code> will ensure that a request is sent once the page is loaded to call the 
                            <code>delete_posts()</code> method of the Posts bond controller. There is however, one thing left to do. We need to 
                            call the Post bond controller using the bond directive in our main rex file
                          </div>
                          <div class="pre-area bc-white">
                            <div class="bc-silver pxv-10">
                              Sample - main rex file. 
                            </div>
    <pre class="pre-code">
  @(bond('Posts'))@
    </pre>
                          </div>  

                          <div class="mvs-10">
                            In the examples above, once the bond controller <code>Posts</code> is invoked from the main rex file, the <code>Posts</code> 
                            will in turn invoke it's <code>render()</code> method which will compile the bond template by calling the <code>delete_posts()</code> 
                            method. The response obtained after <code>delete_posts()</code> is called will be returned back through the <code>render()</code> 
                            method but only contents within the <code>div</code> element gets modified  
                          </div>                          
                          
                        </div>
                          <div class="pre-area bc-white">
    <pre class="pre-code">
 &lt;div @(bond:load="")@&gt; &lt;/div&gt;
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