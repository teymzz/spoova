<?php 

namespace spoova\mi\core\tools;

use Error;
use ValueError;

class BytesConverter {

    /**
     * Value to be converted
     *
     * @var string|integer|float
     */
    public $value = null;

    /**
     * Value to be converted
     *
     * @var string|integer|float
     */
    public $size;

    /**
     * Specifies the bytes power conversion rate for file sizes
     *
     * @var integer optional [1000|1024]
     *  - Default value is 1024
     */
    protected int $bytesPower = 1024;
  
    /**
     * Integer used to select byte unit's string format
     *
     * @var integer optional [0|1|2|3|4|5|6]
     */
    private int $bytesFormatSelector = 1; 

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
    
    public function __construct(string|int|float $value, int $power = 1024) {
        $this->value = $value;
        $this->bytesPower = $power;
    }

    /**
     * Sets a value to be converted
     *
     * @param string|integer|float $value
     * @param integer $power
     * @return BytesConverter
     */
    public static function conversion(string|int|float $value, int $power = 1024) : BytesConverter {
        return new self($value, $power);
    }

    /**
     * Alias to conversion() method
     *
     * @param string|integer|float $value
     * @param integer $power
     * @return BytesConverter
     */
    public static function convert(string|int|float $value, int $power = 1024) : BytesConverter {
        return new self($value, $power);
    }

    /**
     * Sets the string bytes to which a value must be converted
     *  - if both arguments are not specified, the best unit will be assumed
     * @param string $unit type of bytes to be converted to (e.g MB, GB). 
     *  - Avoid using any of 'B' or 'Bytes' as option as these unit strings are ambiguous.
     * 
     * @param string $format format required for displaying bytes unit
     *  ##### 0 => B,K,M,G,T
     *  ##### 1 => B,KB,MB,GB,TB (default)
     *  ##### 2 => B,Kb,Mb,Gb,Tb 
     *  ##### 3 => Bytes,KBytes,MBytes,GBytes,TBytes
     *  ##### 4 => Bytes,KiloBytes,MegaBytes,GigaBytes,TeraBytes
     *  ##### 5 => Bytes,Kilobytes,Megabytes,Gigabytes,Terabytes
     *  ##### 6 => BYTES,KILOBYTES,MEGABYTES,GIGABYTES,TERABYTES
     * @return array
     */
    public function toUnitBytes(?string $unit = null, int $format = 1, $precision = 2) : array {
        if(!in_array($format, [0,1,2,3,4,5,6])){
            $option = 1;
            throw new ValueError('The integer value supplied must be within the range of 0-6');
          }
        //   $this->bytesFormatSelector = $format;
        $units = $this->bytesFormat[$format];
        $value = (!is_numeric($this->value))? $this->toBytes($this->value) : $this->value;
        $bytes = max($value, 0);
        $pow   = floor(($bytes?log($bytes):0) / log($this->bytesPower));
        $pow   = min($pow, count($units) - 1);
        $bytes /= pow($this->bytesPower, $pow);
        $size = round($bytes, $precision);
        $unit = $units[$pow]; 
        return $this->size = [$size, $unit];
    }

    /**
     * Sets the string bytes to which a value must be converted
     *  - if both arguments are not specified, the best unit will be assumed
     * @param string $unit unit format of bytes returned (e.g MB, GB). 
     *  - Avoid using any of 'B' or 'Bytes' as option as these unit strings are ambiguous.
     * 
     * @param string $format format required for displaying bytes unit
     *  ##### 0 => B,K,M,G,T
     *  ##### 1 => B,KB,MB,GB,TB (default)
     *  ##### 2 => B,Kb,Mb,Gb,Tb 
     *  ##### 3 => Bytes,KBytes,MBytes,GBytes,TBytes
     *  ##### 4 => Bytes,KiloBytes,MegaBytes,GigaBytes,TeraBytes
     *  ##### 5 => Bytes,Kilobytes,Megabytes,Gigabytes,Terabytes
     *  ##### 6 => BYTES,KILOBYTES,MEGABYTES,GIGABYTES,TERABYTES
     * @return string
     */
    public function toStringBytes(?string $unit = null, int $format = 1, $precision = 2) : string {
        return implode('', $this->toUnitBytes(...func_get_args())); 
    }
  
    /**
     * Smartly shortens integer bytes to array of size and asummed best unit bytes
     *
     * @param integer $bytes
     * @param integer $precision
     * @return array
     */
    public function toMaxBytes(int $bytes, int $precision = 2) : array {
        $units = self::$bytesFormat[self::$bytesFormatSelector];
        $bytes = max($bytes, 0);
        $pow   = floor(($bytes?log($bytes):0) / log($this->bytesPower));
        $pow   = min($pow, count($units) - 1);
        $bytes /= pow($this->bytesPower, $pow);
        $size = round($bytes, $precision);
        $unit = $units[$pow]; 
        return [$size, $unit];
    }

    /**
     * This method transforms the php.ini notation for numbers (like '2M') to an integer (2 *1024 *1024 in this case)
     * 
     * @param string $stringSize
     *
     * @return integer value in bytes
     */
    public function toBytes(string|array|null $stringSize = null) : int
    {

        if(func_num_args() === 0){
            if(!isset($this->size)){
                if(isset($this->value)){
                    $this->toUnitBytes();
                }else{
                    throw new Error('No value defined to be converted!');
                }
            }
            $stringSize = $this->size;
        }

        if(is_array($stringSize) && (count($stringSize) === 2)){
            $stringSize = implode('',$stringSize);
        }

        if(!$stringSize) throw new Error('No bytes found to be converted');

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

        $power = $this->bytesPower; //use default bytes power defined

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

}