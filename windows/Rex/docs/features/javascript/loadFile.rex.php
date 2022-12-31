
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

<div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-20 tutorial database bc-white">
        <div class="font-em-1d2">

            @lay('build.co.links:tutor_pointer')

            <div class="start font-em-d8">

                <div class="font-em-1d5 c-orange">Javascript Resources (loadFile.js)</div> <br>
                
                <div class="db-connection">
                    <div class="fb-6">Introduction</div>
                    This is a jquery dependent function used for validating or loading media file when selected through the 
                    html file input element based on specific data attribute instructions. <br>
                    
                    <div class="foot-note mvt-10">
                      <span class="head">Note:</span>
                      Although the resource file to handle this
                      feature is not enabled by default, it can be pulled in from the <code>res/res.php</code> core resource caller file. 
                      Simply add the <code>->url("js/loadFile.js")</code> into the resource headers within the <code>res/res.php</code> file 
                      and the <code>loadFile.js</code> file will be included when importing headers if it is available within the framework's specified path. Also, 
                      since <code>loadFile.js</code> might not be globally needed for all files, the <code>@(Res())@</code> is a good directive to help pull in a specific resource 
                      into a specific rex template file type.
                    </div>
                    <br>
<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Syntax : loadFile()</div>
  <pre class="pre-code">

  loadFile(target, parent, responseField)
  
  <span class="comment">
    where:

      target: target element selector
      parent: parent element selector
      parent: a response field selector
  </span>
  </pre>

    <div class="pxv-10 bc-sea-blue c-white">                        
      For <code class="c-white">loadFile</code> to work, it requires the help of a trigger button. Instead of clicking directly on the <code class="c-white">&lt;input type="file"&gt;</code> html 
      element, we have to click on a trigger button that can help us identify our button. This function suggest that both the <code class="c-white">&lt;input type="file"&gt;</code> element and its trigger 
      element (or button) must share the same parent element and only one single <code class="c-white">&lt;input type="file"&gt;</code> can be within that parent element just as below:
    </div>
</div> <br>
                    <div class="mvt-6">

                    </div>

                    <br>
<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">HTML Format 1: loadFile()</div>
  <pre class="pre-code">
  &lt;div&gt;
  
    &lt;input type="file" &gt;
    &lt;button onclick="loadFile(this)"&gt;click me&lt;button&gt;
  
  &lt;/div&gt;
  </pre>

    <div class="pxv-10 bc-sea-blue c-white">
        According to the code above, when the button is clicked, the <code class="c-white">input</code> file button will be triggered. This is because they share the same direct parent 
        which in this case is <code class="c-white">"div"</code>.
    </div>
</div> <br>

<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">HTML Format 2: loadFile()</div>
  <pre class="pre-code">  
  &lt;div class="super-parent"&gt;

    &lt;input type="file" hidden &gt;

    &lt;div class="direct-parent"&gt;
    
        &lt;button onclick="loadFile(this, '.super-parent')"&gt;click me&lt;button&gt;
    
    &lt;/div&gt;

  &lt;/div&gt;
  </pre>

    <div class="pxv-10 bc-sea-blue c-white">
        According to the code above, since the <code class="c-white">button</code> does not share the same direct parent with the <code class="c-white">input</code> button, then to locate this button we have to 
        select the "super-parent" with appropriate selector. This will allow the <code class="c-white">input</code> button to be triggered. Notice that the class selector <code class="c-white">"."</code> 
        was added before <code class="c-white">super-parent</code>. Also, in this case, the <code class="c-white">"super-parent"</code> for example, must contain only one single 
        <code class="c-white">&lt;input type="file"&gt;</code>.
        This relationhip makes it easy to use any html element as our <code class="c-white">button</code>. For example, instead of the <code class="c-white">button</code> element 
        used, we can replace it with an <code class="c-white">img</code> html element. The second argument of <code class="c-white">loadFile()</code> which selects the parent element also make it possible to select an 
        <code class="c-white">&lt;input type="file"&gt;</code> that does not share the same parent or super parent with the trigger button.
    </div>
</div> <br>

