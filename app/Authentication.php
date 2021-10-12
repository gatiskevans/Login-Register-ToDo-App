<?php

namespace App;

use App\Models\User;
use App\Repositories\MySQLUsersRepository;

class Authentication
{
    public static function loggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public static function user(): ?User
    {
        if(!self::loggedIn()) return null;

        $userRepository = new MySQLUsersRepository();
        return $userRepository->getById($_SESSION['id']);
    }
}