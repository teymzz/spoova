
@template('template.t-tut')

  @title('Function: striplastSlash()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : striplastSlash</div> <br>  
        

          <div class="">
            <div id="striplastSlash" class="striplastSlash">

                <div class="">
                  This function removes the last trailing slash of a string.
                </div> <br>
                
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  striplastSlash($string)
  <span class="c-sky-blue-dd"> 
  $string  : supplied string url
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $stripped = striplastSlash('site.com/user/profile/');
  
  vdump( $stripped ); <span class="comment">// site.com/user/profile</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $stripped = striplastSlash('site.com/user/profile/////');

  vdump( $stripped ); <span class="comment">// site.com/user/profile</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 3</div>
                  <pre class="pre-code">
  $stripped = striplastSlash('space\user\profile\\');

  vdump( $stripped ); <span class="comment">// space\user\profile</span>
                  </pre>
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