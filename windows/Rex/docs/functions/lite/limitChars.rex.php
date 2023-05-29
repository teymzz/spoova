
@template('template.t-tut')

  @title('Function: limitChars()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : limitChars</div> <br>  
        

          <div class="">
            <div id="limitChars" class="limitChars">

                <div class="">
                  This function is used to limit the number of characters acceptable 
                  in a text string and appends an ellipses to strings that have beyond 
                  the acceptable length of texts. A little correctional or adjustment level is also 
                  made before ellipses are appended to strings that have beyond the acceptable length of characters
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  limitChars($text, $max)
  <span class="c-sky-blue-dd"> 
  $text : supplied text string
  $max  : adjusted maximum number of characters to return. 
  </span> 
                  </pre>
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  $text = 'This is a string of not more than 10 texts';

  $text = limitChars($text, 22); 

  var_dump( $text ); 
                  </pre>
                </div> 

                <div class="foot-note">
                  The result is shown below:
                </div>

                <div class="pre-area shadow mvt-16">
                  <pre class="pre-code">
  This is a string of not...
                  </pre>
                </div>

                <div class="">
                  In the above, although 22 characters should stop at <code>of no...</code>, however, due to 
                  some little internal adjustments, the <code class="bd-f">limitChars()</code> function will smartly 
                  adjust the last character to find a form of meaning. This is the reason why the last character <code>t</code> 
                  was appended to form <code>of not...</code>. This behaviour is not predictable but it is majorly determined based 
                  on the number of characters left to form a word.
                </div>

          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;