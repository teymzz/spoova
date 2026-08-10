<?php

namespace spoova\mi\core\classes;

use Throwable;
use spoova\mi\core\commands\Root\Cli;

class Benchmark {

    /**
     * Start time of the running test.
     *
     * microtime(true) returns a float. Declaring this as int floors it, which
     * throws away the fraction the whole measurement depends on, so every
     * result is inflated by a random amount up to one full second.
     */
    private static float $start = 0.0;

    /** Memory in use when the running test started */
    private static int $memory = 0;

    /** Name of the running test */
    private static string $name = '';

    private static array $tests = [];

    /** Number of times each test is executed. Timings are averaged over it. */
    private static int $repeat = 1;

    /** Runs each test once, untimed, before measuring */
    private static bool $warmup = false;

    /** Recorded run the current one is compared against */
    private static array $base = [];

    /** File the baseline is read from and, when absent, written to */
    private static string $basefile = '';

    /** A test is only reported as changed once it moves past this fraction */
    private static float $tolerance = 0.10;

    /** Orders the table by speed instead of the order the tests were declared in */
    private static bool $sorted = false;

    /** Number of cells in the relative bar */
    private const BAR = 10;

    private static function start(string $name){
        self::$name = $name;
        self::$memory = memory_get_usage();
        self::$start = microtime(true);
    }

    /**
     * Closes the running test.
     *
     * @param array $times elapsed seconds of each iteration. Defaults to a
     *                     single reading taken here, so a lone start()/stop()
     *                     pair still measures one run as it always did.
     */
    private static function stop(array $times = []){

        $name = self::$name;
        $start = self::$start;
        $stop = microtime(true);

        if(!$times) $times = [$stop - $start];

        $runs = count($times);
        $total = array_sum($times);
        $diff = $total / $runs;

        self::$tests[$name]['start']  = $start;
        self::$tests[$name]['stop']   = $stop;
        self::$tests[$name]['diff']   = $diff;
        self::$tests[$name]['time']   = self::readable($diff);
        self::$tests[$name]['runs']   = $runs;
        self::$tests[$name]['total']  = $total;
        self::$tests[$name]['min']    = min($times);
        self::$tests[$name]['max']    = max($times);
        self::$tests[$name]['ops']    = ($diff > 0)? (1 / $diff) : 0.0;
        self::$tests[$name]['memory'] = memory_get_usage() - self::$memory;
        self::$tests[$name]['peak']   = memory_get_peak_usage(true);
        self::$tests[$name]['error']  = '';

    }

    /**
     * @param $key selects a specific key or a list of keys in the tests results
     * @phan-return mixed
     *  -  false : if key is not found
     *  -  array : if $key is NULL or a list of keys
     */
    public static function info(string|int|array|null $key = null) : mixed{

        if($key === null) return self::$tests;

        if(is_array($key)){
            $list = [];
            foreach($key as $name){
                if(is_string($name) || is_int($name)) $list[$name] = self::$tests[$name] ?? false;
            }
            return $list;
        }

        return self::$tests[$key] ?? false;
    }

    /**
     * Sets how many times each test is executed. Reported timings are the
     * average of the runs, with the spread shown as min and max.
     *
     * @param integer $times
     * @return void
     */
    public static function repeat(int $times) : void {
        self::$repeat = max(1, $times);
    }

    /**
     * Runs each test once before measuring, so that lazily built caches,
     * autoloads and opcode warmups are not charged to the first test.
     *
     * @param boolean $enabled
     * @return void
     */
    public static function warmup(bool $enabled = true) : void {
        self::$warmup = $enabled;
    }

    /**
     * Lists the results fastest first rather than in the order they were declared,
     * which lets the relative bar be read as a ranking. Tests that never produced a
     * measurement are listed last.
     *
     * @param boolean $enabled
     * @return void
     */
    public static function sort(bool $enabled = true) : void {
        self::$sorted = $enabled;
    }

    /**
     * Compares the run against a previously recorded one.
     *
     * When the file does not exist the current run is written to it and becomes
     * the reference, so the first call records and every later call compares.
     *
     * @param string $file path of the baseline json file
     * @param float $tolerance fraction a test must move by before it is reported
     *                         as faster or slower. Default is 0.10 (10%).
     * @return void
     */
    public static function baseline(string $file, float $tolerance = 0.10) : void {

        self::$basefile = $file;
        self::$tolerance = abs($tolerance);
        self::$base = [];

        if(!is_file($file)) return;

        $saved = json_decode((string) file_get_contents($file), true);

        if(is_array($saved)) self::$base = $saved;

    }

