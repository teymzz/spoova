
@template('template.t-tut')

  @title('Function: inflect()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : inflect</div> <br>  
        

          <div class="">
            <div id="inflect" class="inflect">

                <div class="">
                  Inflect is a simple function that either adds or removes the last "s" character of a string based on the 
                  integer value supplied to it as a second argument. 
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  inflect($value, $count, $strict)
  <span class="c-sky-blue-dd">
  where:

  $text   : string or array list of text strings
  $count  : integer used to determine the quantity of $text 
  $strict : strict automation of addition or removal of last "s" character.
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  inflect("Boy", 1); <span class="comment no-select"> //Boy <span class="c-sky-blue-dd">- (will add "s" if $count is greater than 1)</span></span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  inflect("Boy", 2); <span class="comment no-select"> //Boys <span class="c-sky-blue-dd">- (adds "s" because $count is greater than 1)</span></span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  inflect("Boy", 2, true); <span class="comment no-select"> //Boys <span class="c-sky-blue-dd">- (adds "s" if $count is greater than 1 and last character is not "s") </span></span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 4</div>
                  <pre class="pre-code">
  inflect("Boys", 2, true); <span class="comment no-select"> //Boys <span class="c-sky-blue-dd">- (adds "s" if $count is greater than 1 and last character is not "s") </span></span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 5</div>
                  <pre class="pre-code">
  inflect("Boys", 1, true); <span class="comment no-select"> //Boy <span class="c-sky-blue-dd">- (removes last "s" if $count is less than 1) </span></span>
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