<?php

namespace App\Http\Controllers;

header('Access-Control-Allow_Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;

use App\User;
use App\MsPerson;
use App\MsPerusahaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use App\Http\Mail\MailNotify;
use App\Notifications\SignupActivate_HRD_Anak_Perusahaan;


class MsPersonController extends Controller
{
    public function index()
	{
        $ms_person = DB::table('ms_person')
        ->join('ms_perusahaan', 'ms_person.pers_perusahaan', '=', 'ms_perusahaan.id')
        ->select('ms_person.pers_role', 'ms_person.pers_password', 'ms_person.pers_nama_lengkap','ms_person.pers_perusahaan','ms_perusahaan.per_nama',
        'ms_person.pers_email','ms_person.pers_no_telepon','ms_person.pers_status_aktif')->paginate(5);

        $results = DB::select( DB::raw("SELECT p.pers_role, p.pers_password, p.pers_nama_lengkap, p.pers_perusahaan, ps.per_nama as pers_nama_perusahaan,
        p.pers_email, p.pers_no_telepon, p.pers_status_aktif FROM ms_person p JOIN ms_perusahaan ps on p.pers_perusahaan = ps.id"
          ));
        return $ms_person;
	}

	public function showDetail($id)
    {
        // get detail pelamar
		$ms_person = MsPerson::find($id);
        return response()->json($ms_person);
    }

    public function showPerusahaan()
    {
        $ms_perusahaan = DB::table('ms_perusahaan')->get();
        return response()->json([
            'message' => 'success',
            'data' => $ms_perusahaan
        ], 200);
    }

    public function viewPewawancara()
	{
        $ms_person = MsPerson::where( 'pers_role', '=', 'Pewawancara' )
            ->paginate(5);

        return response()->json($ms_person);
	}

	public function search(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
		$ms_person = DB::table('ms_person')
		->orwhere('pers_nama_lengkap', 'LIKE', "%".$cari."%")
		->orwhere('pers_perusahaan', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_person);
    }

	public function searchPewawancara(Request $request)
    {
		// menangkap data pencarian
		$cari = $request->cari;
        $ms_person = DB::table('ms_person')
        ->orwhere( 'pers_role', '=', 'Pewawancara' )
		->orwhere('pers_nama_lengkap', 'LIKE', "%".$cari."%")
		->orwhere('pers_perusahaan', 'LIKE', "%".$cari."%")->paginate(5);

        return response()->json($ms_person);
    }

	public function create(Request $request){

        $ms_person = new MsPerson();
        $email = $request->input('pers_email');
        $name = $request->input('pers_nama_lengkap');
        $pass = Str::random(8);

        $role = $request->input('pers_role');

        $ms_person->pers_password = $pass;
		$ms_person->pers_nama_lengkap = $name;
        $ms_person->pers_role = $request->input('pers_role');
        $ms_person->pers_perusahaan = $request->input('pers_perusahaan');
        $ms_person->pers_email = $email;
        $ms_person->pers_status_aktif = "Aktif";
        $ms_person->created_by = $request->input('created_by');

        if($role == 'HRD Anak Perusahaan'){
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make("123456"),
                'role_user' => 0,
                'activation_token' => Str::random(60)
                // 'password' => Hash::make(Str::random(6)),
            ]);//hash untuk crypting password
        }else{
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make("123456"),
                'role_user' => 2,
                'activation_token' => Str::random(60)
                // 'password' => Hash::make(Str::random(6)),
            ]);//hash untuk crypting password
        }

        $user->save();

        $token=$user->createToken($user->email.'-'.now());

        $user->notify(new SignupActivate_HRD_Anak_Perusahaan($user, $ms_person));

		$ms_person->save();

        return response()->json(['ms_person'=>$ms_person, 'user'=>$user,'token'=>$token->accessToken,]);
    }

	public function createPewawancara(Request $request){

        $ms_person = new MsPerson();
        $email = $request->input('pers_email');
        $nama = $request->input('pers_nama_lengkap');
        $pass = Str::random(12);

        $ms_person->pers_password = $pass;
		$ms_person->pers_nama_lengkap = $nama;
        $ms_person->pers_role = "Pewawancara";
        $ms_person->pers_no_telepon = $request->input('pers_no_telepon');
        $ms_person->pers_perusahaan = $request->input('pers_perusahaan');
        $ms_person->pers_email = $email;
        $ms_person->pers_status_aktif = "Aktif";
        $ms_person->created_by = $request->input('created_by');

        $to_name = $nama;
        $to_email = $email;
        $data = array("name" => $to_name, "body" => "Coba dulu Deh", "pass" => $pass);
        Mail::send('mailrole', $data, function ($message) use ($to_name, $to_email, $pass){
            $message->to($to_email)
                ->subject('Like this Example');
        });

		$ms_person->save();

        return response()->json($ms_person);
    }

	// method untuk edit data pelamar
	public function edit($id)
	{
        $ms_person = MsPerson::find($id);
        return response()->json($ms_person);
	}

	// update data pelamar
	public function update(Request $request, $id)
	{
		//http://127.0.0.1:8000/api/ms_pelamar/create?pel_nama_lengkap=Dihan Kaniro&pel_email=dihankaniro@gmail.com&pel_password=9876&pel_jenis_kelamin=Perempuan&pel_no_telepon=081347576890&cari=S2&created_by=1&pel_no_ktp=0320170021&pel_tanggal_lahir=10-15-1999&pel_tempat_lahir=Jakarta&pel_gaji_diharapkan=7500000&pel_umur=20&pel_alamat=Jakarta Barat&pel_tinggi_badan=162&pel_berat_badan=60&pel_pendidikan_terakhir=S2
		$ms_person = MsPerson::find($id);

        $ms_person->pers_role = $request->input('pers_role');
        $ms_person->pers_nama_lengkap = $request->input('pers_nama_lengkap');
        $ms_person->pers_perusahaan = $request->input('pers_perusahaan');
        $ms_person->pers_email = $request->input('pers_email');
        $ms_person->pers_status_aktif = $request->input('pers_status_aktif');
        $ms_person->pers_status_aktif = "Aktif";
		$ms_person->updated_by = $request->input('updated_by');

		$ms_person->update();

        return response()->json($ms_person);
	}

	// update data pelamar
	public function updatePewawancara(Request $request, $id)
	{
		//http://127.0.0.1:8000/api/ms_pelamar/create?pel_nama_lengkap=Dihan Kaniro&pel_email=dihankaniro@gmail.com&pel_password=9876&pel_jenis_kelamin=Perempuan&pel_no_telepon=081347576890&cari=S2&created_by=1&pel_no_ktp=0320170021&pel_tanggal_lahir=10-15-1999&pel_tempat_lahir=Jakarta&pel_gaji_diharapkan=7500000&pel_umur=20&pel_alamat=Jakarta Barat&pel_tinggi_badan=162&pel_berat_badan=60&pel_pendidikan_terakhir=S2
		$ms_person = MsPerson::find($id);

        $ms_person->pers_role = "Pewawancara";
        $ms_person->pers_no_telepon = $request->input('pers_no_telepon');
        $ms_person->pers_nama_lengkap = $request->input('pers_nama_lengkap');
        $ms_person->pers_perusahaan = $request->input('pers_perusahaan');
        $ms_person->pers_email = $request->input('pers_email');
        $ms_person->pers_status_aktif = $request->input('pers_status_aktif');
        $ms_person->pers_status_aktif = "Aktif";
		$ms_person->updated_by = $request->input('updated_by');

		$ms_person->update();

        return response()->json($ms_person);
	}

	// method untuk hapus data pelamar
	public function delete($id){
        $ms_person = MsPerson::find($id);
        $ms_person->delete();
        return response()->json($ms_person);
    }

    public function ubahStatus($id){
        $ms_person = MsPerson::find($id);
        $ms_person->pers_status_aktif = "Tidak Aktif";
		$ms_person->update();
        return response()->json($ms_person);
	}

}
