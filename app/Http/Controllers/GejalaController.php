<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\Faktor;
use App\Models\Mental;

class GejalaController extends Controller
{
    public function index(Request $request)
    {
        $mental = Mental::get();
        $gejala = Faktor::join('gejala', 'faktor.id_faktor', '=', 'gejala.id_faktor')->join('mental', 'mental.id_mental', '=', 'faktor.id_mental')->get(['gejala.*', 'faktor.nama AS namaFaktor', 'mental.nama AS namaMental', 'mental.id_mental']);
        $faktor = Faktor::get();
        if ($request->ajax()) {
            return response()->json([
                'gejala'    => $gejala,
                'faktor'    => $faktor
            ]);
        }
        return view('gejala')->with('mental', $mental);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_faktor' => 'required',
            'nama' => 'required',
        ]);

        $gejala = Gejala::create([
            'id_faktor' => $request->id_faktor,
            'nama' => $request->nama,
        ]);

        if ($gejala) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Gejala Mental berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gejala Mental gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $gejala = Gejala::where('id_gejala', $id)->first();
        if ($gejala) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Gejala Mental berhasil diambil!',
                'data' => $gejala
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gejala Mental gagal diambil!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_gejala' => 'required',
            'id_faktor' => 'required',
            'nama' => 'required',
        ]);

        $gejala = Gejala::where('id_gejala', $request->id_gejala)->update([
            'id_faktor' => $request->id_faktor,
            'nama' => $request->nama,
        ]);
        if ($gejala) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Gejala Mental berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gejala Mental gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $gejala = Gejala::destroy($id);
        if ($gejala) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Gejala Mental berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Gejala Mental gagal dihapus!'
            ]);
        }
    }
}