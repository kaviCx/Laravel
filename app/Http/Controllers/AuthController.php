<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

//     public function index(){
//         return view('auth.login');
//     }
//     public function registration()
//     {
//         return view('auth.register');
//     }

//     public function register(Request $request)
// {
//     $request->validate([
//         'name' => 'required',
//         'email' => 'required|email|unique:users',
//         'password' => 'required|confirmed'
//     ]);

//     $data = $request->only('name', 'email');
//     $data['password'] = Hash::make($request->password);

//     $user = User::create($data);

//     Auth::login($user);


//     $token = $user->createToken('auth_token')->plainTextToken;
//     return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
// }

//     public function login(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email',
//         'password' => 'required',
//     ]);

//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();


//         $token = $user->createToken('auth_token')->plainTextToken;
//           $credentials = $request->only('email', 'password');
//         if (Auth::attempt($credentials)) {
//             return redirect()->intended('dashboard')
//                 ->withSuccess('You have Successfully loggedin');
//         }
//     }

//     return redirect("login")->withError('Oppes! You have entered invalid credentials');
// }

//     public function dashboard()
//     {
//         if (Auth::check()) {
//             return view('dashboard');
//         }

//         return redirect("login")->withSuccess('Opps! You do not have access');
//     }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
