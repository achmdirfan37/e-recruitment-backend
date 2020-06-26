<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\MsPelamar;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Mail\MailNotify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Notifications\SignupActivate;


class AuthController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */


    public function register(Request $request)
    {
        // $request->validate([
        //     'pel_nama_lengkap' => 'required',
        //     'pel_jenis_kelamin' => 'required',
        //     'pel_tanggal_lahir' => 'required',
        //     'pel_alamat' => 'required',
        //     'pel_no_telepon' => 'required',
        //     'email' => 'required|email|unique:users',
        //     'pel_password' => 'required|min:6'
        // ]);

        $ms_pelamar = new MsPelamar();
        $dateOfBirth = $request->input('pel_tanggal_lahir');	// get the request date

        $age = Carbon::parse($dateOfBirth)->age;	// calculate the age
        $email = $request->input('email');
        $name = $request->input('pel_nama_lengkap');
        $password = $request->input('pel_password');

        $ms_pelamar->pel_email = $email;
        $ms_pelamar->pel_password = $request->input('pel_password');
		$ms_pelamar->pel_no_ktp = $request->input('pel_no_ktp');
        $ms_pelamar->pel_nama_lengkap = $name;
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

        // $to_name = $name;
        // $to_email = $email;
        // $data = array("name" => $to_name, "body" => "Thanks for signing up! Please check your email to complete your registration.");
        // Mail::send('mail', $data, function ($message) use ($to_name, $to_email){
        //     $message->to($to_email)
        //         ->subject('Please verify your email address.');
        // });

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_user' => 3,
            'activation_token' => Str::random(60)
            // 'password' => Hash::make(Str::random(6)),
        ]);//hash untuk crypting password
        $user->save();

        $user->notify(new SignupActivate($user));

        $token=$user->createToken($user->email.'-'.now());
        $ms_pelamar->save();

        return response()->json(['user'=>$user,'token'=>$token->accessToken,]);
    }

    public function signupActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        if($user->role_user == 3){
            $urlLogin = "http://localhost:3000/login";
        }else if($user->role_user == 2){
            $urlLogin = "http://localhost:3000/login_pewawancara";
        }else if($user->role_user == 1){
            $urlLogin = "http://localhost:3000/login_admin2";
        }else{
            $urlLogin = "http://localhost:3000/login_admin";
        }

        return redirect($urlLogin);
    }

    public function login(Request $request)
    {
    //     $request->validate([
    //         'pel_email' => 'required|email|exists:users,email',
    //         'pel_password' => 'required|min:6'
    //     ]);
        // $email = $request->input('email');
        // $password = $request->input('password');
        // if(Auth::attempt(['email' => $email, 'password' => $password]))//checking if there's any user with the email and password we type
        // {
        //     $user=Auth::user();//checking the authentication
        //     $token=$user->createToken($user->email.'-'.now());
        //     return response()->json([
        //         'token' => $token->accessToken,
        //         'user' => $user
        //     ]);
        // }else{
        //     return response()->json(['error'=>"unauthorized"]);
        // }
        $credentials = request(['email', 'password']);
        $credentials['active'] = 1;
        $credentials['deleted_at'] = null;
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }



    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     $rules = [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ];

    //     if($validator->fails()) {
    //         return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
    //     }

    //     $credentials['is_verified'] = 1;

    //     try {
    //         // attempt to verify the credentials and create a token for the user
    //         if (! $token = JWTAuth::attempt($credentials)) {
    //             return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
    //         }
    //     } catch (JWTException $e) {
    //         // something went wrong whilst attempting to encode the token
    //         return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
    //     }

    //     // all good so return the token
    //     return response()->json(['success' => true, 'data'=> [ 'token' => $token ]], 200);
    // }


    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}
