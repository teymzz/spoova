
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d85">

            @lay('build.co.links:tutor_pointer') <br>

          <div class="font-em-1d5 c-orange-dd">Ajax Class</div> <br>  
        
            <div class="helper-classes">
                <div class="">

                <div class="">
                    The <code class="bd-f">Ajax</code> class is an helper class that was created to 
                    manage Ajax requests. We suggest that you should learn about the 
                    <a href="@domurl('docs/domurl')" class="c-olive rule-dotted"><code class="bd-f">WMV</code></a>  pattern first before learning about 
                    Ajax class because reference could be made to it in the course of this documentation. 
                    The <code class="bd-f">Ajax</code> class handles Requests based on 3 main categories. 
                </div> <br>

                    <ol>
                        <li> <a href="#direct-request" class="c-olive ch-olive-dd"> Direct Request </a> </li>
                        <li> <a href="#json-request" class="c-olive ch-olive-dd"> JSON Restriction </a> </li>
                        <li> <a href="#referred-request" class="c-olive ch-olive-dd"> Referred Restriction </a> </li>
                    </ol> 
                    
                    In this documentation, we will learn and understand the meaning of these loading types and how to 
                    apply them.
                </div> 
            </div>   <br>


            <div id="direct-request" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-8">
                            </span> Direct Request
                        </div>
                    </div>
                    <div class="">
                    When requests are naturally sent to urls, the raw contents of that url is returned as response. This approach suggests that 
                    all requests are returned raw whether as an http request or as an ajax request. This means that the raw data obtained by 
                    sending an http request to a page is still the same data obtained when an ajax request is forwarded. This is termed 
                    as direct loading of contents from urls. In this method, the <code class="bd-f">Ajax</code> class has no effect on responses obtained 
                    because such data is just forwarded as obtained. 
                    </div>
                </div> <br>
            </div>       

            <div id="json-request" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-8">
                            </span> JSON Restriction
                        </div>
                    </div>
                    <div class="">
                    JSON Restriction is set when we declare content type of data obtained as JSON (i.e application/json). This 
                    means that we expect the response obtained from a request data to be in json format. If data obtained from a request (http or ajax) 
                    is not a valid <code>JSON</code> string, then a <code>ParseError</code> is obtained. The <code class="bd-f">Ajax</code> class 
                    makes it easy for us to declare our content-type as json by calling the <code>Ajax::isAjax(':json')</code> 
                    or <code>Ajax::withJson()</code> method.    
                    </div>
                </div>
            </div> <br>

            <div id="referred-restriction" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                             REFFERED Restriction
                        </div>
                    </div>
                    <div class="">
                    REFERRED restriction is applied when we set certain referer restrictions on a particular page. This restriction, when set,
                    prevents requests that are not sent through an XMLHttpRequest referer. In this way we can most likely keep our data 
                    protected in such a way that data is obtained only when an ajax request is sent. The <code>Ajax</code> class provides a method 
                    <code>"isReferred()"</code> which helps to set this restriction.  
                    </div>
                </div>
            </div> <br>

            <div id="initializing-class" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-8 bi-lightning-fill">
                            </span> Initializing Ajax class
                        </div>
                    </div>
                    <div class="mvt-6 pvs-10">
                    The syntax for initializing the Ajax class is shown below: <br><br>
 <!-- code started -->                   
<div class="pre-area mvt-6">
    <div class="bc-silver pxv-10">Ajax initialization syntax</div>
    <pre class="pre-code">
  use spoova\mi\core\classes\Ajax;

  new Ajax($response, $ecode);
  <span class="comment">
    where: 
      
     $response : optional error response text
     $ecode : optional error response code 
  </span>
    </pre>
</div>
<!-- code ended -->

 <!-- code description started -->                   
<div class="foot-note">
    Whenever arguments are supplied on the <code>Ajax</code> class, 
    the class becomes mandated to check if the current request is ajax. 
    However, if no arguments are supplied, then the ajax class will only create 
    an instanceof itself without checking if the request is an ajax request. 
    In the code above, when <code>$emess</code> is supplied, once the request is not 
    an ajax request, then the <code>$emess</code> text will be returned with a default 
    401 error response code. The <code>$ecode</code> can also change the default 
    <code>401</code> response into a new accepted response code. The examples below 
    show how the <code>Ajax</code> class can be initialized.
</div> <br>
<!-- code description ended -->

 <!-- code started -->                   
 <div class="pre-area mvt-6">
    <div class="bc-silver pxv-10">Example 1a: Ajax initialization</div>
    <pre class="pre-code">
  use spoova\mi\core\classes\Ajax;

  new Ajax();
    </pre>
