@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    <div class="start font-em-d8">

                        @lay('build.co.links:tutor_pointer') <br>

                        <div class="font-em-1d5 c-orange">UrlMapper</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="">

                                <div class="">
                                    The <code class="bd-f">Urlmapper</code> class is a simple navigation tool that makes it 
                                    easier to map url links. It separates each section of a link to a clickable link.
                                    The following methods are used to map urls.
                                </div> <br>

                                <ol>
                                    <li> <a href="#setbase" class="c-olive"> setbase </a> </li>
                                    <li> <a href="#map" class="c-olive"> map </a> </li>
                                </ol>
                                
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
    url  : supplied url to be processed

    path : supplied url to be compared

    pointer : navigation pointer or icon (accepts html tags)
    </span>
                                    </pre>
                                </div>
                            </div>

                                </div>
                            </div> 
                        </div> <br>

                        <div id="initialize" class="">
                            <div class="">
                                <div class="fb-6 flex-full rad-4 pvs-8">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-lightning-fill"></span>
                                        </span> Initializing Urlmapper class
                                    </div>
                                </div>

                                <div class="">
                                    The UrlMapper tool can be easily initialized as shown below.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Sample: Initializing Input</div>
                                            <pre class="pre-code">
  $url  = new UrlMapper;
                                            </pre>
                                        </div>
                                        </div>
                                </div>
                            </div>
                        </div>    
                        
                        <div class="foot-note">
                            This class has only two methods which are <code>setbase()</code> and <code>map()</code>. 
                            These are explained below: 
                        </div>

                        <div id="map" class="">
                            <div class="">
                                <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> map
                                    </div>
                                </div>
                                <div class="">
                                The <code>map()</code> method is used to map urls. It divides each section of a url link 
                                to a clickable link.
                                <br><br>

                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Syntax</div>
                                            <pre class="pre-code">
  $url->map($url, $pointer); 

  <span class="comment">
    where: 

    $url: url to be sectionalized 

    $pointer: navigation pointer 
  </span>
                                            </pre>
                                        </div>
                                    </div> <br>  

                                    <div class="pre-area mvt-10">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white">Example 1</div>
                                            <pre class="pre-code">
  $mapped = $url->map('index/user', '&lt;span class="bi-chevron-right"&gt;&lt;/span&gt;');

  var_dump($mapped);
                                            </pre>
                                        </div>
                                    </div> <br>
                                    <div class="foot-note">The above returns a string similar to the html below:</div>
                                    
                                    <div class="pre-area mvt-10">
                                        <div class="box-full">
                                            <pre class="pre-code">
    <span class="c-brown">
  &lt;a href="index"&gt;index&lt;/a&gt; 

  &lt;span class="bi-chevron-right"&gt;&lt;/span&gt; 

  &lt;a href="index/user"&gt;user&lt;/a&gt;
    </span>
                                            </pre>
                                        </div>
                                    </div>

                                    <div class="foot-note">
                                        According to the html structure above, each part of the supplied url is 
                                        converted to a link which is a reflection of its parent or root link. Notice that 
                                        the first link generated was <code>index</code> while the final url of the last link 
                                        generated is <code>index/user</code>. The icon supplied as pointer is also
                                        used as the resolved links separator. Using the <code>bootstrap</code> 
                                        library, the link will finally resemble the format below on web pages
                                    </div>
                            
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <pre class="pre-code">
  index <span class="bi-chevron-right"></span> user 
                                            </pre>
                                        </div>
                                    </div>
                                    <div class="foot-note">
                                        Any string can be used as the navigation pointer of the urls as it is not necessary to 
                                        use an icon. It could as well be a text or an image.
                                    </div>
                                </div>
                            </div>
                        </div> <br>

                        <div id="setbase" class="">
                            <div class="">
                                <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv c-orange-dd"> 
                                        <span class="mxr-8">
                                            <span class="bi-circle-fill"></span>
                                        </span> setbase
                                    </div>
                                </div>
                                <div class="">
                                    The <code class="bd-f">setbase()</code> method is used to apply a prefix to generated urls. 
                                    When defined, the value supplied will be added at the beginning of all generated url.
                                </div>
                            </div> <br>
                                
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example</div>
                                    <pre class="pre-code">
   $url->setbase('http::/localhost/app'); <span class="comment">// supplies a prefix to all mapped urls</span>
   
   $mapped = $url->map('index/user', '&lt;span class="bi-chevron-right"&gt;&lt;/span&gt;');

   var_dump($mapped);
                                    </pre>
                                </div>
                            </div>

                            <div class="foot-note">
                                The html string returned above will resemble the format below:
                            </div>
                                    
                            <div class="pre-area mvt-10">
                                <div class="box-full">
                                    <pre class="pre-code">
    <span class="c-brown">
  &lt;a href="http://localhost/app/index"&gt;index&lt;/a&gt; 

  &lt;span class="bi-chevron-right"&gt;&lt;/span&gt; 

  &lt;a href="http://localhost/app/index/user"&gt;user&lt;/a&gt;
    </span>
                                    </pre>
                                </div>
                            </div>   
                            
                            <div class="foot-note">
                                In the above response html format, notice that the supplied base prefix was added to the 
                                url supplied. The <code>Window</code> root class has a built-in static method <code>map()</code> for mapping urls. The window class 
                                handles the <code>setbase()</code> part of the <code class="bd-f">Urlmapper</code> class and just applying the 
                                directive <code>self::map()</code> urls can be easily mapped. This provides an easy navigation system.
                            </div>
                        
                        </div> <br>


                        <div>
                        </div> <br>
                        
                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;