

@template('template.t-tut')

  <section class="flex">
    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
          <section class="pxv-10 tutorial bc-white">
              <div class="font-em-1d2">

                  <div class="start font-em-d85">

                      <div class="font-em-1d5 c-orange docs-header">Hello World!</div>
                        
                      <div class="c-black-ll pvs-10">
                          Creating your first application can be a bit choicy because of the flexibility of 
                          the architectural logics which defines how pages should be resolved. Although we have 
                          3 architectural logics which are standard, basic and index logics, on this page 
                          we are going to use the standard logic pattern to create our first application. We 
                          are also going to assume that we are working on <code class="bc-white-dd c-teal">localhost</code> 
                          and the project folder name is <code class="bc-white-dd c-teal">"app"</code>.
                      </div> <br>

                      <div class="calibri bckg-1">
                          
                          <div class="header-black pxv-10">Adding webpage home</div>

                          <div class="flex-col mvt-10 gap-2">
                            <div class="pxs-10">
                              <i class="bi-dot"></i> We can easily add a new page (route) by running the following commands in the terminal 
                            </div>
                            <div class="calibri pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code">
<span class="comment">&gt;</span> php mi add:route Home
                                  </pre>
                                </div>
                            </div>
                          </div>

                          <div class="">
                            <div class="pxs-10">
                              <i class="bi-dot"></i> The command above will create a new route controller file 
                              <code>"Home"</code> in the <code>windows/Routes</code> directory. The file generated 
                              will resemble the format below:
                            </div>
                            <div class="calibri pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code"><code>
&lt;?php

namespace @scheme('windows\Routes', false);

use Window;

class Home extends Window {
    
    public function __construct(){

        self::call($this,
            [
                window(":") => 'home'
            ]
        );

    }

    public function home() {

        <span class="comment">// self::addRex();</span>
        <span class="comment">// self::load('home', fn() => compile() );</span>
        
    }

    <span class="comment">/**
      * Add name of routes
      *
      * @return array
      */</span>
    public static function addRoutes(array $array = []) : array {

        return [
            <span class="comment">// 'routeName' => 'routePath'</span>
        ];

    }

} 
                                  </code></pre>
                                </div>
                            </div>
                          </div>

                            
                          <div class="">
                            <div class="pxv-10">
                              <i class="bi-dot"></i> 
                              Once the <code class="bc-silver">Home</code> route controller file above is generated, when you visit the url address 
                              <code class="bc-silver">http://localhost/app/home</code> on your browser, you should see a blank page specifying that the route has 
                              been successfully added. The <code class="bc-silver">self::call()</code> method in the controller file above is a shutter or url validator 
                              that prevents unregistered urls and processes registered urls. When we visit <code class="bc-silver">http://localhost/app/home</code>, the corresponding method <code class="bc-silver">home()</code> 
                              is internally called through the shutter. To generate our first template file, we need to uncomment both of the methods called within the <code class="bc-silver">home()</code> method above. 
                              The <code class="bc-silver">self::addRex()</code> sends an auto template generation instruction to the <code class="bc-silver">self::load()</code> method only if we try to load an unexisting 
                              template file as the case above. After uncommenting both methods, the <code class="bc-silver">Home</code> controller file should resemble the format below
                            </div>
                            <div class="calibri mvt-5 pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code"><code>
&lt;?php

namespace spoova\mi\windows\Routes\Home;

use Window;

class Home extends Window {
    
    public function __construct(){

        self::call($this,
            [
                window(":") => 'home'
            ]
        );

    }

    function home() {

        self::addRex();
        self::load('home', fn() => compile() );
        
    }

    <span class="comment">/**
      * Add name of routes
      *
      * @return array
      */</span>
    public static function addRoutes(array $array = []) : array {

        return [
            <span class="comment">// 'routeName' => 'routePath'</span>
        ];

    }

}
                                  </code></pre>
                                </div>
                            </div>
                          </div>
                          
                          <div class="">
                            <div class="pxv-10">
                              <i class="bi-dot"></i> 
                              Once the lines are uncommented and the corresponding webpage is refreshed, the <code class="bc-silver">self::load()</code> method will 
                              automatically generate a template file <code class="bc-silver">home.rex.php</code> inside the <code class="bc-silver">windows/Rex</code> 
                              directory if it does not already exist. Alternatively, this template can also be generated using the command line as shown below:
                            </div>
                            <div class="calibri mvt-5 pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code">
