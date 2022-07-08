@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Shutters - Calls</div> <br>  
        
        <div class="resource-intro">
            <div class="">
                The call methods are methods designed to handle window urls. Every url path called on a 
                window file can be handled using specially designed method which are listed below 
                
                <br><br>

                <ul>
                    <li>call</li>
                    <li>rootcall</li>
                    <li>pathcall</li>
                    <li>basecall</li>
                </ul>

                All urls that are introduced into any Window system (file), can be streamlined into acceptable and 
                invalid urls. This is done by using any of the call methods above. These "call" method when used accepts the 
                parameters. The first parameter is the current class instance while the second parameter is the list of urls accepted 
                from a particular window. Whenever a url is called on a window and that url does not exist in the list of accepted urls by 
                such window, the any call method used to validate such url will automaticall close other urls resulting in a 
                404 error page. When any of the shutter methods above are used, a subsequent method cannot follow. For example, 
                if <code>Window::call()</code> method is called, then one cannot apply any other method (e.g <code>root</code>) below it, as the first method call 
                will automatically close the window if urls does not exist within its list of acceptable urls. In order to keep 
                a window open when a shutter is applied, a pending directive must be applied on the specific call type. This tells the 
                call method to prevent automatic closing of the windows. This option may be employed when handling complex applications or urls and the value (true|false) 
                when supplied as the  third or fourth argument, helps to prevent shutters from closing the window.
                However, when any of this method is pended, developer must be careful of properly closing non-existing urls as this may result 
                in faulty pages, if not properly handled.
                
                <p>
                    The <code>window()</code> function is specially designed to return specific divisions of url. These divisions are:
                    <br><br>

                    <ol>
                        <li>root : the current url's window entry point name</li>
                        <li>path : the path that directly follows the window's entry point name</li>
                        <li>base : this returns the entire url (i.e window + path)</li>
                    </ol>

                    The samples below reveals the different sections of a url based on the three paths mentioned above. 
                    Except the domain option, every other options is allowed on the <code>window()</code> function. <br><br>
<div class="pre-area">
    <div class="pxv-10">
        <div class="no-select bc-off-white pxv-10">Example - 1 (local urls)</div>
        <pre class="pre-code">
<span class="comment">#sample url: http://localhost/folder/some/added/path</span>

http://localhost/folder <span class="comment">//domain</span>

some                    <span class="comment">//root (or window)</span>

added/path              <span class="comment">//path</span>

some/added/path         <span class="comment">//base</span>
        </pre>
    </div>
</div>

<div class="pre-area">
    <div class="pxv-10">
        <div class="no-select bc-off-white pxv-10">Example - 2 (domain urls)</div>
        <pre class="pre-code">
<span class="comment">#sample url: http://site.com/some/added/path</span>

http://site.com   <span class="comment">//domain</span>

some              <span class="comment">//root (or window)</span>

added/path        <span class="comment">//path</span>

some/added/path   <span class="comment">//base</span>
        </pre>
    </div>
    <div class="pxv-10 c-silver-dd bc-off-white">
        The above examples reveals that the chosen root (or window) is usually the path after a 
        project folder name or the path after a site's domain name.
    </div>
</div>

                </p>

                <div class="">
                    A windowed url can be handled using four different approaches known as the RWDB approach.
                    These approaches are listed and discussed below.
                    <br><br>
                    <ul>
                        <li>Root path (window)</li>
                        <li>Window's path</li>
                        <li>Direct path</li>
                        <li>Base path</li>
                    </ul>
                </div>
                

                <div class="">
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Root Path </div>
                    </div> <br>
                    <div class="">
                        The root path approach suggests that the current windowed url has an entry point that exists within 
                        the lists of supplied valid entry points. If the entry point exists, then the corresponding method 
                        supplied for it will be triggered. If the entry point does not exist within the valid lists, then a 404 
                        error page is displayed. An example is displayed below.
                    </div>
                    <br>
                    <div class="pre-area">
