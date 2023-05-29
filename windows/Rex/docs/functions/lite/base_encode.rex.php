
@template('template.t-tut')

  @title('Function: base_encode()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : base_encode</div> <br>  
        

          <div class="">
            <div id="base_encode" class="base_encode">

                <div class="">
                  A coined function for php <code>base64_encode()</code>. It removes the equals sign from the 
                  generated hashed value. This does not affect the performance of <code>base64_decode()</code> function 
                  when decoding the hashed value.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  base_encode($value)
  <span class="c-sky-blue-dd">
  $value: value to be encoded
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: base64_encode</div>
                  <pre class="pre-code">
  base64_encode('ab'); <span class="comment">//YWI=</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: base_encode</div>
                  <pre class="pre-code">
  base_encode('ab'); <span class="comment">//YWI</span>
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