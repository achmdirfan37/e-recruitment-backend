<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsKeterampilan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsKeterampilanController extends Controller
{
    public function index()
	{
		$ms_keterampilan = DB::table('ms_keterampilan')->paginate(2);;

        // return response()->json([
        //     'message' => 'success',
        //     'data' => $ms_keterampilan
        // ], 200);

        // $ms_keterampilan = MsKeterampilan::paginate(5);

        return $ms_keterampilan;

	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_keterampilan = MsKeterampilan::find($id);
        return response()->json($ms_keterampilan);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_keterampilan = DB::table('ms_keterampilan')
		->where('ket_nama','LIKE',"%".$cari."%")->paginate(5);;

        return response()->json($ms_keterampilan);
    }

	public function create(Request $request){

        $ms_keterampilan = new MsKeterampilan();

        $ms_keterampilan->ket_nama = $request->input('ket_nama');
		$ms_keterampilan->ket_pelamar = 0320170004;
		//$request->input('ket_pelamar');

		$ms_keterampilan->save();

        return response()->json($ms_keterampilan);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_keterampilan = MsKeterampilan::find($id);
        return response()->json($ms_keterampilan);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{
		$ms_keterampilan = MsKeterampilan::find($id);

        $ms_keterampilan->ket_nama = $request->input('ket_nama');
		$ms_keterampilan->ket_pelamar = 0320170004;
		//$request->input('ket_pelamar');

		$ms_keterampilan->update();

        return response()->json($ms_keterampilan);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_keterampilan = MsKeterampilan::find($id);
        $ms_keterampilan->delete();
        return response()->json($ms_keterampilan);
	}

}
