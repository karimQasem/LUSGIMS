<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        User::destroy($userId);
    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser($userId, array $data)
    {
        return User::whereId($userId)->update($data);
    }
}
