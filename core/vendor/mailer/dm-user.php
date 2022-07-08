<?php

  $webmail['header']   = '';
  $webmail['webmail']  = 'info@site.com';
  $webmail['username'] = 'akinola';
  $webmail['usermail'] = 'teymss@gmial.com';

  $html = '
      
      <!DOCTYPE html>
       <html>
         <head>
           <meta charset="utf-8">
           <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
           '.file_get_contents('css.php').'
         </head>


         <body style="margin: 0; background-color:#fbfbfb; color: #9e9e9e; overflow-x:hidden; font-family: calibri;">
          <div style="width:100%; height: 100%; padding: 0; background-color:#fbfbfb;">

           <div class="header padd-10 padd-xsides-20 mybox-full" style="font-size: 18px; color: #c6c6b7; background-color: #f2f2f2; ">
               
               <div class="mybox border-true padd-xsides-20 radius100" style="line-height:40px; vertical-align:middle; background-color: #b5aa52; color: white; border: solid 2px #b5aa52">
                    <div class="bold">M</div>
               </div>

               <div class="font-em-1 bold mybox border-transparent" style="line-height:40px; vertical-align:middle">
                 <div style="display:inline-block; ">ercySpeaks</div>
               </div>
           </div> 

           <div class="content" style="display:inline-block; padding:20px; position: relative;">
             <span style="color:#f36666; font-weight: bold">Hi there guy, {{$username}} </span> <br>

             <p>
               Congratulations you have successfully registered with us. Please ensure to keep your username and password safe   
             </p><br>

             <p> 
               To view and download our products visit mercyspeak @ <a href="https://www.mercyspeaks.com.ng" style="color:#3d8cc6; font-weight:bold;">https://www.mercyspeaks.com</a>      
             </p><br>     

             <div style="display:inline-block; width:100%">
                
                <div class="mybox" style="">
                   <div class="px-120 relative bg-cover" style="background-image:url('.DomUrl('res/images/list-pack/list1.jpg').')">
                     <div class="px-full overlay" style="background-color:rgba(0,0,0,0.5)"></div>
                   </div>
                </div>

                <div class="mybox" style="">
                   <div class="px-120 relative bg-cover" style="background-image:url('.DomUrl('res/images/list-pack/list1.jpg').')">
                     <div class="px-full overlay" style="background-color:rgba(0,0,0,0.5)"></div>
                   </div>
                </div>

                <div class="mybox" style="">
                   <div class="px-120 relative bg-cover" style="background-image:url('.DomUrl('res/images/list-pack/list1.jpg').')">
                     <div class="px-full overlay" style="background-color:rgba(0,0,0,0.5)"></div>
                   </div>
                </div>      
                 
                <div class="mybox" style="">
                   <div class="px-120 relative bg-cover" style="background-image:url('.DomUrl('res/images/list-pack/list1.jpg').')">
                     <div class="px-full overlay" style="background-color:rgba(0,0,0,0.5)"></div>
                   </div>
                </div>

             </div>
             <div style="display:inline-block; padding: 5px">
               <p>
               <span class="span-btns">To check out other products available</span>
                <a href="https://mercyspeaks.com/survey" style="color:#3d8cc6">
                  <span class="span-btns padd-4 font12 bold padd-10 radius4" style="position:relative; background-color: red; color: white;"> Click here </span>
                </a>
               </p>
             </div>
             <br><br>

             <div style="display:inline-block; padding: 5px">
               <p>Note: You can reach us using any of our social network handles on the contact us page.
                Thanks for registering with us. We hope to serve you better.
               </p>
             </div>

           </div>

           <div class="footer" style="display:inline-block; padding: 20px 0px;  text-align: center; position: relative; bottom: 0; width:100%; background-color: #4e4e4e; box-shadow: #000 0 0 20px inset; color: #9e9e9e; left: 0;">
             <div><a href="www.dufma.ng" style="font-size: 15px; color:#9e9e9e;">Visit Our site</a></div>
             <div style=""></div><br><br>
             <div style="">Social Handle</div>
             <div class="mycover-full">
               <a href="https://www.facebook.com/demishoincorporations/" style="font-size: 15px; margin:4px; color:#9e9e9e;">facebook</a>
               <a href="https://twitter.com/dermisho_ent" style="font-size: 15px; margin:4px; color:#9e9e9e;">twitter</a>
               <a href="www.dufma.ng" style="font-size: 15px; margin:4px; color:#9e9e9e;">instagram</a>
               <a href="https://www.linkedin.com/company/dermisho-enterprise/" style="font-size: 15px; margin:4px; color:#9e9e9e;">linkedIn</a>    
             </div> <br>
             <div>&copy; '.date("Y") .'</div>
           </div>

           </div>

           </body>
       </html>

  ';

  print $html;
?>