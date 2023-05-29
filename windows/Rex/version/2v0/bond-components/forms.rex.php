

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - Forms') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond - Forms </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Adding forms </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            Forms field can be added to the web page from bond components and they will render easily into the 
                            main template file. However some events are attached to forms which determines how forms data are submitted to be processed. We can also 
                            bind events to buttons to determine activities that should occur when a form is submitted. A default behaviour when a form is  
                            submitted is that the page will be refreshed. We can prevent the submission of any button within a form by adding an halt event 
                            on form fields. This is done by adding the attribute <code>bond:action="avert"</code> to the form field. Any button within such forms will be prevented from 
                            submission.
                            <br><br>
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  @(bond('Posts'))@
                              </pre>
                            </div> 
                            
                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;
    
    &lt;form bond:action="avert"&gt;

      &lt;input name="field1" type="text"&gt;
      &lt;input name="field2" type="text"&gt;

      &lt;button&gt; submit &lt;/button&gt;

    &lt;/form&gt;

  &lt;/div&gt;
                              </pre>
                            </div> 

                            <div class="">
                              Once the button above is clicked, the button will be prevented from submitting. We can also bind events to 
                              specific buttons rather than the form field itself. This will be discussed in button events.
                            </div>

                          </div>
                        </div> <br>

                    </div>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/real-time')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span>Real time</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/button-events')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Button events<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 