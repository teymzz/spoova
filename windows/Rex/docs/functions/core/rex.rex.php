
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Rex</div> <br>  
        

          <div class="">
            <div id="compile" class="compile">

                <div class="">
                  The <code>rex()</code> function is the shortest form of fetching 
                  the direct string of a Compiler object rendered component. In this case, 
                  components are rendered with the Compiler object and the relative rendered 
                  string is returned.  
                </div> <br>


            <!-- code line started -->
                <div class="foot-note">
                  Assuming we have a template file within the template directory "windows/Rex" named "home.rex.php" as below:
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  The boy is @({{ $age }})@ years today
                  </pre>
                </div> <br>
                <div class="foot-note">
                  We can use the <code>rex()</code> function as shown below:
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">//fetch template string</span>
      $templateString = rex('home', fn() => compile(['age' => 13]));

      var_dump( $templateString );


    }


  }
                  </pre>
                </div> <br>                
                <div class="foot-note">
                  In the sample above, the rendered component will be returned as a string. We don't 
                  have to use the <code>compile()</code> function unless an argument is needed to be parsed. 
                  We can also directly display the rendered components as shown below:
                </div> <br>
           
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">//render template string</span>
      echo rex('home', fn() => compile(['age' => 13]) );

    }


  }
                  </pre>
                </div> <br>
               
                <div class="foot-note">
                  The essence of this method is to enable the subjection of rendered component to 
                  extended functionality. For some reason, if we need this functionality from a compiler 
                  object, the compiler class has a <code>rex()</code> method that directly returns the string 
                  of a compiled component. So, rather than use the approach above, we can address this similary using 
                  a better approach below :
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">//fetch template string</span>
      $string = compile('home', ['age' => 13])->rex();

      var_dump($string);

    }


  }
                  </pre>
                </div> <br>
                
            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;