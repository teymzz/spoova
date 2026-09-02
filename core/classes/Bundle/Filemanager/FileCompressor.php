<?php 

namespace spoova\mi\core\classes\Bundle\Filemanager;

use Override;
use spoova\mi\core\classes\Ghost\GhostClass;
use ZipArchive;

abstract class FileCompressor extends GhostClass {

    /**
     * Index of the current file compressed
     *
     * @var integer
     */
    public int $index;

    /**
     * Total number of files counted
     *
     * @var integer
     */
    public int $count;

    /**
     * Status in percentage of file compressed
     *
     * @var integer
     */
    public int $status;

    /**
     * Instance of the current ZipArchive
     *
     * @var ZipArchive
     */
    public ZipArchive $ZipArchive;

    /**
     * The current zip file path
     *
     * @var string
     */
    public string $file;

    /**
     * Returns the index of the compression activity.
     *
     * @return integer
     */
    function index() : int {
        return $this->proxy->index();
    }
    
    /**
     * Retusnt the percentage status of the current operation
     *
     * @return integer
     */
    function count() : int {
        return $this->proxy->count();
    }

    /**
     * Retusnt the percentage status of the current operation
     *
     * @return integer
     */
    function status() : int {
        return $this->proxy->status();
    }

    /**
     * Returns the current file compressed
     *
     * @return string
     */
    function file() : string {
        return $this->proxy->file();
    }

    /**
     * Returns the ZIP state
     *
     * @return ZipArchive
     */
    function zip() : ZipArchive {
        return $this->proxy->zip();
    }

    #[Override]
    protected function ghostInit(): void
    {
        $this->update();
    }

    /**
     * This method is used internally to updates all properties. 
     * Directly calling it in closure functions has no impact on the state of properties
     *
     * @return void
     */
    public function update() {
        $this->index = $this->index();
        $this->count = $this->count();
        $this->status = $this->status();
        $this->ZipArchive = $this->zip();
        $this->file = $this->file();
    }

}