
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="mails-intro">

              <div class="fb-6">
                  <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="bi-update mxr-8 c-lime-dd"></span> Injecting template variables 
                    </div>
                  </div>
              </div> <br>

              <div class="">

                <div class="">
                    The <code>inject()</code> method is used to inject local variables into the mail template files
                    which can later be accessed by using placeholder with a dollar sign <code> @({{$ }})@ </code>
                </div>

              </div> 
          </div>
          
          <div id="core" class="content"> 
              <br>
            
              
              <div>
                  Some few examples below provides a better insight to how this is done.
              </div> <br>

              <div class="file-setup">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Injecting local variables</code></div>
    <pre class="pre-code">
    &#60;?php

      $mailer = new Mailer;

      <span class="comment">... //other codes here</span>
      
      $mailer->content('mail.template'); <span class="comment no-select">// can be defined in $mailer->sendmail() </span> 

      $mailer->inject(['name' => 'Foo']); 

      $mailer->sendmail(); 

    </pre>
                  </div>
                </div>
              </div>
              <div class="file-setup">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: File Template (mail/template.php)</code></div>
    <pre class="pre-code">

    &#60;?php

      Hi there @({{ $name }})@ <span class="comment">// rendered as Hi there Foo</span>

    </pre>
                  </div>
                </div>
              </div>

          </div>  <br>

          <div class="font-menu">
              The mail template file accepts pushing forward requests as either get or post request. 
              However, this must be defined in the placeholder.
          </div>


          @lay('build.co.links:tutor_pointer')

        </div>
      </div>
    </section>

  </div>
      
      @lay('build.co.coords:footer')

@template;