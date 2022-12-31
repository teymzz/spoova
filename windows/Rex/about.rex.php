@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxv-20 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20 pvs-10">
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
                                is but upon the concept that there can be base entry point(s) which can be active or passive depending on the 
                                availability of a root window entry point that leads to a view. All webpages are window pages. They 
                                exist due to the availability of a single entry point. While different urls may have a similar entry point (window), 
                                there can also exists different urls with different entry points. However, every url must be handled by a window file which sorts 
                                and manages its relative paths and determines how urls load their contents. The window files are placed 
                                within the "window" directory. 
                            </p>
                            <p>
                                There are different ways by which a window url can be handled. Spoova's flexibility supports 
                                multiple ways of loading urls but however, favors a standard logic and provides a great support for it. In order for the logic to 
                                work, all window files (or entry points) and window subdirectories containing window files are expected to be placed within the "window\Routes" directory including all APIs. 
                                The standardlogic uses the window files as the base for any url visited. This means that any url visited that does not have its 
                                entry point within the Routes folder is considered as an invalid url. This structure helps in file organization and code deployment. 
                                It also helps to locate files easily with a minimal level of stress.
                            </p>
                            
                        </div>
                    </div>

                    <div class="bc-white-dd mvt-10">
                        <div class="bc-orange c-white pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-lock"></span> Security </div>  
    
                        </div>
    
                        <div class="pxv-20 pvb-1 font-em-d85">
                            Although great care has be taken to provide an environment for building secure applications, developers should trend 
                            carefully with form inputs. Proper validation should be done for form inputs as improper 
                            validation may lead to undesired responses. All php files are protected along with some core directories. This behaviour can 
                            affect file download. A solution will be to fix this by creating window url and setting header content-type of that url<br><br>
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