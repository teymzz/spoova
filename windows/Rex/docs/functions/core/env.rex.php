
@template('template.t-tut')

  <!-- @lay('build.co.coords:header') -->

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    <section class="pxv-10 tutorial database bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8"> <br>

          <div class="font-em-1d5 c-orange">Function : env</div> <br>  
         
          <div class="">
            <div id="env" class="env">
                
                <div class="">
                  The <code>env</code> function is used to access keys declared within the <code>$_ENV</code> global variable. It takes two arguments. The first argument 
                  is the access key any stored value while the second argument is a modifier option that specfies where data should be obtained. This function also  
                  works along with the <code>Filemanager::loadenv()</code> method. The samples below reveals the response of <code>env()</code> function. 
                </div> <br>

                <div class="sample-1">
                  <div class="pre-area">
                    <div class="pxv-10 bc-silver">
                      Sample 1: Filemanager::loadenv()
                    </div>
                    <pre class="pre-code">
    &lt;?php 
    
    use spoova\mi\core\classes\FileManager;

    Filemanager::loadenv('file_path');
  
    env('some_key');
                    </pre>
                  </div>
                  <div class="foot-note mvs-10">
                    In the format above, the <code>Filemanager::loadenv()</code> loads data from the supplied file path into the <code>$_ENV</code> 
                    global scope. Assuming the path <code>"file_path"</code> contains a configuration key <code>"some_key"</code>, when the <code>env("some_key")</code> 
                    method is used, it first tries to search for the value of "some_key" in the <code>$_ENV</code> global variable. If the index key does not exist in the global scope, 
                    since by default, <code>Filemanager::loadenv()</code> stores value into the <code>":ENV"</code> key, the <code>env()</code> will search for the key within the 
                    <code>$_ENV[':ENV']</code> global access key and if the key does not exist also, then an empty string is returned.
                  </div> 
                </div><br>


                <div class="sample-2">
                  <div class="pre-area">
                    <div class="pxv-10 bc-silver">
                      Sample 2: Filemanager::loadenv()
                    </div>
                    <pre class="pre-code">
    FileManager::loadenv('file_path');
  
    env('some_key', true);
                    </pre>
                  </div>
                  <div class="foot-note mvs-10">
                  Using sample 1 as reference, when second argument of <code>env()</code> is set as true, then only global keys will be fetched. This means that fetching a list 
                  of keys stored from <code>FileManager::loadenv()</code> will be eqivalent to <code>env(':ENV', true)</code>.
                  </div> 
              </div><br>

              <div class="sample-1">
                <div class="pre-area">
                  <div class="pxv-10 bc-silver">
                    Sample 3: Filemanager::loadenv()
                  </div>
                  <pre class="pre-code">
    FileManager::loadenv('some_path');
  
    env('child_key', 'parent_key');
                  </pre>
                </div>
                <div class="foot-note">
                 Also, using sample 1 as reference, when second argument of <code>env()</code> is a non-empty string, the <code>env()</code> function will look within the <code>"parent_key"</code> 
                 for a <code>"child_key"</code> and the value of the <code>"child_key"</code> will be returned if it exists. For example, assuming we have an environment data as below:
                </div> <br>
                <div class="pre-area">
                  <pre class="pre-code">
    $_ENV = [
      
      'app'  => 'frame',

      ':ENV' => [
        
        'name' => 'foo'

      ]

    ]
                  </pre>
                </div>
                 
                <div class="foot-note">
                  The responses of the <code>env()</code> function will be as shown below:
                </div>  
                <div class="pre-area">
                  <pre class="pre-code">
    env('app'); <span class="comment">// frame</span>

    env('name'); <span class="comment">// foo</span>

    env('name', true); <span class="comment">// false</span>

    env(':ENV'); <span class="comment">// [ name => 'foo' ]</span>

    env(':ENV', 'name'); <span class="comment">// foo</span>
                  </pre>
                </div>
              </div>

              <div class="foot-note">
                Since the a global key value overwrites any similar subkey of the 
                <code>:ENV</code> main key. To avoid conflicting values, if any key of 
                ":ENV" is to be fetched, it is essential to specify the ":ENV" first before the 
                name of the sub key is specified just as the last sample format given above.
              </div>
                
            </div>
          </div> <br>
          
          @lay('build.co.links:tutor_pointer')
      
        </div> <br>  


      </div> <br>  

    </section>
  </div> <br>    
  
  @lay('build.co.coords:footer')
  
@template;