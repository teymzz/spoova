
@template('template.t-doc')

    @lay('build.coords:header')

        <section class="pxv-20 installation">
            <div class="font-em-1d2">

                @lay('build.links:tutor_pointer')

                <div class="start">
                    <div class="font-em-1d5 c-orange">Starting a project</div> <br>
                    
                    <div class="font-em-d85 i c-blue-d">
                        It is strongly advised to learn about the features of this framework
                        before proceeding with configuration. You can learn about the features 
                        <span class="c-orange-dd">
                            <a href="@DomUrl('about')" class="inherit">here</a>
                        </span> 
                    </div> <br>
                    
                    <div class="">Application config</div> <br>

                    <div class="font-menu font-em-d8">
    
                        <ul class="list-square">
                            <li>Download the spoova frame project pack file online from here</li>
                            <li>Place the project pack into your root web folder (offline or online)</li>
                            <li>From the cli navigate to spoova pack core folder (i.e spoova/core)</li>
                            <li>Run the cli command : <span class="fb-6 c-black-ll"> php spoova project <span class="c-gold-dd">app</span></span> where "app" is your new project folder name </li>
                            <li> Open your project on the browser and navigate to install (e.g http://localhost/app/install)</li>
                            <li> Note: Process above must be repeated whenever your project folder name is changed </li>
                            <li> From the installation page (i.e install), you can set up your database enviroment settings </li>
                            <li> For spoova to run efficiently, database configuration along with other basic configurations should be updated with valid credentials. </li>
                            <li> All database configurations are saved into the icore/dbconfig folder for both offline and online environments </li>
                            <li> When using the inbuilt web installation tool, you can choose the hard install option on the home page to reset previously defined configurations </li>
                            <li> The spoova project pack with name "spoova" should not be renamed or deleted </li>
                        </ul>
                        
                    </div>
                </div>

                <div class="setup">
                    <div class="">Setup config</div> <br>
                    <div class="font-menu font-em-d8">
    
                        <ul class="list-square">
                            <li>Basic setup includes live server, resource meta and session control</li><br>
                            <li>Live Server: <br>
                                Spoova comes with an internal php live server. 
                                Attached to the live server is a live debug system (beta) 
                                running upon the live server. Live server is divided into two environments which are offline and online.
                                
                                <br><br>Setting your resource can be for: <br>
                                <br> "offline" enables the live server for only offline environments
                                <br> "online" enables the live server for both online and offline environments
                            </li> <br>

                            <li>Resource Meta: <br>
                                Spoova comes with an inbuilt meta tags controller. 
                                When activated, default environment (i.e ENV) meta tag settings are applied to all pages during resource importation. 
                                Resource importation is further discussed under File Control Systems.
                            </li> <br>

                            <li>Database Control: <br>
                                Sessions are handle by putting into consideration, 
                                the frequently built app systems which involves the
                                User-App relationship. In order to control the User-App flow, 
                                Sessions are handled in relation with the database configuration systems. 
                                In order to recognize this flow, certain default session-database configurations must be made when initializing your application.
                                
                                <br><br>The required configurations are stated below: 
                                <br>
                                <br>1. User Database Table Name (USER_TABLE) : 
                                <br> <span class="pxs-14">Database table name that contains all users basic information</span>  <br>

                                <br>2. User Database Table ID Field (USER_ID_FIELDNAME): 
                                <br>This points to the database table field name that contains the specific user id.</span>  <br>
                            </li> <br>

                            All respective config keys should be place (or can be found) in the init file (i.e icore/init). 
                            By using the frameworks installation tool, these fields will be automatically added at each installation phase.
                        
                        </ul>
                        
                    </div>
                </div>

                <div class="getting-ready">
                    
                    <div class="">Getting ready</div> <br>

                    <div class="font-menu font-em-d8">
    
                        <ul class="list-square">
                            <li>
                                Upon a successful installation using the inbuilt installation tool, 
                                you will be redirected to your app's home page
                            </li> <br>
                            <li>
                                Ensure that your application is properly configured by checking the following files: <br><br>

                                <span class="fb-6">.htaccess :</span> <br> Error document must point to your project folder name <span class="c-red">(strictly important!)</span> <br><br>
                                
                                <span class="fb-6">icore/dbconfig.php :</span> <br> File must contain the correct definition of your database configuration for offline or online environments (or both) <br><br>

                                <span class="fb-6">icore/init :</span> <br> File must contain database setup configurations. <br><br>

                                <span class="font-i">
                                    If any of the file above is not properly configured, you can do a manual installation by configuring the required keys yourself.
                                </span>

                            </li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </section>
    
    @lay('build.coords:footer')

@template;