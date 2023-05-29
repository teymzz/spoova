
@template('template.t-tut')

  @title('Function: base_decode()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : base_decode</div> <br>  
        

          <div class="">
            <div id="base_decode" class="base_decode">

                <div class="">
                  This is the same as the php <code>base64_decode()</code>. 
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  base_decode($value)
  <span class="c-sky-blue-dd">
  $value: value to be encoded
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: base64_decode</div>
                  <pre class="pre-code">
  base64_decode('YWI'); <span class="comment">//ab</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: base_decode</div>
                  <pre class="pre-code">
  base_decode('YWI'); <span class="comment">//ab</span>
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