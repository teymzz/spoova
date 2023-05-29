
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : lastCall</div> <br>  
         
          <div class="">
            <div id="lastcall" class="lastcall">
                
                <div class="">
                  This function returns the last called url of a window shutter. When working 
                  with shutters, it is usually a difficult process to track window urls. The <code>lastCall()</code> 
                  function however, makes this process easy by connecting a parent route to its child routes even if they 
                  are not within the same class.
                </div> <br>

                <div class="foot-note">
                  Assuming we have a sample route controller: 
                </div>

            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample route: Home
                  </div>
                  <pre class="pre-code">
  &lt;?php 

  ... 

  use Window;
  use spoova/mi/windows/Routes/HomeUser;

  Home extends Window { 


    function __construct() {

      self::call($this, 
      
        [
         'home/user' => 'win:Routes/HomeUser',
         'home/dashboard' => 'dashboard',
        ]

      );

    }

    function dashboard() : array {

      echo lastCall(); <span class="comment">// home/dashboard</span>

    }


  }
                  </pre>
                </div>

                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample route: HomeUser
                  </div>
                  <pre class="pre-code">
  &lt;?php 

  ... 

  use Window;
  use spoova/mi/windows/Routes/HomeUser;

  Home extends Window { 


    function __construct() {

      echo lastCall(); <span class="comment">// home/user </span>

    }


  }
                  </pre>
                </div>

                <div class="foot-note">
                  In the first class, if the url "home/user" was visited, the <code>dashboard()</code> method is called. 
                  However, if the <code>home/user</code> was called, then this will trigger a new class <code>Home/User</code>. 
                  While we can easily guess the last url called for <code class="bd-f">"home/user"</code> 
                  because the method called is within the same class. This may not be easy for the external class <code class="bd-f">HomeUser</code> 
                  called. The <code>lastCall()</code> will however, make it easy to fetch the incoming url as long as a shutter method was used to trigger 
                  the class.
                </div> <br>

                <div class="">
                  <h3 class="c-dodger-blue">Binding Paths</h3>

                  <div class="">
                    Just like the <code class="bd-f">window()</code> function, we can also bind paths to the <code class="bd-f">lastCall()</code> function. 
                    However, this function will not convert dots to slashes.
                  </div>                  
                </div><br>


                <div class="pre-area shadow">
                  <pre class="pre-code">
 lastCall('new/path'); <span class="comment">//append "new/path" to previous path</span>
                  </pre>
                </div>

            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;