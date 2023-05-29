
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          @lay('build.co.links:tutor_pointer') <br>

          <div class="font-em-1d5 c-orange">Mails</div> <br>  
          
          <div class="resource-intro">
              <div class="">

                <div class="">
                  Sending mails in spoova is done through the <code>Mailer</code> class. 
                  The functionality of this class is made possible through the combination of third party 
                  plugins which are PhpMailer and CssInliner. The <code>Mailer</code> class ensures that mails 
                  can be generated from template files and forwarded as mail. It also enables functionalities such as 
                  performing dummy tests for mails and also viewing lasting effect of mails.
                </div> <br>

                <div class="">
                  <div class="fb-6 c-orange-d">Installation</div>
                  <div class="mvs-10">
                    In order to use the Mailer class, the PHPMailer and CssInliner libraries must be installed as dependencies. The composer.json file 
                    should contain a similar code syntax below 
                    can be used to install the supported version of these classes.
                  </div>
                  <div class="pre-area">
                    <pre class="pre-code">
  {
    require: {
      'phpmailer/phpmailer' : '^6.0',
      'pelago/emogrifier' : '^6.6'
    }
  }
                    </pre>
                  </div>
                  <div class="foot-note">
                    Once the dependencies are installed through the <code>composer dump-autoload -o</code>, then we need to modify the <code>CssInliner</code> 
                    class <code>__construct()</code> method in order for <code>Mailer</code> class to work. This method should be set as public rather than private. 
                    Once this is done, we can proceed to set up the configuration files. 
                  </div>
                </div> <br>

                  Before the <code>Mailer</code> class can be used, there is need to set up the mailer system. Setting up mail system can be addressed in two categories 
                  <br>
                  <ul>
                    <li>mail configuration setup</li>
                    <li>mail content setup</li>
                  </ul>
                  
              </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
              <br>
              <div class="fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> Setting up mail - config </div>
              </div> <br>
              
              <div>
                  The mail configuration is done for two systems which are <code class="fb-6">server</code> and <code class="fb-6">headers</code> configurations. 
                  Both of this systems can be set up as default (using files) or within the code. It is however advisable to 
                  have a default configuration which can be updated when necessary.
              </div> <br>

              <div class="server">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample Server configuration (server.php)</code></div>
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
    <div class="pxv-6 bc-off-white"><code>Sample Content configuration (headers.php)</code></div>
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
        
          </div>  
          
          <div class="foot-note">

          <ul>
            <li>
              In the examples above, we have two files 
              <code class="bd-f">server.php</code> and <code class="bd-f">headers.php</code>.
              The <code>server.php</code> is used to setup the phpMailer server 
              according to the PHPMailer Documentation. The <code>headers.php</code>
              is a default file that anchors the PHPMailer headers.
            </li>
            <li>
              The <code>$webmail</code>
              is a reserved variable that anchors PHPMailers headers' values. Although the 
              <code>$webmail['body']</code> can be configured here, it is not advisable to do so as 
              the content may change from time to time depending on what type of mail is expected 
              to be sent. 
            </li>
            <li>
              The <code>$webmail['client']['mail']</code> refers to user email to which
              the mail is expected to be forwarded while the <code>$webmail['client']['name']</code>
              is the user name. Both of the <code>$webmail['client']</code> can easily change, therefore, 
              setting them within the <code>header</code> file is not realistic.
            </li>
            <li>
              After setting up the default parameters, the files can be loaded up when using the Mailer tool. 
              The example below shows how the <code>server.php</code> and <code>headers.php</code> files can be
              imported.
            </li>
          </ul>
            <p>
            </p>
            
            <p>
            </p>
            
            <p>
            </p>

          </div>
          
          <p class="">
          </p>
          <div class="mailer">
                <div class="pre-area">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample loading configuration files</code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-purple">use spoova\mi\core\classes\Mailer</span>

    $mail = new Mailer;  <span class="comment">// Mailer instantiation</span>

    $mail->server('server'); <span class="comment">  // add server.php (accepts dots for paths)</span>
    $mail->setup('headers'); <span class="comment">  // add headers.php (accepts dots for paths)</span>
    
    $mail->authorize(true); <span class="comment">  // allow sending of mails </span>
    
    <span class="comment no-select">#update mail headers </span>
    $mail->sync('header', 'Notice'); <span class="comment">  // mail subject </span>
    $mail->sync('client', ['user'=>'foo', 'name' => 'bar']); <span class="comment">  // mail subject </span>

    <span class="comment no-select">#send mail</span>
    $mail->sendmail();

    if($mail->sent('online') || $mail->sent('offline')) {

      print 'mail successfully sent';

    }
    </pre>
                  </div>
                </div>
        </div> 

        <div class="font-em-d95 mvt-6">
            <p>
              In the example above, <code>$mailer->server()</code> and <code>$mailer->setup()</code> are used to 
              load the default server config and server header respectfully from a config file or array.
            </p>
            
            <p>
              The <code>$mail->authorize()</code> either allows or prevents a mail from 
              sending as a means of testing. Setting it as false will prevent the 
              <code>$mailer->sendmail()</code> method from sending out mails when used. 
              This helps to suppress errors especially when working in offline environment. 
              Spoova's <code>online</code> constant can then come into play as <code>online</code>
              returns true in live or online environment. This can then be rewritten to send mails only in online 
              environment as <code>$mail->authorize(online)</code>. For example: <br>

              <div class="authorize">
                <div class="pre-area fix">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: mail authorize</code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-sky-blue-dd">...</span>
    
    $mail->authorize(online); <span class="comment">  // allow sending of mails online </span>
    
    <span class="comment no-select">#update mail headers </span>
    $mail->sync('header', 'Notice'); <span class="comment">  // mail subject </span>
    $mail->sync('client', ['user'=>'foo', 'name' => 'bar']); <span class="comment">  // mail subject </span>

    <span class="comment no-select">#send mail if authorized</span>
    if($mail->authorized()){

      $mailer->sendmail('Hi there, this is a mail');

    } 
    </pre>
                  </div>
                </div>
        </div> 
            </p>
            
            <p>
              The <code>$mail->sync()</code> method is used to update the default header configurations just as
              seen above. It synchronizes new data supplied with the old data set. The <code>mail->authorized()</code> can 
              be used to check if a mail is authorized or not. This may prove useful when handling mails with different 
              configurations or setup.
            </p>

            <p>
            The last part which is <code>$mailer->sendmail()</code> is used to send a mail content. The content supplied serves as the 
            body of the mail headers. Although a string can be forwarded from the sendmail option. It is preferred that this should be 
            a file instead. The Mailer system allows that html mail pages can be sent. By default, it also accepts embeded css stylesheets. 
            This means that an html page can be forwarded as a mail. However, it is important to stick with either embedded or inline css 
            when writing mail pages or mail template pages to prevent undesired results.
            </p>

            <div class="pre-area fix">
                  <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Sample: template content loading </code></div>
    <pre class="pre-code">
  &#60;?php

    <span class="c-sky-blue-dd">...</span>
      
    if($mail->authorized()){

      $mailer->sendmail( Res::markup('mail-temp.feedback', fn() => compile()) );

    } 
    </pre>
                  </div>
            </div> <br><br>  
            
            <div class="font-em-1">
              <p>
                Since the <code>Res::markup()</code> prevents <code>compile()</code> from displaying a content, 
                but instead returns the content of a rex file, a template processed page can be forwarded as a mail. 
                However, the mailer tool has its internal way of handling template files. In order to send a raw file,
                The <code>$mailer->content('filename.php')</code> must be set where <code>filename.php</code> is the name 
                or path of the file. Supported files include <span class="c-orange-dd">xml, txt, html and php.</span> 
                You can learn more about this on the <a href="@Domurl('docs/mails/templating')"><span class="c-olive">templating</span></a> page.
              </p>
  
              <div>
                Below are lists of the available mailer methods. <br><br>
  
                <ul class="c-olive">
                  <li> <a href="@domurl('docs/mails/server')"> server </a></li>
                  <li> <a href="@domurl('docs/mails/setup')"> setup </a></li>
                  <li> <a href="@domurl('docs/mails/content')"> content </a></li>
                  <li> <a href="@domurl('docs/mails/sync')"> sync </a></li>
                  <li> <a href="@domurl('docs/mails/inject')"> inject </a></li>
                  <li> <a href="@domurl('docs/mails/authorize')"> authorize </a></li>
                  <li> <a href="@domurl('docs/mails/authorized')"> authorized </a></li>
                  <li> <a href="@domurl('docs/mails/pull')"> pull </a></li>
                  <li> <a href="@domurl('docs/mails/info')"> info </a></li>
                  <li> <a href="@domurl('docs/mails/attempted')"> attempted </a></li>
                  <li> <a href="@domurl('docs/mails/casted')"> casted </a></li>
                  <li> <a href="@domurl('docs/mails/sent')"> sent </a></li>
                  <li> <a href="@domurl('docs/mails/response')"> response </a></li>
                </ul>
              </div>
            </div>
          </div>

          @lay('build.co.links:tutor_pointer')

        </div>

      </div>

    </section>

  </div>
      
  @lay('build.co.coords:footer')

@template;