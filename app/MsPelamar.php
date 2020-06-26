<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsPelamar extends Model
{
    protected $table = 'ms_pelamar';
    protected $fillable = ['pel_foto', 'pel_email', 'pel_password', 'pel_no_ktp', 'pel_nama_lengkap', 'pel_jenis_kelamin', 'pel_tempat_lahir', 'pel_tanggal_lahir', 'pel_no_telepon', 'pel_alamat', 'pel_tinggi_badan', 'pel_berat_badan', 'pel_gaji_diharapkan', 'pel_posisi', 'pel_status_aktif', 'created_by', 'updated_by', 'pel_umur', 'pel_pendidikan_terakhir', 'pel_kewarganegaraan', 'pel_alamat_ortu', 'pel_no_telepon_ortu', 'pel_alasan_memilih_jurusan', 'pel_karya_ilmiah', 'pel_pendidikan_non_formal', 'pel_bahasa', 'pel_status_pernikahan', 'pel_tanggal_status_pernikahan', 'pel_susunan_keluarga', 'pel_detail_atasan_bawahan', 'pel_masalah_dihadapi', 'pel_kesan_kerja', 'pel_inovasi_kerja', 'pel_orang_yang_mendorong', 'pel_case_keputusan', 'pel_cita_cita', 'pel_hal_mendorong_bekerja', 'pel_alasan_ingin_bekerja', 'pel_fasilitas_diharapkan', 'pel_kapan_mulai_bekerja', 'pel_urutan_jenis_pekerjaan', 'pel_lingkungan_kerja_diminati', 'pel_bersedia_diluar_daerah', 'pel_tipe_orang_disenangi', 'pel_hal_sulit_mengambil_keputusan', 'pel_kenalan_di_perusahaan_astra', 'pel_referensi_perusahaan', 'pel_hobi', 'pel_cara_mengisi_waktu_luang', 'pel_organisasi_diikuti', 'pel_psikotes', 'pel_kekuatan', 'pel_kelemahan', 'pel_riwayat_penyakit', 'pel_persetujuan'];
}
