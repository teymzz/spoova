<?php

namespace spoova\mi\core\commands\Root;

use Error;
use Closure;
use stdClass;
use Exception;
use LengthException;
use ReflectionFunction;
use ReflectionNamedType;
use InvalidArgumentException;
use spoova\mi\core\classes\Debug;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\classes\ErrorHandlers\HandleCliErrors;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\commands\Root\Cli\CliDev;
use spoova\mi\core\commands\Root\Cli\CliKey;
use spoova\mi\core\commands\Root\Cli\CliColor;
use spoova\mi\core\commands\Root\Cli\CliInput;
use spoova\mi\core\commands\Root\Cli\CliList;
use spoova\mi\core\commands\Root\Cli\CliCast;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Cli\CliPercent;
use spoova\mi\core\commands\Root\Cli\CliPlay;
use spoova\mi\core\commands\Root\Cli\Enums\AnimeList;
use spoova\mi\core\commands\Root\Cli\CliQuery;
use spoova\mi\core\commands\Root\Cli\CliPrompter;

declare(ticks=1); // Ensures signal handling in loops

/**
 * Animation class for cli
 * @todo resolve mapTo() to work properly
 */
class Cli 
{

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

    private static array $emods = [];
    private static bool $animeResolved = false;
    private static bool $header_mode = false;
    private static ?Cli $instance = null;
    private static bool $hideCursor = false;
    private static bool $hiddenCursor = false;
    private static string|false|null $reader_state = null;

    private static bool $getMove = false; 

    private static bool|null $truecolor = null; 
    private static ?string $colormode = null; 

    /**
     * Used to determine color wrappers
     *
     * @var boolean
     */
    private static bool $colorStart = false;

    private static array $colors = [
        'black'  => '0',
        'red'    => '1',
        'green'  => '2',
        'yellow' => '3',
        'blue'   => '4',
        'purple' => '5',
        'cyan'   => '6',
        'ash'    => '7',
        'white'  => '7',
        'hidden' => '8',
    ];

    private const colormap = [
        'warn'=>'darkmoon','alert'=>'blue','danger'=>'red','valid'=>'green','success'=>'green','error'=>'red'
    ];

    private static array $colorInt = [
         0 => 'black',
         1 => 'white',
         2 => 'alert',
         3 => 'warn',
         4 => 'valid',
         5 => 'danger',
    ];

    private static array $textStyles = [
        'thick'  => '1', 
        'light'  => '2',
        'italic' => '3',
        'underline' => '4',
        'inverse' => '7',
        'bgcolor' => '8', //hidden
        'strike' => '9', 
    ];

    /**
     * Tracked text style to be used
     *
     * @var bool
     */
    private static bool $isStyle = false;

    private static string $anime = 'normal'; 
    private static array $animes = [
        'normal' => ['/', '-', '\\'], /* 10000 - 500000 */
        'dotted' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'dotmin' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'dotmax' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'roller' => ['/', '-', '\\'], /* 10000 - 500000 */ 
        'arrows' => ['>', ' ','>>', ' ', '>>>', ' '], /* 10000 - 500000 */ 
        'forward' => ['⟩','⟫','⟩', '⟫'], /* 10000 - 500000 */ 
        'timer'  => ['◴', '◷','◶', '◵'],
        'circle' => ['◜','◝','◞','◟'], /* 40000 - 50000 */
        'angles' => ['◣','◤','◥','◢'],
        'steps' => ['☰','☱','☲','☴'],
        'braill' => ['⠿','⠷','⠯','⠟', '⠻', '⠽', '⠾'],
        'percent' => '',
    ]; 
    private static AnimeList $animeList = AnimeList::Yield; //specifies when animeList type is used.
    
    /** @var boolean specifies when runAnime fails. */
    private static bool $animeFails = false; 
    
    /** 
     * @var boolean specifies when runAnime should run in clean mode 
     * which hides default errors and allows users to always display 
     * custom messages after runAnime fails. 
     */
    private static bool $animeClean = false; 
    
    /** @var string specifies where runAnime fails. Options [load|percent|chars] */
    private static string $animeState = '';

    /** @var array $animeInfo contains default and clean animation response error text*/
    private static array $animeInfo = [];

    /**
     * total number of animated plays (generator).
     *
     * @var integer
     */
    private static int $animeListYields = 0; //

    /**
     * total number of expected loading characters.
     *
     * @var integer
     */
    private static int $animeListLength = 10;

    private static array $spchars = [
        'timer','forward','circle','angles','steps','braill'
    ];

    private static int $loadTime = 60000;

    private static string $text = '';
    private static string $textView = '';
    private static string $textPlay = '';
    private static string $pulseText = '';
    private static array $pulse = [];

    private static array $prompt = [];
    private static int $ipromptCounter = 0;
    private static array $q = [];

    private static array $storage = [];

    /**
     * Animation loader type
     *
     * @param string $anime [normal|percent|dotted|dotbar|roller|arrows|timer|circle|angles|steps|braill]
     * @param string $char default character for percentages
     * @return Cli
     */
    static function animeType($anime = 'normal', $char = '') :  Cli {
        if(array_key_exists($anime, self::$animes)){
            self::$anime = $anime;
            if($anime === 'percent'){
                self::$animes['percent'] = ['subject'=>self::$textView, 'char'=>$char];
            }
        }
        return self::instance();
    }

    /**
     * Display a list of items on the CLI
     * @return void
     */
    static function console(array|string $view, $label = '»', bool|Closure $exit = false) : void {

        $label .= ' ';

        if(is_string($view)) $view = [$view];

        foreach($view as $item){
            self::textPlain(Cli::alert($label));
            print_r($item);
            print_r(PHP_EOL.PHP_EOL);
        }

        if($exit) {
            if($exit instanceof Closure) $exit();
            exit;
        }
    }

    /**
     * Animate a character or number using percentage increase
     *
     * @param string $textView text to be printed before animation  
     * @param string $char character to be animated (e.g text, background-color)
     * @param Closure|null $modifier a callback function for modifying character during animation
     * @return Cli
     */
    static function percent($textView = '', string $char = '', ?Closure $modifier = null) : Cli{
        self::$textView = $textView;
        self::animeType('percent', $char);
        if($modifier) self::$animes['percent']['mod'] = $modifier;
        return self::instance();
    }

    /**
     * Alias for {@see Cli::runAnime()}
     *  - Class methods must be set as public to make it callable
     *  - Yielding FALSE denotes that an error has occured and animation closed
     *  - Yielding TRUE denotes that an all processes have been completed an animation ended
     *  - Note that this method is designed to automatically add two line breaks before returning final response.
     *
     * @param array|string $function 
     * @param array|string $final_callback
     * @return bool
     *  - FALSE is returned if animation stopped while TRUE is returned if animation completed successfully
     */
    static function anime(array|string $function, $final_callback = []) {

        $response = (new self)->animeLoad(true, $function, $final_callback);

        Cli::break(1);

        return $response;

    }
    /**
     * method to run progressbar
     *  - Class methods must be set as public to make it callable
     *  - Yielding FALSE denotes that an error has occured and animation closed
     *  - Yielding TRUE denotes that an all processes have been completed an animation ended
     *  - Note that this method is designed to automatically add line breaks before returning final response.
     *
     * @param array|string $function 
     * @param array|string $final_callback
     * @return bool
     *  - FALSE is returned if animation stopped while TRUE is returned if animation completed successfully
     */
    static function runAnime(array|string $function, $final_callback = []) {
        HandleCliErrors::consoleErrors(false, true); // reset consoler display flag for every usage
        self::$animeFails = false;
        $response = (new self)->animeLoad(true, $function, $final_callback);

        if(self::animeFails($state) && $state === 'animeLoad'){
            $caller = '';
            if((count($function) === 2) && is_object($function[0])){
                $caller = [$function[0], $function[1]];
            }elseif(is_array($function[0]) && (count($function[0]) === 2) && is_object($function[0][0])){
                $caller = $function[0];
            } 
            if($caller && !method_exists($caller[0], $caller[1])){
               $text = Cli::error('command "'.$caller[1].'" not recognized on '.basename(to_frontslash(get_class($caller[0]))).'.');
               $textDefault = Cli::textBuild(Cli::error('command "'.Cli::warn($caller[1]).'" not recognized on '.Cli::alert(basename(to_frontslash(get_class($caller[0])))).'.'), break: '|1');
            }else{
               $text = Cli::error('cannot process "'.$caller[1].'" command on '.basename(to_frontslash(get_class($caller[0]))).'.');
               $textDefault = Cli::textBuild(Cli::error('cannot process "'.Cli::warn($caller[1]).'" command on '.Cli::alert(basename(to_frontslash(get_class($caller[0])))).'.'), break: '|1');
            }
            self::$animeInfo['default'] = $textDefault;
            self::$animeInfo['basic'] = $text;
            if(self::$animeClean){
                Cli::textView(self::$animes['normal']);
            }
        }
        
        if(Cli::isSilent(true)) Cli::break(1);

        if($response) self::$animeResolved = true;

        return $response;

    }

    public static function animeResolved() : bool {
        return self::$animeResolved;
    }

    /**
     * Yields from a specified value.
     *
     * @param array $arg value to yield from
     * @return void
     */
    static function yield($arg = []){
        yield from $arg;
    }

    /**
     * Executes runAnime in clean (no-error-display) mode allowing users 
     * to customize error messages or use the default one retrievable through the animeInfo method.
     *
     * @param closure $callback
     * @return mixed
     */
    static function cleanAnime(closure $callback){
        self::$animeClean = true;
        $response = $callback();
        self::$animeClean = false;
        return $response;
    }

    /**
     * Determines when a {@see Cli::runAnime()} animation fails to initialize
     *
     * @param string $state references the state when animation fails which can be 'animeLoadPercent' or 'animeLoadChars' 
     * depending on the animation applied.
     * @return void
     */
    static function animeFails(?string &$state = null) {
        $state = self::$animeState;
        return self::$animeFails;
    }

    /**
     * Retrieves animation info
     * @param string $type optional [default|basic|clean]
     *  - default : display with default predefined colors 
     *  - clean : display as a clean text
     * @return string
     */
    static function animeInfo($type = 'default') : string {
        $animeInfo = self::$animeInfo[$type] ?? self::$animeInfo['basic'] ?? '';
        if($type === 'clean'){
            $animeInfo = preg_replace('~\033\[[0-9;]*[A-Za-z]~', "", $animeInfo);
        }
        return $animeInfo;
    }

    /**
     * Display a message to a console or page
     *
     * @param string $message
     * @param integer|array|bool|string $yield
     * @return void
     * 
     * @notice: - when $yield is set as integer, it must not be less than 1.
     *          - ensure to use yield from textYield().
     */
    static function textYield(string $message, $yield = 1, int $pause = 0){
        
        static $count = 0;
        $count++;

        if(is_numeric($yield)){
            if($yield < 1){
                trigger_error('second parameter cannot be an integer that is less than 1');
                return;
            }
            $yield = array_fill(0, ($yield), '');
        }

        $message .= (self::isSpecial())? '' : '';

        print $message;

        yield from $yield;

        if($pause > 0) sleep($pause);
    
    }

    /**
     * Runs only animations (i.e no text) using textYield
     *
     * @param integer|array|bool|string $yield
     * @param integer $pause pause after animation (in seconds)
     * @return void
     * 
     * @notice: - when $yield is set as integer, it must not be less than 1.
     *          - ensure to use yield from animate() 
     */
    static function animate($yield = 1, int $pause = 0){
        
       yield from self::textYield('', $yield, $pause);
    
    }

    /**
     * Sets a text that can be retrieved with {@see Cli::getText()} or {@see Cli::text()} methods
     *
     * @param string $text
     * @return void
     */
    public static function setText(string $text) : void {
        self::$text = $text;
    }

    /**
     * Retrieves a text previously defined with {@see Cli::setText()} method
     *
     * @return string
     */
    public static function getText() : string {
        return self::$text;
    }

    /**
     * Retrieves or Set a text initially defined with {@see Cli::setText()} or  {@see Cli::getText()} method
     *
     * @return string
     */
    public static function text(string|null $text = null) : string {
        if($text !== null) self::setText($text);
        return self::$text;
    }

    /**
     * Designed method for displaying tracked console text
     *
     * @param string $message
     * @param integer $spacing left and right space margins
     *  - When a single integer is supplied, it is assumed to be a right (i.e after) space.  
     *  - Documentation on CLI spacing is available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     * @param string|integer|bool $break add line breaks or TRUE clears the current line.
     *  - string: defines breaks before and after respectively
     *  - integer: defines breaks after only
     *  - bool(TRUE) : clears the current line before display
     * @param integer|string $pause delay in seconds before and after a text displayed.
     *  - Note: without the pipe, value supplied (integer or string) will be assummed as setting pause before.
     * @return Cli
     */
    static function textView(string $message, $spacing = '0|0', $break = '0|0', $pause = '0|0') : Cli {

        $clearLine = false;

        if(is_bool($break)){
            $break = 0;
            $clearLine = $break;
        }
        
        $spaces = self::toBreaks($spacing);
        $break  = self::toBreaks($break);
        $pause  = self::toBreaks($pause);
        
        $spacel = str_repeat(' ', $spaces[0]);
        $spacer = str_repeat(' ', $spaces[1]);

        self::$textView = $message;

        if($clearLine) self::clearLine();

        sleep($pause[0]);
        print br('', $break[0]).br($spacel.$message.$spacer, $break[1]);
        sleep($pause[1]);

        return self::instance();
    }

    /**
     * Designed method for displaying console text after the current line is cleared.
     *  - For all arguments supporting pipe spacing format, documentation on CLI spacing 
     *    is available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     *
     * @param string $message
     * @param integer $spacing left and right space margins
     *  - When a single integer is supplied, it is assumed to be a right (i.e after) space.  
     * @param string|integer $break add line breaks (booleans values are not supported)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @param integer $pause delay in seconds before and after a text displayed.
     *  - When a single integer is supplied, it is assumed to be a right (i.e after) space.  
     *  - Uses the same format as the documentation on CLI pipe spacing available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     * @return Cli
     * @uses Cli::textPlain()
     */
    static function clearView(string $message, string|int $spacing = '0|0', string|int $break = '0|0', string|int $pause = '0|0') : Cli {

        self::clearLine();

        return self::textPlain(...func_get_args());
    }

    /**
     * Designed method for displaying console text without tracking
     *  - For all arguments that accepts pipe spacing format, documentation on 
     *    CLI spacing is available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     *
     * @param string $message message to be displayed.
     * @param string|integer $spacing before and after a text is displayed.
     * @param string|integer|bool $break add (int) line breaks or clears the current line
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     *   - bool (boolean): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *     - other accepted data types are processed according to the [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @param integer $pause pause after text display (in seconds)
     * 
     * @return Cli
     */
    static function textPlain(?string $message, string|int $spacing = '0|0', $break = '0|0', $pause = '0|0') : Cli {

        $clearLine = false;

        if(is_bool($break)){
            $break = 0;
            $clearLine = $break;
        }
        
        $spaces = self::toBreaks($spacing);
        $break  = self::toBreaks($break);
        $pause  = self::toBreaks($pause);
        
        $spacel = str_repeat(' ', $spaces[0]);
        $spacer = str_repeat(' ', $spaces[1]);

        if($clearLine) self::clearLine();

        sleep($pause[0]);
        print br('', $break[0]).br($spacel.$message.$spacer, $break[1]);
        sleep($pause[1]);

        return self::instance();
    }

    /**
     * Designed method for returning a console text
     *
     * @param string $message
     * @param string $spacing text left and right spacing (or indent).
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @param string|integer|array|bool $break (string, int) add line breaks or TRUE clears the current line.
     *   - bool (boolean): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *   - other accepted data types are processed according to the [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @return string
     * 
     */
    static function textBuild(?string $message, string|int $spacing = '0|0', string|int|bool $break = '0|0') : string {

        $clearLine = false;

        if(is_bool($break)){
            $break = 0;
            $clearLine = $break;
        }
        
        $spaces = self::toBreaks($spacing);
        $break  = self::toBreaks($break);
        
        $spacel = str_repeat(' ', $spaces[0]);
        $spacer = str_repeat(' ', $spaces[1]);

        $clear = '';

        if($clearLine) $clear = self::clearLine(false); // changed argument to false. If error remove argument!!!

        return $clear.br('', $break[0]).br($spacel.$message.$spacer, $break[1]);
    }

    /**
     * Display a button-like hint message useful for notifications
     *
     * @param string $title button value
     * @param string $message message 
     * @param string $color background and foreground color respectively separated by pipe.
     *  - Basic color options include: [red/danger, blue/alert, yellow/warn, green/success]
     *  - Note that the options 'red,blue,yellow,green' may use truecolor if available. For consistency 
     *    use the corresponding smart color words 'danger,alert,warn,success' which uses the old terminal colors.
     * @param integer $indent space at the beginning of the text displayed.
     * @param string|integer|bool $break add (int) line breaks or TRUE clears the current line.
     *   - bool (boolean): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *   - other accepted data types are processed according to the [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @uses Cli::textPlain()
     * @return Cli
     */
    static function infoView(?string $title, string $message, string $color = 'danger|black', int $indent = 0, $break = '0|0') : Cli{
        $colors = explode('|',$color);
        $background = $colors[0] ?? 'white';
        $foreground = $colors[1] ?? 'black';

        Cli::textPlain(Cli::bgColor($title, $background, $foreground).': '.$message, $indent, $break);
        return self::$instance;
    }

    /**
     * Returns a button-like hint message useful for notifications
     * 
     * @param string $title button value
     * @param string $message message 
     * @param string $color background and foreground color respectively separated by pipe.
     *  - Basic color options include: [red/danger, blue/alert, yellow/warn, green/success]
     *  - Note that the options 'red,blue,yellow,green' may use truecolor if available. For consistency 
     *    use the consistent smart color words 'danger,alert,warn,success' which uses the old terminal colors.
     * @param string $break linebreak before and after.
     *   - boolean (bool): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *   - other accepted data types are processed according to the [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @return string
     * @uses Cli::textBuild()
     */
    static function infoBuild(?string $title, string $message, string $color = 'danger|black', int $indent = 0, string|int|bool $break = '0|0') : string {
        $colors = explode('|',$color);
        $background = $colors[0] ?? 'white';
        $foreground = $colors[1] ?? 'black';

        return Cli::textBuild(Cli::bgColor($title, $background, $foreground).': '.$message, $indent, $break);
    }

    /**
     * Display message with an error subject flag.
     *  - Note that this internally uses the {@see spoova\mi\core\commands\Root\Cli::textPlain()} method.
     *  - Arguments supporting pipe space format are resolved according to the
     *    [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @param string $message error message
     * @param string $title error title
     * @param integer $indent number of spaces to be displayed before text is printed
     * @param string $break
     *   - boolean (bool): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *   - other accepted data types are processed according to the [CLI spacing](https://spoova.com/docs/helpers/classes/cli/spacing) documentation.
     * @param string $pause
     * @uses Cli::textPlain
     * @return Cli
     */
    static function errorView(?string $message, string $title = "Error: ", int $indent = 0, string|int|bool $break = '0|0', string|int $pause = '0|0') : Cli {
        Cli::textPlain(Cli::error($message, $indent, $title), break: $break, pause: $pause);
        return self::instance();
    }

