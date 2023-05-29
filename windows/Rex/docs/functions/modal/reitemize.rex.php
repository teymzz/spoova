
@template('template.t-tut')

  @title('Function: reItemize()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : reItemize</div> <br>  
        

          <div class="">
            <div id="reItemize" class="reItemize">

                <div class="">
                  This function is used to regroup a group of associative arrays of equal values.
                  It is mainly used to regroup files for easy uploads.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  reItemize($array)
  <span class="c-sky-blue-dd">
  $array: 2 dimentional array to be reitemized
  </span> 
                  </pre>
                </div>

                <div class="foot-note">
                  Assuming we have an array as below:
                </div>
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample array</div>
                  <pre class="pre-code">
  $array['name'][0] = 'foo';
  $array['name'][1] = 'bar';
  
  $array['date'][0] = 20;  
  $array['date'][1] = 25;

  $array['tmp_name'][0] = 'some/dir1';
  $array['tmp_name'][1] = 'some/dir2';
                  </pre>
                </div>

                <div class="pre-area shadow mvt-1">
                  <pre class="pre-code">
  $array = reItemize($array);
                  </pre>
                </div>

                <div class="foot-note">
                  By applying <code class="bd-f">reItemize()</code> function as above, we have 
                  a result as below:
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Final array format</div>
                  <pre class="pre-code">
  $array[0]['name'] = 'foo';
  $array[0]['date'] = 20;  
  $array[0]['tmp_name'] = 'some/dir1';
  
  $array[1]['name'] = 'bar';
  $array[1]['date'] = 25;
  $array[1]['tmp_name'] = 'some/dir2';
                  </pre>
                </div>
              
                
            </div>
            <div class="foot-note">
              This is only applied to array formats resembling the format defined above.
            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;