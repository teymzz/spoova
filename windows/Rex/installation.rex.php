

@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxv-10 tutorial bc-white">
           <div class="font-em-1d2">

               <div class="start font-em-d85">
             
                   @lay('build.co.links:tutor_pointer') <br>

                   <div class="font-em-1d5 c-orange">Installation</div>
                   
                   <div class="c-black-ll">
                       It is strongly advised to learn about the features of this framework
                       before proceeding with installation. You can learn about the features 
                       <span class="c-orange-dd">
                           <a href="@DomUrl('about')" class="inherit">here</a>
                       </span> 
                   </div> <br>

                   <div class="calibri bc-white-dd">
                       <div class="c-olive pxv-10 bc-silver">Application config</div>

                       <div class="pxv-10">
       
                           <ul class="list-square pxl-20">
                               <li>Download the spoova frame project pack file</li>
                               <li>Place the project pack into your root web folder (offline)</li>
                               <li>Open spoova project pack in the terminal</li>
                               <li>Run the command : <span class="fb-6 c-black-ll"> php mi project <span class="c-gold-dd">app</span></span> where "app" is your new project folder name </li>
                               <li>Follow the console directives to generate your project app</li>
                               <li>Configuration of new project app can be done through web installer page (if allowed before generation) or through the command line</li>
                               <li>Open the new project app in your editor's (e.g vscode) terminal for configuration</li>
                               <li>Run the command <code>php mi config:all</code> to configure your new project app</li>
                               <li>During configuration, database parameters must be defined within quotes, for example <code>"name user pass server port socket"</code> </li> 
                               <li>Database parameters should be filled with valid details while empty parameters should be set as dash (i.e -)</code></li>
                               <li>For spoova to run efficiently, database configuration along with other basic configurations should be updated with valid credentials. </li>
                               <li>All database configurations are saved into the icore/dbconfig.php file for both offline and online environments.</li>
                               <li>When using the inbuilt web installation tool, you can choose the hard install (e.g http://localhost/app/install?refresh) option on the home page to reset previously defined configurations. </li>
                           </ul>
                           <div class="bc-silver rad-3 flow-x flex font-em-d85 pvs-10 pxs-10 hide"> 
                            <div class="box bc-red-dd bd-1 bd-red-dd pxv-4 c-white-d no-wrap"> <span class="bi-exclamation-triangle"></span> Note:</div> 
                            <div class="box bd-1 bd-silver-d pxv-4 wid-full">It is highly discourged to use the spoova source pack as project folder.</div>
                           </div>
                       </div>
                   </div> <br>
                   
               </div>

               <div class="install-page calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Web Installer</div>
                   <div class="font-em-d85 pxv-10 no-select">
                   
                        During project application generation, a web installer page may be added. If the installer page is missing. Use the command 
                        <code>php mi web-installer</code> to generate a new installer page. However, it is strongly advised that all configurations should be 
                        handled from the terminal to ensure that all configurations are applied. To manually generate an installer page the following code may be 
                        added to an installation route.

                   </div>

                   <div class="font-em-d8">

                        <div class="pre-area">
            
            <pre class="pre-code">
    &lt?php

    namespace spoova\mi\windows\Routes;

    use Installer;
    use Window;

    class Install extends Window{


        function __construct()
        {
            include_once(_core.'installer.php');

            $Install = new Installer;
            $Install->install();

            echo $Install->content();
        }


    }
            </pre>            
                        
                        </div>

                   </div>

                   
                </div> 
                <div class="foot-note font-em-d8 pvs-10">Note that the web installer page should be relative to the route logic used.</div>
                <br>

               <div class="setup calibri bc-white-dd">
                   <div class="c-olive pxv-10 bc-silver">Setup config</div>
                   <div class="font-em-d85 pxv-10">
   
                       <div>Basic configuration can be applied for live server, resource meta and session control</div> <br>
                       <ul class="list-square pxl-20">
                           <li> <span class="fb-6 c-sky-blue-dd">Live Server:</span> <br>
                               Spoova comes with an internal php live server (beta). 
                               Attached to the live server is a live debug system (beta) 
                               that runs upon the live server. The liveserver is mainly designed for local 
                               environment but can also be enabled in live environments. This follows 
                               the options listed below:
                               
                               <br><div class="mvs-6 i pvs-10">The live server can be configured as:</div>
                               <span class="c-orange-dd">"offline"</span> enables the live server for only offline environments
                               <br> <span class="c-green">"online"</span> enables the live server for both online and offline environments
                               <br> <span class="c-red">"disabled"</span> suspends the liveserver. <br>
                               <br>
                               It is important to know that there are cases when fatal error may occur during reload or before the live server 
                               is able to reload the page or when live server is switched off (either by code or settings), forcing the live server to trip off. This is known as <code>"KILL EFFECT"</code>. In this situation, 
                               the page must be manually reloaded after the fatal error is fixed or liveserver re-enabled before the liveserver can propely continue. However, 
                               if an error occurs while the live server is monitoring the page (before sending a reload request), then the live server
                               tries to pause the page from reloading while popping up a debug message it could properly match to the type of error that occured.
                               Once the error is fixed, the notification is removed and the page resumes its monitoring. The pop-up is still known to have few bugs as it might be sometimes glitchy.
                           </li><br>

                           <li> <span class="fb-6 c-sky-blue-dd">Resource Meta:</span> <br>
                               Spoova comes with an inbuilt meta tags controller. 
                               When activated, default environment (i.e $_ENV) meta tag settings are applied to all pages during resource importation. 
                               Resource importation is further discussed under <a href="@domurl('docs/resource/grouping')"><span class="c-olive ch-olive  calibri fb-6 font-em-d9 hyperlink">Resource class</span></a> .
                           </li> <br>

                           <li> <span class="fb-6 c-sky-blue-dd">Database Control:</span> <br>
                               Sessions are handled putting into consideration, 
                               the frequently built systems which involves a
                               User-App relationship. In order to control a User-App flow or relationship, 
                               sessions are handled in relation with the database configuration systems. 
                               Building this relationship requires that certain default session-database configurations must be made when initializing a project application.
                               
                               <br><br>The required configurations are stated below: 
                               <br>
                               <br> <span class="fb-6 c-olive-d">1. USER_TABLE</span>
                               <br> <div class="pxs-14">
                                        This refers to the Database table name that contains all users basic information <br>
                                    
                                        <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  USER_TABLE: users;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">2. USER_ID_FIELDNAME</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table unique column set for identifying each user <br> 
                                    
                                       <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example: USER_ID_FIELDNAME: email;</div>
                                        </div>
                                    </div>  
                                <br> <span class="fb-6 c-olive-d">3. COOKIE_FIELDNAME</span> 
                                <br> <div class="pxs-14">
                                        This refers to the Database table column set to store cookies used that may be used for remember me. <br>
                                        
                                        <div class="pxs-14 box-full c-orange-dd bc-white shadow c-wine">
                                            <div class="span pvs-10">Example:  COOKIE_FIELDNAME: cookie;</div>
                                        </div>
                                    </div>  
                               
                           </li> <br>

                           All respective config keys should be placed (or can be found) in the init file (i.e icore/init). 
                           These keys are automatically configured either by the web installer tool or the terminal during configuration. 
                       
                       </ul>
                       
                   </div>
               </div> <br>

               <div class="getting-ready calibri bc-white-dd setup">
                   
                   <div class="c-olive pxv-10 bc-silver">Getting ready</div>

                   
                   <div class="calibri font-em-d85 mvt-5 pxv-10">

                       Spoova does an automatic caliberation of project folder once it is created. It is suggested to keep the name of project folders strictly as 
                       strings without any special characters which may lead to undesired responses. The caliberation system enables the project app to properly 
                       configure the <code class="">.htaccess</code> file. 
   
                       <ul class="list-square mvt-10 pxl-20">
                           <li>
                               Upon a successful installation using the in-built installation tool, 
                               you will be redirected to your app's home page
                           </li> <br>
                           <li>
                               After installation, ensure that your application is properly configured by checking the following files: <br><br>

                               <span class="fb-6 c-orange-dd">.htaccess :</span> <br> Error document should point to your project folder name. <br><br>
                               
                               <span class="fb-6 c-orange-dd">icore/dbconfig.php :</span> <br> File should contain the correct definition of your database configuration for offline or online environments (or both) <br><br>

                               <span class="fb-6 c-orange-dd">icore/init :</span> <br> File should contain other configuration keys and respective values.<br><br>
                               
                               <span class="fb-6 c-orange-dd">Session control :</span> <br> The session class requires a user table which is defined in the "icore/init" file. This must be created before using session class.<br><br>

                               <div class="flex-in midv shadow rad-4">
                                    <div class="box bc-silver c-orange-d pxv-6">
                                        Note
                                    </div>
                                    <div class="bc-white pxv-6 pxl-10 wid-full">
                                        <span class="">
                                            If any of the file above is not properly configured, you can do a manual installation by configuring the required keys yourself.
                                        </span>
                                    </div>
                               </div>

                           </li>
                       </ul>
                       
                   </div>
               </div>
           </div>
       </section>
   </div>
@template;