<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MsJabatan;
use DB;

class MsJabatanController extends Controller
{
    public function index(){
		$ms_jabatan = DB::table('ms_jabatan')->get();

        return response()->json([
            'message' => 'success',
            'data' => $ms_jabatan
        ], 200);

        // $ms_jabatan = MsJabatan::all();
        // return response()->json($ms_jabatan);
    }

    public function create(Request $request){
		
        $ms_jabatan = new MsJabatan();

        $ms_jabatan->jab_nama = $request->input('jab_nama');
        $ms_jabatan->jab_deskripsi = $request->input('jab_deskripsi');
        $ms_jabatan->jab_status_aktif = "Aktif";
        $ms_jabatan->created_by = $request->input('created_by');
        $ms_jabatan->save();
	
        return response()->json($ms_jabatan);
    }

    public function edit($id){
        $ms_jabatan = MsJabatan::find($id);
        return response()->json($ms_jabatan);
    }

    public function update(Request $request, $id){
        $ms_jabatan = MsJabatan::find($id)->update([
            'jab_nama' => $request->jab_nama,
            'jab_deskripsi' => $request->jab_deskripsi,
            'jab_status_aktif' => $request->jab_status_aktif,
            'updated_by' => $request->updated_by
        ]);
        return response()->json($ms_jabatan);
    }

    public function delete($id){
        $ms_jabatan = MsJabatan::find($id);
        $ms_jabatan->delete();
        return response()->json($ms_jabatan);
	}
	
    // public function index()
	// {
	// 	$ms_jabatan = DB::table('ms_jabatan')->get();

    //     return response()->json([
    //         'message' => 'success',
    //         'data' => $ms_jabatan
    //     ], 200);
	// }
 
	// // method untuk menampilkan view form tambah pegawai
	// public function tambah()
	// {
 
	// 	// memanggil view tambah
	// 	return view('tambahPelamar');
 
	// }
 
	// // method untuk insert data ke table pegawai
	// public function store(Request $request)
	// {
	// 	// insert data ke table pegawai
	// 	// DB::table('ms_pelamar')->insert([
	// 	// 	'pel_nama' => $request->pel_nama,
	// 	// 	'pel_gender' => $request->pel_gender,
    //     //     'pel_email' => $request->pel_email,
    //     //     'pel_username' => $request->pel_username,
	// 	// 	'pel_alamat' => $request->pel_alamat
    //     // ]);
        
    //     $ms_pelamar = new Pelamar();

    //     $ms_pelamar->pel_nama = $request->input('pel_nama');
    //     $ms_pelamar->pel_gender = $request->input('pel_gender');
    //     $ms_pelamar->pel_email = $request->input('pel_email');
    //     $ms_pelamar->pel_username = $request->input('pel_username');
    //     $ms_pelamar->pel_alamat = $request->input('pel_alamat');

    //     if($request->hasfile('pel_image')){
    //         $file = $request->file('pel_image');
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $extension;
    //         $file->move('uploads/', $filename);
    //         $ms_pelamar->pel_image = $filename;
    //     }else{
    //         return $request;
    //         $ms_pelamar->pel_image = '';
    //     }

    //     $ms_pelamar->save();

	// 	// alihkan halaman ke halaman pegawai
	// 	return redirect('/ms_pelamar');
 
	// }
 
	// // method untuk edit data pegawai
	// public function edit($id)
	// {
	// 	// mengambil data pegawai berdasarkan id yang dipilih
	// 	$ms_pelamar = DB::table('ms_pelamar')->where('id',$id)->get();
	// 	// passing data pegawai yang didapat ke view edit.blade.php
	// 	return view('editPelamar',['ms_pelamar' => $ms_pelamar]);
 
	// }
 
	// // update data pegawai
	// public function update(Request $request)
	// {
	// 	// update data pegawai
	// 	DB::table('ms_pelamar')->where('id',$request->id)->update([
	// 		'pel_nama' => $request->pel_nama,
	// 		'pel_gender' => $request->pel_gender,
    //         'pel_email' => $request->pel_email,
    //         'pel_username' => $request->pel_username,
	// 		'pel_alamat' => $request->pel_alamat
	// 	]);
	// 	// alihkan halaman ke halaman pegawai
	// 	return redirect('/ms_pelamar');
	// }
 
	// // method untuk hapus data pegawai
	// public function hapus($id)
	// {
	// 	// menghapus data pegawai berdasarkan id yang dipilih
	// 	DB::table('ms_pelamar')->where('id',$id)->delete();
		
	// 	// alihkan halaman ke halaman pegawai
	// 	return redirect('/ms_pelamar');
    // }
    
    // public function getAllMsPelamar()
    // {
    //     $pelamar = DB::table('ms_coba')->get();

    //     return response()->json([
    //         'message' => 'success',
    //         'data' => $pelamar
    //     ], 200);
    // }

    // public function filterMsPelamar(Request $request)
    // {
    //     $filter = strtoupper($request->filter);
    //     $pelamar = DB::table('ms_coba')->where('pel_nama', 'like', "%$filter%")->get();

    //     return response()->json([
    //         'message' => 'success',
    //         'data' => $pelamar
    //     ], 200);
    // }
}
