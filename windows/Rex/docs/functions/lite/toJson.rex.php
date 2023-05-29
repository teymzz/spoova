
@template('template.t-tut')

  @title('Function: toJson()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : toJson</div> <br>  
        

          <div class="">
            <div id="toJson" class="toJson">

                <div class="">
                  This converts an array to json format just like the <code>json_encode()</code> internal php function.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  toJson($value)
  <span class="c-sky-blue-dd">
  $value: value to be converted to json format
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: toJson</div>
                  <pre class="pre-code">
  toJson(['name'=>'foo']); <span class="comment">//{"name":"foo"}</span>
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