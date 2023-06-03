
@template('template.t-tut')

@lay('build.co.navbars:left-nav')

<style>
     table {
          border-collapse: separate;
          border-spacing: 1em;
     }
</style>

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            <div class="start font-em-d8">

               @lay('build.co.links:tutor_pointer') <br>

                <div class="font-em-1d5 c-orange">Intersect.js</div> <br>
                
                <div class="db-connection">
                    The <code>Intersect()</code> plugin is a class that is dependent upon the <code>IntersectionObserver</code> 
                    native javascript class. The function of this plugin is to make it easier to use the native 
                    IntersectionObserver 
                    with added functionalities. 
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-lightning-fill mxr-6"></span>Initializing plugin</div>
                    The plugin is added as part of the core javascript urls of the application. However, it is not loaded by default. By 
                    using the unique name, we can load the javascript file first before we can have access to the plugin. The <code>intersectJS</code> 
                    is the unique name assigned to this script. Let's include the script below in the head section of our project template file:
                    
                    <div class="pre-area">
                         <pre class="pre-code">
  @(@load('intersectJS'))@
                         </pre>     
                    </div>

                    <div class="foot-note">
                         Once the script is included in our file, we can go on to initialize the <code>Intersect</code> plugin 
                         at the footer of the web page.
                    </div>
                    
                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;script&gt;

     let Intersect = new Intersect;

     console.log(Intersect);

  &lt;/script&gt;
                         </pre>     
                    </div>

                    <div class="foot-note">
                         When we do a <code>console.log()</code> of the plugin, we will 
                         have some returned object that resembles the format below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;script&gt;

  Object {  }

     <span class="c-blue-violet">&lt;prototype&gt;: Object { … }</span>
        <span class="c-sky-blue-dd">constructor</span> class Intersect {}
        <span class="c-sky-blue-dd">observe</span> function observe(el)
        <span class="c-sky-blue-dd">item</span> function item(el)
        <span class="c-sky-blue-dd">onScroll</span> function onScroll(el)
        <span class="c-sky-blue-dd">status</span> function status(el)

  &lt;/script&gt;
                         </pre>     
                    </div>                  
                </div>
                <div class="foot-note">
                    Each of the objects method have their specific functions and these are explained below:
                </div> <br>
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>constructor</div>
                    This is a reference to the object itself which is automatically added when the plugin 
                    is instantiated. It mostly does not provide any more functionality on the plugin
                </div> <br>

                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>observe</div>
                    This method is called when an object is expected to be observed. It takes an object that 
                    contains details of the element to be observed and a callback function. Assumming we have an html 
                    button as shown below: 

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe these two buttons using the <code>observe()</code> method. This is shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     <span class="c-sky-blue-dd">callback</span> : function(entry, observer) {
        console.log(entry);
     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code sample above, the <code>el</code> is used for selecting the buttons to be observed, while the 
                         <code>callback</code> will be triggered once the button is in view. Notice that the class selector <code>.btn</code> 
                          was used to select the buttons above. Once the button is in view, the entry will return that resembles the format below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
    <span class="c-sky-blue-dd">boundingClientRect</span>: DOMRect { x: 12, y: 11.916671752929688, width: 95.19999694824219, … }
    <span class="c-sky-blue-dd">index</span>: 0
    <span class="c-sky-blue-dd">intersectionRatio</span>: 1
    <span class="c-sky-blue-dd">intersectionRect</span>: DOMRect { x: 12, y: 11.916671752929688, width: 95.19999694824219, … }
    <span class="c-sky-blue-dd">intersections</span>: 0
    <span class="c-sky-blue-dd">inview</span>: true
    <span class="c-sky-blue-dd">isIntersecting</span>: true
    <span class="c-sky-blue-dd">selector</span>: ".btn"
    <span class="c-sky-blue-dd">rootBounds</span>: DOMRect { x: 0, y: 0, width: 678.4000244140625, … }
    <span class="c-sky-blue-dd">target</span>: &lt;button class="btn"&gt;
    <span class="c-sky-blue-dd">time</span>: 1188.7
    <span class="c-sky-blue-dd">unobserve</span>: function unobserve()
                         </pre>
                    </div>

                    <div class="foot-note">
                         The object returned above is similar to the entry object returned in an <code>IntersectionObserver</code> API with 
                         only slight differences. Some new keys were returned which are 
                         <code class="bd-f">index</code>, <code class="bd-f">intersections</code>, <code class="bd-f">inview</code>, <code class="bd-f">target</code> and 
                         <code class="bd-f">unobserve()</code>. <br>
                         
                         <div class="bc-white-dd pxv-10 mvt-16">
                              <table class="text-left calibri wid-full">
                                   <tr><th>Keys</th><th>Function</th></tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">index</span></td>
                                        <td>Identifies the count number of a target element is a selected group list</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">intersections</span></td>
                                        <td>Identifies the total number of intersections made by an element</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">inview</span></td>
                                        <td>Alias or alternative for <span class="c-soft-pink-d">isIntersecting</span>.</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">selector</span></td>
                                        <td>Returns the element's query selector (i.e <code>el</code>)</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">target</span></td>
                                        <td>Defines the entry target element.</td>
                                   </tr>
                                   <tr>
                                        <td><span class="c-soft-pink-d">unobserve()</span></td>
                                        <td>Defines the method to unobserve an observed element.</td>
                                   </tr>
                              </table>
                         </div>

                         <div class="foot-note">
                              Once we observe an element, we can easily unobserve it as shown below: 
                         </div>

                         <div class="pre-area">   
                              <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     
     <span class="c-sky-blue-dd">callback</span> : function(entry) {

        if(entry.inview) entry.unobserve()

     }

  })     
                              </pre>
                         </div>

                         <div class="foot-note">
                              With this returned object index, we can even perform more amazing operations like the sample below where 
                              we logged a console message when the second selected button is unobserved.
                         </div>

                         <div class="pre-area">   
                              <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.observe({

     <span class="c-sky-blue-dd">el</span> : ".btn",
     
     <span class="c-sky-blue-dd">callback</span> : function(entry) {

        if(entry.inview && entry.index === 1) {
          entry.unobserve();
          console.log('second button unobserved!')
        }

     }

  })     
                              </pre>
                         </div>
                         <div class="foot-note">
                              Amazingly, the <code class="bd-f">Intersect</code> plugin makes it easier to use the intersection class 
                              for multiple elements just as seen above.
                         </div>
                    </div>

                </div> <br>


                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>onScroll</div>
                    This method is called when an object is expected to be observed through an <code class="bd-f">onScroll</code> 
                    event. Once used, the <code>Intersection</code> will return the status of the selected elements on every scroll. 
                    Although, it is not ideal to use <code class="bd-f">onScroll</code> events on items but it can be helpful in some 
                    cases. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe through the <code>onScroll()</code> method as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.onScroll({

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log(`button ${entry.index + 1} is in intersecting`)
               entry.unobserve()
          }else{
               console.log('scrolling...')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code sample above, notice that we used the <code>unobserve()</code> method when the 
                         element is finally intersecting. This does not stop the scroll event from happening. Once the 
                         <code>unobserve()</code> is called, internally, the element will no longer be observed and this will 
                         make the <code>unobserved()</code> method return true. In order to truly end the scroll event, 
                         we can use the <code>item()</code> method instead or set the <code>status()</code> method's 
                         <code class="bd-f">onScroll</code> key as <code class="bd-f">"scroll-item"</code>.
                    </div>

                </div> <br>


                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>status</div>
                    This method is called when the status of an element is needed to be retrieved. Although, 
                    it can use the <code>onScroll</code> event, by default, the element status is only returned 
                    when the observed element is intersecting. When the <code>onScroll</code> key is set as 
                    <code class="bd-f">"scroll"</code> or <code class="bd-f">"scroll-item"</code>, the <code>onScroll</code> 
                    event will be triggered. The only difference between these two options is that while <code class="bd-f">"scroll"</code> 
                    does not truly stop a scroll event until the last observed element is unobserved, the <code class="bd-f">scroll-item</code> option truly removes the 
                    scroll event and is used on a single element. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         Using the <code>status</code> method, we can obtain the status of an element as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : "intersect",

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log(entry)
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  <span class="comment">Object {</span>    
     
     <span class="c-sky-blue-dd">boundingClientRect</span>: DOMRect { x: 12, y: -3309.833251953125, width: 95.19999694824219, … }
     
     <span class="c-sky-blue-dd">element</span>: <span class="comment">{</span>
       <span class="c-sky-blue-dd">aboveWindowTop</span> true
       <span class="c-sky-blue-dd">belowWindowTop</span> false
       <span class="c-sky-blue-dd">fromWindowTop</span> -3309
       <span class="c-sky-blue-dd">index</span> 0
       <span class="c-sky-blue-dd">id</span> ""
       <span class="c-sky-blue-dd">isIntersecting</span> false
       <span class="c-sky-blue-dd">selector</span> ".btn"
       <span class="c-sky-blue-dd">zeroDownwards</span> true
       <span class="c-sky-blue-dd">zeroPoint</span> false
       <span class="c-sky-blue-dd">zeroUpwards</span> false          
     <span class="comment">}</span>,
     
     <span class="c-sky-blue-dd">id</span>: ""
     <span class="c-sky-blue-dd">index</span>: 0
     <span class="c-sky-blue-dd">intersectionRatio</span>: 0
     <span class="c-sky-blue-dd">intersectionRect</span>: DOMRect { x: 0, y: 0, width: 0, … }
     <span class="c-sky-blue-dd">intersections</span>: 0
     <span class="c-sky-blue-dd">inview</span>: false
     <span class="c-sky-blue-dd">isIntersecting</span>: false
     <span class="c-sky-blue-dd">selector</span>: ".btn"
     <span class="c-sky-blue-dd">rootBounds</span>: DOMRect { x: 0, y: 0, width: 678.4000244140625, … }
     <span class="c-sky-blue-dd">selector</span>: ".btn"
     <span class="c-sky-blue-dd">scrollPoint</span>: 4083.88330078125
     <span class="c-sky-blue-dd">target</span>: &lt;button class="btn"&gt;
     <span class="c-sky-blue-dd">time</span>: 566.8
     <span class="c-sky-blue-dd">unobserve</span>: function unobserve()
     <span class="c-sky-blue-dd">unobserved</span>: function unobserved()
  <span class="comment">}</span>
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the sample above the <code class="bd-f">"onScroll"</code> key is set as <code class="bd-f">intersect</code>. 
                         Which is the default option. This ensures that the status of the element is only returned once it is intersecting. 
                         This also means that this default option does not use the scroll event rather it uses only the intersection observer. 
                         Notice that in the code sample above some new keys were added. These keys include the 
                         <code class="bd-f">element</code>, <code class="bd-f">scrollPoint</code>, <code class="bd-f">unobserved()</code>. The 
                         <code class="bd-f">scrollPoint</code> usually returns the current position of the element 
                         observed, while the <code class="bd-f">element</code> key contains futher information about the target element which are 
                         listed and explained in the table below:
                    </div>

                         
                    <div class="bc-white-dd pxv-10 mvt-16 foot-note">
                         <table class="text-left calibri wid-full">
                              <tr><th>Keys</th><th>Function</th></tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">aboveWindowTop</span></td>
                                   <td>Returns true when the element is entirely above the browsers top and not in view</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">belowWindowTop</span></td>
                                   <td>Returns true when at least a part of the element is in below the top browser's screen</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">fromWindowTop</span></td>
                                   <td>Returns the distance of the element from the window's top screen.</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">isIntersecting</span></td>
                                   <td>Returns true when the target element is intersecting</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroDownwards</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero or lower</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroPoint</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero</td>
                              </tr>
                              <tr>
                                   <td><span class="c-soft-pink-d">zeroUpwards</span></td>
                                   <td>Returns true when the target element's current position from the top window is at zero or above</td>
                              </tr>
                         </table>
                    </div>

                    <div class="foot-note">
                         The <code class="bd-f">unobserved()</code> method is only useful on scroll event when the <code>onScroll</code> 
                         key's option is set as <code class="bd-f">"scroll"</code>.
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : 'scroll'

     <span class="c-sky-blue-dd">el</span> : ".btn",

     callback : function(entry) {
        
          if(entry.inview) {
               <span class="comment">//code block 1</span>
               entry.unobserve()
               console.log('element unobserved!')
          }elseif(entry.unobserved()){
               <span class="comment">//code block 2</span>
               console.log('element has been unobserved!')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the code above, the "code block 1" will continue to run until the element is unobserved. 
                         Once the element is unobserved, since the element is a scroll event, the "code block 2" will 
                         be triggered an continue to run. The <code class="bd-f">scroll</code> option is equivalent to the 
                         <code>onScroll()</code> method discussed earlier. It is important to note that as long as there 
                         is still at least one element observed, the scroll event will run internally. Once the last element is 
                         unobserved, the scroll element will be removed. Another equivalent option to use is the <code>srcoll-item</code> 
                         which is only used on a single element. The element will be observed and once it is unobserved, the 
                         scroll event will be removed.
                    </div>

                    <div class="pre-area ">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.status({

     <span class="c-sky-blue-dd">onScroll</span> : 'scroll-item'

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               entry.unobserve()
               console.log('element unobserved and scroll event detached!')
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         In the above, notice that when the option <code class="bd-f">"scroll-item"</code> is used, 
                         the <code>entry.unobserved()</code> is no longer used. This is because once the scroll 
                         event is detached, we can no longer detect if the element has been unobserved. Also, although 
                         we are using a class selector, only one element can be selected. If the number of selected elements returned 
                         is more than one, the <code class="bd-f">Intersection</code> object will return an error.
                    </div>

                </div> <br>

                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill mxr-6"></span>item</div>
                    This method is the same as when the option <code class="bd-f">"scroll-item"</code> is used within the  
                    root <code>status()</code> method. <br><br>

                    <div class="pre-area">
                         <pre class="pre-code">
  &lt;button class="btn"&gt;cancel&lt;/button&gt;
  &lt;button class="btn"&gt;submit&lt;/button&gt;
                         </pre>
                    </div>

                    <div class="foot-note">
                         We can easily observe through the <code>onScroll()</code> method as shown below:
                    </div>

                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect;

  Intersect.item({

     <span class="c-sky-blue-dd">el</span> : ".btn",

     <span class="c-sky-blue-dd">callback</span> : function(entry) {
        
          if(entry.inview) {
               console.log('element unobserved and scroll event detached!')
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange">
                         <span class="bi-record-circle mxr-6"></span>Setting options
                    </div>
                    <div class="">
                         In the javascript <code>IntersectionObserver</code> API we can set options for <code class="bd-f">rootMargin</code> and 
                         <code class="bd-f">threshold</code>. This can also be defined for the <code>Intersection</code> plugin as shown 
                         below:
                    </div>
                    <br><br>
                    <div class="pre-area">
                         <pre class="pre-code">
  Intersect = new Intersect();

  Intersect.item({

     <span class="c-sky-blue-dd">el</span>: ".btn",

     <span class="c-sky-blue-dd">threshold</span>: [0],

     <span class="c-sky-blue-dd">rootMargin</span>: "0px",

     <span class="c-sky-blue-dd">callback</span>: function(entry) {
        
          if(entry.inview) {
               console.log('element unobserved and scroll event detached!')
               entry.unobserve()
          }

     }

  })
                         </pre>
                    </div>

                    <div class="foot-note">
                         Aside from the <code class="bd-f" class="bd-f">el</code> 
                         and <code class="bd-f">callback</code> keys, any key defined in the 
                         <code>item()</code>, <code>observe()</code> and <code>onScroll()</code> 
                         methods will be added as an option for the <code>IntersectionObserver</code> API. 
                    </div>

                </div> <br>
                
            </div>
        </div>
    </section>
</div>
@template;