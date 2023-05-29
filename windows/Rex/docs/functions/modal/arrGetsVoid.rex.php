
@template('template.t-tut')

  @title('Function: arrGetsVoid()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : arrGetsVoid</div> <br>  
        

          <div class="">
            <div id="arrGetsVoid" class="arrGetsVoid">

                <div class="">
                  This checks if an array contains at least one empty value which may be string, array, integer or boolean. If such exists,
                  then a <code class="bd-f">true</code> value is returned.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  arrGetsVoid($array)
  <span class="c-sky-blue-dd">
  $array: array to be checked
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid([])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid([[]])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> 'foo'])); <span class="comment">//false</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> ''])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> []])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 6</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> false])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 7</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> 0])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 8</div>
                  <pre class="pre-code">
  vdump(arrGetsVoid(['user'=> 'foo', 'name'=>''])); <span class="comment">//true</span>
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