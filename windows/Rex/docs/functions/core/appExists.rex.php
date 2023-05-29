
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : appExists</div> <br>  
         
          <div class="">
            <div id="appExists" class="appExists">
                
                <div class="">
                  This function <code>appExists()</code> is used to check if a class exists 
                  within the framework. If the class exists, a true value will be returned.
                </div> <br>

            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample appExists: Home
                  </div>
                  <pre class="pre-code">
  &lt;?php 

  ... 

  use Window;

  Home extends Window { 


    function __construct() {

      if( appExists('core\classes\Ajax') ) {

        <span class="comment">// do something ...</span>

      }

    }


  }
                  </pre>
                </div>

                <div class="foot-note">
                  The <code>appExists()</code> function uses directories format to find classes. 
                  Rather than supply the full namespace of the class, only the directory path from the 
                  root folder is supplied. If the class exists, a true value will be returned, else, a false 
                  value will be returned.
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