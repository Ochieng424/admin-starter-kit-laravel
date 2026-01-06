<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }
    public function register(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        $data = $this->authService->register($validated);

        return response()->json($data);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $data = $this->authService->login($validated);

        return response()->json($data);
    }

    public function user()
    {
        return auth()->user();
    }

    public function logout(){
        $user = auth()->user();
        return $user->currentAccessToken()->delete();
    }

    public function refresh()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return $user->createToken('web')->plainTextToken;
    }
}
