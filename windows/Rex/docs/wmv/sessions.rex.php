@template('template.t-tut')

    @title('WMV - Errors')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Window Sessions</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Window session files are files which contain session naming pattern which are stored within the <code>window/Sessions</code> 
                            directory. These files are used to define 
                            session key names and the name is later imported into frame files which can be shared to routes. In most cases, 
                            one session file is needed within the application. However, when certain situation arises for the need of a different session file, then the 
                            session files comes into play. For example, a session file can help to separate an admin data from a user data if the admin data is stored 
                            under a different session key. Consider the example below where we have three files: 

                                <div class="pre-area mvt-10">
                                    <div class="pxv-10 bc-silver">1a. window/Sessions/UserSession.php</div>
<pre class="pre-code c-olive">
  &lt;?php 
  
  new Session('user', 'usercookie');

</pre>
                                </div> <br>

                                <div class="pre-area mvt-10">
                                    <div class="pxv-10 bc-silver">2a. window/Sessions/AdminSession.php</div>
<pre class="pre-code c-olive">
  &lt;?php 
  
  new Session('admin', 'admincookie');

</pre>
                                </div> <br>

                                <div class="pre-area mvt-10">
                                    <div class="pxv-10 bc-silver">1b. window/Frames/UserFrame.php</div>
<pre class="pre-code c-olive">
  &lt;?php 

  namespace spoova/mi/windows/Frames;

  use Window;
  use User;

  session('usersession')

  class UserFrame extends Window {
    
    function __construct() {

        vdump( User::config('SESSION_NAME') ); <span class="comment">//session</span>

    }
    
  }

</pre>
                                </div>

                                <div class="pre-area mvt-10">
                                    <div class="pxv-10 bc-silver">2b. window/Frames/AdminFrame.php</div>
<pre class="pre-code c-olive">
  &lt;?php 

  namespace spoova/mi/windows/Frames;

  use Window;
  use User;

  session('adminsession')

  class AdminFrame extends Window {
    
    function __construct() {

        vdump( User::config("SESSION_NAME") ); <span class="comment">//admin</span>

    }
    
  }

</pre>
                                </div>

                                <div class="foot-note mvt-6">
                                    In the example above, we have two session within the <code>window/Sessions/</code> 
                                    directory. Within each session file in <code>"1a"</code> and <code>"2a"</code> above, we 
                                    defined two different session keys "user" and "admin" in which relative session data are expected 
                                    to be stored. Once the key is stored, we can then import the session files into any frame file 
                                    using the <code>session()</code> function which was built to load session files into window files by 
                                    calling the session file name. In the example above, the <code>Userframe</code> class will connect to the 
                                    <code>UserSession</code> file while the class <code>AdminFrame</code> will connect to the 
                                    <code>AdminSession</code> file. By defining the <code>session()</code> at the top of the class, it ensures that when we 
                                    call the session is always added and not overridden from any method. However, if we are sure that the <code>super()</code> 
                                    of window or in this case "frame" files will not be overridden, then we can declare the session within a the <code>super()</code> method which is usually being called at the 
                                    start of any route. An example is shown below:
                                </div>

                                <div class="pre-area mvt-10">
                                    <div class="pxv-10 bc-silver">2b. window/Frames/AdminFrame.php</div>
<pre class="pre-code c-olive">
  &lt;?php 

  namespace spoova/mi/windows/Frames;

  use Window;
  use User;

  class AdminFrame extends Window {
    
    function __construct() {

       vdump( User::config('SESSION_NAME') ); <span class="comment">//admin</span>

    }

    static function super() {
        
        session('adminsession');

    }
    
  }

</pre>
                                </div>
                        </div> 
                    </div>
                    
                    <div class="foot-note mvt-10">
                        in the example above, the <code>AdminFrame</code> file calls the <code>AdminSession</code> 
                        file using the global <code>super()</code> method. Once we declare the session keys, we can then 
                        extends the session frame files to routes. The children route of the relative session frames will 
                        only have access to their respective parent session keys. This makes it easier to deal with session 
                        data and helps to distinguish between one session from another.
                    </div>
                    
                    <br>

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;