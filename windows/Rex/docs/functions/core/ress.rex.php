
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : ress</div> <br>  
         
          <div class="">
            <div id="ress" class="ress">
                
                <div class="">
                  The <code>ress()</code> function is an helper function that is 
                  used to directly fetch a file from a specified static file path. 
                  At most times, this function will not be used because of its equivalent 
                  <code>@(@ress())@</code> directive which is used in template files. However, 
                  if for any reason the result is needed in routes, the <code>ress()</code> 
                  function can be used. 
                </div> <br>


            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  var_dump ( ress('res/some-file.js') ); <span class="comment">// returns file script if url is valid</span>
                  </pre>
                </div> <br>

            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;