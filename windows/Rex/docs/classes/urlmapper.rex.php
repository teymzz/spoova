@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-20 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">UrlMapper</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                            <div class="">
                                The <code>urlmapper</code> class is a simple navigation tool that makes it 
                                easier to map url links. It separates each section of a link to a clickable link.
                                The following methods are used to map urls.
                            </div> <br>

                                <ol>
                                    <li> <a href="#setbase"> setbase </a> </li>
                                    <li> <a href="#map"> map </a> </li>
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
                                    The UrlMapper tool can be easily initialized as shown below.
                                    <br><br>
                                
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
                                            <pre class="pre-code">
    $url  = new UrlMapper;
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
    url  : supplied url to be processed

    path : supplied url to be compared

    pointer : navigation pointer or icon (accepts html tags)
    </span>
                                    </pre>
                                </div>
                            </div>

                                </div>
                            </div> <br><br>
                        </div>        

                        <div id="setbase" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> setbase
                                    </div>
                                </div> <br>
                                <div class="">
                                    The <code>setbase</code> method supplies the prefix of a url.
                                    <br><br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: setbase</code></div>
                                            <pre class="pre-code">
    $url->setbase(url)
                                            </pre>
                                        </div>
                                    </div>
                                </div>
                            </div> <br>
                                
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: setbase</code></div>
                                    <pre class="pre-code">
    $url->setbase('http::/localhost/spoova'); <span class="comment">// supplies a prefix to all mapped urls</span>
                                    </pre>
                                </div>
                            </div>
                        
                        </div> <br>

                        <div id="map" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> map
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>map()</code> method is used to map urls. It divides each section of a url link 
                                to a clickable section while prepending the base url to all mapped urls.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: map</code></div>
                                    <pre class="pre-code">
    $url->map(url, pointer); 
                                    </pre>
                                </div>
                            </div>      

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Examples: map</code></div>
                                    <pre class="pre-code">
    $url->setbase('http://localhost');

    $mapped = $url->map('index/user', '&lt;span class="bi-chevron-right"&gt;&lt;/span&gt;');

    var_dump($mapped);
    <span class="comment">
    <span class="c-teal no-select">// The above returns:</span>

       &lt;a href="http://localhost/index"&gt;index&lt;/a&gt; 

       &lt;span class="bi-chevron-right"&gt;&lt;/span&gt; 

       &lt;a href="http://localhost/index"&gt;user&lt;/a&gt;


    <span class="c-teal no-select">// The above (using bootstrap icons) resolves as:</span>

       index <span class="bi-chevron-right"></span> user   
    </span>
                                    </pre>
                                </div>
                            </div>
                            
                                </div>
                            </div> <br>
                        </div>

                        <div>
                        The window class has a build in static method <code>map</code> for mapping urls. The window class 
                        handles the <code>setbase</code> part of the <code>urlmapper</code> class. By just applying the 
                        directive <code>self::map()</code> urls can be easily mapped. This provides an easy navigation system.
                        </div> <br>
                        
                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;