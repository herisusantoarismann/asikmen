<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mental;
use Yajra\DataTables\DataTables;

class MentalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $mental = Mental::get();

            return Datatables::of($mental)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid              fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_mental.'"
                                 data-bs-target="#editMentalModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_mental.'"
                            data-bs-target="#deleteMentalModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
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