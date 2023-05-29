
@template('template.t-tut')

  @title('Function: array_object()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : array_object</div> <br>  
        

          <div class="">
            <div id="array_object" class="array_object">

                <div class="">
                This function converts an array to a stdClass object in which all values 
                are maintained.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  array_object($value)
  <span class="c-sky-blue-dd">
  $value: value expected to be converted
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $object = array_object(['gender' => 'male']);

  vdump($object->gender); <span class="comment">//male</span>
                  </pre>
                </div>

                <div class="foot-note">
                  It should be noted that when values which are not of array data type are 
                  supplied, the value is returned as supplied:
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $object = array_object(1);

  vdump($object); <span class="comment">//1</span>
                  </pre>
                </div>

                <div class="foot-note">
                  In order to keep the data supplied as array only, see 
                  <a href="@domlink('docs.functions.modal.tostdClass')" class="hyperlink c-orange-d ch-orange-dd">tostdClass()</a> documentation
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