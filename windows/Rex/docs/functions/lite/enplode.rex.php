
@template('template.t-tut')

  @title('Function: enplode()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : enplode</div> <br>  
        

          <div class="">
            <div id="enplode" class="enplode">

                <div class="">
                  This function wraps a specified string or character around an imploded array.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  enplode($chars, $array)
  <span class="c-sky-blue-dd">
  $chars: contains characters used for imploding and wrapping imploded array
  $array: array to be imploded and wrapped
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  enplode('_', ['Hi', 'there']); <span class="comment">//Hi_there</span>
                  </pre>
                </div>
                <div class="foot-note">
                  Just like the php <code class="bd-f">implode()</code> function, the supplied character 
                  helps to bind the array strings together.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  enplode(['_', '#'], ['Hi', 'there']); <span class="comment">//Hi_there</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The sample above shows that we can also specify the imploding character as 
                  the first value of an array. This will respond as if it was a normal string that was supplied. 
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  enplode(['_', '#'], ['Hi', 'there']); <span class="comment">//#Hi_there#</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The sample above shows that by supplying a second character value of an array, the 
                  <code class="bd-f">enplode()</code> function assumes to use the second character to wrap the imploded 
                  array string returned.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  enplode(['_', '(',')'], ['Hi', 'there']); <span class="comment">//(Hi_there)</span>
                  </pre>
                </div>
                <div class="foot-note">
                  In certain situations, the opening wrapper may be different from the closing wrapper. In order to modify 
                  the closing wrapper, we can set a third parameter as shown above.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  enplode(['','"'], [], true); <span class="comment">// "" </span>
                  </pre>
                </div>
                <div class="foot-note">
                  In certain situations, we wish to return binded characters for empty arrays, we need to supply a third parameter 
                  of true which makes sure that the characters are returned even if the array is empty. Notice that in the sample 
                  above, the imploding character is an empty string while the wrapper chacracter is a double quote.
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