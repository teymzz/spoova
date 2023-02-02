<?php

namespace spoova\windows\Routes\Docs;

use Window;

class Database extends Window {

    public function __construct($path){

        //accepted routes
        $acceptables = [
            window('root:database') => 'root',
            window('root:database.query' )   => 'query',
            window('root:database.insert')   => 'insert',
            window('root:database.select')   => 'select',
            window('root:database.update')   => 'update',
            window('root:database.delete')   => 'delete',
            window('root:database.process')  => 'process',
            window('root:database.errors')   => 'errors',
            window('root:database.status')   => 'status',
            window('root:database.data-model')   => 'model',
            window('root:database.migrations')   => 'migrations',
            window('root:database.migrations.samples')   => 'migration_samples',
        ];

        self::call($this, $acceptables);

    }

    function root() {

        $pointer = self::mapurl('Tutorial/Database', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'tutorial',
            'pointer' => $pointer
        ];

        self::load('database', fn() => compile($vars) );

    }

    function query(){    
        $pointer = self::mapurl('Tutorial/Database/Query', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database query',
            'pointer' => $pointer
        ];
        self::load('docs.db.query', fn() => compile($vars));
    }
    
    function insert(){    
        $pointer = self::mapurl('Tutorial/Database/Insert', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database insert',
            'pointer' => $pointer
        ];
        self::load('docs.db.insert', fn() => compile($vars));
    }

    function select(){    
        $pointer = self::mapurl('Tutorial/Database/Select', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database select',
            'pointer' => $pointer
        ];
        self::load('docs.db.select', fn() => compile($vars));
    }

    function update(){    
        $pointer = self::mapurl('Tutorial/Database/Update', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database update',
            'pointer' => $pointer
        ];
        self::load('docs.db.update', fn() => compile($vars));
    }    


    function delete(){    
        $pointer = self::mapurl('Tutorial/Database/Delete', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database delete',
            'pointer' => $pointer
        ];
        self::load('docs.db.delete', fn() => compile($vars));
    }        

    function process(){    
        $pointer = self::mapurl('Tutorial/Database/Process', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Process',
            'pointer' => $pointer
        ];
        self::load('docs.db.process', fn() => compile($vars));
    }    

    function errors(){    
        $pointer = self::mapurl('Tutorial/Database/Errors', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Errors',
            'pointer' => $pointer
        ];
        self::load('docs.db.errors', fn() => compile($vars));
    }       

    function status(){    
        $pointer = self::mapurl('Tutorial/Database/Status', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Status',
            'pointer' => $pointer
        ];
        self::load('docs.db.status', fn() => compile($vars));
    } 

    function model(){    
        $pointer = self::mapurl('Tutorial/Database/Data-Model', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Data Model',
            'pointer' => $pointer
        ];
        self::load('docs.db.data-model', fn() => compile($vars));
    } 

    function migrations(){    
        $pointer = self::mapurl('Tutorial/Database/Migrations', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Data Model',
            'pointer' => $pointer
        ];
        self::load('docs.db.migrations', fn() => compile($vars));
    } 

    function migration_samples(){    
        $pointer = self::mapurl('Tutorial/Database/Migrations/Samples', ' <span class="bi-chevron-right"></span> ');
        
        $vars = [
            'title' => 'Tutorial - Database Data Model',
            'pointer' => $pointer
        ];
        self::load('docs.db.migrations.samples', fn() => compile($vars));
    } 
    

}