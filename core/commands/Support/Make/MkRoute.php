<?php

namespace spoova\mi\core\commands\Support\Make;

use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliArgs;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\Url;

/**
 * This class is an alias for MKWinRoute
 */
class MkRoute extends MkBase{

    public function build() : bool{

        /* Positionals and directives are separated up front so that a directive may
           be written anywhere in the command, and so an unknown one is named rather
           than being mistaken for the "extends" argument. */
        $input = (new CliArgs(static::$args))
            ->arg('class')
            ->arg('extends')
            ->flag('overwrite', ['-O'])
            ->flag('live', ['--live'])
            ->flag('load', ['--load'])
            ->max(2)
            ->parse();

        if(!$input->ok()){
            foreach($input->errors() as $error){
                Cli::textView(Cli::error($error), '1');
            }
            Cli::break(2);
            return false;
        }

        $arg1 = $input->getArg('class') ?? '';
        $arg2 = $input->getArg('extends') ?? '';

        $overwrite = $input->isFlag('overwrite');

        /* --live and --load both enable the loader; they differ only in whether the
           template that gets written carries the @live directive. */
        $useLive = $input->isFlag('live');
        $useLoad = $input->isFlag('load');

        if($useLive && $useLoad){
            Cli::textView(Cli::error('Directives "--live" and "--load" cannot be combined.'), '1');
            Cli::break(2);
            return false;
        }

        $loads = $useLive || $useLoad;

        $class = $arg1;
        $class = ltrim(to_frontslash($class, true), '/');
        $class = to_frontslash($class, true);
        $classDir  = dirname($class);
        $classDir  = ($classDir == '.')? '' : $classDir;
        $className = ucfirst(basename($class));
        
        /* Note:: all space variables have no trail slash */

        /* class subnamespace in Routes if subnamespace exists */
        $classSpace = to_namespace($classDir);
        $url = new Url;
        $classSpace = $url->path($classSpace)->pathmod(fn($val) => ucfirst($val)); 
        
        /* class namespace starting from windows folder  */
        $routedSpace  = to_namespace(WIN_ROUTES.$classSpace);
        
        /* class full namespace */
        $nameSpace = scheme($routedSpace, false);

        /* class relative window directory */
        $fileDir  = to_frontslash($routedSpace.'\\');
        
        /* class absolute file path */
        $fileLoc   = $fileDir.$className.'.php'; /* relative file path */

        /* window routes' absolute file path */
        $filePath  = domroot($fileLoc);        
        
        Cli::textView(Cli::danger(Cli::emo('point-list').' add:routes ').Cli::warn($fileLoc));
        Cli::break(2);

        $extend = to_frontslash($arg2, true);
        $use = "Route";

        //try validating class, extends name
        $pattern1 = '~[^\w\/]~';

        if(!$class) {
            $this->display(Cli::danger('Error:').' no route name supplied!');
            $this->display('Syntax:'.Cli::btn('mi','add:route').Cli::color('<className> [frame?]', 'yellow'), 2);
            return false;
        }
        
        if(
            preg_match($pattern1, $class, $matches) || 
            preg_match($pattern1, $extend, $matches)
        ){
            Cli::textView(Cli::danger('Error:').' some invalid characters detected!', '1').Cli::break(2);
            return false;
        }

        if($extend) $use = scheme(WIN_FRAMES.$extend, false);

        $extends = $extend? $extend : 'Route';

        $Filemanager = new Filemanager;

        /* create class directory & class file */
        if(!is_file($filePath) || $overwrite){

            $rexName = strtolower($className); //set className for method...
            $tmpName = str_replace(['/','\\'], '.',strtolower($classDir.'/'.$className));

            //create class file if not exist, return false if not created                  
            if($Filemanager->openFile(true, $filePath)) {

                $rexName = strtolower($className); //set className for method...
                /* trimmed because an empty $classDir leaves a leading separator, which
                   used to reach the template name as ".name" — harmless while the loader
                   was commented out, but a wrong path once it runs */
                $tmpName = trim(str_replace(['/','\\'], '.', strtolower($classDir.'/'.$className)), '.');

                /* Without --live or --load the loader stays commented, so a new route
                   renders nothing until its author opts in. Either directive enables it. */
                $loader = $loads
                    ? "self::load('$tmpName..', fn() => compile() );"
                    : "//self::load('$tmpName..', fn() => compile() );";

                $content = <<<CContent

                    public function __construct(){

                        self::call(\$this,
                            [
                                lastCall() => '$rexName'
                            ]
                        );

                    }

                    function $rexName() {

                        $loader

                    }
    
                    /**
                     * Add name of routes
                     *
                     * @return array
                     */
                    public static function addRoutes(array \$array = []) : array {
    
                        return [
                            // 'routeName' => 'routePath'
                        ];
    
                    }
    
                CContent;
    
                $format = self::classFormat([
                    'namespace' => $nameSpace, 
                    'class'     => $className, 
                    'use'       => $use, 
                    'extends'   => basename($extends),
                    'methods'   => $content
                ]);
    
                /* re-check if file exists */
                if($Filemanager->openFile(true, $filePath)) {
                    
                    $file = fopen($filePath, 'w');
                    fputs($file, $format);
                    fclose($file);
                    
                    Cli::textView('class'.Cli::alert($className, '1')." created successfully in ".Cli::warn($fileLoc));

                    /* The loader resolves its template through the trailing "..", which would
                       scaffold one at runtime — but that scaffold always carries @live. Writing
                       it here instead is what lets --load leave the directive out. */
                    if($loads) $this->addTemplate($tmpName, $useLive, $overwrite);

                    // Cli::break(1)->bashBreak(1);
                    Cli::smartBreak(2);

                    return true;
    
                } else {
                    Cli::textView('class'.Cli::alert($className, '1')." creation failed to create in ".Cli::danger($nameSpace));
                    Cli::smartBreak(2);                
                }
    
            } else {
                Cli::textView(Cli::error('cannot access directory', 1)." ".Cli::danger($nameSpace));
                Cli::smartBreak(2); 
            }

        } else {
            Cli::textView(Cli::error('namespace', 1).Cli::warn($nameSpace.'\\'.$className, '1').' | file already exists');
            Cli::break(2);  
            
            Cli::textView('Try using: '.Cli::btn('mi').Cli::warn('add:route '.$arg1.' '.$arg2.' -O', '1').' | to overwrite file', '1');
            
            Cli::smartBreak(2);  
        }

        return false;

    }

