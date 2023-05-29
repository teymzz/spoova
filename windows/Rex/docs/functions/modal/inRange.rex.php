
@template('template.t-tut')

  @title('Function: inRange()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : inRange</div> <br>  
        

          <div class="">
            <div id="inrange" class="inrange">

                <div class="">
                This function checks if a value is within the range of two values
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  inRange($value, $min, $max)

  <span class="c-sky-blue-dd">
  $value: test value
  $min  : minimum value
  $max  : maximum value
  </span> 

                  </pre>

                </div>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  vdump(inRange(27, 20, 50)); <span class="comment">//true</span>
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