
@template('template.t-tut')

  @title('Function: refil()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : refil</div> <br>  
        

          <div class="">
            <div id="compile" class="compile">

                <div class="">
                The <code>refil()</code> function returns the second argument supplied if the 
                If a trimmed value of the first argument is not empty.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Sample</div>
                  <pre class="pre-code">
  $value  = 'foo';
  $newval = refil($value, 'bar');

  echo $newval; <span class="comment">//bar </span>
               
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