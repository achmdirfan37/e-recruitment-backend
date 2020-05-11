<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrLamaranKerja extends Model
{
    protected $table = 'tr_lamaran_kerja';
    protected $fillable = ['lk_cv', 'lk_status_baca', 'lk_status_rekrutmen', 'lk_pelamar', 'lk_perusahaan', 'lk_lowongan', 'created_by', 'updated_by'];
}
