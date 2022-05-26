<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use Illuminate\Http\Request;
use App\Models\Pertanyaan;
use App\Models\User;
use App\Models\Mental;
use App\Models\Hasil;
use App\Models\Faktor;
use App\Models\Kategori;
use App\Models\Aturan;
use App\Models\Solusi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('dashboard');
        } else {
            return view('login');
        }
    }

    public function getTestResult($id)
    {
        $hasil = Hasil::join('users', 'users.id', '=', 'hasil.id_user')->join('mental', 'mental.id_mental', '=', 'hasil.id_mental')->where('hasil.id_user', $id)->get(['hasil.*', 'users.name AS userNama', 'mental.nama AS mentalNama']);

        return Datatables::of($hasil)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<td><button type="button" class="btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
                             <button type="button" class="btn btn-warning editButton" data-id="'.$row->id_hasil.'"
                                 data-bs-target="#editHasilModal" data-bs-toggle="modal"><i class="fa-solid fa-pencil"></i></button>
                             <button type="button" class="btn btn-danger deleteButton" data-id="'.$row->id_hasil.'"
                            data-bs-target="#deleteHasilModal" data-bs-toggle="modal"><i class="fa-solid fa-trash"></i></button>
                        </td>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function editHasil($id)
    {
        $hasil = Hasil::where('id_hasil', $id)->first();
        if ($hasil) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Hasil berhasil diambil!',
                'data' => $hasil
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Hasil gagal diambil!'
            ]);
        }
    }
    
    public function updateHasil(Request $request)
    {
        $request->validate([
            'id_hasil' => 'required',
            'hasil' => 'required',
        ]);

        $hasil = Hasil::where('id_hasil', $request->id_hasil)->update([
            'hasil' => $request->hasil
        ]);
        
        if ($hasil) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Hasil berhasil diubah!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Hasil gagal diubah!'
            ]);
        }
    }

    public function deleteHasil($id)
    {
        $hasil = Hasil::destroy($id);
        if ($hasil) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Hasil berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Hasil gagal dihapus!'
            ]);
        }
    }

    public function test(Request $request)
    {
        $pertanyaan = Pertanyaan::where('id_tes', $request->route('id'))->get();
        $mental = Mental::where('id_mental', $request->route('id'))->first();
        if ($request->ajax()) {
            return response()->json([
                'pertanyaan'    => $pertanyaan,
                'mental'        => $mental
            ]);
        }

        return view('test')->with('pertanyaan', $pertanyaan);
    }

    public function saveTest(Request $request)
    {
        $request->validate([
            'id_user'   => 'required',
            'id_mental'    => 'required',
            'jawaban'   => 'required',
        ]);

        $jawaban = Jawaban::create([
            'id_user'   => $request->id_user,
            'id_mental'    => $request->id_mental,
            'jawaban'   => $request->jawaban
        ]);

        if ($jawaban) {
            return response()->json([
                'status' => 'Berhasil',
                'message' => 'Jawaban berhasil disimpan!',
                'jawaban' => $jawaban->jawaban
            ]);
        } else {
            return response()->json([
                'status' => 'Gagal',
                'message' => 'Jawaban gagal disimpan!'
            ]);
        }
    }

    public function testResult(Request $request)
    {
        $jawaban = Jawaban::where('id_jawaban', $request->route('id'))->first();
        $question = Pertanyaan::where('id_tes', $jawaban->id_mental)->get();
        $faktor = Faktor::where("id_mental", $jawaban->id_mental)->get();
        $kategori = Kategori::where('id_mental', $jawaban->id_mental)->get()->groupBy('id_faktor');
        $AllKategori = Kategori::where('id_mental', $jawaban->id_mental)->get();
        $aturan = Aturan::where('id_mental', $jawaban->id_mental)->get();
        $mental = Mental::where("id_mental", $jawaban->id_mental)->first();
        $solusi = Solusi::where('id_mental', $jawaban->id_mental)->first();

        $jawaban->jawaban = trim($jawaban->jawaban, "{");
        $jawaban->jawaban = trim($jawaban->jawaban, "}");
        $arr_jawaban = explode(',', $jawaban->jawaban);
        for ($i = 0; $i < count($arr_jawaban); $i++) {
            $j[$i] = explode(':', $arr_jawaban[$i]);
        }
        $total = [];
        $faktorCount = count($faktor);
        $k = 0;
        foreach ($faktor as $f) {
            $total[$f->id_faktor] = 0;
            $k++;
            if ($k == $faktorCount) {
                $total[$f->id_faktor] = array_sum($total);
            } else {
                for ($i = 0; $i < count($question); $i++) {
                    if ($f->id_faktor == $question[$i]->id_faktor) {
                        // var_dump(filter_var($j[$i][1], FILTER_SANITIZE_NUMBER_INT));
                        // var_dump($questionCount);
                        $total[$f->id_faktor] += filter_var($j[$i][1], FILTER_SANITIZE_NUMBER_INT);
                        // $total[$f->id_faktor] += filter_var($j[$i][1], FILTER_SANITIZE_NUMBER_INT);
                    }
                }
            }
        }

        function Rendah($bawah, $x, $atas)
        {
            if ($x >= $atas) {
                return 0;
            } elseif ($x <= $atas && $x >= $bawah) {
                return ($atas - $x)/($atas - $bawah);
            } elseif ($x <= $bawah) {
                return 1;
            } else {
                return 0;
            }
        }
        
        function Sedang($bawah, $x, $atas)
        {
            if ($x >= $bawah && $x > $atas) {
                return 0;
            } elseif ($x <= $atas && $x >= $bawah) {
                return ($x - $bawah)/($atas - $bawah);
            } elseif ($x >= $atas) {
                return ($atas - $x)/($atas - $bawah);
            } else {
                return 0;
            }
        }
        
        function Tinggi($bawah, $x, $atas)
        {
            if ($x <= $bawah) {
                return 0;
            } elseif ($x <= $atas && $x >= $bawah) {
                return ($x - $bawah)/($atas - $bawah);
            } elseif ($x >= $atas) {
                return 1;
            } else {
                return 0;
            }
        }

        function ResultRendah($bawah, $alpa, $atas)
        {
            if ($alpa == 0) {
                return 0;
            } elseif ($alpa == 1) {
                return 1;
            } else {
                return $atas - (($atas-$bawah) * $alpa);
            }
        }
        
        function ResultSedang()
        {
        }
        
        function ResultTinggi($bawah, $alpa, $atas)
        {
            if ($alpa == 0) {
                return 0;
            } elseif ($alpa == 1) {
                return 1;
            } else {
                return $bawah + (($atas-$bawah) * $alpa);
            }
        }

        // function checkArray($x, $arr)
        // {
        //     in_array()
        // }

        $result = [];
        foreach ($kategori as $k) {
            $bawah = 0;
            $tengah = 0;
            $atas = 0;
            for ($i = 0; $i < count($k); $i++) {
                if (count($k) % 2 === 0) {
                    $bawah = $k[0]->nilai;
                    $atas = $k[count($k)-1]->nilai;
                } else {
                    $bawah = $k[0]->nilai;
                    $tengah = $k[count($k) / 2]->nilai;
                    $atas = $k[count($k)-1]->nilai;
                }
                // var_dump($total[$k[0]->id_faktor]);
                if ($k[$i]->nama == "Rendah") {
                    $result[$k[0]->id_faktor][$k[$i]->nama] = Rendah($bawah, $total[$k[0]->id_faktor], $atas);
                } elseif ($k[$i]->nama == "Sedang") {
                    $result[$k[0]->id_faktor][$k[$i]->nama] = Sedang($bawah, $total[$k[0]->id_faktor], $atas);
                } elseif ($k[$i]->nama == "Tinggi") {
                    $result[$k[0]->id_faktor][$k[$i]->nama] = Tinggi($bawah, $total[$k[0]->id_faktor], $atas);
                }
                // var_dump($bawah);
                // var_dump($atas);
                // if ($i == (count($k)-1)) {
                //     unset($result[$k[0]->id_faktor]);
                // }
            }
        }

        $resultRules = [];
        foreach ($aturan as $a) {
            $rules = explode(',', $a->aturan);
            $temp = [];
            foreach ($rules as $rule) {
                foreach ($AllKategori as $k) {
                    if ($k->id_kategori == $rule) {
                        array_push($temp, $result[$k->id_faktor][$k->nama]);
                        // var_dump($result[$k->id_faktor][$k->nama]);
                    }
                }
            }
            // var_dump($a->hasil);
            // buat looping disini buat cari z1
            $idFaktor = "";
            $batas = [];
            foreach ($faktor as $f) {
                if ($f->nama == "Hasil") {
                    $idFaktor = $f->id_faktor;
                    foreach ($AllKategori as $k) {
                        if ($idFaktor == $k->id_faktor) {
                            array_push($batas, $k->nilai);
                        }
                    }
                    // var_dump($result);
                }
            }
            // var_dump($z1);
            array_pop($temp);
            $z1 = 0;
            if ($a->hasil == "Rendah") {
                $z1 = ResultRendah($batas[0], min($temp), $batas[1]);
            }
            array_push($resultRules, ['a' => min($temp), 'z' => $z1]);
        }

        $akhir = 0;
        $alpaPredikat = 0;
        foreach ($resultRules as $r) {
            $akhir += $r['a'] * $r['z'];
            $alpaPredikat += $r['a'];
        }

        $akhir = $akhir / $alpaPredikat;

        $hasil = '';
        if ($akhir <= 14) {
            $hasil = 'Rendah';
        } elseif ($akhir > 14 && $akhir <= 30) {
            $hasil = 'Sedang';
        } else {
            $hasil = 'Tinggi';
        }

        // foreach ($faktor as $f) {
        //     $i = 0;
        //     $bawah = 0;
        //     $atas = 0;
        //     $hasil = 0;
        //     $rules = [];
        //     foreach ($kategori as $k) {
        //         var_dump($i);
        //     }
        //     foreach ($aturan as $a) {
        //         if ($i <= 0) {
        //             $bawah = 0;
        //         } else {
        //             $bawah = $kategori[$i-1]->nilai;
        //         }
        //         if ($i >= count($aturan)-1) {
        //             $atas = 0;
        //         } else {
        //             $atas = $kategori[$i+1]->nilai;
        //         };
        //         $rules = explode(',', $aturan[$i]->aturan);
        //         var_dump($rules);
        //         // var_dump($rules);
        //         // var_dump(array_filter($rules, function ($item) {
        //         //     return $item == 31;
        //         // }));
        //         $i++;
        //     }
        // }
        
        $solusi->syarat = trim($solusi->syarat, "{");
        $solusi->syarat = trim($solusi->syarat, "}");
        $arrSolusi = explode(',', $solusi->syarat);
        $resultSolusi = explode(',', $solusi->solusi);
        for ($i = 0; $i < count($arr_jawaban); $i++) {
            // var_dump(explode(':', $arr_jawaban[$i])[0]);
            $temp1 = explode(':', $arr_jawaban[$i]);
            for ($j = 0; $j < count($arrSolusi); $j++) {
                $temp2 = explode(':', $arrSolusi[$j]);
                if ($temp1[0] == $temp2[0] && (int)filter_var($temp1[1], FILTER_SANITIZE_NUMBER_INT) > (int)filter_var($temp2[1], FILTER_SANITIZE_NUMBER_INT)) {
                    $temp3 = str_replace('"', '', substr($temp2[1], strpos($temp2[1], ".") + 1));
                    array_push($resultSolusi, $temp3);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'question'      => $question,
                'hasil'   => explode(',', $jawaban->jawaban),
                'solusi'=> $hasil
            ]);
        }
        $data = [
            'id'    => $request->route('id'),
            'hasil' => $hasil,
            'name'  => $mental->nama,
            'solusi'=> $resultSolusi
        ];

        return view('testResult')->with("data", $data);
    }

    public function profile()
    {
        return view('profile');
    }

    public function editProfile($id)
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

    public function updateProfile(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'email' => 'required',
            'name' => 'required',
            'new_password' => 'min:3|max:15|same:password_confirmation|nullable',
            'password_confirmation' => 'min:3|max:15|nullable'
        ]);

        if (!is_null($request->old_password) && !is_null($request->new_password)) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->old_password])) {
                $user = User::where('id', $request->id_user)->update([
                    'email' => $request->email,
                    'name' => $request->name,
                    'password' => Hash::make($request->new_password)
                ]);
                return response()->json([
                    'status' => 'Berhasil',
                    'message' => 'User berhasil diubah!',
                ]);
            } else {
                return response()->json([
                    'status' => 'Gagal',
                    'message' => 'Masukkan data User dengan benar!'
                ]);
            }
        } else {
            $user = User::where('id', $request->id_user)->update([
                'email' => $request->email,
                'name' => $request->name
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
    }

    public function home()
    {
        return view('landing');
    }

    public function about()
    {
        return view('about');
    }
}