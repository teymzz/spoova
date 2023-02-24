
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions - Core</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper functions are predefined spoova functions that eases building 
                web applications. These functions are discussed below
                <br>
                
            </div> 
          </div> <br>
          
          <div id="webclass" class="webclass">
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                1. webClass
            </div>
            
            <div class="mvt-10">
              The framework's core classes are located in the <code>core/classes</code> 
              folder while the tools are located in the <code>core/tool</code> folder. The <code>webClass()</code> 
              and <code>webTool()</code> methods loads classes from their respective folders. 
              In the line below, both line 1 & 2 resolves to the same class folder while line 3 & 4 loads from the 
              tools folder.
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  <span class="comment">1.</span>$myclass = spoova\core\classes\myclass;

  <span class="comment">2.</span>$myclass = webClass('myclass');
              </pre>    
            </div>
          </div>

          <div id="webtool" class="webtool"><br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                2. webTool
            </div>
            
            <div class="mvt-10">
              Just like the <a href="@Domurl('docs/functions/core#webclass')">webClass</a>, the webTool loads its 
              classes from the <code>core/tools</code> folder.
            </div> <br>

            <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  <span class="comment">1.</span>$mytool = spoova\core\tools\myclass;

  <span class="comment">2.</span>$mytool = webTool('myclass');
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="isguest" class="isguest"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                3. isGuest
            </div>
            
            <div class="mvt-10">
            This function depends on the <code>User</code>  class. It returns a bool of true when a user is NOT logged in.
            </div>      
          </div>

          <div id="isuser" class="isuser"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                4. isUser
            </div>
            
            <div class="mvt-10">
            This function also depends on the <code>User</code>  class. It returns a bool of true when a user is logged in.
            </div>      
          </div>

          <div id="ishttp" class="ishttp"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                5. isHTTP
            </div>
            
            <div class="mvt-10">
            This function returns true if a protocol begins with <code>http://</code>.
            </div>
  <div class="pre-area">
    <pre class="pre-code">
  echo isHTTP('http://site.com'); <span class="comment">//returns: true</span>
    </pre>
  </div>      
          </div>

          <div id="ishttps" class="ishttps"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                6. isHTTPS
            </div>
            
            <div class="mvt-10">
            Similarly to <code>isHTTP</code>, it returns true if a url begins with <code>https://</code>.
            </div>      
          </div>

          <div id="isabsolutepath" class="isabsolutepath"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                7. isAbsolutePath
            </div>
            
            <div class="mvt-10">
            This returns true on absolute urls.
            </div>  
            <div class="pre-area">
  <pre class="pre-code">
  echo isAbsolutePath('folder/path/space'); <span class="comment">//returns: true</span>
  
  echo isAbsolutePath('http://site.com/folder/path/space'); <span class="comment">//returns: false</span>
  </pre>
            </div>    
          </div>

          <div id="invoked" class="invoked"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                8. invoked
            </div>
            
            <div class="mvt-10">
            The <code>invoked</code> is a case-sensitive function that is used to check if the current url matches the  
            supplied url within a windows url. Only absolute path from the window entry point 
            should be supplied. Since index pages can either be empty (i.e "") or "index", a frontslash ("/") can be used to denote 
            an index page.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( invoked('some/url') ){

     <span class="comment">// currently in url some url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="windowIncludes" class="windowincludes"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                8. windowIncludes
            </div>
            
            <div class="mvt-10">
            The <code>windowIncludes</code> is a case-sensitive function that is used to check if the current base url matches the  
            list of supplied urls. Since index pages can either be empty (i.e "") or "index", a frontslash ("/") can be used to denote 
            an index page.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( windowIncludes('some/url') ){

     <span class="comment">// currently in url some url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="windowExcludes" class="windowincludes"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                9. windowExcludes
            </div>
            
            <div class="mvt-10">
            This method is an inverse of <code>windowIncludes</code>. It is also a case-sensitive function and it returns true if the 
            current page url does not exist within the list of supplied urls.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  if( windowExcludes(['some/url']) ){

     <span class="comment">//... do this if current url is not in list of url</span>

  }
                </pre>
              </div>
            <!-- code line ended -->
          </div>



          <div id="authdirect" class="authDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                10. authDirect
            </div>
            
            <div class="mvt-10">
            The <code>authDirect</code> is used to redirect only an authenticate user to another page. 
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  authDirect('new_url');
                </pre>
              </div>
            <!-- code line ended -->
          </div>

          <div id="guestdirect" class="guestDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                11. guestDirect
            </div>
            
            <div class="mvt-10">
            The <code>guestDirect</code> is used to redirect a user to another page only when logged out. 
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  guestDirect('new_url');
              </pre>
            </div>
            <!-- code line ended -->
          </div> 

          <div id="redirect" class="redirect"> <br> 
              <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                  12. redirect
              </div>
              
              <div class="mvt-10">
              The <code>redirect</code> function is the spoova internal way of 
              redirecting urls. Url's are redirected to pages based on the project root 
              folder. For example, if the project folder is <code>app</code>, the <code>redirect</code> 
              function begins its redirection in the project root. This means that the <code>app</code> 
              is not included as part of the url supplied.
              </div> <br>      
              <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  redirect('/') <span class="comment">// redirect to accessible site root</span>
  redirect('index') <span class="comment">// redirect index page inside accessible site root</span>
                </pre>
                </div>
              <!-- code line ended -->
          </div> 

          <!-- response -->
          <div id="response" class="response"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                13. response
            </div>
            
            <div class="mvt-10">
            The <code>response</code> function is an http_response_code driven json string 
            that is built for handling ajax responses. It takes an http response code as argument 
            and uses it to build a json response string. By default, all 4xx and 5xx response codes 
            when supplied as argument are considered as errors while other response codes are considered 
            as successes. This behaviour sets the json error key as true when any of the error codes are 
            supplied as argument. These can be overidden by supplying a third boolean argument that defines 
            the success status of the response. When error is set as true, success becomes false and vice versa.
            </div> <br>   

            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  response(200, 'successful') <span class="comment"> // {"success":true,"error":false,"message":"successful","response_code":200}</span>
  response(500, 'failed') <span class="comment">     // {"success":false,"error":true,"message":"failed","response_code":500} </span>

  response(500, 'some message', true) <span class="comment">// {"success":true,"error":false,"message":"some message","response_code":500} </span>
                </pre>
              </div>
            <!-- code line ended -->

            <div class="font-menu font-em-d85 mvt-10">
              In the examples above, the first two lines returns a json response based on the supplied 
              response code while the last code was overwritten be supplying a third argument 
              of true, inidicating a success.
            </div>
          </div>

          <!-- setvar -->
          <div id="setvar" class="setvar"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd rad-4 pxv-8">
              <div class="box-full">
                14. setVar
              </div> <br>
              <div class="pre-area">
                <pre class="pre-code" style="font-size:1.2em">
   setVar($main, $alternate, $replacement);
  
   <span class="comment">where:</span>

   <span class="c-green">$main : main test value
   $alternate : alternate value
   $replacement: boolean value to determine if main value is updated with alternate value</span>
                </pre>
              </div>
            </div> <br>
            
            <div class="mvt-10">
              The <code>setVar</code> is a complex function that is used to perform several functions which include <br>
              <br>

              <ul>
                <li>
                  initializes variables through reference.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment no-select pxv-10 bc-silver">Example 1 - Undefined variables</div>
                      <pre class="pre-code">

  setVar($new_variable);

  var_dump($new_variable); <span class="comment">// void</span>

                      </pre>
  <div class="comment no-select pxv-10 bc-silver"> Example 2 - Defined variables</div>
                      <pre class="pre-code">
  $val = 'foo';

  echo( setVar($val) ); <span class="comment">// foo</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li> <br>


                <li>
                  returns a custom defined variable for an undefined or empty variables.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment no-select pxv-10 bc-silver">Example 1 - Undefined variable alternate</div>
  <pre class="pre-code">
  echo ( setVar($old, 'alternate') ); <span class="comment">// alternate</span>
  </pre>
  
  <div class="comment no-select pxv-10 bc-silver">Example 2 - Defined variable ignores alternate</div>
  <pre class="pre-code">
  $old = 'main';
  $alt = 'alternate';

  echo ( setVar($old, $alt) ); <span class="comment">// main</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li> <br>

                <li>
                  updates or modifies a supplied empty variable with alternate value when 
                  the third argument is set as true.
                  <!-- code line started -->
                  <div class="pre-area shadow">
  <div class="comment pxv-10 bc-silver">Example 1</div>
                      <pre class="pre-code">
  $alt = 'alternate';
  
  setVar($old, $alt, true);

  echo ( $old ); <span class="comment">// alternate</span>
                      </pre>
  <div class="comment pxv-10 bc-silver">Example 2</div>
                      <pre class="pre-code">
  $old = 'main';
  $alt = 'alternate';

  echo ( setVar($old, $alt, true) ); <span class="comment">// main</span>

  echo ( $old ); <span class="comment">// main</span>
                      </pre>
                    </div>
                  <!-- code line ended -->
                </li>

              </ul>

              <div class="font-menu font-em-d85">
                It should be noted that a alternate value is only activated when the main test variable is empty or undefined.
              </div>

            </div> 

          </div>

          <!-- vdump -->
          <div id="vdump" class="vdump"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                15. vdump
            </div>
            
            <div class="mvt-10">
            This function dumps the information of a value supplied while exiting the page. When dumping values, it provides special divisions of information based on the 
            data type returned.
            </div>    
          </div>        

          <!-- vdump -->
          <div id="env" class="env"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                16. env
            </div>
            
            <div class="mvt-10">
            The <code>env</code> function is used to access keys declared within the <code>$_ENV</code> global variable. It takes two arguments. The first argument 
            is the access key any stored value while the second argument is a modifier option that specfies where data should be obtained. This function also  
            works along with the <code>Filemanager::loadenv()</code> method. The samples below reveals the response of <code>env()</code> function. 

              <div class="sample-1">
                <div class="pre-area">
                  <div class="pxv-10 bc-silver">
                    Sample 1: Filemanager::loadenv()
                  </div>
                  <pre class="pre-code">
    Filemanager::loadenv('some_path');
  
    env('some_key');
                  </pre>
                </div>
                <div class="foot-note">
                  In the format above, assuming the path <code>"some_path"</code> contains a configuration key <code>"some_key"</code>, when the <code>env("some_key")</code> 
                  method is used, it tries to search for the value of "some_key" in the <code>$_ENV</code> global varible. If the index key does not exist in the global scope, 
                  since by default, <code>Filemanager::loadenv()</code> stores value into the <code>":ENV"</code> key, the <code>env()</code> will search for the key within the 
                  <code>$_ENV[':ENV']</code> global access key and if the key does not exist also, then an empty string is returned.
                </div> 
              </div><br>

              <div class="sample-2">
                <div class="pre-area">
                  <div class="pxv-10 bc-silver">
                    Sample 2: Filemanager::loadenv()
                  </div>
                  <pre class="pre-code">
    FileManager::loadenv('some_path');
  
    env('some_key', true);
                  </pre>
                </div>
                <div class="foot-note">
                 Using sample 1 as reference, when second argument of <code>env()</code> is set as true, then only global keys will be fetched and the <code>FileManager::loadenv()</code> 
                 method will be ignored.
                </div> 
              </div><br>

              <div class="sample-1">
                <div class="pre-area">
                  <div class="pxv-10 bc-silver">
                    Sample 3: Filemanager::loadenv()
                  </div>
                  <pre class="pre-code">
    FileManager::loadenv('some_path');
  
    env('child_key', 'parent_key');
                  </pre>
                </div>
                <div class="foot-note">
                 Also, using sample 1 as reference, when second argument of <code>env()</code> is a non-empty string, the <code>env()</code> function will look within the <code>"parent_key"</code> 
                 for a <code>"child_key"</code> and the value of the <code>"child_key"</code> will be returned if it exists.
                </div> 
              </div>


            </div>    
          </div> <br>       

          <div id="urlparams" class="urlparams"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                17. urlParams
            </div>
            
            <div class="mvt-10">
              It returns the parameters of a supplied url. If no argument is supplied, 
              it uses the current page url as default url.
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  $params = urlParams('http://site.com/users?val=foo&var=bar');

  print_r($params); <span class="comment">// ['val'=>'foo', 'var'=> 'bar']</span>
                </pre>
              </div>
            <!-- code line ended -->
          </div>        
          
          <div id="url" class="url"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                18. url
            </div>
            
            <div class="mvt-10">
            The <code>url()</code> function is used to return the <code>Url</code> class. Url class is 
            used to manage urls. It takes only one argument which is used as the test url and returns the instance 
            of the Url class. You can learn more about url class from <a href="@domurl('docs/classes/url')"><span class="c-olive hyperlink">here</span></a>
            </div> <br>      
            <!-- code line started -->
            <div class="pre-area shadow">
                <pre class="pre-code">
  url('http://site.com/users#profile')->hash(); <span class="comment">// returns profile</span>
                </pre>
              </div>
            <!-- code line ended -->
          </div> <br>

          <!-- ROUTE FUNCTIONS -->
          <div class="font-em-1d1 c-orange">Route Functions</div>
          <div class="div">Route functions are function designed specifically to handle routing operations. These functions are <code>compile()</code> 
          and <code>view()</code>. </div>
          <!-------------------------------- compile -->
          <div id="compile" class="compile"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                19. compile
            </div>
            
            <div class="mvt-10">
              This funtion can only be used once within the <code>Router</code> class to compile and render 
              the contents of a page. It can only be used once within each route.
            </div> <br>    

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  Res::load('file', fn => compile());
              </pre>
            </div>
            <br><br>
            <!-- code line ended -->

            <!-- code line started -->
              <div class="pre-area shadow">
                <pre class="pre-code">
  class Home {
    
    function __construct(){

      self::load('file', fn => compile());

    }

  }
                </pre>
              </div>   <br><br>
            <!-- code line ended -->

            <div class="font-menu font-em-d85">
              It should be noted that the first example above will work but the second example will not work.
              In order for example 2 to work, it must be extended to a windows file just as below:
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function __construct(){

      self::load('file', fn => compile());

    }

  <span class="c-green">}</span>
              </pre>
            </div> <br><br>

            <div class="font-menu font-em-d85">
              Compile can accept globally and locally declared variables and in turn pass these variables 
              as local variable to rex template files. When global variables are injected locally, such variables will be accessible 
              within the global and local scopes. 
              Only arrays are accepted as arguments.
            </div> <br>

            <div class="pre-area"> 
              <div class="bc-silver pxv-6">Example 1 - Global variables injection</div>
              <pre class="pre-code">
  $var = ['name' => 'foo'];

  Res::load('index', fn => compile($var));
              </pre>
            </div> <br><br>

            <div class="pre-area"> 
              <div class="bc-silver pxv-6">Example 2 - Local variables injection</div>
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function __construct(){

      $var = ['name' => 'foo', 'title' => 'bar'];

      self::load('file', fn => compile($var));

    }

  <span class="c-green">}</span>
              </pre>
            </div>   
          </div>


          <!-------------------------------- view -->
          <div id="view" class="view"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                20. view
            </div>
              
            <div class="mvt-10">
              This function can also be used within the router class. 
              Unlike the <code>compile()</code> method, the <code>view()</code> method can be applied more than once and can be 
              used to render more than one template engines.
            </div> <br> 

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  Res::load('file', fn => view('file'));
              </pre>
            </div>

            <br><br>
            <!-- code line ended -->

    
            <div class="font-menu font-em-d85">
              The code above can also be used within a window file as shown below:
            </div> <br>

            <div class="pre-area shadow">
              <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends Window{</span> 
    
    function __construct(){

      $file1 = view('file1');
      $file2 = view('file2');
      
      return $file1.$file2;

    }

  <span class="c-green">}</span>
              </pre>
            </div> 
          </div> <br>

          <div class="font-menu font-em-d85">
            Just like compile, <code>view</code> can accept globally and locally declared variables and in turn pass these variables 
            as local variable to rex template files. When global variables are injected locally, such variables will be accessible 
            within the global and local scopes. 
            Only arrays are accepted as arguments.
          </div> <br>

          <div class="pre-area"> 
            <div class="bc-silver pxv-6">Example 1 - Global variables injection</div>
            <pre class="pre-code">
  $var = ['name' => 'foo'];

  Res::load('index', fn => view('file', $var));
            </pre>
          </div> <br><br>

          <div class="pre-area"> 
            <div class="bc-silver pxv-6">Example 2 - Local variables injection</div>
            <pre class="pre-code">
  use Window;

  <span class="c-green">class Home extends window{</span> 
    
    function __construct(){

      $args = ['name' => 'foo', 'title' => 'bar'];

      $view1 = view('file1', $args);
      $view2 = view('file2');

      $view = $view1.$view2;

      return self::load('file', fn => $view );

    }

  <span class="c-green">}</span>
            </pre>
          </div>  

          <div class="font-menu font-em-d85 mvt-6">
            In the example above, <code>file1</code> and <code>file2</code> 
            were rendered (viewed) and displayed on a template <code>file</code>. 
            The contents of the <code>file</code> itself is not rendered but <code>file</code>
            only serves as an anchor for the loaded files to be viewed. Variables are likewise passed 
            in an array (<code>$args</code>) as argument.
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;