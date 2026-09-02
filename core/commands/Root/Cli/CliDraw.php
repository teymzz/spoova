<?php 

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\commands\Root\Cli;

class CliDraw {

    public static ?CliDraw $instance = null; 

    public static ?bool $canvas = null;
    public static array $textbox = [];

    protected static function instance() : CliDraw {
        if(!isset(self::$instance)) self::$instance = new CliDraw;
        return self::$instance;
    }

    /**
     * Displays a textbox to the screen with a repositioned cursor
     * 
     * @param integer $width width of the text box
     * @param integer $height height of the text box
     * @param integer $indent margin of text box from left side of the screen
     * @param string $color color of the text box
     * @param string $title hiht or title of the text box
     * @param string $shape optional [square|round|clean|] shape of the textbox.
     * @return CliDraw
     */
    public static function textBox(int $width = 20, $height = 1, int $indent = 0, $color = 'white', $title = '', string $shape = 'square') : CliDraw {

        /* Deliberately measures nothing here. textBox() is redrawn on every keypress,
           and measuring the terminal shells out to tput, stty or mode con, which costs
           in the region of a sixth of a second - long enough to be seen as the field
           blinking off and back on while typing. The fitting is done once by each form
           through fitIndent()/fitWidth() before the first draw, so the values arriving
           here already fit the screen. */

        self::$textbox = ['width'=>$width, 'height'=> $height];

        if($shape === 'round'){
            self::roundBox($width, $height, $indent, $color, $title);
        }elseif($shape === 'cap-round'){
            self::captureRound($width, $height, $indent, $color, $title);
        }elseif($shape === 'capture'){
            self::captureSquare($width, $height, $indent, $color, $title);
        }else{
            self::squareBox($width, $height, $indent, $color, $title);
        }
        // Set cursor position inside box 
        $indent += ($shape === 'smart')? 0 : 1;
        self::$textbox['indent'] = $indent;
        Cli::moveUp($height + 1)->moveStart($indent); // first position inside the box
        return self::instance();
    }

    public static function getIndent() : int {
        return self::$textbox['indent']?? 0;
    }

    /**
     * Clamp a left indent so it can never push a box off-screen.
     * Always leaves at least $reserve columns for the box itself.
     *
     * @param integer $indent  requested left margin
     * @param integer $reserve minimum columns to keep for the box (borders + content)
     * @return integer
     */
    public static function fitIndent(int $indent, int $reserve = 8) : int {
        $screen = CliScreen::width() ?: 80;
        return max(0, min($indent, max(0, $screen - $reserve)));
    }

    /**
     * Clamp a box width so indent + borders + width never exceed the screen.
     * If the requested width is wider than the screen, it is reduced to fit.
     *
     * @param integer $width   requested inner width
     * @param integer $indent  left margin already reserved
     * @param integer $borders columns used by the box borders (left + right)
     * @return integer
     */
    public static function fitWidth(int $width, int $indent = 0, int $borders = 2) : int {
        $screen = CliScreen::width() ?: 80;
        $max    = max(1, $screen - $borders - max(0, $indent));
        return max(1, min($width, $max));
    }

    public static function canvas(Closure $handle) : CliDraw {
        self::$canvas = true;
        Cli::hideCursor(); 
        $cursor = Cli::cursor('col');
        $handle(new CliCanvas);  
        Cli::moveTo(...$cursor);
        self::$canvas = false;
        Cli::showCursor();
        return self::instance();
    }

    public static function clearCanvas(int $increase = 0) : CliDraw {
        $cursor = (self::$textbox['height'] ?? 0) + 1;
        Cli::clearUp($cursor + $increase + 2);
        return self::instance();
    }

    /**
     * Delay in seconds
     * alias for wait()
     *
     * @param integer $seconds
     * @return CliDraw
     */
    static function pause(int $seconds) : CliDraw{
        sleep($seconds);
        return self::instance();
    }

