
@template('template.t-doc')

    @lay('build.coords:header')

    <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Resource - Flashes</div> <br>

        <div class="resource-intro">
            <div class="fb-6">Introduction</div> <br>
            <div class="">
                Flashes are notifications or messages that are displayed once in the application. 
                Notifications are handled by the Notice class. However, Notice class can also be called on the
                Resource class. This makes it easier to set up or display flash messages. The three (3) main methods 
                of the Notice class are <code>setFlash</code> <code>Flash</code> and <code>hasFlash</code>
                The following are ways by which the flash can be applied to web applications.
                <br><br>
                

                <div class="mox-full font-menu font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $name = 'Foo';

    if($name == 'Foo') {

        Res::setFlash('notice', 'I found a Foo');

    }

    if( Res::hasFlash('notice') ) {

        print Res::flash('notice');

    }
    </pre>
                </div> <br>
            </div> 

            <div class="font-menu">
                The examples above are self explanatory. Flashes are set with a specific key name 
                having its corresponding value using the <code>setFlash()</code> method. The existence 
                of a flash (key) can also be tested by using the <code>hasFlash()</code> method while 
                <code>Res::flash()</code> returns the value of a specified key.
            </div>
        </div> <br>

    </div>

    @lay('build.coords:footer')

@template;