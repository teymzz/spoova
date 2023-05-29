@template('template.t-tut')

    @title('compiler class')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> 
                          <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div>  Compiler Class
                        </div>
                    </div>

                    <div class="font-em-d8">
                      <div class="">
                        The spoova's compiler class is introduced in version 2.0 in order to improve rex template engine 
                        by providing an easier and much flexible way of rendering template files. The major effect of this is 
                        to be able to add an extended control for template files. The following below are the useful subjects that
                        be discussed separately in order to have a full understnding of what the Compiler object does. 
                      </div> <br>                   
                      <div class="">
                        <ul>  
                          <li>Compiler instantiation</li>
                          <li>Compiler for string</li>
                          <li>Fetching rendered content</li>
                          <li>Viewing rendered content</li>
                          <li>Compiler improvements</li>
                          <li>Compiler helper functions</li>
                        </ul>
                      </div>
                    </div> <br>



                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler Instantiation</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                            The compiler object initialization syntax is as shown below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler($filepath, $vargs);

<span class="comment">
  where:
  
    $filepath : optional rex file path 
    $vargs    : optional variable arguments  
</span>
    </pre>
                                </div>

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 1</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler('user.home', ['name' => foo]);

                                </div>


                                In the example above, the compiler was initialized with a rex file path "user.home" and variable arguments 
                                were supplied using array as the second parameter which can the be accessed using the placeholder template 
                                directive (i.e <code>@({{ $name }})@</code> ) . Although, arguments are supplied above, we don't necessarily need to 
                                instantiate the Compiler class with objects. The <code>setFile()</code> method can be used to set or update the file name while the 
                                <code>setArgs()</code> can be used to set or update arguments. This is shown below:
                            

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 2</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->setFile('user.home');
  $Compiler->setArgs(['name' => foo]);
                                </div>

                                <div class="">
                                  In the example 2 above, the <code>setFile()</code> and <code>setArgs()</code> are both used 
                                  to set or update the file path and file arguments respectively. Both of these can also be defined using the <code>compile()</code> 
                                  method instead. This is shown below: 
                                </div> <br>
                                
                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 3</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->compile('user.home', ['name' => foo]);
                                </div>
                                
                                <div class="">
                                  In example 3 above, the compiler method does not necessarily need to follow the predefined order. The arguments may be switched interchangeably such that 
                                  arguments come before the file name, however, both arguments cannot be of the same data type. One must be a string which defines the file path while the others 
                                  is an array which defines the variable arguments.
                                </div>
                                
                                <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler For Strings </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                            One of the major feature of the compiler class is the ability to compile strings only into file path. This means that rather than a 
                            real template file, instead, a string content is supplied for rendering. The string will be compiled and added into a defined template file for viewing. This can be achieved 
                            through the sample procedure below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler;

  $Compiler->body($body);

  $Compiler->setBase($storage_path); <span class="comment">//set a storage path for rendered string</span>

<span class="comment"> where :

  $body         : a string content to be rendered. 
  $storage_path : a unique subdirectory in "core/storage" directory. 
