@template('template.t-doc')

    @lay('build.coords:header')
    
    
      <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Directives</div> <br>  
        
        <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                Helper directives are predefined template directives that are used within 
                template files. These directives are preceeded by an <code>@</code> symbol. 
                They are listed below:
                <br><br>
                
                <li><a href="#meta">@meta</a></li>
                <li><a href="#res">@Res</a></li>
                <li><a href="#import">@import</a></li>
                <li><a href="#live">@live</a></li>
                <li><a href="#domurl">@domurl</a></li>
                <li><a href="#assets">@assets</a></li>
                <li><a href="#mapp">@mapp</a></li>
                <li><a href="#mass">@mass</a></li>
                <li><a href="#images">@images</a></li>
                <li><a href="#include">@(include)@</a></li>
                <li><a href="#template">@template</a></li>
                <li><a href="#layout">@layout</a></li>
                <li><a href="#flash">@flash</a></li>
                <li><a href="#auth">@(auth:)@</a></li>
                <li><a href="#guest">@(guest:)@</a></li>
                <li><a href="#authdirect">@authdirect</a></li>
                <li><a href="#guestdirect">@guestdirect</a></li> <br>
                <li class="conditionals" style="list-style: none">
                  Conditonals
                  <ul class="list-square">
                    <li><a href="#conditionals">@if</a></li>
                    <li><a href="#conditionals">@for</a></li>
                    <li><a href="#conditionals">@foreach (or @each)</a></li>
                    <li><a href="#conditionals">@do</a></li>
                    <li><a href="#conditionals">@while</a></li>
                    <li><a href="#conditionals">@switch</a></li>
                    <li><a href="#conditionals">@break</a></li>
                  </ul>
                </li>
                
            </div> 
        </div>
         
        <div id="meta" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">1. @meta</div>
            </div> <br>
            
            <div>
              This directive is used to load meta tags that are set by default within the 
              <code>$_ENV</code> variable. It takes the parameter <code>dump</code> or 
              <code>drop</code> which is one of its methods. BY defining <code>dump</code>, 
              it dumps all the default meta tag that was set with the help of the <code>Meta</code> class.
              Before this tag can work successfully, the default meta tags must have been properly configured
              in the <code>icore/filemeta</code> file. You can learn how to set up meta tags using <code>Meta</code> 
              class from <a href="@DomUrl('tutorials/classes/meta')">here</a>.
              
              <br><br>
              <div class="font-menu mvb-6">The example below shows how the meta 
              directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span>
    @(meta('dump'))@  
  <span class="comment">&lt;/head&gt;</span> 
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

         
        <!---------------------------- res -->
        <div id="res" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">2. @(res)@</div>
            </div> <br>
            
            <div>
              The <code>@Res</code> directive is a bit different from other directives. It has two 
              different modes of application which resolves into different responses. <br> <br>
              <ul>
                <li>@(Res::import())@</li>
                <li>@(Res())@</li>
              </ul> 
              
              The <code>@(Res::import)@</code> works similarly as the <code>Res::import</code> function 
              while the <code>@(Res())@</code> is used to resolve static files. 

              <div class="font-menu mvb-6">The example below shows how the <code>@(Res())@</code> 
              directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    @(Res('res/file.css'))@ <span class="comment"> &lt;script src="http://localhost/spoova/res/file.css"&gt;&lt;/script&gt;</span>

    @(Res('file.js'))@ <span class="comment"> &lt;link href="http://localhost/spoova/file.js" rel="stylesheet" type="text/css"/&gt; </span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 
        
        <!-------------------------------- import -->
        <div id="import" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">3. @import</div>
            </div> <br>
            
            <div>
              The <code>@import</code> directive is similar to the <code>Res::import()</code> 
              function. It is specifically being used to import two things: <br>

              <ul>
                <li>static resources group <code>@(import(':group'))@</code></li>
                <li>live server <code>@(import('::watch'))@</code></li>
              </ul>
              
              <div class="font-menu mvb-6">The example below shows how the import 
              directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span>
    @(import(':header'))@  
    @(import('::watch'))@  
  <span class="comment">&lt;/head&gt;</span> 
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

        <!---------------------------------- live -->
        <div id="live" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">4. @live</div>
            </div> <br>
            
            <div>
              The <code>@live</code> directive is the shorthand directive for <code>@(Res::import('::watch'))@</code> 
              function. It is specifically being used to import the live server into a specific template engine if 
              switched off by default. 
            </div>
      
        </div>  
         
        <!--------------------------------- domurl -->
        <div id="domurl" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">5. @(domurl)@</div>
            </div> <br>
            
            <div>
              Just like the domurl function, <code>@domurl</code> is being used to resolve 
              local urls into http protocol urls. Within the spoova framework, developers should 
              use the <code>domurl</code> when linking static files as it properly maps the local url
              supplied. This creates a handshake between : <br> <br>
              <ul>
                <li>offline - online projects</li>
                <li>desktop - mobile device developments</li>
              </ul> 
              
              <div class="font-menu mvb-6">The example below shows how the import 
              directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
  <span class="comment">&lt;head&gt;</span>
    &lt;a href="@(domurl('res/images/myimage.jpg'))@"&gt; myimage &lt;/a&gt;   

    &lt;link href="@(domurl('https://site.com/assets/css/site.css'))@" /&gt; 
  <span class="comment">&lt;/head&gt;</span> 
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 


        <!------------------------------- assets -->
        <div id="assets" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">6. @(assets)@</div>
            </div> <br>
            
            <div>
              The <code>@assets</code> directive is a shorthand directive that loads static files directly from the  
              assets folder which is a subdirectory of the <code>res/</code> folder. This directive can also be applied 
              to load grouped static files just like the <code>@(Res())@</code> method.
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area">
<div class="pxv-10 bc-off-white">Example 1</div>
  <pre class="pre-code">
    @(assets('css/file.css'))@ <span class="comment no-select">// &lt;link href=":domainurl/res/assets/css/file.css"/&gt;</span>
  </pre>
