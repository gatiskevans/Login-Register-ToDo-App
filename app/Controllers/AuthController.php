<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\User;
use App\Repositories\MySQLUsersRepository;
use Ramsey\Uuid\Uuid;

class AuthController
{
    private MySQLUsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new MySQLUsersRepository();
    }

    public function loginView(): void
    {
        if(Authentication::loggedIn()) header('Location: /');
        require_once 'app/Views/Users/userLogin.php';
    }

    public function registerView(): void
    {
        require_once 'app/Views/Users/userRegister.php';
    }

    public function register(): void
    {
        //todo validate

        $this->usersRepository->save(new User(
            Uuid::uuid4(),
            $_POST['username'],
            $_POST['email'],
            password_hash($_POST['password'], PASSWORD_DEFAULT)
        ));

        header('Location: /');
    }

    public function login(): void
    {
        if(Authentication::loggedIn()) header('Location: /');

        $user = $this->usersRepository->getByEmail($_POST['email']);

        if($user !== null && password_verify($_POST['password'], $user->getPassword())){
            $_SESSION['id'] = $user->getId();
            header('Location: /todo');
        } else {
            header('Location: /login');
        }

        //todo errors
    }

    public function logout(): void
    {
        unset($_SESSION['id']);
        header('Location: /');
    }
}