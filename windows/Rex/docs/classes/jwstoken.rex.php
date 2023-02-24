@template('template.t-tut')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-20 tutorial bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">JWSToken</div> <br>  
                    
                    <div class="helper-classes">
                        <div class="fb-6">Introduction</div> <br>
                        <div class="">

                        <div class="">
                            The <code>Jwstoken</code> class is a tool that is used to generate 
                            JWS tokens. The following are available methods in the Jwstoken class
                        </div> <br> 

                            <ol>
                            <li> <a href="#set"> set </a> </li>
                            <li> <a href="#algo"> algo </a> </li>
                            <li> <a href="#payload"> payload </a> </li>
                            <li> <a href="#sign"> sign </a> </li>
                            <li> <a href="#expires"> expires </a> </li>
                            <li> <a href="#token"> token </a> </li>
                            <li> <a href="#decrypt"> decrypt </a> </li>
                            <li> <a href="#isvalid"> isValid </a> </li>
                            <li> <a href="#expired"> expired </a> </li>
                            <li> <a href="#pending"> pending </a> </li>
                            <li> <a href="#error"> error </a> </li>
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
                            The jwstoken tool can be easily initialized as shown below.
                            <br><br>
                            
                            <div class="pre-area">
                                <div class="box-full">
                                    <div class="pxv-6 bc-off-white"><code>Sample: Initializing Input</code></div>
                                    <pre class="pre-code">
    $jws  = new Jwstoken;
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
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>keywords</code></div>
                                        <pre class="pre-code">
    <span class="comment">
    secretkey : a secret password string

    hash_algo : hashing algorithm (e.g sha256, md5)

    algo      : any of the options - [HS256|HS384|HS512|RS256]

    type      : any of the options - [JWS|JWT]

    payload   : a data array having predefined keysets <code>iss</code> <code>nbf</code> and <code>exp</code> expected to be hashed

    token     : currently or previously generated token

    $token    : previously generated token
    </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> 
                    </div> <br><br>       

                    <div id="set" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">1.</span>
                                    </span> set
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>set</code> method is used to set or modify the default type and algorithm 
                                to be used for generating the jwstokens. The default type is <code>JWS</code> and the 
                                default algorithm is <code>HS256</code>. This method can be skipped if the default set parameters 
                                are used.
                                <br><br>
                            
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: set</code></div>
                                        <pre class="pre-code">
    $jws->set(type, algo);
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>

                        We shall be looking at a series of examples below.
                        <br><br>
                            
                        <div class="pre-area">
                            <div class="box-full">
                                <div class="pxv-6 bc-off-white"><code>Example: setting files</code></div>
                                <pre class="pre-code">

    $jws->set(); <span class="comment">// sets default algorithm - ['JWS', 'HS256']</span>

    $jws->set('JWS', 'HS384'); <span class="comment">// using JWS with HS384 algorithm</span>

    $jws->set('JWT', 'HS384'); <span class="comment">// using JWT with HS384 algorithm</span>

                                </pre>
                            </div>
                        </div>

                    </div> <br>

                    <div id="algo" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">2.</span>
                                    </span> algo
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>algo()</code> method is used to overide only the default algorithm 
                                set for creating jwstokens. The algorithm supplied must be amongst the valid algorithms.
                                <br><br>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: algo</code></div>
                                        <pre class="pre-code">
    $jws->algo(hash_algo); 
                                        </pre>
                                    </div>
                                </div>     

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: algo</code></div>
                                        <pre class="pre-code">
                                        
    $jws->algo('HS512');

                                        </pre>
                                    </div>
                                </div>
                        
                            </div>
                        </div> <br>
                    </div>

                    <div id="payload" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">3.</span>
                                    </span> payload
                                </div>
                            </div> <br>

                            <div class="">
                                The <code>payload()</code> method is used to set a payload for jwstokens.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: payload</code></div>
                                        <pre class="pre-code">
    $jws->payload($payload); <span class="comment">// supplies data  to be hashed.</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
    <div class="pxv-6 bc-off-white"><code>Example: payload</code></div>
    <pre class="pre-code">
    $payload = [
        'data'=>'mydata',    <span class="comment">// some extra data supplied</span>

        'nbf'=>time() + 60,  <span class="comment">// time when token becomes active (60secs)</span>

        'exp'=>time() + 120, <span class="comment">// time when token becomes expired (2minutes after created)</span>

        'iss' => 'user',     <span class="comment">// user who issued token </span>
    ];

    $jws->payload($payload);
    </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                        
                        <div class="font-menu">
                            The payload supplied has a predefined format which must be followed. This enables 
                            the <code>jwstoken</code> class to perform verifications on the token generated. The 
                            payload data should be set using the following special array indices. <br><br>

                            <code>iss</code> - issued by <br>
                            <code>nbf</code> - not before <br>
                            <code>exp</code> - expire time <br><br>

                            <p>
                                The values defined above are keys that should be used when supplying some special data.
                                <br>
                                <code>iss</code> defines the user who issued a token.<br>
                                <code>nbf</code> defines the time when a generated token should become active in seconds<br>
                                <code>exp</code> defines the time when a generated token should expire in seconds. <br> <br>
                                Example: The following payload data <code>['iss' =>'user', 'nbf'=> 60, 'exp'=>120]</code> tells the 
                                jwstoken to issue a token from "user" that becomes active only after 1 minute (60secs) it was generated 
                                and valid for 2 minutes (120secs). It should be noted that this token will only have a total of 
                                1 minute activeness because 1 minute is used out of the accessible 2 minutes to pend the token. It is 
                                also possible to set tokens that do not expire by not defining the expire time. The
                                <code>nbf</code> can also be avoided by not defining it .
                            </p>

                        </div>
                    </div>

                    <div id="expires" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">4.</span>
                                    </span> expires
                                </div>
                            </div> <br>
                            <div class="">
                                This method sets the time at which a jwstoken must expire in seconds. The minimum 
                                acceptable time range is 60 secs which is equivalent of 1 minute.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: expires</code></div>
                                        <pre class="pre-code">
  $jws->expires($time); 
    <span class="comment">
      where:
        
       $time: expire time in seconds.
    </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: expires</code></div>
                                        <pre class="pre-code">
  $jws->expires(120); <span class="comment"> // sets expire time to 2 minutes </span>
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="sign" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">5.</span>
                                    </span> sign
                                </div>
                            </div> <br>

                            <div class="">
                                This method is used to sign a payload. It locks the payload with a secret 
                                alogrithm that is specific and can only be decrypted by the server itself. 
                                This creates a multi-layered security on the payload when it is encrypted. 
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: sign</code></div>
                                        <pre class="pre-code">
    $jws->sign(secretkey, hash_algos); 
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: Signing a payload</code></div>
                                        <pre class="pre-code">
  $jws = new JWSToken;
  
  $jws->payload($payload); <span class="comment">//check <a href="#payload">payload</a> for $payload supplied</span>
  
  $jws->sign('password123'); <span class="comment">//sign and generate a payload with sha256</span>
  
  $jws->sign('password123', 'md5'); <span class="comment">//sign and generate a payload with md5</span>
                                        </pre>
                                    </div>
                                </div>
                                
                            </div>
                        </div> <br>
                    </div>

                    <div id="token" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">6.</span>
                                    </span> token
                                </div>
                            </div> <br>
                            <div class="">
                                This <code>token</code> sets or fetches a generated token. When a token is generated 
                                using the <code>sign()</code> method, the <code>token()</code> method returns the current 
                                hash string of the generated token. It can also be used to supply a token meant for decryption.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: token</code></div>
                                        <pre class="pre-code">
    $jws->token(); <span class="comment"> // return a generated token </span>
    $jws->token($token); <span class="comment"> // set a previously generated token </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: Generating a token</code></div>
                                        <pre class="pre-code">
  $jws->payload($payload); <span class="comment">// check <a href="#payload">payload</a> for the $payload used here.</span>
    
  $jws->sign('secret_key'); <span class="comment"> // lock and sign payload with a secret key</span>
    
  var_dump( $jws->token() ); <span class="comment"> // output generated token</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>


                    <div id="isvalid" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">7.</span>
                                    </span> isValid
                                </div>
                            </div> <br>

                            <div class="">
                                This method checks if a supplied token is valid. Only valid tokens return 
                                a boolean of true. A token might not be valid 
                                for three reasons. <br><br>
                                <ul>
                                    <li>A token may be inactive (i.e pending state).</li>
                                    <li>A token could have expired.</li>
                                    <li>The string supplied might not be a valid token.</li>
                                </ul>
                        
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: isValid</code></div>
                                        <pre class="pre-code">
  $jws->isValid($secretkey, $hash_algo); <span class="comment"> // returns bool of true if token is valid </span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: isValid</code></div>
                                        <pre class="pre-code">
  $jws->payload($payload); <span class="comment">// check <a href="#payload">payload</a> for the $payload used here</span>
    
  $jws->sign('secret', 'sha256');

  $token = $jws->token(); <span class="comment">// generate a token.</span>

  var_dump( $jws->isValid($token) ); <span class="comment">// returns: true</span>
                                        </pre>
                                    </div>

                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: isValid</code></div>
                                        <pre class="pre-code">
  <span class="comment">// $token as some generated token</span>

  var_dump( $jws->token($token)->isValid('password', 'md5') ); <span class="comment">// note: hash algo (i.e md5) must match algo used for generating token</span>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <br>

                    <div id="decrypt" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">8.</span>
                                    </span> decrypt
                                </div>
                            </div> <br>
                            <div class="">
                                The <code>decrypt</code> method decrypts a generated token, returning back the 
                                supplied payload data.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: decrypt</code></div>
                                        <pre class="pre-code">
  $jws->decrypt($token, $secretkey, $hash_algo); 
