

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>
                    <div class="font-em-1d5 c-orange">Routing WMV</div> <br>
                    
                    <div class="db-connection">
                        <div class="">
                            The wmv is a term used for loading of web pages using a 3-logic pattern. Routes can be loaded using in-built php server through ports or through external servers 
                            such as xampp or wamp or remote servers. By default, Windows files are all loaded from the windows folder through the use of a standard logic which is one of the 3 logics supported. 
                            The default behaviour is that spoova tries to load its routes from the <code>window/Routes</code> directory which is equivalent to the <code>spoova\mi\windows\Routes</code> namespace. 
                            If the route file does not exist spoova will return a 404 error response which can be in form of a 404 error page or 404 json response. The behavior is shown below:
                            <br><br>
                            <div class="  font-em-d85 bc-white-dd box-full rad-4 pxv-8">
                                url > windows(route) -> 404 error page
                            </div>
                        </div> 
                    </div> <br>

                    <div class="db-operations">
                        <div class="fb-6 c-olive">Setting up a route using frame</div>
                        <div class=" font-em-1 mvt-10">
                            All window files are loaded from the <code>windows</code> directory while routes are loaded from <code>windows/Routes</code> directory. Route files
                            can be extended to root <code>Window</code> class or <code>Frames</code>. Frames are binding structures that can be used as a parent group for different Routes. 
                            Their functions are to define basic structure or concepts a route
                            can emulate. For example, Frame files can be used to separate or divide sessions which are
                            only recognized in some particular windows files. Hence, all window files extending to such 
                            Frames will only derive their session values from their parent frame file. Proceedures below 
                            helps to explain the steps or stages involved in setting up a new route.
                            <br><br>

                            <div class="fb-6 mvb-10 c-dry-blue">Setup steps</div>
                            <ol class="calibri">
                                <li>Create a separate <code class="bd-f">Frames</code> directory within the <code class="bd-f">windows</code> directory.</li>
                                <li>In the <code class="bd-f">Frames</code> directory, add a class file that extends to the root <code>Window</code> class.</li>
                                <li>Add a route class into the <code>windows/Routes</code> directory page by using the page's entry point name as the class name in the <code>spoova\mi\windows\Routes</code> namespace.</li>
                                <li>Extend the route file to the frame file created earlier</li>
                                <li>Lastly, add a <code>__construct()</code> method within the frame file which will control how data is shared</li>
                                <li>These processes can be shortened by working with available cli commands designed for generating files.</li>
                                <li>
                                    Once these setps are completed, when a user tries to access a page with the name of the route file,
                                    the route file will be automatically be called. The benefit of the frame file is that it can serve as a parent class that distributes data to several routes, since multiple routes can be 
                                    extended to that frame file.
                                </li>
                            </ol>
                            
                        </div>

                        <div class="box-full font-em-d85 bc-white-dd shadow flow-x">
<div class="pxv-10 bc-silver">File 1 - Frame file sample (UserFrame.php)</div>        
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\mi\windows\Frames;
    use Window;

    class Userframe extends Window{

        function data() {

            return ['name' => 'Felix'];

        }

    }

  ?&gt;
                    </pre>
                        </div> <br><br>     

                        <div class="font-em-d8">Step 3, 4 & 5 above</div> <br> 
                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
  <div class="pxv-10 bc-silver">File 2 - Windows file sample (Home.php)</div> <br>         
                    <pre class="pre-code">
  &lt;?php

    use spoova\mi\windows\Frames\UserFrame;

    class Home extend Userframe{

        function __construct() {

            print "This is the homepage";

        }

    }

  ?&gt;
                    </pre>
                        </div> <br><br>



                        <div class="font-em-d87">
                            <div class="">Notice : In the above, we can discover that Frames are extensions of Windows.</div>          
                            Since the <code>Res::load()</code> can be applied on windows files, then we can say: <br>
                        </div> <br> 

                        <div class="box-full   font-em-d85 bc-white-dd shadow flow-x"> 
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\mi\windows;

    use spoova\mi\windows\Frames\UserFrame;


    class Home extend Userframe{

        function __construct() {

            self::load( 'index', fn => compile() );

        }

    }

  ?&gt;
                    </pre>
                        </div>

                        <div class="foot-note">
                            In example above:
                            <ol class="font-em-d9 mvt-10">
                                <li>
                                    File 1 <code class="c-wine-dd">UserFrame.php</code> was added into the <code>windows/Frame</code> folder 
                                    and the UserFrame class was extended to the <code class="bd-f">Window</code> root class.
                                </li><br>
                                <li>
                                File 2 <code class="c-wine-dd">Home.php</code> which exists in the <code>windows/Routes</code> directory is expected to be 
                                instance of the in-built <code>Window</code> object so as to become a route. Since the <code>UserFrame.php</code> extends to the root 
                                <code>Window</code> class, the <code>Home.php</code> can inherit the properties of a window from the <code>UserFrame</code> 
                                class it was extended to.
                                </li><br>
                                <li>
                                    The <code>self::load()</code> is equivalent to <code>Res::load()</code> compiler method which loads the template file <code>index.rex.php</code> 
                                    template file from the <code>windows/Rex</code> directory
                                </li>
                            </ol>

                        </div>

                    </div>
 
                    @lay('build.co.links:tutor_pointer')
                </div>
            </div>
        </section>
    </div>
@template;