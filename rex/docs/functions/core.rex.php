@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

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
            </div> <br><br>
            
            <div>
              The framework's core classes are located in the <code>core/classes</code> 
              folder while the tools are located in the <code>core/tool</code> folder. The <code>webClass()</code> 
              and <code>webTool()</code> methods loads classes from their respective folders. 
              In the line below, both line 1 & 2 resolves to the same class folder while line 3 & 4 loads from the 
              tools folder.
            </div> <br>

  <div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">1.</span>$myclass = spoova\core\classes\myclass;

      <span class="comment">2.</span>$myclass = webClass('myclass');
    </pre>    
  </div>
      
        </div>  <br>

        <div id="webtool" class="webtool"><br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                2. webTool
            </div> <br><br>
            
            <div>
              Just like the <a href="@Domurl('tutorial/functions/helpers#webclass')">webClass</a>, the webTool loads its 
              classes from the <code>core/tools</code> folder.
            </div> <br>

<!-- code line started -->
  <div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">1.</span>$mytool = spoova\core\tools\myclass;

      <span class="comment">2.</span>$mytool = webTool('myclass');
    </pre>
  </div>
<!-- code line ended -->
      
        </div>  <br>

        <div id="isguest" class="isguest"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                3. isGuest
            </div> <br><br>
            
            <div>
             This function depends on the <code>User</code>  class. It returns a bool of true when a user is NOT logged in.
            </div>      
        </div> <br>

        <div id="isuser" class="isuser"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                4. isUser
            </div> <br><br>
            
            <div>
             This function also depends on the <code>User</code>  class. It returns a bool of true when a user is logged in.
            </div>      
        </div> <br>

        <div id="ishttp" class="ishttp"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                5. isHTTP
            </div> <br><br>
            
            <div>
             This function returns true if a protocol begins with <code>http://</code> class.
            </div>      
        </div> <br>

        <div id="ishttps" class="ishttps"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                6. isHTTPS
            </div> <br><br>
            
            <div>
             Similarly to <code>isHTTP</code>, it returns true if a url begins with <code>https://</code> class.
            </div>      
        </div> <br>

        <div id="isabsolutepath" class="isabsolutepath"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                7. isAbsolutePath
            </div> <br><br>
            
            <div>
             This returns true on absolute urls.
            </div>      
        </div> <br>

        <div id="authdirect" class="authDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                8. authDirect
            </div> <br><br>
            
            <div>
             The <code>authDirect</code> is used to redirect only an authenticate user to another page. 
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      authDirect('new_url_here')
    </pre>
  </div>
<!-- code line ended -->
        </div> <br>

        <div id="guestdirect" class="guestDirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                9. guestDirect
            </div> <br><br>
            
            <div>
            The <code>guestDirect</code> is used to redirect a user to another page only when logged out. 
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      guestDirect('new_url_here')
    </pre>
  </div>
<!-- code line ended -->
        </div> <br> 

        <div id="redirect" class="redirect"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                10. redirect
            </div> <br><br>
            
            <div>
            The <code>redirect</code> function is the spoova internal way of 
            redirecting urls. Url's are redirected to pages based on the project root 
            folder. For example, if the project folder is <code>app</code>, the <code>redirect</code> 
            function begins its redirection in the project root. This means that the <code>app</code> 
            is not included as part of the url supplied.
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      redirect('/') <span class="comment">// redirect to accessible site root</span>
      redirect('index') <span class="comment">// redirect index page inside accessible site root</span>
    </pre>
  </div>
<!-- code line ended -->
        </div> <br> 

        <!-- response -->
        <div id="response" class="response"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                11. response
            </div> <br><br>
            
            <div>
            The <code>response</code> function is an http_response_code driven json string 
            that is built for handling ajax responses. It takes an http response code as argument 
            and uses it to build a json response string. By default, all 4xx and 5xx response codes 
            when supplied as argument are considered as errors while other response codes are considered 
            as successes. This behaviour sets the json error key as true when any of the error codes are 
            supplied as argument. These can be overidden by supplying a third boolean argument that defines 
            the success status of the response. When error is set as true, success becomes false and vice versa.
            </div> <br>   

