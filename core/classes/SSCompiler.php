<?php

namespace spoova\mi\core\classes;

use Exception;
use spoova\mi\core\classes\Bundle\Filemanager\Filemanager;

class SSCompiler {
    protected string $cacheFile;
    protected string $packageName;
    protected string $sourcePath;
    protected string $sourceContent;
    protected array $packageInfo = [];
    protected string $packageID;
    protected array $cache = [];
    private $modulesDir = 'res/assets/js';

    /** Generate SPAuto Module */
    private bool $use_module = false;

    /**
     * Set path where .ssmodule file is stored.
     *
     * @param string $modulesDir path for .ssmodules
     */
    public function __construct($modulesDir = 'res/assets/js') {
        $this->modulesDir = $modulesDir;
        $this->cacheFile = domroot($modulesDir.'/'.'.ssmodules'); // relative to modules directory
        $this->loadCache();
    }

    /**
     * Return ssmodule data from cacheFile
     *
     * @return array|false
     */
    public function ssmodule() : array|false {
        if (file_exists($this->cacheFile)) {
            return json_decode(file_get_contents($this->cacheFile), true) ?? [];
        }
        return false;
    }

    /**
     * Fetch .ssmodule cache file path
     *
     * @return string|null NULL if no cache file path is defined.
     */
    public function getCacheFile() : ?string {
        return isset($this->cacheFile)? $this->cacheFile : null;
    }

    protected function loadCache() {
        if (file_exists($this->cacheFile)) {
            $this->cache = json_decode(file_get_contents($this->cacheFile), true) ?? [];
        }
    }

    /** Save cache into .ssmodules */
    protected function saveCache() {
        $Filemanager = new Filemanager;
        if($Filemanager->addDir(dirname($this->cacheFile))){
            file_put_contents($this->cacheFile, json_encode($this->cache, JSON_PRETTY_PRINT));
        }
    }

    /**
     * Fetch a file from specified source path or URL
     *
     * @param string $sourcePath
     * @return string
     */
    public function fetchContent(string $sourcePath) {
        $this->sourcePath = $sourcePath;
        $this->sourceContent = '';
        if (filter_var($sourcePath, FILTER_VALIDATE_URL)) {
            // Remote fetch (e.g. jsDelivr)
            $content = @file_get_contents($sourcePath);
            if ($content === false) {
                throw new Exception("Failed to download source from {$sourcePath}");
            }
            return $content;
        } elseif (file_exists($sourcePath)) {
            // Local file
            return $this->sourceContent = file_get_contents($sourcePath);
        } else {
            throw new Exception("Module source path not found: {$sourcePath}");
        }
    }
    
    /** Generate module package id using path defined */
    public static function generateId(string $path, int $length = 7) {
        
        // Normalize the path or URL to ensure consistency
        $path = dompath($path, 'app');
        $normalized = strtolower(trim($path));
        $normalized = str_replace('\\', '/', $normalized); // unify separators
        $normalized = preg_replace('#/+#', '/', $normalized); // remove duplicate slashes

        // Create a strong hash from the normalized string
        $hash = sha1($normalized, true); // binary output

        // Convert binary hash to Base62
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = gmp_import($hash); // turn binary into big integer
        $encoded = '';
        while ($num > 0) {
            $encoded = $chars[gmp_intval(gmp_mod($num, 62))] . $encoded;
            $num = gmp_div_q($num, 62);
        }

        // Ensure the result always has at least $length characters
        if (strlen($encoded) < $length) {
            $encoded = str_pad($encoded, $length, '0', STR_PAD_LEFT);
        }

        return substr($encoded, 0, $length);
    }

