@template('template.t-tut')

   @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> 
                          <div class="px-80 bd-2 in-flex mid"> 2.0+ </div>  Resource class 
                        </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10">
    
                            <div class="bi"> <span class="bi-circle"></span> Resource urls (&lt; 2.0) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1">

                            <div>
                            The resource class already makes it possible to group static urls into specified group names through the <code>Res::name()</code> method just as  
                            shown below: <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')
        ->url('some_css_url_2.css')
        ->url('some_js_url.js')

      ->name('footers')
        ->url('some_css_url_1.css')
        ->url('some_css_url_2.css')
        ->url('some_js_url.js')
        
      ->urlClose();

    </pre>
                                </div>

                                <div class="foot-note">
                                  Once the group names are defined, we can then go on to import the groups into the 
                                  template file with the defined group names using the <code>@(@res())@</code> directive 
                                </div>

                                <div class="pre-area bc-white pxs-10 mvs-10">
    <pre class="pre-code">
@(@res(':header'))@ <span class="comment">//import all declared header urls</span>
    </pre>
                                </div> <br>

                                <div class="foot-note">
                                  We can also use the <code>&lt;?= Res::import() ?&gt;</code> method similarly outside the template file. Only the urls in 
                                  the called group will be imported to the webpage rather than having to call them one after the other in multiple files. 
                                  While this is easy to use, one major issue could be that if we need a url from another group into a new group, we need to set the group name and url again. 
                                  If we happen to use the same url in multiple groups and the list is long, it may be difficult to manage a url 
                                  multiple times especially if we have to change the path of a file. In order to resolve this issue, version 2.0 provides new methods which helps to properly name urls 
                                  making it easier to manage all urls as deemed fit.
                                </div>
                                
                                <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10">
    
                            <div class="bi"> <span class="bi-circle"></span> Resource urls (2.0+)</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1">

                            <div>
                                In version 2.0, each url can be given a unique name that makes it easier to call it as a group 
                                or as an single file. <br><br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1') <span class="comment">//set unique name</span>
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')

      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        
      ->urlClose();

    </pre>
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
@(@recall('css1', 'css2', 'js2'))@ <span class="comment">//call files by unique name</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  In route files, we can also use the <code>Res::recall()</code> method or the <code>recall()</code> helper function to achieve a similar response. While 
                                  the <code>recall()</code> function is similar to <code>@(@recall())@</code> directive, the <code>Res::recall()</code> 
                                  is slightly different as it can only call a single unique name at a time. 
                                  
                                 </div> <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;?php

Res::recall('css1'); <span class="comment">//calling unique name returns a script or list of scripts</span>
Res::recall('css1', true); <span class="comment">//calling unique name returns an array of scripts</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  The second line above is useful in helping to know the number of scripts existing in a single unique group. This is not possible in the first line because it 
                                  returns a string rather than an array. In cases where multiple unique names are required, then the helper function <code>recall()</code> makes this operation easier. 
                                  However, since the files are used within template files, the directive <code>@(@recall())@</code> or <code>@(@load())@</code> will at most times be used. The introduction of these 
                                  approaches even makes it easier to generate groups using defined names rather than their real path. 
                                </div> <br>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1')
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')

      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        
      ->bind('cssgroup', ['css1','css2'])
      ->bind('jsgroup', ['js1','js2'])
        
      ->urlClose();
    </pre>
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
@(@recall('cssgroup'))@ <span class="comment">//each script of specified group will be returned to the webpage.</span>
    </pre>
                                </div>

                                <div class="foot-note">
                                  In the example above, new groups were created using the uniquely specified names of 
                                  the stored file urls. Once the group is created with its unique name, then name can then be 
                                  used in the template files. It is essential to know that the <code>bind()</code> method's group name supplied as 
                                  the first argument must be unique name. The resource methods <code>named()</code>, <code>bind()</code> and 
                                  <code>bindTo()</code> all share the same unique storage space. This means that any name supplied in any of these 
                                  methods cannot be unique in another method of the same group although, the <code>bindTo()</code> method is slightly 
                                  different. This is shown below:
                                </div>

                                <div class="pre-area bc-white pxs-10">
    <pre class="pre-code">
&lt;php? 

Res::new() 

      ->name('headers')
        ->url('some_css_url_1.css')->named('css1')
        ->url('some_css_url_2.css')->named('css2')
        ->url('some_js_url.js')->named('js1')
        ->bindTo('headers')
        
      ->name('footers')
        ->url('js_url_1.js')
        ->url('js_url_2.css')->named('js2')
        ->bindTo('footers')
        ->bindTo('headers', ['js2'])  

      ->bind('cssgroup', ['css1','css2'])
      ->bind('jsgroup', ['js1','js2'])
        
      ->urlClose();
    </pre>
                                </div>

                                <div class="foot-note">
                                  The example above explains how the <code>bindTo()</code> method works. The code structure is explained below: <br>
                                  <br> 
                                  <ul>
                                    <li>When <code>bindTo()</code> is used immediately after a set of named urls, it binds 
                                      only the previously named urls into a new unique group. The new unique group name
                                      has nothing to do with the one defined through the global <code>name()</code>. For example, the <code>bindTo('headers')</code> will 
                                      add all the previously named urls into the supplied unique name <code>"headers"</code> while in the case of 
                                      <code>bindTo('footers')</code> only the named url <code>"js2"</code> will be added to the new unique group name.
                                    </li><br>
                                    <li class="">
                                      The method supports adding more files to a previously declared group, however, two arguments must be supplied. 
                                      The first argument is the existing unique name while the second argument is the array containing unique names of urls to be added to 
                                      the group. For example, in the above <code>bindTo('headers', ['js2'])</code> adds the url of <code>"js2"</code> to existing unique 
                                      group <code>"headers"</code>
                                    </li><br>
                                    <li class="">
                                      When <code>bindTo()</code> is used, all named urls before it will be added into the new group regardless of their parent groups. 
                                      Once the method is used, the previous named groups will be safely exited without affecting their unique names.
                                    </li>
                                  </ul>
                                </div>

                                <br><br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="">
                      <div class="c-orange"> <span class="bi-lightbulb"></span> Notice </div>
                      <div class="">
                        <ul class="pxl-20">
                          <li>
                            The custom global urls are stored and loaded from the <code>res/res.php</code> file.
                            The main static files declaration have been moved to a more private directory <code>core/res.php</code> to remove visual noise.
                          </li>  
                          <li>
                            While the names <code class="bd-f">"headers"</code> and <code class="bd-f">"footers"</code> are reserved, more urls can be 
                            added into them. This can be done by either using <code>bindTo()</code> for unique names or by using the <code>name()</code> 
                            method for global namespace.
                          </li>  
                          <li>
                            Methods that shares unique name space cannot redefine a unique name. These methods are <code>named()</code>, <code>bind()</code> and <code>bindTo()</code>. The <code>bindTo()</code> can only 
                            add more urls, it cannot redeclare an existing name unless the entire class is started on a strict mode using the <code>urlOpen(true)</code> method which entirely clears all previous declarations. 
                          </li>  
                          <li>
                            When a non-existing unique name is called, an empty string is returned. However, if a unique name is redeclared, 
                            an error is thrown.                        
                          </li>  
                        </ul>
                      </div>
                    </div>
                </div>
           </div>
       </section>
   </div>

@template;