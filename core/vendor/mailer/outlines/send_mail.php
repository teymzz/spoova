<?php

require_once "index.php";

define("_ACCESS_",true);
require_once("../basics.php");


$mail->setFrom('info@dufma.ng', 'Dufma');
$mail->addAddress('princessdarlexy@gmail.com', 'Princess Darlexy');     // Add a recipient
$mail->isHTML(true); 


$header = 'Welcome to dufma'; 
$body   = '
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
</head>



<body style="margin: 0; background-color:#efefef; color: #9e9e9e; overflow-x:hidden; font-family: calibri;">
<div style="width:100%; height: 100%; padding: 0; background-color:#efefef;">

<div class="header" style="display:inline-block; width: 100%; font-size: 18px; border-bottom: solid thin #aaa; color: #c6c6b7; background-color: #6a745a; ">
    <div style="display:inline-block; float:left; margin-top:20px; padding:10px; border-radius: 100px;">
		<img class="mycover pull" src="www.dufma.ng/images/icons/favicon.png" style="float:left; width:40px; height: 40px;">
       <div style="display:inline-block; "></div>
    </div>

   	<div style="display:inline-block; float:left; padding:10px 2px; border-radius: 100px;">
      <div style="display:inline-block; "><h2>Dufma</h2></div>
    </div>
</div>	

<div class="content" style="display:inline-block; padding:20px; position: relative;">
	<span style="color:#f36666; font-weight: bold">Hi there,</span> <br>
	<p>
		You have successfully registered to dufma. Please ensure to keep your login details below secured from third party agents. 
		You can visit dufma site from <a href="https://www.dufma.ng" style="color:#3d8cc6; font-weight:bold;">https://www.dufma.ng</a> 
        
	</p><br>
	<p>Your Login details are:</p>
	<div class="mycover" style="display:inline-block; padding:10px">
		<p style="padding: 5px">Username: Akinola</p>
		<p style="padding: 5px">Password: Password</p>
	</div><br>

	<div class="mycover" style="display:inline-block; padding: 5px">
		<p>To download our android app.
		 <a href="https://play.google.com/store/apps/details?id=com.demisho.app&amp;hl=en" style="display:inline-block; color:#46b646; text-decoration:none; border:solid thin #aaa; background-color: #d4d2c4; padding:2px 4px;">
		   <img src="https://www.dufma.ng/images/icons/icon_android.png" style="position: relative; display:none; top:2px; width:20px; height:20px; border-radius:100px; position:relative">
		   <span style="position:relative; top: -3px; padding:2px; border-radius:4px;"> Click here </span>
		 </a>
		</p>
	</div>


	<div class="mycover" style="display:inline-block; padding: 5px">
		<p>Note: In the event that you forget your password, please use the forgot password link from
		 the dufma login or sign up dialog box. Thanks for registering with us
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
  <div>&copy; '.date("Y").'</div>
</div>

</div>

</body>
';

$mail->Subject = $header;
$mail->Body    = $body;
$mail->AltBody = strip_tags($body);

if($mail->send()){
    echo "Mail Sent";
}else{
    echo "Mail not Sent";
}
//print $body;
// Resource::import();
?>


