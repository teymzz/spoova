

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')
                <div class="start font-em-d8">
        
                    <div class="font-em-1d5 c-orange">Database : Select (CRUD)</div> 
                    
                    <ul class="list-free pxs-1 mvt-10">
                        <li>
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> select</span> <br>
                             The query method directive is the top level sql setter method for
                            selecting data from database fields. It defines sql select queries that can be 
                            executed later.

                            <br><br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Method 1 : select </div>
                        <pre class="pre-code">
  $db->select('* from users');
                        </pre>
                            </div> <br><br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Method 2 : select with chained controller </div>
                        <pre class="pre-code">
  $db->select('* from users')->where(['username'=>'Felix']);
                        </pre>
                            </div> <br><br>

                            <div class="font-menu font-i">
                                The method above is used to set simple sql queries. 
                                Method <code>where()</code> should only be chained once on the <code>select()</code> operator in the predefined order.
                            </div>
                            <br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 1 : Executing predefined query </div>
                        <pre class="pre-code">
  $db->select('* from users')->where(['username'=>'Felix']);

  $result = $db->read();
                        </pre>
                            </div> <br><br>

                            <div class="font-menu font-i">
                                Reading from database comes with different formats as the <code>read()</code> method is
                                capable of applying limits to queries. Another method <code>results()</code> can be used to 
                                obtain and remodify data obtained from the database. Let's take a look at some few examples.
                            </div> <br>

                            <!-- reading with limit -->
                            
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 2 (Reading with limit)</div> 
                        <pre class="pre-code">
  $db->query('select * from users')->read(1);
                        </pre>
                            </div> <br><br>   
                            <div class="font-menu font-i">In Example 2 above, only one data is fetched from the database</div>
                            <br>

                            <!-- reading with limits -->
                            
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 3 (Reading with limits)</div> 
                        <pre class="pre-code">
  $db->query('select * from users')->read(1, 2);
  $db->query('select * from users')->read(5, 7);
                        </pre>
                            </div> <br><br>   
                            <div class="font-menu font-i">
                                In Example 3 above, only two data is fetched from the database table. <br><br>
                                The first query translates that the number 1 data on the database should be 
                                ignored whilst 2 data should be obtained after. <br>
                                The second query translates that the number 5 data on the database should be 
                                ignored whilst 2 data should be obtained after (i.e. 7). <br>
                            </div>
                            <br>

                            <div class="foot-note">
                                <span class="head">Footnote:</span>
                                It is worth noting that data obtained are always in a multi-dimentional array format.<br>
                            </div> <br>
                        
                        <li>
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> results </span> <br>
                             This method is applied on data obtained from the database. It performs a data modifier function.
                            <br><br>

                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 4 : Data Fetching</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix']);
  
  $result1 = $db->read()? $db->results() : [];
  
  $result2 = $db->read()? $db->results(0) : [];
  
  $result3 = $db->read()? $db->results(0, 'username') : [];
                        </pre>
                            </div>

                        <br><br>
                        <div class="font-menu font-i">
                                When dealing with multi-dimentional arrays, data can be easily fetched and accessed<br><br> 
                                
                                <span class="pxs-4">Assuming :</span> <br>
                                <code>$result1</code> obtained above translates <code>[0 => ['username'=>Felix]]</code>, then :
                                <code>$result2</code> translates that the zero <code>0</code> key should be fetched, hence :  <br>
                                <code>$result2</code> will translate as <code>['username'=>Felix]</code> <br> 
                                <code>$result3</code> will translate as <code>Felix</code> <br> 
                                
                                <br>
                                Note : In this manner, we are able to pull data easily from the data obtained. If such key does not exist, <code>$result2</code> or <code>$result3</code> will be set as an empty value.
                            </div> <br>

                            <!-- Data Trimming -->
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 5 : Data Trimming</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix'])->read(50);
  
  $six_results = $db->results(':6');
  
  $ten_results = $db->results(':10');
                        </pre>
                            </div>         
                            
                            <div class="font-menu font-i">
                                When dealing with multiple results, data obtained can be further trimmed
                                into a specifc number of items arrays. <br><br> 
                                
                                The first result obtained above i.e 
                                <code>$six_results</code> will only pull 6 results out of 50 results obtained or
                                less depending on the total number of results obtained. <br>

                                The second result obtained above i.e 
                                <code>$ten_results</code> will only pull 10 results out of 50 results obtained or
                                less depending on the total number of results obtained. <br>
                                
                                <br>
                                Note : In this manner, we are able to trim data easily from the data obtained. 
                            </div> <br>

                            <!-- Data Shuffling -->
                            <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 5 : Data Shuffling</div>
                        <pre class="pre-code">
  $db->query('select * from users where username = ?',['Felix'])->read(50);

  $results1 = $db->results(':shuffle');

  $results2 = $db->results(':10', ':shuffle');
                        </pre>
                            </div>         
                            
                            <div class="font-menu font-i">
                                Data obtained can be shuffled. This means that every time a data is obtained,
                                it is shuffled or reshuffled. In the example above, 50 results may be obtained and then
                                reshuffled which changes the position of data obtained at each reload. <br><br>
                                
                                In <code>$results2</code> above, 10 data was pulled out of 50 data and then reshuffled.
                                Notice the shift in position of <code>:shuffle</code> directive when two arguments are supplied.
                            </div> <br>

                        </li> 
        
                    </ul>
                </div>
            </div>
        </section>
    </div>

    @lay('build.co.coords:footer')

@template;