<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricateUnit {

  /**
   * Fabricate a random unit based on type 
   *
   * @param string $type unit category (money, speed, mass, etc)
   *  - Examples: money, mass, area, speed, percentage, calorie, length, volume, power, data, temperature
   * @param string|null $word optional word argument
   *  - Examples (based on type):
   *    - money: dollar, euro, yen, naira, pound, rupee, ruble, won, bitcoin
   *    - mass: gram, kilogram, milligram, microgram, tonne, quintal, pound, ounce, carat
   *    - area: centimeter-squared, meter-squared, millimeter-squared, hectare, acre, mile-squared, yard-squared, foot-squared, inch-squared, rod-squared
   *    - speed: kilometer-per-second, meter-per-second, mile-per-hour, kilometer-per-hour, speed-of-light, feet-per-second, inches-per-second, kilometer 
   *    - calorie: calorie, kilocalorie 
   *    - length: meter, millimeter, centimeter, inch, foot, yard, mile, kilometer
   *    - volume: milliliter, liter, centiliter, deciliter, hectoliter, meter-cubed, decimeter-cubed, centimeter-cubed, millimeter-cubed, foot-cubed, inch-cubed, yard-cubed, acre-foot 
   *    - power: one, half, one-third, one-quarter, one-eighth, two, two-thirds, three, three-quarters, three-eighths, four, five-eighths, seven-eighths
   *    - data: bit, kilobyte, megabyte, gigabyte, terabyte, petabyte
   *    - temperature: celsius, fahrenheit, kelvin
   * @return string
   */
  public static function fabricate(string $type, ?string $word = null) : string {
    switch (strtolower($type)) {

      case 'money':        return self::money($word);
      case 'mass':         return self::mass($word);
      case 'area':         return self::area($word);
      case 'speed':        return self::speed($word);
      case 'percentage':   return self::percentage();
      case 'calorie':      return self::calorie($word);
      case 'length':       return self::length($word);
      case 'volume':       return self::volume($word);
      case 'power':        return self::power($word);
      case 'data':         return self::data($word);
      case 'temperature':  return self::temperature($word);

      default:
        throw new \InvalidArgumentException("Unknown unit type: {$type}");
    }
  }

  /* Helpers */

  private static function normalize(?string $word) : ?string {
    if (!$word) return null;
    return strtolower(str_replace([' ', '_'], '-', $word));
  }

  private static function pick(array $map, ?string $word ) : string {
    if ($word !== null) {
      $word = self::normalize($word);
      if (isset($map[$word])) {
        return $map[$word];
      }
      throw new \InvalidArgumentException("Unknown unit word: {$word}");
    }

    // Random pick if no word supplied
    return $map[array_rand($map)];
  }

  /**
   * Fabricate money unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: dollar, euro, yen, naira, pound, rupee, ruble, won, bitcoin
   * @return string
   */
  public static function money(?string $word = null) : string {
    $map = [
      'dollar'        => '$',
      'euro'          => '€',
      'yen'           => '¥',
      'naira'         => '₦',
      'pound'         => '£',
      'rupee'         => '₹',
      'ruble'         => '₽',
      'won'           => '₩',
      'bitcoin'       => '₿',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate mass unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: gram, kilogram, milligram, microgram, tonne, quintal, pound, ounce, carat
   * @return string
   */
  public static function mass(?string $word = null) : string {
    $map = [
      'gram'         => 'g',
      'kilogram'     => 'kg',
      'milligram'    => 'mg',
      'microgram'    => 'µg',
      'tonne'        => 'tonne',
      'quintal'      => 'q',
      'pound'        => 'lb',
      'ounce'        => 'oz',
      'carat'        => 'ct',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate area unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: centimeter-squared, meter-squared, millimeter-squared, hectare, acre, mile-squared, yard-squared, foot-squared, inch-squared, rod-squared
   * @return string
   */
  public static function area(?string $word = null) : string {
    $map = [
      'centimeter-squared' => 'cm²',
      'meter-squared'      => 'm²',
      'millimeter-squared' => 'mm²',
      'hectare'            => 'ha',
      'acre'               => 'ac',
      'mile-squared'       => 'mile²',
      'yard-squared'       => 'yd²',
      'foot-squared'       => 'ft²',
      'inch-squared'       => 'in²',
      'rod-squared'        => 'rd²',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate speed unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: kilometer-per-second, meter-per-second, mile-per-hour, kilometer-per-hour, speed-of-light, feet-per-second, inches-per-second, kilometer
   * @return string
   */
  public static function speed(?string $word = null) : string {
    $map = [
      'kilometer-per-second' => 'km/s',
      'meter-per-second'     => 'm/s',
      'mile-per-hour'        => 'mph',
      'kilometer-per-hour'   => 'km/h',
      'speed-of-light'       => 'c',
      'feet-per-second'      => 'fps',
      'inches-per-second'    => 'ips',
      'kilometer'            => 'km', // your example
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate percentage unit
   *
   * @return string
   */
  public static function percentage() : string {
    return '%';
  }

  /**
   * Fabricate calorie unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: calorie, kilocalorie
   * @return string
   */
  public static function calorie(?string $word = null) : string {
    $map = [
      'calorie'        => 'c',
      'kilocalorie'    => 'kcal',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate length unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: meter, millimeter, centimeter, inch, foot, yard, mile, kilometer
   * @return string
   */
  public static function length(?string $word = null) : string {
    $map = [
      'meter'       => 'm',
      'millimeter'  => 'mm',
      'centimeter'  => 'cm',
      'inch'        => 'in',
      'foot'        => 'ft',
      'yard'        => 'yd',
      'mile'        => 'mile',
      'kilometer'  => 'km',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate volume unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: milliliter, liter, centiliter, deciliter, hectoliter, meter-cubed, decimeter-cubed, centimeter-cubed, millimeter-cubed, foot-cubed, inch-cubed, yard-cubed, acre-foot
   * @return string
   */
  public static function volume(?string $word = null) : string {
    $map = [
      'milliliter'  => 'ml',
      'liter'       => 'l',
      'centiliter'  => 'cl',
      'deciliter'   => 'dl',
      'hectoliter'  => 'hl',
      'meter-cubed' => 'm³',
      'decimeter-cubed' => 'dm³',
      'centimeter-cubed' => 'cm³',
      'millimeter-cubed' => 'mm³',
      'foot-cubed'  => 'ft³',
      'inch-cubed'  => 'in³',
      'yard-cubed'  => 'yd³',
      'acre-foot'   => 'af³',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate power unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: one, half, one-third, one-quarter, one-eighth, two, two-thirds, three, three-quarters, three-eighths, four, five-eighths, seven-eighths
   * @return string
   */
  public static function power(?string $word = null) : string {
    $map = [
      'one'          => '¹',
      'half'         => '½',
      'one-third'    => '⅓',
      'one-quarter'  => '¼',
      'one-eighth'   => '⅛',
      'two'          => '²',
      'two-thirds'   => '⅔',
      'three'        => '³',
      'three-quarters' => '¾',
      'three-eighths'  => '⅜',
      'four'         => '⁴',
      'five-eighths' => '⅝',
      'seven-eighths'=> '⅞',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate data unit
   *
   * @param string|null $word optional word argument 
   *  - Examples: bit, kilobyte, megabyte, gigabyte, terabyte, petabyte
   * @return string
   */
  public static function data(?string $word = null) : string {
    $map = [
      'bit'        => 'b',
      'kilobyte'   => 'kb',
      'megabyte'   => 'mb',
      'gigabyte'   => 'gb',
      'terabyte'   => 'tb',
      'petabyte'   => 'pb',
    ];
    return self::pick($map, $word);
  }

  /**
   * Fabricate calorie unit
   *
   * @param string|null $word optional word argument 
   *  - options: celsius, fahrenheit, kelvin
   * @return string
   */
  public static function temperature(?string $word = null) : string {
    $map = [
      'celsius'    => '°C',
      'fahrenheit' => '°F',
      'kelvin'     => 'K',
    ];
    return self::pick($map, $word);
  }

}