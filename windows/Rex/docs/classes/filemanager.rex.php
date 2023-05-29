@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">
                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">FileManager</div> <br>  
                    
                    <div class="helper-classes">
                        
                        <div class="">

                            <div class="">
                                The filemanager is a special tool that performs series of processes 
                                on files such as reading and writing into writable files, moving files, 
                                copying files to other locations, removing files, renaming files and 
                                reading folder contents. It can be used to rename the entire contents 
                                of a folder. The following are methods that can be called on the 
                                <code>FileManager</code> class.
                            </div> <br>

                            <ul class="c-sky-blue-dd">
                                <li> <a href="#seturl"> seturl </a> </li>
                                <li> <a href="#getfolders"> getFolders </a> </li>
                                <li> <a href="#getfiles"> getFiles </a> </li>
                                <li> <a href="#adddir"> addDir </a> </li>
                                <li> <a href="#lastdir"> lastDir </a> </li>
                                <li> <a href="#openfile"> openFile </a> </li>
                                <li> <a href="#readfile"> readFile </a> </li>
                                <li> <a href="#readfile"> readAll </a> </li>
                                <li> <a href="#textwrite"> textWrite </a> </li>
                                <li> <a href="#textline"> textLine </a> </li>
                                <li> <a href="#textreplace"> textReplace </a> </li>
                                <li> <a href="#textupdate"> textUpdate </a> </li>
                                <li> <a href="#textdelete"> textDelete </a> </li>
                                <li> <a href="#load"> load </a> </li>
                                <li> <a href="#loadenv"> loadenv </a> </li>
                                <li> <a href="#copyto"> copyTo </a> </li>
                                <li> <a href="#moveto"> moveTo </a> </li>
                                <li> <a href="#move"> move </a> </li>
                                <li> <a href="#zipurl"> zipurl </a> </li>
                                <li> <a href="#decompress"> decompress </a> </li>
                                <li> <a href="#response"> response </a> </li>
                                <li> <a href="#err"> err / error </a> </li>
                                <li> <a href="#succeeds"> succeeds </a> </li>
                                <li> <a href="#fails"> fails </a> </li>
                                <li> <a href="#source"> source </a> </li>
                                <li> <a href="#prefix"> prefix </a> </li>
                                <li> <a href="#rename"> rename </a> </li>
                                <li> <a href="#startfrom"> startFrom </a> </li>
                                <li> <a href="#respace"> reSpace </a> </li>
                                <li> <a href="#smarturl"> smartUrl </a> </li>
                                <li> <a href="#dirfiles"> dirFiles </a> </li>
                                <li> <a href="#renumber"> reNumber </a> </li>
                                <li> <a href="#view"> view </a> </li>
                            </ul>
                            
                        </div> 
                    </div>

                    <div class="">
                        For the purpose of this tutorial we shall be using a text file. 
                        <br><br>
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">TEST FILE (testfile.txt)</div>
                                <pre class="pre-code">
  $filemanager->readFile($keys, $separator); 
    <span class="comment"> 
    USERNAME : Foo 
    PASSWORD : Bar
    EMAIL    : foobar@email.com
    TALL     : true</span>
                                </pre>
                            </div>
                        </div> 
                    </div> <br>

                    <div id="seturl" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> seturl
                                </div>
                            </div>
                            <div class="">
                                This method is used to set the local path where an action is expected 
                                to be performed. Some methods do not require this to be done.
                                Example is shown below: <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Sample: Initializing FileManager</div>
                                        <pre class="pre-code">
  $filemanager  = new FileManager();

  $filemanager->setUrl('directory'); <span class="comment"> // set base directory or path</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> <br>

                    <div id="getfolders" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> getFolders
                                </div>
                            </div>
                            <div class="">
                                The <code>getFolders</code> method returns the directories in a predefined path: <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: getting directories</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('some_path'); <span class="comment"> // set base directory</span>
    
  $filemanager->getFolders(); <span class="comment"> // returns the available directories</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="getfiles" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> getFiles
                                </div>
                            </div>
                            <div class="">
                                The <code>getFiles</code> method returns the files available in a predefined directory or path: <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: getting file in directories</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('some_path'); <span class="comment"> // set base directory</span>
    
  $filemanager->getFiles(); <span class="comment"> // returns the full path of files available file in directory</span>
  $filemanager->getFiles(false); <span class="comment"> // returns only names of files (and extension) in a directory</span>
  $filemanager->getFiles(false, false); <span class="comment"> // returns only names of files in a directory without the extension name</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="adddir" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> addDir
                                </div>
                            </div>
                            <div class="">
                            The <code>addDir</code> method adds a new directory. This may return null if directory cannot be created <br><br>
                    
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white">Example: creating directories</div>
                                <pre class="pre-code">
  $filemanager->addDir('some_path'); <span class="comment no-select"> // creates a new directory</span>
                                </pre>
                            </div>
                        </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="lastdir" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> lastDir
                                </div>
                            </div>
                            <div class="">
                            The <code>lastDir</code> method returns the last set directory. 
                            This method is useful when handling zip files.
                            <br><br>
                    
                            <div class="pre-area shadow">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Example: fetch last directory</div>
                                    <pre class="pre-code">
  $filemanager->setUrl('myurl')
  $filemanager->lastDir(); <span class="comment no-select"> // myurl</span>
                                    </pre>
                                </div>
                            </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="openfile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> openFile
                                </div>
                            </div>

                            <div class="">
                                This method is used to open a new directory 
                                or to create a new file. It can also create a new 
                                file to a non-existing writable directory. 
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: open directory</div>
                                        <pre class="pre-code">
  $filemanager->openFile($strict, $url)
    
    <span class="comment">
    where: 
        
      $strict : boolean <span class="verdana c-red-orange-dd">true</span> permits to create a new directory for a url that does not exist.
      $url    : an optional new url or path to be created. 
                If not supplied, openFile uses the default url set.
                If supplied, overides the default set url from <code>setUrl()</code>   
    </span>
                                        </pre>
                                    </div>
                                </div> <br>

                                <div class="pre-area shadow mvt-6">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 1</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('somepath');
    
  if( $filemanager->openFile(true) ) {

      <span class="comment">//file path opened successfully</span>

  }
                                        </pre>
                                    </div>
                                </div>
                                <div class="foot-note">
                                    We can also set a url from the <code class="bd-f">openFile()</code> method by supplying 
                                    the url as the second argument as shown below
                                </div>
                                <div class="pre-area shadow mvt-6">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example 2</div>
                                        <pre class="pre-code">
  if( $filemanager->openFile(true, 'somefile.txt') ) {

      <span class="comment">//file path opened successfully</span>

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="readfile" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> readFile
                                </div>
                            </div>

                            <div class="">
                                The <code>readFile</code>  method is used to read a readable file. 
                                This method reads a file line by line to fetch supplied keys. 
                                Using test file:
                                <br><br>   
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: read file</div>
                                        <pre class="pre-code">
  $filemanager->readFile($keys, $separator); 
    <span class="comment"> 
    where: 

      $keys : array of keys to be read in given local file
      $separator  : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>. When set as true, 
                    the readFile checks if the key supplied exists within the file and returns
                    a bool of true or false                                     
    </span>
                                        </pre>
                                    </div>
                                </div>

                        
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: reading text file</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.txt');

  $read = $filemanager->readFile(['USERNAME', 'PASSWORD']);  

  var_dump($read); <span class="comment">// ['USERNAME' => 'Foo', 'PASSWORD' => 'Bar']</span>
    

  $check = $filemanager->readFile('USERNAME', true);  

  var_dump($check); <span class="comment">// returns true because USERNAME key exists in testfile</span> 
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="readAll" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> readAll
                                </div>
                            </div>

                            <div class="">
                                The <code>readAll</code>  method is used to read an entire readable file. 
                                This method reads a file line by line and stores each key with its respective values. 
                                Using test file:
                                <br><br>   
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: read file</div>
                                        <pre class="pre-code">
  $filemanager->readAll($separator); 
    <span class="comment"> 
    where: 

      $separator  : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>.</span>
                                        </pre>
                                    </div>
                                </div>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: reading text file</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.txt');
    
  $read = $filemanager->readAll();  

  var_dump($read); <span class="comment">// ['USERNAME' => 'Foo', 'PASSWORD' => 'Bar', 'EMAIL' => 'foobar@email.com', 'TALL'=>'true']</span>          
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="textwrite" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> textWrite
                                </div>
                            </div>

                            <div class="">
                                The <code>textWrite</code> method write a text into a file using supplied 
                                array key-value pairs <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: write into text file</div>
                                        <pre class="pre-code">
  $filemanager->textWrite([$key => $value], $options); 
    <span class="comment"> 
    where: 

      $key     : line key
      $value   : value of supplied key
      $options : array containing postions of where text should be written. [before, after]
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: adding a new line with key and value</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('text.txt');  

  var_dump($filemanager->read('AGE')); <span class="comment no-select"> //returns: false</span>

  $filemanager->textWrite(['AGE' => '30']); <span class="comment no-select"> //write AGE to a new line </span>
    
  $filemanager->textWrite(['AGE' => '30'], ['after' => 'USERNAME']); <span class="comment no-select"> //write AGE to a position after USERNAME, else write to a new line </span>

  $filemanager->textWrite(['AGE' => '30'], ['before' => 'USERNAME']);<span class="comment no-select"> //write AGE to a position before USERNAME, else write to a new line </span>

  var_dump($filemanager->read('AGE')); <span class="comment no-select"> //returns: ['AGE' => '30']</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="textline" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> textLine
                                </div>
                            </div>

                            <div class="">
                                The <code>textLine</code>  method writes a new line into a writable file.
                                Example is shown below: <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: adding a new line to writable file</div>
                                        <pre class="pre-code">
  $filemanager->textLine($number, $options); 
    <span class="comment"> 
    where: 

      $number : number of lines to be added
      $options: array containing postions of where line should be written [before, after]
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: adding new lines</div>
                                        <pre class="pre-code">
  $filemanager->textLine(4, ['after'=>'USERNAME']); <span class="comment no-select"> //add four new lines after USERNAME line</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="textreplace" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> textReplace
                                </div>
                            </div>

                            <div class="">
                                The method replaces a key's value with a new value. If such 
                                key does not exists nothing is written into the file.<br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: adding a new line to writable file</div>
                                        <pre class="pre-code">
  $filemanager->textReplace([$key => $value], $separator); 
    <span class="comment"> 
    where: 

      $key   : target key
      $value : target key's new value.
      $separator : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>. When set as true, 
                    the readFile checks if the key supplied exists within the file and returns
                    a bool of true or false        
                                            </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: replacing values</div>
                                        <pre class="pre-code">
  $filemanager->textReplace(['USERNAME'=>'NewFoo']); <span class="comment no-select"> //replaces foo with NewFoo</span> 
  
  <span class="comment">//Note:: This can be done for multiple keys.</span>                           
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="textupdate" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> textUpdate
                                </div>
                            </div>

                            <div class="">
                                The method updates a key's value with a new value. If such 
                                key does not exists, the values supplied is written to a new line.<br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: adding a new line to writable file</div>
                                        <pre class="pre-code">
  $filemanager->textUpdate([$key => $value], $updates, $separator); 
    <span class="comment"> 
    where: 

        $key   : target key
        $value : target key's new value
        $updates : a referenced variable that contains all successful updates 
        $separator : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>. When set as true, 
                    the readFile checks if the key supplied exists within the file and returns
                    a bool of true or false        
                                            </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                    <div class="pxv-6 bc-off-white">Example: replacing values</div>
                    <pre class="pre-code">
  $filemanager->textUpdate(['USERNAME'=>'NewFoo'], $updates); <span class="comment no-select"> //replaces foo with NewFoo</span> 

  var_dump($updates) <span class="comment">// returns: ['USERNAME']</span>

  <span class="comment">//Note:: This can be done for multiple keys.</span>                           
                    </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="textdelete" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> textDelete
                                </div>
                            </div>
                            <div class="">

                                <div class="">
                                    The method deletes a key and its entire line from the supplied file.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: adding a new line to writable file</div>
                                        <pre class="pre-code">
    $filemanager->textDelete($key, $dels, $separator); 
    <span class="comment"> 
    where: 

    $key : target key
    $updates : a referenced variable that contains all successful deletes 
    $separator : An optional character separator used to separate keys and values. 
                By default, this is set as colon <code>:</code>. When set as true, 
                the readFile checks if the key supplied exists within the file and returns
                a bool of true or false</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: replacing values</div>
                                        <pre class="pre-code">
  $filemanager->textReplace(4, ['USERNAME'=>'NewFoo']); <span class="comment no-select"> //replaces foo with NewFoo</span> 
  <span class="comment">//Note:: This can be done for multiple keys.</span>                           
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="load" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> load
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    The <code>load</code>  method reads an entire file without instantiating the 
                                    FileManager class similarly as <code>readAll</code> method. The instantiation is 
                                    done within itself.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: load</div>
                                        <pre class="pre-code">
  FileManager::load($path, $separator);
    <span class="comment"> 
    where: 

      $path : path of file
      $separator  : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>. When set as true, 
                    the readFile checks if the key supplied exists within the file and returns
                    a bool of true or false
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: loading files </div>
                                        <pre class="pre-code">
  $contents = FileManager::load('test.txt', ':');   

  var_dump($contents); <span class="comment no-select"> //returns the entire array key and value pairs.</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <br>
                    
                    <div id="loadenv" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> loadenv
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    The <code>load</code>  method reads an entire file just like the <code>load</code>
                                    method. All data obtained are saved into the <code>$_ENV</code> global variable.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: loadenv</div>
                                        <pre class="pre-code">
  FileManager::loadenv($path, $separator);
    <span class="comment"> 
      where: 

        $path : path of file
        $separator  : An optional character separator used to separate keys and values. 
                    By default, this is set as colon <code>:</code>. When set as true, 
                    the readFile checks if the key supplied exists within the file and returns
                    a bool of true or false
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $contents = FileManager::loadenv('test.txt', ':');   

  var_dump($contents); <span class="comment no-select"> //returns the entire array key and value pairs.</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="copyTo" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> copyTo
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This method copies a file from one path to another
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: copyTo</div>
                                        <pre class="pre-code">
  $filemanager->copyTo($newpath, $newname, $strict);
    <span class="comment"> 
    where: 

      $newpath : newpath of file
      $newname : An optional new file name 
      $strict  : prevents previous errors from stopping operation when handling zip files.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.txt');   
  $filemanager->copyTo('newdirectory/files', 'newtext.txt', true);  
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>
                    
                    <div id="moveTo" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> moveTo
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This method moves a file from one path to another path.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: moveTo</div>
                                        <pre class="pre-code">
  $filemanager->copyTo($newpath, $newname, $strict);
    <span class="comment"> 
    where: 

      $newpath : newpath of file
      $newname : An optional new file name 
      $strict  : prevents previous errors from stopping operation when handling zip files.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: moveTo</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.txt');   
  $filemanager->moveTo('newdirectory/files', 'newtext.txt', true);  
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="move" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> move
                                </div>
                            </div>
                            <div class="">

                                <div class="">
                                    This method moves a file from one path to another path.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: move</div>
                                        <pre class="pre-code">
  $filemanager->move($path1, $path2);
    <span class="comment"> 
    where: 

      $path1  : old path or new destination of folder or file
      $path2  : new destination of folder or file
        
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: move</div>
                                        <pre class="pre-code">
  $filemanager->move('somefile.txt', 'newdir/somefile.txt');   <span class="comment">moves from one path to another</span>
    
  $filemanager->setUrl('test.txt');  
  $filemanager->move('newdir/test.txt');   <span class="comment">moves from predefined path to another</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>    

                    <div id="zipurl" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> zipUrl
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This method zips a predefined file or folder path.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: zipUrl</div>
                                        <pre class="pre-code">
  $filemanager->zipUrl($output);
    <span class="comment"> 
    where: 

      $output : output name of zipfile   
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: zipUrl</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.txt');    <span class="comment">// set a file path</span>
  $filemanager->zip('test.zip');   <span class="comment">// zip file to a new name</span>
  $filemanager->move('newdir/test.zip');   <span class="comment">// moves zipped file to a new location.</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="decompress" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> decompress
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This method unzips a zipped file.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: decompress</div>
                                        <pre class="pre-code">
  $filemanager->decompress($delete, $strict);
    <span class="comment"> 
    where: 

      $delete  : a boolean of true deletes the compressed file after extraction   
      $strict  : a boolean of true prevent previous errors from stopping code execution   
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: decompress</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.zip');    <span class="comment">// set a file path</span>
  $filemanager->decompress(true);   <span class="comment">// decompress file to current location and delete compressed file after</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        
                    
                    <div id="response" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> response
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This returns the response obtained when executing operation.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: response</div>
                                        <pre class="pre-code">
  $filemanager->response($message);
    <span class="comment"> 
    where: 

      $message  : sets a new message when not supplied, response returns the last set response  
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: response</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.zip');   <span class="comment">// set a file path</span>
  $filemanager->decompress(true);     <span class="comment">// decompress file to current location and delete compressed file after</span>
  
  var_dump($filemanager->response()); <span class="comment">// returns last response set</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>         
                    
                    <div id="err" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> err or error (use err instead)
                                </div>
                            </div> 

                            <div class="">

                                <div class="">
                                    This returns the error encountered when executing operation. The 
                                    error method is used when renaming files.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: err</div>
                                        <pre class="pre-code">
  $filemanager->response(message);
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: response</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.zip'); <span class="comment">// set a file path</span>
  $filemanager->decompress(true);   <span class="comment">// decompress file to current location and delete compressed file after</span>
  var_dump($filemanager->err());    <span class="comment">// returns last error set</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="succeeds" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> succeeds
                                </div>
                            </div> 

                            <div class="">

                                <div class="">
                                    This returns a boolean of true if last operation succeeds.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax</div>
                                        <pre class="pre-code">
  $filemanager->succeeds();
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.zip'); <span class="comment">// set a file path</span>
  $filemanager->decompress(true);   <span class="comment">// decompress file to current location and delete compressed file after</span>
  if($filemanager->succeeds()) {

    <span class="comment">//file decompressed successfully</span>

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="fails" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> fails
                                </div>
                            </div>
                            <div class="">

                                <div class="">
                                    This returns a boolean of true if last operation fails.
                                </div> <br>
                                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: fails</div>
                                        <pre class="pre-code">
  $filemanager->fails();
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: fails</div>
                                        <pre class="pre-code">
  $filemanager->setUrl('test.zip');    <span class="comment">// set a file path</span>
  $filemanager->decompress(true);   <span class="comment">// decompress file to current location and delete compressed file after</span>
  
  if($filemanager->fails()) {

    <span class="comment">//file decompressing failed</span>

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="source" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> source
                                </div>
                            </div>

                            <div class="">

                                <div class="">
                                    This function sets the source of a file to be renamed similarly to the 
                                    <code>setUrl</code> method. However, this must be used to set source path when 
                                    trying to rename folders or paths.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: source</div>
                                        <pre class="pre-code">
  $filemanager->source($path, $extensions);
    <span class="comment">
    where:
        
      $path: full path of files to be renamed
      $extensions: the extension of files allowed to be renamed
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: source</div>
                                        <pre class="pre-code">
  $FileManager->source(dirname(__FILE__)."/main/images","jpg");
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>
                    
                    <div id="prefix" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> prefix
                                </div>
                            </div> 
                            <div class="">

                                <div class="">
                                    This method sets the prefix of the files to be renamed. The prefix will be added 
                                    to the file name during renaming.
                                </div> <br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: prefix</div>
                                        <pre class="pre-code">
  $filemanager->prefix($path, $extensions);

    <span class="comment">
    where:
        
      $path: full path of files to be renamed
      $extensions: the extension of files allowed to be renamed
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: prefix</div>
                                        <pre class="pre-code">
  $filemanager->source(dirname(__FILE__)."/main/images/pexels","jpg"); 
  $filemanager->prefix("list"); //static prefix name added to files (prefix)
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        
                    
                    <div id="rename" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> rename
                                </div>
                            </div> 

                            <div class="">
                                This method is used to rename files in a specified a directory. When an extension 
                                is supplied, the files renamed will assume the newly specified extension name. 
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: rename</div>
                                        <pre class="pre-code">
  $filemanager->rename($extension);
    <span class="comment">
    where:
            
      $extension: optional new file extension name.</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: rename</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", 'jpg'); <span class="comment">// set only jpg files </span>
  $filemanager->prefix("list"); <span class="comment">// add prefix to file name when renaming (prefix)</span>
  $filemanager->rename('jpg'); <span class="comment">// rename all jpg in directory serially using .jpg as output extension</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>       

                    <div id="startfrom" class="">
                        <div class="">

                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> startFrom
                                </div>
                            </div> 

                            <div class="">
                                The startFrom method defines a numeric point from which the renaming of files 
                                should start. For example, if a folder contains 10 jpg images of different names, 
                                and each is expected be renamed with a prefix of <code class="bd-f">"list"</code>, assuming 
                                the <code>startFrom()</code> method is applied, 
                                with an integer of 5 ( i.e startFrom(5) ), by default each file is expected to be renamed
                                as list1.jpg - list5.jpg but the application of startFrom(5) will change the counter to 
                                start from 5 , hence we will have list5.jpg - list15.jpg. <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: startFrom</div>
                                        <pre class="pre-code">
  $filemanager->startFrom($counter);
    <span class="comment">
    where:
            
      $counter: index from which renaming should be started
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: startFrom</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->prefix("list"); <span class="comment">// add prefix to file name when renaming (prefix)</span>
  $filemanager->startFrom(5); <span class="comment">// start counter from 5</span>
  $filemanager->rename(); <span class="comment">// list5.jpg, list6.jpg, ...</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="reSpace" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> reSpace
                                </div>
                            </div>
                            <div class="">
                                The <code>reSpace</code> method directs the FileManager
                                to replace multiple spaces in file names when renaming<br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: reSpace</div>
                                    <pre class="pre-code">
  $filemanager->reSpace($character);
    <span class="comment">
    where:
            
      $character: new character that spaces should be relaced with</span>
                                    </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: reSpace</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->reSpace('_'); <span class="comment no-select">// replace whitespace with underscore (_)</span>
  $filemanager->rename(); <span class="comment no-select">// list1.jpg, list2.jpg, ...</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="smartUrl" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> smarturl
                                </div>
                            </div>
                            <div class="">
                                The <code>smartUrl</code> method directs the FileManager
                                to reduce special characters when renaming files<br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: smartUrl</div>
                                        <pre class="pre-code">
  $filemanager->smartUrl();
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example: smarUrl</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->smartUrl('_'); <span class="comment no-select">// reduce special characters)</span>
  $filemanager->rename(); <span class="comment no-select">// list1.jpg, list2.jpg, ...</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="dirfiles" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> dirFiles
                                </div>
                            </div> 
                            <div class="">
                                The <code>dirFiles</code> method returns the files within a directory<br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                    <div class="pxv-6 bc-off-white">Syntax: dirFiles</div>
                                    <pre class="pre-code">
  $filemanager->dirFiles($extensions, $bool);
    <span class="comment">
    where:

      $extensions: file extensions to be shown 
      $bool  : boolean of true shows the full path of file when listing files</span>
                                    </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->dirFiles('jpg'); <span class="comment no-select">// return jpg files in a directory</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="renumber" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> reNumber
                                </div>
                            </div>
                            <div class="">
                                The <code>reNumber</code> method directs the FileManger to allow 
                                <code>rename</code> to renumber files in a directory.<br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: reNumber</div>
                                        <pre class="pre-code">
  $filemanager->reNumber($bool);
    <span class="comment">
    where:

      $bool  : boolean of false prevents renaming. Default set is true
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->reNumber(false); <span class="comment no-select">//prevent re-numbering of files</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>        

                    <div id="view" class="">
                        <div class="">
                            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv c-orange"> 
                                    <span class="mxr-8">
                                        <span class="bi-circle-fill"></span>
                                    </span> view
                                </div>
                            </div>

                            <div class="">
                                The <code>view()</code> method Resolve renaming to display mode without any active 
                                renaming process. It prevents the <code>rename()</code> from actually renaming 
                                files. This is used when previewing outputs<br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Syntax: view</div>
                                        <pre class="pre-code">
  $filemanager->view(bool);
    <span class="comment">
    where:

      bool : boolean of false prevents renaming. Default set is true
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow mvt-10">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white">Example</div>
                                        <pre class="pre-code">
  $filemanager->source(__FILE__."/images", "jpg"); 
  $filemanager->view(false); <span class="comment no-select">//prevent re-numbering of files</span>
  $filemanager->rename();    <span class="comment">//displays expected output</span>
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