
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-20 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="mails-intro">

              <div class="fb-6">
                  <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                  <div class="flex-full midv"> 
                      <span class="bi-check-square mxr-8 c-lime-dd"></span> authorizing mails 
                  </div>
                  </div> <br>
              </div> <br>

              <div class="">

                <div class="">
                    The <code>authorize()</code> method either prevents or allows a mail to be sent.
                    When set to <code>true</code>, mail will be allowed for forwarding. This can be useful when trying 
                    to preview the mail content output expected to be forwarded as mail.
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
    <div class="pxv-6 bc-off-white"><code>Sample: Authorizing mails</code></div>
    <pre class="pre-code">

    &#60;?php

      $mailer = new Mailer;

      <span class="comment">... //other codes here</span>
      
      $mailer->content('mail.template'); <span class="comment no-select">// can be defined in $mailer->sendmail() </span> 
      
      $mailer->authorize(true);
      
      if($mailer->authorized()){

          $mailer->sendmail(); <span class="comment">// returns true if configuration parameters are set and mail attempted</span>       

      }
      
    </pre>
                  </div>
                </div>
              </div>

              <div class="font-menu pvs-6">
                  Note: when authorized, the <code>sendmail()</code> returns true only if the mail is successfully 
                  configured and an attempt is made to forward the mail. 
                  However, when <code>authorize(false)</code> is used, the sendmail returns true only if the configuration 
                  parameters are set. The example below reveals this.
              </div>

              <div class="mail-authorize">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Preventing mail forwarding</code></div>
    <pre class="pre-code">

    &#60;?php

      $mailer = new Mailer;

      <span class="comment">... //other codes here</span>
      
      $mailer->content('mail.template'); <span class="comment no-select">// can be defined in $mailer->sendmail() </span> 
      
      $mailer->authorize(false);
      
      if($mailer->sendmail()){
      <span class="comment">
        // run this block if parameters are configured
        // note: no attempt is ever made here to send mails 
      </span>       
      }
    </pre>
                  </div>
                </div>
              </div>

              <div class="font-menu pvs-6 font-em-d85">
                  The <code>sendmail()</code> method is not a true way of checking if mail is 
                  successfully sent. This should be handled using the <code>sent()</code> method.
                  The <code>authorize()</code> method can be harvested to only send mails online by 
                  using the <code>online</code> constant which returns true on live environment. An example
                  is shown below:
              </div>            
              
              <div class="mail-authorize">
                <div class="pre-area shadow">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Authorizing mails in live environment</code></div>
    <pre class="pre-code">

    &#60;?php

      $mailer = new Mailer;

      <span class="comment">... //other codes here</span>
      
      $mailer->authorize(online);
      
      if($mailer->authorized()){

          $mailer->sendmail('mail.template'); <span class="comment">// attempt to send mail</span>  

      } else {
      <span class="comment">
          // oops! mail can only be forwarded online
      </span>         
      }
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