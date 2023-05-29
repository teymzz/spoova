@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    @layout:rex 

                    <div class="font-em-1d5 c-orange">Window Rex</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Rex files are template files that use template directives to control and manage the content of webpages. They are capable of 
                            using decoupled component files to structure or restructure how a page content is organized. Rex template files are usually 
                            found within the <code>windows/Rex</code> directory and they are usually rendered using compiler functions which can be <code>compile()</code>  
                            or <code>view()</code> functions. Rex files makes it easier to load and modify pages without having to write multiple codes. In spoova, there are 
                            three types of template files. These files are : <br><br>

                            <ul>
                                <li>php template files</li>
                                <li>css template files</li>
                                <li>javascript template files</li>
                            </ul>

                            The rex template files can easily be identified by their respective extensions. For example a css file assumes a 
                            <code>.css</code> extension while php and javascript assumes the <code>.php</code> and <code>.js</code> extensions respectively. 
                            Rex files are mostly identified by the <code>.rex</code> extension name which comes before the real extension name. 
                            This means that whilst a php rex file uses a <code>.rex.php</code> extension, the css files uses <code>.rex.css</code> and javascript 
                            files uses <code>.rex.js</code> extension name. This naming pattern makes it easier to identify the rex files and the type of 
                            code language each contains.

                        </div> 
                    </div> <br>
                    
                    <div class=""> 

                        <div class="php-rex-files">
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> PHP Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The php rex files are the main rex files upon which other template files are built. 
                                        They are usually compiled by the <code>compile()</code> or <code>view()</code> 
                                        functions. When a compiler function is used, it take a first argument which defines 
                                        the path of a php rex file within the <code>windows/Rex</code> directory. For example: <br> 
                                        <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 1 - PHP rex file compilation (index.rex.php)</div>
        <pre class="pre-code">
    namespace windows\Routes;

    use window;

    class Home extends Window {
        
        function __construct(){

            self::load('index', fn() => compile() );

        }

    } 
        </pre>
    </div>
                                        <div class="foot-note mvs-6">
                                            In the code above the <code>load()</code> method will look for the <code>index.rex.php</code> file within the 
                                            <code>windows/Rex</code> directory. If such file exists, then the compiler function <code>compile()</code> will 
                                            compile the rex template file.
                                        </div>
    
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="css-rex-files">
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> CSS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The css rex files stylesheets that are directly loaded into the webpage as embedded stylesheets. 
                                        In css rex files, stylesheets are divided into sections with each section having its own unique style name. 
                                        The path of a stylesheet along with its unique name makes it possible to import only specifically needed style within an 
                                        external css rex file. When compiling php rex file data, only the defined css styles will be extracted from a stylesheet file while other css will 
                                        be ignored. An example below shows how the format of a css rex file.
                                        <br><br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 2a: Css File (index.rex.css)</div>
        <pre class="pre-code">
    &#35;style:header
    <span class="c-orange-dd">
    .header{

      background-color: red;

    }
    </span>
    &#35;style;


    &#35;style:footer
      <span class="c-orange-dd">
    .footer{

      width: 100%;

    }
      </span>
    &#35;style;
        </pre>
    </div>
                                        <div class="foot-note mvs-6">
                                            The code in sample 2 above is an example of sectionalizing of a rex css file. Each section above can be imported into a php rex file 
                                            using the <code>@(style())@</code> directive. Only the css style names declared within the directive will be pulled into the php rex file. 
                                            . For example, assuming the css file above is located within the <code>windows/Rex/Css</code> directory, then to import the css file above, 
                                            a php rex file will contain the following code:
                                        
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 2b: PHP File (somefile.rex.php)</div>
        <pre class="pre-code">
  @(style('css.index:header'))@;
        </pre>
    </div>       
                                        <div class="foot-note">
                                        In the code above when the file <code>somefile.rex.php</code> is compiled, the compiler will extract css styles 
                                        from <code>windows/Rex/css/index.rex.css</code>. Only the styles within the header section will be extracted.
                                        The compiled data will resemble the code below:
                                        </div> <br>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">compiled data</div>
        <pre class="pre-code">
    &lt;style rel="css.index"&gt;

      .header{

        background-color: red;

      }

    &lt;/style&gt;
        </pre>
    </div>                                
                   
                                        <div class="foot-note pvs-10">
                                            The <code>rel</code> attribute helps to reveal the path of the css file as it can become difficult to locate stylesheet 
                                            files when working on large projects. The path shown in the <code>rel</code> attribute is usually a path within the 
                                            <code>windows/Rex</code> directory. In certain situations we can import multiple styles from a single css file. This
                                            can be done by first defining the file path, then each style section is extracted by their unique names. The unique names 
                                            in this case will be separated by columns. For example, the code below is an example of multiple style extraction from a single css 
                                            file. Both the <code>footer</code> and <code>header</code> styles will be imported as the compiled data.
                                        </div>
    <div class="pre-area">
        <div class="pxv-10 bc-silver">somefile.rex.php</div>
        <pre class="pre-code">
  @(style('css.index:header:footer'))@;    
        </pre>
    </div>      
                                    </div>
                                </div>
                            </div>

                        </div> <br>

                        <div class="js-rex-files">
                            
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> JS Rex Files </div>
                            </div>
                            <div class="">
                                <div class="">
                                    <div class="desc mvt-10">
                                        
                                        The javascript rex files are external javascript files are compiled directly into the webpage as embedded scripts through the 
                                        template directive <code>@(script())@</code>. In js rex files, scripts are also divided into sections with each section having its own unique name. 
                                        An example below shows the format of a js rex file <br><br>
                                        
    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 3: Js Rex File (index.rex.js)</div>
        <pre class="pre-code">
    &#35;script:header

      window.onload = function() {

        alert('loaded');

      }

    &#35;script;
        </pre>
    </div>
                              
                                        <div class="foot-note">
                                            Assuming we have the rex file above to be within the <code class="">"windows/Rex/js/"</code> directory, then we can import the file as shown below:
                                        </div>

    <div class="pre-area">
        <div class="pxv-10 bc-silver">Sample 3b: PHP File (some.rex.php) to file</div>
        <pre class="pre-code">
    @(script('js.index:header'))@
        </pre>
    </div>
                                        <div class="foot-note">
                                            The path supplied above is expected to be found at <code>windows/Rex/js/index.rex.php</code>. The data compiled from the file above will be as below:
                                        </div>                                       
    <div class="pre-area">
        <div class="pxv-10 bc-silver">compiled data</div>
        <pre class="pre-code">
    &lt;script&gt;

      window.onload = function() {

        alert('loaded');

      }

    &lt;script&gt;
        </pre>
    </div>  

                                        <div class="foot-note mvs-6">
                                            Note that when compiling the template directives, an error will displayed only if the source file of the expectant rex file is missing. If the file is 
                                            not missing but the unique name supplied is not defined within the rex files (i.e css and js), no error will be displayed.  
                                        </div>
                       
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                
                    </div>  <br>

                    @lay('build.co.links:tutor_pointer')

                </div>

                @layout;
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;