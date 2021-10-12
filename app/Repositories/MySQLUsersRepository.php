<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;
use App\Models\User;
use App\MySQLConnect\MySQLConnect;

class MySQLUsersRepository extends MySQLConnect implements UsersRepository
{
    public function getAllUsers(): UsersCollection
    {
        $usersCollection = new UsersCollection();

        $statement = $this->connect()->query("SELECT * FROM users");

        foreach($statement->fetchAll() as $row){

            $usersCollection->add(new User(
                $row['user_id'],
                $row['user_name'],
                $row['email'],
                $row['password']
            ));
        }

        return $usersCollection;
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (user_id, user_name, email, password) VALUES (:user_id, :user_name, :email, :password)";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $user->getId(),
            ':user_name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword()
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $statement = $this->connect()->prepare($sql);
        $statement->execute([$email]);

        $user = $statement->fetch();

        return new user(
            $user['user_id'],
            $user['user_name'],
            $user['email'],
            $user['password']
        );
    }
}