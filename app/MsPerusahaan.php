<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsPerusahaan extends Model
{
    protected $table = 'ms_perusahaan';
    protected $fillable = ['per_foto', 'per_nama', 'per_deskripsi', 'per_email', 'per_no_telepon', 'per_alamat_website', 'per_alamat', 'per_status_aktif', 'created_by', 'updated_by'];
}
