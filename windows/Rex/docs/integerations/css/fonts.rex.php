@template('docs.integerations.template.co.format')

    @title('Css Integerations - Fonts')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-orange-dd font-em-1d7">FONTS</div>
            Font classes are used to set font sizes and font families. Font sizes are measured based on pixels or relative to the 
            size of the font (i.e em). The fonts measured in pixels are the static fonts while those measured in "em" are the relative fonts.
        </span> <br><br>

        <div class="wid-fit c-olive font-em-1d1">FONT SIZES</div>
        <div class="static-fonts">
            <div class="wid-fit c-olive font-em-1d1 mvt-10">Static Fonts</div>

            <div class="font-em-d85">
                Static fonts' classes range from <code>font-8</code> to <code>font-25</code> although there is also <code>font-0</code> 
                which can set the font of a text with the property and value <code>font: 0/0 a;</code>
            </div>

            <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                <div class="pxv-10 bc-silver-d">Example: font-14</div>
                <div class="bc-white-d pxv-8 text-left font-14" >
                    This text will never change its size based on any device because it uses font size 14 
                </div>
            </div> <br><br>
        </div>

        <div class="em-fonts">
            <div class="wid-fit c-olive font-em-1d1">EM Fonts</div>
            <div class="font-em-d85">
                Since em fonts are meausured using em unit, they have a much better relationship with different  
                devices. The em utility classes run from <code>0</code> and <code>1-6</code>. The font sizes that 
                fall under the category of zero <code>"0"</code> are known as the decimal fonts while others which run from 1 to 6 
                are the digit relative fonts. 
                
                <div class="decimal-only">
                    <div class="pvs-10 fb-6">Decimal Only Fonts</div>
                    Decimal only fonts are em fonts that have only the the decimal unit identifiers without a digit before them (ie <code>-d</code>). 
                    This is because the zero digit is ignored. These fonts run from <code>font-em-d1</code> to <code>font-em-d9</code> 
                    and they have a sub decimal value that uses the  <code>1-2-3-5-7-9</code> pattern. For example a decimal only font <code>font-em-d1</code> can be applied a sub decimal value of <code>7</code> to form 
                    <code>font-em-d17</code>. The illustration below shows the list of decimal fonts and the sub decimals that can be applied on them <br>
                    <br>

                    <div class="bc-white-d pxv-10">
                        Decimals : <code>font-em-d1</code> <code>font-em-d2</code> 
                                   <code>font-em-d3</code> <code>font-em-d4</code>
                                   <code>font-em-d5</code> <code>font-em-d6</code> 
                                   <code>font-em-d7</code> <code>font-em-d8</code>
                                   <code>font-em-d9</code>
                                   <br>
    
                        Subdecimals : <code>1</code><code>2</code><code>3</code>
                                      <code>5</code><code>7</code><code>9</code> 
                                      <br><br>
                        Examples : <code>font-em-d1</code><code>font-em-d17</code><code>font-em-d25</code>
                    </div>
                </div> <br>
                
                <div class="decimal-only">
                    <div class="pvs-10 fb-6">Integer Relative Fonts</div>
                    The integer relative fonts are em fonts that have whole digits assigned to them and they can be assigned decimal values but not subdecimals.
                    These fonts run from <code>1</code> to <code>6</code> 
                    while their decimal value that uses the pattern <code>d1-d2-d3-d5-d7-d9</code>. The illustration above best explains the syntax and examples 
                    of these fonts.
                    <br>
                    <div class="bc-white-d pxv-10">
                        Integer :  <code>font-em-1</code> <code>font-em-2</code> 
                                   <code>font-em-3</code> <code>font-em-4</code>
                                   <code>font-em-5</code> <code>font-em-6</code> <br>

                        Decimals : <code>1</code><code>2</code><code>3</code>
                                   <code>5</code><code>7</code><code>9</code> <br><br>
                        Examples : <code>font-em-1</code><code>font-em-1d5</code><code>font-em-2d7</code>
                    </div>
                </div>
                
                This means that the unit value of any font can be assigned relative 
                to its real font size at the units of <code>0</code> through <code>9</code>. Each of these units employs a decimal pattern 
                of <code>d1-d2-d3-d5-d7-d9</code> except the decimal only fonts. For example, a font <code>font-em-1</code> can use a decimal value of <code>1</code> just by assigning the value <code>d1</code> 
                to it to form <code>font-em-1d1</code> based on the pattern mentioned earlier. Since having a font size <code>font-em-0</code> is non realistic, there is not utility 
                class assigned for <code>font-em-0</code>, however there are categories of decimal only font sizes which can be assigned to any fonts. In this case, the zero <code>"0"</code> 
                is ignored while the decimal part only remains. Font sizes in this category uses a different pattern of flow.

            </div> <br>
        </div>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">FONT WEIGHTS</div>
            <div class="font-em-d85">
                Font weights utility classes ranges from <code>6</code> to <code>9</code> and they can be identified through the <code>fb-</code> identifier. 
                The format below reveals the font types supported <br>

                <code>fb-6</code> - sets font-wieight at 600 <br>
                <code>fb-7</code> - sets font-wieight at 700 <br>
                <code>fb-8</code> - sets font-wieight at 800 <br>
                <code>fb-9</code> - sets font-wieight at 900 <br><br>

                The weight of any font is applied relative to its font size. <br>

                <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                    <div class="pxv-10 bc-silver-d">Example: font weight 600 at 14pixels</div>
                    <div class="bc-white-d pxv-8 font-14 fb-6" >
                        Lorem ipsum dolor sit amet consectetur adipisicing el
                    </div>
                </div> <br><br>
            </div>
        </div>

        <div class="font-weights">
            <div class="wid-fit c-olive font-em-1d1">FONT FAMILY</div>
            <div class="font-em-d85">
                The font family utility classes that come with the local css font library includes:<br>

                <code>Calibri</code> 
                <code>Verdana</code> 
                <code>Helvetica</code> 
                <code>Nunito</code> 
                <code>Fira</code> 
                <code>Boxigen</code> 
                <br><br>

                <div class="box pxv-10 bc-silver font-em-d85" style="width:100%">
                    <div class="pxv-10 bc-silver-d">Example: font family verdana</div>
                    <div class="bc-white-d pxv-8 font-14 fb-6 verdana" >
                        Lorem ipsum dolor sit amet consectetur adipisicing el
                    </div>
                </div> <br><br>
            </div>
        </div>

    </div> <br>

@template;