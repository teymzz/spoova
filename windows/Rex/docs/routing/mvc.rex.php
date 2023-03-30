
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">MVC Port Routing</div> <br>
                    
                    <div class="db-connection">
                        <div class="">
                            In some mvc frameworks, routing is done by using the 
                            <code>post()</code> and <code>get()</code> 
                            methods. However, spoova is wired differently. The the post and get methods are better handled
                            using the <code>Res::load()</code> method instead as there are lots of code flexilities attached to it.
                            Developers are best left to handle their requests in the manner in which they desire. The term "MVC Port" within 
                            this application refers to port routing, even though in real terms, MVC is a wide term 
                            that refers to all architectures that employs the <code>model-view-controller</code> structure.

                            <br><br> Generally, port routing is done by the use of php inbuilt server to route urls. However, even when the method 
                            is applicable within the framework and has also been integrated with the (wvm or wmv) structure to ensure that all routes 
                            respond in closely similar manner, the process can be slow and sometimes may prevent some files such as external library icons 
                            from responding well. It is however advisable to employ the use of local (e.g wamp, xampp) or remote servers in order to render 
                            the application well.

                            
                        </div> 
                    </div> <br>

                    <div>
                        <div class="font-menu fb-6 bc-white-dd box-full rad-4 pxv-8 fb-9">
                         Using Ports
                        </div>    
                    </div>

                    <div>


                        <div class="port-routing mvt-6">
                            <div class="font-menu font-em-1">
                            This method involves the accessing of a server file (index.php) through port (8080) to load classes based on requested urls. 
                            Once the server is started, the index server file will route urls using any of the 3 logics supported by framework for loading 
                            routes.
                            </div> <br>
                            
                            
                            <div class="bc-white-dd font-menu">
  <div class="pxv-10 bc-silver">server file - index.php</div>
                            
                    <pre class="pre-code">
  &lt;?php

    include 'icore/filebase.php';

    Server::run();

  ?&gt;
                    </pre>
                            </div>
                        </div>
                    </div>  
                    
                    <div class="mvt-10">
                        <div class="font-em-d87">
                        The code above is a sample format of the <code>index.php</code> server file. Urls are routed through the server file <code>index.php</code>. In this way, all php urls and files are protected 
                        unless allowed. Server can be started on port <code>8080</code> by running the command
                        <code>php mi start</code> on the terminal which starts the built-in php server. If this method is slow or unresponsive, as a better alternative, developers can use their preferred local or remote server. Spoova has been configured to 
                        respond in a better way.
                        </div> <br>  

                        <div class="font-em-d87">
                            <p>
                                Once the server is started, spoova begins to search for its route files within the <code>windows/Routes</code> directory. It is 
                                important to keep the <code>windows/Routes/Index.php</code>. For more information on WVM approach visit <a href="@DomUrl('docs/routings/wmv')">here</a>   <br> 
                            </p>
                        
                            <p class="c-orange-d">
                                Note that when file are loaded using the php inbuilt server ports, external css library icons may be affected. This may be resolved by 
                                loading the icons directly using the cdn link of such libraries. 
                            </p>
                        </div>

                    </div> <br>
                
                    @lay('build.co.links:tutor_pointer')
                </div>
            </div>
        </section>
    </div>
@template;