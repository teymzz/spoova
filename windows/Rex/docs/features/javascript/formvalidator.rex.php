
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Formvalidator</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                    The form validator plugin is a jquery depedent plugin for validating forms. This plugin uses certain html element attributes 
                    to control form responses. This plugin can be used for validating strings, numbers, integers, urls and so on. It is also  
                    capable of sending ajax
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Css Integerations</div>
                    Spoova comes with its own list of simple css utility classes to handle designs such as flex boxes, fluid boxes, grids items, 
                    form classes, borders, paddings, margins, colors and backgrounds and so on. These utility classes are provided as first 
                    hand help to make development faster. Devlopers can learn about more on these utility classes from <a href="@route('::css')">here</a>.
                     
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>In-built Javascript Integerations</div>
                    Javascript integerations ranges from Javascript functions to Javascript plugins, some of which are jquery dependent. Some of the plugins 
                    that comes with this framework are listed below: <br>
                    <ul class="mvt-6 c-olive">
                        <li><a href="@route('::javascript.core-functions')">core functions</a></li>
                        <li><a href="@route('::javascript.loadFile').js">loadFile Plugin</a></li>
                        <li><a href="@route('::javascript.formvalidator').js">formValidator.js</a></li>
                        <li><a href="@route('::javascript.intersect').js">intersect.js</a></li>
                        <li><a href="@route('::javascript.anime').js">anime.js</a></li>
                        <li><a href="@route('::javascript.device').js">device.js</a></li>
                        <li><a href="@route('::javascript.switcher').js">Switcher.js</a></li>
                    </ul> 
                </div>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Integerated Functionalities</div>
                    Integerated functions are activities that are built into the framework which may have their dependencies on external libraries, javascript functions or even css utility classes. 
                    In some cases, a response could depend on all of these dependencies altogether. These integerations sometimes use html attributes to effect their functions. In order to allow 
                    these integerations to work effectively, all core resource header files should be imported. This is done with <code>@(Res(':headers'))@</code> rex template directive. <br><br>
                    
                    <div class="integerated-images">
                        <div class="font-em-d95 c-orange-dd">Integerated Functionalities (images)</div>                        
                        As an added feature, spoova manages lazy-loading of images through javascript along with a specifically 
                        reserved html attribute <code>data-src</code>. If the <code>data-src</code> attribute is added to any html element, then lazy-loading is applied to that element. The 
                        <code>data-src</code> can be applied in this way:
<div class="pre-area shadow shadow-1-strong mvs-4">
    <pre class="pre-code">
  &lt;img data-src="http://site.com/some-image.jpg" &gt;
  
  &lt;div data-src="http://site.com/some-image.jpg" &gt;&lt;/div&gt;
      </pre>
  </div>
  In the above, both the <code>img</code> and <code>div</code> class will be resolved differently into the code below respectively.
  <div class="pre-area shadow shadow-1-strong mvs-4">
      <pre class="pre-code">
  &lt;img src="http://site.com/some-image.jpg" data-src="http://site.com/some-image.jpg" &gt;
  
  &lt;div style="background-image:url('http://site.com/some-image.jpg')" data-src="http://site.com/some-image.jpg"&gt;&lt;/div&gt;
      </pre>
  </div>
From the code above, we can conclude that <code>div</code> elements are assigned a <code>backround-image</code> css property while
<code>img</code> elements are assigned the <code>src</code> attribute. If we are walking within our template files, we can also apply the 
<code>@(domurl())@</code> directive used in mapping static files url.
                    </div><br>
                    
                    <div class="integerated-page-scrolling">

                        <div class="">
                            <div class="font-em-d95 c-orange-dd">Integerated Functionalities (page-scrolling)</div>                        
                            A special feature for managing page scroll is the <code>data-scroll</code> and <code>data-scroll-hash</code> attributes. 
                            These attributes helps to scroll to an element having an id attribute value that matches the supplied value of these attributes. 
                            Since the <code>data-scroll-hash</code> attibute performs both the function of <code>data-scroll</code> and even more extended features, 
                            this attribute alone will be discussed. The only major difference between these two attributes is that <code>data-scroll-hash</code> 
                            works for the current page hash as an extended feature. Other relative attributes that can be applied on these attributes are <code>data-plus</code> 
                            , <code>data-minus</code> which are used for adding or subtracting from target scroll point. There is also the <code>data-delay</code> which set a timeout 
                            before the scroll is executed.
                        </div>

                        <div class="samples">


  <div class="pre-area mvt-10">
  <div class="pxv-10 bc-silver">Example 1: data-scroll-hash</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Button:</span>
  <span class="c-olive">&lt;button data-scroll-hash&gt;click btn&lt;/button&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="someid"&gt;&lt;/div&gt; 
  </pre>

