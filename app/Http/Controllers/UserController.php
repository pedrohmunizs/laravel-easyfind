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
                    $defaultUrl = '/home';
                } else {
                    $defaultUrl = '/estabelecimentos';
                }

                return redirect()->intended($defaultUrl);

            } else {
                return response()->json([
                    'message' => 'User not found after authentication.',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Login failed. Invalid credentials.',
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
