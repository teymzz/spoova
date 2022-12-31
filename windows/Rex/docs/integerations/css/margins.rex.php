@template('docs.integerations.template.co.format')

    @title('Css Integerations - Images')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    
    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Setting margins</div>
        </span>

    </div> <br>

    <div class="padd-x-4 font-em-d87">

        <span class="">
            Margins are defined using special fixed patterns which can be for negative or positive margins. The margins are set based on 
            pixels. The horizontal margins are denoted with the <code>mx</code> class while the vertical margins are denoted with <code>mv</code> 
            class. In situations where both horizontal and vertical margins are expected to be applied at equal margin, the <code>mxv</code> class 
            is employed. Negative margins uses the <code>n</code> identifier. Hence, a negative margin of 10 pixels on an horizontal axis will be denoted 
            as <code>mxn-10</code>. Margins can also be applied for left or right sides on either the horizontal axis and top or bottom sides or vertical axis. 
            The margin applied on contents uses the <code>1</code>, <code>2</code>, <code>3</code>, <code>4</code>, <code>5</code> <code>6</code>,
            <code>8</code>, <code>10</code>, <code>12</code>, <code>14</code>, <code>15</code>, <code>16</code>, <code>18</code> and <code>20</code>
            unit identifiers. Each of these digits reflects the margin distance given on any side defined. The list below are the list of margin purpose identifiers. 
            <br><br>

            <ul class="pxl-14">
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxs-</code> </span> <span> - applies margin on both sides on the horizontal axi</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-</code> </span> <span> - applies margin on the left side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-</code> </span> <span> - applies margin on the right size on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-n</code></span> <span>  - applies negative margin on the left side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-n</code></span> <span>  - applies negative margin on the right side on the horizontal axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvs-</code> </span> <span> - applies margin on both sides on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-</code> </span> <span> - applies top margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-</code> </span> <span> - applies bottom margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-n</code></span> <span>  - applies negative top margin on the vertical axis</span></li>
                <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-n</code></span> <span>  - applies negative bottom margin on the vertical axis</span></li>
            </ul>
            
            <div class="">
                The example below reveals how to apply a margin of 2 pixels on any of the margin identifiers above: <br><br>
    
                <ul class="pxl-14">
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxs-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on both sides on the horizontal axi</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on the left side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on the right size on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxl-n2</code></span> <span>  - applies negative margin of <b class="c-teal">2 pixels</b> on the left side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mxr-n2</code></span> <span>  - applies negative margin of <b class="c-teal">2 pixels</b> on the right side on the horizontal axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvs-2</code> </span> <span> - applies margin of <b class="c-teal">2 pixels</b> on both sides on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-2</code> </span> <span> - applies top margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-2</code> </span> <span> - applies bottom margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvt-n2</code></span> <span>  - applies negative top margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                    <li class="mvb-2"> <span class="flex midv"> <span class="clip-50 bc-silver mxr-4"><code>mvb-n2</code></span> <span>  - applies negative bottom margin of <b class="c-teal">2 pixels</b> on the vertical axis</span></li>
                </ul>

            </div>

            <div class="bc-silver rad-4 shadow rad-2 flow-hide">
               <div class="box pxv-10 bc-orange-d c-white">Note:</div> 
               <span class="pxs-2">Although, these margins may be fixed, other margins can be applied from the bootstrap library.</span>
            </div>

        </span>

    </div>

@template;