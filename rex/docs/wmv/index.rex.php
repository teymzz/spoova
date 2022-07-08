@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">WMV FRAME</div> <br>  
        
        <div class="resource-intro">
            <div class="">
                The WMV pattern is an achitecture built upon the ideology of MVC pattern.
                Unlike the MVC, it follows a series of predefined structures that makes up the WMV itself. 

                The WMV depends on a Window - Frame Structure where the <code>Model</code> is created before a 
                <code>View</code> is rendered. In order to work with wmv framework, 
                A windows file must be created. In real application, many windows can exist within a Frame.
                We shall be examining how to create a windows - frame structure below.
            </div> 
         </div>
         
        <div class="windows-folder"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Folder </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>

            <div class="">
                The first thing to take note of when creating a windows project file is the windows folder.
                The windows folder is expected to have an entry point <code>Index</code> which extends to the 
                root <code>Window</code> class. By default, when running our application, whenever a page is loaded,
                when a page does not exist, the url is transferred to the windows management structure. This will try to resolve the url 
                by performing 3 operations:
                    <br><br>
                    <ul>
                        <li>Looks for a class relative to the url within the windows root folder</li>
                        <li>
                            If step 1 is not resolved, it transfers the url to the Index window class within the windows folder root.
                        </li>
                        <li>The Index file transfers the url to its <code>door</code> method which finally defines how the url should be handled.</li>
                    </ul>
            </div>
            
      
        </div>  

        <div class="windows-files"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Files </div>
            </div> <br>

            
            <div>
                In the creation of windows project, all window files (classes) must have the following features :
                <br><br>
                <ul>
                    <li>A window file must exist within the windows folder</li>
                    <li>A windows file (class) must be extended to the root <code>Window</code> class</li>
                    <li>A windows file (class) must have a public <code>__construct</code> function (entry point).</li>
                    <li>A windows file (class) must have a closing structure</li>
                </ul>
            </div> <br>
      
        </div>  

        <div class="windows-frames"> 
            
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Windows Frames </div>
            </div> <br>

            
            <div>
                Frames are used to bind window files together. The provide similar data shared across window files. 
                Although, a Frames is an extension of Window class itself, they act as bridges or gaps between the root Window class 
                and a Window child class. When a class is extended to a frame class, it inherits both the properties of the root window class
                along with the specific frame class. The purpose of frame is to separate windows files that have different data from each other.
                All windows file sharing the same Frame will have data belonging to their specific frames. 
                <br><br>
                In order to identify frame files, they should have the following features:
                <br><br>
                
                <ul>
                    <li>Should be placed in a "Frame" folder, a direct subdirectory of windows folder</li>
                    
                    <li>A frame file (class) should extend to the root Windows class</li>
                    <li>A frame file (class) should never be used to close a window</li>
                    <li>A frame file (class) should contain only data essential for its child class</li>
                    
                    <li>A frame file (class) should not be used to render template engines.</li>
                    <li>A frame file (class) may be attached to a channel, thereby including data specific only to that channel.</li>    
                </ul>
                
            </div>
      
        </div>  

        <div class="about_wmv"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-card-list mxr-8 c-lime-dd"></span> Note </div>
            </div> <br>

            
            <div>
                There are several key points to note when working with the wvm network. To futher explain the wmv 
                pattern, we have categorized important keynotes to the underlying subjects:
                <br><br>
                <ul>
                    <li> <a href="@route('.wmv')">About <span class="fb-6 pointer" title="Windows Models View">WMV</span> and <span class="fb-6 pointer" title="Model View Controller">MVC</span>?</a></li>
                    <li> <a href="@route('.open')">Opening and Closing windows</a> </li>
                    <li> <a href="@route('.calls')">Windows Calls</a> </li>
                    <li> <a href="@route('.frames')">Window Frames</a> </li>
                    <li> <a href="@route('.routes')">Window Routes</a> </li>
                </ul>
            </div>      
      
        </div>  

        @lay('build.links:tutor_pointer')

      </div>
    
      
    @lay('build.coords:footer')

    
@template;