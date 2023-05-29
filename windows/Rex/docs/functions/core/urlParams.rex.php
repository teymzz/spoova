
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : urlParams</div> <br>  
         
          <div class="">
            <div id="urlparams" class="urlparams">
                
                <div class="">
                  This function returns the query parameters of a supplied url.
                </div> <br>

                <div class="pre-area shadow mvt-6">
                  <pre class="pre-code">
  $url = 'http://site.com/users?val=foo&var=bar';

  print_r( urlParams($url) ); <span class="comment">// ['val'=>'foo', 'var'=> 'bar']</span>                  
                  </pre>
                </div> <br>
                <div class="foot-note mvt-6">
                  Note that if no argument is supplied, the current page url is assumed to be the 
                  default url.
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