

@template('template.t-tut')

    <!-- @lay('build.co.coords:header') -->

    @lay('build.co.navbars:left-nav')

    <div class="box-full pxl-2 bc-white-dd pull-right">
        <section class="pxv-10 tutorial database bc-white">
            <div class="font-em-1d2">

                @lay('build.co.links:tutor_pointer')

                <div class="start font-em-d8">

                    <div class="font-em-1d5 c-orange">Database : Process (CRUD)</div> 
                    
                    <ul class="list-free pxs-1 mvt-10">
                        <li>
                            <span class="c-olive"><i class="bi-circle-fill c-silver"></i> process</span> <br>
                            The process method directive is a final level query executor.
                            It can be used to run any sql query. However, it is mostly applied on Non-CRUD
                            operations. The term "Non-CRUD" here refers to operations that fall outside 
                            user custom defined sql tables. It takes no argument but only executes sql queries. It returns a bool value 
                            of true or false depending on if the query is successfully executed.

                            <br><br>

                            <div class="box-full  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 1 : execute sql query (crud) </div>
                        <pre class="pre-code">
  $db->query('delete * from users')->process();
                        </pre>
                            </div> <br><br>

                            <div class="box-full  font-em-d85 bc-white-dd shadow">
<div class="pxv-10 bc-silver">Example 2 : non-crud </div>
                        <pre class="pre-code">
  $db->query('CREATE DATABASE IF NOT EXISTS APP')->process();
                        </pre>
                            </div> <br><br>

                            <div class="d87">
                                It is not advisable to use <code>process()</code> to read or delete from database.
                                In fact, it should not be used to read at all.
                            </div>
                            <br>
                        </li>

                    </ul>
                </div>
            </div>
        </section>
    </div>
  
    @lay('build.co.coords:footer')

@template;