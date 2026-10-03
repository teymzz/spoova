<?php 

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPrompter;

// This file contains CLI helper commands.

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * CLI function for receiving input from the terminal
 *
 * @param string $message
 * @param array $options list of options to be accepted.
 * @param Closure|null $callback A callback that receives {@see CLIPrompt} object
 * @return CliPrompter|string
 */
function input(string $message = '', array $options = [], ?Closure $callback = null) : CliPrompter|string { 
  $terminate = !$callback;
  return Cli::textPlain($message)->prompt(callback: $callback, options: $options, terminate: $terminate);
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Runs an iterable process . Alias to {@see Cli::runAnime()}
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
function runAnime(array|string $function, $final_callback = []) {
  
  return Cli::runAnime(...func_get_args());
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Designed function for displaying console text in an animated format. Alias to {@see Cli::play()}
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
function textPlay($yield, string|null $message = null, Closure|bool|string|null $callback = true, int $pause = 0){
  
  return Cli::play(...func_get_args());
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * CLI function for writing text to the terminal. Alias to {@see Cli::textView()}.
 *
 * Designed function for displaying console text without tracking
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
 */
function textView(string $message = '', $spacing = '0|0', $break = '0|0', $pause = '0|0') : Cli { 
  
  return Cli::textView(...func_get_args());
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * CLI function for writing text to the terminal. Alias to {@see Cli::textPlain()}.
 *
 * Designed function for displaying console text without tracking
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
 */
function textPlain(string $message = '', $spacing = '0|0', $break = '0|0', $pause = '0|0') : Cli { 
  
  return Cli::textPlain(...func_get_args());
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * CLI function for writing text to the terminal. Alias to {@see textPlain()}.
 *
 * Designed function for displaying console text without tracking
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
 */
function textPrint(string $message = '', $spacing = '0|0', $break = '0|0', $pause = '0|0') : CliPrompter|string { 
  
  return Cli::textPlain(...func_get_args());
  
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Designed function for returning a console text. Alias to {@see Cli::textBuild()}
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
 function textBuild(?string $message, string|int $spacing = '0|0', string|int|bool $break = '0|0') : string {
    return Cli::textBuild(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Display a button-like hint message useful for notifications. Alias to {@see CLI::infoView()}
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
function infoView(?string $title, string $message, string $color = 'danger|black', int $indent = 0, $break = '0|0') : Cli{
  return Cli::infoView(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Display message with an error subject flag. Alias to {@see CLI::errorView()}
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
function errorView(?string $message, string $title = "Error: ", int $indent = 0, string|int|bool $break = '0|0', string|int $pause = '0|0') : Cli {
    return Cli::errorView(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Returns a button-like hint message useful for notifications. Alias to {@see Cli::infoBuild()}
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
function infoBuild(?string $title, string $message, string $color = 'danger|black', int $indent = 0, $break = '0|0') : string {
  return Cli::infoBuild(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Quickly display an error message before exit. Alias to {@see CLi::errorExit()}
 *
 * @param string $message message to be displayed
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 * @param string|int|bool $break addition of line breaks or line clearing
 *   - boolean (bool): 
 *     - TRUE clears the current line before printing message 
 *     - FALSE prints without clearing line.
 *   - other accepted data types are processed according to the [CLI spacing](http://localhost/spocs/docs/helpers/classes/cli/spacing) documentation.
 * @param string $title if supplied, shows as red colored title
 * @return Never
 */
function errorExit(?string $message = '', string|int $spacing = '0|0', string|int|bool $break = '0|1', string $title = '') : Never {
   Cli::errorExit(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Display message with an success subject flag. Alias to the {@see Cli::successView()} method.
 *  - Note that this internally uses the {@see spoova\mi\core\commands\Root\Cli::textPlain()} method.
 * @param string $message error message
 * @param string $title error title
 * @param integer $indent number of spaces before text is printed
 * @param string $break adding line breaks or line clearing
 * @param string $pause
 * @uses Cli::textView
 * @return Cli
 */
function successView(?string $message, string $title = "Success: ", int $indent = 0, string|int|bool $break = '0|0', string|int $pause = '0|0') : Cli {
   return Cli::successView(...func_get_args());
}


/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Designed function for displaying console text as a new header.  
 *   - This will clear the screen before displaying the header text
 * @param string|Closure $message header message
 * @param string $icon icon of header message (only supported UTF-8 icons)
 * @param string $color color of header message
 * @param integer $break break applied after header message is printed 
 * @param integer $mode determines the mode of header text display 
 *    - mode 0 : Disables silent error mode. This means errors are displayed as at when they occur
 *    - mode 1 : applies silent error mode. This means warning errors (excluding fatal) are displayed after executable processes have been completed. If this mode is aplied, you can 
 *      later use Cli::silent_errors(true) to re-enable silent errors mode.
 * @uses Cli::cls()
 * @uses Cli::headerView() 
 * @return Cli
 */
function newCliHeader(string|Closure $message, string $icon = '►', string $color = 'danger', int $break = 0, int $mode  = 0) : Cli {
  return Cli::cls()->headerView(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Designed function for displaying console text as an header. Alias to {@see Cli::headerView()}
 * - Warning: This disables the silent mode setting latent_mode to false internally. This means that error display order is restored. To re-enable latent_mode, use Cli::silent_errors(true).
 * @param string|Closure $message header message
 * @param string $icon icon of header message (only supported UTF-8 icons)
 * @param string $color color of header message
 * @param integer $break break applied after header message is printed
  * @param integer $mode determines the mode of header text display 
  *    - mode 0 : Disables silent error mode. This means errors are displayed as at when they occur
  *    - mode 1 : applies silent error mode. This means warning errors (excluding fatal) are displayed after executable processes have been completed. If this mode is aplied, you can 
  *      later use Cli::silent_errors(true) to re-enable silent errors mode.
 * @return Cli
 */
function headerView(string|Closure $message, string $icon = '►', string $color = 'danger', int $break = 0, int $mode = 0) : Cli {
  return Cli::headerView(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Designed function for displaying console text in a pulsated mode. Alias to{@see Cli::pulseView()}
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
function pulseView(string $message, int|Closure $beats = 30000, ?Closure $eachChar = null) : Cli {
  return Cli::pulseView(...func_get_args());
}


/**
 * Alias to {@see Cli::response()}. This makes it easier to return a boolean response while ensuring 
 * that the CLI errors are properly displayed smartly on the CLI screen. It also sets the last message displayed on the CLI screen.
 *  - This function is suitable when the {@Cli::silentErrors()} is initially applied.
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
function cliResponse(bool|string $return, string|Closure|false|null $msg = 'Program terminated!', string $title = 'Info', int $indent = 0, array|string $args = []) : bool {
    return Cli::response(...func_get_args());
}

/**
 * Apply a security validation policy on the CLI
 *
 * @param array|string $args arguments parsed to the CLI controller method
 * @param callable $callback 
 * @return void
 */
function cliPolicy(array|string $args, callable $callback, bool $timed = false) : void{
   Cli::policy(...func_get_args());
}

function console() {
  Cli::console(...func_get_args());
}

function consolex() {
  Cli::consolex(...func_get_args());
}

function miconsole() {
  $state = Cli::console_color_state();
  Cli::use_console_colors(true);
  Cli::console(...func_get_args());
  Cli::use_console_colors($state);
}

function miconsolex() {
  $state = Cli::console_color_state();
  Cli::use_console_colors(true);
  try {
    Cli::consolex(...func_get_args());
  } finally {
    Cli::use_console_colors($state);
  }
}

// CLI Color helper functions ............................................................................................................................................... 

/**
 * Specified by an alert color (blue). May also be used to denote code syntax. Alias for {@see Cli::alert()}
 *
 * @param string $text text to be colored
 * @param string $color color to be applied.. Supports rgb, hex, color names and predefined color names (i.e warn, danger, alert, valid) 
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 *   - int: after
 *   - string: 'before|after'
 *   - array: [before,after]
 * @return string
 */
function textColor(Closure|string $text, $color, string|array|int $spacing = '0|0') : string {
    return Cli::textBuild(Cli::color($text, $color), $spacing);
}

/**
 * Specified by an alert color (blue). May also be used to denote code syntax. Alias for {@see Cli::alert()}
 *
 * @param string $text text to be colored
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 *   - int: after
 *   - string: 'before|after'
 *   - array: [before,after]
 * @return string
 */
function textAlert(Closure|string $text, string|array|int $spacing = '0|0') : string {
    return Cli::textBuild(Cli::color($text, 'alert'), $spacing);
}

/**
 * Specified by a success color (green). May also be used to denote code syntax. Alias for {@see Cli::valid()}
 *
 * @param string $text text to be colored
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 *   - int: after
 *   - string: 'before|after'
 *   - array: [before,after]
 * @return string
 */
function textValid(Closure|string $text, string|array|int $spacing = '0|0') : string {
    return Cli::valid(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a warning color (yellow). May also be used to denote code syntax. Alias for {@see Cli::warn()}
 *
 * @param string $text text to be colored
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 *   - int: after
 *   - string: 'before|after'
 *   - array: [before,after]
 * @return string
 */
function textWarn(Closure|string $text, string|array|int $spacing = '0|0') : string {
    return Cli::warn(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a danger color (red). May also be used to denote code syntax. Alias for {@see Cli::danger()}
 *
 * @param string $text text to be colored
 * @param string $spacing left and right spacing according to documentation at [CLI Spacing](http://spoova.com/docs/helpers/classes/cli/spacing)
 *   - int: after
 *   - string: 'before|after'
 *   - array: [before,after]
 * @return string
 */
function textDanger(Closure|string $text, string|array|int $spacing = '0|0') : string {
    return Cli::danger(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by an alert color (blue), attaches a "NOTICE:" prefix before supplied text. Alias for {@see Cli::notice()}
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
function textNotice(string $text, int $textIndent = 0, $colorInt = 2, string $title = 'NOTICE: '){
    return Cli::notice(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a warning color (warn/yellow), attaches a "CAUTION:" prefix before supplied text. Alias for {@see Cli::caution()}
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
function textCaution(string $text, int $textIndent = 0, string|int $colorInt = 3, string $title = 'CAUTION: ') : string {
    return Cli::caution(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a warning color (red), attaches a "WARNING:" prefix before supplied text. Alias for {@see Cli::warning()}
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
function textWarning(string $text, int $textIndent = 0, $colorInt = 5, string $title = 'WARNING: ') : string {
    return Cli::warning(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a success color (green), attaches an "Success:" prefix before supplied text. Alias for {@see Cli::success()}
 *
 * @param string $text
 * @param integer $textIndent left space margin
 * @param string $title error default title
 * @return string
 */
function textSuccess(string $text, int $textIndent = 0, string $title = 'Success: ') : string {
    return Cli::success(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a danger color (red), attaches an "Error:" prefix before supplied text. Alias for {@see Cli::error()}
 *
 * @param string $text
 * @param integer $textIndent left space margin
 * @param string $title error default title
 * @return string
 */
function textError(string $text, int $textIndent = 0, string $title = 'Error: ') : string {
    return Cli::error(...func_get_args());
}

/**
 * (Spoova 3 &gt;= 3.0.0) <br/>
 * Specified by a danger color (red), attaches an "Failed:" prefix before supplied text. Alias for {@see Cli::failed()}
 *
 * @param string $text text to be colored
 * @param integer $textIndent left space margin
 * @return string
 */
function textFailed(string $text, int $textIndent = 0) : string {
    return Cli::failed(...func_get_args());
}