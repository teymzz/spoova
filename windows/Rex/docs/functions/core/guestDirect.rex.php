
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : guestDirect</div> <br>  
         
          <div class="">
            <div id="guestdirect" class="guestdirect">
                
                <div class="">
                  The <code>guestDirect()</code> is the opposite of <code>authDirect()</code>. 
                  It is only used to perform a redirection when a user account is not active.
                </div> <br>


            <!-- code line started -->
                <div class="foot-note">Assuming we have to write a test code as below</div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  if( isGuest() ) {

    redirect('index');

  }
                  </pre>
                </div>

                <div class="foot-note">
                  We can easily run this in one line with <code>guestDirect()</code> as shown below
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  guestDirect('index');
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