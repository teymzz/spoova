

@template('template.t-doc')

@lay('build.coords:header')
<style>
    
    ul > li > a{
        color:inherit;
    }   

    ul > li > a:hover{
        color:inherit;
    }   

    ul > li a:hover{
       color: var(--orange-dd);
       cursor:pointer;
    }

    .olist {
        font-family: calibri;
        color: burlywood;
    }
</style>

<div class="pxv-20 c-black-ll">
    
    @lay('build.links:tutor_pointer')

    <div class="font-em-1d5 c-orange">Routing</div> <br>
    
    <div class="routing-files">
        <div class="fb-6">Routing files</div> <br>
        <div class="">
            Routes are registered through multiple ways using either MVC or WMV approach.
            The <code>model-view-controller</code> is a common approach for routing files using ports.
            However, WMV <code>windows-model-view</code> approach was introduced to surpass the MVC.
            Both MVC and WMV is supported by this framework.
            The WMV was introduced
        </div> 
    </div> <br>

    <div class="routing-files">
        <div class="fb-6">What is WMV ?</div> <br>
        <div class="font-menu font-em-1">
            The <code>windows-model-view</code> is an architectural pattern built on mvc framework. 
            It works in a similar manner to building a real house with its several windows. 
            <code>wmv</code> also has a window. Consider a <code>wmv</code> project as a house with its 
            different window, window frames and entry points. A window cannot naturally exist unless it is given
            its own space. WMV does not depend on files but window files. Similarly to a house, a window enables us
            to have a view and what we see are the models outside that view which are objects visible to our sight.
            A view cannot occur if there is nothing to be seen. This means that an object must be able to reflect a light.
            Without a light, then there is no view at all. Hence, wmv is a pattern that follows a window format. A better example
            is our eyes. When the eyes is opened, a light must be reflected on objects to be seen, else there will be total darkness.
            The light itself is an object (model) that makes view possible. So, under wmv, the model comes first before view. <br>
            <br>
            Since model comes first, our model classes must be built first, then lastly rendered as a view.
            as view will only show existing models rather than non-existing ones.
        </div> 
    </div> <br>

    <div class="wmv-routing">
        <div class="fb-6">Routing - Template Engines (mvc)</div>
        <div class="font-menu font-em-1">
            Routing involves the use of template engines. Spoova uses the rex template engines
            to render its rex template files. Rex template files are placed within the rex folder.
            This is the location where all php resource (rex) template files are loaded from. The template files
            are loaded through the use of <code>Res::load()</code> class which means "load resource". It is very
            easy to load template files and we will be examining few examples.
        </div> <br>
        
        <div class="">Example 1 : Functions</div>
        <div class="mox-full font-menu bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
  &lt;?php
    
    <span class="comment no-select">1.</span> include_once 'icore/filebase.php';
    <span class="comment no-select">2.</span>
    <span class="comment no-select">3.</span> Res::load('index', function(){ return "me"; });
    <span class="comment no-select">4.</span>
    <span class="comment no-select">5.</span> Res::load('index', fn => "me" );
    <span class="comment no-select">6.</span>
    <span class="comment no-select">7.</span> Res::load('index', fn => compile() );
    <span class="comment no-select">8.</span> 
    <span class="comment no-select">9.</span> Res::load('index', fn => view() );
    
  ?&gt;
    </pre>
        </div> <br><br>

         <div class="font-menu">
            In example above : 

            <br><br> line 1 connects to the spoova base controller class

            <br><br> line 3 & 4 are both used to print into the rex index file. This means that <code>index.rex.php</code> must
            exist within the rex folder for the word "me" to be printed out successfully on the page.
            
            <br><br> In line 7, the <code>compile()</code> method is used as a directive for rendering the contents of the loaded 
            <code>index</code> file. A file will not be rendered unless the compile method is declared upon it.
            
            <br><br> In line 9, the <code>view()</code> method is used as a directive for rendering the contents of a supplied 
            template file into the index file. 

            <br><br> 
            <span class="fb-6">Note:</span> Each of the compiler methods i.e <code>view()</code> and <code>compile()</code> can be applied within classes. 
            
            <br><br>
            <span class="fb-6">Note:</span> The <code>icore/filebase.php</code> file should be included or accessible on all project files.
        </div> <br>      

        <!-- Handling Classes -->
        
        <div class="">Example 2 : Classes </div>        
        <div class="mox-full font-menu bc-white-dd flow-x">
    <pre class="pre-code">
  &lt;?php
    
    <span class="comment no-select">1.</span> include_once 'icore/filebase.php';
    <span class="comment no-select">2.</span>
    <span class="comment no-select">3.</span> use spoova\windows;
    <span class="comment no-select">4.</span> 
    <span class="comment no-select">5.</span> Res::load('index', [App::class, 'index']);
    <span class="comment no-select">6.</span>

  ?&gt;
    </pre>
        </div> <br><br>

        <div class="font-menu">
            In example 2 above : 

            <br><br> We supplied a class using an array. The <code>App</code> class will be loaded from the <code>spoova\windows</code>
            directory and the <code>index</code> method will be called from that <code>App</code> class
            
            
        </div> <br> 
    
    <div class="">
        <div class="fb-6">Markup</div>
        <div class="">
            
            The <code>markup()</code> method is similar to the the <code>load</code> 
            method except that it prevents the <code>compile()</code> function from 
            automactically displaying the content rendered. Instead, it returns the data 
            compiled. Example is shown below:

            <br><br>

            <div class="">Example 3 : Markup </div>        
        <div class="mox-full font-menu bc-white-dd flow-x">
    <pre class="pre-code">
  &lt;?php
    
    <span class="comment no-select">1.</span> include_once 'icore/filebase.php';
    <span class="comment no-select">2.</span>
    <span class="comment no-select">3.</span> use spoova\windows;
    <span class="comment no-select">4.</span> 
    <span class="comment no-select">5.</span> $compiled = Res::markup('index', [App::class, 'index']);
    <span class="comment no-select">6.</span> print $compiled;

  ?&gt;
    </pre>
        </div> <br><br> 
        <div class="font-menu">The <code>markup</code> method above will return the compiled data.</div>
        </div> 
    </div> <br>

    <div class="learn-more">
        <div class="fb-6">More on MVC and WMV</div>
        <div class="">
            Learn more on <code>mvc</code> and <code>wmv</code> from here

            <br><br>

            <div class="pxs-10">
                <ul class="olist list-square">
                    <li> <a href="@DomUrl('tutorial/routings/mvc')">MVC</a>  </li>
                    <li> <a href="@DomUrl('tutorial/routings/wmv')">WMV</a> </li>
                </ul>                 
            </div>   

        </div> 
    </div> <br>

</div>

@template;