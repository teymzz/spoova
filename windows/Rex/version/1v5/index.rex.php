@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <span class="bi-recycle"></span> Spoova 1.5!</div>
                    
                        <div class="font-em-d8">
                            New features have been added to version 1.5.0 to improve security and fixing of bugs
                        </div> <br>

                        <div class="">
                            <div class=" fb-9 font-em-1d2 calibri">What's new?</div>
                        </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Ajax requests </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Special characters are now allowed in ajax urls. Prior to this version, when a request 
                                data is sent to ajax urls having special characters, while the url may be accessed, there 
                                could be a data loss due to a bug preventing post data from forwarding the request data. This bug only affected urls 
                                that have special characters like underscore (_) and hyphen (-). In version 1.5.0, this has been fixed. 
                                Special characters are now allowed in ajax urls. More information on this update can be found <a href="@domurl('version/1.5/ajax-requests')">here</a>. 
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Map files </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8">

                            Map files are used to protect route entry file names under a standard logic to ensure that entry files are not exposed to the public. 
                            In version 1.5.0, the map file have been modified to allow two new features. These features 
                            include file protection used for securing entry point names and the other is entry inverse used to modify the strictness of entry point names.
                            Find more information on this <a href="@domurl('version/1.5/map-file')">here</a>.
                            <br><br>
                        </div>
                    </div><br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Live server </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                When writing codes on live development state with the use of live server, the error notifications 
                                are sometimes glitchy. This effect was due to an entrace animation effect which has now been removed. 
                                The live server glitchy error notification bug has been fixed which now make the error notices look more stable for developers.
                            </div>
                            
                        </div> <br>
                    </div> <br>
                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-grid"></span> Template on the go </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Template on the go was a feature added to make it easier to create template files easily with 
                                integrated live server. When such rex templates are generated, they come with the basic <code>@(@live)@</code> 
                                directive which keeps them on a live state mode. Some bugs were removed when the template is generated. Learn more 
                                from <a href="@domurl('version/1.5/live-template')">here</a>.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-red-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Deprecated! </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                Prior to the intial release, some resource methods such as <code>Res::get()</code>, <code>Res::gett()</code>, 
                                <code>Res::post()</code> and <code>Res::postt()</code> were used as test cases to render routes before the wvm 
                                logics were introduced. With the <code>wvm</code> 
                                logics, we find no use for this methods any more because routes are now being handled by a server file and the 
                                entire route is being managed by a shutter system. It is advised to desist from the use of this methods as they 
                                may be removed at any point in time. Learn more 
                                from <a href="@domurl('version/1.5/deprecations')">here</a>.
                            </div>
                            
                        </div> <br>
                    </div> <br>


                </div>
           </div>
       </section>
   </div>

@template;