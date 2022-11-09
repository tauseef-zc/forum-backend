<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\PasswordCreationNotification;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthService extends BaseService implements AuthServiceInterface
{
    //
    protected AuthRepositoryInterface $repo;

    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }
    
    /**
     * Getting the user
     *
     * @param  int $id
     * @return User
     */
    public function getUser(int $id): User
    {
        return $this->repo->getUser($id);
    }
    
    /**
     * Storing the user to DB
     *
     * @param  array $data
     * @return Model
     */
    public function addUser(array $data): Model
    {
        return $this->repo->store($data);
    }

    /**
     * @throws ValidationException
     */    
    /**
     * Authenticate user
     *
     * @param  array $user
     * @return User
     */
    public function authenticateUser(array $user): ? User
    {

        $auth = $this->repo->getUserByEmail($user['email']);

        if (!empty($auth) && Hash::check($user['password'], $auth->password)) {
            return $auth;
        }

        return null;
    }
}