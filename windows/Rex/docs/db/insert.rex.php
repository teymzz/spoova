@template('template.t-tut')

  @lay('build.co.navbars:left-nav') 

  <section class="pxv-20 database tutorial bc-white">
    <div class="">
        @lay('build.co.links:tutor_pointer')
        <div class="font-em-1d5 c-orange">Database : Insert (CRUD)</div>
        <ul class="list-free pxs-1 mvt-10">
            <li >
                <span class="bi-circle-fill c-silver-d"></span>
                <span class="c-olive">insert_into :</span> The query method directive is the top level sql setter method for
                inserting data into database fields. It defines sql insert queries that can be 
                executed later.

                <br><br>

                <div class="pre-area shadow">
                    <div class="pxv-10 bc-silver">Example 1 : sql setter with chained controllers </div>
            <pre class="pre-code">
  $db->insert_into('users')

     ->columns(['id', 'username'])

     ->values(['1', 'Felix']);
            </pre>
                </div> <br>

                <div class="font-menu mvt-6">The method above is used to set simple sql queries. Methods <code>columns()</code> and <code>values()</code> can only be chained once on the <code>insert_into()</code> operator in the predefined order.</div>
                <br>

                <div class="">Method 2 (Binded Parameters)</div> 
                <div class="font-em-d87">
                    In the example below, columns and values are defined as an array of key(field) and value pairs. 
                    The <code>username</code> represents the database column name and <code>Felix</code> as its respective value. 
                    Several keys and their respective values can be supplied.
                </div> 
                <div class="pre-area shadow">
                    <div class="pxv-10 bc-silver">Example 2 (Binded Parameters)</div> 
            <pre class="pre-code">
  $db->insert_into('users', ['username' => 'Felix']);
            </pre>
                </div> <br><br>   
                <div class="font-menu font-i">Recommend: Method 2 above works similarly as method 1. It is concise and easier to read which makes it the best choice for setting up insert queries</div>

                <div class="c-orange-dd foot-note mvt-6">
                    <span class="head">Footnote:</span>
                    It is worth noting that <code>query()</code>  method can also be used for setting up sql insert queries and may be used to handle multiple insertions <br>
                </div> <br>
            
            <li>
                <span class="bi-circle-fill c-silver-d"></span> 
                <span class="c-olive">insert :</span> This method is used to execute database queries relating to insertions.
                <br><br>

                <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Example 1 : Data insertion</div>
            <pre class="pre-code">
  $db->query('insert into users')
     ->columns(['id', 'username'])
     ->values([1, 'Felix'])
     ->insert();
            </pre>
                </div> <br><br> 

                <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Example 2 : Data insertion</div>
            <pre class="pre-code">
  $db->insert_into('users')
     ->columns(['id', 'username'])
     ->values([1, 'Felix'])
     ->insert();
            </pre>
                </div> <br><br> 

                <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Example 3 : Data insertion</div>
            <pre class="pre-code">
  $db->insert_into('users',['id' => 1, 'username' => 'Felix'])
     ->insert();
            </pre>
                </div> <br><br> 

                <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Example 4 : Data insertion</div>
            <pre class="pre-code">
  $db->query('insert into users columns(id, username) values(?, ?)', [ 1, 'Felix'])
     ->insert();
            </pre>
                </div> <br><br> 

                <div class="pre-area shadow">
<div class="pxv-10 bc-silver">Example 5 : Multiple Data insertion</div>
            <pre class="pre-code">
  $db->insert_into('users', [ 'id' => [1, 2, 3], 'username'=>['Felix','Richard','Brymo']])
     ->insert();
            </pre>
                </div> <br><br> 


            </li> 

                <div class="foot-note">
                    <span class="head">Footnote:</span><br>
                    Method 3 above seems to be the easiest, but when handling complex queries, it is preferred 
                    to use the query approach in Example 4 above. Also, when inserting multiple data, we can use the approach in method 5 above where 
                    data will be splitted into different rows relative to their field (or column) names. It is important to ensure that the data supplied 
                    for columns in method 5 above have equal number of array values to prevent value misplacement or errors.
                    <br>
                </div> <br>
                
            </li>
        
        </ul>
    </div>
  </section>
  
  @lay('build.co.coords:footer')

@template;