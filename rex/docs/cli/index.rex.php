@template('template.t-doc')

    @lay('build.coords:header')

    <div class="pxv-20 c-black-ll">
        
        @lay('build.links:tutor_pointer')

        <div class="font-em-1d5 c-orange">Cli Commands</div> <br>  
        
        <div class="resource-intro">
            <div class="fb-6">Introduction</div>
            <div class="">
                The cli commands are spoova directives that can be used in the cli environment to modify or update
                the developers' project app. The spoova cli commands can only be run from the core folder
                <br><br>
                
                For the purpose of file structuring, it is believed that vendor folder should be part of the core 
                framework. All core applications and classes are stored within the core folder which is the reason 
                for placing vendor folder into core folder.
                
            </div> 
         </div>
         
        <div id="core" class="core-helpers"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Commands </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                A list of helpful cli command are listed below with their descriptions
            </div> <br>
        </div>  

        <div class="">
          <ul>
            <li>add</li>
            <li>add:controller</li>
            <li>add:window</li>
            <li>add:model</li>
            <li>add:winmodel</li>
            <li>add:rex</li>
            <li>config:dbonline</li>
            <li>config:dboffline</li>
            <li>config:usersTable</li>
            <li>config:cookieField</li>
            <li>config:idField</li>
            <li>config:meta</li>
            <li>cli</li>
            <li>classes</li>
            <li>features</li>
            <li>functions</li>
            <li>info</li>
            <li>install</li>
            <li>install:app</li>
            <li>install:db</li>
            <li>install:dbname</li>
            <li>project &lt;project_name&gt;</li>
            <li>support</li>
            <li>version</li>
            <li>watch</li>
          </ul>
        </div>
         
        <div id="add"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add</div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                The "add" directive is being used to add a new file. List of files that can be added are:

                <ul>
                  <li>controller</li>
                  <li>window</li>
                  <li>frame</li>
                  <li>model</li>
                  <li>winmodel (window model)</li>
                  <li>rex (template file)</li>
                </ul>
            </div> <br>
        </div>          
         
        <div id="add-controller"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:controller </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command is used to create a controller file into a specified path. If such path does not exist, the folder 
                will automatically be generated. It is important that the path supplied should be accessible. Path supplied 
                can be be the use of slash or dot.
<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova add:controller &lt;name&gt; &lt;path&gt;
  <span class="comment">
    where: 

        name => name of controller file
        path => path to contoller file
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="add-window"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:window </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command is used to create a window file into the window directory or subdirectory. If such path does not exist, the folder 
                will automatically be generated as a subdirectory of the window directory. Path supplied 
                can be in form of slashes or dots. When the path is not supplied, the file will be added directly into the window directory.
<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova add:window &lt;name&gt; &lt;path&gt;
  <span class="comment">
    where: 

        name => name of controller file
        path => optional path to contoller file
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="add-model"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:model </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command is used to create a model file into a models directory. If such path does not exist, the folder 
                will automatically be generated as a subdirectory of the model directory. Path supplied 
                can be in form of slashes or dots. When the path is not supplied, the file will be added directly into the model directory.
<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova add:window &lt;name&gt; &lt;path&gt;
  <span class="comment">
    where: 

        name => name of window file
        path => optional path to contoller file
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="add-winmodel"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:winmodel </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This winmodel command is used to create a model file into a models directory which is a subdirectory of a the window folder (directory).

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova add:model &lt;name&gt; &lt;path&gt;
  <span class="comment">
    where: 

        name => name of model file
        path => optional path to contoller file
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="add-rex"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> add:rex </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command is used to create a template rex file into the rex directory.
                Path supplied can be in form of dots or slashes. When adding the file name,
                only name should be added without the file extension <code>.rex.php</code>. 
                The file extension will automatically be added. The pathname is also optional.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova add:rex  &lt;pathname&gt.&lt;filename&gt;;
  <span class="comment">
    where: 

        filename => name of rex file
        pathname => optional path to contoller file
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="config-dbonline"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dbonline </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This configures the online database connection parameters. Online parameters 
                are used when working on live environment.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:dbonline dbname dbuser dbpass dbserver dbport dbsocket
  <span class="comment">
    where: 

        dbname => database name
        dbuser => database username
        dbpass => database password 
        dbserver => database server
        dbport => database port 
        dbsocket => database socket

        NOTE: Empty values are replaced with dash (i.e -)
  </span>
  </pre>

</div>
            </div> 
        </div> 
         
        <div id="config-dboffline"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dboffline </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                Similarly to <code>dbonline</code> , the <code>dboffline</code> is used to configures the online database 
                connection parameters. The offline connection parameters are also triggered to be used to connect to database 
                locally.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:dboffline dbname dbuser dbpass dbserver dbport dbsocket
  <span class="comment">
    where: 

        dbname => database name
        dbuser => database username
        dbpass => database password 
        dbserver => database server
        dbport => database port 
        dbsocket => database socket
  </span>
  </pre>

</div>

