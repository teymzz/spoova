
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
              <div class="">
                  The spoova project application applies a specific structure in handling php composer dependency manager. 
                  While most frameworks places the composer <code>vendor</code> folder in the root of their application, spoova 
                  suggests that the vendor folder which is a core aspect of the application, should be placed in the <code>core/</code> 
                  directory. This means that developers will have to navigate to the <code>core/</code> directory in order to run composer commands and also install composer packages. 
                  <br><br>
                  
                  However, since spoova is a very flexible framework, developers are allowed to move the <code>vendor</code> folder outside of the <code>core/</code> into the root of the 
                  application by following the process below:
                  
              </div> 
          </div>
          
          <div id="vendor" class=""> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-folder-fill mxr-8 c-lime-dd"></span> Vendor Folder </div>
              </div> <br>

              <div class="">
                <div class="">The composer vendor folder can be moved by applying the following processes</div>
                <br>

                <div class="">

                  <ul>
                    <li>Move the <code>vendor</code> folder out of the <code>core</code> directory.</li>
                    <li>Move the <code>composer.json</code> file out of the vendor folder</li>
                    <li>Edit the json file <code>autoload</code> key such that it becomes as shown below 

                      <div class="pre-area">
                        <pre class="pre-code">
    "autoload": {

        "psr-4": {
            "spoova\\": "./",
            "Spoova\\": "./"
        }

    },
                        </pre>
                      </div>
                    </li>
                    <li>
                      Run the <code>composer dump-autoload -o</code> command to update the application
                    </li>
                    <div class="">
                      Refresh your application to ensure that it runs perfectly fine
                    </div>
                    <div class="">
                      Once the application runs well, return <code>composer.json</code> back into the <code>vendor</code> folder.
                    </div>
                  </ul>

                </div>
              </div>
        
          </div>  <br>

          <div id="core"> 

              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> Core Folder </div>
              </div> <br>
              
              <div>
                  Developers should avoid tampering with the core files in the core folder. If new classes will be created, custom folders may be used for classes. 
                  If the <code>vendor</code> folder is shifted out of the <code>core\</code> directory, packages can be installed directly into the vendor folder using the 
                  <code>composer.json</code> file.  The root app namespaces follow the pattern of <code>{{ rtrim(scheme('',false),'\\') }}</code>, hence, custom classes 
                  defined in <code>core\</code> directory should use the predefined namespace. 
              </div> <br>
        
          </div>  
        </div>
      
      </div>
    </section>
  </div>

  @lay('build.co.coords:footer')

@template;