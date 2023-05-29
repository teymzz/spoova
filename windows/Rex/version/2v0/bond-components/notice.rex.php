

@template('template.t-tut')
    @lay('build.co.navbars:left-nav')
    @Res('res/main/js/local/bond.js')
    @title('bond components - Notice') 

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Bond Conclusion </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                          <div class="bi"> <span class="bi-circle"></span> Notice </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                          
                          <div class="">
                           The bond component is a new feature introduced into this framework and it is still in its beta phase. There are other features that 
                           may be rolled out in future updates but it is important to also know that there can be a few bugs in its beta phase. You may wish to 
                           try it out but ensure that it is only used in test cases until its stable version is released. Here are a few tips to take note of when 
                           working with live components. <br><br>
                           
                           <div class="">
                            <div class="c-orange-dd"> <span class="bi-lightbulb c-yellow-dd"></span> Bond Tips</div>
                            <div class="">
                              <ol class="pxv-20 pvs-4">
                                <li>Live server should be turned off when working with live components</li>
                                <li>Avoid running multiple live components on a single page if they involve sending multiple requests at intervals.</li>
                                <li>Bond attributes should be escaped when used in normal texts with the <code>&#64;()&#64;</code> directive </li>
                              </ol>
                            </div>
                           </div>

                          </div>
                        </div> <br>

                    </div>

                    <div class="font-em-d8 mvs-10">
                        <div class="box previous">
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components/form-data')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"><span class="bi-arrow-left"></span> Form data</a>
                          </div>
                          <div class="box" hidden>Previous</div>
                        </div> &nbsp;
                        <div class="box next">
                          <div class="box" hidden>Next</div>
                          <div class="box">
                              <a href="@domurl('version/2.0/bond-components')" class="flex-btn rad-r bc-dodger-blue-dd font-em-d85 mid" style="color:white"></span>Main &nbsp; <span class="bi-house"></a>
                          </div>
                        </div>
                    </div><br>

                </div>
           </div>
       </section>
   </div>

 
@template; 