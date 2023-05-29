
@template('template.t-tut')

  @title('Function: array_delete()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : array_delete</div> <br>  
        

          <div class="">
            <div id="array_delete" class="array_delete">

                <div class="">
                This is used to remove the the relative key of the first occurence of a value in an array
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  array_delete($array, $value)
  <span class="c-sky-blue-dd">
  $array: array which value is expected to be removed
  $value: value which first occurence is removed from array
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $array = [1, 2, 3, 2];

  $array = array_delete($array, 2);

  vdump($array); <span class="comment">//[1, 3, 2]</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $array = ['name'=> 'foo', 'class' => 'bar'];

  $array = array_delete($array, 'foo');

  vdump($array); <span class="comment">//['class'=>'bar']</span>
                  </pre>
                </div>

              
                
            </div>
            <div class="foot-note">
              To remove the entire occurence of a value see <a href="@domlink('docs.functions.modal.array_unset')" class="c-orange-d ch-orange-dd">array_unset()</a> documentation
            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;