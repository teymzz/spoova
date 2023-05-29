
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : recall</div> <br>  
         
          <div class="">
            <div id="authdirect" class="authdirect">
                
                <div class="">
                  The <code>recall()</code> function is an helper function that is 
                  used to obtain static urls stored with the Resource class <code>named()</code> 
                  method.
                </div> <br>


            <!-- code line started -->
                <div class="foot-note">Assuming we have a resource class which stores urls as shown below:</div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  Res::new()

       ->url('res/some-file.js')->named('some-js')
       ->url('res/some-file.css')->named('some-css')
       ->urlClose();

                  </pre>
                </div> <br>

                <div class="foot-note">
                  We can easily call any of the named url with their uniquely specified name
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  var_dump( recall('some-js', 'some-css') );
                  </pre>
                </div>

                <div class="foot-note">
                  This will return a script as shown below:
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code c-dry-blue-d">
  &lt;script src="http://domain/res/some-file.js" /&gt;
  
  &lt;link href="http://domain/res/some-file.css" rel="stylesheet" type="text/css" /&gt;
                  </pre>
                </div> <br><br>       
                
                <div class="foot-note">
                  When resources are binded into a new group name, we can also use this function 
                  to call the binded group.
                </div>
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  Res::new()

       ->url('res/some-file.js')->named('some-js')
       ->url('res/some-file.css')->named('some-css')

       ->bind('some-group', ['some-js', 'some-css'])
       ->urlClose();

                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  var_dump( recall('some-group') );
                  </pre>
                </div>

                <div class="foot-note">
                  This will return a script as similar as before:
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code c-dry-blue-d">
  &lt;script src="http://domain/res/some-file.js" /&gt;
  
  &lt;link href="http://domain/res/some-file.css" rel="stylesheet" type="text/css" /&gt;
                  </pre>
                </div> <br><br> 

                <div class="foot-note">
                  One major thing to note is that relative urls are internally checked before they are 
                  added to the webpage. If a relative path was supplied and the file does not exist, the 
                  file is never added to the web page. However, static files that start with http protocols 
                  are always returned because they are never validated. If a relative path is supplied and the 
                  equivalent script is not returned, then the relative file path supplied is not valid.
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