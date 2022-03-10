<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('dashboard');
        } else {
            return view('login');
        }
    }

    public function test(Request $request)
    {
        $pertanyaan = Pertanyaan::where('id_tes', $request->route('id'))->get();
        if ($request->ajax()) {
            return response()->json([
                'pertanyaan' => $pertanyaan
            ]);
        }

        return view('test')->with('pertanyaan', $pertanyaan);
    }

    public function saveTest(Request $request)
    {
        $request->validate([
            'id_user'   => 'required',
            'id_mental'    => 'required',
            'jawaban'   => 'required',
        ]);

        $jawaban = Jawaban::create([
            'id_user'   => $request->id_user,
            'id_mental'    => $request->id_mental,
            'jawaban'   => $request->jawaban
        ]);

        if ($jawaban) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Jawaban berhasil disimpan!',
                'jawaban' => $jawaban->jawaban
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Jawaban gagal disimpan!'
            ]);
        }
    }

    public function testResult()
    {
        return view('testResult');
    }

    public function profile()
    {
        return view('profile');
    }

    public function editProfile($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'User berhasil diambil!',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'User gagal diambil!'
            ]);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'email' => 'required',
            'name' => 'required',
            'new_password' => 'min:3|max:15|same:password_confirmation|nullable',
            'password_confirmation' => 'min:3|max:15|nullable'
        ]);

        if (!is_null($request->old_password) && !is_null($request->new_password)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->old_password])) {
                $user = User::where('id', $request->id_user)->update([
                    'email' => $request->email,
                    'name' => $request->name,
                    'password' => Hash::make($request->new_password)
                ]);
                return response()->json([
                    'status' => 'Berhasil',
                    'message' => 'User berhasil diubah!',
                    'data' => $request->old_password
                ]);
            } else {
                return response()->json([
                    'status' => 'Gagal',
                    'message' => 'Masukkan data User dengan benar!'
                ]);
            }
        } else {
            $user = User::where('id', $request->id_user)->update([
                'email' => $request->email,
                'name' => $request->name
            ]);

            if ($user) {
                return response()->json([
                    'status' => 'Berhasil',
                    'message' => 'User berhasil diubah!'
                ]);
            } else {
                return response()->json([
                    'status' => 'Gagal',
                    'message' => 'User gagal diubah!'
                ]);
            }
        }
    }

    public function home()
    {
        return view('landing');
    }

    public function about()
    {
        return view('about');
    }
}