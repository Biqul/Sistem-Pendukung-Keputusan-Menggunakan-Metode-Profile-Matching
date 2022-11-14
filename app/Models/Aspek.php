<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function hasil_aspek()
    {
        return $this->belongsTo(Hasil_aspek::class);
    }

    public function kriteria()
    {
        return $this->hasMany(Kriteria::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
