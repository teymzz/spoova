

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Database : Errors</div> <br>

                    <div class="pxs-6">
                        Running queries sometimes hit a dead end which may be due to different reasons such as: <br>
                        
                        <br> Database connection error
                        <br> Database environment error
                        <br> Database sql error

                        <br><br>
                        In order to prevent end users from encountering this errors, developer must be able to handle such errors.
                        By default, all errors have been softened out. This means that when errors occur, the Database class does not
                        by default output those errors. Instead, developer must use predefined methods to handle such errors. Spoova
                        has created two basic methods to test and check errors for any error. By default, spoova also stores its last 
                        database error in an environment that is accessable at any level of development. We shall be looking at few ways by
                        which we can handle our database errors
                    </div> <br>
                    
                    <ul class="list-free pxs-6">
                        <li>
                            <span class="c-olive">Handling connection errors</span>

                            <br>

                            <div class="d87">
                                The two methods used for handling errors are <code>error_exists()</code> and <code>error()</code>.
                                Whilst <code>error_exists()</code> checks for error, <code>error()</code> returns the error itself. 
                            </div>

                            <br>

                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 1 : Handling connection errors </div>
                        <pre class="pre-code">
  $db = ($dbc = new DB())->openDB();
  
  if( $db ) {
  
      echo 'Database connected successfully';
  
  } else {
  
      echo $dbc->error();
  
  }
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                In Example 1 above, when a connection is successful, <code>openDB()</code> method returns a <code>DBHandler</code> class 
                                else if not successful, it returns an empty value. If an empty value is returned, then an error must have occured. In order
                                to handle that error, we have to call the <code>error()</code> method from the class itself which returns the last occured error.
                            </div> <br> 
                        </li>

                        <li>
                            <div class="c-olive">Handling environment errors</div>
                            <div class="d87">
                                A database may be connected but no database name selected. To work on a specific
                                database, the name must be selected or specified. We can check if a table is selected through
                                of <code>active()</code> method while <code>currentDB()</code> returns the currently selected database name.
                            </div> <br>
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 2 : Handling environment errors</div>
                        <pre class="pre-code">
  $db = ($dbc = new DB)->openDB();
  
  if($dbc->active()) {
  
      <span class="comment">// output the current database selected </span>
      echo $dbc->currentDB();
  
  } else if( $dbc->error() ) {
      
      <span class="comment">// some error occured</span>
      echo $dbc->error();
  
  } else {
  
      <span class="comment">// No attempt to connect to database yet!</span>
      
  }
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                The method above simply checks if a database is selected
                                and prints out the database name using <span class="comment">currentDB()</span>.
                                However, if it does not exist, if an error occured (due to a connection error), 
                                then the last error should be displayed using the <code>error()</code> method. The beauty of this
                                approach is that no error gets printed if a connection has not been previously attempted. It is
                                however important to note that when a default connection e.g <code>dbconfig.php</code> is set, this is
                                assumed to be a previous connection.
                            </div>
                            <br>

                        </li>

                        <li>
                            <div class="c-olive">Handling sql errors</div>
                            <div class="d87">
                                Sql errors are errors that occur after queries have been attempted for execution. To handle this errors, we 
                                use the <code>error_exists()</code> and <code>error()</code> methods just as discussed earlier
                            </div> <br>
                            <div class="box-full font-menu font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 3 : Handling sql errors </div>
                        <pre class="pre-code">
  $db = ($dbc = new DB)->openDB();

  if($db) {

    <span class="comment">// handler connected : run sql </span>
    $db->query('select * from users')->read();

    if( $results = $db->results() ) {
        
        <span class="c-lime-dd">var_dump( $results() );</span>

    } else if ( $db->error_exists() ) {

        echo $db->error();

    }

  } else {

    <span class="comment">// database connection failed</span>
    echo $dbc->error();

  }    
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                In Example 3, we used our <code>$db</code> to run a query and tested for errors using
                                <code>error_exists</code> and <code>error</code> methods respectively. The <code>error()</code>
                                method can also be used to replace <code>error_exists()</code>. However, using <code>error_exists</code> 
                                helps to make our code more readable.
                            </div>
                            <br>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </div>
    
    @lay('build.co.coords:footer')

@template;