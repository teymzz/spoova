<!DOCTYPE html>
 <html>
 	<head> 
 	  	@Res(':headers') <!-- load only 404 resources -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="@mapp('images/icons/favicon.png')" type="image/x-icon">
		<title>404 Error Page</title>
    </head> 
    <body class="e404 theme-black">
		<div class="box-full">
			<div class="grid-center vh-full">
				<div class="e-field grid-center rad-2">
                    <div class="flex midv">
                        <span class="bd-2 v-line">404 REDIRECT</span>
                        <span> This url does not exist ...</span>
                    </div>
				</div>
			</div>
	 	</div>  
	</body>
</html>