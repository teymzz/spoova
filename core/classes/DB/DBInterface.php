<?php

    namespace spoova\core\classes\DB;

    Interface  DBInterface  {

        /**
         * Construct takes database configuration parameters (optional)
         */
        function __construct(
            $dbname   = null, 
            $dbuser   = null, 
            $dbpass   = null, 
            $dbserver = null, 
            $dbport   = null, 
            $dbsocket = null
        );
        
        /**
         * For Executing non crud queries
         *
         * @param string $sql sql query
         * @return bool|array
         */
        public function process_query($sql);

        /**
         * sort or creates binded parameters syntax
         *
         * @param array $data parameters to be binded to query supplied
         * @param string $sqL raw sql query supplied
         * @return void
         */
        public function buildBind(&$data, $sqL);
        
        /**
         * executes insert queries
         *
         * @param string $sql
         * @return void
         */
        public function insert_query($sql);
        
        /**
         * executes fetch queries
         *
         * @param string $sql
         * @return void
         */
        public function fetch_array($sql);
        
        /**
         * executes update query
         *
         * @param string $sql
         * @return void
         */
        public function update_query($sql);
        
        /**
         * executes delete query
         *
         * @param string $sql
         * @return void
         */
        public function delete_query($sql);

        /**
         * returns the insert id
         *
         * @return void|int insertion id
         */
        public function insert_id();  

        /**
         * Returns the number of rows
         *
         * @return int number of affected rows
         */
        public function num_rows();  

        /**
         * Error of the instanti
         *
         * @return int number of affected rows
         */        
        public function error();

    }