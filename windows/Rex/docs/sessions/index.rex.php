
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange"> <i class="bi-person-fill"></i> Sessions</div> <br>
                    
                    <div class="resource-intro">
                        <div class="">
                            Sessions by default are handled by the <a href="@route('::session')" class="hyperlink">Session</a> class. 
                            The session class depends on series of configurations both in files and code in other to work 
                            unanimously. It uses the mysql database connection class to handle user Requests. It is important 
                            to configure our session class by following the procedure listed below: 

                            <br><br>
                            
                            <ul>
                                <li>Configuration of init file</li>
                                <li>Top level code configuration of session class</li>
                            </ul>
                            
                        </div> 
                    </div> <br>

                    <div>
                        <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            1. Init File setup
                        </div> <br><br>

                        <div class="">
                            <div class=" font-em-d9">
                            The init file <code>icore/init</code> contains few configurations keys and values pairs 
                            that help the Session class to properly map itself to the database. These keys are listed and 
                            discussed below:
                            <br><br>
                            <ul>
                                <li>USERS_TABLE
                                    <div class="mvt-6">The user's main table in database containing user details</div>
                                </li> <br>
                                <li>USER_ID_FIELDNAME
                                    <div class="mvt-6">The user's main table user id field in database containing user details</div>
                                </li> <br>
                                <li>COOKIE_FIELDNAME
                                    <div class="mvt-6">A user cookie field where remember me cookie can be stored.</div>
                                </li>
                            </ul>
                            </div>
                            <div class="foot-note">
                                The configuration keys are usually handled automatically from the command-line using the <code>config</code> 
                                command. The format below defines a sample format of how the configuration keys are expected to be defined.
                            </div>
                            <div class="pre-area">
                                <pre class="pre-code">
  USERS_TABLE: users;
  USER_ID_FIELDNAME: email;
  COOKIE_FIELDNAME: cookie;
                                </pre>
                            </div>
                        </div>        
                    </div> <br>

                    <div>
                        <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            2. Session Setup
                        </div> <br><br>


                        <div class="">
                            <div class=" font-em-d9">
                            Since spoova supports multi-sessions, session class requires a session key and an optional cookie key to run sucessfully. 
                            This should be set at the top of your application or project file.
                            </div> <br>

                            <div class="pre-area shadow">
                <pre class="pre-code">
  new Session('session_key', 'cookie_key');
                </pre>
                            </div> <br><br>

                            <div class=" font-em-d9">
                                Once the Session class is set, then the User class will become active for use. This is because 
                                the User class depends on the session class to function properly. The Session set above can also 
                                be done on the User class. Hence, the user class can be used to start a session system. This means
                                that the line below is an acceptable replacement for the code above 
                            </div> <br>

                            <div class="pre-area shadow">
                <pre class="pre-code">
  new User('session_key', 'cookie_key');
                </pre>
                            </div> <br><br>

                        </div>        
                    </div><br>

                    <div>
                        <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            3. Session Channels
                        </div> <br><br>


                        <div class="">

                            <div class=" font-em-d9">
                            Session channels are different session accounts that are built on top of the user application.
                            They are parallel sessions that are controlled by different session keys. This provides an easy 
                            structure in building sessions which contains data that can be obtained based on its predefined access key 
                            . Since just a single top level session key can be attached to a session account, each 
                            separate session account is controlled by its own unique key separately. For example, you can have a user account and 
                            a separate admin account. The user account will obtain its data from its own user session while the admin account will 
                            obtain its data from the admin session. In order to do this, two separate session (user) files must be created with their 
                            own unique keys such as the example below:
                            </div> <br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">File 1 - UserAccount.php</div>
                <pre class="pre-code">
  new Session('user', 'user_cookie');
                </pre>
                            </div> <br><br>

                            <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                                <div class="pxv-10 bc-silver">File 2 - AdminAccount.php</div>
                <pre class="pre-code">
  new Session('admin', 'admin_cookie');
                </pre>
                            </div> <br><br>

                            <div class="font-em-d87">
                                In the above examples, two different session files were created. User related 
                                pages will be connected to the <code>UserAccount.php</code> file while admin related pages 
                                will be connected to the <code>AdminAccount.php</code> files. By default, all session files should 
                                be placed in the <code>windows/Sessions</code> directory. This makes it easier for developers to know the number of session accounts that are available 
                                for each project application. The session files placed in the predefined session directory can be included into pages by using the 
                                <code>session()</code> function. For example: Assuming both previously created files exists within the accounts folder, then
                                they can be included into the top of the window frame classes as shown below:
                            </div> <br>

                <!--code started-->
                <div class="pre-area">
                    <div class="pxv-10 bc-silver">Example - adding UserAccount to a Frame Class</div>
                <pre class="pre-code">
  &lt;?php

    <span class="comment no-select">...namespace here...</span>

    session('UserAccount');

    class UserFrame {

    }
                </pre>
                </div> <br>
                
                
                            <div class="font-em-d9">
                                In the code above, we connected to the framework and loaded UserAccount.php file from the <code>windows/Sessions</code> directory.
                                So, if your account file's name is <code>User</code>, you can access your session main keys just by writing <code>session('User')</code>.
                                Since <code>Frames</code> have a <code>super()</code> method functionality, the <code>Account('UserAccount')</code> can also be placed in the 
                                super method. However, it is preferred to use the method above to load sessions accounts because a child window file will easily inherit the 
                                parent session keys if the method above is used.
                            </div> <br>
                        </div>        
                    </div>

                    <div>
                        <div class=" fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                            4. User Class
                        </div> <br><br>


                        <div class="">
                            <div class=" font-em-1">
                        The user class bridges the gap between User account and Database control. It makes it easier 
                        to set up a User-Session-Database relationship. This relationship makes it easier to 
                        perform the following: <br><br>
                            <ul>
                                <li>Obtain the user setup configuration</li>
                                <li>Obtain an authenticated user account </li>
                                <li>Run queries on the User class</li>
                                <li>Create a structured communication between a Login and Logout system</li>
                            </ul>
                            </div> <br>
                        </div>     

                        <div class="">
                            <div class="fb-6 c-olive">Obtaining the user setup configuration</div> <br>
                            <div class="font-em-d9">
                                Assuming we are connected to a user session file, 
                                we can obtain the user configuration setup by calling the 
                                <code>User::config()</code> method.
                            </div> <br>
                            
                            <div class="">
                            
                <!-- code line started -->
                <div class="pre-area shadow">
                <pre class="pre-code">
  session('UserAccount');

  <span class="comment">// returns the user configurations </span>
  var_dump( User::config() );
                </pre>
                </div> <br><br>  
                <!-- code line ended -->
                                
                                <div class="font-em-d87">
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
                            <div class="fb-6 c-olive">Obtaining an authenticated user account</div> <br>
                            <div class="font-em-d9">
                                Assuming we are connected to the user channel as before, we can obtain the user id and user data 
                                through the User class.
                            </div> <br>
                            
                            <div class="">
                                <div class="pre-area shadow">
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
                            <div class="fb-6 c-olive">Securing sessions</div> <br>
                            <div class="font-em-d9">
                                The session class provides a means to strictly validate the authenticated session using the method 
                                <code>Session::secure(true)</code>. This tells the session to perform the following operations: <br>

                                <ol>
                                    <li>Get the configured user database table where user data is expected to be stored</li>
                                    <li>Get the configured database tables's user id field(or column)</li>
                                    <li>Get the current user id (i.e <code>User::id()</code>)</li>
                                    <li>Check if the user id in 3 above exists in the user id field</li>
                                </ol>

                                The essence of the security is that the developer cannot create a fake userid because the Session 
                                class will try to ensure that the <code>User::id()</code> (same as <code>User::id()->main()</code>) exists within the database. This means that for this 
                                security system to work, the session's userid value stored must be found in the corresponding <span class="c-teal">USER_ID_FIELDNAME</span>
                                column name that is configured within the <code>icore/init</code> file. If these two data does not match, 
                                the session will be logged out. This behaviour can also be enabled by setting the third argument of an instantiated Session 
                                to true just as below:
                            </div> <br> 
                            
    <div class="pre-area">
        <pre class="pre-code shadow">
  new Session('user', 'cookie', true); <span class="comment">// secured session</span>
        </pre>              
    </div> <br><br>
                        </div>

                        <div class="">
                            <div class="fb-6 c-olive">Running queries in User Class</div> <br>
                            <div class="font-em-d9">
                                When a user is logged in, User class returns an authentication class from its <code>auth()</code> method that is capable of running queries. 
                                The authentication returned performs its operation based on user configurations.
                            </div> <br>
                            
                            <div class="">
                            
                <!--code started-->
                <div class="pre-area shadow">
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
                <div class="pre-area shadow">
                <pre class="pre-code">
  $db = ($dbc = new DB)->openDB('newdb','newuser','newpass','newport','newserver');

  $auth = User::auth($db, $dbc);
                </pre>
                </div> <br><br>   
                <!-- code ended -->
                                            <div class="font-em-1">
                                                In the code above, the User class is used to update the default connections set in <code>dbconfig.php</code> file. 
                                                Every other subsequent connections will obtain their configuration from the last update instead of the default config file.
                                            </div> <br>
                                        </li>
                                    </ul>


                                </div> <br>
                            </div>
                        </div>


                        
                    </div>    

                
                    @lay('build.co.links:tutor_pointer')
                </div>
            </div>
        </section>
    </div>
@template;