<div class="pxv-10 bc-off-white">Example 2</div>
  <pre class="pre-code">
    @(assets(':headers'))@ <span class="comment no-select">// include grouped static files (headers) </span>
  </pre>
</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 

        <!------------------------------- mapp -->
        <div id="mapp" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">7. @(mapp)@</div>
            </div> <br>
            
            <div>
              The <code>@mapp</code> directive is a shorthand directive that returns files url using 
              static resources main folder (i.e res/main) as its base path
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    &lt;img src="@(mapp('images/image.jpg'))@"&gt; <span class="comment no-select">// &lt;img src=":domainurl/res/main/images/image.jpg"/&gt;</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 

        <!------------------------------- mapp -->
        <div id="mass" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">8. @(mass)@</div>
            </div> <br>
            
            <div>
              The <code>@mass</code> directive is a shorthand directive that returns files url using 
              static resources main folder (i.e res/assets) as its base path
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    &lt;img src="@(mass('images/image.jpg'))@"&gt; <span class="comment no-select">// &lt;img src=":domainurl/res/assets/images/image.jpg"/&gt;</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 
         
        <!-------------------------------- images -->
        <div id="images" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">9. @(images)@</div>
            </div> <br>
            
            <div>
              The <code>@images</code> is a shorthand directive that loads images directly from the  
              images folder which is a subdirectory of the <code>res/assets/</code> folder. When it is used, 
              images from this folder will be loaded into the webpage if exists. Subdirectories of that folder 
              can also be applied.
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    &lt;img src="@(images('myimage.jpg'))@"&gt; <span class="comment no-select">// &lt;img src="/res/assets/images/image.jpg"/&gt;</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 
         
        <!---------------------------------- include -->
        <div id="include" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">10. @(include)@</div>
            </div> <br>
            
            <div>
              The <code>@(include())@</code> is a shorthand directive for php internal <code>include</code> function. Any file 
              included should only follow the document root. For example, if a file <code>file.php</code> exists within the project root,
              then including that file will be as follows:
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    @(include('file.php'))@ <span class="comment no-select">// include "file.php" from the document root.</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div> 
         
        <!-------------------------------- template -->
        <div id="template" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">11. @(template())@</div>
            </div> <br>
            
            <div>
              The <code>@(template())@</code> function is used to load templates into another template file. A template 
              is more like a layout structure of how a page should look like. When such template has been successfully created, 
              a specific part of the layout can be allocated for external structure to fill up using the <code>@(yield())@</code>
              directive. This is explained by using file1.rex.php and file2.rex.php below as examples.
              <br><br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(template)@</code> and <code>@(yield)@</code> directives can be applied in template files</div>

              <div class="font-menu mvb-6">file1.rex.php</div>

<!-- code line started -->
<div class="pre-area"> <br><br>
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

              <div class="font-menu mvb-6">file2.rex.php</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    <span class="comment no-select">// include "file.php" from the document root.</span>
    @(template('file1.rex.php')):@
    
      This is a content from file2.rex.php

    @(template;)@
  </pre>

