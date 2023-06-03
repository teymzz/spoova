
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

          <div class="font-em-1d5 c-orange">Rex Engine : Template directives</div> <br>  
          
          <div class="directives-intro">
              <div class="">
                  Rex template engine is an inbuilt template compiler engine for compiling and rendering template files which uses special 
                  predefined template directives to make it easier to build web pages. Through the use of template directives, 
                  the ability to create reusable components becomes easier to deal with. The <code>Rex</code> template engine is  
                  built along with compiler functions and methods that performs the entire process of compiling the rex
                  template files and also rendering the rex template after compilation. The rex template directives are listed  
                  and discussed below:
                  <br><br>

                  <ul class="font-em-d9 list-free pxl-1 c-sea-blue directives">
                    <li><a href="#meta"><code>@meta</code></a></li>

                    <li><a href="#res"><code>@res</code></a></li>

                    <li><a href="#src"><code>@src</code>  / <code>@ress</code></a></li>
                    
                    <li><a href="#import"><code>@import</code></a></li> 
                    
                    <li><a href="#live"><code>@(@live)@</code></a></li>
                    
                    <li><a href="#domurl"><code>@domurl</code></a></li>

                    <li><a href="#placeholders"><code>@({{}})@</code></a></li> 
                    
                    <li><a href="#php"><code>@(@php)@</code></a></li> 
                    
                    <li><a href="#assets"><code>@assets</code></a></li>
                    
                    <li><a href="#mapp"><code>@mapp</code></a></li>
                    
                    <li><a href="#mass"><code>@mass</code></a></li>
                    
                    <li><a href="#images"><code>@images</code></a></li>
                    
                    <li><a href="#include"><code>@(@include)@</code> </a></li>
                    
                    <li><a href="#template"><code>@template</code></a></li>
                    
                    <li><a href="#title"><code>@title</code></a></li>
                    
                    <li><a href="#attr"><code>@(@attr)@</code></a></li>

                    <li><a href="#layout"><code>@layout</code></a></li>
                    
                    <li><a href="#inpath"><code>@inPath</code></a></li>
                    
                    <li><a href="#ispath"><code>@isPath</code></a></li>
                    
                    <li><a href="#style"><code>@style</code></a></li>

                    <li><a href="#styles"><code>@(@styles)@</code></a></li>
                    
                    <li><a href="#script"><code>@script</code></a></li>
                    
                    <li><a href="#onscript"><code>@onscript</code></a></li>
                    
                    <li><a href="#onshow"><code>@onShow</code></a></li>
                    
                    <li><a href="#onhide"><code>@onHide</code></a></li>
                    
                    <li><a href="#flash"><code>@flash</code></a></li>
                    
                    <li><a href="#auth"><code>@(@auth:)@</code></a></li>
                    
                    <li><a href="#guest"><code>@(@guest:)@</code></a></li>
                    
                    <li><a href="#authdirect"><code>@authdirect</code></a></li>
                    
                    <li><a href="#guestdirect"><code>@guestdirect</code></a></li>
                    
                    <li><a href="#btn"><code>@(@btn)@</code></a></li>
                    
                    <li><a href="#get"><code>@(@get)@</code></a></li>
                    
                    <li><a href="#post"><code>@(@post)@</code></a></li>
                    
                    <li><a href="#old"><code>@(@old)@</code></a></li>
                    
                    <li><a href="#csrf"><code>@(@csrf)@</code></a></li>
                    
                    <li><a href="#error"><code>@(@error)@</code></a></li>
                    
                    <li><a href="#vdump"><code>@(@vdump)@</code></a></li>

                    <li class="conditionals c-olive">
                      <span class="fb-6 calibri pvs-10 box">CONDITIONALS</span>
                      <ul class="list-square pxs-4">
                        <li><a href="#conditionals">@if</a></li>
                        <li><a href="#conditionals">@for</a></li>
                        <li><a href="#conditionals">@foreach (or @each)</a></li>
                        <li><a href="#conditionals">@do</a></li>
                        <li><a href="#conditionals">@while</a></li>
                        <li><a href="#conditionals">@switch</a></li>
                        <li><a href="#conditionals">@break</a></li>
                      </ul>
                    </li>
                  </ul>
                  
                  
              </div> 
          </div>
          
          <div id="meta" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> meta()</div>
              </div>
              
              <div class="">
                This directive is used to load meta tags that are set by default within the 
                <code>$_ENV</code> variable. It takes the parameter <code>"dump"</code> or 
                <code>drop</code> which is one of its methods. By setting the option <code>"dump"</code>, 
                it dumps all the default meta tag that was set with the help of the <code>Meta</code> class.
                Before this tag can work successfully, the default meta tags must have been properly configured
                in the <code>icore/filemeta</code> file. You can learn how to set up meta tags using <code>Meta</code> 
                class from <a href="@domurl('docs/classes/meta')">here</a>.
                
                <br><br>
                <div class=" mvb-6">The example below shows how the meta 
                directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span> @(@meta('dump'))@ <span class="comment">&lt;/head&gt;</span> 
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>   
          
          <!---------------------------- res -->
          <div id="res" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> res()</div>
              </div>
              
              <div>
                The <code>@(@res())@</code> directive is a bit different from other directives. It has two 
                different modes of application which resolves into different responses. <br>
                <ul class="font-em-d9 mvt-6">
                  <li>@(@Res::import())@</li>
                  <li>@(@Res())@</li>
                </ul> 
                
                The <code>@(@Res::import)@</code> works similarly as the <code>Res::import()</code> method 
                while the <code>@(@Res())@</code> is used to resolve static files. 

                <div class=" mvb-6">The example below shows how the <code>@(@Res())@</code> 
                directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@Res('res/file.css'))@ <span class="comment no-select"> &lt;script src="http://localhost/spoova/res/file.css"&gt;&lt;/script&gt;</span>

  @(@Res('file.js'))@ <span class="comment no-select"> &lt;link href="http://localhost/spoova/file.js" rel="stylesheet" type="text/css"/&gt; </span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div> 
          
          <!---------------------------- src -->
          <div id="src" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> src() / ress()</div>
              </div>
              
              <div class="mvt-10">
                The <code>@(@src())@</code> directive returns resources from the <code>res/</code> directory. If the path 
                of file supplied exists within the res folder, an equivalent http address of the static file is returned.<br><br>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@src('res/file.css'))@ <span class="comment no-select"> http://site-domain/res/file.css</span>
  
  @(@ress('res/file.css'))@ <span class="comment no-select"> http://site-domain/res/file.css</span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div> 
          
          <!-------------------------------- import -->
          <div id="import" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> import()</div>
              </div>
              
              <div>
                The <code>@import</code> directive is similar to the <code>Res::import()</code> 
                function. It is specifically being used to import two things: <br>

                <ul>
                  <li>static resources group <code>@(@import(':group'))@</code></li>
                  <li>live server <code>@(@import('::watch'))@</code></li>
                </ul>
                
                <div class=" mvb-6">The example below shows how the import 
                directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span>
    @(@import(':header'))@  
    @(@import('::watch'))@  
  <span class="comment">&lt;/head&gt;</span> 
                  </pre>

                </div>
                <!-- code line ended -->

              </div> 
        
          </div>  

          <!---------------------------------- live -->
          <div id="live" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> live / live()</div>
              </div>
              
              <div>
                The <code>@(@live)@</code> directive is the shorthand directive for <code>@(@Res::import('::watch'))@</code> 
                function. It is specifically being used to import the live server into a specific template engine if 
                switched off by default. 
              </div>
        
          </div>  
          
          <!--------------------------------- domurl -->
          <div id="domurl" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> domurl() </div>
            </div>
            
            <div>
              Just like the domurl function, <code>@domurl</code> is being used to resolve 
              local urls into http protocol urls. Within the spoova framework, developers should 
              use the <code>domurl</code> when linking static files as it properly maps the local url
              supplied. This creates a handshake between : <br> <br>
              <ul>
                <li>offline - online projects</li>
                <li>desktop - mobile device developments</li>
              </ul> 
              
              <div class=" mvb-6">The example below shows how the import 
              directive can be applied in template files</div>

              <!-- code line started -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span>
    &lt;a href="@(@domurl('res/images/myimage.jpg'))@"&gt; myimage &lt;/a&gt;   

    &lt;link href="@(@domurl('https://site.com/assets/css/site.css'))@" /&gt; 
  <span class="comment">&lt;/head&gt;</span> 
                </pre>

              </div>
              <!-- code line ended -->

            </div>
        
          </div> 
          
          <!-------------------------------- placeholders -->
          <div id="placeholders" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> placeholders @({{}})@ </div>
              </div>
              
              <div>
               Placeholders are used to display contents on the screen. They can also be 
               used to make calculations, execute functions or even access arguments passed on to template files. 
               Placeholders are usually denoted by 
               two opening <code><span>{</span>{</code></code>  curly brackets and two closing curly barckets <code><span>}</span>}</code>  
             
                <div class=" mvb-6">
                  The example below shows how placeholders can be used. 
                  Returned data type can be ony within the range of integers, floats, strings or bool, which literally translates as 
                  integers or null. Returned data type cannot be arrays, functions or objects.
                </div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @({{ 2 + 2 }})@ 

  @({{ 2 / 2 * 3 }})@ 

  @({{ true? 'yes' : 'no' }})@ 

  @({{ true ?? false }})@ 

  @({{ myfunction() }})@ 
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>  
          
          <!-------------------------------- placeholders -->
          <div id="php" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> php()</div>
              </div>
              
              <div>
               This directives is used when raw php codes are need to be executed Any code that stays 
               within the <code>@(@php:)@</code> and <code>@(@php;)@</code> directives will be executed as 
               a raw php code.
              
             
                <div class=" mvb-6">
                  The example below shows how the <code>@php:</code> directives can be used. 
                </div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@php:)@ 

    $text = '123';

    echo( $text ); <span class="comment no-select">//123</span>

  @(@php;)@ 
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>

          <!------------------------------- assets -->
          <div id="assets" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> assets()</div>
            </div>
            
            <div>
              The <code>@assets</code> directive is a shorthand directive that loads static files directly from the  
              assets folder which is a subdirectory of the <code>res/</code> folder. This directive can also be applied 
              to load grouped static files just like the <code>@(@Res())@</code> method.
              <br><br>

              <div class=" mvb-6">The example below shows how the directive can be applied in template files</div>

              <!-- code line started -->
              <div class="pre-area shadow">
                <div class="pxv-10 bc-silver">Example 1 - Loading urls</div>
                <pre class="pre-code">
  @(@assets('css/file.css'))@ <span class="comment no-select">// &lt;link href=":domainurl/res/assets/css/file.css"/&gt;</span>
                </pre>

                <div class="pxv-10 bc-silver">Example 2 - Importing resource groups</div>
                <pre class="pre-code">
  @(@assets(':headers'))@ <span class="comment no-select">// import headers </span>
                </pre>

              </div>
              <!-- code line ended -->

            </div>
        
          </div> 

          <!------------------------------- mapp -->
          <div id="mapp" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> mapp()</div>
            </div>
            
            <div>
              The <code>@mapp</code> directive is a shorthand directive that returns files url using 
              static resources main folder (i.e res/main) as its base path
              <br><br>

              <div class=" mvb-6">The example below shows how the directive can be applied in template files</div>

              <!-- code line started -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  &lt;img src="@(@mapp('images/image.jpg'))@"&gt; <span class="comment no-select">// &lt;img src=":domainurl/res/main/images/image.jpg"/&gt;</span>
                </pre>

              </div>
              <!-- code line ended -->

            </div>
        
          </div> 

          <!------------------------------- mapp -->
          <div id="mass" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> mass()</div>
            </div>
            
            <div>
              The <code>@mass</code> directive is a shorthand directive that returns files url using 
              static resources main folder (i.e res/assets) as its base path
              <br><br>

              <div class=" mvb-6">The example below shows how the directive can be applied in template files</div>

              <!-- code line started -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  &lt;img src="@(@mass('images/image.jpg'))@"&gt; <span class="comment no-select">// &lt;img src=":domainurl/res/assets/images/image.jpg"/&gt;</span>
                </pre>

              </div>
              <!-- code line ended -->

            </div>
        
          </div> 
          
          <!-------------------------------- images -->
          <div id="images" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> images()</div>
            </div>
            
            <div>
              The <code>@images</code> is a shorthand directive that loads images directly from the  
              images folder which is a subdirectory of the <code>res/assets/</code> folder. When it is used, 
              images from this folder will be loaded into the webpage if exists. Subdirectories of that folder 
              can also be applied.
              <br><br>

              <div class=" mvb-6">The example below shows how the directive can be applied in template files</div>

              <!-- code line started -->
              <div class="pre-area shadow">

                <pre class="pre-code">
  &lt;img src="@(@images('myimage.jpg'))@"&gt; <span class="comment no-select">// &lt;img src="/res/assets/images/image.jpg"/&gt;</span>
                </pre>

              </div>
              <!-- code line ended -->

            </div>
        
          </div> 
          
          <!---------------------------------- include -->
          <div id="include" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> include()</div>
              </div>
              
              <div>
                The <code>@(@include())@</code> is a shorthand directive for php internal <code>include</code> function. Any file 
                included should only follow the document root. For example, if a file <code>file.php</code> exists within the project root,
                then including that file will be as follows:
                <br><br>

                <div class="foot-note mvb-6">The example below shows how the directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@include('file.php'))@ <span class="comment no-select">// include "file.php" from the document root.</span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div> 
          
          <!-------------------------------- template -->
          <div id="template" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"><i class="bi-building-up mxr-4"></i> template()</div>
            </div>
            
            <div class="mvt-16">
              The <code>@(@template())@</code> function is used to load templates into another template file. A template 
              is more like a layout structure of how a page should look like. When such template has been successfully created, 
              a specific part of the layout can be allocated for external structure to fill up using the <code>@(@yield())@</code>
              directive. This is explained by using file1.rex.php and file2.rex.php below as examples.
              <br><br>

              <div class=" mvb-6">The example below shows how the <code>@(@template)@</code> and <code>@(@yield)@</code> directives can be applied in template files</div>

              
              <!-- code line started -->
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver  mvb-6">file1.rex.php</div>
                <pre class="pre-code">
  <?= to_lgts(
    '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
    </head>
    <body>

      @yield()

    </body>
    </html>
    '
  );
  ?>
                </pre>

              </div>
              <!-- code line ended -->

            </div> <br>

            
            <!-- code line started -->
            <div class="pre-area shadow">
              <div class="pxv-6 bc-silver  mvb-6">file2.rex.php</div>
              
              <pre class="pre-code">
  <span class="comment no-select">// include "file.php" from the document root.</span>
  @(@template('file1.rex.php'))@
  
    This is a content from file2.rex.php

  @(@template;)@
              </pre>

            </div> <br>
            <!-- code line ended -->

            <div class="foot-note mvt-10">file2.rex.php will be resolved to </div>

            <!-- code line started -->
            <div class="pre-area shadow mvt-10">

              <div class="pxv-10 bc-silver no-select"> Include "file.php" from the document root.</div>
              <pre class="pre-code">
  <?= to_lgts(
    '
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
      </head>
      <body>

        This is a content from file2.rex.php

      </body>
    </html>
    '
  );
  ?>
              </pre>

            </div>
            <!-- code line ended -->


            <div class="foot-note">Note: when building template files, 
              the template files should be separated from the real contents. Templates by 
              default are loaded from the <code>windows\Rex</code> folder. 
              It is advisable that the real content may be located within the
              template engine <code>rex</code> folder directory while the template 
              files may be in a subdirectory for proper file organization. Also, when 
              a parent template file has the live server turned on, a child page 
              can be employed to turn it off by calling the <code>:off</code> directive 
              on the template url just as below:
            </div>

            <!-- code line started -->
            <div class="pre-area shadow mvt-6">

              <div class="pxv-10 bc-silver no-select"> Turn off live server on template import.</div>
            <pre class="pre-code">
  @(@template('file1:off'))@
  
    This is a content from file2.rex.php

  @(@template;)@
              </pre>

            </div>
            <!-- code line ended -->

          </div>

          <!-- head -->
          <div id="head" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> head()</div>
              </div>
              
              <div>
                The <code>@(@head())@</code> directive is used to set a default webpage title. 
                
                <br><br>
                <div class=" mvb-6">The example below shows how head 
                directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  &lt;html lang="en"&gt;
    &lt;head&gt;
     &#64;head('homepage')
    &lt;head&gt;
    &lt;body&gt;
     &#64;yield()
    &lt;body&gt;
  &lt;html&gt;
                  </pre>

                </div>
                <div class="pre-area shadow">

                  <pre class="pre-code">
  &#64;template('home')
    <span class="comment">some new content here...</span>
  &#64;template;
                  </pre>

                </div>
                <div class="foot-note">
                  In the sample above, the default page title will be inherited by the child template.
                  In the event that we need to overide the default title set, we can overide this default 
                  title by using the <code>@(@title())@</code> directive.
                </div>
                <!-- code line ended -->

              </div>
        
          </div> 

          <!-- title -->
          <div id="title" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> title()</div>
              </div>
              
              <div>
                This directive is used to set a webpage title. It works along with the <code>@(@template)@</code> 
                directive. We can declare this above or within the <code>@(@template)@</code> directive. When 
                importing templates, the application will first check for the page title, then it will successfully map
                it to the current page.
                
                <br><br>
                <div class="foot-note mvb-6">The example below shows how the title 
                directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @template('some-template-file')@
   @(@title('home'))@

   <span class="comment">...new content here...</span>

  @(@template)@;
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div> 
          
          <!------------------------------- attr -->
          <div id="attr" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> attr()</div>
            </div>
            
            <div>

              <div class=" font-em-d9 helvetica">
                The <code>@(@attr:)@</code> directive is used to store a line of code within a template file. 
                Once the line is stored, then it can be imported back within the template file. This directive works 
                in pairs. While the <code>@(@&lt;x-attr:/&gt; )@</code> directive is used to store the text, the 
                <code>@(@attr:)@</code> is used to return back the specific data stored. This function 
                should not be used to store extremely long strings as the are only meant for use in situation where 
                there are similary recurring text files. 
              </div>
              <br>

              <div class=" mvb-6">The example below shows how the <code>@(@attr:)@</code> and <code>&lt;x-attr: /&gt;</code> directives can be applied in template files</div>

              
              <!-- code line started -->
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver  mvb-6">lay.rex.php</div>
                <pre class="pre-code">
  &lt;x-attr:book This is a book /&gt; <span class="no-select comment">// stores 'This is a book' </span>

  @(@attr:book)@ <span class="no-select comment">// "This is a book" string will be returned</span>
                </pre>
              </div>
              <!-- code line ended -->

            </div> <br>
            
            <!-- code line started -->
            <div class="pre-area shadow">
              <div class="pxv-6 bc-silver mvb-6">page.rex.php</div>
              <pre class="pre-code">
  <?= to_lgts('<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>

  @(@lay(\'lay:header\'))@ 
      ').'
    <span class="comment no-select">// other contents here...</span>
      '.to_lgts('
  @(@lay(\'lay:footer\'))@ 
        
  </body>
  </html>
      '
    );
  ?>
              </pre>
            </div> <br><br>
            <!-- code line ended -->

            <!-- code line started -->
            
            <div class="pre-area shadow">
              <div class="pxv-6 bc-silver  mvb-6">page.rex.php will be resolve to </div>

              <pre class="pre-code">
  <?= to_lgts(
    '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>

    <header> This is my page header </header>

    <footer> This is my page footer </footer>

  </body>
  </html>
    '
  );
  ?>
              </pre>

            </div>
            <!-- code line ended -->

            <div class="foot-note mvb-6"> 
              <div class="pvs-8">Note: In the above,</div>
              <code>@(@lay)@</code> is the directive for importing layouts <br>
              <code>lay</code> is the file name (or file path if within subdirectory) <br>
              <code>:</code> column is used to denote the id while
              <code>footer</code> or <code>header</code> is the id name without special characters.
            </div> 

          </div>
          
          <!------------------------------- layout -->
          <div id="layout" class="mvt-16"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full"> <i class="bi-building-up mxr-4"></i> layout()</div>
            </div>
            
            <div>

              <div class=" font-em-d9 helvetica">
                The <code>@(@layout())@</code> function is similiar to the <code>@(@template())@</code> directive.
                While <code>@(@template)@</code> loads a full layout from a file, the <code>@(@layout)@</code> directive picks a 
                layout from a group of layouts within a file. When grouping layouts, it is not advisable to put all eggs 
                in one basket as they will break. Layout files are only used to group files of similar functionalities together.
                For example, a <b>footer</b>  and <b>header</b> content can be grouped together in one single layout file, each separated with its own layout id.
                When importing or picking a layout from a layout file, the id can then be called and only the specific layout relative to that id 
                will be returned.
              </div>
              <br>

              <div class=" mvb-6">The example below shows how the <code>@(@layout)@</code> and <code>@(@lay)@</code> directives can be applied in template files</div>

              
              <!-- code line started -->
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver  mvb-6">lay.rex.php</div>
                <pre class="pre-code"><?= to_lgts(
  '
  @(@layout:header)@
    <header> This is my page header </header> 
  @(@layout;)@  


  @(@layout:footer)@
    <header> This is my page footer </header> 
  @(@layout;)@        
    '
  );
  ?>
                </pre>
              </div>
              <!-- code line ended -->

            </div> <br>

            
            <!-- code line started -->
            <div class="pre-area shadow">
              <div class="pxv-6 bc-silver  mvb-6">page.rex.php</div>
              <pre class="pre-code">
  <?= to_lgts(
  '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>

  @(@lay(\'lay:header\'))@ 
  ').'
    <span class="comment no-select">// other contents here...</span>
      '.to_lgts('
  @(@lay(\'lay:footer\'))@ 
        
  </body>
  </html>
      '
    );
  ?>
              </pre>
            </div> <br><br>
            <!-- code line ended -->

            <!-- code line started -->
            
            <div class="pre-area shadow">
              <div class="pxv-6 bc-silver  mvb-6">page.rex.php will be resolve to </div>

              <pre class="pre-code">
  <?= to_lgts(
    '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>

    <header> This is my page header </header>


    <footer> This is my page footer </footer>

  </body>
  </html>
    '
  );
  ?>
              </pre>

            </div>
            <!-- code line ended -->

            <div class="foot-note mvb-6"> 
              <div class="pvs-8">Note: In the above,</div>
              <code>@(@lay)@</code> is the directive for importing layouts <br>
              <code>lay</code> is the file name (or file path if within subdirectory) <br>
              <code>:</code> column is used to denote the id while
              <code>footer</code> or <code>header</code> is the id name without special characters.
            </div> 

          </div>

          
          <!------------------------------- inpath -->
          <div id="inpath" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> inPath()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  The <code>@inPath</code> checks if the current request url has a parent address which is supplied 
                  within the <code>@(@inPath())@</code> directive. If the parent address matches, the second argument 
                  supplied will be returned.
                </div>
                <br>

                <div class="font-em-d87 mvb-6">The example below shows how the <code>@(@inPath())@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Examples with assumed test pages</div>
                  <pre class="pre-code">
  <span class="comment no-select">
  Assumed Page 1: http://localhost/docs/resource/item
  Assumed Page 2: http://localhost/docs/some/page
  </span> 
  <span class="comment">Page 1:</span> @(@inPath('tutorial.resource', 'hi'))@  <span class="comment">returns "hi"</span> 
  <span class="comment">Page 2:</span> @(@inPath('tutorial.resource', 'hi'))@  <span class="comment">returns ""</span> 
                  </pre>

                </div>
                <!-- code line ended -->


                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example - Integrating domUrl with inPath </div>
                  <pre class="pre-code">
  &lt;a href="@(@domUrl('docs/resource'))@" class="@(@inPath(':dom-path', 'active'))@"&gt; 
  &lt;a href="@(@domUrl('docs/users'))@" class="@(@inPath(':dom-path', 'active'))@"&gt; 
                  </pre>

                </div>
                <!-- code line ended -->

                <div class="font-em-d8 mvt-10">
                  In the code above, <code>active</code> will be returned once the <code>@(@domUrl())@</code> path is 
                  visited. This happens because the <code>:dom-path</code> will automatically use the last path supplied on 
                  <code>@domUrl</code>, saving us the time to rewrite urls. This  behaviour is good for navigation bar menus. 
                  Also, for this to work, the <code>@(@inPath())@</code> must come immediately after <code>@(@domUrl())@</code> directive is used. Now  
                  it even gets easier when only one argument is supplied. If it is only one single argument supplied on  <code>@(@inPath())@</code>, then 
                  <code>@(@inPath)@</code> will automatically call the <code>:dom-path</code> argument on itself. This can save a lot of time when building 
                  web applications just as below:
                </div> <br>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example 2 - Integrating domUrl with inPath </div>
                  <pre class="pre-code">
  &lt;a href="@(@domUrl('docs/resource'))@" class="@(@inPath('active'))@"&gt; 
  &lt;a href="@(@domUrl('docs/users'))@" class="@(@inPath('active'))@"&gt; 
                  </pre>

                </div>
                <!-- code line ended -->
                
              </div>
        
          </div>  
          
          <!------------------------------- inpath -->
          <div id="ispath" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> isPath()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  The <code>@isPath</code> works similary as <code>@inPath</code> directive except that the exact path 
                  must be the same. This means that unlike <code>@inPath</code> which uses parent url, <code>@inPath</code> 
                  matches only the exact url supplied
                </div>
                <br>

                <div class="font-em-d87 mvb-6">The example below shows how the <code>@(@inPath())@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Examples with assumed test pages</div>
                  <pre class="pre-code">
  <span class="comment no-select">
  Assumed Page 1: http://localhost/docs/resource
  Assumed Page 2: http://localhost/docs/resource/item
  </span> 
  <span class="comment">Page 1:</span> @(@isPath('tutorial.resource', 'hi'))@  <span class="comment">returns "hi"</span> 
  <span class="comment">Page 2:</span> @(@isPath('tutorial.resource', 'hi'))@  <span class="comment">returns ""</span> 

                  </pre>

                </div>
                <!-- code line ended -->

                <div class="font-em-d8 mvt-10">
                  The code above reveals that when <code>@(@isPath)@</code> is used in page 1, it returned the second argument because 
                  the exact url matches the supplied argument for the directive. However, in page 2, the value returned is empty 
                  because the the request url is not the same with value supplied. This directive can also be integerated with <code>@(@domUrl())@</code> 
                  just like  the <code>@(@inPath())@</code> directive.
                </div>

              </div>
        
          </div>  
          
          <!------------------------------- style -->
          <div id="style" class=""> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"><i class="bi-building-up mxr-4"></i> style()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  This is used to pull the contents of a rex css template file into an html template file. It works similarly as the  
                  layout method. The rex css template file is structured to contain multiple divisions of css codes. The <code>@style</code> 
                  is a directive that is structure to pull only specifically needed divisions of css codes from the css template file. 
                </div>
                <br>

                <div class="font-em-d87 mvb-6">The example below shows how the <code>@(@style)@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example: Css Rex File (index.rex.css)</div>
                  <pre class="pre-code">
  <span class="c-orange-d">#style:css1</span>
    <span class="c-olive">
    body {
      background-color:red;
    }
    </span>
  <span class="c-orange-d">#style;</span>

  <span class="c-orange-d">#style:css2</span>
    <span class="c-olive">
    body {
      font-size:1em;
    }
    </span>
  <span class="c-orange-d">#style;</span>

                  </pre>

                </div>
                <!-- code line ended -->

                <!-- code line started -->
                <br>
                <div class="pre-area shadow">
                  <div class="bc-silver comment no-select pxv-10">Now, we can import our css file codes using the division name</div>
                  <pre class="pre-code">
  @(@style('index:css1'))@  <span class="comment">returns code in css1 above</span> 
  @(@style('index:css2'))@  <span class="comment">returns code in css2 above</span> 
  
  <span class="comment no-select">We can also import both css at once</span>

  @(@style('index:css1:css2'))@  <span class="comment">returns code in css1 & css2 above</span> 
                  </pre>
                </div>
                <!-- code line ended -->

                <div class="font-em-d8 mvt-10">
                  In the example above, the contents of the rex css template file can be imported into any template file just as
                  shown above. It is important not to store heavy css files into the css rex template file as this may break the 
                  application. Developers should organize and simplify their codes into different files which can then be imported 
                  by the <code>@(@style())@</code> directive. It is also important to note that every rex file must be located within the 
                  rex directory or subdirectory folders as this is the location the application will start searching for files from. In 
                  situtation where our <code>index.rex.css</code> file is in <code>rex/css</code> directory for example, then the path can be 
                  resolved by using dots as shown below
                </div> <br>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example: Css Rex File (rex.css.index.rex.css)</div>
                  <pre class="pre-code">
  @(@style('css.index:css1'))@  <span class="comment">resolves as rex/css/index.rex.css:css1</span>  
                  </pre>

                </div>
                <!-- code line ended -->
                
              </div>
        
          </div>  
          
          <!------------------------------- styles -->
          <div id="styles" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> styles</div>
              </div>
              
              <div>

                <div class="pxv-10">
                    The <code>@(@styles)@</code> has a parent relationship with <code>@(@style())@</code> directive. 
                    It pulls all the <code>@(@style())@</code> directives into one single space line after line. 
                </div>
                <br>

                <div class="font-em-d87 mvb-6">The example below shows how the <code>@(@style)@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Syntax:</div>
                 <pre class="pre-code">
  &lt;!DOCTYPE html&gt;
  &lt;html lang="en"&gt;
    &lt;head&gt;
      &lt;meta charset="UTF-8"&gt;
      &lt;meta http-equiv="X-UA-Compatible" content="IE=edge"&gt;
      &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
      &lt;title>Document&lt;/title>&gt;

      <span class="c-teal">@(@styles)@</span>

    &lt;/head&gt;
    &lt;body&gt;

        @(@style('some/css/layout:one'))@

          <span class="comment no-select">&lt;-- some html code here ... --&gt;</span>        
          
        @(@style('some/css/layout:two'))@

    &lt;/body&gt;
  &lt;/html&gt;
  @(@styles)@
                  </pre>

                </div>
                <!-- code line ended -->

                <!-- code line started -->
                <br>
                <div class="pre-area shadow">
                  <div class="bc-silver comment no-select pxv-10">
                    In the code above, all the <code>@(@style())@</code> directives will shift to the location of <code>@(@styles)@</code> 
                    directive before rendered 
                  </div>
                </div>

              </div>
        
          </div>
          
          <!------------------------------- script -->
          <div id="script" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> script()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  This is used to pull the contents of an external rex javascript template file into an html template file. It works similarly as the  
                  <code>@(@style())@</code> directive. The javascript template file is structured to contain multiple divisions of javascript codes. 
                  The <code>@(script)@</code> is a directive that is structure to pull only specifically needed divisions of css codes from the css template file. 
                </div>

                <div class="foot-note mvs-10">The example below shows how the <code>@(@script)@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example: Javascript Rex File (index.rex.js)</div>
                  <pre class="pre-code">
  <span class="comment no-select">
  <span class="c-orange-d">#script:js1</span>
    <span class="c-olive">
    function hi(){
      console.log('hi')
    }
    </span>
  <span class="c-orange-d">#script;</span>

  <span class="c-orange-d">#script:js2</span>
    <span class="c-olive">
    hi();
    </span>
  <span class="c-orange-d">#script;</span>
  </span>
                  </pre>

                </div>
                <div class="foot-note">
                  Now, we can import our javascript codes using the division name
                </div>
                <div class="pre-area">
                  <pre class="pre-code">
  @(@script('index:js1'))@  <span class="comment no-select">returns code in js1 above</span> 
  @(@script('index:js2'))@  <span class="comment no-select">returns code in js2 above</span> 
  
  <span class="comment no-select">We can also import both js at once</span>

  @(@style('index:js1:js2'))@  <span class="comment no-select">returns code in js1 & js2 above</span> 
                  </pre>
                </div>
                <!-- code line ended -->

                <div class="foot-note mvt-10">
                  In the example above, the contents of the rex javascript template file can be imported into any template file just as
                  shown above. It is important not to store heavy javascript files into the javascript rex template file as this may break the 
                  application. Developers should organize and simplify their codes into different files which can then be imported 
                  by the <code>@(@script())@</code> directive. Every rex file must also be located within the 
                  rex directory or subdirectory folders as this is the location the application will start searching for files from. In 
                  situtation where our <code>index.rex.js</code> file is in <code>rex/js</code> directory for example, then the path can be 
                  resolved by using dots as shown below
                </div> <br>

                <!-- code line started -->
                <div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example: Css Rex File (rex.js.index.rex.js)</div>
                  <pre class="pre-code">
  @(@script('js.index:js1'))@  <span class="comment">resolves as rex/js/index.rex.js:js1</span>  
                  </pre>

                </div>
                <!-- code line ended -->

                
              </div>
        
          </div>  
          
          <!------------------------------- onscript -->
          <div id="onscript" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> onscript()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  This function works similary as the <code>@script</code>directive. The only major difference 
                  is the any script pulled by this directive will be pulled into javascript's <code>window.onload</code> 
                  function.
                </div>

              </div>
        
          </div>  

          <!------------------------------- onShow -->
          <div id="onshow" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> onShow()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  This function is specially built for html tag's attribute <code>"hidden"</code>. It is used to display a 
                  string value "hidden" when the returned value of a function is not an empty value. This means that when 
                  a non-empty value is returned by a function, then <code>@onShow</code> will return a string value <code>"hidden"</code>. 
                  It takes a function name as its first main arguments. Other arguments are optional based on the supplied 
                  function's argument. The function name supplied must be an already defined function that is accessible.
                </div> <br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example for onShow() directive</div>
    <pre class="pre-code">
  function test($name){

    if($name == 'Rolland') {

      return 'some_non_empty_value';

    } 

  }

  @(@onShow('test', 'Rolland'))@ <span class="comment no-select">// returns 'hidden'</span>

  @(@onShow('test', 'Russell'))@ <span class="comment no-select">// returns empty string</span>
    </pre>
</div>

              </div>

        
          </div>  

          <!------------------------------- onShow -->
          <div id="onhide" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> onHide()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  This function is the inverse of <code>@onShow</code> directive. When a non-empty value is returned by 
                  a function, the <code>"hidden"</code> attribute will not be shown. However when an empty value is returned, 
                  then the <code>"hidden"</code> attribute will be returned.
                </div> <br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example for onHide() directive</div>
    <pre class="pre-code">
  function test($name){

    if($name == 'Rolland') {

      return 'some_non_empty_value';

    } 

  }

  @(@onHide('test', 'Rolland'))@ <span class="comment no-select">// returns empty string</span>
  
  @(@onHide('test', 'Russell'))@ <span class="comment no-select">// returns 'hidden'</span>
    </pre>
</div>

              </div>

        
          </div>  

          
          <!------------------------------- flash -->
          <div id="flash" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> flash()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  The <code>@flash</code> is a shorthand directive for <code>Res::flash</code> 
                  It is used to display a message or notification once. Every notice is defined by
                  a unique notice key which anchors the notice itself. When this key is called, the 
                  value of that key (which is the notice itself) is returned. This makes it easier to
                  display only messages or notifications only when they exist. The directive can also be used to update 
                  an already existing message or notification. 
                </div>
                <br>

                <div class="foot-note mvb-6">The example below shows how the <code>@(@flash())@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  <span class="comment no-select">&lt;?php 
    
    Res::setFlash('notice', 'Thanks');  // used in windows or controllers
  
  ?&gt;</span> 
                  </pre>

                </div>
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@flash('notice'))@ <span class="comment no-select"> // returns: Thanks</span>
                  </pre>

                </div>
                <!-- code line ended -->                
                
                <div class="foot-note">
                  The <code>@(@flash())@</code> directive can also be configured to give a different response message when an error occurs. 
                  This can be done by supplying a second argument on the directive.
                </div>
                
                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@flash('notice', 'new custom value'))@ <span class="comment no-select"> // returns: new custom value</span>
                  </pre>

                </div>
                <!-- code line ended -->                

              </div>
        
          </div>  

          
          <!------------------------------- auth -->
          <div id="auth" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> auth: auth;</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  The <code>@(@auth:)@</code> directive only displays a section of code within it when the 
                  user account is logged in or the current session is active. When the user is not 
                  logged in, the the block of code within it is never displayed. The closing directive is 
                  <code>@(@auth;)@</code>
                </div>

                <div class="foot-note pvt-4">The example below shows how the <code>@(@auth:)@</code> and <code>@(@auth;)@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@auth:)@
    Welcome <span class="comment no-select"> // show this only if user is logged in.</span>
  @(@auth;)@
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>  

          <!------------------------------- guest -->
          <div id="guest" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> guest: guest;</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  Just like the <code>@(@auth:)@</code> directive, the <code>@(@guest:)@</code> directive only displays a section of code within it when the 
                  user account is NOT logged in or the current session is NOT active. When the user is 
                  logged in, the the block of code within it is never displayed. The equivalent closing directive is 
                  <code>@(@guest;)@</code>
                </div>
                <br>

                <div class="foot-note mvb-6">The example below shows how the <code>@(@auth:)@</code> and <code>@(@auth;)@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@guest:)@
    Login <span class="comment no-select"> // show this only if user is not logged in.</span>
  @(@guest;)@
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>  

          <!------------------------------- authDirect -->
          <div id="authdirect" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> authDirect()</div>
              </div> 

              <div>

                <div class=" font-em-d9 helvetica">
                The <code>@(@authDirect())@</code> directive is used for redirecting users from a page 
                  when the session is active or user session is logged in.
                </div>
                <br>

                <div class=" mvb-6">The example below shows how the <code>@(@authDirect())@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@authDirect('home/profile'))@ <span class="comment no-select">// redirect when user is logged in</span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
        
          </div>  

          <!------------------------------- guestDirect -->
          <div id="guestdirect" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> guestDirect()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                The <code>@(@guestDirect())@</code> directive is used for redirecting users from a page 
                  when session is not active or user session is logged out.
                </div>
                <br>

                <div class=" mvb-6">The example below shows how the <code>@(@authDirect())@</code> directive can be applied in template files</div>

                <!-- code line started -->
                <div class="pre-area shadow">

                  <pre class="pre-code">
  @(@guestDirect('/'))@ <span class="comment no-select">// redirect out when user is logged out</span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
          </div>

          <!------------------------------- btn -->
          <div id="btn" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> btn()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                  The <code>@(@btn())@</code> adding attributes into buttons. When working with submit buttons, we sometimes tend to 
                  add a value for form buttons. The <code>Request</code> class requires that all html input fields and button must have 
                  a name and a value set. The <code>@btn</code> takes a single parameter and uses it to specify the name and value of a 
                  submit button. For example 
                </div>
                <br>

                
                <!-- code line started -->
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver  mvb-6">Using @(@btn)@ directive</code> </div>

                  <pre class="pre-code">
  &lt;button @(@btn('logout'))@&gt;&lt;/button&gt; <span class="comment no-select">&lt;button name="logout" value="logout"&gt;&lt;/button&gt;</span>
                  </pre>

                </div>
                <!-- code line ended -->

              </div>
          </div>

          <!------------------------------- get -->
          <div id="get" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> get</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                When forms are submitted using get request, the string data can be obtained within the template file using this directive.  
                </div>
                <br>

                
                <!-- code line started -->
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver  mvb-6">Using @(@get)@ directive</code> </div>

                  <pre class="pre-code">
  &lt;form method="get"&gt;
  
    @(@csrf)@

    &lt;input type="text" name="firstname" value="@(@get.firstname)@" &gt;
    &lt;input type="text" name="lastname" value="@(@get.lastname)@"&gt;

    &lt;button @(@btn('login'))@&gt;&lt;/button&gt; 
  &lt;/form&gt;
                  </pre>
                  
                </div>

                <div class="foot-note">
                  The value attributes above will remain empty until the form is submitted and all defined names are obtained from the <code>get</code> 
                  request. 
                </div>
                <!-- code line ended -->

              </div> 
          </div>

          <!------------------------------- post -->
          <div id="post" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> post</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                When forms are submitted using post request, the string data can be obtained within the template file using the <code>post()</code> directive.  
                </div>
                <br>

                
                <!-- code line started -->
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver  mvb-6">Using @(@post)@ directive</code> </div>

                  <pre class="pre-code">
  &lt;form method="get"&gt;
  
    @(@csrf)@

    &lt;input type="text" name="firstname" value="@(@post.firstname)@" &gt;
    &lt;input type="text" name="lastname" value="@(@post.lastname)@"&gt;
    &lt;input type="text" name="data['a']" value="@(@post.data['a'])@"&gt;

    &lt;button @(@btn('login'))@&gt;&lt;/button&gt; 
  &lt;/form&gt;
                  </pre>
                  
                </div>

                <div class="foot-note">
                  The value attributes above will remain empty until the form is submitted and all defined names are obtained from the <code>post</code> 
                  request. 
                </div>
                <!-- code line ended -->

              </div> 
          </div>

          <!------------------------------- old -->
          <div id="old" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> old</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                When forms are submitted using post request, just like the <code>@(@post)@</code> and <code>@(@get)@</code> directives, 
                the <code>@(@old)@</code> directive returns the old data submitted. This can be used as replacement for the <code>@(@get)@</code> or 
                <code>@(@post)@</code> directive.
                </div>
                <br>

                
                <!-- code line started -->
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver  mvb-6">Using @(@old)@ directive</code> </div>

                  <pre class="pre-code">
  &lt;form method="get"&gt;
  
    @(@csrf)@

    &lt;input type="text" name="firstname" value="@(@old.firstname)@" &gt;
    &lt;input type="text" name="lastname" value="@(@old.lastname)@"&gt;
    &lt;input type="text" name="data['a']" value="@(@old.data['a'])@"&gt;

    &lt;button @(@btn('login'))@&gt;&lt;/button&gt; 
  &lt;/form&gt;
                  </pre>
                  
                </div>

                <div class="foot-note mvt-6">
                  The value attributes above will remain empty until the form is submitted and all defined names are obtained from the <code>post</code> 
                  request. 
                </div>
                <!-- code line ended -->

              </div> 
          </div>

          <!------------------------------- csrf -->
          <div id="csrf" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> csrf</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                Before a form's data can be successfully obtained by the <code>Request</code> class, 
                it must contain a valid token forwarded as part of request which in turn is validated within the 
                application. The failure to generate this token, forms will not submit forwarded data. The 
                <code>@(@csrf())@</code> directives ensures that the specifically needed token field which helps to 
                prevent cross-site request forgery, is placed is within the form. Once it is added within a form, 
                then our form will be protected from cross-site request forgery
                </div>
                <br>

                
                <!-- code line started -->
                <div class="pre-area shadow">
                  <div class="pxv-10 bc-silver  mvb-6">Using @(@csrf)@ directive</code> </div>

                  <pre class="pre-code">
  &lt;form method="post"&gt;
  
    @(@csrf)@

    &lt;input type="text"&gt;
    &lt;input type="text"&gt;
    &lt;input type="text"&gt;

    &lt;button @(@btn('login'))@&gt;&lt;/button&gt; 
  &lt;/form&gt;
                  </pre>
                  
                </div>

                <div class="font-em-d8 mvt-6">
                  The <code>@(@csrf)@</code> directive above will be resolved to a hidden field with a token will will be 
                  forwarded along with submitted data. 
                </div>
                <!-- code line ended -->

              </div>
          </div>

          <!------------------------------- error -->
          <div id="error" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> error()</div>
              </div>
              
              <div>

                <div class="foot-note helvetica">
                The <code>@(@error())@</code> directive is used to pull errors on <a href="@domurl('docs/forms#managing-errors')" class="font-em-1 fb-6 hyperlink"><span class="c-olive">Forms</span></a> 
                which is returned from <code>Form::errors()</code> method.
                </div>
        
              </div> 
          </div>

          <!------------------------------- vdump -->
          <div id="vdump" class="mvt-16"> 
              <br>
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"> <i class="bi-building-up mxr-4"></i> vdump()</div>
              </div>
              
              <div>

                <div class=" font-em-d9 helvetica">
                The <code>@(@vdump())@</code> is an inbuilt directive for dumping data information of a defined or specified value.
                </div>
        
              </div> 
          </div> <br>

            <div id="conditionals" class="conditonals">

              <div class="font-em-1d5 c-orange">The Conditionals</div> <br> 
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full"><i class="bi-circle-fill mxr-6"></i> Conditionals</div>
              </div> <br>
              <div class=" font-em-d9 helvetica">
                The conditonal directives are directives that follows php conditional operators.
                They are listed below:
              </div>
              <br>
              <ul class="font-em-d9">
                <li><code>@if</code> <code>@elseif</code> and <code>@endif</code></li>
                <li><code>@for</code> </li>
                <li><code>@foreach</code> and <code>@endforeach</code> or <code>@each</code> and <code>endeach</code></li>
                <li><code>@while</code> <code>@do</code> and <code>@dowhile</code></li>
                <li><code>@switch</code> and <code>@endswitch</code>
              </ul>   
              <div class=" mvb-6">Examples of their applications</div>            
              <!-- code line started -->
              <div class="pre-area shadow">
                <!-- conditionals: if -->
                <div class="bc-blue c-white pxv-6">using if </div>
                <pre class="pre-code">
  @(@if($user == 'foo'):)@
    
      &lt;div&gt;foo&lt;/div&gt;

  @(@endif;)@ 
                </pre>

               <!-- conditionals: for -->
                <div class="bc-blue c-white pxv-6">using for</div>   
                <pre class="pre-code"> 
  @(@for($arrays as $array):)@
    
      &#123{ $array }&#125 &lt;br&gt;
      
  @(@endforeach)@; 

  <span class="comment no-select">// Note: when breaking out of foreach loops the &#64;break; directive should be applied</span>
                </pre>

                <div class="bc-blue c-white pxv-6">using foreach </div>   
                <pre class="pre-code"> 
  @(@foreach($arrays as $array):)@
    
      &#123{ $array }&#125 &lt;br&gt;
      
  @(@endforeach)@; 

  <span class="comment no-select">// Note: when breaking out of foreach loops the &#64;break; directive should be applied</span>
                </pre>
              
                <div class="bc-blue c-white pxv-6">using each - same as foreach </div>   
                <pre class="pre-code">
  &#64;each($arrays as $array):
    
      &#123{ $array }&#125 &lt;br&gt;
      
  &#64;endeach; 
                </pre>

                <!-- conditionals switch -->
                <div class="bc-blue c-white pxv-6">using switch </div>   
                <pre class="pre-code">
  @(@switch(1):)@
    
      case 1 : echo 'one';
      
  @(@endswitch)@; 

  @(@(switch($var)):)@
    
      case 'fit' : echo $var;
      
  @(@endswitch)@;    
                </pre>

              </div>
              <div class="foot-note mvs-6">
                Footnotes:
                <ul class="pxl-20 mvt-4">
                  <li>Variables can be transferred as arguments from Router function or classes</li>
                  <li>
                    Escaping directives can be done through
                    the use of <code>&#64;(directive)&#64;</code> where <code>directive</code> is the name 
                    of the specified directive. For example <code>&#64;(&#64;domurl())&#64;</code> will resolve to  
                    <code>&#64;domurl()</code> as a text rather than process it as a directive.
                  </li>
                </ul>
                
              </div>
              <!-- code line ended -->
            </div>
          </div>  

        </div> 
      
      </div>
    </section>

  </div>
  @lay('build.co.coords:footer')

@template;