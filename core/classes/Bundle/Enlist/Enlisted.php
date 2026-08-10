<?php 

namespace spoova\mi\core\classes\Bundle\Enlist;

use Closure;
use spoova\mi\core\classes\Ghost\GhostClass;

abstract class Enlisted extends GhostClass {

    /** Returns a Mutable object */
    private function data() : object { return $this->proxy->ghostData(); }

    /** Returns the current file path */
    public function file() : string { return $this->data()->file; }

    /** Returns the list of all iterated files. */
    public function files() : array { return $this->data()->files; }

    /** Returns the total number of iterated files */
    public function count() : int { return $this->data()->count; }

    /** Alias to {@see Enlisted::file()} */
    public function path() : string { return $this->data()->file; }

    /** Name of current file  */
    public function name() : string { return basename($this->file()); }

    /** Returns the new expected path of a given file only when name is accepted */
    public function newFile() : string|false { return $this->data()->newFile; }

    /** Returns the new expected name of a given file only when name is accepted */
    public function newName() : string|false { return basename($this->data()->newFile); }

    /** Returns the expected final name of a renamed file */
    public function presumedFile() : string  { return $this->data()->presumedFile; }

    /** Returns true when the entire renaming process has been completed */
    public function done() : bool { return $this->data()->done; }

    /**
     * Percentage of completion
     *
     * @return integer
     */
    public function status() : int { return $this->data()->status; }

    /** Enables view mode for files before actual renaming process is done */
    public function isView() : bool { return $this->data()->isView; }

    /** Returns TRUE when the renaming process is about to start */
    public function initiated() : bool { return $this->data()->initiated; }

    /** Return the current extension name of the file  */
    public function fileExt() : string { return $this->data()->fileExt; }

    # Three distinct indexes, all zero-based ......................................

    /** Index for each iterated process */
    public function loopIndex() : int { return $this->data()->loopIndex; } 

    /** Returns index for every file allowed to be renamed  */
    public function candidateIndex() : int { return $this->data()->candidateIndex; }
    
    /** Index of files that are renamed. Allows faking when {@see Enlist::view()} is enabled. */
    public function renamedIndex() : int { return $this->data()->renamedIndex; } 

    /** Alias to  {@see Enlisted::candidateIndex()}  */
    public function index() : int { return $this->candidateIndex(); }

    /** Return TRUE when a genuine disk rename occurs. Can never be faked with view mode.  */
    public function isRenamed() : bool { return $this->data()->isRenamed; }

    /** Returns TRUE when a file is selected for modification. Supports view mode.   */
    public function selected() : bool { return $this->data()->isSelected; }

    /** Returns TRUE if a file is renaming averted. */
    public function isAverted() : bool { return (bool) $this->data()->avert; }

    /** Returns TRUE if a file is not renamed due to bad name supplied. */
    public function badName() : bool { return (bool) $this->data()->badName; }

    /** Returns TRUE is a file name remains the same */
    public function identical() : bool { return (bool) $this->data()->identical; }

    /** Alias for {@see Enlisted::identical()} */
    public function isIdentical() : bool { return (bool) $this->data()->identical; }

    /** Returns TRUE is a file destination path already exist */
    public function exists() : bool { return (bool) $this->data()->exists; }

    /** 
     * Used for preventing a file rename process. Files averted will be ignored during renaming process. 
     * To check if a file is averted use the {@see Enlisted::isAverted()} method.
     **/
    public function avert() : void { $this->data()->avert = true; }

    /**
     * Sets a custom filename stem only. 
     *  - Note1: File names should not include dot characters unless cleaning is enabled. 
     *  - Note2: Cleaning will replaces all dot characters with hyphen while removing the last extension name.
     *
     * @param string $name
     * @param boolean $clean forces cleaning of file names through ```cleanFileName()``` method.
     * @return void
     * @uses Enlisted::cleanFileName()
     */
    public function setFileName(string $name, bool $clean = false) : void {
        
        if($clean) $name = $this->cleanFileName($name);

        $valid = trim($name) !== '' && (bool) preg_match('@^[a-zA-Z0-9_\-]+$@', $name);

        $data = $this->data();

        if(!$valid){
            $data->badName = true;
            $data->newFile = ''; // sentinel: invalid custom name
            return;
        }

        $ext = $data->fileExt;

        // resolved stem // auto-dedups: foo, foo1, foo2...
        $data->usedNames[$ext] = $data->usedNames[$ext] ?? [];
        $resolvedStem = $name;
        $suffix = 0;
        while(in_array($resolvedStem, $data->usedNames[$ext], true)){
            $suffix++;
            $resolvedStem = $name.$suffix;
        }
        $data->usedNames[$ext][] = $resolvedStem;
        
        // use resolved stem.
        $dir = dirname($this->file());
        $dir = ($dir === '.') ? '' : $dir.'/';
        $full = $dir.$resolvedStem.($ext !== '' ? '.'.$ext : '');

        $data->badName = false;
        $data->newFile = $full;
    }

    /**
     * Converts internal dots to hyphens while preserving the true trailing extension. Eg: "foo.bar.baz.svg" becomes "foo-bar-baz" 
     * having no extension name. The extension name (if available) is later re-attached as the final file extension name.
     *  - Note: if the stem resolves to empty (e.g. name was just ".svg" or "svg"), the original raw name is kept as-is rather than discarding it.
     * @param string $name
     * @return string
     */
    public function cleanFileName(string $name) : string {
        $stem = pathinfo($name, PATHINFO_FILENAME);
        return ($stem !== '') ? str_replace('.', '-', $stem) : $name;
    }

    /** 
     * Sets an executable callback function after a renaming process is expected to have occured. 
     * The function helps to understand the state of things whether a renaming process failed or is successful.
     * 
     * @param Closure $callback a callback function that is excuted at the end of each iterated activity 
     *  - Closure takes the same Enlisted object as : $callback(Enlisted $file)
     */
    public function after(Closure $callback) : void {
        $this->data()->runAfter = $callback;
    }

}