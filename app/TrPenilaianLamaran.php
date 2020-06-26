<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrPenilaianLamaran extends Model
{
    protected $table = 'tr_penilaian_lamaran';
    protected $fillable = ['pn_pelamar', 'pn_lamaran', 'pn_lowongan', 'pn_perusahaan', 'pn_tanggal', 'pn_tujuan', 'pn_tahapan_wawancara', 'pn_penampilan_sikap', 'pn_pengetahuan_penguasaan', 'pn_percaya_diri', 'pn_motivasi_ambisi', 'pn_inisiatif_kreatifitas', 'pn_kerjasama', 'pn_komunikasi', 'pn_kekuatan', 'pn_kelemahan', 'pn_kesimpulan', 'pn_total_nilai', 'pn_interpersonal_skill', 'pn_analysis_judgment', 'pn_planning_driving_action', 'pn_leading_motivating', 'pn_team_work', 'pn_drive_courage'];
}
