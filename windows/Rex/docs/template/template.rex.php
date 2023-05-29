
@template('template.t-tut')

  @title('Rex template')

  @lay('build.co.navbars:left-nav')

  <style>
    .directives code {
      color: #f7f7f7;
      background-color: #47b13e;
      border:none;
    }

    .template-area {
      display: grid;
      grid-template-areas: "one" "two" "three";
      gap: 1em;
    }

    @media (min-width: 1000px) {

      .template-area {
        grid-template-areas: "one two" "three three";
      }  

    }

    @media (min-width: 1200px) {

      .template-area {
        grid-template-areas: "one two three";
      }  

    }
  </style>

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        <div class="start font-em-d8">

          @lay('build.co.links:tutor_pointer') <br>

          <div class="font-em-1d5 c-orange">Template Engine : Rex</div> <br>  

          <div class="templating-intro">
              <div class="">
                  Rex template engine is an inbuilt spoova engine for compiling and rendering template files which uses special 
                  predefined template directives to make it easier to build web pages. The <code>rex</code> files are mostly identified 
                  with the <code>.rex</code> extension name which usually comes before the code file extension name. Aside from the main php template files
                  identified with <code>.rex.php</code> extension, spoova also uses template directives for css and javascript files. 
                  The extension of these files are identified with <code>.rex.css</code> and <code>.rex.js</code> respectively. There are several couple of 
                  template directives designed for the spoova template engine, some of which makes is possible to create reusable template components. 
                  The template engine is also built to be responsive with compiler functions and methods that performs the entire process of compiling the rex
                  template files and also rendering the rex template after compilation. In most cases, the compiler functions
                  <code>compile()</code> and <code>view()</code> are used along with a rendering method <code>Res::load()</code>. 
                  The combination of this method and its relatively designed compiler functions both creates the template engine system. In 
                  order to provide a much better clarity on how rex template engine works, this section will be divided into different parts. 
                  <br><br>  
              </div>
          </div>  
          
          <div class="c-teal-d flex template-area">


            <div class="">

                <div class="shadow-2-strong rad-5 flow-hide" style="height: 300px">
                  <div class="pxv-10 bc-silver-d"><span class="bi bi-stack"></span> Template Compilers</div>
                  <div class="pre-area">
                    <pre class="pre-code vh-full">
  &lt;?php 

    class Home {

      function __construct() {

          self::load('home' => compile());

      }

    }
                    </pre>
                  </div>
                </div>

            </div>

            <div class="">

                <div class="shadow-2-strong rad-5 flow-hide" style="height: 300px">
                  <div class="pxv-10 bc-silver-d"><span class="bi-at"></span> Template Directives</div>
                  <div class="pre-area">
                    <pre class="pre-code vh-full">
  @(template('rex-path'))@

   Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
   Cum tempora sunt accusamus tenetur nobis. Itaque, iure 
   neque. Accusantium debitis amet fugiat dicta totam quidem 
   quod magni ratione repellendus doloribus. Corrupti debitis 
   provident atque laboriosam, dicta consectetur amet eius 
   voluptatum. Quos quod natus inventore culpa deserunt 
   laudantium aliquid quae magni laborum ab nostrum, 
   ipsa aliquam repudiandae quam, dignissimos ...

  @(template)@;
                    </pre>
                  </div>
                </div>

            </div>

            <div class="">

                <div class="shadow-2-strong rad-5 flow-hide" style="height: 300px">
                  <div class="pxv-10 bc-silver-d"><span class="bi-arrow-clockwise"></span> Template on the go</div>
                  <div class="pre-area">
                    <pre class="pre-code vh-full">
    &lt;?php 

    class Home {

      function __construct() {

          self::addRex();
          self::load('home' => compile());
          ...

      }

    }
                    </pre>
                  </div>
                </div>

            </div>

            
            <ul>
                <li><a href="@route('::compilers')">Template compilers</a></li>
                <li><a href="@domurl('version/2.0/compiler-class')">Compiler class</a></li>
                <li><a href="@route('::files')">Template files</a></li>
                <li><a href="@route('::directives')">Template directives</a></li>
                <li><a href="@route('::window')">Templating on window</a></li>
                <li><a href="@route('::on_the_go')">Template on the go</a></li>
            </ul>


          </div>
        
        </div>  

        @lay('build.co.coords:footer')
      </div> 
      
    </section>
  </div>


@template;