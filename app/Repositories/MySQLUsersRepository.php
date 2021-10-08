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
                $row['user_name']
            ));
        }

        return $usersCollection;
    }

    public function register(User $user): void
    {
        $sql = "INSERT INTO users (user_id, user_name, password) VALUES (:user_id, :user_name, :password)";

        $this->connect()->prepare($sql)->execute([
            ':user_id' => $user->getId(),
            ':user_name' => $user->getName(),
            ':password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
        ]);
    }
}