
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : View</div> <br>  
        

          <div class="">
            <div id="compile" class="compile">

                <div class="">
                  The <code>view()</code> function renders template file in a slightly different way and does not return 
                  the compiler object because files are sliced directly using a template slicer tool which returns a 
                  string of rendered components. Template files in this case are rendered directly 
                  with parsed arguments and the resultant template string is returned. In most cases, the returned string have 
                  to be subjected to further processing which is why the template string returned may most likely be dependent 
                  on the window <code>self::load()</code> method.
                </div> <br>


            <!-- code line started -->
                <div class="foot-note">
                  Assuming we have a template file within the template directory "windows/Rex" named "home.rex.php" as below:
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  The boy is @(&lt;?= $age ?&gt;)@ years today
                  </pre>
                </div> <br>
                <div class="foot-note">
                  We can pass the <code>"$age"</code> value to the template file and have it loaded through the <code>view()</code> 
                  function as shown below:
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">//fetch template string</span>
      $templateString = view('home', ['age' => 13]);

      <span class="comment">// The boy is 13 years today</span>
      self::load( 'home', fn() => $templateString );

    }


  }
                  </pre>
                </div> <br>                
                <div class="foot-note">
                  When parameters are passed into the <code>view()</code> function, they are usually saved 
                  temporarily for immediate use. In a short and close cycle, this can become an advantage 
                  for placeholders. Hence, a template file of the format below may still work. 
                </div> <br>
               <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  The boy is @({{ $age }})@ years today
                  </pre>
                </div>             
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">//fetch template string</span>
      $templateString = view('home', ['age' => 13]);

      <span class="comment">// The boy is 13 years today</span>
      self::load( 'home', fn() => $templateString );

    }


  }
                  </pre>
                </div> <br>
               
                <div class="foot-note">
                  When rendering components, it is preferrable to use functions that truly renders template 
                  component through the compiler object. These methods are the <code>compile()</code> and <code>rex()</code> functions.
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