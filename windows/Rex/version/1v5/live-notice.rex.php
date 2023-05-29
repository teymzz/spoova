@template('template.t-tut')

    @title('Spoova 1.5')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 1.5+ </div>  Live notice</div>
                    </div>


                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Live server </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                               The live server feature is one that makes it possible to develop on a live state. The error notification system makes it possible 
                               to also view errors on a live mode. The error notification detector is one that runs several algorithms to determine when an error occurs 
                               and when a content is only refreshed. This functionality makes it possible to pause the live server when an error occurs and only resumes when the 
                               error is fixed. Athough, the error notification system manages to detect when an error occurs, it is still known to have few bugs which may not be entirely 
                               eradicated but is constantly being improved over time. Prior to version 1.5, the error notification system sometimes resolves into constant blinks depending on the 
                               type of error that occured. In version 1.5.0 however, a more stabilized live server error notification is achieved. While the error notification isn't entirely perfect, 
                               the blink effect has been considerably handled to reduce the adverse effect of side distractions. 
                            </div>
                            
                        </div> <br>
                    </div> <br>
              
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-red-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-exclamation-triangle"></span> Warning! </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                When working with codes that can permanently alter the state of an element, such as database modifier operations 
                                (i.e insert, update and delete), file management and control and other key state-changing operations, it is important to 
                                turn the live server off using any of the control functions or template directives. Also, when working with html forms, 
                                it is advised to turn off the live server as the <code>@(csrf)@</code> template directives will cause a looping effect of the live server. The following situations 
                                are cases where the live server should be turned off if it was already turned on: <br><br>

                                <ul>
                                  <li>When inserting values into database fields, to avoid multiple insertion</li>
                                  <li>When deleting values from database fields, to avoid loss of unintended data.</li>
                                  <li>When updating values in database fields, to avoid unintended update.</li>
                                  <li>When submitting a post request to avoid a looped request validation prompt from web browser</li>
                                  <li>When using the <code>@(csrf)@</code> directive on forms to prevent looped page refresh or reload</li>
                                  <li>When working with file management such as file delete, rename, movement, etc</li>
                                  <li>When working with data that constantly changes its state or form.</li>
                                </ul>
                            </div>
                            
                        </div> <br>
                    </div> <br>


                </div>
           </div>
       </section>
   </div>

@template;