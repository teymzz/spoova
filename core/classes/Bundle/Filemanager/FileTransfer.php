<?php 

namespace spoova\mi\core\classes\Bundle\Filemanager;

use spoova\mi\core\classes\Ghost\GhostClass;

abstract class FileTransfer extends GhostClass {

    /**
     * Enables or disables overwriting existing file
     *
     * @param boolean $overwrite TRUE enables while FALSE disables
     * @return array
     */
    public function overwrite(bool $overwrite) : array  { return $this->proxy->overwrite($overwrite); }    

    /**
     * Full path of the item currently being processed
     *
     * @return string
     */
    public function file() : string       { return $this->proxy->file(); }

    /**
     * Returns TRUE if the current item's transfer succeeded
     *
     * @return boolean
     */
    public function success() : bool  { return $this->proxy->success(); }

    /**
     * Returns TRUE if the current item's transfer failed
     *
     * @return boolean
     */
    public function failed() : bool   { return !$this->proxy->success(); }

    /**
     * Response message returned as 'success' or 'failed'
     *
     * @return string
     */
    public function status() : string { return $this->success() ? 'success' : 'failed'; }

    /**
     * Number of items processed so far, across the whole operation
     *
     * @return integer
     */
    public function processed() : int { return $this->proxy->processed(); }

    /**
     * Total number of files to be processed
     *
     * @return integer
     */
    public function total() : int { return $this->proxy->total(); }

    /**
     * Running count or list of items successfully transferred so far
     *
     * @param string $type Optional [all|count] 
     *   - all: returns an array of all resolved items
     *   - count: returns a total count of resolved items
     * @return integer|array
     */
    public function resolved(string $type = 'all') : int|array  { return $this->proxy->resolved($type); }

    /**
     * Running count or lists of items NOT transferred so far
     *
     * @param string $type Optional [all|count] 
     *   - all: returns an array of all unresolved items
     *   - count: returns a total count of unresolved items
     * @return integer|array
     */    
    public function unresolved(string $type) : int|array  { return $this->proxy->unresolved($type); }
    
    /**
     * All Errors compiled so far
     *
     * @return array
     */
    public function errors() : array  { return $this->proxy->errors(); }

    /**
     * Currently obtained error if any
     *
     * @return string|null
     */
    public function error() : string|null  { return $this->proxy->error(); }


    public function is_dir() : bool  { return is_dir($this->file()); }
    public function is_file() : bool { return is_file($this->file()); }
    public function type() : string  { return $this->is_dir() ? 'directory' : 'file'; }
}