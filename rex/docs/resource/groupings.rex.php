@template('template.t-doc')

@lay('build.coords:header')
<style>
    ul > li > a{
        color:inherit;
    }   

    ul > li > a:hover{
        color:inherit;
    }   

    ul > li a:hover{
       color: var(--orange-dd);
       cursor:pointer;
    }

    .olist {
        font-family: calibri;
        color: burlywood;
    }
</style>

<div class="pxv-20 c-black-ll">
    
    @lay('build.links:tutor_pointer')

    <div class="font-em-1d5 c-orange">Resource Grouping</div> <br>
    
    <div class="intro">
        <div class="fb-6">Introduction</div>
        <div class="">
            Resource grouping is the use of resource class to group static file urls
            which can be imported later into the webpage. The resource importer is not
            only capable of loading static urls but can also load configured meta tags 
            and live server through default configuration settings. The features of
            resource grouping are listed below: <br><br>
            
            <li>Storing and importing static urls</li>
            <li>Validating local static urls</li>
            <li>Grouping static urls</li>
            <li>Resolving local urls into http protocol</li>
            <li>Loading the default meta tag configurations</li>
            <li>Live server importations and control</li>
            
        </div> 
    </div> <br>

    <div>
        <div class="font-menu fb-6 font-em-1 bc-white-dd mox-full rad-4 pxv-8">
            1. Storing and importing static urls
        </div> <br><br>


        <div class="">
            <div class="font-menu font-em-1">
            Static urls are imported from the global resource folder <code>res</code>.
            Therefore, all local static urls should begin with the res folder name, although 
            a different folder name may be accepted. Before a file can be imported, it can 
            be first stored into the storage system. However, by default, the Resource class stores 
            urls into different containers which are either named or unamed. When storing static urls, 
            a group name should be first declared else, the url will be store in an unamed space. There are 
            several methods used for handling resource storage and importation and they are listed below
            <br><br>
            <ul>
                <li>Res::name()</li>
                <li>Res::callFile()</li>
                <li>Res::getFile()</li>
                <li>Res::addFile()</li>
                <li>Res::ignore()</li>
                <li>Res::new()
                    <ul>
                        <li>->name()</li>
                        <li>->url()</li>
                        <li>->xurl()</li>
                        <li>->urlOpen()</li>
                        <li>->urlClose()</li>
                    </ul>
                </li>
                <li>

                </li>
                <li>
                    Res::open()
                </li>
                <li>
                    Res::close()
                </li>
                <li>
                    Res::import()
                </li>
                <li>
                    Res::export()
                </li>
            </ul>
            </div> <br>


            <!-- Resource Naming -->
            <div class="resource-naming">
                <div class="fb-6">Resource naming</div> <br>
                <div class="">

                    <div class="font-em-d9">
                        Resource naming or grouping is done by giving static resources their own 
                        storage group space which may be declared (named) or undeclared (unmamed).
                        Example is listed below: <br><br>
                    </div>
                    
                    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    Res::name('css');

    Res::new()->name('js');
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                         The example above reveals two different ways by which static urls can be grouped 
                        before they are being stored. While <code>Res::name()</code> is a direct static method of 
                        naming a new resource group, the <code>Res::new()->name()</code> is an indirect instance method of naming groups.
                        To switch to a previously declared group or declare a new group, line one will have to be repeated at each declaration but line 2 supports a chainable 
                        structure naming convention reducing the number of times the <code>Res</code> class will have to be called just as shown in the example below:
                    </div> <br> 

                    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    <span class="comment">1.</span> Res::name('css');
    <span class="comment">2.</span> Res::name('js');
    <span class="comment">3.</span> 
    <span class="comment">4.</span> Res::new()->name('css')->name('js');
    </pre>

                    </div> <br><br>

                    <div class="font-menu">
                        When adding multiple groups, line 1 & 2 will be harder to manage, hence line 4 is mostly recommended
                    </div> <br>         
                </div>
            </div>


            <!-- Resource Setting -->
            <div class="resource-input">
                <div class="fb-6">Resource Setting</div> <br>
                <div>
                    <div class="font-em-d9">
                        Resources can be added through 3 input methods which are
                        <code>Res::callFile()</code> <code>Res::getFile()</code> and
                        <code>Res::addFile()</code>
                    </div>
                    <br>
                    
                    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> 
                        <div class="pxv-6 bc-off-white">Example 1 - callFile</div>
                        
                    <br><br>
    <pre class="pre-code">
    Res::name('css');

    Res::callFile('res/css/file1.css');
    Res::callFile('res/css/file2.css');


    Res::name('js');

    Res::callFile('res/js/file1.js');
    Res::callFile('res/js/file2.js');
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                        In example 1 above, two groups were declared. The first group 
                        <code>css</code> is where <code>file1.css</code> and <code>file2.css</code>
                        paths will be saved. While the <code>file1.js</code> and <code>file2.js</code> 
                        will be saved into <code>js</code> storage group declared above them. These groups
                        can be imported later using the <code>Res::import()</code> method. Paths stored does not necessarily 
                        have to be of the same extension. However, only four files extensions are supported which are 
                        <code>html</code> <code>css</code> <code>js</code> and <code>php</code>
                    </div> <br> 


                    <div class="example-2">
                        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x">
                            <div class="pxv-6 bc-off-white">Example 2 - instanced</div> <br><br>
        <pre class="pre-code">
    Res::new();

        ->name('css');

        ->url('res/css/file1.css')
        ->url('res/css/file2.css')


        ->name('js');

        ->url('res/css/file1.js')
        ->url('res/css/file2.js')
        </pre>
    
                        </div> <br><br>
    
                        <div class="font-menu">
                        
                         When using the instance method, a chainable structure can be employed that
                         helps to keep the code easier to maintain instead of calling the resource <code>Res</code>
                         class at every declaration like example 1 above.
    
                        </div> <br>         
                    </div>


                    <!-- example - 3 -->
                    <div class="example-3">
                        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x">
                            <div class="pxv-6 bc-off-white">Example 3 - getFile</div> <br><br>
        <pre class="pre-code">
    $resolved = Res::getFile('res/css/file2.js')
        </pre>
    
                        </div> <br><br>
    
                        <div class="font-menu">
                        
                         Just like the callFile method, the getFile method processes its arguments similarly 
                         and returns a resolved url of its input. It is however worth noting that local urls 
                         are validated before inclusion. If the path is not found, a null response is returned.
                         Such invalid urls are never imported to the page. 

    
                        </div> <br>         
                    </div>

                    <!-- example - 4 -->
                    <div class="example-3">
                        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x">
                            <div class="pxv-6 bc-off-white">Example 4 - addFile</div> <br><br>
        <pre class="pre-code">
    Res::name('css');
    Res::name('js');
    
    Res::addFile('css','res/css/file2.js');

    Res::addFile('res/css/file3.js');
        </pre>
    
                        </div> <br><br>
    
                        <div class="font-menu">
                        
                         Just like the callFile method, the addFile method processes its urls by adding file to 
                         an existing group. The group name to which the url will be added must be first declared as the first argument 
                         while the second argument should be the file path that will be added. After the first 
                         group declaration, <code>addFile</code> permits the omission of the class name for subsequent addFile 
                         calls.

    
                        </div> <br>         
                    </div>
                    
                </div>
            </div>


            <!-- Resource Protection -->
            <div class="resource-protection">
                <div class="fb-6">Resource protection</div> <br>
                <div class="">

                    <div class="font-em-d9">
                        Resource naming opens a storage space which is expected to be closed. 
                        The dangers of not closing resource space is that developers may accidentally save into a different storage 
                        space. Hence, it is a good practice to either close your resources or start naming on a safe mode. The 
                        <code>Res::open()</code> is used to open a resource inclusion on safe mode while <code>Res::close()</code>
                        is used to close currently opened resource group or to move back into the unamed storage space.
                    </div> <br>
                    
                    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> 
                        <div class="pxv-6 bc-off-white">Example 5 - Resource opening in safe mode</div> <br><br>
    <pre class="pre-code">
       
    <span class="comment">// Method 1 ----------------------------------------------------</span>
    Res::open();
    Res::name('js');

    Res::callFile('http://www.site.com/file.css');
    

    <span class="comment">// Method 2 ----------------------------------------------------</span>       
    Res::open();

    Res::new()
        ->name('js')
        ->url('http://www.site.com/file.css');


    <span class="comment">// Method 3 ----------------------------------------------------</span>       
    Res::new()

        ->urlOpen()
        ->name('js')
        ->url('http://www.site.com/file.css');
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                        The examples above reveals three different ways by which resource grouping can be started in safe mode. 
                        This can also be achieved by naming a group at the top of your application where the urls will be saved.

                       
                    </div> <br> 

                    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> 
                    <div class="pxv-6 bc-off-white">Example 6 - Resource closing</div> <br><br>
    <pre class="pre-code">
    <span class="comment">// Method 1</span>
    Res::name('css');
    Res::name('js');
    
    Res::close();

    <span class="comment">// Method 2</span>
    Res::new()

       ->name('js')
       ->urlClose();
    </pre>

                    </div> <br><br>

                    <div class="font-menu">
                        The resource <code>close()</code> can also clear previous storage when a bool of true 
                        is supplied as its argument. Using the <code>close()</code> outside of a storage space will 
                        reset all previously stored urls. This is why <code>open</code> or <code>urlOpen</code> is much
                        preferred as it also provides a safe mean of existing into unamed space. The "open" methods will 
                        never reset the storage space unless an bool argument of true is suuplied.
                    </div> <br>         
                </div>
            </div>

            <!-- Resource Naming -->
            <div class="resource-defaulting">
                <div class="fb-6">Resource url defaulting</div> <br>
                <div class="">
                    <div class="font-em-d9">
                        Resource supports that a base or root url can be set for static files. Hence, 
                        all subsequent urls will derive their parent url from the base url. The only way to 
                        escape this is by using the <code>xurl</code> method to overide the defualt url set or by closing 
                        the previously defined url base. The <code>new()</code> method accepts the default url base as shown in the 
                        example below:
                    </div> <br>
                    
                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    Res::new('res/assets/')

        ->url('css/file.css')
        ->url('js/file.js')

        ->xurl('res/main/css/file2.css')
        ->xurl('res/main/js/file3.js')

        ->url('css/file2.css')

        -> urlClose();
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                        The example above reveals that once a base url is set, the only way to overide it is by using the 
                        <code>xurl</code> method. However, the full file path must be included into the <code>xurl()</code> 
                        method. Every other <code>url()</code> declared will derive their base url from their parent <code>new()</code>
                        method just as shown above.
                    </div> <br> 

                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    <span class="comment">1.</span> Res::name('css');
    <span class="comment">2.</span> Res::name('js');
    <span class="comment">3.</span> 
    <span class="comment">4.</span> Res::new()->name('css')->name('js');
    </pre>

                    </div> <br><br>

                    <div class="font-menu">
                        When adding multiple groups, line 1 & 2 will be harder to manage, hence line 4 is mostly recommended
                    </div> <br>         
                </div>
            </div>

            <!-- Resource Ignoring -->
            <div class="resource-ignoring">
                <div class="fb-6">Resource ignoring</div> <br>
                <div class="">
                    <div class="font-em-d9">
                        By default, the <code>Res</code> class imports its static files from the <code>res</code> folder 
                        . In order to prevent this, a resource ignore <code>Res::ignore()</code> is used to reset its path from the root 
                        folder.The <code>Res::ignore()</code> method should come before the urls to be imported are stored. The <code>close()</code> 
                        <code>urlClose()</code> <code>open()</code> or <code>urlOpen()</code> methods can be used to terminate this rule. It is however 
                        preferable to avoid the use of <code>close</code> methods. 
                    </div> <br><br>
                    
                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    
    Res::new()->name('css')
        
       ->url('folder/file.js')
    
    <span class="comment no-select mox" style='border:dashed 1px; width: 97%'></span>

    Res::ignore(); 

    Res::new()->name('js')

       ->url('folder/file.js')
       ->urlClose();
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                       In example above, the <code>Res::ignore()</code> will only 
                       affect the urls stored after it was called while those above will not be affected. 
                       The <code>urlClose()</code> method will also terminate the effect of <code>Res::ignore()</code>
                    </div>
        
                </div>
            </div> <br> 

            <!-- Resource Definition -->
            <div class="resource-definition">
                <div class="fb-6">Resource Defining</div> <br>
                <div class="">
                    <div class="font-em-d9">
                        There are cases in which certain urls may not reveal their file extensions. This makes it difficult for 
                        Resource class to properly resolve such urls to their respective script. In such cases, the file extension should be supplied
                        manually to help resource class to resolve such urls. An example is shown below:
                    </div> <br>
                    
                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    
    Res::new()->name('js')

       ->url('http://site.com/js-file::js')
       ->url('http://site.com/css-file::css')

       ->urlClose();
    </pre>
                    </div> <br><br>

                    <div class="font-menu">
                       In example above, the urls supplied has no recognizable extension, however, if we know the 
                       type of file it is, we can tell the resource class to resolve the url with its respective script tag.
                       This is done by adding two colons and file extension after the url supplied. The extension will not be 
                       added by the resource class. These extensions only exists to help resource class to identify what tag should be 
                       used to resolve such urls. The urls when imported will be resolved into : <br><br>
                       <div class="bc-blue c-white pxv-10 font-em-1d1"> 
                           &lt;script src="http://site.com/js-file" &gt; <br><br>
                           &lt;link href="http://site.com/css-file" &gt; 
                       </div>
                    </div>
        
                </div>
            </div> <br> 

            <!-- Resource Importation -->
            <div class="resource-importing">
                <div class="fb-6">Resource importation</div> <br>
                <div class="">

                    <div class="font-em-d9">
                        Stored Resource group can be imported using the resource import <code>Res::import()</code> method. Resources 
                        can be imported using different methods. Before we proceed, we need to understand the features and capabilities of 
                        resource importer. <br><br>

                        <div class="pxs-20">Features of Resource importer</div>
                        <ul>
                            
                            <li>Importing static urls</li>
                            <li>Importing live server</li>
                            <li>Importing meta tags</li>
                        </ul> 
                        <br>
                        By configuration, resource import can be configured to import default meta tags or live server when importing urls. The 
                        Resource class has been configured in a way that both the liveserver and meta tags are imported once to the web page. These 
                        configuration settings are stored within the init file which can be configured manually or by use of shell commands. 

                        <br><br>
                        <div class="liveserver">
                            <div class="font-em-1d2 mvb-6">Live Server</div>
                            Using cli commands: <br>
                            <ul>
                                <li>
                                    Navigate to the core folder of your project file. For example: <code>c:\www\project_folder\core >> </code> 
                                </li>
                                <li>
                                    Run the command <code>php spoova watch <span class="c-green-l">online|offline|disable</span></code> to turn on or off the default live server
                                </li>
                                <li>
                                    Online : means to run live server in both online and offline environments
                                </li>
                                <li>
                                    Offline : means to run live server only in offline environments
                                </li>
                                <li>
                                    Disable : means to disable live server in both offline and online environments
                                </li>
                            </ul>

                            Once the live server is turned on, the resource class will include the live server when importing static urls to the web page and this 
                            action is only done once.
                        </div>

                        <br><br>
                        <div class="meta-tags">
                            <div class="font-em-1d2 mvb-6">Meta Tags</div>
                            Using cli commands: <br>
                            <ul>
                                <li>
                                    Navigate to the core folder of your project file. For example: <code>c:\www\project_folder\core >> </code> 
                                </li>
                                <li>
                                    Run the command <code>php spoova meta <span class="c-green-l">on|off</span></code> to turn on or off the default live server
                                </li>
                            </ul>

                            Once the resource meta is turned on, the resource class will include default configured meta tags when importing static urls to the web page. This action is also 
                            visited once.  Manually, the init file can be configured by setting the <code>RESOURCE_META</code> to <code>on</code>
                        </div>
                    </div> <br>
                    
                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    RESOURCE_META: on
    </pre>
                    </div> <br>
        
                </div>
            </div> <br> 


        </div>        
    </div> <br>

    <div>
        <div class="font-menu font-em-1 fb-6 bc-white-dd mox-full rad-4 pxv-8">
            Importing static urls
        </div> <br><br>


        <div class="">
            <div class="font-menu font-em-d9">
                Static urls are imported to the webpage by using the <code>Res::import()</code> method.
                The <code>import()</code> method supports different level of arguments which are discussed below: <br> <br>

                <div class="importing-groups">

                    The sample below (Fig 1) is used to explain resource importation. <br><br>

                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    Res::new('res/assets/')


       -> name('anime')
       -> url('css/anime.css')
       -> url('js/anime.js')


       -> name('design')
       -> url('css/design.css')
       -> url('js/design.js');
    </pre>
                    </div> 
                    Fig 1.
                    <br>
                
                </div>
            </div> <br>
        </div>   

        <div class="">
            <div class="font-menu font-em-d9">
               
                <div class="importing-groups">
                    <div class="head fb-6">Importing Groups</div>
                    <br> 

                    To import a group, a colon must be declared before the group name.  
                    The methods below reveal methods by which a groups can be imported into web page.
                    <br><br>

                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    <span class="comment">1.</span> Res::import(':anime');
    <span class="comment">2.</span> Res::import(':design');

    <span class="comment">3.</span> Res::import([':anime', ':design']);

    <span class="comment">4.</span> Res::import('res/',[':anime', ':design']);

    </pre>
                    </div> <br>
                
                    <div class="font-menu">
                       In example above, <code>line 1 & 2</code>  are methods of importing stored groups 
                       separately. The use of array in <code>line 3</code> is a concise way of importing 
                       multiple groups, without having to call the <code>import()</code> directive every time.
                       Files are resolved and imported in the way they are stored.  In <code>line 4</code>, urls
                       are imported with parent url of <code>res/</code> . However, this was used for testing purposes 
                       hence not recommended for use.
                    </div>

                </div>
            </div> <br>
        </div>   

        <div class="">
            <div class="font-menu font-em-d9">
               
                <div class="importing-groups">
                    <div class="head fb-6">Exporting Groups</div>
                    <br> 

                    To export a stored a group, the <code>Res::export()</code> is used although this can be achieved using 
                    <code>Res::import()</code>. Example below reveals how to export stored urls into variables
                    <br><br>

                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $urls = ":lists";

    Res::import('', [':anime'], $urls);
    
    var_dump($url);
    </pre>
                    </div> <br>
                
                    <div class="font-menu">
                       In example above, the variable <code>$url</code> was set with a value of 
                      <code>:lists</code>, then supplied into the <code>Res::import()</code> method. 
                      The directives tells the Resource class to update the value of <code>$url</code>
                      with the stored urls. Hence, <code>$url</code> was printed out to the page. Another way to export 
                      stored urls is shown below: <br><br>
                    </div>
                    
                    <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $exports1 = Res::export([':anime']);
    $exports2 = Res::export('../',[':anime']);
    </pre>
                    </div> <br>
                
                    <div class="font-menu">
                       In example above, the first variable will contain the stored urls while line 2 adds a suffix of 
                       <code>../</code> to imported local urls. The application of parent urls comes as a modification 
                       to existing urls that may become invalid in static scripts. These helps to properly map the loaded urls to their 
                       specific folders.
                       <br><br>
                    </div>
            </div> <br>
        </div>   
        
        


    </div>


    @lay('build.links:tutor_pointer')
</div>

@template;