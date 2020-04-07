<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsPengalamanKerja extends Model
{
    protected $table = 'ms_pengalaman_kerja';
    protected $fillable = ['pkj_nama_perusahaan',
    'pkj_tanggal_mulai', 'pkj_tanggal_selesai', 'pkj_lokasi', 'pkj_industri',
    'pkj_gambaran_pekerjaan', 'pkj_spesialisasi', 'pkj_bidang_kerja',
    'created_by', 'updated_by', 'created_at', 'updated_at'];
}