    /**
     * Writes the rex template the generated loader points at.
     *
     * An existing template is kept unless -O is supplied, which is the same enforcer
     * that governs the route class itself.
     *
     * @param string $tmpName dotted template name as written into self::load()
     * @param bool   $live    include the @live directive (--live) or leave it out (--load)
     * @param bool   $overwrite replace a template that is already there (-O)
     * @return bool true when a template was written
     */
    private function addTemplate(string $tmpName, bool $live, bool $overwrite = false) : bool {

        $rexLoc  = to_frontslash(WIN_REX).to_frontslash($tmpName, true).'.rex.php';
        $rexPath = domroot($rexLoc);

        $exists = is_file($rexPath);

        if($exists && !$overwrite){
            Cli::textView(Cli::notice('template').Cli::warn($rexLoc, '1').' already exists | left untouched', '1');
            return false;
        }

        $Filemanager = new Filemanager;

        if(!$Filemanager->openFile(true, $rexPath)){
            Cli::textView(Cli::error('cannot write template', 1).Cli::danger($rexLoc, '1'), '1');
            return false;
        }

        $title = pathinfo($rexPath, PATHINFO_FILENAME);
        $title = substr($title, 0, strlen($title) - 4); // drop the ".rex" left by PATHINFO_FILENAME

        /* @live is the whole difference between the two directives, so it is the only
           line that varies — everything else matches the runtime scaffold. */
        $liveTag = $live ? "\n        @live" : '';

        $template = <<<Template
        <!DOCTYPE html>
        <html lang="en">
            <head>{$liveTag}
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$title</title>
            </head>
            <body>

            </body>
        </html>
        Template;

        file_put_contents($rexPath, $template);

        /* replacing a template discards whatever page was written in it, so the two
           cases are named differently rather than both reading as "created" */
        $action = $exists ? 'overwritten' : 'created successfully';

        Cli::textView('template'.Cli::alert($title, '1')." $action in ".Cli::warn($rexLoc), '1');

        return true;

    }

}