@template('template.t-doc')

@lay('build.coords:header')
<style>
    
    ul > li > a{
        color:inherit;
    }   

    ul > li > a:hover{
        color:inherit;
    }   

    ul > li a:hover{
       color: var(--orange-dd);
       cursor:pointer;
    }

    .olist {
        font-family: calibri;
        color: burlywood;
    }
</style>

<div class="pxv-20 c-black-ll">
    
    @lay('build.links:tutor_pointer')

    <div class="font-em-1d5 c-orange">Routing MVC</div> <br>
    
    <div class="db-connection">
        <div class="fb-6">Introduction</div>
        <div class="">
            Just like any other framework, the routing is done by using the 
            <code>Res::load()</code>, <code>Res::post()</code> and <code>Res::get()</code> 
            methods. However, spoova is wired differently, hence, the post and get methods are better handled
            using the <code>Res::load()</code> instead as there are lots of code flexilities attached to it.
            Developers are best left to handle their requests in the manner in which they desire.

            <br><br> Routing can however be applied in two different ways.
            
            <br><br> 1. loading classes through page files.
            <br><br> 2. loading classes through index file using port.

            
        </div> 
    </div> <br>

    <div>
        <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
            1. loading classes through page files.
        </div> <br><br>


        <div class="db-operations">
            <div class="font-menu font-em-1">
            This method involves the use of page files to load classes into their respective pages. 
            The files will only exist to run another main controller file. using by using the <code>Res::load()</code> method
            in each file. This process is highly discourages as it creates multiple handler files that only performs the 
            function of loading controller files. This in fact is the reason it will not be discussed in this tutorial as it is much 
            advisable to either use wmv method to prevent routing from ports or to stick with port routing which will be discussed below.
            </div> <br>
        </div>        
    </div>

    <div>
        <div class="font-menu fb-6 bc-white-dd mox-full rad-4 pxv-8">
            2. loading classes through index file using port.
        </div> <br><br>


        <div class="port-routing">
            <div class="font-menu font-em-1">
            This method involves the use of port to route the index file into loading classes based on requested urls. The urls are first 
            registered and when the address is visited on browser, they are called into activation. In this method, 
            all registered urls are loaded and processed from the index file. <br><br>
            </div> 
            
            Example 1 - Inside the index file, the following is placed <br><br>

            <div class="bc-white-dd font-menu"><br>
    <pre class="pre-code">
    &lt;?php

       include_once 'icore/filebase.php';

       use spoova\windows\App;
    
       Res::get('index', fn => view('index'));

       Res::get('home', fn => view('home'));
       Res::post('home', [App::class, 'index']);

       Res::get('home/user', [App::class, 'index']);

    ?&gt;
    </pre>
            </div>
        </div>
    </div>  
    
    <div class="">
        <div class="font-menu font-em-1">
           The example above reveals different ways by which urls can be routed using the index file. When each 
           url <code>index</code> <code>home</code> or <code>home/user</code> is visited, the view method is executed on that url.
           Unlike wmv, the url supplied are not compiled, instead, the file supplied in the view function is rendered. All template files 
           are loaded from the rex template folder whether it is mvc or wmv method that is applied. However, it is worth noting that only wmv 
           is mobile compatible currently without rooting your mobile device.
        </div> <br>  

        <div class="font-menu font-em-1">
           All post requests are only run when a post request is sent to the defined url, while get requests are run when a url is called 
           using a get method. The example above already explains how a post or get method can be called on different urls.
        </div> <br>  

        <div class="">Notice :</div>          
        <div class="font-em-d95">
            using mvc and wmv together is discouraged as this may lead ti unprecedented issues. We also suggest to visit
            our <a href="@DomUrl('https://youtube.com/wmvpty')">video tutorial</a>  to have a better experience of working on real spoova project.
        </div> 

    </div> <br>
 
    @lay('build.links:tutor_pointer')
</div>

@template;