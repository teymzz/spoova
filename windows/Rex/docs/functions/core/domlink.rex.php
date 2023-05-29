
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : domlink</div> <br>  
         
          <div class="">
            <div id="ishttp" class="ishttp">
                
                <div class="">
                  The <code>domlink()</code> function behaves similarly as the <code>domUrl</code> 
                  however, while <code>domUrl</code> does not support dot convention, in domlink, 
                  dots are converted to slashes. Hence, this method are mostly used for links that 
                  have no dots within them
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo domlink('res.some-link.item');
                  </pre>
                </div> <br>

                <div class="foot-note">
                  The value returned above will resemble a format like:
                </div>
                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 http://domain/res/some-image/item
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