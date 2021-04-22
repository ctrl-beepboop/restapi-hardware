<?php


namespace App\Database;


use PDO;

class DatabaseConnection
{
    private PDO $connection;

    public function open(): PDO
    {
        try {
            $this->connection = new PDO('mysql:host=localhost;dbname=rhw', 'root', '');
        } catch (\PDOException $e) {
            exit($e->errorInfo);
        }

        return $this->connection;
    }
}