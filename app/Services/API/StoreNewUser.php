<?php

namespace App\Services\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreNewUser
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Store New User
     */
    public function store(array $validated): bool
    {
        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        if ($newUser) {
            return true;
        }

        return false;
    }
}
