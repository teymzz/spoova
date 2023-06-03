
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="">

            @lay('build.co.links:tutor_pointer')
            <br>
            <div class="start helvetica font-em-d87"> 

                <div class="c-orange font-em-1d5"> <i class="bi-person-gear"></i> Handling Users</div> <br>
                
                <div class="resource-intro">
                    <div class="">
                        Spoova creates a User-Database relationship which makes its easier to control user accounts. 
                        This relationship makes it possible to perform simple operations like login and logout, account 
                        auto redirection, account information e.t.c just in a few number of lines. The <code>User</code> 
                        class is an extension of the <a href="@domurl('docs/sessions/session')" class="hyperlink">Session</a> class. 
                        Hence, it has access to most of the <code>Session</code> class static methods. 
                        However, it also handles the User session account using some specific static methods that will be discussed 
                        below.
                        <br><br>

                        <p>
                            In order for the User class to be able to link to database, it is important to configure the <code>init</code> 
                            file with require user details. The <code>init</code> file contains some basic user information that is 
                            neccessary for the <code>User</code> class to use to connect to the proper user database column in the default 
                            database name set in the <code>dbconfig.php</code> file. This means that both the <code>dbconfig.php</code> and <code>init</code>
                            must be properly configured in order for the <code>User</code> class to be able to pick up some basic User information from the database. 
                        </p>

                        <p class="c-orange-dd">
                           Although, part of this have been discussed on the session class documentation, Some of the earlier discussed may be referenced on this page 
                           with the assumption that the configuration files have been properly set.
                        </p>

                    </div>
                </div> <br>

                <div class="">
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8 ">
                        <span class="bi-circle-fill c-silver-d"></span> Helper Methods
                    </div> <br>

                    <div class="mvt-10">
                        <div class="">
                            Assuming that we have properly set up our configuration files, the <code>User</code> class provides us with certain useful static method 
                            that can be used to either obtain the User information from the database or perform queries on the database itself.
                            <br><br>

                            <ul class="c-olive bc-white-dd pvs-10">
                                <li>User::config()</li>
                                <li>User::tableName()</li>
                                <li>User::id()</li>
                                <li>User::auth()</li>
                            </ul>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::config()</div>
                                <div class="">
                                    <div class="">
                                        <div class=" pvs-10"> This method returns certain important user configuration data details such as:</div>
                                        <div class="mvt-6 font-em-d85">
                                            <div class="mvs-6"><span class="c-orange-dd">DBNAME</span> =>  current database name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">USER_TABLE</span> =>  the user table name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">SESSION_NAME</span> => current session key name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">COOKIE_NAME</span> => current cookie name.</div>
                                            <div class="mvs-6"><span class="c-orange-dd">USER_ID_FIELD_NAME</span> => current user id field name in user database table (i.e USER_TABLE).</div>
                                            <div class="mvs-6"><span class="c-orange-dd">COOKIE_FIELD_NAME</span> => current cookie field name in database table (i.e USER_TABLE).</div>
                                        </div>
                                    </div>                                
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::tableName()</div>
                                <div class="pvs-10">
                                    This is an helper method that quickly returns the currently connected User default table name which contains all 
                                    user information. which is equivalent to "USER_TABLE" discussed earlier under the <code>User::config()</code> method
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::id()</div>
                                <div class="pvt-10">
                                This method returns the current user id for a logged in user. It is important that in order for a userid 
                                to be returned, the following must have occurred: <br><br>                                  
                                <ol class="pxl-14 font-em-d87">
                                    <li>
                                        The <span class="c-orange-dd">USER_TABLE</span> must have been previously set in the configuration
                                    </li>
                                    <li>
                                        The <span class="c-orange-dd">USER_ID_FIELD_NAME</span> must have been previously set in the configuration
                                    </li>
                                    <li>
                                        A userid must be stored when logging in whose value exists in <span class="c-orange-dd">USER_ID_FIELD_NAME</span> 
                                        in the database <span class="c-orange-dd">USER_TABLE</span>
                                    </li>
                                    <li>
                                        A user session must be active based on the predefined configurations
                                    </li>
                                </ol> 
                                </div>
                            </div> <br>

                            <div class="bc-white-dd pxv-10">
                                <div class="c-olive">User::auth()</div>
                                <div class="pvs-10">
                                    This method returns some basic user information which includes current user id, primary user id and current user connection. 
                                    This method returns the <code>UserAuth</code> class. Hence the following can be chained on this method:
                                        
                                    <ul class="font-em-d87 pvs-10 pxl-20 list-square">
                                        <li><b class="c-teal ">User::auth()->db()</b> : This returns the <code>DB</code> class</li>
                                        <li><b class="c-teal ">User::auth()->dbh()</b> : This returns the <code>DBHandler</code> class with its current user connection</li>
                                        <li><b class="c-teal ">User::auth()->id()</b> : This returns the currently authenticated user id for a session user account if called as a string</li>
                                        <li><b class="c-teal ">User::auth()->id()->main()</b> : This returns the currently authenticated user primary id for a session account. 
                                        <li><b class="c-teal ">User::auth()->id()->primary()</b> : This returns the <code>current</code> authenticated user primary id for a session account. 
                                        This can only be obtained if each user has an auto generated primary "id" field in the user's database table.
                                        </li>
                                    </ul>  
                                    
                                    Rather than setting up a new connection, the <code>User::auth()</code> method returns the default user connection if not previously modified 
                                    using the same method. This method only reflects that the Framework handles the entire User connection using the default connection parameters set in the 
                                    <code>dbconfig.php</code> file. This means that, provided all default configurations are set, running queries will be as simple as :
                                    <br><br>   
                                        
                                    <div class="pre-area bc-white">
    <pre class="pre-code">
  if($db = User::auth()->dbh()){
  
      $auth->query('select * from users')->read();
      $results = $auth->results();
  
  }
    </pre>                                    

                                    </div> 
                                
                                </div>
                            </div>

                        </div>
                    </div>        
                </div> <br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> Session Setup
                    </div> <br><br>


                    <div class="">
                        <div class=" ">
                        Since spoova supports multi-sessions, session class requires a session key and an optional cookie key to run sucessfully. 
                        This should be set at the top of your application or project file.
                        </div> <br>

                        <div class="pre-area shadow">
            <pre class="pre-code">
  new Session('session_key', 'cookie_key');
            </pre>
                        </div> <br><br>

                        <div class="">
                            Once the Session class is set, then the User class will become active for use. This is because 
                            the User class depends on the session class to function properly. Since the User class is an extension 
                            of the Session class. Hence, a session can also be started from the user class.
                        </div> <br>

                        <div class="pre-area shadow">
            <pre class="pre-code">
  new User('session_key', 'cookie_key');
            </pre>
                        </div> <br><br>

                    </div>        
                </div><br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> Session accounts
                    </div> <br><br>


                    <div class="">

                        <div class=" ">
                        Session accounts may be separated using <code>Frames</code>. Frames are container classes for window files 
                        hence may contain data that are specific to certain window files which may not necessarily be available in other 
                        window files. Since <code>Frames</code> a extensions of Windows, they have access to all window methods. The 
                        <code>super()</code> method is a window method that contains all logic that must occur before a window is loaded. 
                        This gives us access to configure our session keys within the a specific session frame which can then be extended to by 
                        our window classes. Since only one top level key session can be attached to a user account, each 
                        separate user account can be controlled by its own key separately, for example, you can have a user account and 
                        a separate admin account. The user account will obtain its data from its own user session group while the admin account will 
                        obtain its data from the admin's separate group. In order to do this, two separate session (user) files or frames must be created with their 
                        own unique keys such as the example below:
                        </div> <br>

                        <div class="pre-area shadow">
                            <div class="pxv-10 bc-silver">File 1 - UserFrame.php</div>
            <pre class="pre-code">
    &lt;?php

    namespace spoova\mi\windows\Frames;
    
    use Window;

    class UserFrame extends Window {

        function super() {

            new Session('user', 'user_cookie');

        }

    }
            </pre>
                        </div> <br><br>

                        <div class="pre-area shadow">
                            <div class="pxv-10 bc-silver">File 2 - AdminFrame.php</div>
            <pre class="pre-code">
    &lt;?php

    namespace spoova\mi\windows\Frames;
    
    use Window;

    class AdminFrame extends Window {

        function super() {

            new Session('admin', 'admin_cookie');

        }

    }
            </pre>
                        </div> <br><br>

                        <div class="">
                            In the above examples, two different channel (session) files were created. User related 
                            pages (or routes) will be can be extended to the <code>UserFrame.php</code> file while admin related pages 
                            can be connected to the <code>AdminFrame.php</code> files. Session files may be separated from other frame files to keep track of 
                            where session files are declared. 
                        </div>

                    </div>        
                </div><br>

                <div>
                    <div class="c-olive bc-white-dd box-full rad-4 pxv-8">
                        <span class="bi-circle-fill c-silver-d"></span> User Session Control
                    </div> <br><br>


                    <div class="">
                        <div class=" ">
                            The User class can be used to control the activity and response of a session which includes storing of data and user redirection. 
                            The setting up of a user account system involve three(3) main steps: <br><br>

                            <ul>
                                <li>Data Storage and Retrieval</li>
                                <li>Session storage</li>
                                <li>Session redirection</li>
                            </ul>

                        </div>
                    </div>     

                    <div class="bc-white-dd pxv-10">
                        <div class="c-olive">Data Storage and Retrieval</div> <br>
                        <div class="">
                            <p>
                                Data storage is mostly handled through the <code>Model</code> and <code>Form</code> class. 
                                The <code>Form</code> is supplied a model which contains authentication rules for form inputs and mapping 
                                of form inputs to database columns. Once the form is authenticated, the data can be saved using the <code>Form::isSaved()</code> 
                                method which saves the data to the model's defined database table.
                            </p>
                            <p>
                                Once a data is stored, then it can be fetched through using the <code>DB</code> class. The means of data retreival mostly depends on the 
                                developer. However, because the Model's Eloquent <code>ORM</code> structure is not fully integerated with the application, it is better to use the 
                                <code>DB</code> class which has a wider range of support.
                            </p>
                        </div> 
                        
                    </div> <br>

                    <div class="bc-white-dd pxv-10">
                        <div class="c-olive">Session Storage</div> <br>
                        <div class="">
                            When a session is authenticated, the data of the user is expected to be stored in the session which can be retrieved later. 
                            In most cases only specific essential data which is required to keep a session active is mostly stored in the session. This 
                            data is expected to be authenticated before each request sent can obtain a session's data. The <code>User::login()</code> 
                            method allows us to store our data into the session by simply supplying the user data in the format: 
                        </div> <br>
                        
                        <div class="">
                        
            <!-- code line started -->
            <div class="pre-area shadow">
            <pre class="pre-code">
  $userdata = ['userid' => 'someid'];

  User::login( $userdata );
            </pre>
            </div> <br><br>  
            <!-- code line ended -->
                            
                            <div class="">
                            In the above code format, the <code>someid</code> is a unique id that must be found in the init-defined <code>"USER_ID_FIELDNAME"</code>. 
                            If the corresponding column set in the init file does not contain the <code>someid</code>, the data is never stored if such session is defined as  
                            secured. This is explain in the <a href="@domurl('docs/sessions/session')">Session</a> documentation. The <code>User::login()</code> method also 
                            manages the storage of a <code>cookie_key</code> which is binded to the session.
                            </div> <br>
                        </div>

                        
                    </div> <br>

                    <div class="bc-white-dd pxv-10">
                        <div class="c-olive">Session redirection</div> <br>
                        <div class="">

                            <p>
                                A session redirection occurs in two format. This includes logging in and logging out of a session account. 
                                While the <code>User::login()</code> stores the user data in the session storage, it is also capable 
                                of redirecting the user to a new url once the session data is successfully stored. This is done by supplying the 
                                redirection url as a second parameter on the <code>login()</code> method. For example, the code syntax: 
                                <code>User::login(['userid'=>'someid'], 'home')</code> would mean that a session data should be stored and a redirection 
                                to the <code>home</code> should be made. This would be applied only when the user data has been validated and retrieved 
                                from the database.
                            </p>

                            <p>
                                The <code>User::login()</code> also take a third parameter which defineds the maximum lifetime of a cookie. By default, this 
                                is set as <code>86400</code> which is equivalent to 1 day. This can be modified as desired. For example <code>User::login(data, url, 60)</code> 
                                would mean that the cookie generated or retrieved from database should only last for 60 seconds.
                            </p>

                            <p>
                                Also, the <code>User::logout()</code> method ensures that an active session is terminated. Once this method is called on 
                                an active session, the session will be terminated. The <code>User::logout()</code> not only ensures that the session is terminated, 
                                it also terminates the cookie key if it exists and supplying a url within the <code>logout()</code> method will ensure that a redirection 
                                is made to the defined url once the session is terminated.
                            </p>

                            <p>
                                Lastly, as an added feature on the <code>User::logout()</code> method, a session cookie can be revoked from the database. In this case, 
                                any stored cookie which is binded the user data in the database will be nullified and a new one generated once a user logs in and the rememberMe feature is used.
                                In order to achieve this, the <code>User::logout()</code> method must be supplied a logout url followed by a <code>true</code> argument. For example, 
                                <code>User::logout('index', true)</code> will revoke the cookie key, terminate a session and redirect the user to <code>index</code> page. 
                            </p>


                        </div>

                        
                    </div> <br>



                    <div class="">
                        <div id="running-queries" class="fb-6 c-olive">Running queries from User Class</div> <br>
                        <div class="">
                            User class returns an authentication class from its <code>auth()</code> which is the <code>UserAuth</code> class. This class 
                            has a method <code>dbh()</code> which returns the database handler class only if a session is active. If a session is not 
                            active, the <code>dbh()</code> method will return null. The <code>DBhandler</code> class returned is always specfic to the current user session. 
                            Hence, rather than opening a new connection, we can retrieve the current user connection from the <code>User::dbh()</code> 
                            method and perform our queries through that <code>DBHandler</code> class returned.
                        </div> <br>
                        
                        <div class="">
                        
            <!--code started-->
            <div class="pre-area shadow">
            <pre class="pre-code">
  $auth = User::auth();

  if($db = $auth->dbh()) {

    <span class="comment">Session is active, run query</span>

  }
            </pre>
            </div> <br><br>   
            <!--code ended-->
            
                            <div class="5">
                                Some of the actions that can be performed on the User class include : <br><br>
                                
                                <ul class="pxl-14">
                                    <li>Modify the default <code>dbconfig.php</code> connection of a User through the use of <code>User::auth()</code> directive 
                                    by creating new database connection and supplying it as argument just as shown below: <br><br>
                                
                                        <!-- code started -->
                                        <div class="pre-area shadow">
    <pre class="pre-code">
  $db = ($dbc = new DB)->openDB('db','user','pass','port','server');
    
  $auth = User::auth($db, $dbc); <span class="comment">// use a new connection </span>
    </pre>
                                        </div> <br><br>   
                                        <!-- code ended -->

                                        <div class=" ">
                                            In the code above, the <code>DB</code> class is used to update the default connections of the <code>User</code> class set in <code>dbconfig.php</code> file. 
                                            Every other subsequent connections will obtain their configuration from the last update instead of the default config file.
                                        </div>
                                    </li>    

                                    <li class="mvt-10">Return the specific database connection a currently authenticated user uses through the <code>dbcon()</code> directive </li>
                                    
                                    <li>Return the authenticated user database handler class when <code>dbh()</code> method is called upon it. </li>
                                
                                    <li>
                                        Find data related to the defined user table by using the <code>find()</code> directive 
                                
    <!-- code started -->
    <div class="pre-area shadow mvt-10">
    <pre class="pre-code">
  $db = $auth->dbh();

  $db->where('userid = ?', [1])->find('username'); <span class="comment">//returns username from the user database table name</span>
    </pre>
    </div> <br><br>   
    <!-- code ended -->
                                    </li>

                                </ul>


                            </div>
                        </div>
                    </div>


                    
                </div>    
            
                @lay('build.co.links:tutor_pointer')
            </div>
        </div>
    </section>
</div>
@template;