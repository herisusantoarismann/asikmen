<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid              fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id.'"
                                 data-bs-target="#editUserModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id.'"
                            data-bs-target="#deleteUserModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('users');
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'level' => 'required',
            'password' => 'required|min:3|max:15|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:3|max:15'
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level,
            'password' => Hash::make($request->password)
        ]);
        if ($users) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'User berhasil disimpan!',
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'User gagal disimpan!'
            ]);
        }
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'User berhasil diambil!',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'User gagal diambil!'
            ]);
        }
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'level' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        $user = User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'level' => $request->level,
        ]);
        
        if ($user) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'User berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'User gagal diubah!'
            ]);
        }
    }

    public function delete($id)
    {
        $user = User::destroy($id);
        if ($user) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'User berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'User gagal dihapus!'
            ]);
        }
    }
}