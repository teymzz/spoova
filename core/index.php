<?php
require_once 'custom/permit.php';
require_once 'basics.php';
?>

 <!DOCTYPE html>
 <html>
 	<head>
		<title>Secure Message</title>
		<link href="res/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all" type="text/css">
		<link href="res/css/design.css" rel="stylesheet" media="all" type="text/css">
		<link href="res/css/colors.css" rel="stylesheet" media="all" type="text/css">
		<link href="res/css/global.css" rel="stylesheet" media="all" type="text/css">
		<style>
			body{
			 background-color: #4e4e4e;
			}
			.grid-center{
				display: grid;
				place-items: center;
			}
			.mox-full{
				display: inline-block;
				width:100%;
			}
		</style>
    </head> 
    <body>
		<div class="mox-full">
			<div class="grid-center">
				<div class="bd-true" style="width:320px; background-color: #e7e7e7; color: black;">
					<div class="text-left" style="padding: 12px 8px; background-color: #ded5b4; background-color: #efefef;color: #da6d04;">
						<span class="bi-triangle"></span> Page Error!!!
					</div>
					<div class="mox-full font-em-d85" style="padding:10px 20px; color: #939393;"> 
						This is a secure location. Access is denied. Please refer to documentation or check your URL Address information.
					</div>
				</div>
			</div>
	 	</div>  
	</body>
</html>


