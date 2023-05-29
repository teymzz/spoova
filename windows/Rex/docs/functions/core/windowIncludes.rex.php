
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : windowIncludes</div> <br>  
         
          <div class="">
            <div id="windowincludes" class="windowincludes">
                
                <div class="">
                  The <code>windowIncludes</code> is a case-sensitive function that is used to check if the current base url matches the  
                  list of supplied urls. Since index pages can either be empty (i.e "") or "index", a frontslash ("/") can be used to denote 
                  an index page.
                </div> <br>

                <div class="foot-note">
                  The condition below tests if the current url address exists as the specified url <br> 
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">

  if( windowIncludes('some/url') ){

     <span class="comment">// current url is "some/url"</span>

  }
                  </pre>
                </div> <br> <br>

                <div class="foot-note">
                  The condition below tests if the current url address exists in the list of the specified urls <br> 
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  
  $validUrls = ['some/url1', 'some/url2']; 

  if( windowIncludes($validUrl) ){

     <span class="comment">// current url is in accepted urls</span>

  }
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