@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div>  Window urls</div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Shutter controls </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                In previous updates, window urls having dots are converted to slashes making it impossible to have dots in shutter urls. An example is shown below:

                                <div class="pre-area">
    <pre class="pre-code">
namespace windows/Routes;

class Home { 

    function __construct() {

        self::call($this, 
            [
                window(':user/2.0') => 'user'
            ]
        )

    }


    function user() {

        <span class="comment">//do something ...</span>

    }

}
    </pre>
                                </div>
                                In the example above, the <code class="bd-f">window()</code> function will convert <code>user/2.0</code> to <code>user/2/0</code> is visited. This
                                will prevent the page from loading because by default, all dots are converted to slashes in the window's function. When working with urls such as this, it is 
                                helpful to be able to overide such default behavior. The new version fixes this issue and the default behavior can now be modified by supplying a boolean argument 
                                of <code>true</code> to the window's function.
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Shutter controls (2.0)</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                An improved way of handing urls that contains dots

                                <div class="pre-area">
    <pre class="pre-code">
namespace windows/Routes;

class Home { 

    function __construct() {

        self::call($this, 
            [
                window(':user/2.0', true) => 'user'
            ]
        )

    }


    function user() {

        <span class="comment">//do something ...</span>

    }

}
    </pre>
                                </div>
                                In the example above, the window function will now resolve the argument supplied by ignoring the conversion of dots to slashes. Hence, the 
                                <code>user()</code> method will now be called when the relative page is visited.
                            </p>
                            
                        </div>
                    </div> <br>

                </div>
           </div>
       </section>
   </div>

@template;