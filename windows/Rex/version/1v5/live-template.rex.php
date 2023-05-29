@template('template.t-tut:off')

    @title('Spoova 1.5')

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 1.5+ </div>  Live template</div>
                    </div>
                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-grid"></span> Template on the go </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Template on the go was a feature added to make it easier to create template files easily by taking 
                                advantage of the integrated live server feature. If a rex template file does not exist, we can forward a signal to 
                                the widow's <code>self::load()</code> method to automatically generate the template file when the relative page is visted. 
                                This functionality is achievable through the <code>self::addRex()</code> method. Not only does the template file generate 
                                itself but it also generates on a live state making it possible to continue  with development on a live state. The <code>self::addRex()</code> 
                                must however be called before the template is generated to keep it on a live state mode using live server directives.  
                            </p>
                            
                        </div>
                    </div> <br>

                    
                    <div class="font-em-d8">

                        <div class="list-free pxs-1">
                            <div class="mox bc-silver pxv-4 rad-5">
                                
                                <div class="pxv-10">
                                    <span class="bi-arrow-clockwise"></span> Live template generation #1<br>
                                </div>
                            
                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver-d">windows/Routes/Home</div>
                                    <pre class="pre-code">
  class Home{

    function __construct(){

        self::addRex();

        self::load('sample', fn() => compile() );

    }

  }
                                    </pre>
                                </div>

                                <div class="foot-note pxv-10">
                                    Using the example above as reference, assuming that the supplied rex path does not exist, the  
                                    <code>self::addRex()</code> method will direct the <code>self::load()</code> method to create
                                    the rex file. This means that from the example above, a file <code>sample.rex.php</code> will be 
                                    added into the <code>"windows/Rex"</code> directory if it does not already exist.
                                </div>
                            </div> <br>
                        </div>

                        <div class="list-free pxs-1">
                            <div class="mox bc-silver pxv-4 rad-5">
                                
                                <div class="pxv-10">
                                    <span class="bi-arrow-clockwise"></span> Extensive properties #2<br>
                                </div>
                            
                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver-d">windows/Routes/Home</div>
                                    <pre class="pre-code">
  class Home{

    function __construct(){

        self::addRex();

        self::call($this, 
            [
                window(':') => "index",
                window(':users') => "users",
            ]
        )


    }

    function index() {
        
        self::load('home.index', fn() => compile() );

    }

    function users() {
        
        self::load('home.users', fn() => compile() );

    }

  }
                                    </pre>
                                </div>

                                <div class="foot-note pxv-10">
                                    The <code>self::addRex()</code> method is one which has extensive properties. This means that 
                                    the directive to generate a rex file can be inherited by subsequent shutter invoked methods. In the example 
                                    above, both the <code>home/index.rex.php</code> and <code>home/users.rex.php</code> files will be generated 
                                    once their respective methods are invoked (or relative page visited). This is a top level call that makes it easier to generate rex files. 
                                    This functionality can also be restricted only to a specific shutter method through the <code>SELF::ONCALL</code> shutter middleware preload 
                                    key.
                                </div>
                            </div> <br>
                        </div>

                        <div class="list-free pxs-1">
                            <div class="mox bc-silver pxv-4 rad-5">
                                
                                <div class="pxv-10">
                                    <span class="bi-arrow-clockwise"></span> Template inheritance #3<br>
                                </div>
                            
                                <div class="pre-area">
                                    <div class="pxv-10 bc-silver-d">windows/Routes/Home</div>
                                    <pre class="pre-code">
  class Home{

    function __construct(){

        self::addRex('some.template');
        
        self::load('home.index', fn() => compile() );

    }

  }
                                    </pre>
                                </div>

                                <div class="foot-note pxv-10">
                                    The <code>self::addRex()</code> method takes an argument, one which allows it 
                                    to extend to a default template file when generating a template file. In this case, 
                                    the live status of the template file will be determined by the parent template file 
                                    that is inherited from. The example above will generate a template file using the the 
                                    default template structure which resembles the format below
                                </div>

                                <div class="pre-area">
                                    <pre class="pre-code">
  @(template('some.template'))@

  @(template;)@
                                    </pre>
                                </div>
                            </div> <br>
                        </div>

                    </div>

                </div>
           </div>
       </section>
   </div>

@template;