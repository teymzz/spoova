

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - Real Time') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond - Timed Events </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Real time events </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            Every activity can be triggered based on specified timed intervals. This is done by 
                            adding the attribute <code>bits</code> to bond live trigger element. This attribute 
                            takes a value in seconds that determines the rate of request sent per second 
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

      $this->count++;

    }

  }  
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;

    &lt;button bond:click="increase" bits="1500"&gt; @({{ $counter }})@ &lt;button&gt;
  
  &lt;/div&gt;
                              </pre>
                            </div> 

                            <div class="">
                              Once the button above is clicked, the event will start sending request 
                              at the interval of 1.5seconds.
                            </div>

                          </div>
                        </div> <br>

                    </div> <br>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/counter')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span>Counter</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/forms')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Forms<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 