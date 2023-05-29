
@template('template.t-tut')

  @title('Function: limitText()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : limitText</div> <br>  
        

          <div class="">
            <div id="limitText" class="limitText">

                <div class="">
                  This function is used to limit the size of a words in a 
                  string based on the number of words desired. Longer texts are 
                  appended with ellipses.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  limitText($text, $max)
  <span class="c-sky-blue-dd"> 
  $text : supplied text string
  $max  : maximum number of words to return. 
  </span> 
                  </pre>
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  $text = 'This is a string of not more than 10 texts';

  $text = limitText($text, 7); 

  var_dump( $text ); 
                  </pre>
                </div> 

                <div class="foot-note">
                  The result is shown below:
                </div>

                <div class="pre-area shadow mvt-16">
                  <pre class="pre-code">
  This is a string of not more ...
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