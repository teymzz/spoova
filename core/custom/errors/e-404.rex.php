<!DOCTYPE html>
 <html>
 	<head> 
 	  	@load('404') <!-- load only 404 resources -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="@mapp('images/icons/favicon.png')" type="image/x-icon">
		<title>404 Error Page</title>
		<style>
			body{
				font-family: monospace;
			}
		</style>
    </head> 
    <body class="e404 theme-black">
		<div class="box-full">
			<div class="grid-center vh-full">
				<div class="e-field grid-center rad-2">
                    <div class="flex midv">
                        <span class="bd-2 v-line">GET <span class="route">[/{{ limitChars(window('base'), 11) }}]</span> 404 REDIRECT</span>
                        <span> This route does not exist ...</span>
                    </div>
				</div>
			</div>
	 	</div>  
	</body>
</html>