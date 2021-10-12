<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MySQLUsersRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;

class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySQLUsersRepository();
    }

    public function confirmationView(): void
    {
        require_once 'app/Views/Users/confirmation.php';
    }

    public function loginSuccess(): void
    {
        require_once 'app/Views/Users/loginSuccess.php';
    }
}