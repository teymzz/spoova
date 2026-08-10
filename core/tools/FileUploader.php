<?php 

namespace spoova\mi\core\tools;

use Closure;
use ValueError;

/**
 * This class was created for handling file uploads.
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
 */
class FileUploader{

  /**
   * Set file description callback
   *
   * @var Closure|null
   */
  protected ?Closure $describe = null;

  /**
   * Sets file descritption array format
   *
   * @var array
   */
  protected array $desc = [];

  /**
   * Sets file description
   *
   * @var string
   */
  protected string $fileDesc = '';

  /**
   * Sets accepted file mimes
   *
   * @var array
   */
  protected array|false $mimes = false;

  /**
   * Sets accepted file extension
   *
   * @var array
   */
  protected array|false $types = false;

  /**
   * stores original data pushed into uploader
   *
   * @var array
   */
  protected array $data = [];

  /**
   * sets uploaded file info (properties)
   *
   * @var array
   */
  protected array $finfo = [];

  /**
   * Returns true when error occurs
   *
   * @var boolean
   */
  private bool $error = false;

  /**
   * response message
   *
   * @var string
   */
  protected string $msg = ''; 

  /**
   * Contains information about uploaded file
   *
   * @var array
   */
  protected array $responseData = []; 
  
  /**
   * Filename (with extension) after upload
   *
   * @var string
   */
  public string $newfile = '';  
  
  /**
   * File destination directory
   *
   * @var string
   */
  public $newdir = ''; 

  /**
   * Temporary file name
   *
   * @var string
   */
  protected $file = '';

  /**
   * Internally sets the uploaded or loaded file's path
   *
   * @var string
   */
  public string $newloc = '';

  /**
   * Allow delete of string loaded image files
   *
   * @var boolean
   */
  protected bool $deletePath = false;

  /**
   * Allows assigning of custom unique 
   * names to uploaded file
   *
   * @var boolean
   */
  protected string|bool $uniquefile = false;

  /**
   * Specifies the bytes power conversion rate for file sizes
   *
   * @var integer optional [1000|1024]
   *  - Default value is 1024
   */
  protected int $bytesPower = 1024;

  /**
   * Specifies a custom minimum and maximum file size allowed for uploading. 
   * These values is are calculated by default using a default byte power of 1024 
   * and can be modified to a byte power of _1000_ using the _bytesPower()_ method.
   *
   * @var array 
   */
  protected array $specSize = ['min' => 0, 'max' => 1572864]; // (1.5 megabytes)

  /**
   * Contains a list of uniquely assumed audio extensions fallbacks
   *  - Values specified here are not defined in video extensions
   * 
   * @var array
   */
  protected array $audio_exts = [
    '3gp','3gpp','8svx','aa','aac','aax','ac3',
    'act','adt','aiff','alac','amr','ape','au',
    'awb','caf','cda','dss','dts','dvf','flac',
    'g723','gsm','iklax','ircam','it','ivs','kar',
    'm3u','m4a','m4b','mid','mka','mmf','mod',
    'movpkg','mp2','mp3','mpc','mpga','msv','nki',
    'nmf','oga','ogg','opus','pcm','pls','ra',
    'raw','rf64','rm','rns','rx2','s3m','sf2',
    'sid','sln','snd','spx','tta','voc','vorbis',
    'vox','vqf','w64','wav','wma','wv','xm',
  ];

  /**
   * Contains a list of uniquely assumed video extension fallbacks
   *  - Values specified here are not defined in audio extensions
   *
   * @var array
   */  
  protected array $video_exts = [
    '3g2','3gp','asf','avi','drc','f4a','f4b',
    'f4p','fav','flv','gifv','m2ts','m2v','m4v',
    'mkv','mng','mov','mp4','mpe','mpeg','mpg',
    'mpv','mts','mxf','nsv','ogv','qt','rm',
    'rmvb','roq','svi','ts','viv','vob','webm',
    'wmv',
  ];

