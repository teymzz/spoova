<?php 

namespace spoova\mi\core\functions; 

class FunctionsList {

    private $path = '';
    private $func = '';

    public function __construct(string $path, string $func = '')
    {
        $this->path = $path;
        $this->func = $func;
    }

    /**
     * Get the file path of a function's file
     *
     * @return string
     */
    public function path() : string {
        $func = $this->func;
        if($func) $func = '::'.$func;
        return to_dirslash($this->path.''.$func);
    }

    public function name() : string {

        return $this->func;

    }

    public function namespace() : string {
        $namespace = trim(to_backslash($this->path.'\\'.$this->func));
        return scheme($namespace);

    }

    public function fullpath() : string {
        $filepath = trim(to_dirslash($this->path)).'.php\\'.$this->func;
        return $filepath;
    }

}