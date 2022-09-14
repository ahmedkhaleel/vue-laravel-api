<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'token' => auth()->user()->createToken('admin')->plainTextToken
            ], Response::HTTP_OK);
        }
        return  response([
            'error' => 'Invalid credentials'
        ], response::HTTP_UNAUTHORIZED);

    }
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only('first_name', 'last_name', 'email') + ['password' => bcrypt('password')]);
        return response($user, Response::HTTP_CREATED);
    }



}
