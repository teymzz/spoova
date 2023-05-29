@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Notice</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                        <div class="">
                            The <code class="bd-f">Notice</code> class is used to set flash messages or notifications. 
                            These messages are displayed once and then removed after display. Available  
                            methods are:
                        </div> <br>

                            <ul>
                                <li> <a href="#setFlash" class="c-olive ch-olive-dd"> setFlash </a> </li>
                                <li> <a href="#getFlash" class="c-olive ch-olive-dd"> getFlash </a> </li>
                                <li> <a href="#hasFlash" class="c-olive ch-olive-dd"> hasFlash </a> </li>
                                <li> <a href="#flash" class="c-olive ch-olive-dd"> flash </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  


                    <div id="keywords" class="">
                        <div class="">
                            <div class="">
                                The following keywords should be noted:
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">keywords</div>
                                        <pre class="pre-code">
                                            <span class="comment">
  key : a unique id string for a notice
  message : a string of text stored for displayed
                                            </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>    

                    <div id="initialize" class="">
                        <div class="">
                            <div class="fb-6 flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> Initializing Notice class
                                </div>
                            </div>

                            <div class="">
                                The notice class can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Sample: Initializing Hasher</div>
                                        <pre class="pre-code">
  $notice  = new Notice;
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>
    

                    <div id="hasFlash" class="">
                        <div class="">
                            <div class="fb-6 flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> hasFlash
                                </div>
                            </div>
                            <div class="">
                            This method is used to a check if a flash 
                            key exists.
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: hasFlash</div>
                                    <pre class="pre-code">
  $notice->hasFlash(key); <span class="comment">// returns true or false</span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: checking flash</div>
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
                            <div class="fb-6 flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> getFlash
                                </div>
                            </div>

                            <div class="">
                                This method is used to fetch a previously defined flash key. 
                                It throws an error if the flash key supplied does not exist.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: getFlash</div>
                                        <pre class="pre-code">
  $notice->getFlash(key); 
                                        </pre>
                                    </div>
                                </div> <br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: setFlash</div>
                                        <pre class="pre-code">
  $notice->setFlash('greeting', 'Welcome to our site')

  $message = $notice->getFlash('greeting');  

  var_dump( $message ); <span class="comment no-select">// Welcome to our site</span>
                                        </pre>
                                    </div>
                                </div> <br>

                                <div class="pre-area mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-10 bc-off-white">Example: setFlash (Real Application)</div>
                                        <pre class="pre-code">
  $db = (new DB())->openDB(); <span class="comment">//open a database class.</span>

  $db->insert_into('users', ['username' => 'foo']);

  if( $db->insert() ){

      $notice->setFlash('notice', 'message stored successfully');
      redirect('display');

  }
    <div class="pxv-10 bc-off-white c-grey"> Check flash in display page </div>

  if($notice->hasFlash('notice')){
    
      echo $notice->getFlash('notice');

  } else {

      echo redirect('insert');

  }

                                        </pre>
                                    </div>
                                </div> 
                                <div class="foot-note">

    <span class="">
  In the above, when a data is successfully stored using <b>setFlash()</b>, it redirects to 
  <b>"display"</b> url which displays the last message set. If no message is found,  
  then a redirection will be made back to the <b>"insert"</b> page.
    </span>                                    
                                </div>           
                            </div>
                        </div> <br>
                    </div>

                    <div id="flash" class="">
                        <div class="">
                        <div class="fb-6 flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> flash
                                </div>
                            </div>
                            <div class="">
                                Unlike the <code class="bd-f">getFlash()</code> method, <code class="bd-f">flash()</code> returns 
                                the value of an existing or non-existing key without throwing an error. 
                                This means that if a key does not exist, a null value is returned instead.
                                .
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: flash</div>
                                    <pre class="pre-code">
  $notice->setFlash('text','1234');

  echo $notice->flash('text'); <span class="comment">//returns 1234</span>
  echo $notice->flash('word'); <span class="comment">//returns null</span>
                                    </pre>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="foot-note"> 
                        The Resource class <code>Res</code> only has three static relative methods to access 
                        the notice class. These methods are <code>Res::setFlash()</code> <code>Res::hasFlash()</code> and 
                        <code>Res::flash()</code> which resolves similarly to the corresponding notice class methods.
                    </div>
                </div>
            </div>
        </section>

    </div>
    @lay('build.co.coords:footer')


@template;