    /**
     * Delay in milliseconds
     *
     * @param integer $milliseconds
     * @return CliDraw
     */
    static function wait(int $milliseconds) : CliDraw {
        usleep($milliseconds);
        return self::instance();
    }

    /**
     * Designed method for displaying text
     *
     * @param string $message
     * @param integer $spacing left and right space margins
     * @param string|integer|bool $break add line breaks or TRUE clears the current line.
     *  - string: defines breaks before and after respectively
     *  - integer: defines breaks after only
     *  - bool(TRUE) : clears the current line before display
     * @param integer $pause delay in seconds before and after a text displayed.
     * @return Cli
     */
    public static function textView(string $message, $spacing = '0|0', $break = '0|0', $pause = '0|0') : CliDraw {
        Cli::textPlain(...func_get_args());
        return self::instance();
    }
    
    public static function squareBox(int $width = 20, $height = 1, int $margin = 0, $color = 'white', $title = ''){
        $pad   = str_repeat(' ', max(0, $margin));
        $width = max(0, $width);
        $title = mb_strlen($title)+5 >  $width ? mb_substr($title, 0, max(0, $width - 5))."..." : $title;
        $title = str_repeat("─", 1).$title.str_repeat("─", max(0, $width - (strlen($title)+1)));

        $input['top'] = Cli::color("┌" . $title . "┐", $color)."\n";
        $input['mid'] = Cli::color("│" . str_repeat(" ", $width) . "│", $color)."\n";
        $input['btm'] = Cli::color("└" . str_repeat("─", $width) . "┘", $color)."\n";

        Cli::textView($pad.$input['top']);
        for ($i = 0; $i < $height; $i++) {
            Cli::textView($pad.$input['mid']);
        }
        Cli::textView($pad.$input['btm']);
    }
    
    public static function captureSquare(int $width = 20, $height = 1, int $margin = 0, $color = 'white', $title = ''){
        $pad   = str_repeat(' ', max(0, $margin));
        $width = max(0, $width);
        $title = mb_strlen($title)+5 >  $width ? mb_substr($title, 0, max(0, $width - 5))."..." : $title;
        $title = str_repeat(" ", 1).$title.str_repeat(" ", max(0, $width - (strlen($title)+1)));

        $input['top'] = Cli::color("┌" . $title . "┐", $color)."\n";
        $input['mid'] = Cli::color(" " . str_repeat(" ", $width) . " ", $color)."\n";
        $input['btm'] = Cli::color("└" . str_repeat(" ", $width) . "┘", $color)."\n";

        Cli::textView($pad.$input['top']);
        for ($i = 0; $i < $height; $i++) {
            Cli::textView($pad.$input['mid']);
        }
        Cli::textView($pad.$input['btm']);
    }

    public static function banner(int $width = 20, $height = 1, int $margin = 0, $color = 'white', $title = ''){
        $title = mb_strlen($title)+5 >  $width ? mb_substr($title, 0, $width - 5)."..." : $title; 
        $title = str_repeat("", 1).$title.str_repeat("", $width - (strlen($title)+1));

        $input['top'] = Cli::color("" . $title . "", $color)."\n";
        $input['mid'] = Cli::color("" . str_repeat("", $width) . "", $color)."\n";
        $input['btm'] = Cli::color("" . str_repeat("", $width) . "", $color)."\n";

        $pad = str_repeat(' ', max(0, $margin));
        Cli::textView($pad.$input['top']);
        for ($i = 0; $i < $height; $i++) {
            Cli::textView($pad.$input['mid']);
        }
        Cli::textView($pad.$input['btm']);
    }
    