</div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    In the example above, no check will be done to determine if the incoming request is 
    an ajax request. Only the instace of the class is created.
</div>
<!-- code description ended -->

 <!-- code started -->                   
 <div class="pre-area mvt-6">
    <div class="bc-silver pxv-10">Example 1b: Ajax initialization</div>
    <pre class="pre-code">
  use spoova\mi\core\classes\Ajax;

  new Ajax('invalid request', 401);
    </pre>
</div>
<!-- code @domurl('abc') -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    In the example above, the ajax class will check to determine if the incoming request is 
    an ajax request. If the incoming request is not ajax request, then the page will exit with a 
    response code of <code>401</code> and response message in the format below:
</div>
<!-- code description ended -->

<!-- code description started -->                   
<div class="foot-note mvt-6">
    In the example above, the ajax class will check to determine if the incoming request is 
    an ajax request. If the incoming request is not ajax request, then the page will exit with a 
    response code of <code>401</code> and response message in the format below:

</div><br>
<!-- code description ended -->

 <!-- code started -->                   
 <div class="pre-area mvt-6 rad-4 box-full flow-hide">
    <div class="bc-silver pxv-10 c-brown">Example 2: Invalid Request Response Message Format</div>
    <pre class="pre-code  font-em-d87" style="color:red;">
  {
    "success": false,
    "error": true,
    "message": "invalid request",
    "response_code": 401
  } 
    </pre>
</div>
<!-- code ended -->

<!-- code description started -->                   
<div class="foot-note mvt-6">
    Although, the first argument supplied was a string (i.e <code>"invalid request"</code> ), this can also be 
    an array which will be processed and returned as a json format.
</div>
<!-- code description ended -->

                    </div>
                </div>
            </div> <br>



            <div id="ajax-methods" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-8">
                                <span class="bi-circle"></span>
                            </span> Ajax Methods
                        </div>
                    </div>
                    <div class="">
                    Aside from Initializing our Ajax class, there are few methods provided for handling 
                    requests and request responses. These method are listed and explained below: <br> 
                    
                    <ul class="font-em-d9 c-olive mvt-10">
                        <li>isAjax()</li>
                        <li>referred()</li>
                        <li>withJson()</li>
                        <li>accept()</li>
                        <li>setcode()</li>
                        <li>getcode()</li>
                    </ul>
                    </div>
                </div>
            </div>

            <div id="isajax" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-8">
                                <span class="bi-circle-fill"></span>
                            </span> isAjax
                        </div>
                    </div>
                    <div class="">
                    This method is used to check or set an ajax response type and it can also be used 
                    to perform both operations at once. By default, it returns a boolean of true if 
                    the current request type is <code>XMLHttpRequest</code>. It can also set the content 
                    type of the current file. Example is shown below
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: isAjax</div>
    <pre class="pre-code">
  Ajax::isAjax(); <span class="comment">// returns true or false</span>
  Ajax::isAjax('application/json'); <span class="comment">// returns true or false and sets content-type </span>
  
  Ajax::isAjax(':json'); <span class="comment">// shorthand for application/json </span>
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    The example above shows how the <code>isAjax()</code> method can be applied. The first code line will not set a 
    content-type for url. However, in the second code line, the argument 
    supplied is used to set the content-type to <code>application/json</code>. Also, if our content-type is 
    <code>application/json</code> as in example above, we can set the argument to <code>:json</code> which is a shorthand 
    argument for <code>application/json</code>. This shorthand argument can only be applied for <code>application/json</code> 
    content type.
</div>
<!-- code description ended -->                

                    </div>
                </div> <br>
                    
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: checking request</div>
    <pre class="pre-code">
  if( Ajax::isAjax() ) {

    <span class="comment">//This seems to be an xmlHttpRequest</span>

  }
    </pre>
                    </div>
                </div>

            
            </div> <br>

            <div id="setcode" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>setcode
                        </div>
                    </div> 
                    <div class="">
                    This <code>setcode()</code> method is used to set a response code
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: setcode</div>
    <pre class="pre-code">
  $Ajax = (new Ajax);

  if( $Ajax::isAjax() ) {

    $Ajax->setcode(401); <span class="comment">//set last response code</span>

  }

    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    The example above shows how the <code>setcode()</code> method can be applied. Naturally, the 
    <code>setcode()</code> only sets a last response obtained. Ordinarily, this method has no effect 
    unless used with other methods like <code>accept()</code> and <code>referred</code> which will be discussed later
