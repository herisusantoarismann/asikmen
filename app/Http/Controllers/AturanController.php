<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faktor;
use App\Models\Mental;
use App\Models\Kategori;
use App\Models\Aturan;
use Yajra\DataTables\DataTables;

class AturanController extends Controller
{
    public function index()
    {
        $mental = Mental::get();
        
        return view('aturan')->with('mental', $mental);
    }

    public function getData($id)
    {
        $aturan = Aturan::where('id_mental', $id)->get();
        $kategori = Kategori::where('id_mental', $id)->get();
        foreach ($aturan as $a) {
            $rule = explode(',', $a->aturan);
            $data = "";
            foreach ($kategori as $k) {
                for ($i = 0; $i < count($rule); $i++) {
                    if ($k->id_kategori == $rule[$i]) {
                        if ($i == (count($rule)-1)) {
                            $data .= $k->nama;
                        } else {
                            $data .= $k->nama.'-';
                        }
                    }
                }
            }
            $a->rule = $data;
        }
        return Datatables::of($aturan)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_aturan.'" data-id-mental=
                             "'.$row->id_mental.'"
                                 data-bs-target="#editAturanModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_aturan.'" 
                            data-bs-target="#deleteAturanModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getKategori($id)
    {
        $kategori = Kategori::where('id_mental', $id)->get()->groupBy('id_faktor');

        return response()->json([
            'kategori'  =>  $kategori
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_mental' => 'required',
            'aturan' => 'required',
            'hasil' => 'required',
        ]);

        $aturan = Aturan::create([
            'id_mental' => $request->id_mental,
            'aturan' => $request->aturan,
            'hasil' => $request->hasil,
        ]);
        if ($aturan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Aturan berhasil disimpan!',
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Aturan gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $aturan = Aturan::where('id_aturan', $id)->first();
        if ($aturan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Aturan berhasil diambil!',
                'aturan' => $aturan
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Aturan gagal diambil!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_aturan' => 'required',
            'aturan' => 'required',
            'hasil' => 'required',
        ]);

        $aturan = Aturan::where('id_aturan', $request->id_aturan)->update([
            'aturan' => $request->aturan,
            'hasil' => $request->hasil,
        ]);
        if ($aturan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Aturan berhasil diubah!',
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Aturan gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $aturan = Aturan::destroy($id);
        if ($aturan) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Aturan berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Aturan gagal dihapus!'
            ]);
        }
    }
}