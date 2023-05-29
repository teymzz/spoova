
@template('template.t-tut')

  @title('Function: alert()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : alert</div> <br>  
        

          <div class="">
            <div id="alert">

                <div class="">
                  This function is mostly equivalent to the javascript alert function. 
                  Array or string urls are converted to json format to allow for proper 
                  viewing while other strings maintain their form.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  alert($string)
  <span class="c-sky-blue-dd"> 
  $string  : supplied string
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  alert("sometext");
                  </pre>
                </div>
                <div class="foot-note">
                  The result of the string above is shown below
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample result</div>
                  <pre class="pre-code">
  &lt;script&gt; alert('sometext') &lt;/script&gt;
                  </pre>
                </div>

                <div class="foot-note">
                  Note that the text above is directly printed to the web page
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