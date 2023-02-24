### SPOOVA FRAME
Spoova is a PHP Framework that uses a Window-View-Model (WVM) pattern that 
is built upon MVC arcitecture. It uses a 3-Logic pattern to determine how routes 
are controlled or managed. Other features include inbuilt live server (beta), inbuilt template engine, 
Reusable components, Static Resource Handler, ORM (beta) and FileManager tool.  

##### INSTALLATION / DEPLOYMENT

1. Clone or download the spoova frame project package to your device web server root and rename extracted pack to `spoova`
2. On desktop devices, open project in your terminal and run the command below to create a new separate project application.

```
php mi project <project_name>
```

3. On mobile devices start your mobile local server, rename the spoova project pack to your desired project application name.
4. Visit the new project application on the browser and navigate to <project_name>/install page to configure the essential parameters needed to get started.
5. To restart or refresh configuration, select the refresh button "R" or navigate to "<project_name>/install?refresh" page.
6. Database connection parameters for offline (or local) environments should be configured on local server while online database parameters may be manually configured later in production environment.
7. Once the application is installed, the installation page can be removed.
8. Once configuration has completed, page will be redirected back to the home page.
9. Visit the offline project pack documentation to learn more on how to install the framework and other cli commands.
10. Deploying your application online comes easy. This is because spoova provides special functions that help to localize the static resource files to their current environment. If these functions are used, then if the application is deployed into an online environment, all static resources will be mapped and the application will still run perfectly. This feature helps to simplify the migrations of files across online and offline environments. 

##### CONFIGURATION FILES

1. The database configuration files can be manually configured at _icore/dbconfig.php_ file
2. Other configuration files can be found within the same directory (i.e _icore/_).


##### QUICK TIPS

1. The root _.htaccess_ file should not be modified without proper knowledge of how to handle such files.
2. Storing urls of unused static resources into Resource class (Res) should be avoided to reduce load time.
3. Spoova uses the _res/_ directory to store static files. Hence, all global css and javascript files should be placed within the res directory.
4. All domain and subdomains must have an icore folder within them as icore folder helps to localize and (or) update default configurations when necessary.
5. All subdomain folders (if created), should have access to the res directory (this may require the use of symlink)
6. Place all external php plugins inside the "core/" directory or subdirectories.
7. Run all composer commands from the "core/" directory because the vendor folder is placed within it.
8. Avoid placing classes directly in the the root of "core/" directory. A special subdirectory may be designated for classes.
9. To use the live server, ensure to read the offline documentation provided on how to implement the feature.
10.All spoova directories are protected except the "res/" and "src/" directory which are specially reserved directories for keeping static resources.

##### NOTICE

1. All API route urls should be free of special characters including underscore as this may lead to loss of data.

2. `Spoova` framework's vendor folder exist within a secured `core/` directory which contains all the core aspect of the application. Direct installation from packagist.org is not available at the moment. Download only by cloning the application directly from github or downloading directly as a zipped pack. This project pack however, should not be used directly to build real web applications unless it is being used on a mobile device. If your device is capable of running cli commands, then it is preferred to create a new separate application. The installation has been discussed under the [INSTALLATION / DEPLOYMENT](https://github.com/teymzz/spoova#installation--deployment).
