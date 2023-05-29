
@template('template.t-tut')

  @title('Function: href()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : href</div> <br>  
        

          <div class="">
            <div id="href" class="href">

                <div class="">
                  This function converts the urls in a text or string to an html link.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                  <pre class="pre-code">
  href($string, $wrapper)
  <span class="c-sky-blue-dd"> 
  $string  : supplied string
  $wrapper : an html wrapper tag
  </span> 
                  </pre>
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                  <pre class="pre-code">
  vdump( href("url : http://somesite.com") );
                  </pre>
                </div>
                <div class="foot-note">
                  The result of the string above is shown below
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 1 result</div>
                  <pre class="pre-code">
  url : &lt;a href="http://somesite.com"&gt; http://somesite.com &lt;/a&gt;
                  </pre>
                </div>

                <div class="foot-note">
                  We also can add a wrapper tag as shown below:
                </div>

                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                  <pre class="pre-code">
  vdump( href('url : http://somesite.com', 'span id="link"') );
                  </pre>
                </div>
                <div class="foot-note">
                  The result of the wrapper string above is shown below
                </div>
                
                <div class="pre-area shadow mvt-16">
                  <div class="pxv-10 bc-silver">Sample 2 result</div>
                  <pre class="pre-code">
            
  url :
   
  &lt;span id="link"&gt; 
    &lt;a href="http://somesite.com"&gt; http://somesite.com &lt;/a&gt;
  &lt;/span id="link"&gt; 

                  </pre>
                </div>
                <div class="foot-note">
                  Note that the tags were separated on a different line above to provide a better 
                  view. The returned response is usually on a single line.
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