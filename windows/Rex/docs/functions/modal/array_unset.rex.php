
@template('template.t-tut')

  @title('Function: array_unset()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : array_unset</div> <br>  
        

          <div class="">
            <div id="array_unset" class="array_unset">

                <div class="">
                This is used to remove the the relative key of the entire occurence of a value in an array
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  array_unset($array, $value)
  <span class="c-sky-blue-dd">
  $array: array which value is expected to be removed
  $value: value which entire occurence is removed from array
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  $array = [1, 2, 3, 2];

  $array = array_unset($array, 2);

  vdump($array); <span class="comment">//[1, 3]</span>
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  $array = ['a'=>'foo', 'b'=>'bar', 'c'=>'foo'];

  $array = array_unset($array, 'foo');

  vdump($array); <span class="comment">//['b'=>'bar']</span>
                  </pre>
                </div>

              
                
            </div>
            <div class="foot-note">
              To remove the first occurence of a value see <a href="@domlink('docs.functions.modal.array_delete')" class="c-orange-d ch-orange-dd">array_delete()</a> documentation
            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;