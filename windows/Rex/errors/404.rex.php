<!DOCTYPE html>
<html>
 	<head> 
 	  	@load('headers') <!-- load only 404 resources -->
		<title>404 Error Page</title>
		<link rel="shortcut icon" href="@mapp('images/icons/favicon.png')" type="image/x-icon">
		<style>
			body{
			 background-color: #431670;
			}
			img{
				transition: width .5s ease-in-out, height .5s ease-in-out;
			}
			.grid-center{
				display: grid;
				place-items:center;
			}
			@media (min-width: 1025px){
				img{
					width: 70%;
					height: 100%;
				}
			}
		</style>
    </head> 
    <body>
		<div class="box-full">
			<div class="grid-center vh-full">
				<div class="inner grid-center rad-2" style="min-width:320px; color: black;">
					<img src="@mapp('images/404.png')" height="100%" width="100%" alt="404 error">
				</div>
			</div>
	 	</div>  
	</body>
</html>