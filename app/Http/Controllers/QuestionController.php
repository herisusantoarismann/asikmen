<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questionAnxiety = Pertanyaan::where('id_tes', 1)->get();
        if ($request->ajax()) {
            return response()->json([
                'questionAnxiety' => $questionAnxiety
            ]);
        }
        return view('question')->with('questionAnxiety', $questionAnxiety);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_tes' => 'required',
            'pertanyaan' => 'required',
        ]);

        $pertanyaan = Pertanyaan::create([
            'id_tes' => $request->id_tes,
            'pertanyaan' => $request->pertanyaan,
        ]);
        if ($pertanyaan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Pertanyaan berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Pertanyaan gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $pertanyaan = Pertanyaan::where('id_pertanyaan', $id)->first();
        if ($pertanyaan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Pertanyaan berhasil disimpan!',
                'data' => $pertanyaan
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Pertanyaan gagal disimpan!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_pertanyaan' => 'required',
            'pertanyaan' => 'required',
        ]);

        $pertanyaan = Pertanyaan::where('id_pertanyaan', $request->id_pertanyaan)->update([
            'pertanyaan' => $request->pertanyaan
        ]);
        if ($pertanyaan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Pertanyaan berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Pertanyaan gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $pertanyaan = Pertanyaan::destroy($id);
        if ($pertanyaan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Pertanyaan berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Pertanyaan berhasil dihapus!'
            ]);
        }
    }
}