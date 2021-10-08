<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MySQLUsersRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;

class UserController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySQLUsersRepository();
    }

    public function showUsers(): void
    {
        $users = $this->usersRepository->getAllUsers();

        require_once 'app/Views/Users/showUsers.php';
    }

    public function loginView(): void
    {
        require_once 'app/Views/Users/userLogin.php';
    }

    public function registerView(): void
    {
        require_once 'app/Views/Users/userRegister.php';
    }

    public function login(): void
    {
        var_dump($_POST['login']);die;
    }

    public function register(): void
    {
        if(strlen($_POST['password']) < 6 || strlen($_POST['password']) > 35) header('Location: /register');
        if($_POST['password'] !== $_POST['passwordVerify']) header('Location: /register');

        $user = new User(
            Uuid::uuid4(),
            $_POST['username']
        );

        $this->usersRepository->register($user);
    }

    public function confirmation(): void
    {
        require_once 'app/Views/Users/confirmation.php';
    }
}