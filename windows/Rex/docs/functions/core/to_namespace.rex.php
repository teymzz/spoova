
@template('template.t-tut')

  @title('Function: to_namespace()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : to_namespace</div> <br>  
        

          <div class="">
            <div id="to_namespace" class="to_namespace">

                <div class="">
                  This function performs three operations. It converts frontslashes to backslash, removes a trailing 
                  front or back slashes suffix from the end of a url and decides if a prefix trailing slash is to be added 
                  to the supplied url. This in simple terms means that any url supplied is converted to a namespace pattern 
                  with or without a prefix trailing backslash.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  to_namespace($url, $dots)
  <span class="c-sky-blue-dd"> 
  $url  : supplied url string
  $prefix : a boolean value of true adds a backslash prefix
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $text = to_namespace('some/url'); 

  var_dump( $text ); <span class="comment">// some\url </span> 
                  </pre>
                </div> 

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $text = to_namespace('some/url', true); 

  var_dump( $text ); <span class="comment">// \some\url </span> 
                  </pre>
                </div> 
               
          </div>

          <div class="foot-note">
            It is should be noted that dots are never converted to slashes. 
            To convert dots to backslash see <a href="@domurl('docs/functions/core/to_dotspace')" class="c-orange-d ch-orange-dd">to_dotspace</a> documentation
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;