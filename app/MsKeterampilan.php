<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsKeterampilan extends Model
{
    protected $table = 'ms_keterampilan';
    protected $fillable = ['ket_nama', 'ket_pelamar'];
}
