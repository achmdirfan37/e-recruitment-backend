<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsLowongan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsLowonganController extends Controller
{
    public function index()
	{
        $ms_lowongan = DB::table('ms_lowongan')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('ms_lowongan.id', 'ms_lowongan.low_judul', 'ms_lowongan.low_kualifikasi', 'ms_lowongan.low_gaji', 'ms_lowongan.low_tanggal_ditutup', 'ms_posisi.pos_nama')
        ->paginate(5);
        return response()->json($ms_lowongan);
	}

	public function showDetail($id)
    {
        // // get detail pengalaman kerja
		$ms_lowongan = MsLowongan::find($id);
        return response()->json($ms_lowongan);
        
        // get detail pengalaman kerja
        // $ms_lowongan = DB::table('ms_lowongan')
        // ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        // ->join('ms_perusahaan', 'ms_lowongan.low_perusahaan', '=', 'ms_perusahaan.id')
        // ->select('ms_lowongan.id', 'ms_lowongan.low_judul', 'ms_lowongan.low_kualifikasi', 'ms_lowongan.low_gaji', 'ms_lowongan.low_tanggal_ditutup', 'ms_lowongan.low_perusahaan', 'ms_perusahaan.per_nama', 'ms_posisi.pos_nama')
        // ->where( 'ms_lowongan.id', '=', $id )
        // ->paginate(5);
        
        return response()->json($ms_lowongan);
    }

    public function showLowonganbyPerusahaan($id)
    {
        $ms_lowongan = DB::table('ms_lowongan')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('ms_lowongan.id', 'ms_lowongan.low_judul', 'ms_lowongan.low_kualifikasi', 'ms_lowongan.low_gaji', 'ms_lowongan.low_tanggal_ditutup', 'ms_posisi.pos_nama')
        ->where( 'ms_lowongan.low_perusahaan', '=', $id )
        ->where( 'ms_lowongan.low_status_aktif', '=', 'Aktif' )
        ->paginate(5);

        return response()->json($ms_lowongan);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
        $ms_lowongan = DB::table('ms_lowongan')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('ms_lowongan.id', 'ms_lowongan.low_judul', 'ms_lowongan.low_kualifikasi', 'ms_lowongan.low_gaji', 'ms_lowongan.low_tanggal_ditutup', 'ms_posisi.pos_nama')
		->where('low_judul','LIKE',"%".$cari."%")
		->orwhere('low_bidang_kerja', 'LIKE', "%".$cari."%") //ubah jadi tahun lulus
		->orwhere('low_gaji', 'LIKE', "%".$cari."%")
		->orwhere('low_tanggal_ditutup', 'LIKE', "%".$cari."%")
		->orwhere('low_kualifikasi', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_lowongan);
    }

	public function create(Request $request){

        $ms_lowongan = new MsLowongan();

        $ms_lowongan->low_judul = $request->input('low_judul');
        $ms_lowongan->low_deskripsi = $request->input('low_deskripsi');
        $ms_lowongan->low_gaji = $request->input('low_gaji');
        $ms_lowongan->low_tanggal_ditutup = $request->input('low_tanggal_ditutup');
        $ms_lowongan->low_kualifikasi = $request->input('low_kualifikasi');
        $ms_lowongan->low_posisi = $request->input('low_posisi');//foreign key
        $ms_lowongan->low_perusahaan = $request->input('low_perusahaan');//foreign key
        $ms_lowongan->low_bidang_kerja = $request->input('low_bidang_kerja');//foreign key
        $ms_lowongan->low_spesialisasi = $request->input('low_spesialisasi');//foreign key
        $ms_lowongan->low_status_aktif = "Aktif";


		$ms_lowongan->save();

        return response()->json($ms_lowongan);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_lowongan = MsLowongan::find($id);
        return response()->json($ms_lowongan);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{

		$ms_lowongan = MsLowongan::find($id);

        $ms_lowongan->low_judul = $request->input('low_judul');
        $ms_lowongan->low_deskripsi = $request->input('low_deskripsi');
        $ms_lowongan->low_gaji = $request->input('low_gaji');
        $ms_lowongan->low_tanggal_ditutup = $request->input('low_tanggal_ditutup');
        $ms_lowongan->low_kualifikasi = $request->input('low_kualifikasi');
        $ms_lowongan->low_posisi = $request->input('low_posisi');//foreign keyW
        $ms_lowongan->low_perusahaan = $request->input('low_perusahaan');//foreign key
        $ms_lowongan->low_bidang_kerja = $request->input('low_bidang_kerja');//foreign key
        $ms_lowongan->low_spesialisasi = $request->input('low_spesialisasi');//foreign key
        $ms_lowongan->low_status_aktif = "Aktif";

		$ms_lowongan->update();

        return response()->json($ms_lowongan);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_lowongan = MsLowongan::find($id);
        $ms_lowongan->delete();
        return response()->json($ms_lowongan);
    }

}
