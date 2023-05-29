
@template('template.t-tut')

  @title('Function: not_empty()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : not_empty</div> <br>  
        

          <div class="">
            <div id="not_empty" class="not_empty">

                <div class="">
                  This function is the direct opposite of the <code>not_empty()</code> method. It 
                  tests if a value is not empty. This can be an array or trimmed string. 
                  By trimming strings before testing, it acts as a proof against empty spaces. The function 
                  is also capable of regarding non-empty values as empty values. Examples are shown below:
                </div> <br>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  not_empty($testval, $includes)

  <span class="c-sky-blue-dd">
  $testval: value to be tested
  $includes: values to be regarded as empty values
  </span> 
                  </pre>

                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  vdump(not_empty('10')); <span class="comment">//true</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The value above is not empty value, hence, <code class="bd-f">true</code> is returned
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump(not_empty('')); <span class="comment">//false</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The string value above is empty, hence, <code class="bd-f">false</code> is returned
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  vdump(not_empty(' ')); <span class="comment">//false</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The string value above contains only empty spaces, hence, <code class="bd-f">false</code> is returned
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  vdump(not_empty([])); <span class="comment">//false</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The array value above is empty, hence, <code class="bd-f">false</code> is returned
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  vdump(not_empty('10', [5, 10, 15])); <span class="comment">//false</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The value above exist in the empty values array list, hence, <code class="bd-f">false</code> is returned
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 6</div>
                  <pre class="pre-code">
  vdump(not_empty('10', [2, 4, 6])); <span class="comment">//true</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The value above does not exist in the empty values array list, hence, <code class="bd-f">true</code> is returned
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