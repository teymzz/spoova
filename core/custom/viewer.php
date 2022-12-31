<?php
 
 require_once "secure.php";

 $url = $_GET['view'];

 $urlexp = str_replace(' ', '/', $url);
 $urlexp = str_replace(':', '.', $urlexp);

 $file = is_file($urlexp)? $urlexp : die('Error: failed to read '.$urlexp);

 $filec = file_get_contents($file);

 $filec = ($filec)? $filec : 'Error: Failed to get contents';

 $fileExt = (pathinfo($file,PATHINFO_EXTENSION));
 
 $mime = mime_content_type($file);

 if(strpos($mime, 'video')== 'video'){
 	$content = '<div class="pre padd-10 rad-5"><video controls="controls" style="width:100%"> <source src="'.$file.'"> </video></div>';
 }elseif(strpos($mime, 'image') !==false){
 	$content = '<div class="px-full pre padd-10 rad-5"><img src="'.$file.'" style="width:100%; height:100%"></div>';
 }elseif($mime == 'application/pdf'){
 	$content = '<div class="px-full pre padd-10 rad-5"><iframe src="'.$file.'" style="width:100%; height:100%"></div>';
 }
 else{
 	$content = '<div class="px-full pre padd-10 rad-5" contenteditable="true" spellcheck="false" style="overflow:auto">'.htmlentities($filec).'</div>';
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dev:Viewer</title>
</head>
<body>
	<div class="box-full" style="padding:10px"> 
	<div class="box-full rad-5 bold" style="background-color:#efefef; padding:6px;">File: <?= $urlexp ?> </div> 
	<div class="font12 message mvt-4 rad-5" style="background-color: #636679; color: #eac865; padding:15px;">
		<?= $content; ?>
	</div>
	</div>	 
</body>
</html>


