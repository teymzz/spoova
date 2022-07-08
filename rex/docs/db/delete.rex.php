@template('template.t-doc')

  @lay('build.coords:header')
  
  <section class="pxv-20 database">
   <div class="">
     @lay('build.links:tutor_pointer')
    <div class="font-em-1d5 c-orange">Database : Delete (CRUD)</div> <br>
    <ul class="list-square">
      <li>
          
          do_delete : This query method directive is the top level sql setter method for
          deleting data from database fields. It defines sql select queries that can be 
          executed later.

          <br><br>

          <div class="">Method 1 : set delete query </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->do_delete('from users');
    </pre>
          </div> <br><br>

          <div class="">Method 2 : chain controller </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->do_delete('from users')->where('username = ?', ['Felix']);
    </pre>
          </div> <br><br>

          <div class="font-menu font-i">
              The method above is used to set simple sql queries. 
              Method <code>where()</code> should only be chained once on the <code>delete</code> operator in the predefined order.
          </div>
         <br>

          <div class="">Example 1 : Executing predefined query </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->do_delete('from users')->where('username = ?', ['Felix']);

    $db->delete();
    </pre>
          </div> <br><br>

          <div class="font-menu font-i">
              Deleting from database comes with different formats and the <code>query()</code> method can
              be applied when handling complex delete queries.
          </div> <br>

          <!-- reading with limit -->
          <div class="">Example 2 : Deleting with query method</div> 

          <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('delete * from users')->delete();
    </pre>
          </div> 
          
        </li> 
    </ul>
  </section>
  
  @lay('build.coords:footer')

@template;