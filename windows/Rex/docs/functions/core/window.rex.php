
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Window</div> <br>  
         
          <div class="">
            <div id="window" class="window">
                
                <div class="">
                  This function is mostly used in window classes. It provides information on the current 
                  window url based on three window url pattern which are specified as 
                  <code class="bd-f pxr-none">root</code>, <code class="bd-f pxr-none">path</code>, <code class="bd-f">base</code>. 
                  Every url in spoova framework is rendered based on these named divisions. 
                </div> <br>

                <div class="foot-note">
                  Assuming we have url samples: 
                </div>

            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <div class="pxv-10 bc-silver">
                    sample urls
                  </div>
                  <pre class="pre-code">
  Localhost:  <span class="c-olive">http://localhost/spoova/</span>docs/functions/core
  
  Remote Url: <span class="c-olive">http://some_site.com/</span>docs/functions/core
                  </pre>
                </div>

                <div class="foot-note">
                  Then using the samples as reference: <br><br>
                  
                  <div class="">
                    <code>window('root')</code>: The first path that exists after the domain name. This will be equivalent to <code class="bd-f">"docs"</code> <br>
                    <code>window('path')</code>: The paths that comes after root path. This will be equivalent to <code class="bd-f">"functions/core"</code> <br>
                    <code>window('base')</code>: All paths that comes after the assumed domain. This is equivalent to <code class="bd-f">"docs/functions/core"</code> 

                  </div> <br>

                  <div class="">
                    It is important to mention that the short form of <code>window('root')</code> is <code>window(':')</code> as they both return the same value.
                    Also, in the course of this tutorial, the word <code>domain</code> will be used as a general representation for 
                    <code>localhost/spoova</code> and <code>some_site.com</code>.
                  </div>

                </div> <br>


                <div class="">
                  <h3 class="c-dodger-blue">Binding Paths</h3>

                  <div class="">
                    The <code>window()</code> function supports path binding which usually involve the prepending of window options returned value with the 
                    specified path supplied along with the argument. Examples of these are shown below:
                  </div>                  
                </div><br>


                <div class="pre-area shadow">
                  <pre class="pre-code">
 window('root:user'); <span class="comment">http://domain/docs/user</span>
                  </pre>
                </div>
                <div class="pre-area shadow">
                  <pre class="pre-code">
 window(':user'); <span class="comment">//same as above</span>
                  </pre>
                </div>
                <div class="pre-area shadow">
                  <pre class="pre-code">
 window(':user.profile'); <span class="comment">http://domain/docs/user/profile</span>
                  </pre>
                </div>
                <div class="pre-area shadow">
                  <pre class="pre-code">
 window('base:user'); <span class="comment">http://domain/docs/functions/core/user</span>
                  </pre>
                </div>

                <div class="font-em-d8">
                  By default, the <code>window()</code> function converts dots to slashes but this 
                  can be prevented by setting the second argument to true as shown below:
                </div>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
 window(':user.profile', true); <span class="comment">http://domain/docs/user.profile</span>
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