<span class="comment no-select">&gt;</span> php mi add:rex home
                                  </pre>
                                </div>
                            </div>
                          </div> 
                          
                          <div class="">
                            <div class="pxv-10">
                              <i class="bi-dot"></i> 
                              The command above will add the <code class="bc-silver">home.rex.php</code> file into the <code class="bc-silver">windows/Rex</code> directory. The generated template file 
                              will resemble a structure similar to the format below: 
                            </div>
                            <div class="calibri mvt-5 pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code"> <code>
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
  &lt;meta charset="UTF-8"&gt;
  &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
  &lt;title>Home&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
  <span class="comment">/* some html content here */</span>
&lt;/body&gt;
&lt;/html&gt;
                                  </code></pre>
                                </div>
                            </div>
                          </div> 
                          
                          <div class="">
                            <div class="pxv-10">
                              <i class="bi-dot"></i> 
                              Now we can add our first <span class="quote">Hello world!</span> text into the template file and then refresh the browser page. 
                            </div>
                            <div class="calibri mvt-5 pxv-10 font-em-d85">
                                <div class="pre-area command-line">
                                  <pre class="pre-code">
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
  &lt;meta charset="UTF-8"&gt;
  &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
  &lt;title>Home&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
  <span class="comment">Hello world!</span>
&lt;/body&gt;
&lt;/html&gt;
                                  </pre>
                                </div>
                            </div>
                          </div> 
                          
                          <div class="">
                            <div class="pxv-10">
                              <i class="bi-dot"></i> 
                              When we visit the <code class="bc-silver">http://localhost/app/home</code> on the browser, the text <code class="bc-silver c-teal">"Hello world!"</code> will be displayed. 
                            </div>
                          </div> <br>

                      </div>


                </div>
                
                <select name="" id="">
                  <option value="dark">dark</option>
                  <option value="agate">agate</option>
                  <option value="an-old-hope.min">an old hope</option>
                  <option value="androidstudio.min">androidstudio</option>
                  <option value="adruino-light.min.min">adruino light</option>
                  <option value="arta.min">arta.min</option>
                  <option value="ascetic.min">ascetic.min</option>
                  <option value="atom-one-dark.min">atom-one-dark.min</option>
                  <option value="atom-one-light.min">atom-one-light.min</option>
                  <option value="brown-paper.min">brown-paper.min</option>
                  <option value="codepen-embed.min">codepen-embed.min</option>
                  <option value="color-brewer.min">color-brewer.min</option>
                  <option value="devibeans.min">devibeans.min</option>
                  <option value="docco.min">docco.min</option>
                  <option value="far .min">far.min</option>
                  <option value="felipec.min">felipec.min</option>
                  <option value="foundation.min">foundation.min</option>
                  <option value="github.min">github.min</option>
                  <option value="github-dark.min">github-dark.min</option>
                  <option value="gml.min">gml.min</option>
                  <option value="googlecode.min">googlecode.min</option>
                  <option value="kimbie-dark.min">kimbie-dark.min</option>
                  <option value="kimbie-light.min">kimbie-light.min</option>
                  <option value="lightfair.min">lightfair.min</option>
                  <option value="lioshi.min">lioshi.min</option>
                  <option value="mangula.min">mangula.min</option>
                </select>
                
                <view></view>

<script>  
hljs.highlightAll();

const themeConfig = {
  root: "@domurl('res/assets/libraries/highlight')",
  script: 'highlight.min.js',
  styles: {
    dark: 'styles/dark.min',
    agate: 'styles/agate.min',
  },
  assumeCssPath: true
};
const theme = new Theme(themeConfig);

let themex = document.querySelector('select');
themex.addEventListener('change', function(elem){
  let value = elem.target.value;
  theme.choose('styles/'+value)
})


</script>

              </div>
          </section>
      </div>
  </section>


   
@template;