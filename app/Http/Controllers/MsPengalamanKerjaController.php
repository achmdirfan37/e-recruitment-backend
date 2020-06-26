<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsPengalamanKerja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsPengalamanKerjaController extends Controller
{
    public function index()
	{
        $ms_pengalaman_kerja = DB::table('ms_pengalaman_kerja')->paginate(5);;

        return $ms_pengalaman_kerja;
    }
    
    public function viewflk($id)
	{
        $ms_pengalaman_kerja = MsPengalamanKerja::where( 'pkj_pelamar', '=', $id )
            ->paginate(5);
        return response()->json($ms_pengalaman_kerja);   
    }

	public function showDetail($id)
    {
        // get detail pengalaman kerja
		$ms_pengalaman_kerja = MsPengalamanKerja::find($id);
        return response()->json($ms_pengalaman_kerja);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_pengalaman_kerja = DB::table('ms_pengalaman_kerja')
		->where('pkj_nama_perusahaan','LIKE',"%".$cari."%")
		->orwhere('pkj_tanggal_mulai', 'LIKE', "%".$cari."%")
		->orwhere('pkj_tanggal_selesai', 'LIKE', "%".$cari."%")
		->orwhere('pkj_lokasi', 'LIKE', "%".$cari."%")
		->orwhere('pkj_industri', 'LIKE', "%".$cari."%")
		->orwhere('pkj_gambaran_pekerjaan', 'LIKE', "%".$cari."%")
        ->orwhere('pkj_spesialisasi', 'LIKE', "%".$cari."%")
        ->orwhere('pkj_jabatan', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_pengalaman_kerja);
    }

	public function create(Request $request){


        $ms_pengalaman_kerja = new MsPengalamanKerja();

        $ms_pengalaman_kerja->pkj_nama_perusahaan = $request->input('pkj_nama_perusahaan');
        $ms_pengalaman_kerja->pkj_tanggal_mulai = date('Y-m-d',strtotime($request->input('pkj_tanggal_mulai')));
        $ms_pengalaman_kerja->pkj_tanggal_selesai = date('Y-m-d',strtotime($request->input('pkj_tanggal_selesai')));
        $ms_pengalaman_kerja->pkj_lokasi = $request->input('pkj_lokasi');
        $ms_pengalaman_kerja->pkj_industri = $request->input('pkj_industri');
        $ms_pengalaman_kerja->pkj_gambaran_pekerjaan = $request->input('pkj_gambaran_pekerjaan');
        $ms_pengalaman_kerja->pkj_spesialisasi = $request->input('pkj_spesialisasi');
        $ms_pengalaman_kerja->pkj_bidang_kerja = $request->input('pkj_bidang_kerja');
        $ms_pengalaman_kerja->pkj_jabatan = $request->input('pkj_jabatan');

		$ms_pengalaman_kerja->save();

        return response()->json($ms_pengalaman_kerja);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_pengalaman_kerja = MsPengalamanKerja::find($id);
        return response()->json($ms_pengalaman_kerja);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{

		$ms_pengalaman_kerja = MsPengalamanKerja::find($id);

        $ms_pengalaman_kerja->pkj_nama_perusahaan = $request->input('pkj_nama_perusahaan');
        $ms_pengalaman_kerja->pkj_tanggal_mulai = date('Y-m-d',strtotime($request->input('pkj_tanggal_mulai')));
        $ms_pengalaman_kerja->pkj_tanggal_selesai = date('Y-m-d',strtotime($request->input('pkj_tanggal_selesai')));
        $ms_pengalaman_kerja->pkj_lokasi = $request->input('pkj_lokasi');
        $ms_pengalaman_kerja->pkj_industri = $request->input('pkj_industri');
        $ms_pengalaman_kerja->pkj_gambaran_pekerjaan = $request->input('pkj_gambaran_pekerjaan');
        $ms_pengalaman_kerja->pkj_spesialisasi = $request->input('pkj_spesialisasi');
        $ms_pengalaman_kerja->pkj_bidang_kerja = $request->input('pkj_bidang_kerja');
        $ms_pengalaman_kerja->pkj_jabatan = $request->input('pkj_jabatan');

		$ms_pengalaman_kerja->update();

        return response()->json($ms_pengalaman_kerja);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_pengalaman_kerja = MsPengalamanKerja::find($id);
        $ms_pengalaman_kerja->delete();
        return response()->json($ms_pengalaman_kerja);
	}

}
