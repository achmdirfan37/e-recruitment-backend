<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsRole;
use App\MsPerusahaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;

class MsRoleController extends Controller
{
    public function index()
	{
        $ms_role = DB::table('ms_role')->paginate(5);;
        $results = DB::select( DB::raw("SELECT rol_username, rol_password, rol_nama_lengkap, rol_perusahaan,
        rol_email, rol_no_telepon, rol_status_aktif FROM ms_role "
          ));
        return $ms_role;
	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_role = MsRole::find($id);
        return response()->json($ms_role);
    }

    public function showPerusahaan()
    {
        $ms_perusahaan = DB::table('ms_perusahaan')->get();
        return response()->json([
            'message' => 'success',
            'data' => $ms_perusahaan
        ], 200);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_role = DB::table('ms_role')
		->where('rol_username','LIKE',"%".$cari."%")
		->orwhere('rol_nama_lengkap', 'LIKE', "%".$cari."%")
		->orwhere('rol_perusahaan', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_role);
    }

	public function create(Request $request){

        $ms_role = new MsRole();
        $email = $request->input('rol_email');
        $nama = $request->input('rol_nama_lengkap');
        $username = $request->input('rol_username');
        $pass = $request->input('rol_password');

        $ms_role->rol_username = $username;
        $ms_role->rol_password = $pass;
		$ms_role->rol_nama_lengkap = $nama;
        $ms_role->rol_perusahaan = $request->input('rol_perusahaan');
        $ms_role->rol_email = $email;
        $ms_role->rol_no_telepon = $request->input('rol_no_telepon');
        $ms_role->rol_status_aktif = "Aktif";
        $ms_role->created_by = $request->input('created_by');

        $to_name = $nama;
        $to_email = $email;
        $data = array("name" => $to_name, "body" => "Coba dulu Deh", "pass" => $pass, "username" => $username);
        Mail::send('mailrole', $data, function ($message) use ($to_name, $to_email, $pass, $username){
            $message->to($to_email)
                ->subject('Like this Example');
        });

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
