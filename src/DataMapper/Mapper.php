<?php


namespace App\DataMapper;


use App\Database\DatabaseConnection;
use PDO;
use PDOStatement;

class Mapper
{
    private DatabaseConnection $connection;
    private PDOStatement $statement;

    public function __construct()
    {
        $this->connection = (new DatabaseConnection());
    }

    public function buildStmt(string $stmt): self
    {
        $this->statement = $this->connection->open()->prepare($stmt);
        return $this;
    }

    public function bindValues(array $fields): PDOStatement
    {
        foreach ($fields as $field => $value) {
            $this->statement->bindValue(':' . $field, $value);
        }

        return $this->statement;
    }

    public function executeStmt(): bool
    {
        if ($this->statement) {
            return $this->statement->execute();
        }
    }

    public function result()
    {
        if ($this->statement) {
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }
    }

    public function count(): int
    {
        if($this->statement){
            return $this->statement->rowCount();
        }
    }

}