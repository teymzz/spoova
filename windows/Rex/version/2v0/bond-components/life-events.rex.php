

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - life-events') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond Live Events </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Live components</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            Live bond components are components that are re-rendered back into a page when an live activity or a trigger event occurs. 
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
                              The addition of any of these live events attributes into a bond component element will render such element as a live component trigger. 
                            </div>
                          </div>
                        </div>

                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Working with triggers</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <div class="">
                              We can initialize an onload event using the <code>bond:load</code> directive in the bond 
                              component
                            </div> <br>

                            
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

    public function render(): Compiler|String {

      return compile('bond-template');

    }

    public function activity() {

      <span class="comment">//do something</span>

    }

  }  
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;

    &lt;button bond:load="activity"&gt; Run Activity &lt;button&gt;
  
  &lt;/div&gt;
                              </pre>
                            </div> 

                            <div class="">
                              In the example above, when the button which is initially rendered to <code>@(bond('Posts'))@</code> 
                              loads, a request is immediately forwarded which calls the <code>activity()</code> method of the component 
                              controller. Once the activity is executed, then the live component is re-rendered back to the page. Any method 
                              can be called in this way but the method must not be a private, protected or static method. All other 
                              event attributes can be used similarly to trigger the re-rendering of a bond componenet. 
                            </div>

                        </div><br>
                    </div>

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
                              <a href="@domurl('version/2.0/bond-components/counter')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Counter<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 