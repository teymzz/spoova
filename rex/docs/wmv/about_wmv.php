@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">About WMV</div> <br>  
        
        <div class="resource-intro">
            <div class="">
                The <span class="fb-6 calibri">WinViM</span> architecture (ie. WMV or WVM)</span>, though is a system built upon MVC architecture, it is a bit more advanced and technical.
                It was designed to be an extensible structure while taking into consideration, the future updates or upgrades 
                that may later be integrated into the system. <br><br>

                <p>
                  This pattern flow relates that every existing file is naturally loaded while non-existing urls becomes handled as window files or classes. 
 
                  The pattern flow is listed below
                  <ul>
                    <li>All existing files are loaded</li>
                    <li>All non existing urls are transferred to be loaded as window files which serves as entry points to urls</li>
                    <li>All non-existing windows are tranferred to a an entry point (Index) which uses its method <code>usedoor()</code> to handle non existing urls.</li>
                    <li>Frames are binders used to group window files sharing similar data</li>
                  </ul>
                </p>

                Windows are entry points to every url structure. In this tutorial, non-existing urls that are transferred to be handled with their entry points (windows) 
                will be referred to as windowed urls. The example below shows the entry point in a url for both localhost and online environments.
                <br><br>

                <div class="pre-area">
<div class="pxv-10 bc-off-white">Url Window</div> <br>
<pre class="pre-code pxs-6">
  <table style="min-width:40%"">
    <tr><th class="pxv-4">Windowed url</th> <th>window</th> </tr>
    <tr><td><code>http://localhost/app/</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code>http://localhost/app/index</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code>http://localhost/app/users</code></td> <td><span class="comment no-select"> users </span></td></tr>
    <tr><td><code>http://localhost/app/users/somepath</code></td> <td><span class="comment no-select"> users </span></td></tr>
    <tr><td><code>http://www.site.com/</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code>http://www.site.com/index</code></td> <td><span class="comment no-select"> index </span></td></tr>
    <tr><td><code>http://www.site.com/users/somepath</code></td> <td><span class="comment no-select"> users </span></td></tr>
  </table>
</pre>
                </div> <br><br>


                In spoova frame, the window is usually the base entry point for any url. When this file exists, they are loaded 
                naturally by the web app. However, when they do not exist, they are converted to windows url and then loaded from the 
                windows folder.

                <p class="fb-6">
                  <div class="fb-6 c-red">
                    <span class="bi-exclamation-triangle"></span>  It should be noted that in localhost environment, the window entry point is alway the first path after the project folder name while for online environments, the window 
                    entry point is the first path after the domain name.
                  </div>
                  <div class="">
                    
                  </div>
                </p>

                <div class="pre-area">
<div class="pxv-10 bc-off-white">As a window url (i.e non-existing url)</div>
  <pre class="pre-code pxs-6">
  <span class="comment no-select">
  The examples below best reveal the position 
  of the window entry point for local and online environments
  </span>
  http://localhost/app/window/some/other/path

  http://site.com/window/some/other/path

  </pre>
                </div> <br><br>

                <p>
                  The window system handles all non-existing by looking for urls the class having its window entry point name 
                 from the windows folder. If the window's class does not exist, the full url is are transferred to the Index window file within the 
                 window folder root which takes over as the entry point of the non-existing window urls. The Window's Index class then uses its method 
                 <code>usedoor()</code> to handle the supplied url.
                </p>

                <p>
                  From this point, we understand that a non-existing index file for a url (e.g http://localhost/app/) will also be handled by the Index (window) class. 
                  However, when a non-existing index (index.php) file is called, It converts the url into a window file (i.e Index class) which is handled by the Index 
                  <code>__construct()</code> function rather than using the <code>usedoor()</code> method which is applied for all other windows. A figure is displayed below to explain 
                  this behaviour.
                </p>


                <div class="pre-area">
<div class="pxv-10 bc-off-white">As a window url (i.e non-existing url)</div> <br>
<pre class="pre-code pxs-6">
  <table style="min-width:45%"">
    <tr><th class="pxv-4">Window url</th> <th>Method used</th></tr>
    <tr><td><code>http://localhost/app/</code></td> <td><span class="comment no-select"> Index::__construct() </span></td></tr>
    <tr><td><code>http://localhost/app/index</code></td> <td><span class="comment no-select"> Index::__construct() </span></td></tr>
    <tr><td><code>http://localhost/app/users/somepath</code></td> <td><span class="comment no-select"> Index::usedoor() </span></td></tr>
    <tr><td><code>http://www.site.com/</code></td> <td><span class="comment no-select"> index::__contruct() </span></td></tr>
    <tr><td><code>http://www.site.com/users/somepath</code></td> <td><span class="comment no-select"> Index::usedoor() </span></td></tr>
  </table>
</pre>
                </div> <br><br>

                The example above reveals that when a non existing file (not index) is called, and the corresponding window class does not exist, 
                then the Index window file method<code>::usedoor()</code> is triggered 
                However, as a base entry point when a non-existing index file is called, the Index window <code>__construct()</code> method is called. 
                If the Index window file does not exist, then a 404 error page is returned instead. The figure below explains the pattern flow
            

                <div class="pre-area">
<div class="pxv-10 bc-off-white">As a non-existing window url</div> <br>
<pre class="pre-code pxs-6">
  <table style="min-width:45%"">
    <tr><th class="pxv-4">Window url</th> <th>Missing Window Class</th> <th>Method used</th></tr>
    <tr><td><code>http://localhost/app/users/somepath</code></td> <td>Users (only)</td> <td><span class="comment no-select"> Index::usedoor() </span></td></tr>
    <tr><td><code>http://localhost/app/profile/somepath</code></td> <td>Profile (only)</td> <td><span class="comment no-select"> Index::usedoor() </span></td></tr>
    <tr><td><code>http://site.com/home/somepath</code></td> <td>Home (only)</td> <td><span class="comment no-select"> Index::usedoor() </span></td></tr>
    <tr><td><code>http://localhost/app/users/somepath</code></td> <td>Users and Index</td> <td><span class="comment no-select"> 404 error page </span></td></tr>
    <tr><td><code>http://localhost/app/</code></td> <td>Index</td> <td><span class="comment no-select"> 404 error page </span></td></tr>
  </table>
</pre>
                </div> <br><br>            
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
                    <li>It depends on an apache server to work</li>
                    <li>It depends on <code>.htaccess</code> file to work.</li>
                    <li>Controlling urls might prove a bit technical and advanced depending on developers understanding of wmv concept</li>
                    <li>A great discretion is advised when opening urls as urls are properly managed can result in blank pages.</li>
                    <li>If windows are not properly closed, it can cause faulty pages.</li>
                </ul>
            </div>   
      
            @lay('build.links:tutor_pointer')
        </div>

      </div>
    
      
    @lay('build.coords:footer')


@template;