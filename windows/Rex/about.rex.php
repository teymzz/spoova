@template('template.t-tut')

   @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2"> <span class="bi-stack"></span> About</div>
                    
                        <div class="font-em-d8">
                            Spoova was built to emulate mobile compatibility and enable faster web development 
                            through the use of live server. This application has been tested across different server 
                            such as cpanel, heroku and android kws server. The concept behind its creation is to provide 
                            a synergy between online and offline development. Hence, it provides some useful backend and front-end 
                            functions that helps to easily map static files such as css and javascipt to the development environment. 
                            It also uses a windows-frame mvc pattern which follows a predefined templating structure for managing web pages.
                        </div>
                    </div>

                    <div class="bc-white-dd">
                        <div class="bc-orange c-white pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-cpu"></span> How it works </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The spoova window system can be likened to a real house. Every house has a door and a window. 
                                In WVM, there are three logics that can be applied to manage web urls. The most important thing to note is that the idea 
                                is built upon the concept of base entry point(s) which can be active or passive depending on the 
                                availability of a root window entry point that leads to a view. All webpages are window pages and they 
                                exist due to the availability of a single or multiple entry points. While different urls may have a similar entry point (window), 
                                there can also exists different urls with different entry points. However, every url must be handled by a window (route) file which sorts 
                                and manages its relative paths and determines how urls load their contents. The window files are placed 
                                within the <code>windows/</code> directory while route files are placed in the <code>windows/Routes/</code> directory. 
                            </p>
                            <p>
                                There are different ways by which a window url can be handled. Spoova's flexibility supports 
                                multiple ways of loading urls but however, favors a standard logic and provides a great support for it. In order for the logic to 
                                work, all window route files (or entry points) and route subdirectories containing route files are expected to be placed within the 
                                <code>windows/Routes/</code> directory including all APIs. 
                                The standard logic uses the window (route) files as the base for any url visited. This means that any url visited that does not have its 
                                entry point within the <code>windows/Routes</code> directory is considered as an invalid url. This structure helps in file organization and code deployment. 
                                It also helps to locate files easily with a minimal level of stress.
                            </p>
                            <p>
                                Internally, the framework also introduces a <code>domurl()</code> function for mapping urls to their environment. This function tries to create a form of environmental 
                                handshake that makes relative static urls recognizable in the development environment. Hence, all relative urls of static resource files are converted into an http protocol 
                                format that makes them accessible across different enviroments. This makes it easier to migrate project applications from production to live environment.
                            </p>
                            <p>
                                The live server system was integerated into the application to make development faster. There are couple of ways it can be started, however the best way is through 
                                the use of template directive <code>@(@live)@</code> in template files. If a template file cannot be used, there are other ways in which it can be 
                                turned off or on within routes. This live server also makes it possible to easily create template files easily when a non-existing template file is autoloaded. Together, 
                                all these features and functionalities ensures a faster project development rate.
                            </p>
                        </div>
                    </div>

                    <div class="bc-white-dd mvt-10">
                        <div class="bc-orange c-white pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-shield-check"></span> Security </div>  
    
                        </div>
    
                        <div class="pxv-20 pvb-1 font-em-d85">

                            <div class="">
                                Although great care has be taken to provide an environment for building secure applications, developers should trend 
                                carefully with form inputs, especially inputs that may have close relationships with directive comments. 
                            </div> <br>
                            
                            <ul class="list-square pxl-14">
                                <li>
                                    Proper validation should be done for form inputs as improper validation may lead to undesired responses.
                                </li>
                                <li>
                                    By default, all php files are protected along with some core directories. This behaviour may affect file download which 
                                    can be fixed by creating a route and setting header content-type of that url
                                </li>
                                <li>
                                    All texts with the <code>@</code> symbol should be properly commented with <code>@(@()@)@</code> to avoid conflicts with the 
                                    template directives. When dealing with forms inputs, this can be solved with the php <code>htmlentities()</code> in-built function.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bc-white-dd mvt-10">
                        <div class="bc-orange c-white pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-recycle"></span> Version updates </div>  
    
                        </div>
    
                        <div class="pxv-20 pvb-1 font-em-d85">

                            <div class="">
                                 There is a constant improvement and upgrades on spoova framework. While the basic documentation provides a first-hand understanding 
                                 of the framework, it is important to do a follow up with new changes and developments made within the application. The initial documentation 
                                 provides an assistance for the initial release of the framework. For update documentations on improvements made which are version specific, it is suggested to 
                                 visit the <a href="@domurl('version')">version</a> page to learn more about recent updates or changes made within the framework. The <a href="@domurl('updates')">updates</a> 
                                 page can also be visited to see the current version of the framework along with added changes.
                            </div> <br>

                        </div>
                    </div>

                    <div class="bc-white-dd mvt-10">
                        <div class="bc-orange c-white pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-hdd-stack"></span> Deploying Application</div>  
    
                        </div>
    
                        <div class="pxv-20 font-em-d85">
                            Deploying project applications has never been this easy. Spoova provides lite frontend and backend tools that keep the application on a 
                            production-level state. This means that once a project application has been sucessfully deployed, 
                            it is automatically mapped to the online enviroment. The root htaccess file is a key feature in the functionality of this application, 
                            hence it should not be tampered with. Developer should also ensure to setup all configuration files and database configuration access keys 
                            required to kickstart the framework. This include the <code>icore/init</code> and the <code>icore/dbconfig.php</code> files. Also, the Session 
                            should be defined properly in a Frame file which is accessible. It is also important to keep 
                            project folder names free of special characters.
                        </div>
                    </div>

                </div>
           </div>
       </section>
   </div>

@template;