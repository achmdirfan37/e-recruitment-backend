<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsPelamar;
use App\TrLamaranKerja;
use App\User;
use App\Http\Mail\MailNotify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;
use Carbon\Carbon;
use Log;
use Response;

// use Illuminate\Bus\Queueable;
// use Illuminate\Mail\Mailable;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

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

        $dateOfBirth = $request->input('pel_tanggal_lahir');	// get the request date

        $age = Carbon::parse($dateOfBirth)->age;	// calculate the age
        $email = $request->input('pel_email');
        $nama = $request->input('pel_nama_lengkap');

        $ms_pelamar->pel_email = $email;
        $ms_pelamar->pel_password = $request->input('pel_password');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $nama;
        $ms_pelamar->pel_jenis_kelamin = $request->input('pel_jenis_kelamin');
        $ms_pelamar->pel_tempat_lahir = $request->input('pel_tempat_lahir');
        $ms_pelamar->pel_tanggal_lahir = $request->input('pel_tanggal_lahir');
        $ms_pelamar->pel_no_telepon = $request->input('pel_no_telepon');
        $ms_pelamar->pel_alamat = $request->input('pel_alamat');
        $ms_pelamar->pel_tinggi_badan = $request->input('pel_tinggi_badan');
        $ms_pelamar->pel_berat_badan = $request->input('pel_berat_badan');
        $ms_pelamar->pel_gaji_diharapkan = $request->input('pel_gaji_diharapkan');
        $ms_pelamar->pel_posisi = $request->input('pel_posisi');
        $ms_pelamar->pel_status_aktif = "Aktif";
        $ms_pelamar->pel_umur = $age;
        $ms_pelamar->pel_pendidikan_terakhir = $request->input('pel_pendidikan_terakhir');
		$ms_pelamar->created_by = $request->input('created_by');

        
        $to_name = $nama;
        $to_email = $email;
        $data = array("name" => $to_name, "body" => "Thanks for signing up! Please check your email to complete your registration.");
        Mail::send('mailInterview', $data, function ($message) use ($to_name, $to_email){
            $message->to($to_email)
                ->subject('Please verify your email address.');
        });
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



    public function registerPelamar(Request $request){

        $ms_pelamar = new MsPelamar();
        $dateOfBirth = $request->input('pel_tanggal_lahir');	// get the request date

        $age = Carbon::parse($dateOfBirth)->age;	// calculate the age
        $email = $request->input('pel_email');
        $nama = $request->input('pel_nama_lengkap');

        $ms_pelamar->pel_email = $email;
        $ms_pelamar->pel_password = $request->input('pel_password');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $nama;
        $ms_pelamar->pel_jenis_kelamin = $request->input('pel_jenis_kelamin');
        $ms_pelamar->pel_tempat_lahir = $request->input('pel_tempat_lahir');
        $ms_pelamar->pel_tanggal_lahir = $request->input('pel_tanggal_lahir');
        $ms_pelamar->pel_no_telepon = $request->input('pel_no_telepon');
        $ms_pelamar->pel_alamat = $request->input('pel_alamat');
        $ms_pelamar->pel_tinggi_badan = $request->input('pel_tinggi_badan');
        $ms_pelamar->pel_berat_badan = $request->input('pel_berat_badan');
        $ms_pelamar->pel_gaji_diharapkan = $request->input('pel_gaji_diharapkan');
        $ms_pelamar->pel_posisi = $request->input('pel_posisi');
        $ms_pelamar->pel_status_aktif = "Aktif";
        $ms_pelamar->pel_umur = $age;
        $ms_pelamar->pel_pendidikan_terakhir = $request->input('pel_pendidikan_terakhir');
        $ms_pelamar->created_by = $request->input('created_by');

        $to_name = $nama;
        $to_email = $email;
        $data = array("name" => $to_name, "body" => "Thanks for signing up! Please check your email to complete your registration.");
        Mail::send('mail', $data, function ($message) use ($to_name, $to_email){
            $message->to($to_email)
                ->subject('Please verify your email address.');
        });

        $user = User::create([
            'name' => $request->input('pel_nama_lengkap'),
            'email' => $request->input('pel_email'),
            'password' => Hash::make($request->input('pel_password')),
        ]);

        $token = JWTAuth::fromUser($user);

    //     Mail::to($to_email)->send(new MailNotify($to_name));
    //     if (Mail::failures()) {
    //         return response()->Fail('Sorry! Please try again latter');
    //    }else{
    //         return response()->success('Great! Successfully send in your mail');
    //       }

		$ms_pelamar->save();

        return response()->json(compact('user', 'token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->json()->all();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser(){
        try{
            if($user == JWTAuth::parseToken()->authenticate()){
                return response()->json(['user_not_found'], 404);
            }
        }catch(Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return response()->json(['token_expired'], $e->getStatusCode());
        }catch(Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
            return response()->json(['token_invalid'], $e->getStatusCode());
        }catch(Tymon\JWTAuth\Exceptions\JWTException $e){
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    
    public function getImage($id)
    {
        $ms_pelamar = MsPelamar::find($id);
        $image_path = (public_path('uploads/').$ms_pelamar->pel_foto);
        $image_obj = \Image::make($image_path)->response();
        Log::info("image_path".$image_obj);
        return response()->json($image_obj); 
    }

    
    public function displayImage($id)
    {
        $ms_pelamar = MsPelamar::find($id);
        $path = public_path('uploads/').$ms_pelamar->pel_foto;

        if (!File::exists($path)) {
            abort(404);
        }
        
        $file = File::get($path);
        $type = File::mimeType($path);
        $foto = Response::make($file, 200);
        $foto->header("Content-Type", $type);
        //$ms_pelamar->pel_foto = $foto;
        //return response()->json($response);
        //return response()->json($ms_pelamar);
        return $foto;

        // $path = storage_public('images/' . $filename);
        // if (!File::exists($path)) {
        //     abort(404);
        // }
        
        // $file = File::get($path);
        // $type = File::mimeType($path);
        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);
        // return $response;
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_pelamar = MsPelamar::find($id);
        return response()->json($ms_pelamar);
	}

    // update data pelamar
	public function changePassword(Request $request, $id)
	{
        $ms_pelamar = MsPelamar::find($id);
        
        $password = $request->input('pel_password');
        $old_pass = $request->input('pel_old_pass');
        $new_pass = $request->input('pel_new_pass');
        $con_pass = $request->input('pel_con_pass');

        if ($old_pass != $password) {
            return response()->json('Your Password is Wrong!! Try Again');
        } else if ($new_pass != $con_pass) {
            return response()->json('Your Password is Wrong!! Try Again');
        } else if (($old_pass == $password) && ($new_pass == $con_pass)){
            $ms_pelamar->pel_password = $con_pass;    
        } else {
            return response()->json('Your Password is Wrong!! Try Again');
        }

		$ms_pelamar->update();

        return response()->json($ms_pelamar);
    }
    
    // update data pelamar
	public function updateflk(Request $request, $id)
	{
        $ms_pelamar = MsPelamar::find($id);

        if($request->get('file'))
        {
            $file = $request->get('file');
            $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($request->get('file'))->save(public_path('uploads/').$name);        
            $ms_pelamar->pel_foto=$name;            
        }

		$ms_pelamar->pel_posisi = $request->input('pel_posisi');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $request->input('pel_nama_lengkap');
        $ms_pelamar->pel_tempat_lahir = $request->input('pel_tempat_lahir');
        $ms_pelamar->pel_tanggal_lahir = $request->input('pel_tanggal_lahir');
        $ms_pelamar->pel_kewarganegaraan = $request->input('pel_kewarganegaraan');
        $ms_pelamar->pel_alamat = $request->input('pel_alamat');
        $ms_pelamar->pel_no_telepon = $request->input('pel_no_telepon');
        $ms_pelamar->pel_email = $request->input('pel_email');
        $ms_pelamar->pel_alamat_ortu = $request->input('pel_alamat_ortu');
        $ms_pelamar->pel_no_telepon_ortu = $request->input('pel_no_telepon_ortu');

        
        $ms_pelamar->pel_alasan_memilih_jurusan = $request->input('pel_alasan_memilih_jurusan');
        $ms_pelamar->pel_karya_ilmiah = $request->input('pel_karya_ilmiah');
        $ms_pelamar->pel_pendidikan_non_formal = $request->input('pel_pendidikan_non_formal');
        $ms_pelamar->pel_bahasa = $request->input('pel_bahasa');
        $ms_pelamar->pel_status_pernikahan = $request->input('pel_status_pernikahan');
        $ms_pelamar->pel_tanggal_status_pernikahan = $request->input('pel_tanggal_status_pernikahan');
        $ms_pelamar->pel_susunan_keluarga = $request->input('pel_susunan_keluarga');
        $ms_pelamar->pel_detail_atasan_bawahan = $request->input('pel_detail_atasan_bawahan');
        $ms_pelamar->pel_masalah_dihadapi = $request->input('pel_masalah_dihadapi');
        $ms_pelamar->pel_kesan_kerja = $request->input('pel_kesan_kerja');
        $ms_pelamar->pel_inovasi_kerja = $request->input('pel_inovasi_kerja');
        $ms_pelamar->pel_orang_yang_mendorong = $request->input('pel_orang_yang_mendorong');
        $ms_pelamar->pel_case_keputusan = $request->input('pel_case_keputusan');
        
        $ms_pelamar->pel_cita_cita = $request->input('pel_cita_cita');
        $ms_pelamar->pel_hal_mendorong_bekerja = $request->input('pel_hal_mendorong_bekerja');
        $ms_pelamar->pel_alasan_ingin_bekerja = $request->input('pel_alasan_ingin_bekerja');
        $ms_pelamar->pel_gaji_diharapkan = $request->input('pel_gaji_diharapkan');
        $ms_pelamar->pel_fasilitas_diharapkan = $request->input('pel_fasilitas_diharapkan');
        
        $ms_pelamar->pel_kapan_mulai_kerja = $request->input('pel_kapan_mulai_kerja');
        $ms_pelamar->pel_urutan_jenis_pekerjaan = $request->input('pel_urutan_jenis_pekerjaan');
        $ms_pelamar->pel_lingkungan_kerja_diminati = $request->input('pel_lingkungan_kerja_diminati');
        $ms_pelamar->pel_bersedia_diluar_daerah = $request->input('pel_bersedia_diluar_daerah');
        $ms_pelamar->pel_tipe_orang_disenangi = $request->input('pel_tipe_orang_disenangi');
        $ms_pelamar->pel_hal_sulit_mengambil_keputusan = $request->input('pel_hal_sulit_mengambil_keputusan');
        $ms_pelamar->pel_kenalan_di_perusahaan_astra = $request->input('pel_kenalan_di_perusahaan_astra');
        $ms_pelamar->pel_referensi_perusahaan = $request->input('pel_referensi_perusahaan');
        $ms_pelamar->pel_hobi = $request->input('pel_hobi');
        $ms_pelamar->pel_cara_mengisi_waktu_luang = $request->input('pel_cara_mengisi_waktu_luang');
        $ms_pelamar->pel_organisasi_diikuti = $request->input('pel_organisasi_diikuti');
        $ms_pelamar->pel_psikotes = $request->input('pel_psikotes');
        $ms_pelamar->pel_kekuatan = $request->input('pel_kekuatan');
        $ms_pelamar->pel_kelemahan = $request->input('pel_kelemahan');
        $ms_pelamar->pel_riwayat_penyakit = $request->input('pel_riwayat_penyakit');
        $ms_pelamar->pel_persetujuan = "Ya";

		$ms_pelamar->update();

        return response()->json($ms_pelamar);
    }
    
	// update data pelamar
	public function update(Request $request, $id)
	{
        $ms_pelamar = MsPelamar::find($id);

        if($request->get('file'))
        {
            $file = $request->get('file');
            $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($request->get('file'))->save(public_path('uploads/').$name);        
            $ms_pelamar->pel_foto=$name;            
        }

        $dateOfBirth = $request->input('pel_tanggal_lahir');	// get the request date

        $age = Carbon::parse($dateOfBirth)->age;	// calculate the age


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
        $ms_pelamar->pel_posisi = $request->input('pel_posisi');
        $ms_pelamar->pel_status_aktif = $request->input('pel_status_aktif');
        $ms_pelamar->pel_umur = $age;
        $ms_pelamar->pel_pendidikan_terakhir = $request->input('pel_pendidikan_terakhir');
		$ms_pelamar->updated_by = $request->input('updated_by');

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
