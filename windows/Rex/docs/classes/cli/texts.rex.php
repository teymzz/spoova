@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-20 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Texts Control</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">
                                    There are different cli methods for adding texts to the terminal in the manner which is desirable to console users. 
                                    Hence, features like text margins and line breaks becomes easier to control. Most of these methods achieve their 
                                    functions by shifting the console pointer to desired positions while other methods only makes it easier to print text 
                                    to console in a specific desired format. These methods and their descriptions are listed below.
                                </div> <br>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li>textIndent</li>
                                                <li>textView</li>
                                                <li>List</li>
                                                <li>dots</li>
                                                <li>backspace</li>
                                                <li>cls</li>
                                                <li>clearLine</li>
                                                <li>clearUp</li>
                                                <li>upLine</li>
                                                <li>br</li>
                                                <li>break</li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div>  

                        <div id="textIndent" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> Cli::textIndent()
                                    </div>
                                </div> <br>

                                <div class="">
                                    This method is used to only apply indents on supplied text value. Once the indent is applied, the resulting text will 
                                    be returned as a string.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textIndent</code></div>
                                            <pre class="pre-code">
    Cli::textIndent($text, $spaces);
    <span class="comment">
      where: 
        
        $text   : text to be indented
        $spaces : number of indents to be applied
    </span>
                                            </pre>
                                        </div>
                                        </div>
                                </div>
                            </div> <br><br>
                        </div>

                        <div id="textView" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> Cli::textView()
                                    </div>
                                </div> <br>

                                <div class="">
                                    This method is used to display text contents on the command line. It is capable of applying features like spaces, indents, 
                                    breaks and delays on text to be display.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView($text, $spacing, $break, $pause);
    <span class="comment">
      where: 
        
        $text    : text to be displayed
        $spacing : An optional string format that applies spaces before and after the supplied text using a pipe divider
        $break   : An optional string format that applies breaks before and after the supplied text using a pipe divider
        $pause   : An optional string format that applies delays before and after a string is displayed.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 1: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView("Hello text", 2, 3, 1);
    <span class="comment no-select">
    In the code above, the text "Hello text" will be printed on the cli using specific features:

        1. The <code class="c-orange-d">2</code> defines that 2 spaces should be applied before the text is printed
        
        2. The <code class="c-orange-d">3</code> defines that 3 line breaks should be added before text is printed

        3. The <code class="c-orange-d">1</code> defines a 1 second delay before text is printed.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 2: textView</code></div>
                                            <pre class="pre-code">
    Cli::textView("Hello text", "2|2", "3|2", '2|1');
    <span class="comment no-select"> 
    The code above reveals that pipes are used to specify the position before and after when an event should be applied.

        1. The <code class="c-orange-d">"2|2"</code> defines that 2 spaces before and 2 spaces after should be applied on the text
        
        2. The <code class="c-orange-d">"3|2"</code> defines that 3 line breaks before and 2 breaks after should be applied on the text

        3. The <code class="c-orange-d">"2|1"</code> defines that 2 seconds delay before and 1 delay after should be applied on the text.
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>


                                </div>
                            </div> <br><br>
                        </div>

                        <div id="List" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">3.</span>
                                        </span> Cli::List()
                                    </div>
                                </div> <br>
                                <div class="">
                                    The <code>List</code> method is used to display an array of strings with numbers. The numbering starts from 
                                    zero upward. However, associative arrays will use ther specific array keys
                                    <br><br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: list</code></div>
                                            <pre class="pre-code">
    Cli::list($array, $spacing, $break, $interval);
    <span>
      where:

        $array      : array of strings to be displayed 
        $spacing    : An optional spacing format that applies spacing on each text to be displayed 
        $break      : An optional line breaking format that applies spacing on each text to be displayed 
        $interval   : An optional delay format that applies delay in seconds on each text to be displayed 
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 1: List</code></div>
                                            <pre class="pre-code">
    Cli::List(['Foo','Bar', 'Baz'], 0, "|1");
    <span>
     <span class="comment no-select">The response will be as below:</span> 

     1. Foo
     2. Bar
     3. Baz
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Example 2: List</code></div>
                                            <pre class="pre-code">
    Cli::List(['a'=>'Foo','b'=>'Bar', 'c' => 'Baz'], 0, "|1");
    <span>
     <span class="comment no-select">The response will be as below:</span> 

     a. Foo
     b. Bar
     c. Baz
    </span>
                                            </pre>
                                        </div>
                                    </div> <br>


                                </div>
                            </div>
                        </div> <br>

                        <div id="dots" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">4.</span>
                                        </span> Cli::dots()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is used to repeat a defined character in the number of required number of chracter to to generated. The 
                                number of character generated depends on the maximum number of character expected to be generated in a given text. This 
                                ensures that a defined character fills up the spaces left if the defined maximum length of characters for a given text is not 
                                reached.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: dots</code></div>
                                    <pre class="pre-code">
    Cli::dots($max, $text, $char); 
    <span class="comment no-select">
      where: 
    
        $max  : The expected length of text characters that must be generated. 
        $text : A given text whose length of characters is measured
        $char : A character that fills up left over space. Default is dots "."
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="backspace" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">5.</span>
                                        </span> Cli::backspace()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>backspace()</code> method is used to delete the text characters starting from the right towards the 
                                left side. 
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: backspace</code></div>
                                    <pre class="pre-code">
    Cli::backspace($times); 
    <span class="comment no-select">
      where: $times is the number of times a backspace must be applied. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="cls" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class="mxr-8 c-lime-dd">
                                            <span class="numb-box">6.</span>
                                        </span> Cli::cls()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>cls()</code> method is used to clear the terminal screen.
                                </div>
                            </div> 
                        </div><br>

                        <div id="clearLine" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">7.</span>
                                        </span> Cli::clearLine()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>clearLine()</code> method is used to delete the entire character on a line. This method takes 
                                no arguments.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: backspace</code></div>
                                    <pre class="pre-code">
    Cli::backspace($times); 
    <span class="comment no-select">
      where: $times is the number of times a backspace must be applied. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="clearUp" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class="mxr-8 c-lime-dd">
                                            <span class="numb-box">8.</span>
                                        </span> Cli::clearUp()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>clearUp()</code> method is used to delete a line before a text is printed. It shifts the positon of the cli pointer 
                                up by deleting all characters found along the way to its destination point.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: clearUp</code></div>
                                    <pre class="pre-code">
    Cli::clearUp($times); 
    <span class="comment no-select">
      where: $times is the number of times a the pointer must move up. The default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="upLine" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">9.</span>
                                        </span> Cli::upLine()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>upLine()</code> method is used to shift the position of the command line pointer upwards without 
                                deleting any character.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: upLine</code></div>
                                    <pre class="pre-code">
    Cli::upLine($times); 
    <span class="comment no-select">
      where: $times is the number of times a cursor must be shifted upwards.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="br" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">10.</span>
                                        </span> Cli::br()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>br()</code> method is used to apply text line breaks after a text has been printed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: br</code></div>
                                    <pre class="pre-code">
    Cli::br($times); 
    <span class="comment no-select">
      where: $times is the number of times a line break must be applied. Default value is "1".
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> <br>
                        </div>

                        <div id="break" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">11.</span>
                                        </span> Cli::break()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>break()</code> method is also used to apply text line breaks after a text has been printed. The difference between <code>Cli::br()</code> 
                                and <code>Cli::break()</code> is that the latter prints directly by default while the former returns line breaks. However, the <code>Cli::break()</code> 
                                can also be modified to return line breaks rather than printing them. This can be done by setting the second argument to false.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: break</code></div>
                                    <pre class="pre-code">
    Cli::break($times, $print); 
    <span class="comment no-select">
      where: 
        
        $times : The number of times a line break must be applied. Default value is "1".
        $print : When set as false, line breaks will only be returned as a string
    </span>
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
