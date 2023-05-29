
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Route</div> <br>  
         
          <div class="">
            <div id="route" class="route">
                
                <div class="">
                  This function is used in routes to get the value of a named route. The equivalent 
                  template directive is <code>@(@route())@</code> directive.
                </div> <br>

                <div class="foot-note">
                  Assuming we have a sample route: 
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

  Home extends Window { 


    function __construct() {

      self::loadRoutes($this);

      echo route('homeUser'); <span class="comment">// home/user</span>

    }

    static function addRoute(array $array = []) : array {

      return [
        
        'homeUser' => 'home/user'

      ];

    }


  }
                  </pre>
                </div>

                <div class="foot-note">
                  The <code>route()</code> function makes it easy to get the value of the named route using the 
                  specified route name just as shown above.
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