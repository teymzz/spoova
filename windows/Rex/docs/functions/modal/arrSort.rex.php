
@template('template.t-tut')

  @title('Function: arrSort()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : arrSort</div> <br>  
        

          <div class="">
            <div id="arrSort" class="arrSort">

                <div class="">
                  This remove array keys with empty values and then returns a sorted array. Here, only 
                  empty strings and boolean value <code class="bd-f">false</code> are considered as empty 
                  values.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  arrSort($array, $sort)
  <span class="c-sky-blue-dd">
  $array: array to be sorted
  $sort : true sorts the array
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  vdump(arrSort([0 => 'foo', 1 => '', 2 => 'bar'])); <span class="comment">//[0=>'foo', '2'=>'bar']</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump(arrSort([0 => 'foo', 1 => '', 2 => 'bar'], true)); <span class="comment">//[0=>'foo', '1'=>'bar']</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  vdump(arrSort([0 => 'foo', 1 => false])); <span class="comment">//[0 => 'foo']</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  vdump(arrSort([0 => 0, 1 => 'bar'])); <span class="comment">//[0=>0, '1'=>'bar']</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  vdump(arrSort([0 => [], 1 => 'bar'])); <span class="comment">//[0=>[], '1'=>'bar']</span>
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