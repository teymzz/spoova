
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="resource-intro">
            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-person mxr-8 c-lime-dd"></span> Setting up mail headers 
                </div>
                </div> <br>
            </div> <br>
            <div class="">

              <div class="">
                  The <code>server()</code> method is used to load the default setup either as an array or a file.
              </div>

            </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
            <br>
            
            <div>
                Setting up the mail headers as default through file can be done by setting up the web mail clients using 
                the reserved variable <code>$webmail</code> within a file and using the <code>setup()</code> to load that file.
                The method accepts the filename or file path by using the dot convention. for example, a file path of 
                <code>mail/setup.php</code> will be supplied as <code>mail.setup</code> . This makes it easier to load the server 
                default headers.
            </div> <br>

            <div class="pvs-6">1. File Setup Method</div>

            <div class="file-setup">
              <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Setup File Configuration (setup.php)</code></div>
  <pre class="pre-code">

  &#60;?php

    <span class="comment">// default configuration settings for mail</span>
    $webmail['site']['mail']  = 'info@site.com';  <span class="comment">// website mail e.g info@site.com</span>
    $webmail['site']['name']  = 'website'; <span class="comment">       // mail header name or site name</span>

    <span class="comment">//default content settings - should be set later</span>
    $webmail['header'] = ''; <span class="comment">// optional - mail title e.g Welcome to ...</span>
    $webmail['body']   = ''; <span class="comment">// optional - mail content string or file</span>

    <span class="comment">//default user details - should be set later</span>
    $webmail['client']['mail'] = ''; <span class="comment">// optional- user email</span>
    $webmail['client']['name'] = ''; <span class="comment">// optional- user name</span> 

  </pre>
                </div>
              </div>
            </div>

            <div class="server">
              <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Loading Server File</code></div>
  <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;

    $mailer->server('server'); <span class="comment">// e.g server.php</span>

  </pre>
                </div>
              </div>
            </div> <br>

            <div class="array-loading">
                <div class="pvs-6">2. Sync Setup Method </div>
                <div class="">
                    The array setup method is done by supplying the configuration arrays themselves 
                    directly into the <code>sync()</code> method. This method is used to modify default 
                    configurations on the go before forwarding the message. This is discussed 
                    <a href="@domurl('docs/mails/sync')">here</a> .
                </div>
            </div>
              
          </div>  <br>

        @lay('build.co.links:tutor_pointer')

        </div>
      </div>
    </section>

  </div>
    
    @lay('build.co.coords:footer')

@template;