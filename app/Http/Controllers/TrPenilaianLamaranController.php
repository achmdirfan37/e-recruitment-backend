<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\TrPenilaianLamaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Mail\MailNotify;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TrPenilaianLamaranController extends Controller
{
    public function index()
	{
		$tr_penilaian_lamaran = DB::table('tr_penilaian_lamaran')->paginate(5);;
        return $tr_penilaian_lamaran;
    }

    
    public function showDetailPenilaian($id)
    {
        $tr_penilaian_lamaran = TrPenilaianLamaran::where( 'pn_lamaran', '=', $id )
        ->paginate(5);

        return response()->json($tr_penilaian_lamaran);
    }

	public function create(Request $request){

        $tr_penilaian_lamaran = new TrPenilaianLamaran();
        
        $tr_penilaian_lamaran->pn_pelamar = $request->get('pn_pelamar');
        $tr_penilaian_lamaran->pn_lamaran = $request->get('pn_lamaran');
        $tr_penilaian_lamaran->pn_lowongan = $request->get('pn_lowongan');
        $tr_penilaian_lamaran->pn_perusahaan = $request->get('pn_perusahaan');
        $tr_penilaian_lamaran->pn_tahapan_wawancara = $request->get('pn_tahapan_wawancara');
        $tr_penilaian_lamaran->pn_tujuan = $request->get('pn_tujuan');
        $tr_penilaian_lamaran->pn_tanggal = $request->get('pn_tanggal');
        $tr_penilaian_lamaran->pn_penampilan_sikap = $request->get('pn_penampilan_sikap');
        $tr_penilaian_lamaran->pn_pengetahuan_penguasaan = $request->get('pn_pengetahuan_penguasaan');
        $tr_penilaian_lamaran->pn_percaya_diri = $request->get('pn_percaya_diri');
        $tr_penilaian_lamaran->pn_motivasi_ambisi = $request->get('pn_motivasi_ambisi');
        $tr_penilaian_lamaran->pn_inisiatif_kreatifitas = $request->get('pn_inisiatif_kreatifitas');
        $tr_penilaian_lamaran->pn_kerjasama = $request->get('pn_kerjasama');
        $tr_penilaian_lamaran->pn_komunikasi = $request->get('pn_komunikasi');
        $tr_penilaian_lamaran->pn_kekuatan = $request->get('pn_kekuatan');
        $tr_penilaian_lamaran->pn_kelemahan = $request->get('pn_kelemahan');
        $tr_penilaian_lamaran->pn_kesimpulan = $request->get('pn_kesimpulan');
        // $tr_penilaian_lamaran->pn_total_nilai = $request->get('pn_total_nilai');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_interpersonal_skill');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_analysis_judgment');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_planning_driving_action');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_leading_motivating');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_team_work');
        // $tr_penilaian_lamaran->lk_pelamar = $request->get('pn_drive_courage');
        $tr_penilaian_lamaran->save();
        return response()->json($tr_penilaian_lamaran);
    }

    
	public function createHead(Request $request){

        $tr_penilaian_lamaran = new TrPenilaianLamaran();
        
        $tr_penilaian_lamaran->pn_pelamar = $request->get('pn_pelamar');
        $tr_penilaian_lamaran->pn_lamaran = $request->get('pn_lamaran');
        $tr_penilaian_lamaran->pn_lowongan = $request->get('pn_lowongan');
        $tr_penilaian_lamaran->pn_perusahaan = $request->get('pn_perusahaan');
        $tr_penilaian_lamaran->pn_tahapan_wawancara = $request->get('pn_tahapan_wawancara');
        $tr_penilaian_lamaran->pn_tujuan = $request->get('pn_tujuan');
        $tr_penilaian_lamaran->pn_tanggal = $request->get('pn_tanggal');
        $tr_penilaian_lamaran->pn_kekuatan = $request->get('pn_kekuatan');
        $tr_penilaian_lamaran->pn_kelemahan = $request->get('pn_kelemahan');
        $tr_penilaian_lamaran->pn_kesimpulan = $request->get('pn_kesimpulan');
        //$tr_penilaian_lamaran->pn_total_nilai = $request->get('pn_total_nilai');
        $tr_penilaian_lamaran->pn_interpersonal_skill = $request->get('pn_interpersonal_skill');
        $tr_penilaian_lamaran->pn_analysis_judgment = $request->get('pn_analysis_judgment');
        $tr_penilaian_lamaran->pn_planning_driving_action = $request->get('pn_planning_driving_action');
        $tr_penilaian_lamaran->pn_leading_motivating = $request->get('pn_leading_motivating');
        $tr_penilaian_lamaran->pn_team_work = $request->get('pn_team_work');
        $tr_penilaian_lamaran->pn_drive_courage = $request->get('pn_drive_courage');
        $tr_penilaian_lamaran->save();
        return response()->json($tr_penilaian_lamaran);
    }

    public function edit($id)
	{
        $tr_penilaian_lamaran = TrPenilaianLamaran::find($id);
        return response()->json($tr_penilaian_lamaran);
    }

}
