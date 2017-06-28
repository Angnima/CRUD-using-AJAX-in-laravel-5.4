<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $user;
    protected $auth;

    public function __construct(User $user , Guard $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
        $this->middleware('guest',['except'=>'logout']);
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'Required',
            'password' => 'Required|min:6'
        ]);
        $credentials = $request->only('email','password');

        if($this->auth->attempt($credentials,$request->has('remember'))){
            return redirect()->route('home');
        }
        return redirect()
            ->back()
            ->withInput($request->only('email'))
            ->withErrors(['Auth' => \Lang::get('auth.failed')]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
