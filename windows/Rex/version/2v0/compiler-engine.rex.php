@template('template.t-tut')

    @title('compiler engine')

    @lay('build.co.navbars:left-nav')

    <style>
        table.spaced {
            border-collapse: separate;
            border-spacing: 1em;
        }
    </style>

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> 
                          <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div>  Compiler Engine
                        </div>
                    </div>

                    <div class="font-em-d8">
                      Spoova's compiler engine have been updated for more functionalities. In the previous versions only 
                      two compiler functions were used to compile template files which are the "compile" and "view()" functions. 
                      The limitation of the "compile" function is that it cannot be used more than once within a window call. Both of 
                      these methods have been redefined and while the "compile" returns a string previously, the new update now returns 
                      an object of the Compiler class. This makes it easier to extend its functionalities and also makes it possible to 
                      run the compiler functions more than once. With the new updates and added functionalities to version 2.0, template 
                      compilers now become easier to use.
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compile string argument (2.0+)</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                            The compiler function now uses strings as rex file paths starting from version 2.0 upwards

                                <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Routes;

use Window;
use spoova/mi/core/classes/Ajax;

class Home extends Window { 

    function __construct() {

        $Ajax = new Ajax;
        $myArray = [1,2,3];

        self::load('home', fn() => compile('user.home') );

    }

}
    </pre>
                                </div>
                                In the example above, the compiler function "compile" above will 
                                render its string argument as a rex template file into the supplied storage file name 
                                "home". Hence, the file "core/storage/home.php" will be the storage file name while "windows/Rex/user/home.rex.php" is the template file itself. 
                                However, if a string argument is not supplied, the 
                                <code>self::load()</code> method will assume that the file name "home" (i.e windows/Rex/home.rex.php) supplied is the intended rex template file.
                                file.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compile Similarities (2.0 <) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The former behaviour of compile function with array arguments still remains the same

                                <div class="pre-area">
    <pre class="pre-code">
namespace windows/Routes;

class Home { 

    function __construct() {

        self::load('sample_file', fn() => compile(['name'=>'foo']));

    }

}
    </pre>
                                </div>
                                In the example above, the compile function will still be able to pass variables to the template file because 
                                array are used as variable containers.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compile Improvements </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Previously, the compiler function does not exist as a stand-alone function. It needs to be used within the <code>Res::load()</code> 
                                or a window's "self::load()" method. The new updates now ensures that the <code>compile()</code> function can exist as a stand alone.

                                <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Routes;

use Window;

class Home extends Window{ 

    function __construct() {

       echo compile('sample', ['name'=> 'foo']);

    }

}
    </pre>
                                </div>
                                In the example above, the compile function will render the "windows/Rex/sample.rex.php" file and the content will be printed to the page. 
                                The compile function returns a compiler object and without printing the content, the file will not be fully rendered. However, because the 
                                compiler is now an object, it makes it possible to manage our template files before finally being displayed as a view. For example, we can fetch our raw 
                                page and do some other things to them before finally rendering the page.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Compiler Class </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Since the compile function returns a Compiler object, it is only natural that we discuss the Compiler class itself. Compiler class introduced in 
                                spoova 2.0 version, is the template engine class that helps to render the rex template files in a structured form providing some form of flexibility 
                                in the way template files are managed and rendered. The following code lines reveals how to render a rex template from the compiler class:

                                <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Routes;

use Window;
use spoova/mi/core/classes/Compiler;

class Home extends Window { 

    function __construct() {

       $args = ['name' => 'foo'];

       $Compiler = new Compiler('sample', $args);
      
       $Compiler->compile(); <span class="comment">//compile and print page</span>

    }

}
    </pre>
                                </div>
                                In the example above, the compile function will render the "windows/Rex/sample.rex.php" file and the content will be printed to the page. The 
                                supplied variables will also be passed to the template file while the <code>compile()</code> method will compile the entire file and render the 
                                content on the webpage. There are also other activities we can perform with this class. For more details about the compiler class, visit  
                                <a href="@domurl('version/2.0/compiler-class')">here</a>.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Template Rendering </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                A major change has been made to directive comments. Previously, when a comment <code>&#64;()&#64;</code> is used, it is usually 
                                resolved as a single "at" sign <code>@</code>. So a template directive <code>&#64;(domurl())&#64;</code> will be resolved as 
                                <code>@(@domurl())@</code>. The scope of this comment has been expanded which calls for remodification as it is not only used for directives anymore. Contrary to the 
                                previous behaviour the new behaviour will return its direct content. This means that an additional "at" sign will no longer be added by default. Hence, 
                                <code>&#64;(domurl())&#64;</code> for example, will now return <code>@(domurl())@</code> while  
                                <code>&#64;(&#64;domurl())&#64;</code> will now return <code>@(@domurl())@</code>. The following samples reflect the new behaviour:
                                <br><br>

                                <div class="bc-white pxv-10">

                                    <table class="wid-full font-em-d85 spaced">
                                        <tr><th>Comment (sample)</th><th>Response</th></tr>
                                        <tr><td><code>&#64;(domurl())&#64;</code></td><td><code>@(domurl())@</code></td></tr>
                                        <tr><td><code>&#64;(&#64;domurl())&#64;</code></td><td><code>@(@domurl())@</code></td></tr>
                                        <tr><td><code>&#64;(&#123;{}&#125;)&#64;</code></td><td><code>@({{}})@</code></td></tr>
                                    </table>
                                </div> <br>
                    
                            </div>
                            
                        </div>
                    </div> <br>

                </div>
                
           </div>
       </section>
   </div>

@template;