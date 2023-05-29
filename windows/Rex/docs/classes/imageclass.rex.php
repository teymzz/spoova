@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">ImageClass</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                            <div class="">
                                The <code class="bd-f">ImageClass</code> is an extension of the <a href="@domurl('docs/classes/fileuploader')" class="c-olive ch-olive-dd rule-dotted">FileUploader</a>  class. All methods 
                                belonging to the FileUploader can be applied on the ImageClass. Other available methods 
                                are:
                            </div> <br> 

                            <ul>
                                <li> <a href="#setimage" class="c-olive ch-olive-dd"> setImage </a> </li>
                                <li> <a href="#setwidth" class="c-olive ch-olive-dd"> setWidth </a> </li>
                                <li> <a href="#resizeimage" class="c-olive ch-olive-dd"> resizeImage </a> </li>
                                <li> <a href="#runimage" class="c-olive ch-olive-dd"> runImage </a> </li>
                                <li> <a href="#imagedisplay" class="c-olive ch-olive-dd"> imageDisplay </a> </li>
                                <li> <a href="#imagedelete" class="c-olive ch-olive-dd"> imageDelete </a> </li>
                                <li> <a href="#check_jpeg" class="c-olive ch-olive-dd"> check_jpeg </a> </li>
                                <li> <a href="#newdata" class="c-olive ch-olive-dd"> newData </a> </li>
                                <li> <a href="#imagedestroy" class="c-olive ch-olive-dd"> imageDestroy </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following data
                        <br><br>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">TEST DATA</div>
                                <pre class="pre-code">
<span class="c-sea-blue"> 
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
                            <div class="fb-6 bc-white-dd flex-full rad-4 pvs-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-lightning-fill"></span>
                                    </span> initializing class
                                </div>
                            </div>
                            <div class="">
                                The file uploader class can be easily initialized as shown below.
                                <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Sample: Initializing ImageClass</div>
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
                                        <div class="pxv-6 bc-off-white">Syntax: start</div>
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
                        </div>

                        <div class="foot-note">
                            We shall be looking at a series of examples below.
                        </div>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: setting files</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> setImage
                                </div>
                            </div>
                            <div class="">
                            The <code>setImage()</code> sets an image for processing<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Syntax: setImage</div>
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
                                <div class="pxv-6 bc-off-white">Example</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> setWidth
                                </div>
                            </div>
                            <div class="">
                            The <code>setwidth()</code> sets the output width of an image<br><br>

                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Syntax: setWidth</div>
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
                                <div class="pxv-6 bc-off-white">Example: setWidth</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> resizeImage
                                </div>
                            </div>
                            <div class="">

                                This method returns is used to resize an image.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: resizeImage</div>
                                        <pre class="pre-code">
  $ImageClass->resizeImage(); <span class="comment"> // sets image class activity </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: resizeImage </div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> runImage
                                </div>
                            </div>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: runImage</div>
                                        <pre class="pre-code">
  $ImageClass->runImage(); <span class="comment"> // executes the activity declared. </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: runImage</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> imageDisplay
                                </div>
                            </div>

                            <div class="">
                                This method displays the processed image to the screen using the html img tag.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: imageDisplay</div>
                                        <pre class="pre-code">
  $ImageClass->imageDisplay(); <span class="comment"> // prints the image to screen </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: imageDisplay</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> imageDelete
                                </div>
                            </div>
                            <div class="">
                                This method safely deletes an image if it exists without throwing an error. It returns true if image 
                                was deleted and false if the image was not able to delete or does not exists.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: imageDelete</div>
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
                                        <div class="pxv-6 bc-off-white">Example: imageDelete</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> check_jpeg
                                </div>
                            </div>
                            <div class="">
                                This method tries to detect if a jpeg image is bad.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: check_jpeg</div>
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
                                        <div class="pxv-6 bc-off-white">Example: check_jpeg</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> newdata
                                </div>
                            </div>
                            <div class="">
                                This method returns the <code>data</code> for current processed file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: newData</div>
                                        <pre class="pre-code">
  $ImageClass->newData(); <span class="comment"> //  returns array data of valid file or empty array </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: newData</div>
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
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uniqueFile
                                </div>
                            </div> 
                            <div class="">
                            This function directs the image class to destroy previous activity
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: imageDestroy</div>
                                    <pre class="pre-code">
  $ImageClass->imageDestroy();
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: imageDestroy</div>
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