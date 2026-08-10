<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateRomanNumeral implements FabricatorInterface {
  
  public static function fabricate(int $number = 0) : string {
    
    return self::convert($number);
    
  }
  
  private static function convert(int $number) : string {
    
    $numerals = [
        1000 => 'M',
        900  => 'CM',
        500  => 'D',
        400  => 'CD',
        100  => 'C',
        90   => 'XC',
        50   => 'L',
        40   => 'XL',
        10   => 'X',
        9    => 'IX',
        5    => 'V',
        4    => 'IV',
        1    => 'I'
    ];

    $result = '';
    
    foreach ($numerals as $value => $symbol) {
      while ($number >= $value) {
          $result .= $symbol;
          $number -= $value;
      }
    }

    return $result;
    
  }
  
}