@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

        <div class="box-full pxl-2 bc-white-dd pull-right">
        
            <section class="pxv-10 tutorial bc-white">
                <div class="font-em-1d2">

                    @lay('build.co.links:tutor_pointer')

                    <div class="start font-em-d8">

                        <div class="font-em-1d5 c-orange">Cli Animations</div> <br>  
                        
                        <div class="helper-classes">
                            <div class="fb-6">Introduction</div> <br>
                            <div class="">

                                <div class="">

                                    <p>
                                        Notifications are used to keep users aware of the current state of an executed command. They help users to have a clearer understanding 
                                        pf what is going on. For example, there could be notifications for when a code successfully executes or when an error is encountered. 
                                        The Cli class provides some useful methods for setting responses. These method have a predefined text prefixes assigned to messages. The 
                                        text prefixes also use similarly related color codes to quickly call console users to awareness. The following are notification related methods. 
                                    </p>

                                </div>

                                <div>
                                    <div>
                                        <div class="">
                                            <ul>
                                                <li><a href="#textYield" class="c-i">textYield</a></li>
                                                <li><a href="#animeType" class="c-i">animeTest</a></li>
                                                <li><a href="#play" class="c-i">play</a></li>
                                                <li><a href="#pause" class="c-i">pause</a></li>
                                                <li><a href="#animeType" class="c-i">animeType</a></li>
                                                <li><a href="#animate" class="c-i">animate</a></li>
                                                <li><a href="#loadTime" class="c-i">loadTime</a></li>
                                                <li><a href="#endAnime" class="c-i">endAnime</a></li>
                                                <li><a href="#runAnime" class="c-i">runAnime</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                
                            </div> 
                        </div> <br>

                        <div id="textYield" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">1.</span>
                                        </span> Cli::textYield()
                                    </div>
                                </div> <br>
                                <div class="">
                                    This method is used to yield a particular text. Yielding here means that text will first be printed while 
                                    a loading animation will run after.
                                    <br><br>
                                    
                                    <div class="pre-area">
                                        <div class="box-full">
                                            <div class="pxv-6 bc-off-white"><code>Syntax: textYield</code></div>
                                            <pre class="pre-code">
    Cli::textYield($text, $yield, $pause);
    <span>
      where:

        $text     : test to be displayed 
        $yield    : Integer number of times the animation must run
        $pause    : An optional delay that is added after the loading animation is completed.
    </span>
                                            </pre>
                                        </div>
                                    </div>

                                </div>
                            </div> <br>

                        </div> <br>


                        <div id="play" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">2.</span>
                                        </span> Cli::play()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is used to run animations
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: play</code></div>
                                    <pre class="pre-code">
    Cli::play($yield, $indent, $message, $break, $pause); 
    <span class="comment no-select">
      where: 
    
        $yield   : Number of times animation must run
        $indent  : Number of left space indents to be added before text is printed
        $message : Animation text to be printed
        $break   : Number of line breaks to be added after animation is done.
        $pause   : Delay in seconds to be added after animation is done.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="pause" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">3.</span>
                                        </span> Cli::pause() or Cli::wait()
                                    </div>
                                </div> <br>
                                <div class="">
                                These method are used to set delay before an operation is executed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: pause</code></div>
                                    <pre class="pre-code">
    Cli::pause($seconds); 
    <span class="comment no-select">
      where: $seconds is delay in seconds
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="animeTest" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">4.</span>
                                        </span> Cli::animeTest()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>animeTest()</code> method is used to test the response of animations
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: animeTest</code></div>
                                    <pre class="pre-code">
    yield from Cli::animeText(); <span class="comment no-select">//tries to run animation using a long (or heavy) loading strategy.</span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="animate" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">5.</span>
                                        </span> Cli::animate()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>animate()</code> method is used to view the different loading animations and their behaviour when used.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: animeTest</code></div>
                                    <pre class="pre-code">
    Cli::animate($yield, $delay); 
    <span class="comment no-select">
      where: 
    
        $yield   : Number of times animation must run.
        $delay   : Delay in seconds to be added after animation is done.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="endAnime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">6.</span>
                                        </span> Cli::endAnime()
                                    </div>
                                </div> <br>
                                <div class="">
                                The <code>endAnime()</code> method is designed to print a text after animation is completed.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: endAnime</code></div>
                                    <pre class="pre-code">
    Cli::endAnime($pause, $break1, string $message, $break2, $indent); 
    <span class="comment no-select">
      where: 
    
        $pause   : Delay in seconds to before text is printed.
        $break1  : Line breaks before text is printed. Default is zero (0).
        $message : Message to be printed
        $break2  : Line breaks after text is printed. Default is one (1).
        $indent  : Left margin on printed text. Default is two (2).
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="loadTime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                         <span class=" mxr-8 c-lime-dd">
                                           <span class="numb-box">7.</span>
                                        </span> Cli::loadTime()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is designed to increase or decrease the amount of time needed for an animation to successfully complete. It can be 
                                declared before the <code>Cli::runAnime()</code> method is called or at any point before a <code>yield</code> generator function is 
                                declared.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: loadTime</code></div>
                                    <pre class="pre-code">
    Cli::loadTime($time); 
    <span class="comment no-select">
      where: 
    
        $time  : Animation time in seconds
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                        <div id="runAnime" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                        <span class=" mxr-8 c-lime-dd">
                                            <span class="numb-box">8.</span>
                                        </span> Cli::runAnime()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method is specially designed to run animations based on whether a function or public method is iterable. It uses special 
                                syntaxes to determine whether an iterable item is function related or object related, making it possible to run animations from functions 
                                or methods. An iterable item means a generator function or method.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: runAnime</code></div>
                                    <pre class="pre-code">
    Cli::runAnime($function, $callback); 
    <span class="comment no-select">
      where: 
    
        $function  : A function name or an array of function (or object) and its arguments.
        $callback  : An optional final callback to be executed when animation is complete.
    </span>
                                    </pre>
                                </div>
                            </div>  <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: functions without arguments</code></div>
                                    <pre class="pre-code">
    function animate(){

        yield from 100;

    }

    Cli::runAnime('animate'); <span class="comment no-select"> //run animation 100 times.</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: function with arguments</code></div>
                                    <pre class="pre-code">
    function animate($text){

        yield from 100;

        print $text[0];

    }

    Cli::runAnime(['animate', ['completed']]); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Class without arguments</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public static function load() {

            yield 100;

        }

    }

    Cli::runAnime([Anime::class, 'load']); <span class="comment no-select"> //run animation 100 times.</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Class with arguments</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public static function load($args) {

            yield 100;

            print $args[0];

        }

    }

    Cli::runAnime([[Anime::class, 'load'], ['completed']]); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Running animation in classes</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public function load() {

            Cli::runAnime([[$this, 'generator'], ['completed']]);

        }

        public function generator($args) {

            yield 100;

            print $args[0];

        }

    }

    $Anime = new Anime; 
    $Anime->load(); <span class="comment no-select"> //run animation 100 times, then prints "completed".</span>
                                    </pre>
                                </div>
                            </div> <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: Stopping animations</code></div>
                                    <pre class="pre-code">
    class Anime($text){

        public function load() {

            Cli::runAnime([[$this, 'generator'], ['completed']]);

        }

        public function generator($args) {

            yield 100; 
            
            print $args[0];

            yield false; <span class="comment">//stop animation here.</span>
            
            print "something"; <span class="comment">//this will not run.</span>

        }

    }

    $Anime = new Anime; 
    $Anime->load();
                                    </pre>
                                </div>
                            </div> <br>
                            
                                </div>

                                <div class="foot-note">
                                    Animations can be stopped using the key words <code>yield false</code> or <code>yield true</code>. In the example above, the 
                                    last message "something" will not execute because the stop keyword <code>yield false</code> was used.
                                </div>
                            </div> 
                        </div> <br>

                        <div id="loadType" class="">
                            <div class="">
                                <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                    <div class="flex-full midv"> 
                                         <span class=" mxr-8 c-lime-dd">
                                           <span class="numb-box">9.</span>
                                        </span> Cli::loadType()
                                    </div>
                                </div> <br>
                                <div class="">
                                This method selects the type of animation to be used. In spoova Cli, there are currently 10 types of animations which includes 
                                <code>normal</code>, <code>roller</code>, <code>dotted</code>, <code>arrows</code>, <code>forward</code>, <code>timer</code>, 
                                <code>circle</code>, <code>angles</code>,<code>steps</code> and <code>braill</code>. Animation type can be declared or switched
                                at any point before or during an animation runtime.
                                <br><br>

                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: loadType</code></div>
                                    <pre class="pre-code">
    Cli::loadTime($type); 
    <span class="comment no-select">
      where: $type defines the loading type.
    </span>
                                    </pre>
                                </div>
                            </div>  
                            
                                </div>
                            </div> 
                        </div> <br>

                    @lay('build.co.links:tutor_pointer')

                    </div>
                </div>
            </section>
        </div>

    @lay('build.co.coords:footer')

@template;