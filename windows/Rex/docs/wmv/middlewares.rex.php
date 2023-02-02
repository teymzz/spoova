@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d85">

                    <div class="font-em-1d5 c-orange">Middlewares</div> <br>  
        
                    <div class="shutters-intro">
                        
                        <div class="font-em-d87">
                           Middlewares are operations that must run before a class or method is called. 
                           They are mostly executed through class methods. Their activity can affect the performace of 
                           window files. While middlewares can be applied to shutters from the <code>super()</code> method of
                           <a href="@domurl('docs/wmv/frames')" class="hyperlink">Frame</a> files, it is mostly preferred 
                           to use them in other class method in which a shutter method is applied. Their flexible structure makes 
                           it possible for methods or windows to inherit them. While shutters have been discussed earlier, here, we 
                           will focus on how to apply middlewares to shutters. Middlewares can be applied through the <code>ONCALL()</code> method or 
                           by passing the <code>SELF::ONCALL</code> constant key into a specific shutter list of accepted urls. It can also be applied 
                           by setting a preload function on urls using the <code>self::preload()</code> method. When supplied, 
                           these functions will execute before the method or class is resolved.
                            <br><br>

                            <div class="font-em-d9">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">self::preload()</div> <br> 
                                <div class="">
                                    This method can be applied to specific urls the immediately a url is resolved but not before it is authenticated. 
                                    A url becomes must first be resolved before it is allowed to render. Between the resolving and rendering of a url, 
                                    middlewares are allowed to act as bridge to determine how a url responds.   
                                    (i.e visited). The <code>preload()</code> method takes a list of direct urls as its first argument and a boot function as its second argument.
                                    A syntax and an example is shown below: <br><br>
                                    
                          
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
        <div class="no-select bc-silver-d pxv-10">Syntax:  self::preload()</div>
        <pre class="pre-code">
  <span class="comment">#sample stucture 1: <span class="c-brown-ll">self::preload($acceptableUrls, $boot)</span></span>

  $acceptableUrls <span class="comment">//an array list of valid urls</span>
  
  $boot  <span class="comment">//a function that is called before a url are rendered</span>
 </pre>
                                        </div>
                                    </div> <br> <br>  
                          
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
        <div class="no-select bc-silver-d pxv-10">Example:  self::preload()</div>
 <pre class="pre-code">

    use Window;

    class Home extends Window {

        function __construct() {

            self::preload( 
                [ 
                    'docs/user/settings',
                    'docs/user/profiles',
                ], 
        
                function() {
                    
                    echo "method applied";
        
                }
            );

        }

    }
 </pre>
                                        </div>
                                    </div> <br>

                                    <div class="font-menu mvt-10">
                                    Using the example above as reference, if the url <code>docs/user/settings</code> or 
                                    <code>docs/user/profiles</code> is visited, the text <code>"method applied"</code> 
                                    will be printed on the page before the content of the page itself is rendered. 
                                    </div> <br>
                            
                                </div>
                            </div>

                            <!-- oncall() -->
                            <div class="font-em-d87">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">SELF::ONCALL()</div> <br> 
                                <div class="">
                                    This method is a preload method that can be applied on any of the four shutter methods. The first argument declares the type of middleware 
                                    to be applied. These options are: <br><br>
                                    
                                    <ul>
                                        <li> <code>CASTED::CALL</code>(or <code>CASTED::CAST</code>) </li>
                                        <li> <code>CASTED::ROOT</code> </li>
                                        <li> <code>CASTED::BASE</code> </li>
                                        <li> <code>CASTED::PATH</code> </li>
                                        <li> <code>CASTED::E404</code> </li>
                                    </ul>
                                   
                                   Each of these options defines the shutter environment in which a boot function can execute its operations. 
                                   As their name implies, they only execute their operation when a relative shutter method comes into play. In a situation where 
                                   multiple shutters are pended for another, we may need to define our boot function for specfic shutters. Hence, when any of the defined shutter is 
                                   called then the function will execute.
                                </div>
                            </div> <br>

                          
                            <div class="pre-area shadow">
                                    <div class="">
                                        <div class="no-select bc-silver-d pxv-10">SELF::ONCALL()</div>
        <pre class="pre-code">
  <span class="comment">#sample stucture 1: <span class="c-brown-ll">self::ONCALL(option, urls)</span></span>

  option <span class="comment">//casted options</span>
  
  urls  <span class="comment">acceptable urls and their respective boot options</span>
        </pre>
                                    </div>
                            </div> <br> <br>

                            
                            <p class="font-em-d87">The code structure below is an example of its usage: </p>

                          
                            <div class="pre-area shadow">
                                    <div class="">
                                        <div class="no-select bc-silver-d pxv-10">SELF::ONCALL()</div>
        <pre class="pre-code" style="color: rgb(var(--sea-blue-dd));">
      class {

        function __construct() {

            SELF::ONCALL(CASTED::CALL, [
                
                'home/user/settings' => function(){
                                            <span class="comment">// run this for settings</span>
                                        },
                
                'home/user/profiles' => function(){
                                            <span class="comment">// run this for profiles</span>
                                        },
                ]);

            SELF::ONCALL(CASTED::BASE, [
                
                'home/user' => function(){
                                            <span class="comment">// run this for user</span>
                                        },
                
                'home/room' => function(){
                                            <span class="comment">// run this for room</span>
                                        },
                ]);

            SELF::CALL([
                
                'home/user/settings' => 'root',
                'home/user/profiles' => 'profiles',

                ], false);

            SELF::BASECALL([
                
                'home/user' => 'user',
                'home/room' => 'room',

                ]);

        }

      }
       </pre>
                                    </div>
                            </div> <br> <br>

                            <div class="font-em-d87">
                                The code structure above is a 
                                complex relationships between shutters and predefined 
                                or preloaded function. This relationship is explained below: <br><br>

                                <ul>
                                    <li>
                                        The <code>SELF::ONCALL(CASTED::CALL)</code> method is used to set a preset (or preload) function on the list of urls it contains which 
                                        is only applied within the <code>SELF::CALL()</code> method.
                                    </li>
                                    <li>
                                        The <code>SELF::ONCALL(CASTED::BASE)</code> method is used to set a preset (or preload) function on the list of urls it contains which 
                                        is only applied within the <code>SELF::BASECALL()</code> method.
                                    </li>
                                    <li>
                                        If the <code>SELF::CALL()</code> can resolve any of its urls, then the function for <code>SELF::ONCALL(CASTED::CALL)</code> will be called before 
                                        the url is rendered. However, if it cannot resolve its urls, then because it was pended, it will continue to <code>SELF::BASECALL()</code>.
                                    </li>
                                    <li>
                                        If <code>SELF::BASECALL()</code> can resolve any of its urls, the <code>SELF::ONCALL(CASTED::BASE)</code> function will be called for the relative url. If basecall 
                                        cannot resolve its url also, then a 404 error page is returned.
                                    </li>                                
                                </ul>
                                
                                <div class="">
                                    <p>
                                        According to the explanation made above, this means that <code>CASTED::BASE</code>, <code>CASTED::CALL</code>, <code>CASTED::PATH</code> and <code>CASTED::ROOT</code> will 
                                        respond similarly only to their respective or relative shutter methods. However, the <code>CASTED::E404</code> defines that a middleware should only be applied when a 404 error page occurs.
                                    </p>

                                    <p>

                                    </p>
                                </div>

                               
                                <div class="c-teal">
                                    While the approach above may be useful, it can be a tedious process and setting up boot functions this way can cause a lot of confusion even if it is handled separately. 
                                    We can however shorten this function, making it more comprehensible by passing <code>SELF::ONCALL</code> key on the shutter itself. 
                                </div>
                            </div> <br>

                            <div class="font-em-d87">
                                <div class="c-orange font-em-1d1 bc-white-dd pxv-10">SELF::ONCALL - RECOMMENDED</div> <br> 
                                <div class="">
                                    This <code>SELF::ONCALL</code> key is a preload method can be applied within any list of urls for any of the four shutter methods. We don't have to apply any option since we are within the shutter itself.<br><br>
                                    <div class="pre-area shadow">
                                        <div class="font-em-1d2">
                                            <div class="no-select bc-silver-d pxv-10">Sample:  SELF::ONCALL</div>
  <pre class="pre-code">
  SELF::CALL([
    
    'home/user/profiles' => 'profiles',
    'home/user/settings' => 'settings',

     SELF::ONCALL => function() {

            <span class="comment">//run this if any of the url was resolved.</span>

            if( invoked('home/user/profiles') ) {
                <span class="comment">//do this</span>
            }

            if( invoked('home/user/settings') ) {
                <span class="comment">//do this</span>
            }

        }

    ])
  </pre>
                                        </div>
                                    </div> <br> <br>  
                                </div>
                            </div> <br>

                            <div class="font-em-d87">
                                The code structure above is more concise and 
                                understandable than when we applied the <code>SELF::ONCALL()</code> method. The only difference is that here, 
                                our function is more localized and will not extend to a subsequent call method. For example, if the <code>SELF::CALL()</code> 
                                method above was pended, then another <code>SELF::CALL()</code> or any shutter method below it will not inherit the <code>SELF::ONCALL</code> constant. 
                            </div>


                        </div>

                    </div> <br>
                </div>
            </div>
    
            @lay('build.co.links:tutor_pointer')
      
            @lay('build.co.coords:footer')
        </section>
    </div>

@template;