<div class="pre-area">
  <div class="bc-silver c-silver-dd pxv-6">Example</div>
  <pre class="pre-code">
  <span class="c-lime-dd">php spoova</span> <span class="c-sky-blue-dd">config:dboffline</span><span class="c-violet-dd"> <abbr title="">mydatabase</abbr> <abbr title="">root</abbr> <abbr title="">-</abbr> <abbr title="">localhost</abbr> <abbr title="">3307</abbr> <abbr title="">-</abbr></span>
  <span class="comment">
    where: 

        mydatabase => database name
        root       => database username
        -          => database password (empty) 
        localhost  => database server
        3307       => database port 
        -          => socket (empty)
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="config-userstable"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:usersTable </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This configures the users table name in a given database. This table is expected to contain the user information 
                such as user id or unique id field that can be used to trace a user.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:usersTable tablename
  <span class="comment">
    where: 

        tablename => name of database table
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="config-cookiefield"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:cookieField </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                In most login-logout system, users tend to keep records such as "rememberMe" which enables users to be able 
                to login without difficulty. The cookie field can be used to store a cookie token than can be retrieved for 
                logging in. Although it is not a neccesity to have a cookie field in the database user's table, yet, it is
                important to have a structure in place that supports this. Hence spoova suggests that for every project application, 
                a cookie field should exist in the selected database user's table. The name of this cookie field should be supplied 
                for use when logging in or out of an application.  

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:usersTable tablename
  <span class="comment">
    where: 

        tablename => name of database table
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="config-idField"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:idField </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                Every login-logout system, requires that a user should have an identification number or string. Spoova naturally 
                do not assume the user id column (or field) name is usually an integer field or usually named "id". Instead, a name 
                must be supplied which helps spoova to locate the user id column from the user table already set. The id field used may 
                be a unique field (e.g email, id, phone. e.t.c) 

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:idField column
  <span class="comment">
    where: 

        column => name id column
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="config-meta"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:idField </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                When importing static files using the <code>Res::import()</code> class, the resource class can be configured
                to load default meta configuration automatically when imoporting static files. When such configuration is made, 
                the resource class will only load the meta tag at the first importation while other subsequent importations ignore 
                loading the meta tags.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova config:meta [on|off]
  <span class="comment">
    where: 

        on  => switches automatic importation on 
        off => switches automatic importation off
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="cli"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-code mxr-8 c-lime-dd"></span> cli </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                The <code>cli</code> directive shows a list of available cli commands. When the <code>-lists</code> 
                directive is applied, more details of cli commands are displayed.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova cli [-lists]
  <span class="comment">
    where: 

        -list  => optional directive to display more information on ci commands
  </span>
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="features"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> features </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command shows a list of spoova features

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova features
  <span class="comment">
    where: 

        features  => shows a list of available features
  </span>
  </pre>

</div>
            </div> 
        </div> 

        <div id="info"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-info-circle mxr-8 c-lime-dd"></span> info </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                The <code>info</code> command is used to show a description of a particular command.

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova info &lt;command&gt;
  <span class="comment">
    where: 

        command  => cli command name (e.g add:controller)
  </span>
  </pre>

</div>
            </div> 
        </div> 

        <div id="install"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-download mxr-8 c-lime-dd"></span> Install </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command installs the entire spoova application by testing all configuration parameters supplied for database,
                and the entire application. It also creates neccessary database if the selected database name does not exist 
                as long as the database connection parameters have been properly set. When no option is supplied, then the entire 
                application is installed. Specific options performs their relative functions as shown below.


<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova install [app|db|dbname]
  <span class="comment">
    where: 

        app    => installs entire spoova application 
        db     => installs all database parameters 
        dbname => creates configured database name if it does not already exist
  </span>
  </pre>

</div>
            </div> 
        </div> 

        <div id="project"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> project  </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command is used to create a new project application. This can only be done from the 
                spoova pack directory. When a new project file is created using the cli, all essential mapping 
                of file to the current enviroment is done. It is highly suggested to create a new project app 
                using the cli which ensures that the new project app is essentially ready for configuration.


<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova project &lt;project_name&gt;
  <span class="comment">
    where: 

        project_name    => name of new project application
  </span>
  </pre>

</div>
            </div> 
        </div> 

        <div id="support"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> support </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command displays the current support of spoova frame in terms of php version, mysql server,
                web servers and other essential informations.


<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova support
  </pre>

</div>
            </div> 
        </div> 

        <div id="version"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-file-text mxr-8 c-lime-dd"></span> version </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                This command displays the current version of spoova frame

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova version
  </pre>

</div>
            </div> 
        </div> 
                 
        <div id="watch"> 
            <br>
            <div class="font-menu fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-clock mxr-8 c-lime-dd"></span> watch </div>
              <div class="flex mid">
                <span class="bi-chevron-double-right"></span>
              </div>
            </div> <br>
            
            <div>
                Watch is the inbuilt spoova live server system. This system can be switched to online or offline or disabled mode. 
            

<div class="pre-area">
  <div class="">Syntax</div>
  <pre class="pre-code">
  php spoova watch [online|offline|disabled]
  <span class="comment">
    where: 

        online    => sets watch for both offline and online environments
        offline   => sets watch for offline environment only
        disabled  => disables the watch entirely for both environments
  </span>
  </pre>

</div>
            </div> 
        </div> 
        
        
      </div>

    @lay('build.coords:footer')

@template;
