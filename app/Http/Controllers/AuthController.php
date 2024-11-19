<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //dd("chegamos");
        // Valida os campos de email e senha
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tenta autenticar o usuário
        if (Auth::attempt($credentials)) {
            // Regenera a sessão por segurança
            $request->session()->regenerate();

            // Retorna sucesso com a URL de redirecionamento
            return response()->json([
                'success' => true,
                'message' => 'Login realizado com sucesso! renan conseuiu fazer login',
                //'redirect' => url('/home'), // Modifique para a página desejada
            ]);
        }

        // Retorna erro se as credenciais estiverem erradas
        return response()->json([
            'success' => false,
            'message' => 'Credenciais inválidas. Verifique e tente novamente.',
        ], 401);
    }
}
