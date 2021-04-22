<?php

namespace App\Action\POST;

use App\APICall\POSTCall;
use App\DataMapper\Mapper;

class User
{
    /**
     * @param POSTCall $call
     * @param string $action
     * @return User
     */
    public static function initPOSTUser(POSTCall $call, string $action): User
    {
        return new self($action);
    }

    /**
     * User constructor.
     * @param string $action
     */
    private function __construct(string $action)
    {
        $actionToCall = [$this, $action];

        return call_user_func($actionToCall);
    }

    private function create(): void
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            exit();
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $mapper = new Mapper();
        $statement = $mapper->buildStmt('INSERT INTO user (email, password) VALUES (:email, :password)');
        $statement->bindValues(['email' => $email, 'password' => $password]);
        $statement->executeStmt();
    }
}