@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    <div class="start font-em-d8">

                        @lay('build.co.links:tutor_pointer') <br>

                        <div class="font-em-1d5 c-orange">Cli Notifications</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="">

                                <div class="">

                                    <p>
                                        Notifications are used to keep users aware of the current state of an executed command. They help users to have a clearer understanding 
                                        pf what is going on. For example, there could be notifications for when a code successfully executes or when an error is encountered. 
                                        The Cli class provides some useful methods for setting responses. These method have a predefined text prefixes assigned to messages. The 
                                        text prefixes also use similarly related color codes to quickly call console users to awareness. The following are notification related methods. 
                                    </p>

                                </div>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li><a href="#error" class="c-i">error</a></li>
                                                <li><a href="#warning" class="c-i">warning</a></li>
                                                <li><a href="#caution" class="c-i">caution</a></li>
                                                <li><a href="#notice" class="c-i">notice</a></li>
                                                <li><a href="#success" class="c-i">success</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>  

                        <div id="error" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> Cli::error()
                                    </div>
                                </div>
                                <div class="">
                                    This method makes it easier to display error texts. It adds a prefix of "Error:" on any text supplied and returns the prefixed text.
                                    <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
    Cli::error($text, $indent); 
    <span class="comment no-select">
      where: 
    
        $text   : The error text to be prefixed
        $indent : Number of left space indents to be added
    </span>
                                            </pre>
                                        </div>
                                    </div>  
                                </div>
                            </div> 
                        </div> <br>

                        <div id="warning" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> Cli::warning()
                                    </div>
                                </div>
                                <div class="">
                                    This method makes it easier to display warning texts. It adds a prefix of "Warning:" on any text supplied and returns the prefixed text.
                                    <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
    Cli::warning($text, $indent); 
    <span class="comment no-select">
      where: 
    
        $text   : The error text to be prefixed
        $indent : Number of left space indents to be added
    </span>
                                            </pre>
                                        </div>
                                    </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="caution" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> Cli::caution()
                                    </div>
                                </div>
                                <div class="">
                                    This method makes it easier to display caution texts. It adds a prefix of "CAUTION:" on any text supplied and returns the prefixed text.
                                    <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
    Cli::warning($text, $indent); 
    <span class="comment no-select">
      where: 
    
        $text   : The error text to be prefixed
        $indent : Number of left space indents to be added
    </span>
                                            </pre>
                                        </div>
                                    </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="notice" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> Cli::notice()
                                    </div>
                                </div>
                                <div class="">
                                    This method makes it easier to display notice texts. It adds a prefix of "NOTICE:" on any text supplied and returns the prefixed text.
                                    <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
    Cli::warning($text, $indent); 
    <span class="comment no-select">
      where: 
    
        $text   : The error text to be prefixed
        $indent : Number of left space indents to be added
    </span>
                                            </pre>
                                        </div>
                                    </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="success" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> Cli::success()
                                    </div>
                                </div>
                                <div class="">
                                    This method makes it easier to display notice texts. It adds a prefix of "Success:" on any text supplied and returns the prefixed text.
                                    <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
    Cli::warning($text, $indent); 
    <span class="comment no-select">
      where: 
    
        $text   : The error text to be prefixed
        $indent : Number of left space indents to be added
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