    /**
     * Generate module raw JSON data from module content
     *
     * @param string $source original code from which module content is generated.
     * @param string|null $packageName custom package name must be a unique name if defined.
     *  - Note that if not defined, packageName will be extracted from class name of source code.
     * @throws Exception if source path is missing or the package name cannot be detected
     * @return array with keys : sourcePath, packageName, packageID, hashString
     */
    public function generateData(string $source, ?string $packageName = null) : array {
        
        if(!isset($this->sourcePath)){
            throw new Exception('undefined module path cannot generate data.');
        } 
            
        if(!is_file($this->sourcePath)){
            throw new Exception('missing module cannot generate data.');
        }
        $sourcePath = $this->sourcePath;

        $packageID = $packageName; $hashString = '';

        if (!$packageName) {
            if (preg_match('/^\s*(?:export\s+)?(?:default\s+)?class\s+([A-Za-z_][A-Za-z0-9_]*)/m', $source, $m)) {
                $packageName = $m[1];
                $hashString = self::generateId($sourcePath);
                $packageID = $packageName.'.'.$hashString;
            } else {
                throw new Exception("Unable to auto-detect package name.");
            }
        }

        $this->packageID = $packageID;

        return [
            'sourcePath' => $sourcePath,
            'packageName' => $packageName,
            'packageID' => $packageID,
            'hashString' => $hashString,
        ];
    }

    /**
     * Convert source content to module format
     *
     * @param string|false $code
     * @param string $sourcePath relative source path
     * @param string $packageName package name
     * @return string
     */
    public function modularize(string|false $code, $sourcePath, string $packageName) : string {
        if($code === false) return '';
        $modulesDir = to_frontslash(dompath($sourcePath, 'app'));

        $pathRef = explode('/', rtrim($modulesDir,'/'));
        $pathRef = str_repeat('../', count($pathRef));

        $compiled = <<<JS
        import { SPAuto } from "{$pathRef}res/main/js/local/autoload/SPAuto.js";

        {$code}

        export default SPAuto({$packageName});
        JS;
        return $compiled;
    }

    /**
     * Enable module generation during .ssmodule compilation
     *
     * @param boolean|null $use 
     * @return void
     */
    public function use_module(bool $use = true) : void {
        $this->use_module = $use;
    }

    /**
     * Compile a module from a source string
     *
     * @param string|null $packageName package name for remote files 
     * @param string|null $version
     * @return array
     */
    public function compile(?string $packageName = null, ?string $version = null) : array {

        // Auto-detect package name from class if not provided
        $sourcePath = $this->sourcePath; // auto-detect source path
        $sourceData = $this->sourceContent; // auto-detect source content

        $generatedData = $this->generateData($sourceData, $packageName);
        $sourcePath = $generatedData['sourcePath'];
        $packageID = $generatedData['packageID'];
        $packageName = $generatedData['packageName'];
        $hashString = $generatedData['hashString'];
        
        // If version not provided, assume "latest"
        $version = $version ?: 'latest';
        $useModule = $this->use_module;

        // Check cache to see if we already have this version
        if (isset($this->cache[$packageID]) && $this->cache[$packageID]['version'] === $version) {
            $cache = $this->cache;
            $modulePath = $cache['module'] ?? '';
            if(is_file(domroot($modulePath))){
                return $this->cache; // Skip rebuild
            }
        }
        
        $outputDir = dompath(dirname($sourcePath), 'app');
        $moduleName = pathinfo($sourcePath, PATHINFO_FILENAME);

        $Filemanager = new Filemanager;

        if(!$Filemanager->addDir($outputDir)){
            throw new Exception('cannot create base directory for modules package.');
        }

        /** Directory path for all packages relative to project root*/
        if($useModule){
            $modules_dir = $outputDir? dompath($outputDir) : dompath(dirname($this->sourcePath), 'app');
            $compiled = $this->modularize($sourceData, $modules_dir, $packageName);
            $outFile = to_frontslash("{$outputDir}/{$moduleName}.ss.js");
            file_put_contents($outFile, $compiled);
        }
            
        $this->cache[$packageID] = [
            'version' => $version,
            'source' => to_backslash(dompath($sourcePath, 'app')),
            'module' => to_backslash(isset($outFile)? dompath($outFile, 'app') : ($outFile??'')),
            'compiled_at' => date('c'),
            'name' => $packageName,
            'id' => $hashString,
        ];
            
        $this->saveCache();

        $this->packageInfo['name'] = $packageName;
        $this->packageInfo['id'] = $packageID;
        $this->packageInfo['hash'] = $hashString;

        return $this->cache;

    }
    
    public function packageID(): ?string {
        return $this->packageID ?? null;
    }
    public function packageInfo($info = null): string|array|null {
        if(func_num_args() > 0){
            return $this->packageInfo[$info] ?? null;
        }
        return $this->packageInfo;
    }
}