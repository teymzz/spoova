@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Mails</div> <br>  
        
        <div class="mails-intro">

            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-check-square mxr-8 c-lime-dd"></span> 
                    checking authorized mails 
                </div>
                </div>
            </div> <br>

            <div class="">

              <div class="">
                  The <code>authorized()</code> method is used to check if a mail has been permitted
                  to send. 
                  page. An example is shown below.
              </div>

            </div> 
         </div> <br>
         
        <div id="authorized" class="content"> 

            <div class="file-setup">
              <div class="pre-area">
                <div class="mox-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Checking Authorized mails</code></div>
  <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;

    <span class="comment">... //other codes here</span>
    
    $mailer->content('mail.template'); <span class="comment no-select">// can be defined in $mailer->sendmail() </span> 
    
    $mailer->authorize(true);
    
    if($mailer->authorized()){

        <span class="comment">// run this block if mail is authorized </span>       

    }


  </pre>
                </div>
              </div>
            </div>

            <div class="font-menu pvs-6">
                To see more details about its usage check the <a href="@domurl('tutorial/mails/authorize')">authorize</a> page
            </div>


        </div> <br>

        @lay('build.links:tutor_pointer')

    </div>
    
    @lay('build.coords:footer')


@template;