  /**
   * Specifies the byte unit format for defining file sizes _(e.g Megabytes, Gigabytes)_ 
   *
   * @var array
   */
  private $bytesFormat = [
    0 => ['B','K','M','G','T'],
    1 => ['B','KB','MB','GB','TB'],
    2 => ['B','Kb','Mb','Gb','Tb'],
    3 => ['Bytes','KBytes','MBytes','GBytes','TBytes'],
    4 => ['Bytes','KiloBytes','MegaBytes','GigaBytes','TeraBytes'],
    5 => ['Bytes','Kilobytes','Megabytes','Gigabytes','Terabytes'],
    6 => ['BYTES','KILOBYTES','MEGABYTES','GIGABYTES','TERABYTES'],
  ];

  /**
   * Integer used to select byte unit's string format
   *
   * @var integer optional [0|1|2|3|4|5|6]
   */
  private int $bytesFormatSelector = 1; 
  
  /**
   * Specifies a source for image file to be loaded or uploaded
   *
   * @param array|string $files 
   *  - Arrays specified an uploaded file's form data
   *  - Strings are used for loading image paths
   * @param Closure $callback a callback function that is always applied if specified 
   * @return bool
   */
  public function start(array|string $files = [], ?Closure $callback = null) : bool {

    $this->reset();

    if(is_string($files)){
      $file = $files; $files = [];
      $files['name'] = basename($file);
      $files['tmp_name'] = $file;
      if(is_file($file)){
        $files['error'] = (is_file($file))? UPLOAD_ERR_OK : 4;
        $files['size'] = filesize($file);
        $push = true;
      } else {
        $files['error'] = 4;
        $files['size'] = 0;
      }
    }
    $push = $push ?? false;

    $this->data = $files;

    $fileTemp  = $files['tmp_name'] ?? $file ?? '';
    $fileName  = $files['name'] ?? '';
    $fileError = $files['error'] ?? '';
    $fileExists= file_exists($fileTemp);
    $fileOkay = ($fileName && $fileError === UPLOAD_ERR_OK);

    if($fileOkay && $fileExists){
      
      $DEFMime  = $files['type'] ?? '';
      $DEFMimes = explode('/', $DEFMime); 

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $PHPMime = finfo_file($finfo, $fileTemp);
      $PHPMimes = explode('/', $PHPMime); 

      $FILEMime = $PHPMime;
      $FILEMimes = $PHPMimes;
      
      if($push) $DEFMime = false;

      $this->finfo['def_mime'] = $DEFMime; //default mime returned by form
      $this->finfo['php_mime'] = $PHPMime; //mime returned by php
      $this->finfo['file_ext'] = pathinfo($fileTemp, PATHINFO_EXTENSION);

      if(($DEFMime && $PHPMime) && ($DEFMime !== $PHPMime)){
        if((substr($DEFMime, 0, 12) === 'application/') && ($PHPMime === 'application/octet-stream')){
          $FILEMime = $DEFMime;
          $FILEMimes = $DEFMimes;
        }
      }

      $this->file = $files;

      $method1 = 'pick_name_from_'.$PHPMimes[0].'_mime';
      $method2 = 'pick_name_from_files_mime';
      if(method_exists($this, $method1)){
        unset($FILEMimes[0]);
        ksort($FILEMimes);
        $fileMime = implode('/', $FILEMimes);
        $isXFile = (substr($fileMime, 0, 2) === 'x-');
        $xMime   = ($isXFile)? substr($fileMime, 2) : '';
        if($xMime && (strpos($xMime, '-') === false)){
          $fileMime = $xMime;
        }
        $this->$method1($fileName, $fileMime, $PHPMimes);
      }else{
        $this->$method2($fileName, $FILEMime, $PHPMimes);
      }

      $this->finfo['file_mime'] = $FILEMime;

      if($this->describe instanceof Closure){
        $describe = $this->describe;

        $descs = $this->desc; // contains file extension name, mime type & suffix

        for($i=count($this->desc); $i<3; $i++){
          $descs[] = ''; //filler for file extension name, mime type & suffix
        }

        $newdesc = $describe(...array_values($descs));
        $descwords = [];
  
        if($newdesc && is_array($newdesc)){
          foreach($newdesc as $descword){
            if(trim($descword)) $descwords[] = $descword;
          }
          if($descwords) $desc = $descwords;
        }

        // revert to default description of not provided
        if(!isset($desc)) $desc = ['file'];
  
      }else{
        $desc = array_values($this->desc);
      }
  
      $this->fileDesc = str_replace('  ', ' ', implode(' ', $desc));

      if((strpos($this->fileDesc, $fileName) !== false) && (strlen($fileName) > 15)){
        $shortName = substr($fileName, 0, 10).'...';
        $this->fileDesc = str_replace($fileName, $shortName, $this->fileDesc);
      }
      // if(isset($file)) {
      //   $this->newfile = basename($file);
      //   $this->newloc  = $file;
      //   $this->newdir  = dirname($file);
      // }
      $success = $this->success($this->fileDesc.' loaded successfully');

      if($callback) $callback($success, $this);
      return $success;
    }else{

      $stringBytes = $this->unitConverter($this->toBytes(ini_get('upload_max_filesize')));

      $response_message = [
        '1' => 'file exceeds ini:upload_max_filesize('.implode('',$stringBytes).')',
        '2' => 'file exceeds form:max_file_size',
        '3' => 'file partially uploaded',
        '4' => 'no file uploaded',
        '6' => 'missing temp directory',
        '7' => 'file failed to write to disk',
        '8' => 'file aborted by some php extension',
      ];

      $message = (!$fileTemp) ? 'File rejected: ' : '';
      
      $error = $this->error($message.($response_message[$fileError] ?? 'something is wrong!'));  
      $responseData= $this->responseData;
      
      //update response data
      $this->responseData['FILESIZE'] = false;
      $this->responseData['FITSSIZE'] = false;
      if(!$responseData['FILEMIME']) $this->responseData['FILEMIME'] = false;
      if(!$responseData['FORMMIME']) $this->responseData['FORMMIME'] = false;
      if(!$responseData['FILESTAT']) $this->responseData['FILESTAT'] = false;
      if(!$responseData['FILETEMP']) $this->responseData['FILETEMP'] = false;
      if(!$responseData['FILEPATH']) $this->responseData['FILEPATH'] = false;
      if(!$responseData['FITSSIZE']) $this->responseData['FITSSIZE'] = false;

      if($callback) $callback($error, $this);
      return $error;
    }

  }

    
  /**
   * Restructures the mutiple file for validation and processing. 
   * This method should be used before the start() method is executed in a loop for each file.
   *
   * @param array $files form's access name
   * @return array 
   */
  public function multiFiles($files = []) : array {

    $newarray = array();

    $file_keys = array_keys($files);

    $file_nums = count($files["name"]);

    for($i=0; $i < $file_nums; $i++){
      
      foreach($file_keys as $key){
        $newarray[$i][$key] = $files[$key][$i];
      }  

    }

    return $newarray;

  }

