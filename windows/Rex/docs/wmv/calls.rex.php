@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d85">

                    <div class="font-em-1d5 c-orange">Shutters - Calls</div> <br>  
        
                    <div class="shutters-intro">
                        
                        <div class="font-em-d87">
                            The call methods are methods designed to manage window urls. Every url path called on a 
                            window can be handled using specially designed method which are listed below 
                            
                            <br><br>

                            <ul>
                                <li>call</li>
                                <li>rootcall</li>
                                <li>pathcall</li>
                                <li>basecall</li>
                            </ul>

                            All urls introduced into any Window file, can be streamlined into acceptable and 
                            invalid urls. This is done by using any of the call methods above. When any of the call methods 
                            listed above are applied, they are given certain acceptable urls to deal with. The syntax of these call methods is 
                            shown below: <br><br>
                          
                            <div class="pre-area shadow">
                                    <div class="">
        <div class="no-select bc-silver-d pxv-10">Syntax: (call syntax)</div>
        <pre class="pre-code">
  <span class="comment">#sample stucture 1: <span class="c-brown-ll">self::call(windowInstance, acceptableUrls, close)</span></span>
  <span class="comment">#sample stucture 2: <span class="c-brown-ll">self::call(windowInstance, acceptableUrls, arguments, close)</span></span>

  self <span class="comment">//must be an extension of window class</span>
  
  windowInstance  <span class="comment">instance of the current window (i.e $this)</span>
  
  call  <span class="comment">any of the shutter methods (i.e rootcall, call, basecall, pathcall)</span>
            
  acceptableUrls  <span class="comment">an array with the list of accepted valid urls and method or class called</span>
  
  close           <span class="comment">a boolean of false prevents a shutter from closing when current page url does not exist in accepted urls</span>
  
  argument        <span class="comment">an array of varibles passed as argument to method or class called when a url is resolved</span>
 </pre>
                                    </div>
                                </div> <br> <br>   
                                
                                <div class="">
                                    The description below helps to explain each part of the syntax above: <br><br>

                                    <ul class="font-em-d9 list-free pxl-2">
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>self</code>: Since the shutter methods belong to the window class, they can only be applied within window classes 
                                            </div>
                                        </li> <br>
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>windowInstance</code> shutter methods can only be applied in window methods that are non-static (e.g  <code>__construct()</code>). 
                                                This is because they need to point to the current window's instance itself.
                                            </div>
                                        </li> <br>
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>call</code> There are basically four shutters and all four uses the same argument syntax shown earlier.
                                            </div>
                                        </li> <br>
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>acceptableUrls</code> These are arrays of key and value pairs where the "key" is a url that is expected to be compared with the  
                                                current page url based on the type of shutter method applied on them. Once a url successfully matches the currently visited url (i.e resolved), the "value" which is either a 
                                                direct method of that current class or a new window class will be called.
                                            </div>
                                        </li> <br>
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>close</code> When a current page url tested on a shutter is not matched, the webpage is closed. This close effect can be prevented by setting 
                                                "close" to <code>false</code>
                                            </div>
                                        </li> <br>
                                        <li>
                                            <div class="bc-silver rad-4 pxv-4">
                                                <code>argument</code> When a url is resolved, the correponding method or class is called. Arguments can be passed across to the method or function called by 
                                                passing the argument mostly as an array. Note that the position of the argument can also serve as close only if the argument is a boolean and a fourth argment 
                                                is not defined.
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            
                            
                            Whenever a url is called on a shutter 
                            and that url does not exist in the list of accepted urls by 
                            such window shutter, that shutter will automatically close resulting in a 404 error page. When any of the shutter methods above is used, 
                            a subsequent shutter method cannot follow. For example, 
                            if <code>call()</code> method is called, then one cannot apply any other method (e.g <code>root()</code>) below it. 
                            This is because the shutter system method by default is configured to handle one shutter method at a time by any window method. 
                            This means that once a shutter method is called, all other shutters are disabled from functioning because once a url does not exist, 
                            a 404 error page has to be returned. In order to keep a window open when a shutter is applied, a pending directive must be applied on the specific call type
                            which tells the shutter method to prevent automatic closing of the windows. This option may be employed when handling complex applications or urls. 
                            This can be done by setting a third or fourth argument as a boolean value of <code>false</code>.
                            Whenever any of the shutters are pended, developer must be careful to properly close invalid urls, most especially for <code>basecall()</code> because 
                            failure to close may result in faulty or black pages if not properly handled.
                        
                            <p>
                                <div class="c-orange font-em-1">The Window Function</div>
                                Before we continue, lets take a look at the <code>window()</code> function. 
                                This function is specially designed to return specific divisions of any url. Every request url is divided into 3 divisions. These divisions are:
                                <br><br>

                                <ul>
                                    <li><span class="c-olive">root</span> : the current url's window entry point name</li>
                                    <li><span class="c-olive">path</span> : the path that directly follows the window's entry point name</li>
                                    <li><span class="c-olive">base</span> : this returns the entire url (i.e root + path)</li>
                                </ul>

                                The samples below reveals the different sections of a url based on the three paths mentioned above. 
                        
                                <div class="pre-area shadow mvt-6">
                                    <div class="">
        <div class="no-select bc-silver-d pxv-10">Example - 1 (local urls)</div>
        <pre class="pre-code">
  <span class="c-teal">#sample url: <span class="c-brown-ll">http://localhost/folder/some/added/path</span></span>


  http://localhost/folder <span class="comment">//domain</span>
  
  some                    <span class="comment">//root (or window)</span>
  
  added/path              <span class="comment">//path</span>
  
  some/added/path         <span class="comment">//base</span>
        </pre>
                                    </div>
                                </div> <br> <br>

                                <div class="pre-area shadow">
                                    <div class="">
        <div class="no-select bc-silver-d pxv-10">Example - 2 (domain urls)</div>
        <pre class="pre-code">
  <span class="comment">#sample url: http://site.com/some/added/path</span>

  http://site.com   <span class="comment">//domain</span>
  
  some              <span class="comment">//root (or window)</span>
  
  added/path        <span class="comment">//path</span>
  
  some/added/path   <span class="comment">//base</span>
        </pre>
    </div>
                                    <div class="pxv-10 c-grey bc-off-white">
                                        The above examples reveals that the chosen root (or window) is usually the path after a 
                                        project folder name or the path after a site's domain name.
                                    </div>
                                </div> <br>
                                
                                <div class="font-menu mvt-6">
                                    Since we now understand that the domain part of our url can be <code>localhost/folder</code> or 
                                    <code>site.com</code>, in tutorial course, we will use the name "domain" to refer to this part 
                                    of url.
                                </div> <br>

                                The <code>window()</code> takes any of the arguments "base", "path" or "root". Whenever any of these three 
                                arguments are supplied, using the current request url, the window function returns the 
                                equivalent value of that argument supplied. This is shown below: <br> <br>
                                
