<?php

namespace spoova\mi\core\classes\Fabricator;

use ErrorException;

class FabricateIcon implements FabricatorInterface {
  
  /**
   * @param string $name uses a specific name
   *
   * @param string $filter filter name of the icon to fabricate. Options include:
   *  - emojiTime
   *  - emojiFace
   *  - emojiAnimal
   *  - emojiFruit
   *  - emojiFingers
   *  - emojiHand
   *  - transport
   *  - circled : returns circuled dingbat numbers from 1-10 only (e.g ➀, ➁...)
   *  - dice : displays different sides of a dice
   * @param string $name relative option for filtered icon determining the icon design format return. 
   *  - emojiTime: [1:00,1:30,2:00,...,12:30]
   *  - emojiFace: [neutral,tough,down,blushing,kisses,kiss,blushing-kiss,mockery,furious,angry,worried,crying,fearful,frightened,weary,tears,unbelievable,surprised,ghost-fright,smile,dry,mute,greedy,glasses,thinking,injured,peaceful,hat,joking,sneeze,doubtful,shutup,astounding,amazing,delight,much-love,yawn,party,drilled,frozen,search,sick,undermine,wink,frivolous,sleeping,emotional,touchy,joyous,laughing,funny,lol]
   *  - emojiAnimal: [monkey,grasshopper,fly,mosquito,scorpion,antelope,camel,red-bug,bee,cockroach,spider,ant,butterfly,snail,octopus,dolphin,whale,fish,shark,duck,wallgecko,tortoise,crocodile,parrot,duck,eagle,penguin,turkey,cock,bird,rhinosos,rabbit,squirrel,rat,bull,horse,dog,elephant,bird,dove,owl,vulture,sheep,pig,bear,worm,crab,prawn]
   *  - emojiFruit: [apple,banana,orange,grape,watermelon,lemon,lime,pineapple,mango,peach,pear,cherry,strawberry,blueberry,raspberry,blackberry]
   *  - emojiFingers: [thumb-up,thumb-down,fist-bump,fist-down,palm-up,palm-down,finger-gesture]
   *  - emojiHand: [wave-hand,clap-hands,hands-up,salute-hand]
   *  - transport: [car,bus,truck,bicycle,motorcycle,airplane,ship]
   *  - circled : returns circuled dingbat numbers from 1-10 only (e.g ➀, ➁...)
   *  - dice : Numerical words or digits from 1 to 9. For example argument 1 or one shows a dice with side one. 
   * @return string
   */
  public static function fabricate(?string $filter = null, ?string $name = null) : string {
    
    $filter = explode('|',$filter);
    $class = $filter[0] ?? '';
    $type = $filter[1] ?? '';
    
    if($class === 'emoji'){
      $class .= ucfirst($type);
    }else{
      $class = strtolower($class);
    }
    
    if( method_exists(get_called_class(), $name) ) {
      
      return self::$class($name);
      
    }
    return '';
  }
  
  public static function emojiTime(?string $time = null){
    
    $times = [
      "1:00" => "🕐",
      "1:30" => "🕜",
      "2:00" => "🕑",
      "2:30" => "🕝",
      "3:00" => "🕒",
      "3:30" => "🕞",
      "4:00" => "🕓",
      "4:30" => "🕟",
      "5:00" => "🕔",
      "5:30" => "🕠",
      "6:00" => "🕕",
      "6:30" => "🕡",
      "7:00" => "🕖",
      "7:30" => "🕢",
      "8:00" => "🕗",
      "8:30" => "🕣",
      "9:00" => "🕘",
      "9:30" => "🕤",
      "10:00" => "🕙",
      "10:30" => "🕥",
      "11:00" => "🕚",
      "11:30" => "🕦",
      "12:00" => "🕛",
      "12:30" => "🕧",
    ];
    
    if($time === null) return $times[array_rand($times)];
    if(isset($times[$time])){
      return $times[$time];
    } else {
      throw new ErrorException('invalid emoji time option supplied');
    }
  }
  
