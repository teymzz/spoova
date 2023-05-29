@template('template.t-tut')

    @title('Other updates')

    @lay('build.co.navbars:left-nav')


   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 2.0+ </div> Models </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Request Class </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <p>
                            The <code>Request->has()</code> method is used to check if a string key exists in a list of request data keys. The new update allows the 
                            <code>has()</code> method to check for multiple keys and returns false if any of the keys is not defined.
                            </p> 
                            <div class="pre-area bc-white">
    <pre class="pre-code">
  namespace spoova/mi/windows/Routes;

  use spoova/mi/core/classes/Request;
  use Window;

  class Home extends Window { 

      function __construct(Request $Request) {

        if($Request->has(['firstname', 'lastname'])) {

          <span class="comment">//all required keys exists.</span>

        }

      }

  }
    </pre>
                            </div>
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-exclamation-triangle"></span> Res class </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <p>
                            The <code>Res</code> class now has its <code>get()</code>, <code>gett()</code>, <code>post()</code> and <code>postt()</code> methods completely removed. These 
                            method were used initially to test route requests prior to the initial release which has seen routes handled using specially defined window logics.
                            </p> 
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Helper Function: error() </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">
                            <p>
                            The <code>error()</code> helper function previously returns a string value obtained from an error key when a form is submitted. This function has been remodified to 
                            return a mixed data type. Data returned will now be dependent on the type of data obtained when an error key is supplied. Note that the <code>error()</code> function 
                            is equivalent to the <code>@(error())@</code> template directive.
                            </p> 
                        </div>
                    </div> <br>

                </div>
           </div>
       </section>
   </div>

@template;