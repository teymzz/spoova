

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - counter') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond Live Counter </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Live counter</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            A click counter can be generated easily by using the <code>bond:click</code> attribute in the bond component as below:
                            <br><br>
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  @(bond('Posts'))@
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;?php
  
  namespace spoova/mi/windows/Bond;

  use spoova/mi/core/classes/Bond;

  class Posts extends Bond{

    public $count = 0;

    public function render(): Compiler|String {

      return compile('bond-template');

    }

    public function increase() {

      $this->count++; <span class="comment">//increase</span>

    }

  }  
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;

    &lt;button bond:click="increase"&gt; @({{ $counter }})@ &lt;button&gt;
  
  &lt;/div&gt;
                              </pre>
                            </div> 

                            <div class="">
                              In the example above, when the button is clicked, the counter will 
                              increase and once the page is refreshed, the counter will reset to the 
                              default value.
                            </div>

                          </div>
                        </div> <br>

                    </div> <br>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/variables')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span>Bond variables</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/real-time')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Real time events<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 