  public static function emojiFace(?string $name = null){
    
    $faces = [
      "neutral" => "😑",
      "tough" => "😓",
      "down" => "😔",
      "blushing" => "😚",
      "kisses" => "😘",
      "kiss" => "😙",
      "blushing-kiss" => "😚",
      "mockery" => "😜",
      "furious" => "😡",
      "angry" => "😠",
      "worried" => "😟",
      "crying" => "😢",
      "fearful" => "😨",
      "frightened" => "😨",
      "weary" => "😩",
      "tears" => "😭",
      "unbelievable" => "😲",
      "surprised" => "😳",
      "ghost-fright" => "😱",
      "smile" => "🙂",
      "dry" => "🙄",
      "mute" => "🤐",
      "greedy" => "🤑",
      "glasses" => "🤓",
      "thinking" => "🤔",
      "injured" => "🤕",
      "peaceful" => "🤗",
      "hat" => "🤠",
      "joking" => "🤤",
      "sneeze" => "🤧",
      "doubtful" => "🤨",
      "shutup" => "🤫",
      "astounding" => "🤯",
      "amazing" => "🤯",
      "delight" => "🤩",
      "much-love" => "🥰",
      "yawn" => "🥱",
      "party" => "🥳",
      "drilled" => "🥵",
      "frozen" => "🥶",
      "search" => "🧐",
      "sick" => "🤒",
      "undermine" => "😒",
      "wink" => "😉",
      "frivolous" => "🙄",
      "sleeping" => "😴",
      
      "emotional" => "🥺",
      "touchy" => "🥺",
      
      "joyous" => "🥹",
      "laughing" => "🤣",
      "funny" => "😂",
      "lol" => "🤣",
    ];
    
    if($name === null) return $faces[array_rand($faces)];
    
    if(isset($faces[$name])){
      return $faces[$name];
    } else {
      throw new ErrorException('invalid emoji face option supplied');
    }
    
  }
  
  public static function emojiAnimal(?string $name = null){
    
    $animals = [
      "monkey" => "🐒",
      "grasshopper" => "🦗",
      "fly" => "🪰",
      "mosquito" => "🦟",
      "scorpion" => "🦂",
      "antelope" => "🦌",
      "camel" => "🐪",
      "red-bug" => "🐞",
      "bee" => "🐝",
      "cockroach" => "🪳",
      "spider" => "🕷",
      "ant" => "🐜",
      "butterfly" => "🦋",
      "snail" => "🐌",
      "octopus" => "🐙",
      "dolphin" => "🐬",
      "whale" => "🐋",
      "fish" => "🐟",
      "shark" => "🦈",
      "snake" => "🐍",
      "wallgecko" => "🦎",
      "tortoise" => "🐢",
      "crocodile" => "🐊",
      "parrot" => "🦜",
      "duck" => "🪿",
      "eagle" => "🦅",
      "penguin" => "🐧",
      "turkey" => "🦃",
      "cock" => "🐓",
      "bird" => "🐤",
      "rhinosos" => "🦏",
      "rabbit" => "🐇",
      "squirrel" => "🐿",
      "rat" => "🐁",
      "bull" => "🐂",
      "horse" => "🐎",
      "dog" => "🐕",
      "elephant" => "🐘",
      "cockrel" => "🐦",
      "dove" => "🕊️",
      "owl" => "🦉",
      "vulture" => "🦩",
      "sheep" => "🐑",
      "pig" => "?🐷",
      "bear" => "🐻",
      "worm" => "🪱",
      "crab" => "🦀",
      "prawn" => "🦐",
    ];
    
    if($name === null) return $animals[array_rand($animals)];
    
    if(isset($animals[$name])){
      return $animals[$name];
    } else {
      throw new ErrorException('invalid emoji animal option supplied');
    }
    
    
  }
  
  /**
   * Generate a fruit emoji
   *
   * @param string|null $name 
   *  - if no name is supplied, assumes a random fruit name.
   * @return void
   */
  public static function emojiFruit(?string $name = null){
    
    $fruits = [
      "corn" => "🌽",
      "berry" => "🍒",
      "lemonade" => "🍋",
      "banana" => "🍌",
      "pineapple" => "🍍",
      "mango" => "🥭",
      "packham" => "🍐",
      "apple" => "🍏",
      "tomato" => "🍅",
      "cucumber" => "🍆",
      "pear" => "🥑",
      "chilli" => "🌶",
      "coconut" => "🥥",
      "groundnut" => "🥜",
      "onion" => "🧅",
    ];
    
    if($name === null) return $fruits[array_rand($fruits)];
    
    if(isset($fruits[$name])){
      return $fruits[$name];
    } else {
      throw new ErrorException('invalid emoji fruit option supplied');
    }
    
  }

  /**
   * Generate a finger emoji
   *
   * @param string|null $type 
   *  - if no type is supplied, assumes a random finger type.
   *  - options: [one, two, three, five, thumbs-up, thumbs-down, point-left, point-right, point-up, point-down, call, 
   *    point-you, pay].
   * @return void
   */
  public static function emojiFingers(?string $type = null){
    
    $types = [
      "one" => "☝",
      "two" => "✌",
      "three" => "🤟",
      "five" => "🖐",      
      "thumbs-up" => "👍",
      "thumbs-down" => "👎",
      "point-left" => "👈",
      "point-right" => "👉",
      "point-up" => "👆",
      "point-down" => "👇️",
      "call" => "🤙",
      "point-you" => "🫵",
      "pay" => "🫰",
    ];
    
    if($type === null) return $types[array_rand($types)];
    
    if(isset($types[$type])){
      return $types[$type];
    } else {
      throw new ErrorException('invalid emoji finger option supplied');
    }
     
  }
  
