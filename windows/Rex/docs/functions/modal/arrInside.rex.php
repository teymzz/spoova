
@template('template.t-tut')

  @title('Function: arrInside()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : arrInside</div> <br>  
        

          <div class="">
            <div id="arrInside" class="arrInside">

                <div class="">
                  This checks if an array exists within another array. This will return 
                  a <code class="bd-f">true</code> if an array contains another array.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  arrInside($array)
  <span class="c-sky-blue-dd">
  $array: array to be checked
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  
  vdump(arrInside([1, 2, 3])); <span class="comment">//false</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump(arrInside([1 => 'name'])); <span class="comment">//false</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  vdump(arrInside([[]])); <span class="comment">//true</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  vdump(arrInside([1, 2, 'name' => ['foo', 'bar'])); <span class="comment">//true</span>
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