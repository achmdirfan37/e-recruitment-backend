<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsPelamar extends Model
{
    protected $table = 'ms_pelamar';
    protected $fillable = ['pel_foto', 'pel_email', 'pel_password', 'pel_no_ktp', 'pel_nama_lengkap', 'pel_jenis_kelamin', 'pel_tempat_lahir', 'pel_tanggal_lahir', 'pel_no_telepon', 'pel_alamat', 'pel_tinggi_badan', 'pel_berat_badan', 'pel_gaji_diharapkan', 'pel_jabatan_dicari', 'pel_status_aktif', 'created_by', 'updated_by'];
}
