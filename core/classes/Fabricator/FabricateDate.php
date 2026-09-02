<?php 

namespace spoova\mi\core\classes\Fabricator;

use DateTime;
use spoova\mi\core\classes\Fabrication\Fabricator;
use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateDate implements FabricatorInterface{

    private static ?DateTime $date = null;

    public static function fabricate(DateTime $date = new DateTime(), $format = 'Y-m-d H:i:s'){

        self::setDate($date);

        $hours = mt_rand(1, 24);
        $minutes = mt_rand(1, 59);
        $seconds = mt_rand(1, 59);
        $date = self::$date;
        $date->modify("+".$hours." hours");
        $date->modify("+".$minutes." minutes");
        $date->modify("+".$seconds." seconds");

        return $date->format($format);  

    }

    private static function setDate(DateTime $date){
        if(!isset(self::$date)) {
            self::$date = $date;
        }
    }

    /**
     * Resets the date to null
     *
     * @return void
     */
    public function reset() {
        self::$date = null;
    }
    
}