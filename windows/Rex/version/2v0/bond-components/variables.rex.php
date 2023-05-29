

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - variables') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond variables </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Pass Variables</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              Bond components are capable of accessing direct template variables when they are passed into the 
                              bond directive. The bond component controller must however have a public property with the supplied variable name 
                              in order to be able to access the variable. When the template is rendering, the variables passed will be rendered along with the 
                              bond component.
                            </div> <br>

                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  @(bond('Posts', [ 'name' => 'foo' ]))@
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{

    public $name;

    public function render(): Compiler|String {

      return &lt;&lt;&lt;compile
      &lt;div&gt; 

        @({{ $name }})@ <span class="comment no-select">//foo</span>

      &lt;/div&gt;
      compile;

    }


  }  
                              </pre>
                            </div> 

                        </div><br>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Overide Pass Variables</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              When varibles are passed, they can be overidden from the bond component controller 
                              by setting the value of the relative public property.
                            </div> <br>

                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  @(bond('Posts', [ 'name' => 'foo' ]))@
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{

    public $name = 'bar';

    public function render(): Compiler|String {

      return &lt;&lt;&lt;compile
      &lt;div&gt; 

        @({{ $name }})@ <span class="comment no-select">//bar</span>

      &lt;/div&gt;
      compile;

    }


  }  
                              </pre>
                            </div> 

                        </div><br>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Default Variables </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              It is not mandated to pass variables only from the directive, we can also set 
                              default values from the bond component controller. These will be rendered along with the 
                              main template file.
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

    public $name = "foo";

    public function render(): Compiler|String {

      return &lt;&lt;&lt;compile
      &lt;div&gt;
      
        @({{ $name }})@ <span class="comment no-select">//foo</span>
      
      &lt;/div&gt;
      compile;

    }


  }
                              </pre>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Inherit Variables </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              Variable are automatically inherited when they are passed from main compiler engine and it is not 
                              essential to re-parse them in bond directives even when it is possible. 
                            </div> <br>
                            <div class="pre-area bc-white">
                              <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes;

  use Window;

  class Home extends Window{

    public function root() {

      self::load('rex-template', fn() => compile(['name' => 'foo']) );

    }


  }
                              </pre>
                            </div>
                            <br>
                            <div class="pre-area bc-white">
                              <div class="pxv-4 bc-silver">rex-template</div>
                              <pre class="pre-code">
  @(bond('Posts'))@
                              </pre>
                            </div>

                            <div class="pre-area bc-white">
                              <div class="pxv-4 bc-silver">bond controller</div>
                              <pre class="pre-code">
  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{

    public function render(): Compiler|String {

      return compile('bond-component', fn() => compile());

    }


  }
                              </pre>
                            </div>

                            <div class="pre-area bc-white">
                              <div class="pxv-4 bc-silver">bond-component</div>
                              <pre class="pre-code">
  &lt;div&gt;
  The name is @({{ $name }})@
  &lt;/div&gt;
                              </pre>
                            </div>

                            <div class="">
                              In the sample above, the bond component will inherit the parent compiler 
                              variables without having to pass the variable into the bond directive unless 
                              it is overridden by a public property.
                            </div> <br>
                            
                        </div>
                    </div>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span>Bond components</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/life-events')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Life events<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 