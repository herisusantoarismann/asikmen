<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $mental = Mental::get();

    //         return Datatables::of($mental)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid              fa-magnifying-glass"></i></button>
    //                          <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_mental.'"
    //                              data-bs-target="#editMentalModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
    //                          <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_mental.'"
    //                         data-bs-target="#deleteMentalModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
    //                     </td>';
    //                 return $actionBtn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }
    //     return view('mental');
    // }

    public function save(Request $request)
    {
        $request->validate([
            'id_mental' => 'required',
            'id_faktor' => 'required',
            'nama' => 'required',
            'nilai' => 'required',
        ]);

        $kategori = Kategori::create([
            'id_mental' => $request->id_mental,
            'id_faktor' => $request->id_faktor,
            'nama' => $request->nama,
            'nilai' => $request->nilai,
        ]);
        if ($kategori) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Kategori berhasil disimpan!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Kategori gagal disimpan!'
            ]);
        }
    }

    // public function edit($id)
    // {
    //     $mental = Mental::where('id_mental', $id)->first();
    //     if ($mental) {
    //         return response()->json([
    //             'status' => 'Berhasil',
    //             'message' => 'Penyakit Mental berhasil diambil!',
    //             'data' => $mental
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'Gagal',
    //             'message' => 'Penyakit Mental gagal diambil!'
    //         ]);
    //     }
    // }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_mental' => 'required',
            'id_kategori' => 'required',
            'id_faktor' => 'required',
            'nama' => 'required',
            'nilai' => 'required',
        ]);

        $kategori = Kategori::where('id_kategori', $request->id_kategori)->update([
            'id_mental' => $request->id_mental,
            'id_faktor' => $request->id_faktor,
            'nama' => $request->nama,
            'nilai' => $request->nilai
        ]);
        if ($kategori) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Kategori berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Kategori gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $kategori = Kategori::where('id_faktor', $id)->delete();
        if ($kategori) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Kategori berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Kategori gagal dihapus!'
            ]);
        }
    }
}