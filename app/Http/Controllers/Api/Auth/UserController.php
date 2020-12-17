<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\DTOs\UserResource;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        return response(new UserResource($user));
    }

    /**
     * Display authenticated user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        return response(new UserResource($request->user()));
    }

    /**
     * Login the user.
     *
     * @param  UserLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! \Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid credentials.',
            ], 400);
        }

        $token = $user->createToken('authenticate_token')->plainTextToken;

        return response((new UserResource($user))->additional(['token' => $token]));
    }

    /**
     * Logout the user.
     *
     * @param  UserLoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response([
            'message' => 'Logged out!',
        ]);
    }
}
