@template('docs.integerations.template.co.format')

    @title('Css Integerations - Forms')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <div class="font-em-d87">
            <div class="wid-fit c-olive font-em-1d5">Forms and Form Alignments</div>
            <div class="">
                Forms are mostly controlled using the <code>i-flex</code> class, although 
                <code>in-flex</code> and <code>flex</code> can also be applied. Other special 
                classes included <code>flex-full</code>, <code>flex-btn</code>, 
                <code>i-flex-btn</code> and <code>flex-child</code> classes.
            </div>
            <br>
            <ul class="mvt-10">
                <li><code>i-flex</code> -  sets input field up with flex properites</li>
                <li><code>i-flex-full</code> - sets input field up with flex properites at 100% width </li>
                <li><code>flex-btn</code> - used on form buttons </li>
                <li><code>flex-full</code> - applied on any form field</li>
            </ul>

            <div class="">
                Since these flex classes have the properties of a <code>flex</code> display type, utility classes 
                like <code>f-row</code> (or <code>flex-row</code> ) and <code>f-col</code> (or <code>flex-col</code>)
                can be applied on them. The example below defines how to set up a form input field using these predefined  
                classes.
            </div> <br>

            <div class="">

                <div class="bc-silver sample">
                    <div class="bc-silver-d pxv-6">Form Input with <span class="c-teal">flex</span> property</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex" placeholder="firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
    print to_lgts('<input type="text" class="i-flex" placeholder="firstname">');
  @php;

 </pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bc-silver sample">
                    <div class="bc-silver-d pxv-6">Form Input with <span class="c-teal">i-flex-full</span> property</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex-full" placeholder="firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
    print to_lgts('<input type="text" class="i-flex-full" placeholder="firstname">');
  @php;

 </pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mvt-10">
                    The <code>input</code> field's height above can be increased by setting a padding on the <code>input</code>
                    field itself just as shown: below
                </div> <br>

                <div class="bc-silver sample">
                    <div class="bc-silver-d pxv-6">Form Input with padding (10 pixels)</div>
                    <div class="pxv-10">
                        <input type="text" class="i-flex-full pxv-10" placeholder="firstname"> <br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
    print to_lgts('<input type="text" class="i-flex-full pxv-10" placeholder="firstname">');
  @php;

 </pre>
                            </div>
                        </div>
                    </div>
                </div>                

                <div class="mvt-10">
                    In the code above, although we applied padding of "10 pixels" to all sides, only the top and bottom paddings were 
                    added. In situations we need to control the entire element padding, we can use a wrapper instead just shown as below: 
                </div> <br>


                <div class="bc-silver sample">
                    <div class="bc-silver-d pxv-6">Wrapping Form Input</div>
                    <div class="pxv-10">
                        <div class="i-flex-full bc-white pxs-4">
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="firstname"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-10">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full bc-white pxs-4">
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="firstname"> <br><br>
  </div>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>                    

                <div class="mvt-10">
                    Yeah, That's it! Just by wrapping our <code>input</code> in a <code>div</code> with class <code>i-flex</code> 
                    or <code>i-flex-full</code>, we have been able to control the side margins. Also, in order to achieve this, the <code>input</code> 
                    was defined with a transparent white background while the parent <code>div</code> was given the desired background color. This means that 
                    our input can inherit its background color from the parent element. Aside from background colors and margins, wrapping our <code>input</code> 
                    elements in a div is the most ideal way to set up form inputs as it give us a lot of flexibilites with other properties. 
                    The code below reveals how to attach a side button to a form input element.
                </div> <br>

                <div class="bc-silver sample">
                    <div class="bc-silver-d pxv-6"> Form Input with side button (left) </div>
                    <div class="pxv-10">
                        <div class="i-flex-full bc-white">
                           <span class="flex-ico bc-silver pxs-12">
                            <span class="ico-envelope"></span>
                           </span> 
                           <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full bc-white">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span> 

    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

  </div><br><br>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>  


                <div class="mvt-10">
                    The input design above will not be possible without an input wrapper. Which makes it easier to position 
                    our input icon (i.e <code>flex-ico</code>). Since the <code>input</code> exists at an 100% width, we can  
                    shift our icon to the right side of the input item and this will still work fine. This is show below: <br>
                </div>     
                

                <div class="bc-silver sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form Input with side button (right) </div>
                    <div class="pxv-10">
                        <div class="i-flex-full bc-white pxl-4">
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full bc-white pxl-4">
      
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span> 

  </div><br><br>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>
                    </div>
                </div>  

                
                <div class="mvt-10">
                    In the code above, when we switched our icon, notice that the wrapper <code>div</code> 
                    was given a left padding to push the input button a bit towards right side. Without applying 
                    the left padding, the <code>input</code> may look closer to the left than usual.
                </div> <br>
                
                <div class="mvt-10">
                    Now, that we successfully understand the effect of our utility classes and how to apply them, wouldn't 
                    it be nicer to build a round input button with an icon? Let's do that: <br>
                </div> 

                <div class="bc-silver sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form round input field with button </div>
                    <div class="pxv-10">
                        <div class="i-flex-full-in rad-r bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                        </div><br><br>
                        <div class="bc-white-dd pxv-12">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full-in rad-r bc-white">

    <span class="flex-ico bc-silver pxs-10">
        <span class="ico-envelope"></span>
    </span>       
    
    <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com">

  </div><br><br>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>
                    </div>
                </div> 
             
                <div class="mvt-10">
                    Now is the moment to talk about <code>i-flex-in</code> and <code>i-flex-full-in</code>  
                    utility classes. In most times, when we have an overflowing flex child, it is better to use 
                    the <code>i-flex-in</code> or <code>i-flex-full-in</code> classes or we could just add the 
                    <code>flow-hide</code> property to keep our content within the parent element. These classes 
                    are branded with the feature of an <code>overflow:hidden;</code> property. Rather than apply the 
                    <code>flow-hide</code> property on <code>i-flex</code> or <code>i-flex-full</code>, the <code>i-flex-in</code> 
                    and <code>i-flex-full-in</code> helps to provide a shorter method of combining both properties.
                </div> 

            </div>   <br>

            <!-- Heading -->
            <div class="wid-fit c-olive font-em-1d5"><span class="bi-circle-fill c-silver-d mxr-6"></span>Form Fields</div>

            <div class="">
                Form fields are mostly needed for stacking form inputs together either as rows or as columns. At most 
                times, forms inputs are usually aligned on separate lines. Naturally, the utility classes does not define vertical 
                spaces or gaps of form input fields. Howvever, when a class of <code>form-field</code> is applied on the form input's 
                direct parent element, the css library will understand that each form field is expected to have a vertical spacing just as below: 


                <div class="bc-silver sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form input fields without a parent "form-field" </div>
                    <div class="pxv-10">

                        <div class="i-flex-full-in bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-envelope"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                        </div>
                        <div class="i-flex-full-in bc-white shadow-1">
                            <span class="flex-ico bc-silver pxs-12">
                             <span class="ico-plane"></span>
                            </span> 
                            <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
                        </div>

                        <div class="bc-white-dd pxv-12">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-envelope"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
  </div>
  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-plane"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
  </div>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>
                    </div>
                </div> <br>

                <div class="">
                    In the code above, the forms a aligned next to each other without a space. In order to add a space, 
                    we have to define the <b class="c-orange">form field</b> itself as shown below:
                </div><br>

                

                <div class="bc-silver sample mvt-6">
                    <div class="bc-silver-d pxv-6"> Form input fields with a direct parent "form-field" </div>
                    <div class="pxv-10">

                        <div class="form-field">
                            <div class="i-flex-full-in bc-white shadow-1">
                                <span class="flex-ico bc-silver pxs-12">
                                 <span class="ico-envelope"></span>
                                </span> 
                                <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
                            </div>
                            <div class="i-flex-full-in bc-white shadow-1">
                                <span class="flex-ico bc-silver pxs-12">
                                 <span class="ico-plane"></span>
                                </span> 
                                <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
                            </div>
                        </div>

                        <div class="bc-white-dd pxv-12">
                            <div class="no-select c-grey">code structure</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-envelope"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="email@example.com"> <br><br>
  </div>
  <div class="i-flex-full-in bc-white shadow-1">
      <span class="flex-ico bc-silver pxs-12">
          <span class="ico-plane"></span>
      </span> 
      <input type="text" class="i-flex-full bc-white bco-10" placeholder="address"> <br><br>
  </div>
  ');
  @php;
 
 </pre>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mvt-6">
                    We can also add spaces with direct parents having any of the <code>sp-d5</code>, <code>sp-d7</code> 
                    or <code>sp-1</code> classes with <code>sp-1</code> being the highest number of vertical spaces we can
                    add for form input fields. 
                </div>
                    
            </div> <br>


            
            <!-- Heading -->
            <div class="wid-fit c-olive font-em-1d5"><span class="bi-circle-fill c-silver-d mxr-6"></span>Form Animations</div>
            
            There are basically two animations that can be applied on the form inputs or placeholders. In order to set a transition 
            on the form inputs, the utility class <code>anime-place</code> must be added to the form field wrapper. Examples are shown below: 
            <br><br>


            <div class="i-flex anime-place loaded">
                <input type="text" class="i-flex-full pxv-6" placeholder="Animation 1">
            </div>


            <div class="i-flex anime-place">
                <label for="anime-2" class="place">Animation 2</label>
                <input id="anime-2" type="text" class="i-flex-full pxv-6" placeholder="Animation 2">
            </div>


            <div class="i-flex anime-place loaded c-teal">
                <label for="anime-3" class="place">Animation 3</label>
                <input id="anime-3" type="text" class="i-flex-full pxv-6" placeholder="Animation 3">
            </div> <br>

            <div class="bc-white-dd pxv-12 shadow mvt-6">
                            <div class="no-select c-grey">code structure - Animation 1</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex anime-place loaded">
    <input type="text" class="i-flex-full pxv-6" placeholder="Animation 1">
  </div>
  ');
  @php;
 
 </pre>
                            </div>
            </div>

            <div class="bc-white-dd pxv-12 shadow mvt-6">
                            <div class="no-select c-grey">code structure - Animation 2</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex anime-place">
    <label for="anime-2" class="place">Animation 2</label>
    <input id="anime-2" type="text" class="i-flex-full pxv-6" placeholder="Animation 2">
  </div>
  ');
  @php;
 
 </pre>
                            </div>
            </div>

            <div class="bc-white-dd pxv-12 shadow mvt-6">
                            <div class="no-select c-grey">code structure - Animation 3</div>
                            <div class="pre-area">
 <pre class="pre-code">
  @php:
  print to_lgts('
  <div class="i-flex anime-place loaded">
    <label for="anime-3" class="place">Animation 3</label>
    <input id="anime-3" type="text" class="i-flex-full pxv-6" placeholder="Animation 3">
  </div>  
  ');
  @php;
 
 </pre>
                            </div>
            </div>

            <div class="">

                In the codes above, when the <code>loaded</code> utility class is added 
                along with the <code>anime-place</code> attribute, the bottom 
                line is also animated. However, to animate the placeholder, there must be a direct 
                sibling of the input field with the class of <code>"place"</code> which has a text value 
                that is equal to the value of the input's placeholder just as shown above. 
            </div>

        </div>  
        


    </div> <br>

@template;