<?php

namespace spoova\mi\core\classes\Fabricator;

use ErrorException;
use InvalidArgumentException;

class FabricateSymbol implements FabricatorInterface {
  
  /**
   * @param string $filter uses a specific name
   */
  public static function fabricate(?string $filter = '') : string {
    
    return '';
    
  }
  
  public static function math(string $name){
    
    $names = [
      "percent" => "%",
      "ampersand" => "&",
      "hash" => "#",
      "at" => "@",
      "aterisk" => "*",
      "plus" => "+",
      "minus" => "-",
      "divide" => "÷",
      "multiply" => "×",
      "approximate" => "~",
      "caret" => "^",
      "sigma" => "∑",
      "delta" => "∆",
      "pi" => "π",
      "intersect" => "⋂",
      "union" => "⋃",
      "micro" => "μ",
      "degree" => "°",
      "lambda" => "λ",
      "not-subset" => "⊄",
      "proper-subset" => "⊂",
      "superset" => "⊇",
      "not-superset" => "⊅",
      "empty-set" => "Ø",
      "implies" => "⇒",
      "factorial" => "!",
      "therefore" => "∴",
      "because" => "∵",
      "epsilon" => "ε",
      "integral" => "∫",
      "closed-contour" => "∮",
      "closed-surface" => "∯",
      "closed-volume" => "∰",
      "bullet" => "∙",
      "root" => "√",
      "per-mile" => "‰",
      "perpendicular" => "⊥",
      "angle" => "∠",
      "right-angle" => "∟",
      "parallel" => "∥",
      "cogruent-to" => "≅",
      "infinity" => "∞",
      "laquo" => "«",
      "raquo" => "»",
      "frac1" => "¹",
      "frac12" => "½",
      "frac13" => "⅓",
      "frac14" => "¼",
      "frac18" => "⅛",
      "frac2" => "²",
      "frac23" => "⅔",
      "frac3" => "³",
      "frac34" => "¾",
      "frac38" => "⅜",
      "frac4" => "⁴",
      "frac58" => "⅝",
      "frac78" => "⅞",
      "prime" => "¯",
      //"prime" => "ª",
      "plus-minus" => "±",
      
    ];

    if(!isset($names[$name])){
      throw new InvalidArgumentException('invalid option supplied for math symbol');
    }

    return $names[$name];
    
  }
  
  public static function trademark(){
    
    return [
      "copyright" => "©",
      "original" => "®",
      "trademark" => "™",
      "sound-copyright" => "℗",
    ];
    
  }
  
  public static function gender(){
    
    return [
      "male" => "♂",
      "female" => "♀",
      "both" => "⚥",
    ];
    
  }
  
  /**
   * Generate zodiac symbol
   * @param string $name uses a specific name
   *  - options [aries, tauraus, gemini, cancer, leo, virgio, libra, scorpious, sagittarious, capricon, aquarius, pisces and opichius]
   *  - if no option is supplied, it will return a random zodiac symbol
   * @return string
   */
  public static function zodiac(?string $name = null){
    
    $zodiacs = [
      "aries" => "♈",
      "tauraus" => "♉",
      "gemini" => "♊",
      "cancer" => "♋",
      "leo" => "♌",
      "virgio" => "♍",
      "libra" => "♎",
      "scorpious" => "♏",
      "sagittarious" => "♐",
      "capricon" => "♑",
      "aquarius" => "♒",
      "pisces" => "♓",
      "opichius" => "⛎",
    ];

    if($name === null){
      return $zodiacs[array_rand($zodiacs)];
    }else{
      if(!isset($zodiacs[$name])){
        throw new InvalidArgumentException('invalid option supplied for zodiac name');
      }
      return $zodiacs[$name];
    }
    
  }
  
  /**
   * Generate greek alphabet symbol
   * @param string $letter uses a specific name
   *  - options for small case [alpha, beta, gamma, delta, epsilon, zeta, eta, theta, iota, kappa, lambda, mu, nu, xi, omicron, pi, rho, sigma, tau, upsilon, phi, chi, psi and omega]
   *  - options for capital case [ALPHA, BETA, GAMMA, DELTA, EPSILON, ZETA, ETA, THETA, IOTA, KAPPA, LAMBDA, MU, NU, XI, OMICRON, PI, RHO, SIGMA, TAU, UPSILON, PHI, CHI, PSI and OMEGA]
   *  - if no option is supplied, it will return a random greek alphabet symbol
   * @return string
   */
  public static function greek(string $letter){
    
    $letters = [
      "alpha" => "α",
      "beta" => "β",
      "gamma" => "γ",
      "delta" => "δ",
      "epsilon" => "ε",
      "zeta" => "ζ",
      "eta" => "η",
      "theta" => "θ",
      "iota" => "ι",
      "kappa" => "κ",
      "lambda" => "λ",
      "mu" => "μ",
      "nu" => "ν",
      "xi" => "ξ",
      "omicron" => "ο",
      "pi" => "π",
      "rho" => "ρ",
      "sigma" => "σ",
      "tau" => "τ",
      "upsilon" => "υ",
      "phi" => "φ",
      "chi" => "χ",
      "psi" => "ψ",
      "omega" => "ω",
      
      "Alpha" => "Α",
      "Beta" => "Β",
      "Gamma" => "Γ",
      "Delta" => "Δ",
      "Epsilon" => "Ε",
      "Zeta" => "Ζ",
      "Eta" => "Η",
      "Theta" => "Θ",
      "Iota" => "Ι",
      "Kappa" => "Κ",
      "Lambda" => "Λ",
      "Mu" => "Μ",
      "Nu" => "Ν",
      "Xi" => "Ξ",
      "Omicron" => "Ο",
      "Pi" => "Π",
      "Rho" => "Ρ",
      "Sigma" => "Σ",
      "Tau" => "Τ",
      "Upsilon" => "Υ",
      "Phi" => "Φ",
      "Chi" => "Χ",
      "Psi" => "Ψ",
      "Omega" => "Ω",
    ];

    //get the uppercase letter
    if($letter === strtoupper($letter)){
      $letter = ucfirst(strtolower($letter)); //convert to accepted format
    }

    if(!array_key_exists($letter, $letters)){
      
      throw new InvalidArgumentException('invalid option supplied for greek alphabet name');
      
    }

    return $letters[$letter];
    
  }
 
}