<div class="pre-area shadow">
    <div class="pxv-10 bc-silver-d">Example (Page url): http://domain/user/abc/... </div>
    <pre class="pre-code">
  window(':');    <span class="comment no-select">//returns user</span>
  window('root'); <span class="comment no-select">//returns user (same as above)</span>
  window('path'); <span class="comment no-select">//returns abc/...</span>
  window('base'); <span class="comment no-select">//returns user/abc/...</span>
    </pre>
</div> <br>

                                <div class="font-menu mvt-10">
                                    In the above, the root, path and base options returns their equivalent part of the url. The ellipes is used to denote more paths. Although, <code>window(':')</code> is a short form of 
                                    <code>window("root")</code> There are special uses of this reserved option. The colon is a directive that append root directory to urls supplied urls. When the colon 
                                    character precedes any argument, the window function understands that such arguments are relative paths which must be appended to url. For example, using the previous 
                                    request url: 
                                </div> <br>
                                
<div class="pre-area shadow">
    <div class="pxv-10 bc-silver-d">Example - if request url is: http://domain/user/abc </div>
    <pre class="pre-code">
  window(':profile'); <span class="comment no-select">//returns user/profile</span>
  window(':some/path'); <span class="comment no-select">//returns user/some/path</span>

  window('root:profile');  <span class="comment no-select">//same as window(':profile'); </span>
    </pre>
