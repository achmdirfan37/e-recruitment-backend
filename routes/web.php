<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/ms_pelamar','MsPelamarController@index');
Route::get('/ms_pelamar/tambah','MsPelamarController@tambah');
Route::post('/ms_pelamar/store','MsPelamarController@store');
Route::get('/ms_pelamar/edit/{id}','MsPelamarController@edit');
Route::post('/ms_pelamar/update','MsPelamarController@update');
Route::get('/ms_pelamar/hapus/{id}','MsPelamarController@hapus');

Auth::routes();
