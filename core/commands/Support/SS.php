<?php

/**
 * @author Akinola Saheed <akinolasaheed001@gmail.com> .
 * 
 * This class is for development process. 
 * Warning: The usage of this class will alter installation files. 
 * This may cause app to break or lead to other undesired errors.
 */
namespace spoova\mi\core\commands\Support;

use Exception;
use spoova\mi\core\classes\Bundle\Filemanager\FileCompressor;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;
use spoova\mi\core\classes\SSCompiler;
use spoova\mi\core\commands\Root\Cli;
use spoova\mi\core\commands\Root\Cli\CliPulser;
use spoova\mi\core\commands\Root\Cli\CliPulser\CliWords;
use spoova\mi\core\commands\Root\Entry;

class SS extends Entry{

    public $old_dump_path = '';

    function __construct($args = []) {

        // format: compile "&assets:js.selector.selector"
        // format: import "&assets.js:selector@latest" --module
        // php mi ss compile "&assets:js.selector.selector"

        if(!$args){
            Cli::headerView('ss module', break: 2);
            Cli::errorView('no command declared', break: '|2');
            return ;
        }

        $commands = ['import','update','compile'];
        $command = $args[0];

        if(!in_array($command, $commands)) {
            Cli::headerView('ss module', break: 2);
            Cli::errorView('"'.Cli::warn($command).'" command not recognized', break: '|2');
            return ;
        }

        unset($args[0]); $args = array_values($args);

        Cli::runAnime([[$this, $command], $args]);

    }

    private static function get_release(string $repo): array|false {
        $gitUrl = "https://api.github.com/repos/{$repo}/releases";
        $options = [
            "http" => [
                "header" => "User-Agent: PHP\r\n"
            ]
        ];

        if(!isOnline()){
            Cli::clearLine();
            Cli::textView(Cli::error('no internet connection active.'), break: '|1');
            Cli::textView(Cli::error('module compilation aborted.'), break: '|1');
            return false;
        }

        Cli::clearLine()->pulseView('Checking release...', 0)->pulseToggle(3, 3);
        $context = stream_context_create($options);
        $response = @file_get_contents($gitUrl, false, $context);

        $releases = json_decode($response, true);

        if (!$releases) { die("No releases found."); }
        return $releases;
    }

    /**
     * import file from source URL
     *
     * @param array $args
     * @param bool $incoming determines when a command is initiated internally
     * @return void
     */
    public function import($args = [], bool $incoming = false) {

        // syntax: import "&assets.js:Interval@latest" --module

        if(!$incoming) Cli::headerView('ss module import', break: 2);

        yield from Cli::yield();
        
        if(!$args){
            Cli::errorView('no access path supplied.', break: '|2');
            Cli::infoView(' Syntax ','import '.Cli::warn('"path::repo@version"').' --module?', break: '|1');
            yield false;
        }

        if(count($args) > 2){
            Cli::errorView('invalid arguments count supplied', break: '|1');
            yield false;
        }

        $access_path = $args[0]; // file remote URL
        $flag = $args[1] ?? ''; // module flag

        // reformat access path defined 
        $pathway = preg_replace_callback('/^&(\w+)::/', fn ($m) =>'res/'.$m[1].'/js::', $access_path);
        $pathdiv = explode('::',$pathway, 2); // path division 
       
        if(count($pathdiv) < 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'access path "'.Cli::warn($access_path).'" invalid.', break:'|1');
            yield false;
        }

        $relativePath = $pathdiv[0]; // access directory
        $repositLabel = $pathdiv[1]; // repository label

        $repositLabels = explode('@', $repositLabel, 2);
        
        $repository = $repositLabels[0];
        $version = $repositLabels[1] ?? 'latest';
        $repos = explode('/', $repository, 2);

        /** relative path + repository */
        $localPath = $relativePath.'/'.$repository;

