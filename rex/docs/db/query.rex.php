@template('template.t-doc')

  @lay('build.coords:header')
  
  <section class="pxv-20 database">
   <div class="">
     @lay('build.links:tutor_pointer')
    <div class="font-em-1d5 c-orange">Database : Handling Queries</div> <br>
    <ul class="list-square">
      <li>
          
          query : The query method directive is the top level sql setter method. 
          It simply sets queries that can be executed later.

          <br><br>

          <div class="">Method 1 (Raw sql queries)</div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('select * from users where id = 1');
    </pre>
          </div> <br><br>

          <div class="">Method 2 (Binded Parameters)</div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('select * from users where id = ?', [1]);
    </pre>
          </div> <br><br>   
          
          
          <div class="">Method 3 (Binded Parameters and Storage)</div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('select * from users where id = ?', [1], 'sql_storage_name');
    </pre>
          </div> <br><br>   

          <div class="font-i c-silver-dd font-menu font-em-d97">
              <span class="fb-6">Footnote:</span><br>

              Query method supports raw sql queries and binded parameters as seen in method 1 and 2 above. 
              However, the database handler class supports a storage system known as sql state. This means 
              that sql queries can be stored at top level and updated later. To do this, an identifier query name must be supplied.
              The stored query can then be pulled later. For example: <br>
          </div> <br>

          <div class="">Method 4 (Storage: query state)</div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('select * from users where id = ?', [1], 'sql_storage_name');
    $db->stateSet(':sql_storage_name', [2]);
    </pre>
          </div> <br><br> 

          <div class="font-i c-silver-dd font-menu font-em-d97">
              <span class="fb-6">Footnote:</span><br>
              In method 4 above, a query was first saved and then imported using 
              the colon followed by the state name. The second argument (optional) 
              is used to update the previously defined binded value of [1] to [2] . This means
              that sql query will remain the same and only the binded parameters will be changed.
              <br>
          </div> <br>
          
      </li>

      <li>
        queryState : This is used to store sql queries just like query method above <br><br>

        <!-- Query State -->
        <div class="">Method 5 (Query state)</div>
        <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->queryState('select * from users where id = ?', [1])
       ->saveState('state_name');

    if( $db->stateSet('state_name') ) {

      <span class="comment">//run code here...</span>

    }
    </pre>
        </div>    
      </li> <br>

      <span class="c-silver-dd">
        Footnote: stateSet is used to check if a state exist in storage. However, it can also be used
        to select an sql query state at the same time. This is done by applying a colon before the state name. That is:
      </span> <br><br>

      <!-- state set colons -->

      <div class="">Method 6 (Query state colons)</div>
      <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $db->queryState('select * from users where id = ?', [1])->saveState('state_name');

    if( $db->stateSet(':state_name') ) {

      <span class="comment">//execute sql query (i.e state_name) </span>
      $db->process();

    }
    </pre>
      </div> 
      
      <!-- states set update -->
            
      <br><br>
      <div class="">Method 7 (State set - update)</div>
      <div class="">Binded parameters can be updated when using a state set. For example:</div>
      <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
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
  
  @lay('build.coords:footer')

@template;