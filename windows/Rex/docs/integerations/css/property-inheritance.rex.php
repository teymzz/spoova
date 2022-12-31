@template('docs.integerations.template.co.format')

    @title('Css Integerations - Anchors')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Property Inheritance</div>
            <div class="">
                There are certain utility classes that can be used to inherit other 
                properties from their parent elements. These properties mostly end with the <code>-i</code>
                directive.
            </div>
            <br>
            <ul class="mvt-10">
                <li><code>c-i</code> -  inherit color from parent element (mostly used for links)</li>
                <li><code>bd-i</code> - inherit parent border </li>
                <li><code>bdh-i</code> - inherit parent border on hover</li>
                <li><code>oc-i</code> - inherit parent outline with color</li>
                <li><code>och-i</code> - inherit parent outline color on hover</li>
                <li><code>oc-ch</code> - inherit parent color for outline color on hover</li>
                <li><code>d-i</code> - inherit parent display property</li>
                <li><code>f-i</code> - inherit parent font size property</li>
                <li><code>h-i</code> - inherit parent height property</li>
                <li><code>padd-i</code> - inherit parent padding property</li>
                <li><code>wid-i</code> - inherit parent width property</li>
            </ul>
        </div>

        

    </div> <br>

@template;