</div> <br>

                                <div class="font-menu mvt-10">In the sample, above, since the root of the url is <span class="c-brown-ll">"app"</span>, when colons are applied, to arguments, spoova will 
                                automatically prefix such url with the current page root name. The last line is an alternative way which involves defining the full structure. This also means that the <code>root:</code> 
                                can be replaced by <code>base:</code> or <code>path:</code> but when only the colon <code>:</code> precedes the argument, then the <code>root:</code> is automatically assumed as revealed in 
                                the sample above.
                                </div>                    
                            
                            </p>

                            <div class="">
                                <div class="c-orange font-em-1">Handling Shutters</div>
                                <div class="pvs-6">
                                    A window url can be handled using four different approaches known as the RWDB approach.
                                    These approaches are listed and discussed below.
                                </div>
                                <ul>
                                    <li>Root path (window) approach</li>
                                    <li>Window's path approach</li>
                                    <li>Direct path approach</li>
                                    <li>Base path approach</li>
                                </ul>
                            </div>
                

                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Root Path </div>
                                </div> <br>
                                <div class="">
                                    The root path approach suggests that the current window url has an entry point that exists within 
                                    the lists of supplied valid entry points. If the entry point exists, then the corresponding method 
                                    supplied for it will be triggered. If the entry point does not exist within the valid lists, then a 404 
                                    error page is displayed. An example is displayed below.
                                </div>
                                <br>
                                <div class="pre-area">
<div class="pxv-10 bc-silver-d">The example below uses the rootcall method to load only acceptable entry points.</div> <br>
<pre class="pre-code pxs-6">
  class Home extends Window {

    function __construct(){

                
        $accepted_urls = [
            'home'  => 'index', <span class="comment">// index will be called on any url having "home" as its entry point</span>
        ];

        self::rootcall($this, $accepted_urls);

    }

    function index() {
        
        self::load('index', fn() => compile() ); <span class="comment">// load an index template file</span>

    }


  }

</pre>
                                </div> <br><br>
                                
                                <div class="font-menu">
                                    In the above, when the home web url is visited, then, the index method is called. The <code>rootcall</code> 
                                    will only match the url's window entry point "home". Since our root class name is "home", this means that using 
                                    <code>window(':')</code> within this class 
                                    will also return "home". The we can rewrite our code as : <br><br>
                                </div>

                                <div class="pre-area">
<div class="pxv-10 bc-silver-d">The example below uses the rootcall method to load only acceptable entry points.</div> <br>
<pre class="pre-code pxs-6">
  class Index extends Window {

    function __construct(){

        self::rootcall($this, [window(':')  => 'root']);

    }

    function root() {
        
        self::load('index', fn() => compile() ); <span class="comment">// load an index template file</span>

    }


  }

