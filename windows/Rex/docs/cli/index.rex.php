
@template('template.t-tut')

  @title('Cli commands')

  @lay('build.co.navbars:left-nav')

  <div class="box-full pxl-2 bc-white-dd pull-right">
    
    <section class="pxv-10 tutorial mails bc-white">
      <div class="font-em-1d2">

        @lay('build.co.links:tutor_pointer')

        <div class="start font-em-d8">

          <div class="font-em-1d5 c-orange"> <span class="bi-terminal"> </span>Cli Commands</div> <br>  
          
          <div class="resource-intro">
            <div class="">
              The spoova framework uses a terminal command <code>mi</code> which is an helpful command to modify or update
              the developers' project app. This command can also be used for generating classes or files needed within the application. 
              In this page, we will learn about some useful cli commands that can make the development of project applications easier.
            </div> 
          </div>
          
          <div id="core" class="core-helpers"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> Commands </div>

            </div> <br>
            
            <div>
                A list of helpful cli <code>mi</code> commands are listed below with their descriptions
            </div> <br>
          </div>  

          <div class="">
            <ul>
              <li><a href="#add">add</a></li>
              <li><a href="#add-window">add:window</a></li>
              <li><a href="#add-model">add:model</a></li>
              <li><a href="#add-frame">add:frame</a></li>
              <li><a href="#add-route">add:route</a></li>
              <li><a href="#add-api">add:api</a></li>
              <li><a href="#add-migrator">add:migrator</a></li>
              <li><a href="#add-rex">add:rex</a></li> 
              <li><a href="#backup-project">backup project</a></li> 
              <li><a href="#backup-clear">backup :clear</a></li> 
              <li><a href="#clean-storage">clean storage</a></li> 
              <li><a href="#config-all">config:all</a></li>
              <li><a href="#config-dbonline">config:dbonline</a></li>
              <li><a href="#config-dbonline">config:dboffline</a></li>
              <li><a href="#config-env">config:env</a></li>
              <li><a href="#config-usersTable">config:usersTable</a></li>
              <li><a href="#config-cookieField">config:cookieField</a></li>
              <li><a href="#config-idField">config:idField</a></li>
              <li><a href="#config-meta">config:meta</a></li>
              <li><a href="#cli">cli</a></li>
              <li><a href="#features">features</a></li>
              <li><a href="#info">info</a></li>
              <li><a href="#install">install</a></li>
              <li><a href="#migrate">migrate</a></li>
              <li><a href="#project">project &lt;project_name&gt;</a></li>
              <li><a href="#support">support</a></li>
              <li><a href="#version">version</a></li>
              <li><a href="#watch">watch</a></li>
              <li><a href="#wiz">:wiz</a></li>
            </ul>
          </div>
          
          <div id="add"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add</div>

            </div>
            
            <div>

                <div class="pvs-10">
                  The "add" directive is being used to add a new file. List of files that can be added are:
                </div>

                <ul>
                  <li>windows</li>
                  <li>frames</li>
                  <li>routes</li>
                  <li>apis</li>
                  <li>models</li>
                  <li>rex (template file)</li>
                </ul>
            </div> 
          </div>          
          
          <div id="add-window"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:window </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to create a window file into the window directory or subdirectory. If such path does not exist, the folder 
                will automatically be generated as a subdirectory of the window directory. Path supplied 
                can be in form of slashes or dots. When the path is not supplied, the file will be added directly into the window directory.
              </div>
              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:window &lt;dir?&gt;&lt;windowName&gt; &lt;extends?&gt; [-O?];
  <span class="comment">
    where: 

        name => name of controller file
        path => optional path to contoller file
    
        
    Ex1: <span class="c-orange-dd">php mi add:window Info</span>   <span class="no-select">//add class <span class="c-teal">windows\Info</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:window Info.User</span> <span class="no-select">//add class <span class="c-teal">windows\Info\User</span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:window Info.User UserFrame</span> <span class="no-select">//add class <span class="c-teal">windows\Info\User<span class="comment">, extend to <span class="c-dodger-blue">Frames\UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:window Info UserFrame -O</span> <span class="no-select">//add class <span class="c-teal">windows\Info<span class="comment">, extend to <span class="c-dodger-blue">Frames\UserFrame</span>, overwrite any previous file.</span> </span> </span>
                </span>
                </pre>

              </div>
            </div> 
          </div> 
          
          <div id="add-frame"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:frame </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This "frame" command is used to create a frame file into a "windows/frames" directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:frame &lt;path&gt; [-O?]
  <span class="comment">
    where: 

        path => path to frame file within Frames directory
        [-O] => overwrite old file (optional)
        
    Ex1: <span class="c-orange-dd">php mi add:frame Info</span>   <span class="no-select">//add <span class="c-teal">windows/Frames/Info.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:frame Info.UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Frames/Info/UserFrame.php </span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:frame Info.UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Info/UserFrame.php <span class="comment"> overwrite any previous file.</span> </span> </span>

  </span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="add-routes"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:route </div>
            </div>
            
            <div>
                <div class="pvs-10">
                  This "route" command is used to create a route entry point file into a "windows/Routes" directory which is a subdirectory of the windows folder (directory).
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:route &lt;path&gt; &lt;extends?&gt; [-O?]
  <span class="comment">
    where: 

        path => path of route file within window/Routes directory
        extends => extend to frame file
        -O => Overwrite any existing file.
            
    Ex1: <span class="c-orange-dd">php mi add:route MyRoute</span>   <span class="no-select">//add <span class="c-teal">windows/Routes/MyRoute.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:route Loc.MyRoute</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php. </span>
    Ex3: <span class="c-orange-dd">php mi add:route Loc.MyRoute UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php <span class="comment">extend to <span class="c-dodger-blue">Frames\UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:route Loc.MyRoute UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Loc/MyRoute.php <span class="comment">extend to <span class="c-dodger-blue">Frames\UserFrame</span> overwrite any previous file.</span> </span> </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="add-api"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:api </div>

            </div>
            
            <div>
              <div class="pvs-10">
                The "api" command is used to create a routed api files into a "windows/API" directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:api [name] [extends?] [\Dir?] [-O?]
  <span class="comment">
    where: 

        name => name of api route
        extends? => extend to a frame class
        \Dir => directory of api route 
        -O   => overwrite any previous file   
    
    Ex1: <span class="c-orange-dd">php mi add:api Info</span>   <span class="no-select">//add <span class="c-teal">windows/Routes/Info.php</span>. </span>
    Ex2: <span class="c-orange-dd">php mi add:api Info \Loc</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Info.php, <span class="comment">add</span> windows/Routes/Loc/InfoAPI.php</span>. </span>
    Ex3: <span class="c-orange-dd">php mi add:api Info UserFrame</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames\UserFrame</span>.</span> </span> </span>
    Ex4: <span class="c-orange-dd">php mi add:api Info UserFrame -O</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames\UserFrame</span> overwrite any previous file.</span> </span> </span>
    Ex5: <span class="c-orange-dd">php mi add:api Info UserFrame \Loc -O</span> <span class="no-select">//add <span class="c-teal">windows/Routes/Info.php <span class="comment">extend to <span class="c-dodger-blue">Frames\UserFrame</span>, add <span class="c-teal">windows/Routes/Loc/InfoAPI.php</span>, overwrite any previous file.</span> </span> </span>

  </span>
                </pre>
              </div>
            </div>

          </div> 

          <div id="add-migrator"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:migrator </div>

            </div>
            
            <div>
              <div class="pvs-10">
                This command is used to add a migration file. Migratrion files are added based on specific naming syntaxes. Migration files that starts with 
                the identifier name <code>"create_"</code>  are assumed to be for creating tables while those with starting <code>"alter_"</code> are assumed to be for altering tables. 
                All migration files are generated and added directly to the <code>migrations/</code> directory. The migration file name is also used as the class name. This means that 
                only names accepted for naming classes should be used. 
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:migrator name
  <span class="comment">
    where: 

        name => name of migration file  
  </span>
                </pre>
              </div>
            </div>

          </div> 
          
          <div id="add-model"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:model </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This model command is used to create a model file into a models directory which is a subdirectory of the windows folder (directory).
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:model &lt;path&gt; [-O?]
  <span class="comment">
    where: 

      path => path to model file within the windows/Models directory.
      -O => overwrite any previous file.

    Ex1: <span class="c-orange-dd">php mi add:model UserModel</span>            <span class="no-select">//add <span class="c-teal">windows/Models/UserModel.php</span> </span>
    Ex2: <span class="c-orange-dd">php mi add:model Access.UserModel</span>     <span class="no-select">//add <span class="c-teal">windows/Models/Access/UserModel.php</span> </span>
    Ex3: <span class="c-orange-dd">php mi add:model Access.UserModel -O</span>  <span class="no-select">//add <span class="c-teal">windows/Models/Access/UserModel.php</span>, overwrite previous file </span>

  </span>
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="add-rex"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> add:rex </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to create a template rex file into the <code>windows/Rex</code> directory.
                Path supplied can be in form of dots or slashes. When adding the file name,
                only name should be added without any file extension. The type of rex file can be supplied 
                using the column directive. However if no type is defined, then the rex file will assume a default 
                extension of <code>php</code>.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi add:rex  &lt;pathname&gt;.&lt;filename&gt;&lt;:ext?&gt;
  <span class="comment">
    where: 

      filename => name of rex file
      pathname => optional path to contoller file
      :ext     => options [:css|:js|:php]


    Ex1: <span class="c-orange-dd">php mi add:rex index</span>            <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.php</span> </span>
    Ex2: <span class="c-orange-dd">php mi add:rex index:css</span>        <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.css</span> </span>
    Ex3: <span class="c-orange-dd">php mi add:rex index:js</span>         <span class="no-select">//add <span class="c-teal">windows/Rex/index.rex.js</span> </span>
    Ex4: <span class="c-orange-dd">php mi add:rex build.index:css</span>  <span class="no-select">//add <span class="c-teal">windows/Rex/build/index.rex.css</span> </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="backup-project"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> backup project </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to storage backups. It uses interactive console steps to determine how best to generate project backups. 
                The default backup folder name is "backup". 
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi backup project
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="backup-clear"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> backup :clear </div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to delete the entire project backups from the <code class="">backup/</code> directory that 
                is reserved for backups. It is essential to trend carefully when applying this command since all the backups removed 
                cannot be recovered.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi backup <span class="c-orange-dd">:clear</span>
                </pre>
              </div>
            </div> 
          </div> 

          <div id="clean-storage"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> clean storage </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This command is used to clean storage files. When executed, this will remove all storage files from the storage path.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi clean storage
                </pre>
              </div>
            </div> 
          </div> 
          
          <div id="config-all"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:all </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This is an interactive console guide to set up all required essential configuration parameters.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:all

  <span class="comment">Note: database connection parameters must always be wrapped within quotes.</span>
                </pre>

