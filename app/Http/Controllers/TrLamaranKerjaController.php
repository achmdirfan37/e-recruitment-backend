<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\TrLamaranKerja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TrLamaranKerjaController extends Controller
{
    public function index()
	{
		$tr_lamaran_kerja = DB::table('tr_lamaran_kerja')->paginate(5);;
        return $tr_lamaran_kerja;
    }


    public function viewBelumDibaca(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_status_baca', '=', "Belum Dibaca" )
            ->paginate(5);

        return response()->json($tr_lamaran_kerja);

    }

    public function viewInterview1(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_status_rekrutmen', '=', "Wawancara 1" )
            ->paginate(5);

        return response()->json($tr_lamaran_kerja);

    }
    public function viewInterview2(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_status_rekrutmen', '=', "Wawancara 2" )
            ->paginate(5);

        return response()->json($tr_lamaran_kerja);

    }

    public function viewPsikotes(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_status_rekrutmen', '=', "Wawancara HR" )
            //->where( 'lk_status_view', '=', 'Kirim' )
            ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    public function viewMCU(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_status_rekrutmen', '=', "Psikotes" )
            //->where( 'lk_status_view', '=', 'Kirim' )
            ->paginate(5);

        return response()->json($tr_lamaran_kerja);

    }

	public function showDetail($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_perusahaan', 'tr_lamaran_kerja.lk_perusahaan', '=', 'ms_perusahaan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul', 'ms_perusahaan.per_nama', 'ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
        ->paginate(10);

        return response()->json($tr_lamaran_kerja);
    }

	public function showLamaranPewawancara($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'tr_lamaran_kerja.lk_golongan', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul','ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_person', '=', $id )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

	public function showLamaranPewawancaraStaff($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul','ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_person', '=', $id )
        ->where('tr_lamaran_kerja.lk_golongan', '=', "Staff" )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

	public function showLamaranPewawancaraSectionHead($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul','ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_person', '=', $id )
        ->where('tr_lamaran_kerja.lk_golongan', '=', "Section Head" )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    public function displayImage($filename)
    {
        $path = storage_public('uploads/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function showDetailInterview1(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Wawancara 1' )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    public function showDetailInterview2(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Wawancara 2' )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    public function showDetailInterviewHR(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Wawancara HR' )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    public function showDetailPsikotes(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Psikotes' )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }


    public function showDetailMCU(Request $request)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Medical Check Up' )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

    
	public function showDetailTransaksiPelamar($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_perusahaan', 'tr_lamaran_kerja.lk_perusahaan', '=', 'ms_perusahaan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul', 'ms_perusahaan.per_nama', 'ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_pelamar', '=', $id )
        ->paginate(10);

        return response()->json($tr_lamaran_kerja);
    }

    public function showDetailAcceptDeclinePelamar($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_perusahaan', 'tr_lamaran_kerja.lk_perusahaan', '=', 'ms_perusahaan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'ms_pelamar.pel_nama_lengkap', 'ms_lowongan.low_judul', 'ms_perusahaan.per_nama', 'ms_posisi.pos_nama','tr_lamaran_kerja.lk_status_rekrutmen')
        ->where( 'tr_lamaran_kerja.lk_pelamar', '=', $id )
        ->where( 'tr_lamaran_kerja.lk_status_view', '=', 'Terima' )
        ->paginate(10);

        return response()->json($tr_lamaran_kerja);
    }

	public function create(Request $request){

        $tr_lamaran_kerja = new TrLamaranKerja();

        if($request->get('file'))
        {

            // $file = $request->file('file');
            // $extension = $file->getClientOriginalExtension();
            // $filename = time() . '.' . $extension;
            // $file->move('uploads/', $filename);
            // $tr_lamaran_kerja->lk_cv = $filename;

            $file = $request->get('file');
            $name = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            \Image::make($request->get('file'))->save(public_path('uploads/').$name);
            $tr_lamaran_kerja->lk_cv=$name;

        }

        $tr_lamaran_kerja->lk_status_baca = "Belum Dibaca";
        $tr_lamaran_kerja->lk_status_rekrutmen = "Belum Diproses";
        $tr_lamaran_kerja->lk_status_view = "Kirim";
        $tr_lamaran_kerja->lk_perusahaan = $request->get('lk_perusahaan');
        $tr_lamaran_kerja->lk_lowongan = $request->get('lk_lowongan');
        $tr_lamaran_kerja->lk_pelamar = $request->get('lk_pelamar');
        $tr_lamaran_kerja->save();
        return response()->json($tr_lamaran_kerja);

		// if($request->hasfile('lk_cv')){
        //     $file = $request->file('lk_cv');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/', $filename);
        //     $tr_lamaran_kerja->lk_cv = $filename;
        // }else{
        //     return $request;
        //     $tr_lamaran_kerja->lk_cv = '';
		// }

        // $tr_lamaran_kerja->lk_cv = $name;
        // $tr_lamaran_kerja->lk_status_baca = "Belum Dibaca";
        // $tr_lamaran_kerja->lk_status_rekrutmen = "";
        // $tr_lamaran_kerja->lk_perusahaan = 1;
        // $tr_lamaran_kerja->lk_lowongan = 1;
        // $tr_lamaran_kerja->lk_pelamar = 4;
        // $tr_lamaran_kerja->save();
        // return response()->json('Successfully added');
    }

    public function edit($id)
	{
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->join('ms_perusahaan', 'tr_lamaran_kerja.lk_perusahaan', '=', 'ms_perusahaan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_umur', 'ms_pelamar.pel_tanggal_lahir', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_lowongan.low_deskripsi', 'ms_perusahaan.per_nama')
        ->where( 'tr_lamaran_kerja.id', '=', $id )
        ->get();
        return response()->json($tr_lamaran_kerja);
    }

    public function editNoQuery($id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        return response()->json($tr_lamaran_kerja);
    }

    public function setujuAja(Request $request)
	{
            $to_name = "Salshabilla";
            $to_email = "sabil.salshabilla@gmail.com";
            $konfirmasi = "Wawancara 1";
            $data = array("name" => $to_name, "body" => "Coba", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });
    }


    public function undangTerimaInterview(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $posisi = $request->input('lk_posisi');
        $email = $request->input('lk_email');
        $hari = $request->input('lk_hari');
        $tanggal = $request->input('lk_tanggal');
        $waktu = $request->input('lk_waktu');
        $tempat = $request->input('lk_tempat');
        $link = "http://localhost:3000/login";
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 1";

        $tr_lamaran_kerja->lk_status_baca = "Sudah Dibaca";
        $tr_lamaran_kerja->lk_status_view = "Terima";
        $to_name = $nama;
        $to_email = $email;
        $to_posisi = $posisi;
        $to_hari = $hari;
        $to_tanggal = $tanggal;
        $to_waktu = $waktu;
        $to_tempat = $tempat;
        $to_link = $link;
        $data = array("name" => $to_name, "body" => "", "posisi" => $to_posisi, "hari" => $to_hari, "tanggal" => $to_tanggal, "waktu" => $to_waktu, "tempat" => $to_tempat, "link" => $to_link);
        Mail::send('mailInterview', $data, function ($message) use ($to_name, $to_email, $to_posisi, $to_hari, $to_tanggal, $to_waktu, $to_tempat, $to_link){
            $message->to($to_email)
                ->subject('Please Check Status Confirmation.');
        });

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }

    public function undangTerimaInterview2(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $posisi = $request->input('lk_posisi');
        $email = $request->input('lk_email');
        $hari = $request->input('lk_hari');
        $tanggal = $request->input('lk_tanggal');
        $waktu = $request->input('lk_waktu');
        $tempat = $request->input('lk_tempat');
        $link = "http://localhost:3000/login";
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 2";

        $tr_lamaran_kerja->lk_status_baca = "Sudah Dibaca";
        $tr_lamaran_kerja->lk_status_view = "Terima";
        $to_name = $nama;
        $to_email = $email;
        $to_posisi = $posisi;
        $to_hari = $hari;
        $to_tanggal = $tanggal;
        $to_waktu = $waktu;
        $to_tempat = $tempat;
        $to_link = $link;
        $data = array("name" => $to_name, "body" => "", "posisi" => $to_posisi, "hari" => $to_hari, "tanggal" => $to_tanggal, "waktu" => $to_waktu, "tempat" => $to_tempat, "link" => $to_link);
        Mail::send('mailInterview', $data, function ($message) use ($to_name, $to_email, $to_posisi, $to_hari, $to_tanggal, $to_waktu, $to_tempat, $to_link){
            $message->to($to_email)
                ->subject('Please Check Status Confirmation.');
        });

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }

    public function undangTerimaInterviewHR(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $posisi = $request->input('lk_posisi');
        $email = $request->input('lk_email');
        $hari = $request->input('lk_hari');
        $tanggal = $request->input('lk_tanggal');
        $waktu = $request->input('lk_waktu');
        $tempat = $request->input('lk_tempat');
        $link = "http://localhost:3000/login";
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara HR";

        $tr_lamaran_kerja->lk_status_baca = "Sudah Dibaca";
        $tr_lamaran_kerja->lk_status_view = "Terima";
        $to_name = $nama;
        $to_email = $email;
        $to_posisi = $posisi;
        $to_hari = $hari;
        $to_tanggal = $tanggal;
        $to_waktu = $waktu;
        $to_tempat = $tempat;
        $to_link = $link;
        $data = array("name" => $to_name, "body" => "", "posisi" => $to_posisi, "hari" => $to_hari, "tanggal" => $to_tanggal, "waktu" => $to_waktu, "tempat" => $to_tempat, "link" => $to_link);
        Mail::send('mailInterview', $data, function ($message) use ($to_name, $to_email, $to_posisi, $to_hari, $to_tanggal, $to_waktu, $to_tempat, $to_link){
            $message->to($to_email)
                ->subject('Please Check Status Confirmation.');
        });

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }

    public function undangTerimaPsikotes(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $posisi = $request->input('lk_posisi');
        $email = $request->input('lk_email');
        $hari = $request->input('lk_hari');
        $tanggal = $request->input('lk_tanggal');
        $waktu = $request->input('lk_waktu');
        $tempat = $request->input('lk_tempat');
        $tr_lamaran_kerja->lk_status_rekrutmen = "Psikotes";

        $tr_lamaran_kerja->lk_status_view = "Terima";
        $link = "http://localhost:3000/login";
        $to_link = $link;
        $to_name = $nama;
        $to_email = $email;
        $to_posisi = $posisi;
        $to_hari = $hari;
        $to_tanggal = $tanggal;
        $to_waktu = $waktu;
        $to_tempat = $tempat;
        $data = array("name" => $to_name, "body" => "", "posisi" => $to_posisi, "hari" => $to_hari, "tanggal" => $to_tanggal, "waktu" => $to_waktu, "tempat" => $to_tempat, "link" => $to_link);
        Mail::send('mailPsikotes', $data, function ($message) use ($to_name, $to_email, $to_posisi, $to_hari, $to_tanggal, $to_waktu, $to_tempat, $to_link){
            $message->to($to_email)
                ->subject('Please Check Status Confirmation.');
        });

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }

    public function undangTerimaMCU(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $posisi = $request->input('lk_posisi');
        $email = $request->input('lk_email');
        $hari = $request->input('lk_hari');
        $tanggal = $request->input('lk_tanggal');
        $waktu = $request->input('lk_waktu');
        $tempat = $request->input('lk_tempat');
        $tr_lamaran_kerja->lk_status_rekrutmen = "Medical Check Up";

        $tr_lamaran_kerja->lk_status_view = "Terima";
        $link = "http://localhost:3000/login";
        $to_link = $link;
        $to_name = $nama;
        $to_email = $email;
        $to_posisi = $posisi;
        $to_hari = $hari;
        $to_tanggal = $tanggal;
        $to_waktu = $waktu;
        $to_tempat = $tempat;
        $data = array("name" => $to_name, "body" => "", "posisi" => $to_posisi, "hari" => $to_hari, "tanggal" => $to_tanggal, "waktu" => $to_waktu, "tempat" => $to_tempat, "link" => $to_link);
        Mail::send('mailMCU', $data, function ($message) use ($to_name, $to_email, $to_posisi, $to_hari, $to_tanggal, $to_waktu, $to_tempat, $to_link){
            $message->to($to_email)
                ->subject('Please Check Status Confirmation.');
        });

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }



    public function Accept(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $email = "oohsehunexol1994@gmail.com";
        $status_rekrutmen = $request->input('lk_status_rekrutmen');

        if ($status_rekrutmen == "Wawancara 1") {

            //$tr_lamaran_kerja->lk_sta_kon_interview_satu = "Menerima";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Wawancara 2") {

            //$tr_lamaran_kerja->lk_sta_kon_interview_dua = "Menerima";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Wawancara HR") {

            //$tr_lamaran_kerja->lk_sta_kon_interview_hr = "Menerima";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Psikotes") {

            //$tr_lamaran_kerja->lk_sta_kon_psikotes = "Menerima";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Medical Check Up") {

            //$tr_lamaran_kerja->lk_sta_kon_mcu = "Menerima";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi);
            Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else {

        }

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }

    public function Decline(Request $request, $id)
	{
        $tr_lamaran_kerja = TrLamaranKerja::find($id);

        $nama = $request->input('lk_nama');
        $ket = $request->input('lk_keterangan_konfirmasi');
        $email = "oohsehunexol1994@gmail.com";
        $status_rekrutmen = $request->input('lk_status_rekrutmen');

        // $to_name = $nama;
        // $to_email = $email;
        // $konfirmasi = $status_rekrutmen;
        // $data = array("name" => $to_name, "body" => "");
        // Mail::send('mailConfirmation', $data, function ($message) use ($to_name, $to_email, $konfirmasi){
        //     $message->to($to_email)
        //         ->subject('Please Check Status Confirmation.');
        // });

        if ($status_rekrutmen == "Wawancara 1") {

            $tr_lamaran_kerja->lk_sta_kon_interview_satu = "Menolak";
            $tr_lamaran_kerja->lk_ket_interview_satu = $ket;
            $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 1";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi, "ket" => $ket);
            Mail::send('mailConfirmationDecline', $data, function ($message) use ($to_name, $to_email, $konfirmasi, $ket){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Wawancara 2") {

            $tr_lamaran_kerja->lk_sta_kon_interview_dua = "Menolak";
            $tr_lamaran_kerja->lk_ket_interview_dua = $ket;
            $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 1";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi, "ket" => $ket);
            Mail::send('mailConfirmationDecline', $data, function ($message) use ($to_name, $to_email, $konfirmasi, $ket){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Wawancara HR") {

            $tr_lamaran_kerja->lk_sta_kon_interview_hr = "Menolak";
            $tr_lamaran_kerja->lk_ket_interview_hr = $ket;
            $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 2";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi, "ket" => $ket);
            Mail::send('mailConfirmationDecline', $data, function ($message) use ($to_name, $to_email, $konfirmasi, $ket){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Psikotes") {

            $tr_lamaran_kerja->lk_sta_kon_psikotes  = "Menolak";
            $tr_lamaran_kerja->lk_ket_psikotes = $ket;
            $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara HR";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "Coba", "konfirmasi" => $konfirmasi, "ket" => $ket);
            Mail::send('mailConfirmationDecline', $data, function ($message) use ($to_name, $to_email, $konfirmasi, $ket){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else if ($status_rekrutmen == "Medical Check Up") {

            $tr_lamaran_kerja->lk_sta_kon_mcu = "Menolak";
            $tr_lamaran_kerja->lk_ket_mcu = $ket;
            $tr_lamaran_kerja->lk_status_rekrutmen = "Psikotes";
            $tr_lamaran_kerja->lk_status_view = "Kirim";
            $to_name = $nama;
            $to_email = $email;
            $konfirmasi = $status_rekrutmen;
            $data = array("name" => $to_name, "body" => "", "konfirmasi" => $konfirmasi, "ket" => $ket);
            Mail::send('mailConfirmationDecline', $data, function ($message) use ($to_name, $to_email, $konfirmasi, $ket){
                $message->to($to_email)
                    ->subject('Please Check Status Confirmation.');
            });

        } else {

        }

		$tr_lamaran_kerja->update();

        return response()->json($tr_lamaran_kerja);
    }
    
    //Ubah Status Rekrutmen
    public function ubahStatusBelumDiproses($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Belum Diproses";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusTerpilih($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Terpilih";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
	}
    
    public function ubahStatusWawancara1($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 1";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
	}

    public function ubahStatusWawancara2($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara 2";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusWawancaraHR($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Wawancara HR";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusPsikotes($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Psikotes";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusMCU($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "MCU";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusPlacement($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Placement";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    public function ubahStatusTidakSesuai($id){
        $tr_lamaran_kerja = TrLamaranKerja::find($id);
        $tr_lamaran_kerja->lk_status_rekrutmen = "Tidak Sesuai";
		$tr_lamaran_kerja->update();
        return response()->json($tr_lamaran_kerja);
    }
    
    //Daftar Lamaran by Lowongan
	public function viewStatusBelumDiproses($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Belum Diproses" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }

	public function viewStatusTerpilih($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Terpilih" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusWawancara1($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Wawancara 1" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusWawancara2($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Wawancara 2" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusWawancaraHR($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Wawancara HR" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusPsikotes($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Psikotes" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusMCU($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "MCU" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusPlacement($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Placement" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusTidakSesuai($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_lowongan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen', '=', "Tidak Sesuai" )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }
    
	public function viewStatusSeluruh($id)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
        ->paginate(5);
        return response()->json($tr_lamaran_kerja);
    }

    //Lihat Detail Pelamar Untuk Penilaian
    public function detailPelamarPenilaian($id)
	{
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_pelamar', 'tr_lamaran_kerja.lk_status_rekrutmen', 'ms_pelamar.pel_nama_lengkap','ms_pelamar.pel_tanggal_lahir', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama')
        ->where( 'tr_lamaran_kerja.id', '=', $id )
        ->get();
        return response()->json($tr_lamaran_kerja);
    }
    
	public function rangeUmur($id, $umur1, $umur2)
    {
		//manggil api
		//http://127.0.0.1:8000/api/ms_pelamar/rangeUmur?umur1=20 & umur2=21

		// $umur1 = $umur1;
		// $umur2 = $umur2;

		if(!empty($umur1 && $umur2 ))
		{
            $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
            ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
            ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
            ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
            ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
            ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
            ->whereBetween('ms_pelamar.pel_umur', array($umur1, $umur2))
            ->paginate(5);
		}
		else
		{
            $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
            ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
            ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
            ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
            ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
            ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
            ->paginate(5);
		}

		return response()->json($tr_lamaran_kerja);
	}

	public function rangeGaji($id, $gajiMin, $gajiMax)
    {
		//manggil api
		//http://127.0.0.1:8000/api/ms_pelamar/rangeGaji?gajiMin=6000000 & gajiMax=9000000

		if(!empty($gajiMin && $gajiMax ))
		{
            $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
            ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
            ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
            ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
            ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
            ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
            ->whereBetween('ms_pelamar.pel_gaji_diharapkan', array($gajiMin, $gajiMax))
            ->paginate(5);
		}
		else
		{
            $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
            ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
            ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
            ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
            ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
            ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
            ->paginate(5);
		}

		return response()->json($tr_lamaran_kerja);
    }
    
	public function gender($id, $jenisKelamin)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
        ->where('ms_pelamar.pel_jenis_kelamin','LIKE',"%".$jenisKelamin."%")
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

	public function status($id, $status)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
        ->where('tr_lamaran_kerja.lk_status_rekrutmen','LIKE',"%".$status."%")
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }

	public function all($id, $all)
    {
        $tr_lamaran_kerja = DB::table('tr_lamaran_kerja')
        ->join('ms_pelamar', 'tr_lamaran_kerja.lk_pelamar', '=', 'ms_pelamar.id')
        ->join('ms_lowongan', 'tr_lamaran_kerja.lk_lowongan', '=', 'ms_lowongan.id')
        ->join('ms_posisi', 'ms_lowongan.low_posisi', '=', 'ms_posisi.id')
        ->select('tr_lamaran_kerja.id', 'tr_lamaran_kerja.lk_status_rekrutmen', 'tr_lamaran_kerja.lk_pelamar', 'ms_pelamar.pel_umur', 'ms_posisi.pos_nama', 'ms_lowongan.low_judul', 'ms_pelamar.pel_nama_lengkap', 'ms_pelamar.pel_jenis_kelamin', 'ms_pelamar.pel_pendidikan_terakhir', 'ms_pelamar.pel_gaji_diharapkan', 'ms_pelamar.pel_posisi')
        ->where( 'tr_lamaran_kerja.lk_perusahaan', '=', $id )
        ->where('ms_lowongan.low_judul','LIKE',"%".$all."%")
        ->orwhere('ms_pelamar.pel_nama_lengkap','LIKE',"%".$all."%")
        ->orwhere('ms_pelamar.pel_pendidikan_terakhir','LIKE',"%".$all."%")
        ->orwhere('ms_posisi.pos_nama','LIKE',"%".$all."%")
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
    }
}
