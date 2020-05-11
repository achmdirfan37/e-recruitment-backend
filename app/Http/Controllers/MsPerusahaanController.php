<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsPerusahaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MsPerusahaanController extends Controller
{
    public function index()
	{
		// $ms_perusahaan = DB::table('ms_perusahaan')->get();

        // return response()->json([
        //     'message' => 'success',
        //     'data' => $ms_perusahaan
        // ], 200);

		$ms_perusahaan = MsPerusahaan::paginate(5);

        return $ms_perusahaan;

    }

    public function view()
	{
		$ms_perusahaan = DB::table('ms_perusahaan')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_perusahaan
        ], 200);
	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_perusahaan = MsPerusahaan::find($id);
        return response()->json($ms_perusahaan);
    }

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_perusahaan = DB::table('ms_perusahaan')
		->where('per_nama','LIKE',"%".$cari."%")
		->orwhere('per_deskripsi', 'LIKE', "%".$cari."%")
		->orwhere('per_email', 'LIKE', "%".$cari."%")
		->orwhere('per_alamat_website', 'LIKE', "%".$cari."%")->paginate(5);;

        return response()->json($ms_perusahaan);
    }

	public function create(Request $request){

        $ms_perusahaan = new MsPerusahaan();

        $ms_perusahaan->per_nama = $request->input('per_nama');
        $ms_perusahaan->per_deskripsi = $request->input('per_deskripsi');
		$ms_perusahaan->per_email = $request->input('per_email');
        $ms_perusahaan->per_no_telepon = $request->input('per_no_telepon');
        $ms_perusahaan->per_alamat_website = $request->input('per_alamat_website');
        $ms_perusahaan->per_alamat = $request->input('per_alamat');
        $ms_perusahaan->per_status_aktif = "Aktif";
		$ms_perusahaan->created_by = $request->input('created_by');

		// if($request->hasfile('pel_foto')){
        //     $file = $request->file('pel_foto');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.tj' . $extension;
        //     $file->move('uploads/', $filename);
        //     $ms_pelamar->pel_foto = $filename;
        // }else{
        //     return $request;
        //     $ms_pelamar->pel_foto = '';
		// }

		$ms_perusahaan->save();

        return response()->json($ms_perusahaan);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_perusahaan = MsPerusahaan::find($id);
        return response()->json($ms_perusahaan);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{
		$ms_perusahaan = MsPerusahaan::find($id);

        $ms_perusahaan->per_nama = $request->input('per_nama');
		$ms_perusahaan->per_deskripsi = $request->input('per_deskripsi');
        $ms_perusahaan->per_email = $request->input('per_email');
        $ms_perusahaan->per_no_telepon = $request->input('per_no_telepon');
        $ms_perusahaan->per_alamat_website = $request->input('per_alamat_website');
        $ms_perusahaan->per_alamat = $request->input('per_alamat');
        $ms_perusahaan->per_status_aktif = $request->input('per_status_aktif');
		$ms_perusahaan->updated_by = $request->input('updated_by');

		if($request->hasfile('per_foto')){
            $file = $request->file('per_foto');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);
            $ms_perusahaan->per_foto = $filename;
        }

		$ms_perusahaan->update();

        return response()->json($ms_perusahaan);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_perusahaan = MsPerusahaan::find($id);
        $ms_perusahaan->delete();
        return response()->json($ms_perusahaan);
	}

}
