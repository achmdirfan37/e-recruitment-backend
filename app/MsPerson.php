<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsPerson extends Model
{
    protected $table = 'ms_person';
    protected $fillable = ['pers_role', 'pers_password', 'pers_nama_lengkap', 'pers_perusahaan', 'pers_email', 'pers_no_telepon', 'pers_status_aktif', 'created_by', 'updated_by'];
}
