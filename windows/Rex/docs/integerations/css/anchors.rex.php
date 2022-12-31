@template('docs.integerations.template.co.format')

    @title('Css Integerations - Anchors')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Anchors</div>
            <br>
            <ul class="mvt-10">
                <li><code>b-center</code> -  sets the background image to "center top" position</li>
                <li><code>b-fluid</code> - auto fits background images based on screen size.</li>
                <li><code>b-parallax</code> - gives a parallax effect on images</li>
                <li><code>b-clip</code> - sets background-clip property to "padding-box"</li>
                <li><code>im-fixed</code> - sets background-attachment property to "fixed"</li>
            </ul>
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-center" data-src="@images('bkg.jpg')"></div>
            b-center
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-cover" data-src="@images('bkg.jpg')"></div>
            b-cover
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-cover" data-src="@images('bkg.jpg')"></div>
            b-cover
        </div><br><br>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-contain" data-src="@images('bkg.jpg')"></div>
            b-contain
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-parallax" data-src="@images('bkg.jpg')"></div>
            b-parallax
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-fluid" data-src="@images('bkg.jpg')"></div>
            b-fluid
        </div><br><br>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d b-cover b-clip" data-src="@images('bkg.jpg')"></div>
            b-cover b-clip
        </div>

        <div class="box pxv-10 bc-silver font-em-d85">
            <div class="px-200 bc-silver-d im-fixed" data-src="@images('bkg.jpg')"></div>
            im-fixed
        </div><br><br>

    </div> <br>

@template;