<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use Exception;
use InvalidArgumentException;
use spoova\mi\core\classes\Ghost\GhostDraft;
use spoova\mi\core\classes\Ghost\GhostFunction;
use spoova\mi\core\classes\Ghost\GhostProxy;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliDev;
use stdClass;

/**
 * This class specifies how inputs are retreived from 
 * operating devices in relation to devices such as windows, unix systems
 */
class CliInput {
    

    /**
     * This method facilitates reading of individual key presses from CLI input.
     *   - It requires 'stty' command and 'pcntl' extension.
     *   - It tries to supports reading of special keys (arrows, function keys, home,
     *   - It reads escape sequences incrementally until a terminator is seen (letters or '~').
     *   - It returns friendly key names like HOME, END, DELETE, INSERT, PAGEUP, PAGEDOWN, F1..F12.
     *   - Produces modifier-aware names (e.g. CTRL+UP, SHIFT+DOWN) using private static comboKeys()
     *   - Emits raw ESC sequences only if unrecognised so callers can inspect .char directly.
     * 
     * @param $callback Closure function that receives a CliKey object on each key press.
     * - CliKey properties:
     *    - .char → the raw character(s) read from input
     *    - .ascii → the ASCII code of the first character
     *    - .key → the friendly key name (e.g. UP, CTRL+C, F1, etc)
     *    - .isSignal → true if the key represents a caught signal (SIGINT, SIGTERM, SIGTSTP)
     *    - .input → the internal input object with read(), open(), close() methods
     *    - .close() → method to close input reading
     * @param ?Closure $signal optional custom signal handler that receives (CliAutoSignals $signal) argument.
     */
    public static function input(Closure $callback) {
        Cli::requires('stty', fn() => Cli::textPlain('Cli input requires stty') );
        Cli::requires('pcntl', fn() => Cli::textPlain('Cli input requires pcntl extension') );

        $input = new stdClass;

        $open = CliState::current(); // fetch original mode

        $input->open = function() {
            CliState::stty('-echo -icanon min 1 time 0', false);
        };

        $input->close = function() use($input, $open){
            CliState::stty($open? escapeshellarg($open) : 'sane');
            $input->reading = false;
        };

        $openReadStream = function() {
            if (DIRECTORY_SEPARATOR === '/' && is_readable('/dev/tty')) {
                $fp = @fopen('/dev/tty', 'r+');
                if ($fp !== false) {
                    @stream_set_blocking($fp, false);
                    return $fp;
                }
            }
            if (is_resource(STDIN)) {
                @stream_set_blocking(STDIN, false);
                return STDIN;
            }
            return null;
        };

        $readStream = $openReadStream();

        $input->read = function($length = 1) use (&$readStream) {
            if (!is_resource($readStream)) return false;
            return fread($readStream, $length);
        };

        $input->readEscape = function($first = '') use($input, &$readStream){
            $seq = $first;
            $limit = 10;
            for ($i = 0; $i < $limit; $i++) {
                $r = [$readStream]; $w = null; $e = null;
                $has = @stream_select($r, $w, $e, 0, 200000);
                if ($has === false) break;
                if ($has) {
                    $c = ($input->read)();
                    if ($c === false || $c === '') break;
                    $seq .= $c;
                    $last = substr($seq, -1);
                    if ((ord($last) >= 65 && ord($last) <= 90) || (ord($last) >= 97 && ord($last) <= 122) || $last === '~') break;
                } else {
                    break;
                }
            }
            return $seq;
        };

        ($input->open)();
        $input->reading = true;

        //* Connect CliAutoSignals through GhostProxy
        $Ghost = new GhostFunction(['ghostData']);
        $Ghost->ghostData(function($value) use($input, $callback){
            $accessibles =  ['input' => $input, 'callback' => $callback];
            if (in_array($value, array_keys($accessibles))) return $accessibles[$value];
            throw new InvalidArgumentException("Undefined property: GhostFunction::ghostData(#1) '$value'");
        });
        GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliAutoSignals{});
        /** @var CliAutoSignals */
        $autoSignals = GhostProxy::object();

