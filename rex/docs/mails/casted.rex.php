@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Mails</div> <br>  
        
        <div class="pulling-data">

            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-share mxr-8 c-lime-dd"></span> Casted mails
                </div>
                </div>
            </div> <br>

            <div class="">

              <div class="">
                  The casted mails are mails that have been properly configured and attempted to send. 
                  This mail may be sent or not sent naturally due to offline mode. Howvever, they have been 
                  authorized to send. It is an higher level testing that does not require mails to be truly 
                  sent even when they were sent. All mails that were sent but failed to deliver and those that 
                  were truly delivered fall into the category of casted mails. This means that for a mail to be
                  casted, it must have been sent or attempted. The casted method is however used to test the environment 
                  in which a mail was attempted.
              </div>

            </div> 
         </div> <br>
         
        <div id="pull" class="content"> 
            
            <div>
                The example below provides an insight into how this is done.
            </div>

            <div class="file-setup">
              <div class="pre-area">
                <div class="mox-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Checking casted mails</code></div>
  <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;
    
    $mailer->server('mail.server'); <span class="comment no-select">// load server config file </span> 
    
    $mailer->setup([

        'client' => ['name' => 'Foo']

    ]);

    $mailer->sendmail('mail.template');
    
    if($mail->casted(!online)) {        
        <span class="comment">
        //... mail was forwarded in while offline. 
        </span>
    }
  </pre>
                </div>
              </div>
            </div>

            <div class="font-menu pvs-6">
                In the example above, the <code>casted()</code> method was used to check 
                if attempt to send a mail was done while in offline environment. This may be 
                helpful in code structuring and organization.
            </div>

        </div> <br>

        @lay('build.links:tutor_pointer')

    </div>
    
    @lay('build.coords:footer')


@template;