<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      response(200, 'successful') <span class="comment"> // {"success":true,"error":false,"message":"successful","response_code":200}</span>
      response(500, 'failed') <span class="comment">     // {"success":false,"error":true,"message":"failed","response_code":500} </span>

      response(500, 'some message', true) <span class="comment">// {"success":true,"error":false,"message":"some message","response_code":500} </span>
    </pre>
  </div>
<!-- code line ended -->

              <div class="font-menu font-em-d85">
                In the examples above, the first two lines returns a json response based on the supplied 
                response code while the last code was overwritten be supplying a third argument 
                of true, inidicating a success.
              </div>
        </div> <br>

        <!-- setvar -->
        <div id="setvar" class="setvar"> <br> 
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                12. setVar <br>
  <div class="pre-area">
  <pre class="pre-code" style="font-size:1.1em">


  
  <span class="comment">//syntax</span>
  setVar(main, alternate, replacement);
  
  <span class="c-sky-blue-dd">main : main test value
  alternate : alternate value
  replacement: boolean value to determine if main value is updated with alternate value</span>
  </pre>
  </div>
            </div> <br><br>
            
            <div>
            This is a complex function that is used to perform several functions which include <br>
              <br>

              <ul>

              
                <li>
                  initializes variables through reference.
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">// Example 1 - Unexisting variables</span>

      setVar($new_variable);

      var_dump($new_variable); <span class="comment">// void</span>


      <span class="comment">// Example 2 - Existing variables</span>
      $val = 'foo';

      echo( setVar($val) ); <span class="comment">// foo</span>
    </pre>
  </div>
<!-- code line ended -->
                </li> <br>


                <li>
                returns a custom defined variable for an undefined or empty variables.
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">// Example 1</span>
      $alt = 'alternate';

      echo ( setVar($old, $alt) ); <span class="comment">// alternate</span>


      <span class="comment">// Example 2</span>
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
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">// Example 1</span>
      $alt = 'alternate';
      
      setVar($old, $alt, true);

      echo ( $old ); <span class="comment">// alternate</span>


      <span class="comment">// Example 2</span>
      $old = 'main';
      $alt = 'alternate';

      echo ( setVar($old, $alt, true) ); <span class="comment">// main</span>
    </pre>
  </div>
<!-- code line ended -->

                </li>

              </ul>
              <div class="font-menu font-em-d85">
                It should be noted that a alternate value is only activated when the main test value is empty or undefined.
              </div>
            </div> 

        </div>

        <!-- vdump -->
        <div id="vdump" class="vdump"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                13. vdump
            </div> <br><br>
            
            <div>
             This function dumps the information of a value supplied while exiting the page.
            </div> <br>      
        </div> <br>        

        <div id="urlparams" class="urlparams"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                14. urlParams
            </div> <br><br>
            
            <div>
             It returns the parameters of a supplied url. If no argument is supplied, 
             it uses the current page url as default url.
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      $params = urlParams('http://site.com/users?val=foo&var=bar');

      print_r($params); <span class="comment">// ['val'=>'foo', 'var'=> 'bar']</span>
    </pre>
  </div>
<!-- code line ended -->
        </div> <br>        
        
        <div id="url" class="url"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                15. url
            </div> <br><br>
            
            <div>
             The <code>url</code> function is used to return the <code>Url</code> class. Url class is 
             used to manage urls. <a href="">Learn more.</a>
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      <span class="comment">// returns profile</span>
      url('http://site.com/users#profile')->hash()
    </pre>
  </div>
<!-- code line ended -->
        </div> <br>

        <!-- ROUTE FUNCTIONS -->
        <div class="font-em-2 c-orange">Route Functions</div>

        <!-------------------------------- compile -->
        <div id="compile" class="compile"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                16. compile
            </div> <br><br>
            
            <div>
             This belongs to the Router class and can only be used within the router class to compile and render 
             the contents of a page. It can only be used once within each route.
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      Res::load('file', fn => compile());
    </pre>
  </div>

