<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mental;

class MentalController extends Controller
{
    public function index(Request $request)
    {
        $mental = Mental::get();
        if ($request->ajax()) {
            return response()->json([
                'mental' => $mental
            ]);
        }
        return view('mental');
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'description' => 'required',
        ]);

        $mental = Mental::create([
            'nama' => $request->nama,
            'description' => $request->description,
        ]);
        if ($mental) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Penyakit Mental berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Penyakit Mental gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $mental = Mental::where('id_mental', $id)->first();
        if ($mental) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Penyakit Mental berhasil diambil!',
                'data' => $mental
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Penyakit Mental gagal diambil!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_mental' => 'required',
            'nama' => 'required',
            'description' => 'required',
        ]);

        $mental = Mental::where('id_mental', $request->id_mental)->update([
            'nama' => $request->nama,
            'description' => $request->description
        ]);
        if ($mental) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Penyakit Mental berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Penyakit Mental gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $mental = Mental::destroy($id);
        if ($mental) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Penyakit Mental berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Penyakit Mental gagal dihapus!'
            ]);
        }
    }
}