</div>
            </div> 
          </div> 
          
          <div id="config-dbonline"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dbonline </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This configures the online database connection parameters. Online parameters 
                are used when working on live environment.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:dbonline "dbname dbuser dbpass dbserver dbport dbsocket"
  <span class="comment">
    where: 

        <span class="c-orange">dbname</span> => database name
        <span class="c-orange">dbuser</span> => database username
        <span class="c-orange">dbpass</span> => database password 
        <span class="c-orange">dbserver</span> => database server
        <span class="c-orange">dbport</span> => database port 
        <span class="c-orange">dbsocket</span> => database socket

        NOTE: Empty values are replaced with dash (i.e "-")

        Ex: <span class="c-orange-dd">php mi config:dbonline "tester root - localhost 3306" </span>  <span class="no-select">//set online database connection parameters </span>
  </span>
                </pre>

</div>
            </div> 
          </div> 
          
          <div id="config-dboffline"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:dboffline </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Similarly to <code>dbonline</code>, the <code>dboffline</code> is used to configures the online database 
                  connection parameters. The offline connection parameters are also triggered to be used to connect to database 
                  locally.
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:dboffline "dbname dbuser dbpass dbserver dbport dbsocket"
  <span class="comment">
    where: 

        <span class="c-orange">dbname</span> => database name
        <span class="c-orange">dbuser</span> => database username
        <span class="c-orange">dbpass</span> => database password 
        <span class="c-orange">dbserver</span> => database server
        <span class="c-orange">dbport</span> => database port 
        <span class="c-orange">dbsocket</span> => database socket

        NOTE: Empty values are replaced with dash (i.e "-")

        Ex: <span class="c-orange-dd">php mi config:dboffline "tester root - localhost 3306" </span>  <span class="no-select">//set offline database connection parameters </span>
