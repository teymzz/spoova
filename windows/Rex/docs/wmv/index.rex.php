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
                            can be classified into three categories which are <code>Routes</code>, <code>Frames</code> 
                            and <code>APIs</code>.

                            The WMV depends on a structure where the <code>Model</code> is created before a 
                            <code>View</code> is rendered. In order to work with wmv framework, 
                            A window file must be created. Window files are classes that are extended to a root Window manager class.
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
                            The first thing to take note of when creating a windows project file is the windows folder.
                            The windows folder is expected to have a server entry point. By order of standard, spoova employs 
                            a standard logic which uses an <code>Index.php</code> file as a server entry point. This file exists within the 
                            windows root directory (i.e <code>window/Routes/Index.php</code> )  which extends to the 
                            root <code>Window</code> class. By default, when running our application, whenever a page is loaded,
                            the url is transferred to the windows management structure. This will try to resolve the url by looking for 
                            a route file within the windows/Routes folder. If a window entry class file matching a url's entry 
                            name does not exist, spoova will return a 404 error. It is however worth to be emphasized that all window files should be initialized with an 
                            upper case character. Spoova favors 3 different logics for loading window files. 
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
                                        
                                        If this is done, then the application will assume that a <code>windows/Routes/Basic.php</code> file controls the entire application by 
                                        taking the full ownership and control of how urls run. This means that every url will first land on that <code>windows/Routes/Basic.php</code> file which 
                                        then determines how that url is handled. In this manner, the Basic file is the sole distributor and manager of all urls. Without it, pages will 
                                        not be able to load. Also, it is worth noting that in this logic, all urls are opened and considered as valid. The management of invalid urls and their 
                                        response codes are left for developers to handle.
                                    </div>
                                </div>
                            </div> <br>


                            <div class="pxs-14">
                                <span id="index-logic"></span>
                                <div class="index-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Index Logic</div>
                                    <div class="desc mvt-10">
                                        Index logic is built upon the basic logic. In this logic, the <code class="calibri">Window/Routes/Index.php</code>
                                        file is allowed to run its pages through a method <code class="calibri">"root"</code>. This serves as a door to manage 
                                        urls. If the <code class="calibri">root()</code> method does not exist within the <code>windows/Routes/Index.php</code> file and 
                                        the current requested page url is not an index page, that is, <code class="calibri">http://host_name/</code> or <code class="calibri">http://host_name/index</code>, then 
                                        a 404 error will be returned. The structure below is an example of how to set up an index logic. 
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
      
         self::pathcall($this, [
    
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
                                         In the code above, by setting the <code>index.php</code> file to 
                                         <code>Server::run('index')</code>, the application will try to call the <code>windows\Routes\Index.php</code>. 
                                         If the file exists and the currently requested url is an index page, the <code>windows\Routes\Index.php</code>file will in turn call its <code>root()</code> method.
                                         However, if a different url is called whose entry point name is not "index", rather than call the <code>root()</code> method, 
                                         spoova will check if the route exists first and try to use it to handle its relative url through <code>self::callRoute()</code> which ensures that 
                                         the window tries to load every page using a class entry window name that exists within the windows directory. If the url handler or window router file 
                                         does not exist, then a 404 reponse is returned through the <code>self::close()</code> method. In any given url, The <code>window('root')</code> or <code>window(':')</code> 
                                         is always the name that comes after the domain url. In localhost, it is the name that comes after the project folder name.
                                        </div>


                                    </div>
                                </div>
                            </div> <br>

                            <div class="pxs-14">
                                <span id="standard-logic"></span>
                                <div class="standard-logic">
                                    <div class="subject c-olive"><i class="bi-circle-fill"></i> Standard Logic</div>
                                    <div class="desc mvt-10">
                                        This logic also uses the <code class="calibri">Window/Routes/Index.php</code> as its index entry point. Unlike other 
                                        logics, this logic suggests that all urls must have a window entry point or server entry file that takes ownership of the its 
                                        relative sub-urls. For example, a home webpage must have its respective <code>Home</code> window class. The window class 
                                        can then take ownership of its sub-urls. This means that a url <code>home</code> and <code>home/user/...</code> for example, will be handled 
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
                                         if the method <code>user_method()</code> does not exist or the when the <code>http://domain/index/user</code>, 
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
                                <li>A window file must exist within the <code>window/</code> directory or subdirectory</li>
                                <li>A window file (class) must be extended to the root <code>Window</code> class</li>
                                <li>A window file (class) must have a public <code>__construct</code> function (entry point).</li>
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
                            Although, a Frames are extensions of Window class itself, they act as bridges or gaps between the root Window class 
                            and a Window child class. When a class is extended to a frame class, it inherits both the properties of the root window class
                            along with the specific frame class. The purpose of frame is to separate windows files that have different data from each other.
                            All window files sharing the same Frame will have data belonging to their specific frames. 
                            <br><br>
                            In order to identify frame files, they should have the following features:
                            <br><br>
                            
                            <ul>
                                <li>Should be placed in a "Frame" folder, a direct subdirectory of windows folder</li>
                                
                                <li>A frame file (class) should extend to the root Windows class</li>
                                <li>A frame file (class) should never be used to close a window</li>
                                <li>A frame file (class) should contain only data essential for its children classes</li>
                                
                                <li>A frame file (class) should not be used to render template engines.</li>
                                <li>A frame file (class) may be attached to an account channel, thereby including data specific only to that account.</li>    
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