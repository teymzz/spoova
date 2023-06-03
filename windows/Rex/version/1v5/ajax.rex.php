@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 1.5+ </div>  Ajax Requests</div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Ajax requests </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Prior to spoova 1.5, ajax urls do not support the use of special characters. 
                                A sample of this is explained below. 

                                <div class="pre-area">
    <pre class="pre-code">
&lt;script&gt;

  let xhttp, url, params;

  xhttp = new XMLHttpRequest();

  url = "some-url";
  params = window.location.search;

  xhttp.onreadystatechange = function(){

  }

  xhttp.open("GET", url + params, true);
  xhttp.setHeaders('X-Requested-With', 'xmlHttpRequest');
  xhttp.send();
  

&lt;/script&gt;
    </pre>
                                </div>
                                In the example above, when request parameters for post or get method are forwarded to the server, the parameters are not forwarded 
                                due to a bug in the url structure that prevent urls that have special characters from forwarding parameters 
                                supplied. This means that we have to change the url "some-url" to "someUrl" or alphabets only in order to be able to forward the 
                                request parameters. This also affects commonly used underscore <code>"_"</code> character. In version 1.5.0, this bug has been resolved and ajax urls can now receive request paramaters from urls as long as the url is of a valid structure. 
                            </p>
                            
                        </div>
                    </div> <br>

                </div>
           </div>
       </section>
   </div>

@template;