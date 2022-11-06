<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Interfaces\AuthServiceInterface;

class AuthController extends Controller
{
    protected AuthServiceInterface $service;

    function __construct(AuthServiceInterface $service)
    {
        $this->service = $service;
    }
    
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        try {

            $inputs = $request->only('email', 'password');

            // Authenticate the user
            $user = $this->service->authenticateUser($inputs);
            throw_if(empty($user), new \Exception('User not found on the server!', 404));

            // Revoke previous tokens...
            $user->tokens()->delete();

            // Creating a token
            $user_token = $user->createToken($user->password)->plainTextToken;
            throw_if(empty($user_token), new \Exception('User token cannot be created!', 404));

            return response()->ok('AUTHENTICATED', 'User successfully logged in!', ['token' => $user_token, 'user' => $user]);

        } catch (\Exception | \Throwable $exception) {
            return response()->unauthorized('UNAUTHENTICATED', $exception->getMessage());
        }
    }
}