<?php

namespace App;

class Authentication
{
    public static function loggedIn(): bool
    {
        return isset($_SESSION['id']);
    }
}