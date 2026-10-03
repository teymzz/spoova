<?php 

namespace spoova\mi\core\commands\Root\Cli\CliEmos;

use Closure;
use spoova\mi\core\commands\Root\Cli;

abstract class CliEmos {

    private static array $emods = [];
    
    public const emos = [

        /* starred */
        'point-list'=> '►  ',
        'point-list2'=> '▶  ', //different from top
        'list-right'=> '▶  ',
        'list-down'=> '▼  ',
        'fish-eye'=> '◉  ',
        'radio'=> '●  ',
        'bullet'=> '•  ',
        'bullet-square'=> '▪  ',
        'bullet-insquare'=> '▣  ',
        'bullet-right'=> '▸  ',
        'point-right'=> ' →  ',
        'degrees'=> '°  ',
        'circle'=> '∘  ',
        'lens'=> '⌕  ',
        'ellipses'=> '⋯  ',
        'therefore'=> '∴  ',
        'raquo'=> '»  ',
        'laquo'=> '«  ',
        'block'=> '█  ',
        'colon'=> ':  ',
        'pipe'=> '|  ',
        'infinity'=> '∞  ',
        'minilist-right'=> '▸  ',
        'pointer'   => '☞  ',  
        'link'      => '☍  ', 
        'linkb'     => '⚯  ',
        'checkmark' => '✔  ',
        'crossmark' => '✘  ',
        'times' => 'x  ',
        'times-big' => 'X  ',
        'hot'       => '♨  ',
        'capture'   => '⛶  ',
        'flagb'     => '⛿  ',
        'umbrella'  => '☂  ',
        'plane'     => '✈  ',
        'cloud'     => '☁  ',
        'sun'       => '☀  ',
        'cut'       => '✀  ',
        'close'     => '⮿  ', 
        'envelope'  => '✉  ', 
        'share'     => '➦  ', 
        'view'      => '➥  ', 
        'checkbox'  => '☑  ', 
        'timesbox'  => '☒  ', 
        'clock'     => '◷  ', 

        /* marked */
        'flash'     => '⭍  ',
        'yin-yang'  => '☯  ',
        'diamond'   => '◈  ',        
        'eye'       => '◉  ',
        'ribbon-arrow' => '⮱  ',   
        'light-arrow' => '⌁  ',   
        'infinite-arrow' => '↝  ',   
        'xs-arrow' => '⥂  ',   
        'barb-arrow' => '⥊  ',   
        'bullet-arrow' => '⥤  ',   
    ]; 
    

    /**
     * One of the three emo methods. This is more flexible in supporting custom spaces for each of the sides (i.e left and right) of the 
     * supported character icon specified.
     *
     * @param string $name special character name
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     * 
     */
    public static function emo(string $name, string|array|int $spacing = '0|0'){
        $spaces = Cli::toBreaks($spacing);
        $emo = trim(self::emos($name, ...$spaces),' ');
        $emo = str_repeat(' ', $spaces[0]).$emo.str_repeat(' ', $spaces[1]);
        return $emo;
    }


    /**
     * One of the three "emo" methods. Spaces added are applied to both left and right sides
     * of character in equal numbers
     *
     * @param string $name special character name
     * @return string $space number of spaces to add to both left and right side of character
     * 
     * @notice: A space of zero(0) removes the all spaces
     * @uses Cli::emo()
     */
    public static function emox(string $name, int $space = 2){
        $emo = self::emo($name);
        return Cli::emo($emo,$space.'|'.$space);
    }

    /**
     * The basic emo method. The special characters have been prefixed to two spaces. 
     *  - Warning: spaces defined are rendered to fit charater animations. Hence may be 
     *    upredictable. In order to be specific with spaces, use {@see Cli::emo()} method instead.
     *
     * @param string $name special character icon's name from
     * @param integer $indent number of indents (or spaces) at both sides of icon
     *  - A space of zero(0) removes the all spaces
     * @param string $color output color of character icon.
     *  - Warning: colors within Cli color (e.g color, danger, alert, ...) methods are not supported and will render bad
     * @return string
     * @uses Cli::color()
     */
    public static function emos(string $name, int $indent = 2, string $color = ''){
        if(!isset(self::emos[$name])){
            return Cli::color(self::emos['crossmark'], $color)."invalid character name \"{$name}\" ".PHP_EOL.PHP_EOL;
        }
        
        //check emoticon display ability
        $icon = self::emos[$name];
        $icox = false;
        if(!iconv_strlen($icon, 'UTF-8') === 1){
            //check from the list of defaults defined 
            foreach(self::$emods as $emod){
                if(!iconv_strlen($icon, 'UTF-8') === 1){
                    $icox= true;
                    break;
                }
            }

            if($icox === true){
                $emo = $icox;
            }else{
                $emo = "~";
            }
        }

        $emo = self::emos[$name];

        if(func_num_args() > 1){
            if($indent == 0){
                $emo = substr($emo, 0, (strlen($emo) - 2 ));
            }
            elseif($indent == 1){
                $emo = substr($emo, 0, (strlen($emo) - 1 ));
            }elseif($indent > 2){
                $emo =  substr($emo, 0, (strlen($emo) - ($indent - 2) ));
            }
        }
        return $color? Cli::color($emo, $color) : $emo;
    }

    /**
     * Set a list of default icons in case the terminal does not support unicode characters. 
     * The Cli::emo() method must be used within the callback function. 
     *  - Note that if all unicode characters fails, the default character set is "~" without the quotes.
     *
     * @param array $emos default replacement emoticon name lists
     * @param Closure $emo apply Cli::emo() or its related method within the callback
     * @return string
     * 
     */
    public static function emods(array $emos = ["~"], ?Closure $emo = null) : string {
        self::$emods = $emos;
        $emo = $emo();
        self::$emods = [];
        return $emo;
    }
}