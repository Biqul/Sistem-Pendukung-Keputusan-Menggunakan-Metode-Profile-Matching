<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pembukaan()
    {
        return $this->hasMany(Pembukaan_seleksi::class);
    }

    public function aspek()
    {
        return $this->hasMany(Aspek::class);
    }

    public function kriteria()
    {
        return $this->hasMany(Kriteria::class);
    }

    public function alternatif()
    {
        return $this->hasMany(Alternatif::class);
    }

}
