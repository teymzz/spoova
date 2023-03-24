@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
          <div class="font-em-1d2">

              @lay('build.co.links:tutor_pointer')

              <div class="start font-em-d8">
                <div class="font-em-1d5 c-orange">Routes</div> <br>  
                
                <div class="resource-intro">
                    <div class="">
                      Routes are classes which are triggered when a specific url is visited. They help to control the response obtained 
                      or activity performed at the trigger of such classes. Routes are also window files which means that they must be 
                      extended to the root <code>Window</code> class either directly or by the use of Frames. Whenever Routes are extended to 
                      Frames, it is usually because they want to inherit a particular property, data or functionality of that specific Frame which is 
                      also a window class. Route files are usually placed within the <code>window/Routes</code> directory. 
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
  &lt;?php

  namespace spoova\mi\window\Routes;

  use Window;

  class Home extends Window {

    function __construct(){
        
        echo "This is some route";

    }
    
  }

                          </pre>
                      </div>
                  </div>   
              
                </div> <br>

                
                <div class="windows-files"> 

                  <div class="c-orange">Route Methods</div>
                  
                  <div>
                    Route methods are designed to control or obtain information about declared route names. These route methods are
                    <code>addRoutes()</code>, <code>loadRoutes()</code> and <code>getRoutes()</code>.
                    <br><br>


                    <!-- addRoute -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> addRoutes </div>
                    </div>

                    <div class="mvt-10">
                      This method is used to declare names for routes on particular Route controller class which can later be loaded using the <code>loadRoutes()</code> 
                      method. It follows a predefined structure in which when an array of key pairs "name" and "route" is supplied, then such 
                      route will be assigned the specific name. Examples are shown below:
                      <br><br>

                      <div class="">
                          <div class="pre-area">
                              <div class="file-1 pxv-10 bc-orange c-white">sample 1 - Local addRoutes()</div>
                              <pre class="pre-code">
  &lt;?php

  namespace spoova\mi\window\Routes;

  use Window;

  class Home extends Window {

    function __construct(){

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' <span class="comment">//set name "profile" for "home/profile" route</span>

        ];
    }

  }

                              </pre>
                          </div>
                      </div>

                      <div class="foot-note mvs-6">
                        In the sample above, the <code>addRoutes()</code> method ensures that a name is assigned for the particular route <code>home/profile</code> 
                        which is expected to be of base url format (i.e full url structure). Once the name of the route is declared, the name can later be used to access the specified route when it is updated. 
                        We can define routes names globally for a route controller using the syntax below:  
                      </div>

                      <div class="">
                          <div class="pre-area">
                              <div class="file-1 pxv-10 bc-orange c-white">sample 2 - Global addRoutes()</div>
                              <pre class="pre-code">
  &lt;?php

  namespace spoova\mi\window\Routes;

  use Window;

  class Home extends Window {

    function __construct(){

    }

    function addRoutes(array $array = []) : array {

        return Window::addRoutes([
        
          'profile' => 'home/profile' <span class="comment">//set name "profile" for "home/profile" globally</span>

        ]);
    }

  }

                              </pre>
                          </div>
                      </div>

                      <div class="foot-note mvs-6">
                        While sample 1 and 2 above may look similar, there is a slight difference. The major differences is that in sample 1 
                        above where the <code>addRoutes()</code> only returns an array, route names declared usually stay unknown to the class itself 
                        unless a method <code>loadRoutes()</code> is used within the constructor function. However, in sample 2 where the <code>Window::addRoutes()</code> 
                        is uses, the declared names are automatically process and accessible within the class.
                        Using sample 2 above as reference, we can access the assigned name of <code>home/profile</code> route by using the function <code>routes('profile')</code> 
                        or directive <code>@routes('profile')</code> in template files. In order to achieve the same effect in sample 1, the <code>loadRoutes()</code> method must first 
                        be applied.
                      </div>       

                    </div> <br>

                    <!-- loadRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> loadRoutes </div>
                    </div> <br>
                    <div class="">
                      By default, the <code>loadRoutes()</code> method calls the <code>addRoutes()</code> method of the root Window class or last globally named route. 
                      However, since <code>addRoutes()</code> method can be re-defined in child Window classes, if the <code>addRoutes()</code> 
                      is re-defined, then only the root <code>Window::addRoutes()</code> method, can be used to update the named urls. This example is displayed in <b>sample 2</b> of <a href="#addroute">addRoutes</a> 
                      discussed earlier. In the event that the <code>addRoutes()</code> method of the current Route uses a direct array only, then it is required 
                      to pass the current Window class as an argument into the <code>loadRoutes()</code> method when calling it within that class. 
                      A sample of this is shown below. <br><br>
                      <div class="pre-area font-menu">
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

                      <div class="foot-note pvs-10">
                        In the sample above, the <code>__construct()</code> method was used to update the 
                        default routes by passing the instance of the current class into the <code>loadRoutes()</code> method which 
                        by default automatically updates the routes by using the root <code>Window::addRoutes()</code> to pull the 
                        route names from the <code>addRoutes()</code> method of the current class. Once this is done, then the <code>routes()</code> 
                        method will be able to access the declared names.
                      </div>

                    </div> <br>

                    <!-- getRoutes -->
                    <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                      <div class="flex-full midv"> <span class="bi-circle mxr-8 c-lime-dd"></span> getRoutes </div>
                    </div> <br>

                    <div class="">
                      This method only returns the list of named routes for a particular window class. Before this method can successfully return 
                      the list of named route of a class, the <code>loadRoutes()</code> or <code>Window::addRoutes()</code> method must have been used. 
                      If these methods are not applied, then the default named routes are returned, if any.
                    </div> <br>

                    <div class="pre-area font-menu">
                      <div class="bc-silver pxv-10">Sample 1 - getRoutes()</div>
                        <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){
        
        self::loadRoutes(this);

        vdump(self::getRoutes()); // ['profile' => 'home/profile'];

    }

    function addRoutes(array $array = []) : array {

        return [
        
          'profile' => 'home/profile' 

        ];
    }

  } 
                        </pre>
                    </div> <br><br>

                    <div class="pre-area font-menu">
                      <div class="bc-silver pxv-10">Sample 2 - getRoutes()</div>
                        <pre class="pre-code">

  use Window;

  class Home extends Window {

    function __construct(){

        vdump(self::getRoutes()); // ['profile' => 'home/profile'];

    }

    function addRoutes(array $array = []) : array {

        return Window::addRoutes([
        
          'profile' => 'home/profile' 

        ]);
    }

  } 

                        </pre>
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