<?php

namespace spoova\mi\core\classes\Fabricator;

class FabricatePost implements FabricatorInterface {

  /**
   * @param int|string|null $length
   *  - int    : exact character length
   *  - short  : 50–120 chars
   *  - medium : 150–300 chars
   *  - long   : 400–800 chars
   */
  public static function fabricate($length = null) : string {

    if (is_int($length)) {
      return self::byCharacters($length);
    }

    switch (strtolower((string)$length)) {
      case 'short':  return self::short();
      case 'medium': return self::medium();
      case 'long':   return self::long();
      default:       return self::random();
    }
  }

  public static function short() : string {
    return self::byCharacters(rand(50, 120));
  }

  public static function medium() : string {
    return self::byCharacters(rand(150, 300));
  }

  public static function long() : string {
    return self::byCharacters(rand(400, 800));
  }

  public static function random() : string {
    return self::byCharacters(rand(80, 600));
  }

  /**
   * Build a reasonable-looking post
   */
  public static function byCharacters(int $length) : string {

    $post = '';

    while (strlen($post) < $length) {
      $post .= self::sentence() . ' ';
    }

    return trim(substr($post, 0, $length));
  }

  /**
   * Generates a human-like sentence
   */
  private static function sentence() : string {
    $subjects = [
      'This system', 'The framework', 'Our platform', 'The application',
      'This solution', 'The project', 'Our team', 'The design'
    ];

    $verbs = [
      'improves', 'enhances', 'simplifies', 'accelerates',
      'optimizes', 'strengthens', 'supports', 'transforms'
    ];

    $objects = [
      'performance', 'development workflow', 'user experience',
      'scalability', 'security', 'maintainability',
      'system reliability', 'data handling'
    ];

    $extras = [
      'with minimal effort',
      'in a flexible way',
      'for modern applications',
      'without sacrificing quality',
      'using a clean architecture',
      'through smart automation',
      'with better efficiency',
      'for long-term stability'
    ];

    $subject = $subjects[array_rand($subjects)];
    $verb    = $verbs[array_rand($verbs)];
    $object  = $objects[array_rand($objects)];
    $extra   = $extras[array_rand($extras)];

    return ucfirst("{$subject} {$verb} {$object} {$extra}.");
  }

}
