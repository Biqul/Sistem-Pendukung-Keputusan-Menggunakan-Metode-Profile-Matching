<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['seleksi_id', 'alternatif_id', 'nilai_akhir'];

    public function alternatif()
    {
        return $this->hasMany(Alternatif::class);
    }

    public function pembukaan()
    {
        return $this->hasMany(Pembukaan_seleksi::class);
    }
}
