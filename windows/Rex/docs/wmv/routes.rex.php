@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
          <div class="font-em-1d2">

              @lay('build.co.links:tutor_pointer')

              <div class="start font-em-d8">
                <div class="font-em-1d5 c-orange">Routes</div> <br>  
                
                <div class="resource-intro">
                    <div class="">
                      The routes method on windows are used to name a route. They help to provide a name for a 
                      particular url which can later be accessed by using the <code>Routes()</code> function or 
                      <code>@Routes()</code> directive. Once the name of a particular url has been defined using 
                      <code>addRoutes()</code> method, if the path changes, as long as the name of the path remains 
                      the same, then such paths can be easily modified across web pages. This functionality makes it 
                      easier to work with links that are called multiple times in a very easier way saving a considerable 
                      amount of time in web development.
                    </div> 
                </div>

                
                <div class="example"> 
                  <br>
                  <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> <span class="bi-globe2 mxr-8 c-lime-dd"></span> Routes Example </div>
                  </div> <br>

                  <div class="">
                      <div class="pre-area">
                          <div class="file-1 pxv-10 bc-orange c-white">Home.php (sample window)</div>
                          <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){
        
        self::loadRoutes();

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' 

        ];
    }

  }

                          </pre>
                      </div>
                  </div>

                  <div class="font-menu mvt-6">
                    The method <code>addRoutes()</code> was applied to the code above, now we can access our <code>home/profile</code> 
                    using the function <code>routes('profile')</code> or directive <code>@routes('profile')</code> in template files.
                  </div>
                    
              
                </div> <br>

                
                <div class="windows-files"> 

                  <div class="c-orange">Route Methods</div>
                  
                  <div>
                    The Window class uses three different methods to handle its named routes which are 
                    <code>addRoutes()</code>, <code>loadRoutes()</code> and <code>getRoutes()</code>.
                    <br><br>

                    <!-- addRoute -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> addRoutes </div>
                    </div>

                    <div class="mvt-10">
                      This method is used to set a route on particular Window. The which can later be loaded using the <code>loadRoutes</code> 
                      method. It follows a predefined structure in which when an array of key pairs "name" and "route" is supplied, then such 
                      array is used to update the <code>Window</code> default routes. Also, an array must be returned when using <code>addRoutes()</code> 
                      method. The syntax structure is shown below:
                      <div class="pre-area">
                        <pre class="pre-code bc-off-white-dd">

  <span class="comment">... sample 1</span>

    public function addRoutes(array $array = []) : array {

        return Window::addRoutes([
        
          'route_name' => 'window/route/url' <span class="comment">// i.e full base url</span> 

        ]);
    }

  <span class="comment">... sample 2</span>

    public function addRoutes(array $array = []) : array {

        return [
        
          'route_name' => 'window/route/url' <span class="comment">// i.e full base url</span> 

        ];
    }

                        </pre>
                      </div> 
                      <div class="font-menu pvs-10">
                        By default, the <code>Window::addRoutes()</code> sets a list of named url 
                        and also returns an array of the currently set url. When the <code>addRoutes</code> 
                        method is redefined in a window file such as <b>sample 2</b> above, 
                        the root <code>Window::addRoutes()</code> must be used to update the routes. 
                        This can be achieved calling the code <code>Window::addRoutes()</code> such as 
                        <b>sample 1</b> above. It can also be achieved in a different way using <code>loadRoutes()</code> 
                        method.
                      </div>
                    </div> <br>

                    <!-- loadRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> loadRoutes </div>
                    </div> <br>
                    <div class="">
                      By default, the <code>Window::loadRoutes()</code> method calls a Window's <code>addRoutes()</code> method. 
                      The root <code>Window</code> class uses its <code>addRoutes()</code> to update its named routes. However, the 
                      <code>addRoutes()</code> method can be re-defined in child Window classes, since the most important concept of the 
                      <code>addRoutes()</code> method is to return an array list of named urls (or routes). If the <code>addRoutes()</code> 
                      was remodified, then the only the root Window <code>addRoutes()</code> method, that is <code>Window::addRoutes()</code> 
                      can be used to update the named urls. This example is displayed in <b>sample 1</b> of <a href="#addroute">addRoutes</a> 
                      discussed earlier. However, if <code>self::loadRoutes()</code> was used within the construct function of a child Window 
                      and the <code>addRoutes()</code> method was only used to return an array within that child Window class, then it is required 
                      to pass the current Window class as an argument into the <code>loadRoutes()</code> method when calling it within that class. 
                      A sample of this is shown below. 
                      <div class="pre-area font-menu bc-off-white-dd">
                        <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){
        
        self::loadRoutes(this);

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' 

        ];
    }

  } 

                        </pre>
                      </div>

                      <div class="font-menu pvs-10">
                        In the sample above, the construct function was used to update the 
                        default routes by passing the instance of the current class into the <code>loadRoutes()</code> method which 
                        by default automatically updates the routes by using the root <code>Window::addRoutes()</code> to pull the 
                        returned routes from the <code>addRoutes()</code> method of the current class.
                      </div>

                    </div> <br>

                    <!-- getRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> getRoutes </div>
                    </div> <br>

                    <div class="">
                      This method only returns the list of named routes for a particular window class. Before this method can successfully return 
                      the list of named route of a class, an update from a previously defined parent Window class must have occured through the use of
                      <code>loadRoutes()</code> method. If no update occurs, the parent Window routes are returned.
                    </div>

                  </div> <br>
              
                </div>  

                @lay('build.co.links:tutor_pointer')

              </div>
              
            </div>
        </section>
    </div>
              @lay('build.co.coords:footer')

    
@template;