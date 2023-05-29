
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Compile</div> <br>  
         
          <div class="">
            Template compilers are of four types which are the <code>compile()</code>, 
            <code>view()</code>, <code>rex()</code> and <code>raw()</code> functions. These functions are used 
            to render rex template files through the compiler class.
          </div> <br>

          <div class="">
            <div id="compile" class="compile">
                
                <h4>Compile</h4>
                <div class="">
                  The <code>compile()</code> function is the root function for rendering template files. 
                  Prior to version 2.0, it was not a stand alone function but after recent improvements, it is 
                  now capable of rendering template files alone using the Compiler engine. There are three ways by which 
                  this function can be used in window files to render template files. The sample of the usuage are shown 
                  below
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
                  We can compile this <code class="bd-f">home</code> template file through the compiler function as shown below:
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">// The boy is 15 years today</span>
      self::load('home', fn() => compile(['age' => '15']));

    }


  }
                  </pre>
                </div> <br>                
                <div class="foot-note">
                  Automatically, the <code>self::load()</code> which is a window method tells the compiler to render the template file immediately 
                  as a page without using any <code class="bd-f">print</code> or <code class="bd-f">echo</code> word before it. In previous versions, 
                  this is the known way to render template files. While this approach will also work in recent versions, starting from version 2.0, 
                  we can now use the compiler as a stand alone function without depending on the
                  the <code>self::load()</code> method as below:
                </div> <br>

                <h5>version 2.0+</h5>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      <span class="comment">// The boy is 15 years today</span>
      echo compile('home', ['age' => '15']);

    }


  }
                  </pre>
                </div> <br>                 
                <div class="foot-note">
                  In the above, the compiler returns a compiler object, when we print the 
                  compiler object, the template file becomes automatically rendered. We can also 
                  take advantage of this new feature to obtain the rendered component easily as  
                  shown below.
                </div> <br> 
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes/Home;

  use window;

  class Home extends Window { 


    function __construct() {

      $markup = compile('home', ['age' => '15'])->rex();

      vdump($markup); <span class="comment">// view rendered markup</span>

    }


  }
                  </pre>
                </div> <br> 
                <div class="foot-note">
                  Since the <code>compile()</code> function returns a Compiler object, there are couple of 
                  extended functions we can perform on the <code>compile()</code> function. Visit 
                  version 2.0 compiler class <a href="@domurl('version/2.0/compiler-class')" class="hyperlink c-orange-d ch-orange-dd">release notes</a> to learn more 
                  about compiler object.
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