</pre>
                                </div> <br><br>
                                
                                <div class="font-menu">
                                    The <code>root()</code> method is only realistic for use in window root server files. This is because the 
                                    <code>rootcall()</code> only works on the root entry point. As long as a urls root name is matched, the <code>rootcall()</code> 
                                    method will not bother to check the relative paths on that particular request url. The figure below best explain this behavior. 
                                </div> <br>

                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver-d">The example below reveals the effect of rootcall</div> <br>
 <pre class="pre-code">
  <span class="comment no-select">On <span class="c-brown-ll">rootcall($this, ['home' => 'index']);</span> </span>
  
  <span class="comment no-select"><span class="c-green-l">valid url:</span> http://domain/home </span>
  <span class="comment no-select"><span class="c-green-l">valid url:</span> http://domain/home/user </span>
  <span class="comment no-select"><span class="c-green-l">called method:</span> index </span>

  <span class="comment no-select"><span class="c-red-dd">invalid url:</span> http://domain/some </span>
  <span class="comment no-select"><span class="c-red-dd">invalid url:</span> http://domain/some/home </span>
 </pre>    

                                </div> <br>
                                
                                <div class="font-menu mvt-10">
                                    In the above, we can see that as long as <code>home</code> is the root entry point, the window url 
                                    will become a valid url. It is important to remember that domain for localhost is usally the <code>localhost/project_folder_name</code>
                                    
                                    As an example, if a basic logic is employed, this means that all urls will be handled by a base window server class. This class 
                                    is expected to be directly within the <code>windows/Routes</code> directory. Assuming the server class name is Index, then
                                    the Index class may be configured to use the <code>rootcall()</code> method to initialize other classes based on the url's 
                                    window name, since it is the class that manages every other url. In this way, rather than use methods, we can 
                                    directly call classes using the format below:
                                </div> <br>

                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver-d">Example (rootcall)</div> <br>
<pre class="pre-code pxs-6">
  class Index extends Window {

    function __construct(){

        $accepted_urls = [

            'index'  => 'root',

            'home'  => 'win:Routes\Home',

            'profile'  => 'win:Routes\Profile',

        ];

        self::rootcall($this, $accepted_urls);

    }

    function root() {

        <span class="comment">//This is triggered when index page is visited.</span>

    }

  }

</pre>    

                                </div> <br>                                   
                                <div class="font-menu mvt-10">
                                    In the code above, the <code>win:</code> directive tells the window class to load its value as a class.
                                    When a url, for example <code>http://domain/home</code> or <code>http://domain/home/any/path</code> is visited, 
                                    the class <code>teymzz\spoova\windows\Routes\Home</code> will be triggered. The <code>profile</code> also works in a similar way. 
                                    However, when a page e.g <code>http://domain</code>, <code>http://domain/index</code> or <code>http://domain/index/any/path</code> 
                                    is visited, the <code>root()</code> method is triggered. Remember that if the index page is visited, then <code>window(':')</code> 
                                    will also return the name <span class="c-brown-ll">"index"</span>. This means that we can replace our first array key of <code>'index' => 'root'</code> 
                                    with <code>window(':') => 'root'</code> and our class will still run perfectly.
                                </div>
                                <br><br>

                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Window's Path </div>
                                </div> <br>
                                <div class="">
                                    The window's path is the path that follows a window (entry point) in any window url. The <code>window('path')</code> 
                                    function returns the path of the current request url. By using the <code>Window::pathcall()</code> method, this acts 
                                    directly on a list of path that follow the current window (or page) url. The <code>pathcall()</code> method does not 
                                    care about the window entry point name. Instead, it only deals with the path supplied on the window name by making sure that the path supplied 
                                    exists in the list of acceptable url paths. If the current request url of a page has its path in the list acceptable urls paths,
                                    <code>pathcall</code> will trigger the corresponding method, else a 404 error page is returned.
                                    
                                </div> <br>
                                <div class="pre-area">
