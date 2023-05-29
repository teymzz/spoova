
@template('template.t-tut')

  @title('Function: javaconsole()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : javaconsole</div> <br>  
        

          <div class="">
            <div id="javaconsole">

                <div class="">
                  This function is mostly equivalent to the javascript <code class="bd-f">console.log()</code> function. 
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  javaconsole($string)
  <span class="c-sky-blue-dd"> 
  $string  : supplied string
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1 - code</div>
                  <pre class="pre-code">
  javaconsole("sometext");
                  </pre>
                </div>
                <div class="foot-note">
                  The result of the string above is shown below
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1 - result</div>
                  <pre class="pre-code">
  &lt;script&gt; console.log('sometext') &lt;/script&gt;
                  </pre>
                </div>

                <div class="foot-note">
                  Note that the text above is directly printed to the web page. We can also 
                  supply multiple values to the function as shown in sample 2 below.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2 - code</div>
                  <pre class="pre-code">
  javaconsole('text 1','text 2');
                  </pre>
                </div>
                <div class="foot-note">
                  The result of the code above is shown below where each value is displayed on a different 
                  line.
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2 - result</div>
                  <pre class="pre-code">
  &lt;script&gt; 
  
  console.log('text 1'); 
  console.log('text 2');

  &lt;/script&gt;
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