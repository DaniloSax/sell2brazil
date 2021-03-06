<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $token = $request->user()->createToken('sell2brazil-token');

            return response()->json(['token' => $token]);
        }

        return response()->json(['errors' => 'Login ou Senha incorreto!'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json(null, Response::HTTP_OK);
    }

    public function auth()
    {
        return response()->json(['auth' => Auth::user()], Response::HTTP_OK);
    }
}
