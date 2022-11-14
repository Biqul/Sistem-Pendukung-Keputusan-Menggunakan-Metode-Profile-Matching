<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil_aspek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['pembukaan_id', 'aspek_id', 'alternatif_id', 'ncf', 'nsf', 'total', 'totalEach'];

    public function pembukaan()
    {
        return $this->hasMany(Pembukaan_seleksi::class);
    }

    public function aspek()
    {
        return $this->hasMany(Aspek::class);
    }

    public function alternatif()
    {
        return $this->hasMany(Alternatif::class);
    }

    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('periode', 'like', '%' . $search . '%');
        });
    }
}
