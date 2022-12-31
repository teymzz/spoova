
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
    
        <section class="pxv-20 tutorial mails bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">
                    <div class="font-em-1d5 c-orange">Mails</div> <br>  
                    
                    <div class="pulling-data">



                        <div class="fb-6">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                            <div class="flex-full midv"> 
                                Checking attempted mails 
                            </div>
                            </div>
                        </div> <br>

                        <div class="">
                            The attempted mails are mails that have been tried. This could be in offline or online 
                            environment. They don't necessarily mean mails that have been truly forwarded. They can
                            also mean mails that developer have tried to send. For a mail to be attempted, it means 
                            that the mail has been authorized to send after server and header configuration parameters 
                            have been set successfully. If the important configuration parameters like server configuration 
                            and the recipient have been set, when a mail is tried, then an attempt is made. The <code>attempt</code>
                            method is used to check if a mail has been attempted. A mail must also be authorized to send before 
                            an attempt can be successfully made.
                        </div>

                    </div> <br>
                    
                    <div id="pull" class="content"> 
                        
                        <div>
                            The example below shows how to check if a mail is attempted.
                        </div>

                        <div class="file-setup">
                        <div class="pre-area shadow">
                            <div class="box-full">
            <div class="pxv-6 bc-off-white"><code>Sample: Fetching mail header data</code></div>
            <pre class="pre-code">
  &#60;?php
  
    $mail = new Mailer;
    
    $mail->server('mail.server'); <span class="comment no-select">// load server config file </span> 
    
    $mail->setup([

        'client' => ['name' => 'Foo']

    ]);

    $mail->authorize(true);

    $mail->sendmail();

    if($mail->attempted()){
        
        <span class="comment no-select">// ...do this</span>

    } else {

        <span class="comment no-select">// ...no attempt was made</span>     

    }
            </pre>
                            </div>
                        </div>
                        </div>

                    </div> <br>

                    <div class="font-menu">
                        If the <code>authorize</code> is not set as true or necessary config 
                        parameters needed to send a mail (server and recipient) are not set, 
                        the <code>attempted()</code> method returns false even if <code>sendmail</code> 
                        is used. 
                    </div>

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>

    @lay('build.co.coords:footer')

@template;