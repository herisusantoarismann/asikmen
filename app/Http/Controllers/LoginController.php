<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $message = [
            'required'  => ':attribute tidak diisi!',
            'email'     => 'Format email salah!',
            'min'       => ':attribute harus diisi minimal :min karakter!',
            'max'       => ':attribute harus diisi maksimal :max karakter!',
        ];
        
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:3|max:15'
        ], $message);

        $user = User::where('email', $request->email)->first();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('dashboard');
        } else {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'level' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|max:15|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:3|max:15'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level
        ]);
        if ($user) {
            Session::flash('success', 'Berhasil Registrasi');
            return redirect('/');
        } else {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/register');
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}