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
    private MockApiService $mockApiService;

    public function __construct(MockApiService $mockApiService)
    {
        $this->mockApiService = $mockApiService;
    }

    public function register(Request $request)
    {
        $registerdData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($registerdData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([
            'message' => 'User Registered successfully',
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
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = auth()->user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function logout(Request $request){

        // auth()->user()->token()->delete();
        // $token->revoke();

        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([
            'status' => true,
            'message' => 'User Logout successfully',
            'data' => [],
        ],200);
    }

    public function fetchPosts(Request $request)
    {
        $posts = Post::all();
        return response()->json($posts);
    }




    public function getPosts(): JsonResponse
    {
        try {
            $posts = $this->mockApiService->getPosts();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getComments(int $postId): JsonResponse
    {
        try {
            $comments = $this->mockApiService->getComments($postId);
            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

}
