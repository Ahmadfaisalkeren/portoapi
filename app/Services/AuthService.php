<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService.
 */
class AuthService
{
    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                Auth::logout();

                return [
                    'status' => 'error',
                    'message' => 'Your email address is not verified',
                ];
            }

            /** @var \App\Models\User $user **/
            $token = $user->createToken('auth_token', ['expires' => now()->addHours(24)])->plainTextToken;

            return [
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Invalid credentials',
        ];
    }

    public function checkUser($userId)
    {
        return User::findOrFail($userId);
    }
}
