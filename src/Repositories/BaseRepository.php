<?php

namespace App\Repositories;

use App\Service\Database;

abstract class BaseRepository
{
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database(
            host: 'automapa_postgres',
            port: 5432,
            dbName: 'automapa',
            username: 'automapa',
            password: '123'
        );
        $this->db->connect();
    }
}