<?php

namespace App\Validation;

class AuthValidator
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate(array $data): void
    {
        if(!isset($_POST['username']) || empty($_POST['username'])){
            $this->errors['username'] = "Username must be required";
        }

        if(!isset($_POST['email']) || empty($_POST['email'])){
            $this->errors['email'] = "Email must be required";
        }

        if($_POST['password'] < 6){
            $this->errors['password'] = "Password must be at least 6 characters long";
        }

        if($_POST['password'] !== $_POST['passwordVerify']){
            $this->errors['passwordVerify'] = "Passwords do not match";
        }

        if(count($this->errors) > 0) {
            throw new FormValidationException();
        }
    }

    public function validateLogin(array $data): void
    {
        if(!isset($_POST['email']) || empty($_POST['email'])){
            $this->errors['email'] = "Email must be required";
        }

        if(!isset($_POST['password']) || empty($_POST['password'])){
            $this->errors['password'] = "Password must be required";
        }

        if(count($this->errors) > 0) {
            throw new FormValidationException();
        }
    }
}