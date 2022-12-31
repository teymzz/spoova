@template('docs.integerations.template.co.format')

    @title('Css Integerations - Overlay')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    
    <div class="padd-x-4"> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Overlay Items</div>
            The overlay items just as the name implies, are items that stay as an upper layer over other elements. The main feature of these items is that they 
            have the capacity to spread across other elements. This can be used for blurring pages or preventing the click of a button 
            or even as notification boxes. By default, overlay items are not given a positional layer index. This has to be set manually 
            using the <code>z-index</code> property. There are two overlay utility classes available. These are the <code>page-overlay</code> 
            and the <code>overlay</code> class. The <code>page-overlay</code> differs from <code>overlay</code> in that the former has a <code>fixed</code> 
            postion while the latter has an <code>absolute</code> position. Whenever <code>page-overlay</code> class is used on an element, the element's 
            size will spread entirely across the screen or web page but when an <code>overlay</code> is used, it spreads only relative to its container which is 
            of course possible if the parent element has a <code>relative</code> positioning. Since these elements are transparent by nature, they are not visible 
            unless a color is applied on them. Due to the fact that they are mostly used for pop-ups, they are mostly used with other untility classes which sets 
            a slightly transparent background on them. These classes are the <code>ov-l</code> and <code>ov-d</code> classes which sets a white or dark transparent color 
            on the overlay items. The <code>ov-l</code> classes include <code>ov-l1</code>, <code>ov-l2</code>, <code>ov-l5</code> and <code>ov-l7</code> classes while the 
            <code>ov-d</code> classes include <code>ov-d1</code>, <code>ov-d2</code>, <code>ov-d5</code> and <code>ov-d7</code> classes.
            <br><br>
            
            <div class="pre-area">
                <div class="bc-silver">
    
                    <div class="pxv-10 bc-silver-d">Overlay Sample</div>
                    <pre class="pre-code">
  &lt;div class="px-180 c-orange grid-center"&gt;

    &lt;span style="margin-top:-30px"&gt; Hello in the back &lt;/span&gt;

    &lt;div&gt class="overlay ov-d5 grid-center c-white"&gt;
        Hello in the front
    &lt;/div&gt;
    
  &lt;/div&gt;
                    </pre>
                </div>
            </div>

            In the code above, the parent div element was set at a width and height of 180 pixels and the position was set at relative. The child div that has a class of 
            overlay will cover the entire parent div while the <code>ov-d5</code> will set the overlay darkness transparency just as shown below: 
            <br><br>

            <div class="px-180 relative c-orange grid-center">
                <span style="margin-top:-30px">Hello in the back</span>
                <div class="overlay ov-d5 grid-center">
                    Hello in the front
                </div>
            </div>

            <br>
            In the code above, the "Hello in the back" stays at the back of the overlaying element while "Hello in the front" stays in the front.
        </span>

    </div> <br>

@template;