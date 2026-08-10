<?php

namespace spoova\mi\core\classes\Fabricator;

use ErrorException;

class FabricateColor implements FabricatorInterface {
  
  /**
   * Fabricate color
   *
   * @param string $type Optional. [primary|secondary|CSS]|[ART|RGB]
   *  - primary: basic colors (ART: white, black | RGB: red, green, blue)
   *  - secondary: secondary colors (ART: green, orange, purple | RGB: cyan, magenta, yellow)
   *  - CSS: full list of CSS color names
   *  - Note that parameter format is "class|option", where class is primary or secondary while option is ART, RGB or CSS.
   * @return string
   */
  public static function fabricate(string $type = 'CSS') : string {
    
    $fb = explode('|', $type, 2);
    $class  = $fb[0] ?? '';
    $option = $fb[1] ?? 'ART';
    
    if(!in_array($option, ['ART','RGB', 'CSS'])){
      throw new ErrorException('invalid option for color');
    }
    
    if($type === 'CSS'){
      $colors = self::css();
    }
    
    if($class === 'primary'){
      $colors = self::primary($option);
    }
    
    if($class === 'secondary'){
      $colors = self::secondary($option);
    }
    if(!isset($colors)){
      throw new ErrorException('invalid options format');
    }
   
    return $colors[array_rand($colors)];
    
  }
  
  private static function primary($option = 'ART') : array {
    if($option === 'ART') return ['white', 'black'];
    if($option === 'RGB') return ['red', 'green', 'blue'];
    return [];
  }
  
  
  private static function secondary($option = 'ART') : array {
    if($option === 'ART') return ['green', 'orange','purple'];
    if($option === 'RGB') return ["cyan","magenta","yellow"];
    return [];
  }
  
  private static function css() : array {
    return [
      "AliceBlue","AntiqueWhite","Aqua","Aquamarine",
      "Azure","Beige","Bisque","Black","BlanchedAlmond",
      "Blue","BlueViolet","Brown","BurlyWood","CadetBlue",
      "Chartreuse","Chocolate","Coral","CornflowerBlue",
      "Cornsilk","Crimson","Cyan","DarkBlue","DarkCyan",
      "DarkGoldenRod","DarkGray","DarkGreen","DarkKhaki",
      "DarkMagenta","DarkOliveGreen","DarkOrange",
      "DarkOrchid","DarkRed","DarkSalmon","DarkSeaGreen",
      "DarkSlateBlue","DarkSlateGray","DarkTurquoise",
      "DarkViolet","DeepPink","DeepSkyBlue","DimGray",
      "DodgerBlue","FireBrick","FloralWhite","ForestGreen",
      "Fuchsia","Gainsboro","GhostWhite","Gold","GoldenRod",
      "Gray","Green","GreenYellow","HoneyDew","HotPink",
      "IndianRed","Indigo","Ivory","Khaki","Lavender",
      "LavenderBlush","LawnGreen","LemonChiffon",
      "LightBlue","LightCoral","LightCyan",
      "LightGoldenRodYellow","LightGray","LightGreen",
      "LightPink","LightSalmon","LightSeaGreen",
      "LightSkyBlue","LightSlateGray","LightSteelBlue",
      "LightYellow","Lime","LimeGreen","Linen",
      "Magenta","Maroon","MediumAquaMarine","MediumBlue",
      "MediumOrchid","MediumPurple","MediumSeaGreen",
      "MediumSlateBlue","MediumSpringGreen",
      "MediumTurquoise","MediumVioletRed",
      "MidnightBlue","MintCream","MistyRose",
      "Moccasin","NavajoWhite","Navy","OldLace","Olive",
      "OliveDrab","Orange","OrangeRed","Orchid",
      "PaleGoldenRod","PaleGreen","PaleTurquoise",
      "PaleVioletRed","PapayaWhip","PeachPuff",
      "Peru","Pink","Plum","PowderBlue","Purple",
      "RebeccaPurple","Red","RosyBrown","RoyalBlue",
      "SaddleBrown","Salmon","SandyBrown","SeaGreen",
      "Seashell","Sienna","Silver","SkyBlue","SlateBlue",
      "SlateGray","Snow","SpringGreen","SteelBlue",
      "Tan","Teal","Thistle","Tomato","Turquoise",
      "Violet","Wheat","White","WhiteSmoke","Yellow",
      "YellowGreen"
    ];
  }
  
}