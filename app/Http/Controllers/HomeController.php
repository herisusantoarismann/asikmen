<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use Illuminate\Support\Facades\Auth;

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
        $pertanyaan = Pertanyaan::where('id_tes', 1)->get();
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

    public function home()
    {
        return view('landing');
    }

    public function about()
    {
        return view('about');
    }
}