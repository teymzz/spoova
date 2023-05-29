
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : webClass</div> <br>  
         
          <div class="">
            <div id="webclass" class="webclass">
                
                <div class="">
                    The framework's core classes are located in the <code>core/classes</code>. The <code>webClass()</code> 
                    methods loads classes from <code>spoova\mi\core\classes</code> namespace. 
                    In the line below, both line 1 & 2 resolves to the same class.
                </div> <br>

                <div class="pre-area shadow">
                    <pre class="pre-code">
  $myclass1 = new spoova\mi\core\classes\Myclass;
                    </pre>    
                </div><br><br>

                <div class="pre-area shadow">
                    <pre class="pre-code">
  $myclass2 = webClass('Myclass'); <span class="comment">//same as above</span>
                   </pre>    
                </div>

                <div class="mvs-10 font-em-d9">
                    Note that if the supplied class cannot be found, a false value will be returned.
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