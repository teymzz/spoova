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
            <div class="wid-fit c-olive font-em-1d5">Images and Thumbnails</div>
        </span>

    </div> <br>

    <div class="padd-x-4 font-em-d87">

        <span class="">
            The class <code>"image-thumb"</code> can be used to access the thumbnail class properties which are useful when designing images. 
            The image below is an example of thumbnail: <br>

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    An example of image thumbnail 
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="@images('bkg.jpg')">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri">Study</div>
                    </div>
                </div>
            </div>

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 1</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="@images('bkg.jpg')"&gt;

        &lt;div class="image-label ov-d5 c-white c-silver calibri" data-anime="slide-up">Study&lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br><br>

            <div class="">
                In the code above, 
                
                <ul class="pxl-20">
                    <li>
                        <code>image-thumb</code> parent class defines the thumbail box. 
                    </li>
                    <li>
                        <code>image</code> direct child class defines the thumbail box. 
                    </li>
                    <li>
                        <code>image-label</code> class defines the image label. 
                    </li>
                    <li>
                        A height of 180 pixels was set on the <code>image</code> element. 
                        This height defines the entire height of the thumbnail's image excluding any external padding
                    </li>
                </ul>

            </div>
        </span>

    </div>
    
    <div class="padd-x-4 font-em-d87">

        <span class="">
            <div class="wid-fit c-olive font-em-1d5">Slide-up Labels</div>
        </span>

        <div class="">
            By adding the attribute <code>data-anime="slide-up"</code> to labels, the label will only be displayed once the class name <code>slide-up</code> 
            is added to it. This can be done using javascript. Howvever, another way to achieve a slide-up without using javascript is to set the class of the 
            image label to "on-hover" just as shown below. 

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 2</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="@images('bkg.jpg')"&gt;

        &lt;div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up">Study&lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br> <br>      

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    Hover on image to display label
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="@images('bkg.jpg')">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up">
                            Study
                        </div>
                    </div>
                </div>
            </div> <br>

            When there are large overflowing texts, the <code>data-anime="slide-up-scroll"</code> may be preferred over the normal slide up  as show below.

            <div class="pre-area mvt-10 rad-4 flow-hide shadow">
                <div class="code p10 bc-silver">sample code structure 3</div>
    <pre class="pre-code">
  &lt;div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10"&gt;

    &lt;div class="image b-cover px-180" data-src="@images('bkg.jpg')"&gt;

        &lt;div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">

            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Vitae molestias voluptates nam necessitatibus obcaecati, 
            culpa libero eaque distinctio praesentium cumque provident 
            quis iste omnis laboriosam vero labore voluptatem explicabo consectetur.
            
        &lt;/div&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
    </pre>
            </div><br> <br> 

            <div class="bc-silver rad-4 pxv-10 shadow">
                <div class="pxv-10 bc-silver-d">
                    Effect of "slide-up-scroll"
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="@images('bkg.jpg')">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                        </div>
                    </div>
                    Non-Overflowing Text
                </div>
                <div class="image-thumb bd-1 bd bd-red pxv-10 mvt-10">
                    <div class="image b-cover px-180" data-src="@images('bkg.jpg')">
                        <div class="image-label on-hover ov-d5 c-white c-silver calibri" data-anime="slide-up-scroll">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                            Vitae molestias voluptates nam necessitatibus obcaecati, 
                            culpa libero eaque distinctio praesentium cumque provident 
                            quis iste omnis laboriosam vero labore voluptatem explicabo consectetur.                            
                        </div>
                    </div>
                    Overflowing Text
                </div>
            </div>

        </div>

    </div> <br>
    
    <div class="padd-x-4 font-em-d87">

        <span class="">
            <div class="wid-fit c-olive font-em-1d5">Background Image positioning</div>
        </span>

        <div class="">
            The classes <code>b-cover</code>, <code>b-contain</code> are used to set image background-size 
            property to <code>cover</code> and <code>contain</code> respectively. Each of these classes have a 
            background-repeat set to <code>no-repeat</code>. Other classes under this are listed below: 
            <br>
            <ul class="mvt-10">
                <li><code>b-center</code> -  sets the background image to "center top" position</li>
                <li><code>b-fluid</code> - auto fits background images based on screen size.</li>
                <li><code>b-parallax</code> - gives a parallax effect on images</li>
                <li><code>b-clip</code> - sets background-clip property to "padding-box"</li>
                <li><code>im-fixed</code> - sets background-attachment property to "fixed"</li>
            </ul>
            
            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-center" data-src="@images('bkg.jpg')"></div>
                b-center
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover" data-src="@images('bkg.jpg')"></div>
                b-cover
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover" data-src="@images('bkg.jpg')"></div>
                b-cover
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-contain" data-src="@images('bkg.jpg')"></div>
                b-contain
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-parallax" data-src="@images('bkg.jpg')"></div>
                b-parallax
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-fluid" data-src="@images('bkg.jpg')"></div>
                b-fluid
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d b-cover b-clip" data-src="@images('bkg.jpg')"></div>
                b-cover b-clip
            </div>

            <div class="box pxv-10 bc-silver mxv-6">
                <div class="px-200 bc-silver-d im-fixed" data-src="@images('bkg.jpg')"></div>
                im-fixed
            </div>

        </div>

    </div> <br>

@template;