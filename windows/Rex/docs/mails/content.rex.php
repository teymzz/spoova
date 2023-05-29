
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          @lay('build.co.links:tutor_pointer') <br>

          <div class="font-em-1d5 c-orange">Mails : content</div> <br>  
        
            <div class="mails-intro">

                <div class="fb-6">
                    <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="bi-person mxr-8 c-lime-dd"></span> Setting up mail content 
                    </div>
                    </div> <br>
                </div>

                <div class="">

                  <div class="">
                      The <code>content()</code> method is used to load the content of a mail which
                      of course is the body of the mail. Although the <code>setup</code> is used for setting 
                      headers, the <code>content()</code> method is specifically created to handle the content 
                      (or body) part of the header. The content can either be supplied as a file 
                      path or as a text string. By default, the <code>content()</code> method is set for 
                      string texts. In order to change this default behavior, a second parameter must be supplied
                      that reflects this.
                  </div>

                </div> 
            </div>
         
            <div id="core" class="content"> 
                
                <div>
                    Some few examples below provides a better insight to how this is done.
                </div> <br>

                <div class="file-setup">
                  <div class="pre-area">
                    <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Loading mail content</code></div>
  <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;

    <span class="comment">... //other codes here</span>

    $mailer->content('mail.body', 'file'); <span class="comment">// load as a file</span>    
    
    $mailer->content('Here is a mail text'); <span class="comment">// load as a string</span>    

  </pre>
                </div>
              </div>
            </div> <br>

            <p class="">
                The <code>content()</code> method sets a default mail body. It preferably applied 
                after setting up the mail's default configuration setup although it can be used to 
                as a modifier to a previously declared default body.
            </p>

          </div> 

          @lay('build.co.links:tutor_pointer')

        </div>

      </div>

    
      @lay('build.co.coords:footer')

    </section>

  </div>
@template;