</span>
                </pre>

              </div>

              <div class="pre-area shadow">
                <div class="bc-silver pxv-6">Example</div>
                <pre class="pre-code">
  <span class="c-lime-dd">php mi</span> <span class="c-orange-dd">config:dboffline</span><span class="c-violet-dd"> "<abbr title="">mydatabase</abbr> <abbr title="">root</abbr> <abbr title="">-</abbr> <abbr title="">localhost</abbr> <abbr title="">3307</abbr> <abbr title="">-</abbr>"</span>
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
                  
          <div id="config-env"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:env </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This configures the <code>icore/.env</code> environment keys.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:env key value
  <span class="comment">
    where: 

      key   : key to be configured

      value : value of key

      Ex: <span class="c-orange-dd">php mi config:env API_KEY some_value</span>
  </span>
                </pre>

              </div>

            </div> 
          </div> 

          <div id="config-userstable"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:usersTable </div>

            </div>
            
            <div>

              <div class="pvs-10">
                This configures the users table name in a given database. This table is expected to contain the user information 
                such as user id or unique id field that can be used to trace a user.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:usersTable tablename
  <span class="comment">
    where: 

      tablename => name of database table

      Ex: <span class="c-orange-dd">php mi config:userTable users</span>  <span class="no-select">//set database user info table</span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="config-cookiefield"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:cookieField </div>

            </div>
            
            <div>

              <div class="pvs-10">
                In most login-logout system, users tend to keep records such as "rememberMe" which enables users to be able 
                to login without difficulty. The cookie field can be used to store a cookie token than can be retrieved for 
                logging in. Although it is not a neccesity to have a cookie field in the database user's table, yet, it is
                important to have a structure in place that supports this. Hence spoova suggests that for every project application, 
                a cookie field should exist in the selected database user's table. The name of this cookie field should be supplied 
                for use when logging in or out of an application.  
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:cookieField tablename
  <span class="comment">
    where: 

      tablename => name of database table

      Ex: <span class="c-orange-dd">php mi config:cookieField cookie </span>  <span class="no-select">//set cookie column in user info table </span>
  </span>
                </pre>
              </div>
            </div> 
          </div> 
                  
          <div id="config-idField"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:idField </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Every login-logout system, requires that a user should have an identification number or string. Spoova naturally 
                  do not assume the user id column (or field) name is usually an integer field or usually named "id". Instead, a name 
                  must be supplied which helps spoova to locate the user id column from the user table already set. The id field used may 
                  be a unique field (e.g email, id, phone. e.t.c) 
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:idField column
  <span class="comment">
    where: 

      column => name id column

      Ex: <span class="c-orange-dd">php mi config:idField email</span>  <span class="no-select">//set user id column name in user table</span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="config-meta"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-gear mxr-8 c-lime-dd"></span> config:meta </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  If meta tags are configured by default to be loaded by the resource class automatically, when importing static files using any of the resource 
                  importer function, method or directives (e.g <code>&lt;?= Res::import() &gt;</code>, <code>@(Res())@</code>), the resource class
                  will build meta tags using the configuration set in <code>icore/filemeta.php</code> file and the predefined meta tags will be added only once to the webpage. 
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi config:meta [on|off]
  <span class="comment">
    where: 

      on  => switches automatic importation on 
      off => switches automatic importation off

      Ex: <span class="c-orange-dd">php mi config:meta on</span>  <span class="no-select">//set meta tags autoloading from <span class="c-teal">icore/filemeta.php</span> configuration on </span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="cli"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> cli </div>

            </div> <br>
            
            <div>
                The <code>cli</code> directive shows a list of available cli commands. When the <code>-lists</code> 
                directive is applied, more details of cli commands are displayed.

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi cli [-lists]
  <span class="comment">
    where: 

      -list  => optional directive to display more information on cli commands

      Ex: <span class="c-orange-dd">php mi cli -lists </span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="features"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> features </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  This command shows a list of spoova features
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi features
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
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-info-circle mxr-8 c-lime-dd"></span> info </div>

            </div>
            
            <div>

              <div class="pvs-10">
                The <code>info</code> command is used to show a description of a particular command.
              </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi info &lt;command&gt;
  <span class="comment">
    where: 

      command  => cli command name (e.g add:window)

      Ex1: <span class="c-orange-dd">php mi info add:window</span>  <span class="no-select">//displays description for "add:window" command</span>
      Ex2: <span class="c-orange-dd">php mi info add:routes</span>  <span class="no-select">//displays description for "add:routes" command</span>
      Ex3: <span class="c-orange-dd">php mi info "watch status"</span>  <span class="no-select">//displays description for "watch status" command</span>
  </span>
      <span class="c-teal"><span class="bi-circle-fill"></span> You can view a list of available commands using <code>php mi cli -lists</code></span>
               </pre>


              </div>
            </div> 
          </div> 

          <div id="install"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-download mxr-8 c-lime-dd"></span> Install </div>
            </div>
            
            <div>

                <div class="pvs-10">
                  This command installs the entire spoova application by testing all configuration parameters supplied for database
                  and the entire application. It also creates neccessary database if the selected database name does not exist 
                  as long as the database connection parameters have been properly set. When no option is supplied, then the entire 
                  application is installed. Specific options performs their relative functions as shown below.
                </div>


              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi install [db|dbname] [folder?]
  <span class="comment">
    where: 

      db     => test the database connection parameters defined in "icore/dbconfig.php" file 
      dbname => creates default database name supplied in "icore/dbconfig.php" file using the defined connection parameters
      folder => refers to an optional custom folder name in project root that contains an "icore/dbconfig.php" file with connection parameters.
  </span>
                </pre>

              </div>
            </div> 
          </div> <br>

          <div id="migrate"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-server mxr-8 c-lime-dd"></span> Migrate </div>
            </div>
            
            <div>

                <div class="pvs-10">
                  The "migrate" command is used to step up, step down or get migration status.
                </div>


              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi migrate [up|down|status]
  <span class="comment">
    where: 

      up     => step up the migration files
      down   => step down the migration files
      status => fetches the migration status table.
  </span>
                </pre>

              </div>
              <div class="foot-note pvs-6">
                Note that when running migrations down, the number of times to run migrations down can be specified. This is done by supplying the number of  
                down migrations after the "migrate down" command. For example, <code>mi migrate down 4</code> will step down the migration files in four times. 
                This means that only the last 4 recent migration files will be affected while others will be ignored.
              </div>
            </div> 
          </div> <br>

          <div id="project"> 
              <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
                <div class="flex-full midv"> <span class="bi-folder mxr-8 c-lime-dd"></span> project  </div>
                <div class="flex mid">
                  <span class="bi-chevron-double-right"></span>
                </div>
              </div> 
              
              <div>

                  <div class="pvs-10">
                    This command is used to create a new separate project application. This should be done from the 
                    spoova project pack directory. When a new project file is created using the cli, all essential mapping 
                    of file to the current enviroment is done. It is highly suggested to create a new project app 
                    using the cli which ensures that the new project app is essentially ready for configuration.
                  </div>


                <div class="pre-area shadow">
                  <div class="pxv-6 bc-silver">Syntax</div>
                  <pre class="pre-code">
  php mi project &lt;project_name&gt;
  <span class="comment">
    where: 

      project_name => name of new project application

      Ex: <span class="c-orange-dd">php mi project lumen</span>  <span class="no-select">//create separate project name "lumen"</span>
  </span>
                  </pre>

                </div>
              </div> 
          </div> <br>

          <div id="support"> 
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> support </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  This command displays the current support of spoova frame in terms of php version, mysql server,
                  web servers and other essential informations.
                </div>


              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi support
                </pre>
              </div>
            </div> 
          </div> 

          <div id="version"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-terminal mxr-8 c-lime-dd"></span> version </div>
            </div>
            
            <div>

                <div class="pvs-10">
                  This command displays the current version of spoova frame
                </div>

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi version
                </pre>
              </div>
            </div> 
          </div> 
                  
          <div id="watch"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="bi-clock mxr-8 c-lime-dd"></span> watch </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  Watch is the inbuilt spoova live server system. This system can be switched to online or offline or disabled mode. 
                </div>
            

              <div class="pre-area shadow">
                <div class="pxv-6 bc-silver">Syntax</div>
                <pre class="pre-code">
  php mi watch [online|offline|disabled|status]
  <span class="comment">
    where: 

      online    => sets watch for both offline and online environments
      offline   => sets watch for offline environment only
      disabled  => disables the watch entirely for both environments
      status    => get the current configuration status of watch

      Ex1: <span class="c-orange-dd">php mi watch online  </span>  <span class="no-select">//set watch to online and offline environments </span>
      Ex2: <span class="c-orange-dd">php mi watch offline </span>  <span class="no-select">//set watch to offline environment </span>
      Ex3: <span class="c-orange-dd">php mi watch disabled</span>  <span class="no-select">//set watch to disabled mode </span>
      Ex4: <span class="c-orange-dd">php mi watch status</span>    <span class="no-select">//get current watch status.</span>
  </span>
                </pre>

              </div>
            </div> 
          </div> 
                  
          <div id="wiz"> 
            <br>
            <div class=" fb-6 bc-white-dd flex-full rad-4 pxv-8 lacier">
              <div class="flex-full midv"> <span class="helvetica mxr-6"><span class="bi-magic"></span></span> <span>wiz</span> </div>

            </div>
            
            <div>

                <div class="pvs-10">
                  This command starts a wizard that is capable of running php codes in the command line in the offline environment. The <code>wiz</code> 
                  also allows pasting of code lines on the command line. In order to execute commands, developer must end code with a newline followed by 
                  semicolon delimiter and then an enter. This tells the wiz to run or process the code. If the delimiter is not added on a separate line, 
                  the wiz will just assume that the delimiter is part of the code and will not execute it.
                </div>
            

                <div class="pre-area shadow">
                  <div class="pxv-6 bc-silver">Syntax</div>
                  <pre class="pre-code">
  php mi :wiz
                  </pre>
                </div>

                <div class="foot-note pvs-10">
                  When working with wiz, all important namespaces must be fully defined in a way that it becomes accessible.
                </div>

            </div> 
          </div> 
          
        </div>
      </div>
    </section>

  </div>

  @lay('build.co.coords:footer')

@template;
