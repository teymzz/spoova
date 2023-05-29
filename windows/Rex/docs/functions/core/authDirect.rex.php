
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : authDirect</div> <br>  
         
          <div class="">
            <div id="authdirect" class="authdirect">
                
                <div class="">
                  The <code>authDirect()</code> function is used to redirect to another page 
                  if the current user session is active.
                </div> <br>


            <!-- code line started -->
                <div class="foot-note">Assuming we have to write a test code as below</div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  if( isUser() ) {

    redirect('some-url');

  }
                  </pre>
                </div>

                <div class="foot-note">
                  We can easily run this in one line with <code>authDirect()</code> as shown below
                </div>

                <div class="pre-area shadow">
                  <pre class="pre-code">
  authDirect('some-url');
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