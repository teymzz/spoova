@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                  <div class="font-em-1d5 c-orange">Frames</div> <br>  
                  
                  <div class="frames-description">
                    <div class="">
                        <p>
                            In Windows architectural pattern, Frames are extensions of the Window class which means that frames are also windows. 
                            Frames are binding structures that act as bridges between a parent window and another child window, more like a root window and its subwindows. 
                            They can be referred to as data house as they provide a medium for which data can be localized and channeled across different window files. 
                        </p>

                        <p>
                            The handling of sessions is one key feature why the use of Frames may be advised. 
                            Although spoova naturally supports multiple sessions, frames help to separate sessions from each other while providing 
                            an organized structure and pattern to which each session disseminates its information  
                        </p>

                        <p>
                          When creating Frame files or classes, it is important to separate them from other window files and they should be in
                          any subdirectory of the window folder. This makes it easier to locate them. 
                          Also, as a naming convention, Frames should be appended the name "Frame". For example a frame file with name of <code>IndexFrame</code> 
                          sends a meaning that such frame belongs to the Index files or files that may exists outside a session while one with a name of 
                          <code>UserFrame</code> reveals that it contains data for a user account. 
                        </p>

                        <div class="font-em-1d2 c-orange">The super method</div>  

                        The <code>super()</code> method is a method that helps window to perform operations tha must run before any window handler file is executed.
                        This function can be useful for instantianting functions or even initializing session configurations. The key point is that super method should 
                        only be declared within a frame file. In fact, it should be declared as a final method. This helps to ensure that no other child class has the ability 
                        to overide it. Once declared, all children classes extending to such frames will ensure to execute the super method first before 
                        running. Example of usage is shown below: <br><br>

                        <div class="pre-area">
                            <pre class="pre-code">
  &lt;?php

    use Window;

    class SessionFrame extends Window {

        final static function super() {
            
            new Session('session_name', 'cookie_name');

        }

    }
                            </pre>
                        </div>

                        <div class="font-menu mvt-6">Now we can extend our Window entry files to the frame which will automatically call the super function.</div>
                        <br>
                        <div class="pre-area">
                            <pre class="pre-code">
  &lt;?php

    <span class="comment">...add namespace here...</span>

    class Child extends SessionFrame {

        function construct() {
            
            self::load('template-file', fn() => compile() );

        }

    }
                            </pre>
                        </div>

                        <div class="foot-note">
                            <span class="head">Footnote:</span>
                            A frame file can also be extended to another frame file. However, if this is done then, it may be 
                            safer NOT to declare the <code>super()</code> as a final method. In this case, the child class may need to call the <code>parent::super()</code> 
                            within its own <code>super()</code> method.
                        </div>
                        

                        <p>
                          
                        </p><br>
                        <span class="bi-minimize"></span>
                    </div>

                  </div>
                </div>
    
                @lay('build.co.links:tutor_pointer')
            </div>
        </section>

    </div>
      
    @lay('build.co.coords:footer')


@template;