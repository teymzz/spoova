

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-20 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Database : Status</div> <br>

                    <div class="pxs-6">
                        Statuses are saved when queries are executed which can be accessed using the <code>DBStatus</code> class. 
                        The <code>DBStatus</code> class is the highest level of call as on the <code>DBHandler</code> class. It 
                        has the power to modify the messages returned by the <code>DBHandler</code> class. 
                        Methods which can be called include :
                        
                        <div class="font-em-d9">
                            <br> <code>DBStatus::query()</code>
                            <br> <code>DBStatus::err()</code>
                            <br> <code>DBStatus::baseErr()</code>
                        </div>

                    </div> <br>

                    <ul class="list-free pxl-12">
                        <li>
                            <div class="c-olive">Query</div>

                            <div class="font-em-d85">
                                The query method returns the last executed query 
                            </div>

                            <br>

                            <div class="box-full font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 1 </div>
                        <pre class="pre-code">
  $db = ($dbc = new DB())->openDB();
  
  if( $db ) {
  
      $db->query('select * from users')->read();
  
      <span class="comment">// outputs : select * from users</span>
      echo DBStatus::query() ;
  
  }
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d85">
                                In Example 1 above, when a connection is successful and a query is executed, 
                                then the last executed query is displayed.
                            </div> <br> 
                        </li>

                        <li>
                            <div class="c-olive">Err (Fetch last error)</div>
                            <div class="font-em-d85">
                                When an error occurs, the last error is saved and can be obtained using the <code>err()</code> method.
                            </div> <br>
                            <div class="box-full font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 2 </div>
                        <pre class="pre-code">
  $db = ($dbc = new DB)->openDB();
  
  if( $db ) {
  
      $db->query('select *name from users')->read();
  
      
      if(DBStatus::err()) {
  
          echo DBStatus::err(); <span class="comment">// displays error</span>
  
      }
  
  }
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d85">
                                In the Example 2 above, we checked if an error exists in 
                                storage and then displayed the error. Athough, this approach is discouraged,
                                it might be useful when working in window classes.
                            </div>
                            <br>

                        </li>

                        <li>
                            <div class="c-olive">Err (Modify error)</div>
                            <div class="font-em-d85 mvt-8">
                                The <code>err()</code> method can also modify an existing error. It takes a string as parameter.
                                The value supplied replaces the last stored error if an error exists. However, if a second parameter of <code>true</code> 
                                is defined, then the defined custom error will forcefully overwrite the default response message even if the response is empty.
                            </div> <br>
                            
                            <div class="font-em-d85">using Example 2 above,</div>  <br>
                            
                            <div class="box-full font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 3</div> <br>
                        <pre class="pre-code">
  if( DBStatus::err('some custom error') ) {
  
      print DBStatus::err(); <span class="comment">//some custom error</span>
  
  }
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d85">
                                In Example 3, if an error occurs from an sql executed query, the <code>DBStatus::err()</code> 
                                will replace the error with 'some custom error'. However if no error previously exists, then 
                                the custom error will not be set.
                            </div>
                            <br>
                            
                            <div class="box-full font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 4</div>
                        <pre class="pre-code">
  DBStatus::err('some custom error', true);
                        </pre>
                            </div> <br><br>

                            <div class="font-em-d85">
                                In Example 4, setting an argument of true on the <code>DBStatus</code> custom message will force the 
                                <code>DBStatus</code> to set a custom error even if no error exists previously
                            </div>
                            <br>


                        </li>

                        <li>
                            <div class="c-olive">baseErr (Default error)</div>
                            <div class="mvt-10 font-em-d85">
                                Since the <code>err()</code> method is capable of modifying the error message returned by the <code>DBStatus</code> 
                                class, if an existing error is modified, we can still retrieve the real or default error returned from an sql query by 
                                calling the <code>DBStatus::baseErr()</code> method which takes no argument. An example is shown below: <br>               
                                <br>
                            
                                <div class="box-full bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 5</div> <br>
                        <pre class="pre-code">
  if( DBStatus::err('some custom error') ) {
  
      print DBStatus::baseErr(); <span class="comment">//default error</span>
      print DBStatus::err(); <span class="comment">//some custom error</span>
  
  }
                        </pre>
                                </div> 
                                
                            </div>
                        </li>
                    
                    </ul>
                </div>
            </div>
        </section>

        @lay('build.co.coords:footer')

    </div>

@template;