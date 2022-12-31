
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Javascript Helper Functions</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                    There are several lists of javascript core helper functions. Some of these functions are jquery dependent and can be identified by a red asterik (<span class="c-red">*</span>) before them. These functions are listed below <br>
                    
                    <ul class="mvt-6 c-olive">
                        <li><a href="#initfunc" data-scroll-hash="initfunc">initFunc</a></li>
                        <li><a href="#loadfuncs" data-scroll-hash="loadfuncs">loadFuncs</a></li>
                        <li><a href="#supercall" data-scroll-hash="supercall">superCall</a></li>
                        <li><a href="#callfunc" data-scroll-hash="callfunc">callFunc</a></li>
                        <li><a href="#isjson" data-scroll-hash="isjson">isJSON</a></li>
                        <li><a href="#urlenv" data-scroll-hash="urlenv">urlenv</a></li>
                        <li><a href="#ajaxuri" data-scroll-hash="ajaxuri"><span class="c-red">*</span>ajaxUri</a></li>
                        <li><a href="#getdate" data-scroll-hash="getdate">getDate</a></li>
                        <li><a href="#ajaxresponder" data-scroll-hash="ajaxresponder"><span class="c-red">*</span>ajaxResponder</a></li>
                        <li><a href="#rdpage" data-scroll-hash="rdpage">rdPage</a></li>
                        <li><a href="#inrange" data-scroll-hash="inrange">inRange</a></li>
                        <li><a href="#hasattr" data-scroll-hash="hasattr"><span class="c-red">*</span>hasAttr</a></li>
                        <li><a href="#hashrunner" data-scroll-hash="hashrunner"><span class="c-red">*</span>hashRunner</a></li>
                        <li><a href="#datascroll" data-scroll-hash="datascroll"><span class="c-red">*</span>dataScroll</a></li>
                        <li><a href="#datascrollhash" data-scroll-hash="datascrollhash"><span class="c-red">*</span>dataScrollHash</a></li>
                    </ul>
                </div> <br>
                
                <!-- init funcs -->
                <div id="initfunc">
                    <div class="font-em-1 c-orange">initFunc</div>
                    This is part of the core web application. It is used for instantiating an already defined function. If a supplied function name 
                    does not exist, then the function will not be called.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax: initFunc</div>
    <pre class="pre-code">
  initFunc(['func_name', param, param,...]);
  <span class="comment">
    where:
      
      func_name : function name 
      param     : function arguments
  </span>
    </pre>
</div> 
                </div> <br>
                
                <!-- load funcs -->
                <div id="loadfuncs">
                    <div class="font-em-1 c-orange">loadFuncs</div>
                    This is part of the core web application. It is used for instantiating already defined functions.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: loadFunc - loading multiple functions without argument</div>
    <pre class="pre-code">
  loadFuncs([func_1, func_2]); 
  <span class="comment">
    where:
      
      func_1 : function name
      func_2 : function name
  </span>
    </pre>
</div> 

<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 2: loadFunc - loading multiple functions with or without their arguments</div>
    <pre class="pre-code">
  loadFuncs([[func_1, arg], func_2]); 
  <span class="comment">
    where:
      
      [func_1, arg] : array of function name with argument 
      func_2        : function name without arguments
  </span>
    </pre>
</div> 
                </div> <br>   

                <!-- callFunc -->
                <div id="callfunc">
                    <div class="font-em-1 c-orange">callFunc</div>
                    This is part of the core web application. It is used for instantiating already defined function with delay timeout before function is called
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
  callFunc(callback, timeout); 
  <span class="comment">
   where:
      
    callback  : callback function name or array of function name and its arguments 
    timeout   : delay time before function is executed
  </span>
    </pre>
</div> 

<!-- code begins -->
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example : callFunc</div>
    <pre class="pre-code">
  <span class="c-olive">&lt;script&gt;

    function myFunction(arg) {

        if(arg === 'hi'){ 
            alert('hi') ;
        }

    }

    callFunc(['myFunction', 'hi'], 1000 );

  &lt;/script&gt;
  </span>
