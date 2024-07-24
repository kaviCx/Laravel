<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class ApiController extends Controller
{

        public function registration()
        {
            return view('auth.register');
        }
        public function register(Request $request)
        {
            try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $expirationMinutes = 30;

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('auth_token', ['expires' => now()->addMinutes($expirationMinutes)])->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User registered successfully.',
                'token' => $token
            ]);

        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
             }
        }



        public function index(Request $request){
            return view('auth.login');
        }


        public function login(Request $request)
        {
            try {

                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validation error',
                        'errors' => $validator->errors()
                    ], 422);
                }

                if (!Auth::attempt($request->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid credentials'
                    ], 401);
                }

                $expirationMinutes = 30;

                $user = User::where('email', $request->email)->first();
                $token = $user->createToken('auth_token', ['expires' => now()->addMinutes($expirationMinutes)])->plainTextToken;

                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully.',
                    'token' => $token
                ]);

                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' => $th->getMessage(),
                    ], 500);
                }
        }


        public function profile(){
            $userData = auth()->user();
            // dd($userData);
            return response()->json([
                'status' => true,
                'message' => 'User Profile Data:',
                'data' => $userData,
                'id' => $userData->id
            ],200);

        }

        public function logout(Request $request){
            // dd("hhhhhhhhhh");
            // auth()->user()->tokens()->delete();
            PersonalAccessToken::where('tokenable_id', auth()->id())->delete();
            return response()->json([
                'status' => true,
                'message' => 'UserLogout successfully',
                'data' => [],
            ],200);
        }




}