<div class="pxv-10 bc-off-white">The example below uses the rootcall method to load only acceptable entry points.</div> <br>
<pre class="pre-code pxs-6">
  class Index extends Window {

    function __construct(){

        self::load('index', fn() => compile() );

    }

    static function usedoor() {
        
        $accepted_roots = [
            'app'  => 'app_method', <span class="comment">the app_method is called on any url having "app" as its entry point</span>
            'root' => 'root_method' <span class="comment">the root_method is called on any url having "root" as its entry point</span>
        ];

        <span class="comment">
        #codes here will run because no call was made earlier
        </span>
        self::rootcall($this, $accepted_roots); <span class="comment">//stop point</span>
        <span class="comment">
        #codes here will not run because a call has been made
        </span>

    }

    function root_method(){

        self::load('app', fn() => compile() ); <span class="comment">load some tempate file</span>

    }

    function app_method(){

        self::close(); <span class="comment no-select">// displays a 404 error page</span>

    }


  }

</pre>
                    </div> <br><br> 

                    <div class="explanation">

                        <p>
                            When an invalid (non-existing) window is call, the url is transferred to Index window (if it exists). 
                            Without instantiating itself, the Index window triggers only its static <code>usedoor</code> method 
                            while ignoring its <code>__construct()</code> method. The <code>__construct()</code> method is only reserved 
                            for a index direct path alone. All other paths gets handled by the <code>usedoor()</code> method.
                        </p>
                        
                        <p>
                            In the above example: <br>

                            1. windowed urls such as (http://domain/app/whatever/path) will trigger the <code>usedoor</code> which then triggers the <code>app_method()</code> <br>
                            2. windowed urls such as (http://domain/root/whatever/path) will trigger the <code>usedoor</code> which then triggers the <code>root_method()</code> <br>
                            3. Every other urls not having a window of <code>app</code> or <code>root</code> will result in a 404 error page. <br>
                            4. Note that Index window url (e.g http://domain/ or http://domain/index) triggers the <code>__construct</code> method instead
                            5. Also, note that urls such as (http://domain/index/some/path) triggers the <code>usedoor</code> method instead. Since index is not among the list of valid entry 
                            points added to the <code>rootcall()</code> method, a 404 error page is displayed
                        </p>

                        <p>
                            It is worth mentioning that <code>rootcall()</code> method is only realistic within the usedoor method of the Index window file. Also, unless few specific window entry points are 
                            required within a web application, this method should be greatly avoided.
                        </p>
                    </div>
                </div>

                <div class="">
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Window's Path </div>
                    </div> <br>
                    <div class="">
                        The window's path is the path that follows a window (entry point) in a windowed url. The <code>window('path')</code> 
                        function returns the path of the current request url. By using the <code>Window::pathcall()</code> method, this acts 
                        directly on a list of path that follow the current windowed (or page) url. The <code>pathcall()</code> method does not 
                        care about the window entry point name. Instead, it only deals with the path supplied by making sure that the path supplied 
                        exists in a list the list of acceptable paths. When the current path of any window exists in the list acceptable urls on 
                        <code>pathcall</code>, then the corresponding method is called, else a 404 error page is returned.
                        
                    </div>
                    <div class="pre-area">
<div class="pxv-10 bc-off-white">The example below uses the pathcall method to load only acceptable entry points.</div> <br>
<pre class="pre-code pxs-6">

  namespace spoova\windows;

  use Window;

  class Home extends Window {


    function __construct(){


        $accepted_paths = [

            'users' => 'users',

            'users/profile' => 'profile'

            ];

        <span class="comment">//set accepted paths on Home window</span>
        self::pathcall($this, $accepted_paths);

    }


    function users(){

        self::load('users', fn() => compile() ); <span class="comment">load tempate file</span>

    }


    function profile(){

        self::load('profile', fn() => compile() ); <span class="comment">load tempate file</span>

    }


  }

</pre>
                    </div> <br><br> 

                    <div class="explanation">Assuming a window file <code>Home</code> was added into the windows folder, when a url 
                    (e.g <code>http://domain/home/whatever/path</code>) is visited, then the Home file is triggered. If the Home window file does not exist,
                    only then would the url be transferred to <code>Index::usedoor()</code> method for handling.
                        <br><br>
                        In the above example, a list of acceptable paths 
                        on the Home window was supplied. 
                        <ul>
                            <li>When a user visits <code>http://domain/home/users</code>, the <code>user()</code> method is called. </li>
                            <li>When a user visits <code>http://domain/home/users/profile</code>, the <code>profile()</code> method is called. </li>
                            <li>Any other paths called on Home will return a 404 error page. </li>
                        </ul>                    
                    </div> 

                </div>  <br><br>

                <!-- Direct Path -->
                <div class="">
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Direct Path </div>
                    </div> <br>
                    <div class="">
                        There direct path method refers to the calling of a method based on the direct or full path supplied.
                        In this case, the urls supplied into the <code>pathcall</code> method must be the full path of a url. 
                        The full path of any url is the combination of the window and the window's path. When using the <code>pathcall</code>
                        method, the first path supplied must be the window name itself else a 404 error will be returned.
                        An example is displayed below:

                        <div class="pre-area">
<pre class="pre-code">

    namespace spoova\windows;

    <span class="c-lime-dd">use Window;</span>

    class Home extends Window {


        function __construct(){


            $accepted_paths = [

                'home' => 'index',

                'home/users' => 'profile'

                ];

            <span class="comment">//set accepted paths for Home window</span>
            self::pathcall($this, $accepted_paths);

        }


        function index(){

            self::load('home', fn() => compile() ); <span class="comment">load tempate file</span>

        }


        function profile(){

            self::load('user', fn() => compile() ); <span class="comment">load tempate file</span>

        }

    }

</pre>
                        </div>
                        <div class="">

                            <div class="pvs-10">
                                In the above, notice that the name of the class "Home" preceded the urls supplied. 
                                This is essential because the <code>pathcall()</code> requires the direct full path 
                                of the urls permitted. When working with multiple urls, redefining the class name at every 
                                step of the array supplied may prove tedious in cases which class names may be redefined. Hence, 
                                the following may be considered
                            </div>

                            <div class="pre-area">
                                <div class="pxv-10 bc-orange c-white">Example 1</div>
<pre class="pre-code">
    function __construct(){


    $accepted_paths = [

        'home' => 'index',

        'home/users' => 'profile'

        ];

    <span class="comment">//set accepted paths for Home window</span>
    self::pathcall($this, $accepted_paths);

    }

</pre>
                            </div>

                            <div class="pre-area">
                                <div class="pxv-10 bc-orange c-white">Example 2</div>
<pre class="pre-code">
    function __construct(){


    $accepted_paths = [

        window() => 'index',

        window().'/users' => 'profile'

        ];

    <span class="comment">//set accepted paths for Home window</span>
    self::pathcall($this, $accepted_paths);

    }

</pre>
                            </div>
                            <div class="pvs-10">
                                When working with <code>pathcalls</code>, one may give 
                                preference to example 2 above than example 1 because <span class="fb-6">eaxmple 2</span> 
                                keeps track of the current window name should it ever change.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- base path -->
                <div class="base-call">
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Base Path </div>
                    </div> <br>
                    <div class="explanation">
                        The <code>basecall</code> method works similarly as the <code>pathcall</code> method on the direct path 
                        supplied. However, the difference is that a basecall method is applied on urls that must have a specific 
                        parent path. For example, a url of <code>home/users</code> and <code>home/users/profile</code> both have the 
                        same parent path of <code>home/users</code>. Hence, the <code>basecall</code> will be triggered for both urls
                        mentioned earlier if the url supplied was <code>home/users</code>. The dangers of this method is that it can leave 
                        unwanted urls opened. When working with urls, it is important to be precise. This makes the handling of urls to be less 
                        ambiguous. This method could however prove useful in certain cases. When it is used anyway, developers must make sure that 
                        all non-essential urls are properly closed.
                    </div>
                </div>

            </div>

      </div> <br>
    
      @lay('build.links:tutor_pointer')
      
    @lay('build.coords:footer')


@template;