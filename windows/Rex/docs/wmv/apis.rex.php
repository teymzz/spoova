
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">


                    <div class="font-em-1d5 c-orange">Handling APIs</div> <br>  
                    
                    <div class="setters-intro">
                        <div class="fb-6 mvb-6">Introduction</div>
                        <div class="">
                           API in spoova are windows that are declared as api channel. Since spoova handle pages using 
                           windows and frames, APIs are also extensions of windows or frame files. This means that they can inherit 
                           all the properties of a window page or url as the case may be. One of the advantages of using 
                           route <a href="@domurl('docs/wmv/calls')">shutter</a> methods is that they have capacity 
                           to naturally determine the response of any window url or web page. Shutter methods, that is 
                           <code>call()</code>, <code>rootcall()</code>, <code>basecall()</code> and <code>pathcall()</code> 
                           methods are designed to detect the type of a window, if it is a normal webpage or an <code>API</code> 
                           route. It is very easy to determine the type of any window by declaring within the window the type of window 
                           it is using the <code>integerateAPI()</code> method.
                            <p>
                                <div class="c-orange mvb-6">API Integeration</div>
                                The figure below explains how to integerate an API with any window page <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Syntax: integerateAPI</div>
                                    <pre class="pre-code">
  Window::integerateAPI($type)  
  <span class="comment">
    where: 

     $type : [ajax|json|ajax:json|json:ajax]
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>type</code> above defines how a window responds to its shutter methods
                                    while the <code>integerateAPI()</code> method defines that the window should respond 
                                    as an api route.
                                </div><br>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example: integerateAPI</div>
                                    <pre class="pre-code">
  <span class="comment">...</span>
  
  class HomeAPI {

    function __construct() {

        self::integerateAPI('ajax');

    }

  }
                                    </pre>
                                </div>
                                <div class="foot-note pvs-10">
                                    The example above defined how to set up an api window url by using the <code>self::integerateAPI()</code> method.
                                    There are 
                                    three different response types which are <code>ajax</code>, 
                                    <code>json</code> and <code>ajax:json</code> or <code>json:ajax</code>.  The behavioral pattern 
                                    or how these types respond to shutter methods are further explained below under their own subheadings.
                                </div>
<!-- code ends -->
                            </p>

                            <p>
                                <div class="c-orange">AJAX Response Type</div>
                                Whenever the <code>integerateAPI()</code> is set as <code>ajax</code>, if a url does not exist, rather than return a 
                                404 request page, the shutters will automatically switch to a json format 404 response type using the format below:  
<!-- code begins -->
                                    <div class="pre-area shadow mvt-6">
                                        <div class="pxv-6 bc-silver">Invalid url response on integerateAPI('ajax')</div>
    <pre class="pre-code">
  {
    "success":false,

    "error":true,

    "message":"Page not found!",

    "response_code":404
  }
    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>integerateAPI('ajax')</code> does not really check if the response of any window 
                                    content matches a json format. It only believes that if an error occurs, then a json format should 
                                    be returned as a response, since api is only integerated with a window file.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">JSON Respose Type</div>
                                    The <code>json</code> type is used to declare that the content of a page should be of json format. This 
                                    follows a strict content-type for any window api. If the content-type is not of a valid <code>json</code> content type, 
                                    the response returned will be json SyntaxError notifying that the content cannot be parsed as revealed in the figure below: 
<!-- figure begins -->
                                <div id="figure1" class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 1: Json Parse Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="@mapp('images/json-parse-error.png')"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>FIGURE 1</code> above is an example of a response returned by an api json-integerated window if the response type is not of valid json
                                    format.
                                </div>
<!-- code description ends -->

<!-- figure begins -->
                                <div id="figure2" class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 2: Json 404 Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="@mapp('images/json-404.png')"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>FIGURE 2</code> above is an example of a response returned by an api json-integerated window if url is not valid or the method does not exist.
                                </div>
<!-- code description ends -->


                            </p>

                            <p>
                                <div class="c-orange">AJAX:JSON Response Type</div>
                                The <code>ajax:json</code> or <code>json:ajax</code> response type is more of a true request validation type on json content-type. When <code>integerateAPI('ajax:json')</code> 
                                is set on any window, the content type of that window must be a json format just like <code>integerateAPI('json')</code>. Secondly, the request type must also be through an ajax 
                                request type. The validation execution order will return a <code>401</code> request if the request is not sent through ajax first. However, if the request is sent through ajax, 
                                then the validation will go on to check if the content type is of json format also. The figure below shows the response returned if the requested page is loaded directly and not 
                                through ajax request. <br>
<!-- figure begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Figure 2: Json 404 Error</div>
  <div class="" style="width:100%; height: 120px">
    <div class="px-full b-fluid bc-black" style="background-position: left;" data-src="@mapp('images/ajax-invalid-request.png')"></div>
  </div>
                                </div>
<!-- figure ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The example above best reveals an error response obtained when an <code>integerateAPI('json:ajax')</code> is loaded directly.
                                </div>
