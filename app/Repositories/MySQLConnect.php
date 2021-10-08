<?php

namespace App\Repositories;

use PDO;

abstract class MySQLConnect
{
    private string $host = "localhost";
    private string $user = "root";
    private string $password = "root";
    private string $database = "todotasks";

    protected function connect(): PDO
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
        $pdo = new PDO($dsn, $this->user, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}