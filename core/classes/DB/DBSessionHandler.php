<?php

namespace spoova\mi\core\classes\DB;

use spoova\mi\core\classes\DB;
use SessionHandlerInterface;

class DBSessionHandler implements SessionHandlerInterface
{   

    private DBHandler $db;
    private $table = 'sessions';


    public function __construct()
    {
        $dbm = new DB();
        $this->db = $dbm->openDB();
    }

    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function gc(int $max_lifetime): int|false
    {
        
    }

    public function read(string $id): string|false
    {
        
    }

    public function write(string $id, string $data): bool
    {
        
    }

    public function destroy(string $id): bool
    {
        
    }

}