    /**
     * Writes the results to a file.
     *
     * @param string $file
     * @param string $format json|csv. Defaults to the file extension, else json.
     * @return bool
     */
    public static function export(string $file, string $format = '') : bool {

        if($format === '') $format = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $data = (strtolower($format) === 'csv')? self::toCsv() : self::toJson();

        return file_put_contents($file, $data) !== false;

    }

    /**
     * Clears every recorded result, so that a later run starts on an empty table.
     *
     * @return void
     */
    public static function reset() : void {
        self::$tests = [];
    }

    /**
     * Runs a list of functions
     *
     * @param array $items list of functions to be benchmarked. The key is the name of the test and the value is a closure function.
     * @param boolean $output determines if the results should be outputted or returned as an array. Default is true (outputted).
     * @return void
     */
    public static function fn(array $items, bool $output = true) {

        foreach($items as $name => $item) {

            $name = (string) $name;

            if(!is_callable($item)) {
                self::$tests[$name] = self::blank('not callable: '.get_debug_type($item).' supplied');
                continue;
            }

            if(self::$warmup){
                try{ $item(); }catch(Throwable $e){ }
            }

            $times = [];
            $error = '';

            self::start($name);

            for($i = 0; $i < self::$repeat; $i++){

                $mark = microtime(true);

                try{
                    $item();
                    $times[] = microtime(true) - $mark;
                }catch(Throwable $e){
                    // record what was measured before the throw, then stop repeating
                    $times[] = microtime(true) - $mark;
                    $error = get_class($e).': '.$e->getMessage();
                    break;
                }

            }

            self::stop($times);
            self::$tests[$name]['error'] = $error;

        }

        self::record();

        if(!$output) return self::$tests;

        self::render();

    }

    /**
     * Outputs the results, as a table on the terminal and as one on a page.
     *
     * @param boolean $return returns the output instead of printing it
     * @return string|null
     */
    public static function render(bool $return = false) : ?string {

        if(isCli()){

            $table = self::cliTable();

            if($return) return $table;

            Cli::textView(Cli::alert($table));
            return null;

        }

        $table = self::htmlTable();

        if($return) return $table;

        print $table;
        return null;

    }

    /**
     * Writes the current run as the baseline when none was found on disk.
     */
    private static function record() : void {

        if(self::$basefile === '' || self::$base || !self::$tests) return;

        $saved = [];

        foreach(self::$tests as $name => $test){
            $saved[$name] = ['diff' => $test['diff'], 'runs' => $test['runs']];
        }

        // deliberately not loaded back into $base: the run that establishes the
        // reference has nothing to be compared against yet, and reporting it as
        // 0.0% slower than itself would read as a result
        file_put_contents(self::$basefile, json_encode($saved, JSON_PRETTY_PRINT));

    }

    /**
     * Result of a test that never ran.
     */
    private static function blank(string $error) : array {
        return [
            'start' => 0.0, 'stop' => 0.0, 'diff' => 0.0, 'time' => '-',
            'runs' => 0, 'total' => 0.0, 'min' => 0.0, 'max' => 0.0,
            'ops' => 0.0, 'memory' => 0, 'peak' => 0, 'error' => $error
        ];
    }

    /**
     * Picks the unit that keeps a duration readable, so that a microsecond
     * test does not flatten to "0ms" and a slow one does not run to six digits.
     */
    private static function readable(float $seconds) : string {

        if($seconds >= 1) return number_format($seconds, 4).'s';
        if($seconds >= 0.001) return number_format($seconds * 1000, 3).'ms';
        if($seconds >= 0.000001) return number_format($seconds * 1000000, 2).'µs';

        return number_format($seconds * 1000000000).'ns';

    }

    private static function bytes(int $bytes) : string {

        $sign = ($bytes < 0)? '-' : '';
        $bytes = abs($bytes);

        if($bytes >= 1048576) return $sign.number_format($bytes / 1048576, 2).'MB';
        if($bytes >= 1024) return $sign.number_format($bytes / 1024, 1).'KB';

        return $sign.$bytes.'B';

    }

