
@template('template.t-tut')

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Device.js</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                    The <code>isMobile()</code> function is used to detect a device based on screen size, touchscreen and media queries.
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Detect Device</div>
                    By calling the <code>isMobile()</code> function, it returns true on mobile devices and false on desktop devices. However, this response
                    may not be entirely true on all devices as there are wide ranges of mobile devices across the globe.
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Touchscreen</div>
                    Mobile devices are commonly known to have a touchsreen feature, while most desktops have larger screen sizes. The 
                    <code>isMobile('touch')</code> function returns true if the device is mobile and also has a touchscreen.<br>
                </div> <br>

                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Screen Sizes</div>
                    It is a commonly known feature that mobile devices usually have smaller screen sizes while desktops have 
                    larger screen sizes. The code <code>isMobile('media')</code> uses css media queries to detect the device screen size. This 
                    will return true only on mobile screen size at maximum width of <code>1000px</code>. The <code>media</code> option can also be replaced 
                    with a valid integer.
                </div> <br>
                
                <div class="">
                    <div class="font-em-1 c-orange"><span class="bi-circle-fill c-silver-d mxr-6"></span>Media Queries: Max & Min</div>
                    The <code>max()</code> or <code>min()</code> option can be supplied as argument to check screen size using media queries. These options take a valid 
                    integer as argument. For example, the code <code>isMobile('min(100em)')</code> checks if the current screen size matches a minimum of <code>100em</code>.  
                </div>
            </div>
        </div>
    </section>
</div>
@template;