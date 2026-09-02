<?php

namespace spoova\mi\core\commands\Root\Cli;

use Closure;
use spoova\mi\core\classes\Bundle\Arr\Arr;
use spoova\mi\core\commands\Root\Cli;

class CliColor {

    private static bool|null $truecolor = null;
    private static string|null $colormode = null; //default

    const support = [
        'aqua','blue','dodgerblue','skyblue','violetblue','black','brown','burlywood','chocolate','crimson',
        'cyan','gold','gray','grey','green','indigo','ivory','khaki','lime','magenta',
        'maroon','moon','orange','olive','pink','purple','rebeccapurple','red','silver','tan','teal',
        'tomato','turqoise','violet','wheat','white','yellow',
        /* darker variations */
        'darkaqua','darkblue','darkdodgerblue','darkskyblue','darkvioletblue','darkbrown','darkburlywood','darkchocolate','darkcrimson',
        'darkcyan','darkgold','darkgray','darkgrey','darkgreen','darkindigo','darkivory','darkkhaki','darklime','darkmagenta',
        'darkmaroon','darkmoon','darkorange','darkolive','darkpink','darkpurple','darkrebeccapurple','darkred','darksilver','darktan','darkteal',
        'darktomato','darkturqoise','darkviolet','darkwheat','darkwhite','darkyellow',

        /* darkerer variations (for white foreground) */
        'darkeraqua','darkerblue','darkerdodgerblue','darkerskyblue','darkervioletblue','darkerbrown','darkerburlywood','darkerchocolate','darkercrimson',
        'darkercyan','darkergold','darkergray','darkergrey','darkergreen','darkerindigo','darkerivory','darkerkhaki','darkerlime','darkermagenta',
        'darkermaroon','darkermoon','darkerorange','darkerolive','darkerpink','darkerpurple','darkerrebeccapurple','darkerred','darkersilver','darkertan','darkerteal',
        'darkertomato','darkerturqoise','darkerviolet','darkerwheat','darkerwhite','darkeryellow',
        
    ];

    /**
     * Check if a color exist in the CliColor library
     *
     * @param string $name
     * @return boolean
     */
    static function exists(string $name) : bool {
        return in_array($name, self::support);
    }

