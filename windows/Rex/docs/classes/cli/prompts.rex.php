@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Prompts</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        Prompts are needed in cli to obtain user information. The PHP <code>STDIN</code> makes it possible to obtain 
                                        user inputs from the cli. After successfully retrieving an input, the input obtain can then be subjected to 
                                        further validation. The cli class has two main methods for obtaining user inputs which are <code>prompt()</code> 
                                        and <code>q()</code> methods.  
                                    </p>

                                </div>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li><a href="#prompt" class="c-i">prompt</a></li>
                                                <li><a href="#q" class="c-i">q (or query)</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div>  

                        <!-- Cli prompt -->
                        <div id="prompt" class="">
                          <div class="font-em-1d2 c-orange-dd">
                            Cli::prompt()
                          </div>
                          <div class="">
                            The prompt method is used when simple data is needed to be obtained from the cli. The first 
                            argument defines a list of options that must be matched by an input supplied while the second argument 
                            is a callback closure function that makes it possible to validate supplied inputs
                          </div> <br>

                          <div class="pre-area">
                            <div class="pxv-10 bc-silver">Syntax: prompt</div>
                            <pre class="pre-code">
Cli::prompt($options, $callback, $terminate);
<span class="comment no-select">
  where: 

    $options   : A list of options that must be matched 
    $callback  : A callback function that can be used to test values.
    $terminate : An optional argument to determines if invalid input should trigger a reprompt
    $new       : This is applied internally to determine a first use case of prompt.
