<?php

    namespace spoova\mi\core\classes\DB;

    Interface  DBInterface  {

        /**
         * Construct takes database configuration parameters (optional)
         */
        function __construct(
            $dbname   = null, 
            string|null $dbuser   = null, 
            string|null $dbpass   = null, 
            string|null $dbserver = null, 
            string|null|int $dbport   = null, 
            string|null $dbsocket = null
        );
        
        /**
         * For Executing non crud queries
         *
         * @param string $sql sql query
         * @return bool|array
         */
        public function process_query(string $sql);

        /**
         * sort or creates binded parameters syntax
         *
         * @param array &$data parameters to be binded to query supplied
         * @param string $sqL raw sql query supplied
         * @return void
         */
        public function buildBind(&$data, string $sqL);
        
        /**
         * executes insert queries
         *
         * @param array $sql
         * @return void
         */
        public function insert_query(array $sql);
        
        /**
         * executes fetch queries
         *
         * @param array $sql
         * @return void
         */
        public function fetch_array(array $sql);
        
        /**
         * executes update query
         *
         * @param array $sql
         * @return void
         */
        public function update_query(array $sql);
        
        /**
         * executes delete query
         *
         * @param array $sql
         * @return void
         */
        public function delete_query(array $sql);

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