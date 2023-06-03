@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dry-blue-d"> <span class="bi-recycle font-em-d85"></span> <span class="c-deep-blue fb-9 verdana">S</span><span class="c-dry-blue-dd">poova 2.0!</span></div>
                    
                        <div class="font-em-d8">
                            New features have been added to version 2.0.0 to improve security and code structure of the framework
                        </div> <br>

                        <div class="">
                            <div class=" fb-9 font-em-1d3 calibri">What's new?</div>
                        </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Improved Resource class </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Resource class is mainly used for importing static files through previously specified urls. 
                                It is also capable of storing urls as groups which can be imported later using the resource 
                                <code>import()</code> method or the <code>@(@res())@</code> directive. While a group can be easily 
                                created for static urls, in cases where a file is required in different groups, it might be become harder 
                                to manage a single url. A new addition makes this easier by setting unique names for each file which can be 
                                required later. Learn more from <a href="@domurl('version/2.0/resource')">here</a>
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Live server improved! </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The integerated live server has been massively improved. Previously to version 2.0, live server uses a great amout of resources
                                from the cpu. The effect of this is that the performace level of the device being used reduces in 
                                a very short period of time and browsers could crash often. Version 2.0 addresses this issue and the live server is now very efficient within the framework. 
                                With this new improvement, developers will now be able to run the live server for a longer period of time without being worried
                                about perfomace issue. 
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Improved shutter controls </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Spoova has improved its window urls to support dotted strings which was not supported by the 
                                shutter methods in the previous updates because dots were treated as slashes. The window function used by shutter methods have also been improved 
                                reflect these changes. The effect of these updates results in an improved url structure and management. It also helps to reduce visual noise when 
                                when working with shutter methods. Learn more from <a href="@domurl('version/2.0/urls')">here</a>
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Automatic Dependency injection Support </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                              In the previous updates, passing dependencies as arguments into window methods through shutters requires a more difficult approach. However, spoova has updated 
                              its window methods to allow for automatic dependency injection. This new feature is added in order to reduce lines of code and to help sanitize the entire code 
                              structure. More details are available <a href="@domurl('version/2.0/shutter-calls')">here</a> 
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Improved compiler engine </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The compiler function was handled as a detached component from the compiler engine in the previous versions of the frameworks. The effect of this detachment 
                                is the function can only be used once within the application. However, this effect was greatly felt with the introduction of bond components which requires a 
                                multiple use case for the compiler. In spoova version 2.0, the compiler function has been improved to allow for more use cases. The 2.0 version also introduces 
                                more compiler functions that determines how templates are rendered. More details are provided 
                                <a href="@domurl('version/2.0/compiler-engine')">here</a>
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Introduction of bond components </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Bond components are components that helps to render template engines on a live state. They are entirely different from the live server used in development. 
                                These components are build upon existing template engine but they are injected as separate live templates into template files using live template directives. 
                                The entire requests are handled with event handlers which determines how the template files are requested, rendered and managed. 
                                Bond components are still on a beta phase and more information is provided <a href="@domurl('version/2.0/bond-components')">here</a>.  
                            </p>
                            
                        </div>
                    </div> <br>

                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Updated Model </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                              New methods have been added to Model and Form classes to help improve database communication. 
                              These methods are <code>Model->id()</code>, <code>Model->insertID()</code>, <code>Model->connection()</code>, 
                              <code>Form::id()</code> and <code>Form::connection()</code>. Details of these methods and their functions are provided 
                              <a href="@domurl('version/2.0/models')">here</a>.
                            </p>
                            
                        </div>
                    </div> <br> 

                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dry-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Other updates </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                              Some classes and helper functions have been remodified. You can learn more about this from <a href="@domurl('version/2.0/others')">here</a>. 
                            </p>
                            
                        </div>
                    </div> <br> 

                    <div class="font-em-d8 pvs-10">
                        For more details on spoova versions, you can track the spoova version updates from <a href="@domurl('version')" class="c-olive ch-dodger-blue-d">here</a>.
                    </div> <br> 

                </div>
           </div>
       </section>
   </div>

@template;