<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsLowongan extends Model
{
    protected $table = 'ms_lowongan';
    protected $fillable = ['low_judul', 'low_deskripsi', 'low_gaji', 'low_tanggal_ditutup',
    'low_kualifikasi', 'low_jabatan', 'low_perusahaan', 'low_bidang_kerja', 'low_spesialisasi',
    'low_status_aktif'];
}
