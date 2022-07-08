 <!DOCTYPE html>
 <html>
 	<head> 
 	  @Res(':404')
		<title>404 Error Page</title>
		<style>
			body{
			 background-color: #4e4e4e;
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
					width: 50%;
					height: 100%;
				}
			}
		</style>
    </head> 
    <body style="background-color: #afafaf;">
		<div class="mox-full">
			<div class="grid-center vh-full">
				<div class="inner grid-center rad-2" style="min-width:320px; color: black;">
					<img src="<?= DomUrl('res/main/images/404.png') ?>" height="100%" width="100%" alt="404 error">
				</div>
			</div>
	 	</div>  
	</body>
</html>