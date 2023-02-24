@template('template.t-tut')

    @lay('build.co.navbars:left-nav')
    
    <div class="box-full pxl-2 bc-white pull-right">
      <div class="pxv-20 tutorial mails c-black-ll">
        
        @lay('build.co.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Mails</div> <br>  
        
        <div class="pulling-data">

            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> 
                    <span class="bi-window mxr-8 c-lime-dd"></span> Templating
                </div>
                </div>
            </div> <br>

            <div class="">

              <div class="">
                  Templating involves the use of template files to handle mails. These template 
                  files can contain series of placeholders that are used to obtain variables that 
                  are later expected to be injected or passed across to them. These template files can 
                  later be loaded, rendered and forwarded as mail using either the 
                  <a href="@domurl('docs/mails/content')">content()</a> or the 
                  <code>sendmail()</code> method. When handling template files, 
                  there are few things to take note <br><br>

                  <ul>
                      <li>Template files can be used to update default header configuration settings</li>
                      <li>
                          Placeholders are supplied as double curly brackets along with a dollar sign 
                          i.e <code>@({{ $var }})@</code> where <code>$var</code> is the name of injected variable.
                      </li>
                      <li>
                          Variables can be injected as local or global variables. Local variables are injected using the 
                            <code class="bg-primary c-white">
                              <a href="@domurl('docs/mails/inject')" class="i c-white">
                                  <span class="c-white">inject()</span>
                              </a>
                            </code> method
                      </li>
                  </ul>
              </div>

            </div> 
        </div> <br>
        
        <div class="">
            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="bi-person mxr-8 c-lime-dd"></span> Configuring Headers - Template File
                    </div>
                </div>
            </div> <br>
            <div class="">
                
                <div class="">  
                    Aside from the <code>setup()</code> method, the template file also be used to configure headers. This is 
                    useful when handling html or txt files. The <code>@</code> symbol is used to process this just as displayed 
                    below. 
                </div>

                <div class="">
                <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Template File With Headers</code></div>
  <pre class="pre-code">
  &#60;setup type="config"&#62;
    @site_name 	: 	{mysite}
    @site_mail 	: 	{mysite@osomething.com}
    @client_name: 	{user name}
    @client_mail: 	{user@something.com}
    @file 	: 	{[user/var/res/myfile.jpg] [myfile.php]}
    @file 	: 	{[myfile/var/filename.php]}
  &#60;/setup&#62;

  <?=
  
  to_lgts('
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
  </head>
  <body>
      
  </body>
  </html>  
  ')

  ?>

  </pre>
                </div>
              </div>
                </div>

            </div>
        </div>

        <div class="font-menu pvs-6">
            In the above, the <code>setup</code> data will be used as mail headers when 
            forwarding a mail. Every parameter is just as similar to the <code>$webmail</code> 
            parameters discussed in <a href="@domurl('docs/mails/setup')">setup</a>. However, 
            when handling multiple files, multiple files should be placed in their own specific angle
            brackets within the curly brackets and separated only by a space just as relayed above. 
            It is not encouraged to do this often.
        </div>
        <div class="">
            <div class="fb-6">
                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                    <div class="flex-full midv"> 
                        <span class="mxr-8 c-lime-dd">@({{ }})@</span> Template File - Placeholders
                    </div>
                </div>
            </div> <br>
            <div class="">
                
                <div class="">  
                    Placeholders are accesssed in 5 different ways: <br> <br>
                    <ul>
                        <li>As a injected local variable</li>
                        <li>As a global variable</li>
                        <li>As a post request</li>
                        <li>As a get request</li>
                        <li>As a post or get request</li>
                    </ul> 
                    
                </div>

                <div class="">
                <div class="pre-area">
                <div class="box-full">
  <div class="pxv-6 bc-off-white"><code>Sample: Mailer File </code></div>
  <pre class="pre-code">

    <span class="comment">// ...Define some default request variables</span>
    $_GET['type'] = 'isGet';

    $_POST['method'] = 'isPost';
    
    <span class="comment">//.. Define a global variable</span>
    $globalvar = 'Foo';

    <span class="comment">// Initialize mailer class</span>
    $mailer = new Mailer;
    
    <span class="comment">// Set or load the mailer configuration parameters</span>
    $mailer->server('mail.server');

    $mailer->setup('mail.setup');

    <span class="comment">//Inject some local variables</span>
    $mailer->inject(['email' => 'foo@site.com']);

    <span class="comment">Load template file</span>
    $mail->sendmail('mail.template');

<div class="pxv-6 bc-off-white"><code>Sample: Template File </code></div>
  <?=
  to_lgts('
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Mail Template File</title>
  </head>
  <body>
      
    Hi there, this is a message from @({{$globalvar}})@

    This however is an injected local variable @({{$email}})@

    The type of this message is @({{get:type}})@

    The method of this message is @({{post:method}})@  

    Choosing any request is as easy as @({{method}})@  or @({{type}})@

  </body>
  </html>  
  ')

  ?>

  </pre>
                </div>
              </div>
                </div>

            </div>
        </div>

        <div class="font-menu pvs-6">
            The examples above shows how the placeholders can be used to 
            access global, local or request variables. <br><br>

            Global variables are naturally accessed with @({{$name}})@ where 
            <code>$name</code> is the name of the global variable <br><br>

            Local variables are injected with <code>inject()</code> method and 
            accessed with the similarly as the global variables. Global variables however 
            overides local variables. <br><br>

            Post request values are accessed with the post keyword i.e @({{post:key}})@ <br><br> where 
            <code>key</code> is the post key <br><br>

            Get request values are accessed with the get keyword i.e @({{get:key}})@ <br><br> where 
            <code>key</code> is the get key <br><br>

            The get or post request values can be obtained generally as @({{key}})@. By default, this 
            variable i.e <code>key</code> will be obtained depending on the current request. However, the get 
            request has the higest power here. This means that if a key exists in post and equally get, then the 
            get request key will be picked.
            <br><br>
        </div>

        @lay('build.co.links:tutor_pointer')

      </div>
    </div>
    
    @lay('build.co.coords:footer')


@template;