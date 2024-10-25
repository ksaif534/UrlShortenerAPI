<?php

namespace App\Services\API;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticateUserWithToken
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate User with API Token
     */
    public function authenticate(array $validated, User $existingUserForAuthentication): bool|string
    {
        if (! filter_var($validated['email'], FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if (Auth::attempt($validated)) {
            $existingUserForAuthentication->tokens()->delete();
            $token = $existingUserForAuthentication->createToken('url-shortener-auth-token')->plainTextToken;

            return $token;
        }

        return false;
    }
}
