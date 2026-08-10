<?php

namespace spoova\mi\core\classes\Fabricator;

use spoova\mi\core\classes\Anonymous;

use function spoova\mi\core\classes\Anonymous;
use ErrorException;

class FabricatePriceUnit implements FabricatorInterface {
  
  /**
   * @param string $name 
   *  - options [dollar, naira, euro, pound, cent, singapore-dollar, argentine-peso, chilean-peso, colombian-peso, 
   *             hong-kong-dollar, yen, yuan, rupee, cedi, shilling, peso, mexican-peso, rand, dirham, dong, koruna, 
   *             shekel, paka, guilder, manat, lev, lira, krona, krone, colon, rial, tenge, won, denar, zloty, dinar, 
   *             baht, hryvnia and real]
   *  - Options can be separated by pipe
   *  - If no option is supplied, it will return a random price unit
   * 
   * @return string
   */
  public static function fabricate(?string $name = null) : string {

    $units = [
      "naira" => '₦',
      "euro"  => '£',
      "pound" => '€',
      "egyptian-pound" => 'E£',
      "dollar" => '$',
      "cent" => '¢',
      "singapore-dollar" => 'S$',
      "argentine-peso" => '$',
      "chilean-peso" => 'CL$',
      "colombian-peso" => 'COL$',
      "hong-kong-dollar" => 'HK$',
      "yen" => '¥',
      "yuan" => '¥',
      "rupee" => '₹',
      "cedi" => '₵',
      "shilling" => 'KSh',
      "peso" => '₱',
      "mexican-peso" => 'Mex$',
      "rand" => 'R',
      "dirham" => 'د.إ',
      "dong" => '₫',
      "koruna" => 'Kč',
      "shekel" => '₪',
      "paka" => '৳',
      "guilder" => 'ƒ',
      "manat" => '₼',
      "lev" => 'лв',
      "lira" => '₺',
      "krona" => 'k',
      "krone" => 'k',
      "colon" => '₡',
      "rial" => '﷼',
      "tenge" => 'лв',
      "won" => '₩',
      "denar" => 'ден',
      "zloty" => 'zł',
      "dinar" => 'Дин',
      "baht" => '฿',
      "hryvnia" => '₴',
      "real" => 'R$',
    ];
    
    if($name === null) return $units[array_rand($units)];
    
    if(isset($units[$name])){
      return $units[$name];
    } else {
      throw new ErrorException('invalid price unit option supplied');
    }
    
  }
  
}