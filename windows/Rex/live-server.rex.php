
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
                            Live server is an inbuilt server that runs on javascript language. It enables
                            live php development. In order to keep live server efficient, some helper classes or functions
                            have been restructured to support live development. Debugging system was attached to php error handlers
                            to reduce what is known as a "KILL EFFECT" which occurs when live server terminates and may not be able to 
                            continue unless the page is refreshed or reloaded. When strict errors occur, it can also prevent the server from 
                            starting unless the error is fixed. Although, this live server may prove helpful, due to the comprehensive structure which php uses to handle its errors, 
                            spoova debug system is still known to have major issues. Hence it is still in a beta phase. It is also important 
                            to empasize that using the live server involves sending muliple requests which is cpu intensive. To reduce this effect 
                            live server pauses its watch mode when a particular web page is not in view and resumes its monitoring when the page resumes.
                        </li> <br>
                        <li>
                            Although, the Live server was built to support online and majorly offline environments, it is disabled by default and can be initialized 
                            or turned off through different ways which are further explained below.
                        
                           <br><br>
                            
                            <div class="c-olive fb-6">1. Resource importing systems.</div>
                            <div class="mvt-6">
                                This is done through a default setup configuration file 
                                by setting "RESOURCE_WATCH" to a default value of "1" or "2" which stands for 
                                offline and online respectively. These tell the resource file handler class to automatically include the live server when
                                importing or downloading resource urls in the desired environment. Setting as online(2) enables it for both offline and online 
                                environments while a defualt of zero(0) disables the live server. This configuration can be set in the <code>icore\init</code> file. <br><br>
                            </div>
    
                            <span class="c-olive fb-6">2.</span> By including the directive <code class="font-em-d8"><?= to_lgts('<?= Res::import("::watch") ?>')?></code>
                            in your project file. <br><br>
    
                            <span class="c-olive fb-6">3.</span> By including the <code class="font-em-d8"><?= to_lgts('<?= Res::live() ?>')?></code> which is a shorthand for 2 above <br><br>
    
                            <span class="c-olive fb-6">4.</span> By including the <code class="font-em-d8"><?= to_lgts('@(live())@')?></code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">5.</span> By including the <code class="font-em-d8"><?= to_lgts('@(Res(\'::watch\'))@')?></code> directive in template engines <br><br>
                            
                            <span class="c-olive fb-6">6.</span> By use the helper function <code class="font-em-d8">monitor()</code>
                        </li> <br>
    
                        <li> 
                            Live server can also be switched off or on inline (non-environment bound)<br><br>
                            
                            1. Turn on.<br>
                            By including the <code class="font-em-d8"><?= to_lgts('<?= Res::watch() ?>')?></code> in the head tag of your html code 
                            <br><br>
    
                            2. Turn off.<br>
                            By including the <code class="font-em-d8"><?= to_lgts('<?= Res::off() ?>')?></code>  in the head tag of your html code
                            <br><br>
    
                            <span class="font-em-d85 box c-brown-ll bc-white-d shadow rad-5 pxv-10">
                                Note: Turning off a live server can only be done before a previous setting is made to turn it on. This means that turning off can be done either 
                                before the page loads or before resource importation is done. Also, whenever the live server is turned off either by a KILL EFFECT 
                                or through code, when turned back on, the page must be reloaded for the changes to take effect.
                            </span>
                        </li>        
                    </ul>
                </div>

            </div>
           </div>
        </section>
   </div>

@template;