
@template('template.t-tut')

  @title('Function: toSingular()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : toSingular</div> <br>  
        

          <div class="">
            <div id="toSingular" class="toSingular">

                <div class="">
                  This function converts a string to singular by removing the last "s" or "S" character. The argument can also take a list of 
                  array strings. 
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  toSingular($value)
  <span class="c-sky-blue-dd">
  $value: string or array of strings
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  echo( toSingular('boys') ); <span class="comment">//boy</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The last "s" character of the text above was removed
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  echo( toSingular('BOYS') ); <span class="comment">//BOY</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The last "S" character of the text above was removed
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  echo( toSingular('glass') ); <span class="comment">//glas</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The function does not use a dictionary to determine the type of word supplied. Hence, 
                  the last "s" character in the word above was removed.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  echo( toSingular('boy') ); <span class="comment">//boy</span>
                  </pre>
                </div>
                <div class="foot-note">
                  The text above remains the same because there is no lasting "S" or "s" 
                  character that was found to be stripped off.
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  var_dump( toSingular(['boys', 'books']) ); <span class="comment">//['boy', 'book']</span>
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