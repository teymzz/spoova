@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">ImageClass</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            The <code>ImageClass</code> is an extension of the <a href="@domurl('docs/classes/fileuploader')">FileUploader</a>  class. All methods 
                            belonging to the FileUploader can be applied on the ImageClass. Other available methods 
                            are:
                        </div> <br> 

                            <ol>
                                <li> <a href="#setimage"> setImage </a> </li>
                                <li> <a href="#setwidth"> setWidth </a> </li>
                                <li> <a href="#resizeimage"> resizeImage </a> </li>
                                <li> <a href="#runimage"> runImage </a> </li>
                                <li> <a href="#imagedisplay"> imageDisplay </a> </li>
                                <li> <a href="#imagedelete"> imageDelete </a> </li>
                                <li> <a href="#check_jpeg"> check_jpeg </a> </li>
                                <li> <a href="#newdata"> newData </a> </li>
                                <li> <a href="#imagedestroy"> imageDestroy </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following data
                        <br><br>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>test data</code></div>
                                <pre class="pre-code">
<span class="c-green"> 
    $_FILES['name']  = 'Foo'; 
    $_FILES['type']  = 'image/png'; 
    $_FILES['size']  = 5000000; //5mb
    $_FILES['tmp_name']   = '/tmp/files/image.png'; 
    $_FILES['error'] = ''; 
