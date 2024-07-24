<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function register(Request $request)
    {
        $registerdData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($registerdData);

        $accessToken = $user
            ->createToken('authToken')
            ->accessToken;

        return response([
            'message' => 'User Register successfully',
            'user' => $user,
            'access_token' => $accessToken],
            201);

    }


    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($loginData)) {
            return response()->json(
                ['message' => 'Invalid credentials'],
                401);
        }

        $user = auth()->user();
        $accessToken = $user
        ->createToken('authToken')
        ->accessToken;

        return response()->json([
            'message' => 'User Login successfully',
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function logout(Request $request){

        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([
            'message' => 'User Logout successfully',
            'status' => true,
            'data' => [],
        ],200);
    }

    public function fetchPosts(Request $request)
    {
        $posts = Post::all();
        return response()->json($posts);
    }

}
