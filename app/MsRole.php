<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsRole extends Model
{
    protected $table = 'ms_role';
    protected $fillable = ['rol_username', 'rol_password', 'rol_nama_lengkap', 'rol_perusahaan', 'rol_email', 'rol_no_telepon', 'rol_status_aktif', 'created_by', 'updated_by'];
}
