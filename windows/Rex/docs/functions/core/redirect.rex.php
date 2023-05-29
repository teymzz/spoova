
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : url</div> <br>  
         
          <div class="">
            <div id="url" class="url">
                
                <div class="">
                The <code>redirect</code> function is an internal way of 
                redirecting urls within the framework. Urls are redirected to pages based on the project root 
                folder. For example, if the project folder is <code>app</code>, the <code>redirect</code> 
                function begins its redirection in the project root. This means that the <code>app</code> 
                is not included as part of the url supplied.
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  redirect('/'); <span class="comment">// redirect to accessible site root</span>
                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  redirect('index'); <span class="comment">// redirect to index url</span>
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