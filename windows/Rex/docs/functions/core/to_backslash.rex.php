
@template('template.t-tut')

  @title('Function: to_backslash()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : to_backslash</div> <br>  
        

          <div class="">
            <div id="to_backslash" class="to_backslash">

                <div class="">
                  This function converts front slashes and dots to back slash.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  to_backslash($url, $dots)
  <span class="c-sky-blue-dd"> 
  $url  : supplied url string
  $dots : a boolean value of true allows dots to be converted also.
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $text = to_backslash('some/url.foo'); 

  var_dump( $text ); <span class="comment">// some\url.foo </span> 
                  </pre>
                </div> 

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $text = to_backslash('some/url.foo', true); 

  var_dump( $text ); <span class="comment">// some\url\foo </span> 
                  </pre>
                </div> 
               
          </div>

          <div class="foot-note">
            To convert to frontslash see <a href="@domurl('docs/functions/core/to_frontslash')" class="c-orange-d ch-orange-dd">to_frontslash</a> documentation
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;