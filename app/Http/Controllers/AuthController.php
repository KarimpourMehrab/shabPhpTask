<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\InvalidUsernameOrPasswordException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $this->data = User::query()->create([
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'mobile' => $request->input('mobile')
        ]);
        return $this->response();
    }

    /**
     * @throws InvalidUsernameOrPasswordException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByMobile($request->input('mobile'));
        $passwordIsCorrect = $this->userRepository->checkPassword($user?->password, $request->input('password'));

        if (!$user || !$passwordIsCorrect) {
            throw  new InvalidUsernameOrPasswordException();
        }
        $token = $user->createToken('clients')->plainTextToken;
        $this->status = true;
        $this->data = ['token' => $token, 'user' => $user];
        return $this->response();
    }
}