</div>
<!-- code description ended -->                

                    </div>
                </div>

            </div> <br>

            <div id="getcode" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>getcode
                        </div>
                    </div>
                    <div class="">
                    This <code>getcode()</code> method returns the last response code set be <code>setcode()</code>
                    method.
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: getcode</div>
    <pre class="pre-code">
  $Ajax = (new Ajax);

  if( $Ajax::isAjax() ) {

    $Ajax->setcode(401); <span class="comment">//set last response code</span>

  } else  {

    $Ajax->setcode(200); <span class="comment">//set last response code</span>
    
  }

  echo $Ajax->getcode(); <span class="comment">// displays either 401 or 200</span>
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    In the example above, the <code>getcode()</code> method will print out the last response set 
    by the <code>setcode()</code> method.
</div>
<!-- code description ended -->                

                    </div>
                </div>

            </div> <br>



            <div id="referred" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>referred
                        </div>
                    </div>
                    <div class="">
                    This <code>referred()</code> method is used to declare that the request of the page 
                    must have a referer url. If the url is loaded directly, then the page will automatically 
                    terminate with a predefined response type.
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: referred</div>
    <pre class="pre-code">
  (new Ajax)->setcode(401)->referred(); <span class="comment">// Ensure that a referer url is sent</span>
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    The example above shows how the <code>referred()</code> method is used. The 401 response code was set first using
    <code>setcode()</code> method, then the <code>referred()</code> method was called. If the url was loaded directly,
    then the <code>referred()</code> method will trigger an <code>"invalid request"</code> response, then a 401 response
    header code will be sent. The response message will be similar to the response message format below:
</div>
<!-- code description ended -->                

                    </div>
                </div> <br>
                
<!-- code started -->                       
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: Invalid request response format</div>
    <pre class="pre-code  foot-note" style="color:grey">
    {
      "success": false,
      "error": true,
      "message": "invalid request",
      "response_code": 401
    } 
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    Alhough, the response is similar to when the <code>Ajax</code> class was initialized, it might be useful in cases when 
    we don't want to initialize <code>Ajax</code> in referred validation mode.
</div>
<!-- code description ended -->               
            </div> <br>

            <div id="withjson" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>withJson
                        </div>
                    </div>
                    <div class="">
                    This <code>withjson()</code> method is a good way to perform all the activities of setting json content type and 
                    also checking if request is referred all in one line. Just like instantiating the class itself, <code>withJson</code>
                    accepts the same argument that the ajax <code>__construct()</code> function takes. This method will first set the content-type 
                    as <code>application/json</code>, then will go on to instantiate the class with supplied arguments. Example of usage is below:
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: withJson</div>
    <pre class="pre-code">
    Ajax::withJson('invalid request', 401)<span class="comment">// Ensure that a referer url is sent</span>
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    The example above shows how the <code>withJson()</code> method is used. The response message <code>"invalid request"</code>. 
    will be retuned along with 401 response code, if the url was loaded directly. Also a parseError will be sent if 
    the content data returned is not a valid json format.
</div>
<!-- code description ended -->                

                    </div>
                </div> <br>

            <div id="request" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>request
                        </div>
                    </div>
                    <div class="">
                    The <code>request()</code> method simply returns the request method of any request 
                    sent.
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: withJson</div>
    <pre class="pre-code">
    Ajax::request(); <span class="comment">// returns post, get, ...etc</span>
    </pre>
                    </div>
                </div>
<!-- code ended -->         

                    </div>
                </div> <br>

            <div id="accept" class="">
                <div class="">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                        <div class="flex-full midv c-orange-dd"> 
                            <span class="mxr-4">
                                <span class="bi-circle-fill"></span>
                            </span>accept
                        </div>
                    </div>
                    <div class="">
                    This method sets the accepted request methods required for data to be obtained
                    from the content url. These request methods are <code>post</code>, <code>get</code>,
                    <code>put</code> and <code>delete</code>. The <code>accept()</code> method sets the allowed 
                    request method(s) based on these four request methods. If the request method forward does not match 
                    the list of accepted specified methods, the page will be terminated using predefined arguments (i.e response codes and messages). 
                    By default, a <code>401</code> error response is returned while an 'invalid request method' is also returned. 
                    However, these can be modified through arguments.
                    <br><br>
