<?php

namespace core\tools;

class FileClass{
       private static $fileName;
       private static $fileDir;
       private static $extension;

       public static function setExtension($ext){
            self::$extension = $ext;
       }  

       public static function createFile($filename=null,$filedir=null){
             self::$fileName = $filename;
	           self::$fileDir = $filedir;

             if(self::$fileName != null){
	              self::makeAll();
             }
       }


       
       private static function makeAll(){
              self::makeFolder();
              self::makeFile();
       }
       private static function makeFolder(){
           $folder  = self::$fileDir;
           if(($folder != null)&&!is_dir($folder)){
              $mdir = mkdir($folder,0777,true);
           }
       }
       private static function makeFile(){
	            $FileName = self::$fileName;
              $FileDir = self::$fileDir;

              $extension = (self::$extension == null)? "txt" : self::$extension;
              
              $filetext  = $FileDir.$FileName.".".$extension;
              
              !is_file($filetext)? fopen($filetext,"w") : false;
       }    
   }
       
//USAGE
//File::setExtension($extension);
//FileClass::createFile(filename,directory); //create a new directory if it does not exist .

//FUNCTION
//Creates a file $extension into a (new) or existing folder;
?>
    
