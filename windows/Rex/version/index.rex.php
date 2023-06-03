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
                            upwards.
                        </div> <br>


                        <div class="versions font-em-d85">
        
                            <div class="">
                                <div class="fb-6 calibri font-em-1d5">Releases</div>
                                
                                <div class="mvt-10">
                                    <div class="">
                                        <div class=""><a href="@domurl('version/2.1')" class="c-orange ch-orange-dd fb-6">version 2.1.0 (beta)</a></div>
                                        <div class="">
                                            <ul class="pxl-15">
                                                <li><a href="@domurl('version/2.1')" class="inherit">Live server error fix</a></li>
                                                <li><a href="@domurl('version/2.1')" class="inherit">Intersect.js update</a></li>
                                                <li><a href="@domurl('version/2.1')" class="inherit">Template directives</a></li>
                                                <li><a href="@domurl('version/2.1')" class="inherit">Bootstrap icons update</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class=""><a href="@domurl('version/2.0')" class="c-orange ch-orange-dd fb-6">version 2.0.0 (beta)</a></div>
                                        <div class="">
                                            <ul class="pxl-15">
                                                <li><a href="@domurl('version/2.0/urls')" class="inherit">Improved url structure</a></li>
                                                <li><a href="@domurl('version/2.0/shutter-calls')" class="inherit">Improved window shutter controls</a></li>
                                                <li><a href="@domurl('version/2.0/compiler-engine')" class="inherit">Improved compiler engine</a></li>
                                                <li><a href="@domurl('version/2.0/bond-components')" class="inherit">Integerated bond components (beta)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="">
                                        <div class=""><a href="@domurl('version/1.5')" class="c-dodger-blue ch-dodger-blue-dd">version 1.5.0 (stable)</a></div>
                                        <div class="">
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

                </div>
           </div>
       </section>
   </div>

@template;