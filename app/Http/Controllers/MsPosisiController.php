<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MsPosisi;
use DB;

class MsPosisiController extends Controller
{
    public function index(){
		$ms_posisi = DB::table('ms_posisi')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_posisi
        ], 200);

        // $ms_posisi = MsPosisi::all();
        // return response()->json($ms_posisi);
    }
    
	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_posisi = DB::table('ms_posisi')
		->where('pos_nama','LIKE',"%".$cari."%")->paginate(5);;

        return response()->json($ms_posisi);
    }

    public function create(Request $request){
		
        $ms_posisi = new MsPosisi();

        $ms_posisi->pos_nama = $request->input('pos_nama');
        $ms_posisi->save();
	
        return response()->json($ms_posisi);
    }

    public function edit($id){
        $ms_posisi = MsPosisi::find($id);
        return response()->json($ms_posisi);
    }

    public function update(Request $request, $id){
        $ms_posisi = MsPosisi::find($id)->update([
            'pos_nama' => $request->pos_nama
        ]);
        return response()->json($ms_posisi);
    }

    public function delete($id){
        $ms_posisi = MsPosisi::find($id);
        $ms_posisi->delete();
        return response()->json($ms_posisi);
	}
	
}