    /**
     * Everything both renderers need: the display strings, the bar fraction and
     * the baseline delta, worked out once from the recorded results.
     */
    private static function summary() : array {

        $fastest = 0.0;
        $slowest = 0.0;
        $multi = false;

        // a test that threw stopped early, so its timing is not a result and must
        // not set the scale the sound tests are measured against
        foreach(self::$tests as $test){

            if($test['runs'] < 1 || $test['error'] !== '') continue;
            if($test['runs'] > 1) $multi = true;

            if($fastest <= 0.0 || $test['diff'] < $fastest) $fastest = $test['diff'];
            if($test['diff'] > $slowest) $slowest = $test['diff'];

        }

        $rows = [];

        foreach(self::$tests as $name => $test){

            $ran = ($test['runs'] > 0);
            $ok = ($ran && $test['error'] === '');

            $rel = ($ok && $fastest > 0)? $test['diff'] / $fastest : 0.0;
            $share = ($ok && $slowest > 0)? $test['diff'] / $slowest : 0.0;

            $delta = null;
            $moved = 'same';

            if(isset(self::$base[$name]['diff']) && $ok){

                $was = (float) self::$base[$name]['diff'];

                if($was > 0){
                    $delta = ($test['diff'] - $was) / $was;
                    if($delta > self::$tolerance) $moved = 'slower';
                    elseif($delta < -self::$tolerance) $moved = 'faster';
                }

            }

            $rows[] = [
                'name'   => $name,
                'ran'    => $ran,
                'ok'     => $ok,
                // a test that threw produced no result, so nothing is reported for it
                // except the error itself. Its partial timing is not a measurement.
                'runs'   => $ok? (string) $test['runs'] : '-',
                'time'   => $ok? $test['time'] : '-',
                'min'    => $ok? self::readable($test['min']) : '-',
                'max'    => $ok? self::readable($test['max']) : '-',
                'ops'    => ($ok && $test['ops'] > 0)? number_format($test['ops']) : '-',
                'memory' => $ok? self::bytes($test['memory']) : '-',
                'rel'    => ($rel > 0)? 'x'.number_format($rel, 2) : '-',
                'share'  => $share,
                'delta'  => $delta,
                'moved'  => $moved,
                'error'  => $test['error'],
            ];

        }

        if(self::$sorted){
            usort($rows, function($a, $b){
                if($a['ok'] !== $b['ok']) return $a['ok']? -1 : 1;   // unmeasured tests sink
                return $a['share'] <=> $b['share'];
            });
        }

        return ['rows' => $rows, 'multi' => $multi, 'based' => (bool) self::$base];

    }

    private static function percent(?float $delta) : string {

        if($delta === null) return '-';

        return (($delta > 0)? '+' : '').number_format($delta * 100, 1).'%';

    }

    /**
     * Pads a cell to an exact width. Cli::dots() measures with mb_strlen, so a
     * multibyte glyph in a cell does not throw the column out of line.
     */
    private static function pad(string $text, int $width, string $align = 'l') : string {

        $fill = Cli::dots($width, $text, ' ');

        return ($align === 'r')? $fill.$text : $text.$fill;

    }

    private static function bar(float $share, bool $ok = true) : string {

        // nothing was measured, so there is no track to draw either
        if(!$ok) return str_repeat(' ', self::BAR);

        $filled = (int) round($share * self::BAR);
        $filled = min(max($filled, ($share > 0)? 1 : 0), self::BAR);

        return str_repeat('█', $filled).str_repeat('░', self::BAR - $filled);

    }

