@template('docs.integerations.template.co.format')

    @meta('dump')
    @title('Css Integerations - Colors')
    @res('res/main/js/timeToggle.js')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    @live 

    <x-attr:anime-btn class="in-flex-btn rad-r bc bc-purple bh-purple-dd oc-purple oc-1 oh-4 oo-5 ooh-7 c-white pxv-10 mxv-20" style="box-shadow: 0 0 0 10px rgb(var(--silver-d)), 0 0 0 14px purple;"/>
    
    <div class="padd-x-4 box-full"> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-orange-dd font-em-1d7">COLORS</div>
            Colors vary from bright to dull colors. While we have primary and secondary colors, there are even 
            more advanced color shades that are discovered through different color mixtures. The basic colors are the 
            primary colors which are 
            <code><span class="bi-circle-fill c-red"></span> Red</code> 
            <code><span class="bi-circle-fill c-blue"></span> Blue</code> and 
            <code><span class="bi-circle-fill c-green"></span> Green</code> colors. From these colors, other colors are derived. 
            The local color library 
            does not distinguish between any of these color through their color categories or classifications. Rather, colors are measured with either 
            the shade of white (-l, -ll) or darkness (-d, -dd). Some colors which are naturally dark, for example green, 
            use the shade of white (i.e -l or -ll) to become brighter while others which are bright use <code>-d</code> or 
            <code>-dd</code> to specify the darkness. However, brown is the only color which has been defined to have both a lighter  and a darker 
            utility class selector. The following colors are available for use: 
            <br>
            <code>black</code><code>white</code><code>off-white</code><code>blue</code>
            <code>red</code>
            <code>yellow </code><code>green</code><code>orange</code><code>purple</code>
            <code>bronze</code><code>silver</code><code>gold</code><code>brown </code>
            <code>indigo</code><code>pink</code><code>aqua</code><code>grey </code>
            <code>slate-grey</code><code>ivory</code><code>lime</code><code>magenta</code>
            <code>maroon</code><code>red-orange</code><code>sea-green</code><code>sea-blue</code>
            <code>sky-blue</code> <code>dry-blue</code><code>steel-blue</code><code>dodger-blue</code>
            <code>deep-blue</code> <code>deeper-blue</code><code>blue-violet</code><code>tan</code>
            <code>teal</code>. 
            
            Colors are either classified as dark colors or bright colors based 
            on the aforementioned colors. The dark colors uses the light <code>-l</code> and lighter <code>-ll</code> ""
            directives to get brighter, while bright colors use the dark <code>-d</code> or darker <code>-dd</code> directive to get darker. 
        </span> <br><br>

        <div class="dark-colors">
            <div class="wid-fit c-olive font-em-1d1">Dark Colors</div>
            <div class="static-fonts">
    
                <div class="font-em-d85">
                   There are only few dark colors that are supported by the local color library. Examples of these colors are listed 
                   below <br>
                   <code>black</code> <code>green</code> and <code>brown</code> colors. Hence, the following are acceptable <br><br>
    
                   <code>black</code> <code>black-l</code> <code>black-ll</code> <br>
                   <code>green</code> <code>green-l</code> <code>green-ll</code> <br>
                   <code>brown</code> <code>brown-l</code> <code>brown-ll</code> <br>
                </div>
    
            </div>
        </div> <br>

        <div class="bright-colors">
            <div class="wid-fit c-olive font-em-1d1">Bright Colors</div>
            <div class="static-fonts">
    
                <div class="font-em-d85">
                   All other colors metioned apart from the dark colors are classified as bright colors. Examples of these colors are listed 
                   below <br><br>

                   <code>white</code> <code>white-d</code> <code>white-dd</code> <br>
                   <code>off-white</code> <code>off-white-d</code> <code>off-white-dd</code> <br>
                   <code>red</code> <code>red-d</code> <code>red-dd</code> <br>
                   <code>blue</code> <code>blue-d</code> <code>blue-dd</code> <br>
                   <code>dodger-blue</code> <code>dodger-blue-d</code> <code>dodger-blue-dd</code> <br>
                   <code>dry-blue</code> <code>dry-blue-d</code> <code>dry-blue-dd</code> <br>
                   <code>deep-blue</code> <code>deep-blue-d</code> <code>deep-blue-dd</code> <br>
                   <code>deeper-blue</code> <code>deeper-blue-d</code> <code>deeper-blue-dd</code> <br>
                   <code>steel-blue</code> <code>steel-blue-d</code> <code>steel-blue-dd</code> <br>
                   <code>blue-violet</code> <code>blue-violet-d</code> <code>blue-violet-dd</code> <br>
                   <code>yellow</code> <code>yellow-d</code> <code>yellow-dd</code> <br>
                   <code>orange</code> <code>orange-d</code> <code>orange-dd</code> <br>
                   <code>pink</code> <code>pink-d</code> <code>pink-dd</code> <br>
                   <code>purple</code> <code>purple-d</code> <code>purple-dd</code> <br>
                   <code>rebecca-purple</code> <code>rebecca-purple-d</code> <code>rebecca-purple-dd</code> <br>
                   <code>bronze</code> <code>bronze-d</code> <code>bronze-dd</code> <br>
                   <code>silver</code> <code>silver-d</code> <code>silver-dd</code> <br>
                   <code>gold</code> <code>gold-d</code> <code>gold-dd</code> <br>
                   <code>indigo</code> <code>indigo-d</code> <code>indigo-dd</code> <br>
                   <code>aqua</code> <code>aqua-d</code> <code>aqua-dd</code> <br>
                   <code>grey</code> <code>grey-d</code> <code>grey-dd</code> <br>
                   <code>slate-grey</code> <code>slate-grey-d</code> <code>slate-grey-dd</code> <br>
                   <code>ivory</code> <code>ivory-d</code> <code>ivory-dd</code> <br>
                   <code>olive</code> <code>olive-d</code> <code>olive-dd</code> <br>
                   <code>lime</code> <code>lime-d</code> <code>lime-dd</code> <br>
                   <code>magenta</code> <code>magenta-d</code> <code>magenta-dd</code> <br>
                   <code>maroon</code> <code>maroon-d</code> <code>maroon-dd</code> <br>
                   <code>crimson</code> <code>pink-d</code> <code>crimson-dd</code> <br>
                   <code>tan</code> <code>tan-d</code> <code>tan-dd</code> <br>
                   <code>teal</code> <code>teal-d</code> <code>teal-dd</code> <br>
                   <code>sea-blue</code> <code>sea-blue-d</code> <code>sea-blue-dd</code> <br>
                   <code>sea-green</code> <code>sea-green-d</code> <code>sea-green-dd</code> <br>
                   <code>red-orange</code> <code>red-orange-d</code> <code>red-orange-dd</code> <br>
                   <code>brown</code> <code>brown-d</code> <code>brown-dd</code><br>
                </div>
    
            </div>
        </div> <br>


        <div class="em-fonts">
            <div class="wid-fit c-olive font-em-1d1">Color Usage</div>
            <div class="font-em-d85">
                The format of the dark and bright colors cannot be applied naturally unless its puporse is strictly 
                defined. The in order words mean that we need to specify where the colors should be applied. Colors can 
                be applied for texts <code>c</code>, backgrounds color <code>bc</code><code>bh</code>, borders <code>bd</code> and outlines <code>oc</code><code>oh</code><code>oo</code>. The following 
                syntaxes defines the purpose of a color: <br><br>

                <div class="flex f-col">
                    <div class="flex midv">
                        <span class="clip-120">text</span> <code class="clip-40 mxr-20">c-</code> <span>- text color</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">text opacity</span> <code class="clip-40 mxr-20">co-</code> <span>- text color opacity</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">text:hover</span> <code class="clip-40 mxr-20">ch-</code>- text hover color<span></span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">text opacity</span> <code class="clip-40 mxr-20">cho-</code> <span>- text color hover opacity</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">background</span> <code class="clip-40 mxr-20">bc-</code>- background color <span></span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">background opacity</span> <code class="clip-40 mxr-20">bco-</code> <span>- background color opacity level</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">background:hover</span> <code class="clip-40 mxr-20">bh-</code> <span>- background hover color</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">background opacity</span> <code class="clip-40 mxr-20">bho-</code> <span>- background hover opacity level</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">border</span> <code class="clip-40 mxr-20">bd-</code> <span>- border (color, thickness)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">border opacity</span> <code class="clip-40 mxr-20">bdo-</code> <span>- border opacity (color)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">border:hover</span> <code class="clip-40 mxr-20">bdh-</code> <span>- border hover (color)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">border opacity</span> <code class="clip-40 mxr-20">bdho-</code> <span>- border hover opacity (color)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline</span> <code class="clip-40 mxr-20">och-</code> <span>- outline color (color, thickness)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline opacity</span> <code class="clip-40 mxr-20">oco-</code> <span>- outline color opacity</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline:hover</span> <code class="clip-40 mxr-20">och-</code> <span>- outline hover color</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline opacity</span> <code class="clip-40 mxr-20">oho-</code> <span>- outline hover opacity (color)</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline offset</span> <code class="clip-40 mxr-20">oo-</code> <span>- outline offset</span>
                    </div>
                    <div class="flex midv">
                        <span class="clip-120">outline offset</span> <code class="clip-40 mxr-20">ooh-</code> <span>- outline offset hover</span>
                    </div>
                </div>

                
                <div class="decimal-only">
                    Colors can be applied by first definining its function before application. For example, to apply a text color of green, 
                    the text color identifier of <code>c-</code> will be merged with the green color <code>green</code> to give <code>c-green</code>. 
                    This method can also be applied for color shades. For examle a light green will used <code>c-green-l</code> and a lighter green will  
                    use <code>c-green-ll</code>. In this way, it becomes easier to identify colors.
                    <br>

                    The illustration above reveals all the acceptable colors.
                </div> <br>
                
                <div class="decimal-only">
                    <div class="pvs-10 fb-6">Color Library</div>
                    <div class="bc-white-d pxv-10 --theme-esc">
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                        <div class="px-20 bc-black oc-black oc-4 oo-1 mxr-10"></div>
                            <span>black</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-black-l oc-black-l oc-4 oo-1 mxr-10"></div>
                            <span>black-l</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-black-ll oc-black-ll oc-4 oo-1 mxr-10"></div>
                            <span>black-ll</span>
                        </div>

                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-white oc-silver oc-4 oo-1 mxr-10"></div>
                            <span>white</span>
                        </div>
                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-white-d oc-silver-d oc-4 oo-1 mxr-10"></div>
                            <span>white-d</span>
                        </div>
                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-white-dd oc-white-dd oc-4 oo-1 mxr-10"></div>
                            <span>white-dd</span>
                        </div>

                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-off-white oc-off-white oc-4 oo-1 mxr-10"></div>
                            <span>off-white</span>
                        </div>
                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-off-white-d oc-off-white-d oc-4 oo-1 mxr-10"></div>
                            <span>off-white-d</span>
                        </div>
                        <div class="flex-full bc-silver-d mvt-10 pxv-4">
                            <div class="px-20 bc-off-white-dd oc-off-white-dd oc-4 oo-1 mxr-10"></div>
                            <span>off-white-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 co-9 bc-blue oc-blue oc-4 oo-1 mxr-10"></div>
                            <span>blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-blue-d oc-blue-d oc-4 oo-1 mxr-10"></div>
                            <span>blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-blue-dd oc-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red oc-red-dd oc-4 oo-1 mxr-10"></div>
                            <span>red</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red-d oc-red-dd oc-4 oo-1 mxr-10"></div>
                            <span>red-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red-dd oc-red-dd oc-4 oo-1 mxr-10"></div>
                            <span>red-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-yellow oc-yellow oc-4 oo-1 mxr-10"></div>
                            <span>yellow</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-yellow-d oc-yellow-d oc-4 oo-1 mxr-10"></div>
                            <span>yellow-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-yellow-dd oc-yellow-dd oc-4 oo-1 mxr-10"></div>
                            <span>yellow-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-orange oc-orange oc-4 oo-1 mxr-10"></div>
                            <span>orange</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-orange-d oc-orange-d oc-4 oo-1 mxr-10"></div>
                            <span>orange-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-orange-dd oc-orange-dd oc-4 oo-1 mxr-10"></div>
                            <span>orange-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red-orange oc-red-orange oc-4 oo-1 mxr-10"></div>
                            <span>red-orange</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red-orange-d oc-red-orange-d oc-4 oo-1 mxr-10"></div>
                            <span>red-orange-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-red-orange-dd oc-red-orange-dd oc-4 oo-1 mxr-10"></div>
                            <span>red-orange-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-purple oc-purple oc-4 oo-1 mxr-10"></div>
                            <span>purple</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-purple-d oc-purple-d oc-4 oo-1 mxr-10"></div>
                            <span>purple-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-purple-dd oc-purple-dd oc-4 oo-1 mxr-10"></div>
                            <span>purple-dd</span>
                        </div>


                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-violet oc-violet oc-4 oo-1 mxr-10"></div>
                            <span>violet</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-violet-d oc-violet-d oc-4 oo-1 mxr-10"></div>
                            <span>violet-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-violet-dd oc-violet-dd oc-4 oo-1 mxr-10"></div>
                            <span>violet-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-magenta oc-magenta oc-4 oo-1 mxr-10"></div>
                            <span>magenta</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-magenta-d oc-magenta-d oc-4 oo-1 mxr-10"></div>
                            <span>magenta-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-magenta-dd oc-magenta-dd oc-4 oo-1 mxr-10"></div>
                            <span>magenta-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-teal oc-teal oc-4 oo-1 mxr-10"></div>
                            <span>teal</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-teal-d oc-teal-d oc-4 oo-1 mxr-10"></div>
                            <span>teal-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-teal-dd oc-teal-dd oc-4 oo-1 mxr-10"></div>
                            <span>teal-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-lime oc-lime oc-4 oo-1 mxr-10"></div>
                            <span>lime</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-lime-d oc-lime-d oc-4 oo-1 mxr-10"></div>
                            <span>lime-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-lime-dd oc-lime-dd oc-4 oo-1 mxr-10"></div>
                            <span>lime-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dodger-blue oc-dodger-blue oc-4 oo-1 mxr-10"></div>
                            <span>dodger-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dodger-blue-d oc-dodger-blue-d oc-4 oo-1 mxr-10"></div>
                            <span>dodger-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dodger-blue-dd oc-dodger-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>dodger-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dry-blue oc-dry-blue oc-4 oo-1 mxr-10"></div>
                            <span>dry-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dry-blue-d oc-dry-blue-d oc-4 oo-1 mxr-10"></div>
                            <span>dry-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-dry-blue-dd oc-dry-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>dry-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deep-blue oc-deep-blue oc-4 oo-1 mxr-10"></div>
                            <span>deep-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deep-blue-d oc-deep-blue-d oc-4 oo-1  mxr-10"></div>
                            <span>deep-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deep-blue-dd oc-deep-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>deep-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deeper-blue oc-deeper-blue oc-4 oo-1 mxr-10"></div>
                            <span>deeper-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deeper-blue-d oc-deeper-blue-d oc-4 oo-1  mxr-10"></div>
                            <span>deeper-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-deeper-blue-dd oc-deeper-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>deeper-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-steel-blue oc-steel-blue oc-4 oo-1 mxr-10"></div>
                            <span>steel-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-steel-blue-d oc-steel-blue-d oc-4 oo-1 mxr-10"></div>
                            <span>steel-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-steel-blue-dd oc-steel-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>steel-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-blue oc-sea-blue oc-4 oo-1 mxr-10"></div>
                            <span>sea-blue</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-blue-d oc-sea-blue-d oc-4 oo-1  mxr-10"></div>
                            <span>sea-blue-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-blue-dd oc-sea-blue-dd oc-4 oo-1 mxr-10"></div>
                            <span>sea-blue-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-blue-violet oc-blue-violet oc-4 oo-1 mxr-10"></div>
                            <span>blue-violet</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-blue-violet-d oc-blue-violet-d oc-4 oo-1 mxr-10"></div>
                            <span>blue-violet-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-blue-violet-dd oc-blue-violet-dd oc-4 oo-1 mxr-10"></div>
                            <span>blue-violet-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-indigo oc-indigo oc-4 oo-1 mxr-10"></div>
                            <span>indigo</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-indigo-d oc-indigo-d oc-4 oo-1 mxr-10"></div>
                            <span>indigo-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-indigo-dd oc-indigo-dd oc-4 oo-1 mxr-10"></div>
                            <span>indigo-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-rebecca-purple oc-rebecca-purple oc-4 oo-1 mxr-10"></div>
                            <span>rebecca-purple</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-rebecca-purple-d oc-rebecca-purple-d oc-4 oo-1  mxr-10"></div>
                            <span>rebecca-purple-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-rebecca-purple-dd oc-rebecca-purple-dd oc-4 oo-1 mxr-10"></div>
                            <span>rebecca-purple-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-pink oc-pink oc-4 oo-1 mxr-10"></div>
                            <span>pink</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-pink-d oc-pink-d oc-4 oo-1 mxr-10"></div>
                            <span>pink-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-pink-dd oc-pink-dd oc-4 oo-1 mxr-10"></div>
                            <span>pink-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-aqua oc-aqua oc-4 oo-1 mxr-10"></div>
                            <span>aqua</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-aqua-d oc-aqua-d oc-4 oo-1 mxr-10"></div>
                            <span>aqua-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-aqua-dd oc-aqua-dd oc-4 oo-1 mxr-10"></div>
                            <span>aqua-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-bronze oc-bronze oc-4 oo-1 mxr-10"></div>
                            <span>bronze</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-bronze-d oc-bronze-d oc-4 oo-1 mxr-10"></div>
                            <span>bronze-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-bronze-dd oc-bronze-dd oc-4 oo-1 mxr-10"></div>
                            <span>bronze-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-silver oc-silver oc-4 oo-1 mxr-10"></div>
                            <span>silver</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-silver-d oc-silver-d oc-4 oo-1 mxr-10"></div>
                            <span>silver-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-silver-dd oc-silver-dd oc-4 oo-1 mxr-10"></div>
                            <span>silver-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-grey oc-grey oc-4 oo-1 mxr-10"></div>
                            <span>grey</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-grey-d oc-grey-d oc-4 oo-1 mxr-10"></div>
                            <span>grey-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-grey-dd oc-grey-dd oc-4 oo-1 mxr-10"></div>
                            <span>grey-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-slate-grey oc-slate-grey oc-4 oo-1 mxr-10"></div>
                            <span>slate-grey</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-slate-grey-d oc-slate-grey-d oc-4 oo-1 mxr-10"></div>
                            <span>slate-grey-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-slate-grey-dd oc-slate-grey-dd oc-4 oo-1 mxr-10"></div>
                            <span>slate-grey-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-gold oc-gold oc-4 oo-1 mxr-10"></div>
                            <span>gold</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-gold-d oc-gold-d oc-4 oo-1 mxr-10"></div>
                            <span>gold-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-gold-dd oc-gold-dd oc-4 oo-1 mxr-10"></div>
                            <span>gold-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-brown oc-brown oc-4 oo-1 mxr-10"></div>
                            <span>brown</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-brown-d oc-brown-d oc-4 oo-1 mxr-10"></div>
                            <span>brown-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-brown-dd oc-brown-dd oc-4 oo-1 mxr-10"></div>
                            <span>brown-dd</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-brown-l oc-brown-l oc-4 oo-1 mxr-10"></div>
                            <span>brown-l</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-brown-ll oc-brown-l oc-4 oo-1 mxr-10"></div>
                            <span>brown-ll</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-crimson oc-crimson oc-4 oo-1 mxr-10"></div>
                            <span>crimson</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-crimson-d oc-crimson-d oc-4 oo-1 mxr-10"></div>
                            <span>crimson-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-crimson-dd oc-crimson-dd oc-4 oo-1 mxr-10"></div>
                            <span>crimson-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-maroon oc-maroon oc-4 oo-1 mxr-10"></div>
                            <span>maroon</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-maroon-d oc-maroon-d oc-4 oo-1 mxr-10"></div>
                            <span>maroon-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-maroon-dd oc-maroon-dd oc-4 oo-1 mxr-10"></div>
                            <span>maroon-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-ivory oc-ivory oc-4 oo-1 mxr-10"></div>
                            <span>ivory</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-ivory-d oc-ivory-d oc-4 oo-1 mxr-10"></div>
                            <span>ivory-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-ivory-dd oc-ivory-dd oc-4 oo-1 mxr-10"></div>
                            <span>ivory-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-olive oc-olive oc-4 oo-1 mxr-10"></div>
                            <span>olive</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-olive-d oc-olive-d oc-4 oo-1 mxr-10"></div>
                            <span>olive-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-olive-dd oc-olive-dd oc-4 oo-1 mxr-10"></div>
                            <span>olive-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-green oc-sea-green oc-4 oo-1 mxr-10"></div>
                            <span>sea-green</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-green-d oc-sea-green-d oc-4 oo-1 mxr-10"></div>
                            <span>sea-green-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-sea-green-dd oc-sea-green-dd oc-4 oo-1 mxr-10"></div>
                            <span>sea-green-dd</span>
                        </div>

                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-tan oc-tan oc-4 oo-1 mxr-10"></div>
                            <span>tan</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-tan-d oc-tan-d oc-4 oo-1 mxr-10"></div>
                            <span>tan-d</span>
                        </div>
                        <div class="flex-full bc-white-dd mvt-10 pxv-4">
                            <div class="px-20 bc-tan-dd oc-tan-dd oc-4 oo-1 mxr-10"></div>
                            <span>tan-dd</span>
                        </div>



                    </div>
                </div>
                
                <div class="mvt-4">
                    The colors with their shade all together form eighty (110) colors that can be applied on texts, borders, outlines and backgrounds and even for opacity. 
                    This is created to provide a wide range of color selection. The entire use case of these color are at a minimum of at least 10,000 applicable
                    ways and the ability to use color mixing through opacity even raises this level.
                </div>

            </div> <br>
        </div>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">COLOR HOVERS</div>
            <div class="font-em-d85">
                It is a commonly used feature to switch between colors when hovering on html contents such as text colors or background colors. 
                In order to apply an hover color, any of the hover utitity classes mentioned earlier should be applied. For example the color 
                <code>grey</code> can be applied a font color of <code>c-grey</code> and hover color <code>ch-grey</code>. 
                For example when we hover on "This is a text" in the figure below, the color becomes darker: 
                <br>

                <div class="bc-silver mvt-6">
                    <div class="ct-8 bc-silver-d pxv-4">
                        Hover to change font color
                    </div>
                    <div class="pxv-10 c-grey ch-grey-dd pointer">
                        This is a beautiful text
                    </div>
                </div>
                
                <br>
                <div>
                    As we might have noticed, the hovering effect is very fast. We can make this faster by applying the <code>bc</code> class. 
                    This slows down the animation speed, making it smoother just as show below:
                </div>

                <div class="bc-silver mvt-6">
                    <div class="bc-silver-d pxv-4">
                        Hover to change font color
                    </div>
                    <div class="bc pxv-10 c-grey ch-grey-dd pointer">
                        This is a beautiful text
                    </div>
                </div>
            </div>
        </div> <br>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">COLOR OPACITY</div>
            <div class="font-em-d85">
                The color opacity of elements can be set for borders, outlines, backgrounds and text using predefined relative 
                utility class. The color opacity level runs from 
                0.1 to 0.9. Hence we the opacity classes with ending values <code>-1</code> <code>-2</code> <code>-3</code> 
                <code>-4</code> <code>-5</code> <code>-6</code> <code>-7</code> <code>-8</code> and
                <code>-9</code>. The <code>-1</code> reflects the lowest level of transparency at 
                <code>0.9</code> while <code>-9</code> relfects the highest highest of transparency at 
                <code>0.1</code>. The code below is an example of background opacity set for an element. The transition effect is applied 
                though the <code>bc</code> class while a background hover color opacity of 3 (ie <code>bho-3</code>). 
            </div> <br>

            <div class="">
                <div class="flex midv bc-silver pxv-10">
                    <span class="px-50 c-white bc bc-black bh-black-dd bho-3 mxr-10 grid-center">Hi</span>
                    <span> hover on the black color</span>
                </div>
            </div>
            <div class="font-em-d85 mvt-10">
                In the code above, the text is not affected by the background color transparency this is because the effect of the transparecy 
                only falls on the background color. Now that we have seen the effect of colors let's see if we can created a cool button.
            </div> <br>

            <div class="bc-silver rad-4 font-em-d85 pxv-6">
                <button @attr:anime-btn >
                    Click me
                </button>
            </div> <br>

            <div class="font-em-d85">
                The button above is achieved through the use of untility classes along with the <code>box-shadow</code> css property. The code structure 
                is show below: <br>

            </div>
            <div class="pre-area shadow">
 <pre class="pre-code">
 @php:
 print to_lgts('<button @attr:anime-btn>
    Click me
 </button>');
 @php;

 </pre>
            </div> <br><br>

            <div class="font-em-d85">
                The utility classes seems a bit longer than usual. This is required given that the utility classes performs different kinds 
                of operation. The following list explains the function of each class. 
                <br>

                <ul class="pxs-10">
                    <li>
                        <code>in-flex-btn</code> is a <a href="">flex</a> display type used for buttons. 
                    </li>
                    <li>
                        <code>rad-r</code> sets an element's border to round shape
                    </li>
                    <li><code>c-white</code> sets text color to white</li>
                    <li><code>bc</code> sets a slower transition effect</li>
                    <li><code>bc-purple</code> sets an elements background color to purple</li>
                    <li><code>bc-purple-dd</code> sets an elements background color to darker purple when hovered upon</li>
                    <li><code>oc-purple</code> sets outline color to purple</li>
                    <li><code>oc-1</code> sets outline thickness to 1</li>
                    <li><code>oh-4</code> sets outline thickness to 4 when hovered upon</li>
                    <li><code>oo-5</code> sets outline offset to 5</li>
                    <li><code>ooh-7</code> sets outline offset to 7 when hovered upon</li>
                    <li><code>pxv-10</code> sets padding to 10 pixel</li>
                    <li><code>mxv-20</code> sets a margin of 20 pixels all around the horizontal (x-axis) and vertical (y-axis)  </li>
                </ul>
                

                In the situation where certain html attributes are longer, developers may employ the 
                use of <code>x-attr</code> template directive for recurring attributes.
            </div>
            
        </div> <br>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">COLOR MIXING</div>
            <div class="font-em-d85">
                Color mixing can be achieved through layers of colors. Since in reality, color mixing involves the  
                addition of separate colors together gives room for new colors, color mixing can be achived by stacking 
                layers of different colors on each other to achive a new color. Each layer is given a specific range of 
                opacity level in which a lower layer can reflect through. The color below is an example of this.
            </div> <br><br>

            <div class="bc-silver relative c-white">
                <div class="flex midv pxs-20 relative" style="height:50px">
                <div class="pxv-10 box-full bc-black bco-7" style="width:120px"></div>
                   <div class="bc-red bco-7 c-white pxv-10 absolute" style="top:-20px; width: 80px; height: 60px">

                   </div>
                   <div class="bc-red bco-7 c-white pxv-10 absolute grid-center" style="left:40px; bottom:-8px; width:80px; height: 100px">
                       HI           
                   </div>
                </div>
            </div> <br>
            <div class="font-em-d85 mvt-10">
                In the image above, different layers of colors were mixed using different levels of color transparency. We can see different color variations achieved by the colors 
                just by setting the transparency. As we can see, the text is not affected because transparency is only set on the background-color 
                of the div items not its contents itself. The code structure is shown below: 
            </div> <br>

            <div class="font-em-d85">
                The button above is achieved through the use of untility classes along with the <code>box-shadow</code> css property. The code structure 
                is show below: <br>

            </div>
            <div class="pre-area shadow">
                <div class="pxv-10 bc-silver">
                    Example: color mixing
                </div>
 <pre class="pre-code c-olive">
 @php:
 print to_lgts('
  <div class="bc-silver relative c-white">
    <div class="flex midv pxs-20 relative" style="height:50px">
    <div class="pxv-10 box-full bc-black bco-7" style="width:120px"></div>
        <div class="bc-red bco-7 c-white pxv-10 absolute" style="top:-20px; width: 80px; height: 60px">

        </div>
        <div class="bc-red bco-7 c-white pxv-10 absolute grid-center" style="left:40px; bottom:-8px; width:80px; height: 100px">
            HI           
        </div>
    </div>
 </div>
 ');
 @php;

 </pre>
            </div>
            
        </div> <br>

    </div>
@template;