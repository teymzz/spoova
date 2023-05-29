@template('template.t-tut')

    @title('Spoova 1.5')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-red-dd"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 1.5+ </div>  Deprecations </div>
                    </div>
                    
                    <div class="">

                        <div class="bc-white-dd rad-4 flow-hide">
                            <div class="bc-red-dd c-white-d pxv-10 font-em-d8">
        
                                <div class="bi"> <span class="bi-circle"></span> Deprecated! </div>  
        
                            </div>
                            <div class="pxv-20 pvb-1  font-em-d8">

                                <div>
                                    Prior to the intial release, some resource methods were used as test cases to render routes before the wvm 
                                    logics were introduced. With the <code>wvm</code> 
                                    logics, we find no use for these methods any more as routes are now handled by the use of a server file and the 
                                    entire route is being managed by a shutter system. Since emphasis are also not laid on these methods, it is believed that 
                                    the impact of their deprecation will not be so trival in the core aspects of developers' project applications. These method will no longer 
                                    be added in the future updates. The list below includes methods that will no longer be added: 
                                    <br><br>
                                    <ul class="pxl-14 c-orange-dd">
                                        <li>Res::get()</li>
                                        <li>Res::gett()</li>
                                        <li>Res::post()</li>
                                        <li>Res::postt()</li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div> <br>

                    </div>



                </div>
           </div>
       </section>
   </div>

@template;