</div> <br><br>
<!-- code line ended -->

              <div class="font-menu mvb-6">file2.rex.php will be resolve to </div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    <span class="comment no-select">// include "file.php" from the document root.</span>
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


          <div class="font-menu mvb-6">Note: when building template files, 
            the template files should be separated from the real contents. 
            It is advisable that the real content may be located within the
            template engine <code>rex</code> folder directory while the template 
            files may be in a subdirectory for proper file organization.
          </div> 

        </div> <br>
         
        <!------------------------------- layout -->
        <div id="layout" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">12. @(layout())@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
                The <code>@(layout())@</code> function is similiar to the <code>@(template())@</code> directive.
                While <code>@(template)@</code> loads a full layout from a file, the <code>@(layout)@</code> directive picks a 
                layout from a group of layouts within a file. When grouping layouts, it is not advisable to put all eggs 
                in one basket as they will break. Layout files are only used to group files of similar functionalities together.
                For example, a <b>footer</b>  and <b>header</b> content can be grouped together in one single layout file, each separated with its own layout id.
                When importing or picking a layout from a layout file, the id can then be called and only the specific layout relative to that id 
                will be returned.
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(layout)@</code> and <code>@(lay)@</code> directives can be applied in template files</div>

              <div class="font-menu mvb-6">lay.rex.php</div>

<!-- code line started -->
<div class="pre-area"> <br><br>
  <pre class="pre-code">
    <?= to_lgts(
      '
      @(layout:header)@
        <header> This is my page header </header> 
      @(layout;)@  


      @(layout:footer)@
        <header> This is my page footer </header> 
      @(layout;)@        
      '
    );
    ?>
  </pre>
</div>
<!-- code line ended -->

            </div> <br>

            <div class="font-menu mvb-6">page.rex.php</div>

