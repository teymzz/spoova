
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          @lay('build.co.links:tutor_pointer') <br>

          <div class="font-em-1d5 c-orange">Mails : sent</div> <br>  
          
          <div class="pulling-data">

              <div class="fb-6">
                  <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                  <div class="flex-full midv"> 
                      <span class="bi-check-circle mxr-8 c-lime-dd"></span> Sent mails
                  </div>
                  </div>
              </div> <br>

              <div class="">

                <div class="">
                    The sent mails are mails that have been truly delivered. The <code>sent</code> 
                    method however, performs more than checking if a mail is truly sent. It can be used to 
                    check if a mail was casted offline too and this is done by supplying the options of either 
                    <code>offline</code> or <code>online</code>
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
    <div class="pxv-6 bc-off-white"><code>Sample: Checking sent mails</code></div>
    <pre class="pre-code">
  &#60;?php

    $mailer = new Mailer;
    
    $mailer->authorize(true);

    $mailer->server('mail.server'); 
    
    $mailer->setup([

        'client' => ['name' => 'Foo']

    ]);

    $mailer->sendmail('mail.template');
    
    if($mail->sent('online') || $mail->sent('offline')) {      

        <span class="comment">
        //... mail was situationally forwarded. 
        </span>

    }
    </pre>
                  </div>
                </div>
              </div>

              <div class=" pvs-6">
                  In the example above, notice that the <code>online</code> and <code>offline</code> 
                  parameters were supplied as strings not constants. The <code>sent('online')</code> 
                  was used to check if a mail was truly sent in online mode. For this to work, success 
                  response has to be returned by the PHPMailer in an online environment after a message 
                  has been sent. If the first test fails, then <code>sent('offline')</code> checks if the 
                  environment was offline and mail was casted in that offline environment. If the second argument 
                  tests postive, then the code block is executed. The second test will only return positive 
                  for an offline environment where a mail is casted. By default, the <code>sent()</code> method is 
                  set for an online environment. So <code>$mail->sent()</code> returns positive only when a message is truly 
                  sent in online environment.
              </div>

          </div> <br>

          @lay('build.co.links:tutor_pointer')

        </div>
      </div>
    </section>

  </div>
      
  @lay('build.co.coords:footer')

@template;