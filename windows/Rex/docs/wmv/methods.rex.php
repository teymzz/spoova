@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Window methods</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                        The Window class contains a list of predefined reserved methods which are listed below
                        </div> 
                    </div>
                    
                    <ul>
                        <li>wvm</li>
                        <li>open</li>
                        <li>mapurl</li>
                        <li>rootcall</li>
                        <li>call</li>
                        <li>basecall</li>
                        <li>pathcall</li>
                        <li>resolved</li>
                        <li>pend</li>
                        <li>close</li>
                        <li>eview</li>
                        <li>load</li>
                        <li>markup</li>
                        <li>loadBase</li>
                        <li>secure</li>
                        <li>sleep</li> <br>
                        <li style="list-style: square;">
                            <b>Inherited Methods (Controller)</b> <br>
                            <ul class="pxs-1 list-disc">
                                <li>setLayout</li>
                                <li>usesLayout</li>
                                <li>addRoutes</li>
                                <li>getRoutes</li>
                                <li>loadRoutes</li>
                            </ul>
                        </li>
                        
                    </ul>

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
      
    @lay('build.co.coords:footer')
    
@template;