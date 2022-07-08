<?php


 print '

   <!DOCTYPE html>
   <html>
     <head>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
       '.file_get_contents(docRoot.'/plugins/mailer/css.php').'
        <style>
          .code-table{
             border-collapse: separate;
             border-spacing:5px;
          }        
          .code-table tr td{
             padding-top:2px;
             padding-bottom:2px;
          }
        </style>
     </head>


     <body style="margin: 0; background-color:#fbfbfb; color: #9e9e9e; overflow-x:hidden; font-family: calibri;">
      <div style="width:100%; height: 100%; padding: 0; background-color:#fbfbfb;">

       <div class="header padd-10 padd-xsides-20 mybox-full" style="font-size: 18px; color: #c6c6b7; background-color: #f2f2f2; ">
           
           <div class="mybox border-true padd-xsides-16 radius100" style="line-height:40px; vertical-align:middle; background-color: #b00c0c; color: white; border: solid 2px #a25151; background-image: linear-gradient(#c80a0a,darkred);">
                <div class="bold">E</div>
           </div>

           <div class="font-em-1 bold mybox border-transparent" style="line-height:40px; vertical-align:middle">
             <div style="display:inline-block; color: #9f9f9f;">rror!</div>
           </div>
       </div> 

       <div class="content" style="display:inline-block; padding:20px; position: relative;">
         <span style="color:#f36666; font-weight: bold">Hi there, user </span><br> <br> 
          If you are seeing this page, it means your mail is not properly configured!
         <p>
          <span class="bold"> Response Recorded </span>'.$error.'   
         </p><br>

         <p> 
           <div class="mybox-full padd-10 font14" style="background-color: #fff;">
           	 Follow this steps to configure your mail <br>
             <ol>
               <li>Ensure the mail-connect file is properly configured with valid parameters</li>
               <li>Ensure your default dbconfig file connects to the right database. The following helps to setup your connection
               	<ul class="list-square">
                    <li> default dbconfig file is located in <span class="font14 bold">'.DomUrl('main/icore/dbconfig.php').'</span></li>
                    <li> you can update this by creating a new dbconfig file in this directory with the same parameters as in above or use <code>$dbcon->openDB(DBNAME,DBUSER,DBPASS,DBSERVER,DBPORT,DBSOCKET)</code> to open a new connection. Check <span class="font14 bold">'.DomUrl('core/classes/API_STRUCTURE.php').'</span> for documentation </li>
                    <li> if new dbconfig file is created in current directory, include it immediately after 
                          <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">include_once \'filebase.php\'</code> 
                          which should be the first line of your code 
                    </li>
               	</ul>
                </li>
               <li>Ensure the client or user\'s email and username are set using 
                        <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'#key\'][#value] => \'\'</code> or
               			<code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'#key\',[\'#value\'=>\'\',\'#value\'=>\'\'])</code> where #key could be [client, site, cc, bcc, file] and #value could be mail or name. Every #key must have an #value of \'mail\' while \'name\' is only optional.
               </li>
               <li>You can configure your mail-setup file as default or update it from your file <br>
                    header <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'header\']</code> <br>
                    body <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'body\']</code> <br>
               </li>   
               <li>All configuration methods and values are listed below with array index \'mail\' optional. For full documentation <a href="'.DomUrl('plugins/mailer/mail-doc.php').'" class="bold" style="color: #27d5c4;">click here</a> <br> <br>
                     
                    <div class="mybox-full">
                      <span class="bold font14">Method 1 : Array Method </span>
                      <span class="bold font12 i">(works with mail-setup.php and php files)</span>
                    </div>

                    <div class="mybox-full flow-x">
                      <table class="code-table">
                         <tr>
                           <th>Keys</th>
                           <th>Array method / PHP embedded method</th>
                         </tr>                    
                         <tr>
                           <th>header</th>
                           <td><code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'header\'] = \'\' </code></td>
                         </tr>
                         <tr>
                           <th>site</th>
                           <td>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'site\'][\'mail\'] = \'\' </code> <br>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'site\'][\'name\'] = \'\' </code>
                           </td>
                            </code>
                           </td>
                         </tr>
                         <tr>
                           <th>client</th>
                           <td>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'client\'][\'mail\'] = \'\' </code> <br>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'client\'][\'name\'] = \'\' </code>
                           </td>
                         </tr>  
                         <tr>
                           <th>cc</th>
                           <td>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'cc\'][\'mail\'] = \'\' </code> <br>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'cc\'][\'name\'] = \'\' </code>
                           </td>
                         </tr>
                         <tr>
                           <th>bcc</th>
                           <td>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'bcc\'][\'mail\'] = \'\' </code> <br>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'bcc\'][\'name\'] = \'\' </code>
                           </td>
                         </tr>  
                         <tr>
                           <th>file (with no names)</th>
                           <td><code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'file\'] = [\'filepath1\',\'filepath2\', ...] </code></td>                       
                         </tr>   
                         <tr>
                           <th>file (with names)</th>
                           <td>
                            <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$webmail[\'file\'][] = [\'name\' => \'\', \'path\' => \'\'] </code>
                           </td>
                         </tr>                                         
                      </table> <br>
                      The method above can only be used inside two types of php files. The first is mail-setup.php which is the default setup file. The second is the php document that contains the mail body or content. The second method is referred to as (php embedded setup) and when used, overides the default only on values declared. Please note that there are two alternative ways of adding files as shown above and each method can support multiple file addition but when names are required to be used, then the last row\'s method must adopted accordingly.
                    </div><br> <br>
                      


                    <div class="mybox-full">
                      <span class="bold font14">Method 2 : Object Method </span>
                      <span class="bold font12 i">(works only with mailer class in php files)</span>
                    </div>

                    <div class="mybox-full flow-x">
                       <table class="code-table">
                          <tr>
                            <th>Keys</th>
                            <th>Object method</th>
                          </tr>                    
                          <tr>
                            <th>header</th>
                            <td><code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'header\',\'\')</code></td>
                          </tr>
                          <tr>
                            <th>site</th>
                            <td>
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'site\',[\'mail\' => \'\', \'name\' => \'\'])
                             </code>
                            </td>
                          </tr>
                          <tr>
                            <th>client</th>
                            <td>
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'client\',[\'mail\' => \'\', \'name\' => \'\'])
                             </code>
                            </td>
                          </tr>  
                          <tr>
                            <th>cc</th>
                            <td>
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'cc\',[\'mail\' => \'\', \'name\' => \'\'])
                             </code>
                            </td>
                          </tr>
                          <tr>
                            <th>bcc</th>
                            <td>
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'bcc\',[\'mail\' => \'\', \'name\' => \'\'])
                             </code>
                            </td>
                          </tr>  
                          <tr>
                            <th>file (with no names)</th>
                            <td><code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'file\',[\'filepath1\',\'filepath2\',...]) </code></td>                         
                          </tr>   
                          <tr>
                            <th>file (with names)</th>
                            <td>
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'file\',[0 => [\'name\' => \'\', \'path\' => \'\'], 1 => [\'name\' => \'\', \'path\' => \'\', ...]])
                             </code> <br> 
                             <code class="radius4 padd-2 font12" style="background-color: #e8e8e8; color: #777272;">$mailer->set(\'files\',[\'paths\' => [\'path1\', \'path2\',\'path3\'], \'names\' => [\'name1\', \'name2\']])
                             </code>                            
                            </td>
                          </tr>                                         
                       </table> <br>
                       In the last row (file), <b>paths</b> path1 and path2 have <b>names</b> name1 and name2 respectively, while path3 has no name
                    </div>



                    <div class="mybox-full">
                      <span class="bold font14">Method 3 : Inline Method </span>
                      <span class="bold font12 i">(works only with mailer class in php files)</span>
                    </div>

                    <div class="mybox-full flow-x">
                      The inline method is added through a string format. The format must be declared as written below: <br><br>

                      <table class="padd-10 mybox-full" style="background-color: #e8e8e8; color: #777272;">

                        <tr>
                          <td colspan="3">'.htmlentities('<setup type="config">').'</td>
                        </tr>

                        <tr>
                          <td>@header</td> <td>:</td> <td>{your_header_here}</td>
                        </tr>

                        <tr>
                          <td>@site_mail</td> <td>:</td> <td>{site_email}</td>
                        </tr>

                        <tr>
                          <td>@site_name</td> <td>:</td> <td>{site_name}</td>
                        </tr>

                        <tr>
                          <td>@client_mail</td> <td>:</td> <td>{client_mail}</td>
                        </tr>

                        <tr>
                          <td>@client_name</td> <td>:</td> <td>{client_name}</td>
                        </tr>

                        <tr>
                          <td>@file</td> <td>:</td> <td>{[file_path] [file_name]}</td>
                        </tr>

                        <tr>
                          <td colspan="3">'.htmlentities('</setup>').'</td>
                        </tr>
                      </table>
                       
                       In the method above each setup key is defined on a new line using an " @ " symbol. It is not required that all setup keys must be defined 
                       but when a key is defined, that key overides the one declared from either "php embedded" or "mailer object method" as it is located within the mail content but does not in anyway get included in mail content that would be sent as long as the following proceedures are kept in place. 
                         <ul class="list-square">
                           <li>All keys must be declared from a new line </li>
                           <li>All keys must be separated from their value using the colon (:) symbol </li>
                           <li>All values must stay within the curly brackets ({}) </li>
                           <li>The files when declared must have its values (i.e paths and names) stay within the curly brackets each with its own separate square brackets with path as the first declared value while name is optional (e.g {[path] [name]}) </li>
                           <li>Multiple files must be declared on a new line each with its own path and/or name, for example: <br>
                           @file : {[path] [name]} <br>
                           @file : {[path] [name]} <br>
                           @file : {[path]} <br>
                            </li>
                         </ul> <br>
                         
                    </div>



               </li>   

             </ol>
           </div>

                
         </p><br>     



       </div>

       <div class="footer" style="display:inline-block; padding: 20px 0px;  text-align: center; position: relative; bottom: 0; width:100%; background-color: #4e4e4e; box-shadow: #000 0 0 20px inset; color: #9e9e9e; left: 0;">
         <div><a href="www.dufma.ng" style="font-size: 15px; color:#9e9e9e;">Visit Our site</a></div>
         <div style=""></div><br><br>
         <div style="">Social Handle</div>
         <div class="mycover-full">
           <a href="https://www.facebook.com/.../" style="font-size: 15px; margin:4px; color:#9e9e9e;">facebook</a>
           <a href="https://twitter.com/..." style="font-size: 15px; margin:4px; color:#9e9e9e;">twitter</a>
           <a href="www.site.com" style="font-size: 15px; margin:4px; color:#9e9e9e;">instagram</a>
           <a href="https://www.linkedin.com/company/.../" style="font-size: 15px; margin:4px; color:#9e9e9e;">linkedIn</a>    
         </div> <br>
         <div>&copy; '.date("Y") .'</div>
       </div>

       </div>

       </body>
   </html>

 ';