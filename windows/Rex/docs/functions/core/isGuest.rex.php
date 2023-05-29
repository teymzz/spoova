
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : isGuest</div> <br>  
         
          <div class="">
            <div id="isguest" class="isguest">
                
                <div class="">
                  The <code>isGuest()</code> function is dependent on session configuration. 
                  It returns true when a user is not logged in.
                </div> <br>


            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  if( isGuest() ) {

    <span class="comment">//session not logged in</span>

  }
                  </pre>
                </div>

                <div class="foot-note">
                  The entire response of this function is dependent on user session configuration. The 
                  <code class="bd-f">init</code> file and the database file <code class="bd-f">dbconfig.php</code> 
                  must be properly configured along with the <code>Session</code> configuration system for this 
                  function to work effectively.
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