<?php
namespace spoova\mi\core\tools;

/**
 * This class is used to upload and resize images
 * 
 * @author Akinola Saheed <teymss@gmail.com>
*/
class ImageClass extends FileUploader{
  
    private $setActivity  = null;
    private $imageValid   = false;
    private $imageSet     = null;
    private $imageWidth   = null;
    private $imageheight  = null;
    private $imageQuality = null;
    private $imageOut     = null;
    private $imageData;
    private $validImage;
    
    /**
     * Sets an image for resizing
     *
     * @param string $image path of image
     * @return void
     */
    public function setImage($image){
      $this->imageSet = $image;
    }

    /**
     * Sets activity to resize of image
     *
     * @return void
     */
    public function resizeImage(){
      ($this->imageSet != null)? $this->setActivity = "newResize" : null;
    }


    /**
     * Sets activity to check if image is valid
     *
     * @return void
     */
    public function validImage(){
      ($this->imageSet != null)? $this->setActivity = "newValidate" : null;
    }

      /**
     * Sets activity to create a new element
     *
     * @return void
     */  
    public function createImage(){
      ($this->imageSet != null)? $this->setActivity = "newImage" : null;
    }

    public function imageData(){
      ($this->imageSet != null)? $this->setActivity = "newData" : null;
    }
    
    /**
     * Executes activities previously declared
     *
     * @return mixed
     */
    public function runImage(){
      if($this->imageSet != null && $this->mvalidateImage()==true){
       return $this->process();
      }else{
       self::setmessage("No image or invalid image supplied");
       return  $this->imageValid = false;
      }
    }
    
    private function mvalidateImage(){
      $image = $this->imageSet;
      if(is_file($image)){
        $imSize = getimagesize($image);
        $image = MyIsset($imSize);
        if($image['mime'] != null){
          $this->imageData  = getimagesize($this->imageSet);
          return	$this->imageValid = true;   
        }else{
          return  $this->imageValid = false;
        }
      }
    }

    private function process(){
      if($this->setActivity != null){
        $function_to_run   = $this->setActivity;
        return $this->$function_to_run();
      }else{
        return  $this->imageValid = false;
      }
    }
    
    /**
     * Sets the size properties of an image
     *
     * @param int $width
     * @param int $height
     * @param int $quality - options ( 0 - 9 )
     * @param string $fileOut
     * @return void
     */
    public function setWidth($width, $height, $quality = null, $fileOut = null){
      $this->imageWidth   = $width;
      $this->imageheight  = $height;
      $this->imageQuality = $quality;
      $this->imageOut     = ($fileOut == null)? $this->imageSet : $fileOut;
    }
    
    private function newValidate(){
      return $this->imageValid;
    }
    
    private function newResize(){
      $filepath     = $this->imageSet;
      $pathInfo     = pathinfo($filepath);
      $pathExt      = $pathInfo['extension'];
      $extension    = strtolower($pathExt);
      $filename_out = $this->imageOut;
      $quality      = $this->imageQuality;
      $width     = $this->imageWidth;
      $height    = $this->imageheight;
      $size = getimagesize($filepath);
      $ratio = $size[0] / $size[1];
      if ($ratio >= 1){
          $scale = $width / $size[0];
      } else {
          $scale = $height / $size[1];
      }

      // make sure its not smaller to begin with!
      if ($width >= $size[0] && $height >= $size[1]){
        $scale = 1;
      }

      if($this->check_jpeg($filepath)==true){
        switch ($extension)
          {
            case "jpg":
              $quality = '100';
              $im_in = imagecreatefromjpeg($filepath);
              $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
              imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
              imagejpeg($im_out,$filename_out,$quality);
              break;
            case "gif":
              $im_in = imagecreatefromgif($filepath);
              $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
              imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
              imagegif($im_out,$filename_out,$quality);
              break;
            case "png":
                  
              $im_in = imagecreatefrompng($filepath);
              $im_out = imagecreatetruecolor($size[0] * $scale, $size[1] * $scale);
              $background = imagecolorallocate($im_out,0,0,0);
              imagecolortransparent($im_out,$background);
              imagecopyresampled($im_out, $im_in, 0, 0, 0, 0, $size[0] * $scale, $size[1] * $scale, $size[0], $size[1]);
               imagealphablending($im_in, true); // setting alpha blending on
              imagesavealpha($im_in, true); // save alphablending setting (important)
              
              //return imagepng($im_out, $filename_out, 9);
              imagepng($im_out,$filename_out);
              break;
          }
        imagedestroy($im_out);
        imagedestroy($im_in);
      }
        
    }

    private function newImage(){
     
      if($this->imageValid == true){
        $width   = $this->imageWidth;
        $height  = $this->imageheight;
        $image   = $this->imageSet;
        return "<img src='$image' style='width:$width; height:$height'>";
      }else{
       return $this->validImage = false;
      }
        
    }

    /**
     * Returns image data
     *
     * @return array
     */
    public function newData(){
      if($this->imageValid == true){
        return $this->imageData;
      }
      return [];
    }
    
    /**
     * prints processed image to the page
     *
     * @param string $class class attribute
     * @return string|false
     */
    public function imageDisplay($class = null){
      
      if($this->imageValid == true){
        $width     = $this->imageWidth;
        $height    = $this->imageheight;
        $image  = $this->imageSet;
        $nImage = "<img src='$image' style='width:$width; height:$height' class='$class'>";
        return $nImage; 
      }else{
        return $this->validImage = false;
      }

    }
    
    /**
     * Resets the properties of the current class
     *
     * @return void
     */
    public function imageDestroy(){
      $this->imageReset();
    }
    
    private function imageReset(){
      $this->setActivity  = null;
      $this->imageValid   = false;
      $this->imageSet     = null;
      $this->imageWidth   = null;
      $this->imageheight  = null;
      $this->imageQuality = null;
      $this->imageOut     = null; 
    }

    /**
     * Safe delete of an image
     *
     * @param string $im_url image path
     * @return bool
     */
    public function imageDelete($im_url = null){

      $image = $this->imageSet;
      if(strpos($image, $im_url)){
        $image =  str_replace($im_url, '', $image);
      }
       
      if(is_file(docroot.$image)) return @unlink($image);

      return false;

    }

    /**
     * Detects Bad file
     *
     * @param string $f file path
     * @param boolean $fix true tries to fix image
     * @return bool
     */
    public function check_jpeg($f, $fix = false) : bool {

      # check for jpeg file header and footer - also try to fix it
      if ( false !== (@$fd = fopen($f, 'r+b' )) ){
          if ( fread($fd,2)==chr(255).chr(216) ){
              fseek ( $fd, -2, SEEK_END );
              if (fread($fd,2)==chr(255).chr(217) ){
                  fclose($fd);
                  return true;
              }else{
                  if ( $fix && fwrite($fd,chr(255).chr(217)) ){return true;}
                  fclose($fd);
                  return false;
              }
          }else{fclose($fd); return false;}
      }else{
          return false;
      }
    }
    
    
    }

?>
