
@template('template.t-tut')

  @title('Function: to_dotspace()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : to_dotspace</div> <br>  
        

          <div class="">
            <div id="to_dotspace" class="to_dotspace">

                <div class="">
                  This function performs three operations. It converts frontslashes or dots to backslash, removes a trailing 
                  front or back slashes suffix from the end of a url and decides if a prefix trailing slash is to be added 
                  to the supplied url. This in simple terms means that any url supplied is converted to a namespace pattern 
                  with or without a prefix trailing backslash.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  to_dotspace($url, $dots)
  <span class="c-sky-blue-dd"> 
  $url  : supplied url string
  $prefix : a boolean value of true adds a backslash prefix
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $text = to_dotspace('some/url.foo'); 

  var_dump( $text ); <span class="comment">// some\url\foo </span> 
                  </pre>
                </div> 

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $text = to_dotspace('some/url.foo/', true); 

  var_dump( $text ); <span class="comment">// \some\url\foo </span> 
                  </pre>
                </div> 
               
          </div>

          <div class="foot-note">
          To prevent dots from being converted to backslash see <a href="@domurl('docs/functions/core/to_namespace')" class="c-orange-d ch-orange-dd">to_namespace</a> documentation
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;