@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Notice</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            The <code>Notice</code> class is a tool that is used to set flash messages. 
                            These messages are displayed once and then removed after display. Available  
                            methods are:
                        </div> <br>

                            <ol>
                                <li> <a href="#setFlash"> setFlash </a> </li>
                                <li> <a href="#getFlash"> getFlash </a> </li>
                                <li> <a href="#hasFlash"> hasFlash </a> </li>
                                <li> <a href="#flash"> flash </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> Initializing class
                                </div>
                            </div> <br>

                            <div class="">
                                The hasher tool can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Sample: Initializing Hasher</code></div>
                                        <pre class="pre-code">
    $notice  = new Notice;
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br><br>
                    </div>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> keywords
                                </div>
                            </div> <br>
                            <div class="">
                                The following keywords should be noted:
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>keywords</code></div>
                                        <pre class="pre-code">
                                            <span class="comment">
    key : a unique id string for a notice
    message : a string of text stored for displayed
                                            </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br><br>
                    </div>        

                    <div id="hasFlash" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> hasFlash
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>hasFlash</code> method is used to a check if a flash 
                            key exists.
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: hasFlash</code></div>
                                    <pre class="pre-code">
    $notice->hasFlash(key); <span class="comment">// returns true or false</span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: checking flash</code></div>
                                <pre class="pre-code">
    $notice->setFlash('greeting', "Welcome"); <span class="comment">// set a notice message</span>

    if($notice->hasFlash('greeting'))) {

        echo 'Greeting exists';

    }
                                </pre>
                            </div>
                        </div>
                    
                    </div> <br>

                    <div id="getFlash" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> getFlash
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>getFlash()</code> method is used to fetch a previously set flash. 
                                It throws an error if the flash key does not exist.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: getFlash</code></div>
                                        <pre class="pre-code">
    $notice->getFlash(key); 
                                        </pre>
                                    </div>
                                </div>          
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: setFlash</code></div>
                                        <pre class="pre-code">
    $notice->setFlash('greeting', 'Welcome to our site')

    $message = $notice->getFlash('greeting');  

    var_dump( $message ); <span class="comment no-select">// Welcome to our site</span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: setFlash (Real Application)</code></div>
                                        <pre class="pre-code">
    <div class="pxv-10 bc-off-white c-green"> <code>url1 - insert</code> </div>
                    
    $db = (new DB())->openDB(); <span>open a database class.</span>

    $db->insert_into('users', ['username' => 'foo']);

    if( $db->insert() ){

        $notice->setFlash('notice', 'message stored successfully');
        redirect('display');

    }
    <div class="pxv-10 bc-off-white c-green"> <code>url2 - display</code> </div>

    if($notice->hasFlash('notice')){
        
        echo $notice->getFlash('notice');

    } else {

        echo redirect('insert');

    }

    <span class="comment no-select">
    In the above, when a data is successfully stored using <code>setFlash()</code>, it redirects to 
    <code>display</code> url which displays the last message set. If no message is found,  
    then a redirection will be made back to <code>insert</code> url.
    </span>
                                        </pre>
                                    </div>
                                </div>            
                            </div>
                        </div> <br>
                    </div>

                    <div id="flash" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> flash
                                </div>
                            </div> <br>
                            <div class="">
                                Unlike the <code>getFlash</code> method, <code>flash()</code> returns 
                                the value of an existing or non-existing key without throwing an error. 
                                This means that if a key does not exist, a null value is returned instead.
                                .
                                <br><br>
                        
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: flash</code></div>
                                        <pre class="pre-code">
    $hasher->flash(key); 
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: flash</code></div>
                                    <pre class="pre-code">
    $notice->setFlash('text','1234');

    echo $notice->flash('text'); <span class="comment">//returns 1234</span>
    echo $notice->flash('word'); <span class="comment">//returns null</span>
                                    </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div> <br>

                    <div class="font-menu"> 
                        The resource class <code>Res</code> only uses three static relative methods to access 
                        the notice classe. These methods are <code>setFlash()</code> <code>hasFlash</code> and 
                        <code>Res::flash()</code> which resolves similarly to the corresponding notice class methods.
                    </div>
                </div>
            </div>
        </section>

    </div>
    @lay('build.co.coords:footer')


@template;