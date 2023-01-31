

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">
                    <div class="font-em-1d5 c-orange">Routing WMV</div> <br>
                    
                    <div class="db-connection">
                        <div class="fb-6 c-olive">Introduction</div>
                        <div class="">
                            The wmv is a term used for loading of web pages using web servers without starting the server manually through ports. 
                            . Windows files are all loaded from the windows folder through the use of a standard logic. By default, when a url does not exist,
                            spoova tries run its windows files from the windows (routes) folder. If the path does not exist spoova will return a 
                            404 error response page depending on whether it is an api window or not. This is done by
                            processing the <code>Index</code> class within the windows folder. The Index is then used to handle 
                            incoming urls which if not handled will return a 404 error page. The architectural pattern flow is
                            shown below.
                            <br><br>
                            <div class="font-menu  font-em-d85 bc-white-dd box-full rad-4 pxv-8">
                                url > windows(route) -> index -> 404 error page
                            </div>
                        </div> 
                    </div> <br>

                    <div class="db-operations">
                        <div class="fb-6 c-olive">Setting up a new wmv route</div>
                        <div class="font-menu font-em-1">
                            All window files are loaded from the windows folder. These files
                            can be extended to different Frames. Frames are binding structures that can be applied
                            on window files. Their functions are to define basic structure or concepts a window
                            can emulate. For example, Frame files can be used to separate or divide sessions which are
                            only recognized in some particular windows files. Hence, all window files extending to such 
                            Frames will only derive their session values from their parent frame file. Windows files have a great 
                            relationship with <code>Res</code> class. This makes it easier to call methods like <code>Res::load()</code> 
                            using <code>self::load()</code> instead, which also searches for its template files from the rex folder.  Proceedures below 
                            helps to explain the steps or stages involved in setting up a windows file.
                            <br><br>

                            <div class="fb-6 mvb-10">Setup steps</div>
                            <ol>
                                <li>Create a separate frame folder within the windows folder</li>
                                <li>In the frame folder, add a base group class frame file for the windows files that will share the same data.</li>
                                <li>Create a windows' page by using the page's entry point name as a class in the Windows File.</li>
                                <li>Extend your windows file to your frame file</li>
                                <li>Add a construct method within the windows file created in one above</li>
                                <li>
                                    Once this is done, when a user tries to access a page with the name of your windows file,
                                    the windows file will be automatically loaded up from the windows folder. If the non-existing url is not handled
                                    a 404 error is returned.
                                </li>
                            </ol>
                            
                        </div>

                        <div class="font-em-d8">Step 1 & 2 above : This frame file should be added inside the Frame folder directory within the windows folder.</div> <br>     
                        <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x">
<div class="pxv-10 bc-silver">File 1 - Frame file sample (UserFrame.php)</div>        
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\windows\Frames;
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
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
  <div class="pxv-10 bc-silver">File 2 - Windows file sample (Home.php)</div> <br>         
                    <pre class="pre-code">
  &lt;?php

    use spoova\windows\Frames\UserFrame;

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

                        <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x"> 
                    <pre class="pre-code">
  &lt;?php

    namespace spoova\windows;

    use spoova\windows\Frames\UserFrame;


    class Home extend Userframe{

        function __construct() {

            self::load( 'index', fn => compile() );

        }

    }

  ?&gt;
                    </pre>
                        </div> <br> <br>

                        In example above:
                        <ol class="font-em-d9 mvt-10">
                            <li>
                                File 1 <code class="c-wine-dd">UserFrame.php</code> was added into the windows/Frame folder 
                                and the UserFrame class was extended to the Windows.
                            </li><br>
                            <li>
                            File 2 <code class="c-wine-dd">Home.php</code> must be a windows File. 
                            Hence, it was extended to the Frame file <code>UserFrame.php</code>. 
                            </li><br>
                            <li>
                                The last code section reveals how to use the resource load method <code>Res::load</code> within the windows File.
                            </li>
                        </ol>

                        <div class="foot-note">
                            <span class="head">Footnote:</span><br>

                            <div class="">
                                <ul>
                                    <li>
                                        It is important to note that file compiling, 
                                        that is, the use of <code>compile()</code>. 
                                        can only be done once. <br>
                                    </li>
                                    <li>
                                        If multiple files will be compiled, then it is 
                                        preferred to use the <code>view()</code> function. 
                                        There are distinctive differences between <code>compile()</code> 
                                        and <code>view()</code> . This is discussed under the helper compiler 
                                        functions tutorial.
                                    </li>
                                </ul>
    
                                The last example below shows how <code>view()</code> can be used within classes
                            </div>

                        </div>
                    </div> <br>
                    
                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow flow-x"> 
    <pre class="pre-code">
  &lt;?php
  
    namespace spoova\windows;

    use spoova\windows\Frames\UserFrame;


    class Home extend Userframe{

        function __construct() {

            $view1 = self::load( 'index', fn => view() );
            $view2 = self::load( 'home', fn => view() );

            echo $view1.$view2;

        }

    }
  
  ?&gt;
    </pre>

                        </div> <br> <br>  
                    @lay('build.co.links:tutor_pointer')
                </div>
            </div>
        </section>
    </div>
@template;