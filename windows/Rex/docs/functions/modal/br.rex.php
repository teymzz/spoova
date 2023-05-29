
@template('template.t-tut')

  @title('Function: br()')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : Br</div> <br>  
        

          <div class="">
            <div id="compile" class="compile">

                <div class="">
                The <code>br()</code> function breaks a line both within cli and on web pages. When 
                working on cli, the <code>br()</code> automatically converts to <code>PHP_EOL</code> 
                while outside cli the break tag <code>&lt;br&gt;</code> is used.
                </div> <br>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Syntax</div>
                <pre class="pre-code">
  <span class="comment">br($value, $breaks);</span>

  <span class="c-sky-blue-dd">
  $value: string 
  $breaks: number of breaks after
  </span> 
                </pre>

                </div>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Sample 1</div>
                <pre class="pre-code">
  echo "Break after this". br('A new line');

  <span class="c-sky-blue-dd">
  //html result:
  </span> 
  <span class="comment">Break after this &lt;br&gt; A new line</span>
  <span class="c-sky-blue-dd">
  //cli result:
  </span> 
  <span class="comment">'Break after this'. PHP_EOL . 'A new line'</span>
                </pre>

                </div>

                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver">Sample 2</div>
                <pre class="pre-code">
  echo "Break after this". br('A new line', 2);

  <span class="c-sky-blue-dd">
  //html result:
  </span> 
  <span class="comment">Break after this &lt;br&gt;&lt;br&gt; A new line</span>
  <span class="c-sky-blue-dd">
  //cli result:
  </span> 
  <span class="comment">'Break after this'. PHP_EOL.PHP_EOL . 'A new line'</span>
                </pre>

                </div>
          
                <div class="foot-note">
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