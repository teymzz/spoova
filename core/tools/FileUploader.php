<?php 

namespace teymzz\spoova\core\tools;

/**
 * This class was created for handling file uploads.
 * 
 * @author Akinola Saheed <teymss@gmail.com>
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
  
  /**
   * File destination directory
   *
   * @var string
   */
  private $newdir; 

  /**
   * Temporary file name
   *
   * @var string
   */
  private $file;

  public $newloc;

  /**
   * Stored Image properties
   */
  private $ImgWidth;
  private $ImgHeight;
  private $ImgType;
  private $ImgAttr;

  private $FileType;

  /**
   * Allows assigning of custom unique 
   * names to uploaded file
   *
   * @var boolean
   */
  private $uniquefile = false;

  private $bytesPower = 1024;

  /**
   * default file size => 2mb.
   *
   * @var integer in bytes
   */
  public  $filesize = 1500000; // (1.5 megabytes)
  
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
   * @return void|bool
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
   * @return string
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
   * @return bool
   */
  public function uploadFile($validfiles, $location, $boolean = true) : bool {

    $FileType = $this->FileType;
    
    $FileType = $FileType?: 'File';
    $FileType = trim($FileType, ' ');
     
    if($boolean == true){

        if(!is_array($validfiles)){ $valids[] = $validfiles; }
        
        $type = $this->GetFileType();

        $ini_max_filesize = $this->iniUploadMax();

        $max_uploadable = (implode('',$this->unitConverter($ini_max_filesize))); 
        
        $FileSize = $this->GetFileSize();

        if(in_array($type, $validfiles)||in_array("*",$validfiles)){
            
            $maxFileSize = $this->unitConverter($this->filesize);

            if($FileSize > $this->filesize){
                self::setmessage("<pre> Maximum file upload should not be more than ". $maxFileSize[0]. $maxFileSize[1] ." </pre> <br>");
                return false;
            }else{
                return $this->UploadAll($location,$boolean);
            }  
        
      }else{

           if($FileSize > $ini_max_filesize) {
            self::setmessage("<pre color='red'>Ini Error: File exceeds maximum uploadable size (max: $max_uploadable) </pre><br>");
            return false;
           }
           
           $fileName = $this->GetFileName();

           if($FileSize == 0){
            $msg = $this->GetFileError()? "(max: $max_uploadable)" : "$FileType is not supported or invalid";
            self::setmessage("<pre>$FileType Invalid: $msg</pre> <br>");
            return false;
           }
           self::setmessage("<pre> $FileType is not supported or invalid</pre> <br>");  
           return false; 
          }
      }  
  }

  /**
   * Sets the power used for bytes conversion. 
   *
   * @param integer $power (optional) 1000 or 1024, default is 1024
   * 
   * @return integer
   */
  public function bytesPower(int $power = 1024){

    $powers = [1000, 1024];
    $power = in_array($power, $powers)? $power : 1024;

    if(func_num_args() > 0)$this->bytesPower = $power; 
    return $this->bytesPower;

  }

  /**
   * Rebuild multiple files for serial upload
   *
   * @param array $param file(s) array list
   * @return array
   */
  public function reconstruct(array $param){

    $fileImages = $param;

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
   * @param boolean|string $unique
   * @return void
   * @Notice: Empty string(s) counts as false while non empty string sets the output name
   */
  public function uniqueFile($unique = true){
    
    if($unique === true){
      $this->uniquefile = true;
    }elseif($unique === false || trim($unique) == ''){
      $this->uniquefile = false;
    }else{
      $this->uniquefile = $unique;
    }

  }
  
  /**
   * returns the upload message
   *
   * @return string
   */
  public function response(){
    return self::$msg;
  }

  /**
    * Create a new folder
    *
    * @param string $path url of directory
    * @return bool
    */
  public function createFolder($path){
    return mkdir($path,0777,true);
  }

  
  public function unitConverter(int $bytes, int $precision = 2) : array {
    $units = array('B','KB','MB','GB','TB');
    $bytes = max($bytes, 0);
    $pow   = floor(($bytes? log($bytes): 0)/ log($this->bytesPower()));
    $pow   = min($pow, count($units) - 1);
    $bytes /= pow($this->bytesPower(), $pow);
    $size = round($bytes, $precision);
    $unit = $units[$pow]; 
    return [$size, $unit];
  }

  /**
  * This function returns the maximum files size that can be uploaded in PHP
  * 
  * @return int file size in bytes
  **/
  private function iniUploadMax()  
  {  
    return min($this->toBytes(ini_get('post_max_size')), $this->toBytes(ini_get('upload_max_filesize')));  
  }  


  /**
  * This function transforms the php.ini notation for numbers (like '2M') to an integer (2*1024*1024 in this case)
  * 
  * @param string $sSize
  * @return integer value in bytes
  */
  public function toBytes($sSize)
  {
    //
    $sSuffix = strtoupper(substr($sSize, -1));

    $power = $this->bytesPower();

    if (!in_array($sSuffix, array('P','T','G','M','K'))){
        return (int)$sSize;  
    } 

    $iValue = substr($sSize, 0, -1);


    switch ($sSuffix) {
        case 'P':
            $iValue *= $power;
            // Fallthrough intended
        case 'T':
            $iValue *= $power;
            // Fallthrough intended
        case 'G':
            $iValue *= $power;
            // Fallthrough intended
        case 'M':
            $iValue *= $power;
            // Fallthrough intended
        case 'K':
            $iValue *= $power;
            break;
    }
    return (int)$iValue;
  }      

  
  private function ValidateImage($param){
    $paramName = $param['tmp_name'];
    if(!empty($paramName)){
      if((list($width, $height, $type, $attr) = getimagesize($paramName)) !== false){
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
       $rand = rand(0, 100);
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

  private function UploadAll($location, $boolean){
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
      $location .= '/'.$newfilename;
      $this->newdir = $location;
      $this->newloc = $location;

      $movefile = move_uploaded_file($Temp, $location);    
        
      if($movefile == true){
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