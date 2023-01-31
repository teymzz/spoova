
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Functions - Scripts</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Script functions are predefined spoova functions that depends on javascript to run 
                or function. They use javascript predefined functions to execute their functions. 
                These functions are listed and explained below.
                <br>
            </div> 
          </div>    
          
          <!-- alert -->
          <div id="alert" class="alert" style="padding:0"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">1. alert</div>
            </div> <br>
            
            <div>
                This uses javascript alert function to display items. Array or string urls are converted to 
                json format while other strings maintain their form.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  alert(10);

  <span class="comment">//alerts 10</span>  
              </pre> 

            </div>
            <!-- code line ended -->

          </div>     

          <!-- javaconsole -->
          <div id="javaconsole" class="javaconsole"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">2. javaconsole</div>
            </div> <br>
            
            <div>
                This uses javascript console.log function to log information into browser console.
                When multiple arguments are supplied, each argument is logged on a separate line.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  javaconsole(10);

  <span class="comment">//displays 10 in developer's console</span> 


  javaconsole('me', 50);

  <span class="comment">//displays 'me' and 50 in developer's console on separate lines</span>
              </pre>

            </div>
            <!-- code line ended -->

          </div>    

          <!-- script -->
          <div id="script" class="script"> 
            <br>
            <div class="lacier font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8">
              <div class="flex-full">3. script</div>
            </div> <br>
            
            <div>
                This uses javascript tags to execute function. The javascript codes supplied are injected 
                into the javascript tags and then processed. All data supplied are expected to be
                raw javascript codes. The code supplied are however not processed unless a second argument 
                is supplied.
            </div> <br>

            <!-- code line started -->
            <div class="pre-area shadow">

              <pre class="pre-code">
  script('console.log('foo')', 1);
   
  <span class="comment">//displays foo in console</span>
              </pre>

            </div>
            <!-- code line ended -->

          </div>      
        
        </div>

      </div>
      
    </section>

  </div>
  
  @lay('build.co.coords:footer')


@template;