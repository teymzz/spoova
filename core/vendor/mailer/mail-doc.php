<?php 
include_once 'filebase.php';
?>
   <!DOCTYPE html>
   <html>
     <head>
       <title>mail document</title>
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
       <?= file_get_contents(docRoot.'/plugins/mailer/css.php'); Resource::import(":headers"); ?>
        <style>
          .code-table{
             border-collapse: separate;
             border-spacing:2px;
          }        
          .code-table.string-format tr td:not(:first-child){
            padding: 0 10px;
          }
          .code-table tr td.desc{
            color: #c6c5c5;
          }          
          .code-table.string-format tr th:not(:first-child){
            padding: 0 10px;
          }          
          code{
            border-radius:4; 
            padding: 2px;
            background-color: #e8e8e8; 
            color: #777272;
          }
        </style>
     </head>


     <body style="margin: 0; background-color:#fbfbfb; color: #9e9e9e; overflow-x:hidden; font-family: calibri;">
      
      <div style="width:100%; padding: 0; background-color:#fbfbfb;">

       <div class="header padd-10 padd-xsides-20 mybox-full" style="font-size: 18px; color: #c6c6b7; background-color: #f2f2f2; ">
           
           <div class="mybox border-true padd-xsides-12 radius100" style="line-height:40px; vertical-align:middle; background-color: #0c99b0; color: white; border: solid 2px #0e74b0; background-image: linear-gradient(#0a93c8,#003d8b);">
                <div class="bold">M</div>
           </div>

           <div class="font-em-1 bold mybox border-transparent" style="line-height:40px; vertical-align:middle">
             <div style="display:inline-block; color: #9f9f9f;">ail setup</div>
           </div>
       </div> 

       <div class="content" style="display:inline-block; padding:20px; position: relative;">
         <span style="color:#309fd5; font-weight: bold">Hi there, learn how to setup your mail</span><br> <br>
         <p>
          <span class="bold"> Topic : </span> How to setup your mail using the mailer class.   
         </p><br>

          <div class="mybox-full padd-10 font14 radius2" style="background-color: #4ea8ac; color: #f2f2d7;">
           	 Follow this steps to configure your mail <br>

            
             <ol>

               <li>
                setup <b>mail-server.php</b> file 
                <ul class="list-square">
                  <li> initialize phpMailer and CssInliner <span class="font12 i">(already done in line 14 and 15 of the file.)</span><br>
                    <code class="font12">$mail = new PHPMailer();</code><br>
                    <code class="font12">$cssInliner = new CssInliner();</code><br>
                    
                  </li><br>

                  <li> setup your mail client server <br>
                    <code class="font12 mybox">
                      $mail->Host       = '';<br>  
                      $mail->SMTPAuth   = true; <br>
                      $mail->Username   = ''; <br>
                      $mail->Password   = ''; <br>
                      $mail->SMTPSecure = ''; <br>
                      $mail->Port       = '';
                    </code>
                  </li>                  
                 </ul>  
               </li> <br>

               <li>
                If you have default mail addresses, then update the default parameters in mail-setup.php
               </li> <br>               

               <li>
                From your document e.g ( <b>mymail.php</b> )
                <ul class="list-square">
                  <li>include your filebase file and mail-config files <br>
                    <code class="font12"> include_once 'filebase.php'; </code> <br>
                    <code class="font12"> include_once 'mail-config.php'; </code>
                  </li><br>
                  <li>initialize the mailer with the cssInliner <br> 
                      <code class="font12"> $mailer = new mailer($cssInliner); </code>
                  </li> <br>
                  <li>load the configured <code class="font12" style="background-color: transparent; color: #e9fbdf;">$mail</code> into the mailer using init object method <br>
                        <code class="font12"> $mailer->init($mail); </code>
                  </li>
                </ul>
                
               </li> <br>

               <li>
                Update mail-setup.php configurations either:
                <ul class="list-square">
                  <li>by setting the configuration in the mail document. <a href="#setup-file" class="bold" style="color: #aaf2eb;">learn more</a></li>
                  <li>or by using <code class="font12 radius2">$mailer->set(key,value)</code> <a href="#setup-object" class="bold" style="color: #aaf2eb;">learn more</a></li>
                </ul class="list-square">
               </li> <br>

               <li>
                Load your html file or string which is the mail content
                <ul class="list-square">
                  <li><code class="font12 radius2">$mailer->load('myfile.php')</code> or </li>
                  <li><code class="font12 radius2">$mailer->load('<?= htmlentities("<html> some html here </html>") ?>')</code></li>
                </ul class="list-square">
               </li> <br> 

               <li>
                Process your mail using <code class="font12 radius2">$mailer->render();</code>
               </li> <br>

               <li>
                Get your mail response 
                <ul class="list-square">
                  <li> in array <code class="font12 radius2">$mailer->response()</code> or </li>
                  <li> in json <code class="font12 radius2">$mailer->response('json')</code></li>
                </ul class="list-square">
               </li> <br>

               <li>
                view your mail as html by printing out the forwarded mail using <code class="font12 radius2">$mailer->content()</code>
               </li> <br>
               
              </ol>


              <div class="mybox-full padd-xsides-20">
                An example structure is written below assuming that your mail-server.php and/or mail-setup file has been configured and 
                we are working with two documents. Our code file (as code.php) and our mail body as (htmldoc.php)<br><br>
                
                <span class="bold font14 padd-ysides-10 radius4"><span class="fa fa-file"></span> filename: code.php</span><br>
                <code class="font12 radius2 mybox"> 
                  include_once 'filebase.php'; <br>
                  include_once 'mail-config.php';<br><br>

                  $mailer->load('myfile.php');<br>
                  $mailer = new mailer($cssInliner);<br>
                  $mailer->init($mail);<br><br>

                  $mailer->load('htmldoc.php')<br>
                  $mailer->render();<br>
                  print $mailer->response('json')
                </code> 
              </div>

            </div><br><br>



            <!-- Methods Explanation -->
            <div class="mybox-full padd-xsides-10 radius2" style="background-color: #16728e;">
              <div class="mybox-full padd-4 padd-ysides-10">
                <span class="bold font14" style="color: white;">Setting / Updating mail-setup configuration</span><br> <br>
                <div class="mybox-full font14 padd-4" style="color: white;">
                  There are three ways to update the mail-setup configuration <br>
                  <ul>
                    <li>Setup File (Default)</li>
                    <li>Object Setup</li>
                    <li>Php File Embedded Setup</li>
                    <li>Inline Embedded Setup</li>
                  </ul>
                  <p class="i font12 padd-xsides-10">It is worth knowing that items that can be configured are 
                    <b>header</b>, <b>from</b>, <b>to</b> and <b>attachment</b>. These items are represented with keys
                  i.e <b>header</b>, <b>site</b>, <b>client</b> and <b>file</b> respectively.</p>
                </div>

                <div class="mybox-full font14 padd-4">
                  <ul class="padd-xsides-10 list-free">
                    <li id="setup-file" style="background-color: #fbfbfb;" class="padd-10">
                      <span class="bold">Default Mail Setup File</span> <br>

                      This is the default headers configuration and it can be done in the mail-setup.php file. It is not neccessary to 
                      supply all parameters from this file. It is only advisable to set up constant parameters if there is any but if the
                      parameters are not yet known or aren't constant, then they can be updated later. the parameters below can be configured.<br><br>
                      
                      <table class="code-table">
                        <tr><th>Name</th><th>keys</th><th class="padd-xsides-10">value format</th><th>description</th></tr>
                        <tr>
                          <th> header </th>
                          <td>$webmail['header'] = </td> 
                          <td class="padd-xsides-10" style="min-width:50px"> ' some_header ' </td> 
                          <td class="desc">// mail title or header</td>
                        </tr> 
                        <tr>
                          <th> body </th>
                          <td> $webmail['body'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">' some_file_or_string ' </td>
                          <td class="desc">// mail content string or content file (html, xml, php)</td>
                        </tr>
                        <tr>
                          <th> site_mail </th>
                          <td> $webmail['site']['mail'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">' mysite@something.com ' </td>
                          <td class="desc">// from website email</td>
                        </tr> 
                        <tr>
                          <th> site_name </th>
                          <td> $webmail['site']['name'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">' mysite ' </td>
                          <td class="desc">// from website name</td>
                        </tr>
                        <tr>
                          <th> client_mail </th>
                          <td>$webmail['client']['mail'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">' user@something.com ' </td>
                          <td class="desc">// to client or user's email</td>
                        </tr> 
                        <tr>
                          <th> client_name </th>
                          <td> $webmail['client']['name'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">' user_name ' </td>
                          <td class="desc">// to client or user's name</td>
                        </tr> 
                        <tr>
                          <th> file </th>
                          <td>$webmail['file'] = </td>
                          <td class="padd-xsides-10" style="min-width:50px">[path, path, ...] </td>
                          <td class="desc">// files attachment with no names </td>
                        </tr>
                        <tr><td class="padd-6" colspan="3"></td></tr>
                        <tr style="margin-top: 20px;">
                          <th> files </th>
                          <td>
                            $webmail['files'][] = <br> 
                            $webmail['files'][] = <br>
                            $webmail['files'][] = <br>                            
                          </td>
                          <td class="padd-xsides-10" style="min-width:50px"> 
                            [path => '', name => ''] <br> 
                            [path => '', name => ''] <br>
                            [path => ''] <br>
                           </td>
                          <td class="desc">
                            // attach file with path and name <br>
                            // attach another file with path and name <br>
                            // attach another file with but no name <br>
                          </td>
                        </tr>                                                                                                                    
                      </table>
                      <br>

                      <b>Code Sample Structure</b> <br>
                      <code class="font12 mybox padd-10 radius5">
                        <table>
                          <tr> <td>$webmail['header']</td> <td>=</td> <td>'some header'</td> </tr>
                          <tr> <td>$webmail['body']</td> <td>=</td> <td>''</td> </tr>
                          <tr> <td>$webmail['site']['mail']</td> <td>=</td> <td>'mysite@something.com'</td> </tr>
                          <tr> <td>$webmail['site']['name']</td> <td>=</td> <td>'mysite'</td> </tr>                          
                          <tr> <td>$webmail['client']['mail']</td> <td>=</td> <td>'user@something.com'</td> </tr>
                          <tr> <td>$webmail['client']['name']</td> <td>=</td> <td>'user name'</td> </tr>
                          <tr> <td>$webmail['file']</td> <td>=</td> <td>['resource/file.jpg', 'resource/file2.jpg']</td> </tr>
                          <tr> <td>$webmail['files'][]</td> <td>=</td> <td>['path'=>'myfolder/resorce/file.jpg', name'=>'file.jpg']</td> </tr> 
                        </table>
                      </code>

                    </li><br>

                    <li id="setup-object" style="background-color: #fbfbfb;" class="padd-10">
                      <span class="bold">Setup Object</span> <br>

                      This is done by using the <code>$mail->set()</code> object method to configure or update the mail setup file. By using this method, parameters configured from the mail default setup file will be updated. The parameters below can be configured.<br><br>
                      
                      <table class="code-table">
                        <tr><th>Name</th><th>Format</th><th>Description</th></tr>
                        <tr>
                          <th> header </th>
                          <td> $mailer->set('header',' some_header '); </td> 
                          <td class="desc">// mail title or header</td>
                        </tr> 
                        <tr>
                          <th> site </th>
                          <td> $mailer->set('site',[mail => '', name => '']); </td>
                          <td class="desc">// from website email, website name. Where name is optional</td>
                        </tr> 
                        <tr>
                          <th> file </th>
                          <td> $mailer->set('client',[path, path, ...]); </td>
                          <td class="desc">// files attachment with no names</td>
                        </tr>
                        <tr>
                          <th> files </th>
                          <td> $mailer->set('files',[0=>['path' => '', 'name' => ''], 1=>['path'='', 'name' => '']]); </td>
                          <td class="desc">// files attachment with names where name is optional</td>
                        </tr>
                        <tr><td class="padd-6" colspan="3"></td></tr>                                              
                      </table>

                      <b>Code Sample Structure</b> <br>
                      <code class="font12 mybox padd-10 radius5">
                        <table>
                          <tr> <td>$mailer->set('header', 'some header'); </td> </tr>
                          <tr> <td>$mailer->set('site', ['mail'=>'mysite@something.com', name'=>'mysite']); </td> </tr>
                          <tr> <td>$mailer->set('client', ['mail'=>'user@something.com', name'=>'user name']); </td> </tr>
                          <tr> <td>$mailer->set('file', ['resource/file.jpg', 'resource/file2.jpg']); </td> <td>// without names</td> </tr>
                          <tr> <td>$mailer->set('files', [0=>['path'=>'myfolder/resorce/file.jpg', name'=>'file.jpg']]); </td> <td>// with names</td> </tr>
                        </table>
                      </code><br>

                       The <code class="radius4 font12 bold">$mailer->load('')</code> is only permitted to load or update the mail content body instead of <code class="radius4 font12 bold">$mailer->set('body','')</code>. The value can either be a valid (php, html, xml, txt) file  or string which may be used along with an embedded css with not more than one style tag.
                      <br><br>

                    </li>   

                    <li style="background-color: #fbfbfb;" class="padd-10">
                      <span class="bold">PHP File Embedded Setup</span> <br>

                      This is done by including the parameters under the <b>Default Mail Setup File</b> above directly into a php file containing the mail's content. The file once loaded by <code class="radius4 font12 bold">$mailer->load()</code>  object will process the setup configurations without affecting the mail's content. Parameters declared must be within the php tags.<br><br>
                    </li> 

                    <li style="background-color: #fbfbfb;" class="padd-10">
                      <span class="bold">Inline Embedded Setup (or Intext)</span> <br>

                      This is done by including the setup parameters into the html text or string using the format below. The <code class="radius4 font12 bold">$mailer->render()</code> will process the setup configurations without affecting the mail's content. It is worth noting that this method is likely unstable, hence the format below should be adhered stricly to. <br><br>
                      


                      <table class="code-table string-format">
                        <tr><th>Name</th><th>format</th><th>separator</th><th>value format</th><th>description</th></tr>
                        <tr>
                          <th> header </th>
                          <td> @header </td> 
                          <td> : </td>
                          <td> {} </td>
                          <td class="desc">// mail title or header</td>
                        </tr> 
                        <tr>
                          <th> site_mail </th>
                          <td> @site_mail </td> 
                          <td> : </td>
                          <td> {} </td>
                          <td class="desc">// from website email.</td>
                        </tr>
                        <tr>
                          <th> site_name </th>
                          <td> @site_name </td> 
                          <td> : </td>
                          <td> {} </td>
                          <td class="desc">// from website name. Optional</td>
                        </tr>
                        <tr>
                          <th> client_mail </th>
                          <td> @client_mail </td> 
                          <td> : </td>
                          <td> {} </td>
                          <td class="desc">// from client email.</td>
                        </tr>
                        <tr>
                          <th> client_name </th>
                          <td> @client_name </td> 
                          <td> : </td>
                          <td> {} </td>
                          <td class="desc">// from website name. Optional</td>
                        </tr>

                        <tr>
                          <th> file </th>
                          <td> @file </td> 
                          <td> : </td>
                          <td> {[path] [name]} </td>
                          <td class="desc">//add a file attachment. name is optional</td>
                        </tr>
                        <tr><td class="padd-6" colspan="3"></td></tr>                                              
                      </table>

                      <b>Code Structure Sample</b> <br>
                      <code class="font12 mybox padd-10 radius5">
                        <table>
                          <tr> <td><?= htmlentities('<setup type="config">'); ?></td> </tr>
                          <tr> <td>@site_name</td> <td>:</td> <td>{mysite}</td> </tr>
                          <tr> <td>@site_mail</td> <td>:</td> <td>{mysite@osomething.com}</td> </tr>
                          <tr> <td>@client_name</td> <td>:</td> <td>{user name}</td> </tr>
                          <tr> <td>@client_mail</td> <td>:</td> <td>{user@something.com}</td> </tr>
                          <tr> <td>@file</td> <td>:</td> <td>{[user/var/res/myfile.jpg] [myfile.php]}</td> </tr>
                          <tr> <td>@file</td> <td>:</td> <td>{[myfile/var/filename.php]}</td> </tr>
                          <tr> <td><?= htmlentities('</setup>'); ?></td> </tr>
                        </table><br>

                        <div class="mybox-full padd-2">
                          &lt;!DOCTYPE html &gt;<br>
                          &lt;html&gt; <br>
                          &nbsp; &lt;head&gt; <br>
                          &nbsp;&nbsp; &lt;title&gt; My Mail Body &lt;/title&gt; <br>
                          &nbsp; &lt;/head&gt; <br>
                          &nbsp; &lt;body&gt; <br><br>
                          &nbsp;&nbsp;&nbsp; ...my body here<br><br>
                          &nbsp; &lt;/body&gt; <br>
                          &lt;/html&gt; <br>
                        </div>

                      </code><br>

                      In the code structure above, the second @file means add another file attachment and it only has a file path and no name unlike the one above it that has both declared. any parameter may absent but once included, it must follow the pattern above. Whatever key defined in the above will overide the default set either in the Mail Default or Object methods menthioned earlier because this configuration is loaded directly from mail's content body.
                      <br><br>
                    </li>

                                                       
                  </ul>
                </div> <br>
                               
              </div>

            </div><br><br>

            
            <!-- Manipulating Dom Values -->
            <div class="mybox-full padd-10 font14 radius2" style="background-color: #95265f; color: white;">
               
               <div class="mybox-full bold"> Manipulating documents and string formats using curly brackets " {{ }} " </div>  <br> <br>
               
               Document values can be manipulted using curly brackets. The curly brackets has two forms by which it can manipulate loaded strings or files when using <code class="font12 bold">$mailer->load()</code> object method. These three structures are listed below <br> <br>
               <ul class="list-disc">
                 <li> variable form {{$myvalue}} </li>
                 <li> string form {{myvalue}} </li>
                 <li> request method form {{post:myvalue}}, {{get:myvalue}} and  {{req:myvalue}} </li>                                   
                </ul> 
             
              <ol>

                <li>
                  Variable Form <br>

                  This method tells the mailer to process <code class="font12 bold">{{$myvalue}}</code> and replace it with the value of $myvalue if $myvalue has been declared before $mailer->render() is called. For example if $myvalue is 'ade', then after the document or string is processed <code class="font12 bold">{{$myvalue}}</code> will become <code class="font12 bold">ade</code>. This makes string or document formating easier. Also, mail template can easily be created an updated dynamically based on content. <br><br>

                  <b>Code Sample Structure</b> <br>
                  <code class="font12 mybox padd-6 radius4">
                    $username = 'Felix'; <br> <br>

                    $mailer->load("Hi there {{$usename}}"); <br>
                    $mailer->render(); <br>
                    $mailer->content(); // returns Hi there Felix
                  </code><br><br>   
                  Remember that <code class="font12 bold">$mailer->load();</code> can take a valid file or string. If a file is supplied instead of a string, the document is processed similarly as above.               
                </li><br>



                <li>
                 String Form <br>

                 This method tells the mailer to process <code class="font12 bold">{{myvalue}}</code> and replace it with the value of <code class="font12">$_POST['myvalue']</code> or <code class="font12">$_GET['myvalue']</code> or <code class="font12">$_REQUEST['myvalue']</code>. This is because of the absence of the dollar sign which differentiates between a variable and a server's request method. This is arranged in hierachy just as listed earlier with $_POST taking the highest power since the request method type is not declared. This means that if we have $_POST['myvalue'] and $_GET['myvalue'] both declared, then $_POST['myvalue'] will be chosen while $_GET['myvalue'] will be ignored. <br><br>

                 <b>Code Sample Structure 1</b> <br>
                 <code class="font12 mybox padd-6 radius4">
                   $_POST['user'] = 'Cynthia'; <br> <br>

                   $mailer->load("Hi there {{user}}"); <br>
                   $mailer->render(); <br>
                   $mailer->content(); // returns Hi there Cynthia <br> <br>
                   
                   $_GET['user'] = 'Bob'; <br> <br>

                   $mailer->load("Hi there {{user}}"); <br>
                   $mailer->render(); <br>
                   $mailer->content(); // returns Hi there Cynthia

                 </code><br><br>  

                 <b>Code Sample Structure 2</b> <br>
                 <code class="font12 mybox padd-6 radius4">
                   $_GET['user'] = 'Bob'; <br> <br>

                   $mailer->load("Hi there {{user}}"); <br>
                   $mailer->render(); <br>
                   $mailer->content(); // returns Hi there Bob <br> <br>
                   
                   $_POST['user'] = 'Cynthia'; <br> <br>

                   $mailer->load("Hi there {{user}}"); <br>
                   $mailer->render(); <br>
                   $mailer->content(); // returns Hi there Cynthia
                 </code><br><br>

                 <b>Code Sample Structure 3</b> <br>
                 <code class="font12 mybox padd-6 radius4">
                   $mailer->load("Hi there {{user}}"); <br><br>

                   $_POST['user'] = 'Cynthia'; <br> <br>

                   $mailer->render(); <br>
                   $mailer->content(); // returns Hi there Cynthia
                 </code><br><br>

                 As long as the value is declared before the <code class="font12 bold">$mailer->render();</code> is called, the file will get updated just like the example above.
                </li> <br>  



                <li> Request Method Form <code class="font12 bold">{{post:myvalue}}</code> , <code class="font12 bold">{{get:myvalue}}</code> , <code class="font12 bold">{{req:myvalue}}</code> <br>

                 This method tells the mailer to process the brackets using the declared method, where post is $_POST, get is $_GET and req is $_REQUEST. The mailer processes these and replaces them with their appropriate values. This reduces the risk of having the mailer choose by hierachy. <br><br>

                 <b>Code Sample Structure</b> <br>
                 <code class="font12 mybox padd-2 radius4">
                  $_POST['user'] = 'Cynthia'; <br>
                  $_GET['user'] = 'Bob'; <br> <br>

                  $mailer->load("Hi there {{post:user}}"); <br>
                  $mailer->render(); <br>
                  $mailer->content(); // returns Hi there Cynthia <br> <br>

                  $mailer->load("Hi there {{get:user}}"); <br>
                  $mailer->render(); <br>
                  $mailer->content(); // returns Hi there Bob
                 </code><br><br> 
                </li> <br>

               </ol>
             </div><br><br>
              
            </div>
            
          </div> <br>

       <div class="footer mybox-full text-center relative padd-ysides-20" style="background-color: #4e4e4e; box-shadow: #000 0 0 20px inset; color: #9e9e9e;">
         <div><a href="www.dufma.ng" style="font-size: 15px; color:#9e9e9e;">Visit Our site</a></div>
         <div style=""></div><br><br>
         <div style="">Social Handle</div>
         <div class="mycover-full">
           <a href="https://www.facebook.com/.../" style="font-size: 15px; margin:4px; color:#9e9e9e;">facebook</a>
           <a href="https://twitter.com/..." style="font-size: 15px; margin:4px; color:#9e9e9e;">twitter</a>
           <a href="www.site.com" style="font-size: 15px; margin:4px; color:#9e9e9e;">instagram</a>
           <a href="https://www.linkedin.com/company/.../" style="font-size: 15px; margin:4px; color:#9e9e9e;">linkedIn</a>    
         </div> <br>
         <div>&copy; <?= date("Y") ?></div>
       </div>

       </body>
   </html>