        // signal queue (handlers must remain tiny)
        $signalQueue = []; //[SIGINT, SIGTERM, SIGTSTP, SIGWINCH]
        Cli::useSignals(array_values(CliKey::SIGNALS), function($signal) use (&$signalQueue, $input) {
            $signalQueue[] = $signal;
            if (in_array($signal, CliKey::EXIT_SIGNALS)) $input->reading = false;
        });

        pcntl_async_signals(true);
        if (method_exists($autoSignals, 'applyInterruption')) {
            $autoSignals->applyInterruption(CliKey::EXIT_SIGNALS);
        }

        // recovery helper
        $openReadStreamFn = $openReadStream;
        $recoverReadStream = function() use (&$readStream, $openReadStreamFn) {
            if (is_resource($readStream) && $readStream !== STDIN) @fclose($readStream);
            $readStream = $openReadStreamFn();
            return is_resource($readStream);
        };

        // maskable signals (block during select)
        $maskSignals = [SIGWINCH];
        $sigmask_supported = function_exists('pcntl_sigprocmask') && defined('SIG_BLOCK') && defined('SIG_UNBLOCK');

        // de-duplication guard
        $__last_callback = ['key' => null, 'time' => 0.0];
        $__dup_window = 0.05; // 50 ms

        $response = null;

        // fallback if no usable stream
        if (!is_resource($readStream)) {
            while ($input->reading) {
                if (!empty($signalQueue)) {
                    while (!empty($signalQueue)) {
                        $sig = array_shift($signalQueue);
                        $sigKey = new CliKey($sig, $input, true);
                        if (in_array($sig, CliKey::EXIT_SIGNALS)) {
                            $response = $callback($sigKey);
                            ($input->close)();
                            return $response ?? null;
                        }
                        if ($sig === SIGWINCH) $callback($sigKey);
                    }
                }
                if (!is_resource(STDIN)) break;
                $line = fgets(STDIN);
                if ($line === false) break;
                $input->char = $line;
                // guarded callback
                $callId = is_string($line) ? $line : json_encode($line);
                $now = microtime(true);
                if (!($__last_callback['key'] === $callId && ($now - $__last_callback['time']) < $__dup_window)) {
                    $response = $callback(new CliKey($line, $input));
                    $__last_callback['key'] = $callId;
                    $__last_callback['time'] = $now;
                }
                pcntl_signal_dispatch();
            }
            ($input->close)();
            return $response ?? null;
        }

