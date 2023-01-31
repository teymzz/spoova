
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

          <!-- enplode -->
          <div id="enplode" class="enplode"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">5. enplode</div>
            </div> <br>
            
            <div>
              This function uses the php implode() function. The main function is to wrap a string around 
              an array that was imploded. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  <span class="comment">1.</span> enplode( ["_", "#"], ['Hi', 'there'] ); <span class="comment">// returns: #Hi_there# </span>

  <span class="comment">2.</span> enplode( ["_", "(", ")"], ['Hi', 'there'] ); <span class="comment">// returns: (Hi_there) </span>

  <span class="comment">3.</span> enplode( ["_", "(", ")"], [] ); <span class="comment">// returns: null</span>

  <span class="comment">4.</span> enplode( ["_", "(", ")"], [], true ); <span class="comment">// returns: ()</span>

              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                In the examples above, while the underscore is the string that is used to implode the second array argument,
                <ul class="mvt-6">
                  <li>
                    In line 1 above, the hash will be wrapped around the implode string only if there is a string to be imploded. 
                  </li>
                  <li>
                    In line 2 above, The first (opening) and second (closing) pathenthesis will be added to the start and end of the imploded string respectively.
                  </li>
                  <li>
                    In line 3 above, both pathenthesis will not be added to the imploded array because the array is empty.
                  </li>
                  <li>
                    Line 4 however, explains that when a third boolean argument of true is supplied, then the wrapper characters will always be added even if the array is empty.
                  </li>
                </ul>
              </div>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- tosingular -->
          <div id="tosingular" class="tosingular"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">6. toSingular</div>
            </div> <br>
            
            <div>
              This function converts a string to singular by removing the last "s" or "S" character. The argument can also take a list of 
              array strings. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  <span class="comment">1.</span> echo( toSingular( 'Boys' ) ); <span class="comment">// Boy </span>

  <span class="comment">2.</span> print_r( toSingular( ['Boys', 'Book' "FUSS"] ) ); <span class="comment">// ['Boy', 'Book', "FUS"] </span>

              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> Notice that only the last "S" character is removed
              </div> <br>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- inflect -->
          <div id="inflect" class="inflect"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">7. inflect</div>
            </div> <br>
            
            <div>
              Inflect is a more powerful function that either adds or removes the last "s" character of a string based on the count 
              of value supplied to it. The format is shown below:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">
                <div class="bc-silver pxv-10">
                  Syntax
                </div>
              <pre class="pre-code">
  inflect($text, $count, $strict) 
              <span class="comment">
    where :

      $text   : string or array list of text strings
      $count  : integer used to determine the qunatity of $text 
      $strict : strict automation of addition or removal of last "s" character.
              </span> 
              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> Let's take a look at few examples:
              </div>

              <pre class="pre-code">
    inflect("Boy", 1); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //Boy  (add "s" if count is greater than 1)</span>

    inflect("Boy", 2); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //Boys (add "s" if count is greater than 1)</span>

    inflect("Boy", 2, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.......</span> //Boys (add "s" if count is greater than 1 and last character is not "s")</span>

    inflect("Boys", 2, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">......</span> //Boys (add "s" if count is greater than 1 and last character is not "s")</span>

    inflect("Boys", 1, true); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">......</span> //Boy  (remove "s" if count is less than 1 and last character is "s")</span>
              </pre>

              <div class="foot-note font-em-d9 pxs-14">
                <span class="bi-circle-fill"></span> First argument can also be an array of strings. All strings values will be processed within the array. 
              </div>


              <pre class="pre-code">
    inflect(["Boy","Book"], 2); <span class="comment no-select"> <span class="co-6 c-sky-blue-d">.............</span> //[Boys, Books]  (add "s" if count is greater than 1)</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>         

          <!-- to_lgts -->
          <div id="to_lgts" class="to_lgts"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">8. to_lgts</div>
            </div> <br>
            
            <div>
                This function converts <code>{{ htmlentities('&lt;') }}</code> and <code>{{ htmlentities('&gt;') }}</code> to 
                their respective equivalent angle brackets. 
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  to_lgts('< code >')<span class="comment">// returns: {{ htmlentities('&lt;') }} code {{ htmlentities('&gt;') }} </span>

              </pre>

            </div>
            <!-- code line ended -->

          </div>      

          <!-- href -->
          <div id="href" class="href"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">9. href</div>
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

            <div class="mvs-10 font-em-d8">
              A wrapper tag name can also be supplied for links
            </div>

            <div class="pre-area shadow">
              <pre class="pre-code">
  $text = href('url : http://www.site.com', 'span class="some_class"');
  
  var_dump($text);<span class="comment"> 
  
  <span class="c-teal no-select">// returns :</span>

  &lt;span class="some_class"&gt; 
    &lt;a href="http://www.site.com"&gt http://www.site.com &lt;/a&gt;
  &lt;/span&gt; 
                 </span>
              </pre>

            </div>
            
            <!-- code line ended -->
          </div>        

          <!-- scriptname -->
          <div id="scriptname" class="scriptname"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">10. scriptName</div>
            </div> <br>
            
            <div>
                This function returns the current script name
            </div>
          </div>    

          <!-- array_get -->
          <div id="striplastslash" class="striplastSlash"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">11. striplastSlash</div>
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
              <div class="flex-full">12. redirectTo</div>
            </div> <br>
            
            <div>
                same as php <code>header("location:")</code>
            </div>
          </div>      

          <!-- limittext -->
          <div id="limittext" class="limittext"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">13. limitText</div>
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
  limitText('This is a string of not more than 10 texts', 7); 
  
  <span class="comment">//returns : This is a string of not more ...</span>
              </pre>

            </div>
            <!-- code line ended -->
          </div>      

          <!-- limitchars -->
          <div id="limitchars" class="limitchars"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">14. limitChars</div>
            </div> <br>
            
            <div>
                This limits the number of characters acceptable in a text string and appends an ellipses 
                to strings that have beyond the acceptable length of texts
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  limitText('This is a string of not more than 10 texts', 22);

  <span class="comment">//returns : This is a string of not...</span> 
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
              <div class="flex-full">15. limitWord</div>
            </div> <br>
            
            <div>
                This works similarly to limitText function but it is applied on the total number 
                of words required before an ellipses is added to a text.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  limitWord('This is a string of not more than 10 texts', 7);

  <span class="comment">//returns : This is a string of not more ...</span> 
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