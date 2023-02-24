@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-20 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Template on the go</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        While the cli is useful in generating rex files, yet it can prove difficult to create multiple files. 
                                        The <code>Window</code> class however supports the creation of rex files on the go. In this case users 
                                        are first notified that the php template rex file does not exist before going on to create the file. 
                                        This behavioral pattern is usally enabled within the code through the method <code>addRex()</code>.  
                                    </p>

                                </div>

                            </div> 
                        </div>  

                        <div id="addrex" class="">
                            <div class="">

                                <div class="">
                                  This method is used to apply colors on cli texts. There are four basic text colors support which are green, yellow, blue and red. Colors 
                                  are added by wrapping texts within the specific color code. The technology is based on the fact that a color code cannot be applied within another 
                                  color code. Hence, to apply diffent color codes on texts, each text must be wrapped separately within its own color. 
                                  <br><br>

                                  <div class="pre-area">
                                      <div class="box-full">
                                          <div class="pxv-6 bc-off-white">Syntax: addRex</div>
                                          <pre class="pre-code">
    Window::addRex($template_file); 
    <span class="comment no-select">
      where: $template_file is an optional existing template file that should be linked.
    </span>
                                          </pre>
                                      </div>
                                  </div>  <br><br>

                                  <div class="pre-area">
                                      <div class="box-full">
                                          <div class="pxv-10 bc-off-white">Example: addRex</div>
                                          <pre class="pre-code">
    &lt;?php 

    namespace spoova\windows\Routes;

    use Window;

    class Home extends Window {


        function __construct() {

            self::addRex();

            self::call($this, [

              'home' => 'root',

              'home/user' => 'user',
              
            ]);

        }

        function root() {

            self::load('home.index', fn() => compile() );

        }

        function user() {

            self::load('home.user', fn() => compile() );

        }


    }
                                          </pre>
                                      </div>
                                  </div>  

                                  <div class="foot-note pvs-20">

                                    In the code above, assuming the <code>home.index</code> template file 
                                    (i.e windows/Rex/window/home/index.rex.php) file does not exist, when the <code>home</code> 
                                    page is visited, the page will display the notification that the template file does not exist 
                                    then will go on to create it. This behaviour will also work for the <code>home/user</code> page 
                                    which will also instruct the <code>load()</code> method to create the template file. This makes it easier to generate 
                                    rex template files. In certain situations, we can also use the <code>addRex()</code> method to add link to external template 
                                    files. This is mostly useful when we have a live template file that can keep our page on the go. 

                                  </div> <br>

                                  <div class="pre-area">
                                      <div class="box-full">
                                          <div class="pxv-6 bc-off-white"><code>Example 2: addRex</code></div>
                                          <pre class="pre-code">
    &lt;?php 

    namespace spoova\windows\Routes;

    use Window;

    class Home extends Window {


        function __construct() {

            self::addRex('template.tut');

            self::call($this, [

              'home' => 'root',

              'home/user' => 'user',
              
            ]);

        }

        function root() {

            self::load('home.index', fn() => compile() );

        }

        function user() {

            self::load('home.user', fn() => compile() );

        }


    }
                                          </pre>
                                      </div>
                                  </div> 

                                  <div class="foot-note pvs-10">
                                    In the code above, assuming we have an already existing template file "template.tut" in the expected 
                                    template path, the <code>self::addRex()</code> will instruct the <code>load()</code> to link to the template 
                                    file once it is generated. Assuming the "template.tut" rex file is already configured to be on a live state mode, 
                                    this makes it easier for our newly generated template file to inherit the live state mode automatically. In this manner 
                                    we won't have to refresh the page because it is already linked to the live server system and once we start adding contents 
                                    within the template division, the page will automically be refreshed saving a couple of time needed to get this process started.
                                  </div>

                                </div> 

                            </div> 
                        </div> <br>

                        @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;