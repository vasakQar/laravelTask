<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'lang_id' => 'exists:languages,id',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'lang_id' => $request->lang_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'data' => $user,
            'success' => 'user has been created successfully Q!'
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $accessToken = auth()->user()->createToken('Laravel Password Grant Client')->accessToken;
            $accessToken = $accessToken->token;
            return response(['user' => auth()->user(), 'access_token' => $accessToken], 200);
        }
    }

    public function logout (Request $request)
    {
        $tokens = $request->user()->tokens;

        foreach ($tokens as $token) {
            $token->delete();
        }

        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function authorizeUser(Request $request) {
        return response()->json(['user' => $request->user()]);
    }

}
