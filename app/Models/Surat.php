<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [
        'jenis_surat_id',
        'no_surat',
        'tgl_surat',
        'isi_surat',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public static function generateNomorSurat($kodeBagian = 'DIRUT')
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        $tahun = date('Y');
        $bulan = date('n'); // angka bulan 1-12
        $romawiBulan = $romawi[$bulan];

        // cari nomor terakhir bulan ini & tahun ini
        $last = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            // ambil urutan dari nomor_surat sebelumnya
            $lastNumber = (int) explode('/', $last->no_surat)[0];
            $urut = $lastNumber + 1;
        } else {
            $urut = 1;
        }

        $nomor = str_pad($urut, 3, '0', STR_PAD_LEFT) . "/$kodeBagian/$romawiBulan/$tahun";

        return $nomor;
    }
}
