
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : routeExists</div> <br>  
         
          <div class="">
            <div id="routeExists" class="routeExists">
                
                <div class="">
                  This function <code>routeExists()</code> is used to check if a class exists 
                  within <code>windows/Routes</code> directory. If the class exists, a true value will be returned.
                </div> <br>

            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample routeExists: Home
                  </div>
                  <pre class="pre-code">
  &lt;?php 

  ... 

  use Window;

  Home extends Window { 


    function __construct() {

      if( routeExists('Index') ) {

        <span class="comment">// namespace <span class="c-dry-blue-dd">spoova\mi\windows\Routes\Index</span> exists ...</span>

      }

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