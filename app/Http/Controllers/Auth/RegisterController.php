<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('auth/register');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],[
            'surname.required' => 'Un prénom est requis.',
            'name.required' => 'Un nom est requis.',
            'email.required' => 'Un e-mail est requis.',
            'email.unique' => 'Un e-mail similaire est déjà inscris.',
        ]);

        $user = new User(); 
        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save(); 

        return redirect()->route('login')->with('success', 'Inscription réussi, vous pouvez maintenant vous connecter');
    }   
    
    public function __construct()
    {
        $this->middleware('guest');
    }

}
