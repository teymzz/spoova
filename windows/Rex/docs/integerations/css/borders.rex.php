@template('docs.integerations.template.co.format')

    @title('Css Integerations - Borders')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Borders Thickness</div>
            <div class="">
                Borders are mostly denoted with the <code>bd</code> utility classes. While border colors 
                are discussed in <a href="@domurl('docs/other-features/css/colors')">colors</a>, the color 
                thickness can be applied though digits that run from <code>1</code> to <code>9</code>. This means 
                that for a border to be applied to any element, it must have the property that matches a <code>bd-</code> and 
                ends with a digit (e.g 9). Hence we have a border thickness utility class that run from <code>bd-1</code> to 
                <code>bd-9</code>. The border thickness is defined using pixels as the thickness unit.
            </div><br>

            <div class="wid-fit c-olive font-em-1d5">Borders Radius</div>
            <div class="">
                There are only quite a number of border radius utility classes. A part runs from <code>rad-1</code>  
                to <code>rad-10</code> while the other parts include <code>rad-12</code>, <code>rad-14</code>, <code>rad-16</code> 
                <code>rad-18</code> and <code>rad-20</code>. Each of the digit specifies the amount of radius (in pixels)  
                that is applied on the element. Other custom radius classes are:<br><br>

                <ul class="pxl-14">
                    <li><code>rad-per-50</code> - radius at 50%</li>
                    <li><code>rad-r</code> - apply radius at 100vw </li>
                    <li><code>rad-rl</code> - apply radius on the left side at 100vw</li>
                    <li><code>rad-rr</code> - apply radius on the right side at 100vw</li>
                    <li><code>rad-r-none</code> - remove right radius</li>
                    <li><code>rad-l-none</code> - remove left radius</li>
                    <li><code>rad-t-none</code> - remove top radius</li>
                    <li><code>rad-b-none</code> - remove bottom radius</li>
                    <li><code>rad-lt-none</code> - remove left top radius</li>
                    <li><code>rad-lb-none</code> - remove left bottom radius</li>
                    <li><code>rad-rt-none</code> - remove right top radius</li>
                    <li><code>rad-rb-none</code> - remove right bottom radius</li>
                    <li><code>rad-none</code> - remove all border radius</li>
                    <li><code>rad-f</code> - remove all border radius (strict)</li>
                </ul>

            </div><br>

            <div class="wid-fit c-olive font-em-1d5">Borders Positions</div>
            <div class="">
                Border postions can be defined using custom classes for left, right, top or bottom<br><br>

                <ul class="pxl-14">
                    <li><code>bd-l</code> - border left</li>
                    <li><code>bd-r</code> - border right </li>
                    <li><code>bd-t</code> - border top</li>
                    <li><code>bd-b</code> - border bottom</li>
                    <li><code>bd-v</code> - border top and bottom</li>
                    <li><code>bd-x</code> - border left and right</li>
                    <li><code>bd-none</code> - remove all borders</li>
                    <li><code>bd-r-none</code> - remove right border</li>
                    <li><code>bd-l-none</code> - remove left border</li>
                    <li><code>bd-tp-none</code> - remove top border</li>
                    <li><code>bd-bm-none</code> - remove bottom border</li>
                    <li><code>bd-x-none</code> - remove right and left border</li>
                    <li><code>bd-v-none</code> - remove top and bottom border</li>
                </ul>

            </div><br>


   
        </div>  
        


    </div> <br>

@template;