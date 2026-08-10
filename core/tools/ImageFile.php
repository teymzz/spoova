<?php
namespace spoova\mi\core\tools;

use Closure;
use Exception;
use ValueError;

/**
 * This class is used to upload and resize images
 * 
 * @author Akinola Saheed <akinolasaheed001@gmail.com>
*/
class ImageFile extends FileUploader{

    private array|false $resize = false;
    private string $resizePath = '';

    public function start(string|array $files = [], ?Closure $callback = null) : bool {

        //normalize variables
        $this->resize = false;
        $this->resizePath = '';

        //initialize parent class
        if(parent::start($files)){
          $success = $this->validateImage(); //apply image validation
          if($callback) {
            if(is_string($files)) $this->newloc = $files;
            $callback($success, $this); 
          }
          return $success;
        }
        
        if($callback) $callback(false, $this);
        return false;
    }

    /**
     * This method is called when an image is expected to be resized. 
     *  - Only file extensions (jpg,png,gif) are supported.
     *
     * @param string $width expected width of an image file.
     * @param string $height expected height of an image file.
     *  - Due to aspect ratio maintenance, this may vary depending on the width (if supplied) of the image 
     * @param string $location this assumes the default image path if not precisely defined.
     * @param Closure|null $callback a return callback function that is always called.
     *  - The closure only supports two arguments. The first argument _$success_ returns true when the image dimensions are successfully modified 
     *    and the second argument specifies the current instance of the _ImageFile_ class itself.
     * @return string|false
     */
    public function resize(int|float|string $width = 'auto', int|float|string $height = 'auto', string $location = '', ?Closure $callback = null) : string|false {

      if(is_numeric($width) || ($width === 'auto')){
        $newSize['x'] = $width; 
      } else{
        $error[] = 'argument(#1) must be a numerical value or must be set as \'auto\' or false.';
      }

      if(is_numeric($height) || ($height === 'auto')){
        $newSize['y'] = $height; 
      } else{
        $error[] = 'argument(#2) must be a numerical value or must be set as \'auto\'';
      }

      if(!isset($error)){
        $this->resize = $newSize;
        $this->resizePath = $location;
        $resize = $this->resizeImage();
        $this->resizePath = realpath($location) ?: $location;
        if($callback) $callback($resize, $this);
        if($resize) return $this->resizePath;
      }else{
        if($callback) $callback(false, $this);
        throw new ValueError($error[0]);
      }

      return false;
      
    }

    /**
     * This method is used to resize an image internally
     *
     * @return boolean
     */
    private function resizeImage() : bool {

      if($sizes = $this->getsImageNewSize()){ 
        $imageFile = $this->newloc; //path of image
        $imageDest = $this->resizePath ?: $imageFile;
        $imageExt  = strtolower(pathinfo($imageDest, PATHINFO_EXTENSION));
        $imageFileExt =  strtolower(pathinfo($this->newloc, PATHINFO_EXTENSION));
        if(!$imageExt) {
          $imageDest .= '.'.$imageFileExt;
        }
        $this->resizePath = $imageDest;

        list($x, $y, $newWidth, $newHeight) = $sizes;

        //resizer function
        $resizeImage =  function($sourceFn, $processFn) use($newWidth, $newHeight, $x, $y, $imageFileExt){
          $sourceImage = $sourceFn();
          $newImage = imagecreatetruecolor($newWidth, $newHeight);
          if($imageFileExt === 'png'){
            imagecolortransparent($newImage, ($bgcolor = imagecolorallocate($newImage,0,0,0)));
            imagealphablending($sourceImage, true); // setting alpha blending on
            imagesavealpha($sourceImage, true); // save alphablending setting (important)
          }elseif($imageFileExt === 'gif'){
            imagecolortransparent($newImage, ($bgcolor = imagecolorallocate($newImage,0,0,0)));
          }
          imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $x, $y);
          $processFn($newImage, $sourceImage);
          imagedestroy($newImage);
          imagedestroy($sourceImage);

          //get new image size 
        };

        // process image and resize 
        if($this->check_jpeg($imageFile) === true){
          try{
            
            switch ($imageFileExt)
              {
                case "jpg":
                  $quality = '100';
                  $resizeImage(
                    fn() => imagecreatefromjpeg($imageFile), //source image
                    fn($newImage) => imagejpeg($newImage,$imageDest,$quality)
                  );
                  break;
                case "gif":
                  $resizeImage(
                    fn() => imagecreatefromgif($imageFile), //source image
                    fn($newImage) => imagegif($newImage,$imageDest)
                  );
                  break;
                case "png":
                  $quality = 9;
                  $resizeImage(
                    fn() => imagecreatefrompng($imageFile), 
                    fn($newImage) => imagepng($newImage,$imageDest,$quality)
                  );
                  break;
              }

              //get new image size 
              $newSizes = getimagesize($imageFile);

              if($newSizes && (($newSizes[0] < $x) || ($newSizes[1] < $y))){
                return true;
              }else{
                return $this->error('no image resize was made');
              }

          } catch(Exception $e) {
            return $this->error($e->getMessage());
          }
        }else{
          return $this->error('bad image cannot be resized');
        }

      }
      
