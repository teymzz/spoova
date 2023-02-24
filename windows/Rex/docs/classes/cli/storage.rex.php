@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
          <section class="pxv-20 tutorial bc-white">
              <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Storage</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        In certain situations when working with cli, there are instances in which a text can 
                                        be displayed multiple times or a set of validations occuring multiple times. Writing 
                                        codes which are recurring multiple times can be a great issue and waste of time which is 
                                        against one of the major reasons spoova was developed. In other to lessen this burden,  
                                        the Cli makes it possible for us to store recurring functions with a name which can later 
                                        be called. The storage and recall of values is handled by the <code>Cli::save()</code> 
                                        and <code>Cli::fn()</code> methods.
                                    </p>

                                </div>

                                <div id="save">

                                  <div class="font-em-1d2 c-orange-d">Cli::save()</div>
                                  <div class="">
                                    This method is used to <code>save</code> values that are expected to be used later. These values 
                                    can be strings, integers or closure functions. Naturally, every value to be saved must be saved with 
                                    a unique id, usually integer. Then the id can then be called later.
                                  </div> <br>

                                  <div class="pre-area">
                                    <div class="pxv-10 bc-silver">
                                      Syntax: Cli::save()
                                    </div>
                                    <pre class="pre-code">
  Cli::save($id, $value);
    <span class="comment">
    where: 

      $id    : a unique id to store value
      $value : a value desired to be stored
    </span>
                                    </pre>
                                  </div>

                                </div> <br><br>

                                <div id="fn">

                                  <div class="font-em-1d2 c-orange-d">Cli::fn()</div>
                                  <div class="">
                                    This method is used to recall a saved value by calling its previous storage id.
                                  </div>

                                  <div class="pre-area">
                                    <div class="pxv-10 bc-silver">
                                      Syntax: Cli::fn()
                                    </div>
                                    <pre class="pre-code">
  Cli::fn($id);
    <span class="comment">
    where: 

      $id : storage id of saved value.
    </span>
                                    </pre>
                                  </div>

                                </div> <br>

                                <div class="examples">


                                  <div class="pre-area">
                                    <div class="pxv-10 bc-silver">
                                      Example 1: storing and calling a closure function
                                    </div>
                                    <pre class="pre-code">
  Cli::save(1, fn() => Cli::textView('my function 1') );
  
  Cli::fn(1); <span class="comment">//prints "my function 1"</span>
                                    </pre>
                                  </div> <br><br>

                                  <div class="pre-area">
                                    <div class="pxv-10 bc-silver">
                                      Example 1: storing with an initial execution
                                    </div>
                                    <pre class="pre-code">
  Cli::save(1, function(){
    
      Cli::textView('my function 1');
    
    }, true 
  );
  
  Cli::fn(1);
                                    </pre>
                                  </div> 
                                  
                                  <div class="foot-note pvs-10">
                                    In the code above, because a third argument of true was supplied, 
                                    the <code>save</code> method will first execute the closure function once before 
                                    storing it. This means that the function will be executed twice, since the <code>Cli::fn()</code> 
                                    was also used.
                                  </div>

                                  <br><br>


                                
                                </div>

                            </div> 
                        </div>  
                        
                    @lay('build.co.links:tutor_pointer')

                    </div>
              </div>
          </section>
        </div>

    @lay('build.co.coords:footer')

@template;