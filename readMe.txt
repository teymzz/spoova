#INSTALLATION / DEPLOYMENT ------------------------------------------------------------

1) Create a new project appliation by running the command "php spoova project <project_name>"
2) On completion of installation process, visit the supplied application and navigate to install page.
3) Configure the essential parameters needed to get started.
4) Once configuration has completed, page will be redirected back to the home page.
5) To restart configuration, select the refresh button "R" or click on Hard Install.

#DEFAULT DATABASE CONFIGURATION---------------------------------------------------------

6) The Offline Database connection parameters should be configured on local server while Online may be configured later in deployment environment.
7) For other ways to connect to database or learn about the database handlers, read _DB file inside core/classes folder.
8) Online activation or mapping must be done by vising the domain url once the application is deployed
9) Read more from the documentation (online) which is also available locally in Ultra Pack.

#QUICK TIPS ----------------------------------------------------------------------------

1. It is important to be connected to the "filebase.php" file. WMV system already has access to this file.
2. The use of Resource class (Res) to store and import css or javascript files will give you dynamic control over them but avoid storing unused urls to reduce load time.
3. Place all your global css and javascript files in the appropriate folder inside the res folder
4. For Single hosting, you can place your files directly in the root folder or create a domain folder within the root folder
5. All domain and subdomains must have an icore folder within them as icore folder helps to localize and (or) update default configurations when necessary
3. All domain folder (if created) or subdomain folders, should have access to the res folder (this will require symlink folder in all cases except for only main domain folder when it is also the root folder)
4. Place all external php plugins inside the core folder or core/vendor folder (if composer was used)
5. Avoid placing classes directly in the the root 'core' folder. A special subfolder like the "classes" or "tools" folder may be created for classes.
6. To use the live server, ensure to read the documentation provided on how to implement it.
7. If an error occurs while the page is loading, this may terminate the live state. Fatal Errors must be fixed, then page should be manually reloaded to resume the live state.
8. Ensure that all inputs are properly validated to prevent undesirable responses.