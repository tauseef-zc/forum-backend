<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;

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

            return response()->ok('AUTHENTICATED', 'User successfully logged in!', [
                'token' => $user_token, 
                'user' => new UserResource($user)
            ]);

        } catch (\Exception | \Throwable $exception) {
            return response()->unauthorized('UNAUTHENTICATED', $exception->getMessage());
        }
    }

    public function register(UserRegisterRequest $request)
    {
        try{

            $inputs = $request->toArray();
            $inputs['password'] = Hash::make($inputs['password']);

            // Creating a user
            $user = $this->service->addUser($inputs);
            throw_unless($user, new \Exception('User cannot be created! Please tray again a while.', 404));

            $user = $this->service->getUser($user->id);

            // $user->sendEmailVerificationNotification();

            return response()->ok('REGISTERED', 'User successfully registered!', [
                'user' => new UserResource($user) 
            ]);

        }catch (\Exception | \Throwable $exception){
            return response()->unauthorized('UNAUTHENTICATED', $exception->getMessage(), $exception->getTrace());
        }
    }

    public function verify(int $id, string $hash)
    {
        
    }
}