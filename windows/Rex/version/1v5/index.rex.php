@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <span class="bi-recycle"></span> Spoova 1.5!</div>
                    
                        <div class="font-em-d8">
                            New features have been added to version 1.5.0 to improve security and fixing of bugs
                        </div> <br>

                        <div class="">
                            <div class=" fb-9 font-em-1d2 calibri">What's new?</div>
                        </div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Ajax requests </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Special characters are now allowed in ajax urls. Prior to this version, when a request 
                                data is sent to ajax urls having special characters, while the url may be accessed, there 
                                could be a data loss due to a bug preventing post data from forwarding the request data. This bug only affected urls 
                                that have special characters like underscore (_) and hyphen (-). In version 1.5.0, this has been fixed. 
                                Special characters are now allowed in ajax urls.  
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Map files </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                Map files are used to protect route entry file names under a standard logic to ensure that entry files are not exposed to the public. 
                                In version 1.5.0, the map file have been modified to allow two new features to further strengthen the security of these files.
                                <br><br>
                                <div class="list-free pxs-1">
                                    <div class="mox bc-silver pxv-4 rad-5">
                                        
                                        <div class="pxv-10">
                                           <span class="bi-lock"></span> File protection #1<br>
                                        </div>
                                    
                                        <div class="pre-area">
                                            <div class="pxv-10 bc-silver-d">windows/Routes/.map</div>
                                            <pre class="pre-code">
    {
        "*": "Mi\\"
    }
                                            </pre>
                                        </div>

                                        <div class="foot-note pxv-10">
                                            The addition of map files is to protect standard logic entry point names by selecting a custom subdirectory where route files are saved just by a single declaration. 
                                            In the sample above, the <code>".map"</code> file will direct the standard logic to look for route files 
                                            within the <code>windows/Routes/Mi</code> directory. For example, rather than for a url <code>http://localhost/home</code> to call the main route <code>"Home"</code>, 
                                            from <code>windows/Routes</code> directory, it will be called from <code>windows/Routes/Mi</code> directory. This makes it easier to protect standard logic entry files path.
                                            We can also fake file names if the double slash is not added to the value, that is "Mi" instead of "Mi\\".
                                        </div>
                                    </div> <br>
                                </div>
                                <div class="list-free pxs-1">
                                    <div class="mox bc-silver pxv-4 rad-5">
                                        
                                        <div class="pxv-10">
                                           <span class="bi-arrow-clockwise"></span> Entry inverse #2<br>
                                        </div>
                                    
                                        <div class="pre-area">
                                            <div class="pxv-10 bc-silver-d">windows/Routes/.map</div>
                                            <pre class="pre-code">
    {
        ":root": {

            "!home" => 'Home'

        }
    }
                                            </pre>
                                        </div>

                                        <div class="foot-note pxv-10">
                                            By default under standard logic, the url entry point "home" or "Home" means the same thing as they forward the url to a route file 
                                            "windows/Routes/Home" file to call. This is because the lowercase or sentence case is accepted. However, when an entry point file name 
                                            which does not follow this pattern is called (e.g "HOme", "hoMe") is called, a 404 response is returned. We can however lessen this 
                                            strictness using a map file. In the code above, the ":root" defines a set of entry names and the route files they call. Using an inverse 
                                            operator on the entry point name, if known, will ensure that such route allows the entry point to have any form of text cases (e.g uppercase, camelcase, etc.). 
                                        </div>
                                    </div> <br>
                                </div>
                            </div>
                            
                        </div>
                    </div><br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Live server </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                When writing codes on live development state with the use of live server, the error notifications 
                                are sometimes glitchy. This effect was due to an entrace animation effect which has now been removed. 
                                The live server glitchy error notification bug has been fixed which now make the error notices look more stable for developers.
                            </div>
                            
                        </div> <br>
                    </div> <br>
                    
                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-grid"></span> Template on the go </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                Template on the go was a feature added to make it easier to create template files easily with 
                                integrated live server. When such rex templates are generated, they come with the basic <code>@(live)@</code> 
                                directive which keeps them on a live state mode. Some bugs were removed when the template is generated. 
                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-red-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Deprecated! </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <div>
                                Prior to the intial release, some resource methods such as <code>Res::get()</code>, <code>Res::gett()</code>, 
                                <code>Res::post()</code> and <code>Res::postt()</code> were used as test cases to render routes before the wvm 
                                logics were introduced. With the <code>wvm</code> 
                                logics, we find no use for this methods any more because routes are now being handled by a server file and the 
                                entire route is being managed by a shutter system. It is advised to desist from the use of this methods as they 
                                may be removed at any point in time.
                            </div>
                            
                        </div> <br>
                    </div> <br>


                </div>
           </div>
       </section>
   </div>

@template;