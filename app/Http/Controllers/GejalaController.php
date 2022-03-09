<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gejala;
use App\Models\Faktor;
use App\Models\Mental;
use Yajra\DataTables\DataTables;

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

    public function getData($id)
    {
        $gejala = Gejala::join('faktor', 'faktor.id_faktor', '=', 'gejala.id_faktor')->where('faktor.id_mental', $id)->get(['gejala.*', 'faktor.nama AS namaFaktor', 'faktor.id_mental']);
        return Datatables::of($gejala)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_gejala.'"
                                 data-faktor="'.$row->id_mental.'" data-bs-target="#editGejalaModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_gejala.'"
                            data-faktor="'.$row->id_mental.'" data-bs-target="#deleteGejalaModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
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