
@template('template.t-tut')


    @lay('build.co.navbars:left-nav')


    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8" >
                    
                    
                    @lay('build.co.links:tutor_pointer') <br>
                    <div class="font-em-1d5 c-orange">Resource - Flashes</div> <br>
                
                    <div class="intro">
                        <div class=" font-em-1">
                            Flashes are notifications or messages that are displayed once in the application. 
                            Notifications are handled by the Notice class. However, Notice class can also be called on the
                            Resource class. This makes it easier to set up or display flash messages. The three (3) main methods 
                            of the Notice class are <code>setFlash</code> <code>Flash</code> and <code>hasFlash</code>.
                            The following are ways by which the flash can be applied to web applications.
                            <br><br>

                            <div class="box-full  font-em-d85 bc-white-dd flow-x">
    <pre class="pre-code">
  $name = 'Foo';
  
  if($name == 'Foo') {
  
      Res::setFlash('notice', 'I found a Foo');
  
  }
  
  if( Res::hasFlash('notice') ) {
  
      print Res::flash('notice');
  
  }
    </pre>
                            </div>
                        </div> 
                    </div> 

                    <div class="font-em-d87 mvt-10">
                        The illustration above is a sample of how to set up flash messages. The flash message are set with a specific key name 
                        having its corresponding value using the <code>setFlash()</code> method. The existence 
                        of a flash (key) can also be tested by using the <code>hasFlash()</code> method while 
                        <code>Res::flash()</code> returns the value of a specified key.
                    </div> <br>
                                    
                    <div class="">
                        <div class="fb-6">Flash in Template files</div>
                        <div class="font-em-d87 mvt-10">
                            When flash messages are set using the <code>Res::setFlash()</code> method, the flash can 
                            be imported using the <code>@(flash())@</code> directive in template files to call the flash key 
                            name. The flash will only be displayed once it exists.
                        </div> 
                    </div> <br>

                </div>
            </div>
        </section>
    </div>

    @lay('build.co.coords:footer')

@template;