    /**
     * Convert name to supported RGB color format.
     *
     * @param string $name
     * @param bool $array TRUE returns RGB color as array while FALSE return as string.
     * @return array|string
     */
    static function build(string $name, bool $array = false) : array|string {
    
        $colors = [
            'aqua' => 'rgb(0, 255, 255)',
            'darkaqua' => 'rgb(0, 139, 139)',
            'darkeraqua' => 'rgb(1, 107, 107)',
            
             /* blue and variations */
            'blue' => 'rgb(0, 0, 255)',
            'darkblue'=> 'rgb(0, 0, 139)',
            'darkerblue'=> 'rgb(1, 1, 108)',

            'dodgerblue' => 'rgb(30, 144, 255)',
            'darkdodgerblue' => 'rgb(25, 118, 212)',
            'darkerdodgerblue' => 'rgb(20, 93, 167)',

            'skyblue' => 'rgb(135, 206, 235)',
            'darkskyblue' => 'rgb(107, 165, 188)',
            'darkerskyblue' => 'rgb(75, 113, 128)',

            'violetblue' => 'rgb(138, 43, 226)',
            'darkvioletblue' => 'rgb(107, 32, 176)',
            'darkervioletblue' => 'rgb(80, 23, 134)',

            'black' => 'rgb(0, 0, 0)',

            'brown' => 'rgb(165, 42, 42)',
            'darkbrown' => 'rgb(139, 34, 34)',
            'darkerbrown' => 'rgb(110, 28, 28)',

            'burlywood'=> 'rgb(222, 184, 135)',
            'darkburlywood'=> 'rgb(184, 151, 108)',
            'darkerburlywood'=> 'rgb(138, 114, 82)',

            'chocolate' => 'rgb(210, 105, 30)',
            'darkchocolate' => 'rgb(165, 82, 23)',
            'darkerchocolate' => 'rgb(128, 64, 18)',

            'crimson' => 'rgb(220, 20, 60)',
            'darkcrimson' => 'rgb(201, 19, 55)',
            'darkercrimson' => 'rgb(167, 16, 46)',

            'cyan' => 'rgb(0, 255, 255)',
            'darkcyan' => 'rgb(0, 139, 139)',
            'darkercyan' => 'rgb(1, 107, 107)',

            'gold' => 'rgb(255, 215, 0)',
            'darkgold' => 'rgb(207, 176, 3)',
            'darkergold' => 'rgb(135, 117, 11)',

            'gray' => 'rgb(128, 128, 128)',
            'darkgray' => 'rgb(169, 169, 169)',
            'darkergray' => 'rgb(120, 120, 120)',

            'grey' => 'rgb(128, 128, 128)',
            'darkgrey' => 'rgb(169, 169, 169)',
            'darkergrey' => 'rgb(120, 120, 120)',

            'green' => 'rgb(0, 128, 0)',
            'darkgreen' => 'rgb(0, 100, 0)',
            'darkergreen' => 'rgb(0, 74, 0)',

            'indigo' => 'rgb(75, 0, 130)',
            'darkindigo' => 'rgb(54, 1, 92)',
            'darkerindigo' => 'rgb(45, 1, 77)',

            'ivory' => 'rgb(255, 255, 240)',
            'darkivory' => 'rgb(208, 208, 195)',
            'darkerivory' => 'rgb(113, 113, 105)',

            'khaki' => 'rgb(240, 230, 140)',
            'darkkhaki' => 'rgb(200, 191, 112)',
            'darkerkhaki' => 'rgb(111, 106, 64)',

            'lime' => 'rgb(0, 255, 0)',
            'darklime' => 'rgb(0, 200, 0)',
            'darkerlime' => 'rgb(0, 130, 0)',

            'magenta' => 'rgb(255, 0, 255)',
            'darkmagenta' => 'rgb(139, 0, 139)',
            'darkermagenta' => 'rgb(111, 1, 111)',

            'maroon' => 'rgb(128, 0, 0)',
            'darkmaroon' => 'rgb(96, 1, 1)',
            'darkermaroon' => 'rgb(80, 1, 1)',

            'moon' => 'rgba(249, 206, 125, 1)',
            'darkmoon' => 'rgba(180, 141, 79, 1)',
            'darkermoon' => 'rgba(150, 110, 36, 1)',

            'orange' => 'rgb(255, 165, 0)',
            'darkorange' => 'rgb(255, 140, 0)',
            'darkerorange' => 'rgb(164, 102, 26)',

            'olive' => 'rgb(128, 128, 0)',
            'darkolive' => 'rgb(98, 98, 1)',
            'darkerolive' => 'rgb(78, 78, 0)',

            'pink' => 'rgb(255, 192, 203)',
            'darkpink' => 'rgb(209, 152, 161)',
            'darkerpink' => 'rgb(136, 102, 107)',

            'purple' => 'rgb(128, 0, 128)',
            'darkpurple' => 'rgb(91, 0, 91)',
            'darkerpurple' => 'rgb(64, 1, 64)',

            'rebeccapurple' => 'rgb(102, 51, 153)',
            'darkrebeccapurple' => 'rgb(76, 36, 116)',
            'darkerrebeccapurple' => 'rgb(66, 32, 101)',

            'red' => 'rgb(235, 0, 0)', // dropped for better view
            'darkred' => 'rgb(139, 0, 0)',
            'darkerred' => 'rgb(117, 2, 2)',

            'silver' => 'rgb(192, 192, 192)',
            'darksilver' => 'rgb(147, 147, 147)',
            'darkersilver' => 'rgb(108, 108, 108)',

            'tan' => 'rgb(210, 180, 140)',
            'darktan' => 'rgb(170, 144, 111)',
            'darkertan' => 'rgb(130, 111, 87)',

            'teal' => 'rgb(0, 128, 128)',
            'darkteal' => 'rgb(2, 106, 106)',
            'darkerteal' => 'rgb(1, 80, 80)',

            'tomato' => 'rgb(255, 99, 71)',
            'darktomato' => 'rgb(227, 89, 64)',
            'darkertomato' => 'rgb(193, 73, 51)',

            'turqoise' => 'rgb(64, 224, 208)',
            'darkturqoise' => 'rgb(0, 162, 165)',
            'darkerturqoise' => 'rgb(2, 129, 131)',

            'violet' => 'rgb(160, 93, 165)',
            'darkviolet' => 'rgb(133, 76, 137)',
            'darkerviolet' => 'rgb(109, 64, 112)',

            'wheat' => 'rgb(245, 222, 179)',
            'darkwheat' => 'rgb(206, 183, 141)',
            'darkerwheat' => 'rgb(121, 110, 90)',
            
            'white' => 'rgb(255, 255, 255)',
            'darkwhite' => 'rgb(218, 218, 218)',
            'darkerwhite' => 'rgb(188, 186, 186)',

            'yellow' => 'rgb(255, 255, 0)',
            'darkyellow' => 'rgb(201, 201, 1)',
            'darkeryellow' => 'rgb(112, 112, 2)',
        ];

        if(substr($name, 0, 1) === '#'){
            $name = join(',',self::normalizeColorArg($name));
        }
        $color = $colors[$name] ?? (strpos($name, ',') !== false? $name : 'rgb(255, 255, 255)');

        $color = str_replace(['rgb(',')',' ','rgba('], '', $color);
        $color = str_replace(',', ' ', $color);
        $color = preg_replace('/\s+/',' ', $color);
        if($array) {
            $color = explode(' ', $color);
            if(count($color) > 3) {
                unset($color[3]);
            }
        }
        return $color;
    }

