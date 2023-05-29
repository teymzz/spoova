@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">FileUploader</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="">

                        <div class="">
                            The FileUploader class is used for uploading files.
                            The following are the available methods in the class.
                        </div> <br>

                            <ul>
                            <li> <a href="#start" class="c-olive ch-olive-dd"> start </a> </li>
                            <li> <a href="#filesize" class="c-olive ch-olive-dd"> filesize </a> </li>
                            <li> <a href="#getfilename" class="c-olive ch-olive-dd"> GetFileName </a> </li>
                            <li> <a href="#getfiletype" class="c-olive ch-olive-dd"> GetFileType </a> </li>
                            <li> <a href="#getfilesize" class="c-olive ch-olive-dd"> GetFileSize </a> </li>
                            <li> <a href="#getfiletemp" class="c-olive ch-olive-dd"> GetFileTemp </a> </li>
                            <li> <a href="#getfileerror" class="c-olive ch-olive-dd"> GetFileError </a> </li>
                            <li> <a href="#getfiledata" class="c-olive ch-olive-dd"> GetFileData </a> </li>
                            <li> <a href="#uniquefile" class="c-olive ch-olive-dd"> uniqueFile </a> </li>
                            <li> <a href="#uploadfile" class="c-olive ch-olive-dd"> uploadFile </a> </li>
                            <li> <a href="#response" class="c-olive ch-olive-dd"> response </a> </li>
                            <li> <a href="#reconstruct" class="c-olive ch-olive-dd"> reconstruct </a> </li>
                            </ul>
                            
                        </div> 
                    </div>  

                    <div class="">
                        For the purpose of this documentation we shall be using the following sample data
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
                            <div class=" fb-6 flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
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
                                <div class="pxv-6 bc-off-white">Sample: Initializing Input</div>
                                <pre class="pre-code">
    $FileUploader  = new FileUploader;
                                </pre>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div> <br>

                    <div id="start" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> start
                                </div>
                            </div>
                            <div class="">
                            The <code>start</code> method is used to set parameters 
                            into the input class.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: start</div>
                                    <pre class="pre-code">
    $FileUploader->start($files, $type);
    <span class="comment no-select">
      where:
            
       $files: $_FILES or files data array
       $type: When set as 'image', it allows internal validation of images selected.
    </span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: setting files</div>
                                <pre class="pre-code">
    $FileUploader->start($_FILES); <span class="comment">// set files for upload</span>

    $FileUploader->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>
                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="filesize" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> filesize
                                </div>
                            </div>

                            <div class="">
                                The <code>filesize()</code> method sets the maximum number of 
                                bytes the files uploaded must not exceed <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: filesize</div>
                                        <pre class="pre-code">
    $FileUploader->filesize($size); 
        <span class="comment">
      where:
            
        $size: maximum file size in bytes
        </span>
                                        </pre>
                                    </div>
                                </div>    

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: filesize</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES);

    $FileUploader->filesize(2000000); <span class="comment"> // 2mb</span>                            
                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfilename" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileName
                                </div>
                            </div>

                            <div class="">
                                This method returns the file name of the currently set file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileName</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileName(); <span class="comment"> // returns name of file</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileName</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileName(); <span class="comment"> // returns Foo</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletype" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileType
                                </div>
                            </div>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileType</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileType(); <span class="comment"> // returns type of file </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileType</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileType(); <span class="comment"> // image/png</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfilesize" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileSize
                                </div>
                            </div>
                            <div class="">
                                This method returns the size of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: GetFileSize</div>
                                        <pre class="pre-code">
    $FileUploader->GetFileSize(); <span class="comment"> // returns size of file </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: GetFileSize</div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileSize(); <span class="comment"> // 5000000</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletemp" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileTemp
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>tmp_name</code> of current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileTemp</div>
                                    <pre class="pre-code">
    $FileUploader->GetFileTemp(); <span class="comment"> // returns the temporary directory of file </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileTemp</div>
                                    <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileTemp(); <span class="comment"> // /tmp/files/image.png</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfileerror" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileError
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>error</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileError</div>
                                    <pre class="pre-code">
  $FileUploader->GetFileError(); <span class="comment"> // returns the current file error </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileError</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');
  $FileUploader->GetFileError(); <span class="comment"> // returns null</span>
                                    </pre>
                                </div>
                            </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiledata" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> GetFileData
                                </div>
                            </div>
                            <div class="">
                            This method returns the <code>data</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: GetFileData</div>
                                    <pre class="pre-code">
  $FileUploader->GetFileData(<span class="c-orange-dd">bool</span>); <span class="comment"> //  returns string of supplied data </span>
    <span class="comment">
    where: 

      <span class="c-orange-dd">bool</span> : boolean of true adds the new directory and new file name of an uploaded file to the data string returned.
    </span>                         </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: GetFileData</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');
  $FileUploader->GetFileData(); <span class="comment"> //list $_FILES as string</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="uniquefile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uniqueFile
                                </div>
                            </div>
                            <div class="">
                            This function directs the uploader class to upload a file with a unique new name 
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: uniqueFile</div>
                                    <pre class="pre-code">
  $FileUploader->uniqueFile($param); 
    <span class="comment">
    where :

      $param : <span class="c-orange">true</span> permits a unique output name
                 <span class="c-orange">false</span> keeps the source file name
                 <span class="c-orange">string</span> sets a new output name. 
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: uniqueFile</div>
                                    <pre class="pre-code">
  $FileUploader->start($_FILES);

  $FileUploader->uniqueFile(); <span class="comment">// generate a new output name</span>
  $FileUploader->uniqueFile(false); <span class="comment">// keep source name</span>
  $FileUploader->uniqueFile('foo'); <span class="comment">// use a unique output name foo</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="uploadfile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> uploadFile
                                </div>
                            </div>

                            <div class="">
                                This method executes the upload directive. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: uploadFile</div>
                                        <pre class="pre-code">
  $FileUploader->uploadFile($validFiles, $destination, $makedir); <span class="comment"> // returns : true if file was uploaded</span> 
    <span class="comment"> 
    where :

       $validFiles: array list of valid or acceptable extensions.
       $destination: destination path of uploaded file.
       $makedir: bool of true creates a new directory if it does not already exist.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: uploadFile</div>
                                        <pre class="pre-code">

  $FileUploader->start($_FILES, 'image');

  $FileUploader->uploadFile(['jpg','png'], dirname(__FILE__).'/images', true); 
    <span class="comment">// 1. upload only files with jpg or png extensions</span>
    <span class="comment">// 2. upload into destination path supplied </span>
    <span class="comment">// 3. create directory of destination if it does not exist</span>

                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="response" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> response
                                </div>
                            </div>

                            <div class="">
                                The <code>response</code> returns the response of the processes executed. This 
                                may be good for code debugging
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: response</div>
                                        <pre class="pre-code">
  $FileUploader->start($_FILES, 'image');

  $upload = $FileUploader->uploadFile(['jpg','png'], dirname(__FILE__).'/images', true); 

  if($upload){

      <span class="comment">//file uploaded successfully</span>

  } else {
        
      var_dump( $FileUploader->response() ); //return the upload response.

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="reconstruct" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange-dd"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> reconstruct
                                </div>
                            </div>
                            <div class="">
                                The <code>reconstruct</code> method is used to restructure multiple files for upload
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: reconstruct</div>
                                        <pre class="pre-code">
  $FileUploader->reconstruct($data);
    <span class="comment no-select"> 
    where : 

      $data: array of multiple files
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: reconstruct</div>
                                        <pre class="pre-code">
  <span class="c-olive-dd">
  $_FILES['name'][0]  = 'Foo'; 
  $_FILES['name'][1]  = 'Bar';   

  $_FILES['type'][0]  = 'image/png'; 
  $_FILES['type'][1]  = 'image/png'; 

  $_FILES['size'][0]  = 5000000; //5mb
  $_FILES['size'][1]  = 2000000; //2mb

  $_FILES['tmp_name'][0]   = '/tmp/files/foo.png'; 
  $_FILES['tmp_name'][1]   = '/tmp/files/bar.png'; 
    
  $_FILES['error'][0] = ''; 
  $_FILES['error'][1] = ''; 
  </span>

  $files = $FileUploader->reconstruct($_FILES);

  var_dump($files); 
    
  <span class="c-dry-blue">//The above returns: </span>
    <span class="comment">
      [
        
        0 => [
            'name'     => 'Foo'; 
            'type'     => 'image/png'; 
            'size'     => 5000000; 
            'tmp_name' => '/tmp/files/foo.png';
            'error'    => ''; 
        ],
    
        1 => [
            'name'     => 'Bar'; 
            'type'     => 'image/png'; 
            'size'     => 2000000; 
            'tmp_name' => '/tmp/files/bar.png';
            'error'    => ''; 
        ],

      ] 
    </span>
                                        </pre>
                                    </div>
                                </div>
                        
                                <div class="foot-note pvs-10">
                                    This method makes it easier to organize files for upload. Then upload can be done easily by:
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>...continued</code></div>
                                        <pre class="pre-code">
  <span class="comment">... using previous data</span>

  $files = $FileUploader->reconstruct($_FILES);

  foreach( $files as $file ) {
  
      $FileUploader->start($file, 'image');
      $FileUploader->uniqueFile();
  
      if($FileUploader->uploadFile(['jpg', 'png'])) {
  
          <span class="comment">//upload successful</span>
  
      } else {
  
          var_dump( $FileUploader->response() );
  
      }
  
  }
    </span>
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