        try {
            while ($input->reading) {
                // 1) process queued signals before blocking
                if (!empty($signalQueue)) {
                    while (!empty($signalQueue)) {
                        $sig = array_shift($signalQueue);
                        $sigKey = new CliKey($sig, $input, true);

                        if (in_array($sig, CliKey::EXIT_SIGNALS)) {
                            $response = $callback($sigKey);
                            ($input->close)();
                            return $response ?? null;
                        }

                        if ($sig === SIGWINCH) {
                            $callback($sigKey);
                        }
                    }
                }

                // 2) block signals around select if supported
                if ($sigmask_supported) {
                    $toBlock = $maskSignals;
                    pcntl_sigprocmask(SIG_BLOCK, $toBlock);
                }

                $r = [$readStream]; $w = null; $e = null;
                $has = @stream_select($r, $w, $e, 0, 50000);

                if ($sigmask_supported) {
                    pcntl_sigprocmask(SIG_UNBLOCK, $toBlock);
                }
                pcntl_signal_dispatch();

                if ($has === false) {
                    $isEINTR = false;
                    $isEBADF = false;
                    if (function_exists('posix_get_last_error') && function_exists('posix_strerror')) {
                        $errno = posix_get_last_error();
                        $errstr = posix_strerror($errno);
                        if ($errno === 4 || stripos($errstr, 'interrupt') !== false) $isEINTR = true;
                        if ($errno === 9 || stripos($errstr, 'bad file descriptor') !== false) $isEBADF = true;
                    }

                    if ($isEINTR) { usleep(20000); continue; }
                    if ($isEBADF) {
                        if ($recoverReadStream()) { usleep(20000); continue; }
                        else break;
                    }
                    usleep(30000);
                    continue;
                }

                if ($has === 0) continue;

                $raw = ($input->read)();
                if ($raw === false || $raw === '') { pcntl_signal_dispatch(); continue; }

                $firstByte = $raw[0] ?? '';
                $ascii = ($firstByte === '') ? 0 : ord($firstByte);
                $input->char = $raw;
                $input->ascii = $ascii;

                // parse keys (unchanged logic)
                $support = false;
                $key = null;

                if ($ascii >= 1 && $ascii <= 26) {
                    $support = true; $key = 'CTRL+'.chr($ascii + 64);
                } elseif ($ascii === 13 || $ascii === 10) { $support = true; $key = 'ENTER'; }
                elseif ($ascii === 9) { $support = true; $key = 'TAB'; }
                elseif ($ascii === 8 || $ascii === 127) { $support = true; $key = 'BACKSPACE'; }
                elseif ($ascii === 27) {
                    $next = ($input->read)();
                    if ($next === false || $next === '') { $support = true; $key = 'ESC'; }
                    else {
                        if ($next === '[' || $next === 'O') $seq = ($input->readEscape)($next);
                        else {
                            $more = ($input->read)();
                            $seq = ($more !== false && $more !== '') ? $next . $more : $next;
                        }
                        $norm = $seq;
                        if ($norm === '[A') { $support=true; $key='UP'; }
                        elseif ($norm === '[B') { $support=true; $key='DOWN'; }
                        elseif ($norm === '[C') { $support=true; $key='RIGHT'; }
                        elseif ($norm === '[D') { $support=true; $key='LEFT'; }

                        elseif ($norm === '[H' || $norm === 'OH' || $norm === '[1~' || $norm === '[7~') { $support=true; $key='HOME'; }
                        elseif ($norm === '[F' || $norm === 'OF' || $norm === '[4~' || $norm === '[8~') { $support=true; $key='END'; }

                        elseif ($norm === '[2~') { $support=true; $key='INSERT'; }
                        elseif ($norm === '[3~') { $support=true; $key='DELETE'; }
                        elseif ($norm === '[5~') { $support=true; $key='PAGEUP'; }
                        elseif ($norm === '[6~') { $support=true; $key='PAGEDOWN'; }

                        elseif ($norm === 'OP') { $support=true; $key='F1'; }
                        elseif ($norm === 'OQ') { $support=true; $key='F2'; }
                        elseif ($norm === 'OR') { $support=true; $key='F3'; }
                        elseif ($norm === 'OS') { $support=true; $key='F4'; }
                        elseif ($norm === '[11~') { $support=true; $key='F1'; }
                        elseif ($norm === '[12~') { $support=true; $key='F2'; }
                        elseif ($norm === '[13~') { $support=true; $key='F3'; }
                        elseif ($norm === '[14~') { $support=true; $key='F4'; }
                        elseif ($norm === '[15~') { $support=true; $key='F5'; }
                        elseif ($norm === '[17~') { $support=true; $key='F6'; }
                        elseif ($norm === '[18~') { $support=true; $key='F7'; }
                        elseif ($norm === '[19~') { $support=true; $key='F8'; }
                        elseif ($norm === '[20~') { $support=true; $key='F9'; }
                        elseif ($norm === '[21~') { $support=true; $key='F10'; }
                        elseif ($norm === '[23~') { $support=true; $key='F11'; }
                        elseif ($norm === '[24~') { $support=true; $key='F12'; }

                        elseif (strlen($norm) >= 4 && substr($norm,0,3) === '[1;' && in_array(substr($norm,-1), ['A','B','C','D'])) {
                            $tail = substr($norm, 3);
                            $mod = intval(substr($tail,0,1));
                            $dir = substr($tail, -1);
                            $modStr = self::comboKeys($mod);
                            $arrowMap = ['A'=>'UP','B'=>'DOWN','C'=>'RIGHT','D'=>'LEFT'];
                            $support = true;
                            $key = strtoupper($modStr . '+' . ($arrowMap[$dir] ?? $dir));
                        }
                        elseif (strpos($norm,';') !== false && substr($norm,-1) === '~') {
                            $inside = trim($norm,'[]');
                            $parts = explode(';', $inside);
                            if (count($parts) === 2) {
                                $num = $parts[0]; $mod = intval($parts[1]);
                                $numMap = ['2'=>'INSERT','3'=>'DELETE','5'=>'PAGEUP','6'=>'PAGEDOWN','1'=>'HOME','4'=>'END'];
                                if (isset($numMap[$num])) {
                                    $modStr = self::comboKeys($mod);
                                    $support = true;
                                    $key = strtoupper($modStr . '+' . $numMap[$num]);
                                }
                            }
                        }

                        if (!$support) {
                            $support = true;
                            $key = 'ESC' . $norm;
                        }

                        $input->char = chr(27) . $norm;
                        $input->isArrow = function($keypressed = null) use($key) {
                            if (func_num_args() > 0) return strtolower($keypressed) === strtolower($key);
                            return in_array($key, ['UP','DOWN','LEFT','RIGHT','SHIFT+UP','SHIFT+DOWN','CTRL+UP','CTRL+DOWN','ALT+UP','ALT+DOWN']);
                        };
                    }
                } else {
                    $support = false;
                    $key = $raw;
                }

                $CTRL_F1_F12 = [
                    'ESC[1;5P'=>'CTRL+F1','ESC[1;5Q'=>'CTRL+F2','ESC[1;5R'=>'CTRL+F3','ESC[1;5S'=>'CTRL+F4',
                    'ESC[16;5~'=>'CTRL+F5','ESC[17;5~'=>'CTRL+F6','ESC[18;5~'=>'CTRL+F7','ESC[19;5~'=>'CTRL+F8',
                    'ESC[20;5~'=>'CTRL+F9','ESC[21;5~'=>'CTRL+F10','ESC[23;5~'=>'CTRL+F11','ESC[24;5~'=>'CTRL+F12'
                ];
                $key = $CTRL_F1_F12[$key] ?? $key;

                // guarded callback: avoid near-immediate duplicates
                $callId = is_int($key) ? "SIG{$key}" : (is_string($key) ? $key : json_encode($key));
                $now = microtime(true);
                if (!($__last_callback['key'] === $callId && ($now - $__last_callback['time']) < $__dup_window)) {
                    $response = $callback(new CliKey($key, $input));
                    $__last_callback['key'] = $callId;
                    $__last_callback['time'] = $now;
                }

                pcntl_signal_dispatch();
            }
        } finally {
            if (is_resource($readStream) && $readStream !== STDIN) @fclose($readStream);
            ($input->close)();
        }