</span>
                                </pre>
                            </div>
                        </div> 
                    </div> <br>

                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> initializing class
                                </div>
                            </div> <br>
                            <div class="">
                                The file uploader class can be easily initialized as shown below.
                                <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Sample: Initializing ImageClass</code></div>
                                        <pre class="pre-code">
    $ImageClass  = new ImageClass;
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="start" class="">
                        <div class="">
                            <div class="">
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: start</code></div>
                                        <pre class="pre-code">
    $ImageClass->start($files, $type);
    <span class="comment no-select">
      where:
        
       <span class="c-sky-blue-dd">$files:</span> $_FILES or files data array
       <span class="c-sky-blue-dd">$type:</span> type of file. options [file|image]. An option 'image' allows internal processing of images supplied.
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>

                        We shall be looking at a series of examples below.
                        <br><br>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setting files</code></div>
                                <pre class="pre-code">
    $ImageClass->start($_FILES); <span class="comment">// set files for upload</span>

    $ImageClass->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>

    $destination = "images/";

    if( $ImageClass->uploadFiles(['jpg']) ) {
        $newFileName = $ImageClass->newfile;
    }else{
        $newFileName = '';
    }

    $newFilePath = $destination.'/'.$newFileName;

                                </pre>
                            </div>
                        </div>
                    
                    </div> <br>

                    <div id="setimage" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> setImage
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>setImage()</code> sets an image for processing<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Syntax: setImage</code></div>
                                <pre class="pre-code">
    $ImageClass->setImage($path); 
    <span class="comment">
      where:
        
        <span class="c-sky-blue-dd">$path:</span> path of image
    </span>
                                </pre>
                            </div>
                        </div>    

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setImage</code></div>
                                <pre class="pre-code">
    $ImageClass->setImage($newFilePath);                         
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="setwidth" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> setWidth
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>setwidth()</code> sets the output width of an image<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Syntax: setWidth</code></div>
                                <pre class="pre-code">
    $ImageClass->width($width, $height, $quality, $fileOut); 
    <span class="comment">
      where:
        
       <span class="c-sky-blue-dd">$width:</span> image width in pixels
       <span class="c-sky-blue-dd">$height:</span> image height in pixels
       <span class="c-sky-blue-dd">$quality:</span> optional image quality from 0 - 9. Nine is the maximum.
       <span class="c-sky-blue-dd">$fileOut:</span> optional output file name.
    </span>
                                </pre>
                            </div>
                        </div>    

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setWidth</code></div>
                                <pre class="pre-code">
    $ImageClass->setWidth(500, 500, 9);                         
                                </pre>
                            </div>
                        </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="resizeimage" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> resizeImage
                                </div>
                            </div> <br>
                            <div class="">

                                This method returns is used to resize an image.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: resizeImage</code></div>
                                        <pre class="pre-code">
    $ImageClass->resizeImage(); <span class="comment"> // sets image class activity </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: resizeImage </code></div>
                                        <pre class="pre-code">
    $ImageClass->setImage($newFilePath);
    $ImageClass-setWidth(500, 500, 9);
    $ImageClass->resizeImage();
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="runimage" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> runImage
                                </div>
                            </div> <br>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: runImage</code></div>
                                        <pre class="pre-code">
    $ImageClass->runImage(); <span class="comment"> // executes the activity declared. </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: runImage</code></div>
                                        <pre class="pre-code">
    $ImageClass->setImage($newFilePath);
    $ImageClass-setWidth(500, 500, 9);
    $ImageClass->resizeImage();
    $ImageClass->runImage(); <span class="comment">// executes the image resize previously declared</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="imagedisplay" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> imageDisplay
                                </div>
                            </div> <br>

                            <div class="">
                                This method displays the processed image to the screen using the html img tag.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: imageDisplay</code></div>
                                        <pre class="pre-code">
    $ImageClass->imageDisplay(); <span class="comment"> // prints the image to screen </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: imageDisplay</code></div>
                                        <pre class="pre-code">    
    $ImageClass->setImage($newFilePath);
    $ImageClass-setWidth(500, 500, 9);
    $ImageClass->resizeImage();
    
    if($ImageClass->runImage()) {

        echo( $ImageClass->imageDisplay() ); <span class="comment no-select">// displays array data of file. </span>

    }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="imagedelete" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> imageDelete
                                </div>
                            </div> <br>
                            <div class="">
                                This method safely deletes an image if it exists without throwing an error. It returns true if image 
                                was deleted and false if the image was not able to delete or does not exists.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: imageDelete</code></div>
                                        <pre class="pre-code">
    $ImageClass->imageDelete($path); <span class="comment"> // returns true or false. </span>
    <span class="comment">
      where : 

       $path: Optional relative path of image. If not provided, uses relative path defined in <code class="c-orange-dd">setImage()</code> method.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: imageDelete</code></div>
                                        <pre class="pre-code">
    $ImageClass->setImage($newFilePath);   <span class="comment">set image relative path</span> 

    if( $ImageClass->imageDelete() ) {

        <span class="comment">//image deleted successfully</span>

    }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="check_jpeg" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> check_jpeg
                                </div>
                            </div> <br>
                            <div class="">
                                This method tries to detect if a jpeg image is bad.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: check_jpeg</code></div>
                                        <pre class="pre-code">
    $ImageClass->check_jpeg($filepath, $fix); <span class="comment"> // returns true or false </span>
    <span class="comment">
      where : 
        
       $filepath: path of image file 
       $fix: a bool of true tries to fix the image if possible.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: check_jpeg</code></div>
                                        <pre class="pre-code">
    if( $ImageClass->check_jpeg($newFilePath) ) {

        <span class="comment">jpeg file seems okay.</span>

    }
 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="newdata" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">8.</span>
                                    </span> newdata
                                </div>
                            </div> <br>
                            <div class="">
                                This method returns the <code>data</code> for current processed file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: newData</code></div>
                                        <pre class="pre-code">
    $ImageClass->newData(); <span class="comment"> //  returns array data of valid file or empty array </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: newData</code></div>
                                        <pre class="pre-code">
    $ImageClass->setImage($newFilePath);
    $ImageClass-setWidth(500, 500, 9);
    $ImageClass->resizeImage();
    
    if($ImageClass->runImage()) {

        var_dump( $ImageClass->newData() ); <span class="comment no-select">// displays array data of file. </span>

    }
                                      </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="imagedestroy" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">9.</span>
                                    </span> uniqueFile
                                </div>
                            </div> <br>
                            <div class="">
                            This function directs the image class to destroy previous activity
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: imageDestroy</code></div>
                                    <pre class="pre-code">
    $ImageClass->imageDestroy();
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: imageDestroy</code></div>
                                    <pre class="pre-code">    
    $ImageClass->setImage($newFilePath);
    $ImageClass-setWidth(500, 500, 9);
    $ImageClass->resizeImage();
    
    if($ImageClass->runImage()) {

        $data = $ImageClass->newData();
        $ImageClass->imageDestroy();

    }
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                    </div>
                    
                @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
                
    @lay('build.co.coords:footer')

@template;