      return false; //message is handled by getsImageNewSize()

    }

    /**
     * Returns the expected path of a file after the _resize()_ method has been called.
     * This may return _empty string_ if the file path is not valid.
     *
     * @return string
     */
    public function resizePath() : string {

      return $this->resizePath;

    }

    private function getsImageNewSize() : array {
      
      $resize = $this->resize;

      if(is_array($resize)){

        $imageFile = $this->newloc; //path of image

        $imageSizes = getimagesize($imageFile); //path of image

        if($imageSizes && is_array($imageSizes)) {
          
          $x = $imageSizes[0];  //default image width
          $y = $imageSizes[1];  //default image height

          $w = $resize['x'] ?? $x; //defined image width
          $h = $resize['y'] ?? $y; //defined image height

          //set image width and height
          $newWidth = ($w !== 'auto')? $w : $x;
          $newHeight = ($h !== 'auto')? $h : $y;

          $aspectRatio = $x / $y; // get current image width-height aspect ratio
          $newAspectRatio = $newWidth / $newHeight;

          //Determine new dimensions while maintaining aspect ratio (no upscaling)
          if($newAspectRatio > $aspectRatio){
            $newWidth = $newHeight * $aspectRatio;
          }else{
            $newHeight = $newWidth / $aspectRatio;
          }

          // convert implicit float values to integer for precision
          $newWidth = (int) $newWidth;
          $newHeight = (int) $newHeight;

          return [$x, $y, $newWidth, $newHeight];
        } else{
          $this->error('invalid image size detected');
        }
      } 
      $this->error('new image sizes(width, height) not defined');
      return [];
    }

    /**
     * Displays the image from the upload path if it exists
     *
     * @param null|string|Closure $url url address of image
     *   - By default, if not supplied or set as _null_, url address will be automatically generated from uploaded file 
     *     through the spoova's magic _dompath()_ helper function.
     *   - Other specified values must return a valid url address of the expected image file to be displayed or viewed 
     * 
     * @param integer|float|string $width sets the image width
     * @param integer|float|string $height sets the image height
     * @param null|Closure|string $path path of image to be viewed. 
     *  - If not supplied, may assume the uploaded file path if it exists.
     * @return string
     * 
     * @throws ValueError if $path is not defined, assumed or does not exist
     */
    public function view(null|string|Closure $url = null, int|float|string $width = 'auto', int|float|string $height = 'auto'){
      
      if(is_numeric($width)){
        $width = $width.'px';
      }

      if(is_numeric($height)){
        $height = $height.'px';
      }

      if($url === null) {
        $url = $this->newloc;
        if(!is_file($url)){
          throw new ValueError('no image path defined');
        }
        $url = dompath($url);
      }else if($url instanceof Closure){
        $url = $url($this->newloc);
      }
      return "<img src='$url' style='width:$width; height:$height'>";

    }

    private function validateImage() : bool {

      $file = $this->data;

      $mimeType = $this->GetFileMime();
      $mimeType = explode('/',$mimeType)[0];

      if($mimeType !== 'image'){
          return $this->error("bad image selected!");
      }

      if((list($width, $height, $type, $attr) = getimagesize($file['tmp_name'])) !== false){
        return true;
      }else{
        $this->setmessage("bad image selected!");
      }

      return false;

    }

    /**
     * Tests for the width and height dimensions of an image file
     *
     * @param string $path path of image to be tested
     * @param integer $width width of image to be matched if not set as false
     * @param integer $height height width of image to be matched if not set as false
     * @return boolean
     *  - Note that false is returned when both _$width_ and _$height_ is set as false
     *  - Due to aspect ratio maintenance, in most cases only the width should be supplied 
     *    as the height of a resized image may not maintain the precise height defined during resizing.
     */
    public function isDimension(?string $path = null, int|false $width = false, int|false $height = false) : bool{

      if(($width===false) && ($height===false)) return false;

      if($path === null) $path = $this->newloc;

      if($sizes = getimagesize($path)){
        $axisX = $sizes[0]; //width 
        $axisY = $sizes[1]; //height
        $isWidth = false;
        $isHeight = false;

        if($width !== false) {
          if($axisX != $width) return false;
          $isWidth = true;
        }

        if($height !== false) {
          if($axisY != $height) return false;
          $isHeight = true;
        }

        if($width && ($height === false)){
          return $isWidth;
        }

        if(($width === false) && ($height)){
          return $isHeight;
        }

        return $isWidth && $isHeight;
      }
      return false;
      
    }

    /**
     * Detects Bad file
     *
     * @param string $file file path
     * @param boolean $fix true tries to fix image
     * @return bool
     */
    private function check_jpeg($file, $fix = false) : bool {

      # check for jpeg file header and footer - also try to fix it
      if ( false !== (@$fd = fopen($file, 'r+b')) ){
          if ( fread($fd,2)==chr(255).chr(216) ){
              fseek ( $fd, -2, SEEK_END );
              if (fread($fd,2) == chr(255).chr(217)){
                  fclose($fd);
                  return true;
              }else{
                  if ( $fix && fwrite($fd,chr(255).chr(217)) ){return true;}
                  fclose($fd);
                  return false;
              }
          }else{ fclose($fd); return false;}
      }else{
          return false;
      }
    }
    
    
}

?>