  /**
   * Sets the only accepted mimes.
   *  - Note that this may prevent files from getting uploaded if the file mime detection fails
   *  - To lessen file validation use types() instead which only validates file extension.
   *
   * @param array $accept array of mimes to accept
   * @return void
   */
  public function mimes(array $accept){
    $this->mimes = $accept;
  }

  /**
   * Sets the only accepted file extension types.
   *  - For strict mime type validation use mimes() method instead which validates file mime type.
   * 
   * @param array $accept array of extensions to accept
   * @return void
   */
  public function types(array $accept){
    $this->types = $accept;
  }

  /**
   * Sets the only accepted file extension types. Alias of {Fileuploader::types()} method.
   *  - For strict mime type validation use mimes() method instead which validates file mime type.
   * 
   * @param array $accept array of extensions to accept
   * @return void
   */
  public function extensions(array $accept){
    $this->types = $accept;
  }


  /**
   * sets the maximum and minimum file size 
   *  - Note that default maximum file size is set as 1.5mb (1572864 bytes)
   * 
   * @param int $min minumum acceptable file size
   * @param int $max maximum acceptable file size
   * @throws ValueError if the maximum size defined is greater than the php ini's iniUploadMax acceptable file size 
   */
  public function specSize(int $min = 0, int $max = 1572864){
    $maxSize = $this->iniUploadMax();
    if($max > $maxSize){
      throw new ValueError('maximum specified size exceeds maximum uploadable size');
    }
    $this->specSize = ['min'=>$min, 'max'=>$max];
  }

