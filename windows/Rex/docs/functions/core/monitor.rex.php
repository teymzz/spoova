
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : monitor</div> <br>  
         
          <div class="">
            <div id="monitor" class="monitor">
                
                <div class="">
                  The <code>monitor()</code> function is a live server function. Usually, 
                  the <code>Resource</code> class manages live server control. However, the 
                  <code>monitor()</code> function make it easier to start live server in routes.
                  It is used in routes to start live server if for a reason, a live template file is inaccessible. 
                </div> <br>


            <!-- code line started -->
                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  monitor(); <span class="comment">// start live server </span>
                  </pre>
                </div> <br>                
                <div class="foot-note">
                  Note that when this function is used, the live server will run before the page is rendered. 
                  This may generate some <code class="bd-f">quirks mode</code> error response in console. The best way 
                  to start live server to avoid <code class="bd-f">quirks mode</code> error is to start it in template 
                  files within html tags using the <code class="bd-f">@(@live())@</code> or <code class="bd-f">@(@live)@</code> 
                  directive.
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