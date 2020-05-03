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
    //Master Pelamar
    Route::get('/ms_pelamar/search', 'MsPelamarController@search');
    Route::get('/ms_pelamar/rangeUmur', 'MsPelamarController@rangeUmur');
    Route::get('/ms_pelamar/rangeGaji', 'MsPelamarController@rangeGaji');
    Route::get('/ms_pelamar/view', 'MsPelamarController@index');
    Route::get('/ms_pelamar/viewDetail/{id}', 'MsPelamarController@showDetail');
    Route::post('/ms_pelamar/regis', 'MsPelamarController@registerPelamar');
    Route::post('/ms_pelamar/profile', 'MsPelamarController@getAuthenticatedUser');
    Route::post('/ms_pelamar/login', 'MsPelamarController@login');
    Route::post('/ms_pelamar/create', 'MsPelamarController@create');
    Route::get('/ms_pelamar/{id}/edit', 'MsPelamarController@edit');
    Route::put('/ms_pelamar/{id}/update', 'MsPelamarController@update');
    //Route::put('/ms_pelamar/{id}/update', 'MsPelamarController@update');
    Route::delete('/ms_pelamar/delete/{id}', 'MsPelamarController@delete');

    Route::middleware('auth:api')->get('/user', function(Request $request){
        return $request->user();
    });

    //Master Bidang Pekerjaan
    Route::get('/ms_bidang_pekerjaan/search', 'MsBidangPekerjaanController@search');
    Route::get('/ms_bidang_pekerjaan/view', 'MsBidangPekerjaanController@index');
    Route::get('/ms_bidang_pekerjaan/viewDetail/{id}', 'MsBidangPekerjaanController@showDetail');
    Route::post('/ms_bidang_pekerjaan/create', 'MsBidangPekerjaanController@create');
    Route::get('/ms_bidang_pekerjaan/{id}/edit', 'MsBidangPekerjaanController@edit');
    Route::put('/ms_bidang_pekerjaan/{id}/update', 'MsBidangPekerjaanController@update');
    Route::delete('/ms_bidang_pekerjaan/delete/{id}', 'MsBidangPekerjaanController@delete');
    Route::get('/ms_bidang_pekerjaan/ddl', 'MsBidangPekerjaanController@view');

    //Master Keterampilan
    Route::get('/ms_keterampilan/search', 'MsKeterampilanController@search');
    Route::get('/ms_keterampilan/view', 'MsKeterampilanController@index');
    Route::get('/ms_keterampilan/viewDetail/{id}', 'MsKeterampilanController@showDetail');
    Route::post('/ms_keterampilan/create', 'MsKeterampilanController@create');
    Route::get('/ms_keterampilan/{id}/edit', 'MsKeterampilanController@edit');
    Route::put('/ms_keterampilan/{id}/update', 'MsKeterampilanController@update');
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
    Route::get('/ms_role/search', 'MsRoleController@search');
    Route::get('/ms_role/view', 'MsRoleController@index');
    Route::get('/ms_role/viewDetail/{id}', 'MsRoleController@showDetail');
    Route::post('/ms_role/create', 'MsRoleController@create');
    Route::get('/ms_role/edit/{id}', 'MsRoleController@edit');
    Route::put('/ms_role/update/{id}', 'MsRoleController@update');
    Route::delete('/ms_role/delete/{id}', 'MsRoleController@delete');
    Route::get('/ms_role/showPerusahaan', 'MsRoleController@showPerusahaan');

    //Master Lowongan Pekerjaan
    Route::get('/ms_lowongan/lowonganbyperusahaan/{id}', 'MsLowonganController@showLowonganbyPerusahaan');
    Route::get('/ms_lowongan/applylamaran', 'MsLowonganController@applyLamaran');
    Route::get('/ms_lowongan/search', 'MsLowonganController@search');
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
    Route::get('/ms_riwayat_pendidikan/edit/{id}', 'MsRiwayatPendidikanController@edit');
    Route::put('/ms_riwayat_pendidikan/update/{id}', 'MsRiwayatPendidikanController@update');
    Route::delete('/ms_riwayat_pendidikan/delete/{id}', 'MsRiwayatPendidikanController@delete');

    //Master Pengalaman Kerja
    Route::get('/ms_pengalaman_kerja/search', 'MsPengalamanKerjaController@search');
    Route::get('/ms_pengalaman_kerja/view', 'MsPengalamanKerjaController@index');
    Route::get('/ms_pengalaman_kerja/viewDetail/{id}', 'MsPengalamanKerjaController@showDetail');
    Route::post('/ms_pengalaman_kerja/create', 'MsPengalamanKerjaController@create');
    Route::get('/ms_pengalaman_kerja/edit/{id}', 'MsPengalamanKerjaController@edit');
    Route::put('/ms_pengalaman_kerja/update/{id}', 'MsPengalamanKerjaController@update');
    Route::delete('/ms_pengalaman_kerja/delete/{id}', 'MsPengalamanKerjaController@delete');

});
