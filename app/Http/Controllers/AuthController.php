<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso! renan conseuiu fazer login',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciais inválidas. Verifique e tente novamente.',
        ], 401);
    }
}
