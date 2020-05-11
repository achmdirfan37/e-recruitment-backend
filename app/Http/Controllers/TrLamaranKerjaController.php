<?php

namespace App\Http\Controllers;

// header('Access-Control-Allow_Origin: *');
// header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;
use DB;
use App\TrLamaranKerja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TrLamaranKerjaController extends Controller
{
    public function index()
	{
		$tr_lamaran_kerja = DB::table('tr_lamaran_kerja')->paginate(5);;
        return $tr_lamaran_kerja;
    }

	public function showDetail($id)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->paginate(5);

        return response()->json($tr_lamaran_kerja);
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
    
    public function showDetailInterviewPelamar($id)
    {
        $tr_lamaran_kerja_interview = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_view', '=', 'Terima' )
        ->where( 'lk_status_rekrutmen', '=', 'Wawancara 1')
        ->orwhere( 'lk_status_rekrutmen', '=', 'Wawancara 2')
        ->orwhere( 'lk_status_rekrutmen', '=', 'Wawancara HR')
        ->paginate(5);

        return response()->json($tr_lamaran_kerja_interview);
    }
    
    public function showDetailPsikotesPelamar($id)
    {
        //$someVariable = Input::get("some_variable");

       // $results = DB::select( DB::raw("SELECT * FROM tr_lamaran_kerja WHERE lk_pelamar = '$id' AND lk_status_view = 'Terima' AND lk_status_rekrutmen = 'Psikotes' ") );

        $tr_lamaran_kerja_psikotes = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_view', '=', 'Terima' )
        ->where( 'lk_status_rekrutmen', '=', 'Psikotes' )
        ->get();

        return response()->json($tr_lamaran_kerja_psikotes);
    }
    
    public function showDetailMCUPelamar($id)
    {
        $tr_lamaran_kerja = TrLamaranKerja::where( 'lk_pelamar', '=', $id )
        ->where( 'lk_status_rekrutmen', '=', 'Medical Check Up' )
        ->where( 'lk_status_view', '=', 'Terima' )
        ->get();

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
        $tr_lamaran_kerja->lk_status_rekrutmen = "";
        $tr_lamaran_kerja->lk_status_view = "Kirim";
        $tr_lamaran_kerja->lk_perusahaan = $request->get('lk_perusahaan');
        $tr_lamaran_kerja->lk_lowongan = $request->get('lk_lowongan');
        $tr_lamaran_kerja->lk_pelamar = 4;
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

}
