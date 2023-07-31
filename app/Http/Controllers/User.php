<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User as ModelUser;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $users = ModelUser::query()->when($request->search, function (Builder $builder) use ($request) {
            $builder->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%");
        })->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($users, 200);
    }

    public function create()
    {
    }

    public function store(UserRequest $request)
    {
        $user = ModelUser::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
        return response()->json(['status' => 'ok', 'user' => $user, 'message' => 'User created successfully'], 201);
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, $uid)
    {
        //
        $user = ModelUser::findOrFail($uid);
        $user->update($request->only("name", "email"));
        return response()->json([
            'status' => 'ok',
            'message' => "User $user->name updated successfully",
            "user" => $user
        ]);
    }

    public function destroy($uid)
    {
        ModelUser::findOrFail($uid)->delete();
        return response()->json([
            'status' => 'ok',
            'message' => 'User deleted'
        ]);
    }
}
