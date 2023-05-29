@template('template.t-tut')

  @lay('build.co.navbars:left-nav') 
  
  <section class="pxv-20 database tutorial bc-white">
   <div class="">
     @lay('build.co.links:tutor_pointer') <br>
    <div class="font-em-1d5 c-orange">Database : Handling Queries</div> <br> 
    <ul class="list-free pxl-1 mvt-10">
      <li>
          <span class="bi-circle-fill c-silver-d"></span>
          <span class="c-olive">query :</span> The query method directive is the top level sql setter method. 
          It simply sets queries that can be executed later.

          <br><br>

          <div class="box-full   font-em-d85 bc-white-dd shadow">
            <div class="pxv-10 bc-silver">Method 1 (Raw sql queries)</div>
    <pre class="pre-code">
  $db->query('select * from users where id = 1');
    </pre>
          </div> <br><br>

          <div class="box-full   font-em-d85 bc-white-dd shadow">
            <div class="pxv-10 bc-silver">Method 2 (Binded Parameters)</div>
    <pre class="pre-code">
  $db->query('select * from users where id = ?', [1]);
    </pre>
          </div> <br><br>   
          
          
          <div class="box-full   font-em-d85 bc-white-dd shadow">
            <div class="pxv-10 bc-silver">Method 3 (Binded Parameters and Storage)</div>
    <pre class="pre-code">
  $db->query('select * from users where id = ?', [1], 'sql_storage_name');
    </pre>
          </div> <br><br>   

          <div class="foot-note">
              <span class="fb-6">Footnote:</span>

              Query method supports raw sql queries and binded parameters as seen in method 1 and 2 above. 
              However, the database handler class supports a storage system known as sql state. This means 
              that sql queries can be stored at top level and updated later. To do this, an identifier query name must be supplied.
              The stored query can then be pulled later. For example: <br>
          </div> <br>

          <div class="box-full   font-em-d85 bc-white-dd shadow">
            <div class="pxv-10 bc-silver">Method 4 (Storage: query state)</div>
    <pre class="pre-code">
  $db->query('select * from users where id = ?', [1], 'sql_storage_name');
  $db->stateSet(':sql_storage_name', [2]);
    </pre>
          </div> <br><br> 

          <div class="foot-note">
              <span class="head">Footnote:</span>
              In method 4 above, a query was first saved in first line and then imported in second line using 
              the colon followed by the state name. The second argument (optional) 
              is used to update the previously defined binded value of [1] to [2] . This means
              that sql query will remain the same and only the binded parameters will be changed.
              <br>
          </div> <br>
          
      </li>

      <li>
        <span class="bi-circle-fill c-silver-d"></span>
        <span class="c-olive">queryState :</span> This is used to store sql queries just like query method above <br><br>

        <!-- Query State -->
        <div class="box-full   font-em-d85 bc-white-dd shadow">
          <div class="pxv-10 bc-silver">Method 5 (Query state)</div>
    <pre class="pre-code">
  $db->queryState('select * from users where id = ?', [1])
      ->saveState('state_name');

  if( $db->stateSet('state_name') ) {

      <span class="comment">//run code here...</span>

  }
    </pre>
        </div>    
      </li> <br>

      <span class="foot-note">
        The <code class="bd-f">stateSet()</code> method is used to check if a state exists in storage. However, it can also be used
        to select an sql query state at the same time. This is done by applying a colon before the state name. For example:
      </span> <br><br>

      <!-- state set colons -->

      <div class="box-full   font-em-d85 bc-white-dd shadow flow-x">
        <div class="pxv-10 bc-silver">Method 6 (queryState colons)</div>
    <pre class="pre-code">
  $db->queryState('select * from users where id = ?', [1])->saveState('state_name');

  if( $db->stateSet(':state_name') ) {

      <span class="comment">//execute sql query (i.e state_name) </span>
      $db->process();

  }
    </pre>
      </div> 
      
      <!-- states set update -->
            
      <div class="font-em-d9 mvs-10">Binded parameters can be updated when using a state set. <span class="c-orange-dd">For example:</span></div>
      <div class="box-full  font-em-d85 bc-white-dd shadow flow-x">
        <div class="pxv-10 bc-silver">Method 7 (stateSet - update)</div>
  <pre class="pre-code">
  $db->queryState('select * from users where id = ?', [1])->saveState('user');

  if( $db->stateSet(':user', [2]) ) {

      <span class="comment">//execute query (i.e state_name) here</span>
      $db->process();

  }
  </pre>
      </div>
  </ul>
  </section>
  
  @lay('build.co.coords:footer')

@template;