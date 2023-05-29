
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : isHTTP</div> <br>  
         
          <div class="">
            <div id="ishttps" class="ishttps">
                
                <div class="">
                  The <code>isHTTPS()</code> function is used to check if a url begins with 
                  <code>https://</code>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo isHTTPS('https://somesite.com'); <span class="comment">//true</span>
                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo isHTTPS('http://somesite.com'); <span class="comment">//false</span>
                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo isHTTPS('some/url'); <span class="comment">//false</span>
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