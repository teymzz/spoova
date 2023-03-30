
@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Routing</div> <br>
                    
                    <div class="routing-files">
                        <div class="fb-6">Routing files</div> <br>
                        <div class="">
                            Routes are registered through multiple ways using either ports or htaccess files.
                            The <code>model-view-controller</code> is a common pattern in framework development.
                            However, WMV <code>windows-view-model</code> or (windows-model-view) approach was introduced as 
                            an approach built upon the MVC architecture. Both port routing (8080) using php inbuilt server or third-party server is supported by this framework. 
                            In order to be more specific, web apps initialized through php local server ports (8080) will be referred to as "MVC Port" while those that uses web servers
                            will be termed as WMV, although, both systems are still under the MVC architecture. The configuration of spoova frame has created a great connection between 
                            the MVC Port and WMV systems which makes it possible to interact with either of this system in the same manner. For example, url addresses are configured to 
                            give out the same response under any of this systems.
                        </div> 
                    </div> <br>

                    <div class="routing-files">
                        <div class="fb-6">What is WMV ?</div> <br>
                        <div class="font-menu font-em-1">
                            <p class="">
                                The <code>windows-model-view</code> is an architectural pattern built on MVC pattern. 
                                It uses a 3 logic pattern to handle url routes which makes it a more flexible system to deal with.
                                It works in a similar manner to building a real house with its several windows. 
                                <code>WMV</code> also has a window. In order to understand how this system works, we need to consider a project application as house with its 
                                different windows, window frames and entry points. A window cannot naturally exist unless it is given
                                its own space. WMV does not depend on files but window files which in turn serves as entry points. Similarly to a house, a window enables us
                                to have a view and what we see are the models or structures built outside that view which are objects visible to our sight.
                                A view cannot occur if there is nothing to be seen. This means that an object must be able to reflect a light.
                                Without a light, then there is no view at all. Hence, wmv is a pattern that follows a window format. A better example
                                is our eyes. When the eyes is opened, a light must be reflected on objects to be seen, else there will be total darkness.
                                The light itself is an object (model) that makes view possible. So, under wmv, the model comes first before view.
                                The <code>WMV</code> architecture is divided into six categories
                                which are 
                                <a href="@domurl('docs/wmv/routes')"><code>Routes</code>, 
                                <a href="@domurl('docs/wmv/frames')"><code>Frames</code></a> 
                                <a href="@domurl('docs/wmv/apis')"><code>APIs</code></a>, 
                                <a href="@domurl('docs/wmv/sessions')"><code>Sessions</code></a>, 
                                <a href="@domurl('docs/wmv/rex')"><code>Rex</code></a> and 
                                <a href=""><code>Models</code></a> . 
                                These will be discussed later under their headings.
                            </p>
                        </div> 
                    </div>

                    <div class="wmv-routing">
                        <div class="fb-6">Routing - Template Engines (mvc)</div>
                        <div class="font-menu font-em-1">
                            Routing involves management or urls that are later rendered along with template engines. Spoova uses an in-built 
                            template engine <code>"rex"</code>
                            to render its rex template files. Rex template files are placed within the <code>windows/Rex</code> directory.
                            This is the location where all php resource template files (rex) are loaded from. The template files
                            are loaded through the use of <code>Res::load()</code> class which means "load resource". It is very
                            easy to load template files and we will be examining few examples.
                        </div> <br>
                        
                        
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
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
    <span class="comment no-select">8.</span> Res::load('index', fn => view() );
        
  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class="font-menu font-em-d85">
                            In example above, assuming we are within a window file : 

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 1 & 2 above, the <code>index</code> is usually an empty rex file (i.e index.rex.php) which serves as a screen 
                            upon which the string value (i.e "me") will be reflected on. This means that <code>index.rex.php</code> must exist within the rex folder for the word "me" to be displayed 
                            successfully on the webpage. The supplied empty file name (or path) <code>index</code> will be used as storage path.

                            <br><br> <span class="bi-circle-fill c-silver-d"></span> Since creating empty files which are just needed as a screen to reflect our content might not be the best idea, 
                            by supplyig a double colon <code>::</code> and a path on the file just as line 4, the load function will help to push our data to the webpage while the storage file path will 
                            also be created. The path after the colon (i.e "path.of.file") will be translated 
                            to <code>path/of/file.rex.php</code> which will then be used as the storage file name (or path). The compile function will not be accepted when the double colon <code>::</code> 
                            is used because the content is not expected to be rendered from a file.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 6, the <code>compile()</code> method is used as a directive for rendering the contents of the loaded 
                            <code>index</code> file. A file will not be rendered unless the compile method is declared upon it.
                            
                            <br><br> <span class="bi-circle-fill c-silver-d"></span> In line 8, the <code>view()</code> method is used as a directive for rendering the contents of a supplied 
                            template file into the index file. 

                            <br><br> 
                            <span class="fb-6">Note:</span> Each of the compiler methods i.e <code>view()</code> and <code>compile()</code> can be applied within classes. 
                            
                            <br><br>
                            <span class="fb-6">Note:</span> The <code>icore/filebase.php</code> file needs to  be included or accessible on all project files. This has been 
                            preloaded to all window structure. Hence, if this structure is employed, then there is no further need to include it.
                        </div> <br>      

                        <!-- Handling Classes -->
                        
                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
                            <div class="pxv-10 bc-silver">Example 2 : Classes </div>        
                    <pre class="pre-code">
  &lt;?php
                    
    <span class="comment no-select">1.</span> use spoova\mi\windows;
    <span class="comment no-select">2.</span> 
    <span class="comment no-select">3.</span> Res::load('index', [App::class, 'index']);

  ?&gt;
                    </pre>
                        </div> <br><br>

                        <div class="font-menu font-em-d85">
                            In example 2 above : 

                            <br><br> We supplied a class using an array. As an example, the <code>App</code> class will be loaded from the <code>spoova\windows</code>
                            directory and the <code>index</code> method will be called from that <code>App</code> class. However, since spoova uses standard 
                            logic, web pages are only loaded classes using window route files, that is, window files within <code>window\Routes</code> directory or app namespace.
                            
                            
                        </div> <br> 
                    
                        <div class="">
                            <div class="fb-6">Markup</div>
                            <div class="">
                                
                                The <code>markup()</code> method is similar to the the <code>load</code> 
                                method except that it prevents the <code>compile()</code> function from 
                                automatically displaying the content rendered. Instead, it returns the data 
                                compiled. Example is shown below:

                                <br><br>

                                <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
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
                                </div> <br><br> 
                            <div class="font-menu font-em-d85">
                                The <code>markup</code> method above will return the compiled data. 
                            </div>
                            </div> 
                        </div> <br>

                        <div class="foot-note">
                            <span class="head">Footnote:</span> Accessing files using the window system allows pages to load 
                            only through the window classes or routes by calling <code>Server::run()</code> from the <code>index.php</code> file 
                            that is connected to an <code>icore/filebase.php</code> file. Hence, line 1 will be naturally available to all window 
                            files as long as any of the spoova <a href="@domurl('docs/wmv')"><span class="c-olive">architectural logics</span></a> are employed. 
                            Assuming that we are within a window file (or class), then the <code>Res::</code> class can be replaced with 
                            <code>self::</code>
                        </div> <br>

                        <div class="box-full font-menu font-em-d85 bc-white-dd shadow flow-x">
                                    <div class="pxv-10 bc-silver">Example 4 : Using window file </div>        
                        <pre class="pre-code">
  &lt;?php
    
    namespace spoova\mi\window\Routes;

    use Window;

    class Home extends Window {

        function __construct() {

            $arguments = ['title' => 'This is Homepage'];

            self::load('home', fn() => compile($arguments) );

        }

    }

  ?&gt;
                        </pre>
                        </div> <br><br>

                        <div class="foot-note">
                            <span class="head">Footnote:</span> In the example above, not only were we able to use the <code>self::load()</code> 
                            inherited method but we also passed an argument to the <code>home.rex.php</code> file using the compiler function which will 
                            also compile or render the rex file. The above is also an example of loading rex templates files.
                        </div> <br> 

                        <div class="learn-more">
                            <div class="fb-6">More on MVC and WMV</div>
                            <div class="">
                                Learn more on <code>mvc</code> and <code>wmv</code> from here

                                <br><br>

                                <div class="pxs-10">
                                    <ul class="olist list-square">
                                        <li> <a href="@DomUrl('docs/routings/mvc')">MVC</a>  </li>
                                        <li> <a href="@DomUrl('docs/routings/wmv')">WMV</a> </li>
                                    </ul>                 
                                </div>   

                            </div> 
                        </div> <br>

                    </div>
                </div>
            </div>
        </section>
    </div>
@template;