</pre>
<div class="c-white no-select pxv-10 bc-sea-blue">Desc: <span class="i">The code above will call "myFunction" after 1 minute of delay time</span></div>
</div> 
                </div> <br>
                
                <!-- supercall -->
                <div id="supercall">
                    <div class="font-em-1 c-orange">superCall</div>
                    This function performs a global scope event calling. 
                    Works with dynamically generated elements
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: superCall</div>
    <pre class="pre-code">
    superCall(event, selector, callback); 
  <span class="comment">
    where:
      
      event    : eventListener
      selector : element selector
      callback : callback function
  </span>
    </pre>
</div> 

<!-- code begins -->
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example : superCall</div>
    <pre class="pre-code">
  <span class="comment no-select">Test HTML:</span>
  &lt;div id="somediv"&gt;&lt;/div&gt;

  <span class="c-olive">
  &lt;script&gt;

    superCall('click','#somediv', function() { alert() } );

  &lt;/script&gt;
  </span>
</pre>
<div class="c-white no-select pxv-10 bc-sea-blue">Desc: <span class="i">The superCall above will call the "click" eventListener on a global scope</span></div>
</div> 
<!-- code ends -->
                </div> <br>

                
                <!-- callFunc -->
                <div id="isjson">
                    <div class="font-em-1 c-orange">isJSON</div>
                    This function is used to check if a string is of json type. It returns a boolean of true if test string is of valid json format
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax: isJSON</div>
    <pre class="pre-code">
  isJSON(string); 
  <span class="comment">
    where:
      
      string : test string
  </span>
    </pre>
</div> 
                </div> <br>
                
                <!-- urlenv -->
                <div id="urlenv">
                    <div class="font-em-1 c-orange">urlenv</div>
                    This function is used by within ajaxUri() function to map urls. It helps to reformats url to strings 
                    by removing extensions or mapping empty strings to current domain url. 
                </div> <br>
               
                <!-- ajaxUri -->
                <div id="ajaxuri">
                    <div class="font-em-1 c-orange">ajaxUri</div>
                    This function uses the <code>urlenv()</code> function to reformat an absolute url to an http protocol.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Example: ajaxUri</div>
    <pre class="pre-code">
  <span class="c-olive">
    $.ajax({

        method: 'post',
        url: ajaxUri('some/url/link'), <span class="comment">// http://current_domain/some/url/link </span>
        contentType: 'json',
        complete(): function() {

            <span class="comment">// request completed!</span>

        }

    })
  </span>
    </pre>
</div> 
                </div> <br> 
               
                <!-- getDate -->
                <div id="getdate">
                    <div class="font-em-1 c-orange">getDate</div>
                    This function is built upon the javascript <code>Date</code> object.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
    getDate(string); 
  <span class="comment">
    where string:
      
      ref   : return the Date Object Instance
      year  : return Date.getFullYear()
      month : return Date.getMonth()
      day   : return Date.getDay()
      date  : return Date.getDate()
      hour  : return Date.getHours()
      min   : return Date.getMinutes()
      sec   : return Date.getSeconds()
      milli : return Date.getMilliSeconds()
      full  : return full date
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- ajaxResponder -->
                <div id="ajaxresponder">
                    <div class="font-em-1 c-orange">ajaxResponder</div>
                    AjaxResponder was built to manage jquery completed requests. If the html response is a json format, it tries to parse the response text before 
                    storing it in an object with key name "message" where it can be accessed. However, if the response text is not a json format, the response will 
                    be stored as a text under the same key. This function suggests that every response should be of json format. If the response status is 200 and 
                    response is of a json format, an object key of <code>type: 200</code> is added to the returned data. Hoewever, if the response is not of json format, 
                    even if the response status is 200, the key <code>type:</code> will be set as <code>response</code> instead of 200. The data returned parsed or unparsed 
                    can be obtained under the object key <code>"message"</code>. The ajaxResponder function should only be used within Jquery ajax <code>complete()</code> method.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: ajaxResponder - Response Format</div>
    <pre class="pre-code">
    <span class="c-olive">
    complete:function(response){

        $data = ajaxResponder(response);

    } 
    </span>
  <span class="comment">
    Example format returned if is Json Format:
      
     <span class="c-orange-dd">{ "success": "true", "type": "200", "message":parsed_responseText}</span>


    Example format returned if is NOT Json Format:
      
     <span class="c-orange-dd">{ "error": "parse error", "type": "response", "message":responseText}</span>
  </span>
    </pre>
