

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

    <div class="font-em-1d5 c-orange">Handling Database</div> <br>
    
    <div class="db-connection">
        <div class="fb-6">Database connection</div>
        <div class="">
            Database connections are handled by default using the 
            dbconfig file (i.e icore/dbconfig). However, this can be 
            updated using specific predefined classes. It is worth mentioning that only sql
            database systems are currently supported
        </div> 
    </div> <br>

    <div class="db-operations">
        <div class="fb-6">Setting up a new connection using Database (DB) Class</div>
        <div class="font-menu font-em-1">There are different ways of opening a new connection and we'll be looking at a few examples</div> <br>
        
        <div class="">Method 1</div>
        <div class="pre-area"> <br><br>
    <pre class="pre-code">
   $dbc = (new DB);
   $dbh = $dbc->openDB();
    </pre>
        </div> <br><br>

        <div class="">Method 2</div>        
        <div class="pre-area"> <br><br>
    <pre class="pre-code">
   $dbc = (new DB);
   $dbh = $dbc->openDB(DBNAME);
    </pre>
        </div> <br><br>

        <div class="">Method 3</div>    
        <div class="pre-area"> <br><br> 
    <pre class="pre-code">
   $dbc = (new DB);
   $dbh = $dbc->openDB(DBNAME, DBUSER, DBPASS, DBPORT, DBSERVER, DBSOCKET);
    </pre>
        </div> <br> <br>

        <ul>
            <li>
                In method (1) above, no arguments were supplied. 
                This makes the database class to assume the default 
                configurations already defined in the dbconfig.php file
            </li><br>
            <li>
                In method (2) above, only one database argument is supplied. 
                This makes the database class to assume only the default selected database  
                is needed to be updated. Hence, it switches to a new defined database using 
                default configurations.
            </li><br>
            <li>
                In method (3) above, all arguments were supplied. SOCKET is optional. 
                This makes the database class to overide the default configuration settings.
            </li>
        </ul>

        <div class="font-i c-silver-dd font-menu font-em-d97">
            <span class="fb-6">Footnote:</span><br>

            It is recommended to configure the default database connection 
            parameters in the dbconfig file. This may however be updated later. <br><br>

            Top level connection parameters will only affect subsequent
            connection when strictly defined. This is further discussed under User Account Control.

            <br><br>
            For the purpose of this tutorial, <code>$dbh</code> will be referred to as <code>$db</code>
        </div>
    </div> <br>
    
    <div class="db-connection">
        <div class="fb-6">Running Database Queries (CRUD)</div>
        <div class="">
            Database queries are handled using database crud and non-crud operators which are listed below:

            <br><br>

            <div class="pxs-10">
                <div class="fb-6">SQL setters:</div>
                <div class="mvs-10">These are methods responsible for setting sql up queries</div>
                
                <ul class="olist">
                    <li> <a href="@DomUrl('tutorial/database/query')">query() / queryState()</a>  </li>
                    <li> <a href="@DomUrl('tutorial/database/insert')">insert_into()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/select')">select()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/update')">do_update()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/delete')">do_delete()</a> </li>
                </ul>                 
            </div>

            <div class="pxs-10">
                <div class="fb-6">CRUD Operators:</div>          
                <div class="mvs-10">
                    These are query executors. 
                    They tell database on how to process predefined sql queries.
                </div> 
                <ul class="olist">
                    <li> <a href="@DomUrl('tutorial/database/insert')">insert()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/select')">read()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/update')">update()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/delete')">delete()</a> </li>
                    <li> <a href="@DomUrl('tutorial/database/process')">process()</a> </li>
                </ul>         
            </div>   

            <div class="pxs-10">
                <div class="fb-6">Handling Errors:</div>          
                <div class="mvs-10">
                    These are query executors. 
                    They tell database on how to process predefined sql queries.
                </div> 
                <ul class="olist">
                    <li> <a href="@DomUrl('tutorial/database/errors')">checking errors</a> </li>
                </ul>         
            </div>   

            <div class="pxs-10">
                <div class="fb-6">Database Status:</div>          
                <div class="mvs-10">
                    Database status tracker class <code>DBStatus</code> helps to keep track of few of our database 
                    operations or responses. 
                </div> 
                <ul class="olist">
                    <li> <a href="@DomUrl('tutorial/database/status')">database status</a> </li>
                </ul>         
            </div>   


        </div> 
    </div> <br>

</div>

@template;