<div class="pxv-10 bc-sea-blue c-white">
In the above, using the test url as current page url. If the button is clicked, the url hash string <code class="c-white">"someid"</code> 
will be obtained. Once this is done, then the page will 
scroll to <code class="c-white">div</code> element because it has a value <code class="c-white">id="someid"</code>
</div>
</div> <br><br>

  <div class="pre-area">
  <div class="pxv-10 bc-silver">Example 2: data-scroll-hash with link</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Button:</span>
  <span class="c-olive">&lt;a href="#newhash" data-scroll-hash&gt;click link&lt;/a&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="newhash"&gt;&lt;/div&gt; 
  </pre>

<div class="pxv-10 bc-sea-blue c-white">
In the above, once the link is clicked, the page url hashstring will change to <code class="c-white">newhash</code>. Once this is done, the new hash 
string will be used as the target id of the element to be scrolled to.
</div>
</div> <br><br>

  <div class="pre-area">
  <div class="pxv-10 bc-silver">Example 3: data-scroll-hash integerations with hashRunner()</div>
  <pre class="pre-code">
  <span class="comment">Test URL:</span>
  https://some-site.com#someid
  
  <span class="comment">Test Link Button:</span>
  <span class="c-olive">&lt;a href="#someid" data-scroll-hash="someid"&gt;click link&lt;/a&gt; 
  
  <span class="comment">Target HTML Element:</span>
  <span class="c-olive">&lt;div id="someid"&gt;&lt;/div&gt; 
  
  <span class="comment">Target Script:</span>
  <span class="c-olive">&lt;script id="someid"&gt;
    
  hashRunner('data-scroll-hash');
  
  &lt;/script&gt; 
  </pre>
  
<div class="pxv-10 bc-sea-blue c-white">
In the above, if the current page url is the test url above, if a user scrolls off from the div element and reloads the page, the <code class="c-white">hashRunner()</code> 
function will re-scroll back to that div element. This might be useful to help a user return back to the target element once the page is reloaded. 
</div>
</div> 

                        </div>                        
                    
                    </div> <br>
                    
                    <div class="integerated-file-loading">

                        <div class="">
                            <div class="font-em-d95 c-orange-dd">Integerated Functionalities (file-loading)</div>                        
                            File-loading attributes are assiged to help handle files which are selected from the <code>&lt;input type="file"&gt;</code> html element. These attributes  
                            allows the validation of files once they have been selected. File loading is not enabled by default. It requires the importation of the <code>loadFile.js</code>
                            plugin. Learn more from <a href="@route('::javascript/loadFile').js" class="hyperlink c-olive">here</a><br> 
                        </div>                  
                    
                    </div> <br>
                
                <div class="integerated-form-validations">

                    <div class="">
                        <div class="font-em-d95 c-orange-dd">Integerated Form Validations</div>                        
                        Javascript form vaildations are handled using specifically reserved attributes. Form vaidations can be applied for strings, texts, numbers, password, certain credit cards, 
                        urls and so on. This plugin is jquery dependent and can be included from the <code>res/res.php</code> file which is automatically imported through the header or footer 
                        files group. Learn more about form validations from <a href="@route('::integerations/form-validations')" class="hyperlink">here</a>  
                    </div>                  
                
                </div> <br>
                    
                    <div class="integerated-navbar">

                        <div class="">
                            <div class="font-em-d95 c-orange-dd">Integerated Functionalities (Animated Navigation Bar)</div>                        
                            Spoova has a few compatiblity for navigation bars. Aside from the fact that it has an in-built php navigation bar contoller system, it also has two variants of navigation 
                            bar support handled by both the css and javascript languages.  
                        </div>                  
                    
                    </div> <br>


                    
                </div>

            </div>

        </div>
    </section>
</div>
@template;