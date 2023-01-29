<?php
 
 require_once "secure.php";
 include_once 'assets.php' ; 
 Res::import(":headers");

 function pathContents($url=null,$type=''){
    if(strlen($url)> 0 && $url != null){ $url .='/'; }
  
    $url = str_replace('+', '/', $url);
    $url = str_replace(' ', '/', $url);  
  
    $dirs = array_filter(glob($url.'*'),'is_dir');
    $files = array_filter(glob($url.'*'),'is_file');
  
    if($type === []){
      return $dirs;
    }else{
  
      $fols = $fils = $fico = $pathor = '';
  
      foreach ($dirs as $key => $value) {
  
        $realrr = explode('/', $value);
        $reals = end($realrr);
        $fols .= '<div class="bsc-folder">
                   <a href= "?urlrq='.implode("+", $realrr).'"><span class="fa fa-fw fa-2x fa-folder anc-btn-link bi-folder" title="folder"></span></a> 
                   <span class="bsc-fol-name">'.$reals.'</span>
                  </div>
                  ';
      }
  
      foreach ($files as $fkey => $fvalue){
        $fext = pathinfo($fvalue,PATHINFO_EXTENSION);
  
        $mime = mime_content_type(dirname(dirname(__FILE__))."/".$fvalue);
        
        $erealrr = explode('/', $fvalue);
  
        $ereals = end($erealrr);
        $erealsBase = dirname($ereals).'+'.basename($ereals); 
        $erealsExt = pathinfo($ereals,PATHINFO_EXTENSION);
        $erealsImp = explode('.',implode('+', $erealrr))[0];
  
        if(strpos($mime, 'inode/x-empty') !== false){ $fico = 'fa fa-file ico-fine-star'; }      
        if(strpos($mime, 'image/') !== false){ $fico = 'fas fa-image bi-image'; }
        if(strpos($mime, 'video/') !== false){ $fico = 'fas fa-film bi-film'; }
        if(pathinfo($fvalue, PATHINFO_EXTENSION) == 'txt'){ $fico = 'far fa-file-text bi-file-text'; }
        if(strpos($mime, 'text/plain') !== false){ $fico = 'fas fa-file-text bi-file-text'; }
     
        if(pathinfo($fvalue, PATHINFO_EXTENSION) == 'php'){ $fico = 'far fa-file bi-file-text'; }
        if(strpos($mime, 'text/x-php') !== false){ $fico = 'fas fa-file bi-file-text'; }
  
        if(pathinfo($fvalue, PATHINFO_EXTENSION) == 'pdf'){ $fico = 'far fa-file-pdf pdf bi-file-text'; } 
        if(strpos($mime, 'application/pdf') !== false){ $fico = 'fas fa-file-pdf pdf bi-file-pdf'; }
  
        if($fico == ''){ $fico = 'fas fa-file-text bi-file-text'; }      
  
        $fils .= '<div class="bsc-files">
                   <a href="?view='.$erealsImp.':'.$erealsExt.'" class="inherit"><span class="'.$fico.' fa-fw fa-2x" title="file"></span></a> 
                   <span class="bsc-file-name">'.$ereals.'</span>
                  </div>
                  ';      
      }
  
      $mapSplit = explode('/', $url);
  
      $mapSplit = array_unset($mapSplit,'');
      $bpathor = ''; $bip = 0;
  
      foreach ($mapSplit as $map) {
        $bpathor .= ($bip == 0)? $map : '+'.$map;
        $pathor .= '
  
          <a href="?urlrq='.$bpathor.'" class="inherit"><span class="mybox pull-left mg mrgt2 padd-8 radius2 anc-btn-link" style="background-color:#cecece"> <span class="fa fa-angle-double-right"></span> '.$map.'</span> 
          </a>
        ';
        $bip++;
      }
  
      $mapper = '
        <div class="mybox-full padd-10">
          <div class="mybox-full rad-4 padd-4 bold" style="background-color: #dedede;">
            <a href="dev" class="inherit"><span class="mybox pull-left padd-8" style="">:Dev</span></a>
             '.$pathor.'
            <form class="mybox pull-right" style="width:200px" method="post">
              <fieldset class="anim-legend pull-left no-padding mg mrgt4" style="width:65%;">
                 <input name="bsc-url" onclick="highlight(this)" class="anim-child" placeholder="directory" style="border: solid 1px #d2d2d2;">
              </fieldset>
              <fieldset class="anim-button pull-left calibri rad-5" style="width:30%; background-color: #7ec851; color: white;">
                 <input name="bsc-run" type="submit" value="Find Url" class="anim-child c-white" placeholder="directory"></div>
              </fieldset>
            </form>
          </div>  
        </div>
      ';
      
      $voidText = (arrVoid($files) && arrVoid($dirs))? '<div class="padd-xsides-10">Directory Empty</div>' : '';
  
      if(!is_dir($url) && $url != ''){ $voidText = '<div class="mybox padd-6 font12 bold radius4 border-true message failed">Failed: Invalid Url Supplied {'.rtrim($url,'/').'} </div>'; }
  
      if($type == ':folder'){
        return $mapper.'<div class="mybox bsc-fols padd-10">'.$fols.'</div>';      
      }elseif($type == ':files'){
        return $mapper.'<div class="mybox bsc-fols padd-10">'.$fils.'</div>';
      }elseif($type == 'folder'){
        return $fols;
      }elseif($type == 'files'){
        return $fils;
      }else{
        return $mapper.'<div class="mybox bsc-fols padd-10">'.$fols.$fils.$voidText.'</div>';
      }
  
    }
 }

 function viewPathContents($content = ''){ 
	print '
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Dev</title>
		</head>
		<body>
			'.pathContents($content).'
		</body>
		</html>
 	';
 };
 
 if(fol == "" and !online){
	if(isset($_POST['bsc-run'])){
		viewPathContents($_POST['bsc-url']);
	}elseif(isset($_GET['urlrq'])){
		viewPathContents($_GET['urlrq']); 	
	}elseif(isset($_GET['view'])){
		include_once "viewer.php";
	}else{
		viewPathContents();
	}
 }else{
	//installation files...
	include_once "install.php";	 
 }
