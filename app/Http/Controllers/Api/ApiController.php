<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
* @OA\Info(
*      title= "Laravel v11 Passport APIs",
*      version="1.0.0"
* )
*/

class ApiController extends Controller
{
/**
* @OA\Post(
* path="/api/register",
* operationId="Register",
* tags={"Register"},
* summary="User Register",
* description="User Register here",
*     @OA\RequestBody(
*         @OA\JsonContent(),
*         @OA\MediaType(
*            mediaType="multipart/form-data",
*            @OA\Schema(
*               type="object",
*               required={"name","email", "password", "password_confirmation"},
*               @OA\Property(property="name", type="text"),
*               @OA\Property(property="email", type="text"),
*               @OA\Property(property="password", type="password"),
*               @OA\Property(property="password_confirmation", type="password")
*            ),
*        ),
*    ),
*      @OA\Response(
*          response=201,
*          description="Register Successfully",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=200,
*          description="Register Successfully",
*          @OA\JsonContent()
*       ),
*      @OA\Response(
*          response=422,
*          description="Unprocessable Entity",
*          @OA\JsonContent()
*       ),
*      @OA\Response(response=400, description="Bad request"),
*      @OA\Response(response=404, description="Resource Not Found"),
* )
*/

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
            'user' => $user,
            'access_token' => $accessToken,
            'message' => 'User Logged in successfully',
        ],
            201);

    }

    /**
* @OA\Post(
*     path="/api/login",
*     operationId="Login",
*     tags={"Login"},
*     summary="User Login",
*     description="User Login here",
*     @OA\RequestBody(
*         required=true,
*         @OA\MediaType(
*            mediaType="multipart/form-data",
*            @OA\Schema(
*               type="object",
*               required={"email", "password"},
*               @OA\Property(property="email", type="string", example="sanjay@gmail.com"),
*               @OA\Property(property="password", type="string", example="123456"),
*            ),
*        ),
*        @OA\MediaType(
*            mediaType="application/json",
*            @OA\Schema(
*               type="object",
*               required={"email", "password"},
*               @OA\Property(property="email", type="string", example="sanjay@gmail.com"),
*               @OA\Property(property="password", type="string", example="123456"),
*            ),
*        ),
*    ),
*    @OA\Response(
*        response=201,
*        description="Login Successfully",
*        @OA\JsonContent()
*    ),
*    @OA\Response(
*        response=200,
*        description="Login Successfully",
*        @OA\JsonContent()
*    ),
*    @OA\Response(
*        response=422,
*        description="Unprocessable Entity",
*        @OA\JsonContent()
*    ),
*    @OA\Response(response=400, description="Bad request"),
*    @OA\Response(response=404, description="Resource Not Found"),
* )
*/


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
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }


    public function logout(Request $request){

        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([
            'status' => true,
            'message' => 'User Logout successfully',
            'data' => [],
        ],200);
    }

      /**
* @OA\Get(
*     path="/api/posts",
*     operationId="getPosts",
*     tags={"Posts"},
*     summary="Get posts",
*     description="Retrieve Posts.",
*     security={{"bearerAuth":{}}},
*     @OA\Parameter(
*         name="Authorization",
*         in="header",
*         description="Authorization Token",
*         required=true,
*         @OA\Schema(
*             type="string",
*             default="Bearer your_access_token_here"
*         )
*     ),
*     @OA\Response(
*         response=200,
*         description="Successful operation",
*         @OA\JsonContent()
*     ),
*     @OA\Response(
*         response=401,
*         description="Unauthorized"
*     )
* )
*
* @OA\SecurityScheme(
*     securityScheme="bearerAuth",
*     type="http",
*     scheme="bearer",
*     bearerFormat="JWT"
* )
*/

    public function fetchPosts(Request $request)
    {
        $posts = Post::all();
        return response()->json(
            [
                'posts' => $posts,
                'message' => 'Posts fetched successfully',
            ]

        );
    }

}
