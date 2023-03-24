
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Routing MVC</div> <br>
                    
                    <div class="db-connection">
                        <div class="fb-6">Introduction</div>
                        <div class="">
                            Just like any other framework, the routing is done by using the 
                            <code>post()</code> and <code>get()</code> 
                            methods. However, spoova is wired differently. The the post and get methods are better handled
                            using the <code>Res::load()</code> method instead as there are lots of code flexilities attached to it.
                            Developers are best left to handle their requests in the manner in which they desire. The term "MVC" within 
                            this application refers to port routing, even though in real terms, MVC is a wide term 
                            that refers to all architectures that employs the <code>model-view-controller</code> structure.

                            <br><br> Generally, routing can however be applied in two different ways.
                            
                            <br><br> 1. loading urls through page files and folder structures using known web servers.
                            <br><br> 2. loading urls through index file using port.

                            
                        </div> 
                    </div> <br>

                    <div>
                        <div class="font-menu fb-6 bc-white-dd box-full rad-4 pxv-8">
                            1. Loading classes through page files.
                        </div> <br>


                        <div class="db-operations mvt-6">
                            <div class="font-menu font-em-1">
                            This method involves the use of page files to load classes into their respective pages. 
                            The php files will only exist to run another main controller file by using the <code>Res::load()</code> method
                            in each file. This process is highly discouraged as it creates multiple handler files that only performs the 
                            function of loading controller files. This in fact is the reason it has been disabled and this tutorial will not be 
                            focusing on this type of development as it is much advisable to use routes.
                            </div> <br>
                        </div>        
                    </div>

                    <div>
                        <div class="font-menu fb-6 bc-white-dd box-full rad-4 pxv-8">
                            2. Loading classes through index file using port.
                        </div> <br>


                        <div class="port-routing mvt-6">
                            <div class="font-menu font-em-1">
                            This method involves the accessing of a server file (index.php) through port to load classes based on requested urls. 
                            The urls are first  registered and when the address is visited on browser, they are called into activation. In this method, 
                            all registered urls are loaded and processed from the index file. <br><br>
                            </div> 
                            
                            
                            <div class="bc-white-dd font-menu">
  <div class="pxv-10 bc-silver">Example - Inside the index file, the following is placed </div>
                            
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
                        The example above reveals that urls are loaded through the server file <code>index.php</code>. In this way, all php urls and files are protected 
                        unless allowed. Since this method is favored, developer can either start a server on port <code>8080</code> by calling the command
                        <code>php mi start</code> which starts the server using cli or developers can use their preferred web server. Spoova has been configured to 
                        respond in a similar way.
                        </div> <br>  

                        <div class="font-em-d87">
                            <p>
                                Once the server is started, spoova begins to search for its route files within the <code>Window</code> and <code>Window/Routes</code> folder. It is 
                                important to keep the <code>windows/Index.php</code> file available in order to successfully load web pages if a basic logic which supports customized 
                                Window entry file (or class) name is not used. <br> 
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