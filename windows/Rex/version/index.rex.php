@template('template.t-tut')

    @title('Spoova 1.5')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <span class="bi-recycle"></span> Versions</div>
                    
                        <div class="font-em-d8">
                            There has been a constant update of spoova framework since its initial release of version 1.0.0. 
                            This page make it easier to easily track new updates for all releases starting from spoova version 1.5.0 
                            spoova updates added in versions from this page. 
                        </div>


                        <div class="versions font-em-d85">
        
                            <div class="">
                                <div class="pvt-20 font-em-1d2">
                                    <a href="version/2.0" class="c-orange ch-orange-dd fb-6">Spoova 2.0.0 (beta)</a>
                                </div> 
                                <div class="hide">
                                    <div class=" fb-9 font-em-1d2 calibri">What's new?</div>
                                </div>
                                <div class="features">
                                    <ul class="pxl-14">
                                        <li><a href="@domurl('version/2.0/urls')" class="inherit">Improved url structure</a></li>
                                        <li><a href="@domurl('version/2.0/shutter-calls')" class="inherit">Improved window shutter controls</a></li>
                                        <li><a href="@domurl('version/2.0/compiler-engine')" class="inherit">Improved compiler engine</a></li>
                                        <li><a href="@domurl('version/2.0/bond-components')" class="inherit">Integerated bond components (beta)</a></li>
                                    </ul>
                                </div>
                            </div>                            
                        
                            <div class="">
                                <a href="version/1.5" class="c-dodger-blue ch-dodger-blue-dd">Spoova 1.5.0 (stable)</a> <br>
                                <div class="features">
                                    <ul class="pxl-14">
                                        <li><a href="@domurl('version/1.5/ajax-requests')" class="inherit">Improved ajax requests</a></li>
                                        <li><a href="@domurl('version/1.5/map-file')" class="inherit">Map files for route protection</a></li>
                                        <li><a href="@domurl('version/1.5/live-notice')" class="inherit">Improved live server error notification</a></li>
                                        <li><a href="@domurl('version/1.5/live-template')" class="inherit">Integerated template on the go functionality</a></li>
                                        <li><a href="@domurl('version/1.5/deprecations')" class="inherit">Deprecations</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
           </div>
       </section>
   </div>

@template;