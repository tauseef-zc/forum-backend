<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface extends RepositoryInterface
{
    public function getUserByEmail(string $email): ? User;

    public function getUser(int $id): ?User;

}