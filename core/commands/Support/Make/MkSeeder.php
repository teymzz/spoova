<?php

namespace spoova\mi\core\commands\Support\Make;

use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Bundle\Str\Str;
use spoova\mi\core\classes\DB;
use spoova\mi\core\classes\DB\DBSeed;
use spoova\mi\core\classes\DB\DBSeeder;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPrompt;
use spoova\mi\core\commands\Support\Make\MkBase;

class MkSeeder extends MkBase{


    public function build() : bool{

        $args = static::$args;

        $arg1 = $args[0] ?? ''; // name
        $arg2 = $args[1] ?? ''; // count
        $arg3 = $args[2] ?? ''; // flag [-O|-I][:index]?

        $filename = $arg1;
        $tableName = basename($filename);

        /* flag syntax: [-O|-I][:index]? */
        $flag   = strtolower($arg3);
        $isFlag = (bool) preg_match('/^-(o|i)(?::(\d+))?$/', $flag, $flagged);

        $isOverwrite = $isFlag && ($flagged[1] === 'o');
        $isIncrement = $isFlag && ($flagged[1] === 'i');

        /* an index targets "<name>_<index>" and overwrites it, on -O and -I alike */
        $flagIndex = ($isFlag && ($flagged[2] ?? '') !== '')? (int) $flagged[2] : null;

        $class = $filename; // database table name
        $classDir  = dirname($class);
        $classDir  = ($classDir == '.')? '' : $classDir;
        $className = strtolower('seed_'.$tableName);
        
        if($className == ''){
          Cli::textView(Cli::danger(Cli::emo('point-list').' add:seeder '), 0, '|2');
          Cli::textView(Cli::danger('Error:')." ".Cli::warn('no valid seeder name is supplied!'), '2');
          Cli::smartBreak(2);
          return false;
        }

        Cli::textView(Cli::danger(Cli::emo('point-list').' add:seeder ').Cli::warn($filename));
        Cli::break(2);

        if(strpos($filename, '.') !== false){
            Cli::textView(Cli::error('invalid character supplied on file name'), '2')->smartBreak(2);
            return false; 
        }

        if(!ctype_digit((string) $arg2) || ((int) $arg2 < 1)){
            Cli::textView(Cli::error('invalid seeder count!'), '2')->smartBreak(2);
            return false;
        }
        if(count($args) > 3){
            Cli::textView(Cli::error('invalid number of arguments count!'), '2')->smartBreak(2);
            return false;
        }

        if(($arg3 !== '') && !$isFlag) {
            Cli::textView(Cli::error('unknown argument "'.Cli::warn($arg3).'"'), '2')->smartBreak(2);
            return false;
        }

        if($flagIndex !== null && $flagIndex < 1){
            Cli::textView(Cli::error('seeder index must be 1 or greater'), '2')->smartBreak(2);
            return false;
        }

        $seedPath = fn(string $name) => docroot.'/db/seeders/'.Str::endWith($name, '.php');

        $baseName = $className;              // seed_<table>
        $filepath = $seedPath($baseName);

        $classSpace = to_namespace($classDir);

        if($flagIndex !== null){

            /* -O:index | -I:index -> overwrite "<name>_<index>" */
            $className = $baseName.'_'.$flagIndex;
            $filepath  = $seedPath($className);

            if(!is_file($filepath)){
                Cli::textView(Cli::danger("Error: ").Cli::warn('"'.$className.'"').' does not exist!', '2')->smartBreak(2);
                return false;
            }

        }elseif($isIncrement){

            /* -I -> leave the existing file alone and take the next free index */
            if(is_file($filepath)){

                $i = 0;
                do{
                    $i++;
                    $className = $baseName.'_'.$i;
                    $filepath  = $seedPath($className);
                }while(is_file($filepath));

                Cli::textView('Seeder exists. Use '.Cli::warn('"'.$className.'"').' instead? [Y/N] ');

                $option = Cli::prompt(['y','n'], fn(CliPrompt $input) => $input->trials()?:Cli::clearView('Seeder exists. Use '.Cli::warn('"'.$className.'"').' instead? [Y/N] '));

                if($option->matches('n')) Cli::textView(Cli::error('cannot continue with ambiguous file.'), break: 2)->exit();
                if($option->invalid()) Cli::textView(Cli::error('invalid option suppied file.'), break: 2)->exit();
            }

        }elseif(!$isOverwrite && is_file($filepath)){

            Cli::textView(Cli::danger("Error: ").Cli::warn('"'.$className.'"').' already exists!', '2')->smartBreak(2);
            return false;

        }

        /* class namespace starting from seeders folder  */
        $seedersSpace  = to_namespace('db\seeders\\'.$classSpace);
        
        /* class full folder namespace */
        $nameSpace = scheme($seedersSpace, false);    

        /* class full namespace */
        $fileNameSpace = $nameSpace.'\\'.$className;

        /* class relative seeders directory */
        $fileDir  = to_frontslash($seedersSpace);
        
        /* class absolute file path */
        //$fileLoc  = $fileDir.'/'.$dbTable.'.php'; /* relative file path */

        $data = "[]";

        if($db = DB::boot()){

            if(!$db->currentDB()){
                Cli::errorView('database table not selected.');
                Cli::exit(breaksAfter: 2);
            }

            $tables = $db->tables();

            if(!in_array($class, $tables)){
                Cli::textView(Cli::error('Unknown database table "'.Cli::warn($class).'"'));
                Cli::break(1)->bashBreak(1);
                exit;
            }else{
                new DBSeeder($db, $class);

                // Honour a seeder's seed_* overrides when the class already
                // exists (regeneration); harmless on first generation.
                DBSeeder::useSeeder($fileNameSpace);

                $seed_count = (int) $arg2;
                $seeds = DBSeeder::seed($seed_count);

                $data = "[\n";
                foreach($seeds as $seed){

                    $data .= "      [";
                    foreach($seed as $k => $s){
                        $data .= "'$k' => '$s',";
                    }
                    $data = rtrim($data,',');
                    $data .= "],\n";

                }
                $data = rtrim($data,',');
                $data .= '    ]';
            }

        }

        // Capture developer-added methods/imports from the existing file BEFORE
        // it is opened/overwritten, so regeneration doesn't wipe custom overrides.
        [$preservedMethods, $preservedUses] = self::preserveCustomMembers($nameSpace.'\\'.$className, $filepath);

        $Filemanager = new Filemanager;

        if($Filemanager->openFile(true, $filepath)) {

            $content = <<<SCRIPT

              public static function seeds() : array {

                return $data;

              }

              public static function table() : string {

                return '$tableName';

              }

            SCRIPT;

            // re-attach any preserved custom methods after the generated ones
            $content .= $preservedMethods;

            $format = self::classFormat([
                'namespace' => $nameSpace,
                'class'     => $className,
                'methods'   => $content,
                'use'       => array_values(array_unique(array_merge([DBSeed::class], $preservedUses))),
                'extends'   => 'DBSeed',
            ]);
            file_put_contents($filepath, $format);
            
            if(is_file($filepath) && class_exists($nameSpace.'\\'.$className)){

                Cli::textView("seeder file ".Cli::alert($className)." created successfully in ".Cli::warn($fileDir));
                Cli::smartBreak(2);
                return true;

            }  else {

                
                Cli::textView("seeder file ".Cli::alert($className)." failed to create in ".Cli::danger($fileDir)." directory.");
                Cli::smartBreak(2);

            }           

        }

        return false;
    }

