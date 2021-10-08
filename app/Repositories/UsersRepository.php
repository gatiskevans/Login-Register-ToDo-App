<?php

namespace App\Repositories;

use App\Models\Collections\UsersCollection;
use App\Models\User;

interface UsersRepository
{
    public function getAllUsers(): UsersCollection;
    public function register(User $user): void;
}