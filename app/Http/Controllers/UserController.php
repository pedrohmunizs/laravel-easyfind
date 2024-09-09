<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function newPassword(Request $request, string $token)
    {

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request['email']
        ]);
    }

    public function resetPassword(Request $request)
    {
        $token =  DB::table('password_reset_tokens')->where('token', $request['token'])->first();

        if(!$token){
            response()->json(['message' => 'Token expirou, solicite outro link!'], 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => 'Senha redefinida com sucesso!'], 201)
                : response()->json(['message' => 'Erro ao redefinir senha, solicite outro link.'], 500);
    }
}
