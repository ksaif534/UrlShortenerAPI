<?php

namespace App\Services\API;

use App\Models\User;

class CheckExistingUser
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check If User Exists or Not
     */
    public function check(array $validated): ?User
    {
        $existingUser = User::where('email', $validated['email'])->first();

        return $existingUser;
    }
}
