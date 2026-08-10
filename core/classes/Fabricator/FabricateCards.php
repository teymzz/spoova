<?php

namespace spoova\mi\core\classes\Fabricator;

use InvalidArgumentException;

class FabricateCards implements FabricatorInterface {
  
  /**
   * @param string $name uses a specific name optional [love|spade|diamond|brothers|king|queen|junior|joker]
   * @param int $number of the card to be fabricated.
   * 
   * @return string
   */
  public static function fabricate(string $name = '', ?int $number = null) {
    
    if(!method_exists(get_called_class(), $name)){
      throw new InvalidArgumentException('invalid option supplied');
    }
    return self::$name($number);
  
  }
  
  public static function spade(?int $index = null){
    
    $cards =  [
      "0" => "♠",
      "1" => "🂡",
      "2" => "🂢",
      "3" => "🂣",
      "4" => "🂤",
      "5" => "🂥",
      "6" => "🂦",
      "7" => "🂧",
      "8" => "🂨",
      "9" => "🂩",
      "10" => "🂪",
      "J" => "🂫",
      "C" => "🂬",
      "Q" => "🂭",
      "K" => "🂮",
    ];
    
    if($index === null){
      return $cards[array_rand($cards)];
    }else{
      return $cards[$index] ?? '';
    }
    
  }
  
  public static function love(?int $index = null){
    
    $cards = [
      "0" => "♥",
      "1" => "🂱",
      "2" => "🂲",
      "3" => "🂳",
      "4" => "🂴",
      "5" => "🂵",
      "6" => "🂶",
      "7" => "🂷",
      "8" => "🂸",
      "9" => "🂹",
      "10" => "🂺",
      "J" => "🂻",
      "C" => "🂼",
      "Q" => "🂽",
      "K" => "🂾",
    ];
    
    if($index === null){
      return $cards[array_rand($cards)];
    }else{
      return $cards[$index] ?? '';
    }
    
  }
  
  public static function diamond(?int $index = null){
    
    $cards = [
      "0" => "♦",
      "1" => "🃁",
      "2" => "🃂",
      "3" => "🃃",
      "4" => "🃄",
      "5" => "🃅",
      "6" => "🃆",
      "7" => "🃇",
      "8" => "🃈",
      "9" => "🃉",
      "10" => "🃊",
      "J" => "🃋",
      "C" => "🃌",
      "Q" => "🃍",
      "K" => "🃎",
    ];
    
    if($index === null){
      return $cards[array_rand($cards)];
    }else{
      return $cards[$index] ?? '';
    }
    
  }
  
  public static function brothers(?int $index = null){
    
    $cards = [
      "0" => "♣",
      "1" => "🃑",
      "2" => "🃒",
      "3" => "🃓",
      "4" => "🃔",
      "5" => "🃕",
      "6" => "🃖",
      "7" => "🃗",
      "8" => "🃘",
      "9" => "🃙",
      "10" => "🃚",
      "J" => "🃛",
      "C" => "🃜",
      "Q" => "🃝",
      "K" => "🃞",
    ];
    
    if($index === null){
      return $cards[array_rand($cards)];
    }else{
      return $cards[$index] ?? '';
    }
    
  }

  public static function kings(){
    $cards = [
      "K" => "🂮",
      "K" => "🂾",
      "K" => "🃎",
      "K" => "🃞"
    ];
    return $cards[array_rand($cards)];
  }

  public static function queens(){
    $cards = [
      "Q" => "🂭",
      "Q" => "🂽",
      "Q" => "🃍",
      "Q" => "🃝"
    ];
    return $cards[array_rand($cards)];
  }

  public static function junior(){
    $cards = [
      "J" => "🂫",
      "J" => "🂻",
      "J" => "🃋",
      "J" => "🃛"
    ];
    return $cards[array_rand($cards)];
  }


  
  public static function joker(string|int|null $index = null){
    
    $cards = ["🃏", "🃟"];
    
    if($index === null){
      return $cards[array_rand($cards)];
    }else{
      return $cards[$index] ?? '';
    }
    
  }
}