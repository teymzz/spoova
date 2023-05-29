
@template('template.t-tut')

  @title('Function: limitWord()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : limitWord</div> <br>  
        

          <div class="">
            <div id="limitWord" class="limitWord">

                <div class="">
                  This function is used to limit the number of characters acceptable 
                  in any given text string. It uses a 5 character correctional count to determine how 
                  texts are trimmed.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  limitWord($text, $max)
  <span class="c-sky-blue-dd"> 
  $text : supplied text string
  $max  : adjusted maximum number of characters to return. 
  </span> 
                  </pre>
                </div>
                
                <div class="foot-note">
                  Assuming a maximum character length of <code>4</code> is supplied on a string, the maximum acceptable number of 
                  character will be <code>9</code> (i.e 4+5) due to an adjusted 5 character increase added by default. Hence, the 
                  <code>limitWord()</code> function will assume that a maximum number of "9" characters is expected to be returned. 
                  This means that any text after a character length 9 will be truncated. However, the <code>limitWord</code> also 
                  projects that each word should never be broken apart. In the event that the last word was broken due to longer length, 
                  then <code>limitChar()</code> will also truncate the last word so as to avoid breaking it apart  
                </div>
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample : limitWord</div>
                  <pre class="pre-code">
  $text = 'This is a string of not more than 10 words';

  $text = limitWord($text, 8); <span class="comment">// max 13 (i.e 8+5)</span> 

  var_dump( $text ); 
                  </pre>
                </div> 
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">String of 13 characters</div>
                  <pre class="pre-code">
  This is a str...
                  </pre>
                </div>

                <div class="foot-note">
                  However, <code>limitWord()</code> does not support breaking words apart. Due to this reason, the last word <code>"str"</code> that was 
                  split from <code>"string"</code> will also be truncated. Hence the final result will be :
                </div>
                

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Final output</div>
                  <pre class="pre-code">
  This is a ...
                  </pre>
                </div>

          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;