<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">HTML Format 3: loadFile()</div>
  <pre class="pre-code">  
  &lt;div class="super-parent"&gt;

    &lt;input type="file" hidden &gt;

    &lt;div class="direct-parent"&gt;
    
        &lt;button onclick="loadFile(this, '.super-parent', '.response-pane')"&gt;click me&lt;button&gt;

        &lt;div class="response-pane"&gt;&lt;/div&gt;

    &lt;/div&gt;

  &lt;/div&gt;
  </pre>

    <div class="pxv-10 bc-sea-blue c-white">
        The third argument supplied above is used mostly to display an error message encountered into a particular html field. It is important that the 
        response field should also have its relative selector. The response field should be given a unique name, so in this case we may favor the 
        <code class="c-white">"id"</code> attribute instead of class, then the selector <code>"."</code> will have to change to <code class="c-white">"#"</code>.
    </div>
</div> <br>
                </div> <br>
                

                <div class="">
                                <div class="font-em-d95 c-orange-dd">Working with images</div>                        
                                It is a commonly used practice to use images as buttons which, if clicked, triggers the dialog box. When a new image is selected, 
                                then the old image is replaced with the new one.<br> The <code>loadFile()</code> function supports this relationship. Whenever any 
                                element having <code>data-src</code> and <code>data-load="image"</code> attribute is used as a trigger button, the <code>loadFile()</code> will try 
                                to change the background image of that element based on the tag type. For example, if an element contains a <code>data-src</code> attribute, 
                                then the backround image url of such element will be changed. This also works for video elements too. However, in the case of video, 
                                <code>data-vsrc</code> attribute is employed instead of <code>data-src</code>. In this relationship, the parent class selector must be 
                                defined.
<div class="pre-area mvt-10 shadow">
  <div class="pxv-10 bc-silver">Example: Image Autoloading</div>
  <pre class="pre-code"><ul class="c-olive">
&lt;div class="parent"&gt;
    &lt;input type="file" hidden data-load="image" &gt;

    &lt;img src="old-image.png" onclick="loadFile(this, '.parent')" /&gt;
&lt;/div&gt;
  </pre>

  <div class="pxv-10 bc-sea-blue c-white">
    In the example above, if the image is clicked and a new file is selected, the <code class="c-white">"old-image.png"</code> will be replaced with the new file name. This is 
    because of the <code class="c-white">data-load</code> attribute which tells directs the trigger to try to load the selected file as an image. It is however important to define the type of 
    extensions allowed using the <code class="c-white">data-accept</code> attribute.
  </div>
</div> <br><br>                                

                            </div>

                <div class="">
                                <div class="font-em-d95 c-orange-dd">Reserved Attributes</div>                        
                                File-selection attributes are assiged to help in validation of files which are selected from the <code>&lt;input type="file"&gt;</code> html element. These attributes  
                                are listed below: <br>
<div class="pre-area mvt-10 shadow">
  <div class="pxv-10 bc-silver">File Loading Reserved Attributes</div>
  <pre class="pre-code"><ul class="c-olive">
        <li>data-size: <span class="comment no-select">For setting maximum file size (in kilobytes)</span></li>
        <li>data-accept: <span class="comment no-select">For setting valid file extensions</span></li>
        <li>data-load: <span class="comment no-select">Sets media autoload and autoload restrictions.

(options) 'image'        : assumes that button is an image and will try to change that image by replacing it with new image
          'image-strict' : if selected file extension is not in <code>data-accept</code> image will not be replaced.
          'im-strict-sz' : if selected file size is not valid or file is not in <code class="c-red">data-accept</code>,  image will not be replaced.</span></li>
          'video'        : assumes that button is a video element and will try to change that video by replacing it with new video
          'video-strict' : if selected file extension is not in <code>data-accept</code> vide will not be replaced.
          'vid-strict-sz': if selected file size is not valid or file is not in <code class="c-red">data-accept</code>,  video will not be replaced.</span></li>
        <li>data-strict: <span class="comment no-select">For enforcing value restriction. If file selected is not valid, the value will be automatically removed </span></li>
        <li>data-status: <span class="comment no-select">For storing upload status response</span></li>
        <li>data-msg: <span class="comment no-select">Stores the validation or file upload response message</span></li>
    </ul></pre>

  <div class="pxv-10 bc-sea-blue c-white">
    For any of these methods to be applied on the input(file), the <code class="c-white">onClick="loadFile(this)"</code> must be added to that input element. 
    Once these is done, the entire control of data supported can be managed using the previously defined attributes.
  </div>
