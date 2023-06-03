

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - Form data') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond - Forms Data </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Accessing Form data </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            When a form is submitted using the <code>bond-action="push"</code> attribute, this data is forwarded to the bond controller. The easiest way to 
                            access such data is by calling the <code>postdata()</code> method which will then return the post request data in an array format.
                            <br><br> 

                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  @(@bond('Posts'))@
                              </pre>
                            </div> 

                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;
    
    &lt;form&gt;

      &lt;input name="field1" type="text"&gt;
      &lt;input name="field2" type="text"&gt;

      &lt;button bond:action="push" bond:click="save"&gt; submit &lt;/button&gt;

    &lt;/form&gt;

  &lt;/div&gt;
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

    public function save() {

      $postdata = self::postdata();

      if ($postdata) {

        <span class="comment">//do something with data</span>

      }


    }

  }  
                              </pre>
                            </div> 

                            <div class="">
                              In the sample above, when the form is submitted, the post data will be forwarded to the 
                              bond component controller which will then access the submitted data through the <code>postdata()</code> 
                              method. <br> 
                            </div>

                          </div>
                        </div> <br>

                    </div>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/forms')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span>Forms</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/notice')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Notice<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 