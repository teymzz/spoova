@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Colors</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        Colors are added to cli texts for different reasons. Mostly, they either provide quick information on a particular subject 
                                        matter or they are used to keep console users alert and aware of responses obtained from running a particular command. They 
                                        can also be used to separate different syntaxes to a particular command but the most important use of colors is that they 
                                        make console texts more readable and easier to process.  
                                    </p>

                                    <p>
                                        Cli colors are added to text based on color codes. Each text is wrapped within its own color code, making it impossible to 
                                        add colors within another color code whether as a combination of text colors or text background colors. This in other words mean 
                                        that each text color must be defined separately for each texts. The available methods under these category are listed below:
                                    </p>

                                </div>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li><a href="#color" class="c-i">color</a></li>
                                                <li><a href="#danger" class="c-i">danger</a></li>
                                                <li><a href="#warn" class="c-i">warn</a></li>
                                                <li><a href="#alert" class="c-i">alert</a></li>
                                                <li><a href="#valid" class="c-i">valid</a></li>
                                                <li><a href="#bgColor" class="c-i">bgColor</a></li>
                                                <li><a href="#bgDanger" class="c-i">bgDanger</a></li>
                                                <li><a href="#bgWarn" class="c-i">bgWarn</a></li>
                                                <li><a href="#bgAlert" class="c-i">bgAlert</a></li>
                                                <li><a href="#bgValid" class="c-i">bgValid</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div>  

                        <div id="color" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> Cli::color()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is used to apply colors on cli texts. There are four basic text colors support which are green, yellow, blue and red. Colors 
                                are added by wrapping texts within the specific color code. The technology is based on the fact that a color code cannot be applied within another 
                                color code. Hence, to apply diffent color codes on texts, each text must be wrapped separately within its own color. 
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: color</code></div>
                                    <pre class="pre-code">
    Cli::color($text, $name, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $name    : The name of color to be applied. Options are [red|blue|green|yellow|cyan|purple]
        $spcaing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="danger" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> Cli::danger()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a red color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: danger</code></div>
                                    <pre class="pre-code">
    Cli::danger($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="warn" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">3.</span>
                                        </span> Cli::warn()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a yellow color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: warn</code></div>
                                    <pre class="pre-code">
    Cli::warn($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="alert" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">4.</span>
                                        </span> Cli::alert()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a blue color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: alert</code></div>
                                    <pre class="pre-code">
    Cli::alert($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="valid" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">5.</span>
                                        </span> Cli::valid()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a green color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: valid</code></div>
                                    <pre class="pre-code">
    Cli::valid($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="bgColor" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">6.</span>
                                        </span> Cli::bgColor()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a used to apply background colors on texts. It is however important to lay emphasis on the fact that both the <code>bgColor()</code>
                                and the <code>color()</code> methods cannot be applied within each other but can only be applied separately on different texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: bgColor</code></div>
                                    <pre class="pre-code">
    Cli::bgColor($text, $name, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which color should be applied
        $name    : The background color name to be applied. Options: [white|black|red|green|blue|cyan|purple|yellow] 
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="bgDanger" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">7.</span>
                                        </span> Cli::bgDanger()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a red background color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: bgDanger</code></div>
                                    <pre class="pre-code">
    Cli::bgDanger($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which background color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="bgWarn" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">8.</span>
                                        </span> Cli::bgWarn()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a yellow background color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: bgWarn</code></div>
                                    <pre class="pre-code">
    Cli::warn($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which background color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="bgAlert" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">9.</span>
                                        </span> Cli::bgAlert()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a blue color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: bgAlert</code></div>
                                    <pre class="pre-code">
    Cli::bgAlert($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which background color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="bgValid" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">10.</span>
                                        </span> Cli::bgValid()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is a short form of applying a green color code on texts.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: bgValid</code></div>
                                    <pre class="pre-code">
    Cli::bgValid($text, $spacing); 
    <span class="comment no-select">
      where: 
    
        $text    : The text on which background color should be applied
        $spacing : An optional spacing format
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;