    /**
     * Quickly display an error message before exit
     *
     * @param string $message message to be displayed
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     * @param string|int|bool $break addition of line breaks or line clearing
     *   - boolean (bool): 
     *     - TRUE clears the current line before printing message 
     *     - FALSE prints without clearing line.
     *   - other accepted data types are processed according to the [CLI spacing](http://localhost/spocs/docs/helpers/classes/cli/spacing) documentation.
     * @param string $title if supplied, shows as red colored title
     * @return Cli
     */
    static function errorExit(?string $message = '', string|int $spacing = '0|0', string|int|bool $break = '0|1', string $title = '') : Cli {
        Cli::wait(100000);
        if($title){ 
            Cli::textPlain(Cli::error($message, title: $title), $spacing, $break); 
        } else {
            Cli::textPlain($message, $spacing, $break); 
        }
        exit;
    }

    /**
     * Display message with an success subject flag.
     *  - Note that this internally uses the {@see spoova\mi\core\commands\Root\Cli::textPlain()} method.
     * @param string $message error message
     * @param string $title error title
     * @param integer $indent number of spaces before text is printed
     * @param string $break adding line breaks or line clearing
     * @param string $pause
     * @uses Cli::textView
     * @return Cli
     */
    static function successView(?string $message, string $title = "Success: ", int $indent = 0, string|int|bool $break = '0|0', string|int $pause = '0|0') : Cli {
        Cli::textPlain(Cli::success($message, $indent, $title), break: $break, pause: $pause);
        return self::instance();
    }

    /**
     * Designed method for displaying console text as an header
     *
     * @param string|Closure $message header message
     * @param string $icon icon of header message (only supported UTF-8 icons)
     * @param string $color color of header message
     * @param integer $break break applied after header message is printed 
     * @return Cli
     */
    static function headerView(string|Closure $message, string $icon = '►', string $color = 'danger', int $break = 0) : Cli {

        if(CliDev::isBash()) Cli::break();
        if($icon && substr(strrev($icon), 0, 1) !== ' '){
            $icon .= " ";
        }

        if(HandleCliErrors::isDisplayed() && $message) Cli::break(1);
        
        Cli::silentErrors(true); //CliDev::isBash() || CliDev::isTermux()) || (CliDev::isWSL()
        Cli::escapeView(fn() => (true), function() use($message, $color, $icon){
            if(is_closure($message)){
                echo Cli::color(fn() => $icon.$message(), $color);
            }else{
                echo Cli::color(fn() => $icon.$message, $color);
            } 
        });
        Cli::silentErrors(false);

        if($hasErrors = HandleCliErrors::hasErrors()) Cli::break(1);
        HandleCliErrors::consoleErrors(false, true);

        if($hasErrors) $break -= 1;

        echo Cli::br($break);

        return self::instance();
    }

    /**
     * Enables or disables silent error mode
     *
     * @param boolean $mode
     * @return Cli
     */
    public static function silentErrors(bool $mode = true) : Cli {
        if($mode) self::header_mode();
        HandleCliErrors::silentErrors($mode);
        return self::instance();
    }

    private static function header_mode(bool $mode = true) {
        self::$header_mode = true;
        HandleCliErrors::header_mode();
    }

    /**
     * Similar to the {@see HandleCliErrors::consoleErrors()} method
     *
     * @param boolean $return determines the response when silent mode is disabled
     * @return boolean|null
     */
    public static function consoleErrors(bool $return = true) : bool|null {
       return HandleCliErrors::consoleErrors($return);
    }

    /**
     * Disable silent mode and display console errors if it exists.
     */
    public static function showErrors() : void {
        if($error_exists = Cli::error_exists())  Cli::moveUp();
        
        Cli::silentErrors(false)->consoleErrors();

        if($error_exists) Cli::break(1);
    }

    /**
     * Returns TRUE if any pre-existing (i.e undisplayed) error exists in the CLI 
     * 
     * @uses HandleCliErrors::hasErrors()
     *
     * @return boolean
     */
    public static function hasErrors() : bool {
        return HandleCliErrors::hasErrors();
    }

    /**
     * Returns TRUE if error exists in the CLI 
     * 
     * @uses HandleCliErrors::error_exists()
     *
     * @return boolean
     */
    public static function error_exists() : bool {
        return HandleCliErrors::error_exists();
    }

    /**
     * Alias of {@see HandleCliErrors::isSilent()}
     *
     * @param boolean $strict
     *  - FALSE : returns TRUE if the current mode is silent 
     *  - TRUE : returns TRUE if the silent was enabled once before being disabled. 
     * @return boolean
     */
    public static function isSilent(bool $strict = false) {
        return HandleCliErrors::isSilent($strict);
    }

    /**
     * This is the {@see Cli} smartest way of returning or yielding a boolean response. This method 
     * ensures that the CLI errors are properly displayed smartly on the CLI screen. It also sets the last message displayed on the CLI screen.
     *  - This method is suitable when the {@Cli::silentErrors()} is initially applied.
     *  - Since a boolean value is applied, you can also yield from a false or true value.
     * @param boolean|string $return This argument determines the response to be returned. Any invalid argument is automatically treated as FALSE 
     *  - boolean (true|false) : returns TRUE or FALSE depending on the boolean supplied.
     *  - string : optional [success|failed|fatal] returns TRUE or FALSE based on the option supplied. 
     *      - success : returns boolean of TRUE similarly to setting a boolean argument of TRUE
     *      - failed : returns boolean of FALSE similarly to setting a boolean argument of FALSE
     *      - fatal : returns boolean of FALSE and allows message defined to override default termination message if fatal error occurs
     * @param string|Closure|false|null $msg determines response error behaviour
     *  - string: An exit info message that will be displayed last on the CLI terminal ONLY when exiting.
     *    - This message will only be used if the $return argument is set as false (i.e indicating a manual error occured) or a fatal error occurs
     *  - Closure: A callback with GhostCliErrors argument that takes a GhostCliMsg object giving access to extended CLI error response customization.
     *  - A false value will disable the exit response.
     * @param string $title message title
     * @param integer $indent number of spaces before text is printed.
     * @return boolean value returned is dependent on the first argument supplied 
     *  - TRUE: when $return argument is 'success' or TRUE
     *  - FALSE: when $return argument is 'failed', 'fatal', FALSE or an invalid argument is supplied.
     */
    public static function response(bool|string $return, string|Closure|false|null $msg = 'Program terminated!', string $title = 'Info', int $indent = 0) : bool {
       HandleCliErrors::strict_mode(strtolower($return.'') === 'fatal');
       HandleCliErrors::set_info($msg, $title, $indent);
       return in_array($return,[true, 'success'], true); // HandleCliErrors::consoleErrors($return) ?: false;
    }

    // public static function hasError() : bool {
    //     return HandleCliErrors::hasError();
    // }

    /**
     * This is an alias for textView() method but is only used to escape 
     * text display on gitbash CLI
     *
     * @param string $message
     * @param int|string|array $spacing 
     *  - int: after
     *  - string: 'before,after'
     *  - array: [before,after]
     * @param integer|bool $break add (int) line breaks or clears the current line (bool:false)
     *  - int: after
     *  - string: 'before,after'
     *  - array: [before,after]
     *  - boolean: TRUE clears line before text display while FALSE only displays text.
     * @param integer $pause pause before or after text display (in seconds)
     *  - int: after
     *  - string: 'before,after'
     *  - array: [before,after]
     * @return Cli
     */
    static function bashView(string|Closure $message, $spacing = '0|0', $break = '0|0', $pause = '0|0') : Cli {
        static $i = 0;
        $args = func_get_args();

        Cli::escapeView(fn() => !CliDev::isBash() || CliDev::isTermux(), function()use($args, $message, $i){
            if($message instanceof Closure){
                if($i === 0) unset($args[0]); ksort($args);
                return self::textView($message(), ...$args);
            }else{
                return self::textView(...$args);
            }
        });

        $i++;
        return self::instance();
    }


    /**
     * Prints or return a break line in Cli terminals except bash terminal 
     * display smartly
     *
     * @param integer $linebreaks number of breaks
     * @param boolean $print false returns break rather than print
     * @return Cli|string
     */
    static function bashBreak(int $linebreaks = 1, bool $print = true) : Cli {
        $args = func_get_args();
        Cli::escapeView(fn() => !CliDev::isBash() || CliDev::isTermux(), fn() => Cli::break(...$args));
        return self::instance();
    }


    /**
     * Resolve callback by using the number of required arguments.
     *
     * @param Closure $callback
     * @param string $class resolver class
     * @return string
     */
    private static function resolveCliPulse(Closure $callback, string $class) : string {

        $reflection = new ReflectionFunction($callback);
        $params = $reflection->getParameters();
        $count = count($params);

        if($count > 0){
            $arg1_type = $params[0]->getType();
            if ($arg1_type instanceof ReflectionNamedType) {
                $name = $arg1_type->getName();
                if($name === $class) return 'pulse';
            }
            if($count > 1){
                $arg2_type = $params[1]->getType();
                if ($arg2_type instanceof ReflectionNamedType) {
                    $name = $arg2_type->getName();
                    if($name === $class) return 'char-pulse';
                }
            }
        }
        return 'char-index-pulse';
        
    }

    /**
     * Designed method for displaying console text in a pulsated mode
     *
     * @param string $message text to be displayed
     * @param integer|Closure $beats 
     *  - Integer sets the text pulse interval (in microseconds)
     *  - Closure sets the $eachChar argument. Hence, a third argument cannot be supplied.
     * @param Closure|null $eachChar callback applied on each character during display
     *  - Closure may be defined as any of the formats: ``Closure($char, $index)``, ``Closure($char, object $mod)``, ``Closure(object $mod)``, ``Closure($char, CliPulser $mod)``, ``Closure(CliPulser $mod)``
     *  - This will throw an error if second argument (i.e $beats) is already set as Closure.
     * @return Cli
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function pulseView(string $message, int|Closure $beats = 30000, ?Closure $eachChar = null) : Cli {

        if(is_closure($beats)){
            if($eachChar){
                throw new Error('double closure arguments rejected by "Cli::pulseView()"');
            }
            $eachChar = $beats;
            $beats = 30000;
        }
        $openingCode = $closingCode = '';

        self::$pulseText = $message;
        self::$pulse['cleared'] = '';
        self::$pulse['eachChar'] = $eachChar;
        self::$pulse['char-index'] = null;

        if (preg_match('/(\033\[[0-9;]*m)(.*?)(\033\[0m)/', $message, $matches)) {
            $openingCode = $matches[1]; // opening ANSI code
            
            $message = $matches[2]; // contains the text inside the color codes
            
            $closingCode = $matches[3]; // closing ANSI code
        }
        self::$pulse['openingASI'] = $openingCode;
        self::$pulse['closingASI'] = $closingCode;
        self::$pulse['text'] = $message;
        self::$pulse['textState'] = $message;

        $chars = mb_str_split($message);
        
        if($eachChar){
            $reflection = new ReflectionFunction($eachChar);
            $params = $reflection->getParameters();
            $name = 'integer';
            
            if (isset($params[0])) {
                $type = $params[0]->getType();
                if ($type instanceof ReflectionNamedType) {
                    $name = $hint = $type->getName();
                }
            }
            if (isset($params[1]) && empty($hint)) {
                $type = $params[1]->getType();
                if ($type instanceof ReflectionNamedType) {
                    $name = $type->getName();
                }
            }

            foreach($chars as $index => $char){

                $Ghost = new GhostFunction([['index'=> $index+1],['char'=>$char], ['message'=>$message]]);

                GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliPulser{});

                $mod = GhostProxy::object();
                
                $firstArgument = (!empty($hint) && ($name === CliPulser::class))? $mod  : ($char??''); // CliPulser $mod | $char
                $secondArgument = (empty($hint) && ($name === CliPulser::class))? $mod  : $index + 1; // $mod | $index
                Cli::textView($eachChar($firstArgument, $secondArgument, $mod)); 
                Cli::wait($beats);
            }
        }else{
            foreach($chars as $char){
                Cli::textView($openingCode.$char.$closingCode);
                Cli::wait($beats);
            }
        }

        return self::instance();
    }

    /**
     * Update a pulse text silently. 
     *  - To be used along with pulseView
     * 
     * @param string $message full message to be updated
     * @param Closure|null $eachChar closure function update if any
     *  - Closure function must be relative to the newly updated message
     * @param boolean $flow determines a continuous state 
     *  - If TRUE, previous state is kept and {@see Cli::pulseFront()} may be used after else if 
     *    FALSE previous state is overridden and {@see Cli::pulseView()} can only be used after.
     * 
     * @return Cli
     */
    static function pulseUpdate($message,  ?Closure $eachChar = null, bool $flow = false) : Cli {
        self::$pulse['text'] = $message;
        if(!$flow) {
            self::$pulse['cleared'] = '';
            self::$pulse['textState'] = $message;
        }
        self::$pulse['eachChar'] = $eachChar;

        return self::instance();
    }

    /**
     * Entirely clears back each text character previously displayed to the CLI screen
     *
     * @param string $message original text on CLI screen desired to be cleared. 
     *   - If not defined, this will assume the last defined CLI message by {@see Cli::pulseView()} method.
     * @param integer $beats text pulse interval (in milliseconds)
     * @param bool $reset TRUE cancels out all cleared texts.
     * @return Cli
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function pulseClear(?string $message = null, int $beats = 30000, bool $reset = false) : Cli {
        if($message === null) $message = self::$pulseText;
        $texts = mb_str_split($message?:'');
        foreach($texts as $text){
            Cli::back(1);
            Cli::textView(" ");
            Cli::back(1);
            Cli::wait($beats);
        }
        Cli::wait($beats);
        if($reset) self::$pulse['cleared'] = '';
        Cli::clearLine();

        return self::instance();
    }

    /**
     * Clears back each text character previously pulsated to the CLI screen through {@see Cli::pulseView()} method.
     *
     * @param integer $length number of characters to clear backwards
     * @param integer $beats text pulse interval (in milliseconds)
     * @return Cli
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function pulseBack(int $length, int $beats = 30000) : Cli {
        $message = self::$pulseText; // original pulse message defined by pulseView()
        $chars = str_split($message?:'');
        $chars = array_reverse($chars);

        $oldTexts = self::$pulse['cleared'] ?? ''; // get previously removed texts
        $newTexts = ''; // variable to contain newly removed texts.

        self::$pulse['char-index'] = self::$pulse['char-index'] ?? strlen(self::$pulse['text']);
        foreach($chars as $index => $char){
            if(self::$pulse['char-index'] === 0) break; // prevent negativity backflow
            if($index === $length){ break; }
            
            Cli::backTrack(); // clear back
            $newTexts .= $char;
            self::$pulse['char-index']--;
            self::$pulse['textState'] = substr(self::$pulse['text'], 0, strlen(self::$pulse['textState']) - 1);

            Cli::wait($beats);
        }
        $newTexts = strrev($newTexts);
        $oldTexts .= $newTexts;

        self::$pulse['cleared'] = $oldTexts; // update cleared texts {(old + newly) removed texts}
        return self::instance();
    }

    /**
     * Pulsates previously cleared text back to the CLI screen.
     *  - This method depends on pulsated texts cleared by {@see Cli::pulseBack()}
     * 
     * @param integer $length text to be displayed
     * @param integer $beats text pulse interval (in milliseconds)
     * @return Cli
     * 
     * @notice when bool of false is supplied, textView clears the current line
     */
    static function pulseFront(int $length, int $beats = 30000) : Cli {
        $message = self::$pulse['cleared'] ?? '';
        $chars = str_split($message?:'');
        $eachChar = self::$pulse['eachChar'] ?? '';

        if($eachChar){

            $format = self::resolveCliPulse($eachChar, CliPulser::class);

            if($chars){
                for($i = 0; $i < $length; $i++){

                    // update the current text state as length of current state in original pulse text. 
                    self::$pulse['textState'] = substr(self::$pulse['text'], 0, strlen(self::$pulse['textState']) + 1);
                    
                    //Apply GhostFunctions here
                    $index = strlen(self::$pulse['textState']); // set normal animation index

                    if(isset($chars[$i])){

                        $msg = self::$pulseText;
                        $char = $chars[$i]; // character retrieved from cleared texts from

                        $GhostFunction = new GhostFunction(['match','index',['index'=>$index],'char',['char'=>$char],['message'=>$msg],'inRange','from','words']);

                        $GhostFunction->match(function(string $word, string|array $indices, ?Closure $callback = null) use($index, $char){
                            if($callback) return Cli::match($word, $indices, $index)? $callback($char, $index) : $char;
                            return Cli::match($word, $indices, $index);
                        });
                        $GhostFunction->index(function()use($index){
                            return $index;
                        });
                        $GhostFunction->char(function()use($char){
                            return $char;
                        });
                        // $GhostFunction->message(function()use($msg){
                        //     return $msg;
                        // });
                        $GhostFunction->inRange(function(array $start, ?Closure $callback = null)use($index, $char){
                            if($callback) return inRange($index + 1, $start[0], $start[1])? $callback($char, $index) : $char;
                            return inRange($index + 1, $start[0], $start[1]);
                        });
                        $message = self::$pulseText;
                        $GhostFunction->from(function(array|string $string, ?Closure $callback = null)use($index, $char, $message){
                            if(!$string) throw new Error('invalid string supplied on Cli::pulseView character modifier object method(from)');
                            $list = (array) $string;
                            if(count($list) > 2) throw new Error('maximum word counts exceeded on Cli::pulseView character modifier object method(from)');
                            $nlist = array_values($list);
                            $nkeys = array_keys($list);
                            $from = Cli::textIndices($message, $nlist[0]);
                            $to = isset($nlist[1])? Cli::textIndices($message, $nlist[1]) : null ;

                            $start = $from[$nkeys[0]] ?? null;
                            if($to !== null) $end = $to[$nkeys[1]];

                            if($start !== null){
                                if(isset($end)){
                                    if($callback) return inRange($index + 1, $start, $end)? $callback($char, $index) : $char;
                                    return inRange($index + 1, $start, $end);
                                }else{
                                    if($callback) return (($index + 1) >= $start)? $callback($char, $index) : $char;
                                    return (($index + 1) >= $start)? $callback($char, $index) : $char;
                                }
                            }
                            return $char;
                        });
                        $GhostFunction->words(function(array|string $string, ?Closure $callback = null)use($index, $char, $message){
                            $lists = (array) $string;
                            
                            foreach($lists as $list){
                                $bases = Cli::textIndices($message, $list);
                                
                                foreach ($bases as $base) {
                                    if ($index >= $base && $index < $base + strlen($list)) {
                                        return $callback? $callback($char, $index, $list) : $char;
                                    }
                                }
                            }
                            return $char;
                        });
                        GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliPulser{});

                        $mod = GhostProxy::object();

                        $closureArgs = [];
                        if($format === 'pulse'){
                            $closureArgs[] = $mod;
                        }elseif($format=== 'char-pulse'){
                            $closureArgs[] = $chars[$i];
                            $closureArgs[] = $mod;
                        }elseif($format=== 'char-index-pulse'){
                            $closureArgs[] = $chars[$i];
                            $closureArgs[] = $index + 1;
                            $closureArgs[] = $mod;
                        }
                        Cli::textView($eachChar(...$closureArgs));
                        self::$pulse['char-index']++;
                        Cli::wait($beats);
                        unset($chars[$i]);
                    }else{
                        break;
                    }
                }
            }
        }else{
            $openingCode = self::$pulse['openingASI'] ?? '';
            $closingCode = self::$pulse['closingASI'] ?? '';
            for($i = 0; $i < $length; $i++){
                if(isset($chars[$i])){ 
                    // update the current text state as length of current state in original pulse text.
                    // this line was added here to ensure that the text state is properly updated even when no eachChar closure is supplied.
                    // extra characters that are not included in the original pulse text will not be included in the text state.
                    // self::$pulse['textState'] = substr(self::$pulse['text'], 0, strlen(self::$pulse['textState']) + 1);
                    // Todo: consider a better way to update text state without relying on length of original pulse text since it may cause issues when extra characters are included in the cleared texts that are not part of the original pulse text.
                    Cli::textView($openingCode.$chars[$i].$closingCode);
                    Cli::wait($beats);
                    // echo ''; //exit; 
                }
            }
            // Keep only the remaining characters that weren't displayed
            self::$pulse['cleared'] = implode('', array_slice($chars, $length));
        }
        if(isset($index)){
            self::$pulse['cleared'] = implode('', $chars);
            Cli::wait($beats);
        }

