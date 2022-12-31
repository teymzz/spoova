@template('template.t-tut')

    @title('Css Integerations')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    
    @lay('build.co.navbars:left-nav')

    <section class="tutorial">

        <div class="pxs-12"> <br>

            <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
                <a href="@domurl('docs/other-features/javascript')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Js</div></a>
                <div class="c-orange-dd">integerations</div>
            </div><br>

            <span class="font-em-d9">
                Jquery is still one of the most widely used javascript library around the the globe because it still has a lot of functionalites 
                that simplifies javascript development. Spoova has its own helper function but also has some helper plugins that can aid development 
                and a good number of these plugin depend on Jquery library. This is because the external library lessens the number of line required to 
                write a code. Some of these functions or plugins are listed below: <br> <br>

                <ul class="mvt-6 c-olive">
                    <li>
                        <a href="@route('::core-functions')">Helper functions</a>
                    </li>
                    <li><a href="@route('::loadFile').js">loadFile Plugin</a></li>
                    <li><a href="@route('::formvalidator')">formValidator</a></li>
                    <li><a href="@route('::device').js">device.js</a></li>
                    <li><a href="@route('::switcher').js">Switcher.js</a></li>
                </ul> 

            </span>
        </div><br>

        <!-- \\
        .--theme-dark > * {
           --white-dd: 11, 10, 28;
           --white:  21, 15, 39;
           --black-ll: 179, 179, 179;        
        }
        -->
    </section>



@template;