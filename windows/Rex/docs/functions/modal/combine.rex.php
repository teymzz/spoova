
@template('template.t-tut')

  @title('Function: combine()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : combine</div> <br>  
        

          <div class="">
            <div id="combine" class="combine">

                <div class="">
                  This function combines two arrays or a string into an array. The first argument 
                  is not neccesarily an array but the second argument must be an array.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  combine($value, $array)

  <span class="c-sky-blue-dd">
  $value: value to be combined
  $array: array to which value is combined
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $array = [1];
  combine(2, $array);

  vdump($array); <span class="comment">//[1, 2]</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $array = [1];                    
  combine([2, 3], $array);

  vdump($array); <span class="comment">//[1, 2, 3]</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  $array = [1, 2];
  combine([2, 3], $array);

  vdump($array); <span class="comment">//[1, 2, 2, 3]</span>
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