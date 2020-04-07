<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsRiwayatPendidikan extends Model
{
    protected $table = 'ms_riwayat_pendidikan';
    protected $fillable = ['rpd_nama_lembaga_pendidikan', 'rpd_tanggal_lulus', 'rpd_kualifikasi', 'rpd_lokasi', 'rpd_jurusan', 'rpd_keterangan_prestasi', 'created_by', 'updated_by'];

}
