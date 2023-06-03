

@template('template.t-tut')

    @lay('build.co.navbars:left-nav') 

    <div class="box-full bc-white-dd">
        <section class="pxv-10 tutorial bc-white">
            <div class="font-em-1d2">

                <div class="start">
                    
                    <div class="font-em-d8 mvt-10">
                    
                        @lay('build.co.links:tutor_pointer') <br>
    
                        <div class="font-em-1d5 c-orange"> <i class="bi-database-fill-gear"></i> Handling Database</div> <br>

                        <div class="db-connection">
                            <div class="fb-6 c-olive">Database connection</div>
                            <div class="">
                                Database connections are handled by default using the 
                                dbconfig file (i.e icore/dbconfig). However, this can be 
                                updated using specific predefined classes. It is worth mentioning that only sql
                                database systems are currently supported
                            </div> 
                        </div> <br>

                        <div class="db-operations">
                            <div class="fb-6 c-olive">Setting up a new connection using Database (DB) Class</div>
                            <div class=" font-em-1">There are different ways of opening a new connection and we'll be looking at a few examples</div> <br>
                            
                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 1</div>
                        <pre class="pre-code">
  $dbc = (new DB);
  $dbh = $dbc->openDB();
                        </pre>
                            </div> <br><br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 2</div>        
                        <pre class="pre-code">
  $dbc = (new DB);
  $dbh = $dbc->openDB(DBNAME);
                        </pre>
                            </div> <br><br>

                            <div class="pre-area shadow">
                                <div class="pxv-10 bc-silver">Method 3</div>    
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

                            <div class="foot-note">
                                <span class="fb-6">Footnote:</span><br>

                                <ul>
                                    <li>
                                        It is recommended to configure the default database connection 
                                        parameters in the dbconfig file. This may however be updated later. <br>
                                    </li>
                                    <li>
                                        Top level connection parameters will only affect subsequent
                                        connection when strictly defined. This is further discussed under 
                                        <a href="@domUrl('docs/useraccounts#running-queries')">
                                            <span class="c-blue foot-note-hyperlink calibri  font-em-d9 fb-6">User Account Control</span>
                                        </a>
                                    </li>
                                    <li>
                                        For the purpose of this tutorial, <code>$dbh</code> will be referred to as <code>$db</code>
                                    </li>
                                </ul>


                                

                            </div>
                        </div> 
                        
                        <div class="db-connection">
                            <div class="fb-6 c-olive">Running Database Queries (CRUD)</div>
                            <div class="">
                                Database queries are handled using database crud and non-crud operators which are listed below:

                                <br><br>

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">SQL setters:</div>
                                    <div class="mvs-10">These are methods responsible for setting sql up queries</div>
                                    
                                    <ul class="olist">
                                        <li> <a href="@DomUrl('docs/database/query')">query() / queryState()</a>  </li>
                                        <li> <a href="@DomUrl('docs/database/insert')">insert_into()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/select')">select()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/update')">do_update()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/delete')">do_delete()</a> </li>
                                    </ul>                 
                                </div>

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">CRUD Operators:</div>          
                                    <div class="mvs-10">
                                        These are query executors. 
                                        They tell database on how to process predefined sql queries.
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="@DomUrl('docs/database/insert')">insert()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/select')">read()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/update')">update()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/delete')">delete()</a> </li>
                                        <li> <a href="@DomUrl('docs/database/process')">process()</a> </li>
                                    </ul>         
                                </div>   

                                <div class="pxs-10">
                                    <div class="fb-6 c-brown-ll">Helper Operators:</div>          
                                    <div class="mvs-10">
                                        Other query executors are helper method which helps to reduce the time frame for performing simple tasks. 
                                        These are listed and explained below: <br>
                                    </div> 
                                    <ul class="olist pxl-14">
                                        <li> 
                                            <a>table_exists()</a> <br>

                                            <div class="c-black-ll pvs-10">This method returns true if a table exists in the database</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->table_exists('table_name')) {
      <span class="comment no-select">
    //run this code ...
      </span>
  }
                                                </pre>
                                            </div>

                                        </li> <br>

                                        <li> 
                                            
                                            <a>column_exist()</a> <br>
                                            <div class="c-black-ll pvs-10">This method returns true if a column exists in the database table name</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->column_exists('table_name', 'column_name')) {
      <span class="comment no-select">
    //run this code ...
      </span>
  }
                                                </pre>
                                            </div>   

                                        </li> <br>

                                        <li> 
                                            
                                            <a>addColumn()</a> <br>
                                            <div class="c-black-ll pvs-10">This method adds a column to database table. The syntax is shown below:</div>
                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->addColumn([table_name => column_name], type, pipe, definition, default)) {
  
  <span class="comment no-select">
    where: 

     table_name  : name of table where column will be added 

     column_name : name of column to be added 

     type        : type of column e.g ( decimal(2,5); varchar(200), e.t.c)

     pipe        : FIRST | AFTER FIELDNAME (After can be replaced with a pipe e.g "|Email" means AFTER Email )

     definition  : field definition (e.g NOT NULL, UNIQUE)

     default     : field default value.
  </span>
  
  }
 </pre>
                                            </div>   

<div class="foot-note">Note: The type (datetime) will set a default of <code>1970-01-01 00:00:00</code> as the default datetime which 
still translates as zero.</div>
                                        </li>

                                        <li> 
                                            
                                            <a>drop()</a> <br>
                                            <div class="c-black-ll pvs-10">This method drops a database, database field or column. Examples are shown below</div> 

                                            <div class="pre-area">
                                                <pre class="pre-code">
  $db = (new DB)->openDB();
  
  if($db->drop(true)) {
  <span class="comment no-select">
    //currently connected database dropped successfully!
  </span>
  }
  
  if($db->drop('table_name', true)) {
  <span class="comment no-select">
    //selected table_name of current database dropped successfully!
  </span>
  }
  
  if($db->drop('table_name', 'column_name')) {
  <span class="comment no-select">
    //relative column dropped successfully
  </span>
  }
  
                                                </pre>
                                            </div>   

                                        
                                        </li>
                                    
                                    </ul>  
                                    
                                </div>

                                <div class="pxs-10">
                                    <div class="fb-6 font-em-1d1 c-orange">Handling Errors:</div>          
                                    
                                    <div class="">
                                        When using any of the helper methods, the DBHandler <code>error_exists()</code> and <code>error()</code> method must be supplied 
                                        an argument of <code>true</code>  in order to function as expected. However <code>DBStatus::err()</code> will still return 
                                        the last error encountered. Errors are discussed below.
                                    </div>
                                    <div class="mvs-10">
                                        Spoova is a silent framework. Most errors are not displayed unless requested.
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="@DomUrl('docs/database/errors')">checking errors</a> </li>
                                    </ul>         
                                </div>   

                                <div class="pxs-10">
                                    <div class="fb-6">Database Status:</div>          
                                    <div class="mvs-10">
                                        Database status tracker class <code>DBStatus</code> helps to keep track of last executed 
                                        sql queries and  error responses. 
                                    </div> 
                                    <ul class="olist">
                                        <li> <a href="@DomUrl('docs/database/status')">database status</a> </li>
                                    </ul>         
                                </div>   


                            </div> 
                        </div> <br>
                    </div>

                </div>
            </div>
        </section>
    </div>
@template;