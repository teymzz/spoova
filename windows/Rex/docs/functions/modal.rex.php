
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions - Modal</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper functions are predefined spoova functions that eases building 
                web applications. Spoova helper functions are divided into three categories 
                
                <br>
                
            </div> 
          </div>

          <!-- br -->
          <div id="br" class="br"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">1. br</div>
            </div> <br>
            
            <div>
                The <code>br</code> function breaks a line both within cli and on web pages
            </div> <br>
            
            <!-- code line started - refil -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment"> >> syntax: br(value, breaks)</span>

  <span class="c-sky-blue-dd">
      value: string 
      breaks: number of breaks after
  </span> 
              </pre>

            </div>
            <!-- code line ended -->
          </div>    

          <!-- refil -->
          <div id="refil" class="refil"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">2. refil</div>
            </div> <br>
            
            <div>
              If a trimmed value is not empty, <code>refil</code> returns the second argument supplied.
    
              <!-- code line started - refil -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  <span class="comment"> >> syntax: </span>

      $value = 'foo';
      $newval = refil($value, 'bar');

      echo $newval  <span class="comment">// returns : bar </span>
                </pre>

              </div>
              <!-- code line ended -->
  
            </div> <br>

          </div>

          <!-- encodeUriComponent -->
          <div id="encodeuricomponent" class="encodeuricomponent"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. encodeUriComponent</div>
            </div> <br>
            
            <div>
                Encodes url in a way that is similar to Javascript's encodeURIComponent
            </div> 
          </div>         

          <!-- inRange -->
          <div id="inrange" class="inrange"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">4. inRange</div>
            </div> <br>
            
            <div>
                Checks if a value is within the range of two values
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">// syntax: </span>
  inRange($value, $min, $max)


  <span class="comment">// Example : returns true </span>
  inRange(27, 20, 50)
              </pre>

            </div>
            <!-- code line ended -->

          </div>      
          
          <!-- randice -->
          <div id="randice" class="randice"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">5. randice</div>
            </div> <br>
              
            <div>
                Generates a list or random_bytes hash string from the supplied range of keys.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns random hashed string of 10 characters</span>
  $hash = randice(10);

  <span class="comment">//returns random hashed string of 5 characters from supplied string</span>
  $hash = randice(10, 'abc123');   
              </pre> 

            </div>
            <!-- code line ended -->

          </div>                 
          
          <!-- is_empty -->
          <div id="is_empty" class="is_empty"> 
            <br>

            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">6. is_empty</div>
            </div> <br>
              
            <div>
                This function tests if a value is empty. This can be an array or trimmed string. 
                By trimming strings before testing, it acts as a proof against empty spaces. The function 
                is also capable of regarding non-empty values as empty values. Examples are shown below:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//tests if value supplied is empty</span>
  is_empty('a'); <span class="comment">//returns false</span>
  is_empty(''); <span class="comment">//returns true</span>
  is_empty('    '); <span class="comment">//returns true</span>
  is_empty([]); <span class="comment">//returns true</span>

  <span class="comment">//using defined and empty values</span>
  is_empty('a', ['a','b','c']); <span class="comment">//returns true (because "a" exists in the list of assumed empty values)</span>  
  is_empty('', ['a','b','c']); <span class="comment">//returns true (because test value is an empty value)</span>  
              </pre> 

            </div>
            <!-- code line ended -->

          </div>                 
          
          <!-- not_empty -->
          <div id="not_empty" class="not_empty"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">7. not_empty</div>
            </div> <br>
            
            <div>
                This is the reverse of <a href="@DomUrl('docs/functions/modal#is_empty')">is_empty</a> function
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
    <span class="comment">//tests if value supplied is empty</span>
    not_empty('a'); <span class="comment">//returns true</span>
    not_empty(''); <span class="comment">//returns false</span>
    not_empty('    '); <span class="comment">//returns false</span>
    not_empty([]); <span class="comment">//returns false</span>

    <span class="comment">//using defined an empty values</span>
    not_empty('a', ['a','b','c']); <span class="comment">//returns false (because "a" exists in the list of assumed empty values)</span>  
    not_empty('', ['a','b','c']); <span class="comment">//returns false (because test value is an empty value)</span>  
              </pre> 

            </div>
            <!-- code line ended -->

          </div>  

          <!-- combine -->
          <div id="combine" class="combine"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">8. combine</div>
            </div> <br>
            
            <div>
                This function combines two arrays or a string into an array. The first argument 
                is not neccesarily an array but the second argument must be an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
              
  $array = [1,2,3];

  combine(4, $array);
  vdump($array); <span class="comment">//returns: [1,2,3,4]</span>  

  <span class="comment">//using $array</span>
  
  combine([4, 5], $array);
  vdump($array); <span class="comment">//returns: [1,2,3,4,5]</span>
              </pre>

            </div>
            <!-- code line ended -->

          </div>   
          
          <!-- compare -->
          <div id="compare" class="compare"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">9. compare</div>
            </div> <br>
            
            <div>
                Compare checks if all arguments supplied are of equal values.
                It is case sensitive. These can be used to test any data type
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">//returns true</span>
  vdump(compare('user', 'user', 'user')); 

  <span class="comment">//returns false</span>
  vdump(compare('user', 'user', 'me')); 
              </pre>

            </div>
            <!-- code line ended -->

          </div>   

          <!-- arrinside -->
          <div id="arrinside" class="arrinside"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">10. arrInside</div>
            </div> <br>
            
            <div>
                This function checks if array contains another array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=> ['name'=>'foo'] ];
      
  <span class="comment">//returns true</span>
  var_dump(arrInside($value)); 
              </pre>

            </div>
            <!-- code line ended -->

          </div>        

          <!-- arrvoid -->
          <div id="arrvoid" class="arrvoid"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">11. arrVoid</div>
            </div> <br>
            
            <div>
                This function checks if an array is empty. Contrary to empty function, all
                array keys having empty values are removed before testing is done.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>''];
  $foo = ['user'=>'foo'];
      
  <span class="comment">//returns true</span>
  var_dump(arrVoid($value));
  
  <span class="comment">//returns false</span>
  var_dump(arrVoid($foo)); 
              </pre>   
              
            </div>
            <!-- code line ended -->

          </div>        

          <!-- arrgetsvoid -->
          <div id="arrgetsvoid" class="arrgetsvoid"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">12. arrGetsVoid</div>
            </div> <br>
            
            <div>
                This function checks if at least one empty value exists within an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
    $value = ['user'=>'','gender'=>'male'];
    $foo = ['user'=>'foo', 'gender'=> 'male'];
        
    <span class="comment">//returns true</span>
    var_dump(arrGetsVoid($value));
    
    <span class="comment">//returns false</span>
    var_dump(arrGetsVoid($foo));    
              </pre>

            </div>
            <!-- code line ended -->

          </div> 

          <!-- arrSort -->
          <div id="arrsort" class="arrsort"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">13. arrSort</div>
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

          <!-- array_trim -->
          <div id="array_trim" class="array_trim"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">14. array_trim</div>
            </div> <br>
            
            <div>
                This function removes keys having empty values from an array.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>'','gender'=>'male'];
      
  <span class="comment">//returns ['gender'=>'male']</span>
  var_dump(array_trim($value));
              </pre>

            </div>
            <!-- code line ended -->
          </div>        

          <!-- array_get -->
          <div id="array_get" class="array_get"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">15. array_get</div>
            </div> <br>
            
            <div>
                This function returns a specified key in an array or null if such key does not exist.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=>'','gender'=>'male'];
      
  <span class="comment">//returns ['gender'=>'male']</span>
  $user = array_get('user', $value);

  var_dump($user);
              </pre>

            </div>
            <!-- code line ended -->

          </div>    

          <!-- array_object -->
          <div id="array_object" class="array_object"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">16. array_object</div>
            </div> <br>
            
            <div>
                This function converts an array to an std object.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  $value = ['user'=> ['name'=>'foo'] ];
      
  $obj = array_object($value);

  <span class="comment">//returns : foo</span>
  vdump($obj->user['name'])
              </pre>

            </div>
            <!-- code line ended -->

          </div>                   

          <!-- array_delete -->
          <div id="array_delete" class="array_delete"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
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
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
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
                    
          <!-- reItemize -->
          <div id="reitemize" class="reitemize"> 
            <br>
            <div class="font-menu lacier fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">19. reItemize</div>
            </div> <br>
            
            <div>
              This function is used to regroup a two dimentional arrays of equal values.
              It is mainly used to regroup file uploads. For example:
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  <span class="comment">// An array: </span> 
  $array['name'][0] = 'fileName1';
  $array['age'][0]  = 20;  

  $array['name'][1] = 'fileName2';
  $array['age'][1] = 25;

  $array = reItemize($array);

  <span class="comment">// Becomes: </span> 
  $array[0]['name'] = 'fileName1';
  $array[0]['age'] = 20;

  $array[1]['name'] = 'fileName2';
  $array[1]['age'] = 25;
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