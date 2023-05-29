
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Vdump</div> <br>  
         
          <div class="">
            <div id="vdump" class="vdump">
                
                <div class="">
                  The <code>vdump</code> function is used to dump the data type of a value or variable 
                  supplied. It also provides a much cleaner view for data types which can be objects, 
                  arrays, strings, floats, integers and null values.
                </div> <br>


            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample array
                  </div>
                  <pre class="pre-code">
  vdump([1, 2, 3], 2, '3', 4.5); <span class="comment">//display data and exit page</span>
                  </pre>
                </div>

                <div class="foot-note">
                  Each of the arguments data type will be returned respectively as shown below. However, 
                  it is important to note that once a <code>vdump()</code> is used, the page will resolve 
                  to an exit. This means that no operation can be peformed later. This is also the reason 
                  why all the data types are supplied at once since it is capable of taking multiple arguments.
                </div> <br>

                <div class="pre-area shadow pxs-10 pvt-10">
                  <pre class="">
  {{ vdump([1, 2, 3], 2, '3', 4.5) }}
                  </pre>
                </div> <br><br>

                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample array
                  </div>
                  <pre class="pre-code">
  vdump([1, 2, 3]); <span class="comment">//display data</span>
                  </pre>
                </div>

                <div class="pre-area shadow pxs-10 pvt-10">
                  <pre class="">
  {{ vdump([1, 2 , 3]) }}
                  </pre>
                </div> <br> 
                
                

            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;