    /**
     * Extracts developer-added members from an existing seeder so they survive
     * regeneration. seeds()/table() are always rewritten and are therefore
     * excluded; every other class member declared in the file — constants,
     * properties, methods and trait `use` — is preserved verbatim (with its
     * docblock/attributes), along with the file's top-of-file `use` imports
     * (minus DBSeed, which the template re-adds).
     *
     * A token walk is used rather than reflection because reflection exposes no
     * source span for constants or properties.
     *
     * @param string $fqcn     fully-qualified seeder class name (unused; kept for API clarity)
     * @param string $filepath path to the existing seeder file
     * @return array{0:string,1:array} [preserved member source, preserved use statements]
     */
    private static function preserveCustomMembers(string $fqcn, string $filepath) : array {

        if(!is_file($filepath)) return ['', []];

        $code = file_get_contents($filepath);
        if($code === false || trim($code) === '') return ['', []];

        $tokens = token_get_all($code);
        $count  = count($tokens);
        $text   = fn($t) => is_array($t) ? $t[1] : $t;

        // Locate the class keyword (guarding against "::class") and its body brace.
        $classAt = -1;
        for($i = 0; $i < $count; $i++){
            if(is_array($tokens[$i]) && $tokens[$i][0] === T_CLASS){
                $prev = $i - 1;
                while($prev >= 0 && is_array($tokens[$prev]) && $tokens[$prev][0] === T_WHITESPACE) $prev--;
                if($prev >= 0 && is_array($tokens[$prev]) && $tokens[$prev][0] === T_DOUBLE_COLON) continue;
                $classAt = $i;
                break;
            }
        }
        if($classAt === -1) return ['', []];

        // Preserve the top-of-file `use` imports (everything before the class), minus DBSeed.
        $uses = [];
        $head = '';
        for($i = 0; $i < $classAt; $i++) $head .= $text($tokens[$i]);
        if(preg_match_all('/^\s*use\s+([^;]+);/m', $head, $m)){
            foreach($m[1] as $u){
                $u = trim($u);
                if($u !== '' && ltrim($u, '\\') !== ltrim(DBSeed::class, '\\')) $uses[] = $u;
            }
        }

        // Find the class body opening brace.
        $bodyStart = -1;
        for($i = $classAt; $i < $count; $i++){
            if($tokens[$i] === '{'){ $bodyStart = $i; break; }
        }
        if($bodyStart === -1) return ['', $uses];

        $skip    = ['seeds', 'table'];
        $members = '';
        $j = $bodyStart + 1;

        while($j < $count && $tokens[$j] !== '}'){

            // skip inter-member whitespace
            if(is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE){ $j++; continue; }

            $memberStart = $j;

            // Recover the member's leading indentation from the whitespace we skipped,
            // so its first line lines up with the rest of the (already-indented) body.
            $indent = '';
            if($memberStart > 0 && is_array($tokens[$memberStart - 1]) && $tokens[$memberStart - 1][0] === T_WHITESPACE){
                $ws = $tokens[$memberStart - 1][1];
                $nl = strrpos($ws, "\n");
                $indent = ($nl === false) ? $ws : substr($ws, $nl + 1);
            }

            // Look ahead past doc/comments/attributes/modifiers to classify the member.
            $k = $j; $kind = 'property'; $fname = null;
            while($k < $count){
                $tk = $tokens[$k];
                if(is_array($tk)){
                    $id = $tk[0];
                    if(in_array($id, [T_DOC_COMMENT, T_COMMENT, T_WHITESPACE, T_PUBLIC, T_PROTECTED,
                                      T_PRIVATE, T_STATIC, T_ABSTRACT, T_FINAL, T_READONLY, T_VAR], true)){
                        $k++; continue;
                    }
                    if($id === T_ATTRIBUTE){ // '#[' ... ']'
                        $depth = 1; $k++;
                        while($k < $count && $depth > 0){
                            if($tokens[$k] === '[') $depth++;
                            elseif($tokens[$k] === ']') $depth--;
                            $k++;
                        }
                        continue;
                    }
                    if($id === T_FUNCTION){ $kind = 'function'; break; }
                    if($id === T_CONST){ $kind = 'const'; break; }
                    if($id === T_USE){ $kind = 'use'; break; }
                }
                break; // a type token, '?', T_VARIABLE, etc. => property
            }

            // Determine the member's end index.
            if($kind === 'function'){
                // capture the name, then walk params, then body block or ';'
                $p = $k + 1;
                while($p < $count && !(is_array($tokens[$p]) && $tokens[$p][0] === T_STRING)) $p++;
                if($p < $count) $fname = $tokens[$p][1];
                while($p < $count && $tokens[$p] !== '(') $p++;
                for($d = 0; $p < $count; $p++){
                    if($tokens[$p] === '(') $d++;
                    elseif($tokens[$p] === ')'){ $d--; if($d === 0){ $p++; break; } }
                }
                $memberEnd = $p;
                while($p < $count){
                    if($tokens[$p] === '{'){
                        for($d = 0; $p < $count; $p++){
                            if($tokens[$p] === '{') $d++;
                            elseif($tokens[$p] === '}'){ $d--; if($d === 0) break; }
                        }
                        $memberEnd = $p; break;
                    }
                    if($tokens[$p] === ';'){ $memberEnd = $p; break; }
                    $p++;
                }
            }else{
                // const / property / trait use: ends at the next ';'
                $p = $k;
                while($p < $count && $tokens[$p] !== ';') $p++;
                $memberEnd = $p;
            }

            // Capture verbatim source unless this is a regenerated method.
            if(!($kind === 'function' && in_array(strtolower((string) $fname), $skip, true))){
                $src = '';
                for($x = $memberStart; $x <= $memberEnd && $x < $count; $x++) $src .= $text($tokens[$x]);
                $members .= "\n".$indent.rtrim($src, "\r\n")."\n";
            }

            $j = $memberEnd + 1;
        }

        return [$members, $uses];
    }


}