<!-- code line ended -->
<br><br>
<!-- code line started -->
  <div class="pre-area"> <br><br>
    <pre class="pre-code">
      class Home {
        
        function construct(){

          self::load('file', fn => compile());

        }

      }
    </pre>
  </div>   <br><br>
  <!-- code line ended -->
  <div class="font-menu font-em-d85">
    It should be noted that the first example above will work but the second example will not work.
    In order for example 2 to work, it must be extended to a controller or windows file just as below:
  </div> <br>

  <div class="pre-area"> <br><br>
    <pre class="pre-code">
      use spoova\core\classes\Controller;

      <span class="c-sky-blue-dd">class Home extends Controller{</span> 
        
        function construct(){

          self::load('file', fn => compile());

        }

      <span class="c-sky-blue-dd">}</span>
    </pre>
  </div> <br><br>

  <div class="font-menu font-em-d85">
    Compile can accept globally and locally declared variables and in turn pass these variables 
    as local variable to rex template files. When global variables are injected locally, such variables will be accessible 
    within the global and local scopes. 
    Only arrays are accepted as arguments.
  </div> <br>

  <div class="pre-area"> 
    <div class="bc-off-white pxv-6">Example 1 - Global variables injection</div>
    <br><br>
    <pre class="pre-code">
      $var = ['name' => 'foo'];

      Res::load('index', fn => compile($var));
    </pre>
  </div> <br><br>

  <div class="pre-area"> 
    <div class="bc-off-white pxv-6">Example 2 - Local variables injection</div>
    <br><br>
    <pre class="pre-code">
      use spoova\core\classes\Controller;

      <span class="c-sky-blue-dd">class Home extends Controller{</span> 
        
        function construct(){

          $var = ['name' => 'foo', 'title' => 'bar'];

          self::load('file', fn => compile($var));

        }

      <span class="c-sky-blue-dd">}</span>
    </pre>
  </div>   
        </div> <br>


        <!-------------------------------- view -->
        <div id="view" class="view"> <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
                17. view
            </div> <br><br>
            
            <div>
             This function can also be used within the router class. 
             Unlike the <code>compile()</code> method, the <code>view()</code> method can be applied more than once and can be 
             used to render more than one template engines.
            </div> <br>      
<!-- code line started -->
<div class="pre-area"> <br><br>
    <pre class="pre-code">
      Res::load('file', fn => view('file'));
    </pre>
  </div>

<!-- code line ended -->
<br><br>

  
  <div class="font-menu font-em-d85">
    It should be noted that the first example above will work but the second example will not work.
    In order for example 2 to work, it must be extended to a controller or windows file just as below:
  </div> <br>

  <div class="pre-area"> <br><br>
    <pre class="pre-code">
      use spoova\core\classes\Controller;

      <span class="c-sky-blue-dd">class Home extends Controller{</span> 
        
        function construct(){

          $file1 = view('file1');
          $file2 = view('file2');
          
          return $file1.$file2;

        }

      <span class="c-sky-blue-dd">}</span>
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
      <div class="bc-off-white pxv-6">Example 1 - Global variables injection</div>
      <br><br>
      <pre class="pre-code">
        $var = ['name' => 'foo'];

        Res::load('index', fn => view('file', $var));
      </pre>
    </div> <br><br>

    <div class="pre-area"> 
      <div class="bc-off-white pxv-6">Example 2 - Local variables injection</div>
      <br><br>
      <pre class="pre-code">
        use spoova\core\classes\Controller;

        <span class="c-sky-blue-dd">class Home extends Controller{</span> 
          
          function construct(){

            $args = ['name' => 'foo', 'title' => 'bar'];

            $view1 = view('file1', $args);
            $view2 = view('file2');

            $view = $view1.$view2;

            return self::load('file', fn => $view );

          }

        <span class="c-sky-blue-dd">}</span>
      </pre>
    </div>  
    <div class="font-menu font-em-d85">
      In the example above, <code>file1</code> and <code>file2</code> 
      were rendered (viewed) and displayed on a template <code>file</code>. 
      The contents of the <code>file</code> itself is not rendered but <code>file</code>
      only serves as an anchor for the loaded files to be viewed. Variables are likewise passed 
      in an array <code>$args</code> as argument.
    </div> <br>
    @lay('build.links:tutor_pointer')
    
  </div> <br>  


        </div> <br>  


    </div> <br>    

    @lay('build.coords:footer')
    
@template;