</div> <br><br>                                

                            </div>

                            <div class="samples">


                                <div class="data-validation">

                                    <div class="font-em-d95 c-orange-dd">File Validation</div>   

                                    <div class="introduction">
                                        File validation can be applied through the <code>data-load</code>, <code>data-accept</code> and <code>data-strict</code> attributes. These attributes are 
                                        sometimes dependent on each other before a validation can be successfully made. Since it is natural that we may sometimes use images as click buttons because 
                                        we want the image to change when we select a file which is mostly used in profile pictures, the <code>loadFile()</code> function has been integerated for this 
                                        kind of operation. However, certain configurations or formats must be put in place to achieve this effect. These configurations are mostly done through the 
                                        reserved attributes mentioned earlier.<br>

                                    </div>


<div class="pre-area mvt-10 shadow">
  <div class="pxv-10 bc-silver">Example 1: File Selection (data-size)</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-size="1024" onclick="loadFile(this)" /&gt; 
  </pre>

  <div class="pxv-10 bc-sea-blue c-white">
    In the above, <code class="c-white">data-size="1024"</code> will set the file size at a limit of <span class="fb-6">1024 kilobytes.</span>. If the file size exceeds that, then the 
    <code class="c-white">data-msg</code> attribute will be added with a relative error message.
  </div>
</div> <br><br>

<div class="pre-area mvt-10 shadow">
  <div class="pxv-10 bc-silver">Example 2: File Selection (data-accept)</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-accept="jpg,png" onclick="loadFile(this)" /&gt; 
  </pre>

  <div class="pxv-10 bc-sea-blue c-white">
    In the above, <code class="c-white">data-accept="jpg,png"</code> will set the accepted file extension types as <code class="c-white">jpg</code> and <code class="c-white">png</code>. If the 
    file extension type is not valid, then <code class="c-white">data-msg</code> attribute will be added with a relative error message.
  </div>
</div> <br><br>

<div class="pre-area mvt-10 shadow shadow-1-strong">
  <div class="pxv-10 c-white bc-sea-blue">Attribute: data-load (format)</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-load="option" onclick="loadFile(this)" /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  <span class="c-olive">&lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt; 
  </pre>

  <div class="pxv-10 bc-silver c-olive">
    The <code class="c-whit">data-load</code> attribute is used to direct the trigger button to try to load the 
    selected file as media. If the trigger button has an attribute <code class="c-whit">data-src</code> then, when a file is selected, 
    <code class="c-whit">loadFile()</code> will try to add a background image to the trigger element. The <code class="c-whit">data-load</code> 
    element has many options and we will discuss each option using examples below:
  </div>
</div> <br><br>


<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example 3a: File Selection (data-load="image")</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-load="image" onclick="loadFile(this)" /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  &lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt;</span>
  </pre>
  <div class="pxv-10 c-white"  style="background-color:rgb(90, 102, 114)">
  In the above, once the trigger button is clicked, and file is selected, the <code class="c-white">"image"</code> option tells the trigger button to 
  try to load the selected item as an image. 
  </div>
</div> <br><br>


<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example 3b: File Selection (data-load="image-strict") or "im-strict"</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-accept="jpg" data-load="image-strict" onclick="loadFile(this)" /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  &lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt;</span>
  </pre>
  <div class="pxv-10 bc-sea-blue c-white" style="background-color:rgb(90, 102, 114)">
  The <code class="c-white">"image-strict"</code> or <code class="c-white">"im-strict"</code> option specifies that only selected valid image types 
  should be considered for loading. This means that background image will not change if the image is not a valid one. A valid image in this case 
  can only be identified through supplied file extension name(s). In respect to this, a <code class="c-white">data-accept</code> attribute must be 
  provided which specifies the file extension just as shown in example above.
  </div>
</div> <br><br>


