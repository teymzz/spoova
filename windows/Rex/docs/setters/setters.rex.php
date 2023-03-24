
@template('template.t-tut')

<!-- @lay('build.co.coords:header') -->

@lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">


                    <div class="font-em-1d5 c-orange">Setters and Getters</div> <br>  
                    
                    <div class="setters-intro">
                        <div class="fb-6">Introduction</div>
                        <div class="">
                            Setter is special top level class that is capable of manipulating or protecting defined values across the web application. 
                            This system can be used within the web application to store and even protect values which must not be tampered with unless 
                            certain strict conditions are met. It also prevents the use of modifiable php variables and keeps defined values in their own specific 
                            division, away from being updated without real known intent.
                            The setter system (or class) involves three specific methods <code>SET()</code>, <code>GET()</code>
                            and <code>MOD()</code> which are applied synergetically. This means that for any defined value to be 
                            properly managed, there has to be a top level to down level relationship between values. Values that are defined at top level can then be 
                            handled or managed in a manner desired by the developer. This system can be mostly used to keep track of specific value properties. For example, 
                            while php variables may be updated as desired along the code, setter values can be prevented from being updated at a low level if certain conditions are not met.

                            <p>
                                <div class="c-orange">Defining Values</div>
                                In order to define a new value, the <code>SET()</code> method has to be called at the top level. This method takes two arguments. The syntax is shown below: <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::SET()</div>
                                    <pre class="pre-code">
  SETTER::SET(KEY, VALUE, SECURE)  
  <span class="comment">
    where: 

     KEY : Protected Key
     VALUE : Key's value
     SECURE : secure hash/string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) that needs to be protected while the <code>VALUE</code> is the 
                                    content of that <code>KEY</code>. The <code>SECURE</code> defines the security level of the <code>KEY</code>. If <code>SECURE</code> 
                                    is set as <code>TRUE</code>, then the <code>KEY</code> defined cannot be updated or modified after it has been defined. 
                                    This turns the <code>KEY</code> to a read-only key. Any attempt to use <code>SETTER::MOD()</code> to modify the key's value, 
                                    an error will be thrown preventing such activity. However, if the <code>SECURE</code> value is a non-empty string, then it is assumed to be 
                                    a secure hash string. Whenever secure hash strings are used, then such hash must be provided by the <code>SETTER::MOD()</code> in order 
                                    for the value to be updated. If the <code>MOD()</code> (i.e modifier) hash does not match the one used to secure the <code>KEY</code>, 
                                    then an error is thrown. Also, whenever a new value is defined, it cannot be redefined using <code>SETTER::SET()</code> again. 
                                    Instead, the <code>SETTER::MOD()</code> must be called.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Modifiying Key's Value</div>

                                    <div class="pvs-10">
                                        In other to modify any key, the <code>SETTER::MOD()</code> method has to be called. 
                                        If this method is called before a value is set, an error will be thrown. 
                                        It takes three argument and the syntax is shown below: <br>
                                    </div>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::MOD()</div>
                                    <pre class="pre-code">
  SETTER::MOD(KEY, VALUE, HASH)  
  <span class="comment">
    where: 

     KEY : Protected Key
     VALUE : Key's new value
     HASH : secure hash string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) that needs to be modified or updated while the <code>VALUE</code> is the 
                                    new content of that <code>KEY</code>. The <code>HASH</code> defines the secure hash string used to set the key, if defined. 
                                    This means that whenever secure hash strings are used to lock a value when defined using <code>SETTER::SET()</code>, then such 
                                    hash must be provided by the <code>SETTER::MOD()</code> in order 
                                    for the value to be updated. If the <code>MOD()</code> (i.e modifier) hash does not match the one used to secure the <code>KEY</code>, 
                                    then an error is thrown.
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Getting Defined Key's Value</div>

                                    <div class="pvs-10">
                                        In other to fetch any defined key, the <code>SETTER::GET()</code> method has to be called. 
                                        If this method is called before a value is set, an error will be thrown. 
                                        This method takes two argument. The syntax is shown below: <br>
                                    </div>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Syntax: SETTER::GET()</div>
                                    <pre class="pre-code">
  SETTER::GET(KEY, HASH)  
  <span class="comment">
    where: 

     KEY : Protected Key
     HASH : secure hash string
  </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The <code>KEY</code> above is the value (or variable) whose value needs to be fetched. Whenever a key is secured with an hash, then the 
                                    <code>HASH</code> string must be provided before the value of that key can be obtained. If the value of the <code>HASH</code> does not match, 
                                    an error is thrown. Also, if a KEY is not secured in <code>SET()</code> but <code>HASH</code> was provided in <code>GET()</code>, although the value 
                                    will be returned, an error will still be triggered discouraging such activity. 
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Detecting if a key exists</div>
                                In other to prevent errors which may occur from <code>SETTER::SET()</code> if the key has already been defined, we have to check if a key already exists 
                                by using the method <code>SETTER::EXIST()</code>. This will only return true if a key already exists. The usage is shown below: <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Usage: SETTER::EXIST()</div>
                                    <pre class="pre-code">

  if( !SETTER::EXISTS('key') ) {

    SETTER::SET('key', 'value');

  }
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-6">
                                    The code above will only set the key if it does not already exist. 
                                </div>
