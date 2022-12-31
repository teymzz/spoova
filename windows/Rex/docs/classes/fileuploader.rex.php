@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">FileUploader</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            FileUploader class is a special tool that is used for uploading files.
                            The following are the available methods in the class.
                        </div> <br>

                            <ol>
                            <li> <a href="#start"> start </a> </li>
                            <li> <a href="#filesize"> filesize </a> </li>
                            <li> <a href="#getfilename"> GetFileName </a> </li>
                            <li> <a href="#getfiletype"> GetFileType </a> </li>
                            <li> <a href="#getfilesize"> GetFileSize </a> </li>
                            <li> <a href="#getfiletemp"> GetFileTemp </a> </li>
                            <li> <a href="#getfileerror"> GetFileError </a> </li>
                            <li> <a href="#getfiledata"> GetFileData </a> </li>
                            <li> <a href="#uniquefile"> uniqueFile </a> </li>
                            <li> <a href="#uploadfile"> uploadFile </a> </li>
                            <li> <a href="#response"> response </a> </li>
                            <li> <a href="#reconstruct"> reconstruct </a> </li>
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
                                <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> start
                                </div>
                            </div> <br>
                            <div class="">
                            The <code>start</code> method is used to set parameters 
                            into the input class.
                            <br><br>
                            
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: start</code></div>
                                    <pre class="pre-code">
        $FileUploader->start(files, type);

        <span class="comment no-select">
        where:
            
            files: $_FILES or files data array
            type: type of file. options [file|image]
                    A type of 'image' allows internal processing of images supplied.
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
    $FileUploader->start($_FILES); <span class="comment">// set files for upload</span>

    $FileUploader->start($_FILES, 'image'); <span class="comment">// set image files for upload</span>
                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="filesize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> filesize
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>filesize()</code> method sets the maximum number of 
                                bytes the files uploaded must not exceed <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: filesize</code></div>
                                        <pre class="pre-code">
    $FileUploader->filesize(size); 
        <span class="comment">
            where:
            
            size: maximum file size in bytes
        </span>
                                        </pre>
                                    </div>
                                </div>    

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: filesize</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> GetFileName
                                </div>
                            </div> <br>

                            <div class="">
                                This method returns the file name of the currently set file.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileName</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileName(type); <span class="comment"> // returns </span>
    
    <span class="comment"> 
        where :

            type: type of validation
                                        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileName</code></div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileName(); <span class="comment"> // Foo</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletype" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> GetFileType
                                </div>
                            </div> <br>

                            <div class="">
                                This method returns the type of current file set.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileType</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileType(); <span class="comment"> // returns type of file </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileType</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> GetFileSize
                                </div>
                            </div> <br>
                            <div class="">
                                This method returns the size of current file set.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: GetFileSize</code></div>
                                        <pre class="pre-code">
    $FileUploader->GetFileSize(); <span class="comment"> // returns size of file </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: GetFileSize</code></div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileSize(); <span class="comment"> // 2000000</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiletemp" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> GetFileTemp
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>tmp_name</code> of current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileTemp</code></div>
                                    <pre class="pre-code">
    $FileUploader->GetFileTemp(); <span class="comment"> // returns the temporary directory of file </span>
                                    </pre>
                                </div>
                            </div>
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileTemp</code></div>
                                    <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');
    $FileUploader->GetFileTemp(); <span class="comment"> // 2000000</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfileerror" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> GetFileError
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>error</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileError</code></div>
                                    <pre class="pre-code">
    $FileUploader->GetFileError(); <span class="comment"> // returns the current file error </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileError</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">8.</span>
                                    </span> GetFileData
                                </div>
                            </div> <br>
                            <div class="">
                            This method returns the <code>data</code> for current file set.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: GetFileData</code></div>
                                    <pre class="pre-code">
    $FileUploader->GetFileData(bool); <span class="comment"> //  returns string of supplied data </span>
    <span class="comment">
        where: 

        bool : boolean of true returns adds a the new directory and new file name of an uploaded file to the information returned.
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: GetFileData</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">9.</span>
                                    </span> uniqueFile
                                </div>
                            </div> <br>
                            <div class="">
                            This function directs the uploader class to upload a file with a unique new name 
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: uniqueFile</code></div>
                                    <pre class="pre-code">
    $FileUploader->uniqueFile(param); 
    <span class="comment">
        where :

        param : true permits a unique output name
                false keeps the source file name
                string sets a new output name. 
    </span>
                                    </pre>
                                </div>
                            </div>

                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Example: uniqueFile</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">10.</span>
                                    </span> uploadFile
                                </div>
                            </div> <br>

                            <div class="">
                                This method executes the upload directive. <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: uploadFile</code></div>
                                        <pre class="pre-code">
    <span class="comment"> // upload a file</span>
    $FileUploader->uploadFile(validFiles, destination, makedir); <span class="comment"> // returns : true if file was uploaded</span>
    
    <span class="comment"> 
        where :

            validFiles: array list of valid or acceptable extensions.
            destination: destination path of uploaded file.
            makedir: bool of true creates a new directory if it does not already exist.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: uploadFile</code></div>
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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">11.</span>
                                    </span> response
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>response</code> returns the response of the processes executed. This 
                                may be good for code debugging
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: response</code></div>
                                        <pre class="pre-code">
    $FileUploader->start($_FILES, 'image');

    $upload = $FileUploader->uploadFile(['jpg','png'], dirname(__FILE__).'/images', true); 
    if($upload){

        <span class="comment">file uploaded successfully</span>

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
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> reconstruct
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>reconstruct</code> method is used to restructure multiple files for upload
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Syntax: reconstruct</code></div>
                                        <pre class="pre-code">
    $FileUploader->reconstruct(data);
    <span class="comment no-select"> 
        where : 

            data: array of multiple files
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: reconstruct</code></div>
                                        <pre class="pre-code">
    <span class="c-green">
    $_FILES['name'][0]  = 'Foo'; 
    $_FILES['name'][1]  = 'Bar';   

    $_FILES[0]['type'][0]  = 'image/png'; 
    $_FILES[0]['type'][1]  = 'image/png'; 

    $_FILES[0]['size'][0]  = 5000000; //5mb
    $_FILES[0]['size'][1]  = 2000000; //2mb

    $_FILES[0]['tmp_name'][0]   = '/tmp/files/foo.png'; 
    $_FILES[0]['tmp_name'][1]   = '/tmp/files/bar.png'; 
        
    $_FILES[0]['error'][0] = ''; 
    $_FILES[0]['error'][1] = ''; 
    </span>

    $files = $FileUploader->reconstruct($_FILES);

    var_dump($files); <span class="comment">// returns: </span>
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
                        
                                <div class="font-menu pvs-10">
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