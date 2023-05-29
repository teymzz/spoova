
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Scheme</div> <br>  
         
          <div class="">
            <div id="scheme" class="scheme">
                
                <div class="">
                The scheme function returns the basic app namespace that is eqivalent to 
                <code>{{ scheme('') }}</code>. Usually, when supplied with argument, the app's 
                namespace will be prefixed to the value supplied. It is also important to note 
                that all frontslashes are converted to backslash.
                </div> <br>

                <div class="pre-area shadow">
                    <pre class="pre-code">
  scheme(''); <span class="comment">// returns <span class="c-dry-blue-dd">{{ scheme('') }}</span></span>
                    </pre>    
                </div>

                <div class="pre-area shadow">
                    <pre class="pre-code">
  scheme('Some/Path'); <span class="comment">// returns <span class="c-dry-blue-dd">{{ scheme('Some/Path') }}</span> </span>
                   </pre>    
                </div>

                <div class="mvs-10 font-em-d9">
                    The prefix trailing slash can be removed setting the second argument as false.
                </div>

                <div class="pre-area shadow">
                    <pre class="pre-code">
  scheme('Some/Path', false); <span class="comment">// returns <span class="c-dry-blue-dd">{{ scheme('Some/Path', false) }}</span> </span>
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