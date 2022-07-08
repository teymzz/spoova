@template('template.t-doc')

  @lay('build.coords:header')
  
  <section class="pxv-20 database">
   <div class="">
     @lay('build.links:tutor_pointer')
    <div class="font-em-1d5 c-orange">Database : Status</div> <br>

    <div class="pxs-6">
        Statuses are saved when queries are executed which can be accessed using the <code>DBStatus</code> class. 
        Methods which can be called on DBStatus include :
        <br>
        
        <br> <code>DBStatus::query()</code>
        <br> <code>DBStatus::err()</code>
        <br> <code>DBStatus::error()</code>

    </div> <br><br>
    <ul class="list-square">
      <li>
          Query

          <br><br>

          <div class="font-menu">
              The query method returns the last executed query 
          </div>

          <br>

          <div class="">Example 1 </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db = ($dbc = new DB())->openDB();
    
    if( $db ) {

        $db->query('select * from users')->read();

        <span class="comment">// outputs : select * from users</span>
        echo DBStatus::query() ;

    }
    </pre>
          </div> <br><br>

          <div class="font-menu">
              In Example 1 above, when a connection is successful and a query is executed, 
              then the last executed query is displayed.
          </div> <br> 
      </li>

      <li>
          <div class="">Err</div> <br>
          <div class="font-menu mvt-6">
              When an error occurs, the last error is saved and can be obtained using the <code>err()</code> method.
          </div> <br>
          <div class="">Example 2 </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db = ($dbc = new DB)->openDB();

    if( $db ) {

        $db->query('select *name from users')->read();

        <span class="comment">// outputs : select * from users</span>
        if(DBStatus::err()) {

            echo DBStatus::err();

        }

    }
    </pre>
          </div> <br><br>

          <div class="font-menu">
              In the Example 2 above, we checked if an error exists in 
              storage and then displayed the error. Athough, this approach is discouraged,
              it might be useful when working in classes.
          </div>
         <br>

      </li>

      <li>
          Error <br><br>
          <div class="font-menu">
              This method is only used to modify an existing error. It takes a string as parameter.
              The value supplied becomes the last stored error.
          </div> <br>
          <div class="">Example 3</div> <br>

          <div class="font-menu">using Example 2 above,</div>  <br>

          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    if( DBStatus::err() ) {
    
        <span class="comment">// update the last error</span>
        DBStatus::error('New Error Found: '. DBStatus::err());

    }
    </pre>
          </div> <br><br>

          <div class="font-menu font-i">
              In Example 3, we updated our last error by using the <code>error()</code> method.
          </div>
         <br>
      </li>

       
  </ul>
  </section>
  
  @lay('build.coords:footer')

@template;