<?php 

namespace spoova\mi\core\classes\Bundle\IOText;

use spoova\mi\core\classes\Ghost\GhostClass;

abstract class IOTextRead extends GhostClass {
    private function data() : object { return $this->proxy->ghostData(); }

    public function file() : string        { return $this->data()->path; }
    public function text() : string        { return $this->data()->contents; }
    public function lines() : array        { return $this->data()->lines; }
    public function lineCount() : int      { return count($this->data()->lines); }
    public function isModified() : bool    { return $this->data()->modified; }
    public function modifiedAt() : int     { return $this->data()->mtime; }
    public function tick() : int           { return $this->data()->tick; }
    public function exists() : bool        { return $this->data()->exists; }

    // 1-based line access, matching how people naturally refer to line numbers
    public function textFromLine(int $line) : string {
        $lines = $this->lines();
        return $lines[$line - 1] ?? '';
    }

    public function stop() : void {
        $this->data()->stopped = true;
    }
}