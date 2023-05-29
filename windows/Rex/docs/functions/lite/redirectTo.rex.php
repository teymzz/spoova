
@template('template.t-tut')

  @title('Function: redirectTo()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : redirectTo</div> <br>  
        

          <div class="">
            <div id="redirectTo" class="redirectTo">

                <div class="">
                  This function uses the internal php header location to redirect to urls
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  redirectTo($url)
  <span class="c-sky-blue-dd"> 
  $url : supplied string url
  </span> 
                  </pre>
                </div>

                <div class="foot-note">
                  The function above is similar to <code>header('location:$url')</code>
                </div>

          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;