<span class="comment"> 
    Note: if $token is not a valid token or cannot be decrypted, the method returns an empty data.
</span>
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 1: decrypt</code></div>
                                        <pre class="pre-code">
  $jws = new JWSToken;

  $jws->sign($payload, 'pass123', 'md5'); <span class="comment">// check <a href="#payload">payload</a> for the $payload used here.</span>
    
  $token = $jws->token();

  $decrypt = $jws->decrypt($token, 'pass123', 'md5');

  if($decrypt) {

    var_dump($decrypt);

  } else {
        
    var_dump($jws->error);

  }
                                        
                                        </pre>
                                    </div>

                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example 2: decrypt</code></div>
                                        <pre class="pre-code">
  $jws = new JWSToken;

  $jws->set('JWS', 'md5');

  <span class="comment">//$token as some generated token</span>

  if( $jws->token($token)->isValid('pass', 'md5') ) {

      var_dump( $jws->decrypt() ); <span class="comment"> // returns payload data or null</span>

  } else {

      var_dump( $jws->error );

  }
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div> <br>

                        <div class="font-menu">
                            The <code>jwstoken</code> class supports that when the method <code>isValid()</code> is used, 
                            then <code>decrypt()</code> method can be used immediately after, providing a shorter way of decrypting 
                            tokens. 
                        </div> <br>

                    </div>

                    <div id="expired" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">9.</span>
                                    </span> expired
                                </div>
                            </div> <br>

                            <div class="">
                                This function returns a boolean of true when a token has expired.
                                <br><br>
                    
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: expired</code></div>
                                        <pre class="pre-code">
    $jws->expired(secretkey, hash_algo); <span class="comment">// returns true or false</span> 
    <span class="comment no-select">
    // Note: when a testing has not been done, it returns an empty string.
    </span>
                                        </pre>
                                    </div>
                                </div>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: expired</code></div>
                                        <pre class="pre-code">
  <span class="comment">// hash_algo used for generating token should be supplied</span>

  if( $jws->token($token)->expired('pass', 'md5') ) {

    <span class="comment">// run code</span>

  }
                                        </pre>
                                    </div>
                                </div>

                            </div>
                        </div> <br>
                    </div>

                    <div id="pending" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">10.</span>
                                    </span> pending
                                </div>
                            </div> <br>
                            <div class="">
                                This function returns a boolean of true if a token is in an inactivated or pending 
                                state. Pending tokens are tokens that are meant to become active only after a specified 
                                time.
                                <br><br>
                        
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Syntax: pending</code></div>
                                        <pre class="pre-code">
  $jws->pending(secretkey, hash_algo); <span class="comment">// returns true or false</span> 
                                        </pre>
                                    </div>
                                </div>

                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: pending</code></div>
                                            <pre class="pre-code">
    <span class="comment">// hash_algo used for generating token should be supplied</span>

    if( $jws->token($token)->expired('pass', 'md5') ) {

        <span class="comment">// ... run code</span>

    }
                                            </pre>
                                        </div>
                                </div>
                            </div>
                        </div> <br>
                    </div>

                    <div id="error" class="">
                        <div class="">
                            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                                <div class="flex-full midv"> 
                                    <span class=" mxr-8 c-lime-dd">
                                        <span class="numb-box">10.</span>
                                    </span> error
                                </div>
                            </div> <br>

                            <div class="">
                                This function returns an array of error messages if a token is not valid.
                                <br><br>
                                
                                <div class="pre-area">
                                    <div class="box-full">
                                        <div class="pxv-6 bc-off-white"><code>Example: error</code></div>
                                        <pre class="pre-code">

    if( ! $jws->token($token)->isValid('pass', 'md5') ) {

        var_dump( $jws->error() );

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