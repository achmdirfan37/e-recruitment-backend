<?php

//header('Access-Control-Allow_Origin: *');
//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function() {

    //Transaksi
    Route::post('/tr_lamaran_kerja/fileupload', 'TrLamaranKerjaController@create');
    Route::get('/tr_lamaran_kerja/viewDetailInterview1', 'TrLamaranKerjaController@showDetailInterview1');
    Route::get('/tr_lamaran_kerja/viewDetailInterview2', 'TrLamaranKerjaController@showDetailInterview2');
    Route::get('/tr_lamaran_kerja/viewDetailInterviewHR', 'TrLamaranKerjaController@showDetailInterviewHR');
    Route::get('/tr_lamaran_kerja/viewDetailPsikotes', 'TrLamaranKerjaController@showDetailPsikotes');
    Route::get('/tr_lamaran_kerja/viewDetailMCU', 'TrLamaranKerjaController@showDetailMCU');
    Route::put('/tr_lamaran_kerja/updateStatusAccept/{id}', 'TrLamaranKerjaController@Accept');
    Route::put('/tr_lamaran_kerja/updateStatusDecline/{id}', 'TrLamaranKerjaController@Decline');
    //Route::put('/tr_lamaran_kerja/kirimEmail', 'TrLamaranKerjaController@setujuAja');
    Route::get('/tr_lamaran_kerja/image/{filename}', 'TrLamaranKerjaController@displayImage')->name('image.displayImage');

    Route::put('/tr_lamaran_kerja/undangTerimaInterview/{id}', 'TrLamaranKerjaController@undangTerimaInterview');
    Route::put('/tr_lamaran_kerja/undangTerimaInterview2/{id}', 'TrLamaranKerjaController@undangTerimaInterview2');
    Route::put('/tr_lamaran_kerja/undangTerimaInterviewHR/{id}', 'TrLamaranKerjaController@undangTerimaInterviewHR');
    Route::put('/tr_lamaran_kerja/undangTerimaPsikotes/{id}', 'TrLamaranKerjaController@undangTerimaPsikotes');
    Route::put('/tr_lamaran_kerja/undangTerimaMCU/{id}', 'TrLamaranKerjaController@undangTerimaMCU');
    Route::put('/tr_lamaran_kerja/undangTolakInterview/{id}', 'TrLamaranKerjaController@undangTolakInterview');
    Route::put('/tr_lamaran_kerja/undangTolakPsikotes/{id}', 'TrLamaranKerjaController@undangTolakPsikotes');
    Route::put('/tr_lamaran_kerja/undangTolakMCU/{id}', 'TrLamaranKerjaController@undangTolakMCU');
    Route::get('/tr_lamaran_kerja/viewBelumDibaca', 'TrLamaranKerjaController@viewBelumDibaca');
    Route::get('/tr_lamaran_kerja/viewInterview', 'TrLamaranKerjaController@viewInterview');
    Route::get('/tr_lamaran_kerja/viewPsikotes', 'TrLamaranKerjaController@viewPsikotes');
    Route::get('/tr_lamaran_kerja/viewMCU', 'TrLamaranKerjaController@viewMCU');

    //Ubah Status Rekrutmen
    Route::delete('/tr_lamaran_kerja/ubahStatusBelumDiproses/{id}', 'TrLamaranKerjaController@ubahStatusBelumDiproses');
    Route::delete('/tr_lamaran_kerja/ubahStatusTerpilih/{id}', 'TrLamaranKerjaController@ubahStatusTerpilih');
    Route::delete('/tr_lamaran_kerja/ubahStatusWawancara1/{id}', 'TrLamaranKerjaController@ubahStatusWawancara1');
    Route::delete('/tr_lamaran_kerja/ubahStatusWawancara2/{id}', 'TrLamaranKerjaController@ubahStatusWawancara2');
    Route::delete('/tr_lamaran_kerja/ubahStatusWawancaraHR/{id}', 'TrLamaranKerjaController@ubahStatusWawancaraHR');
    Route::delete('/tr_lamaran_kerja/ubahStatusPsikotes/{id}', 'TrLamaranKerjaController@ubahStatusPsikotes');
    Route::delete('/tr_lamaran_kerja/ubahStatusMCU/{id}', 'TrLamaranKerjaController@ubahStatusMCU');
    Route::delete('/tr_lamaran_kerja/ubahStatusPlacement/{id}', 'TrLamaranKerjaController@ubahStatusPlacement');
    Route::delete('/tr_lamaran_kerja/ubahStatusTidakSesuai/{id}', 'TrLamaranKerjaController@ubahStatusTidakSesuai');

    //Daftar Lamaran by Lowongan
    Route::get('/tr_lamaran_kerja/viewStatusBelumDiproses/{id}', 'TrLamaranKerjaController@viewStatusBelumDiproses');
    Route::get('/tr_lamaran_kerja/viewStatusTerpilih/{id}', 'TrLamaranKerjaController@viewStatusTerpilih');
    Route::get('/tr_lamaran_kerja/viewStatusWawancara1/{id}', 'TrLamaranKerjaController@viewStatusWawancara1');
    Route::get('/tr_lamaran_kerja/viewStatusWawancara2/{id}', 'TrLamaranKerjaController@viewStatusWawancara2');
    Route::get('/tr_lamaran_kerja/viewStatusWawancaraHR/{id}', 'TrLamaranKerjaController@viewStatusWawancaraHR');
    Route::get('/tr_lamaran_kerja/viewStatusPsikotes/{id}', 'TrLamaranKerjaController@viewStatusPsikotes');
    Route::get('/tr_lamaran_kerja/viewStatusMCU/{id}', 'TrLamaranKerjaController@viewStatusMCU');
    Route::get('/tr_lamaran_kerja/viewStatusPlacement/{id}', 'TrLamaranKerjaController@viewStatusPlacement');
    Route::get('/tr_lamaran_kerja/viewStatusTidakSesuai/{id}', 'TrLamaranKerjaController@viewStatusTidakSesuai');

    //Daftar Lamaran by Perusahaan
    Route::get('/tr_lamaran_kerja/viewStatusSeluruh/{id}', 'TrLamaranKerjaController@viewStatusSeluruh');

    //Filter
    Route::get('/tr_lamaran_kerja/rangeUmur/{id}/{umur1}/{umur2}', 'TrLamaranKerjaController@rangeUmur');
    Route::get('/tr_lamaran_kerja/rangeGaji/{id}/{gajiMin}/{gajiMax}', 'TrLamaranKerjaController@rangeGaji');
    Route::get('/tr_lamaran_kerja/gender/{id}/{jenisKelamin}', 'TrLamaranKerjaController@gender');
    Route::get('/tr_lamaran_kerja/status/{id}/{status}', 'TrLamaranKerjaController@status');
    Route::get('/tr_lamaran_kerja/all/{id}/{all}', 'TrLamaranKerjaController@all');

    //Master Pelamar
    Route::get('/ms_pelamar/search', 'MsPelamarController@search');
    Route::get('/ms_pelamar/rangeUmur', 'MsPelamarController@rangeUmur');
    Route::get('/ms_pelamar/rangeGaji', 'MsPelamarController@rangeGaji');
    Route::get('/ms_pelamar/view', 'MsPelamarController@index');
    Route::get('/ms_pelamar/viewDetail/{id}', 'MsPelamarController@showDetail');
    Route::post('/register', 'AuthController@register');
    Route::post('/ms_pelamar/profile', 'MsPelamarController@getAuthenticatedUser');
    Route::post('/login', 'AuthController@login');
    Route::post('/ms_pelamar/create', 'MsPelamarController@create');
    Route::get('/ms_pelamar/{id}/edit', 'MsPelamarController@edit');
    Route::get('/ms_pelamar/getImage/{id}', 'MsPelamarController@getImage');
    Route::get('/ms_pelamar/displayImage/{id}', 'MsPelamarController@displayImage');
    //Route::get('/ms_pelamar/displayImage/{id}', 'MsPerusahaanController@displayImage')->name('image.displayImage');
    Route::put('/ms_pelamar/{id}/update', 'MsPelamarController@update');
    //Route::put('/ms_pelamar/{id}/update', 'MsPelamarController@update');
    Route::delete('/ms_pelamar/delete/{id}', 'MsPelamarController@delete');
    Route::put('/ms_pelamar/{id}/changePassword', 'MsPelamarController@changePassword');
    Route::put('/ms_pelamar/{id}/updateflk', 'MsPelamarController@updateflk');
    Route::get('/ms_keterampilan/viewflk/{id}', 'MsKeterampilanController@viewflk');
    Route::get('/ms_riwayat_pendidikan/viewflk/{id}', 'MsRiwayatPendidikanController@viewflk');
    Route::get('/ms_pengalaman_kerja/viewflk/{id}', 'MsPengalamanKerjaController@viewflk');

    //authentication
    Route::get('/register/activate/{token}', 'AuthController@signupActivate');

    Route::middleware('auth:api')->get('/user', function(Request $request){
        return $request->user();
    });

    //Master Bidang Pekerjaan
    Route::get('/ms_bidang_pekerjaan/search', 'MsBidangPekerjaanController@search');
    Route::get('/ms_bidang_pekerjaan/view', 'MsBidangPekerjaanController@index');
    Route::get('/ms_bidang_pekerjaan/viewDetail/{id}', 'MsBidangPekerjaanController@showDetail');
    Route::post('/ms_bidang_pekerjaan/create', 'MsBidangPekerjaanController@create');
    Route::get('/ms_bidang_pekerjaan/edit/{id}', 'MsBidangPekerjaanController@edit');
    Route::put('/ms_bidang_pekerjaan/update/{id}', 'MsBidangPekerjaanController@update');
    Route::delete('/ms_bidang_pekerjaan/delete/{id}', 'MsBidangPekerjaanController@delete');
    Route::get('/ms_bidang_pekerjaan/ddl', 'MsBidangPekerjaanController@view');
    
    //Master Posisi
    Route::get('/ms_posisi/search', 'MsPosisiController@search');
    Route::get('/ms_posisi/view', 'MsPosisiController@index');
    Route::get('/ms_posisi/viewDetail/{id}', 'MsPosisiController@showDetail');
    Route::post('/ms_posisi/create', 'MsPosisiController@create');
    Route::get('/ms_posisi/edit/{id}', 'MsPosisiController@edit');
    Route::put('/ms_posisi/update/{id}', 'MsPosisiController@update');
    Route::delete('/ms_posisi/delete/{id}', 'MsPosisiController@delete');
    Route::get('/ms_posisi/ddl', 'MsPosisiController@index');

    //Master Keterampilan
    Route::get('/ms_keterampilan/search', 'MsKeterampilanController@search');
    Route::get('/ms_keterampilan/view', 'MsKeterampilanController@index');
    Route::get('/ms_keterampilan/viewDetail/{id}', 'MsKeterampilanController@showDetail');
    Route::post('/ms_keterampilan/create', 'MsKeterampilanController@create');
    Route::get('/ms_keterampilan/edit/{id}', 'MsKeterampilanController@edit');
    Route::put('/ms_keterampilan/update/{id}', 'MsKeterampilanController@update');
    Route::delete('/ms_keterampilan/delete/{id}', 'MsKeterampilanController@delete');

    //Master Perusahaan
    Route::get('/ms_perusahaan/search', 'MsPerusahaanController@search');
    Route::get('/ms_perusahaan/view', 'MsPerusahaanController@index');
    Route::get('/ms_perusahaan/viewDetail/{id}', 'MsPerusahaanController@showDetail');
    Route::post('/ms_perusahaan/create', 'MsPerusahaanController@create');
    Route::get('/ms_perusahaan/edit/{id}', 'MsPerusahaanController@edit');
    Route::put('/ms_perusahaan/update/{id}', 'MsPerusahaanController@update');
    Route::delete('/ms_perusahaan/delete/{id}', 'MsPerusahaanController@delete');
    Route::get('/ms_perusahaan/ddl', 'MsPerusahaanController@view');


    //Master Role/HRD
    Route::get('/ms_person/search', 'MsPersonController@search');
    Route::get('/ms_person/searchPewawancara', 'MsPersonController@searchPewawancara');
    Route::get('/ms_person/view', 'MsPersonController@index');
    Route::get('/ms_person/viewPewawancara', 'MsPersonController@viewPewawancara');
    Route::get('/ms_person/viewDetail/{id}', 'MsPersonController@showDetail');
    Route::post('/ms_person/create', 'MsPersonController@create');
    Route::post('/ms_person/createPewawancara', 'MsPersonController@createPewawancara');
    Route::get('/ms_person/edit/{id}', 'MsPersonController@edit');
    Route::put('/ms_person/update/{id}', 'MsPersonController@update');
    Route::put('/ms_person/updatePewawancara/{id}', 'MsPersonController@updatePewawancara');
    Route::delete('/ms_person/delete/{id}', 'MsPersonController@delete');
    Route::delete('/ms_person/status/{id}', 'MsPersonController@ubahStatus');
    Route::get('/ms_person/showPerusahaan', 'MsPersonController@showPerusahaan');

    //Master Lowongan Pekerjaan
    Route::get('/ms_lowongan/lowonganbyperusahaan/{id}', 'MsLowonganController@showLowonganbyPerusahaan');
    Route::get('/ms_lowongan/applylamaran', 'MsLowonganController@applyLamaran');
    Route::get('/ms_lowongan/search', 'MsLowonganController@search');
    //Route::get('/ms_lowongan/searchbyidperusahaan/{id}', 'MsLowonganController@searchbyidperusahaan');
    Route::get('/ms_lowongan/view', 'MsLowonganController@index');
    Route::get('/ms_lowongan/viewDetail/{id}', 'MsLowonganController@showDetail');
    Route::post('/ms_lowongan/create', 'MsLowonganController@create');
    Route::get('/ms_lowongan/edit/{id}', 'MsLowonganController@edit');
    Route::put('/ms_lowongan/update/{id}', 'MsLowonganController@update');
    Route::delete('/ms_lowongan/delete/{id}', 'MsLowonganController@delete');

    //Master Riwayat Pendidikan
    Route::get('/ms_riwayat_pendidikan/search', 'MsRiwayatPendidikanController@search');
    Route::get('/ms_riwayat_pendidikan/view', 'MsRiwayatPendidikanController@index');
    Route::get('/ms_riwayat_pendidikan/viewDetail/{id}', 'MsRiwayatPendidikanController@showDetail');
    Route::post('/ms_riwayat_pendidikan/create', 'MsRiwayatPendidikanController@create');
    Route::get('/ms_riwayat_pendidikan/{id}/edit', 'MsRiwayatPendidikanController@edit');
    Route::put('/ms_riwayat_pendidikan/{id}/update', 'MsRiwayatPendidikanController@update');
    Route::delete('/ms_riwayat_pendidikan/delete/{id}', 'MsRiwayatPendidikanController@delete');

    //Master Pengalaman Kerja
    Route::get('/ms_pengalaman_kerja/search', 'MsPengalamanKerjaController@search');
    Route::get('/ms_pengalaman_kerja/view', 'MsPengalamanKerjaController@index');
    Route::get('/ms_pengalaman_kerja/viewDetail/{id}', 'MsPengalamanKerjaController@showDetail');
    Route::post('/ms_pengalaman_kerja/create', 'MsPengalamanKerjaController@create');
    Route::get('/ms_pengalaman_kerja/{id}/edit', 'MsPengalamanKerjaController@edit');
    Route::put('/ms_pengalaman_kerja/{id}/update', 'MsPengalamanKerjaController@update');
    Route::delete('/ms_pengalaman_kerja/delete/{id}', 'MsPengalamanKerjaController@delete');

    Route::post('/tr_penilaian_lamaran/create', 'TrPenilaianLamaranController@create');
    Route::post('/tr_penilaian_lamaran/createHead', 'TrPenilaianLamaranController@createHead');
    Route::get('/tr_penilaian_lamaran/edit/{id}', 'TrPenilaianLamaranController@edit');
    Route::get('/tr_penilaian_lamaran/detail/{id}', 'TrPenilaianLamaranController@showDetailPenilaian');

    Route::get('/tr_lamaran_kerja/showLamaranPewawancara/{id}', 'TrLamaranKerjaController@showLamaranPewawancara');
    Route::get('/tr_lamaran_kerja/showLamaranPewawancaraStaff/{id}', 'TrLamaranKerjaController@showLamaranPewawancaraStaff');
    Route::get('/tr_lamaran_kerja/showLamaranPewawancaraSectionHead/{id}', 'TrLamaranKerjaController@showLamaranPewawancaraSectionHead');
    Route::get('/tr_lamaran_kerja/detailPelamarPenilaian/{id}', 'TrLamaranKerjaController@detailPelamarPenilaian');

    //Diubah
    Route::get('/tr_lamaran_kerja/viewDetail/{id}', 'TrLamaranKerjaController@showDetail');
    Route::get('/tr_lamaran_kerja/viewDetailTransaksiPelamar/{id}', 'TrLamaranKerjaController@showDetailTransaksiPelamar');
    Route::get('/tr_lamaran_kerja/viewDetailAcceptDeclinePelamar/{id}', 'TrLamaranKerjaController@showDetailAcceptDeclinePelamar');
    Route::get('/tr_lamaran_kerja/statusAccept/{id}', 'TrLamaranKerjaController@edit');
    Route::get('/tr_lamaran_kerja/statusDecline/{id}', 'TrLamaranKerjaController@edit');
    Route::get('/tr_lamaran_kerja/statusAcceptNoQuery/{id}', 'TrLamaranKerjaController@editNoQuery');
    Route::get('/tr_lamaran_kerja/statusDeclineNoQuery/{id}', 'TrLamaranKerjaController@editNoQuery');
});
