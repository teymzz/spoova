

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

   <div class="box-full pxl-2 bc-white-dd pull-right">
       <section class="pxv-10 tutorial database bc-white">
           <div class="font-em-1d2">

                <div class="start font-em-d8"> 
                    
                    @lay('build.co.links:tutor_pointer') <br>

                    <div class="font-em-1d5 c-orange">Database : Update (CRUD)</div> <br> 
                    
                    <ul class="list-free pxs-1">
                        <li>
                            
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> do_update </span> <br>
                            <div class="mvs-10">
                                This query method is the top level sql setter method for
                                updating data in the database fields. It defines sql select queries that can be 
                                executed later. 
                            </div>

                            <div class=" font-em-d85 bc-white-dd flow-x shadow">
<div class="pxv-10 bc-silver">Method 1 : Update (set query) </div>
                    <pre class="pre-code">
  $db->do_update('users')

     ->set("gender=?")

     ->where('id=?');

     ->setData(['MALE', $userid]) 
                    </pre>
                            </div> <br>

                            <div class="box-full  font-em-d85 bc-white-dd flow-x shadow">
<div class="pxv-10 bc-silver">Method 2 : Update (set query) </div>
                    <pre class="pre-code">
  $db->query('update users set firstname = ?, lastname = ? where username = ?', ['Felix','Russel','Brown']);
                    </pre>
                            </div>

                            <div class="foot-note">
                                The method above is used to set simple sql queries. 
                                Method <code>where()</code> should only be chained once on the <code>do_update()</code> operator in the predefined order.
                            </div>

                        </li>
                        <li>                            
                            
                            <span class="c-olive"><span class="bi-circle-fill c-silver"></span> insert </span> <br>
                            <div class="mvs-12">
                                This method executes predefined update queries. 
                            </div>

                            <div class="box-full   font-em-d85 bc-white-dd flow-x shadow">
<div class="pxv-10 bc-silver">Example 4 : Data Insertion</div>
                    <pre class="pre-code">
  $db->query('update users set firstname = ? where username = ?',['Felix','Rolland'])->insert();
                    </pre>
                            </div>

                            <div class="foot-note">
                                In the example above, we executed the insertion query by calling the <code>insert()</code> method<br><br> 
                            </div> <br>        

                        </li> 
                        
                    </ul>                        
                </div>

            </div>
        </section>
    </div>

    @lay('build.co.coords:footer')

@template;