
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange">About WMV</div> <br>  
          
          <div class="resource-intro">
              <div class="">
                  The <span class="fb-6 calibri">WinViM</span> architecture (ie. WMV or WVM)</span>, though is a system built upon MVC architecture, it is a bit more advanced and technical.
                  It was designed to be a flexible and extensible architecture that makes it possible to authenticate and validate urls based on specifically designed logics. The pattern flow 
                  relates that every urls becomes handled as window urls or classes through entry points to every url structure. In this tutorial, non-existing urls that are transferred to be handled with their entry points (windows) 
                  will be referred to as window urls. The example below shows the entry points in any given url for either production or live environments.
                  <br><br>

                  <div class="pre-area shadow">
                    <div class="pxv-10 bc-silver">Window url entry point</div>
                    <pre class="pre-code pxs-6">
  <table style="min-width:40%; font-size: .9em;">
    <tr><th class="pxv-4 c-orange-dd">window url sample</th> <th class="c-orange-dd">entry point (or window)</th> </tr>
    <tr><td><code class="bd-f">http://localhost/app/</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code class="bd-f">http://localhost/app/index</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code class="bd-f">http://localhost/app/users</code></td> <td><span class="comment no-select"> users </span></td></tr>
    <tr><td><code class="bd-f">http://localhost/app/users/somepath</code></td> <td><span class="comment no-select"> users </span></td></tr>
    <tr><td><code class="bd-f">http://www.site.com/</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code class="bd-f">http://www.site.com/index</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code class="bd-f">http://www.site.com/users/somepath</code></td> <td><span class="comment no-select"> users </span></td></tr>
  </table>
                    </pre>
                  </div>


                  <div class="pre-area" hidden>
  <div class="pxv-10 bc-off-white">Window url sample</div>
    <pre class="pre-code pxs-6">
    <span class="comment no-select">
    The examples below best reveal the position 
    of the window entry point for local and online environments
    </span>
    http://localhost/app/window/some/other/path <span class="comment">local environment</span>

    http://site.com/window/some/other/path

    </pre>
                  </div> <br>

                  <p class="font-menu mvt-10">
                    According to the url samples above, a url's entry point is usually the immediate path name that comes after a localhost url 
                    or a domain url.
                  </p>
     
                </div> 
          </div>
          
          

          <div class="why_wmv"> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-question-circle mxr-8 c-lime-dd"></span> Why WMV </div>
                <div class="flex mid">
                  <span class="bi-chevron-double-right"></span>
                </div>
              </div> <br>
              
              <div>
                The WMV pattern is best preferred for the following reasons
                <br><br>
                <ul>
                    <li>WMV provides easy control and handling of url</li>
                    <li>Security of web applications is the main goal</li>
                    <li>Easier handling of a more robust application with lesser files</li>
                    <li>File organization makes it easier to locate files</li>
                    <li>Setting up specific error pages to specific routes is made possible</li>
                    <li>The communication between offline and online development is balanced.</li>
                    <li>Data localization is enabled across web pages</li>
                    <li>Non-existing urls are handled by default</li>
                    <li>Interaction between existing and non-existing urls is made easier</li>
                    <li>Integration of extensible architecture is made possible</li>
                </ul>
              </div>          
          </div>  

          <div class="wmv_demerits"> 
              <br>
              <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-exclamation-triangle mxr-8 c-orange-dd"></span> WMV Demerits </div>
                <div class="flex mid">
                  <span class="bi-chevron-double-right"></span>
                </div>
              </div> <br>
              
              <div>
                  The downside of WMV pattern are
                  <br><br>
                  <ul>
                      <li>It depends on <code>.htaccess</code> file to work.</li>
                      <li>Controlling urls might prove a bit technical and advanced depending on developers understanding of the concept</li>
                      <li>A great discretion is advised when opening urls as urls not properly managed can result in blank pages.</li>
                      <li>If windows are not properly closed, it can cause faulty pages.</li>
                  </ul>
              </div>   
        
              @lay('build.co.links:tutor_pointer')
          </div>

        </div>
      </div>
    </section>

  </div>
    
      
    @lay('build.co.coords:footer')


@template;