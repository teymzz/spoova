@template('template.t-doc')

    @lay('build.coords:header')

    <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Sessions</div> <br>
        
        <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Sessions by default are handled by the Session class. 
                The session class depends on series of configurations both in files and code in other to work 
                unanimously. It uses the mysql database connection class to handle user Requests. It is important 
                to configure our session class by following the proceedure listed below: 

                <br><br>
                
                <li>Configuration of init file</li>
                <li>Top level code configuration of session class</li>
                
            </div> 
        </div> <br>

        <div>
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                1. Init File setup
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                The init file <code>icore/init</code> contains few configurations that helps the 
                Session class to properly map itself to the database. In the init file, the following must be configured
                <br><br>
                <ul>
                    <li>USERS_TABLE
                        <div class="mvt-6">The user's main table in database containing user details</div>
                    </li> <br>
                    <li>USERS_FIELD_ID
                        <div class="mvt-6">The user's main table user id field in database containing user details</div>
                    </li> <br>
                    <li>COOKIE_FIELD_NAME
                        <div class="mvt-6">A user cookie field where remember me cookie can be stored.</div>
                    </li>
                </ul>
                </div> <br>
            </div>        
        </div>

        <div>
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                2. Session Setup
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
                Since spoova supports multi-sessions, session class requires a session key and an optional cookie key to run sucessfully. 
                This should be set at the top of your application or project file.
                </div> <br>

                <div class="pre-area"> <br><br>
    <pre class="pre-code">
    new Session('session_key', 'cookie_key');
    </pre>
                </div> <br><br>

                <div class="font-menu">
                    Once the Session class is set, then the User class will become active for use. This is because 
                    the User class depends on the session class to function properly. The Session set above can also 
                    be done on the User class. Hence, the user class can be used to start a session system. This means
                    that the line below is an acceptable replacement for the code above 
                </div> <br>

                <div class="pre-area"> <br><br>
    <pre class="pre-code">
    new User('session_key', 'cookie_key');
    </pre>
                </div> <br><br>

            </div>        
        </div><br>

        <div>
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                3. Channels
            </div> <br><br>


            <div class="">

                <div class="font-menu font-em-1">
                Channels are different session channels that are built on top of a user application.
                The are parallel sessions that are controlled by different channel keys. This allows developers 
                to build sessions that are controlled by different keys, hence, obtaining different user data 
                for different sessions. Since only one top level key session can be attached to a user account, each 
                separate user account can be controlled by its own key separately, for example, you can have a user account and 
                a separate admin account. The user account will obtain its data from its own user channel while the admin account will 
                obtain its data from the admin channel. In order to do this, two separate session (user) files must be created with their 
                own unique keys such as the example below:
                </div> <br>

                <div class="pre-area">
                    <div class="pxv-10 bc-off-white">File 1 - userChannel.php</div> <br><br>
    <pre class="pre-code">
    new Session('user', 'user_cookie');
    </pre>
                </div> <br><br>

                <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x">
                    <div class="pxv-10 bc-off-white">File 2 - adminChannel.php</div> <br><br>
    <pre class="pre-code">
    new Session('admin', 'admin_cookie');
    </pre>
                </div> <br><br>

                <div class="font-menu">
                    In the above examples, two different channel (session) files were created. User related 
                    pages will be connected to the <code>userChannel.php</code> file while admin related pages 
                    will be connected to the <code>adminChannel.php</code> files. By default, all channel files should 
                    be placed in the channels folder. This makes it easier for developers to know the number of channels available 
                    for each project application. Also, channels placed in the channels folder can be included into pages by using the 
                    channels directive. For example: <br><br> Assuming both previously created files exists within the channels folder, then
                    they can be included into pages as shown below:
                </div> <br>

    <!--code started-->
    <div class="pre-area"> <br><br>
    <pre class="pre-code">
    <span class="comment">// adding userChannel to a web page (or file)</span>

    include_once 'icore/filebase.php';

    channel('userChannel');
    </pre>
    </div> <br><br>
    
    
                <div class="font-menu">
                    In the code above, we connected to the framework and loaded userChannel.php file from the channels folder. 
                    Please note that it is not compulsory to add "Channel" to your channels file names. This was done for the purpose of explanation.
                    So, if your channel file's name is <code>user</code>, you can channel your file to the page just by writing <code>channel('user')</code>.
                </div> <br>
            </div>        
        </div><br>

        <div>
            <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
                4. User Class
            </div> <br><br>


            <div class="">
                <div class="font-menu font-em-1">
               The user class bridges the gap between User account and Database control. It makes it easier 
               to set up a User-Session-Database relationship. This relationship makes it easier to 
               perform the following: <br><br>
                <ul>
                    <li>Obtain the user setup configuration</li>
                    <li>Obtain an authenticated user account </li>
                    <li>Run queries on the User class</li>
                    <li>Create a Login - Logout system</li>
                </ul>
                </div> <br>
            </div>     

            <div class="">
                <div class="fb-6">Obtaining the user setup configuration</div> <br>
                <div class="font-em-d9">
                    Assuming we are connected to the user channel, 
                    we can obtain the user configuration setup by calling the 
                    <code>User::config()</code> method.
                </div> <br>
                
                <div class="">
                  
    <!-- code line started -->
    <div class="pre-area"> <br><br>
    <pre class="pre-code">
    include_once 'icore/filebase.php';

    channel('userChannel');

    <span class="comment">// returns the user configurations </span>
    var_dump( User::config() );
    </pre>
    </div> <br><br>  
    <!-- code line ended -->
                    
                    <div class="font-em-d9">
                        The <code>User::config()</code> returns the user configurations. This includes the
                        user database table name, user database id field, user session key and cookie key names, 
                        user cookie database table field name, the current user connection name and the connected user 
                        id. The user id is dependent on the session connected. For example, an admin channel will return the 
                        admin id once logged in, while a user channel will return a user id once logged it. In this manner,
                        channels (or sessions) can be easily logged out just by calling the <code>User::logout()</code> method. 
                    </div> <br>
                </div>

                
            </div>

            <div class="">
                <div class="fb-6">Obtaining an authenticated user account</div> <br>
                <div class="font-em-d9">
                    Assuming we are connected to the user channel as before, we can obtain the user id and user data 
                    through the User class.
                </div> <br>
                
                <div class="">
                    <div class="pre-area"> <br><br>
    <pre class="pre-code">
    User::id(); <span class="comment">// Returns the user id of a currently authenticated account</span>
    
    User::config('CONFIG_KEY'); <span class="comment">// Returns the value of a specific configuration key e.g SESSION_NAME returns the current session name</span>
    </pre>
                    </div> <br><br>                
                    <div class="font-em-d9">
                        When a user is currently authenticated, the user class is capable of returning a user database authentication handler. This is discussed below. 
                    </div> <br>
                </div>
            </div>

            <div class="">
                <div class="fb-6">Running queries in User Class</div> <br>
                <div class="font-em-d9">
                    When a user is logged in, User class returns an authentication class from its <code>auth()</code> method that is capabale of running queries. 
                    The authentication returned performs its operation based on user configurations.
                </div> <br>
                
                <div class="">
                  
    <!--code started-->
    <div class="pre-area"> <br><br>
    <pre class="pre-code">
    $auth = User::auth();
    </pre>
    </div> <br><br>   
    <!--code ended-->
    
                    <div class="font-em-d95">
                        The <code>auth()</code> above can be used to perform direct queries on the user class or database class. Some of the actions that can be performed on the User class includes : <br>
                        
                        <ul>
                            <li>Find data related to specific user by using the <code>find()</code> directive </li>
                            <li>Returns the specific database connection a currently authenticated user uses through the <code>dbcon()</code> directive </li>
                            <li>Modify the default <code>dbconfig.php</code> connection of a User through the use of <code>User::auth()</code> directive 
                            by creating new database connection and supplying it as argument just as shown below: <br><br>

    <!-- code started -->
    <div class="pre-area"> <br><br>
    <pre class="pre-code">
        $db = ($dbc = new DB)->openDB('newdb','newuser','newpass','newport','newserver');

        $auth = User::auth($db, $dbc);
    </pre>
    </div> <br><br>   
    <!-- code ended -->
                                <div class="font-em-d97 font-menu">
                                    In the code above, the User class is used to update the default connections set in <code>dbconfig.php</code> file. 
                                    Every other subsequent connections will obtain their configuration from the last update instead of the default config file.
                                </div> <br>
                            </li>
                        </ul>


                    </div> <br>
                </div>
            </div>


               
        </div>    

       
        @lay('build.links:tutor_pointer')
    </div>

@template;