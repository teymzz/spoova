
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d85"> <br>

          <div class="font-em-1d5 c-orange">Functions - Scripts</div> <br>  
          
          <div class="resource-intro">
            <div class="">
                The <code class="bd-f">script()</code> function is the easiest way to 
                wrap a code in the html <code>&lt;script&gt;</code> tag. The string value 
                supplied to this funtion is place directly within the tag while the result 
                of this is returned back to the web page.
                <br>
            </div> 
          </div> <br>
          
          <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  script($string, $display)
  <span class="c-sky-blue-dd"> 
  $string  : supplied string
  $display : a boolean value of true prints directly
  </span> 
                  </pre>
                </div>

          <!-- script -->
          <div id="script" class="script"> 

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  echo script('console.log(10)'); <span class="comment">//displays 10 in developer's console</span> 
              </pre>

            </div>
            <div class="foot-note mvs-6">
              The html equivalent of the above resembles the format below: 
            </div>
            <div class="pre-area shadow">

              <pre class="pre-code">
  &lt;script&gt; 
  
    console.log('10')
  
  &lt;script&gt; 
              </pre>

            </div>            
            <!-- code line ended -->

          </div> <br>

          <div class="foot-note">
            <span class="bi-circle-fill font-em-d8"></span> When a valid url format or path is supplied, the script tag automatically switches to external 
            script mode as shown below
          </div>    
          
          <!-- code line started -->
          <div class="pre-area shadow mvt-12">
              <pre class="pre-code">
  echo script('some/file/script.js');
              </pre>
          </div>
          <div class="foot-note mvs-6">
            The html equivalent of the above resembles the format below: 
          </div>

          <div class="pre-area shadow">

              <pre class="pre-code">
  &lt;script src="some/file/script.js" /&gt; 
              </pre>

          </div> <br><br>

          <div class="foot-note">
            <span class="bi-circle-fill font-em-d8"></span> When second argument of <code class="bd-f">true</code> 
            or an integer value of <code class="bd-f">1</code>
            is supplied, the resulting text is automatically printed to the page
          </div>    
          
            <!-- code line started -->
            <div class="pre-area shadow mvt-12">

              <pre class="pre-code">
  script('some/file/script.js', 1);
              </pre>

            </div>
            <div class="foot-note mvs-6">
              The html equivalent of the above resembles the format below: 
            </div>
            <div class="pre-area shadow">

              <pre class="pre-code">
  &lt;script src="some/file/script.js" /&gt; 
              </pre>

            </div>
        </div>  <br>
          
        @lay('build.co.links:tutor_pointer')  

      </div>
      
    </section>

  </div>
  
  @lay('build.co.coords:footer')


@template;