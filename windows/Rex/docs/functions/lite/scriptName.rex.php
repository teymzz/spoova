
@template('template.t-tut')

  @title('Function: scriptName()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : scriptName</div> <br>  
        

          <div class="">
            <div id="scriptName" class="scriptName">

                <div class="">
                  This function returns the current script name
                </div> <br>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  vdump( scriptName() ); <span class="comment">//return current script name</span>
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