    private static function cliTable() : string {

        $summary = self::summary();
        $multi = $summary['multi'];
        $based = $summary['based'];

        $head = ['Benchmark'];
        $align = ['l'];

        if($multi){ $head[] = 'Runs'; $align[] = 'r'; }

        $head[] = 'Time'; $align[] = 'r';

        if($multi){
            $head[] = 'Min'; $align[] = 'r';
            $head[] = 'Max'; $align[] = 'r';
        }

        $head[] = 'Ops/s';  $align[] = 'r';
        $head[] = 'Memory'; $align[] = 'r';
        $head[] = 'Rel';    $align[] = 'r';
        $head[] = '';       $align[] = 'l';

        if($based){ $head[] = 'Base'; $align[] = 'r'; }

        $body = [];
        $notes = [];

        foreach($summary['rows'] as $row){

            $cells = [$row['name']];

            if($multi) $cells[] = $row['runs'];

            $cells[] = $row['time'];

            if($multi){
                $cells[] = $row['min'];
                $cells[] = $row['max'];
            }

            $cells[] = $row['ops'];
            $cells[] = $row['memory'];
            $cells[] = $row['rel'];
            $cells[] = self::bar($row['share'], $row['ok']);

            if($based){
                $mark = ($row['moved'] === 'slower')? ' ▲' : (($row['moved'] === 'faster')? ' ▼' : '');
                $cells[] = self::percent($row['delta']).$mark;
            }

            $body[] = $cells;

            if($row['error'] !== '') $notes[] = $row['name'].': '.$row['error'];

        }

        // widths follow the content, so a long name can never clip the column
        $widths = [];

        foreach($head as $i => $title) $widths[$i] = mb_strlen($title);

        foreach($body as $cells){
            foreach($cells as $i => $cell) $widths[$i] = max($widths[$i], mb_strlen($cell));
        }

        foreach($widths as $i => $width) $widths[$i] = $width + 2;

        $span = 1;
        foreach($widths as $width) $span += $width + 1;

        $rule = str_repeat('-', $span).br();

        $table = br();
        $table .= $rule;
        $table .= self::cliRow($head, $widths, $align);
        $table .= $rule;

        foreach($body as $cells){
            $table .= self::cliRow($cells, $widths, $align);
            flush();
        }

        $table .= $rule;

        if($notes){
            $table .= br();
            foreach($notes as $note) $table .= '! '.$note.br();
        }

        return $table;

    }

    private static function cliRow(array $cells, array $widths, array $align) : string {

        $row = '|';

        foreach($cells as $i => $cell){

            $width = $widths[$i];

            $row .= ($align[$i] === 'r')
                  ? self::pad($cell, $width - 1, 'r').' '
                  : ' '.self::pad($cell, $width - 1);

            $row .= '|';

        }

        return Cli::textIndent($row, 0).br();

    }

    private static function htmlTable() : string {

        $summary = self::summary();
        $multi = $summary['multi'];
        $based = $summary['based'];

        $head = '<th scope="col">Benchmark</th>';
        if($multi) $head .= '<th scope="col" class="bm-num">Runs</th>';
        $head .= '<th scope="col" class="bm-num">Time</th>';
        if($multi) $head .= '<th scope="col" class="bm-num">Min</th><th scope="col" class="bm-num">Max</th>';
        $head .= '<th scope="col" class="bm-num">Ops/s</th>';
        $head .= '<th scope="col" class="bm-num">Memory</th>';
        $head .= '<th scope="col" class="bm-num">Rel</th>';
        $head .= '<th scope="col" class="bm-plot">Relative time</th>';
        if($based) $head .= '<th scope="col" class="bm-num">vs baseline</th>';

        $columns = 5 + ($multi? 3 : 0) + ($based? 1 : 0);

        $body = '';

        foreach($summary['rows'] as $row){

            $name = htmlspecialchars($row['name'], ENT_QUOTES);
            $width = number_format($row['share'] * 100, 2);
            $label = htmlspecialchars($row['name'].': '.$row['time'], ENT_QUOTES);

            $body .= '<tr>';
            $body .= '<th scope="row">'.$name.'</th>';
            if($multi) $body .= '<td class="bm-num">'.$row['runs'].'</td>';
            $body .= '<td class="bm-num">'.$row['time'].'</td>';
            if($multi) $body .= '<td class="bm-num">'.$row['min'].'</td><td class="bm-num">'.$row['max'].'</td>';
            $body .= '<td class="bm-num">'.$row['ops'].'</td>';
            $body .= '<td class="bm-num">'.$row['memory'].'</td>';
            $body .= '<td class="bm-num">'.$row['rel'].'</td>';
            $body .= '<td class="bm-plot">'
                   . ($row['ok']
                        ? '<span class="bm-track" title="'.$label.'">'
                          .'<span class="bm-fill" style="width:'.$width.'%"></span></span>'
                        : '')
                   . '</td>';

            if($based){

                $moved = $row['moved'];
                $icon = ($moved === 'slower')? '▲' : (($moved === 'faster')? '▼' : '');

                $body .= '<td class="bm-num bm-'.$moved.'">'
                       . (($row['delta'] === null)? '-'
                            : '<span aria-hidden="true">'.$icon.'</span> '.self::percent($row['delta']))
                       . '</td>';

            }

            $body .= '</tr>';

            if($row['error'] !== ''){
                $body .= '<tr class="bm-failed"><td colspan="'.$columns.'">'
                       . htmlspecialchars($row['error'], ENT_QUOTES).'</td></tr>';
            }

        }

        return '<div class="bm-root">'.self::htmlStyle()
             . '<table><caption>Benchmark results</caption>'
             . '<thead><tr>'.$head.'</tr></thead>'
             . '<tbody>'.$body.'</tbody></table></div>';

    }