  /**
   * sets the maximum accepted file size (default is 1.5mb => 1572864)
   * 
   * @param int $size
   * @throws ValueError if the size defined is greater than the php ini's iniUploadMax acceptable file size 
   */
  public function filesize(int $size = 1572864){    
    $maxSize = $this->iniUploadMax();
    if($size > $maxSize){
      throw new ValueError('maximum specified size exceeds maximum uploadable size');
    }
    $this->specSize['max'] = $size;
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
   * Returns the extension name of an uploaded file
   *
   * @return string
   */   
  public function GetFileForm() : string {
    $file = $this->finfo;
    $filename = $file['file_ext'];
    return $filename;
  }

  /**
   * Returns the file mime-type of uploaded file using php mime-detection or default mime forwarded by form.
   *
   * @param bool $usePHP -  A false value will return the form's forwarded mime instead of PHP's mime.
   * @return string
   */   
  public function GetFileMime(bool $usePHP = true){
    $file = $this->finfo;
    if(!$usePHP) return $file['def_mime'] ?? $this->data['type'] ?? '';
    $fileType = $file['php_mime'] ??  $file['def_mime'] ?? $this->data['type'] ?? '';
    return $fileType;
  }

  /**
   * Returns the file mime-type of uploaded file using php mime-detection or default mime forwarded by form.
   * 
   * @return string
   */   
  public function GetFileType() : string{
    return $this->finfo['file_mime'] ?? '';
  }
  
  /**
   * Return file size of uploaded file 
   *
   * @return int|string
   */   
  public function GetFileSize(bool $to_stringbytes = false) : int|string{
    $file = $this->data;
    $fileSize = $file['size'] ?? 0;
    if(!$fileSize && is_file($this->newloc)){
      $fileSize = filesize($this->newloc);
    }
    if($to_stringbytes){
      $fileSize = implode('',$this->unitConverter($fileSize));
    }
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
    $file = $this->data;
    $filerr = $file['error'];
    return $filerr;
  }
  
  /**
   * Sets or Returns useful information of the current file
   *
   * @param boolean $string determines if an array or an html string response data is returned.
   * @return string
   */
  public function GetFileData(bool $string = false){
    $size = $this->GetFileSize(true);
    $name = $this->GetFileName();
    $type = $this->GetFileMime();
    $temp = $this->GetFileTemp();
    $error = $this->GetFileError();

    $file = [
      'FILENAME'  => $this->newfile ?: $name,
      'FILETYPE'  => $type,
      'FILESIZE'  => $size,
      'FILEBASE'  => $this->newdir ?: ($temp? dirname($temp) : $temp),
      'FILETEMP'  => $temp,
      'FILEPATH'  => $this->newloc ?: $temp,
      'FILEDEST'  => $this->newdir,   
      'FILESTAT' => $error,   //error status code during upload
    ];

    if(!$string){
      return $file;
    }
    
    $pre = "<pre>
    FILENAME  : $file[FILENAME]
    FILETYPE  : $file[FILETYPE]
    FILESIZE  : $file[FILESIZE]
    FILEBASE  : $file[FILEBASE]
    FILETEMP  : $file[FILETEMP]
    FILEPATH  : $file[FILEPATH]
    FILESTAT  : $file[FILESTAT]
    </pre>";

    return $pre;

  }
  
  /**
   * execute file upload operation
   *
   * @param string|array $location sets the file upload directory
   *  - The default value "*" accepts all types of file 
   * @param string $location  uploaded file's destination directory path.
   * @param boolean $mkdir true creates new directory _$location_ if it does not exist
   * @param null|Closure $callback a return callback function that is always called after the method has been executed.
   * @return bool
   */
  public function uploadFile(string $location, bool $mkdir = true, ?Closure $callback = null) : bool {

    $mimes = $this->mimes; //accepted mimes
    $types = $this->types; //accepted file types (extension)

    $data = $this->data;

    $path = $data['tmp_name'];
    $def_mime = $this->finfo['def_mime'];
    $php_mime = $this->finfo['php_mime'];
    $file_ext = $this->finfo['file_ext'];
    
    if(($mimes !== false) && !in_array($php_mime, $mimes)){

      $error = $this->error('invalid file mime uploaded');
      if($callback) $callback(false, $this);
      return $error;

    }

    if(($types !== false) && !in_array($file_ext, $types)){

      $error = $this->error('invalid file extension type uploaded');
      if($callback) $callback(false, $this);
      return $error;
    }

    $file_size = $this->GetFileSize();   //current file size
    $min_size =  $this->specSize['min']; //minimum specified size
    $max_size =  $this->specSize['max']; //maximum specified size
    $ini_max_filesize = $this->iniUploadMax();
    $max_uploadable = (implode('',$this->unitConverter($ini_max_filesize)));
    $maxFileSize = $this->unitConverter($this->toBytes($max_uploadable));

    //fetch maximum uploadable in short string bytes (e.g kb, mb)
    
    if($file_size > $ini_max_filesize){
      $error = $this->error("file exceeds a maximum uploadable size: ". $maxFileSize[0]. $maxFileSize[1]);
      if($callback) $callback(false, $this);
      return $error;
    }

    if($file_size > $max_size){
      $maxFileSize = $this->unitConverter($max_size);
      $error = $this->error("file exceeds a maximum size of: ". $maxFileSize[0]. $maxFileSize[1]);
      if($callback) $callback(false, $this);
      return $error;
    }

    if($file_size < $min_size){
      $minFileSize = $this->unitConverter($min_size);
      $error = $this->error("file subceeds a minimum size of: ". $minFileSize[0]. $minFileSize[1]);        
      if($callback) $callback(false, $this);
      return $error;  
    }
    
    $upload = $this->UploadAll($location, $mkdir);
    if($callback) $callback($upload, $this);
    return $upload;

  }

  /**
   * Sets the power used for bytes conversion. 
   *
   * @param integer $power optional [1000|1024]. 
   *  - Default value is 1024
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
   * This gives a unique name to an uploaded file. It overwrites the default file name. 
   *
   * @param boolean|string $unique
   * @return void
   *  - Notice: empty string(s) counts as false while non empty string sets the output name
   */
  public function uniqueFile(string|bool $unique = true){
    
    if(!trim($unique)) $unique = false;

    $this->uniquefile = $unique;

  }

  /**
   *  Sets the integer value for selecting file size bytes string format.
   *
   * @param integer $option 
   *  ##### 0 => B,K,M,G,T
   *  ##### 1 => B,KB,MB,GB,TB (default)
   *  ##### 2 => B,Kb,Mb,Gb,Tb 
   *  ##### 3 => Bytes,KBytes,MBytes,GBytes,TBytes
   *  ##### 4 => Bytes,KiloBytes,MegaBytes,GigaBytes,TeraBytes
   *  ##### 5 => Bytes,Kilobytes,Megabytes,Gigabytes,Terabytes
   *  ##### 6 => BYTES,KILOBYTES,MEGABYTES,GIGABYTES,TERABYTES
   * 
   * @return FileUploader
   * @throws ValueError
   */
  public function bytesFormat(int $option = 1) : FileUploader {
    if(!in_array($option, [0,1,2,3,4,5,6])){
      $option = 1;
      throw new ValueError('The integer value supplied must be within the range of 0-6');
    }
    $this->bytesFormatSelector = $option;
    return $this;
  }
  
  /**
   * Converts integer bytes to array of size and string unit
   *
   * @param integer $bytes
   * @param integer $precision
   * @return array
   */
  public function unitConverter(int $bytes, int $precision = 2) : array {
    $units = $this->bytesFormat[$this->bytesFormatSelector];
    $bytes = max($bytes, 0);
    $pow   = floor(($bytes?log($bytes):0) / log($this->bytesPower()));
    $pow   = min($pow, count($units) - 1);
    $bytes /= pow($this->bytesPower(), $pow);
    $size = round($bytes, $precision);
    $unit = $units[$pow]; 
    return [$size, $unit];
  }

  /**
  * This method returns the maximum files size that can be uploaded in PHP
  * 
  * @return int file size in bytes
  **/
  private function iniUploadMax()  
  {  
    return min($this->toBytes(ini_get('post_max_size')), $this->toBytes(ini_get('upload_max_filesize')));  
  }  


  /**
   * This method transforms the php.ini notation for numbers (like '2M') to an integer (2 *1024 *1024 in this case)
   * 
   * @param string $stringSize
   *
   * @return integer value in bytes
   */
  public function toBytes(string $stringSize) : int
  {

    $matchSize = preg_replace_callback('~(\d)+\s*(YOTTA|ZETTA|EXA|PETA|TERA|GIGA|MEGA|KILO|Y|Z|E|P|T|G|M|K)(BYTES|BYTE|B)?~i', function($matches){

      $digit  = $matches[1];
      $unit  = $matches[2];
      $bytes  = $matches[3] ?? '';
      $unitBytes = $unit.$bytes;

      return strtoupper(str_replace($unitBytes, substr($unitBytes, 0, 1), $matches[0]));

    }, $stringSize);

    $stringSize = $matchSize;

    // Get the last word of the file size
    $sSuffix = strtoupper(substr($stringSize, -1));

    $power = $this->bytesPower(); //use default bytes power defined

    if (!in_array($sSuffix, array('Y','Z','E','P','T','G','M','K'))){
        return (int)$stringSize;  
    } 

    $iValue = substr($stringSize, 0, -1);

    switch ($sSuffix) {
        
        case 'Y':
            $iValue *= $power; // Larger integer not supported yet 
            // Fallthrough intended
        case 'Z':
            $iValue *= $power; // Larger integer not supported yet 
            // Fallthrough intended 
        case 'E':
            $iValue *= $power;
            // Fallthrough intended
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

  /**
   * Defines the name for uploaded files
   *
   * @return string
   */
  private function prepend() : string {  
    $append = "";
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

  /**
   * Uploads a file to specified location
   *
   * @param string $location
   * @param bool $boolean true creates directory _$location_ if it does not exist.
   * 
   * @return bool true when file is uploaded or loaded
   */
  private function UploadAll(string $location, bool $boolean){

    if(!$location) {
      return $this->error("No destination directory defined!");
    }

    if(!is_dir($location) and $boolean == true){
      //create a new directory if not exists
      if(!mkdir($location,0777,true)){
        return $this->error("File directory cannot be created.");
      }
    }
    
    if(!is_dir($location)){
      return $this->error("File destination directory does not exist.");
    }

    if(!is_writable($location)){
      return $this->error("File destination directory is not writeable.");
    }

    $Temp     = $this->GetFileTemp();
    $newfilename = $this->prepend();

    $this->newfile = $newfilename;         
    $this->newdir = $location;
    $location .= DS.$newfilename;         
    $this->newloc = $location;

    if(($move = move_uploaded_file($Temp, $location)) || ($copy = copy($Temp, $location))){
        $this->deletePath = $copy ?? false;
        $this->setmessage($this->fileDesc." uploaded successfully");
        return true;
    }else{
        return $this->error("File failed to move to destination directory");
    }      
          
  }

  /**
   * Sets a response message
   *
   * @param mixed $message
   * @return void
   */
  protected function setmessage($message){
    $this->msg = $message;
  }

  protected function error(string $message) : false{
    $this->setmessage($message);
    $this->error = true;

    $data = $this->data;
    $info = $this->finfo;
    $iniMax = $this->iniUploadMax();
    
    $stringBytes = implode('',$this->unitConverter($iniMax));
    $fileSize    = $this->GetFileSize();
    $specSize    =$this->specSize;
    
    $this->responseData = [
      'FILENAME' => $data['name'], 
      'FILETEMP' => $data['tmp_name'], 
      'FILEPATH' => $this->newloc, 
      'FILESIZE' => $this->GetFileSize(true),   //uploaded file size as string
      'FILEMIME' => $this->GetFileMime(), 
      'FORMMIME' => $this->GetFileMime(false), 
      'FILESTAT' => $this->GetFileError(),      //file error status
      'FREESIZE' => $stringBytes,   //uploadable file size
      'FITSSIZE' => !(($fileSize > $iniMax) || ($fileSize > $specSize['max']) || ($fileSize < $specSize['min'])),   //
      'FITMIMES' => $this->mimes,      
      'FITTYPES' => $this->types,      
      'SPECSIZE' => [
        'MIN' => $this->specSize['min'], 
        'MAX' => $this->specSize['max'] 
      ],
      'MESSAGE' => $message
    ];
    return false;
  }

  /**
   * Sets a success message and returns true .
   *
   * @param string $message
   * @return boolean true
   */
  protected function success(string $message) : bool{
    $this->setmessage($message);
    $this->error = false;

    $data = $this->data;
    $info = $this->finfo;
    
    $this->responseData = [
      'FILENAME' => $data['name'], 
      'FILETEMP' => $data['tmp_name'], 
      'FILEPATH' => $data['tmp_name'], 
      'FILESIZE' => $this->GetFileSize(true),   //uploaded file size as string
      'FILEMIME' => $this->GetFileMime(), 
      'FORMMIME' => $this->GetFileMime(false), 
      'FILESTAT' => $this->GetFileError(),      //file error status
      'FITSSIZE' => true,
      'MESSAGE'  => $message
    ];
    return true;
  }


  /**
   * Returns an error if an error exists
   *
   * @return boolean
   */
  public function error_exists() : bool {
    return $this->error;
  }


  
  /**
   * Returns a response message if available.
   * 
   * @param bool $data specifies if a string or an array response is returned
   *
   * @return array|string returns a string or array response depending on argument supplied
   *  - Note that array from responseData() method is returned when $data is set as true.
   */
  public function response(bool $data = false) : array|string{
    if($data) return $this->responseData();
    return $this->msg;
  }
  
  /**
   * returns the upload message
   *
   * @return array
   */
  public function responseData() : array{
    return $this->responseData;
  }

  /**
   * Returns a word definition for uploaded file
   *
   * @param string $fileName
   * @param string $fileMime text string after the first slash
   * @param array $mimeSplit
   * @return void
   */
  protected function pick_name_from_text_mime(string $fileName, string $fileMime, array $mimeSplit){

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $class = 'text';

    if($fileMime === 'plain'){
      if(!$extension){
        $fileMime = $fileName;
      }else{
        if(!in_array($extension, ['txt','text'])){
          $class = '';
          $fileMime = $extension;
        }
      }
    }

    if(!preg_match('~[+-.\~]~', $fileMime)){
      return $this->description($fileMime, $class);
    }
    
    return $this->description($extension, $class);

  }

  /**
   * Returns a word definition for uploaded file
   *
   * @param string $fileName
   * @param string $fileMime text string after the first slash
   * @param array $mimeSplit
   * @return void
   */
  protected function pick_name_from_image_mime(string $fileName, string $fileMime){

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    if(!preg_match('~[+-.\~]~', $fileMime)){
      
      return $this->description($fileMime, 'image');
    }
    
    return $this->description($extension, 'image');

  }

  protected function pick_name_from_audio_mime(string $fileName, string $fileMime){

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);  

    if(!preg_match('~[+-.\~]~', $fileMime)){
      return $this->description($fileMime, 'audio');
    }

    return $this->description($extension, 'video');
  }

  protected function pick_name_from_video_mime(string $fileName, string $fileMime){

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    if(!preg_match('~[+-.\~]~', $fileMime)){
      return $this->description($fileMime, 'video');
    }
    
    return $this->description($extension, 'video');

  }

  protected function pick_name_from_application_mime(string $fileName, string $fileMime) {

    $extension = pathinfo($fileName, PATHINFO_EXTENSION);

    if(!preg_match('~[+-.\~]~', $fileMime)){
      return $this->description('', $fileMime);
    }elseif(trim($extension) === '') {
      return $this->description('', $fileName);
    }else{
      return $this->description($extension, '');
    }
    
  }

  protected function pick_name_from_files_mime(string $fileName, string $fileMime, $mimeSplit){    

    if($fileMime &&  $mimeSplit && (count($mimeSplit) < 3)){
      $fileMime = implode(' ',array_reverse($mimeSplit));
    } else {
      $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $videoExts = $this->video_exts();
      $audioExts = $this->audio_exts();
      if(in_array($extension, $audioExts)){
        return $this->description($extension, 'audio');
      }elseif(in_array($extension, $videoExts)){
        return $this->description($extension, 'video');
      }else{
        if(!preg_match('~[+-.\~]~', $fileMime)){
          return $this->description('', $fileMime);
        }elseif(trim($extension) === '') {
          return $this->description('', $fileName);
        }
      }
    } 
    
    return $this->description('', $fileMime);
  }

  /**
   * Fallback for some common audio extensions
   *
   * @return array
   */
  public function audio_exts()  : array {
    return $this->audio_exts;
  }

  /**
   * Fallback for some common video extensions
   *
   * @return array
   */
  public function video_exts() : array{
    return  $this->video_exts;
  }

  /**
   * Defines a response format
   *
   * @param Closure $describe
   * @return void
   */
  public function describe(Closure $describe) {
    $this->describe = $describe;
  }

  /**
   * Describes a file using array format
   *
   * @param string $fileExt
   * @param string $fileType
   * @param string $suffix default suffix is 'file'
   * @return void
   */
  private function description($fileExt, $fileType, $suffix = 'file') : void {
    $this->desc['extension'] = $fileExt;
    $this->desc['type'] = $fileType;
    $this->desc['suffix'] = $suffix;
    return;
  }

  /**
   * Deletes a specified file
   *
   * @param string $file path of file to be deleted 
   *  - If specified as true, uses the default source path defined through the _start()_ method
   * @return bool - true only if an existing file is deleted
   */
  public function delete(bool|string $file) :bool{
    if($file === true) $file = $this->newloc;
    if(is_file($file)){
     return @unlink($file) ;
    }
    return false;
  }

  /**
   * Resets class variables
   *
   * @param boolean $strict true starts in strict mode and resets all variables
   * @return void
   */
  private function reset($strict = false){

    $this->fileDesc = '';
    $this->msg = ''; 
    $this->newfile = '';  
    $this->newdir = ''; 
    $this->data = [];
    $this->file = '';
    $this->newloc = '';
    $this->deletePath = false;

    if($strict){
      $this->uniquefile = false;
      $this->bytesPower = 1024;
      $this->specSize = 1572864;
    }
    
  }


}