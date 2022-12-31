
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">


          <div class="font-em-1d5 c-orange">Functions - Lite</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">

                Lite helper functions are predefined spoova functions that eases building 
                web applications. These functions are mostly applied to strings or arrays
                while other remaining parts are just custom functions of already existing php 
                internal functions 
                
            </div> 
          </div>
          
          <!-- base_encode -->
          <div id="base_encode" class="base_encode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">1. base_encode</div>
            </div> <br>
            
            <div>
                A coined function for php <code>base64_encode</code>. It removes the equals sign from the 
                generated hashed value. This does not affect the performance of <code>base64_decode</code> function 
                when decoding the hashed value.
            </div> 
          </div>  
          
          <!-- base_decode -->
          <div id="base_decode" class="base_decode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">2. base_decode</div>
            </div> <br>
            
            <div>
                Performs exactly the same function as <code>base64_decode</code>
            </div>
          </div>  

          <!-- tojson -->
          <div id="tojson" class="tojson"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. toJson</div>
            </div> <br>
            
            <div>
                This converts an array or string to json format. It is coined from 
                php <code>json_encode</code> function.
            </div> 
          </div>         

          <!-- fromjson -->
          <div id="fromjson" class="fromjson"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">4. fromJson</div>
            </div> <br>
            
            <div>
              This converts a std object or string to array format by default.
            </div>
          </div>         

          <!-- to_lgts -->
          <div id="to_lgts" class="to_lgts"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. to_lgts</div>
            </div> <br>
            
            <div>
                This function converts <code>{{ htmlentities('&lt;') }}</code> and <code>{{ htmlentities('&gt;') }}</code> to 
                their respective equivalent angle brackets. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  to_lgts('< code >')<span class="comment">// returns: {{ htmlentities('&lt;') }}  code {{ htmlentities('&gt;') }} </span>

              </pre>

            </div>
            <!-- code line ended -->

          </div>      

          <!-- href -->
          <div id="href" class="href"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">4. href</div>
            </div> <br>
            
            <div>
                This function converts the urls in a text or string to clickable links using the url link itself.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">
              <pre class="pre-code">
  $text = href('url : http://www.site.com');
  
  var_dump($text);<span class="comment"> // url : &lt;a href="http://www.site.com"&gt http://www.site.com &lt;/a&gt;</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>        

          <!-- scriptname -->
          <div id="scriptname" class="scriptname"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">5. scriptName</div>
            </div> <br>
            
            <div>
                This function returns the current script name
            </div>
          </div>    

          <!-- array_get -->
          <div id="striplastslash" class="striplastSlash"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">6. striplastSlash</div>
            </div> <br>
            
            <div>
                This function removes the last slash from a url. It works for both forward slashes and backslashes
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $stripped = striplastSlash('site.com/user/profile/')
      
  var_dump($stripped); <span class="comment">//returns : site.com/user/profile</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>    

          <!-- redirectto -->
          <div id="redirectto" class="redirectto"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">7. redirectTo</div>
            </div> <br>
            
            <div>
                same as php <code>header("location:")</code>
            </div>
          </div>      

          <!-- limittext -->
          <div id="limittext" class="limittext"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">8. limitText</div>
            </div> <br>
            
            <div>
                This limits the number of texts acceptable in a text string and appends an ellipses 
                to strings that have beyond the acceptable length of texts. It performs a simple 
                smart calculation on strings that may require ellipses and resolves to either add or
                ignore the ellipses.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns : This is a string of not more ...</span>
  limitText('This is a string of not more than 10 texts', 7); 
              </pre>

            </div>
            <!-- code line ended -->
          </div>      

          <!-- limitchars -->
          <div id="limitchars" class="limitchars"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">9. limitChars</div>
            </div> <br>
            
            <div>
                This limits the number of characters acceptable in a text string and appends an ellipses 
                to strings that have beyond the acceptable length of texts
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns : This is a string of not...</span>
  limitText('This is a string of not more than 10 texts', 22); 
              </pre>

            </div>
            <!-- code line ended -->

            <div class="font-menu mvt-6">In the example above, by calculation, <code>limitText</code> automatically detects to add the letter <code>t</code> to the 
            <code>no</code> to form <code>not</code>  before adding ellipses. At most times this behaviour is not predictable.</div>

          </div>  

          <!-- limitword -->
          <div id="limitword" class="limitword"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">10. limitWord</div>
            </div> <br>
            
            <div>
                This works similarly to limitText function but it is applied on the total number 
                of words required before an ellipses is added to a text.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns : This is a string of not more ...</span>
  limitWord('This is a string of not more than 10 texts', 7); 
              </pre>

            </div>
            <!-- code line ended -->

          </div>  

          <!-- arrSort -->
          <div id="arrsort" class="arrsort"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">16. arrSort</div>
            </div> <br>
            
            <div>
                The function removes keys with empty values, then sorts an array
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  vdump(arrsort([0 => 'foo', 1 => '', 2 => 'bar'])); <span class="comment">// [0 => 'foo', 2 => 'bar'] </span> 
  

  vdump(arrsort([0 => 'foo', 1 => '', 2 => 'bar'], true)); <span class="comment">// [0 => 'foo', 1 => 'bar'] </span> 
              </pre>

            </div>
            <!-- code line ended -->
          </div>       

          <!-- array_delete -->
          <div id="array_delete" class="array_delete"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">17. array_delete</div>
            </div> <br>
            
            <div>
                The function removes the first matched key of a corresponding supplied value 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $array = ['name' => 'foo', 'size' => '3', 'num' => '3'];


  vdump(array_delete('foo', $array)); <span class="comment">// ['size' => '3', 'num' => '3'] </span> 
  

  vdump(array_delete('3', $array); <span class="comment">// ['name' => 'foo', 'num' => '3'] </span> 
              </pre>

            </div>
            <!-- code line ended -->
          </div>     

          <!-- array_unset -->
          <div id="array_unset" class="array_unset"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">18. array_unset</div>
            </div> <br>
            
            <div>
                The function removes all matched key of a corresponding supplied value 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $array = ['name' => 'foo', 'size' => '3', 'num' => '3'];

  vdump(array_unset('3', $array); <span class="comment">// ['name' => 'foo'] </span> 
              </pre>

            </div>
            <!-- code line ended -->
          </div>           
        
        </div> 

      </div>

    </section>
  </div>

  @lay('build.co.coords:footer')

@template;