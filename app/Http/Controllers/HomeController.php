<?php

namespace App\Http\Controllers;

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
        $pertanyaan = Pertanyaan::where('id_tes', 1)->orderBy('no')->get();
        if ($request->ajax()) {
            return response()->json([
                'pertanyaan' => $pertanyaan
            ]);
        }
        return view('test')->with('pertanyaan', $pertanyaan);
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