
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-20 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Composer / Plugins</div> <br>  
          
          <div class="resource-intro">
              <div class="fb-6">Introduction</div>
              <div class="">
                  Installation of plugins using composer should be within the <code>core/vendor</code>
                  folder. Spoova does not place its vendor folder in the application root. Therefore, to install 
                  using composer, developers should navigate to the <code>core</code> folder which is the root 
                  folder for the <code>vendor</code> folder.  
                  <br><br>
                  
                  For the purpose of file structuring, it is believed that vendor folder should be part of the core 
                  framework. All core applications and classes are stored within the core folder which is the reason 
                  for placing vendor folder into core folder.
                  
              </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Core Folder </div>
                <div class="flex mid">
                  <span class="bi-chevron-double-right"></span>
                </div>
              </div> <br>
              
              <div>
                  Aside from installing into plugins into the core folder, developers should avoid tampering with the core folder . 
                  If new classes will be created, spoova supports creating special folders for classes. These folders could be 
                  located within the core folder itself away from the default folders or at the root of the application. The root 
                  folder itself is named <code>spoova</code> . Therefore, the namespaces follow the pattern of <code>spoova\</code> where 
                  <code>spoova</code> is the root name of the application. 
              </div> <br>
        
          </div>  
        </div>
      
      </div>
    </section>
  </div>

  @lay('build.co.coords:footer')

@template;