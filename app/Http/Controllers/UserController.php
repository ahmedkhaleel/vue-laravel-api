<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function index()
    {
        return User::paginate();
    }
    public function show($id)
    {
        return User::find($id);
    }
    public function store(UserCreateRequest $request)
    {
        $user = User::create(request()->only('first_name', 'last_name', 'email') + ['password' => bcrypt('password')]);
        return response($user, Response::HTTP_CREATED);

    }
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update(request()->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }
    public function destroy($id)
    {
        User::destroy($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function user()
    {
        return auth()->user();
    }
    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response($user, Response::HTTP_ACCEPTED);
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => bcrypt($request->input('password'))
        ]);
        return response($user, Response::HTTP_ACCEPTED);
    }
}