        return self::instance();
    }

    /**
     * Toggle texts back and forth
     *
     * @param integer $length length of characters to be toggled back and forth
     * @param integer $times number of times in which characters must be toggles
     * @param integer $beats delay interval between toggling in milliseconds.
     * @return Cli
     */
    static function pulseToggle(int $length, int $times = 0, int $beats = 30000) : Cli {
        Cli::hideCursor();
        for($i = 0; $i < $times; $i++){

            Cli::pulseBack($length, $beats)->pulseFront($length, $beats);

        }
        if(!self::$hideCursor) Cli::showCursor();
        return self::instance();
    }

    /**
     * Toggle texts back and forth
     *
     * @param integer $times
     * @param integer $times
     * @param integer $beats
     * @return Cli
     */
    static function pulseBlink(int $times = 1, int $beats = 500000) : Cli {
        Cli::hideCursor();
        $len = strlen(self::$pulseText);
        for($i = 0; $i < $times; $i++){

            Cli::clearLine();
            Cli::wait($beats);
            Cli::pulseBack($len, 0)->pulseFront($len, 0);
            Cli::wait($beats);
        }
        if(!self::$hideCursor) Cli::showCursor();
        return self::instance();
    }

    /**
     * Display the positional index of each text character within a full string.
     *
     * @param string|null $texts
     * @return void
     */
    static function pulseTexts(?string $texts = null, int $order = 1) {
        if($texts === null){
            $texts = self::$pulseText ?: '';
        }

        if(!in_array($order, [0, 1], true)) throw new Error('pulseTexts order argument must be set as 0 or 1');

        $texts = (mb_str_split($texts));

        $indices = [];
        array_map(function($value, $index) use(&$indices){
            $indices[$index+1] = $value;
        }, $texts, array_keys($texts));

        foreach($indices as $index => $value){
            Cli::textView(Cli::warn($order) . Cli::dots(20, $index, '.') ."|".Cli::alert($value))->break();
            $order++;
        }

        return self::instance();
    }

    /**
     * Get the indices of specified word from a string starting from 0 and above
     *
     * @param string $haystack
     * @param string $needle
     * @param integer $order optional [0|1] sets the returned array's starting index 
     * @param boolean $strict TRUE enforces word format while FALSE returns indices for al matching word characters regardless of position.
     * @return array
     */
    static function textIndices(string $haystack, string $needle, int $order = 0, bool $strict = true): array { 
        $positions = [];
        $needleLength = strlen($needle);
        $offset = 0; $start = $order === 0? -1 : 0;
        if($strict){ 

            while (($pos = strpos($haystack, $needle, $offset)) !== false) {
                // Ensure exact match boundaries

                $before = $pos === 0 ? '' : $haystack[$pos - 1];
                $after = $pos + $needleLength >= strlen($haystack) ? '' : $haystack[$pos + $needleLength];
        
                $isBoundaryBefore = $before === '' || ctype_space($before) || in_array($before, ['.', ',', ';', ':', '!', '?', '-', '(', '[', '{', '<', '"', "'"]);
                $isBoundaryAfter = $after === '' || ctype_space($after) || in_array($after, ['.', ',', ';', ':', '!', '?', ')', ']', '}','>', '"', "'"]);
        
                if ($isBoundaryBefore && $isBoundaryAfter) {
                    $start = $start+1;
                    $positions[$start] = $pos;
                }
        
                $offset = $pos + 1; // Check next possible position
            }

        }else{

            while(($pos = strpos($haystack, $needle, $offset)) !== false){
                $start++;
                $positions[$start] = $pos;
                $offset = $pos + 1; // move past current match
            }

        }

    
        return $positions;
    }    

    /**
     * Get the indices of specified word from a string starting from 1 and above.
     * @uses textIndices
     * @param string $haystack
     * @param string $needle
     * @param integer $order optional [0|1] sets the returned array's starting index 
     * @param boolean $strict TRUE enforces word format while FALSE returns indices for al matching word characters regardless of position.
     * @return array
     */
    static function textIndexes(string $haystack, string $needle, int $order = 0, bool $strict = true): array { 
        $indices = self::textIndices(...func_get_args());
        $indices = array_map(fn($val)=> $val+1, $indices);
        return $indices;
    }    

    /**
     * Checks if an index is within the range of assumed relatively valid indices of a word
     *
     * @param string $word word to be tested
     * @param int[]|string $indices assumed starting index positions of a word
     * @param integer $index test index that must be within the range of specified starting indices of $word
     * @param string $match references the matched word's character positional index.
     * @param integer $frequency references the matched word's positional frequency. 
     *  - 0 : means that no word index is found as index (if found) runs from 1 above.
     * @return bool only TRUE if $index exists within range of supplied starting indices of $word
     */
    static function match(string $word, string|array $indices, int $index, &$match = null, int|null &$frequency = 0) : bool {
        $indices = (array) $indices;
        foreach($indices as $start){
            $frequency++;
            $stop = $start + strlen($word); 
            if(($index >= $start) && ($index <= $stop)){
                $match = $start;
                return true;
            }
        }
        return false;
    }

    /**
     * Return a new instance of the cli class or an existing one
     *
     * @return Cli
     */
    private static function instance() : Cli {

        if(!self::$instance) self::$instance = new Cli;
        return self::$instance;
        
    }

    /**
     * Designed method for displaying console text in an animated format
     *
     * @param int|int[] $yield
     * @param string $message
     * @param Closure|bool|null $callback function or argument executed after animation is complete 
     *  - Closure : treated as a $callback(CliPlay $arg)
     *  - TRUE/FALSE/STRING : executes {@see CliPlay::stop($arg)} with TRUE, FALSE or string argument supplied
     *     - TRUE : clears line and print root message
     *     - FALSE : clears line and prints no message
     *     - STRING : clears line and prints string argument as callback message
     * @param int $pause delay in seconds after animation is completed
     * @uses CliPlay
     * @return Cli
     */
    static function play($yield, string|null $message = null, Closure|bool|string|null $callback = true, int $pause = 0){
        
        Cli::hideCursor();
        $sp = (self::isSpecial())? '' : ' ';

        if($message === null){
            $message = self::$textView;
        }else{
            self::$textPlay = $message;
            if(isset(self::$animes['percent']) && array_key_exists('subject', (array) self::$animes['percent'])){
                self::$animes['percent']['subject'] = $message;
            }
        }
        self::$textView = $message;

        print $message;
        yield from self::animate($yield);

        $GhostFunction = new GhostFunction([['text'=>self::$textPlay]]);

        GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => 
            new class($draft) extends CliPlay {}
        );
        
        /**  @var CliPlay $play */
        $play = GhostProxy::object();

        if($callback instanceof Closure){
            $callback($play);
        }else{
            $play->stop($callback);
        }

        if($pause) Cli::pause($pause);

        return self::instance();
    }

    /**
     * Returns the last text played through the use of {@see Cli::textPlay()} method.
     * @return string
     */
    public static function playedText() : string {
        return self::$textPlay;
    }

    /**
     * This is an helper method for ending text animated through Cli::play() method.
     *
     * @param boolean $clearLine
     * @param integer $break
     * @return Cli
     */
    static function stop(bool $clearLine = true, bool|int $break = 0){

        if(is_bool($break)){
            $clearLine = $break;
            $break = 0;
        }

        Cli::backspace();
        Cli::break($break);
        if($clearLine === true) self::clearLine();

        return self::instance();
    }

    /**
     * Delay in seconds
     * alias for wait()
     *
     * @param integer $seconds
     * @return Cli
     */
    static function pause(int $seconds) : Cli{
        \sleep($seconds);
        return self::instance();
    }

    /**
     * Delay in microseconds
     *
     * @param integer $microseconds
     * @return Cli
     */
    static function wait(int $microseconds) : Cli {
        \usleep($microseconds);
        return self::instance();
    }

    /**
     * Prints or return a break line in cli
     *
     * @param integer $linebreaks number of breaks
     * @param boolean $print false returns break rather than print
     * @return Cli|string
     * @uses \br()
     */
    static function break(int $linebreaks = 1, bool $print = true) : Cli|string{
        if(!$print) return br('', $linebreaks);
        print br('', $linebreaks);
        return self::instance();
    }

    /**
     * Prints or return a smartly adjusted line break. This should 
     * be used at the end of code execution before a CLI process is terminated. 
     * Applying within processes may not work as desired.
     *
     * @param integer $linebreaks number of breaks
     * @param boolean $print false returns break rather than print
     * @return Cli|string
     * @uses \br()
     */
    static function smartBreak($linebreaks = 1, bool $print = true) : Cli|string {
        if($linebreaks < 0) $linebreaks = 0;

        if($linebreaks > 0){
            $extra = !CliDev::isBash() || CliDev::isTermux();
            if(!$extra) $linebreaks -= 1;
            if(!$print) return br('', $linebreaks);
        }

        echo br('', $linebreaks);
        return self::instance();
    }

    /**
     * (Spoova 3 &gt;= 3.0.0) <br/>
     * prints a real line break using carriage for CMD, WSL and Powershell to the page
     * All arrays are converted to json format
     *
     * @param integer $break
     * @return void
     */
    static function linebr(int $break = 1) : void { 

        echo str_repeat(self::isTerminal(['prompt','powershell'])? "\r\n" : "\n", $break);
        
    }

    /**
     * Return a break line in cli
     * 
     * @param integer $linebreaks number of breaks
     * @return string
     * @uses \br()
     */
    static function br(int $linebreaks = 1) : string {
        return br('', $linebreaks);
    }

    /**
     * This method makes it easier to terminate animation with a final text.
     *   - This should only be used immediately before 'yield false' or 'return' if not yielded.
     *   - This method automatically adds a text indentation of 2
     *
     * @param int $pause number of seconds to sleep before printing the final message
     * @param int $break_before number of line breaks before message is printed
     * @param string $message a closing final message to be printed after animation
     * @param string $break_before number of line breaks after message is printed
     * @param int $indent number of indents for printed message
     * @return false
     */
    static function endAnime(int $pause = 0, int $break_before = 0, string $message = '', int $break_after = 0, int $indent = 2) : false {
        Cli::pause($pause); 
        Cli::break($break_before);
        Cli::textView($message, $indent, '|1'); 
        Cli::break($break_after);
        return false;
    }

    /**
     * Check php terminal type
     * 
     * @param string[] $type optional [cmd|powershell|wsl|windows|bash|git-bash|termux|termux-bash|linux]
     *  - cmd (or prompt) → windows CMD 
     *  - powershell → windows powershell only
     *  - wsl → WSL terminal only
     *  - wt → Windows Terminal (Window's Terminal App)
     *  - windows → any windows terminal (WSL, Powershell, CMD)
     *  - bash → git bash, termux or terminals that have bash
     *  - git-bash → git bash
     *  - termux → termux terminals only
     *  - termux-bash → termux, git bash
     *  - linux → linux O.S terminals
     * @return boolean
     */
    static function isTerminal(string|array $type) : bool { 
   
       return CliDev::isTerminal($type);

    }

    /**
     * This method is designed to be called in the final stage of animation for clearing animations off the screen. 
     *  - By default the current line is cleared and a single line break is added after if the values are not specified.
     *
     * @param int $lines number of lines to be cleared up including the current animation line
     *  - Note that in git bash, this will be replaced with entire console clear if argument 1 is greater than 0.
     * @param string $break number of lines to be added after lines has been cleared
     * 
     * @return Cli
     */
    static function clearAnime($lines = 1, $break = 1) : Cli {
        
        if(self::isTerminal('git-bash')){
           if($lines > 0) Cli::cls();
        }else{
            for($i = 0; $i < $lines; $i++){
    
                Cli::clearLine()->moveUp();
    
            }
        }

        Cli::break($break);

        return self::instance();
    }

    /**
     * This function makes it easier to indent a console text
     *
     * @param integer $indent number of spaces before text
     * @param string $message
     * @return string
     */
    static function textIndent(string $message = '', int $indent = 0) {
        $indent = self::toSpaces($indent);
        return str_repeat(' ', $indent[0]).$message.str_repeat(' ', $indent[1]);
    }

    /**
     * This function makes it easier to write a conclusion or returning 
     * text after all commands have been executed.
     *
     * @param string $message
     * @return void
     */
    static function endView(string $message = '') {
        Cli::textView($message, '2', '|1'); 
    }
    
    /**
     * A sample iterable heavy function to test progress bar
     *  - Note: remember to use yield from animeTest()
     * 
     * @return void
     */
    static function animeTest(){
        $i = 0;
        
        yield 1; // Stage 1 - loading
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }
        
        yield 2; // Stage 2 - loading
        // while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 3; // Stage 3 - loading
        //slows progress bar  
        while($i < 20){ usleep(50000); $i++; if($i == 20){ $i = 0; break; } }

        yield 4; // Stage 4 - loading
        //slows progress bar more 
        while($i < 100){ usleep(50000); $i++; if($i == 100){ $i = 0; break; } }

        yield 5; // Stage 5 - loading
        //slows progress bar even more  
        while($i < 200){ usleep(50000); $i++; if($i == 200){ $i = 0; break; } }

        yield 6; // Stage 5 - loading

        // last stage (yield true) completed here. Exit animation
        yield true;
    }
    
    /**
     * Sets the load time in microseconds
     *
     * @return void
     */
    static function loadTime(int $time = 0){
        if(func_num_args() > 0){
            self::$loadTime = $time;
        }
    }

    /**
     * To use this function, $callback must be iterable
     *
     * @param bool $isLoading tells method to start loading
     * @param array|string $callback an iterable function or method 
     *    - Formats:
     *      - - 'function' => where function name is supplied as a string
     *      - - function() => where function is supplied as a closure
     *      - - ['method'] => where method is a callable method of Anime class
     *      - - ['class', 'method'] => where class is unrelated class and method is public
     *      - - [['class', 'method'], [...args]] => where class is unrelated class, method is public and args are arguments
     *      - - ['function', [...args]] => where function is function name, and args are arguments
     * @param array|string $final a final callback once loading is completed. Supports $callback parameter's format.
     * @return bool
     * @notice when animating, yield false is used to denote that an error has occured
     */
    private function animeLoad(bool $isLoading, $callback = [], $final = []) {
        
        static $start = 0;
        static $posit = 0; 
        $anime = self::$anime;
        self::$animeState = 'animeLoad';

        if($posit > 2) $posit = 0;

        if(!in_array($anime,['normal','percent'])) Cli::break();

        // if($callback && !is_callable($callback)){
            
        //     Cli::exit($callback);
        //     self::$animeFails = true;
        //     return false;
        // }

        if($anime === 'percent'){
            self::$animeState = 'animeLoad';
            $anime = $this->animeLoadPercent($isLoading, $callback);

            if($anime !== null){
                return $anime;
            }
        } else {
            self::$animeState = 'animeLoad';
            $value = $this->animeLoadChars($isLoading, $callback, $posit);
            if(is_bool($value)){
                return $value;
            }
        }
       
        echo ' '; //prevent any left over character 
        $this->animeLoad(false, $final); //set function loading to false.

        $start++;

        return true;

    }

    /**
     * Animate percentage
     *
     * @param bool $isLoading
     * @param array|string $callback
     * @return bool
     */
    private function animeLoadPercent($isLoading, $callback){
            
        if(!$isLoading) {
            /** This is automatically called by the function after successful completion */
            if(is_callable($callback)) {
                if($callback instanceof Closure){
                    $response = $callback();
                    if($response) print $response;
                }else{
                    call_user_func_array($callback[0], $callback[1]);
                }
            }
            return true;
        }

        $animePercent = self::$animes['percent'];
        $loader = $animePercent['char']; 
        $subject = $animePercent['subject'];
        $clearLine = "\033[2K\r"; //clear new line 

        $modifier = new stdClass;

        if(in_array(self::$animeList, [AnimeList::Steps, AnimeList::StepsGrow])){
            

            // Define function used to display animated characters for steps
            $mod = function($modifier, $loader){
                
                $animesPercent = self::$animes['percent'];

                // define default display when modifier function is not defined.
                $display = $modifier->subject;
                if($modifier->subject && $modifier->length > 0) {
                    if(substr(strrev($modifier->subject), 0 , 1) !== ' ') $display .= " ";
                }

                if(is_array($animesPercent) && is_closure($animesPercent['mod'] ?? '')){
                    $display .= $animated = str_repeat($loader, $modifier->length);
                    if($modifier->length > 0){ $display .= " "; $animated .= " "; }
                    $display .= $modifier->percent.'%';
                    
                    //Define a Ghost object for subject, percent and chars 
                    $GhostProps =  [['subject'=>$modifier->subject], ['percent'=>$modifier->percent], ['chars' => $animated]];
                    
                    $GhostFunction = new GhostFunction(['subject','chars','percent',...$GhostProps], 'GhostModifier');

                    $GhostFunction->subject(fn() => $modifier->subject);
                    $GhostFunction->percent(function($type = 'integer') use($modifier){
                        if($type === 'integer') return $modifier->percent;
                        return $modifier->percent.'%';
                    });
                    $GhostFunction->chars(function($type = 'state') use($modifier){
                        if(!in_array($type, ['default','text','state','length','max'])) {

                            $filter = Debug::filter(function($traces){
                                $filter = [];
                                foreach($traces as $key => $info){
                                    if(isset($info['class']) && $info['class'] === $this::class){
                                        if(empty($trace)) {
                                            $trace = true; 
                                            continue;
                                        };
                                    }
                                    if(empty($trace)) continue;
                                    $filter[] = $info;
                                }
                                return $filter;
                            });

                            $handler = $filter[0];

                            if($handler && Arr::bin($handler)->hasKeys(['file','line'])) {
                                $handler = "{$handler['file']} on line {$handler['line']}"; 
                                Cli::textView(Cli::error('')."\"GhostModifier::".Cli::warn("chars(#1)")."\" must be one of valid options: [".Cli::valid("default,text,state")."] in $handler")->break(2);
                                Cli::showCursor();
                                exit;
                            }else{
                                throw new InvalidArgumentException('"GhostModifier::chars(#1)" must be one of valid options: [default,text,state]');
                            }
                        }
                        return ($modifier->chars)($type);
                    });

                    GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>  new class($draft) extends CliPercent{});

                    return $animesPercent['mod'](GhostProxy::object()); // use callback modifier if defined
                    
                } else {
                    
                    if(trim($loader) === '') $loader = Cli::bgWhite(' ');
                    $display .= $animated = str_repeat($loader, $modifier->length);
                    if($modifier->length > 0){ $display .= " "; $animated .= " "; }
                    $display .= $modifier->percent.'%';
    
                    return $display;

                }

            };

            //calculate anime steps info
            $functions = count($callback); // total number of processes - Cli::AnimeList(handler)
            $processes = array_values($callback);
            $totalChars =  self::$animeListLength;  // total number of characters to be displayed - Cli::AnimeList(length)
            
            $stepsPerFunc = intval(100 / $functions);

            $currentProgress = 0;
            $distributedChars = 0;
            $dots = 0;

            Cli::clearLine()->hideCursor();

            $modifier->subject = $subject;

            foreach($processes as $index => $func) {
                
                if(is_iterable($func())){
                    self::$animeInfo['default'] = Cli::error('animation with '.Cli::warn('[AnimeList::Steps]').' and generators suspended in '. Debug::get(2)['file'].' on line '.Debug::get(2)['line']);
                    self::$animeInfo['basic'] = Cli::error('animation with [AnimeList::Steps] and generators suspended in '. Debug::get(2)['file'].' on line '.Debug::get(2)['line']);
                    if(self::$animeClean){
                        self::$animeFails = true;
                        Cli::showCursor();
                        return false;
                    }
                    Cli::clearLine();
                    Cli::textView(self::$animeInfo['default'])->break(2);
                    Cli::showCursor();
                    exit;
                }

                $dots++; //increment the character 

                $modifier->length = $dots;
                $chars = $loader;

                for($i = 0; $i < $stepsPerFunc; $i++){
                    $currentProgress++;

                    // Calculate the expected total characters based on percentage
                    $expectedChars = intval(($currentProgress / 100) * $totalChars);

                    // Determine the distributed characters for this step without exceeding total characters 
                    $chars_for_step = $expectedChars - $distributedChars;
                    
                    // Update the distributed characters count
                    $distributedChars += $chars_for_step;
                    $modifier->length = $distributedChars;
                    
                    $modifier->percent = $currentProgress;

                    if($currentProgress > 100){
                        $currentProgress = 100;
                    }
                    $random = [100, 10000, 40000, 500, 80000, 800, 100000];
                    
                    Cli::clearLine();
                    
                    $modifier->chars = function($type) use($chars, $distributedChars, $totalChars){

                        if($type === 'default') return $chars; 

                        $text = preg_replace('~\033\[[0-9;]*[A-Za-z]~', "", $chars);

                        if($type === 'state') return str_repeat($text, $distributedChars);

                        if($type === 'length') return $distributedChars + 1;

                        if($type === 'max') return $totalChars;

                        return $text; // unknown argument's response

                    };
                    if($i !== 0) $dots++;
                    echo $mod($modifier, $loader);
                    usleep($random[array_rand($random)]);
                }
                
                
                Cli::clearLine();
                
                echo $mod($modifier, $loader);
                
                $random2 = [100, 200, 300, 400];
                usleep($random2[array_rand($random2)]); // 50 
                
                if($index === ($functions - 1)){
                    
                    usleep(100000);

                    Cli::clearLine();

                    if(is_float(100 / $functions)){
                        $distributedChars ++;
                        $modifier->length +=1; //increase the length of characters by 1 for uneven 
                    }

                    $modifier->percent = 100;
                    echo $mod($modifier, $loader);

                    sleep(2);

                }
                
            }

            Cli::showCursor();

        }else{

            
            // Define function used to display animated characters for generators
            $mod = function($modifier, $loader){
                
                $animesPercent = self::$animes['percent'];
                
                // define default display when modifier function is not defined.
                $display = $modifier->subject;
                if($modifier->subject && $modifier->length > 0) {
                    if(substr(strrev($modifier->subject), 0 , 1) !== ' ') $display .= " ";
                }
                $display .= $animated = str_repeat($loader, $modifier->length);
                
                if(is_array($animesPercent) && is_closure($animesPercent['mod'] ?? '')){
                    if($modifier->length > 0){  $animated .= " "; }
                    
                    $GhostProps =  [['subject'=>$modifier->subject], ['percent'=>$modifier->percent], ['chars' => $animated ]];
                    
                    $GhostFunction = new GhostFunction(['subject','chars','percent',...$GhostProps], 'GhostModifier');

                    $GhostFunction->subject(fn() => $modifier->subject);
                    $GhostFunction->percent(function($type = 'integer') use($modifier){
                        if($type === 'integer') return $modifier->percent;
                        return $modifier->percent.'%';
                    });
                    $GhostFunction->chars(function($type = 'state') use($modifier){
                        if(!in_array($type, ['default','text','state'])) {

                            $filter = Debug::filter(function($traces){
                                $filter = [];
                                foreach($traces as $key => $info){
                                    if(isset($info['class']) && $info['class'] === $this::class){
                                        if(empty($trace)) {
                                            $trace = true; 
                                            continue;
                                        };
                                    }
                                    if(empty($trace)) continue;
                                    $filter[] = $info;
                                }
                                return $filter;
                            });

                            $handler = $filter[0];

                            if($handler && Arr::bin($handler)->hasKeys(['file','line'])) {
                                $handler = "{$handler['file']} on line {$handler['line']}"; 
                                Cli::textView(Cli::error('')."\"GhostModifier::".Cli::warn("chars(#1)")."\" must be one of valid options: [".Cli::valid("default,text,state")."] in $handler")->break(2);
                                Cli::showCursor();
                                exit;
                            }else{  
                                Cli::showCursor();
                                throw new InvalidArgumentException('"GhostModifier::chars(#1)" must be one of valid options: [default,text,state]');
                            }
                        }
                        return ($modifier->chars)($type);
                    });
                    
                    GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>  new class($draft) extends CliPercent{});

                    return $animesPercent['mod'](GhostProxy::object());
                    return $animesPercent['mod']($GhostFunction);

                } else {

                    if($display) $display .= " "; 
                    $display .= $modifier->percent.'%';
    
                    return $display;

                }

            };

            if(count($callback) > 0){
                self::$animeFails = true;
                self::$animeInfo['default'] = Cli::textBuild(Cli::error('animation with '.Cli::warn('[AnimeList::Yield]').' must have exactly one closure value '. Debug::get(2)['file'].' on line '.Debug::get(2)['line']));
                self::$animeInfo['basic'] = Cli::textBuild(Cli::error('animation with [AnimeList::Yield] must have exactly one closure value '. Debug::get(2)['file'].' on line '.Debug::get(2)['line']));

                if(!self::$animeClean){
                    Cli::clearLine();
                    Cli::textView(self::$animeInfo['default']);
                    Cli::break(2);
                    // exit;
                }
                Cli::showCursor();
                return false;
            }

            if(is_iterable($callback[0]())){

                $iterators = $callback[0];
                $i = 0; 


                foreach($iterators() as $iterator){

                    if($i === 0){
                        // print $subject;
                        if($subject) {
                          if(substr(strrev($subject), 0 , 1) !== ' ')  print " ";
                        }
                        usleep(300000);               
                    }

                    echo $clearLine; 
                    $i++;

                    if($iterator === false){
                        return false;
                    }elseif($iterator === true){
                        return true;
                    }

                    $chars = $loader;
                    $percent = intval(($i/self::$animeListYields) * 100);
                    $modifier->length  = intval($percent/100 * self::$animeListLength);
                    $modifier->subject = self::$textView;
                    $modifier->percent = $percent; 

                    $modifier->chars = function($type) use($chars, $modifier){

                        if($type === 'default') return $chars; 

                        $text = preg_replace('~\033\[[0-9;]*[A-Za-z]~', "", $chars);

                        if($type === 'state') return str_repeat($text, $modifier->length);

                        if($type === 'length') $modifier->length;

                        return $text; // unknown argument's response

                    };
                    
                    echo $mod($modifier, $loader);
                    usleep(20000);
                    flush();
                }

            }else{
                self::$animeFails = true;
                $animeInfo = Cli::textBuild(Cli::error("closure must be iterable"));
                if(!self::$animeClean) {
                    Cli::clearline();
                    Cli::textView($animeInfo)->break(2);
                } 
                return false;
            }

        }

    }

    private function animeLoadChars(bool $isLoading, string|array|callable $callback, int $posit){

            #Handle String as function call (e.g 'function' as a function)
            if(is_string($callback)){
                $callbackArr = [];
                $callbackArr[0] = $callback;
                $callbackArr[1] = [];
            }      
            
            #Handle current class/method call (e.g ['method'] as current class method) 
            else if(is_array($callback) && (count($callback) === 1) && !is_array($callback[0])){
                $callbackArr = [];
                $callbackArr[0] = [$this, $callback[0]] ;
                $callbackArr[1] = []; //attach no arguments
            }
            $callback = $callbackArr ?? $callback;  

            #Handle two keys (e.g [key1, key2]) 
            if(is_array($callback) && count($callback) == 2) {

                #Handle two string keys (e.g ['class', 'method'] with no arguments) 
                if(!is_array($callback[0]) && is_string($callback[1])){
                    $callback[0] = [$callback[0], $callback[1]];
                    $callback[1] = [];
                } 
                #Note: [string , array ] => [function, args]
                #Handled second array value
            }

            $callback[1] = [ $callback[1] ?? [] ];

            /** This is automatically called by the function after successful completion */
            if(!$isLoading) {
                
                if(is_callable($callback)) {
                    if($callback instanceof \Closure){
                    $response = $callback();
                    if($response) print $response;
                    }else{
                        call_user_func_array($callback[0], $callback[1]);
                    }
                }
                
                return true;
            }
            if(is_callable($callback[0])) { 
                $loop = call_user_func_array($callback[0], $callback[1]);
                
                if(!is_iterable($loop)) {
                    self::$animeFails = true;
                    self::$animeState = 'animeLoadChars';
                    self::$animeInfo['default'] = Cli::textBuild(Cli::error('argument supplied is not runnable.'));
                    self::$animeInfo['basic'] = Cli::error('argument supplied is not runnable.');
                    if(!self::$animeClean) {
                         Cli::textView(self::$animeInfo['default'])->break(2);
                    }
                    return false;
                }

                Cli::hideCursor();
                $charsDisplay = '' ; $loops = 0;
                foreach($loop as $process){
                    $loops++;
                    if(is_bool($process)){
                        if($process === false){
                            if(!self::$hideCursor)Cli::showCursor();
                            return false;
                        }elseif($process === true){
                            if(!self::$hideCursor)Cli::showCursor();
                            return true;
                        }
                    }

                    $j = 1; 

                    
                    $charsDisplay .= '.';

                    //cycles progress bar at least 5 times for each yield
                    for($i = 0; $i <= 5; $i++) {

                        //choose animation type
                        $chr = self::$animes[self::$anime]; //updatable

                        //set animation character's position
                        if($posit > (count($chr) - 1)) {
                            $posit = 0; $j = 1;
                        }

                        if($j > 4){ $j = 1; }

                        //choose animation character to display
                        $char = $chr[$posit];
                        if(self::$anime === 'dotmin'){
                            $char = str_repeat('.', $i).$char;
                        }
                        if(self::$anime === 'dotmax'){
                            $char = $charsDisplay.str_repeat('.', $i).$char;
                        }
                        if(self::$anime === 'dotted'){
                            $char = $charsDisplay.$char;
                        }
                      
                        Cli::clearLine();
                        Cli::textView(self::$textPlay.$char);
                        usleep(self::$loadTime);  
                        $posit++; $j++;
                        
                    }

                    usleep(200000);

                }   
                
                /* 
                Smooth Grow Animation Sample 
                if(!empty($char)) {
                    $state = ''; 
                    $values = [0, 10, 45, 48, 40, 39, 50, 5];
                    $prev = 0;

                    foreach($values as $val){
                        $diff = $val - $prev;
                        $steps = abs($diff);
                        $sleep = 15000; //10ms 

                        for($i=0; $i <= $steps; $i++){
                            $current = $prev + ($diff > 0? $i : -$i);
                            $bar = str_repeat(' ', $current);
                            Cli::clearLine();
                            echo Cli::bgAlert($bar);
                            usleep($sleep);
                        }

                        sleep(1);
                        $prev = $val;
                    }
                } */
            } else {
                if(is_array($callback[0]) && (count($callback[0]) === 2) && is_object($callback[0][0])){
                    //$class = $callback[0][0];
                    $method = $callback[0][1];
                    $text = Cli::error('command "'.$method.'" supplied is not runnable.');
                    $textBuild = Cli::textBuild(Cli::error('command "'.Cli::warn($method).'" supplied is not runnable.'));
                }else{
                    $text = Cli::error('argument supplied is not runnable.');
                    $textBuild = Cli::textBuild(Cli::error('argument supplied is not runnable.'));
                }
                self::$animeFails = true;
                self::$animeInfo['default'] = $textBuild;
                self::$animeInfo['basic'] = $text;
                if(!self::$animeClean) {
                    Cli::textView(self::$animeInfo['default'])->break(2);
                }
                Cli::showCursor();
                return false;
            }
        
            if(!self::$hideCursor)Cli::showCursor();
    }  

    /**
     * This method is an alias to {@see CliInput::input}. It facilitates reading of individual key presses from CLI input.
     *   - It requires 'stty' command and 'pcntl' extension.
     *   - It tries to supports reading of special keys (e.g arrows, function keys, home, end, ...).
     *   - It reads escape sequences incrementally until a terminator is seen (letters or '~').
     *   - It returns friendly key names like HOME, END, DELETE, INSERT, PAGEUP, PAGEDOWN, F1..F12.
     *   - Produces modifier-aware names (e.g. CTRL+UP, SHIFT+DOWN) using private static comboKeys().
     *   - Emits raw ESC sequences only if unrecognised so callers can inspect .char directly.
     *   - For supported signals, check {@see CliKey::SIGNALS}
     * 
     * @param Closure $callback a callback function that receives a CliKey object on each key press.
     *   - CliKey properties:
     *    - - char → the raw character(s) read from input
     *    - - ascii → the ASCII code of the first character
     *    - - key → the friendly key name (e.g. UP, CTRL+C, F1, etc)
     *    - - isSignal → true if the key represents a caught signal (e.g SIGINT,SIGTERM,SIGTSTP).
     *    - - input → the internal input object with read(), open(), close() methods
     *    - - close() → method to close input reading
     */
    static function input(Closure $callback){
        CliInput::input($callback);
    }
    
    // /**
    //  * This method requires stty & pcntl to retrieve inputs
    //  *
    //  * @param Closure $callback
    //  * @return mixed
    //  */
    // static function input(Closure $callback){
      
    //   Cli::requires('stty', fn() => Cli::textPlain('Cli input requires stty') );
    //   Cli::requires('pcntl', fn() => Cli::textPlain('Cli input requires pcntl extension') );

    //   $input = new stdClass;
    //   $open = trim(shell_exec('stty -g'));
    //   $input->open = function() {
    //       //open input reader
    //       system('stty -echo -icanon min 1 time 0'); //requires stty
    //   };

    //   $input->close = function() use($input,$open){
    //       // close input reader
    //       system('stty sane'); //requires stty
    //       //   shell_exec('stty ' . escapeshellarg($open));
    //       $input->reading = false;
    //       if(!self::$hideCursor) Cli::showCursor();
    //   };
    //   $input->read = function($length = 1) {
    //       // read from inputs
    //       return fread(STDIN, $length);
    //   };
      
    //   /** appends 2 more characters length to make a total of 3 characters */
    //   $input->key = function ($char) use($input) {
    //       $char .= ($input->read)(); // append 1 character
    //       if ($char === "\033[") {
    //         $char .= $text = ($input->read)(); // append 1 character
    //       }
    //       return [$char, $text??false];
    //   };
      
      
    //   $input->isArrow = function(){
    //     return false;
    //   };
      
    //   ($input->open)(); //open stty

    //   $input->previous = '';
      
    //   $input->reading = true;

    //   Cli::useSignals([SIGINT, SIGTERM, SIGTSTP], function($signal) use($input, $callback) {
    //     $callback(new CliKey($signal, $input, true));
    //     ($input->close)();
    //   });

    //   while ($input->reading) {

    //         // // Check for available keypress
    //       $readStreams = [STDIN];
    //       $writeStreams = null;
    //       $exceptStreams = null;
    //       $hasInput = stream_select($readStreams, $writeStreams, $exceptStreams, 0, 10000);

    //       if($hasInput){

    //         $key = ($input->read)();

    //         $input->isArrow = function(){
    //             return false;
    //         };

    //         if ($key !== false) {
    //             $ascii = ord($key);
                
    //             $input->char = $key;
    //             $input->ascii = $ascii;

    //             if($ascii === 1) {
    //                 $support = true;
    //                 $key = 'CTRL-A';
    //             }
                
    //             // Detect Enter (Carriage Return, ASCII 13)
    //             if (($ascii === 13) || ($ascii === 10)) {
    //                 $support = true;
    //                 $key = 'ENTER';
    //             }
    //             // Detect Tab (ASCII 9)
    //             elseif ($ascii === 9) {
    //                 $support = true;
    //                 $key = 'TAB';
    //             }

    //             // Detect Backspace (ASCII 8 or 127)
    //             elseif ($ascii === 8 || $ascii === 127) {
    //                 $support = true;
    //                 $key = 'BACKSPACE';
    //             }

    //             // Detect arrow keys (escape sequences starting with \033)
    //             elseif ($ascii === 27) {  // Escape sequence start 
    //                 $keys = ($input->key)($key);

    //                 switch ($keys[1]) {
    //                     case 'A': 
    //                         $input->char = $keys[0];
    //                         $key = "UP";
    //                         break;
    //                     case 'B': 
    //                         $input->char = $keys[0];
    //                         $key = "DOWN";
    //                         break;
    //                     case 'C':
    //                         $input->char = $keys[0]; 
    //                         $key = "RIGHT";
    //                         break;
    //                     case 'D': 
    //                         $input->char = $keys[0];
    //                         $key = "LEFT";
    //                         break;
    //                 } 

    //                 $support = true;

    //                 $input->isArrow = function($keypressed = null) use($key) {
    //                     if(func_num_args() > 0){
    //                         return strtolower($keypressed) === strtolower($key);
    //                     }
    //                     return isset($key) && in_array($key,['UP','DOWN','LEFT','RIGHT']); 
    //                 };

    //                 $home = $keys[1] === 'H';
    //                 if($home) $key = 'HOME';

    //                 $end = $keys[1] === 'F';
    //                 if($end) $key = 'END';

    //                 if(is_numeric($keys[1])){

    //                     $k1 = $keys[1];
    //                     $k2 = ($input->read)(); // read second character

    //                     $keys[0] .= $k2;
    //                     $ks = $k1.$k2;

    //                     if($k2 === '~'){
    //                         if($ks === '2~'){
    //                             $key = 'INSERT';
    //                         }
    //                         if($ks === '3~'){
    //                             $key = 'DELETE';
    //                         }
    //                         if($ks === '5~'){
    //                             $key = 'PAGEUP';
    //                         }
    //                         if($ks === '6~'){
    //                             $key = 'PAGEDOWN';
    //                         }
    //                         $input->char = $keys[0];
                            
    //                     }elseif($k2 === ';'){

    //                         if($k1 === '1'){
    //                             // Handle Next 2 characters sequence
    //                             $k3 = ($input->read)();
    //                             $k4 = ($input->read)();
    //                             // ddump($k4);
    //                             $keys[0] .= $k3;
    //                             $input->char = $keys[0];
    //                             if($k3 === '5'){
                                    
    //                                 // Handle CTRL+Arrow Keys
    //                                 $ctrlArrows = ['A'=>'UP','B'=>'DOWN','C'=>'RIGHT','D'=>'LEFT'];
                                    
    //                                 $key = 'CTRL-'.$ctrlArrows[$k4];

    //                             }

    //                         }

    //                     }elseif(is_numeric($ks)){

    //                         // Handle F5 to F2
    //                         $k3 = ($input->read)();
    //                         $keys[0] .= $k3;
    //                         $input->char = $keys[0];

    //                         if($k3 === '~'){
    //                            $F5_F12 = [
    //                                 '15'=>'F5','17'=>'F6','18'=>'F7','19'=>'F8','20'=>'F9','21'=>'F10','23'=>'F11','24'=>'F12',
    //                             ];
    //                             if(array_key_exists($ks, $F5_F12)){
    //                                 $key = $F5_F12[$ks];
    //                             }
    //                         }
    //                         $ks .= $k3;

    //                     }
    //                 }

    //                 ddump($key);
    //             }
    //             else {
    //                 // Detect other keys
    //                 // echo "You pressed: $key (ASCII: $ascii)\n";
    //                 $support = false;
    //             }
                
    //             $response = $callback(new Clikey($key, $input));  
    //         }
    //       }
    //       pcntl_signal_dispatch();
    //   }
      


    //   return $response;
    // }

    public static function keyboard(?Closure $callback = null) {

        function setRawMode() {
          system('stty -echo -icanon min 1 time 0'); //requires stty
        }

        // Function to read a character from the terminal
        function readChar() {
          return stream_get_contents(STDIN, 1);
        }

        // Function to read arrow keys
        function readArrowKey() {
            $char = readChar();
            if ($char === "\033") {
                $char .= readChar();
                if ($char === "\033[") {
                    $char .= readChar();
                }
            }
            return $char;
        }
       

        // Function to process arrow keys
        function keyboard(Closure $callback) {
            $control = new stdClass;
        
            $control->exit = function() {
                // Reset terminal to its default settings
                system('stty sane'); //requires stty
            };
            setRawMode();

            //echo "Press arrow keys (up, down, left, right) or 'q' to quit.\n";
            $read = true;
            while ($read) {
                $char = readArrowKey();
                switch ($char) {
                    case "\033[A":
                        $callback('up', $control);
                        break;
                    case "\033[B":
                        $callback('down', $control);
                        break;
                    case "\033[C":
                        $callback('right', $control);
                        break;
                    case "\033[D":
                        $callback('left', $control);
                        break;
                    default:
                        $callback($char, $control);
                        break;
                }
            }
        }

        // Call the function to process arrow keys
        keyboard($callback);

    }

    // Function to count the occurrences of "yield" in the source code of an anonymous function
    private static function countYields(Closure $closure) {
        // Use ReflectionFunction to get the source code of the closure
        $reflection = new ReflectionFunction($closure);
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
    
        // Get the source code of the closure as an array of lines
        $source = file($fileName);
        $functionSource = array_slice($source, $startLine - 1, $endLine - $startLine + 1);
        
        // Convert the function source to a string
        $functionCode = implode("", $functionSource);
    
        // Count the number of times "yield" appears in the function code
        $yieldCount = substr_count($functionCode, 'yield');
        
        return $yieldCount;
    }

    /**
     * Add some padding to animated charaters
     *
     * @param string $chr
     * @return string
     */
    private function animePadd($chr) : string {
        if(self::isSpecial()) return ' '.$chr.' ';
        return $chr;
    }

    /**
     * Check if animation characters are special characters
     *
     * @return boolean
     */
    private static function isSpecial() : bool {
        return in_array(self::$anime, self::$spchars);
    }

    /**
     * Clears console
     *
     * @return Cli
     */
    public static function cls() : Cli{
        echo "\033[2J\033[;H";
        usleep(20000); // prevent glitching screen on terminal
        return self::instance();
    }

    /**
     * Returns a string of dots based on required number of strings to be generated
     *
     * @param integer $total total number of characters to be generated
     * @param string $text string character provided
     *  - Note that the total number of characters to be generated (i.e arg(#1)) must be 
     *    greater than the number of characters in the text provided (i.e arg(#2))
     * @return string 
     */
    public static function dots(int $total, string $text = '', $char = ".") : string{
        
        $textNum = mb_strlen($text);

        if($total > $textNum){
            $dotsNum = $total - $textNum;
        }else{
            //$text = limitChars($text, $total);
            $dotsNum = 0;
        }

        return str_repeat($char, $dotsNum);

    }

    /**
     * Store any data type for use later
     *  - This may overwrite existing data
     * @param integer $index
     * @param mixed $value
     * @param boolean $exec determines if a closure value should be executed once.
     * @return mixed 
     *   Returns exact value supplied or value returned by a closure if closure was supplied 
     */
    public static function save(int $index, $value, bool $exec = false){
        
        self::$storage[$index] = $value;
        
        if($exec && ($value instanceof closure)){
            return $value();
        }

        return $value;
    }

    /**
     * Call any closure function using index name if it exists in storage
     *
     * @param integer $index
     * @return mixed dependent on what function returns (or void)
     */
    public static function fn(int $index){

        if(isset(self::$storage[$index]) && (self::$storage[$index] instanceof Closure)){
           return self::$storage[$index]();
        }

    } 

    
    /**
     * Cli prompt
     *
     * @param array $options Valid options to be tested
     *   - Note : use ['::nocase'=>'true'] for case insensitive options validation.
     * @param \Closure $callback callback function to be applied on option that takes {@see CliPrompt} object.
     * @param bool|int $terminate terminate prompt (in number of times) if option is not valid
     *    - True terminates once
     *    - Integers determines the number of acceptable error times 
     * @return CliPrompter|string
     */
    public static function prompt(array $options = [], ?Closure $callback = null, bool|int $terminate = false): CliPrompter|string {
        static $counter = 0;

        /* @var array $argument prompt arguments supplied  */
        $arguments = func_get_args();

        /* @var array $argumentc number of prompt arguments supplied  */
        $argumentc = func_num_args();

        $trials = $counter++; 
        $mainOptions = $options;
        unset($options['::nocase']);

         // use a fourth internal argument of FALSE to determine an ongoing prompt cycle
        // $isFirstPrompt = ( ($argumentc > 3) && ($arguments[3] === false) )? false : true;
        $xterminate = false;
        $isFirstPrompt = ($argumentc < 4) && ($trials === 0);
        $suspend = (($argumentc > 3) && ($arguments[3] instanceof CliPrompt));

        if($suspend){ 
            /** @var CliPrompt */
            $promptObj = $arguments[3];
            $val = self::$prompt['val'] ?? '';

            if(!$promptObj->maximum() && !$options){ 
                
                if($callback){
                    $userInput = fn() : string => self::$prompt['val'] ?? '';
                    $userTrials = function($option = '') use($trials)   { 
                        if($option === 'active') return false;
                        return ($trials); 
                    };
                    $invalid = true; $exceeded = false; $max = false;

                    $CLIPrompt = self::ghostPrompt($userInput, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $max);
                    $prompter = self::prompter($CLIPrompt);
                    $callback($CLIPrompt, $options, self::$prompt);
                }
            }

            // if(!isset($prompter)){
            //     $userInput = fn() : string => self::$prompt['val'] ?? '';
            //     $userTrials = function($option = '') use($trials)   { 
            //         if($option === 'active') return false;
            //         return ($trials); 
            //     };
            //     $invalid = $promptObj->invalid(); $exceeded = $promptObj->exceeded(); $max = $promptObj->maximum();
            //     $CLIPrompt = self::ghostPrompt($userInput, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $max);
            //     $prompter = self::prompter($CLIPrompt);
            //     print 'ggg'.$prompter->inactive();
            // }

            $prompter = isset($prompter) ? $prompter : self::prompter($promptObj);
            
            $counter = 0;
            return $prompter;
            // return $val;
        }

        if($isFirstPrompt){
            self::$prompt = [];
            if(is_int($terminate)) self::$prompt['maximum_accepted'] = $terminate;

            $userInput = fn() => self::$prompt['val'] ?? '';
            $userTrials = function($option = ''){ 
                if($option === 'active') return true;
                return 0; 
            };
            $invalid = true; $exceeded = false; $max = false;
            self::$prompt['invalid'] = true;

            $CLIPrompt = self::ghostPrompt($userInput, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $max);
            
            // initialize callback at the first prompt where trial is 0.
            if($callback) $xterminate = $callback($CLIPrompt, $options, self::$prompt);
            if($xterminate && !$options) $terminate = true;
        }elseif($arguments[3] === false){
            $terminate = true; // terminate if fourth argument is false
        }

        if(is_int($terminate) && ($terminate === $trials) && (!$isFirstPrompt)){

            self::$prompt['maximum'] = true;
            self::$prompt['invalid'] = true;
            self::$prompt['trials'] = $trials;
            self::$prompt['terminate'] = $terminate;

            $userInput = fn() => self::$prompt['val'] ?? '';
            $userTrials = fn($option) => ($option === 'active')? false: $trials;
            
            $invalid = true;
            $exceeded = fn() => is_int($terminate)? ($terminate === $trials) : false;
            $maximum = fn() => self::$prompt['maximum'] ?? false;

            $CLIPrompt = self::ghostPrompt($userInput, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $maximum);
            
            // last trial's callback function
            if($callback) self::prompt($options, $callback, true, $CLIPrompt); // suspend (i.e fourth CliPrompt arg suspends)

            return self::prompter($CLIPrompt);
            // return self::$prompt['val'] ?? ''; // end prompt and return value
        }else if($terminate === true){
            self::$prompt['trials'] = $trials;
            self::$prompt['terminate'] = $terminate;
            $userTrials = fn($option) => ($option === 'active')? false: $trials;
            // fix these...
            $invalid = true;
            $exceeded = true;
            $maximum = is_int($terminate)? $trials === $terminate : false;

            if($trials > 0) {

                $val =  self::$prompt['val'] ?? '';

                $CLIPrompt = self::ghostPrompt($val, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $maximum);

                return self::prompter($CLIPrompt); // Return prompt's value for last cycle (No callback)
            }
        }

        $input = CliInput::read();

        $trials++;
        $promptCases = self::promptCase($input, $mainOptions);
        $promptInput = $promptCases['input'];
        $promptOptions = $promptCases['options'];

        // process and resolve input ..........................................................................
        
        self::$prompt['val'] = $input;

        if($argumentc > 0){

            if($options){
                if(in_array($promptInput, $promptOptions)){

                    self::$prompt['invalid'] = false;
                    
                    $userTrials = function($option = '') use($counter){ 
                        if($option === 'active') return false;
                        return $counter; 
                    };
                    $invalid = false;
                    $exceeded = fn() => is_int($terminate)? ($terminate === $counter) : false;
                    $maximum = fn() => self::$prompt['maximum'] ?? false;
                    
                    $GhostFunction = self::ghostPrompt($input, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $maximum);

                    if($callback) {
                        $response = $callback($GhostFunction, $options, self::$prompt);  
                        $terminate = $response? true : $terminate;
                    }
                    return self::prompt($mainOptions, $callback, $terminate, $GhostFunction); 
                }else{
                    // Execute this block for invalid arguments
                    self::$prompt['trials'] = $counter;
                    self::$prompt['terminate'] = $terminate;
                    self::$prompt['invalid'] = true;
                    self::$prompt['maximum'] = (is_int($terminate) && ($terminate === $counter));

                    $userTrials = function($option = '') use($counter, $terminate, $xterminate){ 
                        if($option === 'active') {
                            if($terminate === true || $xterminate) return false;
                            if(is_int($terminate) && ($counter === $terminate)) return false;
                            return true;
                        }
                        return $counter; 
                    };
                    $invalid = true;
                    $exceeded = fn() => is_int($terminate)? ($terminate === $trials) : false;
                    $maximum = fn() => self::$prompt['maximum'] ?? false;
                    
                    $GhostFunction = self::ghostPrompt($input, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $maximum);

                    if($callback) {
                        $response = $callback($GhostFunction, $options, self::$prompt);  
                        $terminate = $response? true : $terminate;
                    }
                    
                    if( (is_bool($terminate) || is_int($terminate)) ){
                        $flow = (is_int($terminate) && ($terminate === $counter))? $GhostFunction : true; // suspend immediately due to max or continue.
                        return self::prompt($mainOptions, $callback, $terminate, $flow); 
                    }else{
                        Cli::break(1);
                    }

                }
            }elseif(!$options){ 
                // Execute this block when no option range is supplied

                if(($terminate === false || is_int($terminate)) && empty($input)){

                    self::$prompt['trials'] = $trials;
                    self::$prompt['terminate'] = $terminate;
                    self::$prompt['invalid'] = true;
                    self::$prompt['maximum'] = (is_int($terminate) && ($terminate === $counter));

                    $userTrials = function($option = '') use($trials, $terminate, $xterminate){ 
                        if((is_int($terminate) && ($trials === $terminate)) || $xterminate) return false;
                        if($option === 'active'){
                            if(is_int($terminate) && ($trials < $terminate)){
                                return true;
                            }elseif(is_bool($terminate)){
                                if(!$terminate && !$xterminate) return true;
                                if($terminate || $xterminate) return false;
                            }
                            return false;
                        }
                        return $trials; 
                    };
                    $invalid = true; $exceeded = false;
                    $max = fn() => self::$prompt['maximum'] ?? false;

                    $CLIPrompt = self::ghostPrompt($input, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $max);
                    if($callback) {
                       $response = $callback($CLIPrompt, $options, self::$prompt);  
                       $terminate = $response? true : $terminate; // terminate with callback returning truthy response
                       if($response){
                          return self::prompt($mainOptions, $callback, $terminate, $CLIPrompt);
                       }
                    }
                    self::prompt($mainOptions, $callback, $terminate, true);
                }else{

                    // $userTrials = fn() => $trials;
                    $userTrials = function($option = '') use($trials){ 
                        if($option === 'active') return false;
                        return $trials; 
                    };
                    $invalid = true;
                    $exceeded = true;
                    $max = is_int($terminate) && $trials === $terminate;
                    $CLIPrompt = self::ghostPrompt($input, $mainOptions, $userTrials, $terminate, $invalid, $exceeded, $max);
                    
                    // default:: if no options, keep asking till a value is returned.
                    if($callback) {
                       $response = $callback($CLIPrompt, $options, self::$prompt);  
                       $terminate = $response? true : $terminate; // terminate with callback returning truthy response
                        //    if($response){
                        //       return self::prompt($mainOptions, $callback, true, $CLIPrompt);
                        //    }
                    }

                    return self::prompt($mainOptions, $callback, true, $CLIPrompt);
                   
                }
                
            }
        
        }

        $counter = 0; $val = self::$prompt['val'] ?? '';
        if($options && !in_array($promptInput, $promptOptions)) self::$prompt['invalid'] = true;
        $userTrials = function($option = '') use($trials, $val){ 
            if($option === 'active') return false;
            return $trials; 
        };

        $CLIPrompt = self::ghostPrompt($val, $mainOptions, $userTrials, $terminate, self::$prompt['invalid'], true, true);

        return self::prompt($options, $callback, true, $CLIPrompt);

        /// GhostPrompt ... 
        // return self::$prompt['val'] ?? '';
    }

    
    /**
     * Runs an interactive shell, evaluating each line typed at the prompt.
     *
     * @param $callback receives a {@see CliCast} for every line typed, before that
     *                  line is evaluated. The callback may claim the line with
     *                  CliCast::handled(), leaving it unevaluated, so that an
     *                  application can add commands of its own with PHP evaluation
     *                  as the fallback. Returning TRUE ends the session, as with the
     *                  callback of {@see Cli::prompt()}.
     * @return void
     */
    static function cast(?Closure $callback = null) {

        $scope = [];

        // a loop rather than a recursive call: each recursion opened a new scope,
        // so a variable assigned on one line was already gone by the next, and the
        // stack grew for the whole length of the session
        while(true) {

            print "> ";
            $value = self::prompt();
            //print $value;

            // prompt() returns a CliPrompter, whose __toString() carries the line
            $input = trim((string) $value);

            if($input === '') {
                // fgets() keeps returning nothing once the stream is spent, which
                // spins this loop forever on piped or redirected input. An empty
                // line typed at a live terminal is not at end of stream, so it
                // still just moves on to the next prompt.
                if(defined('STDIN') && feof(STDIN)) break;
                continue;
            }

            // the callback sees the line first and may claim it, so that an
            // application can answer commands of its own and leave everything
            // else to be evaluated as PHP
            if($callback) {

                $handled = false;
                $stopped = false;

                $response = $callback(self::caster($input, $scope, $handled, $stopped));

                if($stopped || ($response === true)) break;
                if($handled) continue;

            }

            // a line typed at a prompt carries no terminator, and eval() rejects a
            // statement without one: 'echo 1' is a ParseError where 'echo 1;' is not
            $code = (str_ends_with($input, ';') || str_ends_with($input, '}'))? $input : $input.';';

            extract($scope, EXTR_SKIP);

            try {

                try {
                    // tried as an expression first, so '1+1' or '$a' report a value
                    // the way a shell is expected to. Statements (echo, if, foreach)
                    // do not parse as one and run below instead. A parse failure
                    // executes nothing, so no line can be evaluated twice.
                    $result = eval("return {$input};");
                    if($result !== null) print var_export($result, true).PHP_EOL;
                } catch (\ParseError $parse) {
                    eval($code);
                    print PHP_EOL;
                }

            } catch (\Throwable $error) {
                // without this, the first typo ends the session
                $errorType = get_class($error);
                print Cli::infoView(" {$errorType} ", $error->getMessage(), break: '1|1');
            }

            // carry the variables into the next line
            $scope = array_diff_key(get_defined_vars(), array_flip(
                ['scope', 'value', 'input', 'code', 'result', 'parse', 'error',
                 'callback', 'handled', 'stopped', 'response']
            ));

            echo PHP_EOL;

        }

    }

    /**
     * Creates the CliCast handed to the callback of {@see Cli::cast()}.
     *
     * @param string $input the line typed at the shell
     * @param array $scope variables carried over from the lines already evaluated
     * @param bool &$handled set when the callback claims the line, leaving it unevaluated
     * @param bool &$stopped set when the callback ends the session
     * @return CliCast
     */
    private static function caster(string $input, array $scope, bool &$handled, bool &$stopped) : CliCast {

      $GhostFunction = new GhostFunction(['::input', 'scope', 'handled', 'stop']);

      $GhostFunction->input(fn() => $input);
      $GhostFunction->scope(fn() => $scope);

      $GhostFunction->handled(function(string|null $output = null) use (&$handled) {
          $handled = true;
          if($output !== null) print $output.PHP_EOL;
          // NULL rather than TRUE, so the callback can return this directly without
          // the return value also being read as a request to end the session
          return null;
      });

      $GhostFunction->stop(function() use (&$stopped) {
          $stopped = true;
          return true;
      });

      /** @var CliCast */
      return GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliCast{});
    }

    private static function prompter(CliPrompt $prompt) : CliPrompter {
      // create a Ghost class for prompter

      $GhostFunction = new GhostFunction(['::value', 'options', 'trials', 'valid', 'matches', 'imatches', 'maximum']);
      
      $GhostFunction->value(fn() => $prompt->value());
      $GhostFunction->options(fn() => $prompt->options());
      $GhostFunction->trials(fn() => $prompt->trials());
      $GhostFunction->valid(fn() => $prompt->valid());
      $GhostFunction->maximum(fn() => $prompt->maximum());
      $GhostFunction->matches(fn($options) => $prompt->matches(...func_get_args()));
      $GhostFunction->imatches(fn($options) => $prompt->imatches(...func_get_args()));

      /** @var CliPrompter */
      return GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliPrompter{});
    }

    /**
     * Creates a GhostPrompt 
     *
     * @param string|null $input input from {@see CliInput::read()}
     * @param array $options references the option of a prompt.
     * @param Closure $trials determines the number of trials
     * @param int|bool $terminate determines the mode of termination
     * @param bool $invalid determines if the input option supplied is invalid
     * @param bool|Closure $exceeded determines if the number of trials is exceeded 
     * @param bool|Closure $maximum determines if the maximum number of trials is reached
     * @return CliPrompt
     */
    private static function ghostPrompt(string|Closure|null $input, array $options, Closure $trials, int|bool $terminate, bool $invalid, bool|Closure $exceeded, bool|Closure $maximum) : CliPrompt {
        $GhostFunction = new GhostFunction(['::value', 'options', 'state', 'trials','terminate','invalid','maximum','exceeded','is_case_sensitive']);

        $case_insensitive = $options['::nocase'] ?? false;
        unset($options['::nocase']);
        $GhostFunction->value(is_closure($input)? $input : fn() => $input);
        $GhostFunction->options(fn() => $options);
        $GhostFunction->trials($trials);
        $GhostFunction->terminate(fn() => $terminate);
        $GhostFunction->invalid(fn() => $invalid);
        $GhostFunction->maximum(is_closure($maximum)? $maximum : fn() => $maximum);
        $GhostFunction->exceeded(is_closure($exceeded)? $exceeded : fn() => $exceeded);
        $GhostFunction->is_case_sensitive(fn() => ($case_insensitive === true)? false : true);
        /** @var CliPrompt */
        return GhostProxy::new($GhostFunction, fn(GhostDraft $draft) =>
            new class($draft) extends CliPrompt {}
        );
    }

    /**
     * Open reader mode for WSL environments
     *
     * @param boolean $open
     * @return void
     */
    public static function reader_mode($open = true){
        if(self::sttyEnabled() && self::isTerminal('linux')){
            // Save current stty settings (so we can restore)
            if($open){
                if(!self::$reader_state) self::$reader_state = trim(shell_exec('stty -g'));
                // Disable echo, canonical mode, signals, and extended input in WSL
                shell_exec('stty -echo -icanon -isig -iexten');
            }else{
                if(self::$reader_state) shell_exec('stty ' . escapeshellarg(self::$reader_state));
            }
        }
    }
    
  
  /**
   * Cli Interactive prompt
   *  - Reading only ends with a final semicolon
   * @param string $input returned value
   * @param \Closure $callback callback function to be tested
   * 
   * @return string
   */
   public static function iprompt(string $input = '', ?Closure $callback = null): string {

        $contents = '';

        self::reader_mode();
        
        $handle = fopen('php://stdin',"r");

        if($callback){
            $array = $callback();

            if(is_array($array)){

                $boot = $array['boot'] ?? '';
                $final = $array['final'] ?? '';

                if($boot && !($boot instanceof Closure)){

                    Cli::error('boot of "iprompt" callback must be a closure.', 0, "|2");
                    return false;
                }
                if($final && !($final instanceof Closure)){

                    Cli::error('final of "iprompt" callback must be a closure.', 0, "|2");
                    return false;
                }
            }else{
                Cli::error('callback of "iprompt" must return an array', 0, "|2");
                return false;
            }
            
        }
        
        self::$ipromptCounter = $counter = $starter = 1;
        while(!feof($handle)){
            if($boot ?? '') $boot($starter);
            $starter++;
            $new = fread($handle, 1024);
            if(trim($new) && (trim($new) != ";")) self::$ipromptCounter = $counter++;
            preg_match('~.*?(\)--;?)~', $new, $matches);
            if(isset($matches[0])){
                $new = str_replace(')--', ')- -', $new);
            }
            $contents .= $new;
            if(trim($new) == ";"){
                break;
            }
        };

        fclose($handle);
        
        if($final) $final($contents);

        return $input;

    }

    /** Converts Options and Input to lowercase for better comparison in case insensitive mode */
    private static function promptCase(string $input, array $options) : array {
        
        $nocase = $options['::nocase'] ?? false;
        unset($options['::nocase']);
        if($nocase){
            self::$prompt['::nocase'] = true;
            $input = strtolower($input);
            $options = array_map(fn($val)=>strtolower($val), $options);
        }else{
            self::$prompt['::nocase'] = false;
        }
        return ['input' => $input, 'options'=> $options];
    }

    public static function ipromptCounter() {
        return self::$ipromptCounter;
    }

    /**
     * Open a new stdin prompt channel
     * @param mixed $option optional options to be tested
     *  - Note: set '::case' as lower or upper to specify returned string casing. E.g ['::case'=>'lower'] for lowercase.
     * @param Closure $callback must return an array using specific key indexes: init, test, success, failed, maximum each having a closure value. 
     *  - init callback function will run every time the prompt is recalled
     *  - test callback will contain the test logic which must return a bool value of true or false 
     *  - success callback will be called if the test returns a true value 
     *  - failed callback will be called if the test fails. If the callback returns a true value, Cli::q() will be recalled, else it will be terminated 
     *  - maximum callback will be executed if the maximum number of trials defined by $trials is reached
     * @param integer|null $trials
     * @return boolean|string
     */
    public static function q(mixed $option, Closure $callback, ?int $trials = null, bool $secured = false)  : bool|string|null {
        static $counter = 0;
        
        $mainOption = $option; $case = null;
        if(is_array($option) && isset($option['::case'])){
            $case = $option['::case'];
            $case = in_array($case, ['lower','upper'])? 'strto'.$case : false;
            unset($option['::case']);
        }
        $callbacks = $callback($option);

        if(!isset(self::$q['val']) || ($counter === 0) ) {
            self::$q['val'] = '';
            if($counter === 0) {
                self::$q['max'] = false;
                self::$q['failed'] = false;
            }
        }

        if(is_array($callbacks)){

            //initialize callback argument variables
            $success = '';
            $failed  = '';
            $test    = '';
            $init    = '';
            $maximum = '';

            //test all arguments -----------------------------------------------------------------
            if($counter === 0){
                if(isset($callbacks['init']) && !(($init = $callbacks['init']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "init" must be a closure'), 0,  "|1");
                    return false;
                }
    
                if(isset($callbacks['test']) && !(($test = $callbacks['test']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "test" must be a closure'), 0,  "|1");
                    return false;
                }elseif(!isset($callbacks['test'])) {
                    Cli::textView(Cli::error('q(#2) "test" must be defined'), 0,  "|1");
                    return false;                
                }
    
                if(isset($callbacks['success']) && !(($success = $callbacks['success']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "success" must be a closure'), 0,  "|1");
                    return false;
                }
    
                if(isset($callbacks['failed']) && !(($failed = $callbacks['failed']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "failed" must be a closure'), 0,  "|1");
                    return false;
                }
    
                if(isset($callbacks['maximum']) && !(($maximum = $callbacks['maximum']) instanceof Closure)) {
                    Cli::textView(Cli::error('q(#2) "maximum" must be a closure'), 0,  "|1");
                    return false;
                }
            }else{
                $success = $callbacks['success'] ?? '';
                $failed  = $callbacks['failed']  ?? '';
                $test    = $callbacks['test']    ?? '';
                $init    = $callbacks['init']    ?? '';
                $maximum = $callbacks['maximum'] ?? '';
            }
            
            //Check for maximum trials --------------------------------------------------------------------
            if(is_int($trials) && ($counter === $trials)){
                
                $counter = 0; 
                self::$q['max'] = true;

                if($maximum) {

                    //Define Ghost Function for maximum
                    $GhostFunction = new GhostFunction(['::value','options','count','trials'],'maximum');
                    $GhostFunction->value(fn() => self::$q['val'] ?? '');
                    $GhostFunction->options(fn() => $option);
                    $GhostFunction->trials(fn() => $counter);

                    GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliQuery{});
                    $GhostFunction = GhostProxy::object();

                    $callbacks['maximum']($GhostFunction, $option, $counter);

                }

                $val = self::$q['val'] ?? null;
                if(is_string($val) && $case) return $case($val); 
                return $val;

            }

            //Run inital command --------------------------------------------------------------------------
            if($init) {

                //Define GhostFunction for Init
                $GhostFunction = new GhostFunction(['::value','options','count','trials'], 'init');
                $GhostFunction->value(fn() => self::$q['val'] ?? '');
                $GhostFunction->options(fn() => $option);
                $GhostFunction->trials(fn() => $counter);
                
                GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliQuery{});
                $GhostFunction = GhostProxy::object();

                $init($GhostFunction, $option, $counter);
            }
    
            //Get input supplied --------------------------------------------------------------------------
            // use secure retrieval mode ... 
            self::$q['val'] = CliInput::fetch(hide: $secured);
            $counter++;

            //Define GhostFunction for test && failed
            self::$q['trials'] = $counter;
            if(is_int($trials) && ($counter === $trials)) self::$q['max'] = true;
            $GhostFunction = new GhostFunction(['::value','options','count','trials'], 'test');
            $GhostFunction->value(fn() => self::$q['val']);
            $GhostFunction->options(fn() => $option);
            $GhostFunction->trials(fn() => $counter);

            GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliQuery{});
            $GhostFunction = GhostProxy::object();

            $response = $test(GhostProxy::object(), $option, $counter); //run the test...

            if(!is_bool($response)){
                Cli::textView(Cli::error('q(#2) "test" must return a bool'), 0, "|1");
                $counter = 0;
                return false;                
            }

            if($response === true){
                self::$q['failed'] = false;
                $count = $counter;
                $counter = 0;

                //Define GhostFunction for success
                $GhostFunction = new GhostFunction(['::value','options','count','trials'], 'success');
                $GhostFunction->value(fn() => self::$q['val'] ?? '');
                $GhostFunction->options(fn() => $option);
                $GhostFunction->trials(fn() => $count);
                
                GhostProxy::new($GhostFunction, fn(GhostDraft $draft) => new class($draft) extends CliQuery{});
                $GhostFunction = GhostProxy::object();

                if($success)  $success($GhostFunction, $option, $count);                
                
            }else{
                //Re-prompt only if failed closure returns a true
                self::$q['failed'] = true;
                if($failed && $failed($GhostFunction, $option, $counter) && (self::$q['val'] !== null)) self::q($option, $callback, $trials, $secured);     
            }

        }else{
             Cli::textView(Cli::error('Cli::q(#2) closure argument must return an array'), 0, '|1');
            return false;
        }
        $counter = 0;
        $val = self::$q['val'] ?? null;
        if($val && $case) return $case($val);
        return $val;
    }

    public static function  qFailed() : bool{
        return self::$q['failed']?? false;
    }

    public static function  qValid() : bool{
        return !self::qFailed();
    }
    public static function  qmax() : bool{
        return self::$q['max']?? false;
    }
    public static function  qTrials() : int {
        return self::$q['trials']?? 0;
    }

    /**
     * Checks if the last value entered into the prompt is considered invalid. This can also be used 
     * to check if an input exists in a specified option list.
     *  - Note that if no argument is supplied, the method will assume the last response saved by the 
     *    {@see CliPrompt()} method.
     * @param string $input
     * @param array $options
     * @return boolean
     */
    public static function promptInvalid($input = '', array $options = []) : bool {

        if(func_num_args() === 0) return self::$prompt['invalid'] ?? false;

        $maximum_accepted = self::$prompt['maximum_accepted'] ?? false;

        $prompt = self::$prompt;

        if(is_int($maximum_accepted)){

            if((($prompt['trials'] < $maximum_accepted) || ($prompt['terminate'] === false)) && !in_array($input, $options)) {
                self::$prompt['invalid'] = true;
                return true;
            }

        }else{            
            
            if(($prompt['terminate'] === false) && !in_array($input, $options)) {
                self::$prompt['invalid'] = true;
                return true;
            }
            
        }
        self::$prompt['invalid'] = false;
        return false;
    }

    /**
     * Checks if the last prompt made reached the maximum number of trials
     *
     * @return boolean
     */
    public static function promptIsMax() : bool {
        return self::$prompt['maximum'] ?? false;
    }

    /**
     * Checks if the last input response obtained from {@see Cli::prompt()} matches the specified options. 
     */
    public static function promptMatches(string|array $options) : bool {
        $input = self::$prompt['val'] ?? false;
        $isCaseSensitive = self::$prompt['::nocase'] ?? false;
        if($isCaseSensitive) {
            return in_array($input, $options);
        } else {
            return in_array(strtolower($input), array_map('strtolower', $options));
        }
    }


    /**
     * Clears cursor back in the number of times defined
     * @param $time number of backspace
     *
     * @return void
     */
    public static function backspace(int $time = 1){
        $sp = (in_array(self::$anime, self::$spchars))? '  ' : ' ';
        echo str_repeat($sp.chr(8), $time);
    }

    /**
     * Clears cursor back in the number of times defined
     * 
     * @param $times number of backspace
     * @param $return specifies if back character is printed or directly returned.
     *
     * @return Cli
     */
    public static function back(int $times = 1, bool $return = false) : Cli|string {
        if($return) return str_repeat(chr(8), $times);
        echo str_repeat(chr(8), $times);
        return self::instance();
    }

    /**
     * Uses cursor positioning to clear cursor back in a number of specified times 
     * 
     * @param $times number of backspace
     * @param $return specifies if back character is printed or directly returned.
     *
     * @return Cli
     */
    public static function clearBack(int $times = 1, bool $return = false) : Cli|string {
        // Cli::moveBack(1)->textPlain(' ')->moveBack(1)
        $move =  Cli::getMove(fn() => Cli::moveBack($times));
        $moveBack = $move; // move cursor back 
        $moveBack .= str_repeat(' ', $times);
        $moveBack .= $move; // move cursor back 
        if($return) return $moveBack;
        echo $moveBack;
        return self::instance();
    }

    /**
     * Clear a rectangular region on the terminal.
     *
     * @param array{row:int,col:int} $from  Starting position
     * @param array{row:int,col:int} $to    Ending position
     */
    static function clearRegion(array $from, array $to): void
    {
        $row1 = $from['row'];
        $col1 = $from['col'];
        $row2 = $to['row'];
        $col2 = $to['col'];

        // Normalize order (top → bottom)
        if ($row1 > $row2 || ($row1 === $row2 && $col1 > $col2)) {
            [$row1, $row2] = [$row2, $row1];
            [$col1, $col2] = [$col2, $col1];
        }

        // Same line
        if ($row1 === $row2) {
            Cli::moveTo($col1, $row1);
            echo str_repeat(' ', max(0, $col2 - $col1 + 1));
            return;
        }

        // First line: from col1 → EOL
        Cli::moveTo($col1, $row1);
        echo "\033[K";

        // Middle lines: full clear
        for ($r = $row1 + 1; $r < $row2; $r++) {
            Cli::moveTo(1, $r);
            echo "\033[2K";
        }

        // Last line: from BOL → col2
        Cli::moveTo(1, $row2);
        echo str_repeat(' ', max(0, $col2));
    }


    /**
     * Clears cursor back in a smoothly animated manner. Use this for clean animated back clearing.
     * 
     * @uses Cli::textView writes empty text
     * @uses Cli::back clears back
     *
     * @return Cli|string
     */
    public static function backTrack() : Cli|string {
       Cli::back(1)->textView(" ")->back(1);
       return self::instance();
    }

    /**
     * Clears the console current line
     *
     * @param bool $print TRUE displays while FALSE returns
     * @return Cli
     */
    public static function clearLine(bool $print = true) : Cli|string {
        $clear = "\033[2K\r";
        if(!$print) return $clear;
        echo $clear;
        return self::instance();
    }

    /**
     * Shifts the cursor up the line in the number of times declared
     *
     * @return string
     */
    public static function upLine(int $lines = 1){
        echo "\033[{$lines}A";
    }
    
    /**
     * clears the console line and shifts cusor up in number of times declared
     *
     * @param integer $linesCount
     * @return Cli
     */
    public static function clearUp(int $linesCount = 1) : Cli{
        for($i = 0; $i < $linesCount; $i++){
            echo "\033[2K\r"; //clear line
            echo "\033[A"; //move up
            echo "\033[2K\r"; //clear line
            if($i == (($linesCount) - 2)) usleep(1000); //longer lines
        }
        return self::instance();
    }

    /**
     * clears the console line and shifts cusor up in number of times declared
     *  - Note that this will wipe the entire screen on git bash terminals
     * @param integer $linesCount
     * @return Cli
     */
    public static function bashClear(int $linesCount = 1) : Cli{

        if(isTerminal('git-bash')) self::cls();

        for($i = 0; $i < $linesCount; $i++){
            echo "\033[2K"; //clear line
            echo "\033[A"; //move up
            echo "\033[2K"; //clear line
        }
        usleep(20000); //light delay wipe (resolves glitch on screen)
        return self::instance();
    }

    /**
     * Add a list of items
     * 
     * @param array $array array of keys and string value
     *  - Notice only scalar values will be displayed. 
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @param string $pause pause before or after each text is printed 
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * 
     * @param ?Closure $callback a callback to modify the keys and values of each list item
     * @return void
     */
    public static function List(array $array, string|array|int $spacing = "0|0", string|array|int $break = "0|0", string|array|int $pause = "0|0", ?Closure $callback = null){

        $index = 0;
        array_map(function($value, $key) use($spacing, $break, $pause, $callback, &$index){

            $pauses = Cli::toBreaks($pause);
            $breaks = Cli::toBreaks($break);
            $spaces = Cli::toBreaks($spacing);
            //display list
            Cli::pause(+($pauses[0] ?? 0));
            Cli::break(+($breaks[0] ?? 0));
            Cli::textIndent('',+($spaces[0] ?? 0));
            
            if($callback){
              $data = compact('value','key', 'pause', 'break', 'spaces', 'index');

              $index++;
              
              GhostProxy::new($data, fn(GhostDraft $draft) => new class($draft) extends CliList{});
              $text = $callback(GhostProxy::object()); // takes CliList object as argument.

              if(is_string($text) && trim($text)){
                Cli::textView($text);
              }
            }else{
                if(is_numeric($key)) $key += 1;
                Cli::textView("$key. $value"); //, $spacing, $break, $pause
            }

            Cli::textIndent('',+($spaces[1]) ?? 0);
            Cli::pause(+($pauses[1] ?? 0));
            Cli::break(+($breaks[1] ?? 0));

        }, $array, array_keys($array));

    }


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
        $spaces = self::toBreaks($spacing);
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

    /**
     * Add an icon to a text
     *
     * @param string $icon
     * @param string $text
     * @param integer $indent
     * @param string $color
     * @return string
     */
    public static function label(string $icon, string $text, int $indent = 0, string $color = '') : string {
        return Cli::color(Cli::emos($icon, $indent). ' '. $text, $color);
    }

    /**
     * Adds color to cli text
     * 
     * @param string $text
     * @param string|array $color 
     *  - array are supported only for RGB colors.
     * @param bool $truecolor TRUE enables modern terminal colors for supported terminals.
     *  - Notice: Hexadecimals and RGB colors will automatically be treated as TRUE
     * @return string
     */
    static function color(Closure|string $text, string|array $color = '', bool $truecolor = false){

        $xcolor = ''; $colorStart = $colorClose = '';

        if(self::$truecolor === null) {
            self::$truecolor = CliColor::isSupported(['truecolor','256','16'], $mode); // initialize supported color mode
            self::$colormode = $mode;
        }

        if(is_array($color)){
            if(count($color) !== 3) throw new Error('RGB array color argument must contain exactly 3 values');
            $truecolor = true;
        }else if(is_string($color)) {
            $xcolor = trim(str_replace(' ', '', strtolower($color)));
            $color = array_key_exists($color, self::colormap)? $color : (self::colormap[$color] ?? $color);
           
            if( ($rgb = (substr($xcolor, 0, 4) === 'rgb(')) || $hex = (substr($xcolor, 0, 1) === '#') || CliColor::exists($color)) {
                $truecolor = true;
                if($rgb){
                    $color = str_replace(['rgb(',')'],'',$xcolor);
                }
            }
        }
        
        // Resolve numerical values and color indicators
        if(array_key_exists($xcolor, self::colormap) || ($numerical = is_numeric($xcolor))){
            if(empty($numerical)){
                $color = self::colormap[$xcolor];
                if($color === 'darkmoon') $color = 'yellow';
                $color = '3'.self::$colors[$color]; // convert to numeric
            }else{
                $color = '3'.$xcolor;
            }
            $truecolor = false;
        }

        if($truecolor && self::$truecolor){
            if(!is_array($color)){
                $color = CliColor::build($color, true);
            }
            $color[] = false;
            $colorStart = CliColor::ansiFor(...$color); // using default auto-detection color mode.
            $colorClose = "\033[0m";
        }else{
            if(is_numeric($color) && ($color >= 0 && $color < 10)) $color = '3'.$color;
            if(($color > 29) && ($color < 39)){
                $colorStart = "\033[".$color."m";
                $colorClose = "\033[0m";
            }
        }
    
        if(self::$colorStart) $colorClose = ''; // prevent close 

        if($text instanceof Closure){
            self::$colorStart = true;
            $text = $text();
            self::$colorStart = false;
        }

        return $colorStart.$text.$colorClose;

    }


    /**
     * add colors to cli
     *
     * @param Closure|string $text 
     * @param string $bgcolor background color
     * @param string $color text color
     * 
     * @notice: background color may not render well with color.
     * @return string
     */
    static function bgcolor($text, string|array $bgcolor = '', string|array $color = 'black', bool $truecolor = false){

        $xcolor = ''; $xbgcolor = ''; $colorStart = $colorClose = '';
        
        if(self::$truecolor === null) {
            self::$truecolor = CliColor::isSupported(['truecolor','256','16'], $mode); // initialize supported color mode
            self::$colormode = $mode;
        }

        if(is_array($bgcolor)){
            if(count($bgcolor) !== 3) throw new Error('RGB array bgcolor argument defined on bgcolor must contain exactly 3 values');
            $bgtruecolor = true;
        }else if(is_string($bgcolor)) {
            $bgcolor = array_key_exists($bgcolor, self::colormap)? $bgcolor : (self::colormap[$bgcolor] ?? $bgcolor);
            $xbgcolor = trim(str_replace(' ', '', strtolower($bgcolor)));
           
            if( ($rgb = (substr($xbgcolor, 0, 4) === 'rgb(')) || $hex = (substr($xbgcolor, 0, 1) === '#') || CliColor::exists($bgcolor)) {
                $bgtruecolor = true;
                if($rgb){
                    $bgcolor = str_replace(['rgb(',')'],'',$xbgcolor);
                }
            }
        }
        
        if(is_array($color)){
            $truecolor = true;
            if(count($color) !== 3) throw new Error('RGB array color argument defined on bgcolor must contain exactly 3 values');
        }else if(is_string($color)) {
            $color = array_key_exists($color, self::colormap)? $color : (self::colormap[$color] ?? $color);
            $xcolor = trim(str_replace(' ', '', strtolower($color)));
           
            if( ($rgb = (substr($xcolor, 0, 4) === 'rgb(')) || $hex = (substr($xcolor, 0, 1) === '#') || CliColor::exists($color)) {
                $truecolor = true;
                if($rgb){
                    $color = str_replace(['rgb(',')'],'',$xcolor);
                }
            }
        }

        // Resolve numerical values and background-color indicators
        if(array_key_exists($xbgcolor, self::colormap) || ($numerical = is_numeric($xbgcolor))){
            if(empty($numerical)){
                $bgcolor = self::colormap[$xbgcolor];
                if($bgcolor === 'darkmoon') $bgcolor = 'yellow';
                $bgcolor = '4'.self::$colors[$bgcolor]; // convert to numeric
            }else{
                $bgcolor = '4'.$xbgcolor;
            }
            $bgtruecolor = false;
        }

        // Resolve numerical values and color indicators
        if(array_key_exists($xcolor, self::colormap) || ($numerical = is_numeric($xcolor))){
            if(empty($numerical)){
                $color = self::colormap[$xcolor];
                if($color === 'darkmoon') $color = 'yellow';
                $color = '3'.self::$colors[$color]; // convert to numeric
            }else{
                $color = '3'.$xcolor;
            }
            $truecolor = false;
        }

        if($truecolor && self::$truecolor){
            if(!is_array($color)){
                $color = CliColor::build($color, true);
            }
            $color[] = false;
            $colorStart .= CliColor::ansiFor(...$color); // using default auto-detection color mode.
            $colorClose = "\033[0m";
        }else{
            // if(array_key_exists($color, self::$colors)) $color = '3'.self::$colors[$color];
            if(is_numeric($color) && ($color >= 0 && $color < 10)) $color = '3'.$color;
            if(($color > 29) && ($color < 39)){
                $colorStart .= "\033[".$color."m";
                $colorClose = "\033[0m";
            }
        }

        if(($bgtruecolor??false) && self::$truecolor){
            if(!is_array($bgcolor)){
                $bgcolor = CliColor::build($bgcolor, true);
            }
            $bgcolor[] = true;
            $colorStart .= CliColor::ansiFor(...$bgcolor); // using default auto-detection color mode.
            $colorClose = "\033[0m";
        }else{
            if(is_numeric($bgcolor) && ($bgcolor >= 0 && $bgcolor < 10)) $bgcolor = '4'.$bgcolor;
            if(($bgcolor > 39) && ($bgcolor < 49)){
                $colorStart .= "\033[".$bgcolor."m";
                $colorClose = "\033[0m";
            }
        }

        // ................................................................................................
        // if($truecolor && self::$truecolor){
        //     $addColor = true;

        //     $bgcolor = CliColor::build($bgcolor, true);
        //     $bgcolor[] = true;

        //     $color = CliColor::build($color, true);
        //     $color[] = false;
        //     $colorStart = CliColor::ansiFor(...$color); // using default auto-detection color mode.
        //     $colorStart .= CliColor::ansiFor(...$bgcolor);
        //     $colorClose = "\033[0m";
        // }else{
            
        //     $color = (array_key_exists($color, self::$colors))? '3'.self::$colors[$color] : $color;
        //     if(is_numeric($bgcolor) && ($bgcolor >= 0 && $bgcolor < 10)) $bgcolor = '4'.$bgcolor;
        //     $color = (($color > 29) && ($color < 39))? $color : "" ;
            
        //     if(array_key_exists($bgcolor, self::$colors)) $bgcolor = '4'.self::$colors[$bgcolor];
        //     $addBgColor = ($bgcolor > 39) && ($bgcolor < 49) ;

        //     $colorStart = '';
        //     if($color) $colorStart .= "\033[".$color."m";
        //     if($addBgColor) $colorStart .= "\033[".$bgcolor."m";

        //     $colorClose = "\033[0m";
        // }
        
        if(self::$isStyle){
            $colorClose = '';
        }

        if($text instanceof Closure){
            self::$colorStart = true;
            $text = $text();
            self::$colorStart = false;
        }

        $text = $colorStart.$text.$colorClose;

        return $text;
    }

    /**
     * Adds style to cli text
     *
     * @param Closure $text a closure callback for modifying texts
     * @param string $options specifies font style within the option keys:  
     *  - thick : sets text font to be bold
     *  - light : sets text font to be light
     *  - italic : sets text font to be italic
     *  - underline : underlines a text
     *  - inverse : sets a color contrast
     *  - bgcolor : matches the backgound color
     *  - strike : strike through a text
     * @return string
     */
    static function style(Closure $text, array|string $options = []) : string {

        $options = (array) $options;
        
        $textStyle = '';

        foreach($options as $option){
            if(isset(self::$textStyles[$option])){
                $textStyle .= self::$textStyles[$option].';';
            }
        }

        if($textStyle) $textStyle = "\033[".rtrim($textStyle, ';')."m";

        self::$isStyle = true;
        $text = $text();
        self::$isStyle = false;
        $optionClose = "\033[0m";

        return $textStyle.$text.$optionClose;

    }

    /**
     * Specified by an alert color (blue), attaches a "NOTICE:" prefix before supplied text
     *
     * @param string $text
     * @param int $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function notice(string $text, int $textIndent = 0, $colorInt = 2, string $title = 'NOTICE: '){
        return Cli::textIndent(Cli::color($title, self::colorInt($colorInt, 'alert'), $textIndent)).ltrim($text, ' ');
    }

    /**
     * Specified by a warning color (warn/yellow), attaches a "CAUTION:" prefix before supplied text
     *
     * @param string $text text to be colored
     * @param integer $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function caution(string $text, int $textIndent = 0, string|int $colorInt = 3, string $title = 'CAUTION: ') : string {
        return Cli::textIndent(Cli::color($title, self::colorInt($colorInt,'warn')), $textIndent).ltrim($text,' ');
    }


    /**
 * Specified by a warning color (red), attaches a "WARNING:" prefix before supplied text
     *
     * @param string $text
     * @param integer $textIndent left space margin
     * @param string $colorInt : change text color using predefined integers or color name 
     *      - 0 => black
     *      - 1 => white
     *      - 2 => blue
     *      - 3 => yellow
     *      - 4 => green
     *      - 5 => red
     * @notice: if a color does not exist, it falls back to default color.
     * @return string
     */
    public static function warning(string $text, int $textIndent = 0, $colorInt = 5, string $title = 'WARNING: ') : string {
        return Cli::textIndent(Cli::color($title, self::colorInt($colorInt,'danger')), $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by a success color (green), attaches an "Success:" prefix before supplied text
     *
     * @param string $text
     * @param integer $textIndent left space margin
     * @param string $title error default title
     * @return string
     */
    public static function success(string $text, int $textIndent = 0, string $title = 'Success: ') : string {
        return Cli::textIndent(Cli::color($title, 'valid'), $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by a danger color (red), attaches an "Error:" prefix before supplied text
     *
     * @param string $text
     * @param integer $textIndent left space margin
     * @param string $title error default title
     * @return string
     */
    public static function error(string $text, int $textIndent = 0, string $title = 'Error: ') : string {
        return Cli::textIndent(Cli::color((trim($title)? $title : 'Error'), 'danger'), $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by a danger color (red), attaches an "Failed:" prefix before supplied text
     *
     * @param string $text text to be colored
     * @param integer $textIndent left space margin
     * @return string
     */
    public static function failed(string $text, int $textIndent = 0) : string {
        return Cli::textIndent(Cli::color('Failed: ', 'danger'), $textIndent).ltrim($text,' ');
    }

    /**
     * Specified by an alert color (blue). May also be used to denote code syntax
     *
     * @param string $text text to be colored
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function alert(Closure|string $text, string|array|int $spacing = '0|0') : string {
        return Cli::textBuild(Cli::color($text, 'alert'), $spacing);
    }

    /**
     * Specified by an success color (green). May also be used to denote code syntax
     *
     * @param string $text text to be colored
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function valid(Closure|string $text, string|array|int $spacing = '0|0') : string {
        return Cli::textBuild(Cli::color($text, 'valid'), $spacing);
    }

    /**
     * Specified by a warning color (yellow). May also be used to denote code syntax
     *
     * @param string $text text to be colored
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function warn(Closure|string $text, string|array|int $spacing = '0|0') : string {
        return Cli::textBuild(Cli::color($text, 'warn'), $spacing);
    }

    /**
     * Specified by a danger color (red). May also be used to denote code syntax
     *
     * @param string $text text to be colored
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function danger(Closure|string $text, string|array|int $spacing = '0|0') : string {
        return Cli::textBuild(Cli::color($text, 'danger'), $spacing);
    }
    /**
     * Specified by an alert color (blue). May also be used to denote code syntax
     *
     * @param string $text text to be displayed on the screen
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function bgAlert(string $text, string|array|int $spacing = '0|0') : string {
        return Cli::textBuild(Cli::bgcolor($text, 'alert'), $spacing);
    }

    /**
     * Specified by a success color (green). May also be used to denote code syntax
     *
     * @param string $text text to be displayed on the screen
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     *  - When a single integer is supplied, it is assumed to be a left space. 
     * @return string
     */
    public static function bgValid(string $text, string|array|int $spacing = '0|0') : string {  
        return Cli::textBuild(Cli::bgcolor($text, 'valid'), $spacing);
    }

    /**
     * Specified by a warning color (yellow). May also be used to denote code syntax
     *
     * @param string $text text to be displayed
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function bgWarn(string $text, string|array|int $spacing = '0|0') : string {  
        return Cli::textBuild(Cli::bgcolor($text, 'warn'), $spacing);
    }

    /**
     * Specified by a warning color (white). May also be used to denote code syntax
     *
     * @param string $text text to be displayed
     * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
     *   - int: after
     *   - string: 'before|after'
     *   - array: [before,after]
     * @return string
     */
    public static function bgWhite(string $text, string|array|int $spacing = '0|0'){  
        return Cli::textBuild(Cli::bgcolor($text, 'white'), $spacing);
    }

    /**
     * Specified by a danger color (red). May also be used to denote code syntax
     *
     * @param string $text text to be displayed
     * @param string $spacing left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a right (i.e after) space.  
     *  - Documentation on CLI spacing is available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     * @return string
     */
    public static function bgDanger(string $text, $spacing = '0|0'){      
        return Cli::textBuild(Cli::bgcolor($text, 'danger'), $spacing);
    }

    /**
     * Specified by a neutral color (white). May also be used to denote code syntax
     *
     * @param string $text text to be displayed with background color.
     *   - Note that the default background color (i.e warn color) cannot be modified with this method
     * @param string $spacing left and right space margin separated by pipe
     *  - When a single integer is supplied, it is assumed to be a right (i.e after) space.  
     *  - Documentation on CLI spacing is available at [spoova.com](https://spoova.com/docs/helpers/classes/cli/spacing).
     * @return string
     */
    public static function btn(string $text, $spacing = '0|0'){      
        return Cli::textBuild(Cli::bgcolor($text, 'warn'), $spacing);
    }

    /**
     * This method is designed for handling animations for generators or array list of anonymous functions considered 
     * as animation steps.
     *
     * @param array $handler animation handler. To learn more about this visit [Cli::animeList](https://spoova.com/docs/cli/animeList) for documentation.
     * @param AnimeList $type optional [AnimeList::Yield|AnimeList::Steps]
     *  - AnimeList::Yield for generator functions
     *  - AnimeList::Steps for array list of functions considered as steps
     * @param int|array $length total length of characters to be generated or animations made
     * @return array|Cli
     */
    public static function animeList(array $handler = [], AnimeList $type = AnimeList::Yield, int|array $length = []) : array | Cli{
        
        match($type) {
            // Set the animation type as AnimeList::Yield or AnimeList::Steps
            AnimeList::Yield, AnimeList::YieldGrow => self::$animeList = AnimeList::Yield,
            AnimeList::Steps => self::$animeList = AnimeList::Steps,
            AnimeList::StepsGrow => self::$animeList = AnimeList::StepsGrow,
        };
        
        self::$animeListYields = 0;
        self::$animeListLength = 10;

        if(($type === AnimeList::Yield)){
            if(!is_array($length) || (count($length) !== 2)){
                throw new InvalidArgumentException('Cli::animeList(#arg3) must be an array of two integers');
            }else{
                if(is_array($length[0])){
                    //use array reduction mode 
                    $length[0] = array_reduce($length[0], function($carry, $value){
                        if(!is_numeric($value) || is_float(0+$value) || ((0+$value) === 0)){
                            throw new LengthException('array values must be a valid numerical integer greater than 1');
                        }
                        return $carry += $value;
                    });
                }
                self::$animeListYields = $length[0];
                self::$animeListLength = $length[1];
            }
        } else {
            // AnimeSteps, AnimeStepsGrow (@todo: resolve AnimeYieldGrow)

            $length = (array) $length;
            if(count($length) != 1) {
                throw new LengthException('animation length must be exactly one count for animated steps');
            }

            if(func_num_args() > 2){
                $length = $length[0];
                if(!is_numeric($length) || is_float(0+$length) || ((0+$length) === 0)){
                    throw new LengthException('steps length must be a valid numerical integer greater than 1');
                }
                self::$animeListLength = $length;

            }

            if(self::$anime !== 'percent'){
                // use percentage for AnimeList::step if not defined
                Cli::percent(char: Cli::bgcolor(' ', 'white'));
            }
        }

        if(func_num_args() > 0) return $handler;
        return new self;
    }
    
    private static function open(string $text){
        return "\033[".$text;
    }

    private static function open_close(string $text){
        return "\033[".$text."\033[0m";
    }

    /**
     * Underline through a text
     *
     * @param string $text
     * @return string
     */    
    static function underline(string $text){
        return self::open_close("4m$text");
    }

    /**
     * Change text font style to italics
     *
     * @param string $text
     * @return string
     */    
    static function italics(string $text){
        return self::open_close("3m$text");
    }

    /**
     * Strike through a text
     *
     * @param string $text
     * @return string
     */
    static function strike(string $text){
        return self::open_close("9m$text");
    }

    /**
     * Thicken a text
     *
     * @param string $text
     * @return string
     */
    static function thick(string $text){
        return self::open_close("1m$text");
    }

    /**
     * Lighten a text
     *
     * @param string $text
     * @return string
     */
    static function light(string $text){
        return self::open_close("2m$text");
    }

    /**
     * Alias for {@see Cli::light()}
     *
     * @param string $text
     * @return string
     */
    static function thin(string $text){
        return self::open_close("2m$text");
    }

    /**
     * Move cursor up
     *
     * @param integer $lines number of lines to move up
     * @return Cli|string
     */
    static function moveUp(int $lines = 1) : Cli|string{
        if($lines > 0) {
            if(self::$getMove) return self::open_close($lines."A");
            echo self::open_close($lines."A");
        }
        return self::instance();
    }

    /**
     * Moves the cursor downward to specified number of rows
     *
     * @param integer $lines number of lines to move down
     * @return Cli|string
     */
    static function moveDown(int $lines = 1) : Cli|string {
        if($lines > 0) {
            if(self::$getMove) return self::open_close($lines."B");
            echo self::open_close($lines."B");
        }
        return self::instance();
    }

    /**
     * Moves the cursor forward to specified col
     *
     * @param integer $col
     * @return Cli|string 
     *  - To return ANSI code use within the Cli::getMove() method.
     */
    static function moveFront(int $col = 1) : Cli|string {
        if($col > 0) {
            if(self::$getMove) return self::open_close($col."C");
            echo self::open_close($col."C");
        }
        return self::instance();
    }

    /**
     * Moves the cursor backward to specified col
     *
     * @param integer $col
     * @return Cli|string 
     *  - To return ANSI code use within the Cli::getMove() method.
     */
    static function moveBack(int $col = 1) : Cli|string{
        if($col > 0) {
            if(self::$getMove) return self::open_close($col."D");
            echo self::open_close($col."D");
        }
        return self::instance();
    }

    /**
     * Moves the cursor backward to the beginning of the line
     *
     * @param integer $margin margin or indent from the start position
     * @return Cli|string 
     */
    static function moveStart(int $margin = 0) : Cli|string {
        
        if(self::$getMove){
            $ansi = '';
            $ansi .= self::open_close("\r");
            $ansi .= self::moveFront($margin);
            return $ansi;
        }

        echo self::open_close("\r");
        if($margin){
          self::moveFront($margin);
        }
        return self::instance();
    }

    /**
     * Moves the cursor forward to the end of the line
     *
     * @param integer $margin margin or indent from the start position
     * @return Cli|string 
     */
    static function moveEnd(int $margin = 0) : Cli|string {
        
        if(self::$getMove){
            $ansi = '';
            $ansi .= self::open_close("K");
            $ansi .= self::moveBack($margin);
            return $ansi;
        }

        echo self::open_close("K");
        if($margin){
          self::moveFront($margin);
        }
        return self::instance();
    }

    static function getMove(Closure $function) {

        self::$getMove = true;
        return $function();
        self::$getMove = false;

    }

    /**
     * Moves the cursor to specified row and column using the current cursor 
     * position as the root. This supports negative indexing
     *
     * @param integer $row
     * @param integer $col
     * @return Cli|string 
     */
    static function shiftTo(int $row, int $col) : Cli|string {
        if(self::$getMove){
            $ansi = '';
            if($col >= 0){
                $ansi .= self::moveFront($col);
            }else{
                $ansi .= self::moveBack(abs($col));
            }
            if($row >= 0){
                $ansi .= self::moveDown($row);
            }else{
                $ansi .= self::moveUp(abs($row));
            } 
            return $ansi;
        }
        if($col >= 0){
            echo self::moveFront($col);
        }else{
            echo self::moveBack(abs($col));
        }
        if($row >= 0){
            echo self::moveDown($row);
        }else{
            echo self::moveUp(abs($row));
        }
        // echo self::open($row.";".$col."H"); // this is relative to screen not position
        return self::instance();
    }

    /**
     * Moves the cursor to specified row and column using the current cursor 
     * position as the root.
     *
     * @param integer $col x axis
     * @param integer $row y axis
     * @return Cli 
     */
    static function moveTo(int $col, int $row) : Cli|string {
        if(self::$getMove) return self::open($row.";".$col."H");
        echo self::open($row.";".$col."H"); // this is relative to screen not position
        return self::instance();
    }
    
    /**
     * @todo: refix this method to use grid
     * Moves the cursor to specified row and column
     *  - Note: Highly unstable
     * @param array $xy current horizontal and vertical axis of cursor
     * @param integer $row new row if not null
     * @param integer $col new column if not null
     * @return Cli 
     */
    static function mapTo(array $xy, ?int $row = null, ?int $col = null) : Cli {
        $grid = array_keys($xy);
        $gridX = $grid[0]; //total horizontal columns
        $gridY = $grid[1]; //total vertical rows
        $cursorX = $xy[0] ?? 0; //cursor position on x-axis
        $cursorY = $xy[1] ?? 0 ; //cursor position on y-axis
        
        if(is_numeric($col)){
          //resolve horizontal column
          if($col >=0 && $col <= $gridX){
            //supplied column is within column range
            $advance = $col - $cursorX; //new column - current column
            echo $advance;
            if($advance > 0){
              Cli::moveFront($advance);
            }else{
              Cli::moveBack(abs($advance));
            }
          }
        }
        
        if(is_numeric($row)){
          //Resolve vertical rows. 
          $newRow = $row - $gridY;
          if($row >=0 && $row <= $gridY){
            //supplied column is within row range
            $advance = $row - $cursorY; //new column - old column
            if($advance > 0){
              Cli::moveDown($advance);
            }else{
              Cli::moveUp(abs($advance));
            }
          }
        }
        return self::instance();
    }

    /**
     * Hide cursor
     * 
     * @param Closure|null $callback a callback function that runs through the period when cursor is hidden. 
     *  - when defined, this ensures that the cursor is kept hidden especially when using pulse animations.
     * @param boolean $state reverses the cursor behaviour to default state if set as FALSE
     *
     * @return Cli
     */
    static function hideCursor(?Closure $callback = null, bool $state = true) : Cli {
        if($callback){
            self::$hideCursor = true;
            echo self::open("?25l");
            self::$hiddenCursor = true;
            $callback();
            self::$hideCursor = false;
        }else{
            if($state === false){
                self::$hideCursor = false;
            }else{
                self::$hiddenCursor = true;
                echo self::open("?25l");
            }
        }
        return self::instance();
    }

    /**
     * Show cursor
     * 
     * @return Cli
     */
    static function showCursor() : Cli {
        echo self::open("?25h");
        self::$hiddenCursor = false;
        return self::instance();
    }

    /**
     * Returns true if cursor is visible.
     * 
     * @param boolean|Closure|null $view 
     *  - TRUE or FALSE overides the previous state 
     *  - Closure runs a callback function keeping the state of the cursor. 
     *  - NULL returns the current view state as TRUE or FALSE
     * @param boolean $state sets visibility state of cursor before callback is executed after which it is normalized to previous state. 
     *  - FALSE disables the cursor while TRUE enables the cursor.
     * @return boolean TRUE specifies visible while FALSE specifies hidden.
     */
    static function cursorView(bool|Closure|null $view = null, bool $state = false) : bool {
        if(is_bool($view)) {
            $view? Cli::showCursor() : Cli::hideCursor();
        }elseif(is_closure($view)){
            if($state === null){
                $curstate = self::cursorView();
                $view();
                self::cursorView($curstate);
            }else{
                $curstate = !self::$hiddenCursor;
                self::cursorView($state);
                $view();
                self::cursorView($curstate);
            }
        }
        return !self::$hiddenCursor;
    }

    /**
     * Get cursor position
     *  - This requires stty to be enabled on the terminal
     * 
     * @param string $order optional [row|col]
     *  - If applied, array keys will be numerical where the option specified becomes the first array value.
     * @return array|null
     *  - returns ['row'=>int, 'col'=>int] on success or null on failure.
     * @throws Exception when stty is not enabled
     */
    static function cursorPosition(?string $order = null) {

        if(!Cli::sttyEnabled()) {
            throw new Exception('Getting cursor position requires stty');
        }

        $default_stty = shell_exec("stty -g");

        // Put terminal in raw mode
        shell_exec("stty -echo -icanon min 0 time 5");

        // Ask terminal for cursor position
        echo "\033[6n";

        $response = '';
        while (($c = fread(STDIN, 1)) !== false) {
            $response .= $c;
            if ($c === 'R') break;
        }

        // Restore terminal settings
        shell_exec("stty ".$default_stty);

        if (preg_match('/\[(\d+);(\d+)R/', $response, $m)) {
            $row = (int)$m[1]; $col = (int)$m[2];
            if($order === 'row') return [$row, $col];
            if($order === 'col') return [$col, $row];
            return ['row' => $row, 'col' => $col];
        }

        return null;

    }

    /**
     * Get cursor position. Alias to {@see Cli::cursorPosition()}
     *  - This requires stty to be enabled on the terminal
     * 
     * @param string $order optional [row|col]
     *  - If applied, array keys will be numerical where the option specified becomes the first array value.
     * @return array|null
     *  - returns ['row'=>int, 'col'=>int] on success or null on failure.
     * @throws Exception when stty is not enabled
     */
    static function cursor(?string $order = null) : array|null {
        return self::cursorPosition($order);
    }

    static function testCursor() {
        
        $out = trim(shell_exec(__DIR__.'/cursor.exe get 2>&1'));
        ddump($out);
        if (strpos($out, ',') !== false) {
            list($row, $col) = explode(',', $out);
            return ['row'=>$row,'col'=> ''];
            //echo "Cursor is at row $row, column $col\n";
        } else {
            //echo "Error reading cursor position: $out\n";
        }

        return [];

    }
    /**
     * Blink cursor
     * 
     * @return Cli
     */
    static function blinkCursor() : Cli {
        echo self::open("?12h");
        self::$hiddenCursor = false;
        return self::instance();
    }
    
    /**
     * Save cursor position. Alias of {@see Cli::saveCursorPosition()}
     *
     * @return Cli 
     */
    static function saveCursor() : Cli {
        echo self::open("s");
        return self::instance();
    }
    /**
     * Restore cursor position. Alias of {@see Cli::restoreCursorPosition()}
     *
     * @return Cli 
     */
    static function restoreCursor() : Cli {
        echo self::open("u");
        return self::instance();
    }


    /**
     * Save cursor current position
     *
     * @return Cli 
     */
    static function saveCursorPosition() : Cli {
        echo self::open("s");
        return self::instance();
    }

    /**
     * Restore cursor position after being saved
     *
     * @return Cli 
     */
    static function restoreCursorPosition() : Cli {
        echo self::open("s");
        return self::instance();
    }

    
    /**
     * Converts spacing pipe structure to left and right spaces
     *
     * @param int|string|array $space
     *  - int: before
     *  - string: 'before|after'
     *  - array: [before, after]
     * @return array
     */
    private static function toSpaces($space = '0|0') : array {
        
        $spacel = $space;
        $spacer = 0;

        if(is_array($space)){
            $spacel = $space[0]?? 0;
            $spacer = $space[1]?? 1;
        }else if(strpos($space, '|') !== false){
          $spaces = explode('|',$space);
          $spacel = $spaces[0] ? (int) $spaces[0]: 0;
          $spacer = $spaces[1] ? (int) $spaces[1]: 0;
        }
    
        $spacel = (int) $spacel;
        return [$spacel, $spacer];
    }

    /**
     * Converts spacing pipe structure to before and after breaks format
     *
     * @param int|string|array $break
     *  - int: after
     *  - string: 'before|after'
     *  - array: [before, after] 
     * @return array
     */
    private static function toBreaks(int|string|array $break = '0|0') : array {
        
        $breakl = $break;
        $breakr = 0;
        if(!is_int($break)){
            if(is_array($break)){
                $breakl = $break[0]?? 0;
                $breakr = $break[1]?? 1;
            }else if(strpos($break, '|') !== false){
              $breaks = explode('|',$break);
              $breakl = $breaks[0] ? (int) $breaks[0]: 0;
              $breakr = $breaks[1] ? (int) $breaks[1]: 0;
            }
        }else{
            $breakr = $break; // use direct integer values as break after 
            $breakl = 0;
        }
    
        $breakl = (int) $breakl;
        return [$breakl, $breakr];
    }

    /**
     * Returns a color based on predefined color integers
     *
     * @param string|integer $colorInt
     * @param string|integer $default default fallback color
     * @notice: if fallback color does not exists, a neutral color of white is returned
     * @return string
     */
    private static function colorInt($colorInt = 1, $default = 1) : string {

        if(!is_numeric($colorInt) && is_string($colorInt)){
            $colorInt = (int) array_search($colorInt, self::$colorInt);
        }
        if(!is_numeric($default) && is_string($default)){
            $default = (int) array_search($default, self::$colorInt);
        }
 
       return self::$colorInt[$colorInt] ?? self::$colorInt[$default] ?? 'white';
    }

    /**
     * Check if CLI is git bash
     *
     * @return bool
     */
    public static function isBash() : bool {

        return getenv('OSTYPE') === 'msys' || getenv('MSYSTEM') || strpos(getenv('SHELL'), 'bash') !== false;

    }

    /**
     * Run callback method if test is true
     *
     * @param Closure $callback
     * @return Cli
     */
    public static function escapeView(bool|Closure $test, Closure $callback){

        if(is_bool($test) && $test) {
            $callback();
        }else if(($test instanceof Closure) && ($test() === true)){
            $callback();
        }
        return self::$instance;
    }
    /*
    public static function input($width = 20, $text = ''){
      // Top border
      $field = "┌" . str_repeat("─", $width) . "┐\n";
  
      // Input field line
      echo "│" . str_repeat(" ", ($width - strlen($text))) . "│\n";
  
      // Bottom border
      $field .= "└" . str_repeat("─", $width) . "┘\n";
        
    } */
    
    public static function arrows($width = 20, $text = ''){
      // Top border
      $field = "┌" . str_repeat("─", $width) . "┐\n";
  
      // Input field line
      echo "│" . str_repeat(" ", ($width - strlen($text))) . "│\n";
  
      // Bottom border
      $field .= "└" . str_repeat("─", $width) . "┘\n";
        
    }

    /**
     * Allows appending Cli object as a string or into a string
     *
     * @return string
     */
    public function __toString()
    {
        return '';
    }
    
    /**
     * Check if a command is available. 
     * @return bool
     */
    public static function hasCommand(string $command) : bool{
  
      // For Unix-like systems (Linux, macOS)
      if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
          // Windows: Check if command exists by trying to run it
          $output = [];
          $return_var = 0;
          exec("where $command 2<nul", $output, $return_var);
          return $return_var === 0;
      } else {
          // Unix-like systems: Use which or command -v
          $commandCheck = "command -v $command";
          $output = [];
          $return_var = 0;
          exec($commandCheck, $output, $return_var);
          return $return_var === 0 && !empty($output);
      }
    }

    /**
     * Check if stty is enabled in current terminal
     *
     * @return boolean
     */
    public static function sttyEnabled() : bool {
        try{
            $test = shell_exec('stty -g 2>&1'); // -g prints current settings
            return !str_contains($test, 'not a tty') && trim($test) !== '';
        }catch(Exception $e){};
        return false;
    }
    
    /**
     * Check if a command is available and run a callback function. 
     * - This will exit the CLI if command is not available after the closure is executed.
     * - This can also check if 'pcntl' extension is enabled in CLI.
     */
    public static function requires(string $command, ?callable $callback = null) : bool {
      if($command === 'pcntl'){
        // Check if pcntl is available (it's required for signal handling)
        if (!function_exists('pcntl_signal')) {
           $callback(false);
           exit;
        }
        return true;
      }else{
        if(strtolower($command) === 'stty' && !Cli::sttyEnabled()){
            $callback(false);
            exit;
        }else{
            if(!Cli::hasCommand($command) || !Cli::isTerminal('linux')){
              $callback(false);
              exit;
            }
        }
        return true;
      }
    }
    
    /**
     * Register the action of signals
     *
     * @param array $signals optional or combination of optional values [SIGINT|SIGTERM|SIGTSTP]
     * @param callable $callback
     * @return void
     */
    public static function useSignals(array $signals, callable $callback){

        // Note Re define callbacks to be called & check duplicate CTRL + Z below!!
        $handler = function ($signal) use ($callback) {
            switch ($signal) {
                case SIGINT:
                    $callback(SIGINT, true); // CTRL + C
                    exit;
                case SIGQUIT:
                    $callback(SIGTERM, true); // CTRL + /
                    exit;
                case SIGTERM:
                    $callback(SIGTERM, true); // Termination
                    exit;
                case SIGTSTP:
                    $callback(SIGTSTP, true); // CTRL + Z
                    exit;
                case SIGSTOP:
                    $callback(SIGSTOP, true); // CTRL + Z 
                    exit;
                case SIGCONT:
                    $callback(SIGCONT, true); // CTRL + Z
                    exit;
                case SIGWINCH:
                    $callback(SIGWINCH, true); // Window resize
                    return;
                default:
                    echo "Unsupported signal ($signal) detected!\n";
                    $callback($signal, false);
            }
        };

        // $signalsList = [
        //     WNOHANG, WUNTRACED, WCONTINUED,
        //     SIG_IGN, SIG_DFL, SIG_ERR,
        //     SIGHUP, SIGINT, SIGQUIT, SIGILL,
        //     SIGTRAP, SIGABRT, SIGIOT, SIGBUS,
        //     SIGFPE, SIGKILL, SIGUSR1, SIGSEGV,
        //     SIGUSR2, SIGPIPE, SIGALRM, SIGTERM,
        //     SIGSTKFLT, /* SIGCLD, */ SIGCHLD, SIGCONT,
        //     SIGSTOP, SIGTSTP, SIGTTIN, SIGTTOU,
        //     SIGURG, SIGXCPU, SIGXFSZ, SIGVTALRM,
        //     SIGPROF, SIGWINCH, SIGPOLL, SIGIO,
        //     SIGPWR, SIGSYS, SIGBABY,
        //     PRIO_PGRP, PRIO_USER, PRIO_PROCESS
        // ];
        $signalsList = CliKey::SIGNALS;

        foreach ($signals as $signal) {
            if (!in_array($signal, $signalsList, true)) {
                throw new InvalidArgumentException("Unsupported signal: $signal");
            }
            pcntl_signal($signal, $handler);
        }

    }

    /**
     * Displays a final response message before terminating CLI processes.
     *
     * @param string|integer|boolean|array|null $message 
     *  - Note that ONLY arrays are displayed through PHP {@see var_dump()} function.
     *  - Break will NEVER be added after if $message is NULL.
     * @param integer $breaksAfter number of breaks added after message (not null) is displayed.
     * @return never
     */
    static function exit(string|int|bool|array|null $message = null, int $breaksAfter = 0) {
        if($message !== null){
            if(is_array($message)){
                print var_export($message);
            }else{
                Cli::textPlain($message);
            }
            if($breaksAfter) Cli::break($breaksAfter);
        }
        //self::showCursor(); // display cursor if hidden before exit. (Notice: handled by ErrorHandler)
        exit;
    }
    /**
     * Displays a final response message before terminating CLI processes.
     *
     * @param string|integer|boolean|null|null $message
     * @param integer $breakAfter
     * @return bool
     */
    static function exitAnime(string|int|bool|array|null $message = null, int $breakAfter = 0, bool $yield = false) {
        if($message !== null){
            if(is_array($message)){
                print_r($message);
            }else{
                Cli::textPlain($message);
            }
            if($breakAfter) Cli::break($breakAfter);
        }
        return $yield;
    }
}
