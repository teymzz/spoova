
@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial mails bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Input</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                        <div class="">
                            The input class is a special tool that helps to validate input. It 
                            is mostly used when validating form inputs. All validation are 
                            directly processed and returned through the <code>set</code> method. 
                            The following are methods available in the input class.
                        </div> <br> 

                            <ol>
                            <li> <a href="#set" class="c-olive ch-olive-dd"> set </a> </li>
                            <li> <a href="#strict" class="c-olive ch-olive-dd"> strict </a> </li>
                            <li> <a href="#default_type" class="c-olive ch-olive-dd"> default_type </a> </li>
                            <li> <a href="#default_length" class="c-olive ch-olive-dd"> default_length </a> </li>
                            <li> <a href="#default_range" class="c-olive ch-olive-dd"> default_range </a> </li>
                            <li> <a href="#arrgetsvoid" class="c-olive ch-olive-dd"> arrGetsVoid </a> </li>
                            <li> <a href="#voidkey" class="c-olive ch-olive-dd"> voidKey </a> </li>
                            </ol>
                            
                        </div> 
                    </div>

                    <div id="initialize" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8 bi-lightning-fill">
                                    </span> initializing class
                                </div>
                            </div>
                            <div class="">
                            The <code>input</code> class can be easily initialized as shown below.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Sample: Initializing Input</div>
                                    <pre class="pre-code">
  $input  = new Input;
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br><br>
                    </div>

                    <div id="set" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> set
                                </div>
                            </div>

                            <div class="">
                                The <code>set</code> method is used to set parameters to be validated by
                                the input class. It's alias method is the <code>test()</code> method which takes the same number 
                                of arguments as parameters.
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  $input->set($value, $config, $bool);

  $input->test($value, $config, $bool); <span class="comment">// same as above</span>
    <span class="comment no-select">
    where:
        
        $value : value to be tested 
        $config: configuration parameters or options that define action to be performed 
        $bool  : a boolean of true tells input class to disallow spaces when validating input value set.                            
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="exampes-intro foot-note">
                            We shall be looking at a series of examples below.
                        </div>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: validating strings</div>
                                <pre class="pre-code">
  $text1 = 'foo';
  $text2 = 'foo bar';

  $text1 = $input->set($text1, ['type' => 'string']); <span class="comment">// returns foo</span>

  $text2 = $input->set($text2, ['type' => 'string']); <span class="comment">// returns bar</span>

  <span class="comment">//check spaces</span>
  $text1 = $input->set($text1, ['type' => 'string'], true); <span class="comment">// returns foo</span>
  $text2 = $input->set($text2, ['type' => 'string'], true); <span class="comment">// returns null because test string contains spaces</span>                              
                                </pre>
                            </div>
                        </div>

                        <div class="foot-note pvs-10">
                            The following are list of available options and their descriptions: <br>
                            <br>
                            <div class="">
                                <div class="">
                                    <code>type</code> - defines the type of validation. Options are [string | text | email | integer | number | phone | url | range | pregmatch]
                                </div>
                                <div class="">
                                    <code>length</code> - defines the minimum and maximum number of characters to be allowed where maximum is default if one value is supplied.
                                </div>
                                <div class="">
                                    <code>range</code> - defines an array list which a value must be a member of. 
                                </div> <br>
                            </div>
                            The following examples best describe how these options can be applied for validation <br>
                        </div>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: Input Types</div>
                                <pre class="pre-code">
  $input->set('site@gmail.com', ['type' => 'email']); <span class="comment">// returns site@gmail.com</span>
  $input->set('site.com', ['type' => 'email']); <span class="comment">// returns null</span>


  $input->set('10', ['type' => 'number']); <span class="comment">// returns 10</span>
  $input->set('hi', ['type' => 'number']); <span class="comment">// returns null</span>


  $input->set('0701323323', ['type' => 'phone']); <span class="comment">// returns 0701323323</span>
  $input->set('07812', ['type' => 'phone']); <span class="comment">// returns null : This uses a regex pattern</span>

    
  $input->set('20', ['type' => 'number', range => ['5', '15', '20']]); <span class="comment">// returns 20</span>                              
  $input->set('20', ['type' => 'number', range => ['5', '15', '25']]); <span class="comment">// returns null</span> 


  $input->set('foo', ['type' => 'string', 'length' => 10]); <span class="comment">// returns 10, character is less than 10</span>                              
  $input->set('foobar123', ['type' => 'string', 'length' => ['0', '5']]); <span class="comment">// returns null, character is greater than 5</span>    


  $input->set('foo', ['type' => 'text', 'length' => 10]); <span class="comment">// returns foo</span>                              
  $input->set('foobar123', ['type' => 'text']); <span class="comment">// returns null, value contains number</span> 
    

  $input->set('http://site.com', ['type' => 'url']); <span class="comment">// returns http://site.com</span>                              
  $input->set('site', ['type' => 'url']); <span class="comment">// returns null, value is not a valid url</span> 
    
  $input->set('foobar', ['type' => 'string', 'pattern' => 'a-zA-z']); <span class="comment">// match data type using pattern</span>
    
  $input->set('400', ['type' => 'number', 'range' => [100, 700]]); <span class="comment">// match data type using specific range of values</span>

  $input->set('foobar', ['type' => 'string', 'length' => [3, 7]]); <span class="comment">// matches a minimum and maximum length of character a data must contain.</span> 
                                </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div id="strict" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> strict
                                </div>
                            </div>

                            <div class="">
                                The <code>strict()</code> method is a directive that prevents the input class from proceeding with 
                                subsequent validations if an error is encountered in previous validations <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: strict validation</div>
                                        <pre class="pre-code">
  $input->strict(bool);
    <span class="comment">
    where:
    
      bool: set the strict type to true or false. Default is true.
    </span>                            </pre>
                                    </div>
                                </div>          
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: strict validation</div>
                                <pre class="pre-code">
  $input->strict();

  $input->set('foo', ['type'=>'number']); <span class="comment"> // returns null</span>
    
  $input->set('foo', ['type'=>'text']); <span class="comment"> // returns null because a previous validation returned null</span>                                  
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div>
                        <div class="foot-note mvt-10">
                            The <code>strict()</code> method when set to true, is used to to stop a validation process if any of the <code>set()</code> method 
                            cannot validate the data supplied. Once any error occurs in any earlier validation, other subsequent validations after will fail 
                            by returning an empty value.
                        </div>
                    </div> <br>

                    <div id="default_type" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> default_type
                                </div>
                            </div>
                            <div class="">
                                    
                                Sets the default type of inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                    <div class="pxv-6 bc-off-white">Syntax</div>
                    <pre class="pre-code">
  $input->default_type($type); <span class="comment"> // set base path</span>
    <span class="comment"> 
    where :

      $type: type of validation
    </span>
                    </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $input->default_type('text'); <span class="comment"> // set default type</span>

  $input->set('foo'); <span class="comment">// returns foo</span>
  $input->set('foo123'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="default_length" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> default_length
                                </div>
                            </div>
                            <div class="">
                                Sets the default length of inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  $input->default_length(length); <span class="comment"> // set base path</span>
    <span class="comment"> 
    where :

      length: array or string of acceptable lengths
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $input->default_length(5); <span class="comment"> // set default length</span>
    
  $input->set('foo12'); <span class="comment">// returns foo12</span>
  $input->set('foobar123'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="default_range" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> default_range
                                </div>
                            </div>
                            <div class="">
                                Sets the default ranges for inputs to be validated. This can be overidden by setting 
                                options. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  $input->default_range($range); <span class="comment"> // set default range</span>
    <span class="comment"> 
    where :

      $range: array of acceptable ranges
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $input->default_range(['ball', 'cat', 'dog']); <span class="comment"> // set default range</span>
    
  $input->test('cat'); <span class="comment">// returns cat</span>
  $input->test('bird'); <span class="comment">// returns null</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="arrgetsvoid" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> arrGetsVoid
                                </div>
                            </div>
                            
                            <div class="">
                                The <code>arrGetsVoid</code> checks if a supplied array has any index key having an empty value within it.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  Input::arrGetsVoid($array); 
    <span class="comment no-select"> 
    where:
        
       $array : array lists to be tested
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  Input::arrGetsVoid(['name'=>'foo','age'=>'']); <span class="comment">// returns true</span>
  Input::arrGetsVoid(['name'=>'foo','age'=>'30']); <span class="comment">// returns false</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="voidkey" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> voidKey
                                </div>
                            </div>
                            <div class="">
                                The <code>voidKey</code> method returns the corresponding keys that have 
                                an empty value in a previously tested array. 
                                This method is useful when handling zip files.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: fetch last directory</div>
                                        <pre class="pre-code">
  Input::arrGetsVoid(['name'=>'foo', 'age'=>'']);
  Input::voidKey(); <span class="comment no-select"> // returns ['age']</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div> 
                    
                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
        @lay('build.co.coords:footer')

@template;