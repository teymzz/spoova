

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - Buttons') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond - Forms Buttons </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Forms Submission </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                            Forms buttons are given some special attributes to make it easier to handle form control such as resetting forms, keeping form input state or pushing data for submission. 
                            In most cases when a button is clicked, the page is usually refreshed which means that post data will have to be managed by the route controller. In the case that we like to 
                            prevent specific buttons from refreshing the page we can specify this using the <code>bond-action</code> attribute in the bond component.
                            <br><br>

                            <div class="pre-area bc-white mvb-2">
                              <pre class="pre-code">
  &lt;div&gt;
    
    &lt;form&gt;

      &lt;input name="field1" type="text"&gt;
      &lt;input name="field2" type="text"&gt;

      &lt;button bond:action="halt"&gt; submit &lt;/button&gt;

    &lt;/form&gt;

  &lt;/div&gt;
                              </pre>
                            </div> 

                            <div class="">
                              In the sample above, the specified option <code>"halt"</code> will prevent the form from submitting. There are 
                              other options which can be supplied. These are listed below: <br> 
                              <br> 

                              <div class="pxv-4 bc-white mvb-2">
                                <code class="bd-f">bond:action="halt"</code> 
                               This option will prevents the default form submission behaviour of a form button. If used along with an onclick trigger attribute, 
                               the input fields will be re-rendered while the current value of each input field is maintained. 
                              </div>

                              <div class="pxv-4 bc-white mvb-2">
                                <code class="bd-f">bond:action="reset"</code> 
                               This option prevents the default form submission behaviour and also clears the data of all input forms in a form field. This option is 
                               best used on a button that is not used as a live event trigger.
                              </div>

                              <div class="pxv-4 bc-white">
                                <code class="bd-f">bond:action="push"</code> 
                                This is used to perform three different activities. It prevents the form form 
                                default submission and pushes the data of a form field to the bond controller which will be used to process the 
                                data forwarded. Lastly, it clears the data of all input fields of the current form.
                              </div>
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
                              <a href="@domurl('version/2.0/bond-components/form-data')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Form data<span class="bi-arrow-right"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 