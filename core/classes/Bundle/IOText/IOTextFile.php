<?php 

namespace spoova\mi\core\classes\Bundle\IOText;

use spoova\mi\core\classes\Ghost\GhostClass;

/**
 * Provides information for a currently streamed file
 */
abstract class IOTextFile extends GhostClass {

    private function data() : object { return $this->proxy->ghostData(); }

    /**
     * File path for streamed text file
     *
     * @return string
     */
    public function file() : string { return $this->data()->path; }

    /**
     * Full data stored in file
     *
     * @return string
     */
    public function text() : string { return $this->data()->contents; }

    /**
     * Each pulled line stored in an array list
     *
     * @return array
     */
    public function lines() : array { return $this->data()->lines; }

    /**
     * Total number of lines in text file
     *
     * @return integer
     */
    public function lineCount() : int { return count($this->data()->lines); }

    /**
     * Returns true if a file has been modified
     *
     * @return boolean
     */
    public function isModified() : bool { return $this->data()->modified; }

    /**
     * Returns the time at which a file was modified
     */
    public function modifiedAt() : int { return $this->data()->mtime; }

    /**
     * Returns the number of times a change has been detected
     *
     * @return integer
     */
    public function tick() : int { return $this->data()->tick; }

    /**
     * Checks whether the streamed file exists.
     *
     * @return boolean
     */
    public function exists() : bool { return $this->data()->exists; }

    /**
     * 1-based line access, matching how people naturally refer to line numbers
     *
     * @param integer $line
     * @return string
     */
    public function textFromLine(int $line) : string {
        $lines = $this->lines();
        return $lines[$line - 1] ?? '';
    }

    /**
     * Ends the watch loop
     *
     * @return void
     */
    public function stop() : void {
        $this->data()->stopped = true;
    }
}