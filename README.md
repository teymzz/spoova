### SPOOVA FRAME
Spoova is a PHP Framework that uses a Window-View-Model (WVM) pattern that is built upon MVC architecture. The WVM is a 3-Logic pattern that determine how routes are resolved. Other features include inbuilt live server, inbuilt template engine, Reusable components, Static Resource Handler, ORM (beta) and FileManager tool.  

##### INSTALLATION

   ###### Direct Installation
   If you are downloading spoova project pack directly from the source pack, clone or download the spoova frame project package to your device web server root and rename extracted pack to `spoova`

   ###### Installation from composer #1
   Run the following command in your local web server root to generate the project pack

   ```cmd 
   composer create-project spoova/mi spoova
   ```
     
   ###### Installation from composer #2
   To use composer require 

   > create a file named "mi" in a folder and add the following command 
  
   ```php
   <?php

    require_once "vendor/autoload.php";

    spoova\mi\core\Spv::init();
   ```

   > Add the _composer.json_ file with the following json sample syntax along with the spoova version required

   ```json
   {    
        "description": "Spoova Framework",
        "keywords": ["php framework", "framework", "spoova"],
        "type": "project",
        "license": "MIT",
        "require": {
            "spoova/mi": "^2.5"
        },
        "require-dev": {
            "phpunit/phpunit": "^9.5"
        },
        "autoload": {
            "psr-4": {
                "spoova\\mi\\": "./"
            }
        },    
        "scripts": {
            "post-autoload-dump": [
                "php mi"
            ]
        },
        "minimum-stability": "dev"
   }
   ```

   > Run the command
    
   ```sh
   composer require spoova/mi
   ``` 
##### Creating First Project Application

   > Once the project package installer is successfully installed on desktop devices, open the newly created pack in a code editor's terminal and run the command below to create a new separate project application.

   ```
   php mi project <project_name>
   ```

   > If web installer was added during project app creation, you can navigate to "<project_name>/install" page to configure the essential parameters needed to get started but it is advisable to use the terminal to ensure all required processes are duely configured.
   - To restart or refresh configuration on web, select the refresh button "R" or navigate to "<project_name>/install?refresh" page.
   - Once the application is installed, the installation page can be removed.
   - Once configuration has completed, page will be redirected back to the home page.

   > If you prefer to configure your application from the terminal, skip step 4 and run the command below to start an interactive installation process. Ensuring that all database parameters if supplied, are wrapped within quotes.

   ```cmd
   php mi config:all
   ```
   > To use spoova for development on mobile devices once the configuration is done, transfer your new project folder to the root of your local mobile web server (e.g KSWeb).

   Visit the offline or online project pack documentation as the case may be to learn more on how to install the framework and other cli commands.

##### PROJECT DEPLOYMENT
Deploying a production-ready application requires the use of specially designed functions that help to localize the static resource files such as image, css and javascript files to their current environment. 

1. The `domurl()` function is required for loading static resources which makes it possible for spoova to keep track of static links. Once the application is deployed into an online environment, all static resources relatively loaded through this function are mapped to the current environment. This funtionality provides the ease of files migration of files across local and remote environments. However, if this function is not employed, developers will have to manually define how their static resources should be loaded and this may be difficult to maintain.
2. When deploying applications, the project folder must be used as the domain root folder. The security of directories is maintained by the root _.htaccess_ file. Any uncensored alteration to this file may lead to broken application.

##### CONFIGURATION FILES

1. The database configuration files are automatically configured by the ```php mi config:all``` command but can be manually configured at _icore/dbconfig.php_ file. Database connection parameters are also loaded by default from this file. Remember to remove your connection paramaters when submitting project to a public environment by running ```php mi config:dboffline``` and also remove the online parameters if previously defined also by running the ```php mi config:dbonline``` with the parameters set as dash (i.e "-") in the command-line. This can also be done manually from the database connection configuration file  _icore/init_.
2. Other configuration files can be found within the same _icore/_ directory.
3. The _icore/init_ file is used to initialize the state of the application.
4. The _.env_ file should also be added to the same directory, if needed. This will enable the _env()_ function to load the defined keys automatically if needed.


##### QUICK TIPS

1. The root _.htaccess_ file should not be modified without proper knowledge of how to handle such files.
2. Storing of unused static resource urls into Resource class (Res) should be avoided to reduce load time.
3. Spoova uses the _res/_ directory to store global static files. Hence, all global css and javascript files should be placed within the res directory.
4. All domain and subdomains must have an icore folder within them as icore folder helps to localize and (or) update default configurations when necessary.
5. All subdomain folders (if created), should have access to the global _res/_ directory (this may require the use of symlink).
6. Avoid placing classes directly in the the root of _core/_ directory. Custom classes may be added to a custom separate folder within the root of your application 
7. To use the live server feature, read the offline documentation provided on how to implement it.
8. All directories and php files are protected while other file extensions are excluded. However, the core, icore and windows directories are strictly protected. Any file within these directories also inherit their protection. These can prove useful in helping to secure the _composer.json_ file.

##### NOTICE

1. The earlier spoova main project pack versions previously contained offline documentation. Starting from version 2.5, The documentation is now available on [spoova.com](https://www.spoova.com)
