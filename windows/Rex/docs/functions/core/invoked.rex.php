
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : invoked</div> <br>  
         
          <div class="">
            <div id="ishttp" class="ishttp">
                
                <div class="">
                  The <code>invoked()</code> function is a window function that matches the current page url 
                  with the supplied url and returns a true value if both url matches. By default, this function 
                  is case sensitive and the only way to declare it as case-insensitive is to prefix the url supplied 
                  with an exclamation mark <code>!</code>. This is explained with example below
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 if( invoked('some/URL') ) {

    <span class="comment">//do something</span>

 }
                  </pre>
                </div> <br>

                <div class="foot-note mvs-10">
                  The will only return true if the window url is similar to <code>http://domain/some/URL</code>. The case-sensive 
                  check will automatically be applied. However, to ignore case-sensitivity, we need to prefix the url with exclamation 
                  mark as shown below: 
                </div>
                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 if( invoked('!some/URL') ) {

    <span class="comment">//do something</span>

 }
                  </pre>
                </div> <br>

                <div class="foot-note mvs-10">
                  Since the exclamation mark <code>!</code> is applied, the invoke will not check for case sensitivity on the url suppled. This means that 
                  a url <code>http://domain/some/URL</code> and <code>http://domain/some/url</code> will return true on <code>invoke()</code> function. 
                  The invoke is usually used in window shutter middlewares. You can see a sample of this 
                  below:
                </div>

                <div class="pre-area">
                  <pre class="pre-code">
  &lt;?php

  namespace spoova/mi/windows/Routes;

  use Window;

  class Home extends Window {

      function __construct() {

        SELF::CALL($this, [
          
          'home/user/profiles' => 'profiles',
          'home/user/settings' => 'settings', 

          SELF::ONCALL => function() {

                  if( invoked('home/user/profiles') ) {
                    <span class="comment">//do this for specified url</span>
                  } 

                  if( invoked('home/user/settings') ) {
                    <span class="comment">//do this for specified url</span>
                  }

              }

        ]);

      }

  }

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