<?php

namespace core\tools;

/**
 * @author Akinola Saheed <teymss@gmail.com>
 * @package spoova\core\tools
 * 
 */
class FileUploader{

  /**
   * response message
   *
   * @var mixed
   */
  private static $msg; 
  
  /**
   * Filename after upload
   *
   * @var string
   */
  public  $newfile;

  private $file;
  private $ImgWidth;
  private $ImgHeight;
  private $ImgType;
  private $ImgAttr;
  private $Messageresult;
  private $newdir; 
  private $FileType;

  /**
   * Allows assigning of custom unique 
   * names to uploaded file
   *
   * @var boolean
   */
  private $uniquefile = false;

  /**
   * default file size 150mb
   *
   * @var integer
   */
  public  $filesize = 15000000;
  
  /**
   * reset all variables om start
   */
  public function __construct(){
    $this->resetVars();
  }

  /**
   * Resets all variables on start
   *
   * @return void
   */
  public function resetVars(){
    $class  = get_class();
    $varvals = get_class_vars($class);
    $uniquefile = $this->uniquefile;
    foreach($varvals as $vals){
      if($vals != 'msg') {
        $this->$vals = false;
      }
    }
    $this->uniquefile = $uniquefile;
  }

  /**
   * Sets the uploaded image data
   *
   * @param array $files 
   * @param string $type - options [image | file]
   * @return void
   */
  public function start($files = [], $type = null){

    $param = $files;
    if(!empty($type)){
      if(strtolower($type) == "image"){
        $this->FileType = "Image";
        $result = $this->ValidateImage($param);
        if($result != false){
          $this->file = $result;
          return true;
        }else{
          $this->file = $result;
          return false;
        }
      }else{
        $this->file = $param;
        $this->FileType = $type;
      }
    }else{
      $this->file = $param;
      $this->FileType = "File "; 
    }
  }
  
  /**
   * set the file size (default is 150mb => 15000000)
   * 
   * @param int $size
   */
  public function filesize($size = ''){
    $this->filesize = (int) $size;
  }

  /**
   * Return the file file name of uploaded file 
   *
   * @return string
   */       
  public function GetFileName(){
    $file = $this->file;
    $filename = $file['name'];
    return $filename;
  }

  /**
   * Return the file mime-type of uploaded file 
   *
   * @return string
   */   
  public function GetFileType(){
    $file = $this->file;
    $fileType = $file['type'];
    return $fileType;
  }
  
  /**
   * Return file size of uploaded file 
   *
   * @return string
   */   
  public function GetFileSize(){
    $file = $this->file;
    $fileSize = $file['size'];
    return $fileSize;
  }

  /**
   * Return temporary storage directory of uploaded file 
   *
   * @return string
   */      
  public function GetFileTemp(){
     $file = $this->file;
     $filetmp = $file['tmp_name'];
     return $filetmp;
  }
  
  /**
   * Return error encountered during file upload
   *
   * @return string
   */
  public function GetFileError(){
    $file = $this->file;
    $filerr = $file['error'];
    return $filerr;
  }
  
  /**
   * Sets or Returns useful information of the current file
   *
   * @param boolean $param True returns file information, false sets file information
   * @return void
   */
  public function GetFileData($param = false){
    $size = $this->GetFileSize();
    $name = $this->GetFileName();
    $type = $this->GetFileType();
    $tmp = $this->GetFileTemp();
    $error = $this->GetFileError();
        
    $details ="FILENAME : ".$name."<br>";
    $details.="FILETYPE : ".$type."<br>";
    $details.="FILESIZE : ".$size."kb <br>";
    $details.="FILETEMP : ".$tmp."<br>";
    $details.="FILEERROR : ".$error."<br>";

    if($param == true){
      $details.= "NEW FILENAME : ".$this->newfile."<br>";
      $details.= "NEW FILE DIR : ".$this->newdir."<br>";
    }
    return $details;
  }
  
  /**
   * execute file upload operation
   *
   * @param array $validfiles valid  or accepted mime-type
   * @param string $location  file destination
   * @param boolean $boolean  true creates new directory if it does not exist
   * @return void
   */
  public function uploadFile($validfiles, $location, $boolean = true){

    $FileType = $this->FileType;
    if($FileType = ''){
        $FileType = "File";
    }
     
    if($boolean == true){
      //upload files;
      if(!is_array($validfiles)){ $valids[] = $validfiles; }
         $type = $this->GetFileType();
      if(in_array($type,$validfiles)||in_array("*",$validfiles)){
            $GetSize = $this->GetFileSize();
          if($GetSize > $this->filesize){
              self::setmessage("<pre> Maximum file upload should be less than 2mb </pre> <br>");
              return false;
          }else{
              return $this->UploadAll($location,$boolean);
          }  
      }else{
           self::setmessage("<pre> $FileType is not supported or invalid</pre> <br>");  
           return false; 
          }
      }  
  }

  
  public function reconstruct($param){

    $fileImages= $param;

    $newarray = array();

    $file_keys = array_keys($fileImages);

    $file_count = count($fileImages["name"]);

    for($i=0; $i<$file_count; $i++){
      
      foreach($file_keys as $key){
        $newarray[$i][$key] = $fileImages[$key][$i];
      }  

    }
    return $newarray;
 }

