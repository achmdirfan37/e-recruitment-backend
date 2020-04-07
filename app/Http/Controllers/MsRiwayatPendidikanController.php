<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsRiwayatPendidikan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsRiwayatPendidikanController extends Controller
{
    public function index()
	{
		$ms_riwayat_pendidikan = DB::table('ms_riwayat_pendidikan')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_riwayat_pendidikan
        ], 200);
	}

	public function showDetail($id)
    {
        // get detail pengalaman kerja
		$ms_riwayat_pendidikan = MsRiwayatPendidikan::find($id);
        return response()->json($ms_riwayat_pendidikan);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_riwayat_pendidikan = DB::table('ms_riwayat_pendidikan')
		->where('rpd_nama_lembaga_pendidikan','LIKE',"%".$cari."%")
		->orwhere('rpd_tanggal_lulus', 'LIKE', "%".$cari."%") //ubah jadi tahun lulus
		->orwhere('rpd_kualifikasi', 'LIKE', "%".$cari."%")
		->orwhere('rpd_lokasi', 'LIKE', "%".$cari."%")
		->orwhere('rpd_jurusan', 'LIKE', "%".$cari."%")
		->orwhere('rpd_keterangan_prestasi', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_riwayat_pendidikan);
    }

	public function create(Request $request){

        $ms_riwayat_pendidikan = new MsRiwayatPendidikan();

        $ms_riwayat_pendidikan->rpd_nama_lembaga_pendidikan = $request->input('rpd_nama_lembaga_pendidikan');
        $ms_riwayat_pendidikan->rpd_tanggal_lulus = date('Y-m-d',strtotime($request->input('rpd_tanggal_lulus')));
        $ms_riwayat_pendidikan->rpd_kualifikasi = $request->input('rpd_kualifikasi');
        $ms_riwayat_pendidikan->rpd_lokasi = $request->input('rpd_lokasi');
        $ms_riwayat_pendidikan->rpd_jurusan = $request->input('rpd_jurusan');
        $ms_riwayat_pendidikan->rpd_keterangan_prestasi = $request->input('rpd_keterangan_prestasi');

		$ms_riwayat_pendidikan->save();

        return response()->json($ms_riwayat_pendidikan);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_riwayat_pendidikan = MsRiwayatPendidikan::find($id);
        return response()->json($ms_riwayat_pendidikan);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{

		$ms_riwayat_pendidikan = MsRiwayatPendidikan::find($id);

        $ms_riwayat_pendidikan->rpd_nama_lembaga_pendidikan = $request->input('rpd_nama_lembaga_pendidikan');
        $ms_riwayat_pendidikan->rpd_tanggal_lulus = date('Y-m-d',strtotime($request->input('rpd_tanggal_lulus')));
        $ms_riwayat_pendidikan->rpd_kualifikasi = $request->input('rpd_kualifikasi');
        $ms_riwayat_pendidikan->rpd_lokasi = $request->input('rpd_lokasi');
        $ms_riwayat_pendidikan->rpd_jurusan = $request->input('rpd_jurusan');
        $ms_riwayat_pendidikan->rpd_keterangan_prestasi = $request->input('rpd_keterangan_prestasi');


		$ms_riwayat_pendidikan->update();

        return response()->json($ms_riwayat_pendidikan);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_riwayat_pendidikan = MsRiwayatPendidikan::find($id);
        $ms_riwayat_pendidikan->delete();
        return response()->json($ms_riwayat_pendidikan);
	}

}
