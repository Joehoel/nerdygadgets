<?php

namespace App\Domain\Database;

use PDO;

class DatabaseInstance
{
    private $dsn;

    protected $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct(array $dsn)
    {
        $this->dsn = $dsn;
    }

    public function getDSN()
    {
        return "mysql:host=" . $this->dsn["host"] . ";dbname=" . $this->dsn["database"]
            . ";charset=" . $this->dsn["charset"];
    }

    public function create()
    {
        return new PDO($this->getDSN(),
            $this->dsn["user"],
            $this->dsn["password"]
        );
    }
}