  /**
   * Generate a hand emoji
   *
   * @param string|null $type 
   *  - if no name is supplied, assumes a random hand type.
   *  - options: [stop, wave, pray, clap, write, shake, love, knuckle, hold, wait-right, wait-left, give, take, hail, box-left, box-right, plead, beg].
   * @return void
   */
  public static function emojiHand(?string $type = null){
    
    $types = [
      "stop" => "🤚",
      "wave" => "👋",
      "pray" => "🤲",
      "clap" => "👏",    
      "write" => "✍",
      "shake" => "🤝",
      "love" => "🫶",
      "knuckle" => "👊",
      "hold" => "✊",
      "wait-right" => "🫸",
      "wait-left" => "🫷",
      "give" => "🫴",
      "take" => "🫳",
      "hail" => "🙌",
      "box-left" => "🤛",
      "box-right" => "🤜",
      "plead" => "🙏",
      "beg" => "🙏",
    ];    
    
    if($type === null) return $types[array_rand($types)];
    
    if(isset($types[$type])){
      return $types[$type];
    } else {
      throw new ErrorException('invalid emoji hand option supplied');
    }
    
  }
  
  /**
   * Generate a transport emoji
   *
   * @param string|null $type 
   *  - if no type is supplied, assumes a random transport type.
   *  - options: [ferry, boat, truck, plane, train, ambulance, bus, tractor, tricycle, motorbike, ship, airplane, plane-arrival, plane-depature, helicopter].
   * @return void
   */
  public static function transport(?string $type = null){
    
    $transports = [
      "ferry" => "⛴",
      "boat" => "⛵",
      "truck" => "⛟",
      "plane" => "✈",
      "train" => "🚆",
      "ambulance" => "🚑",
      "bus" => "🚌",
      "tractor" => "🚜",
      "tricycle" => "🛺",
      "motorbike" => "🏍️",
      "ship" => "🛳️",
      "airplane" => "✈️",
      "plane-arrival" => "🛬",
      "plane-depature" => "🛫",
      "helicopter" => "🚁",
    ];
    
    if($type === null) return $transports[array_rand($transports)];
    
    if(isset($transports[$type])){
      return $transports[$type];
    } else {
      throw new ErrorException('invalid emoji transport option supplied');
    }
    
  }
  
  /**
   * Returns circuled dingbat numbers from 1-10 only (e.g ➀, ➁...)
   *
   * @param string $number
   *  - options: [one, two, three, four, five, six, seven, eight, nine, ten] or [One, Two, Three, Four, Five, Six, Seven, Eight, Nine, Ten] for different design format.
   * @return void
   */
  public static function circled(string $number){
    
    $numbers = [
      "one" => "➀",
      "two" => "➁",
      "three" => "➂",
      "four" => "➃",
      "five" => "➄",
      "six" => "➅",
      "seven" => "➆",
      "eight" => "➇",
      "nine" => "➈",
      "ten" => "➉",
      
      "One" => "❶",
      "Two" => "❷",
      "Three" => "❸",
      "Four" => "❹",
      "Five" => "❺",
      "Six" => "❻",
      "Seven" => "❼",
      "Eight" => "❽",
      "Nine" => "❾",
      "Ten" => "❿",
    
    ];
    
    if(isset($numbers[$number])){
      return $numbers[$number];
    } else {
      throw new ErrorException('invalid circled emoji option supplied');
    }
    
  }
  
  /**
   * Displays different sides of a dice
   *
   * @param string|null $side Optional. From [1-6] or [one to six]
   *   - if no side is supplied, assumes a random dice side.
   * @return void
   */
  public static function dice(?string $side = null){
   
    $dices = [
      "one" => "⚀",
      "1" => "⚀",
      
      "two" => "⚁",
      "2" => "⚁",
      
      "three" => "⚂",
      "3" => "⚂",
      
      "four" => "⚃",
      "4" => "⚃",
      
      "five" => "⚄",
      "5" => "⚄",
      
      "six" => "⚅",
      "6" => "⚅",
    ];    
    if($side === null) return $dices[array_rand($dices)];
    
    if(isset($dices[$side])){
      return $dices[$side];
    } else {
      throw new ErrorException('invalid emoji dice option supplied');
    }
    
  }
 
}