<div class="pre-area shadow">
  <div class="pxv-10 bc-silver">Example 3c: File Selection (data-load="imsize-strict")</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-size="1024" data-accept="jpg" data-load="imsize-strict" onclick="loadFile(this)" /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  &lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt;</span>  
  </pre>
  <div class="pxv-10 bc-sea-blue c-white" style="background-color:rgb(90, 102, 114)">
    The <code class="c-white">"imsize-strict"</code> attribute directs the trigger to only load selected image whose file size is not more than the maximum file size. 
    This does not check the file extension type unless the <code class="c-white">data-accept</code> is provided. 
    For this to work, the <code class="c-white">data-size</code> should be used to specify the maximum file size required. The default maximum file size is <span class="fb-6">200 Kilobytes</span> 
  </div>
</div> <br><br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 3d: File Selection (data-load="im-strict-sz")</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-size="1024" data-accept="jpg" data-load="im-strict-sz" onclick="loadFile(this)" /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  &lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt;</span>  
  </pre>
  <div class="pxv-10 bc-sea-blue c-white" style="background-color:rgb(90, 102, 114)">
    The <code class="c-white">"im-strict-sz"</code> attribute directs the trigger to only load selected image whose file size is not more than the maximum file size and file extension 
    exists within the <code class="c-white">data-accept</code> attribute.
  </div>
</div> <br><br>

<div class="font-emd85">
  It is important to note that other <code>data-load</code> options with <code>vid</code> works similarly as the image except that they are supplied on video elements.
</div>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 4: File Selection (data-strict)</div>
  <pre class="pre-code">
  <span class="comment no-select">File Button:</span>
  <span class="c-olive">&lt;input type="file" data-size="1024" data-accept="jpg" data-load="im-strict-sz" onclick="loadFile(this)" data-strict /&gt; 

  <span class="comment no-select">Trigger Button:</span>
  &lt;img src="old-image.png" onclick="loadFile(this, '.parent')"  data-src /&gt;</span>  
  </pre>
  <div class="pxv-10 bc-sea-blue c-white">
    When a a selected file does not meet the requirement of validation rule (i.e not valid), the <code class="c-white">data-strict</code> ensures that the selected file is removed or 
    unset which nullifies the selection.
  </div>
</div> <br><br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 5: File Selection (data-status)</div>

  <div class="pxv-10 bc-sea-blue c-white">
  This attribute is added automatically to both the trigger and the input button. Whenever a select file is considered valid, 
  the <code class="c-white">data-status</code> attribute is added with a <code class="c-white">success</code> value. If the file is not valid, the value will be set as 
  <code class="c-white">"failed"</code>. 

  </div>
</div> <br><br>

<div class="pre-area">
  <div class="pxv-10 bc-silver">Example 5: File Selection (data-msg)</div>

  <div class="pxv-10 bc-sea-blue c-white">
  Just like the <code class="c-white">data-status</code> attribute, <code class="c-white">data-msg</code> is  added automatically to both the trigger and the input button 
  after file selection. Rather than a <code class="c-white">"success"</code> or <code class="c-white">"error"</code> response message through the <code class="c-white">data-status</code>, 
  attribute, the <code class="c-white">data-msg</code> is used to store a more descriptive message about why a selected file is invalid. For example, if an invalid file extension is selected,
  the <code class="c-white">data-msg</code> will contain a response of <code class="c-white">"invalid file"</code> and when the file size is large, it will contain the message <code class="c-white">large file!</code>  
  This attribute can also be used for storing feedback ajax response text messages manually depending on whether a file upload is successful or not. 
  </div>
</div> <br><br>
                                        
                                        <div class="parent hide">
                                            <input type="file" data-accept="png" data-load="image">
                                            <img data-src="" class="px-40 shadow b-cover" onclick="loadFile(this, '.parent')">
                                        </div>                                    
                              </div>


                                <!-- For example, In the above, 
    the <code class="c-white">data-load</code> attribute defined what kind of validation response the (file)input should use for selected file. 
    For example, <code class="c-white">im-strict-sz</code> is a directive that ensures that the selected file is a valid image file with extension name that can 
    be found within the <code class="c-white">"data-accept"</code> attribute. It also ensures that the file size is not above the specified file size. If for any  -->



                            </div> 

            </div>

        </div>
    </section>

    <script>
        hashRunner('data-scroll-hash');
    </script>
</div>
@template;