<?php

namespace spoova\mi\core\classes\Fabricator\DB;

use spoova\mi\core\classes\Fabricator\FabricatorInterface;

class FabricateTimestamp implements FabricatorInterface {

    /**
     * Generates a random timestamp in TIMESTAMP format (Y-m-d H:i:s)
     *
     * @param int $distance optional number of years back from current year. 
     *  - NULL will use any random number of years (range 1 - 10yrs) before the current year.
     *  - Supports positive and negative integer
     * @return string Timestamp in Y-m-d H:i:s format
     */
    public static function fabricate(?int $distance = null) : string {
        
        if($distance === null) {
            $distance = - random_int(1, 10);
        }
        
        $currentYear = date('Y');
        $startYear = $currentYear + $distance;
        
        $randomYear = mt_rand($startYear, $currentYear);
        $randomMonth = mt_rand(1, 12);
        $daysInMonth = (int) date('t', strtotime("$randomYear-$randomMonth-01"));
        $randomDay = mt_rand(1, $daysInMonth);
        $randomHour = mt_rand(0, 23);
        $randomMinute = mt_rand(0, 59);
        $randomSecond = mt_rand(0, 59);
        
        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', 
            $randomYear, $randomMonth, $randomDay, 
            $randomHour, $randomMinute, $randomSecond
        );
    }

}