    private static function htmlStyle() : string {

        return <<<'CSS'
        <style>
        .bm-root{
            color-scheme: light;
            --bm-surface:#fcfcfb; --bm-ink:#0b0b0b; --bm-ink-2:#52514e; --bm-muted:#898781;
            --bm-rule:#e1e0d9; --bm-track:#f0efec; --bm-series:#2a78d6;
            --bm-slower:#d03b3b; --bm-faster:#0ca30c;
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background: var(--bm-surface); color: var(--bm-ink);
            padding: 16px; border-radius: 8px; overflow-x: auto;
            border: solid 1px var(--bm-rule); font-size: 13px;
        }
        @media (prefers-color-scheme: dark){
            :root:where(:not([data-theme="light"])) .bm-root{
                color-scheme: dark;
                --bm-surface:#1a1a19; --bm-ink:#ffffff; --bm-ink-2:#c3c2b7; --bm-muted:#898781;
                --bm-rule:#2c2c2a; --bm-track:#383835; --bm-series:#3987e5;
            }
        }
        :root[data-theme="dark"] .bm-root{
            color-scheme: dark;
            --bm-surface:#1a1a19; --bm-ink:#ffffff; --bm-ink-2:#c3c2b7; --bm-muted:#898781;
            --bm-rule:#2c2c2a; --bm-track:#383835; --bm-series:#3987e5;
        }
        .bm-root table{ border-collapse: collapse; width: 100%; }
        .bm-root caption{
            text-align: left; color: var(--bm-muted); font-size: 11px;
            letter-spacing: .08em; text-transform: uppercase; padding-bottom: 10px;
        }
        .bm-root th, .bm-root td{
            padding: 7px 12px; text-align: left; white-space: nowrap;
            border-bottom: solid 1px var(--bm-rule);
        }
        .bm-root thead th{
            color: var(--bm-muted); font-weight: 500; font-size: 11px;
            letter-spacing: .04em; text-transform: uppercase;
        }
        .bm-root tbody th{ font-weight: 500; color: var(--bm-ink); }
        .bm-root tbody tr:hover td, .bm-root tbody tr:hover th{ background: var(--bm-track); }
        .bm-root .bm-num{ text-align: right; font-variant-numeric: tabular-nums; color: var(--bm-ink-2); }
        .bm-root .bm-plot{ width: 34%; min-width: 120px; }
        .bm-root .bm-track{ display: block; background: var(--bm-track); border-radius: 4px; height: 8px; }
        .bm-root .bm-fill{
            display: block; background: var(--bm-series);
            border-radius: 0 4px 4px 0; height: 8px; min-width: 2px;
        }
        .bm-root .bm-slower{ color: var(--bm-slower); }
        .bm-root .bm-faster{ color: var(--bm-faster); }
        .bm-root .bm-failed td{ color: var(--bm-slower); white-space: normal; font-size: 12px; }
        </style>
        CSS;

    }

    private static function toJson() : string {
        return (string) json_encode(self::$tests, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    private static function toCsv() : string {

        $columns = ['name','runs','diff','total','min','max','ops','memory','peak','error'];
        $csv = implode(',', $columns)."\n";

        foreach(self::$tests as $name => $test){

            $cells = [$name];

            foreach($columns as $column){
                if($column === 'name') continue;
                $cells[] = $test[$column] ?? '';
            }

            $cells = array_map(function($cell){
                $cell = (string) $cell;
                return (preg_match('/[",\n]/', $cell))? '"'.str_replace('"', '""', $cell).'"' : $cell;
            }, $cells);

            $csv .= implode(',', $cells)."\n";

        }

        return $csv;

    }

}
