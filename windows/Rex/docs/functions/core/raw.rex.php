
@template('template.t-tut')

  @title('Function: raw()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Raw</div> <br>  
        

          <div class="">
            <div id="compile" class="compile">

                <div class="">
                  The <code>raw()</code> function is a coined function that uses the 
                  internal <code>file_get_contents()</code> php function to return the 
                  direct content of a rex template file. The only major difference is that 
                  only rex template files from within the  <code class="bd-f">WIN_REX</code>, that is, 
                  window rex directory are being resolved. 
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
                  We can use the <code>raw()</code> function as shown below:
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes;

  use window;

  class Home extends Window { 

    function __construct() {

      <span class="comment">//fetch template content</span>
      $rex = raw('home');

      <span class="comment">//The boy is @({{ $age }})@ years today</span>
      echo ( $rex );

    }

  }
                  </pre>
                </div> <br>                
                <div class="foot-note">
                  In the sample above, the direct content of the template file 
                  is returned. Note that we can also use dots to specify subdirectories. 
                  Internally, all dots will be converted to slashes.
                </div> <br>
           
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  namespace spoova/mi/windows/Routes;

  use window;

  class Home extends Window { 

    function __construct() {

      <span class="comment">// windows/Rex/home/user.rex.php</span>
      $raw = raw('home.user'); 
      
      <span class="comment">//dump template content</span>
      vdump( $raw ); 

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