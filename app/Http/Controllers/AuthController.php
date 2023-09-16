<?php

namespace App\Http\Controllers;

use App\Exceptions\Auth\InvalidUsernameOrPasswordException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private readonly UserRepository $userRepository)
    {
        parent::__construct();
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->data = $this->userRepository->create([
            ...$request->validated(),
            'password' => Hash::make($request->input('password'))
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