        if(count($repos) !== 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'repository path "'.Cli::warn($repository).'" invalid.', break:'|1');
            yield false;
        }        

        if($flag && !in_array($flag, ['--module'])){
          Cli::errorView('unknown flag "'.Cli::warn($flag).'" supplied ', break: '|1');
          yield false;   
        }
        
        if(!$incoming) Cli::pulseView('Initializing command...', 0)->pulseToggle(3, 3);
        
        $packageName = $repos[1];
        $releases = self::get_release($repository);
        if($releases === false){
            yield false;
        }
        $released = [];

        foreach($releases as $release){
            $released[$release['tag_name']] = $release['zipball_url'];
        }

        if($version === 'latest') $version = array_keys($released)[count($released)-1] ?? null;
        
        if(!array_key_exists($version, $released)){
            Cli::clearLine();
            Cli::errorView('invalid module version', break: '|1');
            yield false;
        }

        $remoteURL = "github.com/{$repository}/zip/refs/tags/{$version}";
        $url = "https://codeload.$remoteURL";

        $dump_path = to_frontslash(domroot($relativePath.'/'.$repository));
        
        $keyword = ($flag === '--module')? 'module' : 'package';

        // Initialize File manager
        $Filemanager = new Filemanager;

        $baseName = basename($dump_path);

        if(strpos($baseName, '.') !== false){

            Cli::warning('The dump path contains a dot character. All dots in the dump path are replaced with dashes to prevent errors during module import process.');
            Cli::break(2);
            $this->old_dump_path = $dump_path;
            $dump_path = str_replace('.', '-', $dump_path);
        }

        if($Filemanager->addDir($dump_path)){

            // proceed with package download
            $zipFile = $dump_path.".zip";
            Cli::clearLine()->pulseView('Downloading release...', 0)->pulseToggle(3, 3);
            file_put_contents($zipFile, file_get_contents($url));

            if(is_file($zipFile)){

                Cli::clearLine()->pulseView('Decompressing files...', 0)->pulseToggle(3, 3);

                $Filemanager->setUrl($zipFile);
                $Filemanager->zipProgress(function(FileCompressor $info){
                    $status = $info->status.'%';
                    if($info->status === 0) Cli::clearLine();
                    Cli::moveStart()->pulseView('Decompressing files ['.$status.']', 0);
                    Cli::wait(1000);
                });
                
                $Filemanager->unzip(true, to: $dump_path, dirs: true);
                if($Filemanager->unzipped()){
                
                    /* source() rather than setUrl(): setUrl() with a single argument only
                       records the path for zip operations, while getFolders() reads the
                       source url. Listing after setUrl() therefore returned nothing, and a
                       release that had unzipped correctly was reported as holding no
                       content. source() is what points the listing at the directory. */
                    $Filemanager->source($dump_path);
                    $folders = $Filemanager->getFolders();
                    
                    $foldersCount = count($folders);

                    if($foldersCount === 1){
                        $basePath = to_frontslash($Filemanager->zipDir('unzipped'));
                        $extractedFolder = to_frontslash($folders[0]);
                        $extensionName = pathinfo($packageName, PATHINFO_EXTENSION) ? '' : '.js';
                        $newFile = $dump_path.'/'.$packageName.$extensionName;
                        
                        // moveContentsTo() reads the same source url through getContents()
                        $Filemanager->source($extractedFolder);
                        $Filemanager->moveContentsTo($dump_path);
                        $Filemanager->deleteFile($extractedFolder); // delete after moving contents.
                        Cli::clearLine()->successView('package imported successfully to: '.$dump_path);
                    }else if($foldersCount > 1){
                        Cli::clearLine()->successView('package imported', break: '|2');
                        Cli::clearLine()->infoView('Notice', 'multiple directories in package cannot be resolved.', color: 'yellow');
                    }else{
                        Cli::clearLine()->errorView('no content discovered in package', 'Message: ');
                    }

                }else{
                    Cli::clearLine()->errorView($Filemanager->zipError(), break: '|1');
                    yield false;
                }
            }else{
                Cli::clearLine()->errorView('Package missing', break: 2);
                Cli::clearLine()->infoView('Help', 'Please run command again or check if release is accessible.', break: 1);
                yield false;
            }
            
        }else{
            Cli::clearLine()->errorView('cannot generate module\'s directory: "'.Cli::warn($dump_path).'"', break: 1);
            yield false;
        }


        if(!isset($newFile)){
            Cli::break(1);
            yield false; // prevent further processing
            return false;
        } 
    
        Cli::pause(2)->clearLine();

        if(($flag === '--module') && pathinfo($newFile, PATHINFO_EXTENSION) !== 'js'){
            Cli::errorView('missing module ".js" extension.', break: '|1');
            yield false;
        }
        
        try{

            $ss = new SSCompiler(); // using default modules path
            Cli::clearLine()->pulseView('Fetching module content : '.$newFile, 0)->pulseToggle(3, 3);

            Cli::pause(3)->clearLine();
            $content = $ss->fetchContent($newFile);

            if(!$content){
                Cli::clearLine()->errorView('No content from root package to compile.', break: '|1');
                yield false;
            }

            Cli::clearLine()->pulseView('Compiling '.$keyword.' ...', 0)->pulseToggle(3, 3);

            $ss->use_module($keyword === 'module');
            if($outfile = $ss->compile(version: $version)){       
                // Cli::textPlain(Cli::warn($ss->packageID())); Cli::pause(8);
                $packageID = $ss->packageID();
                Cli::clearLine()->pulseView('Success: '.$keyword.' compiled with '.$packageID.'', 10000, eachChar: function(CliPulser $pulse) use($packageID){
                    return $pulse->words(['Success:',$packageID], function($char, CliWords $mod) {
                       return ($mod->word('Success:'))? Cli::valid($char) : Cli::underline(Cli::warn($char));
                    });
                });
                Cli::break(1);
                yield true;
            }
            
        }catch(Exception $e){
            Cli::errorView('cannot fetch module.', break: 1);
            Cli::errorView('module import failed.', break: 1);
            yield false;
        }

        // $ss->compile('https://cdn.jsdelivr.net/gh/teymzz/Interval@v1.0/Interval.js', null);


    }

    /**
     * Update module or package
     *
     * @param array $args
     * @return void
     */
    public function update($args = []) {

        Cli::headerView('ss module update', break: '2');
        yield from Cli::yield();

        if(!$args){
            Cli::errorView('no access path supplied.', break: '|2');
            Cli::infoView(' Syntax ','import '.Cli::warn('"path::repo@version"').' --module?', break: 1);
            yield false;
        }

        if(count($args) > 2){
            Cli::errorView('invalid arguments count supplied', break: 1);
            yield false;
        }

        $access_path = $args[0]; // file remote URL
        $flag = $args[1] ?? ''; // module flag

        // reformat access path defined 
        $pathway = preg_replace_callback('/^&(\w+)::/', fn ($m) =>'res/'.$m[1].'/js::', $access_path);
        $pathdiv = explode('::',$pathway, 2); // path division 
       
        if(count($pathdiv) < 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'access path "'.Cli::warn($access_path).'" invalid.', break:'|1');
            yield false;
        }

        $relativePatho = $pathdiv[0]; // access directory
        $relativePath = str_replace('.','-',$relativePatho); // access directory
        $repositLabel = $pathdiv[1]; // repository label

        $repositLabels = explode('@', $repositLabel, 2);
        
        $repository = $repositLabels[0];
        $version = $repositLabels[1] ?? 'latest';
        $repos = explode('/', $repository, 2);

        /** relative path + repository */
        $localPatho = $relativePath.'/'.$repository;
        $localPath = $relativePath.'/'.$repository;

        if(count($repos) !== 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'repository path "'.Cli::warn($repository).'" invalid.', break: '|1');
            yield false;
        }        

        if($flag && !in_array($flag, ['--module'])){
          Cli::errorView('unknown flag "'.Cli::warn($flag).'" supplied ', break: '|1');
          yield false;   
        }
        
        Cli::clearLine()->pulseView('Initializing command...', 0)->pulseToggle(3, 3);

        $expectedPackage = to_frontslash(domroot($localPatho).'/'.basename($localPath).'.js');
        $id = SSCompiler::generateId($expectedPackage);
        $repoName = $repos[1];
        $ssmID = $repoName.'.'.$id;

        $ssmodules = (new SSCompiler())->ssmodule();

        if(!isset($ssmodules[$ssmID])){
            Cli::clearLine()->errorView('cannot detect package id "'.$ssmID.'" from .ssmodules', break: '|1');
            yield false;
        }

        $ssmodules = $ssmodules[$ssmID];

        $releases = self::get_release($repository);
        if($releases === false) yield false;
        $released = [];

        foreach($releases as $release){
            $released[$release['tag_name']] = $release['zipball_url'];
        }

        if($version === 'latest') $version = array_keys($released)[count($released)-1] ?? null;

        $ssVersion = $ssmodules['version'];
        
        if(!array_key_exists($version, $released)){
            Cli::clearLine();
            Cli::errorView('unknown module version '.Cli::warn($version), break: '|1');
            yield false;
        }

        if($ssVersion === $version){
            Cli::clearLine();
            Cli::errorView('version '.Cli::warn($version).' is already the current version.', 'Info: ', break: '|2');
            Cli::textView('Redownload current version? [Y/N] ');

            $options = ['y','n'];
            $response = Cli::prompt($options);

            if(!$response->matches($options)){
                Cli::clearUp(3)->errorView('process aborted due to invalid response. ', break: '|1');
                yield false;
            }
            if($response->matches('n')){
                Cli::clearUp(3)->infoView('Info', 'process aborted successfully.', color: '|red', break: '|1');
                yield false;
            }
        }

        Cli::clearUp(3)->pulseView('Updating package...', 0)->pulseToggle(3, 3);

        //build download format;
        Cli::clearLine();

        yield from $this->import($args, true);

        Cli::break(1);

        yield false;

        exit;
        $remoteURL = "github.com/{$repository}/zip/refs/tags/{$version}";
        $url = "https://codeload.$remoteURL";

        $dump_path = to_frontslash(domroot($relativePath.'/'.$repository));
        
        $keyword = ($flag === '--module')? 'module' : 'package';


        
        
    }

    /**
     * Handles compile command for compiling module from package
     *
     * @param array $args
     * @return void
     */
    public function compile($args = []) {

        Cli::headerView('ss module compile', break: '2');
        yield from Cli::yield();
        
        if(!$args){
            Cli::errorView('no access path supplied.', break: '|2');
            Cli::infoView(' Syntax ','compile '.Cli::warn('"path::repo@version"').' --module?', break: 1);
            yield false;
        }

        if(count($args) > 2){
            Cli::errorView('invalid arguments count supplied', break: 1);
            yield false;
        }

        $access_path = $args[0]; // file remote URL
        $flag = $args[1] ?? ''; // module flag

        // reformat access path defined 
        $pathway = preg_replace_callback('/^&(\w+)::/', fn ($m) =>'res/'.$m[1].'/js::', $access_path);
        $pathdiv = explode('::',$pathway, 2); // path division
        $sourceFile = str_replace('::','/', to_frontslash($pathway));

        /* checked here rather than further down: an access path carrying no "::" leaves
           $pathdiv[1] undefined, and the code below passes it straight to to_frontslash(),
           which ends the command on a fatal type error instead of the message meant for it */
        if(count($pathdiv) < 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'access path "'.Cli::warn($access_path).'" invalid.', break:'|1');
            yield false;
            return;
        }

        $relativePath = $pathdiv[0]; // access directory
        $repositLabel = $pathdiv[1]; // repository label

        $repository = explode('/', to_frontslash($repositLabel), 3);
        $repository = ($repository[0]?? '').'/'.($repository[1]?? '');
        $repos = explode('/', $repository, 2);

        /** relative path + repository */
        $localPath = $relativePath.'/'.$repository;

        if(count($repos) !== 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'local repo path "'.Cli::warn($repository).'" invalid.', break: '|1');
            yield false;
        }   
       
        Cli::clearLine()->pulseView('Initializing command...', 0)->pulseToggle(3, 3, 50000);

        if(!is_file($sourceFile)){
            Cli::clearLine();
            Cli::errorView('no module source package found.', break: '|1');
            yield false;
        }

        
        // Begin compilation process 
        Cli::clearLine()->pulseView('Initializing command...', 0)->pulseToggle(3, 3, 100000);
        Cli::clearLine()->pulseView('Compiling package...', 0)->pulseToggle(3, 5, 100000);

        $sourceFilePath = domroot($sourceFile);
        $outputFilePath = dirname($sourceFilePath).'/'.pathinfo($sourceFile, PATHINFO_FILENAME).'.ss.js';
        $outputFilePath = to_frontslash($outputFilePath);

        if(is_file($outputFilePath)){
            Cli::clearLine();
            Cli::infoView('Notice','module already exists', color: '|yellow', break: '|2');
            if(is_file($sourceFilePath)){
                Cli::textView('Recompile module? [Y/N] ');
                $options = ['y','n'];
                $response = Cli::prompt($options, terminate: true);
                if($response === 'n'){
                    Cli::clearUp(3);
                    Cli::textView('Process aborted successfully.', break: '|1');
                    yield false;
                }
                if($response !== 'y'){
                    Cli::clearUp(3);
                    Cli::textView('Process terminated due to invalid response.', break: '|1');
                    yield false;
                }

                Cli::clearUp(3);
            }else{
                yield false;
            }
        }

        try{

            $packageID = SSCompiler::generateId($sourceFilePath);

            $sscompiler = new SSCompiler();
            $ssmodule = $sscompiler->ssmodule();
            $content = $sscompiler->fetchContent($sourceFilePath);
            $moduleData = $sscompiler->generateData(file_get_contents($sourceFilePath));
            $packageID = $moduleData['packageID'] ?? '';
            $packageName = $moduleData['packageName'] ?? '';

            $ssmod = $ssmodule[$packageID] ?? '';
            $version = $ssmod['version']  ?? false;

            if(!$version){ $version = 'unknown'; }
            
            $sscontent = $sscompiler->modularize($content, $sourceFilePath, $packageName);            

            if(!$content){
                Cli::clearLine()->errorView('No content discovered', break: '|1');
                yield false;
            }

            $sscompiler->use_module(true);
            Cli::clearLine()->pulseView('Proceeding with compilation...', 0)->pulseToggle(3, 5, 100000);
            if($outfile = $sscompiler->compile(version: $version)){
                Cli::clearLine()->pulseView('Almost done...', 0)->pulseToggle(3, 5, 100000);
                $packageID = $sscompiler->packageID();
                Cli::clearLine()->pulseView('Success: module compiled with ('.$packageID.') and version '.$version, 0, eachChar: function(CliPulser $pulse) use($packageID){
                    return $pulse->words(['Success:',$packageID], function($char, $index, $word) {
                        return $word === 'Success:'? Cli::valid($char) : Cli::warn($char);
                    });
                });
                Cli::break(1);
                yield true;
            }
            
        }catch(Exception $e){
            Cli::errorView('cannot fetch module.', break: 1);
            Cli::errorView('module import failed.', break: 1);
            yield false;
        }


        $relativePath = $pathdiv[0]; // access directory
        $repositLabel = $pathdiv[1]; // repository label

        $repositLabels = explode('@', $repositLabel, 2);
        
        $repository = $repositLabels[0];
        $version = $repositLabels[1] ?? 'latest';
        $repos = explode('/', $repository, 2);

        /** relative path + repository */
        $localPath = $relativePath.'/'.$repository;

        if(count($repos) !== 2){
            Cli::errorView('process terminated.', break: '|2');
            Cli::infoView(' Hint ', 'repository path "'.Cli::warn($repository).'" invalid.', break: '|1');
            yield false;
        }        

        if($flag && !in_array($flag, ['--module'])){
          Cli::errorView('unknown flag "'.Cli::warn($flag).'" supplied ', break: '|1');
          yield false;   
        }
        
        Cli::clearLine()->pulseView('Initializing command...', 0)->pulseToggle(3, 3);


    }
    /* public function compile($args = []) {
       
       Cli::headerView('ss module compile', break: 2);
       
       // format: ss compile "&main.js.Interval"
       // format: ss compile "res.main.js.Interval"
       $argsCount = count($args);
       if($argsCount !== 1) {
         Cli::errorView('invalid number of arguments counts supplied.', break: '|1');
         yield false;
       }
       
       // resolve arguments path 
       $path = $args[0];
       $pattern = '/^(?:&(main|assets):)?[A-Za-z_][\w]*(?:\.[A-Za-z_][\w]*)*$/';
       if(!preg_match($pattern, $path)){
         Cli::errorView('invalid path structure supplied.', break: '|1');
         yield false;
       }
       
       $path = preg_replace_callback('/^&(main|assets):/', function ($m) {
          return $m[1] === 'main' ? 'res/main/' : 'res/assets/';
         },
         $path
       );

       Cli::pulseView('Checking module source...')->pulseToggle(3, 3);
       $modulePath = domroot(to_frontslash($path, true)).'.ss.js';
       $path = domroot(to_frontslash($path, true)).'.js';
       if(!is_file($path)){
         Cli::clearLine()->errorView('module source file is missing from', break: '|1');
         Cli::clearLine()->errorView(Cli::bgwarn(dompath($path, 'app')), break: '|1', title: ' Path: ');
         if(is_file($modulePath)){
            Cli::clearLine()->textView(Cli::bgAlert(' Info ').': relative module file exists.')->break(1);
         }
         yield false;
       }

    //    Cli::exit($path);

       if(is_file($modulePath)){
         $message = 'Overwrite existing module? [Y/N] ';
         $options = ['y','n'];
         Cli::clearLine()->textView($message);
         $response = strtolower(Cli::prompt($options, terminate: true)?:'');
         if(!in_array($response, $options)){
            Cli::break();
            Cli::clearLine()->textView(Cli::bgDanger(' Error ').': invalid response recieved.')->break(1);
            yield false;
         }
         if($response === 'n'){
            Cli::break();
            Cli::clearLine()->textView(Cli::bgDanger(' Info ').': module compilation terminated.')->break(1);
            yield false;
         }
         if($response === 'y'){
            // check for .ssmodule
            $keyword = 'Recompiling';
            $sscompiler = new SSCompiler;
            $ssmodule = $sscompiler->ssmodule();
            $packageID = null;

            try{
                $sscompiler->fetchContent($path); // set path or throw error
                $sourceContent = file_get_contents($path);
                $moduleData = $sscompiler->generateData($sourceContent);
                $packageID = $moduleData['packageID'] ?? '';
                $packageName = $moduleData['packageName'] ?? '';
            }catch(Exception $e){ 
                Cli::errorExit(lcfirst($e->getMessage()), title: 'Error: ', break: '|2');
             } 
            
            if($ssmodule){

                // fetch module id 
                $modData =  $ssmodule[$packageID] ?? [];

                $modPath = $modData['module'] ?? null;

                if(isset($modPath)){
                    $modPath = domroot($modPath);
                    if(is_file($modPath)){
                        $pathContent = $sourceContent ?? file_get_contents($path);
                        $modContent = file_get_contents($modPath);
                        if($modContent && $sscompiler->modularize($pathContent, $modPath, $packageName) !== $modContent){
                            $message = 'Update existing module? [Y/N] ';
                            $options = ['y','n'];
                            Cli::clearUp(1)->textView($message);
                            $response = strtolower(Cli::prompt($options, terminate: true)?:'');
                            if(!in_array($response, $options)){
                                Cli::break();
                                Cli::clearLine()->textView(Cli::bgDanger(' Error ').': invalid response recieved.')->break(1);
                                yield false;
                            }
                            if($response === 'n'){
                                Cli::break();
                                Cli::clearLine()->textView(Cli::bgDanger(' Info ').': module compilation terminated.')->break(1);
                                yield false;
                            }
                            $keyword = 'Updating';
                        }
                        if(!$modContent) $keyword = 'Compiling';
                    }
                }
            }

            Cli::clearUp(1)->pulseView("$keyword module...", 0)->pulseToggle(3, 3);
         }
       }

       // start compilation .......................................................
       try{
            // compile 
            $ss = new SSCompiler();
            $content = $ss->fetchContent($path);


            if(!$content){
                Cli::clearLine()->errorView('No content discovered', break: '|1');
                yield false;
            }

            if(!isset($keyword)) Cli::clearLine()->pulseView('Compiling module ...', 0)->pulseToggle(3, 3);

            if($outfile = $ss->compile($content)){
                // $packageID = $sscompiler->packageInfo('packageID');
                $packageID = $sscompiler->packageID();
                Cli::clearLine()->pulseView('Success: module compiled with ('.$packageID.')', 0, eachChar: function(CliPulser $pulse) use($packageID){
                    return $pulse->words(['Success:',$packageID], function($char, $index, $word) {
                        return $word === 'Success:'? Cli::valid($char) : Cli::warn($char);
                    });
                });
                Cli::break(1);
                yield true;
            }
            
        }catch(Exception $e){
            Cli::errorView('cannot fetch module.', break: 1);
            Cli::errorView('module import failed.', break: 1);
            yield false;
        }
       
        Cli::break();
    } */

}