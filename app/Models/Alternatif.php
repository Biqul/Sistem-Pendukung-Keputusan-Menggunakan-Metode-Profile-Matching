<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    
    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }

    public function pembukaan()
    {
        return $this->belongsTo(Pembukaan_seleksi::class);
    }

    public function hasil_aspek()
    {
        return $this->belongsTo(Hasil_aspek::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%');
        });
    }
}
