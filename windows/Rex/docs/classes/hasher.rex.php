
@template('template.t-tut')

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
                                The <code>Hasher</code> class is a tool that is used to generate 
                                hashes. It generates salts in multiple ways that makes it difficult to
                                bypass. The methods available on <code>Hasher</code> are:
                            </div> <br>

                            <ol>
                                <li> <a href="#sethash"> setHash </a> </li>
                                <li> <a href="#randomhash"> randomHash </a> </li>
                                <li> <a href="#hashfunc"> hashFunc </a> </li>
                                <li> <a href="#hashify"> hashify </a> </li>
                                <li> <a href="#randomize"> randomize </a> </li>
                            </ol>
                            
                        </div> 
                    </div>  


                    <div id="initialize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> Initializing class
                                </div>
                            </div> <br>

                            <div class="">
                                The hasher tool can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Sample: Initializing Hasher</code></div>
                                        <pre class="pre-code">
    $hasher  = new Hasher;
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br><br>
                    </div>

                    <div id="keywords" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                    </span> keywords
                                </div>
                            </div> <br>
                            <div class="">
                                The following keywords should be noted:
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>keywords</code></div>
                                        <pre class="pre-code">
    <span class="comment">
    data    : array or string data expected to be hashed

    secret  : password string for hashing

    length  : length of hash to be returned

    algo    : any hash algorithm or custom function.

    keys    : specific string of characters from which an hash string should be generated

    hashFunc: any acceptable function for hashing. The may be hashing algorithms or custom functions
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <br>       

                    <div id="sethash" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> sethash
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>sethash</code> method is used to set a data meant for hashing along with 
                                an optional secret password.
                                <br><br>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: sethash</code></div>
                                        <pre class="pre-code">
    $hasher->sethash(data, secret);
                                        </pre>
                                    </div>
                                </div>
                            </div>

                        </div> <br>
                        We shall be looking at a series of examples below.
                            <br><br>
                            
                        <div class="pre-area shadow">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setting hash</code></div>
                                <pre class="pre-code">

    $hasher->sethash('sometext'); <span class="comment">// set a string to be hashed</span>
    
    $hasher->sethash(['user' => 'foo']); <span class="comment">// set an array to be hashed</span>

    $hasher->sethash(['user' => 'foo'], 'password123'); <span class="comment">// set an array to be hashed with a secret password</span>

                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="randomhash" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> randomHash
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>randomHash()</code> method is used to generate a random hash string
                                <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: randomhash</code></div>
                                        <pre class="pre-code">
    $hasher->randomHash(length, keys, algo); 

    <span class="comment">
        where:
        
                length - optional length of hash to be returned
                keys   - an optional set of charaters from which hash should be picked 
                algo   - an optional custom function to hash generated keys.
                                        </span>
                                        </pre>
                                    </div>
                                </div> 

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: randomHash</code></div>
                                        <pre class="pre-code">
    $hasher->randomHash(50);  <span class="comment no-select">generate 50 character string</span>

    $hasher->randomHash(50, 'abc');  <span class="comment no-select">generate 50 character string from abc</span>

    $hasher->randomHash('', 'abc', 'sha1');  <span class="comment no-select">hash 'abc' with sha1 + time</span>
    
    <span class="comment no-select">
    When using hash algorithms, length of character returned depends on the hash algorithm itself. 
    This means that using lengths does not have any on code sample 3 above.
    </span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="hashFunc" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> hashFunc
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>hashFunc()</code> method sets the algorithms for hashing.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: hashFunc</code></div>
                                        <pre class="pre-code">
    $hasher->hashFunc(algo); <span class="comment">// supplies data  to be hashed.</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: hashFunc</code></div>
                                        <pre class="pre-code">
    $hasher->setHash(['foo','bar'],'1234');

    $hasher->hashFunc(['sha1']); <span class="comment">//use one algo for hashing</span>

    $hasher->hashFunc(['sha1', 'md5']); <span class="comment">//use two algos for hashing</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        <div class="font-menu">
                        In the above sample, the array data will be hashed depending on the number of algorithms 
                        supplied. 
                        </div>
                    </div> <br>

                    <div id="hashify" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> hashify
                                </div>
                            </div> <br>

                            <div class="">
                                This method executes the hash code. It works in different formats which are revealed below
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: hashify</code></div>
                                        <pre class="pre-code">
    $hasher->hasify(param1, param2); 
        <span class="comment no-select">
            where:
            
            @param [int|bool|array] param1 (case 1)
                param1 == (int = 0) => reset hash and return first hash  
                param1 == (int > 0) => number of times for hashing
                param1 == (array | string) => list of hashing algorithms
        
            @param [int] param2 (case 2)
                param2 == (int > 0) => number of times for hashing
                param2 == (int = 0) => reset hash and return first hash 
    
            Note: The hashify function takes one or two arguments.

                One argument execute case 1 
                Two arguments execute case 2
        </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: hashify</code></div>
                                        <pre class="pre-code">
    $hasher->setHash('mydata', 'password');
    $hasher->hashFunc(['sha1','md5']);  <span class="comment">// set function(s) to use for hashtype</span>
    
    $hash1 = $hasher->hashify();  <span class="comment">//first hash</span>

    $hash2 = $hasher->hashify();  <span class="comment">//second hash</span>

    $hash3 = $hasher->hashify();  <span class="comment">//third hash</span>

    $hash4 = $hasher->hashify(0); <span class="comment">//reset hash to first hash</span>

    $hash5 = $hasher->hashify();  <span class="comment">//second hash</span>
    <span class="comment no-select"> 
    Note: In the example above, every hash is rehashed at each call until the 
    counter is set back to 0. <span class="fb-9">$hash4</span> will return the same data as <span class="fb-9">$hash1</span> because 
    the counter was reset and <span class="fb-9">$hash5</span> will return the same data as <span class="fb-9">$hash2</span>
    </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: hashify</code></div>
                                        <pre class="pre-code">
    $hasher->setHash('mydata', 'password');

    $hasher->hashFunc(['sha1','md5']);  <span class="comment">//set function(s) to use for hashtype</span>
    
    $hash3 = $hasher->hashify(3); <span class="comment">//return exactly 3 hash executions</span>

    <span class="comment"> 
    In the example above the hash returned will be equivalent to 3 exactly three 
    hashes made just as example 1 above.
                                        </span>
                                        </pre>
                                    </div>
                                </div>
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 3: hashify</code></div>
                                        <pre class="pre-code">
    $hasher->setHash('mydata', 'password');

    <span class="comment">//set hash functions within hashify</span>
    $hashArr = $hasher->hashify(['sha1','md5']);
    $hashStr = $hasher->hashify('sha1');

    <span class="comment"> 
    The examples above shows that hash funcs can be supplied within the hashify method itself. 
    When text strings or arrays are supplied as one argument, hashify processes such arguments 
    as hash functions.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 4: hashify</code></div>
                                        <pre class="pre-code">
    $hasher->setHash('mydata', 'password');
    `
    <span class="comment">//set hash functions and number of times of rehash within hashify</span>
    $hashArr = $hasher->hashify(['sha1','md5'], 4); 
    $hashStr = $hasher->hashify('sha1', 4);

    <span class="comment"> 
    When two arguments are supplied, the first argument resolves as hash function while the second argument resolves as 
    number of times for rehashing. When hash functions are declared within the <code>hashify</code> method, it overides 
    the default set.
    </span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="randomize" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> randomize
                                </div>
                            </div> <br>
                            <div class="">
                                This method is used to randomize an hash function. When used, it provides a one-way 
                                hash code that cannot be recovered. The <code>randomize</code> method makes sure that 
                                the data returned by a hash is never the same at different times.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: randomize</code></div>
                                        <pre class="pre-code">
    $hasher->randomize(bool|string); 
    <span class="comment">
        where:

            bool:true  => allow randomize (default)
            bool:false => disallow randomize
            string     => string text used to randomize
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: randomize</code></div>
                                        <pre class="pre-code">

    $hasher->setHash(['somearray']);
        
    $hasher->randomize(); <span class="comment">//uses time</span>

    $hasher->hashify(); <span class="comment">//generates a new hash using current time</span>

                                        </pre>
                                    </div>
                                </div>
                                
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: randomize</code></div>
                                        <pre class="pre-code">
    $hasher->setHash(['somearray']);
        
    $hasher->randomize('sometext'); <span class="comment">//uses sometext + time</span>

    $hash = $hasher->hashify('sha1'); <span class="comment">//generates a new hash every time with 'sometext' using sha1 algo</span>

    var_dump( $hash ) <span class="comment">//output hash</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>
                    
                @lay('build.co.links:tutor_pointer')

                </div>
    
    @lay('build.co.coords:footer')

@template;