</div> 
                </div> <br> 
                

                <!-- rdPage -->
                <div id="rdpage">
                    <div class="font-em-1 c-orange">rdPage</div>
                    This function redirects a page to another page. It can be used within html "onClick" attribute
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: rdPage</div>
    <pre class="pre-code">
    rdPage(valid_url); 
    </pre>
</div> 
                </div> <br> 

                <!-- inRange -->
                <div id="inrange">
                    <div class="font-em-1 c-orange">inRange</div>
                    This function checks if a value is within the range of two values. It returns true if the test integer is within the 
                    range.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: inRange</div>
    <pre class="pre-code">
    inRange(integer, min, max); 
  <span class="comment">
    where:
      
      integer : test integer 
      min     : minimum range
      max     : maxumim range
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- hasAttr -->
                <div id="hasattr">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>hasAttr</div>
                    This function checks if an element has an attribute.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: hasAttr</div>
    <pre class="pre-code">
    hasAttr(elem, attr); 
  <span class="comment">
    where:
      
      elem : element selector
      attr : name of attribute to be checked
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- hashRunner -->
                <div id="hashrunner">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>hashRunner</div>
                    This function works as a page url hash controller.
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: hashRunner</div>
    <pre class="pre-code">
    hashRunner(option); 
  <span class="comment">
    where:
      
      option ":get"    : get the current hash in page url
      option "id"      : click the element having the relative id of the hash name in current page url
      option "class"   : click the element having the relative id of the hash name in current page url
      option "data-id" : click any element having the attibute of data-id with the value of the hash in current page url
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- dataScroll -->
                <div id="datascroll">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>dataScroll</div>
                    This function helps to scroll to a particular point on the web page using data-scroll attribute
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: callFunc</div>
    <pre class="pre-code">
    <span class="comment">Test: HTML</span>
    &lt;a data-scroll="elementid" data-minus="" data-plus=""&gt;&lt;/a&gt;
  <span class="comment">
    where:
      
      elementid  : the id of the element to be scrolled to
      data-minus : subtracts from the expected element position (in pixels) 
      data-plus  : adds to the expected element position (in pixels) 
      data-delay : add timeout delay before scroll is executed (in seconds)
  </span>
    </pre>
</div> 
                </div> <br> 

                <!-- dataScrollHash -->
                <div id="datascrollhash">
                    <div class="font-em-1 c-orange"><span class="c-red">*</span>dataScrollHash</div>
                    This function is used to scroll to the last url's hash. It also performs the function of <code>dataScroll()</code>
<div class="pre-area">
    <div class="pxv-10 bc-silver">Syntax 1: dataScrollHash</div>
    <pre class="pre-code">
    <span class="comment">Test URL:</span>
    https://some-site.com#someid

    <span class="comment">Test HTML:</span>
    <span class="c-olive">&lt;div id="someid" data-minus="10"&gt;&lt;/div&gt; 


    <span class="comment">Test Script:</span>

    &lt;script&gt; 

        dataScrollHash('someid');

    &lt;/script&gt; 
    </span>
</pre>
    <div class="pxv-10 bc-sea-blue c-white">
    In the above, when the page url is visited, the <code class="c-white">dataScrollHash()</code> function will scroll to the div with the supplied id. 
    The <code><span class="c-white">data-minus</span></code>, <code class="c-white">data-plus</code> and <code class="c-white">data-delay</code> 
    can also be applied on the div element just like the <code class="c-white">dataScroll()</code> 
    function. The <code class="c-white">data-delay</code> will subtract from the current element position by 10 pixels. This function can also be applied 
    on element using html event listener attributes. In some cases, the <code class="c-white">"window.onload"</code> 
    event listener or <code class="c-white">"setTimeout"</code> 
    may be needed to delay the execution before it can effectively work.
    </div>
</div> 
                </div> <br> 
                
                <div class="font-em-d8">
 The <code>dataScrollHash</code> function has been reserved an attribute <code>"data-scroll-hash"</code>. When the attribute is added to any element, it adds an <code>"onclick"</code> 
 event on that element. Once the element is clicked, the <code>data-scroll-hash</code> will search for the current page's url hash name. Once the hash string is obtained, 
 the page will try to scroll to any element having an id attribute value that matches the hash string. This is further discussed under integerated features.
                </div>

            </div>

        </div>
    </section>

    <script>
        hashRunner('data-scroll-hash');
    </script>
</div>
@template;