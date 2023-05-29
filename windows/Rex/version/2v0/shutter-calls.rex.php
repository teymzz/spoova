@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div>  Shutter calls</div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Shutter controls (< 2.0) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                            Shutter calls are window methods or classes called from window's in-built shutter methods. When shutters are called arguments are passed into the method or 
                    class through predefined arguments which the method or class called picks up form its parent caller. In previous versions arguments are passed to methods through the 
                    <code>SELF::ARG</code> or <code>SELF::PARAM</code> shutter key as shown below:

                                <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Routes;

use Window;
use spoova/mi/core/classes/Ajax;

class Home extends Window { 

    function __construct() {

        $Ajax = new Ajax;
        $myArray = [1,2,3];

        self::call($this, 
            [
                window(':user/2.0') => 'user',
                
                SELF::ARG => [$Ajax, $myArray]
            ]
        )

    }


    function user($vars) {

        $Ajax = $vars[0];
        $myArray = $vars[1];

        <span class="comment">//do something ...</span>

    }

}
    </pre>
                                </div>
                                The example above reveals how to pass in arguments in previous versions. The main issue with this is that the 
                                supplied arguments are passed across to all methods called by the shutter even if they are not used and it is more difficult to  
                                pass different dependencies to different methods. 
                            </div> <br>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Shutter controls (2.0+)</div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                In version 2.0, there is an improved way of passing in dependencies into method using type hinting. Once the type is defined, the method will ensure that the dependency is initialized and passed into the 
                                method. This is shown below:

                                <div class="pre-area">
    <pre class="pre-code">
namespace spoova/mi/windows/Routes;

use Window;
use spoova/mi/core/classes/Ajax;
use spoova/mi/core/classes/Filemanager;

class Home extend Window { 

    function __construct() {

        $myArray = [1,2,3];

        self::call($this, 
            [
                window(':user') => 'user',
                window(':profile') => 'profile',

                self::ARG => $myArray
            ]
        )

    }


    function user($Ajax Ajax, $myArray) {

        <span class="comment">//do something ...</span>

    }

    function profile(Filemanager $Filemanager) {

        <span class="comment">//do something ...</span>

    }

}
    </pre>
                                </div>
                                In the example above, the dependencies are first called using type hinting while the passed arguments are obtained afterwards. 
                                This makes it easier to pass variables to the called methods on if it is required for use.
                            </div>
                            
                        </div> <br>
                    </div> <br>

                </div>
           </div>
       </section>
   </div>

@template;