        return $response ?? null;
    }

    private static function comboKeys($mod){
        $map = [
            2 => 'SHIFT',
            3 => 'ALT',
            4 => 'SHIFT+ALT',
            5 => 'CTRL',
            6 => 'SHIFT+CTRL',
            7 => 'ALT+CTRL',
            8 => 'SHIFT+ALT+CTRL'
        ];
        return $map[$mod] ?? 'MOD'.$mod;
    }

    /**
     * This method is designed for reading UNIX input.
     *  - Note that this does not support multi-bytes character like emoji or emoticon characters
     * @param Closure|null $process provides process handler methods for handling signals
     * @param boolean $hide determines whether the input is hidden.
     * @uses CliInput::input()
     * @return string input
     */
    static function UNIXInput(?Closure $process = null, bool $hide = false){
        
        $buffer = ''; $oCursor = null; 
        $backspace = 0; $cursor = 0;
        $prevLen = 0; // help clear trailing chars
        mb_internal_encoding("UTF-8");
        $lastRow = null;

        self::input(function(CliKey $key) use (&$buffer, &$oCursor, &$backspace, &$cursor, &$prevLen, &$lastRow, $process, $hide){
            if($oCursor === null) $oCursor = Cli::cursorPosition();
            
            $Ghost = new GhostFunction(['ghostData']);
            $Ghost->ghostData(function(string $val) use($key, $buffer) {
                if(in_array($val, ['key','buffer'])){
                    return $$val;
                }
                throw new Exception("invalid value $".$val." is not available");
            });
            GhostProxy::new($Ghost, fn(GhostDraft $draft) => new class($draft) extends CliFetch{});
            
            if($key->isSignal()){

                if($key->isSignal(SIGINT)) {
                    Cli::hideCursor();
                    echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                    Cli::textPlain($hide? str_repeat('*', strlen($buffer)) : $buffer);
                    Cli::showCursor();  

                    if($process) $process(GhostProxy::object());
                    return $buffer;
                }
    
                if($key->isSignal(SIGWINCH)) {
                   $process(GhostProxy::object());
                    return $buffer;
                }
                $process(GhostProxy::object());
            }

            if($key->isEnter()){
                echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                Cli::textPlain($hide? str_repeat('*', strlen($buffer)) : $buffer);
                Cli::showCursor(); 
                echo Cli::moveDown();
                echo Cli::moveStart();
                $key->exit();
                return $buffer;
            }

            if($key->isWritable()) {
                Cli::hideCursor();
                
                $buffer .= $char = $key->fetch();
                echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                Cli::textPlain($hide? str_repeat('*', strlen($buffer)) : $buffer);
                Cli::showCursor();
                if($process) $process(GhostProxy::object());
                return;
            }

            // ---------- NEW: Robust Backspace (append-style, fixed leftover char) ----------
            if ($key->isBackspace()) {
                $len = mb_strlen($buffer);
                $caret = $len + $cursor; // absolute caret index (0..len)

                if ($caret > 0) {
                    // remove the character before the caret
                    $before = mb_substr($buffer, 0, $caret - 1);
                    $after  = mb_substr($buffer, $caret);
                    $buffer = $before . $after;

                    if($lastRow === null){
                        $lastRow = Cli::cursorPosition()['row'];
                    }

                    // redraw from origin
                    Cli::hideCursor();
                    echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                    Cli::textPlain($buffer);
                    if(CliScreen::width() === Cli::cursorPosition()['col']){
                        // if at the end of line, add a space to avoid leftover char
                        Cli::textPlain(" ");
                        echo Cli::moveBack(); // move back from added space
                        $curPos = Cli::cursorPosition();
                        if($curPos['col'] === 1){
                            echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                            Cli::textPlain($hide? str_repeat('*', strlen($buffer)) : $buffer);
                        }
                    }else{

                        // CLEAR to end of current line — this reliably removes the leftover char
                        // CSI K  (0 or empty) clears from cursor to end of line
                        echo "\033[K";
                    }


                    // force output out (helps ensure terminal processes prior sequences)
                    if (function_exists('fflush')) { @fflush(STDOUT); }
                    flush();

                    // update prevLen (optional, still useful)
                    $newLen = mb_strlen($buffer);
                    $prevLen = $newLen;

                    // compute visual position for caret (0-based)
                    $caretNew = $caret - 1; // after deletion caret moves left one index
                    // absolute 0-based column index from left edge of terminal:
                    $absColIndex = ($oCursor['col'] - 1) + $caretNew;
                    $termWidth = CliScreen::width();
                    if ($termWidth < 1) $termWidth = 80; // fallback

                    $rowOffset = intdiv($absColIndex, $termWidth);
                    $col = ($absColIndex % $termWidth) + 1;
                    $row = $oCursor['row'] + $rowOffset;

                    // move caret to computed visual position
                    echo Cli::moveTo($col, $row);
                    Cli::showCursor();
                }
                return;
            }


            if($key->isArrow()) {
                if($key->isArrow('left')){

                    Cli::hideCursor();
                    $currentPos = Cli::cursorPosition();
                    if($currentPos !== $oCursor) $cursor--;

                    // Redraw buffer
                    echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                    Cli::textPlain($hide? str_repeat('*', strlen($buffer)) : $buffer); // cursor moved to last position
                 
                    $currentPos = Cli::cursorPosition();

                    $currentCol = $currentPos['col'];

                    for($i = 0; $i < abs($cursor); $i++){
                        $currentCol--;
                        if($currentCol < 1) {
                            if($currentPos['row'] > $oCursor['row']) {
                                $currentPos['row']--;
                                $currentCol = CliScreen::width();
                            }
                        }
                    }

                    $row =  $currentPos['row'];
                    $col =  $currentCol;

                    Cli::moveTo($col, $row);

                    Cli::showCursor();
                }
                if($key->isArrow('right')){

                    Cli::hideCursor();
                    $currentPos = Cli::cursorPosition();
                    if($cursor !== 0) $cursor++;

                    // Redraw buffer
                    echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                    Cli::textPlain($buffer); // cursor moved to last position
                 
                    $currentPos = Cli::cursorPosition();

                    $currentCol = $currentPos['col'];

                    for($i = 0; $i < abs($cursor); $i++){
                        $currentCol--;
                        if($currentCol < 1) {
                            if($currentPos['row'] > $oCursor['row']) {
                                $currentPos['row']--;
                                $currentCol = CliScreen::width();
                            }
                        }
                    }

                    $row =  $currentPos['row'];
                    $col =  $currentCol;

                    Cli::moveTo($col, $row);

                    Cli::showCursor();
                }
                return;
            }
            if($key->isHome()) {
                Cli::hideCursor();
                echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                Cli::textPlain($buffer);
                echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                Cli::showCursor();
                $backspace = 0; // reset backspace
                $cursor = -mb_strlen($buffer);
                return;
            }
            if($key->isEnd()) {
                Cli::hideCursor();
                echo Cli::moveTo($oCursor['col'], $oCursor['row']);
                Cli::textPlain($buffer);
                Cli::showCursor();
                $backspace = 0; // reset backspace
                $cursor = 0;
                return;
            }
        });
        return $buffer;
    }


    /**
     * Currently the mostly responsive method for fetching input from CLI. 
     * This method uses either the {@see CliInput::UNIXInput()} or 
     * normal STDIN to read user input.  
     *
     * @param Closure|null $process provides process handler methods for handling signals
     * @param boolean $hide determines whether the input is hidden
     * @uses CliInput::UNIXInput() or normal STDIN
     * @return string
     */
    public static function read(?Closure $process = null, bool $hide = false){
        if(Cli::isTerminal('linux')){
            return self::UNIXInput($process, $hide);
        }else{
            return self::SHELLInput($hide);
            // $input = self::SHELLInput($hide);
            // if($hide){
            // }else{
            //     $input = trim(fgets(STDIN, 1024));
            // }
            // Cli::wait(2000); // delay eager processes if terminated.
            // return $input;
        }
    }

    /**
     * Smartly fetch user inputs using powershell or unix (stty) depending upon the type of terminal environment. 
     * 
     * @param Closure|null $process callback closure(CliFetch $fetch) arguments providing helper methods triggered for specified events.
     *   - Note that this argument will be ignored if stty is not available.
     * @param boolean $hide determines whether the user input is hidden 
     * in terminal environments that supports signals (e.g WSL, Bash).
     * @uses CliInput::UNIXInput()
     * @uses CliInput::SHELLInput()
     * @uses CliInput::input()
     *  - This is the same as CLI::input()
     * @return string|null
     */
    public static function fetch(?Closure $process=null, bool $hide = false) : ?string {

        if(Cli::hasCommand('stty') && Cli::sttyEnabled()){
            $input = self::read($process, $hide); // $input = self::get_unix_input($hide);
        }elseif(CliDev::isOs('windows')){
            $input = self::SHELLInput($hide);
        }else{
            Cli::exit(Cli::error('Fetching input is not supported on this device.'));
        }
        return $input;

    }

    /**
     * Use special command to fetch secure or unsecure input from windows powershell devices without stty enabled
     *
     * @return string|null
     */
    private static function SHELLInput(bool $hide = false): ?string {

        if($hide){
            $cmd = 'powershell -Command "$pass = Read-Host -AsSecureString; ' .
                   '[System.Runtime.InteropServices.Marshal]::PtrToStringAuto(' .
                   '[System.Runtime.InteropServices.Marshal]::SecureStringToBSTR($pass))"';
            $descriptors = [
                0 => ["pipe", "r"], // stdin
                1 => ["pipe", "w"], // stdout
                2 => ["pipe", "w"], // stderr
            ];
        
            $process = proc_open($cmd, $descriptors, $pipes);

            if (!is_resource($process)) {
                return null;
            }
        
            fclose($pipes[0]); // We won't send input
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
        
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
        
            $exitCode = proc_close($process);
        
            if ($exitCode !== 0 || !empty($error)) {
                // PowerShell failed
                return null;
            }
        
            $response = trim($output);
        }else{
            $response = trim(fgets(STDIN, 1024));
        }
        Cli::wait(2000);
        return $response;
    } 

    /**
     * Gets Unix input using stty command
     *
     * @param boolean $hide
     * @return string|null
     */
    private static function get_unix_input(bool $hide = false): ?string {
        if ($hide && !function_exists('posix_isatty') || !posix_isatty(STDIN)) {
            return null; // Not a TTY — cannot hide input
        }
    
        // Check if stty is available
        $hasStty = (bool) shell_exec('command -v stty 2>/dev/null');

        if (!$hasStty) {
            return null;
        }
    
        $sttyMode = shell_exec('stty -g');
        if (!$sttyMode) return null;
        $sttyMode = trim($sttyMode);
        register_shutdown_function(fn() => shell_exec("stty $sttyMode"));
        shell_exec('stty -echo -icanon min 1 time 0');
    
        $signal = false;
        pcntl_async_signals(true);
        pcntl_signal(SIGINT, function () use (&$signal, $sttyMode) {
            shell_exec("stty $sttyMode");
            $signal = true;
        });
    
        $input = '';
        $stdin = fopen('php://stdin', 'r');
    
        while (true) {
            $read = [$stdin];
            $write = $except = null;
    
            // $result = suppress_error(E_WARNING, fn() =>  stream_select($read, $write, $except, 0, 100000));
            $result = @stream_select($read, $write, $except, 0, 100000);
    
            if ($signal) {
                $input = null;
                break;
            }
    
            if ($result > 0) {
                $char = fgetc($stdin);
                $ord = ord($char);
                if ($char === "\n" || $char === "\r") {
                    break;
                } elseif ($ord === 127 || $ord === 8) {
                    if (strlen($input) > 0) {
                        $input = substr($input, 0, -1);
                        fwrite(STDOUT, "\033[1D \033[1D");
                    }
                } elseif ($ord >= 32 && $ord <= 126) {
                    $input .= $char;
                    fwrite(STDOUT, $hide ? '*' : $char);
                }
            }
        }
    
        fwrite(STDOUT, PHP_EOL);
        fclose($stdin);
        return $input;
    }

}