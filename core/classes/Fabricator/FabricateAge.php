<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateAge implements FabricatorInterface {

  /**
   * Fabricate an age based on an age bracket
   *
   * @param string|null $bracket age bracket: children, teenagers, youth, adults, seniors 
   *  - children, child: 1-12
   *  - teenagers, teens, teen : 13-19
   *  - youth, young-adults, young-adults : 20-35
   *  - adults, adult: 36-60
   *  - seniors, elderly, senior: 61-100
   *  - Note that if no bracket is supplied, any reasonable human age (1-100) is returned
   * @return int
   */
  public static function fabricate(?string $bracket = null) : int {

    switch (strtolower((string) $bracket)) {

      case 'children':
      case 'child':
        return self::children();

      case 'teenagers':
      case 'teens':
      case 'teen':
        return self::teenager();

      case 'young_adults':
      case 'young-adults':
      case 'youth':
        return self::youth();

      case 'adults':
      case 'adult':
        return self::adult();

      case 'seniors':
      case 'elderly':
      case 'senior':
        return self::senior();

      default:
        // If no bracket is supplied, return any human age
        return self::any();
    }
  }

  /**
   * 1 – 12 years
   */
  public static function children() : int {
    return rand(1, 12);
  }

  /**
   * 13 – 19 years
   */
  public static function teenager() : int {
    return rand(13, 19);
  }

  /**
   * 20 – 35 years
   */
  public static function youth() : int {
    return rand(20, 35);
  }

  /**
   * 36 – 60 years
   */
  public static function adult() : int {
    return rand(36, 60);
  }

  /**
   * 61 – 100 years
   */
  public static function senior() : int {
    return rand(61, 100);
  }

  /**
   * Any reasonable human age
   */
  public static function any() : int {
    return rand(1, 100);
  }

}
