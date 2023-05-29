
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : url</div> <br>  
         
          <div class="">
            <div id="url" class="url">
                
                <div class="">
                The <code>url()</code> function is used to return the <code>Url</code> class which is used 
                to manage urls. It takes only one argument which is the test url and returns the instance 
                of the Url class. You can learn more about url class from <a href="@domurl('docs/classes/url')"><span class="c-olive hyperlink">here</span></a>                
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  url('http://site.com/users#profile')->hash(); <span class="comment">// profile</span> 
                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  url('http://site.com/users?val=foo&var=bar')->query(); <span class="comment">// ['val'=>'foo', 'var'=> 'bar'] </span> 
                  </pre>
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  vdump( url('index')->is('index') ); <span class="comment">// true </span> 
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