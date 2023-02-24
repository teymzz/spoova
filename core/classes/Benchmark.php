<?php

namespace spoova\core\classes;

use Closure;
use spoova\core\commands\Cli;

class Benchmark {

    private static $start;
    private static $stop;
    private static $name;
    private static $maxlength = 6;

    static $tests = [];

    private static function start($name){
        self::$name = $name;
        self::$start = microtime(true);
    }

    private static function stop(){

        $name = self::$name;
        $start = self::$start;
        $stop = microtime(true);
        $diff = number_format($stop - $start, 3);

        self::$tests[$name]['start'] = $start;
        self::$tests[$name]['stop']  = $stop;
        self::$tests[$name]['diff']  = $diff;

    }


    public static function fn(array $items, bool $output = true) {

        foreach($items as $name => $item) {

            if((strlen($name)+1) > self::$maxlength) self::$maxlength = strlen($name) + 1;
            if(strlen($name) < strlen('Benchmark')) self::$maxlength = strlen('Benchmark') + 1;

            if($item instanceof Closure) {
                self::start($name);
                $item();
                self::stop();
            }

        }

        if(!$output) return self::$tests;

        if(isCli()) {

            $maxlength = self::$maxlength;
            $maxdef = 20;
            $lines = (3 * $maxdef) + 5;
    
            $table = '';
    
            $table .= br();
            
            $table .= str_repeat('-', $maxlength + $lines).br();
            $table .= "|";
            $table .= Cli::textIndent('Benchmark'.Cli::dots($maxlength, 'Benchmark', ' '), 0);
            $table .= "|"; 
            $table .= Cli::textIndent('Start'.Cli::dots($maxdef, 'Start', ' '), 0);
            $table .= "|"; 
            $table .= Cli::textIndent('Stop'.Cli::dots($maxdef, 'Stop', ' '), 0);
            $table .= "|"; 
            $table .= Cli::textIndent('Diff'.Cli::dots($maxdef, 'Diff', ' '), 0);
            $table .= "|"; 
            $table .= br();    
    
            foreach(self::$tests as $test => $test_value){
    
                $start = $test_value['start'];
                $stop = $test_value['stop'];
                $diff = $test_value['diff'];
    
                $table .= str_repeat('-', $maxlength + $lines).br();
                $table .= "|";
                $table .= Cli::textIndent($test.Cli::dots($maxlength, $test, ' '), 0);
                $table .= "|";
                $table .= Cli::textIndent($start.Cli::dots($maxdef, $start, ' '), 0);
                $table .= "|";
                $table .= Cli::textIndent($stop.Cli::dots($maxdef, $stop, ' '), 0);
                $table .= "|";
                $table .= Cli::textIndent($diff.Cli::dots($maxdef, $diff, ' '), 0);
                $table .= "|";
                $table .= br();
    
            }      
    
            $table .= str_repeat('-', $maxlength + $lines).br();
            $table .= br('', 1);
    
            Cli::textView(Cli::alert($table));

        } else {

            print "<pre>"; 

            print_r(self::$tests);

            print "</pre>";
            //print a benchmark table

        }

    }


}