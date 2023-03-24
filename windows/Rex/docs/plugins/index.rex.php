
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">Composer / Plugins</div> <br>  
          
          <div class="resource-intro">
              <div class="">
                  The spoova project packages are stored in the root <code>vendor/</code> folder. 
                  Although the composer <code>vendor</code> folder is placed at the root of the project application, spoova 
                  suggests that the vendor folder which is a core aspect of the application, should be placed in the <code>core/</code> directory.
                  Since spoova is a very flexible framework, developers are allowed to move the <code>vendor</code> folder into the <code>core/</code>
                  if needed. However, note that the <code>core/</code> directory is a strictly protected directory which means that no file will 
                  become accessible if placed within this directory including static files. If static files will be imported to the vendor folder which 
                  are required to be accessible, then it is better to leave the vendor folder out of this directory. The vendor folder can be moved to 
                  core directory by following the processes below:
              </div> 
          </div>
          
          <div id="vendor" class=""> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-folder-fill mxr-8 c-lime-dd"></span> Vendor Folder </div>
              </div> <br>

              <div class="">
                <div class="">The composer vendor folder can be moved to <code>core/</code> directory by applying the following processes</div>
                <br>

                <div class="">

                  <ul>
                    <li>Move the <code>vendor</code> folder into the <code>core</code> directory.</li>

                    <li>Edit the json file <code>autoload</code> key such that it moves out of the <code>core/</code> directory as shown below 

                      <div class="pre-area">
                        <pre class="pre-code">
    "autoload": {

        "psr-4": {
          "spoova\\mi\\": "../",
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
                    <li>Once the application runs fine, move the <code>composer.json</code> file into the <code>icore/</code> directory for security purposes.</li>
                    <li>Lastly, it is important to note that if the vendor folder is transferred to the <code>core/</code> directory, then composer commands must also be executed within that directory.</li>
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
                  The root namespace follow the pattern of <code>{{ rtrim(scheme('',false),'\\') }}</code>.  This means that custom classes should also apply this namespacing rule. 
              </div> <br>
        
          </div>  
        </div>
      
      </div>
    </section>
  </div>

  @lay('build.co.coords:footer')

@template;