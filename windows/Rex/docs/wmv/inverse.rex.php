@template('template.t-tut')

    @title('WMV - Errors')

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
    
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start font-em-d8">

                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Window Inverse</div> <br>  
                    
                    <div class="resource-intro">
                        <div class="">
                            Spoova is a url-loose framework because it handles url comparison as a non-strict type. 
                            This means that a url <code class="calibri">"Home"</code> and <code class="calibri">"home"</code> are regarded to mean the same thing. 
                            There are certain situations that developers may want to be strict in defining window urls, especially 
                            in situations where urls are generated using <code class="calibri">base64_encode()</code> function. In this case,
                            handling case sensitive urls might be an issue. In order to fix this issue, spoova introduces two approaches which can be used to define 
                            case sensitive urls. 
                        </div> 
                    </div> <br>

                    <div class="">

                        <div class="c-olive">SELF::STRICT</div>

                        <div class="mvt-10">
                            The <code class="calibri">SELF::STRICT</code> key, when defined on a shutter, will set all urls to case sensitive. The value must be 
                            set as a boolean of <code class="calibri">true</code>. Once declared within a shutter, the shutter will remember to set all urls to case sensitive 
                            unless an inverse is declared which naturally negates the <code class="calibri">SELF::STRICT</code> key.
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',    <span class="comment no-select">// case sensitive url</span>
            
            'home/profile' => 'root', <span class="comment no-select">// case sensitive url</span>

             <span class="c-teal">SELF::STRICT => true,</span>    <span class="comment no-select">// set all urls as case sensitive</span>

        ])

    }
    
  }

</pre>
                        </div>
                    </div> <br>

                    <div class="">

                        <div class="c-olive">Inverse operator (<code class="calibri">!</code>)</div>

                        <div class="mvt-10">
                           The inverse operator, when declared upon any shutter url, defines that such url must be declared as strict type (i.e case sensitive). Since it is an inverse 
                           operator, in a situation where a <code class="calibri">SELF::STRICT</code> is already defined on a shutter, then applying the inverse <code class="calibri">!</code> operator will declare such
                           url as non-strict (or case insensitive). This relationship is explained below
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',     <span class="comment no-select">// case insensitive url</span>
            
            '<span class="c-brown">!</span>home/profile' => 'root', <span class="comment no-select">// case sensitive url (inverse)</span>

        ])

    }
    
  }

</pre>
                        </div>

                        <div class="pre-area mvt-10">
<pre class="pre-code c-olive">
  &lt;?php 

  use Window;

  class Home extends Window {
    
    function __construct() {

        self::call($this, [

            'home/user' => 'root',     <span class="comment no-select">// case sensitive url</span>
            
            '<span class="c-brown">!</span>home/profile' => 'root', <span class="comment no-select">// case insensitive url (inverse)</span>

             <span class="c-teal">SELF::STRICT => true,</span> <span class="comment no-select">// set all urls as strict except inverse</span>

        ])

    }
    
  }

</pre>
                        </div>

                        <div class="foot-note mvt-10">
                            The examples above best explains the behavior of the inverse operator. on the urls. In the first code example, the natural 
                            shutter behavior was altered using the inverse operator. Likewise, in the second code example, the behavior of 
                            <code>SELF::STRICT</code> on urls was altered using the same operator. It is important to note that the <code>window()</code> 
                            method has also been integerated with the inverse method. Hence, the inverse operator can be used within the window method, for example, 
                            as <code>window('!:user')</code>. The window function will understand to return the value with the inverse operator as its first character.
                            For example assuming our root entry point on a window url is <code>home</code>, then while <code>window(':user')</code> will return <code>home/user</code> 
                            which will be compared as case-insensitive, 
                            <code>window('!:user')</code> will return <code>!home/user</code> which will be compared as a case-sensitive url unless this behaviour is inversely altered with 
                            <code>SELF::STRICT</code> constant. Also, note that the <code>SELF::STRICT</code> inverse behaviour only affect shutters. Function such as 
                            <code>invoke()</code>, <code>windowExcludes()</code> and <code>windowIncludes()</code> will respond in their own individual default ways.
                        </div>

                    </div>

                    @lay('build.co.links:tutor_pointer')

                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')
    
@template;