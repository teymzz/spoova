@template('docs.integerations.template.co.format')

    @meta('dump')
    @title('Css Integerations - Display')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <style>
        .flow-auto.grid {
            /* margin: 1em; */
            display: grid;
            grid-template-columns:repeat(2, 1fr);
            grid-gap:1em;
        }

        @media (min-width:800px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(3, 1fr);
                grid-gap:1em;
            }
            
        }
        @media (min-width:1000px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(4, 1fr);
                grid-gap:1em;
            }
            
        }
        @media (min-width:1305px){

            .flow-auto.grid {
                /* margin: 1em; */
                display: grid;
                grid-template-columns:repeat(5, 1fr);
                grid-gap:1em;
            }
            
        }

        .flex-item{
            height: 200px;
        }
    </style>

    <div class="padd-x-4"> <br>         
        
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d9 mvt-4">

            <div class="wid-fit c-olive"><h4>Display classes</h4></div>

            Display utilty classes are grouped into 9 classes based on block, grid, flex or 
            table display type. These classes are: <br> <br>

            <code>block</code> - for block elements <br>
            <code>in-block</code> - for inline-block elements <br>
            <code>in-line</code> - for inline elements <br>
            <code>grid</code> - for grid elements <br>
            <code>in-grid</code> - for inline-grid elements <br>
            <code>flex</code> - for flex boxes <br>
            <code>in-flex</code> - for inline-flex boxes <br>
            <code>table</code> - for table elements <br>
            <code>in-table</code> - for inline-table elements <br>

            <div class="mvt-6">
                The <code>grid</code> and <code>flex</code> utility classes are special classes which can be combined with their 
                modifier attributes that determines how a content is displayed. For this reason, they are both discussed below:
            </div>

        </span>
    </div><br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Grid Items</div>
            Grid elements can be identified by their special class name <code>"grid"</code>. The grid items are not entirely handled 
            by the local <code>css</code> library. However, it provides utility class <code>"grid-center"</code> for aligning items 
            to the center. This may prove useful in situations where items are needed to be centralized.
            <br><br>

            <div class="in-flex-full bc-silver-d">
                <div class="px-140 grid-center bc-silver bd-r bd-silver-d">
                    Hello in center
                </div>
<div class="box-full pre-area">
    <div class="pxv-10 bc-silver-d">
        Example of "grid-center"
    </div>
    <pre class="pre-code">
  @php: print to_lgts('
    <div class="px-140 grid-center bc-silver">
        Hello in center
    </div>

    ')
  @php;
    </pre>
</div>
            </div>

        </span>

    </div> <br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5"><i class="bi-circle-fill c-silver-d mxr-6"></i>Flex Items</div>
            Any element that has the class of <code>"flex"</code> is considered as a flex item while <code>"in-flex"</code> is used to 
            specify an inline-flex item. Flex is mostly used in form alignments.
            Flex items are greatly controlled by combining the name with other utility classes. Classes that can be combined with the <code>flex</code> 
            or <code>in-flex</code> are mostly used for flex alignments. Some of the classes and their features are listed below: <br>
            <span class="form-field">
                
                <code class="main">flex-l</code> - shifts a flex child item to the left<br>
                <code class="main">flex-lt</code> - shifts a flex child item to the left top<br>
                <code class="main">flex-lb</code> - shifts a flex child item to the left bottom<br>

                <code class="main">flex-r</code> - shifts a flex child item to the right<br>
                <code class="main">flex-rt</code> - shifts a flex child item to the right top<br>
                <code class="main">flex-rb</code> - shifts a flex child item to the right bottom<br>

                <code class="main">flex-col / f-col</code> - sets flex direction to column<br>
                <code class="main">flex-row / f-row</code> - set flex direction to row<br>
                <code class="main">flex-col-m</code> - sets flex direction to row on smaller screen size<br>
                <code class="main">flex-row-m</code> - sets flex direction to column on smaller screen size <br>

                <code class="main">mid</code> - centralizes the position of child items to the middle (vertically and horizontally) of the parent flex item <br>
                <code class="main">midl</code> - centralizes the position of child items vertically to the middle left of the parent flex item  <br>
                <code class="main">midr</code> -  centralizes the position of child items vertically to the middle right of the parent flex item   <br>
                <code class="main">midv</code> -  centralizes the position of child items vertically <br>
                <code class="main">midh</code> -  centralizes the position of child items horizontally <br>
               
                <code class="main">just-left</code> - justifies flex items to start <br>
                <code class="main">just-right</code> - justifies flex items to end  <br>
                <code class="main">just-center</code> -  justifies flex contents to center <br>
                <code class="main">flex-start</code> -  justifies flex contents to flex-start   <br>
                <code class="main">flex-end</code> -  justifies flex contents to flex-end <br>
                <code class="main">flex-center</code> -  justifies and aligns flex contents to center <br>
                <code class="main">space-between</code> -  justifies contents using space-between <br>
                <code class="main">space-around</code> -  justifies contents using space-around <br>
                <code class="main">space-even</code> -  justifies contents using space-evenly <br>
                <br>
                There is however a twist when it comes to setting flex items to 100 percent width. While 
                <code>flex-full</code> is applied specially for items with flex property, <code>in-flex-full</code> is applied for items with inline-flex display property.
                The images below reveals the effect of flex boxes when other utility classes are applied with it. <br><br>
            </span>

            <div class="flow-auto grid">

                <div class="box shadow-1-strong">
                    <div class="flex flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex <span class="c-silver-dd">f-row</span>
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex f-col flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex f-col
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex mid flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex mid
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midh flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midh
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midv flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midv
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midl flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midl
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midr flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midr
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex midb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex midb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-l flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-l
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-lb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-lb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-r flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-r
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rt flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rt
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-rb flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-rb
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-c flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-c
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-left flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-left
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-right flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-right
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex just-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex just-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-start flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-start
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-end flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-end
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex flex-center flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                    </div>
                    flex flex-center
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-between flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-between
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-around flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-around
                </div>

                <div class="box shadow-1-strong">
                    <div class="flex space-even flex-item bc-silver pxv-4">
                        <span class="bc-silver-d">Hello</span>
                        <span class="bc-silver-dd">Hello</span>
                    </div>
                    flex space-even
                </div>




            </div>
        </span>

    </div> <br>


@template;