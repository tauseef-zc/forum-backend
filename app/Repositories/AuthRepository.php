<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{

    protected Model $model;
    
    function __construct(User $user)
    {
        $this->model = $user;
    }

    public function addUser(array $data): ?User
    {
        return $this->model->store($data);
    }

    public function getUser(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function getUserByEmail($email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

}