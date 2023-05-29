
@template('template.t-tut')

  @title('Function: tostdClass()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : tostdClass</div> <br>  
        

          <div class="">
            <div id="tostdClass" class="tostdClass">

                <div class="">
                This function converts an array to a stdClass object in which all values 
                are maintained.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  tostdClass($array)
  <span class="c-sky-blue-dd">
  $array: array value expected to be converted
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $object = tostdClass(['gender' => 'male']);

  vdump($object->gender); <span class="comment">//male</span>
                  </pre>
                </div>

                <div class="foot-note">
                  It should be noted that when values which are not of array data type are 
                  supplied an error is thrown.
                  This function is depedent upon the 
                  <a href="@domlink('docs.functions.modal.array_object')" class="c-orange-d ch-orange-dd">array_object()</a> function
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