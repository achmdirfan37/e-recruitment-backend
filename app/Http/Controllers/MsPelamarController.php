<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsPelamar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsPelamarController extends Controller
{
    public function index()
	{
		// $ms_pelamar = DB::table('ms_pelamar')->get();

        // return response()->json([
        //     'message' => 'success',
        //     'data' => $ms_pelamar
        // ], 200);


		$ms_pelamar = MsPelamar::paginate(5);

        return $ms_pelamar;

	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_pelamar = MsPelamar::find($id);
        return response()->json($ms_pelamar);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_pelamar = DB::table('ms_pelamar')
		->where('pel_nama_lengkap','LIKE',"%".$cari."%")
		->orwhere('pel_jenis_kelamin', 'LIKE', "%".$cari."%")
		->orwhere('pel_gaji_diharapkan', 'LIKE', "%".$cari."%")
		->orwhere('pel_no_ktp', 'LIKE', "%".$cari."%")
		->orwhere('pel_umur', 'LIKE', "%".$cari."%")
		->orwhere('pel_pendidikan_terakhir', 'LIKE', "%".$cari."%")
		->orwhere('pel_email', 'LIKE', "%".$cari."%")->paginate(5);;

        return response()->json($ms_pelamar);
    }

	public function create(Request $request){

        $ms_pelamar = new MsPelamar();

        $ms_pelamar->pel_email = $request->input('pel_email');
        $ms_pelamar->pel_password = $request->input('pel_password');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $request->input('pel_nama_lengkap');
        $ms_pelamar->pel_jenis_kelamin = $request->input('pel_jenis_kelamin');
        $ms_pelamar->pel_tempat_lahir = $request->input('pel_tempat_lahir');
        $ms_pelamar->pel_tanggal_lahir = $request->input('pel_tanggal_lahir');
        $ms_pelamar->pel_no_telepon = $request->input('pel_no_telepon');
        $ms_pelamar->pel_alamat = $request->input('pel_alamat');
        $ms_pelamar->pel_tinggi_badan = $request->input('pel_tinggi_badan');
        $ms_pelamar->pel_berat_badan = $request->input('pel_berat_badan');
        $ms_pelamar->pel_gaji_diharapkan = $request->input('pel_gaji_diharapkan');
        $ms_pelamar->pel_jabatan_dicari = $request->input('pel_jabatan_dicari');
        $ms_pelamar->pel_status_aktif = "Aktif";
        $ms_pelamar->pel_umur = $request->input('pel_umur');
        $ms_pelamar->pel_pendidikan_terakhir = $request->input('pel_pendidikan_terakhir');
		$ms_pelamar->created_by = $request->input('created_by');

		// if($request->hasfile('pel_foto')){
        //     $file = $request->file('pel_foto');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/', $filename);
        //     $ms_pelamar->pel_foto = $filename;
        // }else{
        //     return $request;
        //     $ms_pelamar->pel_foto = '';
		// }

		$ms_pelamar->save();

        return response()->json($ms_pelamar);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_pelamar = MsPelamar::find($id);
        return response()->json($ms_pelamar);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{
		//http://127.0.0.1:8000/api/ms_pelamar/create?pel_nama_lengkap=Dihan Kaniro&pel_email=dihankaniro@gmail.com&pel_password=9876&pel_jenis_kelamin=Perempuan&pel_no_telepon=081347576890&cari=S2&created_by=1&pel_no_ktp=0320170021&pel_tanggal_lahir=10-15-1999&pel_tempat_lahir=Jakarta&pel_gaji_diharapkan=7500000&pel_umur=20&pel_alamat=Jakarta Barat&pel_tinggi_badan=162&pel_berat_badan=60&pel_pendidikan_terakhir=S2
		// $ms_pelamar = MsPelamar::find($id);

		// if($request->hasfile('pel_foto')){
        //     $file = $request->file('pel_foto');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/', $filename);
        //     $ms_pelamar->pel_foto = $filename;
        // }else{
        //     return $request;
        //     $ms_pelamar->pel_foto = '';
		// }

        // $ms_pelamar = MsPelamar::find($id)->update([
        //     'pel_nama_lengkap' => $request->pel_nama_lengkap,
        //     'pel_email' => $request->pel_email,
        //     'pel_pendidikan_terakhir' => $request->pel_pendidikan_terakhir,
        //     'pel_status_aktif' => $request->pel_status_aktif,
        //     'pel_umur' => $request->pel_umur,
        //     'pel_no_ktp' => $request->pel_no_ktp,
        //     'pel_foto' => $filename
        // ]);

		// return response()->json($ms_pelamar);

		// $ms_pelamar = new MsPelamar();

		// if($request->hasfile('pel_foto')){
        //     $file = $request->file('pel_foto');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/', $filename);
        //     $ms_pelamar->pel_foto = $filename;
        // }else{
        //     return $request;
        //     $ms_pelamar->pel_foto = '';
		// }

		// $ms_pelamar = MsPelamar::find($id)->update([
        //     'pel_nama_lengkap' => $request->pel_nama_lengkap,
		// 	'pel_email' => $request->pel_email,
        //     'pel_jenis_kelamin' => $request->pel_jenis_kelamin,
        //     'pel_no_ktp' => $request->pel_no_ktp,
		// 	'pel_alamat' => $request->pel_alamat,
		// 	'pel_tanggal_lahir' => $request->pel_tanggal_lahir,
		// 	'pel_tempat_lahir' => $request->pel_tempat_lahir,
		// 	'pel_no_telepon' => $request->pel_no_telepon,
		// 	'pel_tinggi_badan' => $request->pel_tinggi_badan,
		// 	'pel_berat_badan' => $request->pel_berat_badan,
		// 	'pel_gaji_diharapkan' => $request->pel_gaji_diharapkan,
		// 	'pel_jabatan_dicari' => $request->pel_jabatan_dicari,
		// 	'pel_status_aktif' => $request->pel_status_aktif,
		// 	'pel_umur' => $request->pel_umur,
		// 	'pel_pendidikan_terakhir' => $request->pel_pendidikan_terakhir,
		// 	'updated_by' => $request->updated_by
		// ]);

        // return response()->json($ms_pelamar);

		$ms_pelamar = MsPelamar::find($id);

        $ms_pelamar->pel_email = $request->input('pel_email');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $request->input('pel_nama_lengkap');
        $ms_pelamar->pel_jenis_kelamin = $request->input('pel_jenis_kelamin');
        $ms_pelamar->pel_tempat_lahir = $request->input('pel_tempat_lahir');
        $ms_pelamar->pel_tanggal_lahir = $request->input('pel_tanggal_lahir');
        $ms_pelamar->pel_no_telepon = $request->input('pel_no_telepon');
        $ms_pelamar->pel_alamat = $request->input('pel_alamat');
        $ms_pelamar->pel_tinggi_badan = $request->input('pel_tinggi_badan');
        $ms_pelamar->pel_berat_badan = $request->input('pel_berat_badan');
        $ms_pelamar->pel_gaji_diharapkan = $request->input('pel_gaji_diharapkan');
        $ms_pelamar->pel_jabatan_dicari = $request->input('pel_jabatan_dicari');
        $ms_pelamar->pel_status_aktif = $request->input('pel_status_aktif');
        $ms_pelamar->pel_umur = $request->input('pel_umur');
        $ms_pelamar->pel_pendidikan_terakhir = $request->input('pel_pendidikan_terakhir');
		$ms_pelamar->updated_by = $request->input('updated_by');

		if($request->hasfile('pel_foto')){
            $file = $request->file('pel_foto');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);
            $ms_pelamar->pel_foto = $filename;
        }

		$ms_pelamar->update();

        return response()->json($ms_pelamar);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_pelamar = MsPelamar::find($id);
        $ms_pelamar->delete();
        return response()->json($ms_pelamar);
	}

	public function rangeUmur(Request $request)
    {
		//manggil api
		//http://127.0.0.1:8000/api/ms_pelamar/rangeUmur?umur1=20 & umur2=21

		$umur1 = $request->umur1;
		$umur2 = $request->umur2;

		if(!empty($umur1 && $umur2 ))
		{
		$ms_pelamar = DB::table('ms_pelamar')
			->whereBetween('pel_umur', array($umur1, $umur2))
			->get();
		}
		else
		{
		$ms_pelamar = DB::table('ms_pelamar')
			->get();
		}

		return response()->json($ms_pelamar);
	}

	public function rangeGaji(Request $request)
    {
		//manggil api
		//http://127.0.0.1:8000/api/ms_pelamar/rangeGaji?gajiMin=6000000 & gajiMax=9000000

		$gajiMin = $request->gajiMin;
		$gajiMax = $request->gajiMax;

		if(!empty($gajiMin && $gajiMax ))
		{
		$ms_pelamar = DB::table('ms_pelamar')
			->whereBetween('pel_gaji_diharapkan', array($gajiMin, $gajiMax))
			->get();
		}
		else
		{
		$ms_pelamar = DB::table('ms_pelamar')
			->get();
		}

		return response()->json($ms_pelamar);
    }
}
