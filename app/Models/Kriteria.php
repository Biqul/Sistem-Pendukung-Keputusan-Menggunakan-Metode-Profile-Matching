<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }


    public function scopeFilter($query, array $filters){

        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('kode_kriteria', 'like', '%' . $search . '%');
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
