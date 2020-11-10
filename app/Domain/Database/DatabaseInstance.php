<?php

namespace App\Domain\Database;

use App\Domain\Config\Config;
use PDO;

class DatabaseInstance
{
    private $dsn;

    public $connection;

    protected $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct()
    {
        $this->dsn = new Config('database');

        $this->dsn = $this->dsn->get('mysql');

        $this->connection = $this->create();
        return $this->connection;
    }

    public function getDSN()
    {
        return "mysql:host=" . $this->dsn["host"] . ";dbname=" . $this->dsn["database"]
            . ";charset=" . $this->dsn["charset"];
    }

    public function create()
    {
        return new PDO($this->getDSN(),
            $this->dsn["username"],
            $this->dsn["password"]
        );
    }

    public function __destruct()
    {
        $this->connection = null;
    }
}