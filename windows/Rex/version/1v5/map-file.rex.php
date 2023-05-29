@template('template.t-tut')

    @title('Spoova 1.5')
    
    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white pull-right">
       <section class="pxs-10 tutorial bc-white">
           <div class="font-em-1d2">

               @lay('build.co.links:tutor_pointer')

               <div class="start">

                    <div class="pvs-20">
                        <div class=" c-orange font-em-2 fb-6 c-dodger-blue-d"> <div class="px-80 bd-2 in-flex mid font-em-d8"> 1.5+ </div>  Map File</div>
                    </div>

                    <div class="bc-white-dd rad-4 flow-hide">
                        <div class="bc-dodger-blue-dd c-white-d pxv-10 font-em-d8">
    
                            <div class="bi"> <span class="bi-circle"></span> Map file (standard logic) </div>  
    
                        </div>
                        <div class="pxv-20 pvb-1  font-em-d8">

                            <p>
                                The version 1.5.0 just added its new map file for route files protection. A Map file stand as directory pointer for route files which allows 
                                an extended functionality of shifting route files directory into a different subdirectory of its parent window directory under a standard logic  
                                route system. This file which is placed directly within the "windows" directory is only identified with its <code>.map</code> extension name. 
                                However, the code structure of a map file is of a json syntax. It uses a predefined 
                                key and value to determine how to resolve standard routes. Some of the use case for map files under standard logic are explained below.

                            </p>
                            
                        </div>
                    </div> <br>

                    <div class="font-em-d8">

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
                                    By default under a standard window logic, the url entry point "home" or "Home" means the same thing as they forward the url to a route file 
                                    "windows/Routes/Home" file to call. This is because the lowercase or sentence case is accepted. However, when an entry point file name 
                                    which does not follow this pattern is called (e.g "HOme", "hoMe") is called, a 404 response is returned. We can however lessen this 
                                    strictness using a map file. In the code above, the <code>":root"</code>  defines a set of entry names and the relative route files they call. Using an inverse 
                                    operator on the entry point name, if known, will ensure that such route allows the entry point to have any form of text cases (e.g uppercase, camelcase, etc.). 
                                </div>
                            </div> <br>
                        </div>

                    </div>



                </div>
           </div>
       </section>
   </div>

@template;