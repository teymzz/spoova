
@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial mails bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Jsonfy</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            <code>Jsonfy</code> class is used to handle a two 
                            level dimensionsional array or json string. It may convert a json string to 
                            an array, convert an array to json, modify an existing json or array data 
                            , fetch or remove data from a json string. The methods available are as follows: 

                        </div> <br> <br>

                            <ol>
                            <li> <a href="#newdata"> newData </a> </li>
                            <li> <a href="#datakey"> datakey </a> </li>
                            <li> <a href="#add"> add </a> </li>
                            <li> <a href="#update"> update </a> </li>
                            <li> <a href="#delete"> delete </a> </li>
                            <li> <a href="#read"> read </a> </li>
                            <li> <a href="#data"> data </a> </li>
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
                                The jsonfy tool can be easily initialized as shown below.
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
                                        <pre class="pre-code">
    $jsonfy  = new Jsonfy;
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
    $data : json string or array data

    $array : sample array used - ['name' => 'foo', 'class' => 'bar'];

    $json  : sample json used - {"name": "foo", "class": "bar"};

    data   : uses json string or array data 
    </span>
                                </pre>
                            </div>
                        </div>

                            </div>
                        </div> <br><br>
                    </div>        

                    <div id="newdata" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> newData
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>newData</code> method is used to set a new json string or array data
                                <br><br>
                            
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: newData</code></div>
                                        <pre class="pre-code">
    $jsonfy->newData(data); 
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

    $jsonfy->newData($json); <span class="comment">// check <a href="#keywords">keywords</a> for $json</span>

    $jsonfy->newData($array); <span class="comment">// check <a href="#keywords">keywords</a> for $array</span>

                                </pre>
                            </div>
                        </div>

                    
                    </div> <br>

                    <div id="add" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> add
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>add()</code> method is used to add a key and its value into 
                                a json or array data. It involves a series of formats. We shall be looking at 
                                few examples:
                                <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: add</code></div>
                                        <pre class="pre-code">
    $jsonfy->add(null); 
    $jsonfy->add(name); 


    $jsonfy->add(null, null); 
    $jsonfy->add(null, value); 
    $jsonfy->add(name, value);


    $jsonfy->add(null, null, null); 
    $jsonfy->add(name, key, value); 
    $jsonfy->add(null, key, value); 
    $jsonfy->add(name, null, value); 
    <span class="comment no-select">
    where: 

     name  : name of a given index of an associative array 
     value : value of a given index of an associative or 2-level multidimentional array 
     key   : subkey of a 2-level multidimentional array
     null  : numbered index (e.g 0, 1, 2 ...) or empty string

    Note: This may look comprehensive but a series of examples will provide guidance 
    </span>
                                        </pre>
                                    </div>
                                </div> 

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: add</code></div>
                                        <pre class="pre-code">
    <span class="c-orange-d">Note:: all case lines below are assumed to be the first line</span>

    <span class="comment">//case 1 - one argument</span>
    <span class="comment">sample:</span> $jsonfy->add('');                 <span class="comment">//['0'=>'']</span>
    <span class="comment">sample:</span> $jsonfy->add('foo');              <span class="comment">//['foo'=>'']</span>

    <span class="comment">//case 2 - two arguments</span>
    <span class="comment">sample:</span> $jsonfy->add('', '');             <span class="comment">//['0'=>'']</span>
    <span class="comment">sample:</span> $jsonfy->add('', 'bar');          <span class="comment">//['0'=>'bar']</span>
    <span class="comment">sample:</span> $jsonfy->add('foo', 'bar');       <span class="comment">//['foo'=>'bar']</span>

    <span class="comment">//case 3 - three arguments</span>
    <span class="comment">sample:</span> $jsonfy->add('', '', '');         <span class="comment">//['0'=>['0'=>'']]</span>
    <span class="comment">sample:</span> $jsonfy->add('foo', 'bar', 'me'); <span class="comment">//['foo'=>['bar'=>'me']]</span>
    <span class="comment">sample:</span> $jsonfy->add('', 'bar', 'me');    <span class="comment">//['0'=>['bar'=>'me']]</span>
    <span class="comment">sample:</span> $jsonfy->add('', 'me', '');       <span class="comment">//['0'=>['me'=>'']]</span>
    <span class="comment">sample:</span> $jsonfy->add('', '', 'me');       <span class="comment">//['0'=>['0'=>'me']]</span>
                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>

                        <div class="font-menu">
                            In the above, all empty strings (i.e '') resolves to <code>numbers</code> except in few 
                            occassions. Kindly note the following<br>
                            <ol>
                                <li>
                                    When one argument is supplied, it becomes the index key. If the argument 
                                    is null, then <code>numbers</code> are used starting from 0. 
                                </li>
                                <li>
                                    When two null arguments are supplied without a third, the first argument 
                                    resolves to numbered index while the second resolves to empty value 
                                </li>
                                <li>
                                    When two null arguments are supplied with a third, the first two arguments 
                                    resolves to numbered index while the third resolves to value 
                                </li>
                                <li>
                                    When numbers are used, the <code>jsonfy</code> class increases index numbers. This 
                                    means that if <code>add('')</code> is used twice, the first will have the index of zero 
                                    <code>0</code> while the the second will assume an index of one <code>1</code>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div id="datakey" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> datakey
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>datakey()</code> method returns the first key of a specified value for 
                                an associative array.
                                <br><br>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: datakey</code></div>
                                        <pre class="pre-code">
    $jsonfy->datakey(key); 

    <span class="comment no-select">
    where: 

     key : name of a given index of an associative array
    </span>
                                        </pre>
                                    </div>
                                </div>          
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: datakey</code></div>
                                        <pre class="pre-code">
    <span class="comment">Note:: very line below is assumed to be the first list</span>

    $jsonfy->newData(['user'=> 'foo', 'class' => 'bar']); <span class="comment">or {"name": "foo", "class": "bar"}</span>

    var_dump( $jsonfy->datakey('foo') ); <span class="comment">// user</span>
    var_dump( $jsonfy->datakey('bar') ); <span class="comment">// class</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="update" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> update
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>update()</code> method works similarly as the <code>add()</code> method, taking the 
                                same count of parameters needed for a corresponding update
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: update</code></div>
                                        <pre class="pre-code">
    <span class="comment">//example 1</span>
    $jsonfy->add('name', 'foo');                     <span class="comment">//['name'=>'foo']</span>
    $jsonfy->update('name', 'voo');                  <span class="comment">//['name'=>'voo']</span>

    <span class="comment">//example 2</span>
    $jsonfy->add('', 'foo');                         <span class="comment">//['0'=>'foo']</span>
    $jsonfy->update($jsonfy->datakey('foo'), 'bar'); <span class="comment">//['0'=>'bar']</span>

    <span class="comment">//example 3</span>
    $jsonfy->add('user','foo','bar');                <span class="comment">//['user'=>['foo'=>'bar']]</span>
    $jsonfy->update('user', 'foo', 'me');            <span class="comment">//['user'=>['foo'=>'me']]</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>


                    <div id="delete" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> delete
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>delete()</code> method deletes a value from existing jsonfy data
                                It removes either the main key of a 2-level multidimentional array or the subkey 
                                of a multidimentional array.
                                <br><br>
                        
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: delete</code></div>
                                        <pre class="pre-code">
    <span class="comment">//test data</span>
    $jsonfy->add('user','foo','bar'); <span class="comment">//['user'=>['foo'=>'bar']]</span>
    
    <span class="comment">//example 1</span>
    $jsonfy->delete('user', 'foo');   <span class="comment">//['user'=>'']</span>

    <span class="comment">//example 2</span>
    $jsonfy->delete('user');          <span class="comment">//[]</span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="read" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> read
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>read</code> method reads data from a supplied jsonfy data.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: read</code></div>
                                        <pre class="pre-code">
    $jsonfy->read(key); 
    <span class="comment">
    where:
        
     key: main array index key.
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Examples: read</code></div>
                                        <pre class="pre-code">
    <span class="comment">//example 1</span>
    $jsonfy->add('user','foo','bar');   <span class="comment">//['user'=>['foo'=>'bar']]</span>
    var_dump( $jsonfy->read('user') );  <span class="comment">//['foo'=>'bar']</span>


    <span class="comment">//example 2</span>
    $jsonfy->add('user','foo');         <span class="comment">//['user'=>'foo']</span>
    var_dump( $jsonfy->read('user') );  <span class="comment">//foo</span>

    <span class="comment">Note: when an index key does not exist, it returns a boolean of false</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="data" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> data
                                </div>
                            </div> <br>

                            <div class="">
                                This <code>data</code> method returns the entire stored data. This can be in 
                                form of array or json string.
                                <br><br>
                    
                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: data</code></div>
                                        <pre class="pre-code">
    $jsonfy->data(type); 
    <span class="comment">
    where: 
    
     type - options [null|json|source|count] 

       null - returns array of data stored 
       json - returns json string of data stored 
       count - returns the total count of data 
       source - returns the source data supplied from newData method 
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area shadow">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: returning a data</code></div>
                                        <pre class="pre-code">
    $jsonfy->newData(['foo' => 'bar']); 

    var_dump($jsonfy->data('source')); <span class="comment">// ['foo' => 'bar']</span>

    var_dump($jsonfy->data());         <span class="comment">// ['foo' => 'bar']</span>

    var_dump($jsonfy->data('json'));   <span class="comment">// {"foo": "bar"}</span>

    var_dump($jsonfy->data('count'));  <span class="comment">// 1</span>
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