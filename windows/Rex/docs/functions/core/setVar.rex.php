
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : setVar</div> <br>  
         
          <div class="">
            <div id="setvar" class="setvar">
                
                <div class="">
                The <code>setVar</code> is a complex function that is used to perform several functions which include <br>
                <br>
                <ul class="pxl-14">
                  <li>initialization of variable through reference</li>
                  <li>returning custom values for empty or undefined variables</li>
                  <li>modifying value of empty or undefined variables with custom values</li>
                </ul>
                </div> <br>


            <!-- code line started -->

                <div class="foot-note">
                  Initializing variables by reference
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php

  setVar($name); 
  
  echo $name; <span class="comment">//null</span>
                  </pre>
                </div> <br><br>

                <div class="foot-note">
                  Returning custom defined values for empty variables
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  $return = setVar($name, 'foo');

  echo $return; <span class="comment">//foo</span>
                  </pre>
                </div> 
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  $name = 'bar';

  $return = setVar($name, 'foo');

  echo $return; <span class="comment">//bar</span>
                  </pre>
                </div> 
                
                <div class="font-em-d9 mvs-10">
                  In the first sample above, the value of <code>'foo'</code> is set as a return custom value for <code class="bd-f">$name</code> if it is empty or it is not 
                  previously defined. However, sample 2 shows that if <code class="bd-f">$name</code> was previously defined, its relative value will be returned rather than the alternate value.
                </div>

                <br>             

                <div class="foot-note">
                  Modifying empty or undefined variable's value with custom value
                </div>                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  $alt = 'bar';

  setVar($value, $alt, true);

  echo $value; <span class="comment">//bar</span>
                  </pre>
                </div> 
                
                <div class="font-em-d9 mvs-10">
                  In the sample above, <code class="bd-f">$alt</code> was predefined but <code class="bd-f">$value</code> was not predefined. By setting the 
                  third parameter as true, <code class="bd-f">$alt</code> value will overide <code class="bd-f">$value</code> because <code class="bd-f">$value</code> 
                  is empty or not previously defined. However, in the sample below, <code class="bd-f">$value</code> was previously defined which means that 
                  <code class="bd-f">$alt</code> will not be able to modify the value of <code class="bd-f">$value</code>.
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  &lt;?php 

  $value = 'foo';

  $alt   = 'bar';

  $return = setVar($value, $alt, true);

  echo $value; <span class="comment">//foo</span>

  echo $return; <span class="comment">//foo</span>
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