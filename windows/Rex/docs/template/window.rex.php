
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
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

            @lay('build.co.links:tutor_pointer') <br>

            <div class="templating-intro"> <br>
              <div class="font-em-1d5 c-orange">Rex On Windows</div> <br>  
              <div class="">
                <p>
                   The window classes have a great relationship with the resource class. This makes it easier to use the <code>Res::load()</code> 
                   method easily by simply calling the <code>self::load()</code> method. Although, there are other methods which are <code>Res::post()</code> 
                   and <code>Res::get()</code> methods, due to the way that spoova is built, the <code>Res::load()</code> method is preferred to be used 
                   to load and render template contents.
                </p>
                <div class="pre-area">
    <div class="pxv-10 bc-silver">Template loading on window routes using compile function</div>
    <pre class="pre-code">
    &lt;php? 

    use window;

    namespace spoova/mi/windows/Routes;

    class Home {

        function __construct(){

          self::load('home', fn() => compile());

        }

    }
    </pre>
                </div> <br><br>

                <div class="pre-area">
    <div class="pxv-10 bc-silver">Template loading on window routes using view function</div>
    <pre class="pre-code">
    &lt;php? 

    use window;

    namespace spoova/mi/windows/Routes;

    class Home {

        function __construct(){

          $view1 = view('index');
          $view2 = view('home');

          self::load('home', fn() => $view );

        }

    }
    </pre>
                </div>
                
                <div class="foot-note">
                    In the example above, the <code>view()</code> function will process all template files within it and 
                    return its contents to the <code>index.rex.php</code> file which will inturn display its contents. Although 
                    the <code>view()</code> function may be used this way, it is highly discouraged to do so. Also, the <code>view()</code> 
                    function may be dropped in 
                    future update to favor only the compile method.
                </div>
              </div>
          </div>   

        </div>
      </div>
    </section>
  </div>

  @template;
  