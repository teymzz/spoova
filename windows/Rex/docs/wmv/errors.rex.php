@template('template.t-tut')

    @title('WMV - Errors')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Modifying WMV Errors Pages</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Although, the shutters handle the most of the errors pages that are displayed on the screen using a default 
                            error page. The default error page can be modified either through the redefining of the default error page 
                            or by declaring an entirely different error page within the <code>shutter</code> methods. 
                        </div> 
                    </div> <br>

                    <div class="">

                        <div class="c-olive fb-6">Updating Default Error Page</div>

                        <div class="mvt-10">
                            The default error pages can be updated by creating a new template file within the directory of the <code>rex</code> 
                            template folder with a new name <code>404.rex.php</code>. This file will be placed directly into the <code>rex/errors</code> 
                            directory. Once this is done, then the <code>404.rex.php</code> file will automatically replace the default one. 
                        </div>

                    </div> <br>

                    <div class="">

                        <div class="c-olive fb-6">Updating From Shutter Methods</div>

                        <div class="mvt-10">
                           The shutter methods are configured to update the default error page only once on its acceptable urls. This can be achieved by 
                           supplying the <code>::404</code> template error key as one of the urls within the acceptable urls. The corresponding method 
                           will then be called by the shutter if any error exists rather than call the default error page. The code below reveals how to 
                           achieve this: 
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',

            '::404' => 'error404()',

        ])

    }

    function error404() {

        self::load('errors/error-template.rex.php', fn() => compile() );

    }

  }

</pre>
                        </div>

                        <div class="mvt-10 font-em-d8">
                            In the image above, the <code>::404</code>, that is, <code>error404()</code> method will be triggered 
                            if the url <code>home/user</code> does not exist. 
                        </div>

                    </div>

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;