<!-- code line started -->
<div class="pre-area"> <br><br>
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

        @(lay(\'lay:header\'))@ 

      ').'
        <span class="comment no-select">// other contents here...</span>
      '.to_lgts('

        @(lay(\'lay:footer\'))@ 
        
      </body>
      </html>
      '
    );
  ?>
  </pre>
</div> <br><br>
<!-- code line ended -->

              <div class="font-menu mvb-6">page.rex.php will be resolve to </div>

<!-- code line started -->
<div class="pre-area"> <br><br>

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

          <div class="font-menu mvb-6"> 
            <div class="pvs-8">Note: In the above,</div>
           <code>@(lay)@</code> is the directive for importing layouts <br>
           <code>lay</code> is the file name (or file path if within subdirectory) <br>
           <code>:</code> column is used to denote the id while
           <code>footer</code> or <code>header</code> is the id name without special characters.
          </div> 

        </div>

         
        <!------------------------------- flash -->
        <div id="flash" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">13. @(flash)@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
                The <code>@flash</code> is a shorthand directive for <code>Res::flash</code> 
                It is used to display a message or notification once. Every notice is defined by
                a unique notice key which anchors the notice itself. When this key is called, the 
                value of that key (which is the notice itself) is returned. This makes it easier to
                display only messages or notifications only when they exist. The directive can also be used to update 
                an already existing message or notification. 
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(flash())@</code> directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br>

  <pre class="pre-code">
   <span class="comment no-select">
   &lt;?php 
     
    Res::setFlash('notice', 'Thanks');  // used in windows or controllers
   
   ?&gt;</span> 

   @(flash('notice'))@ <span class="comment no-select"> // returns: Thanks</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

         
        <!------------------------------- auth -->
        <div id="auth" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">14. @(auth)@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
                The <code>@(auth:)@</code> directive only displays a section of code within it when the 
                user account is logged in or the current session is active. When the user is not 
                logged in, the the block of code within it is never displayed. The closing directive is 
                <code>@(auth;)@</code>
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(auth:)@</code> and <code>@(auth;)@</code> directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br>

  <pre class="pre-code">
    @(auth:)@
      Welcome <span class="comment no-select"> // show this only if user is logged in.</span>
    @(auth;)@
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

        <!------------------------------- guest -->
        <div id="guest" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">15. @(guest)@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
                Just like the <code>@(auth:)@</code> directive, the <code>@(guest:)@</code> directive only displays a section of code within it when the 
                user account is NOT logged in or the current session is NOT active. When the user is 
                logged in, the the block of code within it is never displayed. The equivalent closing directive is 
                <code>@(guest;)@</code>
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(auth:)@</code> and <code>@(auth;)@</code> directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br>

  <pre class="pre-code">
    @(guest:)@
      Login <span class="comment no-select"> // show this only if user is not logged in.</span>
    @(guest;)@
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

        <!------------------------------- authDirect -->
        <div id="authdirect" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">16. @(authDirect)@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
               The <code>@(authDirect())@</code> directive is used for redirecting users from a page 
                when the session is active or user session is logged in.
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(authDirect())@</code> directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    @(authDirect('home/profile'))@ <span class="comment no-select">// redirect when user is logged in</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>
      
        </div>  

        <!------------------------------- guestDirect -->
        <div id="guestdirect" class=""> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">17. @(guestDirect)@</div>
            </div> <br>
            
            <div>

              <div class="font-menu font-em-d99 helvetica">
               The <code>@(guestDirect())@</code> directive is used for redirecting users from a page 
                when session is not active or user session is logged out.
              </div>
              <br>

              <div class="font-menu mvb-6">The example below shows how the <code>@(authDirect())@</code> directive can be applied in template files</div>

<!-- code line started -->
<div class="pre-area"> <br><br>

  <pre class="pre-code">
    @(guestDirect('/'))@ <span class="comment no-select">// redirect when user is logged out</span>
  </pre>

</div>
<!-- code line ended -->

            </div> <br>

          <div id="conditionals" class="conditonals">

            <div class="font-em-1d5 c-orange">The Conditionals</div> <br> 
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full">18. Conditionals</div>
            </div> <br>
            <div class="font-menu font-em-d99 helvetica">
              The conditonal directives are directives that follows php conditional operators.
              They are listed below:
            </div>
            <br>
            <ul>
              <li><code>@if</code> <code>@elseif</code> and <code>@endif</code></li>
              <li><code>@for</code> </li>
              <li><code>@foreach</code> and <code>@endforeach</code> or <code>@each</code> and <code>endeach</code></li>
              <li><code>@while</code> <code>@do</code> and <code>@dowhile</code></li>
              <li><code>@switch</code> and <code>@endswitch</code>
            </ul>   
            <div class="font-menu mvb-6">Examples of their applications</div>            
<!-- code line started -->
<div class="pre-area">
  
  <pre class="pre-code">
    <div class="bc-blue c-white pxv-6">using if </div>
    @(if($user == 'foo'):)@
      
        &lt;div&gt;foo&lt;/div&gt;

    @(endif;)@ 
  </pre>

  <pre class="pre-code"> 
    <div class="bc-blue c-white pxv-6">using for </div>   
    @(for($arrays as $array):)@
      
        &#123{ $array }&#125 &lt;br&gt;
        
    @(endforeach)@; 

    <span class="comment no-select">// Note: when breaking out of foreach loops the &#64;break; directive should be applied</span>
  </pre>

  <pre class="pre-code"> 
    <div class="bc-blue c-white pxv-6">using foreach </div>   
    @(foreach($arrays as $array):)@
      
        &#123{ $array }&#125 &lt;br&gt;
        
    @(endforeach)@; 

    <span class="comment no-select">// Note: when breaking out of foreach loops the &#64;break; directive should be applied</span>
  </pre>
 
  <pre class="pre-code">
    <div class="bc-blue c-white pxv-6">using each - same as foreach </div>   
    &#64;each($arrays as $array):
      
        &#123{ $array }&#125 &lt;br&gt;
        
    &#64;endeach; 
  </pre>

  <pre class="pre-code">
    <div class="bc-blue c-white pxv-6">using switch </div>   
    @(switch(1):)@
      
        case 1 : echo 'one';
        
    @(endswitch)@; 

    @((switch($var)):)@
      
        case 'fit' : echo $var;
        
    @(endswitch)@;    
  </pre>

</div>
<div class="font-menu mvs-6">
  Footnotes:
  <ul class="pxl-20 mvt-4">
    <li>Variables can be transferred as arguments from Router function or classes</li>
    <li>
      Escaping directives can be done through
      the use of <code>&#64;(directive)&#64;</code> where <code>directive</code> is the name 
      of the specified directive. For example <code>&#64;(domurl())&#64;</code> will resolve to  
      <code>&#64;domurl()</code> as a text rather than process it as a directive.
    </li>
  </ul>
  
</div>
<!-- code line ended -->
          </div>
        </div>  

      </div> 
    
    @lay('build.coords:footer')


@template;