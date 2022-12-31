@template('template.t-tut')

    @title('Css Integerations')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <!-- @res('res/assets/css/index.css')  -->
    
    @lay('build.co.navbars:left-nav')
    <div class="box-full i-trans bc-white">
        <section class="tutorial">
            
            <div class="pxs-12"> <br>
    
                <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
                    <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
                    <div class="c-orange-dd">utility classes</div>
                </div><br>
    
                <span class="font-em-d9">
                    Spoova was built on the top of a light local css library while bootstrap mdb5 is its favored external css library.
                    The local css contains some special utility classes for setting background colors, font and font sizes, display types, 
                    form inputs and form alignments. It also contains some core design utility classes which the framework itself uses for  
                    error debugging. This means that local css library should be accessible for the entire framework to respond appropriately. The css classes are 
                    grouped under the following headings <br><br>
    
                    <ul class="c-olive">
                        <li><a href="@route('::display-properties')">Display Classes</a></li>
                        <li><a href="@route('::widths-and-heights')">Width and Heights</a></li>
                        <li><a href="@route('::responsive-paddings')">Responsive paddings</a></li>
                        <li><a href="@route('::margins')">Setting Margins</a></li>
                        <li><a href="@route('::fluid-boxes')">Fluid Boxes</a></li>
                        <li><a href="@route('::images-and-thumbnails')">Images and Thumbails</a></li>
                        <li><a href="@route('::overlay-items')">Overlay items</a></li>
                        <li><a href="@route('::overflow-items')">Overflow items</a></li>
                        <li><a href="@route('::text-alignments')">Text Alignments</a></li>
                        <li><a href="@route('::fonts')">Fonts and Font Sizes</a></li>
                        <li><a href="@route('::colors')">Setting element Colors</a></li>
                        <li><a href="@route('::anchors')">Anchor Buttons</a></li>
                        <li><a href="@route('::property-inheritance')">Property Inheritance</a></li>
                        <li><a href="@route('::forms-and-alignment')">Forms and Form Alignment</a></li>
                        <li><a href="@route('::borders')">Borders and Border Radius</a></li>
                        <li><a href="@route('::menu-burger')">Menu Burger</a></li>
                    </ul>
    
                </span>
            </div><br>
    
            
        </section>
    </div>



@template;