<!-- code started -->                   
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: accept</div>
    <pre class="pre-code">
  Ajax::accept('post'); <span class="comment">// Accept only post request methods, return 401 on error</span>
  
  Ajax::accept(['post','get']); <span class="comment">// Accept only post and get request methods, return 401 on error</span>
  
  Ajax::accept(['post'], 402); <span class="comment">// Accept only post, return 402 on error</span>
  
  Ajax::accept(['post'], 402, ['text' => 'custom message']); <span class="comment">// add a custom array as response message</span>
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    The example above shows the behavioral pattern of the <code>accept()</code> method when used. 
    <ul>
        <li>
            In first line, assumming a request that is not post is sent to the ajax file, then the page will terminate with a
            <code>401</code> response code along with "invalid request method" as response message.
        </li>
        <li>
            In second line, assumming a request that is not post or get is sent to the ajax file, then the page will terminate with a
            <code>401</code> response code along with "invalid request method" as response message.
        </li>
        <li>
            In the third line, assumming a request that is not post is sent to the ajax file, then the page will terminate with a
            <code>402</code> response code along with "invalid request method" as response message.
        </li>
        <li>
            In the last line, assumming a request that is not post is sent to the ajax file, then the page will terminate with a
            <code>402</code> response code along with the supplied array (converted to json) as response message.
        </li>
    </ul>

</div>
<!-- code description ended -->                

                    </div>
                </div> <br>
                
<!-- code started -->                       
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example: Invalid request response format</div>
    <pre class="pre-code  foot-note" style="color:grey">
    {
      "success": false,
      "error": true,
      "message": "invalid request",
      "response_code": 401
    } 
    </pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code description started -->                   
<div class="foot-note mvt-6">
    Although, the response is similar to when the <code>Ajax</code> class was initialized, it might be useful in cases when 
    we don't want to initialize <code>Ajax</code> in referred validation mode.
</div>
<!-- code description ended -->               
            </div> <br>
        
            <div class="response-function">

                <div class="header c-orange-dd">The response function</div>
                <div class="">
                    The response function is used to set responses based on request code defined. 
                    This function formats its json string under four data keys which are 
                    <code>success</code>, <code>error</code>, <code>code</code> and <code>message</code>. 
                    However, this function takes three parameters and the syntax is shown below: 
                </div><br>

<!-- code started -->
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Syntax: response()</div>
    <pre class="pre-code  foot-note">
    response($code, $message, $modifier);
      <span class="comment">
        where: 

          $code : header response code (e.g 404, 401)
          $message: response message (array, string, boolean, e.t.c)
          $modifier: response message modifier (boolean)
      </span>
    </pre>
                    </div>
                </div>

<!-- code started -->
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example 1: response()</div>
<pre class="pre-code  foot-note">
    response(401, 'invalid request');
    <span class="comment">
    returns: 

        {
            "success": false,
            "error": true,
            "message": "invalid request",
            "response_code": 401
        }  
    </span>
</pre>
                    </div>
                </div>
<!-- code ended -->

<!-- code started -->
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example 2: response()</div>
<pre class="pre-code  foot-note">
    response(200, 'valid request');
    <span class="comment">
    returns: 

        {
            "success": true,
            "error": false,
            "message": "valid request",
            "response_code": 200
        }  
    </span>
</pre>
                    </div>
                </div>
<!-- code ended -->
<!-- code started -->
                <div class="pre-area">
                    <div class="box-full">
    <div class="pxv-6 bc-silver">Example 3: response()</div>
<pre class="pre-code  foot-note">
    response(401, 'modified message', true);
    <span class="comment">
    returns: 

        {
            "success": true,
            "error": false,
            "message": "modified message",
            "response_code": 401
        }  
    </span>
</pre>
                    </div>
                </div>
<!-- code ended -->

<!-- code description started -->                   
<div class="foot-note mvt-6">
    In the syntax above, <code>$code</code> is used to set the header response code. This code 
    will also be returned in the list of data keys under the key index name "response_code" as previously 
    seen in the examples above. The response message <code>$message</code> will also 
    set the message index key. The value of <code>$message</code> can be of any data type. Although, 
    <code>"invalid request"</code>, <code>"valid request"</code> and <code>"modified message"</code> were set above, but it can also take an array or preferred data type. Mostly, 
    this key is used to store response data obtained which can later be fetched using index key <code>"message"</code>
    The behavioral pattern of response function is to determine the type of response by using the header response 
    code <code>$code</code> defined. By default, every response code starting with digit <code>"4"</code> or <code>"5"</code>
    are considered as errors while those starting with <code>200</code> are considered as valid 
    requests. When the <code>success</code> index return as true, then the <code>error</code> will return as false 
    and when the <code>error</code> return as true, the <code>success</code> key is set as false. If the <code>$modifier</code> 
    is set as true just as example 3 given above, then regardless of the response header, the <code>success</code> key will become true and the <code>error</code> 
    key will become false. However, the response header code returned will never be affected. This method only helps to ensure that when it matters, an success response will not 
    be mistakenly assigned the value of <code>false</code>.
</div>
<!-- code description ended -->  
            </div>

        </div>
    
    @lay('build.co.coords:footer')

      </div>
    </section>
  </div>
@template;