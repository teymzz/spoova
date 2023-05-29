
@template('template.t-tut')

  @title('Function: array_get()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : array_get</div> <br>  
        

          <div class="">
            <div id="array_get" class="array_get">

                <div class="">
                This function converts an array to stdObject
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  array_get($array, $key)
  <span class="c-sky-blue-dd">
  $array: array from which key's value is fetched
  $key  : key with value to be fetched
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  $array = ['gender' => 'male'];

  $value = array_get($array, 'gender');

  vdump($value); <span class="comment">//male</span>
                  </pre>
                </div>

                <div class="foot-note">
                  The sample above is similar to the expression below:
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Similar expression</div>
                  <pre class="pre-code">
  $array = ['gender' => 'male'];

  vdump($array['gender'] ?? false); <span class="comment">//male</span>
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