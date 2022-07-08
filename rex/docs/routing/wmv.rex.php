

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

    <div class="font-em-1d5 c-orange">Routing WMV</div> <br>
    
    <div class="db-connection">
        <div class="fb-6">Introduction</div>
        <div class="">
            The wmv routing is done by loading windows files. Windows files 
            are all loaded from the windows folder. By default, when a url does not exist,
            spoova tries run its windows files from the windows folder. If the path does not exist,
            spoova will transfer its url through an Indexed door from the windows folder. This is done by
            processing the <code>Index</code> class within the windows folder. The Index is then used to handle 
            other incoming urls which if not handled will return a 404 error page. The architectural pattern flow is
            shown below.
            <br><br>
            <div class="font-menu  font-em-d85 bc-white-dd mox-full rad-4 pxv-8">
                url > windows -> index -> 404 error page
            </div>
        </div> 
    </div> <br>

    <div class="db-operations">
        <div class="fb-6">Setting up a new wmv route</div>
        <div class="font-menu font-em-1">
            All window files are loaded from the windows folder. These files
            can be extended to different Frames. Frames are channels that can be applied
            on window files. Their functions are to define basic structure or concepts a window
            can emulate. For example, Frame files can be used to separate or divide sessions which are
            only recognized in some particular windows files. Hence, all window files extennding to such 
            Frames will only derive their session values from their parent frame file. Windows files can use the
            Res::load() method which also searches for its template files from the rex folder.  Proceedures below 
            helps to explain the steps or stages involved in setting up a windows file.
            <br><br>
            Setup steps <br><br>
            <ul>
                <li>Create a separate frame folder within the windows folder</li>
                <li>In the frame folder, Create a base group class frame file for the windows files that will share the same data.</li>
                <li>Create a windows's page by using the page's name as a class in the Windows File.</li>
                <li>Extend your windows file to your frame file</li>
                <li>Add a construct method within the windows file created in one above</li>
                <li>
                    Once this is done, when a user tries to access a page with the name of your windows file,
                    the windows file will be automatically loaded up from the windows folder. If such names do not
                    exist as a windows file, the controller is passed on to an Index class within the windows folder
                    through a <code>door</code> from the index file. The door then handles the url depending on the developers 
                    setup. If the non-existing url is not handled within the <code>door()</code>, a 404 error is returned.
                </li>
            </ul>
        </div> <br>

        <div class="">File 1 - Frame file (UserFrame.php)</div> <br>         
        <div class="font-em-d95">Step 1 & 2 above : This frame file will be added inside the Frame folder directory within the windows folder.</div> <br>     
        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    &lt;?php

        namespace spoova\windows\Frame;
        use Window;

        class Userframe extends Window{

            function data() {

                return ['name' => 'Felix'];

            }

        }

    ?&gt;
    </pre>
        </div> <br><br>     

        <div class="">File 2 - Windows file (Home.php)</div> <br>         
        <div class="font-em-d95">Step 3, 4 & 5 above</div> <br> 
        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    &lt;?php

        use app/windows/Frame/UserFrame;

        class Home extend Userframe{

            function __construct() {

                print "This is the homepage";

            }

        }

    ?&gt;
    </pre>
        </div> <br><br>



        <div class="">Notice :</div>          
        <div class="font-em-d95">
            Since the <code>Res::load()</code> can be applied on windows files just like mvc, then we can say: <br>
        </div> <br> 

        <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br> 
    <pre class="pre-code">
    &lt;?php

        namespace app/windows;

        use app/windows/Frame/UserFrame;


        class Home extend Userframe{

            function __construct() {

                Res::load( 'index', fn => compile() );

            }

        }

    ?&gt;
    </pre>
        </div> <br> <br>

        <ul>
            <li>
                In example above:
                <br> File 1 <code class="c-sky-blue-dd">UserFrame.php</code> was added into the Frame folder 
                and the UserFrame class was extended to the Windows.
            </li><br>
            <li>
              File 2 <code class="c-sky-blue-dd">Home.php</code> must be a windows File. 
              Hence, it was extended to the Frame file <code class="c-sky-blue-dd">UserFrame.php</code>. 
            </li><br>
            <li>
                The last code section reveals how to use the resource load method <code>Res::load</code> within the windows File.
            </li>
        </ul>

        <div class="font-i c-silver-dd font-menu font-em-d97">
            <span class="fb-6">Footnote:</span><br>

            It is important to note that file compiling, that is, the use of <code>compile()</code>. can only be done once <br><br>
            If multiple files will be compiled, then it is preferred to use the <code>view()</code> function. There are distinctive differences
            between <code>compile()</code> and <code>view()</code> . This is discussed under the compiler functions tutorial.

            The last example below shows how <code>view()</code> can be used within classes
          
            <br><br>
        </div>
    </div> <br>
    
    <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br> 
    <pre class="pre-code">
    &lt;?php

        namespace app/windows;

        use app/windows/Frame/UserFrame;


        class Home extend Userframe{

            function __construct() {

                $view1 = Res::load( 'index', fn => view() );
                $view2 = Res::load( 'home', fn => view() );

                return $view1.$view2;

            }

        }

    ?&gt;
    </pre>
        </div> <br> <br>  
    @lay('build.links:tutor_pointer')
</div>

@template;