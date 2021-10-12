<?php

namespace App\Controllers;

use App\Authentication;
use App\Models\User;
use App\Repositories\MySQLUsersRepository;
use App\Validation\AuthValidator;
use App\Validation\FormValidationException;
use Ramsey\Uuid\Uuid;

class AuthController
{
    private MySQLUsersRepository $usersRepository;
    private AuthValidator $authValidator;

    public function __construct()
    {
        $this->usersRepository = new MySQLUsersRepository();
        $this->authValidator = new AuthValidator();
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
        try{
            $this->authValidator->validate($_POST);

            $this->usersRepository->save(new User(
                Uuid::uuid4(),
                $_POST['username'],
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_DEFAULT)
            ));

            header('Location: /');
        } catch(FormValidationException $exception) {
            $_SESSION['_errors'] = $this->authValidator->getErrors();
            header('Location: /register');
        }
    }

    public function login(): void
    {
        try{
            $this->authValidator->validateLogin($_POST);

            if(Authentication::loggedIn()) header('Location: /');

            $user = $this->usersRepository->getByEmail($_POST['email']);

            if($user !== null && password_verify($_POST['password'], $user->getPassword())){
                $_SESSION['id'] = $user->getId();
                header('Location: /todo');
            } else {
                header('Location: /login');
            }

        } catch(FormValidationException $exception)
        {
            $_SESSION['_errors'] = $this->authValidator->getErrors();
            header('Location: /login');
        }

    }

    public function logout(): void
    {
        unset($_SESSION['id']);
        header('Location: /');
    }
}