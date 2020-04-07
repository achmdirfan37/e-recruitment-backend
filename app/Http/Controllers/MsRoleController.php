<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsRole;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsRoleController extends Controller
{
    public function index()
	{
		$ms_role = DB::table('ms_role')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_role
        ], 200);
 
	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_role = MsRole::find($id);
        return response()->json($ms_role);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_role = DB::table('ms_role')
		->where('rol_username','LIKE',"%".$cari."%")
		->orwhere('rol_nama_lengkap', 'LIKE', "%".$cari."%")
		->orwhere('rol_perusahaan', 'LIKE', "%".$cari."%")->get();
		
        return response()->json($ms_role);
    }

	public function create(Request $request){
		
        $ms_role = new MsRole();

        $ms_role->rol_username = $request->input('rol_username');
        $ms_role->rol_password = $request->input('rol_password');
		$ms_role->rol_nama_lengkap = $request->input('rol_nama_lengkap');
        $ms_role->rol_perusahaan = $request->input('rol_perusahaan');
        $ms_role->rol_email = $request->input('rol_email');
        $ms_role->rol_no_telepon = $request->input('rol_no_telepon');
        $ms_role->rol_status_aktif = "Aktif";
		$ms_role->created_by = $request->input('created_by');
		
		$ms_role->save();
	
        return response()->json($ms_role);
    }
 
	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_role = MsRole::find($id);
        return response()->json($ms_role);
	}
 
	// update data pelamar
	public function update(Request $request, $id)
	{
		//http://127.0.0.1:8000/api/ms_pelamar/create?pel_nama_lengkap=Dihan Kaniro&pel_email=dihankaniro@gmail.com&pel_password=9876&pel_jenis_kelamin=Perempuan&pel_no_telepon=081347576890&cari=S2&created_by=1&pel_no_ktp=0320170021&pel_tanggal_lahir=10-15-1999&pel_tempat_lahir=Jakarta&pel_gaji_diharapkan=7500000&pel_umur=20&pel_alamat=Jakarta Barat&pel_tinggi_badan=162&pel_berat_badan=60&pel_pendidikan_terakhir=S2
		$ms_role = MsRole::find($id);

        $ms_role->rol_username = $request->input('rol_username');
		$ms_role->rol_password = $request->input('rol_password');
        $ms_role->rol_nama_lengkap = $request->input('rol_nama_lengkap');
        $ms_role->rol_perusahaan = $request->input('rol_perusahaan');
        $ms_role->rol_email = $request->input('rol_email');
        $ms_role->rol_no_telepon = $request->input('rol_no_telepon');
        $ms_role->rol_status_aktif = $request->input('rol_status_aktif');
		$ms_role->updated_by = $request->input('updated_by');
		
		$ms_role->update();
		
        return response()->json($ms_role);
	}
 
	// method untuk hapus data pelamar
	public function delete($id){
        $ms_role = MsRole::find($id);
        $ms_role->delete();
        return response()->json($ms_role);
	}
	
}