<!-- code description ends -->
                            </p>

                            <p>
                                <div class="c-orange">Helper Functions</div>
                                There are two provided helper functions for running the Setter system. These functions are <code>SET()</code> and <code>GET()</code> functions. Although, we don't have 
                                any <code>MOD()</code> helper function, the <code>SET()</code> function is build to handle updates in the manner <code>SETTER::MOD()</code> will handle it. The <code>SET()</code>
                                function naturally checks if a varible is updateable or not previously set before setting them and it takes the same parameter as the <code>SETTER::SET()</code> or <code>SETTER::MOD()</code> 
                                methods. This obviously save more time. The <code>GET()</code> method obtains the value of a previously defined key. <br>
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Example: SET and GET</div>
                                    <pre class="pre-code">
  SET('NAME 1', 'Felix');  
  SET('NAME 2', 'Rolland', true);  
  SET('NAME 3', 'Charley', 'hash123');  

  <span class="c-green-l">GET('NAME 1')</span> <span class="comment">// returns Felix</span>
  <span class="c-orange-dd">GET('NAME 1', 'hash234')</span> <span class="comment">// returns Felix, but triggers error</span>

  <span class="c-green-l">GET('NAME 2')</span> <span class="comment">// returns Rolland</span>
  <span class="c-orange-dd">GET('NAME 2', 'hash234')</span> <span class="comment">// returns Rolland, but triggers error</span>

  <span class="c-red-dd">GET('NAME 3')</span> <span class="comment">// invalid hash triggers error</span>
  <span class="c-green-l">GET('NAME 3', 'hash123')</span> <span class="comment">// returns Charley</span>
  <span class="c-red-dd">GET('NAME 3', 'hash234')</span> <span class="comment">// invalid hash triggers error </span>
                                    </pre>
                                </div>
<!-- code ends -->
<!-- code description -->
                                <div class="font-em-d8 mvt-8">
                                    The example above best explains how the <code>SET</code> and <code>GET</code> functions work while the example below 
                                    explains how modifications work.
                                </div>
<!-- code description ends -->
<!-- code begins -->
                                <div class="pre-area shadow mvt-6">
  <div class="pxv-6 bc-silver-d">Example 2: Modifying values</div>
                                    <pre class="pre-code">
  SET('NAME 1', 'Felix');  
  SET('NAME 2', 'Rolland', true);  
  SET('NAME 3', 'Charley', 'hash123');  

  <span class="c-green-l">SET('NAME 1', 'New Felix')</span> <span class="comment">// allowed</span>

  <span class="c-red-dd">SET('NAME 2', 'New Rolland')</span> <span class="comment">// denied (read-only)</span>

  <span class="c-green-l">SET('NAME 3', 'New Charley', 'hash123')</span> <span class="comment">// allowed (valid hash)</span>
  <span class="c-red-dd">SET('NAME 3')</span> <span class="comment">// denied (invalid hash)</span>
  <span class="c-red-dd">SET('NAME 3', 'hash234')</span> <span class="comment">// denied (invalid hash) </span>
                                    </pre>
                                </div>
<!-- code ends -->

                            </p>


                        </div>
                    </div>

                </div>


            </div>

        </section>
    </div>
@template;