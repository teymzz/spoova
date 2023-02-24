
@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial mails bc-white">
            <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Meta</div> <br>  
                
                <div class="helper-classes">
                    <div class="fb-6">Introduction</div> <br>
                    <div class="">

                    <div class="">
                        The meta class is created to handle meta tags. The attributes and 
                        values of these tags are supplied and then rendered. The following are the 
                        available methods and their descriptions
                    </div> <br>

                        <ul class="c-sky-blue-dd">
                            <li> <a href="#charset" data-scroll-hash="" data-minus="10"> charset </a> </li>
                            <li> <a href="#add" data-scroll-hash="" data-minus="10"> add </a> </li>
                            <li> <a href="#name" data-scroll-hash="" data-minus="10"> name </a> </li>
                            <li> <a href="#prop" data-scroll-hash="" data-minus="10"> prop </a> </li>
                            <li> <a href="#equiv" data-scroll-hash="" data-minus="10"> equiv </a> </li>
                            <li> <a href="#refresh" data-scroll-hash="" data-minus="10"> refresh </a> </li>
                            <li> <a href="#og" data-scroll-hash="" data-minus="10"> og </a> </li>
                            <li> <a href="#link" data-scroll-hash="" data-minus="10"> link </a> </li>
                            <li> <a href="#drop" data-scroll-hash="" data-minus="10"> drop </a> </li>
                            <li> <a href="#export" data-scroll-hash="" data-minus="10"> export </a> </li>
                            <li> <a href="#dump" data-scroll-hash="" data-minus="10"> dump </a> </li>
                        </ul>
                        
                    </div> 
                </div>

                <div id="meta">
                    The <code>Meta</code> class can be initialized by defining the meta charset type. <code>new Meta('UTF-8')</code> will 
                    declare a new <code>UTF-8</code> meta tag. However, this can also be done using the 
                    <code>charset()</code> method. The following are lists of available methods in the meta class.
                </div> <br>

                <div id="charset" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">1.</span>
                                </span> Charset
                            </div>
                        </div> <br>
                        <div class="">
                        This method is used to set the charset of meta tags. Example is shown below: <br><br>
                        
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Sample: setting charset</code></div>
                                <pre class="pre-code">
  $meta  = new Meta();
  
  $meta->charset('UTF-8'); <span class="comment"> // set meta charset</span>
                                </pre>
                            </div>
                        </div>

                        </div>
                    </div> <br><br>
                </div>

                <div id="add" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">2.</span>
                                </span> Add
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>add</code> method is used to add attributes to meta tags.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding attributes</code></div>
                                    <pre class="pre-code">
  $meta->add(name, content, type); 
<span class="comment"> 
    where: 

    name    : the name, property or http-equiv attribute value of meta tags 
    content : the content attribute of meta tags 
    type    : the type of meta tag. Options - [name|property|http-equiv]
                default type is name.
</span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding attributes</code></div>
                                    <pre class="pre-code">
  $meta->add('viewport', 'width=device-width, initial-scale=1.0');
  
  $meta->add('robots', 'noindex, nofollow');
  
  $meta->add('description','150 words');
  
  $meta->add('og:type', 'game.achievement', 'property');
  
  $meta->add('Pragma', 'no-cache', 'http-equiv');
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Examples above respectfully translates:</code></div>
    <pre class="pre-code">
  <span class="comment no-select">&#60;meta name="viewport" content="width=device-width, initial-scale=1.0"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="robots" content="noindex, nofollow"/&#62</span>
  
  <span class="comment no-select">&#60;meta name="description" content="150 words"/&#62</span>
  
  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
  
  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="name" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">3.</span>
                                </span> name
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>name</code>  method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding property tags</code></div>
                                    <pre class="pre-code">
  $meta->name(name, content); 
  <span class="comment"> 
    where: 

    name : the name attribute value of meta tag
    content  : the content attribute value of meta tag
  </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                <div class="pxv-6 bc-off-white"><code>Example: adding named meta tags</code></div>
    <pre class="pre-code">
  $meta->name('description', '150 words');  
  
  <span class="comment no-select">//translates as:  &#60;meta name="description" content="150 words"/&#62</span>
    </pre>
                                </div>
                            </div>

                        </div>
                    </div> <br>
                </div>

                <div id="prop" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">4.</span>
                                </span> Prop
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>prop</code> method is a shorthand for the meta tags with the attribute of property.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding property tags</code></div>
                                    <pre class="pre-code">
  $meta->prop(property, content); 