</span>
    </pre>
                                </div>

                                <div class="pre-area bc-white mvs-5">
                                  <div class="pxv-10 bc-silver rad-5">Example 5</div>
    <pre class="pre-code">
  use spoova/mi/core/classes/Compiler;

  $Compiler = new Compiler();

  $Compiler->setBase('folder_name');

  $Compiler->body('This is a body content');
                                </div>
                                
                                <div class="">
                                  In the example above, the compiler will assume to render the string as a raw content into the specfied folder name. It is 
                                  important to note that <code>setBase()</code> method is used by compiler to specify folder name where rendered contents are expected 
                                  to be stored. This is usually a subdirectory of the "core/storage" directory. It is important to keep rendered strings path as a separate 
                                  path from other basic files to avoid conflicting files.
                                </div> <br>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Fetching Rendered Content </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                When a file or string is rendered, the contents can be obtained using the <code>rex()</code> method 
                                which returns a rendered string content. This is shown below

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use spoova/mi/core/classes/Compiler;

  class Home { 

      function __construct() {

        $Compiler = new Compiler();

        $Compiler->compile('file');

        $rex = $Compiler->rex();

        vdump($rex); <span class="comment">//variable dump content</span>

      }

  }
    </pre>
                                </div>
                            </div>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Viewing Rendered Content</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                There are couple of ways to print the rendered components. However, the displaying of rendered  
                                components is best understood by printing the object of the class itself. This means that any of the 
                                methods of the Compiler class that returns the Compiler object instance will be able to display the 
                                rendered contents as long as all essential parameters have be properly defined. An example below is a short way 
                                of displaying a rendered file.
                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  use spoova/mi/core/classes/Compiler;

  class Home extends Window { 

      function __construct() {

        echo new Compiler('file', ['name'=> 'foo']);

      }

  }
    </pre>
                                </div>
                                In the example above, the compiler object will be able to display the rendered component on the webpage when the relative page 
                                is visited. We can also make use of the compiler helper function "compile()" rather than the class itself
                            </div> <br>

                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compile Improvements </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                One of the major improvements to the compiler function is that previously it does 
                                not exist as a stand-alone function which means that it needs to be used within the 
                                <code>Res::load()</code> or a window's "self::load()" method. The new updates now ensures 
                                that the <code>compile()</code> function can exist as a stand alone function.

                                <div class="pre-area bc-white mvs-5">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;

  class Home extends Window { 

      function __construct() {

        echo compile('sample', ['name'=> 'foo']);

      }

  }
    </pre>
                                </div>
                                In the example above, the compile function will render the sampe file and the content will be printed to the page just like the  
                                Compiler class does. This behaviour is because the compile function now returns a compiler object.
                            </div>
                            
                        </div> <br>
                    </div> <br>


                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler Helper Functions </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1 font-em-d8">
                            <div>
                              Aside from the "compile()" function, new functions have been introduced to help render files in a specifically designed way. These functions 
                              include <code>raw()</code> and <code>rex()</code> functions.
                            </div> 
                        </div><br>                  
                        <div class="font-em-d8">
                          
                          <div class="function-raw">
                            <div class="bc-silver pxv-10 pxs-20">
                              Function: raw()
                            </div>
                            <div class="pxv-20">
                              This function is used to obtain the direct raw content of a rex file before it is rendrered. The example of its usage is displayed below
                              <div>
                                  
  
                                  <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;
  
  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $raw = raw('sample'); <span class="comment">//source code</span>
         vdump($raw);
  
      }
  
  }
      </pre>
                                  </div>
                                  In the example above, function will return a raw string content of the rex sample file expected to be within the "window/Rex" directory.
                              </div>                          
                            </div>
                          </div>

                          <div class="function-view">
                            <div class="bc-silver pxv-10 pxs-20">
                              Function: rex()
                            </div>
                            <div class="pxv-20">
                              
                              This function is used to obtain the string content of a rendered rex file. The example of its usage is displayed below
                              
                              <div>

                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample'); <span class="comment">//return rendered content</span>
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                                <div>
                                  In the example above, function will return a string content of the rex file expected to be within the "window/Rex" directory. We can also 
                                  return a string content into the rex file through the second argument as shown below: 
                                </div>
                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;
  
  use Window;

  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample', fn() => 'My url is @(domurl())@'); <span class="comment">//return rendered content of the string </span>   
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                                <div class="">
                                  Just like the <code>window::load()</code> method, we can also use the "compile()" function as a directive to compile the sample file and pass arguments 
                                  to the file instead of using the "sample" file as an anchor for a string content like the previous example. 
                                </div>
                                <div class="pre-area bc-white mvs-5">
      <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use Window;
  
  class Home extends Window { 
  
      function __construct() {
  
         $rex = rex('sample', fn() =>compile(['name'=>'foo'])); <span class="comment">//return rendered content of the string </span>   
         vdump($rex);
  
      }
  
  }
      </pre>
                                </div>
                              </div>                          
                            </div>
                          </div>
                            
                        </div>
                    </div> <br>

                </div>
                
           </div>
       </section>
   </div>

@template;