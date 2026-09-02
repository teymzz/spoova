<?php 

namespace spoova\mi\core\classes\DB;

interface DBExecutors {

    /**
     * Returns the last sql query detected if any.
     *
     * @return string
     */
    public function sql();

    /**
     * Returns TRUE if sql error was detected.
     *
     * @return bool
     */
    public function failed();

    /**
     * Returns TRUE if no sql error was detected.
     *
     * @return bool
     */
    public function succeeds() : bool;

    /**
     * Return an array list of sql data related information
     *
     * @return array
     */
    public function info();


    /**
     * Returns the last error set by DBViewer
     *
     * @return string|false
     */
    public function error();


}