
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
                    <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> Setting up mail server </div>
                  </div>
              </div> <br>
              <div class="">

                <div class="">
                    The <code>setup()</code> method is used to load the default setup either as an array or a file.
                </div>

              </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
              <br>
            
              
              <div>
                  Setting up the mail server through file can be done by returning the PHPMailer server configuration from a 
                  mail setup file. The configurations are set as array and then file is loaded using the <code>setup()</code>
                  method. The method accepts the filename or file path by using the dot convention. for example, a file path of 
                  <code>mail/server.php</code> will be supplied as <code>mail.server</code> . This makes it easier to load the server 
                  config file.
              </div> <br>

              <div class="pvs-6 c-olive">1. File Setup Method</div>

              <div class="file-setup">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample Server File Configuration (server.php)</code></div>
    <pre class="pre-code">

  &#60;?php

    return [
        'SMTPAuth'   => true,  <span class="comment">// Enable SMTP authentication</span>
        'Host'       => 'smtp.mail.com', <span class="comment">// Specify main and backup SMTP servers smtp.gmail.com / website hostname</span>
        'Username'   => 'info@site.com', <span class="comment">// SMTP username e.g info@site.com..</span>
        'Password'   => '123abc',  <span class="comment">// SMTP password  ..</span>
        'SMTPSecure' => 'tls', <span class="comment">// Enable TLS encryption, PHPMailer::ENCRYPTION_STARTTLS`PHPMailer::ENCRYPTION_SMTPS`</span>
        'Port'       => 587,   <span class="comment">// TCP port to connect to (mostly constant)</span>
    ];

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
                  <div class="pvs-6 c-olive">2. Array Setup Method </div>
                  <div class="">
                      The array setup method is done by supplying the configuration arrays themselves 
                      directly into the <code>server()</code> method.
                  </div>
              </div>
              
              <div class="server">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: Server Array Configuration / Modification </code></div>
    <pre class="pre-code">

  &#60;?php

    $mailer = new Mailer;
    
    <span class="comment">// loading array directly</span>
    $mailer->server([
        'SMTPAuth'   => true,  <span class="comment">// Enable SMTP authentication</span>
        'Host'       => 'smtp.mail.com', <span class="comment">// Specify main and backup SMTP servers smtp.gmail.com / website hostname</span>
        'Username'   => 'info@site.com', <span class="comment">// SMTP username e.g info@site.com..</span>
        'Password'   => '123abc',  <span class="comment">// SMTP password  ..</span>
        'SMTPSecure' => 'tls', <span class="comment">// Enable TLS encryption, PHPMailer::ENCRYPTION_STARTTLS`PHPMailer::ENCRYPTION_SMTPS`</span>
        'Port'       => 587,   <span class="comment">// TCP port to connect to (mostly constant)</span>
    ]); 

    </pre>
                  </div>
                </div>
              </div>            
        
          </div>  
          
          <div class="font-em-d8 mvt-10">

              <p>
                  It is however import to note that the array method overides any default configuration set.
              </p>
            
          </div>

        </div>
        
        @lay('build.co.links:tutor_pointer')

      </div>
    </section>
  </div>

  @lay('build.co.coords:footer')

@template;