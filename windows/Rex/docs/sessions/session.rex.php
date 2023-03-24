
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Sessions</div> <br>
                
                <div class="resource-intro">
                    <div class="">
                        Sessions are controlled by the session class which includes some important helper methods. 
                        The session configuration is mainly handled by the <code>icore/init</code> file. This means that the 
                        init file and the Session class are both linked. For session to be properly managed, the <code>init</code> 
                        file must be configured with valid parameteer. The code below reveals the syntax of the <code>init</code> 
                        file.
                        <br>

                        <div class="code">
                            <!-- code begins -->
                            <div class="pre-area mvs-10">
                            <div class="pxv-10 bc-silver">
                                Init File Sample Format
                            </div>
                            <pre class="pre-code">
  USER_TABLE: users;
  COOKIE_FIELDNAME: cookie;
  USER_ID_FIELDNAME: email;
  ...                                         
                                </pre>
                            </div>

                            <!-- code description -->
                            <div class="font-em-d87">
                                The setup syntax above is used to explain the Session class control system 

                                <div class="">
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>USER_TABLE:</code> <span>This table is expected to be the user table where user data is stored.</span></div>                                     
                                    </div>
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>COOKIE_FIELDNAME:</code> <span>A database column in USER_TABLE where cookie hash is stored</span></div>
                                    </div>
                                    <div class="flex mvs-6">
                                        <div class="clip-120"><code>USER_ID_FIELDNAME:</code> <span>A database column in USER_TABLE that contains the user unique id</span></div>
                                    </div>
                                </div>

                                <div class="mvt-10">
                                    Once the <code>init</code> file is configured, the Session class can then be properly initialized within our application.
                                </div>
                            </div>                            
                        </div> <br>
                        

                        <div class="mvt-10">
                            <div class="c-orange">Session Initialization</div>
                            <div class="mvt-10">
                                The session class can be initialized using the format below<br><br>

                                <div class="">
                                    <div class="pxv-10 bc-silver">
                                        Syntax: Session class initialization 
                                    </div>
                                    <div class="pre-area">
                                        <pre class="pre-code">
  new Session($session_key, $cookie_key, $secure);

  <span class="comment">
  where: 
    
    $session_key       : an array key where user data is stored on.

    $cookie_key        : an array key where rememberMe cookie hash is stored on.

    $secure (optional) : defines if a session should be secured (true|false)


    
    Note: For the purpose of this documentation 

    $session_key => session_key 

    $cookie_key  => cookie_key 

    $secure      => secure
  </span>
                                        </pre>
                                    </div>
                                    <div class="font-em-d87 pxv-10 bc-off-white-dd hide">
                                        The session class requires that a <code class="c">$session_key</code> should be defined. This key will be used 
                                        by <code>$_SESSION</code> to store the user data once logged into a session. The <code>$cookie_key</code>, 
                                        though optional, helps the <code>$_COOKIE</code> global variable to identify where to store a cookie hash key.
                                        The entire relationship between the <code>$_SESSION</code> and <code>$_COOKIE</code> class will then be synced. Once 
                                        the relationship is defined, then we can log in or log out of a session with ease.
                                    </div> <br><br>

                                    <div class="">
                                        <div class="">Session(session_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            The session_key defined during the instantiation of the session class is a key that is used to store user data inside 
                                            the global <code>$_SESSION</code> variable. Hence, we can retrieve our data using the defined session_key 
                                            (e.g <code>$_SESSION[session_key]</code>). The session class requires that data stored in the 
                                            <code>$_SESSION[session_key]</code> must have a <code>userid</code>. This means that our session variable will be in the format 

                                            <code>$_SESSION[session_key]['userid']</code>. The session class will look for its userid from the <code>USER_ID_FIELDNAME</code> 

                                            (e.g email) column that must exist in the database.

                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="">Session(cookie_key)</div>

                                        <div class="font-em-d87 mvt-10">
                                            Just like the session_key, the cookie_key is used by the <code>$_COOKIE</code> class to store a user cookie for rememberMe. 
                                            Although, defining this key is optional, it is mostly required even if it is not used. When this value is defined, we can then set up a 
                                            remeberMe on our forms easily. If a session is logged out but its access cookie is active, the session class will look for the active value 
                                            in the database table's field relative to <code>COOKIE_FIELD_NAME</code> declared in the init file. This value will help to log the user back 
                                            if the hashed value stored is active. 
                                            
                                            defined during the instantiation of the session class is a key that is used to store user data inside 
                                            the global <code>$_SESSION</code> variable. Hence, we can retrieve our data using the defined session_key 
                                            (e.g <code>$_SESSION[session_key]</code>). The session class requires that data stored in the 
                                            <code>$_SESSION[session_key]</code> must have a <code>userid</code>. This means that our session variable will be in the format 

                                            <code>$_SESSION[session_key]['userid']</code>. The session class will look for its userid from the <code>USER_ID_FIELDNAME</code> 

                                            (e.g email) column that must exist in the database.

                                        </div><br>
                                    </div>

                                    <div class="">
                                        <div class="">Session(secure)</div>

                                        <div class="font-em-d87 mvt-10">
                                           A layer of security can be added to our session class which ensures that a fake id cannot create an active session. By setting  
                                           <code>secure</code> as true, the Session class will validate the userid stored within the <code>$_SESSION[session_key]['userid']</code>. 
                                           If the value does not exist in the <code>USER_ID_FIELDNAME</code> column defined in init file, the session will be nullified. The 
                                           <code>Session::secure()</code> function can also enable this behaviour which also takes the argument of <code>true</code> or <code>false</code>. 

                                        </div><br>
                                    </div>

                                </div>

                                <div class="">
                                    <div class="pxv-10 bc-silver">
                                        Syntax: Session modification 
                                    </div>

                                    <div class="font-em-d87 pxv-10 bc-silver">
                                        By default, all sessions are set to last for a day. This behaviour can be modified in our application by using the <code>cookie()</code> method.
                                        The <code>cookie()</code> method is similar to the <code>set_cookie()</code> php inbuilt function. The only difference is that, the first argument 
                                        which is the session name does not need to be declared as this will be automatically pulled from the <code>session_key</code> defined during session 
                                        class instantiation. This method is most likely not required to be used except on rare cases. The <code>User::login()</code> method manages mostly what 
                                        a session needs to become active.
                                    </div>

                                </div>


                            </div>
                        </div>

                    </div> 
                </div> <br>

                <div>
                    <div class="font-em-d87 fb-6 c-olive box-full rad-4 pvs-8">
                      Other helper methods of the session class. <br>

                      <ul class="mvt-10">
                        <li>stream()</li> 
                        <li>cookieName()</li> 
                        <li>sessionName()</li> 
                        <li>onauto()</li> 
                        <li>userid()</li> 
                        <li>checkSession()</li>
                      </ul>

                    </div> <br>

                    <!-- stream -->
                    <div class="">
                        <div class="mvs-4">stream()</div>
                        <div class="font-menu font-em-d9">

                            <div class="mvs-10">
                                This method returns the instance of the session class. Once a session is initialized be defining the session_key and cookie_key, accessing the current session 
                                at a lower level of the application can only be achieved without any data loss by fetching the last instance of that session class. The instance of the session 
                                can be retrieved by using the <code>Session::stream()</code> method. which can be accessed at any level of the application. Example is shown below: 
                            </div>

                            <div class="code mvs-10">  
                                <div class="pxv-10 bc-silver">
                                            Syntax: Session::stream
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  new Session::('user', 'usercookie'); <span class="comment no-select">//instance of session</span> 

  Session::stream(); <span class="comment no-select">//fetch the instance of the session back</span>    
                                    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>

                    <!-- sessionName, cookieName -->
                    <div class="">
                        <div class="mvs-4">sessionName() and cookieName()</div>
                        <div class="font-menu font-em-d9">

                            <div class="mvs-10">
                                The <code>Session::sessionName()</code> and <code>Session::cookieName()</code> methods are both methods that retrives the 
                                session_key and cookie_key storage key names once defined 
                            </div>

                            <div class="code mvs-10">  
                                <div class="pxv-10 bc-silver">
                                            Syntax: sessionName(), cookieName()
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  new Session::('user', 'usercookie'); <span class="comment no-select">//instance of session</span> 

  Session::sessionName(); <span class="comment no-select">//user</span>    
  Session::cookieName(); <span class="comment no-select">//usercookie</span>    
                                    </pre>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- onauto -->
                    <div class="mvt-20">
                        <div class="mvs-4">onauto()</div>
                        <div class="font-menu font-em-d9">
                            The <code>Session::onauto()</code> method is an alias for <code>Session::stream()->auto()</code> method. It manages redirection of session class. It is used to perform redirection 
                            when a session is active or inactive to enforce a redirection. The syntax is shown below
                            <br><br>

                            <div class="code">  
                                <div class="pxv-10 bc-silver">
                                    Syntax: Session::onauto
                                </div>
                                <div class="pre-area">
                                    <pre class="pre-code">
  Session::onauto([logout|login], url)

  <span class="comment">
  where: 
    
    login      : option to redirect only when session is active 

    logout     : option to redirect only when session is not active

    url : define the url to be redirected to.
  </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="font-em-d87 pvs-10 ">
                                As an example in relation to the code syntax above, redirection from a <code>user</code> page to an <code>index</code> page when account becomes inactive 
                                or session is terminated will require that the user page should have a code syntax similar to <code>Session::onauto('logout', 'index')</code>. 
                                By placing such code in the <code>user</code> page, the <code>user</code> page will redirect to the <code>index</code> 
                                page once the session is terminated. Likewise, an <code>index</code> page can be enforced to redirect to an <code>home</code> page if a session is active. This means that the 
                                <code>index</code> page will have a code similar to <code>Session::onauto('login', 'home')</code>.  
                            </div>

                        </div>
                    </div> <br>

                </div>

                <div>
                    <div class="font-menu fb-6 c-olive bc-white-dd box-full rad-4 pxv-8">
                        Session::userid()
                    </div> <br><br>


                    <div class="">
                        <div class="font-menu font-em-d9">
                        The <code>Session::userid()</code> method returns an active session id. For the Session class to successfully return the userid, 
                        the data stored in the in the <code>$_SESSION</code> variable must contain a <code>userid</code> key, that is, 
                        <code>$_SESSION['session_key']['userid']</code>. The value of this is then returned by the <code>userid()</code> method. 
                        It is not advisable to set this key manually form the <code>$_SESSION</code> variable. The data should be stored by the  
                        <code>User</code> class which is an extension of the Session class itself. Learn more about this from <a href="@domurl('docs/useraccounts')" class="hyperlink">User accounts</a>
                        </div> <br>
                    </div>       
                     
                </div><br>    

            
                @lay('build.co.links:tutor_pointer')
            </div>
        </div>
    </section>
</div>
@template;