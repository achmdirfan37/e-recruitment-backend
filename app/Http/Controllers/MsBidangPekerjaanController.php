<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsBidangPekerjaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;

class MsBidangPekerjaanController extends Controller
{
    public function index()
	{
        $ms_bidang_pekerjaan = DB::table('ms_bidang_pekerjaan')->paginate(5);;
        return $ms_bidang_pekerjaan;
	}
	
	public function showDetail($id)
    {
        // get detail pelamar
		$ms_bidang_pekerjaan = MsBidangPekerjaan::find($id);
        return response()->json($ms_bidang_pekerjaan);
    }

	
    public function view()
	{
		$ms_bidang_pekerjaan = DB::table('ms_bidang_pekerjaan')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_bidang_pekerjaan
        ], 200);
	}

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_bidang_pekerjaan = DB::table('ms_bidang_pekerjaan')
		->where('bid_nama','LIKE',"%".$cari."%")->paginate(5);;

        return response()->json($ms_bidang_pekerjaan);
    }

	public function create(Request $request){

        $ms_bidang_pekerjaan = new MsBidangPekerjaan();

        $ms_bidang_pekerjaan->bid_nama = $request->input('bid_nama');
		//$request->input('ket_pelamar');

		$ms_bidang_pekerjaan->save();

        return response()->json($ms_bidang_pekerjaan);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_bidang_pekerjaan = MsBidangPekerjaan::find($id);
        return response()->json($ms_bidang_pekerjaan);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{
		$ms_bidang_pekerjaan = MsBidangPekerjaan::find($id);

        $ms_bidang_pekerjaan->bid_nama = $request->input('bid_nama');

		$ms_bidang_pekerjaan->update();

        return response()->json($ms_bidang_pekerjaan);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_bidang_pekerjaan = MsBidangPekerjaan::find($id);
        $ms_bidang_pekerjaan->delete();
        return response()->json($ms_bidang_pekerjaan);
    }

}