    /**
     * Tries to determine supported color modes
     *
     * @param array $supports color mode options [truecolor|256|16]
     * @param string|void $mode references supported color mode
     * @return boolean
     */
    public static function isSupported(array $supports = [], &$mode = '') : bool {
        
        if(self::$truecolor !== null) {
            $mode = self::$colormode;
            return self::$truecolor;
        }

        if(isOs('windows')){

            $truecolor = false; 
            self::$colormode = $mode = '16';

            if(function_exists('sapi_windows_vt100_support')){
               $truecolor = @sapi_windows_vt100_support(fopen('php://stdout', 'w'), true);
               $mode = self::$colormode = 'truecolor';
            }

            if(!$truecolor){  
                $colorterm = strtolower((string)getenv('COLORTERM'));
                $term = strtolower((string)getenv('TERM'));
                if (strpos($term, '256color') !== false) {
                    $mode = self::$colormode = '256';
                    return self::$truecolor = in_array('256',$supports)? true : false; // supports 256
                }
                if (getenv('WT_SESSION') || getenv('TERM_PROGRAM') === 'vscode') {
                    $mode = self::$colormode = 'truecolor';
                    return self::$truecolor = in_array('truecolor',$supports)? true : false;
                }
            }

            return self::$truecolor = (in_array($mode,$supports))? $truecolor : false;

        }else{
            $colorterm = strtolower((string)getenv('COLORTERM'));
            if ($colorterm !== '' && (strpos($colorterm, 'truecolor') !== false || strpos($colorterm, '24bit') !== false)) {
                self::$colormode = $mode =  'truecolor';
                return self::$truecolor = in_array('truecolor',$supports)? true : false;
            }
            $term = strtolower((string)getenv('TERM'));
            if (strpos($term, '256color') !== false) {
                self::$colormode = $mode =  '256';
                return self::$truecolor = in_array('256',$supports)? true : false; // supports 256
            }
            if (getenv('WT_SESSION') || getenv('TERM_PROGRAM') === 'vscode') {
                self::$colormode = $mode = 'truecolor';
                return true;
            }
            return  self::$truecolor = in_array('16',$supports)? true : false;
        }
    }

    
    /* Advanced True color mode handlers */
    // Public convenience APIs

    /**
     * Apply foreground and background color to text supporting both HEX and RGB color definitions
     *
     * @param string $text
     * @param string $fg
     * @param string $bg
     * @param boolean $noReset FALSE prevents application of ANSI escape after color application.
     * @return string returns colored text
     */
    public static function truecolor(string $text, $fg = null, $bg = null, bool $noReset = false): string
    {
        self::enableWindowsVt();
        $fgRGB = self::normalizeColorArg($fg);
        $bgRGB = self::normalizeColorArg($bg);
        $mode = self::detectColorMode();
        $seq = '';
        if ($fgRGB !== null) {
            $fgRGB[] = false;
            $fgRGB[] = $mode;
            $seq .= self::ansiFor(...$fgRGB);
        }
        if ($bgRGB !== null) {
            $bgRGB[] = true;
            $bgRGB[] = $mode;
            $seq .= self::ansiFor(...$bgRGB);
        }
        return $seq . $text . ($noReset ? '' : "\033[0m");
    }

    private static function enableWindowsVt(): void
    {
        if(self::$truecolor === null){
            if((getOs() === 'windows') && function_exists('sapi_windows_vt100_support')){
                self::$truecolor = @sapi_windows_vt100_support(STDOUT, true);
            }
            self::$truecolor = false;
        }
    }

    // Normalize various forms into [r,g,b] or null
    private static function normalizeColorArg($c): ?array
    {
        if ($c === null) return null;

        // If already an array of 3 numerics
        if (is_array($c) && count($c) === 3 && self::allNumeric($c)) {
            return [ (int)$c[0], (int)$c[1], (int)$c[2] ];
        }

        // If string and hex-like
        if (is_string($c) && self::isHexColor($c)) {
            return self::hexToRgb($c);
        }

        // If string like "r,g,b" (comma separated)
        if (is_string($c) && strpos($c, ',') !== false) {
            $parts = array_map('trim', explode(',', $c));
            if (count($parts) === 3 && self::allNumeric($parts)) {
                return [ (int)$parts[0], (int)$parts[1], (int)$parts[2] ];
            }
        }

        // If passed as three separate numeric args (rare) e.g. CLI::truecolor($t, [r,g,b]) handled above
        // Otherwise, unsupported -> return null
        return null;
    }

