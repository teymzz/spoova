
@template('template.t-tut')

  @lay('build.co.navbars:left-nav')

  <style>
    .directives code {
      color: #f7f7f7;
      background-color: #47b13e;
      border:none;
    }
  </style>

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

            <div class="font-em-1d5 c-orange">Rex Compiler Functions</div> <br> 

            <div class="compiler-intro">
              <div class="">
                <p>
                    The rex template engine uses two compiler functions which are <code>compile()</code> and <code>view()</code> 
                    mentioned earlier to render a file from the <code>windows/Rex</code> directory. When any of these methods is used, the 
                    full path of the rex file does not need tp be declared as the framework will naturally search for rex files only from the 
                    specified directory. The major difference between these two functions is that while the <code>compile()</code> function 
                    is used to compile and render file declared within the <code>Res::load()</code> method, the view method is used to compile 
                    and return a rendered file upon another file declared within the <code>Res::load()</code> method. Also, while the <code>compile()</code> 
                    function can only be used once within the <code>Res::load()</code>, the <code>view()</code> function can be applied multiple times.
                    In most cases, the <code>Res::load()</code> method is will be used more to load template files within any window system.
                </p>
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Samples of resource loading with compiler functions</div>
    <pre class="pre-code">
  Res::load('index', fn() => compile()); <span class="comment">//render a template file "index.rex.php"</span>
  
  Res::load('home', fn() => compile(['name' => 'Brooks'])); <span class="comment">//pass an argument to template file  "home.rex.php"</span>
  
  Res::load('foo', fn() => view('bar', ['name' => 'Brooks'])); <span class="comment">//render and dump a template file "bar.rex.php" on "index.rex.php"</span>
  
    </pre>
                </div>
                <div class="foot-note mvs-6">
                    It is important to note that in the above examples, all rex files are assumed to be from the <code>window/Rex</code> directory. Since it is 
                    much better to have one single rex file that controls how pages are displayed, hence, in most cases, the 
                    <code>view()</code> function does not need to be employed. It is much preferable to stick with the <code>compile()</code> function.
                </div> <br>
                <p>
                    The major advantage of the <code>view()</code> function is the ability to render different template files all at once before returning its content 
                    on the <code>Res::load()</code> declared file also known as the main template file.
                </p>               
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Differences between compile and view function</div>
    <pre class="pre-code">
  <span class="c-dodger-blue-dd">Res::load('index', function() {</span>

    return compile();
    
  <span class="c-dodger-blue-dd">});</span>
  

  <span class="c-dodger-blue-dd">Res::load('index', function() {</span>

    return view('index').view('home');

  <span class="c-dodger-blue-dd">});</span>
    </pre>
                </div>
                <div class="foot-note mvs-6">
                  <p>
                    In the example above, the <code>view()</code> method will process all template files within it and 
                    return its contents to the <code>index.rex.php</code> file which will inturn display its contents unlike the 
                    <code>compile()</code> function which cannot be used more than once. However, though the <code>view()</code> 
                    method may be used this way, it is highly discouraged to do so. Also, the <code>view()</code> method may be dropped in 
                    future update to favor only the compile method.
                  </p>

                  <p>
                    It is important to note that the resource loader method <code>Res::load()</code> will not compile its main rex file declared within it. 
                    unless the <code>compile()</code> function is declared within it. Instead, the content of any string returned by the callback function will 
                    be returned back on the page. This is shown below:
                  </p>
                </div> 
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Res loading without compile</div>
    <pre class="pre-code">
  Res::load('index', fn() => "me" });
    </pre>
                </div>
                <div class="foot-note mvs-6">
                  In the code above, The <code>index.rex.php</code> file will not be compiled, rather it will return the content of the callback function (i.e "me"), 
                  unlike when the compiler function <code>compile()</code> is used which literally tells the <code>Res::load()</code> method to compile the 
                  supplied rex file. This is why it is possible to dump the content of <code>view()</code> function on the intended main rex file because the <code>view()</code> 
                  function compiles its own file separately while returning the content of the file compiled. 
                </div>
              </div>
          </div> <br>
          
          <div class="">

            <div class="font-em-1d2 c-orange">Accessing compiler arguments</div> 

            <div class="">
              There are certain key situations when we need to pass variables down to template files. 
              Variables are passed down as array arguments into compiler functions which in turn converts them to accessible variables by the php template files. 
              The array arguments are usually specified by an array key which becomes the accessible variable that is used within the placeholder <code>@({{}})@</code> directive.
              The code below is an example of how to pass arguments to template files.
            </div> <br>

            <div class="pre-area">
              <div class="pxv-10 bc-silver">Sample window file</div>
              <pre class="pre-code">
  &lt;?php

  namespace teymzz\spoova\core\windows\Routes;

  use Window;

  class Home extends Window{ 

      function __construct() {

          self::load('home', fn() => compile(['name' => 'Foo']) );

      }

  }
  
  ?&gt;
              </pre>

            </div>

            <div class="pre-area">
              <div class="pxv-10 bc-silver">Sample rex file (home.rex.php)</div>
              <pre class="pre-code">
  @({{ $name }})@
              </pre>

            </div>

            <div class="foot-note pvs-10">
              The sample rex file above will display the corresponding value of "name", that was passed across to it. Other available template directives can be found 
              <a href="@domurl('docs/template/directives')" class="c-olive-d">here</a> 
            </div>

          </div>
          
          

        </div>
      </div>
    </section>
  </div>
@template;