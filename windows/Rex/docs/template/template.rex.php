
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

          <div class="font-em-1d5 c-orange">Template Engine : Rex</div> <br>  

          <div class="templating-intro">
              <div class="fb-6">Introduction</div>
              <div class="">
                  Rex template engine is an inbuilt spoova engine for compiling and rendering template files which uses special 
                  predefined template directives to make it easier to build web pages. The <code>rex</code> files are mostly identified 
                  with the <code>.rex</code> extension name which comes before the real file extension name. Aside from the main php template files
                  identified with <code>.rex.php</code> extension, spoova uses template directives to other rex files which include css and javascript files only. 
                  The extension of these files are identified with <code>.rex.css</code> and <code>.rex.js</code> respectively. There are several couple of 
                  template directives designed for the spoova template engine, some of which makes is possible to create reusable template components. 
                  The template engine is also built to be responsive with compiler functions and methods that performs the entire process of compiling the rex
                  template files and also rendering the rex template after compilation. In most cases, the compiler functions
                  <code>compile()</code> and <code>view()</code> are used along with a rendering method <code>Res::load()</code>. 
                  The combination of these method and its respective child functions both makes the template engine become a reality. In 
                  order to provide a much better clarity on how rex template engine works, this section will be divided under the following 
                  subheadings. 
                  <br><br>  
              </div>
          </div>  
          
          <div class="c-teal-d">
            <ul>
                <li><a href="@route('::compilers')">Template compilers</a></li>
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