  /**
    * Thus gives a unique name to file uploaded
    * When used, file name will not be kept
    *
    * @param boolean $bool
    * @return void
    */
  public function uniqueFile($bool=true){
    
    if($bool === true){
      $this->uniquefile = true;
    }elseif($bool === false || $bool == null){
      $this->uniquefile = false;
    }else{
      $this->uniquefile = $bool;
    }

  }
  
  /**
   * returns the upload message
   *
   * @return void
   */
  public function response(){
    return self::$msg;
  }

  /**
    * Create a new folder
    *
    * @param string $path url of directory
    * @return void
    */
  public function createFolder($path){
    return mkdir($path,0777,true);
  }
  
  private function ValidateImage($param){
    $paramName = $param['tmp_name'];
    if(!empty($paramName)){
      if((list($width,$height,$type,$attr) = getimagesize($paramName)) !== false){
        $this->ImgWidth  = $width;
        $this->ImgHeight = $height;
        $this->ImgType   = $type;
        $this->ImgAttr   = $attr;
        return $param;
      }else{
        self::setmessage("<pre> This image is bad! </pre> <br>");
        return false;
      } 
    }else{
      self::setmessage("<pre>PLEASE SELECT AN IMAGE </pre> <br>");
    }
  }

  private function prepend(){       
    $append  ="";
    $filename = $this->GetFileName();
    $explode = pathinfo($this->GetFileName(),PATHINFO_EXTENSION);   

    if($this->uniquefile === true){
       $rand = rand(0,100);
       $micro = uniqid("file");
       $append .= $micro.$rand.".".$explode;
    }elseif($this->uniquefile === false){
       $append .= $filename;
    }else{
       $append .= $this->uniquefile.".".$explode;
    }
     
     $this->newfile = $append;
     return $append;
  }

  private function UploadAll($location,$boolean){
    $FileType = $this->FileType;

    if(!is_dir($location) and $boolean == true){
      //create a new directory if not exists
      if(!mkdir($location,0777,true)){
        self::setmessage("file directory cannot be created");
        return false;
      }
    }

    if(is_dir($location)){
      //process file upload

      $filename = $this->GetFileName();
      $Temp     = $this->GetFileTemp();
      $newfilename = $this->prepend();

      $this->newfile = $newfilename;         
      $location .= DS.$newfilename;
      $this->newdir = $location;
      $this->newloc = $location;

      $movefile = move_uploaded_file($Temp, $location);    
        
      if($movefile == true){
        //new Output;
         self::setmessage($FileType." uploaded Successfully");
         return true;
      }else{
         self::setmessage("Error Moving File");
        return false;
      }        
    }
    self::setmessage("No directory found!");
    return false;
  }

  /**
   * Sets a response message
   *
   * @param mixed $message
   * @return void
   */
  protected static function setmessage($message){
    self::$msg = $message;
  }

}


/**
 *
 * This Class is used to upload files ($_FILES)
 * @package FileUploader
 * 
 * $Upload = new  \core\tools\FileUploader(); //initialize class
 * $Upload->Start($_FILES);
 * $Upload->uniqueFile([true|false|#customName]); //makes a file unique, maintains original file name or a new custom name
 * $Upload->GetFileType(); //returns the type of file to be uploaded (optional method)
 *
 * $Upload->Uploadfile($valids,$location,$make_upload); 
 *       @param $valids      => accepted mimes_type(s) in array
 *       @param $location    => upload destination
 *       @param $make_upload => allow upload to destination folder (bool)
 *
 * 
 * @property
 * 
 * $Upload->GetFileName();  // @return old file name;
 * 
 * $Upload->GetFileType();  // @return uploaded file type;
 * 
 * $Upload->GetFileSize();  // @return uploaded file size;
 *    
 * $Upload->GetFileTemp();   // @return uploaded file tmp_name;
 * 
 * $Upload->GetFileError(); // @return upload error
 * 
 * $Upload->newfile;        // @return new file name after upload 
 *
 * $Upload->getResult();    // @return upload message 
 *
 * @example upload single file
 * if(isset($_FILES['images'])){
 *   $Upload = new \core\tools\ FileUploader; //initialize class
 *   $Upload->Start($_FILES['images'],"image")
 *            @param 'image' => image type
 *   $Upload->uniqueFile(true); //makes a file unique, maintains original file name or a new custom name
 *   $Upload->Uploadfile(['application/x-msdownload','image/gif'],'web/images',true); //uploads accepted files into 'web/images'
 *   echo $Upload->GetFileData();
 * }
 *  
 * @example upload multiple files
 *
 * if(isset($_FILES['images'])){
 *   $Upload = new \core\tools\ FileUploader(); //initialize class
 *   $build  = $Upload->reconstruct($_FILES['images']); //reconstruct image for upload
 *
 *   $filesData = '';
 *
 *   foreach($build as $file){
 *      $Upload->uniqueFile(true); //auto create a unique name
 *      $Upload->Start($file); // not a image types. if is image set @param 2 => 'image'
 *      $Upload->Uploadfile(['application/x-msdownload','image/gif'],'web/images',true); //execute upload
 *      $filesData .= $Upload->GetFileData();
 *   }
 *   
 *   print $filesData; //print all information of uploaded files
 * 
 * }
 *
 *
 *
 */
?>
