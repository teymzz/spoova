@template('template.t-tut')

   @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white-dd pull-right">
       <section class="pxv-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pxv-20">
                        <div class=" c-orange font-em-2"> <span class="bi-stack"></span> About</div>
                    
                        <div class="font-em-d8">
                            Spoova was built to emulate mobile compatibility and enable faster web development 
                            through the use of live server. This application has been tested across different server 
                            such as cpanel, heroku and android kws server. The concept behind its creation is to provide 
                            a synergy between online and offline development. It also uses a windows-frame mvc pattern
                            which makes is easier to load pages.
                        </div>
                    </div>

                    <div class="bc-orange c-white pxs-10">

                        <div class="bi"> <span class="bi-cpu"></span> How it works </div>  

                    </div>

                    <div class="pxv-20  font-em-d85">
                        The spoova window system can be likened to a real house. Every house has a door and a window. 
                        The standard WVM logic follows that there is only one main entry point which can either be active or passive depending on the 
                        availability of a root window entry points that leads to a view. All web Zpages are window pages. They 
                        exist due to the availability of a single entry point. While different urls may have a single entry point (window), 
                        there also exists urls with different entry points. However, the standard logic control structure demands that every url must be 
                        handled by a window file which sorts and manages its relative paths and determines how urls load their contents. The window files are placed 
                        within the "window" directory. There are different ways by which a window url can be handled. Spoova's flexibility supports 
                        multiple ways of loading urls but however, favors a standard logic and provides a great support for it over other logics which are baselogic 
                        and indexlogics. The window structure divides into four parts which are window, api, models and template structures. Window files are subsequently 
                        classfied as Routes (window-binding), Frames (frame-binding) and APIs. In order for the logic to work, 
                        all window files (entry points or routes) are expected to be placed within the "window\Routes" directory including all APIs. 
                        The standard logic uses the window files as the base for any url visited. This means that any url visited that does not have its 
                        entry point within the Routes folder is considered as an invalid url. This structure helps in file organization and code deployment. 
                        It also helps to located files easily with a minimal level of stress.
                    </div>

                    <div class="bc-orange c-white pxs-10">

                        <div class="bi"> <span class="bi-lock"></span> Security </div>  

                    </div>

                    <div class="pxv-20  font-em-d85">
                        Although great care has be taken to provide an environment for building secure applications, developers should trend 
                        carefully with form inputs. Great care must be taken to validate form inputs as improper 
                        validation may lead to undesired responses. <br><br>
                    </div>

                    <div class="bc-orange c-white pxs-10">

                        <div class="bi"> <span class="bi-hdd-stack"></span> Deploying Application</div>  

                    </div>

                    <div class="pxv-20  font-em-d85">
                        Deploying project applications has never been this easy. Spoova provides lite frontend and backend tools that keep your application on a 
                        production-level state. This means that once a project application has been sucessfully deployed, 
                        it is automatically mapped to the online enviroment. The root htaccess file is a key feature in the functionality of this application, 
                        hence it should not be tampered with. Developer should also ensure to setup all configuration files and database configuration access keys 
                        to complete all required data needed to kickstart the framework.
                    </div>

                </div>
           </div>
       </section>
   </div>

@template;