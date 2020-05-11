<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\MsPelamar;
use App\User;
use App\Http\Mail\MailNotify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;
use Carbon\Carbon;

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
		$ms_pelamar = MsPelamar::find(17);
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
        $ms_pelamar->pel_umur = $age;
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
        $ms_pelamar->pel_jabatan_dicari = $request->input('pel_jabatan_dicari');
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
        $ms_pelamar->pel_jabatan_dicari = $request->input('pel_jabatan_dicari');
        $ms_pelamar->pel_status_aktif = $request->input('pel_status_aktif');
        $ms_pelamar->pel_umur = $age;
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
