
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Response</div> <br>  
         
          <div class="">
            <div id="response" class="response">
                
                <div class="">
                  The <code>response</code> function is an http_response_code driven json string 
                  that is built for handling ajax responses. It takes an http response code as argument 
                  and uses it to build a json response string. By default, all 4xx and 5xx response codes 
                  when supplied as argument are considered as errors while other response codes are considered 
                  as successes. This behaviour sets the json error key as true when any of the error codes are 
                  supplied as argument. These can be overidden by supplying a third boolean argument that defines 
                  the success status of the response. When error is set as true, success becomes false and vice versa.
                </div> <br>


            <!-- code line started -->

                <div class="foot-note">
                  A defined response code of 200 will be as shown below:
                </div>
                <div class="pre-area shadow">
                  <pre class="pre-code">
  response(200, 'successful'); <span class="comment"></span>
                  </pre>
                </div>

                <div class="pre-area shadow">
                  <pre class="pre-code c-dry-blue-d">
  { 
    "success":true,
    "error"  :false,
    "message":"successful",
    "response_code":200
  }
                  </pre>
                </div>            

                <div class="foot-note">
                  A defined response code of 500 will be as shown below:
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  response(500, 'failed'); <span class="comment"></span>
                  </pre>
                </div>

                <div class="pre-area shadow">
                  <pre class="pre-code c-dry-blue-d">
  { 
    "success":false,
    "error"  :true,
    "message":"failed",
    "response_code":500
  }
                  </pre>
                </div>   

                <div class="foot-note">
                  If ever there is any reason to customize the response in such a way that 
                  the default behavior is overidden, this can be done by supplying the third argument 
                  as <code>true</code> or <code>false</code>. A true value will assume that the response code is success while a 
                  value of false will assume that the response is error.
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  response(500, 'successful', true); <span class="comment"></span>
                  </pre>
                </div>

                <div class="pre-area shadow">
                  <pre class="pre-code c-dry-blue-d">
  { 
    "success":true,
    "error"  :false,
    "message":"successful",
    "response_code":500
  }
                  </pre>
                </div> 

                <div class="foot-note">
                  Although, the header code of the current page will be automatically set when this function is used, we can obtain the json 
                  response in the following way.
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  $response = response(500, 'successful', true); <span class="comment">//set header and return json</span>
                  </pre>
                </div>
                

                <div class="foot-note">

                  Lastly, note that the <code>error</code> key's value is usually the inverse of the <code>success</code> key's value.
                  So, when <code>success</code> is <code>true</code>, then <code>error</code> will be <code>false</code>.

                </div> 
                
                

            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;