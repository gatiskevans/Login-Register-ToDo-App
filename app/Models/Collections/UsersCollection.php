<?php

namespace App\Models\Collections;

use App\Models\User;

class UsersCollection
{
    private array $allUsers = [];

    public function __construct(array $users = [])
    {
        foreach ($users as $user) {
            $this->add($user);
        }
    }

    public function add(User $user): void
    {
        $this->allUsers[$user->getId()] = $user;
    }

    public function getAllUsers(): array
    {
        return $this->allUsers;
    }
}