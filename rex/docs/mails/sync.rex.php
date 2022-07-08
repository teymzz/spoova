@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Mails</div> <br>  
        
        <div class="mails-intro">

            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-update mxr-8 c-lime-dd"></span> Synchronizing mail content 
                </div>
                </div> <br>
            </div> <br>

            <div class="">

              <div class="">
                  The <code>sync()</code> method is used to update headers. It updates the previously set 
                  headers such as the mail recipients. When this is used, it overides or modifies the default 
                  <code>$webmail</code> data set. Unlike inline configuration, it can be used to modify file 
                  attachments and supports multiple files.
              </div>

            </div> 
         </div>
         
        <div id="core" class="content"> 
            <br>
           
            
            <div>
                Some few examples below provides a better insight to how this is done.
            </div> <br>

            <div class="file-setup">
              <div class="pre-area">
                <div class="mox-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Loading mail content</code></div>
  <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;

    <span class="comment">... //other codes here</span>

    $mailer->content('mail.body', 'file'); <span class="comment">// load as a file</span>    
    
    $mailer->sync('client', ['user' => 'foo@mail.com', 'name' => 'foo']); 

    $mailer->sync('file', ['http://site.com/filepath.ext']); <span class="comment">// file attachment</span>

  </pre>
                </div>
              </div>
            </div>

        </div> 

        @lay('build.links:tutor_pointer')

    </div>
    
    @lay('build.coords:footer')


@template;