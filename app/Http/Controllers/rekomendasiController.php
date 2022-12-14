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
        $id = Auth::user()->id;
        $semester = (Auth::user()->semester) + 1;

        $record = statusmk::where(['fkUser' =>  $id]);
        if (!$record->exists()) {
            $listsRekomendasi1 = matakuliah::paginate(18);

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
            $listsRekomendasi = matakuliah::paginate($i);
        } else {
            $listsRekomendasi = matakuliah::where([
                ['semester', '=', "2"]
            ])->get();
        }
        // $listsRekomendasi = matakuliah::get();
        // Product::join('product_images', 'product_images.product_id', '=', 'products.id')
        //     ->join('categories', 'categories.id', '=', 'products.category_id')
        //     ->where('categories.id', $id)
        //     ->get();
        $listsMata = matakuliah::get();
        return view('rekomendasi', compact('listsMata', 'semester', 'id',  'listsRekomendasi'));
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
