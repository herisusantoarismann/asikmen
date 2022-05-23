<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faktor;
use App\Models\Mental;
use App\Models\Kategori;
use Yajra\DataTables\DataTables;

class FaktorController extends Controller
{
    public function index(Request $request)
    {
        $mental = Mental::get();
        if ($request->ajax()) {
            $faktor = Faktor::get();

            return Datatables::of($faktor)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid              fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_faktor.'"
                                 data-bs-target="#editFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_faktor.'"
                            data-bs-target="#deleteFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('factor')->with('mental', $mental);
    }

    public function getData($id)
    {
        $faktor = Faktor::where('id_mental', $id)->get();
        $i = 0;
        foreach ($faktor as $f) {
            $kategori = '';
            $kategori = Kategori::where('id_mental', $id)->where('id_faktor', $f->id_faktor)->get();
            $data = [];
            foreach ($kategori as $k) {
                array_push($data, " " . $k->nama . ':' . $k->nilai);
            }
            $f->kategori = $data;
            $i++;
        }
        return Datatables::of($faktor)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_faktor.'"
                                 data-bs-target="#editFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_faktor.'"
                            data-bs-target="#deleteFaktorModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_mental' => 'required',
            'nama' => 'required',
            'description' => 'required',
        ]);

        $faktor = Faktor::create([
            'id_mental' => $request->id_mental,
            'nama' => $request->nama,
            'description' => $request->description,
        ]);
        if ($faktor) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Faktor Mental berhasil disimpan!',
                'faktor'    => $faktor
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Faktor Mental gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $faktor = Faktor::where('id_faktor', $id)->first();
        $kategori = Kategori::where('id_faktor', $id)->get();
        if ($faktor) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Faktor berhasil diambil!',
                'data' => $faktor,
                'kategori'  => $kategori
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Faktor gagal diambil!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id_faktor' => 'required',
            'nama' => 'required',
            'description' => 'required',
        ]);

        $faktor = Faktor::where('id_faktor', $request->id_faktor)->update([
            'nama' => $request->nama,
            'description' => $request->description,
        ]);
        if ($faktor) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Faktor berhasil diubah!',
                'faktor'    => $request->id_faktor
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Faktor gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $faktor = Faktor::destroy($id);
        if ($faktor) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Faktor berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Faktor gagal dihapus!'
            ]);
        }
    }
}