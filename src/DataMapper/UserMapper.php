<?php


namespace App\DataMapper;


use App\User;

class UserMapper extends Mapper
{
    public function load(User $user)
    {
        $email = $user->getEmail();
        $password = $user->getPassword();

        $statement = $this->buildStmt('SELECT * FROM `user` WHERE email = :email AND password = :password');
        $statement->bindValues(['email' => $email, 'password' => $password]);
        $statement->executeStmt();

        return $this->result();
    }

}