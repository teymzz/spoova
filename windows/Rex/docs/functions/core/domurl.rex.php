
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : domUrl</div> <br>  
         
          <div class="">
            <div id="ishttp" class="ishttp">
                
                <div class="">
                  The <code>domUrl()</code> function is used to map static files to the current 
                  window as long as the path is accessible. Assuming we have a file in the global 
                  <code>res/</code> directory. We can map the file easily by using the <code>domurl()</code>
                  function. This will ensure that the file loaded is properly mapped to the current window on 
                  either a local or a remote url.
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo domurl('res/some-image.jpg');
                  </pre>
                </div> <br>

                <div class="foot-note">
                  The value returned above will resemble a format like:
                </div>
                
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 http://domain/res/some-image.jpg
                  </pre>
                </div> <br>

                <div class="foot-note">
                  The <code>domain</code> section can be <code>localhost/project_folder</code> or some online 
                  domain like <code>somesite.com</code>. This behavior is handled internally depending on the 
                  current environment of work. Also, when this function is used, the last url supplied is usually 
                  tracked by default. Which can be obtained later from the <code>Domurl</code> class.
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 echo domurl('res/some-image.jpg');

 echo GET(DomUrl::last()); <span class="comment">// http://domain/res/some-image.jpg</span>
                  </pre>
                </div> <br>

                <div class="foot-note">
                  Note that the tracking of supplied urls is useful within template files. However, the path tracking may be 
                  avoided by setting the second argument as <code class="bd-f pxr-none">false</code> .
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