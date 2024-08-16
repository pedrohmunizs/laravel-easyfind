<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('institucional.index');
    }

    public function create()
    {
        return view('institucional.create');
    }

    public function login()
    {
        return view('users.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = auth()->user();

            if ($user) {

                if ($user->type == 'consumidor') {
                    $defaultUrl = '/';
                } else {
                    $defaultUrl = '/estabelecimentos';
                }

                $previousUrl = session('url.intended', $defaultUrl);

                return response()->json([
                    'url' => $previousUrl
                ]);

            } else {
                return response()->json([
                    'message' => 'User not found after authentication.',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Erro ao realizar o login!',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
}
