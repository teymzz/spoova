
@template('template.t-tut')

    @title('Live-server')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')
    
    <div class="box pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial bc-white">
           <div class="font-em-1">

               @lay('build.co.links:tutor_pointer') <br>
            <div class="">
                <div class="font-em-1d2 c-orange">Live server implementation</div> <br>         
                
                <div class="">
                    <ul class="list-free pxs-1">
                        <li> 
                            <p>
                                Live server is an inbuilt server that runs on javascript language and helps to enable
                                live php development. In order to keep live server efficient, the live server runs at the top 
                                of the application before any content is rendered when it is called in routes. However, in template files,
                                it is imported at the point of call. Helper classes or functions
                                have been restructured and integerated into this framework to support live development. 
                                An error notification system was attached to php error handlers to convert php errors into an error pop-up 
                                notification message to reduce what is known as a "KILL EFFECT" which occurs when live server terminates and may not be able to 
                                continue unless the page is refreshed or reloaded. 
                            </p>
                            
                            <p>
                                Certain PHP errors prevents the live server from running because they shut down the entire application. In order to reduce the 
                                effect of these errors, the liveserver will continue to run with a relative error pop-up notification message until the page is manually 
                                refreshed. Once the page is refreshed while such errors are active, the live server will not be able to restart until such errors are fixed 
                                and the page is refreshed to reboot the liveserver. In the cases where soft errors (e.g warning and notice errors) occurs, the liveserver will 
                                still try to reboot to keep the application on a live state and any error detected will be converted to a pop-up notification message.
                            </p>

                            <p>
                                Although, the live server may prove helpful, due to the comprehensive structure which php uses to handle its errors, 
                                spoova debug system is still known to have major issues. Hence it is still in a beta phase. The live server implement 
                                different resource management approach to reduce its effect on cpu performace one of these is the internal beavioral pattern 
                                of pausing watch mode for web pages that are not in view. Although, the Live server was built to support majorly offline development, 
                                it is disabled by default and can be initialized or turned off through different ways which are further explained below:
                            </p>

                        </li>
                        <li>
                            
                            <div class="c-olive fb-6">1. Resource importing systems.</div>
                            <div class="mvt-6">
                                Through the command-line, the live server can be turned on by running the command below 
                                <br>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch online
                                    </pre>
                                </div>

                                <div class="">
                                    The command above will turn the live server on for both online and offline environments. 
                                    Although, the online enviroment support is not efficient. In other to keep it strictly for offline, 
                                    we can run the command below:
                                </div>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch offline
                                    </pre>
                                </div>

                                <div class="">
                                    We can also disable the default autoloading of the live server through the command below
                                </div>

                                <div class="pre-area mvs-10">
                                    <pre class="pre-code">
  > php mi watch disable
                                    </pre>
                                </div>

                                <div class="">
                                    Should the command-line fail for any reason, this can be manually configured through <code>icore/init</code> 
                                    file by setting "RESOURCE_WATCH" to a default value of "1" or "2" which stands for 
                                    <code class="bd-f">offline</code> and <code class="bd-f">online</code> respectively while a default of zero(0) disables the live server. 
                                    Although setting up live server this way may sound easy, it is not the most efficient way to start 
                                    the live server unless a template file cannot be reached. <br><br>
                                </div>
                            </div>
    
                            <span class="c-olive fb-6">2.</span> By including the directive <code class="font-em-d8"><?= to_lgts('<?= Res::import("::watch") ?>')?></code>
                            in your project file. <br><br>
    
                            <span class="c-olive fb-6">3.</span> By including the <code class="font-em-d8"><?= to_lgts('<?= Res::live() ?>')?></code> which is a shorthand for 2 above <br><br>
    
                            <span class="c-olive fb-6">4.</span> By including the <code class="font-em-d8">@(@live())@</code> or <code class="font-em-d8">@(@live)@</code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">5.</span> By including the <code class="font-em-d8">@(@Res(\'::watch\'))@</code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">6.</span> By the use of helper function <code class="font-em-d8">monitor()</code> in window route files.<br><br>
                            
                            <span class="c-olive fb-6">7.</span> The template importing directive <code>@(@template(file:off))@</code> is also useful for turning off the live server from a parent file. This is explained below: 
                            
                            <div class="pre-area mvt-10">
                                <div class="pxv-10 bc-silver">some-file.rex.php</div>
 <pre class="pre-code">
    &lt;html&gt; 

      &lt;head&gt; @(@live)@ &lt;/head&gt;    

      &lt;body&gt;   

         @(yield())@

      &lt;/body&gt;    

    &lt;/html&gt;
 </pre>
                            </div>

                            <div class="pre-area">
 <pre class="pre-code">
@(
    @template('some-file:off') 

        <span class="comment">//some html here</span>

    @temple;
)@
 </pre>
                            </div>

                            <div class="">
                                In the sample above, the parent file <code>some-file.rex.php</code> has the <code>@(@live)@</code> 
                                directive which enables the live server. This will also be inherited by the child template. In order to 
                                ensure that the child template does not inherit this live server, we can turn the live server off for the 
                                child template through the <code>:off</code> directive that comes after the rex file name <code>some-file</code>
                                supplied in the <code>@(@template())@</code> directive above.
                            </div>

                        </li> <br>
    
                        <li> 
                            <span class="c-olive fb-6">8.</span> Live server can also be switched off or on with <code class="font-em-d8"><?= to_lgts('<?= Res::watch() ?>')?></code> and <code class="font-em-d8"><?= to_lgts('<?= Res::off() ?>')?></code> respectively.
                            <br><br>
    
                            <span class="font-em-d85 box c-brown-ll bc-white bd-1 shadow rad-5 pxv-10">
                                <div class="font-em-1d2 fb-9 mvb-6"><span class="bi-circle"></span> Notice</div> 
                               
                                <ul class="pxl-20 font-em-1d1">
                                    <li style="list-style:square" class="mvb-6">
                                        Turning off the live server can only be done before a previous setting is made to turn it on. This means that turning off can be done either 
                                        before the page loads or before resource importation is done.
                                    </li>
                                    <li style="list-style:square" class="mvb-6">Whenever the live server is turned off either by a KILL EFFECT 
                                        or through code, when turned back on, the page must be reloaded for the changes to take effect.
                                    </li>
                                    <li style="list-style:square" class="mvb-6">
                                        When working with database operations, operations that could change the state of another item permanently (for example, file update or delete) 
                                        or operations that changes state frequently, it is advised to turn off the liveserver to prevent pre-execution of codes or recurrence of page refresh.
                                    </li>
                                    <li style="list-style:square">
                                        Although, the live server's resource usage has been greatly reduced, we suggest to close and re-open web browser after a minimum of 10 hours continuous usage of live server. 
                                        This of course depends on the processing power of the device in use. This activity is also not required but it may help keep the web browser efficient if it ever slows down.
                                    </li>
                                </ul>
                            </span>
                        </li>   
                    </ul>
                </div>

            </div>
           </div>
        </section>
   </div>

@template;