
@template('template.t-tut')

  @title('Function: fromJson()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : fromJson</div> <br>  
        

          <div class="">
            <div id="fromJson" class="fromJson">

                <div class="">
                  This converts a json string or json stdClass object to an array format only.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  fromJson($value)
  <span class="c-sky-blue-dd">
  $value: json string to be converted to array format
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample: fromJson</div>
                  <pre class="pre-code">
  fromJson('{"name":"foo"}'); <span class="comment">//['name'=>'foo']</span>
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