<span class="comment"> 
    where: 

    property : the property attribute value of meta tag
    content  : the content attribute value of meta tag
</span>
                                    </pre>
                                </div>
                            </div>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding property meta tags</code></div>
                                    <pre class="pre-code">
  $meta->prop('og:type', 'game.achievement');  
    <span class="comment no-select">
  // translates as:  &#60;meta property="og:type" content="game.achievement"/&#62
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="equiv" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">5.</span>
                                </span> http-equiv
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>equiv</code>  method is a shorthand for the meta tags with the attribute of http-equiv.
                            Example is shown below: <br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding http-equiv to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->equiv(http-equiv, content); 
    <span class="comment"> 
        where: 

        http-equiv : the http-equiv attribute value of meta tag
        content  : the content attribute value of meta tag
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding http-equiv meta tags</code></div>
                                    <pre class="pre-code">
  $meta->equiv('Pragma', 'no-cache',);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="Pragma" content="no-cache"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>
                
                <div id="refresh" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">6.</span>
                                </span> refresh
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>refresh</code>  method is a shorthand for the meta tags with the attribute of 
                            <code>http-equiv="refresh"</code>. Example is shown below:<br><br>
                        
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding http-equiv to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->refresh(time); 
    <span class="comment"> 
        where: 

        time : time in seconds
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding refresh to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->refresh(30);  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta http-equiv="refresh" content="30"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="og" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">7.</span>
                                </span> og
                            </div>
                        </div> <br>

                        <div class="">
                            The <code>og</code> method is a shorthand for the meta tags with the attribute of 
                            <code>property="og:"</code>.
                            Example is shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding og to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->og(type, content); 
    <span class="comment"> 
        where: 

        type : og type.
        content : content atttribute of og meta tags.
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding og property to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->og('type', 'game.achievement');  
    <span class="comment no-select">
  //translates as:  <span class="comment no-select">&#60;meta property="og:type" content="game.achievement"/&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="link" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">8.</span>
                                </span> link
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>link</code> method is used to add properties <code>link</code> meta tags. 
                            Examples are shown below: <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: adding og to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->link(rel, href, attrs); 
    <span class="comment"> 
        where: 

        rel : relativity attribute of link tag.
        href : href atttribute of link tags.
        attrs: other attributes of link tag
    </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: adding og property to meta tags</code></div>
                                    <pre class="pre-code">
  $meta->link('icon', 'https://somesite.com/icon.png",['type' => 'image/png']);  
    <span class="comment no-select">
    // <span class="comment no-select">&#60;link rel="icon" href="https://somesite.com/icon.png" type="image/png" /&#62</span>
    </span>
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="drop" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">9.</span>
                                </span> drop
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>drop()</code> method removes all stored meta definitions from storage list.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: clearing definitions</code></div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  $meta->drop(); <span class="comment">// clear previous descriptions</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="dump" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">10.</span>
                                </span> dump
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>dump()</code> method removes all stored meta definitions from storage list.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: clearing definitions</code></div>
                                    <pre class="pre-code">
  $meta->add('description', '150 words'); 

  var_dump($meta->dump()); <span class="comment">// outputs predefined meta tags</span> 
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                </div>

                <div id="sample" class="">
                    <div class="">
                        <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                <span class=" mxr-8 c-lime-dd">
                                    <span class="numb-box">11.</span>
                                </span> sample
                            </div>
                        </div> <br>
                        <div class="">
                            The <code>sample()</code> method returns an array of meta tag samples. This data 
                            was compiled from across different source on the internet.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: get samples of meta tags</code></div>
                                    <pre class="pre-code">
  var_dump( $meta->sample() ); <span class="comment">// outputs array of meta tag sample attributes</span> 
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