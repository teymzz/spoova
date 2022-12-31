<!DOCTYPE html>
 <html>
 	<head> 
 	  	@Res(':headers') <!-- load only 404 resources -->
        @live()
		<title>404 Error Page</title>
		<link rel="shortcut icon" href="@mapp('images/icons/favicon.png')" type="image/x-icon">
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

            body {
                background-color: #525252;
                color: #c7c7c7;
            }
		</style>
    </head> 
    <body>
		<div class="box-full">
			<div class="grid-center vh-full">
				<div class="inner grid-center rad-2" style="min-width:320px;">
                    <div class="flex midv">
                        <span class="bd-2 v-line">404 REDIRECT</span>
                        <span> This url does not exist ...</span>
                    </div>
				</div>
			</div>
	 	</div>  
	</body>
</html>