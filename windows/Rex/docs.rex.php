@template('template.t-tut')

   @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2"> <span class="bi-journal-text"></span> Documentation </div>
                    
                        <div class="font-em-d8">
                            The spoova project pack comes with an offline documentation. This is accessible through the 
                            project packs navigation bar. When a new project application is created, spoova tries to 
                            keep the created project as clean as possible. Hence, the documentation will 
                            not be available in the project app. The quick access link below may prove useful to easily 
                            navigate to some sections within the application.
                        </div>
                    </div>

                    <div class="bc-white-dd">
                        <div class="pxv-10 font-em-d8" style="color: #e3dcdc;
background-color: #56567b;">
    
                            <div class="bi"> <span class="bi-filter-circle"></span> Quick Access </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8" style="color:#56567b;">
                            <div class="">
                              <div class="fb-6"> 
                                <a href="@route('::installation')" class="c-i"><i class="bi-circle"></i> Project Installation</a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="@route('::wmv')" class="c-i"><i class="bi-circle"></i> About wmv </a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="@route('::live-server')" class="c-i"><i class="bi-circle"></i> Live server </a>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Resource grouping</div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::resource.grouping')" class="c-i"> Naming resources (global) </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@domurl('version/2.0/resource')" class="c-i"> Naming resources (unique) </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Database management </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::database')" class="c-i"> Database operations </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::forms')" class="c-i"> Form Request Management </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@domurl('database/data-model')" class="c-i"> Data Model </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@domurl('database/migration')" class="c-i"> Database Migration </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Session management </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::sessions.session')" class="c-i"> Session class </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::sessions')" class="c-i"> Window sessions </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::useraccounts')" class="c-i"> User management </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Helper Resources </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::classes')" class="c-i"> Helper classes </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::functions')" class="c-i"> Helper Functions </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"><i class="bi-circle"></i> Template Engine </div>
                              <div class="font-em-d9 pxs-20">
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@domurl('docs/template/compilers')" class="c-i"> Template compilers </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@domurl('version/2.0/compiler-class')" class="c-i"> Compiler class </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::template/files')" class="c-i"> Template files </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::template/directives')" class="c-i"> Template directives </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::template/window')" class="c-i"> Template directives </a>
                                  </div>
                                </div>
                                <div class="pxl-1">
                                  <div class="pvs-4"> 
                                    <a href="@route('::template/on_the_go')" class="c-i"> Template auto generation </a>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="mvt-16">
                              <div class="fb-6"> 
                                <a href="@route('::cli')" class="c-i"><i class="bi-circle"></i> Cli commands</a>
                              </div>                            
                            </div>
                        </div> <br>
                    </div>

                </div>
           </div>
       </section>
   </div>

@template;