<!-- code description ends -->

                            </p>

                            <p>
                                <div class="c-orange">Modifying Responses</div>
                                <p>
                                    The <code>integerateAPI()</code> method supports more than one argument. There are certain cases developers may want to modify 
                                    the <code>"invalid request"</code> response 
                                    message of the <code>json:ajax</code> api. This can be supplied through a second argument 
                                    (i.e <code>integrateAPI('ajax:json', 'invalid request protocol')</code>). The response default error code <code>"401"</code> can also 
                                    be modified through a third argument. For example : <code>integrateAPI('ajax:json', 'invalid request protocol', 402)</code>. 
                                    It is important to learn and have a good understanding of the <code>Ajax</code> class from <a href="@domurl('docs/classes/ajax')">here</a>. 
                                </p>
                                <p>
                                    Whenever a page 
                                    returns 404, the <code>integerateAPI</code> will always return a response shown in <a href="#figure1"><span class="c-brown-ll bold hyperlink">Figure 1</span></a> earlier
                                    . However, there are other means to set up api routes which involve the use of <code>Ajax</code> class. Although there is no way for 
                                    shutter methods to detect if a window is an <code>API</code> window, the <code>response()</code> function, <code>Ajax</code> class 
                                    and the <code>integerateAPI()</code> method can help the  <code>shutters</code> to create custom APIs whose responses are entirely under the control of developers.
                                    The example below best explains this concept.
                                </p>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example: Custom APIs</div>
                                    <pre class="pre-code">
  class APIs {

    function __construct(){

        self::integerateAPI('ajax'); <span class="comment">// set an ajax channel</span>

        Ajax::accept('post'); <span class="comment">// accept only post requests </span>
        
        Ajax::accept('post')->referred(); <span class="comment">// accept only posts requests and it must referred </span>
        
        Ajax::with('json')->referred(); <span class="comment">// accept only posts requests and it must referred </span>
        
        Ajax::accept(['post','get'])->with('json')->referred(); <span class="comment">// accept only posts and get requests and it must referred and returned value must be of json format</span>
        
        if(Ajax::isAjax()){

            <span class="comment">If this request is an Ajax request, run this block code</span>

            return response(404, 'message here');

        } else {

            <span class="comment">If this request is not an Ajax, run this block code</span>

            return response(404, 'message here');         

        }


    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The example above shows different methods of setting an api route. We suggest to visit the <a href="@domurl('docs/classes/ajax')">ajax documentation</a> 
                                    to understand how the <code>Ajax</code> class works. The window pattern is structurally designed in a way that api can 
                                    be built on urls whose parent url are not of ajax or json types. An example below shows how this can be achieved.
                                </div> <br>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example 2: Building API on routes</div>
                                    <pre class="pre-code">
  class Home {

    function __construct(){

        self::call(
            [
                window(':') => 'root',    
                window(':user') => 'user',    
                window(':user.apiOne') => 'apiOne',    
                window(':user.apiTwo') => 'apiTwo',    
            ]
        )

    }

    fuction root() {

        <span class="comment">//This is the home url</span>
        self::load('some-file', fn() => compile());

    }

    <span class="comment">/**
     * This is home/user/apiOne
     */</span>
    fuction apiOne() {
        
        self::integrateAPI('ajax'); <span class="comment">//error response should be json format for shutters</span>

        self::call([
        
            window('base:') => 'win:Routes\API\APIHandler';
            
        ])

    }

    <span class="comment">/**
     * This is home/user/apiTwo
     */</span>
    fuction apiTwo() {

        Ajax::isAjax(':json'); <span class="comment">//set Content-Type as application/json</span>

        if(!Ajax::isAjax()){

            <span class="comment">//run this is if request is NOT ajax request</span>

            $response = ['message'=>'invalid request protocol', 'code' => 401];

            echo json_encode($response);

            return;

        } else {

            <span class="comment">//run this is if request is ajax request</span>

            if(routeExists('API\APIHandler')) {

                new API\APIHander();

            } else {

                $response = ['message'=>'api not found', 'code' => 404];

                echo json_encode($response);

                return;
                
            }

        }

    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    <p>
                                        In the when the <code>home</code> url is visited, then the method <code>root()</code>
                                        is called. When the <code>home/user</code> is visited, the <code>user()</code> method is called.
                                        When the <code>home/user/apiOne</code> is visited, the method <code>apiOne()</code> is called. 
                                        Each url visited calls their corresponding methods on the Home class. This means that, according to the 
                                        <code>code</code> above, the <code>Home</code> class is the urls entry point. While <code>root()</code> 
                                        may load its file as a web page, the <code>apiOne</code> is managed by the <code>integerateAPI()</code>
                                        method along with the <code>call()</code> shutter. In <code>apiTwo</code> however, the entire logic is handled 
                                        with the <code>Ajax</code> class and this is done through series of testing conditions. It can be easily noticed 
                                        that it is much easier to implement <code>integerateAPI()</code> than testing with <code>Ajax</code> class. However, 
                                        when we need to handle custom requests, then using the <code>Ajax</code> class is the best solution. 
                                    </p>

                                    <p>
                                        Previously defined examples have shown that the <code>integerateAPI()</code> method can be used to define a route type.
                                        This method can also be defined at top level by setting the static property <code>$winAPI</code> to any valid option accepted by 
                                        <code>integerateAPI()</code> method. If the property is set, the window will use that value to set shutter responses. Example 
                                        of this is shown below:
                                    </p>
                                    
                                </div>
<!-- code description ends -->
<!-- code begins -->
<div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver">Example 2: Building API on routes</div>
                                    <pre class="pre-code">
  class Home {

    static $winAPI  = 'json:ajax';

    function __construct(){

        self::call(
            [
                window(':') => 'root',    
                window(':user') => 'user',       
            ]
        );

    }

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    <p>
                                        In the code above, the <code>call()</code> method will respond as if the <code>integrateAPI()</code> was called 
                                        on it.
                                    </p>
                                </div>
<!-- code description ends -->                            
                            </p>

                            <div class="flex-in midv rad-4 bc-silver"> 
                                <div class="bc-red-orange-dd pxv-4" style="color:#efefef">Warning:</div>
                                <div class="font-em-d8 pxs-4">
                                    Ajax urls should not contain any 
                                    special character including underscore ('_') 
                                    as this can lead to loss of data if data is forwarded. However, 
                                    urls can contain digits.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </section>
    </div>
@template;