<div class="pxv-10 bc-silver-d">pathcall method to load acceptable paths on entry points.</div> <br>
<pre class="pre-code pxs-6">
  namespace teymzz\spoova\windows;

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

                                <div class="font-menu">By standard logic, assuming a window file <code>Home</code> was added into the windows folder, when a url 
                                (e.g <code>http://domain/home/whatever/path</code>) is visited, the Home file is triggered. If the Home window file does not exist, a 404
                                response is returned
                                    <br><br>
                                    In the above example, a list of acceptable paths 
                                    on the Home window was supplied. <br>
                                    <ul class="mvt-10">
                                        <li>When a user visits <code>http://domain/home/users</code>, the <code>users()</code> method is called. </li>
                                        <li>When a user visits <code>http://domain/home/users/profile</code>, the <code>profile()</code> method is called. </li>
                                        <li>Any other paths called on Home will return a 404 error page. </li>
                                    </ul>   
                                    It is important to clarify that the <code>pathcall</code> does not check if the window root is <code>home</code>. It only checks 
                                    if the path supplied on the window root matches the list of accepted paths.                 
                                </div> 

                            </div>  <br>

                            <!-- Direct Path -->
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Direct Path </div>
                                </div> <br>
                                <div class="">
                                    The direct path method refers to the calling of a method based on the direct or full path supplied.
                                    In this case, the urls supplied into the <code>call</code> method must be the full path of a url. 
                                    The full path of any url is the combination of the root and window's path. When using the <code>call</code>
                                    method, the first path supplied must be the window name itself else a 404 error will be returned.
                                    An example is displayed below:

                                    <div class="pre-area mvt-10">
<pre class="pre-code">
  &lt;?php
    namespace teymzz\spoova\windows;

    <span class="c-lime-dd">use Window;</span>

    class Home extends Window {


        function __construct(){


            $accepted_paths = [

                'home' => 'index',

                'home/users' => 'profile'

            ];

            <span class="comment">//set accepted paths for Home window</span>
            self::call($this, $accepted_paths);

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

                                        <div class="pvs-10 font-menu">
                                            In the above, notice that the name of the class "home" preceded the urls supplied. 
                                            This is essential because the <code>call()</code> requires the direct full path 
                                            of the urls accepted. When working with multiple urls, redefining the class name at every 
                                            step of the array supplied may prove tedious in cases which class names may be redefined. Hence, 
                                            the following may be considered
                                        </div>

                                        <div class="pre-area">
                                            <div class="pxv-10 bc-orange c-white">Example 1 - Discouraged</div>
<pre class="pre-code">
  function __construct(){


    $accepted_paths = [

        'home' => 'index',

        'home/users' => 'profile'

        ];

    <span class="comment">//set accepted paths for Home window</span>
    self::call($this, $accepted_paths);

  }

</pre>
                                        </div>

                                        <div class="pre-area">
                                            <div class="pxv-10 bc-orange c-white">Example 2 - Redefining example 1 above</div>
<pre class="pre-code">
  function __construct(){


    $accepted_paths = [

        window(':') => 'index',

        window(':users') => 'profile'

        ];

    <span class="comment">//set accepted paths for Home window</span>
    self::call($this, $accepted_paths);

  }

</pre>
                                        </div>

                                        <div class="pvs-10 font-menu">
                                            When working with direct <code>call</code>, one may give 
                                            preference to example 2 because it 
                                            keeps track of the current window name should it ever change. Also, developers are encouraged to 
                                            favor this method than other calls as it acts directly on any url supplied, making it easier to read and 
                                            understand.
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> <br>

                            <!-- base path -->
                            <div class="base-call">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> <span class="bi-circle mxr-8 c-orange-dd"></span> Base Path </div>
                                </div> <br>
                                <div class="explanation">
                                    The <code>basecall()</code> method works similarly as the <code>call()</code> method on the direct path 
                                    supplied. However, the difference is that a basecall method is applied on urls that must have a specific 
                                    parent path structure. For example, a url of <code>home/users</code> and <code>home/users/profile</code> both have the 
                                    same parent path of <code>home/users</code>. Hence, the <code>basecall</code> will be triggered for both urls
                                    mentioned earlier if the url supplied was <code>home/users</code>. The dangers of this method is that it can leave 
                                    unwanted urls opened. When working with urls, it is important to be precise. This makes the handling of urls to be less 
                                    ambiguous. This method could however prove useful in certain cases when we are trying to call a different class or trying to 
                                    accept any path on a specific window url. When it is used anyway, developers must make sure that 
                                    all non-essential urls are properly closed or handled properly.
                                </div> <br>

                                
                                <div class="pre-area">
                                    <div class="pxv-10 bc-orange c-white">Example - Using basecall</div>
<pre class="pre-code">

  &lt;?php 

  use Window;

  class Home {

      function __construct(){
    
        $accepted_paths = [
    
            window(':user') => 'index',
    
            ];
    
        <span class="comment">//set accepted parent paths from Home window</span>
        self::call($this, $accepted_paths);
    
      }

      function index() {

        <span class="comment">//called by all "home/user" parent urls</span>

      }

  }


</pre>
                                </div>

                                <div class="foot-note mvs-6">
                                    In the code above, all urls that have a parent structure of <code>home/user</code> (e.g home/user/settings) will call or trigger the  
                                    <code>index()</code> method.
                                </div>

                            </div> <br>


                        </div>

                        <div class="">

                            <div class="c-orange font-em-1">Pending Shutters</div>
                            <div class="mvt-10">
                                Since shutters control how url are managed and they also help to automatically close invalid urls, by default, when any shutter method is used, another subsequent one cannot be used within the same window method. 

                                For example, if we previously use a <code>call()</code>
                                method, then we cannot use, <code>rootcall()</code>, <code>pathcall()</code>, <code>basecall()</code> or even <code>call()</code> itself after. 
                                This idea is generated from the fact that two different urls (or files) should not be loaded (or resolved) in a single url. Naturally, if any shutter cannot resolve its list of acceptable urls, it will automatically 
                                close unless pended. However complications may arise when we need to resolve multiple urls or resolve urls differently. 
                                Shutters can be pended by supplying a third parameter of <code>false</code> to any shutter method used. When this is done, 
                                a shutter will only allow a subsequent shutter to run if it was unable to resolve any of its urls.
<div class="pre-area mvt-10">
    <pre class="pre-code">
  <span class="comment">...</span>

  self::call($this, ['home' => 'method'], false);


  $basecall = self::basecall($this, ['home/user' => 'method']);

  if(!$basecall) self::close();

    </pre>
</div>

                                <div class="font-menu mvt-6">
                                    In the code above, the <code>call()</code> was pended to allow the <code>basecall()</code> to also run. 
                                    If a url is resolved by <code>call()</code>, then <code>basecall()</code> will trip off. However,
                                    if a url is not resolved by the <code>call()</code> method, then the <code>basecall</code> will try to resolve its own 
                                    list of urls. If <code>basecall()</code> cannot resolve its urls, then, a 404 error page is displayed and a false value is returned. 
                                    Also, if the <code>call()</code> was able to resolve its url, we can force <code>basecall()</code> to work by declaring the previous <code>call()</code> 
                                    as unresolved. This can be done by adding the <code>$this->resolved(false)</code> immediately below the <code>call()</code> 
                                    method. Another method to force our <code>basecall()</code> to work is to call it within the <code>self::clearResolved()</code> method which takes a closure as callback argument.
                                    These are shown below: <br>

                                    
                                    <!-- Whenever a url is successfuly loaded or resolved, the shutter method returns a boolean value of true. If the url does not exist, in the 
                                    list of accepted urls, then false is returned. This response can alse be useful to help us check if a url has been resolved by a shutter even if it was pended. -->
                                </div>
<div class="pre-area mvt-6">
    <pre class="pre-code">
  <span class="comment">...</span>

  self::call($this, ['home' => 'method']);

  $this->resolved(false); <span class="comment">// allow another shutter to work</span>

  self::basecall($this, ['home/user' => 'method']); <span class="comment">// now it works!</span>

    </pre>
</div>
<div class="font-em-d87 mvt-6">Or apply the method below:</div>
<div class="pre-area mvt-6">
    <pre class="pre-code">
  <span class="comment">...</span>

  self::call($this, ['home' => 'method']);

  self::clearResolved(function(){

      self::basecall($this, ['home/user' => 'method']); <span class="comment">// now it works!</span>

  })

    </pre>
</div>

                                <div class="font-menu mvt-6">
                                    Whenever a url is successfuly loaded or resolved, the shutter method returns a boolean value of true. If the url does not exist, in the 
                                    list of accepted urls, then false is returned. This response can alse be useful to help us check if a url has been resolved by a 
                                    shutter even if it was pended, especially for <code>basecall()</code> which is a soft shutter (i.e allows unlimited paths on it).
                                </div>
<div class="pre-area mvt-6">
    <pre class="pre-code">
  <span class="comment">...</span>

  $call = self::call($this, ['home' => 'method'], false);

  if(!$call) {

    if(basecall($this, ['home/user' => 'method'])); self::close();

  }
    </pre>
</div>
                                <div class="font-menu mvt-6">
                                    The code structure above is a good example of how to check if a url is resolved. If the <code>call()</code> cannot resolve its urls, 
                                    then since it was pended,  this will allow <code>basecall</code> to try to resolve its own urls. If basecall happens to resolve it urls, 
                                    since it is a soft shutter, it will leave the resolved url opened to allow multiple paths unless it is handled properly. Naturally, we don't 
                                    want to close a url with <code>self::close()</code> when it is resolved because that will send a 404 response to server. However, the <code>self::close()</code> method above 
                                    is just a way to show that a url can be closed using 
                                    the <code>self::close()</code> method.
                                </div>

                            </div>
                        </div> <br>

                        <div class="passing-variables">

                            <div class="c-orange font-em-1">Passing variables</div>
                            <div class="">
                               Naturally, the <code>Request</code> class instance is passed as second argument to any method called by any of the shutters. 
                               However, shutters also allow us to pass variables into called methods or classes by using <code>SELF::ARG</code> or 
                               <code>SELF::PARAM</code> key. This is shown below: <br><br>
<div class="pre-area">
    <pre class="pre-code">
 &lt;?php

  <span class="comment no-select">...</span>

  class Home {

    function __construct() {

        $var = ['name' => 'Brown'];

        self::call($this, [
        
            window(':') => 'root',
            window(':user') => 'user',

            SELF::ARG => $var

        ]);

    }

    function root($var) {

        var_dump($var); <span class="comment no-select">//['name' => 'Brown']</span>

    }

    function user($var, Request $Request) {

        var_dump($var); <span class="comment no-select">//['name' => 'Brown']</span>

    }

  }
    </pre>
</div>

                                <div class="font-menu mvt-6">
                                    In the code above, the varible <code>$var</code> was passed across to all methods called. 
                                    In the <code>user()</code> method, since the <code>$Request</code> is naturally available to us as a second argument, 
                                    we can supply the argument and still get our <code>Request</code> class instance. In this way, our request was obtained 
                                    in the <code>user()</code> method above. We can also pass different arguments for each method through a function. This is 
                                    shown below:
                                </div> <br>
<div class="pre-area">
    <pre class="pre-code">
 &lt;?php

  <span class="comment no-select">...</span>

  class Home {

    function __construct() {

        $var = ['name' => 'Brown'];

        self::call($this, [
        
            window(':') => 'root',
            window(':user') => 'user',

            <span class="c-orange-dd">SELF::ARG => function($method) {

                $methods_args = [ 
                    
                    'root' => 'foo',
                    'user' => ['foo', 'bar'],

                    ];

                return $methods_args[$method] ?? '';

            }</span>

        ]);

    }

    function root($args) {

        $args = $args(__FUNCTION__); <span class="comment">//foo</span>

    }

    function user($args, Request $Request) {

        $args = $args(__FUNCTION__); <span class="comment">//['foo', 'bar']</span>

    }

  }
    </pre>
</div>
                                
                            </div>
                        </div> <br>

                        <div class="font-menu mvt-6">
                            In the code above, the function allows us to pass different arguments to the window method.
                        </div> <br>

                        <div class="calling-method">

                            <div class="c-orange font-em-1">Methods and Class Call</div>
                            <div class="mvt-10">
                               Window methods or Classes can be called whenever a url is resolved. The difference between a method call and a class call is that 
                               while a method exists as a normal string, a class call is usually preceded by a <code>win:</code> identifier. Naturally, all window 
                               files are expected to be within the <code>Window</code> directory. When a window identifier <code>win:</code> is applied, then, such 
                               path must follow the folder directory. <br><br>
<div class="pre-area">
    <pre class="pre-code">
 &lt;?php

  <span class="comment no-select">...</span>

  class Home {

    function __construct() {

        $var = ['name' => 'Brown'];

        self::call($this, [
        
            window(':') => 'root',
            window(':user') => 'win:Path\To\File',
 
            SELF::ARG => $vars

        ]);

    }

    function root($var) {

        var_dump($var); <span class="comment no-select">//['name' => 'Brown']</span>

    }

  }
    </pre>
</div>

                                <div class="font-menu mvt-6">
                                    In the code above, while the <code>home</code> url will call the <code>root()</code> 
                                    method of the current window, the <code>home/user</code> will call the <code>teymzz\spoova\Windows\Path\To\File</code> 
                                    class.
                                    The <code>win:</code> directive specifies the <code>teymzz\spoova\Windows</code> namespace. 
                                    We can also pass an object as value rather than strings.  The variable <code>$var</code> 
                                    will also be passed down as an argument to the class, object or method defined.
                                </div>
                            </div>
                        </div><br>

                        <div class="calling-method">

                            <div class="c-orange font-em-1">LastCall function</div>
                            <div class="mvt-10">
                                <div class="mvb-10">
                                    The <code>lastcall()</code> function can be applied just like the <code>window()</code> function earlier discussed except 
                                    for a few differences. This function returns the last resolved url. When parameters are supplied, it appends the last resolved 
                                    url to the new parameter supplied. However, this function does not support dot convention. Rather, paths must be strictly defined 
                                    with slashes.  The example below is a relationship between shutters and lastCall function.
                                </div>
<div class="pre-area">
    <div class="bc-silver-d pxv-10">
      File 1: Home.php
    </div>
    <pre class="pre-code">
 &lt;?php

  <span class="comment no-select">...</span>

  namespace teymzz\spoova\windows\Routes;

  class Home {

    function __construct() {

        $var = ['name' => 'Brown'];

        self::call($this, [

            window(':') => 'root',
            lastCall('/user') => 'win:Routes\User',

            SELF::ARG => $vars

        ]);

    }

    function root() {

        <span class="comment"># This is called when home is visited (or resolved)</span>

    }

  }
    </pre>
</div>

<div class="pre-area">
    <div class="bc-silver-d pxv-10">
      File 2: User.php
    </div>
    <pre class="pre-code">
 &lt;?php

  <span class="comment no-select">...</span>

  namespace teymzz\spoova\windows\Routes\Home;

  class User {

    function __construct($var) {

        self::call($this, [
        
            lastCall() => 'root', <span class="comment"># This is home/user</span>

        ]);

    }

    function root() {

        <span class="comment"># This is called when home/user is visited (or resolved)</span>

    }

  }
    </pre>
</div>

                                <div class="font-menu mvt-6">
                                    In the code above, <code>Home</code> class uses its shutter method to call its 
                                    <code>root()</code>  method when <code>home</code> is visited. However, when <code>home/user</code> is visited, 
                                    the <code>User</code> class is called. The <code>lastCall()</code> function tracks this movement and makes it easier 
                                    to harvest the last resolved url. Rather than use <code>window(':user')</code>, we can use the <code>lastCall()</code> 
                                    function which will naturally return the last resolved call. If any argument is supplied on it (e.g <code>lastCall('/path')</code>)
                                    then <code>home/user/path</code> will be returned. 
                                </div>
                            </div>
                        </div><br>




                    </div> <br>
                </div>
            </div>
    
            @lay('build.co.links:tutor_pointer')
      
            @lay('build.co.coords:footer')
        </section>
    </div>

@template;