</span>
                            </pre>

                          </div> <br><br>

                          <div class="examples">

                            <!-- prompt without argument -->
                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 1: prompt without arguments</div>
                              <pre class="pre-code">
    Cli::textView("Please input your name ", 0, 1);
  
    <span class="c-dodger-blue-d">$name = Cli::prompt();</span>
                              </pre>
                            </div> 

                            <div class="foot-note pvs-10">
                              In the above, the prompt method will wait to receive the user input once before terminating. Once the 
                              response is obtained, it will be stored inside the "$name" variable.
                            </div> <br>

                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 2a: prompt with arguments</div>
                              <pre class="pre-code">
    $options= ['y', 'n'];
  
    Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
    <span class="c-dodger-blue-d">Cli::prompt($options, function($input, $options){</span>
  
        $input = strtotlower($input);
  
        if(!in_array($input, $options)){
  
          Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
        }
  
    <span class="c-dodger-blue-d">});</span>
                              </pre>
                            </div> <br>

                            <div class="foot-note pvs-10">
                              In the code above, the <code>prompt</code> will expect an input of "y" or "n". 
                              If an invalid input is supplied, the callback function will tell the prompt to re-ask the 
                              same question until a valid response is obtained. By default, <code>prompt</code> method
                              is designed to continue prompting until a valid input is supplied. This behaviour is only applicable once 
                              arguments are defined on the method. However, this reprompt behaviour can be prevented by supplying 
                              a third argument of <code>true</code> on the <code>prompt()</code> method.
                            </div> <br>

                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 2b: prompt with arguments</div>
                              <pre class="pre-code">
    $options= ['y', 'n'];
  
    Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
    <span class="c-dodger-blue-d">$response = Cli::prompt($options, function($input, $options){</span>
  
        $input = strtotlower($input);
  
        if(!in_array($input, $options)){
  
          Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
        }, <span class="c-orange-dd">true</span>
  
    <span class="c-dodger-blue-d">});</span>
                              </pre>
                            </div> <br>


                            <div class="foot-note pvs-10">
                              In the example 2b above, the <code>prompt</code> will expect an input of "y" or "n". 
                              If an invalid input is supplied, the prompt will terminate and the last input entered will 
                              be forwarded to the "$response" variable. In certain situations, we might want to set the reprompt 
                              to a maximum number of trials. This is also possible by settin the third argument to a valid integer 
                              which tells the Cli that an invalid input is only allowed in the number of specified times. 
                            </div> <br><br>

                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 2c: specifying maximum number of failed trials.</div>
                              <pre class="pre-code">
    $options= ['y', 'n'];
  
    Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
    <span class="c-dodger-blue-d">$response = Cli::prompt($options, function($input, $options){</span>
  
        $input = strtotlower($input);
  
        if(!in_array($input, $options)){
  
          Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
        }, <span class="c-orange-dd">3</span>
  
    <span class="c-dodger-blue-d">});</span>
                              </pre>
                            </div> <br>

                            <div class="foot-note pvs-10">
                              In the example 2c above, the <code>prompt</code> will expect an input of "y" or "n". 
                              If an invalid input is supplied, the prompt continue to reprompt until the maximum 
                              number of trials is reached after which it will exit by returning the last response obtained.
                            </div> <br>

                          </div>

                          <div class="">
                            <div class="font-em-1d1 c-olive">Validating prompt responses</div>
                            <div class="pvs-10">
                              <p>
                                While the <code>prompt</code> method does some light validations, it also enables developers to 
                                perform advanced or custom validations on responses obtained using different relative methods such as 
                                <code>Cli::promptIsMax()</code> and <code>Cli::promptInvalid()</code>.
                              </p>
                              <p>
                                The <code>promptIsMax()</code> returns true when the maximum number of trials is exhausted or reached while 
                                the <code>promptIsValid()</code> returns true when the last input supplied is not valid. Together, this 
                                methods can help developers to understand if a prompt was terminated and why it was terminated.
                              </p>
                            </div>

                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 3: validating responses</div>
                              <pre class="pre-code">
    $options= ['y', 'n'];
  
    Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
    <span class="c-dodger-blue-d">$response = Cli::prompt($options, function($input, $options){</span>
  
        $input = strtotlower($input);
  
        if(!in_array($input, $options)){
  
          Cli::textView("Will you like to continue? [Y/N] ", 0, 1);
  
        }, <span class="c-orange-dd">3</span>
  
    <span class="c-dodger-blue-d">});</span>


    if( Cli::promptIsMax() && Cli::promptInvalid() ) {

      Cli::textView( Cli::error('maximum number of trials was exeeded!') 0, "1|2");

    } elseif( Cli::promptInvalid() ) {

      Cli::textView( Cli::error('invalid response obtained') 0, "1|2");      

    }else{

      Cli::textView( Cli::success('valid response obtained') 0, "1|2");  

    }
                              </pre>
                            </div> <br>

                            <div class="foot-note pvs-10">
                              The code above will expect a response of "y" or "n". If the input is valid then the success message 
                              will be printed. However, if the input obtained is invalid the error message will be displayed based on the 
                              type of error that occured.
                            </div>

                          </div>


                        </div> <br>

                        <!-- Cli::q -->
                        <div id="q" class="">
                          <div class="font-em-1d2 c-orange-dd">
                            Cli::q()
                          </div>
                          <div class="">
                            The <code>q</code> otherwise called the the "query" method is an advanced method for obtaining, testing and validating 
                            user inputs. It is advanced in its structure because it provides an environment for checking data at every level when it 
                            is obtained. The major difference between the <code>cli::q()</code> and <code>Cli::prompt()</code> is that the <code>Cli::q()</code> 
                            manages prompts in a quite effective and articualate way. The callback supplied on this method is expected to return an array with index 
                            keys of <code>init</code>, <code>test</code>, <code>success</code>, <code>failed</code> and <code>max</code>. Each of these keys are in turn used to handle 
                            input validations.
                          </div> <br>

                          <div class="pre-area">
                            <div class="pxv-10 bc-silver">Syntax: Cli::q()</div>
                            <pre class="pre-code">
  Cli::q($options, $callback, $trials);
  <span class="comment no-select">
    where: 

      $options   : A list of options on which a manual test will be performed. 
      $callback  : A callback function for performing advanced validation.
      $trials    : Number of acceptable trials.
  </span>
                            </pre>
                          </div> <br><br>

                          <div class="examples">

                            <!-- query on options -->
                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 4a: query options</div>
                              <pre class="pre-code">
    <span class="c-dodger-blue-d">$options= ['y', 'n'];</span>
    
  
    <span class="c-dodger-blue-d">$input = Cli::q($options, fn() => 

      [</span>
        'init' => fn() => Cli::textView("Will you like to continue? [Y/N] ", 0, 1),

        'test' => function($options, $input, $counter) {

            return in_array( strtolower($input), $options );

         },

         'failed' => function($options, $input, $counter) {

            Cli::textView(Cli::error('invalid option supplied!'));

            return true;

         },

         'success' => function($options, $input, $counter) {

            Cli::textView(Cli::success('valid option supplied!'));

         },   

         'max' => function() {

            Cli::textView( Cli::error('maximum reached!') );
          
         }

    <span class="c-dodger-blue-d">  ], 3
      
    )
    </span>
                              </pre>
                            </div> <br>

                            <div class="foot-note pvs-10">
                              <p>
                                In the code above, the <code>init</code> is first called which prints a text to the Cli. 
                                This action is followed by calling the <code>test</code> which is expected to return a bool of 
                                true or false. If the test fails and false is returned, the <code>failed</code> will be triggered if it was defined. However, if the 
                                test returns true, then the <code>success</code> key will be called if defined. Also, if the test fails and the <code>failed</code> 
                                callback returns true, then a reprompt will be made will will ensure that <code>init</code> is first called before the <code>test</code> 
                                is called. The <code>max</code> key is also triggered if the maximum number of trials is reached. 
                                It should be noted that while <code>init</code>, <code>failed</code>, <code>success</code> and <code>max</code> keys are optional, the <code>test</code> key must be defined.
                              </p>
                              <p>
                                The <code>Cli::q()</code> also has its own validation methods just like the <code>Cli::prompt()</code> method. These validation methods are 
                                <code>Cli::qValid()</code>, <code>Cli::qFailed()</code> and <code>Cli::qmax()</code>
                              </p>
                            </div> <br>

                            <div class="pre-area">
                              <div class="pxv-10 bc-silver">Example 4b: query with validation methods</div>
                              <pre class="pre-code">
    $options = ['y', 'n'];
   
  
    <span class="c-dodger-blue-d">$response = Cli::q($options, fn() => 

      [

        'init' => fn() =>  Cli::textView("Will you like to continue? [Y/N] ", 0, 1),

        'test' => fn($input, $options) => in_array(strtolower($input), $options),

        'failed' => function($input, $options){
          
          if( !Cli::qmax() ) return !in_array(strtolower($input), $options);

        } 


      ],</span> <span class="c-orange-dd">3</span>
  
    <span class="c-dodger-blue-d">});</span>

    if(Cli::qValid()){

      Cli::textView( Cli::success('input is valid') , 0, "|2"  );

    }else{

      if(Cli::qmax()){

        Cli::textView( Cli::error('maximum trials reached!') , 0, "|2"  );
        
      }else{ 
        
        Cli::textView( Cli::error('invalid options supplied!') , 0, "|2" );

      }

    }
                              </pre>
                            </div> <br>


                            <div class="foot-note pvs-10">
                              In the example 4b above, the <code>Cli::q()</code> will expect an input of "y" or "n". 
                              If an invalid input is supplied, a reprompt will be made until the maximum number of trials is reached.
                              Once the query prompt is completed, the response will be saved into "$response". The <code>Cli::qvalid()</code> 
                              will return true if the input was valid. The <code>Cli::qmax()</code> returns true if the maximum acceptable 
                              number of trials is reached. Also, athough the 
                              <code>Cli::qFailed()</code> was not used above, but it will also return true if the input supplied was invalid.
                            </div> <br>

                          </div>


                        </div>

                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;