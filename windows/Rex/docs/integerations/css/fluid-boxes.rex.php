@template('docs.integerations.template.co.format')

    @title('Css Integerations - Fluid Boxes')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    
    <div class="padd-x-4"> <br>
                
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Fluid Boxes</div>
            Fluid boxes are different from container boxes. Fluid boxes are elements (mostly div) whose height and width are rendered 
            in respect to the percentage of the current screen size. The height is usually depedent on the width of the box itself. In this case, only the
            width of the box needs to be defined while the height has been predefined. 
            In order to keep this box responsive based on devices, three device widths variable 
            <code>--fluid-1:</code>, <code>--fluid-2:</code>, <code>--fluid-3:</code> must be defined
            The <code>--fluid-1</code> variable is applied on mobile screens, <code>--fluid-2</code> variable is applied on medium screens and 
            <code>--fluid-2</code> variable is used on screen size at minimum of 1025 pixels.
            <br>
<div class="pre-area bc-white-dd mvt-6 shadow">
    <div class="pxv-10 bc-silver-d">Example: Fluid Box</div>
 <pre class="pre-code">
  &lt;div 
        class="fluid-box" 
        src="@images('bkg.jpg')" 
        style="--fluid-1:2; --fluid-2:2.5; --fluid-3:3.5;"&gt;
  &lt;/div&gt;
 </pre>
</div>
                <div class="fluid-box b-fluid bc-silver" data-src="@images('bkg.jpg')" style="--fluid-1:2; --fluid-2:2.5; --fluid-3:3.5;">
                </div>

            

            <div class="">
                In the code above, the <code>fluid-control</code> controls the height of the image based on screen size. Also, the <code>img</code> tag can be replaced with <code>div</code> element.
            </div>
        </div>

    </div> <br>

@template;