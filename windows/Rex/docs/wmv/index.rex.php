@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">WMV PATTERN</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            The WMV pattern is an achitecture built upon the ideology of MVC pattern.
                            It follows a series of predefined structures that makes up the WMV itself. This system 
                            can be entirely classified into five categories which are <code>Routes</code>, <code>Frames</code>, 
                            <code>Models</code>, <code>APIs</code> and <code>Rex</code> files, where the <code>Rex</code> files are template files 
                            controlled mostly with template directives and compiled using compiler functions.

                            The WMV depends on a structure where a <code>Model</code> is created before a 
                            <code>View</code> is rendered. In order to work with wmv framework, 
                            a window file must be created. Window files are classes that are extended to a root Window manager class.
                            Hence, they inherit properties of the Window parent which has url management, request access and template 
                            loading features. 
                        </div> 
                    </div>
                    
                    <div class="windows-folder"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Folder </div>
                        <div class="flex mid">
                            <span class="bi-chevron-double-right"></span>
                        </div>
                        </div> <br>

                        <div class="">
                            The first thing to take note of when creating a window files is the windows folder.
                            The windows folder is a reserved folder storing for Routes, APIs, Frames, Models and Rex files. By order of standard, spoova employs 
                            a standard logic which uses different window files as route entry points. These file are added to the 
                            windows route directory (i.e <code>windows/Routes</code> )  and each window file extends to a 
                            root <code>Window</code> class which is the main controller. By default, when running our application, whenever a page is loaded,
                            the url is transferred to the windows management structure. This will try to resolve the url by looking for 
                            a route file within the windows/Routes folder. If a window entry class file matching a url's entry 
                            name does not exist, spoova will return a 404 error. It is however worth emphasizing that all window file names should be initialized with an 
                            upper case character. The Spoova framework favors 3 different logics for loading window files. 
                            These logics are : <br>
                            <ul class="mvt-10">
                                <li><a href="#basic-logic"><span class="c-orange-dd">Basic Logic</span></a></li>
                                <li><a href="#standard-logic"><span class="c-orange-dd">Standard Logic</span></a></li>
                                <li><a href="#index-logic"><span class="c-orange-dd">Index Logic</span></a></li>
                            </ul>

                            <div class="pxs-14">
                                <span id="basic-logic"></span>
                                <div class="basic-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Basic Logic</div>
                                    <div class="desc mvt-10">
                                        
                                        Basic logic is applied to load window files depending on developer's desired loading structure. Although the 
                                        windows folder serves as base for loading applications, basic logic prefers that developer should manage the entire 
                                        way in which urls should be resolved. In order to use this method, the <code>index.php</code> file's <code>Server::run()</code> 
                                        method should be supplied with a file name as argument e.g <code>"basic"</code> just as below. 
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  &rarrhk; Server::run('basic');
 </pre>
                                        </div> <br>
                                        
                                        If this is done, then the application will assume that a <code>windows/Routes/Basic.php</code> file controls the entire application. If the 
                                        file (i.e class) exists within the predefined path, then the class will take the full ownership and control of how urls run. This means that 
                                        every url will first land on that <code>windows/Routes/Basic.php</code> file which will then determine how such url is handled. In this manner, 
                                        the Basic file is the sole distributor and manager of all urls. Without it, pages will not be able to load. Also, it is worth noting that in this logic, 
                                        all urls are opened and considered as valid. The management of invalid urls and their response codes are left for developers to handle.
                                    </div>
                                </div>
                            </div> <br>


                            <div class="pxs-14">
                                <span id="index-logic"></span>
                                <div class="index-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Index Logic</div>
                                    <div class="desc mvt-10">
                                        Index logic is built upon the basic logic. In this logic, the <code class="calibri">windows/Routes/Index.php</code>
                                        file takes the full ownership and control of how urls are handled. When an index page 
                                        (e.g <code class="calibri">http://host_name/</code> or <code class="calibri">http://host_name/index</code>) is visited, index class will resolve 
                                        the index page by calling its <code class="calibri">root()</code> method. However when other urls whose entry names are not index are called, 
                                        then spoova will try to resolve the urls by looking for a file with the root name within the <code class="calibri">windows/Routes</code> directory.
                                        If the file does not exist, then spoova will return a 404 error page. The structure below is an example of how to set up an index logic. 
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  Server::run('index');
 </pre>
                                        </div> <br>
                                        
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">windows/Routes/Index.php</div>
 <pre class="pre-code">
 
  <span class="c-violet-dd">namespace spoova\windows\Routes;</span>
  
  <span class="c-purple">use Window;</span>

  class Index extends Window {

    function __construct(){

      if(self::isIndex($this)){
      
         self::call($this, [
    
            window('root') => 'root',
            
         ]);

      } else {

         if(!self::callRoute(window('root'))) self::close();

      } 
    
      function root() {

         <span class="comment">//call this on index page</span>

      }

    }

  }
 </pre>
                                        </div> <br>
                                        
                                        <div class="font-em-d9">
                                            <p>
                                                In the code above, by setting the <code>index.php</code> file to 
                                                <code>Server::run('index')</code>, the application will try to call the <code>windows\Routes\Index.php</code>. 
                                                If the file exists and the currently requested url is an index page, the <code>windows\Routes\Index.php</code>file will in turn call its <code>root()</code> method.
                                                However, if a different url is called whose entry point name is not "index", rather than call the <code>root()</code> method, 
                                                spoova will check if the route file exists first within the <code class="calibri">windows\Routes</code> directory and try to use the class to 
                                                resolve the url. The <code>self::callRoute()</code> method ensures that 
                                                the window tries to load every page using a class entry window name that exists within the <code class="calibri">windows\Routes</code> directory. If the url handler or window router file 
                                                does not exist, then a 404 reponse is returned through the <code>self::close()</code> method. 
                                            </p>

                                            <p>
                                                In any given url, an entry name returned by <code>window('root')</code> or <code>window(':')</code> 
                                                is always the name that comes after the domain url. In localhost, it is the name that comes after the project folder name. In the code 
                                                above, assuming the folder name is <code>app</code>, then a url "http://localhost/app/" and "http://localhost/app/index" will run successfully because the 
                                                <code>call()</code> method was used and both urls still refer to the index page. In situations where we need to handle more paths on the index page, for example 
                                                "http://localhost/app/localhost/more_path" then <code>self::basecall()</code> may be preferred instead while noting that unwanted urls must be filtered out through some validation logic.
                                            </p>
                                         
                                        </div>


                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="standard-logic"></span>
                                <div class="standard-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Standard Logic</div>
                                    <div class="desc mvt-10">
                                        Unlike other logics, standard logic suggests that all urls must have a window entry point or server entry file that takes ownership of the its 
                                        relative sub-urls. For example, a home webpage must have its respective <code>Home</code> window class within the <code class="calibri">windows/Routes</code>
                                        directory. The window class can then take ownership of its sub-urls. This means that a url <code>home</code> and <code>home/user/...</code> for example, will be handled 
                                        by a root window file <code>"Home"</code>. The root class will be the master that will determine how its relative paths are loaded. 
                                        If the root window file does not exist, then a 404 error page is returned. In any given url there is always a window or entry point as explained
                                        <a href="@route('::about_wmv')"><span class="c-olive hyperlink">here</span></a>. The standard logic will then use the window entry point's 
                                        name as the window class and every other relative paths will be handled by their parent Window entry class. If the entry class does 
                                        not exist a 404 error response is returned.
                                        <br>
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">index.php</div>
 <pre class="pre-code">
  Server::run(); <span class="comment no-select">// use standard logic</span>
 </pre>
                                        </div> <br>
                                        
                                        <div class="pre-area shadow mvs-10">
 <div class="pxv-10 bc-silver">windows/Routes/Index.php</div>
 <pre class="pre-code">
 
  <span class="c-violet-dd">namespace spoova\windows\Routes;</span>
  
  <span class="c-purple">use Window;</span>

  class Index extends Window {

    function __construct(){

        self::call($this, [

            window(':') => 'root',
            window(':user') => 'user_method',
        
        ]);

    }

    function root() {

        <span class="comment">//call this on index page</span>

    }

    function user_method() {

        <span class="comment">//call this on index/user page</span>

    }



  }
 </pre>
                                        </div> <br>
                                        
                                        <div class="font-em-d8">
                                         In the code above, note that <code>window(':')</code> will return a requested 
                                         (or current) url's entry point name. Since, Index is the entry server file, then, 
                                         <code>index</code> will be returned. Also, <code>window(':user')</code> will return 
                                         <code>index/user</code>. Since <code>call()</code> is a shutter method, 
                                         if the method <code>user_method()</code> does not exist or when the <code>http://domain/index/user</code>, 
                                         page is visited, then a 404 error will be returned. Once a method is defined, developer is left 
                                         to handle how to close such urls. Any of a window's method can use the shutter methods. It is important to note that 
                                         shutter methods are specifically built for standard logic. Hence, they may work differently under a different logic.
                                        </div>
                                    </div>
                                </div>
                            </div> <br>

                        </div>
                        
                
                    </div>  

                    <div class="windows-files"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Files </div>
                        </div> <br>

                        
                        <div>
                            In the creation of windows project, all window files (classes) must have the following features :
                            <br><br>
                            <ul>
                                <li>A window file must exist within the <code>windows/</code> directory or subdirectory</li>
                                <li>A window file (class) must be extended to the root <code>Window</code> class</li>
                                <li>A window file (class) must have a public <code>__construct()</code> method (entry point).</li>
                                <li>A window file (class) must have a closing structure</li>
                            </ul>
                        </div> 
                
                    </div>  

                    <div class="windows-frames"> 
                        
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Frames </div>
                        </div> <br>

                        
                        <div>
                            Frames are used to bind window files together. The provide similar data shared across window files. 
                            Although, Frames are extensions of Window class itself, they act as bridges or gaps between the root Window class 
                            and a Window child class. When a class is extended to a frame class, it inherits both the properties of the root window class
                            along with the specific frame class. The purpose of frame is to separate windows files that have different data from each other.
                            All window files sharing the same Frame will have data belonging to their specific frames. 
                            <br><br>
                            In order to identify frame files, they should have the following features:
                            <br><br>
                            
                            <ul>
                                <li>Should be placed in a "Frames" folder, a direct subdirectory of windows folder</li>
                                
                                <li>A frame file (class) should extend to the root Windows class</li>
                                <li>A frame file (class) should never be used to close a window</li>
                                <li>A frame file (class) should contain only data essential for its children classes</li>
                                
                                <li>A frame file (class) should not be used to render rex template files.</li>
                                <li>A frame file (class) may be attached to a specific session channel, thereby including data specific only to that session.</li>    
                            </ul>
                            
                        </div>
                
                    </div>  

                    <div class="about_wmv"> 
                        <br>
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv"> <span class="bi-card-list mxr-8 c-lime-dd"></span> Note </div>
                        </div> <br>

                        
                        <div>
                            There are several key points to note when working with the wvm network. To futher explain the wmv 
                            pattern, we have categorized important keynotes to the underlying subjects:
                            <br><br>
                            <ul class="c-olive">
                                <li> <a href="@route('.wmv')">About <span class="fb-6 pointer" title="Windows Models View">WMV</span> and <span class="fb-6 pointer" title="Model View Controller">MVC</span>?</a></li>
                                <li> <a href="@route('.open')">Opening and Closing windows</a> </li>
                                <li> <a href="@route('.calls')">Windows Calls</a> </li>
                                <li> <a href="@route('.middlewares')">Windows Middlewares</a> </li>
                                <li> <a href="@route('.frames')">Window Frames</a> </li>
                                <li> <a href="@route('.routes')">Window Routes</a> </li>
                                <li> <a href="@route('::apis')">Window APIs</a> </li>
                                <li> <a href="@route('::models')">Window Models</a> </li>
                                <li> <a href="@route('::rex')">Window Rex</a> </li> 
                                <li> <a href="@route('.methods')">Window Methods</a> </li>
                                <li> <a href="@route('.inverse')">Window Inverse</a> </li>
                                <li> <a href="@route('.errors')">Window Errors</a> </li>
                            </ul>
                        </div>      
                
                    </div>  

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;