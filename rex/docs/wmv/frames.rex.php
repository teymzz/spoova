@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Frames</div> <br>  
        
        <div class="frames-description">
            <div class="">
                <p>
                    In WinViM system, Frame is an extension of the Window class which means that frames are also windows. 
                    The main importance of frames is that act as bridges between a window and another window, more like a root window and its subwindows. 
                    They can be referred to as data house as they provide a medium for which data can be localized and channeled across different window files. 
                </p>

                <p>
                    The handling of sessions is one key feature why the use of Frames may be advised. 
                    Although spoova naturally supports multiple sessions through the use of channels, frames help to separate sessions from each other while providing 
                    an organized structure and pattern to which each session disseminates its information  
                </p>

                <p>
                  When creating Frame files or classes, it is important to separate them from other window files and they should be in
                  any subdirectory of the window folder. This makes it easier to locate them. 
                  Also, as a naming convention, Frames should be appended the name "Frame". For example a frame file with name of <code>IndexFrame</code> 
                  sends a meaning that such frame belongs to the Index files or files that may exists outside a session while one with a name of 
                  <code>UserFrame</code> reveals that it contains data for a user account. 
                </p>

                <p>
                   
                </p><br>
                <span class="bi-minimize"></span>
            </div>

      </div>
    
      @lay('build.links:tutor_pointer')
      
    @lay('build.coords:footer')


@template;