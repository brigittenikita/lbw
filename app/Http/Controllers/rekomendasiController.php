<?php

namespace App\Http\Controllers;

use App\Models\matakuliah;
use App\Models\statusmk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class rekomendasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = file_get_contents("https://ftisunpar.github.io/data/prasyarat.json");
        $parsedata = json_decode($data);
        $listsMata = matakuliah::get();

        $id = Auth::user()->id;
        $nama = Auth::user()->name;
        $semester = (Auth::user()->semester + 1);

        $record = statusmk::where(['fkUser' =>  $id]);
        if (!$record->exists()) {
            $listsRekomendasi1 = matakuliah::paginate(18);

            // 
            $i = 0;
            $total = 0;
            foreach ($listsRekomendasi1 as $lis) {
                $total = $total + $lis->sks;
                $i = $i + 1;
                if ($total > 18) {
                    $i = $i - 1;
                    break;
                } else if ($total == 18) {
                    break;
                }
            }
            $list = array(array());
            $list1 = array(array());
            $listt = array(array());
            $listsTempuh = matakuliah::join('statusmks', 'statusmks.fkMata', '=', 'matakuliahs.idMata')->where('statusmks.fkUser', '=', $id)->where('statusmks.status', '=', 'lulus')->get();

            $listsRekomendasi = matakuliah::paginate($i);

            return view('rekomendasi', compact('listsMata', 'record', 'list', 'list1', 'listsTempuh', 'listt', 'semester', 'nama', 'id', 'listsRekomendasi'));
        } else {
            $listsRekomendasi = matakuliah::join('statusmks', 'statusmks.fkMata', '=', 'matakuliahs.idMata')->where('statusmks.fkUser', '=', $id)->where('statusmks.status', '=', 'lulus')->get();
            $listsTempuh = matakuliah::join('statusmks', 'statusmks.fkMata', '=', 'matakuliahs.idMata')->where('statusmks.fkUser', '=', $id)->get();
            $listsLulus = matakuliah::join('statusmks', 'statusmks.fkMata', '=', 'matakuliahs.idMata')->where('statusmks.fkUser', '=', $id)->where('statusmks.status', '=', 'lulus')->get();
            $listsKosong = matakuliah::join('statusmks', 'statusmks.fkMata', '=', 'matakuliahs.idMata')->where('statusmks.fkUser', '=', $id)->where('statusmks.status', '=', 'tidak')->get();
            $listLeft = matakuliah::leftJoin("statusmks", 'statusmks.fkMata', '=', 'matakuliahs.idMata')->get();

            $l = "lulus";
            $record1 = statusmk::where(['fkUser' =>  $id, 'status' => $l]);

            $listt = array(array());
            $j = 0;

            for ($i = 0; $i < count($parsedata); $i++) {

                foreach ($listsRekomendasi as $dat) {
                    $se = 2;
                    if ($parsedata[$i]->nama != $dat['namaMataKuliah'] || ($dat['status'] == "tidak")) {
                        $bol = "false";

                        foreach ($listsRekomendasi as $dat1) {
                            if ($dat1['namaMataKuliah'] == $parsedata[$i]->nama and $dat1['status'] == "lulus") {
                                $bol = "true";

                                break;
                            }
                        }

                        if ($bol == "false") {

                            $listt[$j][0] = $parsedata[$i]->nama;
                            $listt[$j][1] = $parsedata[$i]->semester;
                            $listt[$j][2] = $parsedata[$i]->sks;
                            if ($parsedata[$i]->wajib == "true") {
                                $listt[$j][3] = "Wajib";
                            } else {
                                $listt[$j][3] = "Pilihan";
                            }
                            $j = $j + 1;
                            break;
                        }
                    }
                }
            }


            // cek syarat
            if ($record1->exists()) {
                $list1 = array(array());
                $j = 0;
                // echo (count($listt));
                for ($i = 0; $i < count($listt); $i++) {
                    if (count($listt) == 0) {
                        break;
                    }
                    if ($listt[$i][1] <= $semester || $listt[$i][3] == "Pilihan") {
                        $list1[$j][0] = $listt[$i][0];
                        $list1[$j][1] = $listt[$i][1];
                        $list1[$j][2] = $listt[$i][2];
                        $list1[$j][3] = $listt[$i][3];
                        $j = $j + 1;
                    }
                }

                $list = array(array());
                $index = 0;
                $m = 0;

                $length = count($list1);


                for ($i = 0; $i < count($list1); $i++) {

                    for ($j = 0; $j < count($parsedata); $j++) {
                        if ($list1[$i][0] === $parsedata[$j]->nama) {
                            $count = count($parsedata[$j]->prasyarat->tempuh);
                            $countLulus = count($parsedata[$j]->prasyarat->lulus);
                            $countBersamaan = count($parsedata[$j]->prasyarat->bersamaan);
                            // echo ($list1[$i][0] . " =" .  $parsedata[$j]->nama);
                            // echo (" tempuh= " . $count . " ,lulus= " . $countLulus . " , bersamaan= " . $countBersamaan);
                            // echo ('<br>');


                            $resLulus = "false";
                            $res = "false";

                            if ($count == 0 and $countLulus == 0 and $countBersamaan == 0) {
                                $list[$m][0] = $list1[$i][0];
                                $list[$m][1] = $list1[$i][1];
                                $list[$m][2] = $list1[$i][2];
                                $list[$m][3] = $list1[$i][3];
                                $m = $m + 1;
                            } else {

                                if ($count == 0) {
                                    $res = "true";
                                } else {
                                    $totalTempuh = 0;
                                    foreach ($parsedata[$j]->prasyarat->tempuh as $syarat) {
                                        foreach ($listsTempuh as $tempuh) {
                                            if ($tempuh['kode'] == $syarat) {
                                                $totalTempuh = $totalTempuh + 1;
                                                break;
                                            }
                                        }
                                    }


                                    if ($totalTempuh == $count) {
                                        $res = "true";
                                    }
                                    // echo ($totalTempuh . " =TEMPUH =" . $count . "-> " . $res);
                                }

                                if ($countLulus == 0) {
                                    $resLulus = "true";
                                } else {
                                    $totalLulus = 0;
                                    foreach ($parsedata[$j]->prasyarat->lulus as $syarat) {
                                        foreach ($listsRekomendasi as $lulus) {
                                            // echo ($syarat);
                                            if ($lulus['kode'] == $syarat) {
                                                $totalLulus = $totalLulus + 1;
                                                break;
                                            }
                                        }
                                    }

                                    if ($totalLulus == $countLulus) {
                                        $resLulus = "true";
                                    }
                                    // echo ($totalLulus . " =LULUS =" . $countLulus . "-> " . $resLulus);
                                }



                                if ($res == "true" and $resLulus == "true") {

                                    $list[$m][0] = $list1[$i][0];
                                    $list[$m][1] = $list1[$i][1];
                                    $list[$m][2] = $list1[$i][2];
                                    $list[$m][3] = $list1[$i][3];
                                    $m = $m + 1;
                                }
                            }
                        }
                    }
                }

                $listFilter = array(array());
                $statusSemester = "genap";
                if ($semester % 2 == 0) {
                    $statusSemester = "genap";
                } else {
                    $statusSemester = "ganjil";
                }
                $t = 0;
                if ($statusSemester == "ganjil") {
                    for ($i = 0; $i < count($list); $i++) {
                        // echo ($statusSemester);
                        if ($list[$i][1] % 2 != 0) {
                            $listFilter[$t][0] = $list[$i][0];
                            $listFilter[$t][1] = $list[$i][1];
                            $listFilter[$t][2] = $list[$i][2];
                            $listFilter[$t][3] = $list[$i][3];
                            $t = $t + 1;
                        }
                    }
                } else if ($statusSemester == "genap") {
                    for ($i = 0; $i < count($list); $i++) {
                        // echo ($statusSemester);

                        if ($list[$i][1] % 2 == 0) {
                            $listFilter[$t][0] = $list[$i][0];
                            $listFilter[$t][1] = $list[$i][1];
                            $listFilter[$t][2] = $list[$i][2];
                            $listFilter[$t][3] = $list[$i][3];
                            $t = $t + 1;
                        }
                    }
                }
                return view('rekomendasi', compact('listsLulus', 'record', 'record1', 'listsTempuh', 'nama', 'listsMata', 'listFilter', 'semester', 'id', 'listt', 'list1', 'list', 'listsRekomendasi'));
            } else {
                $listt = array(array());
                $t = 0;
                foreach ($listLeft as $left) {
                    if ($left['status'] != "lulus") {

                        $listt[$t][0] = $left['namaMataKuliah'];
                        $listt[$t][1] = $left['semester'];
                        $listt[$t][2] = $left['sks'];
                        $listt[$t][3] = $left['keterangan'];
                        $t = $t + 1;
                    }
                }
                // 
                $list1 = array(array());
                $j = 0;
                // echo (count($listt));
                for ($i = 0; $i < count($listt); $i++) {
                    if (count($listt) == 0) {
                        break;
                    }
                    if ($listt[$i][1] <= $semester || $listt[$i][3] == "Pilihan") {
                        $list1[$j][0] = $listt[$i][0];
                        $list1[$j][1] = $listt[$i][1];
                        $list1[$j][2] = $listt[$i][2];
                        $list1[$j][3] = $listt[$i][3];
                        $j = $j + 1;
                    }
                }

                $list = array(array());
                $index = 0;
                $m = 0;

                $length = count($list1);


                for ($i = 0; $i < count($list1); $i++) {

                    for ($j = 0; $j < count($parsedata); $j++) {
                        if ($list1[$i][0] === $parsedata[$j]->nama) {
                            $count = count($parsedata[$j]->prasyarat->tempuh);
                            $countLulus = count($parsedata[$j]->prasyarat->lulus);
                            $countBersamaan = count($parsedata[$j]->prasyarat->bersamaan);
                            // echo ($list1[$i][0] . " =" .  $parsedata[$j]->nama);
                            // echo (" tempuh= " . $count . " ,lulus= " . $countLulus . " , bersamaan= " . $countBersamaan);
                            // echo ('<br>');


                            $resLulus = "false";
                            $res = "false";

                            if ($count == 0 and $countLulus == 0 and $countBersamaan == 0) {
                                $list[$m][0] = $list1[$i][0];
                                $list[$m][1] = $list1[$i][1];
                                $list[$m][2] = $list1[$i][2];
                                $list[$m][3] = $list1[$i][3];
                                $m = $m + 1;
                            } else {

                                if ($count == 0) {
                                    $res = "true";
                                } else {
                                    $totalTempuh = 0;
                                    foreach ($parsedata[$j]->prasyarat->tempuh as $syarat) {
                                        foreach ($listsTempuh as $tempuh) {
                                            if ($tempuh['kode'] == $syarat) {
                                                $totalTempuh = $totalTempuh + 1;
                                                break;
                                            }
                                        }
                                    }


                                    if ($totalTempuh == $count) {
                                        $res = "true";
                                    }
                                    // echo ($totalTempuh . " =TEMPUH =" . $count . "-> " . $res);
                                }

                                if ($countLulus == 0) {
                                    $resLulus = "true";
                                } else {
                                    $totalLulus = 0;
                                    foreach ($parsedata[$j]->prasyarat->lulus as $syarat) {
                                        foreach ($listsRekomendasi as $lulus) {
                                            // echo ($syarat);
                                            if ($lulus['kode'] == $syarat) {
                                                $totalLulus = $totalLulus + 1;
                                                break;
                                            }
                                        }
                                    }

                                    if ($totalLulus == $countLulus) {
                                        $resLulus = "true";
                                    }
                                    // echo ($totalLulus . " =LULUS =" . $countLulus . "-> " . $resLulus);
                                }



                                if ($res == "true" and $resLulus == "true") {

                                    $list[$m][0] = $list1[$i][0];
                                    $list[$m][1] = $list1[$i][1];
                                    $list[$m][2] = $list1[$i][2];
                                    $list[$m][3] = $list1[$i][3];
                                    echo ($list[$m][0] . " " . $list[$m][3] = $list1[$i][3]);
                                    $m = $m + 1;
                                }
                            }
                        }
                    }
                }

                $listFilter = array(array());
                $statusSemester = "genap";
                if ($semester % 2 == 0) {
                    $statusSemester = "genap";
                } else {
                    $statusSemester = "ganjil";
                }
                $t = 0;
                if ($statusSemester == "genap") {
                    for ($i = 0; $i < count($list); $i++) {

                        if ($list[$i][1] % 2 == 0 && $list[$i][1] <= $semester || $list[$i][1] % 2 == 0 && $list[$i][3] == "Pilihan") {
                            $listFilter[$t][0] = $list[$i][0];
                            $listFilter[$t][1] = $list[$i][1];
                            $listFilter[$t][2] = $list[$i][2];
                            $listFilter[$t][3] = $list[$i][3];
                            $t = $t + 1;
                        }
                    }
                } else {
                    for ($i = 0; $i < count($list); $i++) {

                        if ($list[$i][1] % 2 != 0 && $list[$i][1] <= $semester || $list[$i][1] % 2 != 0 && $list[$i][3] == "Pilihan") {
                            $listFilter[$t][0] = $list[$i][0];
                            $listFilter[$t][1] = $list[$i][1];
                            $listFilter[$t][2] = $list[$i][2];
                            $listFilter[$t][3] = $list[$i][3];
                            $t = $t + 1;
                        }
                    }
                }
                // 


                return view('rekomendasi', compact('listsLulus', 'record', 'record1', 'listsTempuh', 'nama', 'listFilter', 'listsMata', 'semester', 'id', 'list1', 'list', 'listt', 'listsRekomendasi'));
            }



            // return view('rekomendasi', compact('listsLulus', 'record', 'listsTempuh', 'nama', 'listsMata', 'listFilter', 'semester', 'id', 'listt', 'list1', 'list', 'listsRekomendasi'));
        }
    }



    public function store(Request $request)
    {
        $rules = [
            'fkMata' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('rekomendasi.index')->with('status', 'fails')
                ->withInput()
                ->withErrors($validator);
        } else {
            $data = $request->input();
            try {
                $record = statusmk::where(['fkMata' =>  $data['fkMata']]);
                if ($record->exists()) {
                    $input = $request->except('fkMata', 'fkUser', '_token', '_method');
                    $karr = statusmk::where('fkMata', $data['fkMata']);
                    $karr->update($input);
                } else {
                    $mata = new statusmk();
                    $id = Auth::user()->id;

                    $mata->status = $data['status'];
                    $mata->fkMata = $data['fkMata'];
                    $mata->fkUser = $id;
                    $mata->save();
                }





                // toast('data berhasi di tambahkan');
                // Alert::success('SuccessAlert', 'Tambah Kota');

                return redirect()->route('rekomendasi.index')->with('status', 'Insert successfully');
            } catch (Exception $e) {
                return redirect()->route('rekomendasi.index')->with('status', 'operation failed');
            }
        }
    }
}
// if ($semester % 2 == 0) {
            //     for ($i = 0; $i < count($parsedata); $i++) {

            //         foreach ($listsRekomendasi as $dat) {
            //             $se = 2;
            //             if ($parsedata[$i]->nama != $dat['namaMataKuliah'] || ($dat['status'] == "tidak")) {
            //                 if ($parsedata[$i]->semester == $se || $parsedata[$i]->semester == ($se + 2) || $parsedata[$i]->semester == ($se + 4) || $parsedata[$i]->semester == ($se + 6)) {
            //                     $bol = "false";

            //                     foreach ($listsRekomendasi as $dat1) {
            //                         if ($dat1['namaMataKuliah'] == $parsedata[$i]->nama and $dat1['status'] == "lulus") {
            //                             $bol = "true";

            //                             break;
            //                         }
            //                     }

            //                     if ($bol == "false") {

            //                         $listt[$j][0] = $parsedata[$i]->nama;
            //                         $listt[$j][1] = $parsedata[$i]->semester;
            //                         $listt[$j][2] = $parsedata[$i]->sks;
            //                         $listt[$j][3] = $parsedata[$i]->kode;
            //                         $j = $j + 1;
            //                         break;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // } else {
            //     for ($i = 0; $i < count($parsedata); $i++) {

            //         foreach ($listsRekomendasi as $dat) {
            //             $se = 1;
            //             if ($parsedata[$i]->nama != $dat['namaMataKuliah']) {
            //                 if ($parsedata[$i]->semester == $se || $parsedata[$i]->semester == ($se + 2) || $parsedata[$i]->semester == ($se + 4) || $parsedata[$i]->semester == ($se + 6)) {
            //                     $bol = "false";

            //                     foreach ($listsRekomendasi as $dat1) {
            //                         if ($dat1['namaMataKuliah'] == $parsedata[$i]->nama) {
            //                             $bol = "true";

            //                             break;
            //                         }
            //                     }

            //                     if ($bol == "false") {

            //                         $listt[$j][0] = $parsedata[$i]->nama;
            //                         $listt[$j][1] = $parsedata[$i]->semester;
            //                         $listt[$j][2] = $parsedata[$i]->sks;
            //                         $listt[$j][3] = $parsedata[$i]->kode;
            //                         $j = $j + 1;
            //                         break;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // }