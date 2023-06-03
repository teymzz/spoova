
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange"> <i class="bi-router"></i> Routing</div> <br>
                    
                    <div class="routing-files">
                        <div class="">
                            Routes are registered through multiple ways using either ports or htaccess files.
                            The <code>model-view-controller</code> is a common pattern in framework development.
                            However, WMV <code>windows-view-model</code> or <code>windows-model-view</code> is a routing approach
                            that is built upon the MVC architecture. Both port routing (8080) using php in-built server or third-party server is supported by this framework. 
                            In order to be more specific, web apps initialized through php local server ports (8080) will be referred to as "MVC Port" while those that uses web servers
                            will be termed as WMV, although, both systems are still under the MVC architecture. The spoova framework has a great relationship with both the 
                            Port routing and Htacess routing system which makes it possible to interact with either of this system in an almost similar manner. For example, 
                            url addresses are configured to give out the same response under any of this systems.
                        </div> 
                    </div> <br>

                    <div class="routing-files">
                        <div class="fb-6 c-orange">What is WMV ?</div> <br>
                        <div class=" font-em-1">
                            <p class="">
                                The <code>windows-model-view</code> is an architectural pattern built on MVC pattern. 
                                It uses a 3-logic pattern to handle url routes, making it a more flexible system to deal with.
                                It works in a similar manner to building a real house with several windows. In
                                <code>WMV</code>, the entire application is the house which has 
                                different windows, window frames and entry points. In <code>wmv</code> systems, a window cannot naturally 
                                exist unless it is given its own space. The <code>wmv</code> system does not depend on ordinary php files but on window files 
                                which in turn serves as entry points. These window files are classes that extends to the root <code>Window</code> class or object. 
                                Similarly to a house, a window enables us
                                to have a view and what we see are the models or structures which are accessible through the window.
                                A view cannot occur if there is nothing to be seen. This means that an object must be able to reflect a light.
                                Without a light, then there is no view at all. Hence, wmv is a pattern that follows a window format. A better example
                                is our eyes. When the eyes is opened, a light must be reflected on objects to be seen, else there will be total darkness.
                                The light itself is an object (model) that controls how an object is perceived. So, under <code>wmv</code>, the model comes first before view.
                                The <code>WMV</code> architecture is divided into six categories
                                which are 
                                <a href="@domurl('docs/wmv/routes')" class="c-olive ch-olive"><code>Routes</code>, 
                                <a href="@domurl('docs/wmv/frames')" class="c-olive ch-olive"><code>Frames</code></a> 
                                <a href="@domurl('docs/wmv/apis')" class="c-olive ch-olive"><code>APIs</code></a>, 
                                <a href="@domurl('docs/wmv/sessions')" class="c-olive ch-olive"><code>Sessions</code></a>, 
                                <a href="@domurl('docs/wmv/rex')" class="c-olive ch-olive"><code>Rex</code></a> and 
                                <a href="" class="c-olive ch-olive"><code>Models</code></a> . 
                                These will be discussed later under their headings.
                            </p>
                        </div> 
                    </div>

                    <div class="wmv-routing">
                        <div class="fb-6 c-orange">Routing - Template Engines (mvc)</div>
                        <div class=" font-em-1 mvt-10">
                            Routing involves management or urls that are later rendered along with template files. Spoova uses an in-built 
                            template engine <code>Compiler</code> to render its rex template files. Rex template files are placed within the <code>windows/Rex</code> directory.
                            This is the location where all php resource template files (rex) are loaded from. The template files
                            are loaded through the use of <code>Res::load()</code> class which means "load resource". It is very
                            easy to load template files and we will be examining few examples.
                        </div> <br>
                        
                        
                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 1 : Functions</div>
                    <pre class="pre-code">
  &lt;?php

    <span class="comment no-select">1.</span> Res::load('index', function(){ return "me"; });
    <span class="comment no-select">2.</span> Res::load('index', fn => "me" );
    <span class="comment no-select">3.</span>
    <span class="comment no-select">4.</span> Res::load('::path.of.file', fn => "me" );
    <span class="comment no-select">5.</span>
    <span class="comment no-select">6.</span> Res::load('index', fn => compile() );
    <span class="comment no-select">7.</span> 
    <span class="comment no-select">8.</span> Res::load('index', fn => view('some-file') );
        
  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class=" font-em-d9">
                            In example above, assuming we are within a window file : 

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 1 & 2 above, the <code>index</code> is usually an empty rex file (i.e index.rex.php) which serves as a screen 
                            upon which the string value (i.e "me") will be reflected on. This means that <code>index.rex.php</code> must exist within the rex folder for the word "me" to be displayed 
                            successfully on the webpage. The supplied empty file name (or path) <code>index</code> will be used as storage path.

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> Since creating empty files which are just needed as a screen to reflect our content might not be the best idea, 
                            by supplyig a double colon <code>::</code> and a path on the file just as line 4, the load function will help to push our data to the webpage while the storage file path will 
                            also be created. The path after the colon (i.e "path.of.file") will be translated 
                            to <code>path/of/file.rex.php</code> which will then be used as the storage file name (or path). The <code>compile()</code> function will not be accepted when the double colon <code>::</code> 
                            is used because the content is not expected to be rendered from an existing rex file.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 6, the <code>compile()</code> method is used as a directive for rendering the contents of the 
                            <code>index</code> rex file. A file will not be rendered unless the compile method is declared upon it.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 8, the <code>view()</code> method is used as a directive for rendering the contents of a supplied 
                            template file into the index file. 

                            <br><br>
                            <span class="fb-6">Note:</span> The <code>icore/filebase.php</code> file needs to  be included or accessible on all project files. This has been 
                            preloaded to all window structure. Hence, if this structure is employed, then there is no further need to include it.
                        </div> <br>      

                        <!-- Handling Classes -->
                        
                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 2 : Classes </div>        
                    <pre class="pre-code">
  &lt;?php
                    
    <span class="comment no-select">1.</span> use spoova\mi\windows\Routes\App;
    <span class="comment no-select">2.</span> 
    <span class="comment no-select">3.</span> Res::load('index', [App::class, 'index']);

  ?&gt;
                    </pre>
                        </div>

                        <div class="foot-note">
                            In example 2 above, we supplied a class using an array. The <code>App</code> class will be loaded from the <code>spoova\mi\windows\Routes</code>
                            namespace and the <code>index</code> method will be called from that <code>App</code> class.
                        </div>
                    
                        <div class="">
                            <div class="fb-6 c-orange">Markup</div>
                            <div class="mvt-10">
                                
                                The <code>markup()</code> method is similar to the the <code>load</code> 
                                method except that it prevents the <code>compile()</code> function from 
                                automatically displaying the content rendered. Instead, it returns the data 
                                compiled. Example is shown below:

                                <br><br>

                                <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 3 : Markup </div>        
                        <pre class="pre-code">
  &lt;?php
    
    <span class="comment no-select">1. include_once 'icore/filebase.php'; </span> 
    <span class="comment no-select">2.</span> use spoova\mi\windows;
    <span class="comment no-select">3.</span> 
    <span class="comment no-select">4.</span> $compiled = Res::markup('index', [App::class, 'index']);
    <span class="comment no-select">5.</span> print $compiled;

  ?&gt;
                        </pre>
                                </div> 
                            </div> 
                        </div>

                        <div class="foot-note">Accessing files using the window system allows pages to load 
                            only through the window classes or routes by calling <code>Server::run()</code> from the <code>index.php</code> file 
                            which is connected to an <code>icore/filebase.php</code> file. Hence, line 1 will be naturally available to all window 
                            files as long as any of the spoova <a href="@domurl('docs/wmv')"><span class="c-olive">architectural logics</span></a> are employed. 
                            Assuming that we are within a window file (or class), then the <code>Res::</code> class can be replaced with 
                            <code>self::</code>
                        </div>

                        <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 4 : Using window file </div>        
                        <pre class="pre-code">
  &lt;?php
    
    namespace spoova\mi\windows\Routes;

    use Window;

    class Home extends Window {

        function __construct() {

            $arguments = ['title' => 'This is Homepage'];

            self::load('home', fn() => compile($arguments) );

        }

    }

  ?&gt;
                        </pre>
                        </div>

                        <div class="foot-note">In the example above, not only were we able to use the <code>self::load()</code> 
                            inherited compiler but we also passed an argument to the <code>home.rex.php</code> file using the compiler function. 
                            You can learn more about <a href="@DomUrl('docs/routings/mvc')" class="c-olive rule-dotted">port routing</a> or 
                            <a href="@DomUrl('docs/routings/wmv')" class="c-olive rule-dotted">wmv</a> 
                            from the supplied links.
                        </div> <br> 

                    </div>
                </div>
            </div>
        </section>
    </div>
@template;