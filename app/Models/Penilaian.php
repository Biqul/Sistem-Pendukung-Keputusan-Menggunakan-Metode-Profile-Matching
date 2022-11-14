<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = ['pembukaan_id', 'aspek_id', 'kriteria_id', 'alternatif_id', 'value'];

    public function pembukaan()
    {
        return $this->belongsTo(Pembukaan_seleksi::class);
    }

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }

}
