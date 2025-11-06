<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->login($credentials);

        if ($result['status'] === 'error') {
            return response()->json(['error' => $result['message']], 401);
        }

        return response()->json($result, 200);
    }

    public function user($userId)
    {
        $user = $this->authService->checkUser($userId);

        return response()->json([
            'status' => 200,
            'message' => 'User fetched successfully',
            'user' => $user
        ]);
    }
}