    private static function allNumeric(array $a): bool
    {
        foreach ($a as $v) {
            if (!is_numeric($v)) return false;
        }
        return true;
    }

    private static function isHexColor(string $s): bool
    {
        $s = trim($s);
        // accept '#abc', '#aabbcc', 'abc', 'aabbcc'
        if (preg_match('/^#?[0-9a-fA-F]{3}$/', $s)) return true;
        return (bool)preg_match('/^#?[0-9a-fA-F]{6}$/', $s);
    }

    private static function hexToRgb(string $s): array
    {
        $s = ltrim(trim($s), '#');
        if (strlen($s) === 3) {
            $s = $s[0].$s[0].$s[1].$s[1].$s[2].$s[2];
        }
        return [ hexdec(substr($s,0,2)), hexdec(substr($s,2,2)), hexdec(substr($s,4,2)) ];
    }

    /**
     * Build the ANSI code according to detected mode
     *
     * @param integer $r
     * @param integer $g
     * @param integer $b
     * @param boolean $bg
     * @param string|null $mode optional [truecolor|256|16]. For color mode auto detection leave as null, however, the fallback default is 16.
     * @return string
     */
    public static function ansiFor(int $r, int $g, int $b, bool $bg, ?string $mode = null): string
    {
        if($mode === null) $mode = self::$colormode ?? CliColor::detectColorMode();

        $r = max(0, min(255, $r));
        $g = max(0, min(255, $g));
        $b = max(0, min(255, $b));
        if ($mode === 'truecolor') {
            return "\033[" . ($bg ? "48;2;{$r};{$g};{$b}m" : "38;2;{$r};{$g};{$b}m");
        }
        if ($mode === '256') {
            $idx = self::rgb_to_256($r,$g,$b);
            return "\033[" . ($bg ? "48;5;{$idx}m" : "38;5;{$idx}m");
        }
        // 16-color fallback
        [$baseIdx, $isBright] = self::rgb_to_16($r,$g,$b);
        if ($isBright) {
            $code = ($bg ? 100 : 90) + $baseIdx;
        } else {
            $code = ($bg ? 40 : 30) + $baseIdx;
        }
        return "\033[{$code}m";
    }

    // Mode detection (heuristic)
    public static function detectColorMode(): string
    {
        $force = getenv('FORCE_COLOR_MODE');
        if ($force) {
            $f = strtolower($force);
            if (in_array($f, ['truecolor','256','16'])) return $f;
        }
        $colorterm = strtolower((string)getenv('COLORTERM'));
        if ($colorterm !== '' && (strpos($colorterm, 'truecolor') !== false || strpos($colorterm, '24bit') !== false)) {
            return 'truecolor';
        }
        $term = strtolower((string)getenv('TERM'));
        if (strpos($term, '256color') !== false) return '256';
        if (getenv('WT_SESSION') || getenv('TERM_PROGRAM') === 'vscode') return 'truecolor';
        return '16';
    }

    // rgb -> 256 palette index (xterm)
    private static function rgb_to_256(int $r, int $g, int $b): int
    {
        if ($r === $g && $g === $b) {
            if ($r < 8) return 16;
            if ($r > 248) return 231;
            return (int)round(((($r - 8) / 247) * 24)) + 232;
        }
        $ri = (int)round(($r / 255) * 5);
        $gi = (int)round(($g / 255) * 5);
        $bi = (int)round(($b / 255) * 5);
        return 16 + (36 * $ri) + (6 * $gi) + $bi;
    }

    // rgb -> 16-color index and bright flag
    private static function rgb_to_16(int $r, int $g, int $b): array
    {
        $ansi = [
            [0,0,0], [128,0,0], [0,128,0], [128,128,0],
            [0,0,128], [128,0,128], [0,128,128], [192,192,192],
            [128,128,128], [255,0,0], [0,255,0], [255,255,0],
            [0,0,255], [255,0,255], [0,255,255], [255,255,255],
        ];
        $bestIdx = 0; $bestDist = PHP_FLOAT_MAX;
        for ($i=0;$i<count($ansi);$i++){
            [$ar,$ag,$ab] = $ansi[$i];
            $dr=$r-$ar; $dg=$g-$ag; $db=$b-$ab;
            $dist = ($dr*$dr)+($dg*$dg)+($db*$db);
            if ($dist < $bestDist){ $bestDist=$dist; $bestIdx=$i; }
        }
        if ($bestIdx >= 8) return [$bestIdx - 8, true];
        return [$bestIdx, false];
    }

}