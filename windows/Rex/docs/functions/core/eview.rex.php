
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : eview</div> <br>  
         
          <div class="">
            <div id="eview" class="eview">
                
                <div class="">
                  The <code>eview()</code> function means "error view". This function sets the error 
                  page displayed when a url returns a 404 error. The default error page by default is loaded 
                  from <code>windows/Rex/errors/404.rex.php</code> template file. However, this can be overriden 
                  from within routes as shown below:
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  ... 

  use Window;

  class Home extends Window {

    function __construct() {

      eview('errors.custom'); <span class="comment">//set error page</span>

      self::call($this, 
      
        [
          'home' => 'root'  
        ]

      );

    }

    function root() { }

  }


                  </pre>
                </div> <br>

                <div class="foot-note">
                  The example above reflects how to set a custom error page for shutter methods. 
                  If the shutter used cannot resolve the url and the shutter was not pended, rather 
                  than use the default error page, the custom error page will be assumed. In the sample 
                  above, the error template file will be assumed to be in the path 
                  <code class="bd-f">windows/Rex/errors/custom.rex.php</code>
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