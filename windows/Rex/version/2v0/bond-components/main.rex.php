

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
    
                            <div class="bi"> <span class="bi-circle"></span> Installing Bond Script </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              The bond component resource handlers comes with version 2.0. The bond components are handled internally, however, the bond scripts are not 
                              loaded by default. Along with other core static files, the bond script is added to the resource controller file and can be loaded into the 
                              rex template file by using the <code>@(@load('bond'))@</code> directive. This will include the bond script into the template file and we can 
                              start to work with bond components. A sample is shown below
                            </div>
                            <br>
                          
                            <div class="pre-area bc-white">
                              <pre class="pre-code">
  @(
    @template('sample')

      @load('bond')

    @template;
  )@
                              </pre>
                            </div>
                            <div class="mvs-10">
                              Using the sample above as reference, while the <code class="bd-f">@template</code> directive 
                              loads an external template, the <code class="bd-f">@load</code> directive will load the bond scripts 
                              into the template file. Once we load the bond script, we can then continue with initializing the bond 
                              components.
                            </div> <br>
                            
                        </div>
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


                    <div class="font-em-d85 mvs-10">
                        <div class="box">Next</div> 
                        <div class="box">
                            <a href="@route('::variables')" class="flex-btn mid rad-r bc-dodger-blue-dd font-em-d85" style="color:white">
                            variables
                            <span class="bi-arrow-right"></span>
                            </a>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 