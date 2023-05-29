
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          @lay('build.co.links:tutor_pointer') <br> 

          <div class="font-em-1d5 c-orange">Mails : info</div> <br>  
          
          <div class="pulling-data">

              <div class="fb-6">
                  <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                  <div class="flex-full midv"> 
                      <span class="bi-check-square mxr-8 c-lime-dd"></span> Fetching mail data 
                  </div>
                  </div>
              </div> <br>

              <div class="">

                <div class="">
                    The <code>info()</code> method returns the value of a specified key in the headers 
                    data set.
                </div>

              </div> 
          </div> <br>
          
          <div id="pull" class="content"> 
              
              <div>
                  The example below provides an insight into how this is done.
              </div>

              <div class="file-setup">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Fetching mail header data</code></div>
    <pre class="pre-code">
  &#60;?php

    $mailer = new Mailer;
    
    $mailer->server('mail.server'); <span class="comment no-select">// load server config file </span> 
    
    $mailer->setup([

        'client' => ['name' => 'Foo']

    ]);

    $mailer->info('client'); <span> <span class="comment no-select">// returns: ['name'=>'Foo']</span></span>
    </pre>
                  </div>
                </div>
              </div>

          </div> <br>

          @lay('build.co.links:tutor_pointer')

        </div>
      </div>
    </section>

  </div>

  @lay('build.co.coords:footer')

@template;