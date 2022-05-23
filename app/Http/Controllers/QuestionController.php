<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\Mental;
use App\Models\Faktor;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $question = Pertanyaan::get();
        $mental = Mental::get();
        $faktor = Faktor::get();
        if ($request->ajax()) {
            return response()->json([
                'question' => $question,
                'faktor'    => $faktor
            ]);
        }
        return view('question')->with('mental', $mental);
    }

    public function getData($id)
    {
        $pertanyaan = Pertanyaan::join('faktor', 'faktor.id_faktor', '=', 'pertanyaan.id_faktor')->where('id_tes', $id)->get(['pertanyaan.*', 'faktor.nama', 'faktor.id_mental']);
        return Datatables::of($pertanyaan)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_pertanyaan.'"
                                  data-bs-target="#editQuestionModal" data-faktor="'.$row->id_mental.'" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_pertanyaan.'"
                             data-bs-target="#deleteQuestionModal" data-faktor="'.$row->id_mental.'" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function save(Request $request)
    {
        $request->validate([
            'id_tes' => 'required',
            'id_faktor' => 'required',
            'pertanyaan' => 'required',
        ]);

        $pertanyaan = Pertanyaan::create([
            'id_tes' => $request->id_tes,
            'id_faktor' => $request->id_faktor,
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
            'id_faktor' => 'required',
            'pertanyaan' => 'required',
        ]);

        $pertanyaan = Pertanyaan::where('id_pertanyaan', $request->id_pertanyaan)->update([
            'id_faktor' => $request->id_faktor,
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