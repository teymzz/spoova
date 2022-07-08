<?php

namespace spoova\windows\Docs;

use spoova\windows\Frame\UserFrame;

class Database extends UserFrame{
  
    protected $resolved = false; 

    function __construct($value){
        
        if($value){
            $acceptables = [
                'query' => 'query',
                'insert' => 'insert',
                'select' => 'select',
                'update' => 'update',
                'delete' => 'delete',
                'process' => 'process',
                'errors' => 'errors',
                'status' => 'status',
            ];
            
            if(array_key_exists($value, $acceptables)){
                $this->{$acceptables[$value]}();
                $this->resolved = true;
            }
        }
        
    }

    function index($vars){

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

    public function resolve(){
        return $this->resolved;
    }

}