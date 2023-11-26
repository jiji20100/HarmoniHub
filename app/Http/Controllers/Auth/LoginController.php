<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth/login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Un email est requis.',
            'password.required' => 'Un mot de passe est requis.',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt([
            'email' => $request->email, 
            'password' => $request->password
        ], $request->filled('remember'));
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        return redirect()->intended('/home');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Les informations d\'identification fournies ne correspondent pas à nos enregistrements.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
