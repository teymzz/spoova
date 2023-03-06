
@template('template.t-tut')

    @title('Live-server')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')
    
    <div class="box pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')
            <div class="c-black-ll">
                <div class="font-em-1d2 c-orange">Live server implementation</div>         
                
                <div class="calibri font-em-d8">
                    <ul class="list-free pxs-1">
                        <li> 
                            <p>
                                Live server is an inbuilt server that runs on javascript language and helps to enable
                                live php development. In order to keep live server efficient, the live server runs at the top 
                                of the application before any content is rendered. Helper classes or functions
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
                                spoova debug system is still known to have major issues. Hence it is still in a beta phase. It is also important 
                                to empasize that using the live server involves sending muliple requests which is cpu intensive. To reduce this effect 
                                live server pauses its watch mode when a particular web page is not in view and resumes its monitoring when the page resumes.
                                Although, the Live server was built to support majorly offline development, it is disabled by default and can be initialized 
                                or turned off through different ways which are further explained below:
                            </p>

                        </li>
                        <li>
                            
                            <div class="c-olive fb-6">1. Resource importing systems.</div>
                            <div class="mvt-6">
                                This is done through a default setup configuration file 
                                by setting "RESOURCE_WATCH" to a default value of "1" or "2" which stands for 
                                offline and online respectively. These tell the resource file handler class to automatically include the live server when
                                importing or downloading resource urls in the desired environment. Setting as 2 (i.e online) enables it for both offline and online 
                                environments while a default of zero(0) disables the live server. This configuration can be set in the <code>icore\init</code> file. <br><br>
                            </div>
    
                            <span class="c-olive fb-6">2.</span> By including the directive <code class="font-em-d8"><?= to_lgts('<?= Res::import("::watch") ?>')?></code>
                            in your project file. <br><br>
    
                            <span class="c-olive fb-6">3.</span> By including the <code class="font-em-d8"><?= to_lgts('<?= Res::live() ?>')?></code> which is a shorthand for 2 above <br><br>
    
                            <span class="c-olive fb-6">4.</span> By including the <code class="font-em-d8"><?= to_lgts('@(live())@')?></code> or <code class="font-em-d8"><?= to_lgts('@(live)@')?></code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">5.</span> By including the <code class="font-em-d8"><?= to_lgts('@(Res(\'::watch\'))@')?></code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">6.</span> By the use of helper function <code class="font-em-d8">monitor()</code> in window route files.<br><br>
                            
                            <span class="c-olive fb-6">7.</span> The template importing directive "@(template(file:off))@" can also turn off a template inherited live server. 
                        </li> <br>
    
                        <li> 
                            <span class="c-olive fb-6">8.</span> Live server can also be switched off or on with <code class="font-em-d8"><?= to_lgts('<?= Res::watch() ?>')?></code> and <code class="font-em-d8"><?= to_lgts('<?= Res::off() ?>')?></code> respectively.
                            <br><br>
    
                            <span class="font-em-d85 box c-brown-ll bc-white-d shadow rad-5 pxv-10">
                                <div class="font-em-1d2 fb-9"><span class="bi-exclamation-triangle"></span> Warning</div> 
                               
                                <ul class="pxl-14 font-em-1d1">
                                    <li style="list-style:square">
                                        Turning off the live server can only be done before a previous setting is made to turn it on. This means that turning off can be done either 
                                        before the page loads or before resource importation is done. Also, whenever the live server is turned off either by a KILL EFFECT 
                                        or through code, when turned back on, the page must be reloaded for the changes to take effect.
                                    </li>
                                    <li style="list-style:square">
                                        When working with database operations, operations that could change the state of another item permanently (for example, file update or delete) 
                                        or operations that changes state frequently, it is advised to turn off the liveserver to prevent pre-execution of codes and recurrent page reload.
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