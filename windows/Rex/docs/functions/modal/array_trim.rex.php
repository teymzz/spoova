
@template('template.t-tut')

  @title('Function: array_trim()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : array_trim</div> <br>  
        

          <div class="">
            <div id="array_trim" class="array_trim">

                <div class="">
                  This trims the extra spaces in string values of an array.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  array_trim($array)
  <span class="c-sky-blue-dd">
  $array: array to be trimmed
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  $array = [1 => 'aa   aaa', 2 => ' asa   as'];
  array_trim($array);

  vdump($array); <span class="comment">//[1 => 'aa aaa', 2 => 'asa as']</span>
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