    public static function roundBox(int $width = 20, $height = 1, int $margin = 0, $color='white', $title = ''){

        $pad   = str_repeat(' ', max(0, $margin));
        $width = max(0, $width);
        $title = strlen($title)+5 >  $width ? substr($title, 0, max(0, $width - 5))."..." : $title;
        $title = str_repeat("─", 1).$title.str_repeat("─", max(0, $width - (strlen($title) + 1)));

        $input['top'] = Cli::color("╭" . $title . "╮", $color)."\n";
        $input['mid'] = Cli::color("│" . str_repeat(" ", $width) . "│", $color)."\n";
        $input['btm'] = Cli::color("╰" . str_repeat("─", $width) . "╯", $color)."\n";

        Cli::textView($pad.$input['top']);
        for ($i = 0; $i < $height; $i++) {
            Cli::textView($pad.$input['mid']);
        }
        Cli::textView($pad.$input['btm']);
    }
    
    public static function captureRound(int $width = 20, $height = 1, int $margin = 0, $color='white', $title = ''){
        $pad   = str_repeat(' ', max(0, $margin));
        $width = max(0, $width);
        $title = strlen($title)+5 >  $width ? substr($title, 0, max(0, $width - 5))."..." : $title;
        $title = str_repeat(" ", 1).$title.str_repeat(" ", max(0, $width - (strlen($title) + 1)));

        $input['top'] = Cli::color("╭" . $title . "╮", $color)."\n";
        $input['mid'] = Cli::color(" " . str_repeat(" ", $width) . " ", $color)."\n";
        $input['btm'] = Cli::color("╰" . str_repeat(" ", $width) . "╯", $color)."\n";

        Cli::textView($pad.$input['top']);
        for ($i = 0; $i < $height; $i++) {
            Cli::textView($pad.$input['mid']);
        }
        Cli::textView($pad.$input['btm']);
    }

    /* Cursor controls */
    
    /**
     * Move cursor up
     *
     * @param integer $seconds
     * @return Cli
     */
    static function moveUp(int $lines = 1) : CliDraw{
        if($lines > 0) echo self::open_close($lines."A");
        return self::instance();
    }

    /**
     * Moves the cursor downward to specified number of rows
     *
     * @param integer $col
     * @return Cli 
     */
    static function moveDown(int $lines = 1) : CliDraw {
        if($lines > 0) echo self::open_close($lines."B");
        return self::instance();
    }

    /**
     * Moves the cursor forward to specified col
     *
     * @param integer $col
     * @return Cli 
     */
    static function moveFront(int $col = 1) : CliDraw {
        if($col > 0) echo self::open_close($col."C");
        return self::instance();
    }

    /**
     * Moves the cursor backward to specified col
     *
     * @param integer $col
     * @return Cli 
     */
    static function moveBack(int $col = 1) : CliDraw{
        if($col > 0) echo self::open_close($col."D");
        return self::instance();
    }

    /**
     * prints or return a break line in cli
     *
     * @param integer $linebreaks number of breaks
     * @param boolean $print false returns break rather than print
     * @return CliDraw|string
     */
    static function break(int $linebreaks = 1, bool $print = true) : CliDraw|string{
        if(!$print) return br('', $linebreaks);
        print br('', $linebreaks);
        return self::instance();
    }

    /**
     * Moves the cursor backward to the beginning of the line
     *
     * @param integer $col
     * @return Cli 
     */
    static function moveStart(int $margin = 0) : CliDraw {
        echo self::open_close("\r");
        if($margin){
          self::moveFront($margin);
        }
        return self::instance();
    }

    /**
     * Moves the cursor to specified row and column using the current cursor 
     * position as the root. This supports negative indexing
     *
     * @param integer $row
     * @param integer $col
     * @return Cli 
     */
    static function shiftTo(int $row, int $col) : CliDraw {
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
        return self::instance();
    }

    /**
     * Moves the cursor to specified row and column using the current cursor 
     * position as the root. This is relative to screen not position
     *
     * @param integer $row
     * @param integer $col
     * @return Cli 
     */
    static function moveTo(int $row, int $col) : CliDraw {
        echo self::open($row.";".$col."H");
        return self::instance();
    }
    
    private static function open($text){
        return "\033[".$text;
    }
    private static function open_close($text){
        return "\033[".$text."\033[0m";
    }
}