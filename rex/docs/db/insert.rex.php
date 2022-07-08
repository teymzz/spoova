@template('template.t-doc')

  @lay('build.coords:header')
  
  <section class="pxv-20 database">
   <div class="">
     @lay('build.links:tutor_pointer')
    <div class="font-em-1d5 c-orange">Database : Insert (CRUD)</div> <br>
    <ul class="list-square">
      <li>
          
          insert_into : The query method directive is the top level sql setter method for
          inserting data into database fields. It defines sql insert queries that can be 
          executed later.

          <br><br>

          <div class="">Example 1 : sql setter with chained controllers </div>
          <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $db->insert_into('users')

       ->columns(['id', 'username'])

       ->values(['1', 'Felix']);
    </pre>
          </div> <br><br>

          <div class="font-menu font-i">The method above is used to set simple sql queries. Methods <code>columns()</code> and <code>values()</code> can only be chained once on the <code>insert_into</code> operator in the predefined order.</div>
         <br>

          <div class="">Method 2 (Binded Parameters)</div> 
          <div class="font-em-d95 font-i">
              In the example below, columns and values are defined as an array of key(field) and value pairs. 
              The <code>username</code> represents the database column name and <code>Felix</code> as its respective value. 
              Several keys and their respective values can be supplied.
          </div> 
          <div class="mox-full font-menu  font-em-d85 bc-white-dd flow-x"> <br><br>
    <pre class="pre-code">
    $db->insert_into('users', ['username' => 'Felix']);
    </pre>
          </div> <br><br>   
          <div class="font-menu font-i">Recommend: Method 2 above works similarly as method 1. It is concise and easier to read which makes it the best choice for setting up insert queries</div>
          <br>

          <div class="font-i c-silver-dd font-menu font-em-d97">
              <span class="fb-6">Footnote:</span><br>
              It is worth noting that <code>query</code>  method can also be used for setting up sql insert queries and may be used to handle multiple insertions <br>
          </div> <br>
    
    <li>
        insert : Insert directive is used to execute database queries relating to insertions.
        <br><br>

        <div class="">Example 1 : Data insertion</div>
        <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('insert into users')
       ->columns(['id', 'username'])
       ->values([1, 'Felix']);

    $db->insert();
    </pre>
        </div> <br><br> 

        <div class="">Example 2 : Data insertion</div>
        <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->insert_into('users')->columns(['id', 'username'])->values([1, 'Felix']);
    $db->insert();
    </pre>
        </div> <br><br> 

        <div class="">Example 3 : Data insertion</div>
        <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->insert_into('users',['id' => 1, 'username' => 'Felix'])->insert();
    </pre>
        </div> <br><br> 

        <div class="">Example 4 : Data insertion</div>
        <div class="mox-full font-menu  font-em-d85 bc-white-dd"> <br><br>
    <pre class="pre-code">
    $db->query('insert into users columns(id, username) values(?, ?)', [ 1, 'Felix'])->insert();
    </pre>
        </div> <br><br> 


    </li> 

          <div class="font-i c-silver-dd font-menu font-em-d97">
              <span class="fb-6">Footnote:</span><br>
              Method 3 above seems to be the easiest, but when handling complex queries, it is preferred 
              to use the query approach in Example 4 above.
              <br>
          </div> <br>
          
      </li>
       
  </ul>
  </section>
  
  @lay('build.coords:footer')

@template;