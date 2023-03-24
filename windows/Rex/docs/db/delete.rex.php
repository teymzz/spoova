

@template('template.t-tut')

      <!-- @lay('build.co.coords:header') -->

      @lay('build.co.navbars:left-nav')

      <div class="box-full pxl-2 bc-white-dd pull-right">
            <section class="pxv-10 tutorial database bc-white">
                  <div class="font-em-1d2">

                        @lay('build.co.links:tutor_pointer')
                        <div class="start font-em-d8">
                              
                              <div class="font-em-1d5 c-orange">Database : Delete (CRUD)</div>
                              
                              <ul class="list-free px-1 mvt-10">
                                    <li>
                                    <span class="c-olive"><i class="bi-circle-fill c-silver"></i> do_delete</span><br>
                                    This query method directive is the top level sql setter method for
                                    deleting data from database fields. It defines sql select queries that can be 
                                    executed later.

                                    <br><br>

                                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                          <div class="pxv-10 bc-silver">Method 1 : set delete query </div>
                              <pre class="pre-code">
  $db->do_delete('from users');
                              </pre>
                                    </div> <br><br>

                                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                          <div class="pxv-10 bc-silver">Method 2 : chain controller </div>
                              <pre class="pre-code">
  $db->do_delete('from users')->where('username = ?', ['Felix']);
                              </pre>
                                    </div> <br><br>

                                    <div class="font-menu font-i">
                                          The method above is used to set simple sql queries. 
                                          Method <code>where()</code> should only be chained once on the <code>do_delete()</code> operator in the predefined order.
                                    </div>
                                    <br>

                                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                          <div class="pxv-10 bc-silver">Example 1 : Executing predefined query </div>
                              <pre class="pre-code">
  $db->do_delete('from users')->where('username = ?', ['Felix']);

  $db->delete();
                              </pre>
                                    </div> <br><br>

                                    <div class="font-menu font-i">
                                          Deleting from database comes in different formats and the <code>query()</code> method can
                                          be applied when handling complex delete queries.
                                    </div> <br>

                                    <div class="box-full font-menu  font-em-d85 bc-white-dd shadow">
                                          <div class="pxv-10 bc-silver">Example 2 : Deleting with query method</div> 
                              <pre class="pre-code">
  $db->query('delete * from users')->delete();
                              </pre>
                                    </div> 
                                    
                                    </li> 
                              </ul>
                        </div>
                  </div>
            </section>
            
            @lay('build.co.coords:footer')

      </div>

@template;