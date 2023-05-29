
@template('template.t-tut')

  @title('Function: to_lgts()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : to_lgts</div> <br>  
        

          <div class="">
            <div id="to_lgts" class="to_lgts">

                <div class="">
                  This function converts <code>&lt;</code> and <code>&gt;</code> to 
                  <code>{{ htmlentities('&lt;') }}</code> and <code>{{ htmlentities('&gt;') }}</code> respectively in any 
                  given string.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  to_lgts($string)
  <span class="c-sky-blue-dd"> 
  $string : supplied string
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  vdump( to_lgts("&lt;br&gt;") ); <span class="comment no-select"> // {{ htmlentities('&lt;br&gt;') }}</span>
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