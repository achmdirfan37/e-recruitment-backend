<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsKeterampilan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;

class MsKeterampilanController extends Controller
{
    public function index()
	{
        $ms_keterampilan = DB::table('ms_keterampilan')->paginate(5);;
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
		$ms_keterampilan->ket_pelamar = 4;
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
		//http://127.0.0.1:8000/api/ms_pelamar/create?pel_nama_lengkap=Dihan Kaniro&pel_email=dihankaniro@gmail.com&pel_password=9876&pel_jenis_kelamin=Perempuan&pel_no_telepon=081347576890&cari=S2&created_by=1&pel_no_ktp=0320170021&pel_tanggal_lahir=10-15-1999&pel_tempat_lahir=Jakarta&pel_gaji_diharapkan=7500000&pel_umur=20&pel_alamat=Jakarta Barat&pel_tinggi_badan=162&pel_berat_badan=60&pel_pendidikan_terakhir=S2
		$ms_keterampilan = MsKeterampilan::find($id);

        $ms_keterampilan->ket_nama = $request->input('ket_nama');

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
