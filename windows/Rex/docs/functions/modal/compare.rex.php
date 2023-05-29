
@template('template.t-tut')

  @title('Function: compare()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : compare</div> <br>  
        

          <div class="">
            <div id="compare" class="compare">

                <div class="">
                  Compare checks if all arguments supplied are of equal values.
                  It is case sensitive and can be used to test any data type.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  compare(...$arguments)

  <span class="c-sky-blue-dd">
  $arguments: list of values to be compared
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  
  vdump(compare(2, [1])); <span class="comment">//false</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump(compare(12, 12, 12)); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  vdump(compare(12, '12')); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  vdump(compare(12, 3.5)); <span class="comment">//false</span>
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