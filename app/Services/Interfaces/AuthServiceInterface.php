<?php

namespace App\Services\Interfaces;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface AuthServiceInterface
{

    public function addUser(array $data);

    public function getUser(int $id): User;

    public function authenticateUser(array $user): ?Model;

}
