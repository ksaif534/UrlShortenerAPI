<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthenticateUserWithAPIRequest;
use App\Http\Requests\API\ValidateUserRegistrationRequest;
use App\Models\User;
use App\Services\API\AuthenticateUserWithToken;
use App\Services\API\CheckExistingUser;
use App\Services\API\StoreNewUser;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateUserRegistrationRequest $request, CheckExistingUser $checkExistingUser, StoreNewUser $newUser)
    {
        $validated = $request->validated();
        $existingUser = $checkExistingUser->check($validated);

        if ($existingUser) {
            return response()->json([
                'msg' => 'User Already Exists',
            ], Response::HTTP_CONFLICT);
        }

        $response = $newUser->store($validated);

        if ($response) {
            return response()->json([
                'success' => 'User Registered Successfully',
            ], Response::HTTP_CREATED);
        }

        return response()->json([
            'failure' => 'Sorry, could not register User',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Authenticate User using Sanctum API Token
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AuthenticateUserWithAPIRequest $request, CheckExistingUser $existingUser, AuthenticateUserWithToken $authenticateUser)
    {
        $validated = $request->validated();

        $existingUserForAuthentication = $existingUser->check($validated);

        if (! $existingUserForAuthentication) {
            return response()->json([
                'error' => 'Invalid User',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $response = $authenticateUser->authenticate($validated, $existingUserForAuthentication);

        if (gettype($response) == 'string') {
            return response()->json([
                'success' => 'User Authenticated Successfully',
                'token' => $response,
            ]);
        }

        return response()->json([
            'error' => 'Invalid Email or Password',
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
